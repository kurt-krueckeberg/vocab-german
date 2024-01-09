<?php
declare(strict_types=1);
namespace Vocab; 

class DefinitionsInserter implements DefinitionsInserterInterface {
   
   private static $insert_defn_sql = "insert into defns(defn, word_id) values(:defn, :word_id)";
   private \PDOStatement $insert_defn_stmt; 
   private string $defn = '';
   private int $word_id = -1;
      
   private static $insert_exprs_sql = "insert into exprs(expr, defn_id) values(:expr, :defn_id)";
   private \PDOStatement $insert_expr_stmt; 
   private string $expr = '';

   public function __construct(\PDO $pdo)
   {
      $this->insert_defn_stmt = $pdo->prepare(self::$insert_defn_sql); 

      $this->insert_defn_stmt->bindParam(':defn', $this->defn, \PDO::PARAM_STR);
 
      $this->insert_defn_stmt->bindParam(':word_id', $this->word_id, \PDO::PARAM_INT); 

      $this->insert_expr_stmt = $pdo->prepare(self::$insert_exprs_sql); 

      $this->insert_expr_stmt->bindParam(':expr', $this->expr, \PDO::PARAM_STR);
 
      $this->insert_expr_stmt->bindParam(':word_id', $this->word_id, \PDO::PARAM_INT); 
   }

   private function insert_expressions(int $defn_id, array $expressions) : bool
   {
       foreach ($expressions as $expression) {
        
         $this->expr = $expression;
        
         $this->defn_id = $defn_id;
        
         $rc = $this->insert_expr_stmt->execute();
         
         if ($rc === false)
             return $rc;
       }
       
       return true;
   }

   public function insert(int $word_id, DefinitionsInterface $deface) : bool
   {
      // Insert each definition and its associated expressions
      $definition_results = $deface->get_definitions();
      
      foreach ($definition_results as $array)  {
       
        $this->defn = $array['definition'];

        $this->word_id = $word_id; 

        $rc =$this->insert_defn_stmt->execute();
        
        if ($rc === false)
            return false;

        $defn_id = (int) $this->pdo->lastInsertId();
        
        if (count($array['expressions']) != 0)

           $rc = $this->insert_expressions($defn_id, $array['expressions']);        
      }
      
      return $rc;
   }
}
