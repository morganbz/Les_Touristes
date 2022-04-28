<?php

$id_owner = $_SESSION["id_user"];
$housings = getHousingByIdOwner();

?>
<section>
<?php
    foreach($housings as $housing){
        ?>

        <div>
            <h1>><?php echo $housing["nom"] ?></h1>

        </div>

        <?php
    }

    ?>

</section>