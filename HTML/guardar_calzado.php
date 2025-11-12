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

    if (!$data) {
        throw new Exception('No se recibieron datos.');
    }

    $sql = "INSERT INTO calzado (marca, talla, color, stock, precio, categoria)
            VALUES (:marca, :talla, :color, :stock, :precio, :categoria)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':marca' => $data['marca'],
        ':talla' => $data['talla'],
        ':color' => $data['color'],
        ':stock' => $data['stock'],
        ':precio' => $data['precio'],
        ':categoria' => $data['categoria']
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Calzado guardado exitosamente',
        'id' => $pdo->lastInsertId()
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
