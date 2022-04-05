<form action="index.php" method="post">
    <div>
        <input placeholder="Id de l'activite" type="int" name="id_activite" id="id_activite" required>
        <label for="id_activite">Id de l'activité</label>
    </div>



    <div>
        <input placeholder="Prix de l'activite" type="int" name="price_activite" id="price_activite" required>
        <label for="price_activite">Prix de l'activité</label>
    </div>

    <button id="submit" name="submit" value="Add_activite" type="submit">Ajouter l'activité</button>
</form>