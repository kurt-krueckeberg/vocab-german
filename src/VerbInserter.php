<?php
declare(strict_types=1);
namespace Vocab;

class VerbInserter extends WordInserter {
    
   private \PDOStatement $verb_insert_stmt; 
   private string $conjugation = '';
   private int $word_id = 0;

   private static $insert_sql = "insert into verbs_data(conjugation, word_id) values(:conjugation, :word_id)";

   private \PDO $pdo; 

   /*
     Input is the SQL for the prepared statement with :args
     The :args are detected and bind is called for each in order.
    */ 
   public function __construct(\PDO $pdo)
   {
      parent::__construct($pdo);

      $this->pdo = $pdo;  

      $this->verb_insert_stmt = $pdo->prepare(self::$insert_sql); 

      $this->verb_insert_stmt->bindParam(':conjugation', $this->conjugation, \PDO::PARAM_STR);

      $this->verb_insert_stmt->bindParam(':word_id', $this->word_id, \PDO::PARAM_INT); 
   }

   public function insert(string $word, DefinitionsInterface $deface) : int
   {
       // insert the new word into the SQL words table.
       $id = parent::insert($word, $deface);

       // insert the conjugation into the verbs_data table.
       // TODO: What if the conjugation is null?
       $this->conjugation = $deface->get_conjugation();

       $this->word_id = $id;
 
       $this->verb_insert_stmt->execute();

       $id = (int) $this->pdo->lastInsertId();

       return $id;
   }
}
