<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    <link rel="stylesheet" href="./style.css">
        <link href='fullcalendar/main.css' rel='stylesheet' />
        <script src='fullcalendar/main.js'></script>
        <title>Les Touristes</title>
    </head>
    <body>
        <nav class="navbar top-0 w-100 navbar-dark navbar-expand-sm bg-dark justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="?page=home">Accueil</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=recherche_activitee">Rechercher une activitée</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=test_google">TEST GOOGLE</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=search_housing">Recherche logement</a>
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
                echo "home";
            }
            else if ($page == "recherche_activitee"){
                ?>
                <script>

                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prevYear,prev,next,nextYear today',
                            center: 'title',
                            right: 'dayGridMonth,dayGridWeek,dayGridDay'
                        },
                        initialDate: '2020-09-12',
                        navLinks: true, // can click day/week names to navigate views
                        editable: true,
                        dayMaxEvents: true, // allow "more" link when too many events
                        events: [
                            {
                            title: 'All Day Event',
                            start: '2020-09-01'
                            },
                            {
                            title: 'Long Event',
                            start: '2020-09-07',
                            end: '2020-09-10'
                            },
                            {
                            groupId: 999,
                            title: 'Repeating Event',
                            start: '2020-09-09T16:00:00'
                            },
                            {
                            groupId: 999,
                            title: 'Repeating Event',
                            start: '2020-09-16T16:00:00'
                            },
                            {
                            title: 'Conference',
                            start: '2020-09-11',
                            end: '2020-09-13'
                            },
                            {
                            title: 'Meeting',
                            start: '2020-09-12T10:30:00',
                            end: '2020-09-12T12:30:00'
                            },
                            {
                            title: 'Lunch',
                            start: '2020-09-12T12:00:00'
                            },
                            {
                            title: 'Meeting',
                            start: '2020-09-12T14:30:00'
                            },
                            {
                            title: 'Happy Hour',
                            start: '2020-09-12T17:30:00'
                            },
                            {
                            title: 'Dinner',
                            start: '2020-09-12T20:00:00'
                            },
                            {
                            title: 'Birthday Party',
                            start: '2020-09-13T07:00:00'
                            },
                            {
                            title: 'Click for Google',
                            url: 'http://google.com/',
                            start: '2020-09-28'
                            }
                        ]
                        });

                        calendar.render();
                    });

                    </script>
                    <style>

                    body {
                        margin: 40px 10px;
                        padding: 0;
                        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
                        font-size: 14px;
                    }

                    #calendar {
                        max-width: 1100px;
                        margin: 0 auto;
                    }

                    </style>

                    <div id='calendar'></div>
                <?php
                
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
            else if($page == "test_google"){
                include_once "test_google.php";
            }  
            else if($page == "ask_reservation"){
                include_once "forms/ask_reservation.php";
            }
            ?>
        </div>
    </body>
</html>
