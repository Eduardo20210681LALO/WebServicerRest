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

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $email = mysqli_real_escape_string($conn, $data->email);
    $password = mysqli_real_escape_string($conn, $data->password);
    $usuario = mysqli_real_escape_string($conn, $data->usuario);

    $sql = "SELECT * FROM tbl_usuarios WHERE vch_correo='$email' AND vch_contraseña ='$password' AND id_rol='$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $id_rol = $user['id_rol'];
        $response = array("success" => true, "user" => $user, "id_rol" => $id_rol, "message" => "Autenticación exitosa");
    } else {
        $response = array("success" => false, "message" => "Correo o Contraseña invalidos");
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
$conn->close();
?>
