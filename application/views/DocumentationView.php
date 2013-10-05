<div class="header"><h1>Report for 09032900</h1></div>

<div class="content">
    <p>Currently all the files are within the folder 'atwd/books', they should really be held inside a different directory elsewhere, one with an actual meaning associated with it, then use .htaccess to rewrite the URL to the site.</p>

<p>By using a framework, the application ended up being very large, the application could be under 100 lines, instead by breaking up the software into an MVC framework it has made it much larger than it needs to be. If I was to do a similar project, I would reconsider whether a framework for this would be necessary.</p>

<p>CodeIgniter’s ruthless access protocols (through routes) mean that the CSS had to be kept outside the application (every direct call to the file would get redirected to 404). This is not ideal at all for the manageability of the application.</p>

<p>No Javascript is used in the client as I did not want to make the functionality require Javascript, this is bad practise. Javascript should not be a requirement.</p>

<p>The database in this application is the XML files. I discovered in the course of the application in the problems associated with using XML files as a database, firstly there is a huge amount of work when increasing the borrow count. An SQL equivalent application could achieve what I achieved much quicker and safer. Secondly, only one user can open and write to the XML file being edited. If two users access the file at the same time, one will get the older version and the count will only be incremented once.</p>

<p>The PHP function json_encode was used for the conversion from XML to JSON (by passing the method the XML). This method is unable to properly encode XML into JSON where there is both a node value and attributes, data is lost. The way to combat this is to not create an XML document straight away (then convert if the format choice is JSON) but to create the output as an array, then encoding the array as XML or JSON depending. This then correctly is encoded as JSON also provides better scalability in the future if other formats are introduced into the service. I did not solve the problem as described due to the discovery of the bug late on in the project (I did suggestions last) and solving this would have required major changes throughout. This would be fixed for the first patch on the software at a later date.</p>

<p>The book covers are pulled from the Open Library website, this makes some of the pages very large in HTML content. Pagination would be required to sort this. I would not AJAX these results in as there would be an empty page for a few seconds while the book covers load. Interestingly, some of the covers are not book covers at all (adverts). Probably a better solution like Google Books might be needed for a future implementation as there is authentication the book covers are likely to be higher quality.</p>

</div>

<div class="content">
	<h3>Source Links</h3>
	<p>This is all the code for the application which I have included/modified. More Codeigniter code is available.</p>
        
        <ul>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/controllers/clientcontroller.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/controllers/servicecontroller.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/libraries/Checker.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/libraries/Error.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/libraries/Formatter.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/libraries/JSON.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/libraries/Sort.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/models/borrowmodel.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/models/clientmodel.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/models/coursemodel.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/models/detailmodel.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/models/suggestionmodel.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/routes/routes.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/template/header.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/template/footer.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/BorrowView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/ClientBorrowView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/ClientErrorView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/ClientSearchCourseView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/ClientSearchDetailView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/ClientSearchSuggestionsView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/DocumentationView.phps</li>
            <li>http://cems.uwe.ac.uk/~gca2-whelan/atwd/booksresources/source/views/GeneralView.phps</li>
            
        </ul>
</div>