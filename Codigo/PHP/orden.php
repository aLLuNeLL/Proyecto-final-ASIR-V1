<?php
include("conexion.php");
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verifica si el usuario está logueado y es un administrador
$id_usuario = $_SESSION['usuario'];
$is_admin = $_SESSION['tipo'] === 'admin';

// Consultar órdenes de trabajo
if ($is_admin) {
    $query = "SELECT * FROM orden_trabajo";
} else {
    $query = "SELECT * FROM orden_trabajo WHERE id_cliente = $id_usuario";
}

$result = $stmt->bind_param( $query);

$ordenes = [];
if ($result && $stmt->execute(); $result = $stmt->get_result(); $row = $result->num_rows > 0) {
    while ($row = $stmt->execute(); $result = $stmt->get_result(); $row = $result->fetch_assoc()) {
        $ordenes[] = $row;
    }
}

// Actualizar estado de una orden de trabajo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id_orden_trabajo = intval($_POST['id_orden_trabajo']);
    $nuevo_estado = mysqli_real_escape_string($conn, $_POST['estado']);
    
    if ($is_admin) {
        $query = "UPDATE orden_trabajo SET estado = '$nuevo_estado' WHERE id_orden_trabajo = $id_orden_trabajo";
    } else {
        $query = "UPDATE orden_trabajo SET estado = '$nuevo_estado' WHERE id_orden_trabajo = $id_orden_trabajo AND id_cliente = $id_usuario";
    }

    $stmt->bind_param( $query);
    header("Location: orden_trabajo.php"); // Redirige a la misma página para ver los cambios
    exit();
}

// Eliminar orden de trabajo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id_orden_trabajo = intval($_POST['id_orden_trabajo']);
    
    if ($is_admin) {
        $query = "DELETE FROM orden_trabajo WHERE id_orden_trabajo = $id_orden_trabajo";
    } else {
        $query = "DELETE FROM orden_trabajo WHERE id_orden_trabajo = $id_orden_trabajo AND id_cliente = $id_usuario";
    }

    $stmt->bind_param( $query);
    header("Location: orden_trabajo.php"); // Redirige a la misma página para ver los cambios
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes de Trabajo</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../img/rls.png" alt="Logo RSL"></a>
            </div>
            <!-- Agregar navegación y opciones según el estado de sesión -->
            <ul class="ul_links">
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="../servicios.php">Servicios</a></li>
                <li><a href="../equipo.php">Equipo</a></li>
                <?php
                if (isset($_SESSION['usuario'])) {
                    echo "<li><a href='orden_trabajo.php'>Órdenes de Trabajo</a></li>";
                }
                ?>
                <li>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="cerrar.php">Cerrar sesión</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <h1>Órdenes de Trabajo</h1>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        
        <?php foreach ($ordenes as $orden): ?>
        <tr>
            <td><?= $orden['id_orden_trabajo'] ?></td>
            <td><?= $orden['fecha_inicio'] ?></td>
            <td><?= $orden['fecha_fin'] ?></td>
            <td><?= $orden['estado'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id_orden_trabajo" value="<?= $orden['id_orden_trabajo'] ?>">
                    <select name="estado">
                        <option value="en progreso" <?= $orden['estado'] === 'en progreso' ? 'selected' : '' ?>>En progreso</option>
                        <option value="finalizada" <?= $orden['estado'] === 'finalizada' ? 'selected' : '' ?>>Finalizada</option>
                        <option value="pendiente" <?= $orden['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    </select>
                    <button type="submit" name="update">Actualizar</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id_orden_trabajo" value="<?= $orden['id_orden_trabajo'] ?>">
                    <button type="submit" name="delete">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Crear nueva Orden de Trabajo</h2>
    <form action="crear_orden_trabajo.php" method="POST">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" required><br><br>
        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" required><br><br>
        <label for="id_presupuesto">ID de Presupuesto:</label>
        <input type="number" name="id_presupuesto" required><br><br>
        <button type="submit" name="crear_orden">Crear Orden</button>
    </form>
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
