<?php

$preferences = getPreferenceByIdUser($_SESSION['id_user']);
$cpt = 1;

if(!empty($preferences)){
    ?>
    <div>

    <h4>Mes Préférences</h4>

    <table class="table table-striped table-hover">
    <thead>
        <tr>
        <th class="text-center" scope="col">#</th>
        <th class="text-center" scope="col">Nom</th>
        <th class="text-center" scope="col">Destination</th>
        <th class="text-center" scope="col">Distance</th>
        <th class="text-center" scope="col">Prix minimum à la nuit</th>
        <th class="text-center" scope="col">Prix maximum à la nuit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($preferences as $preference){
            ?>

            <tr>
                <th scope="row"><?php echo $cpt; ?></th>
                <td class="text-center"><?php echo $preference['nom']; ?></td>
                <td class="text-center"><?php echo $preference['destination']; ?></td>
                <td class="text-center"><?php echo $preference['distance']; ?></td>
                <td class="text-center"><?php echo $preference['price_min'] . "€"; ?></td>
                <td class="text-center"><?php echo $preference['price_max'] . "€"; ?></td>
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
//<div ">
?>

<div class="container h-100" style="width:60%;">
    <div class="align-items-center m-3 display-form-bg">
        <div class="col-lg-15" >
            <div class="about-text go-to">
                <h4 class="dark-color h2"><strong>Ajouter une préférence</strong></h4> 

                <form action="index.php" method="post">

                    <div class="col mb-3">
                        <div class="form-floating">
                            <input placeholder="Vacances à la mer" class="form-control" type="text" name="name_pref_search" id="name_pref_search" required>
                            <label for="name_pref_search" class="form-label">Nom de la preference</label>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col">
                            <div class="form-floating">
                                <input placeholder="Marseille" type="text" class="form-control" name="dest_pref_search" id="dest_pref_search" required>
                                <label for="dest_pref_search" class="form-label">Destination</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <input placeholder="50" type="float" class="form-control" name="distance_pref_search" id="distance_pref_search" required>
                                <label for="distance_pref_search" class="form-label">distance maximal (en km)</label>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col">
                            <div class="form-floating">
                                <input placeholder="50" type="float" class="form-control" name="price_min_pref_search" id="price_min_pref_search" required>
                                <label for="price_min_pref_search" class="form-label">prix minimum à la nuit (en €)</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <input placeholder="150" type="float" class="form-control" name="price_max_pref_search" id="price_max_pref_search" required>
                                <label for="price_max_pref_search" class="form-label">prix maximum à la nuit (en €)</label>
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-outline-primary" id="submit" name="submit" value="add_pref_search" type="submit" class="w-100 btn btn-primary btn-lg px-4 me-sm-3">Ajouter la préférence</button>
                </form>
            </div>
        </div>
    </div>
</div>