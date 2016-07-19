<?php
//Classe abstraite Personnage
abstract class Personnage
{
  // déclaration des attribus
  protected $atout,
            $id,
            $nom,
            $degats,
            $type,
            $timeEndormi;
 
  const  CEST_MOI = 1, // Constante renvoyée par la méthode `frapper` si on se frappe soit-même.
         PERSONNAGE_TUE = 2, // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
         PERSONNAGE_FRAPPE = 3, // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
         PERSONNAGE_ENSORCELE = 4, // Constante renvoyée par la méthode `lancerUnSort` (voir classe Magicien) si on a bien ensorcelé un personnage.
         PAS_DE_MAGIE = 5, // Constante renvoyée par la méthode `lancerUnSort` (voir classe Magicien) si on veut jeter un sort alors que la magie du magicien est à 0.
         PERSONNAGE_ENDORMI = 6; // Constante renvoyée par la méthode `frapper` si le personnage qui veut frapper est endormi.
                    
  // constructeur   /////////////////////
  public function __construct(array $donnee)
  {
   $this->hydrate($donnee);
   $this->type = strtolower(static::class);
  }
  
  //hydratation de l'objet   //////////////
  public function hydrate(array $donnee)
  {
    foreach($donnee as $key => $value){
      $methode = 'set'.ucfirst($key);
      if(method_exists($this,$methode)){
        $this->$methode($value);
      }
     }
  }
  
  //liste des setters  ///////////////////
  public function setId($id)
  {
    $id=(int)$id;
    if($id>0) {
         $this->id = $id;
    } else {
      echo 'id non disponible';
    }
  }
  
  public function setNom($nom)
  {
 
    if (is_string($nom)){
      $this->nom = $nom;
     } else {
      echo ' nom non disponible';
    }
  }
  
  public function setDegats($degats)
  {
    if(isset($degats)){
      $degats = (int) $degats;
      if($degats >=0 && $degats <=100){
        $this->degats = $degats;
      }
    }
  }
  
  public function setAtout($atout)
  {
    $atout = (int) $atout;
    if($atout >= 0 && $atout <= 100)
    {
     $this->atout = $atout;
    }
  }
    
   public function setTimeEndormi($time)
   {
    $this->timeEndormi = (int) $time;
   }
   
   // Pas setter pour l'attributs Type. Il est défini dans le constructeur et l'utilisateur 
   // ne pourra pas changer sa valeur (imaginez le non-sens qu'il y aurait si l'utilisateur 
   // mettait « magicien » à l'attribut $type d'un objet Guerrier).
   
  //liste des getters  ///////////////////
  
  public function id()
  {
    return $this->id;
  }
  
  public function nom()
  {
    return $this->nom;
  }
  
  public function degats()
  {
    return $this->degats;
  }
  
   public function type()
  {
    return $this->type;
  }
  
  public function atout()
  {
   return $this->atout;
  }
  
  public function timeEndormi()
  {
   return $this->timeEndormi;
  }
  
  // fonctionnalités de l'objet /////////////////////
  
  public function frapper(Personnage $perso, $degats=5)
  {
    
    if(($this->id() == $perso->id())){
      return self::CEST_MOI;
    }
    
    if($this->estEndormi()){
     return self::PERSO_ENDORMI ;
    }
   // On indique au personnage qu'il doit recevoir des dégâts.
   // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE.
   return $perso->recevoirDegats($degats);
  }
  
  public function recevoirDegats($degats)
  {
 
   $this->degats += $degats;
   if ($this->degats >= 100){
    return self::PERSONNAGE_TUE;
   }
   return self::PERSONNAGE_FRAPPE;
  }
  
  public function nomValide()
  {
     return !empty($this->nom());
  }
 
  public function estEndormi()
  {
    return ($this->timeEndormi > time());
  }
 
  public function reveil()
  {
    $secondes = $this->timeEndormi ;
    $secondes -= time();
    
    $heures = floor($secondes / 3600);
    $secondes -= ($heures * 3600);
    $minutes = floor($secondes / 60);
    $secondes -= ($minutes * 60);
    
    $heures .= $heures <=1 ? ' heure' : ' heures';
    $minutes .= $minutes <=1 ? ' minute' : ' minutes';
    $secondes .= $secondes <=1 ? ' seconde' : ' secondes';
    
    return $heures.', '.$minutes. ' et '.$secondes;
  }
  
   
}