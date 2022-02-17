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
            <li><a href="?page=recherche_activitee">Rechercher une activitée</a></li>
            <li><a href="?page=recherche_logement">Rechercher un logement</a></li>
            <li><a href="?page=compte">Compte</a></li>
            <li><a href="?page=register">REGISTER</a></li>
        </ul>
    </nav>
    
    <?php
        if ($page == "home"){
            echo "home";
        } elseif ($page == "recherche_activitee"){
            echo "on est sur le recherche activitee";
        } elseif ($page == "recherche_logement"){
            echo "on est sur le recherche logement";
        } elseif ($page == "compte"){
            Compte();
        }elseif($page == "register"){
            include_once "addUser.php";
        }
    ?>
</body>
</html>
