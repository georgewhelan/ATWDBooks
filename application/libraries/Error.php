<?php

class Error {
    
    public $E500 = '<results><error id="500" message="Service Error" /></results>';
	public $C500 = '<h1>Oops. Error 500.</h1><p>A service error has happened.</p>';
    
    public $E501 = '<results><error id="501" message="Invalid Course Code" /></results>';
	public $C501 = '<h1>Oops. Error 501.</h1><p>An invalid course code has been provided.</p>';
    
    public $E502 = '<results><error id="502" message="Invalid Item ID" /></results>';
	public $C502 = '<h1>Oops. Error 502.</h1><p>An invalid item/book ID has been provided.</p>';
   
    public $E503 = '<results><error id="503" message="URL pattern not recognised" /></results>';
	public $C503 = '<h1>Oops. Error 503.</h1><p>The URL pattern is not recognised.</p>';
    
    // Overwriting the default errors with these. Public properties (not methods) since these are constant.
	// XML and HTML errors depending on service or client.
}
?>