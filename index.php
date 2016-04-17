
<?php
require_once("conexao.php");

$rotas = ["Home"=> "index.php", "Contato" => "contato.php", "Empresa" => "empresa.php", "Produtos" => "produto.php", "Serviços" => "servicos.php", "Contato Enviado" => "contatoEnviado.php", "404" => "404.php"];

$rota = "";
$rota = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

function checarRota(string $rota)
{
    $nomeArquivo = substr($rota, 1, strlen($rota) -1);

    if(!isset($nomeArquivo) || $nomeArquivo == "")
    {
        $nomeArquivo = "index.php";
    }

    $nomeArquivo = strpos($nomeArquivo, ".php") ? $nomeArquivo : $nomeArquivo . ".php"; 

	switch($nomeArquivo)	
	{
		case "index.php":
		case "contatoEnviado.php":
		case "fixture.php":
			break;
		case "contato.php":
		case "empresa.php":
		case "produtos.php":
		case "servicos.php":
			$nomeArquivo = getPagina(strtolower(str_replace(".php", "", $nomeArquivo)))['pagina'];
			break;
		default:
			$nomeArquivo = getPagina("404")['pagina'];
			break;
	}
	
    /*if(!file_exists($nomeArquivo))
    {
       return "404.php";
    }*/
	
    return $nomeArquivo;
}

// ==============Funções para obter dados do banco de dados======================

// função para pegar a página do banco de dados
function getPagina(string $nomePagina)
{
	try
	{
		$conexao = getConexao();
		
		$sql = "select pagina, title from paginas.paginas where nome = :nome;";
		$stmt = $conexao->prepare($sql);
		$stmt->bindValue("nome", $nomePagina);
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

$nomeArquivo = checarRota($rota['path']);
?>

<html>
	<head>
        <link href="css/bootstrap.min.css" rel="stylesheet">
		<title><?php $titulo = str_replace(".php", "", $nomeArquivo); echo strtoupper($titulo[0]) . substr($titulo, 1, strlen($titulo) -1);?></title>
	</head>
	
	<body>
    	<?php 
            require_once("menu.php"); 
            if($nomeArquivo == "index.php" || $nomeArquivo == "index") 
            {   
                echo "<div class=\"well\">	<center>		<h1>Home</h1>	</center></div>";
            }

			if(str_replace(".php", "", $nomeArquivo) == "404")
            {
                //gerando erro no php, peguntei na parte de dúvidas e não obtive resposata até o momento 07/04/2016 18:22
                header("HTTP/1.0 404 Not Found");
            }
			
			if(strpos($nomeArquivo, "<div ") === false)
			{
				require_once($nomeArquivo);     
			}
			else if($nomeArquivo != "index.php" && $nomeArquivo != "index" && $nomeArquivo != "contatoEnviado.php" && $nomeArquivo != "contatoEnviado")
			{
				print_r($nomeArquivo);
			}			
           
		?>
	</body>
	
	<?php require_once("rodape.php"); ?>
</html>
	