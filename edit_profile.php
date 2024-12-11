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
    
    <form action="actions/action_edit_profile.php" class="registration-form" method="post" autocomplete="off">
        <fieldset class="edit">
            <h2>Perfil de <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

            <div class="input-container">
                <label for="name">Nome: </label>
                <input type="text" id="name" name="name" autocomplete="off">
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
                    title="O número de telefone deve conter 9 dígitos." autocomplete="off">
            </div>

            <div class="input-container">
                <label for="password">Senha: </label>
                <input type="password" id="password" name="password" autocomplete="new-password">
            </div>

            <div class="input-container">
                <label for="confirm_password">Confirmar Senha: </label>
                <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password">
            </div>

            <input type="submit" value="Salvar">

           
        </fieldset>
        <?php if (isset($msg)) { ?>
                    <?php echo $msg ?>
            <?php } ?>
    </form>
</body>

</html>