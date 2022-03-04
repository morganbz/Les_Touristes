<form action="index.php" method="post">
    <div>
        <input placeholder="Prénom" type="text" name="firstname_register" id="firstname_register" required>
        <label for="firstname_register">Prénom</label>
    </div>

    <div>
        <input placeholder="Nom"type="text" name="lastname_register" id="lastname_register" required>
        <label for="lastname_register">Nom</label>
    </div>

    <div>
        <input placeholder="E-mail" type="text" name="mail_register" id="mail_register" required>
        <label for="mail_register">E-mail</label>
    </div>

    <div>
        <input placeholder="Numéro de téléphone" type="text" name="phone_register" id="phone_register" required>
        <label for="phone_register">Numéro de Téléphone</label>
    </div>

    <div>
        <input placeholder="Mot de Passe" type="password" name="pass_register" id="pass_register" minlenght="8" required>
        <label for="pass_register">Mot de Passe</label>
    </div>

    <div>
        <input placeholder="Confirmer Mot de Passe" type="password" name="conf_pass_register" id="conf_pass_register" minlenght="8" required>
        <label for="conf_pass_register">Confirmer Mot de Passe</label>
    </div>

    <div>
        <input placeholder="Date de naissance" type="date" name="birth_date_register" id="birth_date_register" required>
        <label for="birth_date_register">Date de naissance</label>
    </div>

    <div>
        <label>
            <input type="checkbox" value="1" name="admin_register" id="admin_register"> Admin
        </label>
    </div>

    <button id="submit" name="submit" value="Register" type="submit">Inscription</button>
</form>

