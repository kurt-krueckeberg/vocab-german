<?php
declare(strict_types=1);
namespace Vocab;

class SystranDefinition implements DefinitionInterface { 

  private array $match;

/* Match object
 is an array like this match object:
{
  "auto_complete": "boolean",
  "model_name": "string",
  "source": {
    "inflection": "string",
    "info": "string",
    "lemma": "string",    <---
    "phonetic": "string",
    "pos": "string",      <--- 
    "term": "string"      <---
  },
  "target": {
    "context": "string",
    "domain": "string",
    "entry_id": "string",
    "expressions": [  <-- Array
      {
        "source": "string",  <-- expressions
        "target": "string"   <-- its translation
      }
    ],
    "invmeanings": [
      "string"
    ],
    "lemma": "string",
    "rank": "string",
    "synonym": "string",
    "variant": "string"
  },
  "other_expressions": [
    {
      "context": "string",
      "source": "string",
      "target": "string"
    }
  ]
}
*/

  public static function create(array $match) : DefinitionInterface
  {
      return match($match['source']['pos']) {

         'noun' => new SystranNounDefinition($match),
         'verb' => new SystranVerbDefinition($match),
         default => new SystranDefinition($match) 
      };
  } 

  public function __construct(array $match)
  {
     $this->match = $match; 
  }

  public function get_pos() : Word
  {
   return match ($this->match['source']['pos']) {
           'noun' => Word::Noun,
           'verb' => Word::Verb,
           'conj' => Word::Conj,
           'adv'  => Word::Adv,
           'adj'  => Word::Adj,
           default => Word::Other 
     };
  }

 /*
  * Returns an array of subarrays, each with two keys: 'definition' and 'expressions'.
  *
  * Each array element of $this->std->targets has:
  *  lemma -- that holds the definition, and
  *  expressions -- which are associated expression for that definition.
  */
  public function get_definitions() : array 
  {
     $res = array();
     
     foreach($match['targets'] as $value) {
           
         $res[] = array('definition' => $value['lemma'],  'expressions' => $value['expressions']);
      }
    
     return $res;     
  }
}
