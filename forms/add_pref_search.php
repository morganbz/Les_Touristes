<form action="index.php" method="post">

    <div>
        <input placeholder="Vacances à la mer" type="text" name="name_pref_search" id="name_pref_search" required>
        <label for="name_pref_search">Nom de la preference</label>
    </div>

    <div>
        <input placeholder="50" type="float" name="price_min_pref_search" id="price_min_pref_search" required>
        <label for="price_min_pref_search">prix minimum à la nuit (en €)</label>
    </div>

    <div>
        <input placeholder="150" type="float" name="price_max_pref_search" id="price_max_pref_search" required>
        <label for="price_max_pref_search">prix maximum à la nuit (en €)</label>
    </div>

    <div>
        <input placeholder="Marseille" type="text" name="dest_pref_search" id="dest_pref_search" required>
        <label for="dest_pref_search">Destination</label>
    </div>

    <div>
        <input placeholder="50" type="float" name="distance_pref_search" id="distance_pref_search" required>
        <label for="distance_pref_search">distance maximal (en km)</label>
    </div>

    <button id="submit" name="submit" value="add_pref_search" type="submit">Ajouter la préférence</button>
</form>