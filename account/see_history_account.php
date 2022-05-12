<?php
$id_user = $_SESSION["id_user"];
$reservations = getHistoryByIdUser($id_user);
$cpt = 1;


if(!empty($reservations)){
    ?>
    <table class="table table-bordered caption-top">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Début du séjour</th>
                <th scope="col">Fin du séjour</th>
                <th scope="col">logement</th>
                <th scope="col">note donnée</th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>

        <?php

        foreach($reservations as $history){
            $has_rated = hasRatedHistory($history['id_history']);

            $housing = getHousingById($history['id_housing']);

            ?>
            <th scope="row"><?php echo $cpt; ?></th>
            <td><?php echo $history["begin_date"]; ?></td>
            <td><?php echo $history["end_date"]; ?></td>
            <td><a class = "link_announce" href="?page=user&&id_housing=<?php echo $history["id_history"]; ?>"><?php echo $housing["nom"]; ?></a></td>
            
            <td>
                <?php
                if($has_rated){
                    $rate = getRate($history['id_history']);
                    echo $rate."/5";
                }
                else{
                    ?>
                    <button class="btn btn-primary" id="submit1" name="submit" value="rate_reservation" type="submit">Noter </button>
                    <?php
                }
                ?>
            </td>



            <?php
            $cpt++;
        }

        ?>

        </tbody>
    </table>

    <?php
}
?>



?>