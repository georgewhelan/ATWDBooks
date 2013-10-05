<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ClientController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data = array();
		$this->load->view('template/header');
		// Load the header once, can't load footer once though as destruct
		// has already happened on the super object $CI before this destruct is called. :(

			//$this->load->view('template/footer');
    }
	
	//public function __destruct() {
	//	$this->load->view('template/footer');
	//}
	
	public function Client() {
        
        $this->load->view('ClientView');
    }
    
    public function ClientSearch() {
		// Based off get variables. Makes it easier to interlink between the client service.
        if (isset($_GET) && isset($_GET['type']) && isset($_GET['id'])) {
            
            $Doc = new DomDocument();
            // New DomDocument to accept the API xml.
            $Doc->load('http://gewh.co.uk/uni/books/' . $_GET['type'] . '/' . $_GET['id'] . '/xml');
            // Load the right API URI. The URI gets santized upon access request, fairly safe to just dump the post data in here.
            $this->load->model('clientmodel');
            switch($_GET['type']) {
				
                case 'detail':
                    
                    $Doc->load('http://gewh.co.uk/uni/books/' . $_GET['type'] . '/' . $_GET['id'] . '/xml');
					$Result = $Doc->getElementsByTagName('book');
                    
                    if ($Result->length > 0) {
						// Find the right element.
						$BookDetails = array();
						
						foreach($Result as $r) {
							// Needs a foreach loop to access the attributes.
							$BookDetails['id']              = $r->getAttribute('id');
							$BookDetails['title']           = $r->getAttribute('title');
							$BookDetails['isbn']            = $r->getAttribute('isbn');
							$BookDetails['borrowedcount']   = $r->getAttribute('borrowedcount');
						}
						$this->load->view('ClientSearchDetailView', $BookDetails);
						$this->load->view('template/footer');
					} else {
						$data['result'] = $this->error->C502;
						$this->load->view('ClientErrorView', $data);
						$this->load->view('template/footer');
					
					}
                    
                    break;
                case 'suggestions':
                    
                    
                    $Suggestions = $Doc->getElementsByTagName('suggestions');
					// Searching for this in the document. If it returns 0, no results found, wrong book id.
					if ($Suggestions->length > 0) {
						
						$data['booktitle'] = $this->clientmodel->GetBookName($_GET['id']);
						
						$BaseBook = $Doc->getElementsByTagName('suggestionsfor')->item(0)->nodeValue;
						$SuggestionsDetails = array();

						$SuggestionCount = 0;
						
						foreach($Suggestions->item(0)->childNodes as $s) {
							// Store the <isbn> elements for the Suggestions.
							$SuggestionsDetails[$SuggestionCount]['id']     = $s->getAttribute('id');
							$SuggestionsDetails[$SuggestionCount]['common'] = $s->getAttribute('common');
							$SuggestionsDetails[$SuggestionCount]['before'] = $s->getAttribute('before');
							$SuggestionsDetails[$SuggestionCount]['same']   = $s->getAttribute('same');
							$SuggestionsDetails[$SuggestionCount]['after']  = $s->getAttribute('after');
							$SuggestionsDetails[$SuggestionCount]['total']  = $s->getAttribute('total');
							$SuggestionsDetails[$SuggestionCount]['isbn']   = $s->nodeValue;
							$SuggestionCount += 1;
							
							// Old fashioned way of adding the details to the right index.
						}
						
						$data['suggestionsdetails'] = $SuggestionsDetails;
						// Pass the Suggestions to the data, to be sent to the view.
						
						$this->load->view('ClientSearchSuggestionsView', $data);
						$this->load->view('template/footer');
                    
					} else {
						$data['result'] = $this->error->C502;
						$this->load->view('ClientErrorView', $data);
						$this->load->view('template/footer');
					}
                    
                    
                    break;
                case 'course':
                    
                    $Books = $Doc->getElementsByTagName('books');
                    
					if ($Books->length > 0) {

						$data['coursename'] = $this->clientmodel->GetCourseName($_GET['id']);
						
						// Find the Books and the Course.
						$Books = $Doc->getElementsByTagName('book');
						$CourseBooks = array();
						$CourseBooksCount = 0;
						// Start the counter.
						
						foreach($Books as $b) {
							
							$CourseBooks[$CourseBooksCount]['id'] = $b->getAttribute('id');
							$CourseBooks[$CourseBooksCount]['title'] = $b->getAttribute('title');
							$CourseBooks[$CourseBooksCount]['isbn'] = $b->getAttribute('isbn');
							$CourseBooks[$CourseBooksCount]['borrowedcount'] = $b->getAttribute('borrowedcount');
							
							$CourseBooksCount += 1;
							// Increment the counter.
							// This counter problem is only because of CodeIgniter's way of passing data
							// to the views, through arrays. In short, makes it a much tougher job.
						}
						
						$data['coursebooks'] = $CourseBooks;
						$this->load->view('ClientSearchCourseView', $data);
						$this->load->view('template/footer');
                    } else {
						$data['result'] = $this->error->C501;
						$this->load->view('ClientErrorView', $data);
						$this->load->view('template/footer');
					}
                    break;
				
				case 'borrow' :
					
				
					break;
                
            }
            
            //$this->load->view('ClientSearchView', $data);
            
        } else {
			// No get sent.
			$data['result'] = $this->error->C503;
			$this->load->view('ClientErrorView', $data);
			$this->load->view('template/footer');
		}
        
    }
	
	public function BorrowBook() {
		if (isset($_GET['item-id']) && $_GET['item-id'] != '') {
		// Check the item-id is set, plus it isn't empty.
			$this->load->model('clientmodel');
			$result = $this->clientmodel->UpdateBorrow($_GET['item-id']);
			//print_r($result);
			
			$this->load->view('ClientBorrowView', $result);
			$this->load->view('template/footer');
			
		} else {
			$data['result'] = $this->error->C500;
			$this->load->view('ClientErrorView', $data);
			$this->load->view('template/footer');
			// Any error in this controller should be sending out a client error instead, with html not xml.
			// Lots of repeated header/footer views.
		}
	}
	
	public function Documentation() {
		// Loads the report.
		$this->load->view('DocumentationView');
		$this->load->view('template/footer');
	}
	
	
	
	
	
}