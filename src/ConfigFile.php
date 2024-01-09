<?php
declare(strict_types=1);
namespace Vocab;

//use Vocab\XmlConfigFile;
/*
  Provides access to config.xml through static method, get_config(string provider)
 */
class ConfigFile {

   private \SimpleXMLElement $xml;

   static string $query_fmt =  "/providers/provider[@name='%s']"; 

   public function __construct(string $xml_name)
   {   
     $this->xml = simplexml_load_file($xml_name);
   }

    public function get_config(ProviderID $id) : array
    {
        $simplexml = $this->get_xml_element($id->get_provider());

        $r = array();

        $r['base_uri'] = (string) $simplexml->endpoint;
        
        $r['headers'] = array();

        foreach($simplexml->headers->header as $header) {

          $key = (string) $header['key'];

          $r['headers'][$key] = (string) $header;              
        }

      return $r;
    }
 
   public function get_xml_element(string $name) : \SimpleXMLElement
   {
      $query = sprintf(self::$query_fmt, $name); 
    
      $response = $this->xml->xpath($query);
    
      return $response[0];  
   }
}
