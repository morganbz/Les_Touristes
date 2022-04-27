
<?php

$housing = getHousingById($_GET["id_housing"]);

$log_directory = $housing["image_folder"];

$images = [];

foreach(glob($log_directory.'/*.*') as $file) {
    $images[] = $file;
}

$nb_images = count($images);

?>



<style>
    .carousel-item{
        height:32rem;
        background:#777;
        color:white;
        position:relative;
        background-position:center;
        background-size:cover;
    }
    .container{
        position:absolute;
        bottom:0;
        left:0;
        right:0;
        padding-bottom:50px;
    }
    .overlay-image{
        position:absolute;
        bottom:0;
        left:0;
        right:0;
        top:0;
        background-position:center;
        background-size:cover;
    }
</style>



<div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <?php
    if($nb_images != 0){
        echo '<ol class="carousel-indicators">';
        for($index = 0; $index < $nb_images; $index++){
            if ($index == 0) {
                echo '<li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>';
            }
            else {
                echo '<li data-bs-target="#myCarousel" data-bs-slide-to="'.$index.'"></li>';
            }
        }
            echo '</ol>';
    }
    ?>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <?php
            if ($nb_images == 0) {
                # code...
            }
            else {
                echo '<div class="overlay-image" style="background-image:url('.$images[0].');"></div>';
            }
            ?>
            <div class="container">
                
            </div>
        </div>
        <?php
        for ($index = 1; $index < $nb_images; $index++) { 
            echo '<div class="carousel-item">';
            echo '<div class="overlay-image" style="background-image:url('.$images[$index].');"></div>';
                echo '<div class="container">';
            
                echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <a href="#myCarousel" class="carousel-control-prev" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a href="#myCarousel" class="carousel-control-next" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>
<div id="contener">
    <div id="housing_description">
        <?php
            echo "<h1 class='bite'>".$housing["nom"]."</h1>";
        ?>
    </div>
    <div id="housing_booking">
        
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
        
                <button class="btn btn-primary btn-lg" id="submit" name="submit" value="Ask_reservation" type="submit">Reserver</button>
            </form>
        </section>
    </div>
</div>


