<?php

session_start();
$paginaEdicao = "";
$nomePagina = "";

if(isset($_REQUEST['deslogar']) && isset($_SESSION['logado']))
{
	$_SESSION['logado'] = 0;
	echo "<div class=\"well\">
			<center>
				<h1>Deslogado</h1>
			</center>
		 </div>";
		 return;
}

if(isset($_POST['usuario']) and isset($_POST['password']))
{
	$usuario = $_POST['usuario'];
	$senha = $_POST['password'];
	
	$_SESSION['logado'] = checarUsuario($usuario, $senha);
}

if(isset($_SESSION['logado']) && $_SESSION['logado'] == 0)
{   
    echo "<div class=\"well\">
			<center>
				<h1>Usuario ou senha inválidos ou usuário não logado, clique no menu administração!</h1>
			</center>
		 </div>";
	die();
}

if(isset($_GET['pagina']))
{
	$nomePagina = $_GET['pagina'];
	$paginaEdicao = getPagina($nomePagina)['pagina'];
}

if(isset($_POST['salvar']) && isset($_POST['nomePagina']))
{
	atualizarPagina($_POST['nomePagina'], stripslashes(str_replace('"', '\\"', trim(preg_replace('/\s\s+/', ' ',  $_POST['editor1'])))));
	$paginaEdicao = 'A página ' . $_POST['nomePagina'] . ' foi atualizada com sucesso!';
}

if(isset($_REQUEST['cancelar']))
{
	$paginaEdicao = "";
	$nomePagina = "";
}

// ==============Funções para obter dados do banco de dados======================

// função para pegar a senha do banco de dados e verifica-la
function checarUsuario(string $usuario, string $password)
{
	try
	{
		$conexao = getConexao();
		
        $sql = "select senha from paginas.usuarios where nome = :nome;";
		$stmt = $conexao->prepare($sql);
		$stmt->bindValue("nome", $usuario);
        $stmt->execute();
		$ret = $stmt->fetch();
        return isset($ret['senha']) ? password_verify($password, $ret['senha']) : 0 ;
	}
	catch(\PDOException $ex)
	{
		echo $ex->getMessage()."\n";
		echo $ex->getTraceAsString()."\n";
		die();
	}
}

// função para atualizar a página do banco de dados
function atualizarPagina(string $nomePagina, string $pagina)
{
	try
	{
		$conexao = getConexao();
		
		$sql = "update paginas.paginas set pagina = :pagina where nome = :nome;";
		$stmt = $conexao->prepare($sql);
		$stmt->bindValue("nome", $nomePagina);
		$stmt->bindValue("pagina", $pagina);
		$stmt->execute();
		$ret = $stmt->fetch();
		return $ret;
	}
	catch(\PDOException $ex)
	{
		echo $ex->getMessage()."\n";
		echo $ex->getTraceAsString()."\n";
		die();
	}
}

// ==============================================================================


?>

<div class="well">
	<center>
		<h1>Administração</h1>
	</center>
</div>
		
<div class="panel panel-default">
	<div class="panel-body">
	    <form method="post" action="administracao" style="width: 90%;">	
				<h4>Para editar alguma página por favor selecione-a no menu abaixo:</h4>
				
				<ul class="nav nav-tabs nav-justified" id="myNav">
					<li><a href="?pagina=empresa">Empresa</a></li>
					<li><a href="?pagina=produtos">Produtos</a></li>
					<li><a href="?pagina=servicos">Serviços</a></li>
					<li><a href="?pagina=contato">Contato</a></li>
					<li><a href="?pagina=404">404</a></li>
				</ul>
				
				<textarea name="editor1" id="editor1" rows="500" cols="1000">
                </textarea>
                <script type="text/javascript">
				      CKEDITOR.replace( 'editor1' );
                      CKEDITOR.instances.editor1.on('instanceReady',function(){
                      CKEDITOR.instances.editor1.setData('<?php echo stripslashes($paginaEdicao);?>');
                     });

                </script>
				<br>
				<input type="submit" name="salvar" value="Salvar"/>
				<input type="submit" name="cancelar" value="Cancelar"/>
				<input type="submit" name="deslogar" value="Deslogar"/>
				<input type="hidden" name="nomePagina" value="<?php echo $nomePagina;?>">
	        </form>
        <br>
	</div>
</div>