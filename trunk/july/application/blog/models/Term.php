<?php
class Term {
    public function __construct() {
        $this->db = July::instance('db');
    }
    public function add($data) {
        $queryString = "INSERT INTO term(".implode(",",array_keys($data)).") VALUES ('".implode("','",$data)."')";
        $affectedNum = $this->db->insert($queryString);
        if ($affectedNum > 0) {
            return $affectedNum;
        } else {
            throw new ModelException("and term failed\n");
        }
    }
    public function delete($id) {
        $queryString = "
        DELETE term,termRelation
        FROM term,termRelation
        WHERE term.id = termRelation.term_id
            AND termRelation.term_id = {$id}
        ";
        $affectedNum = $this->db->delete($queryString);
        if ($affectedNum > 0) {
            return $affectedNum;
        } else {
            throw new ModelException("delete term and relation failed\n");
        }
    }
    public function update($id,$data) {
        foreach ($data as $key => $value) {
            $updateArray[] = "`{$key}` = {$value}";
        }
        $queryString = "UPDATE term SET ".implode(',', $updateArray)." WHERE id = {$id}";
        $affectNum = $this->db->update($queryString);
        if ($affectedNum > 0) {
            return $affectedNum;
        } else {
            throw new ModelException("update term failed\n");
        }
    }
    public function relate($termId,$relationId) {
        $queryString = "
        INSERT INTO
        termRelation(term_id,relation_id)
        VALUES
        ('{$termId}','{$relationId}')
        ";
        $affectedNum = $this->db->insert($queryString);
        if ($affectedNum > 0) {
            return $affectedNum;
        } else {
            throw new ModelException("insert term relation failed\n");
        }
    }
    public function quickNewTag($tagArray) {
        $tagArray = array_unique($tagArray);
        foreach ($tagArray as $key => $value) {
            $queryString = "UPDATE term SET `name` = {$value[0]},`slug` = {$value[1]},'type' = 'article','include_num` = 'include_num` + 1 WHERE `name` = {$value[0]} AND `slug` = {$value[1]}";
            $affectedNum = $this->db->update($queryString);
            if ($affectedNum > 0) {
                unset($tagArray[$key]);
            }
        }
        foreach ($tagArray as $tag) {
             $insertArray[] = "('".implode("','",$tag)."',1)";
        }
        $queryString = "INSERT INTO term(`name`,slug,`type`,includenum) VALUES ".implode(',',$tempArray);
        $affectedNum = $this->db->insert($queryString);
        if ($affectedNum > 0) {
            return $affectedNum;
        } else {
            throw new ModelException("insert term relation failed\n");
        }
    }
}
?>
