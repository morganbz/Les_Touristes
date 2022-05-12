<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    <link rel="stylesheet" href="./style.css">
        <title>Les Touristes</title>
    </head>
    <body>
        <nav class="navbar top-0 w-100 navbar-dark navbar-expand-sm bg-dark justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="?page=home">Accueil</a>
                </li>
                <!--
                <li class="nav-item active">
                    <a class="nav-link" href="?page=recherche_activitee">Rechercher une activitée</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=test_google">TEST GOOGLE</a>
                </li>
-->
                <li class="nav-item active">
                    <a class="nav-link" href="?page=search_housing">Recherche logement</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=search_activity">Recherche Activité</a>
                </li>
                <?php 
                    if (isset($_SESSION["id_user"])){
                ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="?page=user_page">Compte</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="?page=deconnexion">Déconnexion</a>
                        </li>
                        <?php
                    } else {
                        echo '<li class="nav-item active">';
                            echo '<a class="nav-link" href="?page=register&back_page='.$page.'">Inscription</a>';
                        echo '</li>';
                        echo '<li class="nav-item active">';
                            echo '<a class="nav-link" href="?page=login&back_page='.$page.'">Connexion</a>';
                        echo '</li>';
                    }
                ?> 
            </ul>
        </nav>

        <div class="main_container">

            <?php
            if ($page == "home"){
                var_dump(searchAnnounce(0, 10000, "2022-03-23", "2022-03-25", "Chambery", 99999));

                include_once "home.php";
            }
            else if ($page == "recherche_activitee"){
                include_once "test_calendar.php";

            }
            else if ($page == "user_page"){
                include_once "account/user_page.php";
            }
            else if($page == "register"){
                include_once "forms/register.php";
            }
            else if($page == "login"){
                include_once "forms/login.php";
            }
            else if ($page == "deconnexion"){
                header("Location: .");
                session_unset();
            }
            else if($page == "search_housing"){
                include_once "search_housing.php";
            } 
            else if($page == "search_activity"){
                include_once "search_activity.php";
            } 
            else if($page == "test_google"){
                include_once "test_google.php";
            }  
            else if($page == "ask_reservation"){
                include_once "forms/ask_reservation.php";
            }
            else if($page == "update_housing"){
                include_once "forms/update_housing.php";
            }
            else if($page == "update_housing_announces"){
                include_once "forms/update_housing_announces.php";
            }
            else if ($page == "housing" ){
                if (isset($_GET["h"])){
                    displayHousing($_GET["h"]);
                }
            }
            else if ($page == "activity" ){
                if (isset($_GET["a"])){
                    displayActivity($_GET["a"]);
                }
            }
            else if ($page == "user" ){
                if (isset($_GET["u"])){
                    displayUser($_GET["u"]);
                }
            }
            ?>
        </div>
    </body>
</html>
