<?php 
  if (isset($_SESSION["id_user"])){
?>

<nav class="user_page_nav">
  <ul>
    <li><a href="?page=user_page&page_account=change_info">Modifier mes informations</a></li>
    <li><a href="?page=user_page&page_account=change_password">Modifier mon mot de passe</a></li>
    <li><a href="?page=user_page&page_account=see_recommandation">Voir mes recommandations</a></li>
    <li><a href="?page=user_page&page_account=add_recommandation">Ajouter une recommandation</a></li>
    <li><a href="?page=user_page&page_account=see_announce">Voir mes annonces</a></li>
    <li><a href="?page=user_page&page_account=add_announce">Ajouter une annonce</a></li>
    <li><a href="?page=user_page&page_account=see_activity">Voir mes activités</a></li>
    <li><a href="?page=user_page&page_account=add_activity">Ajouter une activité</a></li>
  </ul>
</nav>

<?php 
  
    if(isset($_GET["message"])){
      $message = $_GET["message"];
      if($message = "booking_completed"){
        $start = $_GET["start"];
        $end = $_GET["end"];
        echo "<p>Votre demande de reservation du ".$start." au ".$end." a été envoyé.<p>";
      }
    }
    if ($page_account == "home"){
      include_once "home_user_page.php";
    }
    else if ($page_account == "change_info"){
      include_once "modif_infos_user.php";
    }
    else if ($page_account == "change_password"){
      include_once "modif_mdp_user.php";
    }
    else if ($page_account == "see_recommandation"){

    }
    else if ($page_account == "add_recommandation"){

    }
    else if ($page_account == "see_announce"){
      include_once "display_housing_announce.php";
    }
    else if ($page_account == "add_announce"){
      include_once "forms/add_housing_announce.php";
    } 
    else if ($page_account == "see_activity"){

    }
    else if ($page_account == "add_activity"){
      include_once "forms/add_activites.php";
    }  
}
?>
