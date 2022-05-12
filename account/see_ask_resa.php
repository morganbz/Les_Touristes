<?php

$id_owner = $_SESSION["id_user"];
$id_housing = $_GET["id_housing"];
$housing = getHousingById($id_housing);

$first_demands = getAllBookAskByIdHousing($id_housing);
$conflicts = getConflict($first_demands);
$nb_conflits = 1;

foreach($conflicts as $demands){
    $caption = "";
    $is_conflict = false;
    $cpt = 1;

    if(!($demands == end($conflicts))){
        $caption = "Conflit n°". $nb_conflits;
        $is_conflict = true;
    }
    else{
        $caption = "Sans conflits";
    }



    ?>

    <?php
    if(!empty($demands)){

        ?>

        <table class="table table-bordered caption-top">
            <?php 
            if($is_conflict){
                echo "<caption class = 'text-danger'>";
            }
            else{
                echo "<caption>";
            }
            ?>
                <?php echo $caption; ?>
            </caption>
            <thead class="table-dark">
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Début du séjour</th>
                    <th scope="col">Fin du séjour</th>
                    <th scope="col">nombre de jour</th>
                    <th scope="col">prix total</th>
                    <th scope="col">utilisateur</th>
                    <th scope="col">note</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php
                foreach($demands as $demand){
                    $user = getUserById($demand["id_user"]);
                    $nbNotes = getNbNotes($user["id"], 3);
                    if($nbNotes > 0){
                        $average = getAverage($user["id"], 3);
                    }
                    ?>
                    <tr>
                        <th scope="row"><?php echo $cpt; ?></th>
                        <td><?php echo getNiceDate($demand["date_start"]); ?></td>
                        <td><?php echo getNiceDate($demand["date_end"]); ?></td>
                        <td><?php echo $demand["nb_day"]; ?></td>
                        <td><?php echo $demand["price"]." €"; ?></td>
                        <td><a class = "link_announce" href="?page=user&u=<?php echo $user["id"]; ?>"><?php echo $user["mail"]; ?></a></td>
                        <td>
                            <?php
                            if($nbNotes > 0){
                                if($nbNotes == 1){
                                    echo $average."/5 (".$nbNotes." note)";
                                } else {
                                    echo $average."/5 (".$nbNotes." notes)";
                                }
                            }
                            else{
                                echo "N/A";
                            }
                            ?>
                        </td>
                        <?php
                        if($is_conflict){
                            ?>
                                    <td>
                                        <button class="btn btn-primary modal-button" href ="#myModal<?php echo $demand['id_reservation']; ?>" >Accepter</button>
                                    </td>
                                </tr>

                                <div class="modal" id="myModal<?php echo $demand['id_reservation']; ?>">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Accepter cette réservation entrainera la suppression des autres demandes en conflit avec celle-ci.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary annuler" data-bs-dismiss="modal">Annuler</button>
                                            <form action="index.php" method="post" id="form1">
                                            <?php
                                                echo "<input  type='hidden' name='id_housing' id='id_housing' value =".$id_housing." >";
                                                echo "<input  type='hidden' name='id_user' id='id_user' value =".$demand['id_user']." >";
                                                echo "<input  type='hidden' name='date_start' id='date_start' value =".$demand['date_start']." >";
                                                echo "<input  type='hidden' name='date_end' id='date_end' value =".$demand['date_end']." >";
                                            ?>
                                                <button class="btn btn-primary" id="submit1" name="submit" value="BookHousing" type="submit">Confirmer</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                        else{
                            ?>
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
                        }
                        ?>

                    <div class="modal" id="myModal<?php echo $demand['id_reservation']; ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Accepter cette réservation entrainera la suppression des autres demandes en conflit avec celle-ci.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary annuler" data-bs-dismiss="modal">Annuler</button>
                                <form action="index.php" method="post" id="form1">
                                <?php
                                    echo "<input  type='hidden' name='id_housing' id='id_housing' value =".$id_housing." >";
                                    echo "<input  type='hidden' name='id_user' id='id_user' value =".$demand['id_user']." >";
                                    echo "<input  type='hidden' name='date_start' id='date_start' value =".$demand['date_start']." >";
                                    echo "<input  type='hidden' name='date_end' id='date_end' value =".$demand['date_end']." >";
                                ?>
                                    <button class="btn btn-primary" id="submit1" name="submit" value="BookHousing" type="submit">Confirmer</button>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $cpt++;
                }

                ?>
            </tbody>
        </table>


    <?php
    }
    $nb_conflits++;

}
?>

<script>

    var btn = document.querySelectorAll("button.modal-button");

    // All page modals
    var modals = document.querySelectorAll('.modal');

    // Get the <span> element that closes the modal
    var spans = document.getElementsByClassName("btn-close");

    // Get the annuler button element that closes the modal
    var annuler_button = document.getElementsByClassName("annuler");

    // When the user clicks the button, open the modal
    for (var i = 0; i < btn.length; i++) {
        btn[i].onclick = function(e) {
            e.preventDefault();
            modal = document.querySelector(e.target.getAttribute("href"));
            modal.style.display = "block";
        }
    }

    // When the user clicks on <span> (x), close the modal
    for (var i = 0; i < spans.length; i++) {
        spans[i].onclick = function() {
            for (var index in modals) {
            if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
            }
        }
    }

    for (var i = 0; i < annuler_button.length; i++) {
        annuler_button[i].onclick = function() {
            for (var index in modals) {
            if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
            }
        }
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
        for (var index in modals) {
        if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
        }
        }
    }

</script>