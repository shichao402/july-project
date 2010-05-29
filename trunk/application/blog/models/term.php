<?php
class Term {
    private $type;
    public function __construct($type) {
        $this->db = July::instance('db');
        $this->type = $type;
    }
    public function add($data) {
        $queryString = "INSERT INTO term(`".implode("`,`",array_keys($data))."`) VALUES ('".implode("','",$data)."')";
        try {
            $affectedNum = $this->db->insert($queryString);
            if ($affectedNum > 0) {
                return $affectedNum;
            } else {
                throw new ModelException("add term failed\n");
            }
        } catch (DBException $e) {
            if ($e->getCode() == 1062) {
                throw new ModelException($e->getMessage());
            } else {
                throw $e;
            }
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
    public function TermsInId($idArray) {
        if (empty($idArray)) {
            return null;
        }
        $idString = implode(",", $idArray);
        $queryString = "
            SELECT
                termRelation.relation_id AS `relation_id`,
                term.id                  AS `term_id`,
                term.slug                AS `slug`,
                term.name                AS `name`,
                term.desc                AS `desc`
            FROM termRelation
            LEFT JOIN term
                ON termRelation.term_id = term.id AND term.type = '{$this->type}'
            WHERE termRelation.relation_id IN ({$idString})";
        $resource = $this->db->query($queryString);
        $result = mysql_fetch_array($resource);
        if ($result !== false) {
            while ($result !== false) {
                $list[$result['relateId']][] = $result;
                $result = mysql_fetch_array($resource);
            }
        }
        return $list;
    }
}
?>
