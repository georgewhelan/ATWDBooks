<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DetailModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('Checker');
    }
    
    public function BookDetail($BookID) {
        
        if ($this->checker->CheckItemExists($BookID) == true) {
        
            $Document = new DOMDocument();
            $Results = $Document->createElement('results');
            $Document->appendChild($Results);

            $XML = simplexml_load_file('././books.xml');

            foreach($XML->xpath('items/item') as $book) {
                // Goes through each book, if the book is found it adds the details to the domdoc.
                // Potential to add multiple books if they have the same ID, that means the source provider has got it wrong though.
                if ($book['id'] == $BookID) {
                    $Book = $Document->createElement('book');
                    $Book->setAttribute('id', $book['id']);
                    $Book->setAttribute('title', $book->title);
                    $Book->setAttribute('isbn', $book->isbn);
                    $Book->setAttribute('borrowedcount', $book->borrowedcount);
                    $Results->appendChild($Book);
                }
            }

            return $Document->saveXML();
        } else {
            return $this->error->E502;
        }
        
        
    }
    
    
}
?>