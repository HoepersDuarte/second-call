<?php

    require_once 'app/cfg/manager.php';
    
    class Test {
        private $idTest;
        private $description;
        private $fk_idMatter;

        function construct($arrayConts) {
            $this->description = $arrayConts[0];
            $this->fk_idMatter = $arrayConts[1];
        }

        function setIdTest($arrayConts){
            $this->idTest = $arrayConts[0];
            return true;
        }

        function findAll() {
            try {
                $sql = 'SELECT test.idTest, test.description descTest, matter.description descMatter  FROM test INNER JOIN matter ON (test.fk_idMatter = matter.idMatter) INNER JOIN matteruser ON (matteruser.MatterUser_idMatter=matter.idMatter) WHERE matteruser.MatterUser_idUser = '.$this->idTest.';';
                myLog('try Select -> '.$sql);
				$select = querySelect($sql);
                return $select;
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertTest() {
            try {
                $sql = 'INSERT INTO test (description, fk_idMatter) VALUES ("'.$this->description.'", '.$this->fk_idMatter.')';
                myLog('try Insert -> '.$sql);
				$select = queryInsert($sql);
                return true;
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateTest() {
            try {
                $sql = 'UPDATE test SET description="'.$this->description.'" WHERE idTest='.$this->idTest.'';
                myLog('try Update -> '.$sql);
				$select = queryInsert($sql);
                return true;   
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteTest() {
            try {
                $sql = 'DELETE FROM test WHERE idTest='.$this->idTest.'';
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