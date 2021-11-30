<?php 
//6 FUNCTIONS

//CONNECTION DATABASE
  class Pessoa {
   
    private $pdo;



    public function __construct($dbname,$host,$user,$password) {
    
    try {
        //code...
        $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$password);
    }
     catch (PDOException $e) {
        echo "[ERRO DATABASE: ".$e->getMessage();
         exit();
    }
    catch(Exception $e) {
        echo "[ERRO UNKNOWN] ".$e->getMessage();
         exit();
    
    }
  }
  //FUNCTION GET DATES AND PUSH TO LIST OF CLIENTS
   public function getDate() {
    $res = array();
       $cmd = $this->pdo->query("SELECT * FROM clientes ORDER BY id ASC ");

       $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
       return $res;
   }

   //REGISTER USERS IN DATABASE

   public function registerUser($name,$telephone,$email) {
       
       $cmd = $this->pdo->prepare("SELECT id FROM clientes WHERE email = :e ");
       $cmd->bindValue(":e",$email);
       $cmd->execute();
       if($cmd->rowCount() > 0) {//THE EMAIL HAS BEEN REGISTERED ?
           return false;
       } else {//THE EMAIL NOT HAS BEEN REGISTERED
            $cmd = $this->pdo->prepare("INSERT INTO  clientes (name, telephone, email)VALUES (:n , :t, :e)");
            $cmd->bindValue(":n",$name);
            $cmd->bindValue(":t",$telephone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
       }
   }

    public function deleteUser($id) {
        $cmd = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
      
    }

    //GET DATES USER TO UPDATE
    public function getdatesUser($id) {
        $res = array();

        $cmd = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    //UPDATES DATES IN DATABASE
    public function updateUser($id,$name,$telephone,$email) {

        $cmd = $this->pdo->prepare("UPDATE FROM clientes SET  name = :n, telephone = :t, email = :e, WHERE id = :id ");
        $cmd->bindValue(":n",$name);
        $cmd->bindValue(":t",$telephone);
        $cmd->bindValue(":e",$email);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
      
        
    }
  }



?>