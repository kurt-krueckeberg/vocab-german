#!/usr/bin/env php
<?php
declare(strict_types=1);
use \SplFileObject as File;

use Vocab\{SystranTranslator, LeipzigSentenceFetcher, FileReader, Database, BuildHtml, ConfigFile, ProviderID, Word};

include 'vendor/autoload.php';

if ($argc != 3) {

  echo "Enter the vocabulary words input file, followed by html file name (without .html).\n";
  return;

} else if (! file_exists($argv[1]))  {

  echo "Input file does not exist.\n";
  return;
}

try {
    
    $fwords = $argv[1];
 
    $file = new FileReader($fwords);
    
    $c = new ConfigFile('config.xml');
    
    $sys = new SystranTranslator($c);
    
    $leipzig = new LeipzigSentenceFetcher($c);
   
    $dsn = 'mysql:dbname=vocab;host=127.0.0.1';

    $db = new Database($dsn, 'kurt', 'kk0457');
    
    foreach ($file as $word) {
       
       $results = $sys->lookup($word, 'de', 'en');

       if ($results === false) continue;
       
       if ($db->word_exists($word) === false) {
         
           echo "About to dump defintions for $word.\n";      

           foreach($results as $result) { 
               
             // definition is a SystranVerb- Noun- or WordDefinition. It is not a array!  
             var_dump($result);

             echo "---------------\n";

            //  echo "source->lemma = " . $result['definition'] . "\n";

            //  echo "Number of expressions = "   . count($result['expressions']) . "\n";
           } 
      }
   } 
} catch (Exception $e) {

      echo "Exception: message = " . $e->getMessage() . "\nError Code = " . $e->getCode() . "\n";
  } 
