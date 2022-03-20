<form action="index.php" method="post">
    <div>
        <label for="pass_modif">Mot de Passe</label>
        <input placeholder="Mot de Passe" type="password" name="pass_modif" id="pass_modif" minlenght="8" required>
    </div>

    <div>
        <label for="conf_pass_modif">Confirmer Mot de Passe</label>
        <input placeholder="Confirmer Mot de Passe" type="password" name="conf_pass_modif" id="conf_pass_modif" minlenght="8" required>
    </div>
    
    <button id="submit" name="submit" value="modification_pass_user" type="submit">Modifier le mot de passe</button>
</form>

<?php
    if (isset($_SESSION["errors_modification_pass"])){
        echo "<p class='error'>Erreurs lors de la création de compte :</p>";
        echo "<ul>";
        foreach($_SESSION["errors_modification_pass"] as $error_modification_pass)
            echo "<li class='error'>$error_modification_pass</li>";
        echo "</ul>";
    }
?>