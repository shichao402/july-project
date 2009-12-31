<div id="content">
    <?php if ($article->loadData()) { ?>
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
    <?php } ?>
</div>

<div id="comment" name="comment">
    <div id="comment-header">
        <h3>评论</h3>
    </div>
    <ul id="comment-list">
        <?php if ($comment->have()) { ?>
        <li id="comment-num">
            <span><?php $comment->postCommentNum(); ?>条评论</span>
        </li>
            <?php $i = 0;while ($t->nextComment()) { $odd = $i%2?' odd':'';?>
        <li id="comment-<?php $t->commentId(); ?>" class="comment-entry<?php echo $odd;?>">
            <div class="comment-meta">
                <span class="comment-author"><?php $t->commentAuthor(); ?></span>
                <span class="comment-date"><?php $t->commentDate(); ?></span>
            </div>
            <div class="comment-content"><?php $t->commentContent(); ?></div>
        </li>
            <?php $i++;} ?>
        </ul>
        <?php }else{ ?>
            暂时没有评论
        <?php } if ($t->postAllowComment()) { ?>
    <div id="comment-form">
        <form method="POST" action="<?php echo BLOG_URL; ?>addcomment.php?id=<?php $t->postId();?>">
            <table>
                <tbody>
                    <tr>
                        <td><input type="text" id="from-name" name="name" value="<?php $t->cookieName();?>" /></td>
                        <td class="label"><label for="from-name">name(*)</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" id="from-email" name="email" value="<?php $t->cookieEmail();?>" /></td>
                        <td class="label"><label for="from-email">email(*)</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" id="from-website" name="website" value="<?php $t->cookieWebsite();?>" /></td>
                        <td class="label"><label for="from-website">website</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea id="from-content" name="content" rows="4" cols="20"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="submit" /></td>
                    </tr>
                </tbody>
            </table>

        </form>
    </div>
        <?php }else { ?>
    评论已经被关闭
    <?php } ?>
</div>