<form id="form1" method="post" action="article.php?action=edit">
    <label>title
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    <input type="text" name="title" id="title" value="<?php echo $title ?>" />
    </label>
    <label>date
    <input type="text" name="date" id="date" value="<?php echo $date ?>"/>
    </label>
    <p>&nbsp;</p>
    <label>content
    <textarea name="content" id="content" cols="45" rows="5"><?php echo $content ?></textarea>
    </label>
    <p>
        <label>submit
        <input type="submit" name="submit" id="submit" value="提交" />
        </label>
    </p>
</form>
<a href ="article.php">返回列表</a>