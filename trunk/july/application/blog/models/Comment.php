<?php
class Comment {
    private $totalNum = null;
    public function  __construct() {
        $this->db = July::instance('db');
        $this->cache = July::instance('cache');
    }
    public function getCommentsById($id,$page,$pageLength) {
        $cacheName = __CLASS__.'_'.__METHOD__.implode('_', func_get_args());
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
            $this->totalNum = $this->cache->get(__CLASS__.'_'.__METHOD__.'_totalNum');
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
            $this->cache->set(__CLASS__.'_'.__METHOD__.'_totalNum',$this->totalnum);
        }
        return $result;
    }
    /**
     *  get totalNum use FOUND_ROWS
     * @return int
     */
    public function totalNum() {
        if ($this->totalNum === null) {
            throw new Exception("no SQL_CALC_FOUND_ROWS executed\n");
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
        $queryString = 'INSERT INTO comment(content,author,date,relate_id)';
        $queryString .= " VALUES ('".$data['content']."','".$data['author']."', NULL , '".$data['relate_id']."')";
        $result = $this->db->insert($queryString);
        if ($result > 0) {
            $query = 'UPDATE article SET `commentnum` = commentnum+1 WHERE id = \''.$data['relate_id'].'\'';
            if ($this->db->update($query) <= 0) {
                $queryString = 'DELETE FROM comment WHERE id = '.$this->db->lastInsertId();
                $result = $this->db->delete($queryString);
                throw new UserException("add comment failure\n");
            }
        } else {
            throw new UserException("can not insert\n");
        }
    }
    public function deleteComment($id) {
        $queryString = "SELECT relate_id FROM comment WHERE id = {$id}";
        $data = $this->db->selectFirst($queryString);

        $queryString = "DELETE FROM comment WHERE id = {$id}";
        if ($this->db->delete($queryString) <= 0) {
            throw new UserException("delete comment failure\n");
        }

        $queryString = "UPDATE article SET `commentnum` = commentnum-1 WHERE id = ".$data['relate_id'];
        if ($this->db->update($queryString) <= 0) {
            throw new UserException("update article comment number failure\n");
        }
    }
}
?>
