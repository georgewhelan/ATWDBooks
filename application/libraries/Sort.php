<?php

class Sort {
    
    public function __construct() {
        
    }
    
    public function SortSuggestions($a, $b) {
        if ((int)$a['total'] == (int)$b['total']) return 0;
        return ((int)$a['total'] > (int)$b['total']) ? -1 : 1;
        // Everything needs casting to integer. XML treats them as strings,
        // PHP then sees the longest string as the greatest.
        //http://stackoverflow.com/questions/1229324/php-warning-usort-function-usort-invalid-comparison-function-on-sorting
    }
    
//    There are two funtions here doing nearly the same thing. My mistake, I only thought there was on sort function then
//    this method of sorting was the one I chose except that it takes in objects, not integers and needs the properties changed.
//    
    public function SortBorrowed($a, $b) {
        if ((int)$a['borrowedcount'] == (int)$b['borrowedcount']) return 0;
        return ((int)$a['borrowedcount'] > (int)$b['borrowedcount']) ? -1 : 1;
    }
    
    public function USort($Name, $Array) {
        usort($Name, array( $this, 'SortSuggestions' ));
    }
    
}
?>