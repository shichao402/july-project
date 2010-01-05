<?php
class Controler_Blog extends Controller {
    public function index() {
        $page = $_GET['page'] < 1 ? 1 : $_GET['page'];
        $article = new Article();
        $tag =  new Tag();
        $category = new Tag();
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
                $tag->tagsInId($idArray),
                $articleList->refer('id')
                )
                )
        );
        $categoryList = new Viewer(
                new DataProvider(
                new DataProvider(
                $category->tagsInId($idArray,'category'),
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
    public function newComment() {
        if ($_POST['submit']) {
            try {
                $comment = new Comment();
                $comment->save($_POST);
            } catch (DBException $e) {
                echo $e->getTraceAsString();
                $this->loadView('failure');
                $this->view();
            }
        }else {
            $this->loadView('newcomment');
            $this->view();
        }
    }
}
?>
