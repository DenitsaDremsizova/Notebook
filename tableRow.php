    <tr>
        <td class="left-col <?php if($notePriority == 1) echo "blue"; else if($notePriority == 2) echo "green"; else if($notePriority == 3) echo "yellow"; else if($notePriority == 4) echo "orange"; else echo "red" ?>"> <?= $notePriority ?> </td>
        <td class="right-col <?php if($notePriority == 1) echo "blue"; else if($notePriority == 2) echo "green"; else if($notePriority == 3) echo "yellow"; else if($notePriority == 4) echo "orange"; else echo "red"  ?>"> <?= $noteText ?> </td>
    </tr>
