
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
  if ($pageCompte = "home"){
    echo "page home du compte";
  }
  else if ($pageCompte == "ajoutAnnonce"){
    addLogement();
  }
?>
