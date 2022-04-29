<?php
$id_housing = $_GET["id_housing"];
$announces = getAnnounceGrpNbByIdHousing($id_housing);

if(count($announces) > 0){
    $cpt = 1;
    ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Début du créneau</th>
                <th scope="col">Fin du créneau</th>
                <th scope="col">nombre de jour disponible</th>
                <th scope="col">prix à la nuit</th>
            </tr>
        </thead>

        <tbody>
        <?php
            foreach($announces as $announce){
                ?>
                <tr>
                <th scope="row"><?php echo $cpt; ?></th>
                    <td><?php echo $announce['date_start']; ?></td>
                    <td><?php echo $announce['date_end']; ?></td>
                    <td><?php echo $announce['nb_day']; ?></td>
                    <td><?php echo $announce["price"]." €"; ?></td>
                </tr>

                <?php
                $cpt++;
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>

<div id ="housing_booking">
    <form class = "d-flex flex-column justify-content-center" action="index.php" method="post">

        <div class="form-floating w-30">
            <input class = "form-control" placeholder="date de début" type="date" name="date_start" id="date_start" required>
            <label class="form-label" for="date_start_update">date de début</label>
        </div>

        <div class="form-floating w-30">
            <input class = "form-control" placeholder="date de fin" type="date" name="date_end" id="date_end" required>
            <label class="form-label" for="date_start_update">date de fin</label>
        </div>

        <input type="hidden" name="id_housing" id="id_housing" value = <?php echo $id_housing; ?> required>


        <button class="btn btn-primary btn-lg w-30" id="submit" name="submit" value="add_announce_period" type="submit">Ajouter la periode</button>
    </form>
</div>

