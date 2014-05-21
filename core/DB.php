<?php

class DB {  
    
    private static $_instance = null;
    
    private $pdo,
    		$host,
    		$dbname,
    		$user,
    		$pass;
          	
    
    private function __construct(){
        try{
            $this->host = "localhost";
			$this->dbname = "imdb";
			$this->user = "root";
			$this->pass = "";
	
			$this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    
    //returns database instance (singleton)
    public static function getInstance() {
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function select($sql) {
        $stmt = $this->pdo->query($sql); 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPDO() {
    	return $this->pdo;
    }
}

?>