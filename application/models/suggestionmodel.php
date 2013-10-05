<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SuggestionModel extends CI_Model {
    
    private $Nodes = array();
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('Checker');
    }
    
    public function SortSuggestions($a, $b) {
        if ((int)$a['total'] == (int)$b['total']) return 0;
        return ((int)$a['total'] > (int)$b['total']) ? -1 : 1;
        // Everything needs casting to integer. XML treats them as strings,
        // PHP then sees the longest string as the greatest.
        //http://stackoverflow.com/questions/1229324/php-warning-usort-function-usort-invalid-comparison-function-on-sorting
    }
    
    public function BookSuggestions($BookID) {
        
        if ($this->checker->CheckItemExists($BookID) == true) {
        
            $Document = new DOMDocument();
            $Results = $Document->createElement('results');
			$Books = $Document->createElement('books');
            $Suggestionsfor = $Document->createElement('suggestionsfor', $BookID);
            $Suggestions = $Document->createElement('suggestions');

            // Append them in teh order they appear on the page.
            $Document->appendChild($Results);
            $Results->appendChild($Suggestionsfor);
			$Results->appendChild($Books);
            $Books->appendChild($Suggestions);


            $XML = simplexml_load_file('././suggestions.xml');

            foreach($XML->xpath('suggestions') as $book) {
                if ($book['for-id'] == $BookID) {
                    $Node = $book;
                }
            }

            // put each xmlelement into an array.
            // sort the array.
            // then build the domdoc nodes and append.

            if (isset($Node)) {
                foreach($Node->xpath('item') as $suggestion) {
                    $this->Nodes[] = $suggestion;
                }

                // if nodes > 1 index do the sort - no point otherwise.
                usort($this->Nodes, array( $this, 'SortSuggestions' ));

                foreach($this->Nodes as $Node) {
                    $item = $Document->createElement('isbn', $Node['isbn']);
                    $item->setAttribute('id', $Node);
                    $item->setAttribute('common', $Node['common']);
                    $item->setAttribute('before', $Node['before']);
                    $item->setAttribute('same', $Node['same']);
                    $item->setAttribute('after', $Node['after']);
                    $item->setAttribute('total', $Node['total']);
                    $item->setAttribute('id', $Node);
                    $Suggestions->appendChild($item);

                    // If you add the ISBN *not* as an attribute then the attributes are lost when loaded in JSON.
                    // Either:
                    //      a) Keep to the assigned XML and lose the data.
                    //      b) Adapt the XML structure and keep the data.

                }
            }

            return $Document->saveXML();
        } else {
            return $this->error->E502;
        }
        
    }
    
}
?>