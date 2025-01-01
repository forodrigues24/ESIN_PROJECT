<section id='content_secretaria'>

    <!-- Caixa branca com histórico de consultas -->
    <fieldset class="schedule-form">
        <h2>Marcar Horários</h2>

        <!-- Selecionar função -->
        <form method="POST" action="actions/action_secretaria_horarios.php">


            <!-- Selecionar Data -->
            <label for="data">Escolha uma data:</label>
            <input type="date" name="data" id="data" required>
            <input type="submit" value="Pesquisar">
        </form>

    </fieldset>


    <?php if (isset($_SESSION['semHorario']) && isset($_SESSION['comHorario'])) { ?> <!-- Verifica se já foi feita uma pesquisa-->

    <fieldset class="schedule-form">
        <h2>Horários: <?php echo $_SESSION['data'] ?> </h2>

        <h3>Sem Horário Definido</h3>
        <table id="appointments-table" class="appointments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Função</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telemóvel</th>
                    <th>Data</th>
                    <th>Hora de Entrada/Saída</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($_SESSION['semHorario'] as $horarios) { ?>
                    <tr>
                        <td><?php echo $horarios['person_id']; ?></td>
                        <td><?php echo $horarios['role']; ?></td>
                        <td><?php echo $horarios['employee_name']; ?></td>
                        <td><?php echo $horarios['employee_email']; ?></td>
                        <td><?php echo $horarios['employee_phone']; ?></td>
                        <td><?php echo $_SESSION['data']; ?></td>


                        <td>
                            <div class="select-options">
                                <form action="actions/action_add_schedule.php" class='schedule_form' method="POST">
                                    <input type="hidden" name="person_id" value="<?php echo $horarios['person_id']; ?>">
                                    <!-- Primeiro select -->
                                    <select name="time_block_1" id="time-select-1">
                                        <?php
                                        // Gerar opções do select com base no $_SESSION['timestamps']
                                        foreach ($_SESSION['timestamps'] as $timestamp) {
                                            $time = $timestamp['time_block'];
                                            echo "<option value=\"$time\">$time</option>";
                                        }
                                        ?>
                                    </select>

                                    <!-- Segundo select -->
                                    <select name="time_block_2" id="time-select-2">
                                        <?php
                                        // Gerar opções do select com base no $_SESSION['timestamps']
                                        foreach ($_SESSION['timestamps'] as $timestamp) {
                                            $time = $timestamp['time_block'];
                                            echo "<option value=\"$time\">$time</option>";
                                        }
                                        ?>
                                    </select>

                                    <button type="submit" class="submit-btn">Enviar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5 class="message">
            <?php if (isset($msg)) { ?>
                <?php echo $msg ?>
            <?php } ?>
        </h5>

        <h3>Com Horário Definido</h3>
        <table id="schedule-table" class="appointments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Função</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telemóvel</th>
                    <th>Data</th>
                    <th>Hora de Entrada</th>
                    <th>Hora de Saída</th>
                    <th>Alterar Horário</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['comHorario'] as $horarios) { ?>   <!-- Secção com os horários dos trabalhadores, dando para alterar os horários-->
                    <tr>
                        <td><?php echo $horarios['person_id']; ?></td>
                        <td><?php echo $horarios['role']; ?></td>
                        <td><?php echo $horarios['employee_name']; ?></td>
                        <td><?php echo $horarios['employee_email']; ?></td>
                        <td><?php echo $horarios['employee_phone']; ?></td>
                        <td><?php echo $_SESSION['data']; ?></td>
                        <td><?php echo $horarios['Entrada']; ?></td>
                        <td><?php echo $horarios['Saida']; ?></td>
                        <td>
                            <div class="select-options">
                                <form action="actions/action_add_schedule.php" class='schedule_form' method="POST">
                                    <input type="hidden" name="person_id" value="<?php echo $horarios['person_id']; ?>">
                                    <input type="hidden" name="update_flag" value="True">

                                    <!-- Primeiro select -->
                                    <select name="time_block_1" id="time-select-1">
                                        <?php
                                        // Gerar opções do select com base no $_SESSION['timestamps']
                                        foreach ($_SESSION['timestamps'] as $timestamp) {
                                            $time = $timestamp['time_block'];
                                            echo "<option value=\"$time\">$time</option>";
                                        }
                                        ?>
                                    </select>

                                    <!-- Segundo select -->
                                    <select name="time_block_2" id="time-select-2">
                                        <?php
                                        // Gerar opções do select com base no $_SESSION['timestamps']
                                        foreach ($_SESSION['timestamps'] as $timestamp) {
                                            $time = $timestamp['time_block'];
                                            echo "<option value=\"$time\">$time</option>";
                                        }
                                        ?>
                                    </select>

                                    <button type="submit" class="submit-btn">Enviar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </fieldset>
    <?php } ?>
</section>