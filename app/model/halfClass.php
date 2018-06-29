<?php

    require_once PATH_CFG . '/config.php';
    
    class Half (){
        private $idHalf;
        private $description;
        private $token;

        function __construct($arrayConts) {
            $this->description = $arrayConts[0];
            $this->token = $arrayConts[1];
        }

        function setIdHalf($arrayConts) {
            $this->idHalf = $arrayConts[0];
            return true;
        }

        function selectHalf() {
            try {
                $sql = 'SELECT * FROM half WHERE 1';
                myLog('try selec -> '.$sql);
                 
				$select = querySelect($sql);
                return $select;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro.");
                exit();
            }
        }

        function insertHalf() {
            try {
                $sql = 'INSERT INTO half(description, token) VALUES ("'.$this->description.'","'.$this->token.'")';
                myLog('try Insert -> '.$sql);
				$select = queryInsert($sql);
                return true;    
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateHalf() {
            try {
                $sql = 'UPDATE half SET description="'.$this->description.'" WHERE idHalf='.$this->idHalf.'';
                myLog('try Update -> '.$sql);
				$select = queryInsert($sql);
                return true;    
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteHalf() {
            try {
                $sql = 'DELETE FROM half WHERE idHalf='.$this->idHalf.' ';
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