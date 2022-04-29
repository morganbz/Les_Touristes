<div id ="housing_booking">
    <form class = "d-flex flex-column justify-content-center" action="index.php" method="post">

        <div class="form-floating w-30">
            <input class = "form-control" placeholder="date de début" type="date" name="date_start" id="date_start" required>
            <label class="form-label" for="date_start_update">date de début</label>
        </div>

        <div class="form-floating w-30">
            <input class = "form-control" placeholder="date de fin" type="date" name="date_end" id="date_end" required>
            <label class="form-label" for="date_start_update">date de fin</label>
        </div>

        <input type="hidden" name="id_housing" id="id_housing" value = <?php echo $_GET["id_housing"] ?> required>


        <button class="btn btn-primary btn-lg w-30" id="submit" name="submit" value="add_announce_period" type="submit">Ajouter la periode</button>
    </form>
</div>