<?php
session_start();
$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Cabeçalho da página -->
    <header>
        <a href="index.php">
            <img src="images/logo.png" alt="Logo">
        </a>

        <nav>
            <ul class="nav-links">
                <li><a href="especialidades.html">Especialidades</a></li>
                <li><a href="sobre.html">Sobre</a></li>
            </ul>
            <div class="profile">
                <a href="profile.php">
                    <img src="images/pfp.jpg" alt="Profile">
                </a>
            </div>
        </nav>
    </header>

    <!-- Caixa branca para o perfil -->
    <fieldset class="changedata-form">
        <div class="logout-button">
            <h2>Perfil do <?php echo $_SESSION['name']; ?></h2>
            <!-- Container para os botões com alinhamento à direita -->

        </div>

        <!-- Informações do perfil -->
        <div class="profile-info">
            <p><strong>Nome:</strong> <?php echo $_SESSION['name']; ?></p>
            <p><strong>Idade:</strong> <?php echo $_SESSION['age']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
            <p><strong>Endereço:</strong> <?php echo $_SESSION['address']; ?></p>
            <p><strong>Telefone:</strong> <?php echo $_SESSION['phone_number']; ?></p>
        </div>

        <div class="button-group">
            <a href="edit_profile.php" class="btn-edit">Alterar Dados</a>
            <a href="action_logout.php" class="btn-logout">Logout</a>
        </div>
    </fieldset>

    <!-- Caixa branca com histórico de consultas -->
    <fieldset class="changedata-form">
        <h2>Histórico de Consultas</h2>

        <!-- Tabela de consultas -->
        <?php if (!empty($_SESSION['appointments'])) { ?>
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Horário</th>
                        <th>Médico</th>
                        <th>Enfermeiro</th>
                        <th>Secretário</th>
                        <th>Relatório</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['appointments'] as $appointment) { ?>
                        <tr>
                            <td><?php echo $appointment['appointment_id']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($appointment['schedule'])); ?></td>
                            <td><?php echo $appointment['doctor_name']; ?></td>
                            <td><?php echo $appointment['nurse_name']; ?></td>
                            <td><?php echo $appointment['secretary_name']; ?></td>
                            <td><?php echo $appointment['report']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Você ainda não possui consultas registradas.</p>
        <?php } ?>
    </fieldset class="changedata-form">

</body>

</html>