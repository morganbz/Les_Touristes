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
        <h1>Salut les touristes !</h1>
    </header>
    <nav>
        <ul>
            <li><a href="?page=recherche_activitee">Rechercher une activitée</a></li>
            <li><a href="?page=search_housing_text">Rechercher un logement texte</a></li>
            <?php 
                if (isset($_SESSION["id_user"])){?>
                    <li><a href="?page=user_page">Compte</a></li>
                    <li><a href="?page=deconnexion">Déconnexion</a></li>
            <?php
                } else { ?>
                    <li><a href="?page=register">Inscription</a></li>
                    <li><a href="?page=login">Connexion</a></li>
            <?php
                }
            ?>
            <li><a href="?page=add_housing_announce">Ajouter un logement</a></li>
            <li><a href="?page=search_housing">Recherche logement carte</a></li>
            <li><a href="?page=test">TEST GOOGLE</a></li>
        </ul>
    </nav>
    <?php
        if ($page == "home"){
            echo "home";
        }
        else if ($page == "recherche_activitee"){
            
            //displaySearch(searchAnnounce(0, 1000, "1900-01-01", "2070-01-01"));
            //searchAnnounce(0, 1000, "1900-01-01", "2070-01-01");
            //isTakenDuration(14 , "1900-01-01",  "2070-01-01");
        }
        else if ($page == "search_housing_text"){
            include_once "formulaire/search_housing_text.php";
            //displaySearch(searchAnnounce(0, 1000, "1900-01-01", "2070-01-01"));
        }
        else if ($page == "user_page"){
            include_once "user_page.php";
        }
        else if($page == "register"){
            include_once "register.php";
        }
        /*else if($page == "add_housing"){
            include_once "add_housing.php";
        }
        else if($page == "add_announce"){
            include_once "add_announce.php";
        }*/
        else if($page == "add_housing_announce"){
            include_once "add_housing_announce.php";
        }
        else if($page == "login"){
            include_once "login.php";
        }
        else if ($page == "deconnexion"){
            $page = "home";
            session_unset();
        }
        else if($page == "search_housing"){
            include_once "search_housing.php";
        } 
        else if($page == "test"){
            include_once "test.php";
        }  
    ?>
</body>
</html>
