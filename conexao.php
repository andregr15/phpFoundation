<?php
	function getConexao()
	{
		try
		{		
			$dbConfig = array
			(
				"host" => "localhost",
				"dataBase" => "paginas",
				"user" => "root",
				"password" => "1234"
			);	
			
			return new \PDO("mysql:host={$dbConfig['host']};dbname=", $dbConfig['user'], $dbConfig['password']);
		}
		catch(\PDOException $ex)
		{
			echo $ex->getMessage()."\n";
			echo $ex->getTraceAsString()."\n";
		}
	}
?>



