<?php
function renderHeader($activePage = '')
{ ?>
    <!DOCTYPE html>
    <html lang="pt">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Especialidades - Clínica Saúde Viva</title>
        <link rel="stylesheet" href="../styles.css">
    </head>

    <body>
        <header>
            <div class=logo>
                <a href="../index.php">
                    <img src="../images/logo.png" alt="Logo">
                </a>
            </div>
            <nav>

                <ul class="nav-links">

                    <?php if ($_SESSION['role_user'] == 'patient' && $activePage !== 'consultas') { ?>
                        <li><a href="../marcarconsultas.php"> Marcar Consultas</a></li>
                        
                    <?php } ?>

                    <?php if ($_SESSION['role_user'] == 'secretary' && $activePage !== 'secretaria') { ?>
                        <li><a href="../secretaria.php"> Horários    </a></li>
                    <?php } ?>
                    
                    <?php if ($_SESSION['role_user'] == 'doctor' && $activePage !== 'doutor' ) { ?>
                        <li><a href="../.php"> Doutor </a></li>
                    <?php } ?>

                    <?php if ($_SESSION['role_user'] == 'admin' && $activePage !== 'admin') { ?>
                        <li><a href="../admin.php"> Admin</a></li>
                    <?php } ?>

                    <?php if ($_SESSION['role_user'] == 'nurse' && $activePage !== 'enfermeira' ) { ?>
                        <li><a href="../enfermeira.php"> Enfermeira </a></li>

                    <?php } ?>

                    <?php if ($_SESSION['role_user'] == 'labtech'&& $activePage !== 'labtech') { ?>
                        <li><a href="../labtech.php"> Técnico de Laboratório </a></li>
                    <?php } ?>

                    <?php if ($activePage !== 'especialidades') { ?>
                        <li><a href="../especialidades.php">Especialidades</a></li>
                    <?php } ?>
                    <?php if ($activePage !== 'sobre') { ?>
                        <li><a href="sobre.php">Sobre</a></li>
                        
                    <?php } ?>
                </ul>
                <div class="profile">
                    <?php if (!isset($_SESSION['email'])) { ?>
                        <a href="loginpage.php">
                            <img src="images/pfp.jpg" alt="Profile">
                        </a>
                    <?php } else { ?>
                        <!-- Redireciona para o painel/perfil se o usuário estiver logado -->
                        <a href="profile.php">
                            <img src="images/pfp.jpg" alt="Profile">
                        </a>
                    <?php } ?>
                </div>
            </nav>
        </header>
    </body>

    </html>
<?php } ?>