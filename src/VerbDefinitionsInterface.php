<?php
declare(strict_types=1);
namespace Vocab;

interface VerbDefinitionsInterface extends DefinitionsInterface { 

  function get_conjugation() : string | bool;
};

