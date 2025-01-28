<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSL-Iniciar Sesión</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body>
    <?php
    session_start();
    include("conexion.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    ?>
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../img/rls.png" alt="Logo RSL"></a>

            </div>
            <label class="labe_hamburguesa" for="menu_hamburguesa">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="list_icon"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </label>
            <input class="menu_hamburguesa" type="checkbox" id="menu_hamburguesa">
            <ul class="ul_links">
                <li class="link"><a href="../index.php" class="link">Inicio</a></li>
                <li class="link"><a href="servicios.php" class="link">Servicios</a></li>
                <li class="link"><a href="equipo.php" class="link">Equipo</a></li>

                <?php

                // Comprobar si el usuario está logueado
                if (isset($_SESSION['usuario'])) {
                    // Si hay un usuario logueado, muestra el nombre de usuario con el enlace a logueado.php
                    if ($_SESSION['tipo'] === 'admin') {
                        echo "<li class='link'>";
                        echo "<a href='admin.php' class='link'> Admin </a>";
                        echo "</li>";
                    } else {
                        echo "<li class='link'>";
                        echo "<a href='logueado.php' class='link'> My Site </a>";
                        echo "</li>";
                    }
                } else {
                    ?>
                    <li class="link"><a href="login.php" class="link">Login</a></li> <?php
                }
                ?>
            </ul>
        </nav>
    </header>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $pswd = trim($_POST['contraseÃ±a']);

        // Validar que los campos no estén vacíos
        if (empty($email) || empty($pswd)) {
            echo "<script>alert('Por favor, ingrese su correo y contraseña.');</script>";
        } else {
            // Verificar el usuario
            $sql = "SELECT id_cliente, nombre, contraseÃ±a, tipo FROM cliente WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();

                // Validar la contraseña encriptada
                if (password_verify($pswd, $usuario['contraseÃ±a'])) {
                    // Guardar datos en la sesión
                    $_SESSION['usuario'] = $usuario['id_cliente'];
                    $_SESSION['tipo'] = $usuario['tipo'];
                    $_SESSION['nombre'] = $usuario['nombre'];

                    header("Location: logueado.php");
                    exit();
                } else {
                    echo "<script>alert('Contraseña incorrecta.');</script>";
                }
            } else {
                echo "<script>alert('Usuario no encontrado.');</script>";
            }
        }
    }
    ?>
    <div id="contenedor">
        <div id="central">
            <div id="login">
                <form action="" method="post">
                    <label for="email">e-Mail:</label>
                    <input type="email" name="email" id="email" class="caja" required placeholder="email">
                    <label for="contraseÃ±a">Contraseña:</label>
                    <input type="password" name="contraseÃ±a" id="contraseÃ±a" class="caja" required
                        placeholder="Contraseña">
                    <button type="submit" name="login">Iniciar Sesión</button>
                </form>
                <div class="pie-form">
                    <button class="volver1" type="button"><a class="volver" href="crear-cliente.php">Registrar
                            Usuario</a></button>
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