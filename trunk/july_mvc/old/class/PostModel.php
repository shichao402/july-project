<?php
class PostModel implements DataModeInterface {
    private $id;
    private $slug;
    private $title;
    private $date;
    private $intro;
    private $content;
    private $publish;
    private $allowComment;
    private $commentNum;
    private $dataModel;
    public function __construct($array = null,$extend = 0) {
        $this->dataModel = new DataModel($this,$extend);
        $this->dataModel->setData($array);
    }
    public function setData($array) {
        $this->id = $array['post_id'];
        $this->slug = $array['post_slug'];
        $this->title = $array['post_title'];
        $this->date = $array['post_date'];
        $this->intro = $array['post_intro'];
        $this->content = $array['post_content'];
        $this->publish = $array['post_publish'];
        $this->allowComment = $array['post_allowcomment'];
        $this->commentNum = $array['post_commentnum'];
    }
    public function id() {
        return $this->id;
    }
    public function title() {
        return $this->title;
    }
    public function slug() {
        return $this->slug;
    }
    public function date() {
        return $this->date;
    }
    public function intro() {
        return $this->intro;
    }
    public function content() {
        return $this->content;
    }
    public function allowComment() {
        return $this->allowComment;
    }
    public function publish() {
        return $this->publish;
    }
    public function commentNum() {
        return $this->commentNum;
    }
}
?>
