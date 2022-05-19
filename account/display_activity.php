<?php


$listeActivity  = getActivityByIdOwner($_SESSION["id_user"]);

?>
    <ul class="list-group list-group-flush">
    <?php

        foreach ($listeActivity as $activity){

            $nom = $activity['nom'];
            $latitude = $activity['latitude'];
            $longitude = $activity['longitude'];
            $description = $activity['description'];
            $type = $activity['type'];

            $adresse = getAddress($latitude, $longitude);

            $id = $activity['id'];


            displayActivityAccount($activity);

        }

    ?>  
    </ul>