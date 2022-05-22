<?php 
  if (isset($_SESSION["id_user"])){
?>

<nav class="navbar top-0 w-100 navbar-dark navbar-expand-sm bg-dark justify-content-center">
  <ul class="navbar-nav">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mes informations
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="?page=user_page&page_account=change_info">Modifier mon profil</a></li>
        <li><a class="dropdown-item" href="?page=user_page&page_account=change_password">Modifier mon mot de passe</a></li>
        <li><a class="dropdown-item" href="?page=user_page&page_account=add_pref_search">Voir mes préférences</a></li>
      </ul>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Logements
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="?page=user_page&page_account=see_announce">Voir mes logements</a></li>
        <li><a class="dropdown-item" href="?page=user_page&page_account=see_resa">Voir les réservations</a></li>
        <li><a class="dropdown-item" href="?page=user_page&page_account=add_announce">Ajouter un logement</a></li>
      </ul>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Activtiés
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="?page=user_page&page_account=see_activity">Voir mes activités</a></li>
        <li><a class="dropdown-item" href="?page=user_page&page_account=add_activity">Ajouter une activité</a></li>
      </ul>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Voyages
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li><a class="dropdown-item" href="?page=user_page&page_account=see_resa_client">Voir mes voyages à venir</a></li>
        <li><a class="dropdown-item" href="?page=user_page&page_account=housing_history">Historique de mes réservations</a></li>
      </ul>
    </li>
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
    else if ($page_account == "see_asking"){
      include_once "asking_view.php";
    }/*
    else if ($page_account == "see_recommandation"){

    }
    else if ($page_account == "add_recommandation"){

    }*/
    else if ($page_account == "see_announce"){
      include_once "display_housing_announce.php";
    }
    else if ($page_account == "add_announce"){
      include_once "forms/add_housing_announce.php";
    } 
    else if ($page_account == "see_activity"){
      include_once "display_activity.php";
    }
    else if ($page_account == "add_activity"){
      include_once "forms/add_activites.php";
    }
    else if ($page_account == "see_ask_resa"){
      include_once "account/see_ask_resa.php";
    }
    else if ($page_account == "see_resa"){
      include_once "account/see_resa.php";
    }else if ($page_account == "housing_history"){
      displayHousingHistory($_SESSION["id_user"], true);
    }
    else if($page_account == "add_pref_search"){
      include_once "forms/add_pref_search.php";
    }
    else if($page_account == "see_resa_client"){
      include_once "account/see_resa_client.php";
    }

  } else {
    include_once "./page_404.php";
  }
?>
