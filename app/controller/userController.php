<?php

require_once PATH_APP . '/service/userService.php';
require_once PATH_APP . '/model/userClass.php';

class UserController
{

    public function logar($email, $password)
    {
        try {
            if (!validateEmail($email)) {
                return false;
            }

            if (!validatePassword($password)) {
                return false;
            }

            $arrayConts = validateVariables([null, $email, $password, null, null]);

            $arrayConts[2] = encryptPassword($arrayConts[2]);

            $user = new User();
            $user->construct($arrayConts);

            $consult = $user->selectLogin();
            if ($consult && num_rows($consult)) {
                $row = fetch($consult);
                $token = sha1(date('Y-m'));
                $session = array('userId' => $row['idUser'], 'userName' => $row['name'], 'userType' => $row['description']);
                $_SESSION['session'] = $session;
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            return null;
            exit();
        }
    }

    public function register($name, $email, $password, $passwordConfirm, $phone, $token)
    {
        try {
            if (!validateEmail($email)) {
                return false;
            }

            if (!validatePassword($password)) {
                return false;
            }

            if ($password != $passwordConfirm) {
                return false;
            }

            $result = validateToken(validateVariables([$token]));

            if (!$result) {
                return false;
            }

            $arrayConts = validateVariables([$name, $email, $password, $phone, $result]);

            $arrayConts[2] = encryptPassword($arrayConts[2]);

            $user = new User();
            $user->construct($arrayConts);

            $consult = $user->insertUser();

            if ($consult) {
                return true;
            }

            return false;
        } //
         catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            return null;
            exit();
        }
    }
}
