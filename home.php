<?php


$best_annouces = getFiveBestAnnounces();
$best_annouces_w_img = array();

foreach($best_annouces as $announce){
    if ($announce["is_housing"]){
        $infos = getHousingById($announce["id"]);
    } else {
        $infos = getActivityById($announce["id"]);
    }

    $announce_w_img["is_housing"] = $announce["is_housing"];

    $announce_w_img["infos"] = $infos;

    $images_dispo = array();
    foreach(glob($infos["image_folder"].'/*.*') as $img){
        $images_dispo[] = $img;
    }

    if (count($images_dispo) != 0){
         $announce_w_img["img"]= $images_dispo[0];
         $best_annouces_w_img[] =$announce_w_img;
    }
}

$nb_images = count($best_annouces_w_img);

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
                echo '<div class="overlay-image" style="background-image:url('.$best_annouces_w_img[0]["img"].');"></div>';
                echo '<div class="container">';
                if (! $best_annouces_w_img[0]["is_housing"]){
                    echo "<a class='home_page_link' href='?page=activity&a=".$best_annouces_w_img[0]["infos"]["id_activity"]."'>";
                } else {
                    echo "<a class='home_page_link' href='?page=housing&h=".$best_annouces_w_img[0]["infos"]["id"]."'>";
                }
                echo "<h1 class='center-align'>".$best_annouces_w_img[0]["infos"]["nom"]."</h1></a>";
                echo '</div>';
            }
            ?>
            <div class="container">

            </div>
        </div>
        <?php
        for ($index = 1; $index < $nb_images; $index++) {  
            echo '<div class="carousel-item">';
            echo '<div class="overlay-image" style="background-image:url('.$best_annouces_w_img[$index]["img"].');"></div>';
                echo '<div class="container">';
                if (! $best_annouces_w_img[$index]["is_housing"]){
                    echo "<a class='home_page_link' href='?page=activity&a=".$best_annouces_w_img[$index]["infos"]["id_activity"]."'>";
                }  else {
                    echo "<a class='home_page_link' href='?page=housing&h=".$best_annouces_w_img[$index]["infos"]["id"]."'>";
                }
                echo "<h1 class='center-align'>".$best_annouces_w_img[$index]["infos"]["nom"]."</h1></a>";
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



