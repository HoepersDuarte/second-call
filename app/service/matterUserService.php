<?php
require_once 'app/model/matterClass.php';

function findMatterByToken($arrayConstants)
{
    $token = $arrayConstants[0];

    $matter = new Matter();
    $result = $matter->findByToken($token);
    if ($result && num_rows($result) != 0) {
        $row = fetch($result);
        return $row['idMatter'];
    }
    
    return false;
}
