<section id='content_consultas'>

    <!-- Caixa branca com histórico de consultas -->
    <div>
        <fieldset class="horarios">
            <h2>Marcar Consultas</h2>

            <!-- Selecionar função -->
            <form method="POST" action="actions/action_paciente.php">
                <label for="data">Escolha uma data:</label>
                <input type="date" name="data" id="data" required>

                <label for="especialidade">Escolha uma especialidade:</label>
                <select name="especialidade" id="especialidade" required>
                    <option value="cardiology">Cardiologia</option>
                    <option value="orthopedy">Ortopedia</option>
                    <option value="pediatrics">Pediatria</option>
                </select>
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

        <?php if (isset($_SESSION['horarios_possiveis']) && !empty($_SESSION['horarios_possiveis'])) { ?>
            <fieldset class="consultas">
                <?php
                // Itera sobre o array de horários possíveis
                foreach ($_SESSION['horarios_possiveis'] as $medico_id => $medico) { ?>
                    <form method="POST" class="medico-form" action="actions/action_marcar_consulta.php">
                        <h3>Dr(a). <?php echo $medico['nome']; ?> (Especialidade: <?php echo $medico['especialidade']; ?>)</h3>
                        <label for="horario_<?php echo $medico_id; ?>">Escolha um horário:</label>
                        <select name="horario[<?php echo $medico_id; ?>]" id="horario_<?php echo $medico_id; ?>">
                            <option value="">Selecione...</option>
                            <?php
                            $medico['horarios_possiveis'] = array_unique($medico['horarios_possiveis']);

                            foreach ($medico['horarios_possiveis'] as $horario) { ?>
                                <option value="<?php echo $horario; ?>"><?php echo $horario; ?></option>
                            <?php } ?>
                        </select>
                        <div class="submit-container">
                            <input type="submit" value="Agendar para Dr(a). <?php echo $medico['nome']; ?>">
                        </div>
                    </form> <!-- Fecha formulário para cada médico -->
            <?php }
            }
            ?>
            </fieldset>
    </div>


</section>