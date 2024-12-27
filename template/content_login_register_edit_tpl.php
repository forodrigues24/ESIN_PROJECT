<?php

function login()
{ 
    global $msg; ?>
    <section id='content_loginregister'>
        <form action="actions/action_login.php" class='login-form' method="post">
            <fieldset>
                <h2>Login</h2>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <div class="buttons-container">
                    <input type="submit" value="Entrar">
                    <a href="registpage.php" class="register-button">Registrar-se</a>
                </div>

                <h5 class="message">
                    <?php if (isset($msg)) { ?>
                        <?php echo $msg ?>
                    <?php } ?>
                </h5>

            </fieldset>
        </form>
    </section>
<?php } ?>

<?php



function register()
{ 
    global $msg; ?>
    <section id='content_loginregister'>
        <form action="actions/action_register.php" class='registration-form' method="post" autocomplete="off">
            <fieldset>
                <h2>Registrar-se</h2>

                <div class="input-container">
                    <label for="name">Nome: *</label>
                    <input type="text" id="name" name="name" autocomplete="off" required>
                </div>

                <div class="input-container">
                    <label for="age">Idade:</label>
                    <input type="number" id="age" name="age" min="0" autocomplete="off">
                </div>

                <div class="input-container">
                    <label for="email">Endereço de E-mail: *</label>
                    <input type="email" id="email" name="email" autocomplete="off" required>
                </div>

                <div class="input-container">
                    <label for="address">Morada:</label>
                    <input type="text" id="address" name="address" autocomplete="off">
                </div>

                <div class="input-container">
                    <label for="phone">Número de Telefone: *</label>
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{9}" title="O número de telefone deve conter 9 dígitos." autocomplete="off" required>
                </div>

                <div class="input-container">
                    <label for="password">Senha: *</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required>
                </div>

                <div class="input-container">
                    <label for="confirm_password">Confirmar Senha: *</label>
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required>
                </div>

                <input type="submit" value="Registrar">

                <h5 class="message">
                    <?php if (isset($msg)) { ?>
                        <?php echo $msg ?>
                    <?php } ?>
                </h5>

            </fieldset>
        </form>
    </section>
<?php } ?>


<?php
function edit()
{ 
    global $msg; ?>
    <section id='content_loginregister'>

        <form action="actions/action_edit_profile.php" class="edit-form" method="post" autocomplete="off">
            <fieldset>
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


                <div class="button-container">
                    <input type="submit" value="Salvar">
                </div>

                <h5 class="message">
                    <?php if (isset($msg)) { ?>
                        <?php echo $msg ?>
                    <?php } ?>
                </h5>
            </fieldset>
        </form>
        </body>
    </section>
<?php } ?>