<?php

$id_owner = $_SESSION["id_user"];
$id_housing = $_GET["id_housing"];
$housing = getHousingById($id_housing);

$demands = getAllBookAskByIdHousing($id_housing);
$cpt = 0;

?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Début du séjour</th>
            <th scope="col">Fin du séjour</th>
            <th scope="col">nombre de jour</th>
            <th scope="col">prix total</th>
            <th scope="col">utilisateur</th>
            <th scope="col">points</th>
            <th scope="col"></th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach($demands as $demand){
            $user = getUserById($demand["id_user"]);
            ?>
            <tr>
                <th scope="row"><?php echo $cpt; ?></th>
                <td><?php echo $demand["date_start"]; ?></td>
                <td><?php echo $demand["date_end"]; ?></td>
                <td><?php echo $demand["nb_day"]; ?></td>
                <td><?php echo $demand["price"]." €"; ?></td>
                <td><?php echo $user["mail"]; ?></td>
                <td>50</td>
                <td>
                    
                </td>
            </tr>
            <?php
        }

        ?>
    </tbody>
</table>