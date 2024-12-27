<!-- Caixa branca para o perfil -->

<section id='content_profile'>

    <fieldset class="changedata-form">

        <h2>Perfil de <?php echo $_SESSION['name']; ?></h2>

        <div class="profile-info">
            <p><strong>Nome:</strong> <?php echo $_SESSION['name']; ?></p>
            <p><strong>Idade:</strong> <?php echo $_SESSION['age']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
            <p><strong>Endereço:</strong> <?php echo $_SESSION['address']; ?></p>
            <p><strong>Telefone:</strong> <?php echo $_SESSION['phone_number']; ?></p>
        </div>

        <div class="button-group-edit">
            <a href="edit_profile.php" class="btn-edit">Alterar Dados</a>
            <a href="actions/action_logout.php" class="btn-logout">Logout</a>

            <h5 class="message">
                <?php if (isset($msg)) { ?>
                    <?php echo $msg ?>
                <?php } ?>
            </h5>
        </div>
    </fieldset>




    <!-- Caixa branca com histórico de consultas -->
    <fieldset class="changedata-form">
        <h2>Histórico de Consultas</h2>

        <?php

       
        // Verifica se há agendamentos na sessão
        if (!empty($_SESSION['appointments'])) {
            // Exibe o número total de consultas
            $totalAppointments = count($_SESSION['appointments']);

        ?>

            <table id="appointments-table" class="appointments-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Médico</th>
                        <th>Enfermeiro</th>
                        <th>Dia</th>
                        <th>Horário</th>
                        <th>Relatório</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['appointments'] as $appointment) { ?>
                        <tr>
                            <td><?php echo $appointment['appointment_id']; ?></td>
                            <td><?php echo $appointment['Doutor']; ?></td>
                            <td><?php echo $appointment['Enfermeiro']; ?></td>
                            <td><?php echo $appointment['Data da Consulta']; ?></td>
                            <td><?php echo $appointment['Hora']; ?></td>
                            <td>
                                <div class="report_grid">
                                    <div class="grid-item">
                                        <?php
                                        // Verifica se a variável de sessão 'selected_appointments' existe e é um array
                                        if (isset($_SESSION['selected_appointments']) && is_array($_SESSION['selected_appointments'])):
                                            if (in_array($appointment['appointment_id'], $_SESSION['selected_appointments'])):
                                        ?>
                                                <p> <?php echo $appointment['Relatório']; ?></p>
                                            <?php else: ?>
                                                <!-- Exibe a mensagem para clicar e mostrar o relatório completo -->
                                                <p id="show-report-message">Clique para mostrar relatório completo</p>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <!-- Caso a variável de sessão não exista ou não seja um array -->
                                            <p id="show-report-message">Clique para mostrar relatório completo</p>
                                        <?php endif; ?>
                                    </div>


                                    <div class="show_hide_button">
                                        <form action="actions/action_showhide_report.php" method="POST">
                                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                            <button type="submit" class="toggle-appointment-btn"></button>
                                        </form>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php
        } else {
            // Exibe mensagem se não houver consultas
            echo '<p>Você ainda não possui consultas registradas.</p>';
        }
        ?>

    </fieldset>


</section>