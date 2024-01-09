<?php
declare(strict_types=1);
namespace Vocab;

class SystranNounDefinition extends SystranDefinition implements NounDefinitionInterface { 

    
  public function __construct(array $matches)
  {
     parent::__construct($matches);     
  }
 
  public function get_gender() : Gender
  {
     $m = $this->matches();
     
     return match (m['source']['info']) {
 
        'm' => Gender::Mas,
        'f' => Gender::Fem,
        'n' => Gender::Neu
     };
  }
 
  public function get_plural() : string
  {
     // Strip of the beginning "(pl:" and the ending ")"
     
     $x = substr($this->matches()['source']['inflection'], strpos($this->matches['source']['inflection'], ':') + 1, -1); 
     
     return $x; 
  }
}

