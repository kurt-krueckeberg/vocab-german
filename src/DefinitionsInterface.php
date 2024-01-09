<?php
declare(strict_types=1);
namespace Vocab;

interface DefinitionsInterface { 

  function get_pos() : Word;

  function get_definitions() : array|null;
}

