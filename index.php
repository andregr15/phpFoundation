
<?php
require_once("conexao.php");

$rotas = ["Home"=> "index.php", "Contato" => "contato.php", "Empresa" => "empresa.php", "Produtos" => "produto.php", "Serviços" => "servicos.php", "Contato Enviado" => "contatoEnviado.php", "404" => "404.php"];

$rota = "";
$rota = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$titulo = "";

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
        case "login.php":
        case "administracao.php":
			$titulo = str_replace(".php", "", $nomeArquivo);
			break;
		case "contato.php":
		case "empresa.php":
		case "produtos.php":
		case "servicos.php":
			$titulo = str_replace(".php", "", $nomeArquivo);
			$nomeArquivo = getPagina(strtolower(str_replace(".php", "", $nomeArquivo)))['pagina'];
			break;
		default:
			$titulo = "404";
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
        <meta charset="utf-8">
        <script src="../ckeditor.js"></script>
		<title><?php echo $titulo; ?></title>
	</head>
	
	<body>
		<center>
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
		</center>
	</body>
	
	<?php require_once("rodape.php"); ?>
</html>
	