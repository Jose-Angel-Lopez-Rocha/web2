
<?php
include("..\PHP\conexion.php");


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
    <title>Clientes</title>
    <link href="../CSS/style.css" rel="stylesheet">
</head>
<body>
    <h1 class="titulo">Clientes</h1>
    <ul class="sidenav">
        <li><a class="activate" href="index.php">Index</a></li>
        <li><a href="acerca.html">Acerca de nosotros</a></li>
        <li><a href="clientes.php">Clientes</a></li>
        <li><a href="stock.php">Stock</a></li>
    </ul>
    <h2 class="titulo">Clientes edicion:</h2>
    <div class="contenedor-botones">
        <button id="crearCliente">Crear cliente</button>
        <button id="editarCliente">Editar cliente</button>
        <button id="eliminarCliente">Eliminar cliente</button>
    </div>
<script>
document.getElementById('crearCliente').addEventListener('click', function() {
    window.location.href = 'cliente_crear.php';
});
document.getElementById('editarCliente').addEventListener('click', function(){
    window.location.href='cliente_editar.php';
});
document.getElementById('eliminarCliente').addEventListener('click', function(){
    window.location.href='cliente_eliminar.php';
});
</script>
<footer class="footer">
        <h4>Información</h4>
        <ul>
            <li><a href="mailto:lopezrochaangel30@gmail.com">Enviar correo</a></li>    
        </ul>
        <p>
            <a href="https://validator.w3.org/">
            <img src="../imagenes/valid-html40.png" alt="Valid html" style="border:0;width:88px;height:31px">
            </a>
        </p>            
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