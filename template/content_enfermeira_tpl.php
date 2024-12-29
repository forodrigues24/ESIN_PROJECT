<section id='content_secretaria'>
    <div>
    <!-- Caixa branca com histórico de consultas -->
        <fieldset class="schedule-form">
            <h2>Marcar Horários</h2>

            <!-- Selecionar função -->
            <form method="POST" action="actions/action_encontrar_consultas.php">


                <!-- Selecionar Data -->
                <label for="data">Escolha uma data:</label>
                <input type="date" name="data" id="data" required>
                <div class="button-group-edit">
                    <input type="submit" value="Pesquisar">
                    <h5 class="message">
                        <?php if (isset($msg)) { ?>
                            <?php echo $msg ?>
                        <?php } ?>
                    </h5>
                </div>
            </form>

        </fieldset>
        <?php if (isset($_SESSION['consultas_sem_enfermeira']) && !empty($_SESSION['consultas_sem_enfermeira'])) { ?>
            <fieldset class="schedule-form">
                <h2>Horários: <?php echo $_SESSION['consultas_sem_enfermeira'][0]['date'] ?> </h2>

                <h3>Consultas Sem Enfermeira</h3>
                <table id="appointments-table" class="appointments-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Médico</th>
                            <th>Especialidade</th>
                            <th>Paciente</th>
                            <th>Idade</th>
                            <th>Atribuir</th>


                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($_SESSION['consultas_sem_enfermeira'] as $horarios) { ?>
                            <tr>
                                <td><?php echo $horarios['date']; ?></td>
                                <td><?php echo $horarios['time']; ?></td>
                                <td><?php echo $horarios['doctor_name']; ?></td>
                                <td><?php echo $horarios['doctor_specialty']; ?></td>
                                <td><?php echo $horarios['patient_name']; ?></td>
                                <td><?php echo $_SESSION['patient_age']; ?></td>

                                <td>
                                    <div class="show_hide_button">
                                        <form action="actions/action_enfermeira_consulta.php" method="POST">
                                            <input type="hidden" name="appointment_id" value="<?php echo $horarios['appointment_id']; ?>">
                                            <input type="hidden" name="appointment_date" value="<?php echo $horarios['date']; ?>">

                                            <button type="submit" class="toggle-appointment-btn"></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>


                <h3>Consultas Atribuídas</h3>
                <table id="schedule-table" class="appointments-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Médico</th>
                            <th>Especialidade</th>
                            <th>Paciente</th>
                            <th>Idade</th>
                            <th>Retirar</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['consultas_da_enfermeira'] as $horarios) { ?>
                            <tr>
                                <td><?php echo $horarios['date']; ?></td>
                                <td><?php echo $horarios['time']; ?></td>
                                <td><?php echo $horarios['doctor_name']; ?></td>
                                <td><?php echo $horarios['doctor_specialty']; ?></td>
                                <td><?php echo $horarios['patient_name']; ?></td>
                                <td><?php echo $_SESSION['patient_age']; ?></td>
                                <td>
                                    <div class="show_hide_button">
                                        <form action="actions/action_enfermeira_retirar_consulta.php" method="POST">
                                            <input type="hidden" name="appointment_id" value="<?php echo $horarios['appointment_id']; ?>">
                                            <input type="hidden" name="appointment_date" value="<?php echo $horarios['date']; ?>">
                                            <button type="submit" class="toggle-retirar-btn"></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </fieldset>
    <div>

    <?php } ?>
</section>