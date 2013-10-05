<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ClientModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
        //$this->load->library('Checker');
		// Checker isn't used, it could be used on the GetBookName to re-confirm the book id is real
		// But this is done before it is called anyway.
    }
	
	public function GetCourseName($id) {
	
		// Load the Course XML to get the Course name.
		$Courses = simplexml_load_file('././courses.xml');
		// The Course name is not held in any of the made apis.
		foreach($Courses->xpath('courses/course') as $course) {
			if ($id == $_GET['id']) {
				//$data['coursename'] = ucfirst(strtolower($course));
				return $course;
				// I could format the text but best to do that in CSS.
			} 
		}
	
	}
	
	public function GetBookName($id) {
	
		$Book = simplexml_load_file('http://gewh.co.uk/uni/books/detail/' . $_GET['id'] . '/xml');
		// Get book title from the API.
		foreach($Book->book as $book) {
			return $book['title'];
			// return the book title if it is found (which it should be every time, this method is only
			// called when the book id has already been confirmed as real).
		}
	
	}
	
	public function UpdateBorrow($id) {
		
		$url = 'http://gewh.co.uk/uni/books/borrow';
		$bookid = 'item-id=' . $id;
		$handle = curl_init($url);
		// cURL needs the post data and an initialisation so we have a handle to work from.
		
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $bookid);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($handle, CURLOPT_HEADER, 0);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		// Add the cURL parameters. Timeout at 15 seconds in case, the post variables,
		// and return transfer (bring the data back here).

		$response = curl_exec($handle);
		// Save the string result.
		curl_close($handle);
		// Close the handle.
		
		$xml = simplexml_load_string($response);
		// Load the cURL response as simplexml so we can check the results.
		if ($xml->error) {
			// error returned, die.
			echo 'derp';
			switch($xml->error['id']) {
			// If an error is returned, determine the type.
				case '502':
					// Error 502 found.
				
				break;
				case '500':
					// Internal exception.
				break;
			
			}
			
			
		} elseif ($xml->book) {
			// request worked and a book is returned.
			$book = array();
			
			$book['id'] = $xml->book['id'];
			$book['title'] = $xml->book['title'];
			$book['isbn'] = $xml->book['isbn'];
			$book['borrowedcount'] = $xml->book['borrowedcount'];
			
			return $book;
		}
		
		return $response;
		
		// To send post variables without a form, using curl.
		// Tips from Peter Anselmo @ http://stackoverflow.com/questions/3080146/post-data-to-url-php
	}
	
	
}