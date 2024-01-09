<?php

class InsertStmt {
    
   private \PDOStatement $stmt;

   /*
     Input is the SQL for the prepared statement with :args
     The :args are detected and bind is called for each in order.
    */ 
   public function __construct(\PDO $pdo, string $presql)
   {
       $this->stmt = $pdo->prepare($presql);
   }
   
   public function stmt() { return $this->stmt; }

   public function insert(array  $parms) : bool
   {
      return $this->stmt->execute($parms);
   }
}
