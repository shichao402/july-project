<form action ='./test.php' method='POST'>
    from<input name ="date1" type="input" size="10" value=""/><input name ="version1" type="input" size="10" value=""/>
    to<input name ="date2" type="input" size="10" value=""/><input name ="version2" type="input" size="10" value=""/>
    <input type= 'submit' name ="submit">
</form>
<?php



function scanFilesystem($dir,$r = 1) {
    $tempArray = array();
    $handle = opendir($dir);
    // List all the files
    while (false !== ($file = readdir($handle))) {
        if (substr("$file", 0, 1) != ".") {
            if(is_dir($dir.'/'.$file)) {
                if ($r == 1) {
                    $tempArray[$file] = scanFilesystem("$dir/$file");
                }elseif($r == 0) {
                    $tempArray[] = $file;
                }
            } else {
                $tempArray[]=$file;
            }
        }
    }
    closedir($handle);
    return $tempArray;
}
?>
