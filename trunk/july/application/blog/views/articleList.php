<div id="content">
    <?php
    if ($t->havePost()) {
        while ($t->nextPost()) {
    ?>
    <div id="post-<?php echo $t->postId(); ?>" class="post">
        <h2 class="title">
                <?php $t->postTitle(); ?>
        </h2>
        <div id="meta">
            <span class="date"><?php echo $t->postDate();?></span>
            <span class="categorys">
                <?php if ($t->havePostCategory()) {$t->postCategorys('<span>', ',', '</span>');}else{ ?>
                <span class="noCategory">没有分类</span>
                <?php } ?>
            </span>
            
            <?php if ($t->havePostComment()) { ?>
            <span class="commentnum">
            <?php $t->postCommentUrl($t->post->commentNum().'条评论'); ?>
            <?php }else{ ?>
            没有评论
            <?php } ?>
            </span>
        </div>
        <div class="intro">
                <?php echo $t->postContent();?>
        </div>
        <div class="tags">
            <?php if ($t->havePostTag()) {$t->postTags('<span>', ',', '</span>');}else{ ?>
            <span class="noTag">没有标签</span>
            <?php } ?>
        </div>
    </div>
    <?php
        }
    }else {
    ?>
    <div class="post">
        <span class="noPost">没有找到日志</span>
    </div>
    <?php
    }
    ?>
    <div id="page-nav">
        <?php $t->pageNav($page); ?>
    </div>
</div>
