<?php
// Iniciar la sesión
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o login
header("Location: ../index.php");
exit();
?>