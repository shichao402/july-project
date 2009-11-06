<?php
if ($bookmark->have()) {
    while ($bookmark->have()) {
?>
        <a href="<?php echo $bookmark->url();?>"><?php echo $bookmark['name'];?></a>
        <?php foreach ($categroys[$i++] as $category) {?>
        <a><?php echo $category['name'];?></a>
        <?php } ?>
<?php
    $bookmark->next();
    }
}else {
?>
    "nothing";
<?php
}
?>

