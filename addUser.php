<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <main class="from-signin text-center">
            <form action="index.php" method="post">
            
                <h1 class="display-5 fw-bold">Inscription</h1>
<div class="container h-100">
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

                
                <div class="col mb-4">
                    <div class="form-floating">
                        <input class="form-control" placeholder="Numéro de téléphone" type="text" name="phone_number_register" id="phone_number_register" required>
                        <label class="form-label" for="phone_number_register">Numéro de Téléphone</label>
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

                <div class="col mb-4">
                    <div class="form-floating">
                        <input class="form-control" placeholder="Date de naissance" type="text" name="birth_date_register" id="birth_date_register" required>
                        <label class="form-label" for="birth_date_register">Date de naissance</label>
                    </div>
                </div>
                
                <div class="checkbox mb-4 mt-3">
                <label>
                    <input type="checkbox" value="admin"> Admin
                </label>
                </div>

                <?php
                //    echo '<input type="text" class="display_none" name="id_company" id="id_company" value="'.$id_company.'">';
                //    echo '<input type="text" class="display_none" name="back_page" id="back_page" value="'.$back_page.'">';
                ?>

                <?php
                /*    if($error!=null){
                        if($error=="already_user"){
                            echo "<p class='mb-4'>Ce mail possède déjà un compte.</p>";
                        }
                        else if($error=="wrong_first"){
                            echo "<p class='mb-4'>Nom de famille trop grand.</p>";
                        }
                        else if($error=="wrong_last"){
                            echo "<p>Prénom trop grand.</p>";
                        }
                        else if($error=="wrong_mail"){
                            echo "<p class='mb-4'>L'adresse e-mail est invalide.</p>";
                        }
                        else if($error=="wrong_phone"){
                            echo "<p class='mb-4'>Numéro de téléphone invalide.</p>";
                        }
                        else if($error=="wrong_pass"){
                            echo "<p class='mb-4'>Les mots de passe sont différents</p>";
                        }
                    }*/
                ?>

                <button class="w-100 btn btn-primary btn-lg px-4 me-sm-3" id="submit" name="submit" value="Register" type="submit">Inscription</button>
                &nbsp;

                <?php
                    //echo '<p><a class="forget_password text-primary" href="?page=login&id_company='.$id_company.'&back_page=register">Déjà un compte ?</a></p>';
                ?>
                <p class="mt-5 mb-3 text-muted">&copy; 2021–2022</p>
            </form>
        </main>
    </div>
</div>