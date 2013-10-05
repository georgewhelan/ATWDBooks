
<div class="container">
	<h1>University of Huddersfield Books API access</h1>

	<div class="body">
            <form method="get" action="clientsearch">
                <p>Search Type
                    <select name="type">
                        <option value="detail">Book detail</option>
                        <option value="course">Course books</option>
                        <option value="suggestions">Book suggestions</option>
                    </select>
                </p>
                <p>Book/Course ID <input type="text" name="id" placeholder="Book/Course ID" /></p>
                <p>
                    <input type="submit" />
                </p>
                
            </form>
            
            <!--<form method="post" action="viewallbooks">
                <p>View all books</p>
            </form>-->
			
			<form method="get" action="borrowbook">
				<input type="text" name="item-id" placeholder="Book ID" />
				
				<input type="submit" value="Borrow Book" />
			</form>
			
			
			<div class="content">
				<h2>Instructions</h2>
				<p>Sample Book IDs: 51390, 483</p>
				<p>Sample Course Codes: CC120, CC100, CC140</p>
				
				<p>API service URIs:</p>
				<ul>
					<li>gewh.co.uk/uni/books/detail/"book-id"/[xml|json]</li>
					<li>gewh.co.uk/uni/books/course/"course-id"/[xml|json]</li>
					<li>gewh.co.uk/uni/books/suggestions/"book-id"/[xml|json]</li>
				</ul>
			</div>
			
            
	</div>

        <div class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</div>
</div>
