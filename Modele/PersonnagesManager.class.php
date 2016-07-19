<?php
class PersonnagesManager
{
  // déclaration des attribus
  protected $db; // Instance de PDO
  
  // constructeur
  public function __construct(PDO $db)
  {
   $this->hydrate($db);
  }
  
  //hydratation de l'objet
  private function hydrate(PDO $db)
  {
    $this->setDb($db);
  }
  
  //setter $db
  public function setDb(PDO $db)
  {
    if(isset($db)) {
         $this->db = $db;
    }
  }
  
  //getter $db
  public function db()
  {
    return $this->db;
  }
  
  
  // fonctionnalités de l'objet
  
  public function count()
  {
   return $this->db()->query('SELECT count(*) FROM personnages_v2')->fetchColumn();
  }
  
  // Ajout de nouveaux personnages
  public function add(Personnage $perso)
  {
    $req = $this->db()->prepare("INSERT INTO personnages_v2 (nom, type) VALUES (:nom, :type)");
    $req->execute([':nom' => $perso->nom(),':type' => $perso->type()]);
    $perso->hydrate([
                     'id' => $this->db()->lastInsertId(),
                     'degats' => 0,
                     'atout' => 0
                     ]);
  }
  
  public function delete(Personnage $perso)
  {
    $this->db()->exec("DELETE FROM personnages_v2 WHERE id = ".$perso->id());
   }
  
 
  public function exists($info)
  {
   if (is_int($info)){
     return (bool) $this->db()->query("SELECT count(*) FROM personnages_v2 WHERE id = ".$info)->fetchColumn();
   }
    if(!empty($info)) {
      $req = $this->db()->prepare("SELECT count(*) FROM personnages_v2 WHERE nom = :nom");
      $req->execute([':nom' => $info]);
      return (bool) $req->fetchColumn();
    } else {
      return false;
    }
  }
  
  public function update(Personnage $perso)
  {
    $req = $this->db()->prepare("UPDATE personnages_v2 SET degats = :degats, timeEndormi = :timeEndormi, atout = :atout WHERE id = :id");
    $req->bindValue(':id', $perso->id(), PDO::PARAM_INT);
    $req->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $req->bindValue(':atout', $perso->atout(), PDO::PARAM_INT);
    $req->bindValue(':timeEndormi', $perso->timeEndormi(), PDO::PARAM_INT);
    $req->execute();
  }
    
  public function get($info)
  {
    
    if(is_int($info)){
 
      $req = $this->db()->query("SELECT * FROM personnages_v2 WHERE id = ".$info);
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
    
    } else {
     
      $req = $this->db()->prepare("SELECT * FROM personnages_v2 WHERE nom = :nom");
      $req->execute([':nom'=> $info]);
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
    }
    
    switch($donnees['type'])
    {
     case 'guerrier' : return new Guerrier($donnees);  break;
     case 'magicien' : return new Magicien($donnees); break;
     default : null;
    }
  }
  
  public function getList($nom)
  {
    $persos = [];
    
    $q = $this->db->prepare('SELECT id, nom, degats, timeEndormi, type, atout FROM personnages_v2 WHERE nom <> :nom ORDER BY nom');
    $q->execute([':nom' => $nom]);
    
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      switch ($donnees['type'])
      {
         case 'guerrier' : $persos[] = new Guerrier($donnees); break;
         case 'magicien' : $persos[] = new Magicien($donnees); break;
         default : null;
      }    
    }
    return $persos;
  }


}



