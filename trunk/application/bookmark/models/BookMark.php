<?php
class BookMark {
    public function __construct() {
        $this->db = July::instance('db');
    }
    public function idArray() {
        $result = array();
        foreach ($this->list as $list) {
            $result[] = $list['id'];
        }
        return $result;
    }
    public function totalNum() {
        $this->totalNum = $this->db->selectFirst("SELECT FOUND_ROWS() as totalnum",true);
        return (int) $totalNum['totalnum'];
    }
    public function totalPage($pageLength) {
        $this->totalPage = ($this->totalNum()/$pageLength) + 1;
        return $this->totalPage;
    }
    public function num() {
        return $this->num;
    }
    public function bookmarks($page,$pageLength) {
        $offset = ($page-1)*$pageLength;
        $queryString = "
            SELECT SQL_CALC_FOUND_ROWS
                *
            FROM bookmark
            ORDER BY addDate DESC
            LIMIT {$offset},{$pageLength}";
        $this->list = $this->db->selectAsArray($queryString);
        return $this->list;
    }
    public function search($filed,$keywords,$page) {
        $keywordsString = "";
        $keywords = explode(' ',$keywords);
        foreach ($keywords as $keyword) {
            $keyString .= empty($keyword) ? '' : $filed.' like \'%'.$keyword.'%\' OR ';
        }
        $keyString = substr($keyString, 0, -3);
        $pageLength = PAGE_LENGTH;
        //@todo $length = July::$CONFIG['pageLength'];
        $offset = ($page-1)*$pageLength;
        $queryString = "
            SELECT SQL_CALC_FOUND_ROWS
                *
            FROM bookmark
            WHERE {$keyString}
            LIMIT {$offset},{$pageLength}";
        $result = $this->db->selectAsArray($queryString);
        if (!empty($result)) {
            $totalNum = $this->db->selectFirst("SELECT FOUND_ROWS() as totalnum",true);
            $totalNum = (int) $totalNum['totalnum'];
        } else {
            $totalNum = 0;
        }
        $this->list = $result;
        $this->pointer = 0;

        $this->page = $page;
        $this->num = count($result);
        $this->totalNum = $totalNum;
        $this->totalPage = (int) ($totalNum/$pageLength)+1;
    }
    public function saveFromForm($input) {
        $name = $input['name'];
        $url = urlencode($input['url']);
        $intro = $input['intro'];
        if (empty($name) || empty($url)) {
            throw new Exception("name and url can not be empty\n");
        }else {
            $queryString = "
                INSERT INTO `bookmark`
                    (`id`,`name`,`url`,`visitCount`,`addDate`,`lastVisitDate`,`lastModifiedDate`,`intro`)
                VALUES
                    ( NULL,'$name','$url','0',NULL,NULL,NULL,'$intro')";
            $result = $this->db->insert($queryString);
            if ($result === 0) {
                return false;
            }else {
                return true;
            }
        }
    }
    public function delete($id) {
        if (empty($id)) {
            throw new Exception("bookmark id can not be empty\n");
        }else {
            $result = $this->db->delete("DELETE FROM `bookmark` WHERE id = {$id}");
            if ($result === 0) {
                return false;
            }else {
                return true;
            }
        }
    }
}
?>