<?php
class Article {
    private $SQL_CALC_FOUND_ROWS = false;
    public function  __construct() {
        $this->db = July::instance('db');
    }
    /**
     *  获取文章列表,在这个对象里面暂存文章id列表,计算文章总数量
     * @param int $page 当前页
     * @param int $pageLength   每页文章数量
     * @return array    文章列表
     */
    public function articleList($page,$pageLength) {
        $queryField = array(
                'id',
                'title',
                'slug',
                'intro',
                'content',
                'date',
                'author',
                'allowcomment',
                'publish',
                'commentnum'
        );
        $queryString = 'SELECT SQL_CALC_FOUND_ROWS '.implode(',',$queryField).' from post';
        $queryString .= ' LEFT JOIN author ON author.author_id = post.post_author';
        $queryString .= ' WHERE post.post_publish = 1';
        $queryString .= ' ORDER BY post.post_date DESC';
        $queryString .= ' LIMIT '.$pageLength*($page-1).','.$pageLength;
        $result = $this->db->selectAsArray($queryString);
        $this->SQL_CALC_FOUND_ROWS = true;
        return $result;
    }
    /**
     *  按照$needles指定的值匹配$haystack内所有键名,返回匹配成功的键名键值.
     * @param array $needles  需要查找的键值
     * @param array $haystack 等待查找的数组
     * @return array 数组
     */
    public function splitArray($needles,$haystack) {
        if (empty($needles) || empty ($haystack) || !is_array($needles) || !is_array($haystack)) {
            throw new ModelException("needles or hystack is not effective\n");
        } else {
            foreach ($haystack as $each) {
                foreach ($needles as $needle) {
                    $array[$needle][] = $each[$needle];
                }
            }
            return $array;
        }
    }
    /**
     *  获取总页数
     * @param int $totalNum 总数
     * @param int $pageLength   每页数量
     * @return int 总页数
     */
    public function totalPage($totalNum,$pageLength) {
        return (int) ($totalNum/$pageLength) + 1;
    }
    /**
     *  获得上次包含SQL_CALC_FOUND_ROWS的SQL查询总数
     * @return int
     */
    public function totalNum() {
        if ($this->SQL_CALC_FOUND_ROWS === true) {
            $result = $this->db->selectFirst("SELECT FOUND_ROWS() as totalnum",true);
            $this->SQL_CALC_FOUND_ROWS = true;
            return (int) $result['totalnum'];
        }else {
            throw new Exception("the last sqlquery seems didnt have SQL_CALC_FOUND_ROWS\n");
        }
    }
    public function post($data) {
        
    }
    public function delete($id) {
        
    }
    public function update($id) {
        
    }
}
?>
