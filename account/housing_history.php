<?php

$housing_history  = getHousingHistoryByIdOwner($_SESSION["id_user"]);
?>
    <?php
        if (count($housing_history) == 0){
            echo "<p> Pas d'anciennes réservations </p>";
        } else {
            echo "<div>";
                    $cpt = 1;

                ?>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Début du séjour</th>
                        <th scope="col">Fin du séjour</th>
                        <th scope="col">Logement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($housing_history as $housing){
                            $id = $housing["id"];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $cpt; ?></th>
                                <td><?php echo strftime("%A %d %B %Y", strtotime($housing["begin_date"])); ?></td>
                                <td><?php echo strftime("%A %d %B %Y", strtotime($housing["end_date"])); ?></td>
                                <td><a href="?page=housing&h=<?php echo $id; ?>"><?php echo $housing["nom"]; ?></a></td>
                            </tr>
                        <?php
                        $cpt++;
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        <?php
        }


    ?>  