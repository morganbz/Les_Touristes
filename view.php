<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Touristes</title>
</head>
<body>
    <header>
        <marquee><h1>Salut les touristes !</h1></marquee>
    </header>
    
    <nav>
        <ul>
            <li><a href="?page=compte">Compte</a></li>
            <li><a href="">Ajouter un logement</a></li>
            <li><a href="?page=recherche">Rechercher un logement</a></li>
        </ul>
    </nav>
    <?php
        if ($page == "home"){
            echo "home";
        } elseif ($page == "compte"){
            echo "on est sur le compte";
        } elseif ($page == "recherche"){
            echo "recherche";
        }
    ?>
</body>
</html>
