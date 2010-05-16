<?php
class Comment {
    private $totalNum = null;
    public function  __construct() {
        $this->db = July::instance('db');
        $this->cache = July::instance('cache');
    }
    public function getCommentsById($id,$page,$pageLength) {
        $args = func_get_args();
        $cacheName = __CLASS__.'_'.__FUNCTION__.implode('_', $args);
        $page = (int) $page;
        $pageLength = (int) $pageLength;
        if ($page < 1) {
            throw new Exception("currentpage is not effective\n");
        }
        if ($pageLength < 1) {
            throw new Exception("pageLength is not effective\n");
        }
        try {
            $this->cache->workDir(APP_ROOT.'/cache');
            $result = $this->cache->get($cacheName);
            $this->totalNum = $this->cache->get(__CLASS__.'_'.__FUNCTION__.'_totalNum');
        } catch (FileSystemException $e) {
            $this->cache->touch($cacheName);
            $queryString = "
            SELECT SQL_CALC_FOUND_ROWS
                *
            FROM comment
            WHERE
                relate_id = {$id}
            LIMIT ".($page-1)*$pageLength.",".$pageLength;
            $result = $this->db->selectAsArray($queryString);
            $totalNum = $this->db->selectFirst("SELECT FOUND_ROWS() as totalnum",true);
            $this->totalnum = $totalNum['totalnum'];
            $this->cache->set($cacheName,$result);
            $this->cache->set(__CLASS__.'_'.__FUNCTION__.'_totalNum',$this->totalnum);
        }
        return $result;
    }
    /**
     *  get totalNum use FOUND_ROWS
     * @return int
     */
    public function totalNum() {
        if ($this->totalNum === null) {
            return 0;
        } else {
            return $this->totalNum;
        }
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
    public function newComment($data) {
        $queryString = 'SELECT  FROM `user`';
        $queryString = 'INSERT INTO `user` (`name`,email,website)';
        $queryString = 'INSERT INTO comment(content,date,relate_id)';
        $queryString .= " VALUES ('".$data['content']."', NULL , '".$data['relate_id']."')";
        $result = $this->db->insert($queryString);
        $queryString = "UPDATE article SET `comment_num` = `comment_num`+1 WHERE id = ".$data['relate_id'];
        if ($this->db->update($queryString) <= 0) {
            throw new ModelException("add comment failure\n");
        }
    }
    public function deleteComment($id) {
        $queryString = "SELECT relate_id FROM comment WHERE id = {$id}";
        $data = $this->db->selectFirst($queryString);

        $queryString = "DELETE FROM comment WHERE id = {$id}";
        if ($this->db->delete($queryString) <= 0) {
            throw new ModelException("delete comment failure\n");
        }

        $queryString = "UPDATE article SET `commentnum` = commentnum-1 WHERE id = ".$data['relate_id'];
        if ($this->db->update($queryString) <= 0) {
            throw new UserException("update article comment number failure\n");
        }
    }
    
}
?>
