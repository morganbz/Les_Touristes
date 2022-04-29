<?php 
    if(isset($_SESSION["id_user"])){
        
    echo "<section class='user_page_home'>";

    displayUser($_SESSION["id_user"]);

    echo "</section>";
    }
?>
