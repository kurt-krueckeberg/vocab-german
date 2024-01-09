<?php
declare(strict_types=1);
namespace Vocab;

interface NounDefinitionsInterface extends DefinitionsInterface { 

  function get_gender() : Gender;
  function get_plural() : string;
};

