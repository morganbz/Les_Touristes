<form action="index.php" method="post">
    <div>
        <input placeholder="@mail" type="text" name="mail_user" id="mail" required>
        <label for="user_name">@mail</label>
    </div>

    <div>
        <input placeholder="Mot de passe" type="password" name="passWord" id="password" required>
        <label for="passWord">Mot de passe</label>
    </div>

    <button id="submit" name="submit" value="Login" type="submit">Connection</button>
</form>

<?php
    if (isset($_SESSION["errors_login"])){
        echo "<p class='error'>Erreurs lors de la connexion :</p>";
        echo "<ul>";
        foreach($_SESSION["errors_login"] as $error_register)
            echo "<li class='error'>$error_register</li>";
        echo "</ul>";
    }
?>