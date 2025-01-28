<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSL-Admin</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body>
    <!-- --------------------- Menu Hamburguesa --------------------- -->
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
            <input class="menu_hamburguesa" type="checkbox" name="" id="menu_hamburguesa">
            <ul class="ul_links">
                <li class="link"><a href="../index.php" class="link">Inicio</a></li>
                <li class="link"><a href="servicios.php" class="link">Servicios</a></li>

                <li class="link"><a href="equipo.php" class="link">Equipo</a></li>

                <?php
                session_start();


                // Comprobar si el usuario está logueado
                if (isset($_SESSION['usuario'])) {
                    // Si el usuario está logueado, comprobar su tipo
                    if ($_SESSION['tipo'] === 'admin') {
                        // Mostrar enlace para administradores
                        echo "<li class='link'>";
                        echo "<a href='admin.php' class='link'> Admin </a>";
                        echo "</li>";
                    } else {
                        // Mostrar enlace para clientes
                        echo "<li class='link'>";
                        echo "<a href='logueado.php' class='link'> My Site </a>";
                        echo "</li>";
                    }
                } else {
                    // Si no hay usuario logueado, mostrar enlace para login
                    echo "<li class='link'>";
                    echo "<a href='login.php' class='link'> Login </a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <?php
    include("conexion.php");



    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Función para obtener las tablas de la base de datos
    function getTables($conn)
    {
        $result = mysqli_query($conn, "SHOW FULL TABLES WHERE Table_Type != 'VIEW'");
        $tables = [];
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
        return $tables;
    }

    // Función para renderizar las tablas
    function renderTable($conn, $table)
    {
        echo "<h2>Tabla: $table</h2>";
        echo "<a href='?table=$table&action=add'>Añadir nuevo registro</a><br><br>";

        $result = mysqli_query($conn, "SELECT * FROM $table");
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (count($rows) > 0) {
            echo "<div class='table-container'>";
            echo "<table class='styled-table'>";
            echo "<tr>";
            foreach (array_keys($rows[0]) as $col) {
                echo "<th>$col</th>";
            }
            echo "<th>Acciones</th>";
            echo "</tr>";

            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $col) {
                    echo "<td>$col</td>";
                }
                echo "<td>";
                echo "<a href='?table=$table&action=edit&id=" . $row[array_keys($row)[0]] . "'>Editar</a> ";
                echo "<a href='?table=$table&action=delete&id=" . $row[array_keys($row)[0]] . "'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
            echo "<button><a href='admin.php' class='btn-volver'>Volver a Admin</a></button>";
        } else {
            echo "<p>No hay registros en esta tabla.</p>";
            echo "<button><a href='admin.php' class='btn-volver'>Volver a Admin</a></button>";
        }
    }

    // Función para renderizar el formulario de agregar o editar registros
    function renderForm($conn, $table, $id = null)
    {
        $result = mysqli_query($conn, "DESCRIBE $table");
        $columns = [];
        while ($row = mysqli_fetch_row($result)) {
            $columns[] = $row[0];
        }

        $values = [];
        if ($id) {
            $stmt = mysqli_prepare($conn, "SELECT * FROM $table WHERE " . $columns[0] . " = ?");
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $values = mysqli_fetch_assoc($result);
        }

        echo "<form method='post'>";
        foreach ($columns as $col) {
            $value = isset($values[$col]) ? $values[$col] : '';
            echo "<label>$col: <input name='$col' value='$value'></label><br>";
        }
        echo "<button type='submit'>Guardar</button>";
        echo "</form>";
    }

    // Manejo de las acciones de agregar, editar y eliminar
    if (isset($_GET['table'])) {
        $table = $_GET['table'];

        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            if ($action == 'add' || $action == 'edit') {
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                renderForm($conn, $table, $id);

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $columns = array_keys($_POST);
                    $values = array_values($_POST);

                    if ($id) {
                        $set = [];
                        foreach ($columns as $col) {
                            $set[] = "$col = ?";
                        }
                        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE " . $columns[0] . " = ?";
                        $values[] = $id;
                    } else {
                        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
                        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES ($placeholders)";
                    }

                    $stmt = mysqli_prepare($conn, $sql);
                    $types = str_repeat('s', count($values)); // Asumiendo que los valores son strings
                    mysqli_stmt_bind_param($stmt, $types, ...$values);
                    mysqli_stmt_execute($stmt);
                    header("Location: ?table=$table");
                }
            } elseif ($action == 'delete' && isset($_GET['id'])) {
                $id = $_GET['id'];
                $primary = mysqli_fetch_row(mysqli_query($conn, "DESCRIBE $table"))[0];
                $stmt = mysqli_prepare($conn, "DELETE FROM $table WHERE $primary = ?");
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                header("Location: ?table=$table");
            }
        } else {
            renderTable($conn, $table);
        }
    } else {
        $tables = getTables($conn);
        echo "<h1><p class=empresatitulo>Base de Datos</p></h1>";
        echo "<ul class='lista-estilo-tabla lista-items'>";
        foreach ($tables as $table) {
            echo "<li class='lista-item'><a href='?table=$table'>$table</a></li>";
        }
        echo "</ul>";
    }
    ?>


    <body>
        <?php
        // Verificar si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario'])) {
            echo '<a href="cerrar.php"><button>Cerrar sesión</button></a>';
        } else {
            echo 'No has iniciado sesión.';
        }
        ?>
        <!-- Aquí el contenido dinámico se mostrará dependiendo de la acción -->
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