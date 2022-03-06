<form action="index.php" method="post">
    <div>
        <label for="firstname_modification">Prénom</label>
        <input placeholder="Prénom" type="text" name="firstname_modification" id="firstname_modification" required>
    </div>

    <div>
        <label for="lastname_modification">Nom</label>
        <input placeholder="Nom" type="text" name="lastname_modification" id="lastname_modification" required>
    </div>

    <div>
        <label for="email_modification">Email</label>
        <input placeholder="Email" type="email" name="email_modification" id="email_modification" required>
    </div>

    <div>
        <label for="birth_date_modification">Date de naissance</label>
        <input placeholder="Date de naissance" type="date" name="birth_date_modification" id="birth_date_modification" required>
    </div>

    <div>
        <label for="phone_modification">Numéro de Téléphone</label>
        <input placeholder="Numéro de téléphone" type="text" name="phone_modification" id="phone_modification" required>
    </div>

    <div>
        <label for="description_modification">Description</label>
        <textarea placeholder="Description" name="description_modification" id="description_modification"> </textarea>
    </div>

    <button id="submit" name="submit" value="update_user_info" type="submit">Mettre à jour</button>
</form>