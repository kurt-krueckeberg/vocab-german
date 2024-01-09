<?php
declare(strict_types=1);
namespace Vocab;

class SystranTranslator extends RestApi implements TranslateInterface, DictionaryInterface {

    private \SplFileObject $errorLog;
   /*
    The 'option' query paramter can occur more than once. How do you pass it to Guzzle:
      $this->query['option'] = ['aaa', 'bbb', ... ];????
    */
   
   public function __construct(ConfigFile $c)
   {
      parent::__construct($c, ProviderID::Systran); 

      $this->errorLog = new \SplFileObject("error.log", "w");
   }

   public function getTranslationLanguages() : array
   {
      static $trans_languages = array('method' => "GET", 'route' => "translation/supportedLanguages");

      $contents = $this->request($trans_languages['method'], $trans_languages['route']);
             
      return json_decode($contents, true);
   } 

   final public function getDictionaryLanguages() : array
   {
      static $dict_languages = array('method' => "GET", 'route' => "resources/dictionary/supportedLanguages");

      $contents = $this->request($dict_languages['method'], $dict_languages['route']);
             
      return json_decode($contents, true);    
   } 

   /*
    *  NOTE: Systran requires the language codes to be lowercase.
    *  If the language is not utf-8, the default, then you must speciy the encoding using the 'options' parameter.
    */
   final public function translate(string $text, string $to, string $from="") : string 
   {
       static $trans = array('method' => "POST", 'route' => "translation/text/translate");

       $query = array();
       
       if ($from !== '') 
           $query['source'] = strtolower($from);
       
       $query['target'] = strtolower($to);
       
       $query['input'] = $text;
       
       $contents = $this->request($trans['method'], $trans['route'], ['query' => $query]); 

       return json_decode($contents);
   }

   private function logError(string $err) : void
   {
      $this->errorLog->fwrite($err);
   }

   private function createLookupResult(string $word, array $matches) : false | DefinitionsInterface
   {
      if (empty($matches))  {
    
        $err = "No definitions found for $word";

        $this->logError($err);

        echo "$err\n";

        return false; 

     } else  

       return match($matches[0]['source']['pos']) {
             "noun" => new SystranNounDefinitions($matches),
             "verb" => new SystranVerbDefinitions($matches),
             default => new SystranDefinitions($matches)
       };
   } 

   final public function lookup(string $word, string $src, string $dest) : false | DefinitionsInterface
   {      
      static $lookup = array('method' => "POST", 'route' => "resources/dictionary/lookup");

      $query = array();
      
      if ($src !== '') 
          $query['source'] = strtolower($src);
      
      $query['target'] = strtolower($dest);
      
      $query['input'] = $word;

      $contents = $this->request($lookup['method'], $lookup['route'], ['query' => $query]);
             
      $arr = json_decode($contents, true); // convert JSON string to \stdClass
      
      $matches = $arr['outputs'][0]['output']['matches']; 

       return $this->createLookupResult($word, $matches);
    }
    
     /*
     * Examines $match->source
     * 
     * "source": {
            "inflection": "(pl:Frauen)",
            "info": "f",
            "lemma": "Frau",
            "phonetic": "",
            "pos": "noun",
            "term": "Frau"
        }
     * 
     * and returns array with:
     * 'word' => the word as it will b displayed, with plrual, if noun; with conjugation, if verb.
     * 'pos' => the part of speech.
     * 
     */
    
    private function get_source_info(\stdClass $match) : array
    {        
       if ($match->source->pos == 'noun') {
           /*         
           if ($match->source->info == 'm')
               $gender = 'der';
           else if ($match->source->info == 'n')
               $gender = 'das';
           else  
               $gender = 'die';
                      
           $word = $gender . ' ' . $match->source->lemma;
           
           if (strlen($match->source->inflection) !== 0) 
               
                $word .= ' ' . $match->source->inflection;

           else 
               $word .= " (no plural)";
            */
                       
                  
        } else if ($match->source->pos == "verb") 
            
            $word = $match->source->lemma . ' ' . $match->source->inflection;
        else 
            $word  = $match->source->lemma;   
                
        return array('word' => $word, 'pos' => $match->source->pos, 'gender' => $match->source->info);
   }   
}
