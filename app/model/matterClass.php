<?php

	require_once PATH_CFG . '/config.php';
	
	class Matter (){
		private $idMatter;
		private $description;
		private $time;
		private $token;
		private $fk_idHalf;

		function __construct($arrayConts) {
			$this->description = $arrayConts[0];
			$this->time = $arrayConts[1];
			$this->token = $arrayConts[2];
			$this->fk_idHalf = $arrayConts[3];
		}

		function setIdMatter($arrayConts) {
			$this->idMatter = $arrayConts[0];
			return true;
		}

		function selectMatter() {
			try {
				$sql = 'SELECT * FROM matter WHERE 1';
				myLog('try selec -> '.$sql);
				 
				$select = querySelect($sql);
				return $select;
			}
			catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
		}

		function insertMatter() {
			try {
				$sql = 'INSERT INTO matter(description, time, token, fk_idHalf) VALUES ("'.$this->description.'", "'.$this->time.'", "'.$this->token.'", '.$this->fk_idHalf.')';
				myLog('try Insert -> '.$sql);
				$select = queryInsert($sql);
				return true; 
			}
			catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
		}

		function updateMatter() {
			try {
				$sql = 'UPDATE matter SET description="'.$this->description.'", time="'.$this->time.'" WHERE idMatter='.$this->idMatter.'';
				myLog('try Update -> '.$sql);
				$select = queryInsert($sql);
                return true; 
			}
			catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
		}

		function deleteMatter() {
			try {
				$sql = 'DELETE FROM matter WHERE '.$this->idMatter.'';
				myLog('try delete -> '.$sql);
				$select = queryInsert($sql);
                return true;  
			}
			catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
		}

	}
?>