<?php
declare(strict_types=1);
namespace Vocab;

interface DefinitionsInserterInterface {

   function insert(int $word_id, DefinitionsInterface $deface) : bool;
}
