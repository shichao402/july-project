<form id="form1" method="post" action="options.php?action=edit">
blogname<input type="text" name="blogname" id="blogname" value="<?php echo $options['blogname']; ?>" />
blogurl<input type="text" name="blogurl" id="blogurl" value="<?php echo $options['blogurl']; ?>" />
blogdescription<input type="text" name="blogdescription" id="blogdescription" value="<?php echo $options['blogdescription']; ?>" />
blogkeyword<input type="text" name="blogkeyword" id="blogkeyword" value="<?php echo $options['blogkeyword']; ?>" />

<input type="submit" name="submit" id="submit" />
</form>