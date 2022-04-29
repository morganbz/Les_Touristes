<?php

$id_owner = $_SESSION["id_user"];
$id_housing = $_GET["id_housing"];
$housing = getHousingById($id_housing);

$demands = getAllBookAskByIdHousing($id_housing);
$cpt = 1;

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
            $nbNotes = getNbNotes($user["id"], 0);
            if($nbNotes > 0){
                $average = getAverage($user["id"], 0);
            }
            ?>
            <tr>
                <th scope="row"><?php echo $cpt; ?></th>
                <td><?php echo $demand["date_start"]; ?></td>
                <td><?php echo $demand["date_end"]; ?></td>
                <td><?php echo $demand["nb_day"]; ?></td>
                <td><?php echo $demand["price"]." €"; ?></td>
                <td><?php echo $user["mail"]; ?></td>
                <td>
                    <?php
                    if($nbNotes > 0){
                        echo $average." (".$nbNotes." notes)";
                    }
                    else{
                        echo "N/A";
                    }
                    ?>
                </td>
                <td>
                    <form action="index.php" method="post" id="form1">
                    <?php
                        echo "<input  type='hidden' name='id_housing' id='id_housing' value =".$id_housing." >";
                        echo "<input  type='hidden' name='id_user' id='id_user' value =".$demand['id_user']." >";
                        echo "<input  type='hidden' name='date_start' id='date_start' value =".$demand['date_start']." >";
                        echo "<input  type='hidden' name='date_end' id='date_end' value =".$demand['date_end']." >";
                    ?>
                        <button class="btn btn-primary" id="submit1" name="submit" value="BookHousing" type="submit">Accepter </button>
                    </form>
                </td>
            </tr>
            <?php
            $cpt++;
        }

        ?>
    </tbody>
</table>