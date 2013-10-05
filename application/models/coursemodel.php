<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CourseModel extends CI_Model {
    
    public $Items = array();
    
    public function __construct() {
        parent::__construct();
        $this->load->library('Checker');
    }
    
    
    
    public function SortBorrowed($a, $b) {
        if ((int)$a->borrowedcount == (int)$b->borrowedcount) return 0;
        return ((int)$a->borrowedcount > (int)$b->borrowedcount) ? -1 : 1;
    }


    // Lowercase variables are used for variables only used in this scope.
    // Uppercase are used for persistent variables or class variables.

    
    public function CourseBooks($CourseID) {
        
        if ($this->checker->CheckCourseExists($CourseID) == true) {
            
            //usort($Name, array( $this, 'SortSuggestions' ));
            
            $Document = new DOMDocument();
            $Results = $Document->createElement('results');
            $Course = $Document->createElement('course', $CourseID);
            $Books = $Document->createElement('books');
            $Document->appendChild($Results);
            $Results->appendChild($Course);
            $Results->appendChild($Books);

            //$XML = simplexml_load_file('http://www.cems.uwe.ac.uk/~pmatthew/ATWD/assignments/data/books.xml');
            $XML = simplexml_load_file('././books.xml');

            foreach($XML->xpath('items/item') as $item) {
                // Go through each book. Need to keep the $item as a handle back to this book if there is a match.
                foreach ($item->courses->course as $course) {
                    if ($course == $CourseID) {
                        $this->Items[] = $item;
//                    Go through each course on the book, if it matches add the ITEM to the array.
                    }
                }
            }
            
            usort($this->Items, array($this, 'SortBorrowed'));
            
            foreach($this->Items as $Item) {
                $Book = $Document->createElement('book');
                $Book->setAttribute('id', $Item['id']);
                $Book->setAttribute('title', $Item->title);
                $Book->setAttribute('isbn', $Item->isbn);
                $Book->setAttribute('borrowedcount', $Item->borrowedcount);
                $Books->appendChild($Book);
            }
            
            return $Document->saveXML();

        } else {
            // This triggers if a course code is incorrect.
            return $this->error->E501;
        }
    }

}
?>