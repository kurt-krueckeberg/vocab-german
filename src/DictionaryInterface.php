<?php
declare(strict_types=1);
namespace Vocab;

interface DictionaryInterface {
   
   public function lookup(string $str, string $src_lang, string $dest_lang) : false | LookupResult;
   public function getDictionaryLanguages() : array;
}
