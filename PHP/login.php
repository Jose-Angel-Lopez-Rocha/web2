<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$port = '4306';
$dbname = 'zapateria';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['email']) || !isset($data['clave'])) {
        throw new Exception('Email y contraseña requeridos');
    }

    // Buscar usuario con su rol
    $sql = "SELECT u.id, u.nombre, u.apellido_paterno, u.email, u.clave, u.rol_id, r.nombre as rol_nombre
            FROM usuarios u
            INNER JOIN roles r ON u.rol_id = r.id
            WHERE u.email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $data['email']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }

    // Verificar contraseña
    if (!password_verify($data['clave'], $usuario['clave'])) {
        throw new Exception('Contraseña incorrecta');
    }

    // Crear sesión
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'] . ' ' . $usuario['apellido_paterno'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['usuario_rol'] = $usuario['rol_nombre'];
    $_SESSION['rol_id'] = $usuario['rol_id'];

    echo json_encode([
        'success' => true,
        'message' => 'Login exitoso',
        'usuario' => [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'] . ' ' . $usuario['apellido_paterno'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol_nombre']
        ]
    ]);

} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>