<?php

$id_user = $_SESSION["id_user"];
$reservations = getBookByIdUser($id_user);

?>
<section>
<?php
if(!empty($reservations)){
    $cpt = 0;
    ?>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Début du séjour</th>
            <th scope="col">Fin du séjour</th>
            <th scope="col">Logement</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach($reservations as $reservation){
                ?>
                    <tr>
                    <th scope="row"><?php echo $cpt; ?></th>
                    <td><?php echo getNiceDate($reservation["date_start"]); ?></td>
                    <td><?php echo getNiceDate($reservation["date_end"]); ?></td>
                    <td><a href="?page=search_activity&resa=<?php echo $reservation["id"]; ?>">Voir les activitées proches</a></td>
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

</section>