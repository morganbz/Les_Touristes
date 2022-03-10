 
<section>


    <form action="index.php" method="post">
        <div>
            <?php
            echo "<input placeholder='Description' type='date' name='date_start_reservation' id='date_start_reservation' value =". $_GET['date_start'] .">"
            ?>
            <label for="date_start_reservation">Date de début du sejour</label>
        </div>

        <div>
            <input placeholder="Description" type="date" name="date_end_reservation" id="date_end_reservation" value = <?php $_GET["date_end"] ?> >
            <label for="date_end_reservation">Date de fin du sejour</label>
        </div>

        <input type = "hidden" name = id_housing value = <?php $_GET["id_housing"] ?>>

        <button id="submit" name="submit" value="reservation" type="submit">Ajouter le logement</button>
    </form>
</section>