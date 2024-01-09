<?php
declare(strict_types=1);
namespace Vocab;

class SystranDefinitions implements DefinitionsInterface { 

  public readonly array $matches;
 
  public function __construct(array $matches)
  {
     $this->matches = $matches; 
  }

  public function get_pos() : Word
  {
   return match ($this->matches[0]['source']['pos']) {
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
  public function get_definitions() : array | null
  {
     $res = array();
     
     foreach($this->matches as $key => $match) {

        foreach($match['targets'] as $value) {
           
           $res[] = array('definition' => $value['lemma'],  'expressions' => $value['expressions']);
        }
     }
     return $res;     
 }
}
