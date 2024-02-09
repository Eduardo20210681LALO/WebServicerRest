<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "telesecundaria";

$data = json_decode(file_get_contents('php://input'), true);
$contrasenia = $data['contrasenia'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(array('error' => true, 'message' => 'Error de conexión a la base de datos')));
}

$consultaUsuario = "UPDATE registro SET contrasenia = '$contrasenia'";
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
