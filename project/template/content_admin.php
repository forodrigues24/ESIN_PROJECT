<?php

function profilesearch()
{ ?>
    <section id='content_admin'>
        <form action="actions/action_search.php" class='search-form' method="post">
            <fieldset>
                <h2>Admin</h2>
                <select name="role">
                    <option>Paciente</option>
                    <option>Médico(a)</option>
                    <option>Enfermeiro(a)</option>
                    <option>Secretário(a)</option>
                </select>
                <br>
                <label for="search">Nome ou Email:</label>
                <input type="text" id="search" name="search" required>
                <div class="buttons-container">
                    <input type="submit" value="🔍">
                </div>
            </fieldset>
        </form>
    </section>

<?php 

    if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])) {
        echo "<section id='search_results'>";
        echo "<h2>Search Results:</h2>";
        
        foreach ($_SESSION['search_results'] as $result) {
            ?>
            <div class="profile-info">
            <p><strong>Nome:</strong> <?php echo $_SESSION['name']; ?></p>
            <p><strong>Idade:</strong> <?php echo $_SESSION['age']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
            <p><strong>Endereço:</strong> <?php echo $_SESSION['address']; ?></p>
            <p><strong>Telefone:</strong> <?php echo $_SESSION['phone_number']; ?></p>
            </div>
            <hr>
            <?php
        }
        echo "</section>";
        
        unset($_SESSION['search_results']);
    } elseif (isset($_SESSION['search_results']) && empty($_SESSION['search_results'])) {
        echo "<p>0 Resultados.</p>";
        unset($_SESSION['search_results']); 
    }
}
?>

