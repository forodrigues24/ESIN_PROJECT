
    <section id='content_profile'>

        <!-- Caixa branca com histórico de consultas -->
        <fieldset class="changedata-form">
            <h2>Marcar Horários</h2>

            <!-- Selecionar função -->
            <form method="POST" action="actions/action_secretaria_horarios.php">
                <label for="funcao">Escolha uma função:</label>
                <select name="funcao" id="funcao">
                    <option value="">-- Selecione --</option>
                    <option value="Doctor">Doutor(a)</option>
                    <option value="Nurse">Enfermeiro(a)</option>
                    <option value="LabTech">Técnico(a)</option>
                </select>

                <!-- Selecionar Data -->
                <label for="data">Escolha uma data:</label>
                <input type="date" name="data" id="data" required>

                <input type="submit" value="Pesquisar">
            </form>

        </fieldset>

    </section>
