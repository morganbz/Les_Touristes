 <?php

$housing = getHousingById($_GET["id_housing"]);

$log_directory = './picture_housing/'.$housing['id_owner'].'/'.$housing['id'];

?>


<section>


    <form action="index.php" method="post">
        <div>
            <?php
            echo "<input placeholder='Description' type='date' name='date_start_reservation' id='date_start_reservation' value ='".$_GET['date_start']."' required>"
            ?>
            <label for="date_start_reservation">Date de début du sejour</label>
        </div>

        <div>
            <?php
            echo "<input placeholder='Description' type='date' name='date_end_reservation' id='date_end_reservation' value ='".$_GET['date_end']."' required>"
            ?>            
            <label for="date_end_reservation">Date de fin du sejour</label>
        </div>

        <?php
        echo "<input type = 'hidden' name = id_housing value =  ".$_GET['id_housing']." >";
        ?>

        <button id="submit" name="submit" value="Ask_reservation" type="submit">Reserver</button>
    </form>
</section>

<?php
echo'<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">';
  echo'<ol class="carousel-indicators">';
    echo'<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>';
    echo'<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>';
    echo'<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>';
  echo'</ol>';
  echo'<div class="carousel-inner">';
    foreach(glob($log_directory.'/*.*') as $file) {
        echo'<div class="carousel-item active">';
        echo'<img class="d-block w-100" src="'.$log_directory.'/'.$file.'" alt="First slide">';
        echo'</div>';
    }
  echo'</div>';
  echo'<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">';
    echo'<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo'<span class="sr-only">Previous</span>';
  echo'</a>';
  echo'<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">';
    echo'<span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo'<span class="sr-only">Next</span>';
  echo'</a>';
  echo'</div>';
?>