<form action="index.php" method="post">
    <div>
        <input placeholder="Prénom" type="text" name="firstname_modification" id="firstname_modification" required>
        <label for="firstname_modification">Prénom</label>
    </div>

    <div>
        <input placeholder="Nom" type="text" name="lastname_modification" id="lastname_modification" required>
        <label for="lastname_modification">Nom</label>
    </div>

    <div>
        <input placeholder="Email" type="email" name="email_modification" id="email_modification" required>
        <label for="email_modification">Email</label>
    </div>

    <div>
        <input placeholder="Date de naissance" type="date" name="birth_date_modification" id="birth_date_modification" required>
        <label for="birth_date_modification">Date de naissance</label>
    </div>

    <div>
        <input placeholder="Numéro de téléphone" type="text" name="phone_modification" id="phone_modification" required>
        <label for="phone_modification">Numéro de Téléphone</label>
    </div>

    <div>
        <textarea placeholder="Description" name="description_modification" id="description_modification"> </textarea>
        <label for="description_modification">Description</label>
    </div>

    <button id="submit" name="submit" value="update_user_info" type="submit">Mettre à jour</button>
</form>