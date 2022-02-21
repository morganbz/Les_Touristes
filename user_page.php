
<nav>
  <ul>
    <li><a href="?page=compte&pageCompte=modifInfos">Modifier mes informations</a></li>
    <li><a href="?page=compte&pageCompte=modifMDP">Modifier mon mot de passe</a></li>
    <li><a href="?page=compte&pageCompte=voirRecommandations">Voir mes recommandations</a></li>
    <li><a href="?page=compte&pageCompte=ajoutRecommandation">Ajouter une recommandation</a></li>
    <li><a href="?page=compte&pageCompte=voirAnnonces">Voir mes annonces</a></li>
    <li><a href="?page=compte&pageCompte=ajoutAnnonce">Ajouter une annonce</a></li>
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
