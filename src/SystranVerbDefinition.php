<?php
declare(strict_types=1);
namespace Vocab;

class SystranVerbDefinition extends SystranDefinition implements VerbDefinitionInterface { 

  //-- private int $match_index = -1;

/*
In German certain verbs also have prefix forms.
An example is 'schwimmen', which also has the form 'herunschwimmin' and 'wegschwimmen'. These prefix forms
will have one or more definitions with zero or more associated expressions. 

These prefix formw will not have a conjugation. Only the definition match (in matches) for 'schwimmen' will have the conjugation for
schwimmen.
*/

  public function __construct(array $match)
  {
     parent::__construct($match);

     /*
     foreach($matches as $key => $match) {

         if ($match['source']['lemma'] == $match['source']['term'] || !empty($match['source']['inflection']) ) {

            $this->match_index = $key; 
            break;
         }
     }
      * 
      */
  }
 
  // Word->name returns the string, say, of 'noun'
  public function get_conjugation() : string | false
  {
    $conj = $this->matches[$this->match_index]['source']['inflection'];
    return empty($conj) ? false : $conj;
  }
}

