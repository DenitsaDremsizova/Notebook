<?php
$notes = array();

//add note and property validation:
if (isset($_POST['submit'])) {
    $note = trim($_POST['note']);
    $priority = trim($_POST['priority']);
    if ($note != '') {
        if (strlen($note) <= 30) {
            if (is_numeric($priority) && $priority > 0 && $priority <= 5) {
                $handle = fopen('Assets/files/notes.txt', 'a+');
                fwrite($handle, "\n$note #$priority");
                fclose($handle);
            } else
                echo "<strong class='msg'>Invalid priority. Please enter a value between 1 and 5.</strong><br/></br>";
        } else {
            echo "<strong class='msg'>Note is longer than allowed.</strong><br/></br>";
        }
    } else
        echo "<strong class='msg'>You have not entered a note.</strong><br/></br>";
}

//select note for edit functionality:
$handle = fopen('Assets/files/notes.txt', 'r');
$notesEdited = array();
while (!feof($handle)) {
    $notesEdited[] = fgets($handle);
}
fclose($handle);

$indexEdited = 0;

if (isset($_POST['selectForEdit'])) {
    $indexEdited = trim($_POST['toBeEdited']);
    if (is_numeric($indexEdited)) {
        $indexEdited -= 1;
        if ($indexEdited >= count($notesEdited) || $indexEdited < 0) {
            echo '<strong class="msg"> Invalid note selected for editing.</strong> <br/></br>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> My Notebook </title>
        <link href="Assets/Stylesheets/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <main id="main1">
            <section id="leftPage">
                <form action="" method="post">
                    <textarea placeholder="Add note..." name="note" maxlength="30" rows="1" cols="30"></textarea> </br></br>
                    <span class="priorityField">

                        <input type="number" name="priority"/>
                        <label for="priority">Add Priority</label></br></br>
                    </span>
                    <input type="submit" name='submit' value="Add"/> </br></br>
                    <label for="toBeEdited"> Number of the note to be edited:</label></br></br>
                    <input type="number" name="toBeEdited"/> </br></br>
                    <input type="submit" name='selectForEdit' value="Select"/></br></br>
                    <textarea name="editedNote" maxlength="50" placeholder="Edit note..." rows="1" cols="30"><?php
                        if (isset($_POST['selectForEdit'])) {
                            echo substr($notesEdited[$indexEdited], 0, strpos($notesEdited[$indexEdited], " #"));
                        }
                        ?></textarea> </br></br>
                    <span class="priorityField">

                        <input type="number" name="editedPriority" value="<?php
                        if (isset($_POST['selectForEdit'])) {
                            $priorityPos = strpos($notesEdited[$indexEdited], '#');
                            $priorityPos += 1;
                            $noteString = $notesEdited[$indexEdited];
                            $suggestedPriority = $noteString{$priorityPos};
                            echo $suggestedPriority;
                        }
                        ?>">
                        <label for="editedPriority">Edit Priority</label> </br> </br>
                        <input type="hidden" name="indexEdited" value="<?php echo $indexEdited ?>">
                        <span/>
                        <input type="submit" name='submitEdit' value="Edit"/> </br></br>
                        <label for="toBeDeleted"> Number of the note to be deleted:</label> </br></br>
                        <input type="number" name="toBeDeleted"/> </br></br>
                        <input type="submit" name='delete' value="Delete"/></br>
                </form>
                <h2><a href="./SortedNotebook.php" class="tangerine">My Sorted Notebook</a></h2>

                <img src="Assets/Images/pencil.png" alt="pencil pic" id="img1">
            </section>
            <section id="rightPage">
                <ol>
                    <?php
                    
//add file's rows into an array:
                    $handle = fopen('Assets/files/notes.txt', 'r');
                    while (!feof($handle)) {
                        $notes[] = fgets($handle);
                    }

                    fclose($handle);

//delete empty rows from array
                    for ($index = 0; $index < count($notes); $index++) {
                        if (trim($notes[$index]) == "") {
                            unset($notes[$index]);
                        }
                    }

//delete empty rows from file:
                    $handle = fopen('Assets/files/notes.txt', 'w+');
                    foreach ($notes as $note) {
                        fwrite($handle, $note);
                    }
                    fclose($handle);

//delete note functionality:
                    if (isset($_POST['delete'])) {
                        $deletedNum = $_POST['toBeDeleted'];
                        if (is_numeric($deletedNum) && $deletedNum > 0 && $deletedNum <= count($notes)) {
                            $deletedNum -= 1;
                            unset($notes[$deletedNum]);
                            $handle = fopen('Assets/files/notes.txt', 'w+');
                            fwrite($handle, implode('', $notes));
                            fclose($handle);
                        } else {
                            echo "<strong class='msg'>Invalid note selected for deletion.</strong> <br/></br>";
                        }
                    }

//edit note functionality
                    if (isset($_POST['submitEdit'])) {
                        $indexEdited = $_POST['indexEdited'];
                        if (trim($_POST['editedNote']) != "" && is_numeric(trim($_POST['editedPriority'])) && trim($_POST['editedPriority']) > 0 && trim($_POST['editedPriority']) <= 5) {
                            $notes[$indexEdited] = trim($_POST['editedNote']) . " #" . trim($_POST['editedPriority']) . "\n";
                            $handle = fopen('Assets/files/notes.txt', 'w+');
                            fwrite($handle, implode('', $notes));
                            fclose($handle);
                        }
                    }



//display notes in unordered list and add appropriate images:
                    foreach ($notes as $note) {
                        echo "<li>$note</li>";
                        $arr = explode(' #', $note);
                        switch ($arr[1]) {
                            case 1:
                                echo "<img src='Assets/Images/priority_1.png' class='img2'/>";
                                break;
                            case 2:
                                echo "<img src='Assets/Images/priority_2.png' class='img2'/>";
                                break;
                            case 3:
                                echo "<img src='Assets/Images/priority_3.png' class='img2'/>";
                                break;
                            case 4:
                                echo "<img src='Assets/Images/priority_4.png' class='img2'/>";
                                break;
                            case 5:
                                echo "<img src='Assets/Images/priority_5.png' class='img2'/>";
                                break;
                        }
                        echo "</br>";
                        echo "<hr>";
                    }
                    ?>
                </ol>
            </section>
        </main>
    </body>
</html>
