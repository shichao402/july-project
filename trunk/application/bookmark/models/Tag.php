<?php
class Tag {
    private $db;
    /**
     * create tag
     */
    public function __construct() {
        $this->july = July::instance();
        $this->db = $this->july->db;
    }
    /**
     *  get tagslist by $idArray
     * @param array $idArray array of id,id is tag relation
     * @return taglist
     */
    public function tagsInId($idArray) {
        $idString = implode(",", $idArray);
        $queryString = "
            SELECT
                termRelation.relation_id AS `relateId`,
                term.id                  AS `termId`,
                term.slug                AS `slug`,
                term.name                AS `name`,
                term.desc                AS `description`
            FROM termRelation
            LEFT JOIN term
                ON termRelation.term_id = term.id AND term.type = 'bookmarktag'
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
