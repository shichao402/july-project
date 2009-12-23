<?php
class PF {
    private $reg = array();
    public function regModel($name,$obj) {
        if (!isset($this->reg[$name]) && $name !== null && $obj !== null) {
            $this->reg[$name] = 1;
            $this->{$name} = $obj;
            return true;
        }
        return false;
    }
    public function getReg() {
        return $this->reg;
    }
    //header
    public function headTitle() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            echo $this->post->title();
            echo '|';
        }
        echo $this->option->getOption('blog_title');
    }
    public function headDesc() {
        echo $this->option->getOption('blog_desc');
    }
    public function headKeyWords() {
        echo $this->option->getOption('blog_keywords');
    }
    public function blogTitle() {
        echo '<a href="'.BLOG_URL.'">'.$this->option->getOption('blog_title').'</a>';
    }
    public function blogDesc() {
        echo $this->option->getOption('blog_desc');
    }
    //post,postlist
    public function postTotalNum() {
        return $this->post->totalNum();
    }
    public function havePost() {
        return $this->post->have();
    }
    public function nextPost() {
        $r = $this->post->next();
        return $r;
    }
    public function postId() {
        echo $this->post->id();
    }
    public function postSlug() {
        echo $this->post->slug();
    }
    public function postTitle() {
        echo '<a href="'.BLOG_URL.'index.php?id='.$this->post->id().'">'.$this->post->title().'</a>';
    }
    public function postDate() {
        echo $this->post->date();
    }
    public function postIntro() {
        echo $this->post->intro();
    }
    public function postContent() {
        echo $this->post->content();
    }
    public function postCommentNum() {
        echo $this->post->commentNum();
    }
    public function havePostComment() {
        if ($this->post->commentNum() > 0) {
            return true;
        }
        return false;
    }
    public function postCommentUrl($name) {
        echo '<a href="'.BLOG_URL.'index.php?id='.$this->post->id().'#comment">'.$name.'</a>';
    }
    public function postAllowComment() {
        return $this->post->allowComment();
    }
    public function postPublish() {
        return $this->post->publish();
    }
    //postcategory
    public function havePostCategory() {
        return $this->postCategory->have();
    }
    public function postCategorys($fix1,$separator,$fix2) {
        $length = strlen($separator);
        $str = '';
        while ($this->postCategory->next()) {
            $str .= $fix1.'<a href="'.BLOG_URL.'index.php?category='.$this->postCategory->id().'">'.$this->postCategory->name().'</a>'.$fix2.$separator;
        }
        echo substr($str, 0, -$length);
    }
    //posttag
    public function havePostTag() {
        return $this->postTag->have();
    }
    public function postTags($fix1,$separator,$fix2) {
        $length = strlen($separator);
        $str = '';
        while ($this->postTag->next()) {
            $str .= $fix1.'<a href="'.BLOG_URL.'index.php?tag='.$this->postTag->id().'">'.$this->postTag->name().'</a>'.$fix2.$separator;
        }
        echo substr($str, 0, -$length);
    }
    //comment
    public function haveComment() {
        return $this->comment->have();
    }
    public function nextComment() {
        return $this->comment->next();
    }
    public function commentId() {
        echo $this->comment->id();
    }
    public function commentAuthor() {
        echo '<a rel="nofollow" href="'.$this->commentAuthor->website().'">'.$this->commentAuthor->name().'</a>';
    }
    public function commentDate() {
        echo $this->comment->date();
    }
    public function commentContent() {
        echo stripslashes($this->comment->content());
    }
    //pageElement
    public function totalPage() {
        return ceil ($this->totalNum/POST_NUM_PERPAGE);
    }
    public function pageNav() {
        $parameter = explode('&', substr($_SERVER['REQUEST_URI'],strlen($_SERVER['PHP_SELF'])+1,strlen($_SERVER['REQUEST_URI'])));
        foreach ($parameter as $sub) {
            $temp = explode('=', $sub);
            if ($temp[0] != null) {
                $array[$temp[0]] = $temp[1];
            }
        }
        if (isset($array['page'])) {
            $page = $array['page'];
            $nextpage = $array['page']+1;
            $prevpage = $array['page']-1;
            unset($array['page']);
        }else {
            $nextpage = 2;
            $prevpage = 1;
            $page = 1;
        }
        $url = '';
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $url .= $key.'='.$value.'&';
            }
        }
        $nexturl = $url.'page='.$nextpage;
        $prevurl = $url.'page='.$prevpage;

        if ($page > 1) {
            echo '<span class="prev">';
            echo '<a href="'.BLOG_URL.'index.php?'.$prevurl.'">上一页</a>';
            echo '</span>';
        }
        if ($page < $this->totalPage()) {
            echo '<span class="next">';
            echo '<a href="'.BLOG_URL.'index.php?'.$nexturl.'">下一页</a>';
            echo '</span>';
        }
    }
    //cookies
    public function cookieName() {
        if (isset($_COOKIE['name'])) {
            echo $_COOKIE['name'];
        }
    }
    public function cookieEmail() {
        if (isset($_COOKIE['email'])) {
            echo $_COOKIE['email'];
        }
    }
    public function cookieWebsite() {
        if (isset($_COOKIE['website'])) {
            echo $_COOKIE['website'];
        }
    }
    //widget
    public function categoryTree() {
        function check($id,$targetArray) {
            if (!empty($targetArray)) {
                foreach($targetArray as $v) {
                    if ($v["term_parent"] == $id) {
                        return true;
                    }
                }
            }
            return false;
        }
        function showCategoryTree($id,$targetArray,$level) {
            if (check($id,$targetArray)) {
                echo "<ul>";
                foreach($targetArray as $v) {
                    if ($v["term_parent"] == $id) {
                        echo "<li>";
                        echo '<a href="'.BLOG_URL.'index.php?category='.$v["term_id"].'">',$v["term_name"].'</a>';
                        echo '<span class="includeNum"> ['.$v["term_includenum"].']</span>';
                        echo "</li>";
                        if (check($v["term_id"],$targetArray)) {
                            echo "<li>";
                            showCategoryTree($v["term_id"],$targetArray,$level + 1);
                            echo "</li>";
                        }
                    }
                }
                echo "</ul>";
            }
        }
        $stack = $this->categoryWidget->getStack();
        showCategoryTree(0,$stack->getData(),0);
    }
}
?>
