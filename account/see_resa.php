<?php

$id_owner = $_SESSION["id_user"];
$housings = getHousingByIdOwner($id_owner);

?>
<section>
<?php
    foreach($housings as $housing){
        $hasBook = hasBooking($housing["id"]);
        $hasAskBook = hasAskBooking($housing["id"]);

        if($hasBook || $hasAskBook){

            ?>
            <div class="d-flex justify-content-center"> <h4><?php echo $housing["nom"]; ?></h4> </div>

            <?php
            if($hasAskBook){
                ?>
                <div class="d-flex justify-content-end">
                
                <?php
                echo "<a class='btn btn-primary' href='?page=?page=user_page&page_account=see_ask_resa&id_housing=".$housing['id']."' role='button'>Voir demande de reservation</a>"
                ?>
                </div>
                <?php

            }
            ?>

            <div>
                <?php
                if($hasBook){
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
    }

    ?>

</section>