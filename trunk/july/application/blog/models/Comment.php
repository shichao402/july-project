<?php
class Comment {
    private $SQL_CALC_FOUND_ROWS = false;
    public function  __construct() {
        $this->db = July::instance('db');
        $this->cache = July::instance('cache');
    }
    public function getCommentsById($id,$page,$pageLength) {
        $page = (int) $page;
        $pageLength = (int) $pageLength;
        if ($page < 1) {
            $page = 1;
        }
        if ($pageLength < 1) {
            $pageLength = 1;
        }
        try {
            $cache = new cache(APP_ROOT.'/cache');
            $result = $cache->get(__METHOD__.implode('_', func_get_args()));
        } catch (FileSystemException $e) {
            echo $e->getMessage();
            $queryString = "
            SELECT SQL_CALC_FOUND_ROWS
                *
            FROM comment
            WHERE
                relate_id = {$id}
            LIMIT ".($page-1)*$pageLength.",".$pageLength;
            $result = $this->db->selectAsArray($queryString);
            $this->SQL_CALC_FOUND_ROWS = true;
        }
        return $result;
    }
    /**
     *  get totalNum use FOUND_ROWS
     * @return int
     */
    public function totalNum() {
        $result = $this->db->selectFirst("SELECT FOUND_ROWS() as totalnum",true);
        $this->SQL_CALC_FOUND_ROWS = false;
        return (int) $result['totalnum'];
    }
    /**
     *  get totalPage use $this->totalNum
     * @param int $pageLength
     * @return int
     */
    public function totalPage($totalNum,$pageLength) {
        $totalPage = (int) ($totalNum/$pageLength) + 1;
        return $totalPage;
    }
}
?>
