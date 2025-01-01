<section id='content_consultas'>
    <div>
        <!-- Secção de pesquisa-->
        <fieldset class="schedule-form">
            <h2>Procurar Perfil</h2>
            <!-- Secção para pesquisar as pessoas de uma certa função-->

            <form action="actions/action_search.php" method="post">
                <div class="box_search">
                    <select name="role" class="custom-select">
                        <option value="patient">Todos</option>
                        <option value="doctor">Médico(a)</option>
                        <option value="nurse">Enfermeiro(a)</option>
                        <option value="secretary">Secretário(a)</option>
                        <option value="admin">Admin</option>
                    </select>
                    <br>
                    <div class="search-container">
                        <input type="submit" id="search-button" value="🔍">
                    </div>
                </div>
            </form>
            <!-- Secção para pesquisar por email-->

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
            </div>

        </fieldset>
        
        <!-- Secção para mostrar os resultados-->

        <?php if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])) { ?>
            <fieldset class="schedule-form">
                <h2>Resultados da Pesquisa</h2>

                <?php

                // Paginação feita de forma diferente daquela ensinada na aula- Não usa LIMIT nem OFFSET- Mesmo resultado

                // Definindo o número de itens por página
                $itemsPerPage = 5; 
                // Verificando o número da página atual, se não estiver definido, começa na página 1
                $page_num = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1; 
                // Total de resultados encontrados
                $totalResults = count($_SESSION['search_results']);
                // Calculando o total de páginas
                $totalPages = ceil($totalResults / $itemsPerPage); 
                // Calculando o início da página
                $start = ($page_num - 1) * $itemsPerPage;

                // Pegando apenas os resultados da página atual
                $resultsPage = array_slice($_SESSION['search_results'], $start, $itemsPerPage);
                ?>

                <table class="search-results-table">
                    <thead>
                        <tr>
                            <th>ID</th>
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
                        foreach ($resultsPage as $result) {
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
                                                <option value="removerole"> Retirar role </option>
                                                <option value="doctor" <?php echo $result['role'] == 'doctor' ? 'selected' : ''; ?>>Médico(a)</option>
                                                <option value="nurse" <?php echo $result['role'] == 'nurse' ? 'selected' : ''; ?>>Enfermeiro(a)</option>
                                                <option value="secretary" <?php echo $result['role'] == 'secretary' ? 'selected' : ''; ?>>Secretário(a)</option>
                                                <option value="admin" <?php echo $result['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            </select>

                                            <input type="hidden" name="person_id" value="<?php echo $result['person_id']; ?>">
                                            <input type="hidden" name="person_role" value="<?php echo $result['role']; ?>">

                                            <label for="start-contract">Contrato:</label>
                                            <input type="date" id="start-contract" name="start_contract" value="<?php echo $result['start_contract'] ?? ''; ?>">

                                            <label for="end-contract"></label>
                                            <input type="date" id="end-contract" name="end_contract" value="<?php echo $result['end_contract'] ?? ''; ?>">
                                            <select name="speciality">
                                                <option value="none">Nenhum</option>
                                                <option value="cardiology">Cardiologia</option>
                                                <option value="orthopedy">Ortopedia</option>
                                                <option value="pediatrics">Pediatria</option>
                                            </select>

                                            <button type="submit" id="update-button">Atualizar</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

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

            </fieldset>
        <?php } ?>
    </div>
</section>
