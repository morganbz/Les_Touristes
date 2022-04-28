<?php

$id_owner = $_SESSION["id_user"];
$id_housing = $_GET["id_housing"];
$housing = getHousingById($id_housing);

$demands = getAllBookAskByIdHousing($id_housing);

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
            <th scope="col"></th>
        </tr>
    </thead>

    <tbody>
        <?php

        ?>
    </tbody>
</table>