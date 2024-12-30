<section id='content_profile'>
    <div>
        
        <fieldset class="perfil">
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

        <?php

        // Paginação feita de forma diferente da do professor das aulas
        $itemsPerPage = 5; 
        $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1; 
        $totalAppointments = count($_SESSION['appointments']); 
        $totalPages = ceil($totalAppointments / $itemsPerPage); 
        $start = ($page_num - 1) * $itemsPerPage; 

        $appointmentsPage = array_slice($_SESSION['appointments'], $start, $itemsPerPage);
        ?>
        <fieldset class="perfil">
            <?php if (!empty($appointmentsPage)) { // Corrigido o sinal de comparação 
            ?>
                <h2>Histórico de Consultas</h2>

                <?php if (!empty($appointmentsPage)) { ?>
                    <table id="appointments-table" class="appointments-table">
                        <thead>
                            <tr>
                                <th>Médico</th>
                                <th>Enfermeiro</th>
                                <th>Dia</th>
                                <th>Horário</th>
                                <th>Relatório</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointmentsPage as $appointment) { ?>
                                <tr>
                                    <td><?php echo $appointment['Doutor']; ?></td>
                                    <td><?php echo $appointment['Enfermeiro']; ?></td>
                                    <td><?php echo $appointment['Data da Consulta']; ?></td>
                                    <td><?php echo $appointment['Hora']; ?></td>
                                    <td>
                                        <div class="report_grid">
                                            <div class="grid-item">
                                                <?php
                                                if (isset($_SESSION['selected_appointments']) && is_array($_SESSION['selected_appointments']) && in_array($appointment['appointment_id'], $_SESSION['selected_appointments'])) {
                                                    echo "<p>{$appointment['Relatório']}</p>";
                                                } else {
                                                    echo '<p id="show-report-message">Clique para mostrar relatório completo</p>';
                                                }
                                                ?>
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

                    <!-- Navegação de Página -->
                    <div id="pagination" class="pagination">
                        <?php if ($page_num > 1) { ?>
                            <a href="<?php echo $current_file; ?>?page_num=<?php echo $page_num - 1; ?>" class="pagination-link">&lt; Anterior</a>
                        <?php } ?>

                        <span class="page-number">Página <?php echo $page_num; ?> de <?php echo $totalPages; ?></span>

                        <?php if ($page_num < $totalPages) { ?>
                            <a href="<?php echo $current_file; ?>?page_num=<?php echo $page_num + 1; ?>" class="pagination-link">Próxima &gt;</a>
                        <?php } ?>
                    </div>

                <?php } else { ?>
                    <p>Você ainda não possui consultas registradas.</p>
                <?php } ?>
            <?php } if(($_SESSION['role_user'] !== 'patient')) { ?>
                <h2>Horário</h2>
                <form method="POST" action="actions/action_get_schedule.php">
                    <label for="data">Escolha uma data:</label>
                    <input type="date" name="data" id="data" required>
                    <div class="button-group-edit">
                        <input type="submit" value="Pesquisar">
                        <h5 class="message">
                            <?php if (isset($msg2)) { ?>
                                <?php echo $msg2 ?>
                            <?php } ?>
                        </h5>
                    </div>
                </form>
                <?php
                // Verifica se a sessão contém os dados de horário e exibe os horários
                if (isset($_SESSION['horario']) && $_SESSION['horario'][0]['Entrada'] !== null) {
                    echo "<div class='horario-info'>";
                    echo "<h3>Entrada: " . $_SESSION['horario'][0]['Entrada'] . "</p>";
                    echo "<h3>Saída: " . $_SESSION['horario'][0]['Saida'] . "</p>";
                    echo "</div>";
                } ?>

            <?php } ?>
        </fieldset>
    </div>
</section>