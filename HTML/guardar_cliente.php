<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Configuración de la base de datos
$host = 'localhost';
$port = '4306';                 
$dbname = 'zapateria';         
$username = 'root';
$password = '';

try {
    // Crear conexión PDO con puerto específico
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Obtener datos del POST
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validar que llegaron los datos
    if (!$data) {
        throw new Exception('No se recibieron datos');
    }
    

     if (!isset($data['rol']) || !in_array($data['rol'], ['2', '3'], true)) {
        throw new Exception('Rol inválido. Solo se permite Cliente (2) o Vendedor (3)');
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO clientes (nombre, apellido_paterno, apellido_materno, email, clave, telefono, fecha_nac, estado, ciudad, rol) 
            VALUES (:nombre, :apellido_paterno, :apellido_materno, :email, :clave, :telefono, :fecha_nac, :estado, :ciudad, :rol)";
    
    $stmt = $pdo->prepare($sql);
    
    // Hash de la contraseña (IMPORTANTE para seguridad)
    $claveHash = password_hash($data['clave'], PASSWORD_DEFAULT);
    
    // Ejecutar la consulta
    $stmt->execute([
        ':nombre' => $data['nombre'],
        ':apellido_paterno' => $data['apellido_paterno'],
        ':apellido_materno' => $data['apellido_materno'],
        ':email' => $data['email'],
        ':clave' => $claveHash,
        ':telefono' => $data['telefono'],
        ':fecha_nac' => $data['fecha_nac'],
        ':estado' => $data['estado'],
        ':ciudad' => $data['ciudad'],
        ':rol' => $data['rol']
    ]);
    
    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => 'Registro guardado exitosamente',
        'id' => $pdo->lastInsertId()
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