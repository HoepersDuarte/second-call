<?php

    require_once PATH_CFG . '/config.php';
    
    class SecondCall (){
        private $idSecondCall;
        private $description;
        private $localFile;
        private $status;
        private $local;
        private $date;
        private $fk_idTest;
        private $fk_idUser;

        function __construct($arrayConts) {
            $this->description = $arrayConts[0];
            $this->localFile = $arrayConts[1];
            $this->status = $arrayConts[2];
            $this->local = $arrayConts[3];
            $this->date = $arrayConts[4];
            $this->fk_idTest = $arrayConts[5];
            $this->fk_idUser = $arrayConts[6];
        }
        
        function setIdSecondCall($arrayConts) {
			$this->idMatter = $arrayConts[0];
			return true;
		}

        function selectSecondCall() {
            try {
                $sql = 'SELECT * FROM secondcall WHERE 1';
                myLog('try selec -> '.$sql);
				$select = querySelect($sql);
				return $select; 
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertSecondCall() {
            try {
                $sql = 'INSERT INTO secondcall(description, localFile, status, local, date, fk_idTest, fk_idUser) VALUES ("'$this->description'", "'$this->localFile'", "'$this->status'", "'$this->local'", "'$this->date'", '$this->fk_idTest', '$this->fk_idUser')';
                myLog('try Insert -> '.$sql);
				$select = queryInsert($sql);
				return true;    
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateSecondCall() {
            try {
                $sql = 'UPDATE secondcall SET description="'$this->idSecondCall'", localFile="'$this->idSecondCall'", status="'$this->status'", local="'$this->local'", date="'$this->date'" WHERE idSecondCall='$this->idSecondCall'';
                myLog('try Update -> '.$sql);
				$select = queryInsert($sql);
                return true;
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteSecondCall() {
            try {
                $sql = 'DELETE FROM secondcall WHERE idSecondCall='$this->idSecondCall'';
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