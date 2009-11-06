<form id="addArticle" method="post" action="<?php getActionUrl("action","add") ?>">
	getActionUrl("action","add") = <?php getActionUrl("action","add") ?><br />
    <label>title
    	<input type="text" name="article_title" id="article_title" />
    </label>
    <br />
    <label>date
    	<input type="text" name="article_date" id="article_date" value="<?php getNowDate() ?>"/>
    </label>
    <br />
    <label>article_slug  google自动翻译
    	<input type="text" name="article_slug" id="article_slug" value=""/>
    </label>
    <br />
    <label>article_content
    	<textarea name="article_content" id="article_content" cols="45" rows="5"></textarea>
    </label>
    <br />
    <label>article_excerpt
    	<textarea name="article_excerpt" id="article_excerpt" cols="45" rows="5"></textarea>
    </label>
    <br />
    <label>article_status
    	<input type="text" name="article_status" id="article_status" value=""/>
    </label>
    <br />
     <label>user
    	<select name="user" id="user">
      	
        </select>
    </label>
    <br />
    <label>CategorysTree<br />
    	<?php getCategorysTree();?>
    </label>
    <br /> 
    <label>add category<br />
        <input name="ajax_category" type="input" id="ajax_category" value="" />
        <select name="category_parent" id="category_parent">
      	<?php getCategoryOption();?> 
        </select>
        <input name="submit_ajax_tags" type="button" id="submit_ajax_tags" value="添加分类" onclick="" />
    </label>
    <br /> 
    <label>tag_name<br />移除重复，去除多余空格，移除空值
    	<input name="tag_name" type="input" id="tag_name" value="" />
        <br />
		<?php /*?><?php if (loadTags()) : ?>
			<?php while (hasTags()) : getTags() ?>
                <input name="tag_id[]" type="checkbox" id="tag_id" value="<?php getTagId()?>" />
                <?php getTagName() ?>
                <br />
            <?php endwhile; ?>
        <?php endif; ?><?php */?>
    </label>
    <br />
    <label>submit
    	<input type="submit" name="submit" id="submit" value="提交" />
    </label>
</form>

<a href ="article.php">返回列表</a>

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