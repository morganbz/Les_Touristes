<?php
$TYPE_HOUSING = array("Maison", "Appartement", "Chalet", "Refuge");

$TYPE_ACTIVITY = array("Randonnée", "Espace Culturel", "Restauration", "Baignade");

$TYPE_RATED = array(1 => "Logement", 2 => "Activités", 3 => "Utilisateur");

//ne marche pas sur le serveur car le français n'est pas installé
setlocale(LC_TIME, 'fr_FR.utf8','fra');
date_default_timezone_set('Europe/Paris');

//solution :
$DAY_WEEK = array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");
$MOIS = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");

?>