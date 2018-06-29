<?php
    function criaToken($name) {
        return sha1($name . date('Y-m-d') . 'MyToken');
    }
?>