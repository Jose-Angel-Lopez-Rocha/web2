<?php
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
    
    if (!$data || !isset($data['id'])) {
        throw new Exception('Datos inválidos');
    }
    

    $campos = [
        'nombre = :nombre',
        'apellido_paterno = :apellido_paterno',
        'apellido_materno = :apellido_materno',
        'email = :email',
        'telefono = :telefono',
        'fecha_nac = :fecha_nac',
        'estado = :estado',
        'ciudad = :ciudad',
    ];
    
    $params = [
        ':id' => $data['id'],
        ':nombre' => $data['nombre'],
        ':apellido_paterno' => $data['apellido_paterno'],
        ':apellido_materno' => $data['apellido_materno'],
        ':email' => $data['email'],
        ':telefono' => $data['telefono'],
        ':fecha_nac' => $data['fecha_nac'],
        ':estado' => $data['estado'],
        ':ciudad' => $data['ciudad'],
    ];
    
    if (!empty($data['clave'])) {
        $campos[] = 'clave = :clave';
        $params[':clave'] = password_hash($data['clave'], PASSWORD_DEFAULT);
    }
    
    $sql = "UPDATE clientes SET " . implode(', ', $campos) . " WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    echo json_encode([
        'success' => true,
        'message' => 'Cliente actualizado exitosamente'
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