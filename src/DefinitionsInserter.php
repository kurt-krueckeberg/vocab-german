<?php
declare(strict_types=1);
namespace Vocab; 

class DefinitionsInserter implements DefinitionsInserterInterface {
    
   private \PDOStatement $insert_defn_stmt; 
   private string $defn = '';

   private static $insert_defn_sql = "insert into defns(defn, word_id) values(:defn, :word_id)";
    
   private \PDOStatement $insert_expr_stmt; 
   private string $expr = '';

   private static $insert_exprs_sql = "insert into exprs(expr, defn_id) values(:expr, :defn_id)";

   private int $word_id = -1;

   public function __construct(\PDO $pdo)
   {
      $this->insert_defn_stmt = $pdo->prepare(self::$insert_defn_sql); 

      $this->insert_defn_stmt->bindParam(':defn', $this->defn, \PDO::PARAM_STR);
 
      $this->insert_defn_stmt->bindParam(':word_id', $this->word_id, \PDO::PARAM_INT); 

      $this->insert_expr_stmt = $pdo->prepare(self::$insert_exprs_sql); 

      $this->insert_expr_stmt->bindParam(':expr', $this->expr, \PDO::PARAM_STR);
 
      $this->insert_expr_stmt->bindParam(':word_id', $this->word_id, \PDO::PARAM_INT); 
   }

   public function insert(int $word_id, DefinitionsInterface $deface) : bool
   {
      // Insert each definition and its associated expressions
      $definitions = $deface->get_definitions();
      
      foreach ($definitions as $key => $arr)  {
       
        $this->defn = $arr['definition'];

        $this->word_id = $word_id; // <---

        $rc =$this->insert_defn_stmt->execute();
        
        // TODO: Insert the expressions also.
      }
      return $rc;
   }
}
