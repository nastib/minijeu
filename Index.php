<?php
//Phase 1 : initialisation    /////////////
/////////////////////////////////////////

//1- Autoload des classes///////////////

function chargerClass($class)
{
    require_once('/Modele/'.$class.'.class.php');
}
spl_autoload_register('chargerClass');


//2- démarrage d'une session ////////
session_start();

//3- Test pour déconnexion //////////
if(isset($_GET['deconnexion'])){
    session_destroy();
    header('location:.');
    exit();
}

//4- Restauration d'une session //// 
if(isset($_SESSION['perso'])){
    $perso = $_SESSION['perso'];
}

//5- Initialisation des objets PDO et Manager/////////
try {
    $db = new PDOConfig('minijeu','root','');
    $manager = new PersonnagesManager($db);
}
catch (Exception $e){
    echo $e->getMessage();
}

// Phase 2 : contrôle des traitements (Creer, Utiliser et Frapper)////////
///////////////////////////////////////////////////////////////////////////

if (isset($_POST['creer']) && isset($_POST['nom']))
{
    // Gestion du cas de création d'un personnage ////////////
    $perso = new Personnage(['nom' => $_POST['nom'],'degats'=>0]);

    if (!$perso->nomValide()) {
        $message = 'Le nom choisi est invalide.';
        unset($perso);
    }
    elseif (!$manager->exists($_POST['nom']))
    {
        $manager->add($perso);
        $_SESSION['perso'] = $perso;
        $message = 'Personnage créé avec succès';
    }
    else
    {
        $message = 'Le nom du personnage est déjà pris';
        unset($perso);
    }
}
elseif (isset($_POST['utiliser']) && isset($_POST['nom']))
{
    // Gestion du cas d'utilsiation d'un personnage ////////
    if ($manager->exists($_POST['nom']))
    {
        $perso = $manager->get($_POST['nom']);
        $_SESSION['perso'] = $perso;
        $message = 'Personnage bien sélectionné';
    }
    else
    {
       $message = 'Ce personnage n\'existe pas !';
       unset($perso);
    }
} elseif (isset($_GET['frapper']) && isset($_GET['nom']))
{
    //Gestion du cas d'attaque de combat ///////////////////
    if(!isset($perso))
    {
        $message = 'Pas de personnage à utiliser';
    }
    else
    {
     $persoAFrapper = $manager->get($_GET['nom']);
     if($manager->exists($persoAFrapper->nom())){
     $retour = $perso->frapper($persoAFrapper);
     switch ($retour)
     {
        case Personnage::CEST_MOI :
            $message = 'Impossible de se frapper';
            break;
        case Personnage::PERSONNAGE_FRAPPE :
            $message = $persoAFrapper->nom().' a été bien frappé';
            $manager->update($persoAFrapper);
            $manager->update($perso);
            break;
        case Personnage::PERSONNAGE_TUE :
            $message = $persoAFrapper->nom().' est tué';
            $manager->delete($persoAFrapper);
            break;
     }
     }
     else
     {
        $message = 'Personnage à frapper inexistant';
     }
    }
}
include_once('vue/vue.php');
