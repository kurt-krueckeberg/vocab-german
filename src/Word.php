<?php
declare(strict_types=1);
namespace Vocab;

interface WordInterface {

   function getInserterClass() : string;
   function getString() : string;
}

/*
enum Word : string { 
 
   case Noun = 'noun';
   case Verb = 'verb';
   case Adj = 'adj';
   case Adv = 'adv';
   case Conj = 'conj';
   case Other = 'other';
};
*/
enum Word implements WordInterface { 
 
   case Noun;
   case Verb;
   case Adj;
   case Adv;
   case Conj;
   case Other;

   public function getInserterClass() : string
   {
       return match($this) {
           Word::Noun  => 'Vocab\NounInserter',
           Word::Verb  => 'Vocab\VerbInserter',
           Word::Adj, Word::Adv, Word::Conj, Word::Other => 'Vocab\WordInserter'
       }; 
   }

   public function getString() : string
   {
       return match($this) {
           Word::Noun  => 'noun',
           Word::Verb  => 'verb',
           Word::Adj => 'adj',
           Word::Adv => 'adv',
           Word::Conj => 'conj',
           Word::Other => 'other'
       }; 
   }
}
