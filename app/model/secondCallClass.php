<?php

require_once 'app/cfg/manager.php';

class SecondCall
{
    private $idSecondCall;
    private $description;
    private $localFile;
    private $status;
    private $local;
    private $date;
    private $fk_idTest;
    private $fk_idUser;

    public function construct($arrayConts)
    {
        $this->description = $arrayConts[0];
        $this->localFile = $arrayConts[1];
        $this->fk_idTest = $arrayConts[2];
        $this->fk_idUser = $arrayConts[3];
        $this->status = 1;
        $this->local = '-';
        $this->date = '-';
    }

    public function setIdSecondCall($arrayConts)
    {
        $this->idSecondCall = $arrayConts[0];
        return true;
    }

    public function findAll()
    {
        try {
            $sql = 'SELECT secondcall.idSecondCall, secondcall.description descSecondCall, secondcall.localFile, secondcall.status, secondcall.local, secondcall.date, test.description descTest ,matter.description descMatter FROM secondcall INNER JOIN user ON (user.idUser = secondcall.fk_idUser) INNER JOIN test ON (test.idTest = secondcall.fk_idTest) INNER JOIN matter ON (matter.idMatter = test.fk_idMatter)';
            myLog('try selec -> ' . $sql);
            $select = querySelect($sql);
            return $select;
        } //
         catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function insertSecondCall()
    {
        try {
            $sql = 'INSERT INTO secondcall(description, localFile, status, local, date, fk_idTest, fk_idUser) VALUES ("' . $this->description . '", "' . $this->localFile . '", "' . $this->status . '", "' . $this->local . '", NULL, ' . $this->fk_idTest . ', ' . $this->fk_idUser . ')';
            myLog('try Insert -> ' . $sql);
            $select = queryInsert($sql);
            return true;
        } catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function approvesSecondCall()
    {
        try {
            $sql = 'UPDATE secondcall SET status=3 WHERE idSecondCall=' . $this->idSecondCall . '';
            myLog('try approvesSecondCall -> ' . $sql);
            $select = queryInsert($sql);
            return true;
        } catch (Exception $e) {
            myLog('catch approvesSecondCall -> ' . $e);
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function disapproveSecondCall()
    {
        try {
            $sql = 'UPDATE secondcall SET status=2 WHERE idSecondCall=' . $this->idSecondCall . '';
            myLog('try disapproveSecondCall -> ' . $sql);
            $select = queryInsert($sql);
            return true;
        } catch (Exception $e) {
            myLog('catch disapproveSecondCall -> ' . $e);
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function updateSecondCall()
    {
        try {
            $sql = 'UPDATE secondcall SET description="' . $this->idSecondCall . '", localFile="' . $this->idSecondCall . '", status="' . $this->status . '", local="' . $this->local . '", date="' . $this->date . '" WHERE idSecondCall=' . $this->idSecondCall . '';
            myLog('try Update -> ' . $sql);
            $select = queryInsert($sql);
            return true;
        } catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function deleteSecondCall()
    {
        try {
            $sql = 'DELETE FROM secondcall WHERE idSecondCall=' . $this->idSecondCall . '';
            myLog('try delete -> ' . $sql);
            $select = queryInsert($sql);
            return true;
        } catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

}
