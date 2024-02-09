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
$correo = $data['correo'];
$telefono = $data['telefono'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$consultaUsuario = "SELECT * FROM tbl_usuarios WHERE vch_correo = '$correo' AND vch_telefono = '$telefono'";
$resultadoUsuario = $conn->query($consultaUsuario);

if ($resultadoUsuario) {
    if ($resultadoUsuario->num_rows > 0) {
        $usuarioExistente = $resultadoUsuario->fetch_assoc();

        $response = array(
            'success' => true
        );
    } else {
        $response = array(
            'error' => false,
            'message' => 'No se encontró ningún usuario.'
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
