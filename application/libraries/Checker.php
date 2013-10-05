<?php

class Checker {
    
    public function CheckItemExists($id) {
        
//        This method checks the book ID against the courses in the books XML. If it exists, the program can continue,
//        if false there is no book with that id.
        $XML = simplexml_load_file('././books.xml');
        foreach($XML->xpath('items/item') as $book) {
            // If the book ID is found in the Books xml then true.
            if ($book['id'] == $id) {
                return true;
            } 
        }
        // Return false 
        return false;
    }
    
    public function CheckCourseExists($id) {
        
//        This method checks the course ID against the courses in the courses XML. If it exists, the program can continue,
//        if false there is no course with that id.
        $XML = simplexml_load_file('././courses.xml');
        
        foreach($XML->xpath('courses/course') as $course) {
            if ($course['id'] == $id) {
                return true;
            } 
        }
        return false;
    }
    
}
?>
