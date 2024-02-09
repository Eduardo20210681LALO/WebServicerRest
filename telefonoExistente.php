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
$telefono = $data['telefono'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$consultaUsuario = "SELECT * FROM tbl_usuarios WHERE vch_telefono = '$telefono'";
$resultadoUsuario = $conn->query($consultaUsuario);

if ($resultadoUsuario) {
    if ($resultadoUsuario->num_rows > 0) {
        $response = array(
            'success' => true
        );
    } else {
        $response = array(
            'error' => false,
            'message' => 'El telefono ya esta en usoo.'
        );
    }
} else {
    $response = array(
        'error' => false,
        'message' => 'Error al ejecutar la consulta: ' . $conn->error
    );
}

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
