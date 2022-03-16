<?php 
  if (isset($_SESSION["id_user"])){
?>

<nav class="user_page_nav">
  <ul>
    <li><a href="?page=user_page&pageCompte=modifInfos">Modifier mes informations</a></li>
    <li><a href="?page=user_page&pageCompte=modifMDP">Modifier mon mot de passe</a></li>
    <li><a href="?page=user_page&pageCompte=voirRecommandations">Voir mes recommandations</a></li>
    <li><a href="?page=user_page&pageCompte=ajoutRecommandation">Ajouter une recommandation</a></li>
    <li><a href="?page=user_page&pageCompte=voirAnnonces">Voir mes annonces</a></li>
    <li><a href="?page=user_page&pageCompte=ajoutAnnonce">Ajouter une annonce</a></li>
    <li><a href="?page=user_page&pageCompte=voirActivites">Voir mes activités</a></li>
    <li><a href="?page=user_page&pageCompte=ajoutActivite">Ajouter une activité</a></li>
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
    if ($pageCompte == "home"){
      include_once "home_user_page.php";
    }
    else if ($pageCompte == "modifInfos"){
      include_once "modif_infos_user.php";
    }
    else if ($pageCompte == "modifMDP"){
      include_once "modif_mdp_user.php";
    }
    else if ($pageCompte == "voirRecommandations"){
      echo "voir recommandation";
    }
    else if ($pageCompte == "ajoutRecommandation"){
      include_once "add_announce.php";
    }
    else if ($pageCompte == "voirAnnonces"){
      include_once "display_housing_announce.php";
    }
    else if ($pageCompte == "ajoutAnnonce"){
      include_once "add_housing_announce.php";
    } 
    /*else if ($pageCompte == "voirActivites"){
      include_once "display_activites.php";
    } */ 
    else if ($pageCompte == "ajoutActivite"){
      include_once "add_activites.php";
    }  
}
?>
