<div class="container h-100" style="width:40%;">
    <div class="row h-100 justify-content-center align-items-center">
        <main class="from-signin text-center">
            <form action="index.php" method="post">
            
                <h1 class="display-5 fw-bold">Connexion</h1>

                <div class="col mb-4 mt-5">
                    <div class="form-floating">
                        <input class="form-control" placeholder="E-mail" type="text" name="mail_user" id="mail_user" required>
                        <label for="floatingInput" for="mail_user">E-mail</label>
                    </div>
                </div>

                <div class="col mb-4">
                    <div class="form-floating">
                        <input class="form-control" placeholder="password" type="password" name="password" id="password" required>
                        <label for="floatingInput" for="password">Mot de passe</label>
                    </div>
                </div>
                <?php
                    echo '<input type="text" class="d-none" name="back_page" id="back_page" value="'.$back_page.'">';
                ?>

                <button class="w-100 btn btn-primary btn-lg px-4 me-sm-3" id="submit" name="submit" value="Login" type="submit">Connexion</button>

                &nbsp;
            </form>
            <?php
                if (isset($_SESSION["errors_login"])){
                    echo "<p class='error'>Erreurs lors de la connexion :</p>";
                    echo "<ul>";
                    foreach($_SESSION["errors_login"] as $error_login)
                        echo "<li class='error'>$error_login</li>";
                    echo "</ul>";
                }
            ?>
        </main>
    </div>
</div>