<?php
class Controler_Blog extends Controler {
    public function index() {
        $page = $_GET['page'] < 1 ? 1 : $_GET['page'];
        try {
            $cache = new Cache(APP_ROOT.'/cache/article/');
            $renderData = $cache->get('article_tag_categroy_'.$page);
            $miscData = $cache->get('misc');
        } catch (FileSystemException $e) {
            echo $e->getMessage();
            $cache->touch('article_tag_categroy_'.$page);
            $article = new Article();
            $tag =  new Tag();
            $category = new Tag();
            $articleList = new Viewer(
                    new DataProvider(
                        $articleListResult = $article->articleList($page,PAGE_LENGTH)
                    )
            );
            $totalPage = $article->totalPage($article->totalNum(), PAGE_LENGTH);
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
                'commentNum' => $commentNum,
            );
            $miscData = array(
                'totalPage' => $totalPage,
            );
            $cache->set('article_tag_categroy_'.$page,$renderData);
        }
        $this->render($renderData);
        $this->render($miscData);
        $this->loadView('articleList');
        $this->view();
    }
}
?>
