<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT');
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

    if (!$data) {
        throw new Exception('No se recibieron datos');
    }

    // Validar que venga el ID
    if (!isset($data['id']) || empty($data['id'])) {
        throw new Exception('ID de cliente requerido');
    }

    $sql = "UPDATE clientes SET 
            nombre = :nombre,
            apellido_paterno = :apellido_paterno,
            apellido_materno = :apellido_materno,
            email = :email,
            telefono = :telefono,
            fecha_nac = :fecha_nac,
            estado = :estado,
            ciudad = :ciudad
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $params = [
        ':id' => $data['id'],
        ':nombre' => $data['nombre'],
        ':apellido_paterno' => $data['apellido_paterno'],
        ':apellido_materno' => $data['apellido_materno'],
        ':email' => $data['email'],
        ':telefono' => $data['telefono'],
        ':fecha_nac' => $data['fecha_nac'],
        ':estado' => $data['estado'],
        ':ciudad' => $data['ciudad']
    ];

    // Si viene contraseña nueva, actualizarla
    if (isset($data['clave']) && !empty($data['clave'])) {
        $sql = "UPDATE clientes SET 
                nombre = :nombre,
                apellido_paterno = :apellido_paterno,
                apellido_materno = :apellido_materno,
                email = :email,
                clave = :clave,
                telefono = :telefono,
                fecha_nac = :fecha_nac,
                estado = :estado,
                ciudad = :ciudad
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $params[':clave'] = password_hash($data['clave'], PASSWORD_DEFAULT);
    }

    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'cliente actualizado exitosamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se realizaron cambios o el cliente no existe'
        ]);
    }

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