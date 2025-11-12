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
        throw new Exception('ID de calzado requerido');
    }

    $sql = "UPDATE calzado SET 
            marca = :marca,
            talla = :talla,
            color = :color,
            stock = :stock,
            precio = :precio,
            categoria = :categoria
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $data['id'],
        ':marca' => $data['marca'],
        ':talla' => $data['talla'],
        ':color' => $data['color'],
        ':stock' => $data['stock'],
        ':precio' => $data['precio'],
        ':categoria' => $data['categoria']
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Calzado actualizado exitosamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se realizaron cambios o el calzado no existe'
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