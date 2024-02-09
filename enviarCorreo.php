<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Recibe los datos del cuerpo de la solicitud POST
$datos = json_decode(file_get_contents("php://input"), true);

if (isset($datos['cuerpo']) && isset($datos['nombre']) && isset($datos['apellidoPaterno']) && isset($datos['apellidoMaterno']) && isset($datos['correo']) && isset($datos['telefono']) && isset($datos['usuario'])) {
    // Extrae el cuerpo del correo y los datos del usuario del objeto JSON
    $cuerpoCorreo = $datos['cuerpo'];
    $nombreUsuario = $datos['nombre'];
    $apellidoPaterno = $datos['apellidoPaterno'];
    $apellidoMaterno = $datos['apellidoMaterno'];
    $correo = $datos['correo'];
    $telefono = $datos['telefono'];
    $usuario = $datos['usuario'];

    // Configura la instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '20210681@uthh.edu.mx';
        $mail->Password = 'Eduardo20210681';
        $mail->SMTPSecure = 'tls'; // Cambiado a TLS
        $mail->Port = 587;

        // Destinatario
        $mail->setFrom('20210681@uthh.edu.mx', 'Tu Nombre');
        $mail->addAddress('20210681@uthh.edu.mx', 'Administrador');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo usuario registrado';
        $mail->Body = "
            <p>Se ha registrado un nuevo usuario:</p>
            <ul>
                <li><strong>Nombre:</strong> $nombreUsuario</li>
                <li><strong>Apellido Paterno:</strong> $apellidoPaterno</li>
                <li><strong>Apellido Materno:</strong> $apellidoMaterno</li>
                <li><strong>Correo:</strong> $correo</li>
                <li><strong>Teléfono:</strong> $telefono</li>
                <li><strong>Usuario:</strong> $usuario</li>
            </ul>
            <p>Cuerpo del correo:</p>
            <p>$cuerpoCorreo</p>";

        // Envía el correo
        if ($mail->send()) {
            echo 'Correo enviado correctamente';
        } else {
            echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Error al configurar PHPMailer: ' . $e->getMessage();
    }
} else {
    echo 'Faltan datos en la solicitud POST.';
}
?>
