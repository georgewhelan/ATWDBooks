<?php

class URLRetriever {
    
    public $URI;
    
    public function __construct() {
        $this->URI = $_SERVER['REQUEST_URI'];
    }
    
}
?>
