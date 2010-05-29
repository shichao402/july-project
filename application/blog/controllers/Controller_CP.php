<?php
class Controller_CP extends Controller {
    public function __construct() {

    }
    public function index() {

    }
    public function newTag() {
        if (isset($_GET['submit'])) {
            $tag = new Term('tag');
            try {
                $tag->add($_POST);
                $this->render(array(
                        'message' => 'sucess'
                ));
                $this->loadView('success');
            } catch (ModelException $e) {
                $this->render(array(
                        'message' => $e->getMessage()
                ));
                $this->loadView('failure');
            }
        } else {
            $this->loadView('/admin/newtag');
        }
        $this->view();
    }
    public function newCategory() {
        if (isset($_GET['submit'])) {
            $category = new Term('category');
            try {
                $category->add($_POST);
                $this->render(array(
                        'message' => 'sucess'
                ));
                $this->loadView('success');
            } catch (ModelException $e) {
                $this->render(array(
                        'message' => $e->getMessage()
                ));
                $this->loadView('failure');
            }
        } else {
            $this->loadView('/admin/newcategory');
        }
        $this->view();
    }
    public function newArticle() {
        if (isset($_GET['submit'])) {
            $article = new Article();
            try {
                $article->newArticle($_POST);
                $this->render(array(
                        'message' => 'sucess'
                ));
                $this->loadView('success');
            } catch (ModelException $e) {
                $this->render(array(
                        'message' => $e->getMessage()
                ));
                $this->loadView('failure');
            }
        } else {
            $this->loadView('/admin/newarticle');
        }
        $this->view();
    }
    public function deleteTag() {
        $tag = new Term('tag');
        try {
            $tag->delete($_POST['id']);
            $this->loadView('success');
        } catch (ModelException $e) {
            $this->render(array(
                    'message' => $e->getMessage()
            ));
            $this->loadView('failure');
        }
    }
    public function deleteCategory() {
        $category = new Term('category');
        try {
            $category->delete($_POST['id']);
            $this->loadView('success');
        } catch (ModelException $e) {
            $this->render(array(
                    'message' => $e->getMessage()
            ));
            $this->loadView('failure');
        }
    }
    public function deleteArticle() {
//        $article = new Article();
//        try {
//            $article->delete($_POST['id']);
//            $this->loadView('success');
//        } catch (ModelException $e) {
//            $this->render(array(
//                'message' => $e->getMessage()
//            ));
//            $this->loadView('failure');
//        }
    }
    public function updateTag() {
        
    }
    public function updateCategroy() {

    }
    public function updateArticle() {

    }
    public function tag() {

    }
    public function Category() {

    }
    public function Article() {

    }
}
?>
