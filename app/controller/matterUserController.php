<?php

require_once PATH_APP . '/service/matterUserService.php';
require_once PATH_APP . '/model/matterUserClass.php';

class MatterUserController
{

    public function addMatterOnUser($token, $idUser)
    {
        try {
            
            $result = findMatterByToken(validateVariables([$token]));

            if (!$result) {
                return false;
            }

            $arrayConts = validateVariables([$idUser, $result]);

            $matterUser = new MatterUser();
            $matterUser->construct($arrayConts);

            $consult = $matterUser->insertMatterUser();

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
