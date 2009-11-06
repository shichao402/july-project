<?php
class BookMark extends Model {
    public function bookmarks() {
        $page = 1;
        $length = 10;
        $offset = ($page-1)*$length;
        return $this->DB->queryAsArray("SELECT * FROM bookmark LIMIT {$offset},{$length}");
    }
}
