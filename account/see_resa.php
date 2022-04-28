<?php

$id_owner = $_SESSION["id_user"];
$housings = getHousingByIdOwner($id_owner);

?>
<section>
<?php
    foreach($housings as $housing){
        ?>

        <div>
            <h5><?php echo $housing["nom"]; ?></h5>

        </div>

        <?php
    }

    ?>

</section>