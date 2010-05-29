<?php
class DBC extends Mysql {
    public function __construct() {
        $this->connect();
        if ($this->version() > '4.1') {
            $this->query("SET NAMES 'utf8'");
        }
    }
    public function __destruct() {
        $this->close();
    }
    public function getBookMarks($page = 0) {
        list($prefixedColumn,$a) = $this->Field2String($queryField,true);
        $query = 'SELECT SQL_CALC_FOUND_ROWS '.$prefixedColumn.' from bookMark';
        $query .= ' ORDER BY bookMark.addDate DESC';
        $query .= ' LIMIT '.POST_NUM_PERPAGE*($page-1).','.POST_NUM_PERPAGE;
        $resource = $this->queryArray($query);
        return $resource;
    }
    public function defineConfig() {
        $query = 'SELECT * FROM `option`';
        $query .= ' WHERE `option_autoload`= 1';
        $result = $this->queryArray($query);
        $optionData = array();
        foreach ($result as $row) {
            $optionData[$row['option_name']] = $row['option_value'];
        }
        new OptionModel($optionData);
    }
    public function getPosts($page = 1) {
        $queryField = array(
            'post' => array(
            'post_id',
            'post_title',
            'post_slug',
            'post_intro',
            'post_content',
            'post_date',
            'post_author',
            'post_allowcomment',
            'post_publish',
            'post_commentnum'
            ),
            'author' => array(
            'author_name',
            'author_account'
            )
        );
        $postData = array();
        $authorData = array();
        $idData = array();
        list($prefixedColumn,$a) = $this->Field2String($queryField,true);

        $query = 'SELECT SQL_CALC_FOUND_ROWS '.$prefixedColumn.' from post';
        $query .= ' LEFT JOIN author ON author.author_id = post.post_author';
        $query .= ' WHERE post.post_publish = 1';
        $query .= ' ORDER BY post.post_date DESC';
        $query .= ' LIMIT '.POST_NUM_PERPAGE*($page-1).','.POST_NUM_PERPAGE;
        $resource = $this->query($query);
        $this->getTotalNum();
        $temp = $this->fetchArray($resource);
        while ($temp) {
            $postData[] = array_slice($temp, $a['post']['offset'],$a['post']['length']);
            $authorData[] = array_slice($temp, $a['author']['offset'],$a['author']['length']);
            $idData[] = $temp['post_id'];
            $temp = $this->fetchArray($resource);
        }

        $post = new PostModel($postData);
        $author = new AuthorModel($authorData);
        $this->PF->regModel('post',$post);
        $this->PF->regModel('postAuthor',$author);
        $post = $post->getParent();
        $post->setSync($author->getStack());
        $this->getTerms($idData);
    }
    public function getPostsByCategoryId($categoryId,$page = 1) {
        $queryField = array(
            'post' => array(
            'post_id',
            'post_title',
            'post_slug',
            'post_intro',
            'post_content',
            'post_date',
            'post_author',
            'post_allowcomment',
            'post_publish',
            'post_commentnum'
            ),
            'author' => array(
            'author_name',
            'author_account'
            )
        );
        $postData = array();
        $authorData = array();
        $idData = array();
        list($prefixedColumn,$a) = $this->Field2String($queryField,true);
        $query = 'SELECT SQL_CALC_FOUND_ROWS '.$prefixedColumn.' FROM term';
        $query .= ' RIGHT JOIN postrelation ON term.term_id = postrelation.term_id';
        $query .= ' RIGHT JOIN post ON post.post_id = postrelation.post_id';
        $query .= ' LEFT JOIN author ON post.post_author = author.author_id';
        $query .= ' WHERE term.term_id = \''.$categoryId.'\' AND term.term_type = \'postcategory\'';
        $query .= ' LIMIT '.POST_NUM_PERPAGE*($page-1).','.POST_NUM_PERPAGE;
        $resource = $this->query($query);
        $this->getTotalNum();
        $temp = $this->fetchArray($resource);
        while ($temp) {
            $postData[] = array_slice($temp, $a['post']['offset'],$a['post']['length']);
            $authorData[] = array_slice($temp, $a['author']['offset'],$a['author']['length']);
            $idData[] = $temp['post_id'];
            $temp = $this->fetchArray($resource);
        }
        $post = new PostModel($postData);
        $author = new AuthorModel($authorData);
        $this->PF->regModel('post',$post);
        $this->PF->regModel('postAuthor',$author);
        $post = $post->getParent();
        $post->setSync($author->getStack());
        $this->getTerms($idData);
    }
    public function getPostsByTagId($tagId,$page = 1) {
        $queryField = array(
            'post' => array(
            'post_id',
            'post_title',
            'post_slug',
            'post_intro',
            'post_content',
            'post_date',
            'post_author',
            'post_allowcomment',
            'post_publish',
            'post_commentnum'
            ),
            'author' => array(
            'author_name',
            'author_account'
            )
        );
        $postData = array();
        $authorData = array();
        $idData = array();
        list($prefixedColumn,$a) = $this->Field2String($queryField,true);
        $query = 'SELECT SQL_CALC_FOUND_ROWS '.$prefixedColumn.' FROM term';
        $query .= ' RIGHT JOIN postrelation ON term.term_id = postrelation.term_id';
        $query .= ' RIGHT JOIN post ON post.post_id = postrelation.post_id';
        $query .= ' LEFT JOIN author ON post.post_author = author.author_id';
        $query .= ' WHERE term.term_id = \''.$tagId.'\' AND term.term_type = \'posttag\'';
        $query .= ' LIMIT '.POST_NUM_PERPAGE*($page-1).','.POST_NUM_PERPAGE;
        $resource = $this->query($query);
        $this->getTotalNum();
        $temp = $this->fetchArray($resource);
        while ($temp) {
            $postData[] = array_slice($temp, $a['post']['offset'],$a['post']['length']);
            $authorData[] = array_slice($temp, $a['author']['offset'],$a['author']['length']);
            $idData[] = $temp['post_id'];
            $temp = $this->fetchArray($resource);
        }

        $post = new PostModel($postData);
        $author = new AuthorModel($authorData);
        $this->PF->regModel('post',$post);
        $this->PF->regModel('postAuthor',$author);
        $post = $post->getParent();
        $post->setSync($author->getStack());
        $this->getTerms($idData);
    }
    public function getPostById($postId) {
        $queryField = array(
            'post' => array(
            'post_id',
            'post_title',
            'post_slug',
            'post_intro',
            'post_content',
            'post_date',
            'post_author',
            'post_allowcomment',
            'post_publish',
            'post_commentnum'
            ),
            'author' => array(
            'author_name',
            'author_account'
            )
        );
        $postData = array();
        $authorData = array();
        $idData = array();
        list($prefixedColumn,$a) = $this->Field2String($queryField,true);
        $query = 'SELECT '.$prefixedColumn.' FROM post';
        $query .= ' LEFT JOIN author ON author.author_id = post.post_author';
        $query .= ' WHERE post.post_publish = 1 AND post.post_id = \''.$postId.'\'';
        $query .= ' LIMIT 0,1';
        $resource = $this->query($query);
        $temp = $this->fetchArray($resource);
        if ($temp) {
            $postData[] = array_slice($temp, $a['post']['offset'],$a['post']['length']);
            $authorData[] = array_slice($temp, $a['author']['offset'],$a['author']['length']);
            $idData[] = $temp['post_id'];
        }
        $post = new PostModel($postData);
        $author = new AuthorModel($authorData);
        $this->PF->regModel('post',$post);
        $this->PF->regModel('postAuthor',$author);
        $post = $post->getParent();
        $post->setSync($author->getStack());
        $this->getTerms($idData);
    }
    private function getTerms($idData) {
        if ($idData == null) {return;}
        $queryField = array(
            'postrelation' => array(
            'post_id'
            ),
            'term' => array(
            '*'
            )
        );
        list($prefixedColumn,$a) = $this->Field2String($queryField);
        foreach($idData as $id) {
            (int) $id;
            $category[$id] = array();
            $tag[$id] = array();
        }
        $idStr = implode(',', $idData);

        $query = 'SELECT '.$prefixedColumn.' FROM postrelation';
        $query .= ' LEFT JOIN term ON term.term_id = postrelation.term_id';
        $query .= ' WHERE postrelation.post_id in ('.$idStr.')';
        $query .= ' ORDER BY post_id ASC';
        $resource = $this->query($query);
        $row = $this->fetchArray($resource);
        while ($row) {
            if ($row['term_type'] == 'postcategory') {
                $category[$row['post_id']][] = array(
                    'term_id' => $row['term_id'],
                    'term_name' => $row['term_name'],
                    'term_slug' => $row['term_slug'],
                    'term_parent' => $row['term_parent'],
                    'term_desc' => $row['term_desc'],
                    'term_includenum' => $row['term_includenum']
                );
            }elseif ($row['term_type'] == 'posttag') {
                $tag[$row['post_id']][] = array(
                    'term_id' => $row['term_id'],
                    'term_name' => $row['term_name'],
                    'term_slug' => $row['term_slug'],
                    'term_includenum' => $row['term_includenum']
                );
            }
            $row = $this->fetchArray($resource);
        }
        foreach ($category as $key=>$value) {
            $categoryData[] = $category[$key];
        }
        foreach ($tag as $key=>$value) {
            $tagData[] = $tag[$key];
        }

        $postCategory = new CategoryModel($categoryData,1);
        $postTag = new TagModel($tagData,1);
        $this->PF->regModel('postCategory',$postCategory);
        $this->PF->regModel('postTag',$postTag);
        $post = $this->PF->post->getParent();
        $post->setSync($postCategory->getStack(),$postTag->getStack());
    }
    private function Field2String($queryField) {
        $prefixedColumn = '';
        $offset = 0;
        $length = 0;
        $a = array();
        $fieldKeys = array_keys($queryField);
        foreach ($fieldKeys as $table) {
            $a[$table]['offset'] = $offset;
            $a[$table]['length'] = count($queryField[$table]);
            $offset += $a[$table]['length'];
            foreach ($queryField[$table] as $column) {
                if ($column !== '*') {
                    $column = '`'.$column.'`';
                }
                $prefixedColumn .= '`'.DB_PREFIX.$table.'`.'.$column.',';
            }
        }
        return array(substr($prefixedColumn, 0, -1),$a);
    }
    private function getTotalNum() {
        $result = $this->queryOne('SELECT FOUND_ROWS()');
        $this->PF->totalNum = $result[0];
        return $result[0];
    }

    public function getCategorys() {
        $query = 'SELECT * FROM term';
        $query .= ' WHERE term_type = \'postcategory\'';
        $result = $this->queryArray($query);
        $category = new CategoryModel($result,0);
        $this->PF->regModel('categoryWidget',$category);
    }
    public function getCommentsByPostId($postId) {
        $queryField = array(
            'comment' => array(
            'comment_id',
            'comment_content',
            'comment_date',
            ),
            'author' => array(
            'author_name',
            'author_website'
            )
        );
        $commentData = array();
        $authorData = array();
        $idData = array();
        list($prefixedColumn,$a) = $this->Field2String($queryField,true);
        $query = 'SELECT '.$prefixedColumn.' FROM comment';
        $query .= ' LEFT JOIN author ON author.author_id = comment.comment_author';
        $query .= ' WHERE comment.comment_postid = \''.$postId.'\'';
        $resource = $this->query($query);
        $this->getTotalNum();
        $temp = $this->fetchArray($resource);
        while ($temp) {
            $commentData[] = array_slice($temp, $a['comment']['offset'],$a['comment']['length']);
            $authorData[] = array_slice($temp, $a['author']['offset'],$a['author']['length']);
            $temp = $this->fetchArray($resource);
        }

        $comment = new CommentModel($commentData);
        $author = new AuthorModel($authorData);
        $this->PF->regModel('comment',$comment);
        $this->PF->regModel('commentAuthor',$author);
        $comment = $comment->getParent();
        $comment->setSync($author->getStack());
    }
    public function addComment($postId) {
        $author = $this->PF->commentAuthor;
        $comment = $this->PF->comment;
        $query = 'SELECT author.author_id FROM author,post';
        $query .= ' WHERE post.post_id = \''.$postId.'\' and post.post_publish = 1 and post.post_allowcomment = 1 and author.author_name = \''.$author->name().'\' and author.author_email = \''.$author->email().'\' and author.author_website = \''.$author->website().'\'';
        $result = $this->queryOne($query);
        if ($result == false) {
            $query = 'INSERT INTO author (author_name, author_email, author_website, author_account, author_pwd, author_grade)';
            $query .= ' VALUES (\''.$author->name().'\', \''.$author->email().'\', \''.$author->website().'\', NULL, NULL, 0)';
            if ($this->query($query)) {
                $authorId = $this->insertId();
            }else {
                return false;
            }
        }else {
            $authorId = $result['author_id'];
        }
        $query = 'INSERT INTO comment(comment_content,comment_author,comment_postid)';
        $query .= ' VALUES (\''.$comment->content().'\', \''.$authorId.'\', \''.$postId.'\')';
        if ($this->query($query)) {
            $query = 'UPDATE post SET `post_commentnum` = post_commentnum+1 WHERE post_id = \''.$postId.'\'';
            if ($this->query($query)) {
                return true;
            }
        }
        return false;
    }
}
?>
