<?php

require_once("conexao.php");

$conexao = getConexao();

// =============================Fixture==========================================
	
	function fixture()
	{
		try
		{
			$conexao = getConexao();
			
			echo "removendo banco....<br>";
			$conexao->query("drop database if exists paginas;");
			
			echo "criando o banco de dados....<br>";
			$conexao->query("create database paginas;");
			
			echo "removendo as tabelas....<br>";
			
			$conexao->query("drop table if exists paginas.paginas;");
						
			$conexao->query("drop table if exists paginas.usuarios;");
			
			echo "criando tabelas....<br>";
			
			$conexao->query("create table paginas.paginas
					(
						id int not null auto_increment,
						nome text,
						title text,
						pagina text,
						primary key (id)
					);
					create table paginas.usuarios
					(
						nome varchar(255),
						senha text,
						primary key (nome)
					);");
					
			echo "inserindo os dados....<br>";
			
			$dados = array
			(	
				"empresa" => array
					(
						"nome" => "empresa",
						"title" => "Empresa",
						"pagina" => "<div class=\"well\">
										<center>
											<h1>Empresa</h1>
										</center>
									</div>"
					),
					
				"produtos" => array
					(
						"nome" => "produtos",
						"title" => "Produtos",
						"pagina" => "<div class=\"well\">
										<center>
											<h1>Produtos</h1>
										</center>
									</div>"
					),
					
				"servicos" => array
					(
						"nome" => "servicos",
						"title" => "Serviços",
						"pagina" => "<div class=\"well\">
										<center>
											<h1>Serviços</h1>
										</center>
									</div>"
					),
					
				"contato" => array
					(
						"nome" => "contato",
						"title" => "Contato",
						"pagina" => "<div class=\"well\">
										<center>
											<h1>Contato</h1>
										</center>
									</div>
											
									<div class=\"panel panel-default\">
										<div class=\"panel-body\">
										<form method=\"post\" action=\"contatoEnviado\" >
											Nome:<br>
											<input type=\"text\" name=\"nome\"/><br>
											E-mail:<br>
											<input type=\"text\" name=\"email\"/><br>
											Assunto:<br>
											<select name=\"assunto\">
												<option value=\"suporte\">Suporte</option>
												<option value=\"ouvidoria\">Ouvidoria</option>
												<option value=\"outros\">Outros</option>
											</select>	  
											Mensagem:<br>
											<textarea rows=\"4\" cols=\"50\" name=\"mensagem\"></textarea><br>
											<input type=\"submit\" value=\"Evniar\"/>
										</form>
										</div>
									</div>"
					),
					"404" => array
					(
						"nome" => "404",
						"title" => "Página não encontrada",
						"pagina" => "<div class=\"well\">
										<center>
											<h1>Página não encontrada!</h1>
										</center>
									</div>"
					)
			);
			
			foreach($dados as $dado)
			{
				inserirDados($dado, $conexao, 0);
			}
			
            $dados = array
            (
                "usuario" => array 
                (
                    "nome" => "admin",
                    "password" => password_hash("admin", PASSWORD_DEFAULT)
                )
            );

            foreach($dados as $dado)
			{
                inserirDados($dado, $conexao, 1);
			}

			echo "processo finalizado com sucesso...<br><br>";
			/*
			$sth = $conexao->prepare("SELECT * from sakila.actor;");
			$sth->execute();
			$result = $sth->fetchAll();
			print_r($result);
			*/
			
		}
		catch(\PDOException $ex)
		{
			echo $ex->getMessagem()."\n";
			echo $ex->getTraceAsString()."\n";
		}
	}
	
	function inserirDados(array $dado, \PDO $conexao, int $usuario)
	{
		try
		{
            if($usuario == 1)
            {
                $sql = "insert into paginas.usuarios (nome, senha) values (:nome, :password);";
			    $stmt = $conexao->prepare($sql);
			    $stmt->bindValue("nome", $dado['nome']);
			    $stmt->bindValue("password", $dado['password']);
                $ret = $stmt->execute();
            }
            else
            {
			    $sql = "insert into paginas.paginas (nome, title, pagina) values (:nome, :titulo, :pagina);";
			    $stmt = $conexao->prepare($sql);
			    $stmt->bindValue("nome", $dado['nome']);
			    $stmt->bindValue("titulo", $dado['title']);
			    $stmt->bindValue("pagina", $dado['pagina']);
			    $ret = $stmt->execute();
            }
		}
	    catch(\PDOException $ex)
		{
			throw $ex;
		}
	}
	
	// =============================Fixture==========================================

?>

<div class="well">
	<center>
		<h1>Conexão - Gerando os dados do Banco de dados</h1>
		
	</center>
</div>
<div class="panel panel-default">
	<div class="panel-body">
	<?php fixture();?>
	</div>
</div>