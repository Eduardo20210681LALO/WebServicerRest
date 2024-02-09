<?php
    $servername = 'viaduct.proxy.rlwy.net';
    $username = 'root';
    $password = 'hCC3EfDfAg4aHACgad1C4bCc1hdcD1C3';
    $dbname = 'railway';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo 'No se pudo conectar con el servidor';
        exit;
    }
?>
<!--
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'telesecundaria';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo 'No se pudo conectar con el servidor';
        exit;
    }
-->