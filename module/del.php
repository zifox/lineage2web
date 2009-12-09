<?php
$filename="./module/data.txt";
if ( unlink($filename) )
echo "";
else
echo"<b>All Messages have been deleted.</b><br><br>";
?>
<b>Delete all messages:</b>
<form name='form' action='./index.php?id=msg' method='POST'>
          <br>
      
         <input type=submit name='action' value='Back'>
     </form>
     

