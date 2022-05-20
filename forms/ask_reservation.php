
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.simple-calendar.js"></script>
<link rel="stylesheet" type="text/css" href="simple-calendar.css" />
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
        <br>
        <?php
            echo "<h1 class='center-align'>".$housing["nom"]."</h1>";
            echo "<h3>Localisation</h3>";
            echo "<p>".getAddress($housing["latitude"], $housing["longitude"])."</p>";
            echo "<h3>Description</h3>";
            echo "<p>".$housing["description"]."</p>";
            ?>
            <h3>Periodes de disponibilitées</h3>
            <div id = "calendar" class = "w-75"></div>
            <?php
            $announces = getAnnounceByIdHousing($housing["id"]);
            $cpt = 0;
            foreach($announces as $announce){
                echo "<input  type='hidden' class='date_start_announce' name='date_start_announce".$cpt."' id='date_start_announce".$cpt."' value =".$announce['date_start']." >";
                echo "<input  type='hidden' class='price_announce' name='price_announce".$cpt."' id='price_announce".$cpt."' value =".$announce['price']." >"; 
                echo "<input  type='hidden' class='isTaken_announce' name='isTaken_announce".$cpt."' id='isTaken_announce".$cpt."' value =".$announce['isTaken']." >"; 
                echo "<input  type='hidden' class='id_announce' name='id_announce".$cpt."' id='id_announce".$cpt."' value =".$announce['id']." >"; 

                $cpt++;
            }
            ?>
    </div>
    <div id="housing_booking">
        <?php
        if(isset($_GET['near'])){
            $dates = durationDispo($_GET['id_housing'], $_GET['date_start'], $_GET['date_end']);
            $cpt = 0;

            ?>
                <div class="d-inline-flex p-2 bd-highlight">
                <select class="form-select" aria-label="Default select example" id="select_date" >
                    <option selected>dates de séjour suggérées </option>
                    <?php
                    foreach($dates as $date){
                        echo "<option class='option_near' id='option_near' value='".$cpt."' ><?php ?>Du ".getNiceDate($date['date_start'])." au ".getNiceDate($date['date_end'])."</option>";
                        $cpt++;
                    }
                    ?>

                </select>
                <?php
                    $cpt = 0;
                    foreach($dates as $date){
                        echo "<input  type='hidden' class='date_start_near' name='date_start_near".$cpt."' id='date_start_near".$cpt."' value =".$date['date_start']." >";
                        echo "<input  type='hidden' class='date_end_near' name='date_end_near".$cpt."' id='date_end_near".$cpt."' value =".$date['date_end']." >";
                        echo "<input  type='hidden' class='nb_day' name='nb_day".$cpt."' id='nb_day".$cpt."' value =".$date['nb_day']." >";
                        echo "<input  type='hidden' class='price' name='price".$cpt."' id='price".$cpt."' value =".$date['price']." >";
                        

                        $cpt++;

                    }
                    ?>
                    <button class="btn btn-outline-primary " id="validate_date">Valider</button>
                </div>



                <section>
                    <form class="d-flex flex-column justify-content-center align-items-center" action="index.php" method="post">
                        <br>
                        <div class="form-floating w-75">
                            <?php
                                echo '<input class="form-control" placeholder="Date de début du sejour" type="date" name="date_start_reservation" id="date_start_reservation" required>';
                            ?>
                            <label class="form-label" for="date_start_reservation">Date de début du sejour</label>
                        </div>
                        <br>
                        <div class="form-floating w-75">
                            <?php
                                echo '<input class="form-control" placeholder="Date de fin du sejour" type="date" name="date_end_reservation" id="date_end_reservation" required>';
                            ?>
                            <label class="form-label" for="date_end_reservation">Date de fin du sejour</label>
                        </div>
                
                        <?php
                            echo "<input type = 'hidden' name = id_housing value =  ".$_GET['id_housing']." >";
                        ?>
                        <br>
                        <p name = "price" id = "price_id"></p>
                        <button class="btn btn-outline-primary btn-lg w-75" id="submit" name="submit" value="Ask_reservation" type="submit">Reserver</button>
                    </form>
                </section>

            <?php

        }
        else{

        
            if(isset($_GET['date_start']) && isset($_GET['date_end'])){

                ?>
                <section>
                    <form class="d-flex flex-column justify-content-center align-items-center" action="index.php" method="post">
                        <br>
                        <div class="form-floating w-75">
                            <?php
                                echo '<input class="form-control" placeholder="Date de début du sejour" type="date" name="date_start_reservation" id="date_start_reservation" value ="'.$_GET['date_start'].'" required>';
                            ?>
                            <label class="form-label" for="date_start_reservation">Date de début du sejour</label>
                        </div>
                        <br>
                        <div class="form-floating w-75">
                            <?php
                                echo '<input class="form-control" placeholder="Date de fin du sejour" type="date" name="date_end_reservation" id="date_end_reservation" value ="'.$_GET['date_end'].'" required>';
                            ?>
                            <label class="form-label" for="date_end_reservation">Date de fin du sejour</label>
                        </div>
                
                        <?php
                            echo "<input type = 'hidden' name = id_housing value =  ".$_GET['id_housing']." >";
                        ?>
                        <br>
                        <p name = "price" id = "price_id"><?php echo getPriceHousingPeriod($_GET['id_housing'],$_GET['date_start'], $_GET['date_end']) ; ?>€</p>
                        <button class="btn btn-outline-primary btn-lg w-75" id="submit" name="submit" value="Ask_reservation" type="submit">Reserver</button>
                    </form>
                </section>
                <?php
            }
        }
        ?>
    </div>
</div>

<script>
    var container = $("#calendar").simpleCalendar(
        {
        disableEventDetails: true, // disable showing event details
        disableEmptyDetails: true, // disable showing empty date details
    }
    );
    let $calendar = container.data('plugin_simpleCalendar');
   
    var btn = document.getElementById('#validate_date');

    var prices = document.getElementsByClassName("price_announce");

    var date_announces = document.getElementsByClassName("date_start_announce");
    var takens = document.getElementsByClassName("isTaken_announce");
    var ids = document.getElementsByClassName("id_announce");

    // new Date("dateString") is browser-dependent and discouraged, so we'll write
    // a simple parse function for U.S. date format (which does no error checking)
    function parseDate(str) {
        var mdy = str.split('-');
        return new Date(mdy[0], mdy[1]-1, mdy[2]);
    }


    for (var i = 0; i < date_announces.length; i++) {
        if(takens[i].value == "0"){
            var newEvent = {
                startDate: new Date(date_announces[i].value).toISOString(),
                endDate: new Date(date_announces[i].value).getTime(),
                summary: ids[i].value + ' ' + prices[i].value
            };
            $calendar.addEvent(newEvent);

        }

    }

    var has_events = document.getElementsByClassName("day has-event");

    for (var i = 0; i < has_events.length; i++) {
        has_events[i].innerHTML  = "<p data-bs-toggle='tooltip' data-bs-placement='bottom' data-bs-html='true' title='" +
           'prix à la nuit : '+ prices[i].value + '€' + 
            "'>"+ has_events[i].innerText + "</p>";
    }



    if(btn.length > 0){
        btn.onclick = function(e) {
            var message = (parseInt($('#nb_day' + $('#select_date').val()).val()) *  parseInt($('#price' + $('#select_date').val()).val())) + '€';
            $('input[name=date_start_reservation]').val( $('#date_start_near' + $('#select_date').val()).val() );
            $('input[name=date_end_reservation]').val( $('#date_end_near' + $('#select_date').val()).val() );
            $('#price_id').text(message);


        }
    }

    $('input[name=date_end_reservation]').change(function() {
        var price = 0;
        var date_start = $('input[name=date_start_reservation]').val();
        var date_end = $('input[name=date_end_reservation]').val();
        for (var i = 0; i < date_announces.length; i++) {
            if($('#date_start_announce' + i).val() >= date_start){
                if($('#date_start_announce' + i).val() <= date_end){
                    price = price + parseInt($('#price_announce' + i).val());
                }
            }

        }

        $('#price_id').text(price + '€');

    });

    $('input[name=date_start_reservation]').change(function() {
        var price = 0;
        var date_start = $('input[name=date_start_reservation]').val();
        var date_end = $('input[name=date_end_reservation]').val();
        for (var i = 0; i < date_announces.length; i++) {
            if($('#date_start_announce' + i).val() >= date_start){
                if($('#date_start_announce' + i).val() <= date_end){
                    price = price + parseInt($('#price_announce' + i).val());
                }
            }

        }

        $('#price_id').text(price + '€');

    });





</script>
