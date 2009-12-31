<div id="content">
    <?php if ($article->have()) { while ($article->loadData()) { ?>
    <div id="post-<?php echo $article->id; ?>" class="post">
        <h2 class="title"><?php echo $article->title; ?></h2>
        <div id="meta">
            <span class="date"><?php echo $article->date;?></span>
            <span class="categorys">
                <?php if ($category->loadData()) { while ($category->loadData()) {?>
                <span class="category"><?php echo $category->name;?></span>
                <?php }}else{ ?>
                <span class="noCategory">没有分类</span>
                <?php } ?>
            </span>
            <?php if ($tag->have()) { while ($tag->loadData()) {?>
            <span class="tags">
                <?php if ($tag->loadData()) { while ($tag->loadData()) {?>
                <span class="tag"><?php echo $tag->name;?></span>
                <?php }}else{ ?>
                <span class="noTag">没有Tag</span>
                <?php } ?>
            </span>
            <?php }} ?>
            <span class="commentnum">
            <?php echo $comment->commentNum; ?>条评论
            </span>
        </div>
        <div class="intro">
                <?php echo $article->intro;?>
        </div>
    </div>
    <?php }} else { ?>
    <div class="post">
        <span class="noPost">没有找到日志</span>
    </div>
    <?php } ?>
    <div id="page-nav">
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'index.php?p='.($article->page-1); ?>"><<</a></span>
        <span><?php echo $article->page.'/'.$article->totalPage;?></span>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'index.php?p='.($article->page+1); ?>">>></a></span>
    </div>
</div>
