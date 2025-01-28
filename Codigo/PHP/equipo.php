<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>RSL-Equipo</title>
   <link rel="stylesheet" href="../style/style.css">
   <link rel="icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body>
   <!------------------------------menu hamburgesa--------------------------------------------------->
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
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            session_start();
            // Comprobar si el usuario está logueado
            if (isset($_SESSION['usuario'])) {
               // Si hay un usuario logueado, muestra el nombre de usuario con el enlace a logueado.php
               if ($_SESSION['tipo'] === 'admin') {
                  echo "<li class='link'>";
                  echo "<a href='admin.php' class='link'> My Site </a>";
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
   <!------------------------------menu hamburgesa--------------------------------------------------->
   <div class="contenedo">
      <div class="imagene">
         <img class="ini" src="../img/gonomeo.jpg" alt="Descripción de la imagen 1">
         <p class="textini">ROMEO - CEO de Operaciones y Tecnología</p>
         <br>
         <p class="subtexta">Romeo lidera el área de operaciones y tecnología en RSL, donde su experiencia técnica y
            operativa es fundamental para el éxito de la empresa. Con un sólido trasfondo en ingeniería informática y
            más de 10 años en ciberseguridad, Romeo se encarga de supervisar la implementación de soluciones
            tecnológicas y la gestión de proyectos. Su enfoque en la eficiencia operativa garantiza que RSL pueda
            ofrecer servicios de alta calidad de manera rápida y eficaz. Además, trabaja estrechamente con el equipo
            técnico para integrar las últimas herramientas y tecnologías en los servicios que ofrecemos, asegurando que
            nuestros clientes siempre reciban lo mejor en protección y prevención cibernética.</p>
      </div>
      <div class="imagene">
         <img class="ini" src="../img/ruso.jpg" alt="Descripción de la imagen 2">
         <p class="textini">LLUNA - CEO de Estrategia y Desarrollo de Negocios</p>
         <br>
         <p class="subtext">Lluna es la fuerza impulsora detrás de la estrategia y el desarrollo de negocios en RSL. Con
            más de 15 años de experiencia en el sector de la ciberseguridad, ha desempeñado un papel clave en la
            identificación de oportunidades de crecimiento y en la formación de alianzas estratégicas. Su enfoque
            visionario y habilidades en gestión empresarial le permiten adaptar la oferta de RSL a las necesidades
            cambiantes del mercado. Lluna es apasionada por la innovación y se dedica a mantener a la empresa a la
            vanguardia de las tendencias en ciberseguridad, asegurando que los servicios ofrecidos no solo sean
            relevantes, sino también líderes en el sector.</p>
      </div>
      <div class="imagene">
         <img class="ini" src="../img/guiri.jpg" alt="Descripción de la imagen 3">
         <p class="textini">SANCHO - CEO de Formación y Capacitación</p>
         <br>
         <p class="subtexta">Sancho es el líder de formación y capacitación en RSL, responsable de diseñar y desarrollar
            los programas educativos que capacitan a los profesionales en ciberseguridad. Con más de 12 años de
            experiencia en enseñanza y desarrollo de talento, Sancho es un experto en métodos de aprendizaje
            innovadores. Su misión es empoderar a los empleados de las organizaciones para que comprendan y enfrenten
            las amenazas cibernéticas de manera efectiva. Sancho se asegura de que cada curso no solo sea informativo,
            sino también práctico y aplicable a situaciones del mundo real. Su pasión por la enseñanza y su compromiso
            con la excelencia educativa hacen de RSL un referente en la capacitación en ciberseguridad.</p>
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
            <img class="youtube" src="../img/icons8-youtube-50.png" alt="logo logo-youtube">
         </div>
      </div>
   </footer>
</body>

</html>