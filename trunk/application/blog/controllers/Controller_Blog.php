<?php
class Controller_Blog extends Controller {
    public function index() {
        $page = $_GET['page'] < 1 ? 1 : $_GET['page'];
        $article = new Article();
        $tag =  new Term('article_tag');
        $category = new Term('article_category');
        $articleList = new Viewer(
                new DataProvider(
                $articleListResult = $article->articleList($page,PAGE_LENGTH)
                )
        );
        $totalNum = $article->totalNum();
        $totalPage = $article->totalPage($totalNum, PAGE_LENGTH);
        $idArray = $article->splitArray(array('id'),$articleListResult);

        $tagList = new Viewer(
                new DataProvider(
                new DataProvider(
                $tag->termsInId($idArray),
                $articleList->refer('id')
                )
                )
        );
        $categoryList = new Viewer(
                new DataProvider(
                new DataProvider(
                $category->termsInId($idArray),
                $articleList->refer('id')
                )
                )
        );
        $renderData = array(
                'article' => $articleList,
                'tag' => $tagList,
                'category' => $categoryList,
                'page' => $page,
                'totalPage' => $totalPage,
                'totalNum' => $totalNum,
        );

        $this->render($renderData);
        $this->loadView('articleList');
        $this->view();
    }
    public function article() {
        $comment_page = (int) $_POST['comment_page'];
        $comment_page = $comment_page < 1 ? 1 : $comment_page;
        $comment_pageLength = 10;
        $id = $_GET['id'];
        $_article = new Article();
        $article = new Viewer($_article->getArticleById($id));
        $_comment = new Comment();
        $comment = new Viewer(new DataProvider($_comment->getCommentsById($id, 1, $comment_pageLength)));
        $comment->totalNum = $_comment->totalNum();
        $comment->totalPage = $_comment->totalPage($comment->totalNum, $comment_pageLength);
        $this->render(array(
                'article' => $article,
                'comment' => $comment,
        ));
        $this->loadView('article');
        $this->view();
    }
    public function newComment() {
        if (isset($_GET['submit'])) {
            try {
                $comment = new Comment();
                $comment->newComment($_POST);
                $this->render(array(
                        'message' => "success"
                ));
                $this->loadView('success');
            } catch (ModelException $e) {
                $this->render(array(
                        'message' => $e->getMessage()
                ));
                $this->loadView('failure');
            }
        }else {
            
        }
        $this->view();
    }
}
?>
