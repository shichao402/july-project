<form id="form1" method="post" action="category.php?action=edit">
    <label>category_name
	<input type="hidden" name="category_id" id="category_id" value="<?php echo $r["category_id"]; ?>" />
    <input type="text" name="category_name" id="category_name" value="<?php echo $r["category_name"]; ?>" />
    </label>
    <label>category_slug
    <input type="text" name="category_slug" id="category_slug" value="<?php echo $r["category_slug"]; ?>"/>
    </label>
    <p>&nbsp;</p>
    <label>category_desc
    <textarea name="category_desc" id="category_desc" cols="45" rows="5"><?php echo $r["category_desc"]; ?></textarea>
    </label>
      
    <label>add category<br />
        <input name="category_name" type="input" id="category_name" value="" />
        <select name="category_parent_id" id="category_parent_id">
			<option id="option-0" value="0" selected="selected">root</option>
      		<?php getCategoryOption(); ?> 
        </select>
    </label>
    
      <label>submit
        <input type="submit" name="submit" id="submit" value="提交" />
      </label>
</form>
<a href ="category.php">返回列表</a>