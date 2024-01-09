<?php
declare(strict_types=1);
namespace Vocab;

interface DefinitionsInserterInterface {

   function insert(DefinitionsInterface $deface, int $word_id) : bool;
}
