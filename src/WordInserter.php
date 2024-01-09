<?php
declare(strict_types=1);
namespace Vocab;

class WordInserter implements WordInserterInterface {
   
   private \PDO $pdo;
   
   private static $insert_word_stmt_sql = "insert into words(word, pos) values(:word, :pos)";

   private \PDOStatement $insert_word_stmt; 
   private string $pos = '';
   private string $word = '';
   
  /*
    Input is the SQL for the prepared statement with :args
    The :args are detected and bind is called for each in order.
   */ 
   public function __construct(\PDO $pdo)
   {
      $this->pdo = $pdo;
      
      $this->insert_word_stmt = $pdo->prepare(self::$insert_word_stmt_sql); 

      $this->insert_word_stmt->bindParam(':word', $this->word, \PDO::PARAM_STR);
 
      $this->insert_word_stmt->bindParam(':pos', $this->pos, \PDO::PARAM_STR); 
   }
    
   public function insert(string $word, DefinitionsInterface $deface) : int
   {
      $this->word = $word;
      
      $this->pos  = $deface->get_pos()->getString();
      
      $rc = $this->insert_word_stmt->execute();

      /*
       TODO: 
lastInsertId() does not return the primary key; instead it returns the name of the sequence object -- whatever that is -- from
which the ID should be returned.

Someone added this comment concerning MySQL:

"With no argument, LAST_INSERT_ID() returns a BIGINT UNSIGNED (64-bit) value representing the first automatically generated value
successfully inserted for an AUTO_INCREMENT column as a result of the most recently executed INSERT statement."
       */

      $id = (int) $this->pdo->lastInsertId();

      return $id;
   }
}
