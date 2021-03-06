<?php 
class PDOConfig extends PDO
{ 
    protected $engine; 
    protected $host; 
    protected $database; 
    protected $user; 
    protected $pass;
    protected $charset; 
    
    public function __construct($db,$user,$pw)
    { 
        if(isset($db) && isset($user)){
        $this->engine = 'mysql'; 
        $this->host = 'localhost'; 
        $this->database = $db;
        $this->charset = 'utf8';
        $this->user = $user; 
        $this->pass = $pw; 
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host.";charset=".$this->charset;
        parent::__construct( $dns, $this->user, $this->pass, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING) );
        } else {
            echo "Attention parametres incomplet";
        }
    } 
} 
?>