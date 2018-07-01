<?php

require_once PATH_APP . '/service/userService.php';
require_once PATH_APP . '/model/userClass.php';

class SecondCallController
{

    public function findMatter()
    {
        try {

            $matter = new Matter();
            $consult = $matter->findAll();
            if ($consult && num_rows($consult) != 0) {
                $result = [];
                while ($row = fetch($consult)) {
                    array_push($result, array($row['idMatter'], $row['descMatter'], $row['time'], $row['token'], $row['descHalf']));
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

    public function register($name, $time, $idHalf)
    {
        try {

            $token = criaToken($name);

            $arrayConts = validateVariables([$name, $time, $token, $idHalf]);

            $matter = new Matter();
            $matter->construct($arrayConts);

            $consult = $matter->insertMatter();

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
