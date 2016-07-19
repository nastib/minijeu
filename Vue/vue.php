<!--// phase 3 : résultats et vues /////////////////////////////////
///////////////////////////////////////////////////////////////-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf8'/>
        <title>Mini jeu de combat - Version 2</title>
    </head>
    <body>
        <fieldset>
            <legend> Statut </legend>
       <?php    
            if($manager->count() > 0)
            {
            echo '<p> Nombre de personnages créés : '.$manager->count() .'</p>';
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
                      Type : <?=ucfirst($perso->type())?><br/>
                      Nom : <?= $perso->nom() ?> <br/>
                      Dégats : <?= $perso->degats() ?>
                      <?php
                      switch($perso->type())
                      {
                        case 'magicien' :
                            echo 'magie : ';
                            break;
                        case 'guerrier' :
                            echo 'Protection : ';
                            break;
                      }
                      echo $perso->atout();
                      ?>
                    </p> 
                </fieldset>
                <fieldset>
                    <legend> Qui frapper ? </legend>
                    <?php
                    $persos = $manager->getList($perso->nom());
                    if (empty($persos))
                    {
                        echo 'Personne à frapper !';
                    } else
                    {
                      if ($perso->estEndormi())
                      {
                        echo 'Un magicien vous a endormi ! Vous allez vous reveiller dans ', $perso->reveil(),'.';
                      } else
                      {
                      
                      foreach($persos as $pers)
                      {
                        echo '<a  href="?frapper='.$pers->id().'">'.htmlspecialchars($pers->nom()).'</a>',' (dégats : ', $pers->degats(),' | type : ', $pers->type(), ')';
                        //on joute un lien pour un sort si le personnage est un magicien
                        if($perso->type() =='magicien')
                        {
                        echo '| <a href="?ensorceler=', $pers->id(),'">', 'lancer un sort ,</a>';
                        }
                        echo '<br/>';
                      }
                      }
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
                    
                    <input type='submit' value='utiliser' name='utiliser'/></p>
                    <p>Type :
                    <select name ="type">
                        <option value='magicien'> Magicien </option>
                        <option value='guerrier'> Guerrier </option>
                    </select>
                    <input type='submit' value='creer' name='creer' />
                    </p>
                </form  
            <?php
            }
            ?>
    </body>
</html>


