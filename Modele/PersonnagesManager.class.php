<?php
class PersonnagesManager
{
  // déclaration des attribus
  private $_db; // Instance de PDO
  
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
         $this->_db = $db;
    }
  }
  
  //getter $db
  public function db()
  {
    return $this->_db;
  }
  
  
  // fonctionnalités de l'objet
  
  public function count()
  {
   return $this->db()->query('SELECT count(*) FROM personnages')->fetchColumn();
  }
  
  // Ajout de nouveaux personnages
  public function add(Personnage $perso)
  {
    $req = $this->db()->prepare("INSERT INTO personnages (nom) VALUES (:nom)");
    $req->execute([':nom' => $perso->nom()]);
    $perso->hydrate([
                     'id' => $this->db()->lastInsertId(),
                     'nom' => $perso->nom(),
                     'degats' => 0
                     ]);
  }
  
  public function delete(Personnage $perso)
  {
    $this->db()->exec("DELETE FROM personnages WHERE id = ".$perso->id());
   }
  
 
  public function exists($info)
  {
  
   if (is_int($info)){
     return (bool) $this->_db->query("SELECT count(*) FROM personnages WHERE id = ".$info->id())->fetchColumn();
   }
    if(!empty($info)) {
      $req = $this->db()->prepare("SELECT count(*) FROM personnages WHERE nom = :nom");
      $req->execute([':nom' => $info]);
      $result = $req->fetchColumn();
      return (bool) $result;
    } else {
      return false;
    }
  }
  
  public function update(Personnage $perso)
  {
    $req = $this->db()->prepare("UPDATE personnages SET degats = :degats WHERE id = :id");
    $req->bindValue(':id', $perso->id(), PDO::PARAM_INT);
    $req->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $req->execute();
  }
    
  public function get($info)
  {
    if(is_int($info)){
      $req = $this->db()->query("SELECT * FROM personnages WHERE id = ".$info);
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      //$perso = new Personnage($donnees);
    } else {
      $req = $this->db()->prepare("SELECT * FROM personnages WHERE nom = :nom");
      $req->execute([':nom'=> $info]);
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      //$perso = new Personnage($donnees);
    }
    if(!empty($donnees))
    {
     $perso = new Personnage($donnees);
     return $perso;
    }
    
  }
  
  public function getList($nom)
  {
    $persos = [];
    
    $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
    $q->execute([':nom' => $nom]);
    
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new Personnage($donnees);
    }
    
    return $persos;
  }


}



