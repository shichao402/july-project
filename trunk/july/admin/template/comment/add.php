<form action="comment.php?action=add" method="post">
name<input name="name" type="text" />
articleid<input name="articleid" type="text" readonly="readonly" value="<?php echo $articleid ?>" />
content<input name="content" type="text" />
email<input name="email" type="text" />
website<input name="website" type="text" />
date<input name="date" type="text" value="<?php echo $date ?>"/>
<input type="submit" value="submit" />
</form>
<a href="comment.php">列表</a>