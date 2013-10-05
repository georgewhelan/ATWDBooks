<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formatter {
    
    private $FormatRaw;
    
    public $Header = 'text/xml';
    public $Result;
    
    private $JSONHeader = 'application/json';
    private $JSON = false;
    private $XML = false;
	private $UnrecognisedFormat;
    
    private $CI;
    
    public function __construct($params) {
        $this->CI =& get_instance();
        $this->CI->load->library('JSON');
        
        
        $this->FormatRaw = $params['Format'];
        
        $this->FormatRaw = strtolower($this->FormatRaw);
        
        switch($this->FormatRaw) {
            case 'xml' :
                //$this->Header = $this->XMLHeader;
                $this->XML = true;
                // Default result is XML.
                break;
            case 'json' :
                $this->Header = $this->JSONHeader;
                $this->JSON = true;
                //$this->Result = $JSON->Indent($JSON->Encode($result));
                break;
			//case default:
			//	$this->UnrecognisedFormat = true;
        }
        
    }
    
    public function Result($result) {
        $this->Result = $result;

        
        // Checks through the format options, if either JSON or XML it is allowed
        // if it is not either of those it errors.
        
        if ($this->JSON == true) {
            $this->Result = $this->CI->json->Encode($this->Result);
            $this->Result = $this->CI->json->Indent($this->Result);
            return $this->Result;
        } elseif ($this->XML == true) {
            return $this->Result;
        } else {
            return $this->CI->error->E502;;
            //should be returning false is neither xml or json is noted.
        }
        
        
    }
    
   
//    if ($Format == 'xml') $data['header'] = 'text/xml';
//            
//            if ($Format == 'json') {
//                
//                
//                
//                $data['header'] = 'application/json';
//                $simplexml = simplexml_load_string($result);
//                $json = $this->json->Encode($simplexml);
//                $json = $this->json->Indent($json);
//                $data['result'] = $json;
//            }
//    
    
}
?>
