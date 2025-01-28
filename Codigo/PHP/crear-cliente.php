<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include("conexion.php");

if ($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ingresar'])) {
        $nombre = trim($_POST['Nombre']);
        $apellido = trim($_POST['apellido']);
        $apellido2 = trim($_POST['apellido2']);
        $empresa = trim($_POST['empresa']);
        $direccion = trim($_POST['direccion']);
        $telefono = trim($_POST['telefono']);
        $email = trim($_POST['email']);
        $pswd = trim($_POST['contraseÃ±a']);

        // Validar que los datos no estén vacíos
        if (empty($nombre) || empty($apellido) || empty($email) || empty($pswd)) {
            echo "<script>alert('Todos los campos son obligatorios.');</script>";
        } else {
            // Comprobar si el usuario ya existe
            $sql_check = "SELECT * FROM cliente WHERE correo = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param('s', $email);
            $stmt_check->execute();
            $resultado = $stmt_check->get_result();

            if ($resultado->num_rows === 0) {
                // Encriptar la contraseña
                $hashed_password = password_hash($pswd, PASSWORD_BCRYPT);

                // Insertar nuevo usuario
                $sql_insert = "INSERT INTO cliente (nombre, apellido_1, apellido_2, nombre_empresa, direccion, telefono, correo, contraseÃ±a) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param('ssssssss', $nombre, $apellido, $apellido2, $empresa, $direccion, $telefono, $email, $hashed_password);

                if ($stmt_insert->execute()) {
                    header("Location: ../index.php");
                    exit();
                } else {
                    echo "<script>alert('Error al registrar el usuario. Intente nuevamente.');</script>";
                }
            } else {
                echo "<script>alert('Este usuario ya existe. Pruebe con otro correo.');</script>";
            }
        }
    }
} else {
    echo "<script>alert('Error de conexión a la base de datos.');</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Registro de Usuario</title>
      <link rel="stylesheet" href="../style/style.css">
      <link rel="icon" href="../img/favicon.png" type="image/x-icon">
   </head>
   <body>
   <header class="header">
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../img/rls.png" alt="Logo RSL"></a>
            </div>
            <label class="labe_hamburguesa" for="menu_hamburguesa">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="list_icon" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </label>
            <input class="menu_hamburguesa" type="checkbox" name="" id="menu_hamburguesa">
            <ul class="ul_links">
                    <li class="link"><a href="../index.php" class="link">Inicio</a></li>
                    <li class="link"><a href="servicios.php" class="link">Servicios</a></li>
                    
                    <li class="link"><a href="equipo.php" class="link">Equipo</a></li>
                
                <?php
                  // Comprobar si el usuario está logueado
                  if (isset($_SESSION['usuario'])) {
                      // Si hay un usuario logueado, muestra el nombre de usuario con el enlace a logueado.php
                      echo "<li class='link'>";
                      echo "<a href='logueado.php' class='link'> My Site </a>";
                      echo "</li>";
                  } else {
                      // Si no hay usuario logueado, muestra el enlace de login
                      echo "<li class='link'>";
                      echo "<a href='login.php' class='link'>Login</a>";
                      echo "</li>";
                  }
               ?>
               </ul>
        </nav>
    </header>
      <div id="contenedor">
         <div id="central">
            <div id="login">
               <form id="AltaUsuario" action="" method="post">
                  <label for="nombre">Nombre:</label>
                  <input type="text" id="nombre" name="Nombre" class="caja" required pattern="[a-zA-Z\s]+" placeholder="Nombre">
                  <label for="apellido">Apellido:</label>
                  <input type="text" id="apellido" name="apellido" class="caja" required pattern="[a-zA-Z\s]+" placeholder="Apellido">
                  <label for="apellido2">Segundo apellido:</label>
                  <input type="text" id="apellido2" name="apellido2" class="caja" required pattern="[a-zA-Z\s]+" placeholder="Segundo apellido">
                  <label for="direccion">Dirección:</label>
                  <input type="text" name="direccion" id="direccion" class="caja" required placeholder="Dirección">
                  <label for="empresa">Empresa:</label>
                  <input type="text" name="empresa" id="empresa" class="caja" placeholder="Empresa">
                  <label for="telefono">Teléfono: </label>
                  <input type="tel" name="telefono" id="telefono" class="caja" required pattern="[0-9]+" placeholder="Teléfono">
                  <label for="email">e-Mail:</label>
                  <input type="email" name="email" id="email" class="caja" required placeholder="email">
                  <label for="contraseÃ±a">Contraseña:</label>
                  <input type="password" name="contraseÃ±a" id="contraseÃ±a" class="caja" required pattern="^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]+$" placeholder="Contraseña">
                  <button type="submit" title="AltaUsuario" name="Ingresar">Alta Usuario</button>
               </form>
               <div class="pie-form">
                  <button class="volver1" type="button"><a class="volver" href="login.php">Volver</a></button>
               </div>
            </div>
         </div>
      </div>
      <footer>
        <div class="pie">
            <div class="copi">
                <h5>©2024-2025</h5>
            </div>
            <div class="logos">
                <img class="instagram" src="../img/icons8-insta-50.png" alt="logo instagram">
                <img class="linkedin" src="../img/icons8-linkedin-48 (2).png" alt="logo linkedin">
                <img class="youtube" src="../img/icons8-youtube-50.png" alt="logo youtube">
            </div>
        </div>
    </footer>
   </body>
</html>
