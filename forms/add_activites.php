<div class="container">
    <div class="align-items-center m-3 display-form-bg">
        <div class="col-lg-15" >
            <div class="about-text go-to">
                <h3 class="dark-color">Ajout d'une activité</h3>                
                <form action="index.php" method="post" class="align-items-center">
                    <div>
                        <h3 class="dark-color"><label class="h3" for="nom_activite">Nom de l'activité</label></h3>  
                        <input  class="form-control w-30" placeholder="Nom de l'activite" type="text" name="nom_activite" id="nom_activite" required>                    
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="type_activite">Type de l'activité</label></h3> 
                        <select class="form-select w-30" name="type_activite" id="type_activite" required>
                        <?php
                            $indice = 0;
                            foreach($TYPE_ACTIVITY as $type){
                                echo "\n<option value=$indice>$type</option>";
                                $indice++;
                            }
                        ?>
                        </select>                      
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="city_activite">Ville de l'activité</label></h3>
                        <input  class="form-control w-30" placeholder="Paris" type="text" name="city_activite" id="city_activite" required>                   
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="adress_activite">Adresse de l'activité</label></h3> 
                        <input  class="form-control w-30" placeholder="01 rue de la Paix" type="text" name="adress_activite" id="adress_activite" required>                   
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="post_activite">Code Postal de l'activité</label></h3>
                        <input  class="form-control w-30" placeholder="75100" type="double" name="post_activite" id="post_activite" required>   
                    </div>

                    <div>
                        <h3 class="dark-color"><label class="h3" for="desc_activite">Descritpion de l'activité</label></h3>
                        <input  class="form-control w-30" placeholder="Description de l'activite" type="text" name="desc_activite" id="desc_activite" required>
                    </div>

                    <button class="btn btn-outline-primary" id="submit" name="submit" value="Add_activite" type="submit">Ajouter l'activité</button>
                </form>
            </div>
        </div>
    </div>
</div>