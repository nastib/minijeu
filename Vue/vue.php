<!--// phase 3 : résultats et vues /////////////////////////////////
///////////////////////////////////////////////////////////////-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf8'/>
        <title>Mini jeu de combats</title>
    </head>
    <body>
        <fieldset>
            <legend> Statut </legend>
       <?php    
            if($manager->count() > 0)
            {
            echo '<p> Nombre de personnages créés : '.$manager->count();
            }
            if(isset($perso))
            {
                // Affichage des résultats et vues
                if(isset($message))
                {
                    echo '<br/>'.$message;
                }
        ?>
                <br/><a href='index.php?deconnexion=1'>Déconnexion</a>
                </fieldset>
                <fieldset>
                    <legend> Mes informations </legend>
                    <p>
                      Nom : <?= $perso->nom() ?> <br/>
                      Dégats : <?= $perso->degats() ?>
                    </p> 
                </fieldset>
                <fieldset>
                    <legend> Qui frapper ? </legend>
                    <?php
                      $persos = $manager->getList($perso->nom());
                      foreach($persos as $pers)
                      {
                        echo '<a  href=index.php?nom='.$pers->nom().'&frapper=frapper>'.$pers->nom().'</a>'.' (dégats : '.$pers->degats().' ) <br/>';
                      }
                    ?>
                </fieldset>
            <?php
            }
            else
                // afficharge du formulaire
            {?>
                <form method='post' action='index.php'>
                    <label for='nom'><input type='text' name='nom' maxlength=50 /></label>
                    <p><input type='submit' value='creer' name='creer' />
                    <input type='submit' value='utiliser' name='utiliser'/></p>
                </form  
            <?php
            }
            ?>
    </body>
</html>


