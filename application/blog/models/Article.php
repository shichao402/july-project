<?php
class Article {
    private $totalNum = null;
    public function  __construct() {
        $this->db = July::instance('db');
        $this->cache = July::instance('cache');
    }
    /**
     *  获取文章列表,在这个对象里面暂存文章id列表,计算文章总数量
     * @param int $page 当前页
     * @param int $pageLength   每页文章数量
     * @return array    文章列表
     */
    public function articleList($page,$pageLength) {
        $args = func_get_args();
        $cacheName = __CLASS__.'_'.__FUNCTION__.'_'.implode('_',$args);
        try {
            $result = $this->cache->get($cacheName);
            $this->totalNum = $this->cache->get(__CLASS__.'_'.__FUNCTION__.'_totalNum');
        } catch (FileSystemException $e) {
            echo $e->getTraceAsString();

            $this->cache->touch($cacheName);
            $this->cache->touch(__CLASS__.'_'.__FUNCTION__.'_totalNum');

            $queryString = 'SELECT SQL_CALC_FOUND_ROWS * from article';
            $queryString .= ' LEFT JOIN user ON user.id = article.author';
            $queryString .= ' WHERE article.publish = 1';
            $queryString .= ' ORDER BY article.date DESC';
            $queryString .= ' LIMIT '.$pageLength*($page-1).','.$pageLength;
            $result = $this->db->selectAsArray($queryString);

            $totalNum = $this->db->selectFirst("SELECT FOUND_ROWS() as totalnum",true);
            $this->totalNum = $totalNum['totalnum'];

            $this->cache->set($cacheName,$result,60);
            $this->cache->set(__CLASS__.'_'.__FUNCTION__.'_totalNum',$this->totalNum);
        }
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
        if ($this->totalNum === null) {
            throw new Exception("no SQL_CALC_FOUND_ROWS executed\n");
        } else {
            return $this->totalNum;
        }
    }
    public function getArticleById($id) {
        $cacheName = __CLASS__.'_'.__FUNCTION__.'_'.$id;
        try {
            $result = $this->cache->get($cacheName);
        } catch (FileSystemException $e) {
            $this->cache->touch($cacheName);
            $queryString = 'SELECT article.* FROM article';
            $queryString .= ' LEFT JOIN user ON user.id = article.author';
            $queryString .= ' WHERE article.publish = 1 AND article.id = '.$id;
            $queryString .= ' LIMIT 0,1';
            $result = $this->db->selectFirst($queryString,true);
            $this->cache->set($cacheName,$result,60);
        }
        return $result;
    }
    public function getArticleByTag($tagId) {
        
    }
    public function searchArticle($keywords) {
        
    }
    public function newArticle($data) {
        $queryString = "INSERT INTO article(".implode(",",array_keys($data)).") VALUES ('".implode("','",$data)."')";
        $affectedNum = $this->db->insert($queryString);
        if ($affectedNum > 0) {
            return $affectedNum;
        } else {
            throw new ModelException("no article added\n");
        }
    }
}
?>
