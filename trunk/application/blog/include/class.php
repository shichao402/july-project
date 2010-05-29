<?php
class PF {
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
?>
