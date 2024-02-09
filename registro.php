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

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodificar los datos JSON recibidos
    $data = json_decode(file_get_contents("php://input"));

    // Limpiar y escapar los datos para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($conn, $data->nombre);
    $apellidoPaterno = mysqli_real_escape_string($conn, $data->apellidoPaterno);
    $apellidoMaterno = mysqli_real_escape_string($conn, $data->apellidoMaterno);
    $usuario = mysqli_real_escape_string($conn, $data->usuario);
    $correo = mysqli_real_escape_string($conn, $data->correo);
    $telefono = mysqli_real_escape_string($conn, $data->telefono);
    $contrasenia = mysqli_real_escape_string($conn, $data->contrasenia);

    // Verificar si algún campo está vacío
    if (empty($nombre) || empty($apellidoPaterno) || empty($apellidoMaterno) || empty($usuario) || empty($correo) || empty($telefono) || empty($contrasenia)) {
        // Si hay campos vacíos, se envía un mensaje de error
        $response = [
            'success' => false,
            'message' => 'Todos los campos deben ser completados'
        ];
    } else {
        // Si todos los campos están completos, se ejecuta la consulta SQL para insertar el registro
        $insertQuery = "INSERT INTO tbl_usuarios (vch_nombre, vch_apellido_Paterno, vch_apellido_Materno, vch_usuario, vch_correo, vch_telefono, vch_contraseña) VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$usuario', '$correo', '$telefono', '$contrasenia')";
        $result = $conn->query($insertQuery);

        if ($result === TRUE) {
         
            $response = [
                'success' => true,
                'message' => 'Registro exitoso'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No se pudo completar el registro: '
            ];
        }
    }
} else {
    // Si la solicitud no es de tipo POST, se envía un mensaje de error
    $response = [
        'success' => false,
        'message' => 'Método de solicitud no válido'
    ];
}

// Se envía la respuesta en formato JSON
echo json_encode($response);

// Se cierra la conexión
$conn->close();
?>
