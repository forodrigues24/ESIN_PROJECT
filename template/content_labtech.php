<section id='content_profile'>
    <!-- Caixa branca com histórico de exames -->
    <fieldset class="changedata-form">
        <h2>Exames:</h2>
        <?php
        // Verifica se há exames na sessão
        if (!empty($_SESSION['exams'])) {
            // Exibe o número total de exanes
            $totalAppointments = count($_SESSION['exams']);

        ?>
        <table id="exams-table" class="exams-table">
            <thead>
                <tr>
                    <th>ID de Exame</th>
                    <th>Laboratório</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Enfermeiro</th>
                    <th>Data do exame</th>
                    <th>Horário do exame</th>
                 </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['exams'] as $exam) { ?>
                    <tr>
                        <td><?php echo $exam['exam_id']; ?></td>
                        <td><?php echo $exam['lab']; ?></td>
                        <td><?php echo $exam['pacient']; ?></td>
                        <td><?php echo $exam['doctor']; ?></td>
                        <td><?php echo $exam['nurse']; ?></td>
                        <td><?php echo $exam['exam_date']; ?></td>
                        <td><?php echo $exam['exam_schedule']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        } else {
            // Exibe mensagem se não houver consultas
            echo '<p>Você ainda não possui exames registrados.</p>';
        }
        ?>
    </fieldset>
</section>