<?php

require_once PATH_APP . '/service/testService.php';
require_once PATH_APP . '/model/testClass.php';

class TestController
{

    public function findTest()
    {
        try {

            $test = new Test();
            $consult = $test->findAll();
            if ($consult && num_rows($consult) != 0) {
                $result = [];
                while ($row = fetch($consult)) {
                    array_push($result, array($row['idTest'], $row['descTest'], $row['descMatter']));
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

    public function register($name, $idMatter)
    {
        try {

            $arrayConts = validateVariables([$name, $idMatter]);

            $test = new Test();
            $test->construct($arrayConts);

            $consult = $test->insertTest();

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
