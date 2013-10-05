<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BorrowModel extends CI_Model {
    
    private $Books;
    private $Book;
    
    public function __construct() {
        parent::__construct();
        
        // loads books.xml.
        $this->Books = simplexml_load_file('././books.xml');
        
    }
    
    private $ID;
    
    public function BorrowBook($UnsanitizedID) {
        if ($this->SanitizeID($UnsanitizedID) == true) {
            $this->ID = $UnsanitizedID;
            
            // Read the xml file. Find the right node. Update that node's attribute. Save the xml file.
            $Node = $this->Books->xpath('items/item[@id="' . $this->ID . '"]');
            //var_dump($Node[0]->borrowedcount);

            // Increment the borrowed count by one.
            $Node[0]->borrowedcount = $Node[0]->borrowedcount + 1;
            
            //echo $Node[0]->borrowedcount;
            
            if ($this->Books->asXML('././books.xml') == true) {
				// asXML returns true if written, false if not.
				
                    return true;
                    // Returning the string true to do a string match. Enumeration would be my ideal choice for this.
                    // Permissions on Books.xml changed to 777.
                    // This method is a terrible way to do this, only one user allowed to borrow a book at a time.
                    // Cannot do this concurrently with multiple users. A sql database can do this.

            } else {
                    return $this->error->E500;
                    // Error 500 if it can't write to file.
            }
			
            
        } else {
            return $this->error->E502;
			// If the wrong course code error 502.
        }
        
        
    }
    
    private function SanitizeID($ID) {
        // Check books.xml for the ID. If it is there allow, else break.
        foreach($this->Books->xpath('items/item') as $book) {
            
           
            // Not forcing uppercase on the book ID incase in future cc100 is not the same as CC100.
            
            // Goes through each book, if the book is found it adds the details to the domdoc.
            // Potential to add multiple books if they have the same ID, that means the source provider has got it wrong though.
            if ($book['id'] == $ID) {
                $this->Book = $book;
                return true;
            }
        }
    }
    
}