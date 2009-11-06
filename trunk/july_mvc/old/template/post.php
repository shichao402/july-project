<div id="content">
    <?php if ($t->havePost()) { $t->nextPost(); ?>
    <div id="post-<?php $t->postId(); ?>" class="post">
        <h2 class="title">
                <?php $t->postTitle();?>
        </h2>
        <div id="meta">
            <span class="date"><?php $t->postDate();?></span>
            <span class="categorys">
                    <?php if ($t->havePostCategory()) {$t->postCategorys('', ',', '');}else { ?>
                没有分类
                    <?php } ?>
            </span>
        </div>
        <div class="intro">
                <?php $t->postContent();?>
        </div>
        <div class="tags">
                <?php if ($t->havePostTag()) {$t->postTags('', ',', '');}else { ?>
            没有分类
                <?php } ?>
        </div>
    </div>
    <?php }else { ?>
    没有找到
    <?php } ?>
    <div id="comment" name="comment">
        <div id="comment-header">
            <h3>评论</h3>
            <span>欢迎吐槽...</span>
        </div>
        <ul id="comment-list">
            <?php if ($t->haveComment()) { ?>
            <li id="comment-num">
                <span><?php $t->postCommentNum(); ?>条评论</span>
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
</div>