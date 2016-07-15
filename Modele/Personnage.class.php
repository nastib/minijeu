<?php
class Personnage
{
  // déclaration des attribus
  private $_id,
          $_nom,
          $_degats;
 
  const CEST_MOI = 1,
        PERSONNAGE_FRAPPE = 2,
        PERSONNAGE_TUE = 3;

                    
  // constructeur
  public function __construct(array $donnee = ['nom' => ""])
  {
   $this->hydrate($donnee);
  }
  
  //hydratation de l'objet
  public function hydrate(array $donnee)
  {
    foreach($donnee as $key => $value){
      $methode = 'set'.ucfirst($key);
      if(method_exists($this,$methode)){
        $this->$methode($value);
      }
     }
  }
  
  //liste des setteurs
  public function setId($id)
  {
    $id=(int)$id;
    if($id>0) {
         $this->_id = $id;
    } else {
      echo 'id non disponible';
    }
  }
  
  public function setNom($nom)
  {
 
    if (is_string($nom)){
      $this->_nom = $nom;
     } else {
      echo ' nom non disponible';
    }
  }
  
  public function setDegats($degats)
  {
    if(isset($degats)){
      $degats = (int) $degats;
      if($degats >=0 && $degats <=100){
        $this->_degats = $degats;
      }
    }
  }
  
  //liste des getters
  public function id()
  {
    return $this->_id;
  }
  
  public function nom()
  {
    return $this->_nom;
  }
  
  public function degats()
  {
    return $this->_degats;
  }
  
  // fonctionnalités de l'objet
  public function frapper(Personnage $perso, $degats=5)
  {
    if(($this->_id != $perso->id())){
      return $perso->recevoirDegats($degats);
    } else {
      return self::CEST_MOI;
    }
  }
  
  public function recevoirDegats($degats)
  {
   $this->_degats += $degats;
   if ($this->_degats >= 100){
    return self::PERSONNAGE_TUE;
   }
   return self::PERSONNAGE_FRAPPE;
  }
  
    public function nomValide()
  {
     return !empty($this->nom());
  }
}



