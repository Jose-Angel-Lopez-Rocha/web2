<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../CSS/login.css" rel="stylesheet">
</head>
<body>
    <form action="validar.php" method="post">
        <h1>Sistema de login registro</h1>

        <?php if (isset($error)) { ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php } ?>

        <p>
            <input type="email" name="email" placeholder="Ingrese su correo" required>
        </p>
        <p>
            <input type="password" name="clave" placeholder="Ingrese su clave" required>
        </p>
        <input type="submit" value="Ingresar">

    <p>
    <a href="..\HTML\crear_login.php" class="btn-registro">Crear una cuenta</a>
    </p>

    </form>
</body>
</html>
