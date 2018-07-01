<?php

require_once PATH_APP . '/service/halfService.php';
require_once PATH_APP . '/model/halfClass.php';

class HalfController
{

    public function findHalf()
    {
        try {

            $half = new Half();
            $consult = $half->findAll();
            if ($consult && num_rows($consult) != 0) {
                $result = [];
                while ($row = fetch($consult)) {
                    array_push($result, array($row['idHalf'] , $row['description'], $row['token']));
                }

                return $result;
            }

            return false;
        } //
        catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            return null;
            exit();
        }
    }

    function register($name) {
        try {

            $token = criaToken($name);

            $arrayConts = validateVariables([$name, $token]);
            
            $half = new Half();
            $half->construct($arrayConts);

            $consult = $half->insertHalf();

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
