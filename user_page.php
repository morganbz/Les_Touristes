
<nav>
  <ul>
    <li><a href="?page=user_page&pageCompte=modifInfos">Modifier mes informations</a></li>
    <li><a href="?page=user_page&pageCompte=modifMDP">Modifier mon mot de passe</a></li>
    <li><a href="?page=user_page&pageCompte=voirRecommandations">Voir mes recommandations</a></li>
    <li><a href="?page=user_page&pageCompte=ajoutRecommandation">Ajouter une recommandation</a></li>
    <li><a href="?page=user_page&pageCompte=voirAnnonces">Voir mes annonces</a></li>
    <li><a href="?page=user_page&pageCompte=ajoutAnnonce">Ajouter une annonce</a></li>
  </ul>
</nav>

<?php 
  if ($pageCompte == "home"){
    echo "page home du compte";
    $test = 46;
    $test = $test + 3;
    echo $test;
  }
  else if ($pageCompte == "modifInfos"){
    echo "modif infos";
  }
  else if ($pageCompte == "modifMDP"){
    echo "modif mdp";
  }
  else if ($pageCompte == "voirRecommandations"){
    echo "voir recommandation";
  }
  else if ($pageCompte == "ajoutRecommandation"){
    include_once "add_announce.php";
  }
  else if ($pageCompte == "voirAnnonces"){
    echo "voir annonces";
  }
  else if ($pageCompte == "ajoutAnnonce"){
    include_once "add_housing_announce.php";
  }  
  var_dump ($_SESSION);
?>
