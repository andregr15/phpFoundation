
<?php
//$rotas = ["Home"=> "index.php", "Contato" => "contato.php", "Empresa" => "empresa.php", "Produtos" => "produto.php", "Serviços" => "servicos.php", "Contato Enviado" => "contatoEnviado.php", "Página Não Encontrada" => "404.php"];
$rota = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

function checarRota(string $rota)
{
    $nomeArquivo = substr($rota, 1, strlen($rota) -1);

    $nomeArquivo = strpos($nomeArquivo, ".php") ? $nomeArquivo : $nomeArquivo . ".php";

    if(!file_exists($nomeArquivo))
    {
        header("HTTP/1.0 404 Not Found");
        return "404.php";
    }
    return $nomeArquivo;
}

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
            require_once($nomeArquivo); 
            ?>
	</body>
	
	<?php require_once("rodape.php"); ?>
</html>
	