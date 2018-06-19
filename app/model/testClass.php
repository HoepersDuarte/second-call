<?php

    require_once PATH_CFG . '/config.php';
    
    class Test (){
        private $description;
        private $fk_idMatter;

        function __construct($arrayConts) {
            $this->description = $arrayConts[0];
            $this->fk_idMatter = $arrayConts[1];
        }

        function selectTest() {
            try {
                $sql = 'SELECT * FROM `test` WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertTest() {
            try {
                $sql = 'INSERT INTO `test`(`idTest`, `description`, `fk_idMatter`) VALUES ([value-1],[value-2],[value-3])';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateTest() {
            try {
                $sql = 'UPDATE `test` SET `idTest`=[value-1],`description`=[value-2],`fk_idMatter`=[value-3] WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteTest() {
            try {
                $sql = 'DELETE FROM `test` WHERE 0';
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