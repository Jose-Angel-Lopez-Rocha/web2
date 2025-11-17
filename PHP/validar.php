<?php
session_start();
include('conexion.php');

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$clave = isset($_POST['clave']) ? trim($_POST['clave']) : '';

if (empty($email) || empty($clave)) {
    $error = "Por favor, complete todos los campos.";
    include("login.php");
    exit;
}


if (!filter_var($email)) {
    $error = "El formato del correo no es válido.";
    include("login.php");
    exit;
}

$stmt = $conexion->prepare("SELECT id, nombre, rol FROM clientes WHERE email = ? AND clave = ?");
$stmt->bind_param("ss", $email, $clave);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows>0) {
    $cliente=$res->fetch_assoc();

    $_SESSION['cliente_id'] = $cliente['id'];
    $_SESSION['cliente_nombre'] = $cliente['nombre'];
    $_SESSION['cliente_rol'] = $cliente['rol'];

    header("Location: ../HTML/index.php");
    exit;
} else {
    $error = "Correo o contraseña incorrectos.";
    include("login.php");
}


if (isset($_SESSION['cliente_nombre']) && isset($_SESSION['cliente_rol'])) {
    $nombre = $_SESSION['cliente_nombre'];
    $rol = $_SESSION['cliente_rol'];
} else {
    $nombre = 'Invitado';
    $rol = 'N/A';
}

if ($res) $res->free();
$conexion->close();
?>
