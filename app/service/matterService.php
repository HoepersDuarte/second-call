<?php
    function criaTokenMatter($name) {
        return sha1($name . date('Y-m-d') . 'MyToken');
    }
?>