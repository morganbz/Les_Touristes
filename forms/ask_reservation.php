<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.simple-calendar.js"></script>
<link rel="stylesheet" type="text/css" href="simple-calendar.css" />
<?php
$id = $_GET["id_housing"];

$housing = getHousingById($id);

$log_directory = $housing["image_folder"];

$owner = getUserById($housing["id_owner"]);

$profile_picture = "./ressources/profile_picture.png";
        $profile_picture_folder = "picture_profile/".$owner["id"];
        if (isset($profile_picture_folder)){
            $files = scandir ($profile_picture_folder);
            foreach($files as $file){
                if ($file != "." && $file != ".."){
                    $profile_picture = $profile_picture_folder."/".$file;
                }
            }
        }

displayCarousel($log_directory);
?>

<div>
    <div id="housing_description" class="ms-5 about-text display-form-bg">
        <br>
            <h3 class='center-align dark-color'><?php echo $housing["nom"]; ?><NOBR class='h4 ms-5' style='color:black;'><?php echo getNbRecommandationHousing($id); displayHeart($id, 1);?></NOBR></h3>
            <h4 class="center-align" style='padding-left: 3px;'><a href="?page=user&u=<?php echo $owner["id"]; ?>" class="link_user"><img class="photo_user_min" src="<?php echo $profile_picture; ?>" alt="Photo de profil"><?php echo $owner["firstname"]." ".$owner["lastname"];?></a></h4><?php
            echo "<h4 style='padding-left: 3px; border-left: 3px solid rgba(32, 39, 123, 0.17); border-radius: 2px;'>".$TYPE_HOUSING[$housing["type"]]."</h4>";
            echo "<h2 style='padding-left: 3px; border-left: 3px solid rgba(32, 39, 123, 0.17); border-radius: 2px;'>Description</h2>";
            echo "<p class='ms-3'>".$housing["description"]."</p>";
            echo "<h2 style='padding-left: 3px; border-left: 3px solid rgba(32, 39, 123, 0.17); border-radius: 2px;'>Localisation</h2>";
            echo "<p class='ms-3'>".getAddress($housing["latitude"], $housing["longitude"])."</p>";
            ?>
            <div>
                 <h2 class="mb-3" style='padding-left: 3px; border-left: 3px solid rgba(32, 39, 123, 0.17); border-radius: 2px;'>Periodes de disponibilitées</h2>
                <div class = "w-100">
                    <div id = "calendar"></div>
                </div>
            </div>
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
             <div id="map" class="mt-4" style="width:100%; height:500px; border-radius: 10px;"></div>
                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6q4hVJGUioenp17tQTqiCS9dLDWbgATw&callback=initMap"></script>
                                <script>
                                    document.getElementById("map").append(
                                        new google.maps.Marker({
                                                        position: new google.maps.LatLng(<?php echo $housing["latitude"];?>, <?php echo $housing["longitude"];?> ),
                                                        map: new google.maps.Map(document.getElementById("map"), {center: { lat: <?php echo $housing["latitude"];?>,lng: <?php echo $housing["longitude"];?> }, zoom: 13}),
                                                        icon: new google.maps.MarkerImage('./ressources/marker_simple.png')
                                                    })
                                    );
                                </script>
        <div class='container_housing_book'>
            <div id="housing_booking" class="display-form-bg">
                <?php
                if(isset($_GET['near'])){
                    $dates = durationDispo($_GET['id_housing'], $_GET['date_start'], $_GET['date_end']);
                    $cpt = 0;

                    ?>
                        <div class="d-inline-flex p-2 bd-highlight">
                        <select name = "select_date" class="form-select" aria-label="Default select example" id="select_date" >
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

                        ?>
                        <section>
                            <form class="d-flex flex-column justify-content-center align-items-center" action="index.php" method="post">
                                <br>
                                <div class="form-floating w-75">
                                    <?php
                                        if(isset($_GET['date_start']) && isset($_GET['date_end'])){
                                            echo '<input class="form-control" placeholder="Date de début du sejour" type="date" name="date_start_reservation" id="date_start_reservation" value ="'.$_GET['date_start'].'" required>';
                                        }
                                        else{
                                            echo '<input class="form-control" placeholder="Date de début du sejour" type="date" name="date_start_reservation" id="date_start_reservation" required>';
                                        }
                                    ?>
                                    <label class="form-label" for="date_start_reservation">Date de début du sejour</label>
                                </div>
                                <br>
                                <div class="form-floating w-75 mt-1">
                                    <?php
                                    if(isset($_GET['date_start']) && isset($_GET['date_end'])){
                                        echo '<input class="form-control" placeholder="Date de fin du sejour" type="date" name="date_end_reservation" id="date_end_reservation" value ="'.$_GET['date_end'].'" required>';
                                    }
                                    else{
                                        echo '<input class="form-control" placeholder="Date de fin du sejour" type="date" name="date_end_reservation" id="date_end_reservation" required>';
                                    }
                                    ?>
                                    <label class="form-label" for="date_end_reservation">Date de fin du sejour</label>
                                </div>
                        
                                <?php
                                    echo "<input type = 'hidden' name = id_housing value =  ".$_GET['id_housing']." >";
                                ?>
                                <br>
                                <?php
                                if(isset($_GET['date_start']) && isset($_GET['date_end'])){
                                    ?>
                                    <p name = "price" id = "price_id" class="mt-3" style="font-weight:bold;"><?php echo getPriceHousingPeriod($_GET['id_housing'],$_GET['date_start'], $_GET['date_end']) ; ?>€</p>

                                    <?php
                                }
                                else{
                                    ?>
                                    <p name = "price" id = "price_id"></p>
                                    <?php
                                }
                                ?>
                                <button class="btn btn-outline-primary btn-lg w-75" id="submit" name="submit" value="Ask_reservation" type="submit">Reserver</button>
                            </form>
                        </section>
                        <?php
                        }
                ?>
            </div>
        </div>
        <div class="profile-box">
                        <h2>Evaluations
                        <?php
                        if (getNbNotes($id, 1) != 0){
                            ?>
                            <NOBR><?php echo displayRateWithStars(getAverage($id, 1));?></NOBR></h2><?php
                        } else {
                            ?></h2><p>Ce logement n'as encore reçu aucune évaluation</p><?php
                        }
                        if (isset($_SESSION["id_user"]) && !isAlreadyRated($id, $_SESSION["id_user"], 1)){
                                displayFormRateAndComment($id, 1);
                        } 
                        if (getNbNotes($id, 1) != 0){
                            displayRate($id, 1);
                        }
                        ?>
            </div> 
    </div>
</div>
<script>
    var container = $("#calendar").simpleCalendar(
        {
        disableEventDetails: true, // disable showing event details
        disableEmptyDetails: true, // disable showing empty date details
    }
    );
    let $calendar = container.data('plugin_simpleCalendar')

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
    buildCalendar(new Date(2022, 5, 3), container);

    var has_events = document.getElementsByClassName("day has-event");
    console.log(has_events);
    console.log(has_events.length);

    for (var i = 0; i < has_events.length; i++) {
        has_events[i].innerHTML  = "<p data-bs-toggle='tooltip' data-bs-placement='bottom' data-bs-html='true' title='" +
           'prix à la nuit : '+ prices[i].value + '€' + 
            "'>"+ has_events[i].innerText + "</p>";
    }




    $('[name="select_date"]').change(function() {
        var message = (parseInt($('#nb_day' + $('#select_date').val()).val()) *  parseInt($('#price' + $('#select_date').val()).val())) + '€';
        $('input[name=date_start_reservation]').val( $('#date_start_near' + $('#select_date').val()).val() );
        $('input[name=date_end_reservation]').val( $('#date_end_near' + $('#select_date').val()).val() );
        $('#price_id').text(message);
    })
    
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
