<?php

    require_once PATH_CFG . '/config.php';
    
    class Matter (){
        private $id;
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

        function selectMatter() {
            try {
                $sql = 'SELECT * FROM `matter` WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertMatter() {
            try {
                $sql = 'INSERT INTO `matter`(`idMatter`, `description`, `time`, `token`, `fk_idHalf`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])';
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
                $sql = 'UPDATE `matter` SET `idMatter`=[value-1],`description`=[value-2],`time`=[value-3],`token`=[value-4],`fk_idHalf`=[value-5] WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteMatter() {
            try {
                $sql = 'DELETE FROM `matter` WHERE 0';
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