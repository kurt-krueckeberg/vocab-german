<?php
declare(strict_types=1);
namespace Vocab;

interface WordExistsInterface {

   function word_exists(string $word) : bool;
}
