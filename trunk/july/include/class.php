<?php
class BookMark extends DataModel {
//bookmark id
    private $id;
    //bookmark 名字
    private $name;
    //bookmark 链接
    private $url;
    //bookmark 添加日期
    private $addDate;
    //访问次数
    private $visitCount;
    //bookmark �?��修改日期
    private $lastModifiedDate;
    //bookmark �?��访问日期
    private $lastVisitDate;
    //�?��
    private $intro;
    //I
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function setUrl($url) {
        $this->url = $url;
    }
    public function setVisitCount($visitCount) {
        $this->visitCount = $visitCount;
    }
    public function setLastModifiedDate($lastModifiedDate) {
        $this->lastModifiedDate = $lastModifiedDate;
    }
    public function setAddDate($addDate) {
        $this->addDate = $addDate;
    }
    public function setLastVisitDate($lastVisitDate) {
        $this->lastVisitDate = $lastVisitDate;
    }
    public function setIntro($intro) {
        $this->intro = $intro;
    }
    //O
    public function id() {
        return $this->id;
    }
    public function name() {
        return $this->name;
    }
    public function url() {
        return $this->url;
    }
    public function visitCount() {
        return $this->visitCount;
    }
    public function lastModifiedDate() {
        return $this->lastVisitDate;
    }
    public function lastVisitDate() {
        return $this->lastVisitDate;
    }
    public function addDate() {
        return $this->addDate;
    }
    public function intro() {
        return $this->intro;
    }
}
/**
 * 用于数字索引数组承载的类,
 * 由该类实例化的各个对象的指针可以通过setPointerRefer(),getPointerRefer()同步
 */
class DataModel {
/**
 *
 * @var array (多维)数据数组
 */
    protected $data = null;
    /**
     *
     * @var int 数据数组的指�?
     */
    protected $pointer = 0;
    /**
     *
     * @var int 数据数组的长�?
     */
    protected $length = 0;
    /**
     * 创建�?��DataModel对象用于"数字索引数组"数据的承�?
     * @param array $data 数据数组
     */
    public function __construct($data = null) {
    //初始化DataModel对象串的数据数组
        $this->setData($data);
    }
    /**
     *  返回该对象指针引�?
     * @return reference int
     */
    public function & getPointerRefer() {
        return $this->pointer;
    }
    /**
     * 将传递进来的指针引用同步到本对象
     * @param reference int $refer 指针引用
     */
    public function setPointerRefer(& $refer) {
        $this->pointer = & $refer;
    }
    /**
     *  重置数组指针
     * @param int $pointer 指针指向的数组下�?
     */
    public function setPointer($pointer) {
        $this->pointer = $pointer;
    }
    /**
     *  初始化DataModel对象的数据数�?
     * @param array|object refer $array 数据数组或�?数据对象
     */
    public function setData($data) {
        if ($data === null) {
            return;
        }elseif (is_array($data)) {
            $this->data = $data;
        }else {
            $this->data = $data->getData();
        }
        $this->pointer = 0;
        $this->length = count($this->data);
    }
    /**
     *  同步数据数组到本对象
     * @param array refer $refer 外部数据数组
     */
    public function setDataRefer(& $refer) {
        $this->data = & $refer;
    }
    /**
     * 返回本对象数据数组的引用
     * @return reference array
     */
    public function & getDataRefer() {
        return $this->data;
    }
    /**
     *  获取当前指针指向的数据元�?
     * @return array
     */
    public function getData() {
        return $this->data[$this->pointer];
    }
    /**
     *  判断是否还有数据元素可以读取,如果有则将数据数组中的元素复制到该对象属性中
     * @return bool
     * 数据数组中还有数据返回true,否则返回false
     */
    public function have() {
        if ($this->pointer < $this->length) {
        /**
         * 将数据数组中的元素复制到该对象属性中.
         * 复制数组中的元素到与这个元素索引命相同的属�?�?
         * 如果数据数组中的索引命不曾在类中定义,这个属�?仍然会以public权限被建�?
         */
            $data = $this->getData();
            foreach ($data as $field => $value) {
                $this->{$field} = $value;
            }
            return true;
        }else {
            return false;
        }
    }
    /**
     *  控制该对象的数据数组指针后移�?��
     * @return bool
     */
    public function next() {
        return ++$this->pointer;
    }
}
class OptionModel {
    private $optionData;
    public function __construct($optionData) {
        $this->optionData = $optionData;
        $this->defineConfig();
    }
    public function getOption($name) {
        if (isset ($this->optionData[$name])) {
            return $this->optionData[$name];
        }
    }
    public function defineConfig() {
        foreach ($this->optionData as $key => $value) {
            $ukey = strtoupper($key);
            if (!defined($ukey)) {
                define($ukey,$value);
            }
        }
    }
}
class Post extends DataModel {
    private $id;
    private $slug;
    private $title;
    private $date;
    private $intro;
    private $content;
    private $publish;
    private $allowComment;
    private $commentNum;
    //O
    public function id() {
        return $this->id;
    }
    public function title() {
        return $this->title;
    }
    public function slug() {
        return $this->slug;
    }
    public function date() {
        return $this->date;
    }
    public function intro() {
        return $this->intro;
    }
    public function content() {
        return $this->content;
    }
    public function allowComment() {
        return $this->allowComment;
    }
    public function publish() {
        return $this->publish;
    }
    public function commentNum() {
        return $this->commentNum;
    }
}
class Category extends DataModel {
    private $id;
    private $slug;
    private $name;
    private $parentId;
    private $desc;
    private $includeNum;
    //O
    public function id() {
        return $this->id;
    }
    public function name() {
        return $this->name;
    }
    public function slug() {
        return $this->slug;
    }
    public function desc() {
        return $this->desc;
    }
    public function parentId() {
        return $this->parentId;
    }
    public function includeNum() {
        return $this->includeNum;
    }
}
class Tag extends DataModel {
    private $id;
    private $slug;
    private $name;
    private $includeNum;
    public function id() {
        return $this->id;
    }
    public function name() {
        return $this->name;
    }
    public function slug() {
        return $this->slug;
    }
    public function includeNum() {
        return $this->includeNum;
    }
}
class Author extends DataModel {
    private $id;
    private $name;
    private $account;
    private $pwd;
    private $email;
    private $website;
    private $grade;
    public function setName($name) {
        $this->name = $name;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setWebsite($website) {
        $this->website = $website;
    }
    public function id() {
        return $this->id;
    }
    public function name() {
        return $this->name;
    }
    public function email() {
        return $this->email;
    }
    public function website() {
        return $this->website;
    }
    public function grade() {
        return $this->grade;
    }
    public function pwd() {
        return $this->pwd;
    }
    public function account() {
        return $this->account;
    }
}
class Comment extends DataModel {
    private $id;
    private $date;
    private $content;
    public function setId($id) {
        $this->id = $id;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    public function setDate($date) {
        $this->date = $date;
    }
    public function id() {
        return $this->id;
    }
    public function content() {
        return $this->content;
    }
    public function date() {
        return $this->date;
    }
}

class BookMarkView extends BookMark {
    public function link() {
        echo '<a href="'.$this->url.'">'.$this->name.'</a>';
    }
    public function introduce() {
        echo $this->intro();
    }
}
class PostView extends Post {
    
}
    
class CategoryView extends Category {

}
class TagView extends Tag {
    
}
class AuthorView extends Author {
    
}
class CommentView extends Comment {
    
}
class PlatForm {
    public function regModel($name,$obj) {
        if (!isset($this->reg[$name]) && $name !== null && $obj !== null) {
            $this->{$name} = $obj;
            return true;
        }
        return false;
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
            echo '<a href="'.BLOG_URL.'index.php?'.$prevurl.'">上一�?/a>';
            echo '</span>';
        }
        if ($page < $this->totalPage()) {
            echo '<span class="next">';
            echo '<a href="'.BLOG_URL.'index.php?'.$nexturl.'">下一�?/a>';
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
class Validate {
    public function checkFormSubmit($iTimeOffset=60) {
    // 取得表单的标�?
        $idForm = isset($_COOKIE['PHPSESSID'])?$_COOKIE['PHPSESSID']:null;
        // 是否�?��表单提交�?��
        $iFormCheck = true;
        if (isset($_SESSION['formSubmitCheck'])) {
        // 删除过期的表单标�?
            foreach (array_keys($_SESSION['formSubmitCheck']) as $val) {
                if (time() > $val) {
                    unset($_SESSION['formSubmitCheck'][$val]);
                }
            }
        }else {
            $_SESSION['formSubmitCheck'] = array();
            $iFormCheck = false;
        }
        if ($iFormCheck == true) {
        // �?��是否有重复标识的提交记录
            foreach ($_SESSION['formSubmitCheck'] as $val) {
                if ($val == $idForm) {
                    return false;
                }
            }
        }
        // 保存表单标识
        $_SESSION['formSubmitCheck'][(time()+$iTimeOffset)] = $idForm;
        return true;
    }
}


class test {
    public function saveCategory() {
        $query = 'INSERT INTO `category`(`category_id`,`category_name`,`category_slug`,`category_desc`,`category_pid`) values ( NULL,\''.$this->name.'\',\''.$this->slug.'\',\''.$this->desc.'\',\''.$this->pid.'\')';
        if ($this->DBCHandle->query($query)) {
            return $this->DBCHandle->getInsertId();
        }else {
            return false;
        }
    }
    public function updateCategory() {
        $query = 'UPDATE `category` SET category_name=\''.$this->name.'\',category_slug=\''.$this->slug.'\',category_desc=\''.$this->desc.'\',category_pid=\''.$this->pid.'\' WHERE category_pid = \''.$this->id.'\'';
        if ($this->DBCHandle->query($query)) {
            return $this->DBCHandle->getInsertId();
        }else {
            return false;
        }
    }
    public function deleteCategory($id) {
        $query = 'SELECT category_pid FROM category WHERE category_id = '.$id;
        $resource = $this->DBCHandle->query($query);
        $result = $this->DBCHandle->fetchArray($resource);
        $parentId = $result['category_pid'];
        $query = 'UPDATE category SET category_pid = \''.$parentId.'\'  WHERE category_pid = '.$id;
        if ($this->DBCHandle->query($query)) {
            $query = 'DELETE FROM category WHERE category_id = '.$id;
            if ($this->DBCHandle->query($query)) {
                $query = 'DELETE FROM postcategory WHERE category_id = '.$id;
                if ($this->DBCHandle->query($query)) {
                    return true;
                }
            }
        }
        return false;
    }



    public function saveTags($array) {
        $query = 'SELECT tag_id FROM tag WHERE tag_name IN('.implode(',',$array).')';
        $resource = $this->DBCHandle->query($query);
        $loop = true;
        while ($loop) {
            $result = $this->DBCHandle->fetchArray($resource);
            if ($result == false) {
                $loop = false;
            }else {
                $array2[] = $result;
            }
        }
        $insertArray = array_diff($array, $array2);
        $query = 'INSERT INTO `tag`(`tag_id`,`tag_name`,`tag_desc`) values ';
        foreach ($insertArray as $tag_name) {
            $query .= '(NULL,\''.$tag_name.'\',\''.$tag_name.'\'),';
        }
        $query = substr($query, 0, -1);
        if ($this->DBCHandle->query($query)) {
            $insertId = $this->DBCHandle->getInsertId();
            for ($i=count($insertArray);$i>0;$i--) {
                $array2[] = $insertId++;
            }
            return $array2;
        }else {
            return false;
        }
    }
    public function saveTag() {
        $query = 'INSERT INTO `tag`(`tag_id`,`tag_name`,`tag_slug`) values ( NULL,\''.$this->name.'\',\''.$this->slug.'\')';
        if ($this->DBCHandle->query($query)) {
            return $this->DBCHandle->getInsertId();
        }else {
            return false;
        }
    }
    public function updateTag() {
        $query = 'UPDATE `tag` SET tag_name=\''.$this->name.'\',tag_slug=\''.$this->slug.'\' WHERE tag_id = \''.$this->id.'\'';
        if ($this->DBCHandle->query($query)) {
            return $this->DBCHandle->getInsertId();
        }else {
            return false;
        }
    }
    public function deleteTag($id) {
        $query = 'DELETE FROM tag WHERE tag_id = '.$id;
        if ($this->DBCHandle->query($query)) {
            $query = 'DELETE FROM posttag WHERE tag_id = '.$id;
            if ($this->DBCHandle->query($query)) {
                return true;
            }
        }
        return false;
    }

    public function updateOption() {
        $query = 'UPDATE option SET option_value = \''.$this->value.'\' WHERE option_name = \''.$this->name.'\'';
        return $this->DBCHandle->query($query);
    }



    public function savePost() {
        $query = 'INSERT INTO `post`(`post_id`,`post_title`,`post_slug`,`post_intro`,`post_content`,`post_date`,`post_author`) values ( NULL,\''.$this->title.'\',\''.$this->slug.'\',\''.$this->intro.'\',\''.$this->content.'\',\''.$this->date.'\',\''.$this->author.'\')';
        if ($this->DBCHandle->query($query)) {
            return $this->DBCHandle->getInsertId();
        }else {
            return false;
        }
    }
    public function updatePost() {
        $query = 'UPDATE `post` SET post_title=\''.$this->title.'\',post_slug=\''.$this->slug.'\',post_intro=\''.$this->intro.'\',post_content=\''.$this->content.'\',post_date=\''.$this->date.'\',post_date=\''.$this->author.'\'';
        if ($this->DBCHandle->query($query)) {
            return $this->DBCHandle->getInsertId();
        }else {
            return false;
        }
    }
    public function deletePost($id) {
        $query = 'DELETE FROM post WHERE post_id = '.$id;
        if ($this->DBCHandle->query($query)) {
            $query = 'DELETE FROM posttag WHERE post_id = '.$id;
            if ($this->DBCHandle->query($query)) {
                $query = 'DELETE FROM postcategory WHERE post_id = '.$id;
                if ($this->DBCHandle->query($query)) {
                    return true;
                }
            }
        }
        return false;
    }
    public function savePostCategory($insertId,$array) {
        $query = 'INSERT INTO `postcategory`(`post_id`,`category_id`) values ';
        foreach ($array as $category_id) {
            $query .= '(\''.$insertId.'\',\''.$category_id.'\'),';
        }
        $query = substr($query, 0, -1);
        return $this->DBCHandle->query($query);
    }
    public function updatePostCategory($insertId,$array) {
        $query = 'SELECT category_id FROM postcategory WHERE post_id='.$insertId;
        $resource = $this->DBCHandle->query($query);
        $loop = true;
        while ($loop) {
            $result = $this->DBCHandle->fetchArray($resource);
            if ($result == false) {
                $loop = false;
            }else {
                $array2[] = $result;
            }
        }
        $insertArray = array_diff($array, $array2);
        $deleteArray = array_diff($array2, $array);
        $query = 'INSERT INTO `postcategory`(`post_id`,`category_id`) values ';
        foreach ($insertArray as $category_id) {
            $query .= '(\''.$insertId.'\',\''.$category_id.'\'),';
        }
        $query = substr($query, 0, -1);
        $insertResult = $this->DBCHandle->query($query);
        $query = 'DELETE FROM `postcategory` WHERE post_id = \''.$insertId.'\' AND category_id IN('.implode(',',$deleteArray).')';
        $deleteResult = $this->DBCHandle->query($query);
        return ($insertResult && $deleteResult);
    }
    public function savePostTag($insertId,$array) {
        $query = 'INSERT INTO `posttag`(`post_id`,`tag_id`) values ';
        foreach ($array as $tag_id) {
            $query .= '(\''.$insertId.'\',\''.$tag_id.'\'),';
        }
        $query = substr($query, 0, -1);
        return $this->DBCHandle->query($query);
    }
    public function updatePostTag($insertId,$array) {
        $query = 'SELECT tag_name FROM posttag,tag WHERE posttag.tag_id = tag.tag_id AND posttag.post_id='.$insertId;
        $resource = $this->DBCHandle->query($query);
        $loop = true;
        while ($loop) {
            $result = $this->DBCHandle->fetchArray($resource);
            if ($result == false) {
                $loop = false;
            }else {
                $array2[] = $result;
            }
        }
        $insertArray = array_diff($array, $array2);
        $deleteArray = array_diff($array2, $array);

        $query = 'INSERT INTO `tag`(`tag_id`,`tag_name`,`tag_desc`) values ';
        foreach ($insertArray as $tag_name) {
            $query .= '(NULL,\''.$tag_name.'\',\''.$tag_name.'\'),';
        }
        $query = substr($query, 0, -1);
        if ($this->DBCHandle->query($query)) {
            $insertId = $this->DBCHandle->getInsertId();
            for ($i=count($insertArray);$i>0;$i--) {
                $insertTagIdArray[] = $insertId++;
            }
            $query = 'INSERT INTO `posttag`(`post_id`,`tag_id`) values ';
            foreach ($insertTagIdArray as $tag_id) {
                $query .= '(\''.$insertId.'\',\''.$tag_id.'\'),';
            }
            $query = substr($query, 0, -1);
            $insertResult = $this->DBCHandle->query($query);
        }else {
            $insertResult = false;
        }
        $query = 'DELETE FROM `posttag` WHERE post_id = \''.$insertId.'\' AND tag_id IN('.implode(',',$deleteArray).')';
        $deleteResult = $this->DBCHandle->query($query);
        return ($insertResult && $deleteResult);
    }
}
?>
