<?php
require_once 'app/model/halfClass.php';
require_once 'app/model/matterClass.php';

function validateEmail($email)
{
    return true;
}

function validatePassword($password)
{
    return true;
}

function validateToken($arrayConstants)
{
    $token = $arrayConstants[0];

    $half = new Half();
    $result = $half->findByToken($token);
    if ($result && num_rows($result) != 0) {
        return 3;
    }

    $matter = new Matter();
    $result = $matter->findByToken($token);
    if ($result && num_rows($result) != 0) {
        return 2;
    }

    return false;
}

function encryptPassword($password)
{
    $password = sha1($password);
    return $password;
}
