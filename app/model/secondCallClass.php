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

    public function constructUpdate($arrayConts)
    {
        $this->local = $arrayConts[0];
        $this->date = $arrayConts[1];
        $this->idSecondCall = $arrayConts[2];
        $this->status = 4;
    }

    public function setIdSecondCall($arrayConts)
    {
        $this->idSecondCall = $arrayConts[0];
        return true;
    }

    public function findByAdmin()
    {
        try {
            $sql = 'SELECT secondcall.idSecondCall, secondcall.description descSecondCall, secondcall.localFile, secondcall.status, secondcall.local, secondcall.date, test.description descTest, matter.description descMatter FROM secondcall INNER JOIN test ON (secondcall.fk_idTest=test.idTest) INNER JOIN matter ON (test.fk_idMatter=matter.idMatter) WHERE secondcall.status = 1'; //, user.name INNER JOIN matteruser ON (matter.idMatter=matteruser.MatterUser_idMatter) INNER JOIN user ON (matteruser.MatterUser_idUser=user.idUser)
            myLog('try selec -> ' . $sql);
            $select = querySelect($sql);
            return $select;
        } //
         catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function findByTeacher()
    {
        try {
            $sql = 'SELECT secondcall.idSecondCall, secondcall.description descSecondCall, secondcall.localFile, secondcall.status, secondcall.local, secondcall.date, test.description descTest, matter.description descMatter FROM secondcall INNER JOIN test ON (secondcall.fk_idTest=test.idTest) INNER JOIN matter ON (test.fk_idMatter=matter.idMatter) INNER JOIN matteruser ON (matteruser.MatterUser_idMatter=matter.idMatter AND matteruser.MatterUser_idUser='.$this->idSecondCall.') WHERE secondcall.status = 3 OR secondcall.status = 4'; //, user.name INNER JOIN matteruser ON (matter.idMatter=matteruser.MatterUser_idMatter) INNER JOIN user ON (matteruser.MatterUser_idUser=user.idUser)
            myLog('try selec -> ' . $sql);
            $select = querySelect($sql);
            return $select;
        } //
         catch (Exception $e) {
            throw new Exception("Ocorreu um erro.");
            exit();
        }
    }

    public function findByStudent()
    {
        try {
            $sql = 'SELECT secondcall.idSecondCall, secondcall.description descSecondCall, secondcall.localFile, secondcall.status, secondcall.local, secondcall.date, test.description descTest, matter.description descMatter FROM secondcall INNER JOIN test ON (secondcall.fk_idTest=test.idTest) INNER JOIN matter ON (test.fk_idMatter=matter.idMatter)  WHERE secondcall.fk_idUser = ' . $this->idSecondCall . ' ;';
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
            $sql = 'UPDATE secondcall SET status="' . $this->status . '", local="' . $this->local . '", date="' . $this->date . '" WHERE idSecondCall=' . $this->idSecondCall . '';
            myLog('try updateSecondCall -> ' . $sql);
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
