<?php 
function addLogement(){
?>
<h2>Ajouter un logement</h2>
<form action="index.php" method="post">
  <div>
    <label for="nomLogementForm">Nom du logement</label>
    <input id="nomLogementForm" type="text"></input>
  </div>
  <div>
    <label for="typeLogementForm">Type de logement</label>
    <input id="typeLogementForm" type="text"></input>
  </div>
  <div>
    <label for="adresseLogementForm">Adresse du logement</label>
    <input id="adresseLogementForm" type="text"></input>
  </div>
  <div>
    <label for="descriptionLogementForm">Description</label>
    <textarea id="descriptionLogementForm">Services fournis, nombre de couchages, ...</textarea>
  </div>
</form>

<?php
}
?>
