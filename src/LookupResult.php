<?php
declare(strict_types=1);
namespace Vocab;

/*
 This class functions like an array without keys. It has three private member variables

 1. string $word - the word that was looked up in the dictionary
 2. string $pos  - the part of speech
 3. string $definitions - an array of definitions each of which might
    contain a subarray of expressions associated with the particular definition.
 */

class  LookupResult extends \ArrayIterator {
   
   private string $word; // original word looked up in dictonary.

   public function __construct(string $word, array $matches)
   {
      parent::__construct($matches);
   }

   public function current() : DefinitionInterface 
   {
      $current = parent::current();

      $x = SystranDefinition::create($current);       
    
      return $x;
   }
}
