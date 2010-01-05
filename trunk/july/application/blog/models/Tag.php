<?php
class Term {
    public function __construct() {
        $this->db = July::instance('db');
    }
    public function add($data) {
        $queryString = "INSERT INTO term(".implode(",",array_keys($data)).") VALUES ('".implode("','",$data)."')";
        $affectedNum = $this->db->insert($queryString);
    }
    public function delete($id) {
        $queryString = "
        DELETE term,termRelation
        FROM term,termRelation
        WHERE term.id = termRelation.term_id
            AND termRelation.term_id = {$id}
        ";
    }
    public function update($id,$data) {
        $queryString = "UPDATE";
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
}
?>
