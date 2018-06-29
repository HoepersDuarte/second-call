<?php

    require_once PATH_APP . '/service/userService.php';
    require_once PATH_APP . '/model/userClass.php';

    class MatterController {
        
        function logar($email, $password) {
            try {
                if(!validateEmail($email))
                    return false;
                if(!validatePassword($password))
                    return false;
        
                $arrayConts = validateVariables([null,$email,$password,null,null]);
        
                $user = new User();
                $user->construct($arrayConts);
        
                $consult = $user->selectLogin();
                if ($consult && num_rows($consult)) {
                    $row = fetch($consult);
                    $token = sha1(date(Y-m));
                    session_start();
                    $_SESSION['User.tokenValidate'] = $token;
                    $_SESSION['User.name'] = $row['name'];
                    $_SESSION['User.type'] = $row['type'];
                    return true;
                }

                return false;
            }
            catch (Exception $e) {
                throw new Exception("Ocorreu um erro.");
                return null;
                exit();
            }
        }

        function register($name, $email, $password, $passwordConfirm, $phone, $token) {
            
        }
    }

?>