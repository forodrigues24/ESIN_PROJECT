<section id='content_secretaria'>
    <div>
        <!-- Mostra as consultas marcadas de uma certa data-->
        <fieldset class="schedule-form">
            <h2>Ver Consultas Marcadas</h2>

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

        <?php if (isset($_SESSION['consultas_sem_enfermeira']) || isset($_SESSION['consultas_da_enfermeira'])) { ?>

            <?php
            // Definindo o número de itens por página
            $itemsPerPage = 5;
            // Verificando o número da página atual
            $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;

            // Consultas Sem Enfermeira
            $consultasSemEnfermeira = isset($_SESSION['consultas_sem_enfermeira']) && is_array($_SESSION['consultas_sem_enfermeira']) ? $_SESSION['consultas_sem_enfermeira'] : [];
            $totalConsultasSemEnfermeira = count($consultasSemEnfermeira);
            $totalPagesSemEnfermeira = ceil($totalConsultasSemEnfermeira / $itemsPerPage);
            $startSemEnfermeira = ($page_num - 1) * $itemsPerPage;
            $consultasSemEnfermeiraPage = array_slice($consultasSemEnfermeira, $startSemEnfermeira, $itemsPerPage);

            // Consultas Atribuídas
            $consultasAtribuidas = isset($_SESSION['consultas_da_enfermeira']) && is_array($_SESSION['consultas_da_enfermeira']) ? $_SESSION['consultas_da_enfermeira'] : [];
            $totalConsultasAtribuidas = count($consultasAtribuidas);
            $totalPagesAtribuidas = ceil($totalConsultasAtribuidas / $itemsPerPage);
            $startAtribuidas = ($page_num - 1) * $itemsPerPage;
            $consultasAtribuidasPage = array_slice($consultasAtribuidas, $startAtribuidas, $itemsPerPage);
            ?>

            <fieldset class="schedule-form">
                <h2>Horários:</h2>

                <!-- Mostra as consultas que ainda não têm enfermeira atribuída-->
                <h3>Consultas Sem Enfermeira</h3>
                <?php if ($totalConsultasSemEnfermeira > 0) { ?>
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
                            <?php foreach ($consultasSemEnfermeiraPage as $horarios) { ?>
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
                <?php } else { ?>
                    <p>Não há consultas sem enfermeira para exibir.</p>
                <?php } ?>

                <!-- Mostra as consultas que a enfermeira tem atribuídas-->
                <h3>Consultas Atribuídas</h3>
                <?php if ($totalConsultasAtribuidas > 0) { ?>
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
                            <?php foreach ($consultasAtribuidasPage as $horarios) { ?>
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
                <?php } else { ?>
                    <p>Não há consultas atribuídas à enfermeira para exibir.</p>
                <?php } ?>
            </fieldset>

            <!-- Navegação de Página -->
            <div id="pagination" class="pagination">
                <?php if ($page_num > 1) { ?>
                    <a href="?page_num=<?php echo $page_num - 1; ?>" class="pagination-link">&lt; Anterior</a>
                <?php } ?>

                <span class="page-number">Página <?php echo $page_num; ?> de <?php echo max($totalPagesSemEnfermeira, $totalPagesAtribuidas); ?></span>

                <?php if ($page_num < max($totalPagesSemEnfermeira, $totalPagesAtribuidas)) { ?>
                    <a href="?page_num=<?php echo $page_num + 1; ?>" class="pagination-link">Próxima &gt;</a>
                <?php } ?>
            </div>

        <?php } else { ?>
            <p>Não há consultas disponíveis para exibir.</p>
        <?php } ?>
    </div>
</section>
