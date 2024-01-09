<?php
declare(strict_types=1);
namespace Vocab;

interface WordInserterInterface {

   function insert(string $word, DefinitionsInterface $deface) : int;
}
