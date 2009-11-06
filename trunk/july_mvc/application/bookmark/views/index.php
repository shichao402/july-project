<?php
$num = count($bookmarkList);
if ($num > 0) {
    for ($i=0;$i<$num;$i++) {
        ?>
<a href="<?php echo $bookmarkList[$i]['url'];?>"><?php echo $bookmarkList[$i]['name'];?></a>
    <?php
    }
}else {
    ?>
nothing
<?php
}
?>