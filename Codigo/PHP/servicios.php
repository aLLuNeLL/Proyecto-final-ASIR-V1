<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RSL-Servicios</title>
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
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        session_start();
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
      </ul>
    </nav>
  </header>

  <!-- --------------------- Servicios --------------------- -->
  <p class="empresatitulo">Servicios de RSL</p>

  <div class="servicios-galeria">
    <div class="servicio-item">
      <div class="card">
        <div class="front">
          <img src="../img/servicio1.jpg" alt="Auditorías de Ciberseguridad">
        </div>
        <div class="back">
          <h3>Auditorías de Ciberseguridad</h3><br>
          <p>Ofrecemos auditorías de ciberseguridad integrales para identificar vulnerabilidades, evaluar riesgos y
            garantizar el cumplimiento normativo, fortaleciendo la protección de tus sistemas y datos frente a amenazas
            digitales.</p>
          <p>A parte de ello, se ofrece en 2 rangos:</p>
          <p><b>AUDITORIA BASE</b></p>
          <p><b>AUDITORIA VIP</b></p>
        </div>
      </div>
    </div>
    <div class="servicio-item">
      <div class="card">
        <div class="front">
          <img src="../img/servicio2.jpg" alt="Formación y Cursos Especializados">
        </div>
        <div class="back">
          <h3>Formación y Cursos Especializados:</h3>
          <p>Impartimos cursos y capacitaciones especializadas en ciberseguridad, diseñados para fortalecer las
            habilidades técnicas y teóricas de tu equipo, asegurando un aprendizaje adaptado a las necesidades del
            entorno digital actual.</p>
          <p><b>FORMACIÓN</b></p>
          <p><b>CURSOS</b></p>
        </div>
      </div>
    </div>
    <div class="servicio-item">
      <div class="card">
        <div class="front">
          <img src="../img/servicio3.jpg" alt="Consultoría en Seguridad Informática">
        </div>
        <div class="back">
          <h3>Consultoría en Seguridad Informática</h3>
          <p>Brindamos asesoría experta para implementar estrategias y soluciones personalizadas, ayudando a las
            empresas a proteger sus activos digitales y optimizar sus defensas contra amenazas cibernéticas.</p>
          <p><b>CONSULTORÍA EN SEGURIDAD INFORMÁTICA</b></p>
        </div>
      </div>
    </div>
    <div class="servicio-item">
      <div class="card">
        <div class="front">
          <img src="../img/servicio4.jpg" alt="Pruebas de Penetración">
        </div>
        <div class="back">
          <h3>Pruebas de Penetración</h3>
          <p>Realizamos simulaciones controladas de ciberataques para identificar debilidades en tu infraestructura,
            permitiendo implementar medidas correctivas antes de que ocurran incidentes reales.</p>
            <p><b>PENTESTING INTERNO</b></p>
        </div>
      </div>
    </div>
    <div class="servicio-item">
      <div class="card">
        <div class="front">
          <img src="../img/servicio5.jpg" alt="Gestión de Incidentes">
        </div>
        <div class="back">
          <h3>Gestión de Incidentes</h3>
          <p>Ofrecemos soluciones rápidas y efectivas para detectar, contener y mitigar los efectos de incidentes de
            seguridad, minimizando el impacto en tus operaciones.</p>
            <p><b>INCIDENCIAS</b></p>
        </div>
      </div>
    </div>
    <div class="servicio-item">
      <div class="card">
        <div class="front">
          <img src="../img/servicio6.jpg" alt="Monitoreo Continuo">
        </div>
        <div class="back">
          <h3>Monitoreo Continuo</h3>
          <p>Implementamos sistemas avanzados de monitoreo 24/7 para detectar amenazas en tiempo real, garantizando la
            protección constante de tus activos digitales.</p>
            <p><b>MONITOREO</b></p>
        </div>
      </div>
    </div>
  </div>

  <!--Formulario-->

  <div class="boxempresa1">
    <script>
      // Función para alternar la visibilidad de un div
      function toggleDiv(divId) {
        var div = document.getElementById(divId);
        if (div.style.display === "none" || div.style.display === "") {
          div.style.display = "block"; // Mostrar el div
        } else {
          div.style.display = "none"; // Ocultar el div
        }
      }
    </script>

    <?php
    include('conexion.php'); // Incluir la conexión a la base de datos

    if (!$conn) {
      die("Error de conexión con la base de datos: " . mysqli_connect_error());
    }

    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuario'])) {
      echo '<p class="empresatitulo">Debes iniciar sesión para ver y seleccionar servicios.</p>';
      exit();
    }

    $is_admin = isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin';

    // Mostrar servicios según el tipo de usuario
    if (!$is_admin) {
      // Cliente: seleccionar servicios
      $query = "SELECT * FROM servicios";
      $result = $conn->query($query);

      if ($result && $result->num_rows > 0) {
        echo "<form action='procesar_solicitud.php' method='post'>";
        echo "<fieldset>";
        echo "<legend>Selecciona los servicios que deseas</legend>";
        while ($row = $result->fetch_assoc()) {
          $id_servicio = htmlspecialchars($row['id_servicio']);
          $nombre_servicio = htmlspecialchars($row['nombre']);
          $precio_servicio = htmlspecialchars($row['precio']);
          echo "<label><input type='checkbox' name='servicio[]' value='$id_servicio'> $nombre_servicio - $precio_servicio €</label><br>";
        }
        echo "</fieldset>";
        echo "<button type='submit'>Enviar</button>";
        echo "</form>";
      } else {
        echo "<p>No hay servicios disponibles actualmente.</p>";
      }
    } else {
      // Administrador: agregar servicios
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_servicio = $_POST['nombre_servicio'];
        $descripcion_servicio = $_POST['descripcion_servicio'];
        $precio_servicio = $_POST['precio_servicio'];

        $stmt = $conn->prepare("INSERT INTO servicios (nombre, descripcion, precio) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $nombre_servicio, $descripcion_servicio, $precio_servicio);
        if ($stmt->execute()) {
          echo "<p>Servicio agregado correctamente.</p>";
        } else {
          echo "<p>Error al agregar el servicio: " . $conn->error . "</p>";
        }
      }
    }

    // Cerrar la conexión
    $conn->close();
    ?>

    <?php
    // Comprobar si el usuario es administrador para mostrar las opciones de añadir/eliminar servicios
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin') {
      echo '
    <form action="agregar_servicio.php" method="POST">
        <fieldset>
            <legend><p class="empresatitulo">Agregar Nuevo Servicio</p></legend>
            <label for="nombre_servicio">Nombre del Servicio:</label>
            <input type="text" id="nombre_servicio" name="nombre_servicio" required>
            <label for="descripcion_servicio">Descripción del Servicio:</label>
            <input type="text" id="descripcion_servicio" name="descripcion_servicio" required>
            <label for="precio_servicio">Precio del Servicio (€):</label>
            <input type="number" id="precio_servicio" name="precio_servicio" required>
            <button type="submit">Agregar Servicio</button>
        </fieldset>
    </form>';
    }
    ?>
    <?php
    // Verificar si el usuario es admin
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'admin') {
      // Incluir la conexión a la base de datos
      include('conexion.php');  // Asegúrate de que la ruta sea correcta

      // Verificar si la conexión fue exitosa
      if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
      }

      // Consulta SQL para seleccionar todos los servicios
      $query = "SELECT * FROM servicios";

      // Ejecutar la consulta
      $result = $stmt = $conn->prepare($query);

      // Verificar si la consulta se ejecutó correctamente
      if ($result) {
        // Comprobar si hay resultados
        if ($result->num_rows > 0) {
          echo "<h3 class='empresatitulo1'>Servicios Existentes</h3>";
          echo "<div class='row'>"; // Comienza el contenedor de filas

          // Contador para controlar cada grupo de 3 elementos
          $counter = 0;

          // Recorrer todos los resultados
          while ($row = $result->fetch_assoc()) {
            // Cada 3 elementos, se crea una nueva fila
            if ($counter % 3 == 0 && $counter > 0) {
              echo "</div><div class='row'>"; // Cerrar y abrir una nueva fila
            }

            echo "<div class='col-4'>"; // Columna con un tamaño de 4 (de 12 columnas)
            echo "<div class='servicio-info'> 
                        <span class='textin'>ID:</span> " . htmlspecialchars($row['id_servicio']) . "<br>
                        <span class='textin'>Nombre:</span> " . htmlspecialchars($row['nombre']) . "<br>
                        <span class='empresaexpli'>Descripción:</span> " . htmlspecialchars($row['descripcion']) . "<br>
                        <span class='textin'>Precio:</span> " . htmlspecialchars($row['precio']) . "€
                      </div>";

            if (isset($row['id_servicio']) && is_numeric($row['id_servicio'])) {
              $id_servicio = $row['id_servicio'];
              echo "<a class='btn-eliminar link' href='eliminar_servicio.php?id_servicio=" . $id_servicio . "'>Eliminar</a>";
            } else {
              echo "<span class='error mensaje'>ID de servicio no disponible.</span>";
            }
            echo "</div>"; // Cerrar la columna

            $counter++; // Aumentar el contador
          }

          echo "</div>"; // Cerrar la última fila
        } else {
          echo "<p class='boxempresa'>No hay servicios disponibles.</p>";
        }
      } else {
        // Si la consulta falla, mostrar un mensaje de error
        echo "<p class='error'>Error al ejecutar la consulta: " . $conn->error . "</p>";
      }

      // Cerrar la conexión
      $conn->close();
    }
    ?>
    <?php
    ?>


  </div>
  <!-- --------------------- Footer --------------------- -->
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