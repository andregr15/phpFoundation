
<div class="well">
	<center>
		<h1>Dados enviados com sucesso!</h1>
	</center>
</div>
		
<div class="panel panel-default">
	<div class="panel-body">
	<form>
	<p>Abaixo seguem os dados enviados:</p>
		Nome:<br>
		<input type="text" name="nome" value="<?php echo $_POST["nome"];?>"/><br>
		E-mail:<br>
		<input type="text" name="email" value="<?php echo $_POST["email"];?>"/><br>
		Assunto:<br>
		<select>
			<option <?php echo $_POST["assunto"] == "suporte" ? "selected" : ""; ?>>Suporte</option>
			<option <?php echo $_POST["assunto"] == "ouvidoria" ? "selected" : ""; ?>>Ouvidoria</option>
			<option <?php echo $_POST["assunto"] == "outros" ? "selected" : ""; ?>> Outros</option>
		</select>	  
		Mensagem:<br>
		<textarea rows="4" cols="50" name="mensagem"><?php echo $_POST["mensagem"];?></textarea><br>
	</form>
	</div>
</div>