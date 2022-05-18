<div class="container">
    <div class="align-items-center m-3 display-form-bg">
        <div class="col-lg-15" >
            <div class="about-text go-to">
                <h3 class="dark-color">Changement de mot de passe</h3>  
                <form action="index.php" method="post" class="align-items-center">
                    <div>
                        <h3 class="dark-color"><label class="h3" for="old_pass_modif">Ancien mot de Passe</label>
                        <input class="form-control w-30" placeholder="Mot de Passe" type="password" name="old_pass_modif" id="old_pass_modif" minlenght="8" required>
                    </div>
                    <div>
                        <h3 class="dark-color"><label class="h3" for="pass_modif">Nouveau mot de Passe</label>
                        <input class="form-control w-30" placeholder="Mot de Passe" type="password" name="pass_modif" id="pass_modif" minlenght="8" required>
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="conf_pass_modif">Confirmer Mot de Passe</label>
                        <input class="form-control w-30" placeholder="Confirmer Mot de Passe" type="password" name="conf_pass_modif" id="conf_pass_modif" minlenght="8" required>
                    </div>
                    
                    <button class="btn btn-outline-primary" id="submit" name="submit" value="modification_pass_user" type="submit">Modifier le mot de passe</button>
                </form>

                <?php
                    if (isset($_SESSION["errors_modification_pass"])){
                        echo "<ul class='error'>";
                        foreach($_SESSION["errors_modification_pass"] as $error_modification_pass)
                            echo "<li>$error_modification_pass</li>";
                        echo "</ul>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>