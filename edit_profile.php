<?php
session_start();
$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perfil - Editar</title>
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
        <h2>Perfil do <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

        <div class="input-container">
            <label for="name">Nome: </label>
            <input type="text" id="name" name="name" autocomplete="off" required>
        </div>

        <div class="input-container">
            <label for="age">Idade:</label>
            <input type="number" id="age" name="age" min="0" autocomplete="off">
        </div>

        <div class="input-container">
            <label for="address">Morada:</label>
            <input type="text" id="address" name="address" autocomplete="off">
        </div>

        <div class="input-container">
            <label for="phone">Telefone:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{9}"
                title="O número de telefone deve conter 9 dígitos." autocomplete="off" required>
        </div>

        <div class="input-container">
            <label for="password">Senha: </label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>
        </div>

        <div class="input-container">
            <label for="confirm_password">Confirmar Senha: </label>
            <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required>
        </div>

        <input type="submit" value="Salvar">
    </fieldset>


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