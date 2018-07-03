<?php

require_once PATH_APP . '/service/secondCallService.php';
require_once PATH_APP . '/model/secondCallClass.php';

class SecondCallController
{

    public function findSecondCallByAdmin()
    {
        try {

            $secondCall = new SecondCall();
            $consult = $secondCall->findByAdmin();
            if ($consult && num_rows($consult) != 0) {
                $result = [];
                while ($row = fetch($consult)) {
                    array_push($result, array($row['idSecondCall'], $row['descSecondCall'], $row['localFile'], $row['status'], $row['local'], $row['date'], $row['descTest'], $row['descMatter']));
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

    public function findSecondCallByTeacher($idUser)
    {
        try {
            $arrayConts = validateVariables([$idUser]);

            $secondCall = new SecondCall();
            $secondCall->setIdSecondCall($arrayConts);
            $consult = $secondCall->findByTeacher();
            if ($consult && num_rows($consult) != 0) {
                $result = [];
                while ($row = fetch($consult)) {
                    $date = dateForScreen($row['date']);
                    array_push($result, array($row['idSecondCall'], $row['descSecondCall'], $row['localFile'], $row['status'], $row['local'], $date, $row['descTest'], $row['descMatter']));
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

    public function findSecondCallByStudent($idUser)
    {
        try {
            $arrayConts = validateVariables([$idUser]);

            $secondCall = new SecondCall();
            $secondCall->setIdSecondCall($arrayConts);
            $consult = $secondCall->findByStudent();
            if ($consult && num_rows($consult) != 0) {
                $result = [];
                while ($row = fetch($consult)) {
                    $date = dateForScreen($row['date']);
                    array_push($result, array($row['idSecondCall'], $row['descSecondCall'], $row['localFile'], $row['status'], $row['local'], $date, $row['descTest'], $row['descMatter']));
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

    public function register($description, $idTest, $archive)
    {
        try {

            $localFile = saveFile($archive);

            $arrayConts = validateVariables([$description, $localFile, $idTest, $_SESSION['session']['userId']]);

            $secondCall = new SecondCall();
            $secondCall->construct($arrayConts);

            $consult = $secondCall->insertSecondCall();

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

    public function approves($id)
    {
        try {

            $arrayConts = validateVariables([$id]);

            $secondCall = new SecondCall();
            $secondCall->setIdSecondCall($arrayConts);

            $consult = $secondCall->approvesSecondCall();

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

    public function disapprove($id)
    {
        try {

            $arrayConts = validateVariables([$id]);

            $secondCall = new SecondCall();
            $secondCall->setIdSecondCall($arrayConts);

            $consult = $secondCall->disapproveSecondCall();

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

    public function updateSecondCall($local, $date, $idSecondCall)
    {
        try {

            $arrayConts = validateVariables([$local, $date, $idSecondCall]);

            $secondCall = new SecondCall();
            $secondCall->constructUpdate($arrayConts);

            $consult = $secondCall->updateSecondCall();

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
