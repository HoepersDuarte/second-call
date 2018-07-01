<?php

function saveFile($archive)
{

    $fileTmp = $archive['archive']['tmp_name'];
    $nameFile = $archive['archive']['name'];

    if (!file_exists('app/cfg/files/' . $_SESSION['session']['userId'].'/' )){
        mkdir('app/cfg/files/' . $_SESSION['session']['userId'].'/', 0777, true);
    }
    
    $destination = 'app/cfg/files/' . $_SESSION['session']['userId'] . '/file_' . date('Y-m-d') . '_' . $nameFile;

    if (@move_uploaded_file($fileTmp, $destination)) {
        return $destination;
    }

    $local = 'Erro ao salvar arquivo';
    return $local;
}
