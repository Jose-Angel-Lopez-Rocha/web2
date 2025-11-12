<?php
include('conexion.php');

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$clave = isset($_POST['clave']) ? trim($_POST['clave']) : '';

if (empty($email) || empty($clave)) {
    $error = "Por favor, complete todos los campos.";
    include("login.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_email)) {
    $error = "El formato del correo no es válido.";
    include("login.php");
    exit;
}

$consulta = "SELECT * FROM clientes WHERE email = '$email' AND clave = '$clave'";
$res = mysqli_query($conexion, $consulta);

if ($res && mysqli_num_rows($res) > 0) {
    header("Location: ../HTML/index.html");
    exit;
} else {
    $error = "Correo o contraseña incorrectos.";
    include("login.php");
}

if ($res) mysqli_free_result($res);
mysqli_close($conexion);
?>
