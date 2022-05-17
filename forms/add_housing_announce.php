<div class="container">
    <div class="align-items-center m-3 display-form-bg">
        <div class="col-lg-15" >
            <div class="about-text go-to">
                <h3 class="dark-color">Ajout d'un logement</h3>
                <form action="index.php" method="post" class="align-items-center">
                    
                    <div>
                        <h3 class="dark-color"><label class="h3" for="name_housing">Nom du logement</label>
                        <input class="form-control w-30" placeholder="Nom du logement" type="text" name="name_housing" id="name_housing" required> 
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="id_owner_housing">Type de logement</label>
                        <select class="form-select w-30" name="type_housing" id="id_owner_housing">
                            <?php
                                $indice = 0;
                                foreach($TYPE_HOUSING as $type){
                                    echo "\n<option value=$indice>$type</option>";
                                    $indice++;
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="address_housing">Adresse</label>
                        <input class="form-control w-30" placeholder="01 rue de la paix" type="text" name="address_housing" id="address_housing" required>
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="postal_code_housing">Code Postal</label>
                        <input class="form-control w-30" placeholder="75000" type="text" name="postal_code_housing" id="postal_code_housing" required>
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="city_housing">Ville</label>
                        <input class="form-control w-30" placeholder="Paris" type="text" name="city_housing" id="city_housing" required>                   
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="description_housing">Description</label>
                        <input class="form-control w-30" placeholder="Description" type="text" name="description_housing" id="description_housing" required>       
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="price_announce">Prix par nuit</label>
                        <input class="form-control w-30" placeholder="Prix de l'annonce" type="int" name="price_announce" id="price_announce" required> 
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="date_start_announce">Date du début de l'annonce</label>
                        <input class="form-control w-30" placeholder="Date du début de l'annonce" type="date" name="date_start_announce" id="date_start_announce" required>  
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="date_end_announce">Date de la fin de l'annonce</label>
                        <input class="form-control w-30" placeholder="Date de fin de l'annonce" type="date" name="date_end_announce" id="date_end_announce" required>
                    </div>

                    <button class="btn btn-outline-primary" id="submit" name="submit" value="Add_housing_announce" type="submit">Ajouter le logement</button>
                </form>
            </div>
        </div>
    </div>
</div>
