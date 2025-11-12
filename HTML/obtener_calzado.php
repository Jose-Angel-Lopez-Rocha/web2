<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$port = '4306';
$dbname = 'zapateria';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener ID de la URL
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$id) {
        throw new Exception('ID de calzado requerido');
    }

    $sql = "SELECT id, marca, talla, color, stock, precio, categoria 
            FROM calzado 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $calzado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($calzado) {
        echo json_encode([
            'success' => true,
            'data' => $calzado
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Calzado no encontrado'
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