<?php

class SamplesInserter implements InsertRowInterface {
    
   private \PDOStatement $insert; 
   private string $sample;
   private int $word_id;

   private static $exists_sql = "insert into samples values(:sample, :word_id)";

   public function __construct(\PDO $pdo)
   {
      $this->insert = $pdo->prepare(self::$insert_sql); 

      $this->insert->bindParam(':sample', $this->expr, \PDO::PDO_PARAM_STR);
 
      $this->insert->bindParam(':word_id', $this->word_id, \PDO::PDO_PARAM_INT); 
   }

   public function insert(DefinitionsInterface $defn, int $word_id) : bool
   {
      $this->sample= $sample;

      $this->word_id  = $word_id;

      return $this->insert->execute();
   }
}
