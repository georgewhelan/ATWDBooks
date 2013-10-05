<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data = array();
    }
    
    public function GetCourseBooks($CourseID, $Format) {
		
		$params = array('Format' => $Format);
        $this->load->library('Formatter', $params);
		
        if ($this->ValidateURL($CourseID, $Format) == true) {
            
            $this->load->model('coursemodel');
            $result = $this->coursemodel->CourseBooks($CourseID);
            
            $data['result'] = $this->formatter->Result($result);
            
            
        } else {
            // Bad url.
            $data['result'] = $this->error->E503;
        }
        
        $data['header'] = $this->formatter->Header;
        $this->load->view('GeneralView', $data);
        
        
    }
    
    public function GetBookDetail($BookID, $Format) {
        // Client flag defaults to true, so it sends the headers to view the data.
        // If false, then the data can be opened as a DOmDocument instead by the client.
        $params = array('Format' => $Format);
        $this->load->library('Formatter', $params);
        // Separate instance of Formatter required for each method.
        
        if ($this->ValidateURL($BookID, $Format) == true) {
            $this->load->model('detailmodel');
            $result = $this->detailmodel->BookDetail($BookID);
            
            $data['result'] = $this->formatter->Result($result);
            
        } else {
            // Bad URL error.
            $data['result'] = $this->error->E503;
        }
        
        $data['header'] = $this->formatter->Header;
		// This is called after because the instance now knows whether it is json or xml requested.
		// If called first, it will not know the right header to give back.
        $this->load->view('GeneralView', $data);
    }
    
    public function GetSuggestions($BookID, $Format) {
        
        $params = array('Format' => $Format);
		// Formatter library needs the format to work properly.
        $this->load->library('Formatter', $params);
        
        if ($this->ValidateURL($BookID, $Format) == true) {
            $this->load->model('suggestionmodel');
            $result = $this->suggestionmodel->BookSuggestions($BookID);
            
            
            // Separate instance of Formatter required for each method.
            $data['result'] = $this->formatter->Result($result);
            
            
            //http://isa.cems.uwe.ac.uk/~gca2-whelan/atwd/books/suggestions/51390/xml
        } else {
            $data['result'] = $this->error->E503;
        }
            // Default header is text/xml.
            $data['header'] = $this->formatter->Header;
            $this->load->view('GeneralView', $data);
    }
    
    public function BorrowBook() {
        
        //$_POST['item-id'] = '132981'; // Testing purposes only.
        
        if (isset($_POST['item-id'])) { 
           // If the right post item is sent
            
            
            $this->load->model('borrowmodel');
            // Passes the Book ID into the model to be validated and update the borrow count there.
            if ($this->borrowmodel->BorrowBook($_POST['item-id']) == true) {
				
				$this->load->model('detailmodel');
				$data['result'] = $this->detailmodel->BookDetail($_POST['item-id']);
				// Not sending it through the formatter since it isn't asked for in JSON.
				
			
			} else {
				// If this is false, the file has not been written to. Application exception.
				$data['result'] = $this->error->E500;
			}
            
        } else {
            // Error 500 isn't the best suit error but the best fit that the specification lists.
			// No post item-id sent.

            $data['result'] = $this->error->E500;
        }
        
        // Specification does not ask for a JSON version of the borrow method. Hence no need to invoke the JSON library.
        $data['header'] = 'text/xml';
        
        $this->load->view('GeneralView', $data);
        // Finally give all the data to the view.
    }
    
    public function ValidateURL($CourseID, $Format) {
        $Format = strtolower($Format);
		// Checks the format in the URL and sorts it into either json or xml.
        if ($CourseID != '' && $Format == 'xml' || $Format == 'json') {
            return $Format;
			// Returning the format also returns true.
        }
        return false;
    }

    
    public function Error503() {
        // All 404 links end up here as per the spec. Linked to this function from config/routes.php
        $data['header'] = 'text/xml';
        $data['result'] = $this->error->E503;
        $this->load->view('GeneralView', $data);
    }
    
}

?>