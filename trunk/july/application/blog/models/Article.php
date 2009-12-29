<?php
class Article {
    public function  __construct() {

    }
    /**
     *  获取文章列表,在这个对象里面暂存文章id列表,计算文章总数量
     * @param int $page 当前页
     * @param int $pageLength   每页文章数量
     * @return array    文章列表
     */
    public function articleList($page,$pageLength) {
        return $result;
    }
    /**
     *  获得上次成功读取文章列表的所有id
     * @return array 数组,包含上次成功读取列表的文章id
     */
    public function idArray() {
        return $array;
    }
    /**
     *  获取总页数
     * @return int
     */
    public function totalPage() {
        return $int;
    }
    public function totalCount() {
        return $totalCount;
    }
}
?>
