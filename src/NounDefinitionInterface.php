<?php
declare(strict_types=1);
namespace Vocab;

interface NounDefinitionInterface extends DefinitionInterface { 

  function get_gender() : Gender;
  function get_plural() : string;
};

