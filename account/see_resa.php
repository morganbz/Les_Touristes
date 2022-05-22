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
            <div class = "display-form-bg marg_resa">
            <div class="d-flex justify-content-evenly">
                <div><h4><a class = "lien_logement" href="?page=ask_reservation&id_housing=<?php echo $housing["id"]; ?>"><?php echo $housing["nom"]; ?></a></h4></div>

                <?php
                if($hasAskBook){
                    ?>
                    <div>
                    
                    <?php
                    echo "<a class='btn btn-outline-primary' href='?page=user_page&page_account=see_ask_resa&id_housing=".$housing['id']."' role='button'>Voir demande de reservation</a>"
                    ?>
                    </div>
                    <?php

                }
                ?>
                </div>

            <div>
                <?php
                if($hasBook){
                    $reservations = getAllBookByIdHousing($housing["id"]);
                    $cpt = 1;

                    ?>
                     <table class="table table-bordered caption-top">
                        <thead class="tableau_couleur">
                            <tr class="text-center">
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
                                    <td><?php echo getNiceDate($reservation["date_start"]); ?></td>
                                    <td><?php echo getNiceDate($reservation["date_end"]); ?></td>
                                    <td><a class = "lien_logement" href="?page=user&u=<?php echo $reservation["id_user"]; ?>"><?php echo $user["mail"]; ?></a></td>
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
                    ?>
                    <p>Il n'y a pas de reservations pour ce logement.</p>
                    <?php
                }
                ?>

            </div>
            </div>

            <?php
        }
    }
    ?>

</section>