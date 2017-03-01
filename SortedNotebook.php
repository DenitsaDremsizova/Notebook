<html>
    <head>
        <meta charset="UTF-8">
        <title> My Sorted Notebook </title>
        <link href="Assets/Stylesheets/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <main id="main2">
            <h1 class="tangerine">My Sorted Notebook</h1>

            <?php
            $unsortedNotes = array();

            $handle = fopen('Assets/files/notes.txt', 'r');
            
            while (!feof($handle)) {
                $unsortedNotes[] = fgets($handle);
            }

            for ($index = 0; $index < count($unsortedNotes); $index++) {
                if (trim($unsortedNotes[$index]) == "") {
                    unset($unsortedNotes[$index]);
                }
            }
            
            fclose($handle);

            $handle = fopen('Assets/files/notes.txt', 'w+');
            
            foreach ($unsortedNotes as $note) {
                fwrite($handle, $note);
            }
            fclose($handle);

            for ($index = 0; $index < count($unsortedNotes); $index++) {
                $tempArr = explode(' #', $unsortedNotes[$index]);
                $string = $tempArr[1] . ' @ ' . $tempArr[0];
                $unsortedNotes[$index] = $string;
            }

            sort($unsortedNotes);

            $sortedNotes = array(array());

            for ($index = 0; $index < count($unsortedNotes); $index++) {
                $sortedNotes[$index] = explode(' @ ', $unsortedNotes[$index]);
            }

            echo "<html>
    <table>
        <theader>
            <tr>
            <th class='left-col'> Priority </th>
            <th class='right-col'> Note </th>
            </tr>
        </theader>";

            $notePriority = '';
            $noteText = '';

            for ($index = 0; $index < count($sortedNotes); $index++) {
                $notePriority = $sortedNotes[$index][0];
                $noteText = $sortedNotes[$index][1];
                include './tableRow.php';
            }

            echo '</table> </html>';
            ?>
            <a href="MyNotebook.php" class="indie-flower"> Edit Notes </a>
        </main>
    </body>
</html>