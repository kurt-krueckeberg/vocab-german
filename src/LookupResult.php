<?php
declare(strict_types=1);
namespace Vocab;

class  LookupResult extends \ArrayIterator {
   
   private string $word; // original word looked up in dictonary.

   public function __construct(string $word, array $matches)
   {
      parent::__construct($matches);
      $this->word = $word;
   }

   public function current() : DefinitionInterface 
   {
      $current = parent::current();

      return SystranDefinition::create($current);       
   }
}
