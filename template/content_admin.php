<section id='content_consultas'>
    <div>

        <fieldset class="schedule-form">
            <h2>Procurar Perfil</h2>
            <form action="actions/action_search.php" method="post">
                <div class="box_search">
                    <select name="role" class="custom-select">
                        <option value="patient">Paciente</option>
                        <option value="doctor">Médico(a)</option>
                        <option value="nurse">Enfermeiro(a)</option>
                        <option value="secretary">Secretário(a)</option>
                        <option value="labtech">LabTech</option>
                        <option value="admin">Admin</option>
                    </select>
                    <br>
                    <div class="search-container">
                        <input type="submit" id="search-button" value="🔍">
                    </div>
                </div>
            </form>

            <form action="actions/action_search2.php" method="post">
                <div class="box_search">

                    <input type="text" id="search-email" name="search-email" placeholder="Inserir Email" required>
                    <div class="search-container">
                        <input type="submit" id="search-button" value="🔍">
                    </div>
                </div>
            </form>
            <div class="start_message">
                <h5 class="message">
                    <?php if (isset($msg)) { ?>
                        <?php echo $msg ?>
                    <?php } ?>
                </h5>
            <div class="start_message">
       
        </fieldset>

        <?php if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])) { ?>
            <fieldset class="schedule-form">
                <h2>Resultados da Pesquisa</h2>
                <table class="search-results-table">
                    <thead>
                        <tr>
                            <th>ID da Pessoa</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th>Telefone</th>
                            <th>Função</th>
                            <th>Alterar</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['search_results'] as $result) {
                        ?>
                            <tr>
                                <td><?php echo $result['person_id']; ?></td>
                                <td><?php echo $result['name']; ?></td>
                                <td><?php echo $result['email_address']; ?></td>
                                <td><?php echo $result['address']; ?></td>
                                <td><?php echo $result['phone_number']; ?></td>
                                <td><?php echo $result['role']; ?></td>
                                <td>
                                    <form action="actions/action_update_role.php" method="post">
                                        <div class="box_search">
                                            <select name="role">
                                                <option value="doctor" <?php echo $result['role'] == 'doctor' ? 'selected' : ''; ?>>Médico(a)</option>
                                                <option value="nurse" <?php echo $result['role'] == 'nurse' ? 'selected' : ''; ?>>Enfermeiro(a)</option>
                                                <option value="secretary" <?php echo $result['role'] == 'secretary' ? 'selected' : ''; ?>>Secretário(a)</option>
                                                <option value="labtech" <?php echo $result['role'] == 'labtech' ? 'selected' : ''; ?>>LabTech</option>
                                                <option value="admin" <?php echo $result['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            </select>
                                            <input type="hidden" name="person_id" value="<?php echo $result['person_id']; ?>">
                                            <input type="hidden" name="person_role" value="<?php echo $result['role']; ?>">

                                            <button type="submit" id="update-button">Atualizar</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </fieldset>
        <?php } ?>
    </div>
</section>