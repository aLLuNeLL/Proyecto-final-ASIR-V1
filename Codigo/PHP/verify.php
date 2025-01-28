<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== 1) {
    die("Acceso denegado. Necesitas ser un administrador.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userCode = $_POST['verification_code'];

    // Verificar el código ingresado por el usuario
    if ($userCode == $_SESSION['verification_code']) {
        echo "Autenticación exitosa. Ahora puedes modificar los datos.";
        // Redirigir a la página donde el administrador puede modificar la base de datos
        header('Location: modificar.php');
        exit();
    } else {
        echo "Código incorrecto. Intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación</title>
</head>

<body>

    <h2>Verificación de dos factores</h2>

    <form action="" method="POST">
        <label for="verification_code">Código de verificación:</label>
        <input type="text" name="verification_code" id="verification_code" required><br>

        <button type="submit">Verificar</button>
    </form>

</body>

</html>