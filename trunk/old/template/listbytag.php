<div id="content">
<?php while ($postList->getPostsByTag($tagId,$num,$page)) { ?>
    <div id="post-<?php echo $postList->getId(); ?>" class="post">
        <h2 class="title">
                    <?php echo '<a href="',ROOT,'index.php?id=',$postList->getId(),'">',$postList->getTitle(),'</a>';?>
        </h2>
        <div id="meta">
            <span class="date"><?php echo $postList->getDate();?></span>
            <span class="categorys">
                        <?php while ($category->getCategorysByPost($postList->getId())) {
                            echo '<span class="category">';
                            echo '<a href="',ROOT,'index.php?categoryid=',$category->getId(),'">',$category->getName(),'</a>';
                            echo '</span>';
                        }
                        $category->refresh();
                        ?>
            </span>
        </div>
        <div class="intro">
                    <?php echo $postList->getContent();?>
        </div>
        <div class="tags">
                    <?php while ($tag->getTagsByPost($postList->getId())) {
                        echo '<span class="tag">';
                        echo '<a href="',ROOT,'index.php?tagid=',$tag->getId(),'">',$tag->getName(),'</a>';
                        echo '</span>';
                    }
                    $tag->refresh();
                    ?>
        </div>
    </div>
<?php } ?>
    <div id="page-nav">
            <?php
            $totalPost = $postList->getNum();
            $totalPage = floor($totalPost/$num)+1;
            if ($page > 1) {
                echo '<span class="prev">';
                echo '<a href="',ROOT,'index.php?tagid=',$tagId,'page=',$page-1,'">上一页</a>';
                echo '</span>';
            }
            if ($page < $totalPage) {
                echo '<span class="next">';
                echo '<a href="',ROOT,'index.php?tagid=',$tagId,'page=',$page+1,'">下一页</a>';
                echo '</span>';
            }
            ?>
    </div>
</div>