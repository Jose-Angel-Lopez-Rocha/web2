<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "zapateria";
$puerto = 4306;

// Conexión
$conexion = new mysqli($server, $user, $pass, $db, $puerto);
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}
session_start();
if (!isset($_SESSION['cliente_rol']) || $_SESSION['cliente_rol'] != 1) {
    echo "<div style='
        padding: 20px;
        margin: 20px auto;
        max-width: 400px;
        background: #ffe6e6;
        color: #b30000;
        border: 2px solid #ff4d4d;
        border-radius: 10px;
        font-family: Arial;
        text-align: center;
        font-size: 18px;
    '>❌ No tienes permiso para acceder a esta página.</div>";
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edicion de clientes</title>
    <link href="../CSS/formularios.css" rel="stylesheet">
</head>
<body>
    <h1 class="titulo">Creacion de Clientes</h1>
    <ul class="sidenav">
        <li><a class="activate" href="index.html">Index</a></li>
        <li><a href="acerca.html">Acerca de nosotros</a></li>
        <li><a href="clientes.php">Clientes</a></li>
        <li><a href="stock.php">Stock</a></li>
    </ul>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido paterno</th>
            <th>Apellido materno</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Fecha de nacimiento</th>
            <th>Accion</th>
        </tr>
        <?php
        $sql = "SELECT * FROM clientes";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($mostrar = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $mostrar['id']; ?></td> 
            <td><?php echo $mostrar['nombre']; ?></td>
            <td><?php echo $mostrar['apellido_paterno']; ?></td>
            <td><?php echo $mostrar['apellido_materno']; ?></td>
            <td><?php echo $mostrar['email']; ?></td>
            <td><?php echo $mostrar['telefono']; ?></td>
            <td><?php echo $mostrar['ciudad']; ?></td>
            <td><?php echo $mostrar['estado']; ?></td>
            <td><?php echo $mostrar['fecha_nac']; ?></td>
            <td><a href="cliente_editar_2.php?id=<?= $mostrar['id'] ?>" class="boton2">Editar</a></td>
        </tr>
        <?php
            }
        }else{
            echo "<tr><td colspan='7'>No hay clientes registrados</td><tr>";
        }
        ?>    
    </table>
    <footer class="footer">
        <h4>Información</h4>
        <ul>
            <li><a href="mailto:lopezrochaangel30@gmail.com">Enviar correo</a></li>
        </ul>

        <p>
            <a href="https://jigsaw.w3.org/css-validator/check/referer">
                <img style="border:0;width:88px;height:31px"
                    src="https://jigsaw.w3.org/css-validator/images/vcss"
                    alt="Valid CSS!">
            </a>
        </p>

        <p>
            <a href="https://jigsaw.w3.org/css-validator/check/referer">
                <img style="border:0;width:88px;height:31px"
                    src="https://jigsaw.w3.org/css-validator/images/vcss-blue"
                    alt="Valid CSS!">
            </a>
        </p>
    </footer>
</body>
</html>