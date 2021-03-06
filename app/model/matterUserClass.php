<?php

    require_once 'app/cfg/manager.php';
	
	class MatterUser {
		private $MatterUser_idUser;
		private $MatterUser_idMatter;

		function construct($arrayConts) {
			$this->MatterUser_idUser = $arrayConts[0];
			$this->MatterUser_idMatter = $arrayConts[1];
		}

		function insertMatterUser() {
			try {
				$sql = 'INSERT INTO MatterUser (MatterUser_idUser, MatterUser_idMatter) VALUES ('.$this->MatterUser_idUser.', '.$this->MatterUser_idMatter.')';
				myLog('try insertMatterUser -> '.$sql);
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
				$sql = 'DELETE FROM MatterUser WHERE MatterUser_idUser = '.$this->MatterUser_idUser.' AND MatterUser_idMatter = '.$this->MatterUser_idMatter.'';
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