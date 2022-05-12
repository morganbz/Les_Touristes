<?php
$TYPE_HOUSING = array("Maison", "Appartement", "Chalet", "Refuge");

$TYPE_ACTIVITY = array("Randonnée", "Espace Culturel", "Restauration", "Baignade");

$TYPE_RATED = array(1 => "Logement", 2 => "Activités", 3 => "Utilisateur");

define('HOUSING_ORDER', 'id_housing');
define('DATE_ORDER', 'begin_date');

$ORDER = array(array("nom" => "Date", "value" => DATE_ORDER), array("nom" => "Logement", "value" => HOUSING_ORDER));

//ne marche pas sur le serveur car le français n'est pas installé
setlocale(LC_TIME, 'fr_FR.utf8','fra');
date_default_timezone_set('Europe/Paris');

//solution :
$DAY_WEEK = array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");
$MOIS = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");

?>