<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSL</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <!------------------------------Menu Hamburguesa----------------------------------->
    <main id="todo">
        <header class="header">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="img/rls.png" alt="Logo RSL"></a>

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
                    <li class="link"><a href="index.php" class="link">Inicio</a></li>
                    <li class="link"><a href="php/servicios.php" class="link">Servicios</a></li>
                    <li class="link"><a href="php/equipo.php" class="link">Equipo</a></li>

                    <?php
                    session_start();

                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);

                    // Comprobar si el usuario está logueado
                    if (isset($_SESSION['usuario'])) {
                        // Si hay un usuario logueado, muestra el nombre de usuario con el enlace a logueado.php
                        if ($_SESSION['tipo'] === 'admin') {
                            echo "<li class='link'>";
                            echo "<a href='php/admin.php' class='link'> Admin </a>";
                            echo "</li>";
                        } else {
                            echo "<li class='link'>";
                            echo "<a href='php/logueado.php' class='link'> My Site </a>";
                            echo "</li>";
                        }
                    } else {
                        ?>
                    <li class="link"><a href="php/login.php" class="link">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <!------------------------------Menu Hamburguesa----------------------------------->

        <!------------------------------Contenidos----------------------------------------->
        <div class="video-container">
            <video class="video" autoplay loop muted>
                <source src="vid/mi_video.mp4" type="video/mp4">

            </video>
            <div class="overlay">
                <h2>Auditorías RSL</h2>
            </div>
        </div>
        <!------------------------------Contenidos----------------------------------------->

        <!------------------------------Slider--------------------------------------------->
        <p class="empresatitulo"><b>EMPRESAS COLABORADORAS</b></p>
        <div class="slider">
            <div class="slide-track">
                <div class="slide"><img src="img/icons8-amazonas-150.png" alt="Amazon"></div>
                <div class="slide"><img src="img/icons8-burp-suite-de-150.png" alt="Burp Suite"></div>
                <div class="slide"><img src="img/icons8-call-of-duty-black-ops-3-150.png" alt="Call of Duty"></div>
                <div class="slide"><img src="img/icons8-malwarebytes-150.png" alt="Malwarebytes"></div>
                <div class="slide"><img src="img/icons8-nordvpn-150.png" alt="NordVPN"></div>
                <div class="slide"><img src="img/icons8-openvpn-150.png" alt="OpenVPN"></div>
                <div class="slide"><img src="img/icons8-reddit-150.png" alt="Reddit"></div>
                <div class="slide"><img src="img/icons8-rockstar-games-150.png" alt="Rockstar Games"></div>
                <div class="slide"><img src="img/icons8-teamviewer-150.png" alt="TeamViewer"></div>
                <div class="slide"><img src="img/icons8-trello-150.png" alt="Trello"></div>
                <div class="slide"><img src="img/icons8-twitch-150.png" alt="Twitch"></div>
                <div class="slide"><img src="img/icons8-waze-150.png" alt="Waze"></div>
                <div class="slide"><img src="img/icons8-vmware-150.png" alt="VMware"></div>
                <div class="slide"><img src="img/icons8-yandex-direct-150.png" alt="Yandex"></div>
                <div class="slide"><img src="img/icons8-zalando-150.png" alt="Zalando"></div>
                <div class="slide"><img src="img/icons8-meta-150.png" alt="Meta"></div>
            </div>
        </div>
        <!------------------------------Slider--------------------------------------------->

        <!------------------------------Sobre la Empresa----------------------------------->
        <div class="boxempresa">
            <div class="empresa">
                <p class="empresatitulo"><b>SOBRE RSL</b></p>
                <p class="empresaexpli">RSL, fundada en septiembre de 2024, se especializa en auditorías y formación en
                    ciberseguridad. Ofrece cursos de prevención y evaluación de riesgos, ayudando a proteger frente a
                    amenazas digitales.</p>
                <p class="empresatitulo">Nuestros valores</p>
                <ul>
                    <li class="empresaexpli"><b>Integridad:</b> Trabajamos con total transparencia y ética en cada
                        proyecto.</li>
                    <li class="empresaexpli"><b>Innovación:</b> Ofrecemos soluciones adaptadas a los retos actuales de
                        la ciberseguridad.</li>
                    <li class="empresaexpli"><b>Excelencia:</b> Brindamos servicios de alta calidad.</li>
                    <li class="empresaexpli"><b>Compromiso con la seguridad:</b> Su información es nuestra prioridad.
                    </li>
                </ul>
                <p class="empresaexpli">Confíe en nosotros para blindar su seguridad digital.</p>
            </div>
            <div>
                <img class="imgini" src="img/empresa.jpg" alt="Sobre nosotros">
                <img class="imgini" src="img/empresa1.jpg" alt="Equipo RSL">
            </div>
        </div>
        <!------------------------------Sobre la Empresa----------------------------------->

        <!------------------------------Footer--------------------------------------------->
        <footer>
            <div class="pie">
                <div class="copi">
                    <h5>©2024-2025</h5>
                </div>
                <div class="logos">
                    <img class="instagram" src="img/icons8-insta-50.png" alt="Instagram">
                    <img class="linkedin" src="img/icons8-linkedin-48 (2).png" alt="LinkedIn">
                    <img class="youtube" src="img/icons8-youtube-50.png" alt="YouTube">
                </div>
            </div>
        </footer>
    </main>
</body>

</html>