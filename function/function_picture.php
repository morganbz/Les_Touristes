<?php

function createFolder($folder){
    if (!file_exists($folder)){
        mkdir($folder, 0777, true);
    }    
}

function uploadImg($dossier){
    global $base;

    $errors = [];

    if (isset($_FILES)){
        $tmpName = $_FILES["modification_image"]['tmp_name'];
        $typefile = $_FILES["modification_image"]['type'];
        $name = $_FILES["modification_image"]['name'];
        $size = $_FILES["modification_image"]['size'];
        $error = $_FILES["modification_image"]['error'];

        $cheminDossier = "./picture_housing/".$dossier."/".$name;

        $extensionFichier = strtolower(basename($typefile));

        $extensionAcceptee = ['jpg', 'jpeg','png'];

        if(file_exists($cheminDossier)){
            $name = $name."_copy";
            $cheminDossier = "./picture_housing/".$dossier."/".$name;
        }

        if (!(in_array($extensionFichier, $extensionAcceptee))){
            $errors[] = "Veuillez choisir une image valide (JPG ou PNG)";
        }

        if ($size > 2000000){
            $errors[] = "Taille de l'image trop grosse (maximum 2Mo)";
        }

        if ($error != 0){
            $errors[] = "Nous avons rencontré une erreur lors du téléchargement de votre fichier";
        }

        if(count($errors) > 0){
            $_SESSION["errors_modification_image"] = $errors;
            $page = "user_page";
            $pageCompte = "voirAnnonces";
        } else {
            move_uploaded_file($tmpName, $cheminDossier);
            unset($_SESSION["errors_modification_image"]);
        }

        if ($base->connect_error) {
            die("Connection failed: " . $base->connect_error);
        }
    }
}

?>