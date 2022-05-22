<label for="order">Trier par :</label>
<select name = 'order' id="order" onchange="window.location.href = (!(window.location.href.includes('&order='))) ? window.location.href.concat(this.value) : (window.location.href).substr(0, (window.location.href).indexOf('&order=')).concat(this.value)">
<?php
foreach($ORDER as $order){
    if (isset($_GET["order"])){
        if ($order["value"] == $_GET["order"]){
            ?><option value = '&order=<?php echo $order['value']; ?>' selected><?php echo $order['nom']; ?></option><?php
        } else {
            ?><option value = '&order=<?php echo $order['value']; ?>'><?php echo $order['nom']; ?></option><?php
        }
    } else {
        ?><option value = '&order=<?php echo $order['value']; ?>'><?php echo $order['nom']; ?></option><?php
    }
    
}
echo "</select>";
if (isset($_GET["order"])){
    $housing_history = getHousingHistoryByIdOwner($_SESSION["id_user"], $_GET["order"]);
} else {
    $housing_history = getHousingHistoryByIdOwner($_SESSION["id_user"]);
}

?>
    <?php
        if (count($housing_history) == 0){
            echo "<p> Pas d'anciennes réservations </p>";
        } else {
            echo "<div>";
                    $cpt = 1;

                ?>
                <div class = "display-form-bg mb-4">
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
                                    <td><?php echo getNiceDate($housing["begin_date"]); ?></td>
                                    <td><?php echo getNiceDate($housing["end_date"]); ?></td>
                                    <td><a href="?page=housing&h=<?php echo $id; ?>"><?php echo $housing["nom"]; ?></a></td>
                                </tr>
                            <?php
                            $cpt++;
                            }
                            ?>
                        </tbody>
                    </table>
                        </div>

            </div>
        <?php
        }


    ?>  