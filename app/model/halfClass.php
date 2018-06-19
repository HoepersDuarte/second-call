<?php

    require_once PATH_CFG . '/config.php';
    
    class Half (){
        private $description;
        private $token;

        function __construct($arrayConts) {
            $this->description = $arrayConts[0];
            $this->token = $arrayConts[1];
        }

        function selectHalf() {
            try {
                $sql = 'SELECT * FROM `half` WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertHalf() {
            try {
                $sql = 'INSERT INTO `half`(`idHalf`, `description`, `token`) VALUES ([value-1],[value-2],[value-3])';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateHalf() {
            try {
                $sql = 'UPDATE `half` SET `idHalf`=[value-1],`description`=[value-2],`token`=[value-3] WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteHalf() {
            try {
                $sql = 'DELETE FROM `half` WHERE 0';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

    }
?>