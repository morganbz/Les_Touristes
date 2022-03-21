<?php

$id_owner = $_SESSION["id_user"];

$data = getAllBookAskByIdOwner($id_owner);

displayAskReservation($data);

?>