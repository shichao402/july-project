<form id="addArticle" method="post" action="<?php getActionUrl("action","add") ?>">
	getActionUrl("action","add") = <?php getActionUrl("action","add") ?>
    <br />
    <label>category<br />
      	<?php while($c = getCategoryTree(loadCategorys(),"<ul>","</ul>")) :?> 
        	<li>
				<?php echo $c["category_name"]; ?>
                <a href="http://localhost/<?php echo $_SERVER['PHP_SELF']."?action=del&category_id=".$c["category_id"]; ?>">删除</a>
                <a href="http://localhost/<?php echo $_SERVER['PHP_SELF']."?action=edit&category_id=".$c["category_id"]; ?>">修改</a>
            </li>
        <?php endwhile;?> 
    </label>
    <br />
    <label>add category<br />
        <input name="category_name" type="input" id="category_name" value="" />
        <input name="category_slug" type="input" id="category_slug" value="" />
        <textarea name="category_desc" id="category_desc" >
        </textarea>
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

<?php /*?><input name="ajax_categorys" type="input" id="ajax_categorys" value="" />
        <select name="ajax_category_group" >
        	<?php if (loadCategoryGroup()) :?>
				<?php while (hasCategoryGroup()) : getCategoryGroup() ?>
                    <option name="category_group_id" id="category_group_id" value="<?php getCategoryGroupId()?>"><?php getCategoryGroupName()?></option>
                <?php endwhile; ?>
            <?php else: ?>
                <option name="category_group_id" id="category_group_id" value="<?php getCategoryGroupId()?>">选择分组</option>
            <?php endif; ?>
        </select>
        <input name="submit_ajax_categorys" type="button" id="submit_ajax_categorys" value="添加分类" />
        <br /><?php */?>