<?php

    require_once 'app/cfg/manager.php';
	
	class MetterUser {
		private $MatterUser_idUser;
		private $MatterUser_idMatter;

		function __construct($arrayConts) {
			$this->MatterUser_idUser = $arrayConts[0];
			$this->MatterUser_idMatter = $arrayConts[1];
		}

		function selectMatter() {
			try {
				$sql = 'SELECT * FROM MetterUser WHERE 1';
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
				$sql = 'INSERT INTO MetterUser (MatterUser_idUser, MatterUser_idMatter) VALUES ('.$this->MatterUser_idUser.', '.$this->MatterUser_idMatter.')';
				myLog('try Insert -> '.$sql);
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
				$sql = 'DELETE FROM MetterUser WHERE MatterUser_idUser = '.$this->MatterUser_idUser.' AND MatterUser_idMatter = '.$this->MatterUser_idMatter.'';
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