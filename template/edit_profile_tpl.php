<form action="actions/action_edit_profile.php" class="registration-form" method="post" autocomplete="off">
    <fieldset class="edit">
        <h2>Perfil de <?php echo $_SESSION['name']; ?></h2>

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

        <input type="submit" class="btn-logout" value="Salvar">

        <div class="msg-centered">
            <h5 class="message">
                <?php if (isset($msg)) { ?>
                    <?php echo $msg ?>
                <?php } ?>
            </h5>
        <div class="input-container">


    </fieldset>

</form>
</body>