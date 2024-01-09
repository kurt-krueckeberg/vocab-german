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
    
    $dsn = 'mysql:dbname=vocab;host=127.0.0.1';

    $db = new Database($dsn, 'kurt', 'kk0457');
    
    foreach ($file as $word) {
       
       $defs = $sys->lookup($word, 'de', 'en');

       if ($defs === false)
          echo "$word has no definition.\n";

       else {

          echo "Part of speech of $word = " . $defs->get_pos()->getString() . "\n";
          
          $a = $defs->get_definitions();

          if ($defs->get_pos() == Word::Verb)

             echo "Conjugation for verb $word is " . $defs->get_conjugation() . "\n";
       }

       echo "The definitions of $word are:\n";

       print_r($a);

       //print_r($defs); 
       //--echo "Definitions:\n";
       //--print_r($defs);
    }
 
  } catch (Exception $e) {

      echo "Exception: message = " . $e->getMessage() . "\nError Code = " . $e->getCode() . "\n";
  } 
