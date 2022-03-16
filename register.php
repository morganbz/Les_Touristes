
<div class="container h-100" style="width:40%;">
    <div class="row h-100 justify-content-center align-items-center">
        <main class="from-signin text-center">
            <form action="index.php" method="post">
            
                <h1 class="display-5 fw-bold">Inscription</h1>

                <div class="row mb-4 mt-5">
                    <div class="col">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Prénom" type="text" name="firstname_register" id="firstname_register" required>
                            <label class="form-label" for="firstname_register">Prénom</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Nom"type="text" name="lastname_register" id="lastname_register" required>
                            <label class="form-label" for="lastname_register">Nom</label>
                        </div>
                    </div>
                </div>

                <div class="col mb-4">
                    <div class="form-floating">
                        <input class="form-control" placeholder="E-mail" type="text" name="mail_register" id="mail_register" required>
                        <label class="form-label" for="mail_register">E-mail</label>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Numéro de téléphone" type="text" name="phone_register" id="phone_register" minlenght="8" required>
                            <label class="form-label" for="phone_register">Numéro de Téléphone</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Date de Naissance" type="date" name="birth_date_register" id="birth_date_register" minlenght="8" required>
                            <label class="form-label" for="birth_date_register">Date de Naissance</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Mot de Passe" type="password" name="pass_register" id="pass_register" minlenght="8" required>
                            <label class="form-label" for="pass_register">Mot de Passe</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Confirmer Mot de Passe" type="password" name="conf_pass_register" id="conf_pass_register" minlenght="8" required>
                            <label class="form-label" for="conf_pass_register">Confirmer Mot de Passe</label>
                        </div>
                    </div>
                </div>

                <div class="checkbox mb-4 mt-3">
                    <div>
                        <label for="admin_register">
                            <input type="checkbox" value="1" id="admin_register" name="admin_register"> Admin
                        </label>
                    </div>
                </div>

                <button class="w-100 btn btn-primary btn-lg px-4 me-sm-3" id="submit" name="submit" value="Register" type="submit">Inscription</button>
                &nbsp;
            </form>
            <?php
                if (isset($_SESSION["errors_register"])){
                    echo "<p class='error'>Erreurs lors de la création de compte :</p>";
                    echo "<ul>";
                    foreach($_SESSION["errors_register"] as $error_register)
                        echo "<li class='error'>$error_register</li>";
                    echo "</ul>";
                }
            ?>
        </main>
    </div>
</div>