<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Max-Age: 86400");
require 'vendor/autoload.php'; 

ob_start();

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$correoElectronico = $data["correo"];
$debugInfo = ob_get_clean();

if (!empty($correoElectronico)) {
    $stmt = $pdo->prepare("SELECT vchMatricula, vchNombre  FROM estudiantes WHERE vchCorreoElectronico = ?");
    $stmt->execute([$correoElectronico]);

    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {

        $matricula = $fila['vchMatricula'];
        $nombre = $fila['vchNombre'];

        $token = uniqid();
        $stmtToken = $pdo->prepare("UPDATE estudiantes SET recovery_token = :token WHERE vchCorreoElectronico = :correo");
        $stmtToken->bindParam(':token', $token);
        $stmtToken->bindParam(':correo', $correoElectronico);
        $stmtToken->execute();
        $url = "http://localhost:3000/restablecer-contrasena/$matricula/$token";

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '20210643@uthh.edu.mx'; 
            $mail->Password = 'tydh jjmq kzun azde'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('20210643@uthh.edu.mx', 'UTHH VIRTUAL'); 
            $mail->addAddress($correoElectronico);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body = "Hola $nombre,\n\nHas solicitado la recuperación de tu contraseña. Haz clic en el siguiente enlace para restablecer tu contraseña:\n\n$url";

            $mail->send();
            echo json_encode(array(
                'done' => true,
                'message' => 'Solicitud de recuperación de contraseña enviada con éxito.',
                'debug_info' => $debugInfo,
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'done' => false,
                'message' => "Error al enviar el correo: {$mail->ErrorInfo}",
                'debug_info' => $debugInfo,
            ));
        }
    } else {
        echo json_encode(array(
            'done' => false,
            'message' => 'No se encontró el correo en la base de datos.',
            'debug_info' => $debugInfo,
        ));
    }
} else {
    echo json_encode(array(
        'done' => false,
        'message' => 'Falta el correo electrónico.',
        'debug_info' => $debugInfo,
    ));
}

function desencriptarContraseña($contrasenaEncriptada) {

    $contrasenaDesencriptada = hash("sha256", $contrasenaEncriptada);
    return $contrasenaDesencriptada;
}
?>
