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
        }
        else if ($page == "recherche_activitee"){
            echo "on est sur le recherche activitee";
        }
        else if ($page == "recherche_logement"){
            echo "on est sur le recherche logement";
        }
        else if ($page == "user_page"){
            include_once "compte.php";
        }
        else if($page == "register"){
            include_once "add_user.php";
        }
        
    ?>
</body>
</html>
