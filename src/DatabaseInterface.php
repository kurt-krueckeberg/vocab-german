<?php
declare(strict_types=1);
namespace Vocab;

interface DatabaseInterface { 

    function insert(string $word, DefinitionsInterface $def) : int|bool;
}
