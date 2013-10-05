	<h1>Suggestions for <?= $booktitle; ?></h1>
    <table>
        
        <tr>
            <th>Cover</th>
            <th>Book ID</th>
            <th>Common</th>
            <th>Before</th>
            <th>Same</th>
            <th>After</th>
            <th>Total</th>
            <th>ISBN</th>
        </tr>
<?php
        foreach ($suggestionsdetails as $Book) {
            
            echo '<tr>';
            echo '<td><img src="http://covers.openlibrary.org/b/isbn/' . $Book['isbn'] . '-S.jpg" /></td>';
            echo '<td><a href="./clientsearch?type=detail&id=' . $Book['id'] . '">' . $Book['id'] . '</a></td>';
            echo '<td>' . $Book['common'] . '</td>';
            echo '<td>' . $Book['before'] . '</td>';
            echo '<td>' . $Book['same'] . '</td>';
            echo '<td>' . $Book['after'] . '</td>';
            echo '<td>' . $Book['total'] . '</td>';
            echo '<td><a href="http://openlibrary.org/isbn/' . $Book['isbn'] . '">' . $Book['isbn'] . '</a></td>';
            
            
            echo '</tr>';
        }
        ?>
    </table>