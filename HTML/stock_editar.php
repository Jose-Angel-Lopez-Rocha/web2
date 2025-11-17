<?php
    include("..\PHP\conexion.php");
    session_start();
    if (!isset($_SESSION['cliente_rol']) || $_SESSION['cliente_rol'] != 1) {
            if (!isset($_SESSION['cliente_rol']) || $_SESSION['cliente_rol'] != 3) {
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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacion de clientes</title>
    <link href="../CSS/formularios.css" rel="stylesheet">
</head>
<body>
    <h1 class="titulo">Edicion del stock</h1>
    <ul class="sidenav">
        <li><a class="activate" href="index.php">Index</a></li>
        <li><a href="acerca.html">Acerca de nosotros</a></li>
        <li><a href="clientes.php">Clientes</a></li>
        <li><a href="stock.php">Stock</a></li>
    </ul>

    <table>
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Talla</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Editar</th>
        </tr>

        <?php
        $sql = "SELECT * FROM calzado";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($mostrar = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $mostrar['id']; ?></td> 
            <td><?php echo $mostrar['marca']; ?></td>
            <td><?php echo $mostrar['talla']; ?></td>
            <td><?php echo $mostrar['color']; ?></td>
            <td><?php echo $mostrar['precio']; ?></td>
            <td><?php echo $mostrar['stock']; ?></td>
            <td><?php echo $mostrar['categoria']; ?></td>
            <td><a href="stock_editar_2.php?id=<?= $mostrar['id'] ?>" class="boton2">Editar</a></td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='8>No hay productos registrados</td></tr>";
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
            alt="Valid CSS!" />
        </a>
    </p>

    <p>
        <a href="https://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px"
            src="https://jigsaw.w3.org/css-validator/images/vcss-blue"
            alt="Valid CSS!" />
        </a>
    </p>
</footer>
</body>
</html>