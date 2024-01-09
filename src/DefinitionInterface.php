<?php
declare(strict_types=1);
namespace Vocab;

interface DefinitionInterface { 

  function get_pos() : Word;

  function get_definitions() : array;
}

