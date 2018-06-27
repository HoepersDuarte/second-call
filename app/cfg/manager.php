<?php 

	function conecta() {
		try {
			if (session_id() == null)
				session_start();
					
			$conexao = new PDO("mysql:host=localhost;dbname=secondcall", "root", "") or die("Nao conectou");
			return $conexao;
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	function fetch($result) {
		if (!is_null($result) && (!empty($result)))
			return $result->fetch(PDO::FETCH_ASSOC);
		else return 0;
	}
	
	function fetchArray($result) {
		if (!is_null($result) && (!empty($result)))
			return $result->fetch(PDO::FETCH_BOTH);
		else return 0;
	}
	
	function num_rows($result) {
		if (!is_null($result) && (!empty($result)))
			return $result->rowCount();
		else return 0;
	}

	function queryInsert($sql) {
		if (!is_null($sql) && (!empty($sql))) {
			try{
				$conexao = conecta();
				$stmt = $conexao->prepare($sql);
				$stmt->execute(); // = $conexao->query($sql);
				$erro = $stmt->errorInfo();
				if (!empty($erro[1])) {
					return false;
				}
				$id = $conexao->lastInsertId();
				return $id;
			}
			catch ( PDOException $error_query ) {
				return false;
			}
		}
		else return null;
	}
	
	function querySelect($sql) {
		if (!is_null($sql) && (!empty($sql))) {
			try {
				$conexao = conecta();
				$stmt = $conexao->prepare($sql);
				$stmt->execute();// = $conexao->query($sql);
				$erro = $stmt->errorInfo();
				if (!empty($erro[1])) {
					return false;
				}
				return $stmt;
			}
			catch ( PDOException $error_query )
			{
				return false;
			}
		}
		else return null;
	}
	
	function fetch_object($result) {
		if (!is_null($result) && (!empty($result)))
			return $result->fetch(PDO::FETCH_OBJ);
		else return 0;
	}
	
	function affected_rows($result)  {
		if (!is_null($result) && (!empty($result)))
			return $result->rowCount();
		else return 0;
	}
	
	function validateVariables($parameters) {
		for ($i = 0; $i < sizeof($parameters); $i++)
			$arrayConts[$i] = valueCheck($parameters[$i]);
			
		return $arrayConts;
	}
	
 	function valueCheck($value) {
		if (empty($value))
			return 0;
		
		$m = @strtoupper($value);
		$select = strripos($m, 'SELECT');
		$update = strripos($m, 'UPDATE');
		$delete = strripos($m, 'DELETE');
		$drop = strripos($m,'DROP ');
		$innerjoin = strripos($m, 'INNER JOIN');
		$outerjoin = strripos($m, 'OUTER JOIN');
		if (($select == true) || ($update == true) || ($delete == true) || ($innerjoin == true) || ($outerjoin == true) || ($drop == false)) {
			return 0;
		}
		if (is_string($value)) {
			if ($value=="%%")
				return 0;
		}

		return $value;
	}
	
	function consoleLog($msg) {
		echo ('
			<script type="text/javascript"> 
				alert("'.$msg.'"); 
			</script>
		');
	}
	
 	function myLog($message) {
 		try {
			$local = PATH_APP . "/cfg/logs/Log".'_'.date('Y-m-d').'.txt';
			$file = fopen($local  ,"a+");
			fwrite($file,date("d-m-Y H:i:s") . ': ' . $message . "\r\n");
			fclose($file);
			
 		}
 		catch (Exception $e) {
 				consoleLog('Ocorreu um erro ao tentar criar o Log. '.$e->getMessage() );
 			}
 		}
 	}
 	
	function validateKeyUser($key) {
		session_start();

		if ($_SESSION['key']==$key)
			return true;

		session_destroy();
		return false;
	}

	function dayOfWeek($date) {  

		$dia =  substr($date,0,2);
		$mes =  substr($date,3,2);
		$ano =  substr($date,6,9);
		$dayWeek = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($dayWeek) {  
			case 0: $dayWeek = "Domingo"; break;  
			case 1: $dayWeek = "Segunda-Feira"; break;  
			case 2: $dayWeek = "Terça-Feira"; break;  
			case 3: $dayWeek = "Quarta-Feira"; break;  
			case 4: $dayWeek = "Quinta-Feira"; break;  
			case 5: $dayWeek = "Sexta-Feira"; break;  
			case 6: $dayWeek = "Sabado"; break;  
		}                
		return $dayWeek;
	}
	
	function dateTimeForScreen($date) {
		$dateToConvert = strtotime( $date );
		$dateConverted = date('H:i d/m/Y', $dateToConvert);
		return $dateConverted;
	}
	

	function numerecMonthToMonth($month) {
		switch ($month) {
			case 1 	: $str = "Janeiro";		break;
			case 2 	: $str = "Fevereiro"; 	break;
			case 3 	: $str = "Março";		break;
			case 4	: $str = "Abril"; 		break;
			case 5 	: $str = "Maio"; 		break;
			case 6 	: $str = "Junho"; 		break;
			case 7 	: $str = "Julho"; 		break;
			case 8 	: $str = "Agosto"; 		break;
			case 9 	: $str = "Setembro"; 	break;
			case 10 : $str = "Outubro"; 	break;
			case 11 : $str = "Novembro";	break;
			case 12 : $str = "Dezembro"; 	break;
		}
		return $str;
	}

?>