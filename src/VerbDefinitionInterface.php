<?php
declare(strict_types=1);
namespace Vocab;

interface VerbDefinitionInterface extends DefinitionInterface { 

  function get_conjugation() : string | bool;
};

