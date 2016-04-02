<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<title>Contato</title>
	</head>
	
	<body>
		<?php require_once("menu.php"); ?>
		
		<div class="well">
			<center>
				<h1>Contato</h1>
			</center>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-body">
			<form method="post"  action="contatoEnviado.php" >
			  Nome:<br>
			  <input type="text" name="nome"/><br>
			  E-mail:<br>
			  <input type="text" name="email"/><br>
			  Assunto:<br>
			  <select name="assunto">
				  <option value="suporte">Suporte</option>
				  <option value="ouvidoria">Ouvidoria</option>
				  <option value="outros">Outros</option>
			  </select>	  
			  Mensagem:<br>
			  <textarea rows="4" cols="50" name="mensagem"></textarea><br>
			  <input type="submit" value="Evniar"/>
			</form>
		  </div>
		</div>
	</body>
	
	<?php require_once("rodape.php"); ?>
</html>
	