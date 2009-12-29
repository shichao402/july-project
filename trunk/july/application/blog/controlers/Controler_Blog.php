<?php
class Controler_Blog extends Controler {
    public function index() {
        $page = $_GET['page'] < 1 ? 1 : $_GET['page'];
        try {
            $cache = new Cache(APP_ROOT.'/cache/article/');
            $renderData = $cache->get('article_tag_categroy_'.$page);
        } catch (FileSystemException $e) {
            echo $e->getMessage();
            $cache->touch('article_tag_categroy_'.$page);
            $article = new Article();
            $tag =  new Tag();
            $category = new Tag();
            $articleList = new Viewer(
                    new DataProvider(
                        $article->articleList($page,PAGE_LENGTH)
                    )
            );
            $idArray = $article->idArray();
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
                'category' => $categoryList
            );
            $cache->set('article_tag_categroy_'.$page,$renderData);
        }
        $this->render($renderData);
        if ($articleList->have()) {
            $this->loadView('articleList');
        } else {
            $this->loadView('nothing');
        }
        $this->view();
    }
}
?>
