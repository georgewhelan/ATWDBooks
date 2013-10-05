	<h1>Suggestions for <?= $coursename; ?></h1>
    <table>
        <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>ISBN</th>
            <th>Borrowed Count</th>
        </tr>
<?php

        foreach ($coursebooks as $Book) {
            echo '<tr>';
            echo '<td><img src="http://covers.openlibrary.org/b/isbn/' . $Book['isbn'] . '-S.jpg" /></td>';
            echo '<td><a href="./clientsearch?type=detail&id=' . $Book['id'] . '">' . $Book['id'] . '</a></td>';
            echo '<td>' . $Book['title'] . '</td>';
            echo '<td><a href="http://openlibrary.org/isbn/' . $Book['isbn'] . '">' . $Book['isbn'] . '</a></td>';
            echo '<td>' . $Book['borrowedcount'] . '</td>';

            
            
            echo '</tr>';
        }

        ?>
    </table>
