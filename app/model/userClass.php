<?php
    
    require_once 'app/cfg/manager.php';

    class User {
        private $idUser;
        private $name;
        private $email;
        private $password;
        private $phone;
        private $fk_idTypeUser;

        function construct($arrayConts) {
            $this->name = $arrayConts[0];
            $this->email = $arrayConts[1];
            $this->password = $arrayConts[2];
            $this->phone = $arrayConts[3];
            $this->fk_idTypeUser = $arrayConts[4];
        }

        function setIdUser($arrayConts) {
            $this->idUser = $arrayConts[0];
            return true;
        }

        function selectLogin() {
            try {
                $sql = 'SELECT * FROM user INNER JOIN usertype ON (usertype.idUserType = user.fk_idUserType) WHERE email="'.$this->email.'" AND password="'.$this->password.'";';
                myLog('try Select -> '.$sql);
                $select = querySelect($sql);
                return $select;   
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertUser() {
            try {
                // $teste = ;
                $sql = 'INSERT INTO user (name, email, password, phone, fk_idUserType) VALUES ("'.$this->name.'", "'.$this->email.'", "'.$this->password.'", "'.$this->phone.'", "'.$this->fk_idTypeUser.'")';
                myLog('try insert User -> '.$sql);
                $select = queryInsert($sql);
                return true; 
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateUser() {
            try {
                $sql = 'UPDATE user SET name="'.$this->name.'", email="'.$this->email.'", password="'.$this->password.'", phone="'.$this->phone.'" WHERE idUser = '.$this->idUser.'';
                myLog('try Update -> '.$sql);
                $select = queryInsert($sql);
                return true;    
            }
            catch (Exception $e) {
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteUser() {
            try {
                $sql = 'DELETE FROM user WHERE idUser = '.$this->idUser.'';
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