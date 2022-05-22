<?php
$nb_activity = count(getAllActivityID()) ;
$nb_housing = count(getAllHousingID());
$nb_user = count(getAllUserID());
$nb_evaluations = count(getAllRateID());

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

    <div class="carousel-inner">
        <div class="carousel-item active">
            <?php
            if ($nb_images == 0) {
                # code...
            }
            else {
                ?><div class="overlay-image" style="background-image:url('<?php echo $best_annouces_w_img[0]["img"]; ?>');"></div><?php
                echo '<div class="container">';
                if (! $best_annouces_w_img[0]["is_housing"]){
                    echo "<a class='home_page_link' href='?page=activity&a=".$best_annouces_w_img[0]["infos"]["id"]."'>";
                } else {
                    echo "<a class='home_page_link' href='?page=housing&id_housing=".$best_annouces_w_img[0]["infos"]["id"]."'>";
                }
                echo "<h1 class='center-align home_page_link'>".$best_annouces_w_img[0]["infos"]["nom"]."</h1></a>";
                echo '</div>';
            }
            ?>
            <div class="container">

            </div>
        </div>
        <?php
        for ($index = 1; $index < $nb_images; $index++) {  
            echo '<div class="carousel-item">';
            ?><div class="overlay-image" style="background-image:url('<?php echo $best_annouces_w_img[$index]["img"]; ?>');"></div><?php
                echo '<div class="container">';
                if (! $best_annouces_w_img[$index]["is_housing"]){
                    echo "<a class='home_page_link' href='?page=activity&a=".$best_annouces_w_img[$index]["infos"]["id"]."'>";
                }  else {
                    echo "<a class='home_page_link' href='?page=housing&id_housing=".$best_annouces_w_img[$index]["infos"]["id"]."'>";
                }
                echo "<h1 class='center-align home_page_link'>".$best_annouces_w_img[$index]["infos"]["nom"]."</h1></a>";
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

<div class = "home-page-infos">
    <div class="counter home-page-counter">
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="count-data text-center">
                    <h6 class="count" data-to="<?php echo $nb_activity;?>" data-speed="<?php echo $nb_activity;?>"><?php echo $nb_activity;?></h6>
                    <p class="m-0px font-w-600">Activités</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="count-data text-center">
                    <h6 class="count" data-to="<?php echo $nb_housing;?>" data-speed="<?php echo $nb_housing;?>"><?php echo $nb_housing;?></h6>
                    <p class="m-0px font-w-600">Hébergements</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="count-data text-center">
                    <h6 class="count" data-to="<?php echo $nb_user;?>" data-speed="<?php echo $nb_user;?>"><?php echo $nb_user;?></h6>
                    <p class="m-0px font-w-600">Utilisateurs</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="count-data text-center">
                    <h6 class="count" data-to="<?php echo $nb_evaluations;?>" data-speed="<?php echo $nb_evaluations;?>"><?php echo $nb_evaluations;?></h6>
                    <p class="m-0px font-w-600">Evaluations</p>
                </div>
            </div>
        </div>
    </div>
    <p class="catch_phrase"> Bienvenue chez les Touristes la plateforme collaborative regroupant à la fois location de logements et activités à proximité de ces derniers afin de planifier au mieux votre séjour !</p>
</div>



