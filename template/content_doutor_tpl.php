<section id='content_secretaria'>
    <div>
        <!-- Caixa branca com histórico de consultas -->
        <fieldset class="schedule-form">
            <h2>Marcar Horários</h2>

            <!-- Selecionar função -->
            <form method="POST" action="actions/action_consultas_medico.php">
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

        <?php if (isset($_SESSION['consultas_doutor']) && !empty($_SESSION['consultas_doutor'])) { ?>

            <?php
            // Definindo o número de itens por página
            $itemsPerPage = 5; 
            // Verificando o número da página atual, se não estiver definido, começa na página 1
            $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1; 
            // Total de consultas encontradas
            $totalConsultas = count($_SESSION['consultas_doutor']);
            // Calculando o total de páginas
            $totalPages = ceil($totalConsultas / $itemsPerPage); 
            // Calculando o início da página
            $start = ($page_num - 1) * $itemsPerPage;
            
            // Pegando apenas os resultados da página atual
            $consultasPage = array_slice($_SESSION['consultas_doutor'], $start, $itemsPerPage);
            ?>

            <fieldset class="schedule-form">
                <?php if ($_SESSION['report_clicked']) { ?>
                    <h2>Horários: <?php echo $_SESSION['consultas_doutor'][0]['date'] ?> </h2>
                    <h3>Consultas do Médico</h3>
                    <table id="appointments-table" class="appointments-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Médico</th>
                                <th>Especialidade</th>
                                <th>Paciente</th>
                                <th>Idade</th>
                                <th>Relatório/Exames</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultasPage as $horarios) { ?>
                                <tr>
                                    <td><?php echo $horarios['date']; ?></td>
                                    <td><?php echo $horarios['time']; ?></td>
                                    <td><?php echo $horarios['doctor_name']; ?></td>
                                    <td><?php echo $horarios['doctor_specialty']; ?></td>
                                    <td><?php echo $horarios['patient_name']; ?></td>
                                    <td><?php echo $_SESSION['patient_age']; ?></td>
                                    <td>
                                        <div class="show_hide_button">
                                            <form action="actions/action_edit_report.php" method="POST">
                                                <input type="hidden" name="appointment_id" value="<?php echo $horarios['appointment_id']; ?>">
                                                <button type="submit" class="toggle-editreport-btn">Editar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    
                    <?php if (!$_SESSION['report_empty']) { ?>

                        <h2>Relatório Escrito</h2>
                        <div class="report-container">
                            <p><?php echo $_SESSION['report_written']; ?></p>
                        </div>
                    <?php } ?>

                    <h2>Relatório</h2>

                    <!-- Campo para escrever o relatório -->
                    <form method="POST" action="actions/action_save_report.php" class="report-form">
                        <textarea name="report" id="report" rows="10" placeholder="Escreva o conteúdo do relatório aqui..."></textarea>
                        <button type="submit" class="submit-report-btn">Salvar Relatório</button>
                        <button type="button" class="returnsubmit-report-btn" onclick="window.location.href='actions/action_goback_report.php';">Retornar</button>
                    </form>

                <?php } ?>
            </fieldset>

            <!-- Navegação de Página -->
            <div id="pagination" class="pagination">
                <?php if ($page_num > 1) { ?>
                    <a href="?page_num=<?php echo $page_num - 1; ?>" class="pagination-link">&lt; Anterior</a>
                <?php } ?>

                <span class="page-number">Página <?php echo $page_num; ?> de <?php echo $totalPages; ?></span>

                <?php if ($page_num < $totalPages) { ?>
                    <a href="?page_num=<?php echo $page_num + 1; ?>" class="pagination-link">Próxima &gt;</a>
                <?php } ?>
            </div>

        <?php } ?>
    </div>
</section>
