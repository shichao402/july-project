<div id="widgets">
    <div id="widget-nav" class="widget">
        <ul>
            <li><a href="<?php echo BLOG_URL; ?>">首页</a></li>
            <li><a href="http://scyang.cn">scyang.cn</a></li>
        </ul>
    </div>
    <div id="widget-category" class="widget">
        <h3 class="widget-title">Category</h3>
        <?php $t->categoryTree();?>
    </div>
</div>