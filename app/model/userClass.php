<?php

    require_once PATH_CFG . '/config.php';
    
    class User (){
        private $name;
        private $email;
        private $password;
        private $phone;
        private $fk_idTypeUser;

        function __construct($arrayConts) {
            $this->name = $arrayConts[0];
            $this->email = $arrayConts[1];
            $this->password = $arrayConts[2];
            $this->phone = $arrayConts[3];
            $this->fk_idTypeUser = $arrayConts[4];
        }

        function selectUser() {
            try {
            $sql = "SELECT * FROM `user` WHERE 1";
        return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function insertUser() {
            try {
            $sql = "INSERT INTO `user`(`idUser`, `name`, `email`, `password`, `phone`, `fk_idUserType`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])";
        return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function updateUser() {
            try {
            $sql = "UPDATE `user` SET `idUser`=[value-1],`name`=[value-2],`email`=[value-3],`password`=[value-4],`phone`=[value-5],`fk_idUserType`=[value-6] WHERE 1";
        return true;    
        }
        catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro.");
  				exit();
  			}
        }

        function deleteUser() {
            try {
            $sql = "DELETE FROM `user` WHERE 0";
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