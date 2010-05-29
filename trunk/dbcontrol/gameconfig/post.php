<?php
foreach($_POST as $key => $each) {
    $explode = explode('-',$key);
    $result[$explode[0]][$explode[1]] = $each;
}
file_put_contents('./data', serialize($result));
echo "<script>window.location.href='./write.php'</script>";
?>
