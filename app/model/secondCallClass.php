<?php

    require_once PATH_CFG . '/config.php';
    
    class SecondCall (){
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

        function selectSecondCall() {
            try {
                $sql = 'SELECT * FROM `secondcall` WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertSecondCall() {
            try {
                $sql = 'INSERT INTO `secondcall`(`idSecondCall`, `description`, `localFile`, `status`, `local`, `date`, `fk_idTest`, `fk_idUser`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateSecondCall() {
            try {
                $sql = 'UPDATE `secondcall` SET `idSecondCall`=[value-1],`description`=[value-2],`localFile`=[value-3],`status`=[value-4],`local`=[value-5],`date`=[value-6],`fk_idTest`=[value-7],`fk_idUser`=[value-8] WHERE 1';
                return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteSecondCall() {
            try {
                $sql = 'DELETE FROM `secondcall` WHERE 0';
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