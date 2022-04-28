<?php

$id_owner = $_SESSION["id_user"];
$housings = getHousingByIdOwner($id_owner);

?>
<section>
<?php
    foreach($housings as $housing){
        

        ?>
        <div class="d-flex justify-content-center"> <h6><?php echo $housing["nom"]; ?></h6> </div>

        <?php
        if(hasAskBooking($housing["id"])){
            ?>
            <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="?page=home" role="button">Voir demande de reservation</a>
            </div>
            <?php

        }
        ?>

        <div>
            <?php
            if(hasBooking($housing["id"])){
                $reservations = getAllBookByIdHousing($housing["id"]);
                $cpt = 0;

                ?>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Début du séjour</th>
                        <th scope="col">Fin du séjour</th>
                        <th scope="col">Utilisateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($reservations as $reservation){
                            $user = getUserById($reservation["id_user"]);
                            ?>
                            <tr>
                                <th scope="row"><?php echo $cpt; ?></th>
                                <td><?php echo $reservation["date_start"]; ?></td>
                                <td><?php echo $reservation["date_end"]; ?></td>
                                <td><?php echo $user["mail"]; ?></td>
                            </tr>
                          <?php
                          $cpt++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php

            }
            else{
                echo "pas resa";
            }
            ?>

        </div>

        <?php
    }

    ?>

</section>