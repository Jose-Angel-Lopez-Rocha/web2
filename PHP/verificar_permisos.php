<?php
// Archivo que se incluye en otros PHP para verificar permisos

function verificarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['usuario_id'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'No autorizado. Debes iniciar sesión'
        ]);
        exit();
    }
}

function verificarRolAdmin() {
    verificarSesion();
    
    if ($_SESSION['usuario_rol'] !== 'admin') {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Acceso denegado. Solo administradores pueden realizar esta acción'
        ]);
        exit();
    }
}

function obtenerUsuarioActual() {
    verificarSesion();
    
    return [
        'id' => $_SESSION['usuario_id'],
        'nombre' => $_SESSION['usuario_nombre'],
        'email' => $_SESSION['usuario_email'],
        'rol' => $_SESSION['usuario_rol'],
        'rol_id' => $_SESSION['rol_id']
    ];
}

function esAdmin() {
    return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
}
?>