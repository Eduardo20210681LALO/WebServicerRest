<?php
    $servername = 'http://srv871.hstgr.io';
    $username = 'u524156408_backendteam';
    $password = 'LaBarbada1979';
    $dbname = 'u524156408_labarbadadev';

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
