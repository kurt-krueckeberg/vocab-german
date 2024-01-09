<?php
declare(strict_types=1);
namespace Vocab;

class Database /* implements DatabaseInterface */ { 

   private \PDO $pdo;

   private \PDOStatement $word_exists_stmt; 
  
   private static $word_exists_sql = "select 1 from words where word=:new_word";
   private string $new_word = '';

   private $obj_storage = array();

  // Note: We don't instantiate separte WordInserter instances for Adj, Adv, Conj and Other. 
  // All these part of speech return the same int value for getIndex(). 
   private function getInserter(Word $Word)
   {
      $className = $Word->getInserterClass();

      if (!isset($this->obj_storage[$className])) {

         $Inserter = new $className($this->pdo);

         $this->obj_storage[$className] = $Inserter;
      }

      return $this->obj_storage[$className];
   }

   public function __construct(string $dsn, string $username, string $pw)
   {
       $pdo = new \PDO($dsn, $username, $pw);

       $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);   

       $this->pdo = $pdo;

       $this->defnsInserter = new DefinitionsInserter($this->pdo);

       $this->word_exists_stmt = $pdo->prepare(self::$word_exists_sql); 

       $this->word_exists_stmt->bindParam(':new_word', $this->new_word, \PDO::PARAM_STR); 
   }

   /*
     insert_word(string $word) algorithm:

     insert word into words and save the word.id

     if (noun) 
         insert gender, plural and word.id into nouns_data

     elseif (verb)
         insert conjugated and word.id verb into verbs_data

    insert each definition and word.id into defns  
    insert each expression and word.id into exprs.
     
    */
   
   public function word_exists(string $word) : bool
   {
      $this->new_word = $word;

      $rc = $this->word_exists_stmt->execute();

      if ($rc === false) 
          
          throw new \Exception('SQL statement to test if word exist failed.');
      
      $rc = $this->word_exists_stmt->fetch(\PDO::FETCH_NUM);
          
      return ($rc === false) ? false : true;            
   }

   public function insert(string $word, DefinitionsInterface $deface) : int | false
   {       
      $Inserter = $this->getInserter($deface->get_pos());

      $id = $Inserter->insert($word, $deface);

      $this->defnsInserter = new DefinitionsInserter($this->pdo);

      $this->defnsInserter->insert($deface,  $id);

      return true;
   }
}
