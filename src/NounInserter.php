<?php
declare(strict_types=1);
namespace Vocab;

class NounInserter extends WordInserter {
    
   private \PDOStatement $nouns_data_insert; 
   private string $gender = '';
   private string $plural = '';
   private int $word_id = -1;

   private static $insert_sql = "insert into nouns_data(gender, plural) values(:gender, :plural, :word_id)";

   /*
     Input is the SQL for the prepared statement with :args
     The :args are detected and bind is called for each in order.
    */ 
   public function __construct(\PDO $pdo)
   {
      parent::__construct($pdo);

      $this->nouns_data_insert = $pdo->prepare(self::$insert_sql); 

      $this->nouns_data_insert->bindParam(':gender', $this->gender, \PDO::PARAM_STR);
 
      $this->nouns_data_insert->bindParam(':plural', $this->plural, \PDO::PARAM_STR); 

      $this->nouns_data_insert->bindParam(':word_id', $this->word_id, \PDO::PARAM_INT); 
   }
   
   public function insert(string $word, DefinitionsInterface $deface) : int
   {
       $id = parent::insert($word, $deface);
       
       $temp = $deface->get_gender();
               
       $x = $temp->value;
       
       $plural = $deface->get_plural();
       
       $this->insert_noun_data($deface->get_gender(), $deface->get_plural(), $id);

       return $id;
   }

   public function insert_noun_data(string $gender, string $plural, int $word_id) : bool
   {
      $this->gender = $gender;

      $this->plural  = $plural;

      $this->word_id = $word_id;
 
      return $this->nouns_data_insert->execute();
   }
}
