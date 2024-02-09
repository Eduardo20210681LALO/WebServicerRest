<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$servername = 'http://srv871.hstgr.io';
$username = 'u524156408_backendteam';
$password = 'LaBarbada1979';
$dbname = 'u524156408_labarbadadev';

$data = json_decode(file_get_contents('php://input'), true);
$contrasenia = $data['contrasenia'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(array('error' => true, 'message' => 'Error de conexión a la base de datos')));
}

$consultaUsuario = "UPDATE tbl_usuarios SET vch_contraseña = '$contrasenia'";
$resultadoUsuario = $conn->query($consultaUsuario);

if ($resultadoUsuario) {
    $response = array('success' => true);
} else {
    $response = array('error' => true, 'message' => 'Error al actualizar la contraseña: ' . $conn->error);
}

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
