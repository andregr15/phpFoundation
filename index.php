
<?php
$rotas = ["Home"=> "index.php", "Contato" => "contato.php", "Empresa" => "empresa.php", "Produtos" => "produto.php", "Serviços" => "servicos.php", "Contato Enviado" => "contatoEnviado.php", "404" => "404.php"];
$rota = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

function checarRota(string $rota)
{
    $nomeArquivo = substr($rota, 1, strlen($rota) -1);

    if($nomeArquivo == "")
    {
        $nomeArquivo = "index.php";
    }

    $nomeArquivo = strpos($nomeArquivo, ".php") ? $nomeArquivo : $nomeArquivo . ".php"; 

    if(!file_exists($nomeArquivo))
    {
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
            if(str_replace(".php", "", $nomeArquivo) == "404")
            {
                //gerando erro no php, peguntei na parte de dúvidas e não obtive resposata até o momento 07/04/2016 18:22
                header("HTTP/1.0 404 Not Found");
            }

            ?>
	</body>
	
	<?php require_once("rodape.php"); ?>
</html>
	