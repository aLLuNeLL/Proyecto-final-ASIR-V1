<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSL-Presupuestos</title>
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

                $id_usuario = $_SESSION['usuario'];
                $is_admin = $_SESSION['tipo'] === 'admin';

                // Consultar presupuesto
                if ($is_admin) {
                    $query = "SELECT * FROM presupuesto";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $query = "SELECT * FROM presupuesto WHERE id_cliente = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $id_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();
                }

                $presupuesto = [];
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $presupuesto[] = $row;
                    }
                }

                // Eliminar petición
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                    $id_presupuesto = intval($_POST['id_presupuesto']);

                    if ($is_admin) {
                        $query = "DELETE FROM presupuesto WHERE id_presupuesto = ?";
                    } else {
                        $query = "DELETE FROM presupuesto WHERE id_presupuesto = ? AND id_cliente = ?";
                    }
                    $stmt = $conn->prepare($query);
                    if ($is_admin) {
                        $stmt->bind_param('i', $id_presupuesto);
                    } else {
                        $stmt->bind_param('ii', $id_presupuesto, $id_usuario);
                    }
                    $stmt->execute();
                    header("Location: logueado.php");
                }
                ?>
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
                    // Si no hay usuario logueado, muestra el enlace de login
                    echo "<li class='link'>";
                    echo "<a href='login.php' class='link'>Login</a>";
                    echo "</li>";
                }
                ?>
        </nav>
    </header>

    <h1 class="empresatitulo">Mis presupuestos</h1>
    <table class="acciones" border="1">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Coste</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Iterar a través de los presupuestos
        foreach ($presupuesto as $presupuesto_item):
            // Obtener el ID del presupuesto actual
            $id_presupuesto = $presupuesto_item['id_presupuesto'];

            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare("SELECT SUM(s.precio) AS coste 
                                FROM servicios s 
                                JOIN servicios_presupuesto sp ON s.id_servicio = sp.id_servicio 
                                JOIN presupuesto p ON sp.id_presupuesto = p.id_presupuesto 
                                WHERE p.id_presupuesto = ?");
            $stmt->bind_param("i", $id_presupuesto);
            $stmt->execute();
            $result = $stmt->get_result();

            // Obtener el resultado de la consulta
            $row = $result->fetch_assoc();
            $coste_total = $row['coste'] ?? 0; // Si no hay resultado, el coste será 0
        ?>
            <tr>
                <td><?= htmlspecialchars($presupuesto_item['id_presupuesto']); ?></td>
                <td><?= htmlspecialchars($presupuesto_item['fecha_peticion']); ?></td>
                <td><?= htmlspecialchars($coste_total); ?> €</td>
                <td><?= htmlspecialchars($presupuesto_item['estado']); ?></td>
                <td>
                    <div class="romeo">
                        <form method="POST" class="romeo2">
                            <input type="hidden" name="id_presupuesto" value="<?= $presupuesto_item['id_presupuesto'] ?>">
                            <select class="select-estado" name="estado">
                                <option value="------" <?= $presupuesto_item['estado'] === '------' ? 'selected' : '' ?>>-------</option>
                                <option value="aceptado" <?= $presupuesto_item['estado'] === 'aceptado' ? 'selected' : '' ?>>Aceptado</option>
                                <option value="denegado" <?= $presupuesto_item['estado'] === 'denegado' ? 'selected' : '' ?>>Denegado</option>
                            </select>
                            <button type="submit" name="update" class="btn-actualizar">Actualizar</button>
                        </form>
                        <form method="POST" class="romeo2">
                            <input type="hidden" name="id_presupuesto" value="<?= $presupuesto_item['id_presupuesto'] ?>">
                            <button type="submit" name="delete" class="btn-eliminar">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php
            $stmt->close();
        endforeach;
        ?>
    </table>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $id_presupuesto = intval($_POST['id_presupuesto']);
        $nuevo_estado = mysqli_real_escape_string($conn, $_POST['estado']);

        if ($id_usuario) {
            $query = "UPDATE presupuesto SET estado = ? WHERE id_presupuesto = ?";
        } else {
            $query = "UPDATE presupuesto SET estado = ? WHERE id_presupuesto = ? AND id_cliente = ?";
        }
        $stmt = $conn->prepare($query);
        if ($id_usuario) {
            $stmt->bind_param('si', $nuevo_estado, $id_presupuesto);
        } else {
            $stmt->bind_param('sii', $nuevo_estado, $id_presupuesto, $id_usuario);
        }
        //echo ($id_usuario);
        $stmt->execute();

        header("Location: logueado.php");
    }


    ?>
    <button onclick="window.open('factura.php', '_blank')">Ver factura</button>
    <?php
    if (isset($_SESSION['usuario'])) {
        echo '<a href="cerrar.php"><button>Cerrar sesión</button></a>';
    } else {
        echo 'No has iniciado sesión.';
    }

    ?>
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