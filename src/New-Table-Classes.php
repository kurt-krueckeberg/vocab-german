<?
class WordTable implements WordInserterInterface {

   public function word_exists(string $word) // not in WordInserterInterface 
   {
   }
   public function word_exists(string $word)
}

class VerbTable extends WordTable implements VerbInserterInterface {

   public function word_exists(string $word) // not in WordInserterInterface 
   {
   }
   public function word_exists(string $word) // over rides to insert verb data
}

class VerbTable extends WordTable implements NounInserterInterface {

   public function word_exists(string $word) // not in WordInserterInterface 
   {
   }
   public function word_exists(string $word) // over rides to insert verb data
}
