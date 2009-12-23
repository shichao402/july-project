<?php
class Controler_bookmark extends Controller {
    public function index() {
        $page = empty($_GET['p']) ? 1 : $_GET['p'];
        $cache = new Cache(APP_ROOT.'/cache');
        try {
            list($bookmarkList,$tagList) = $cache->get('bookmark_tag_list');
        } catch (Exception $e) {
            echo $e->getMessage();
            $bookmark = new BookMark();
            $bookmarkList = new Viewer(new DataProvider($bookmark->bookmarks($page,PAGE_LENGTH)));
            $bookmarkList->page = $page;
            $bookmarkList->totalPage = $bookmark->totalPage(PAGE_LENGTH);
            if ($bookmarkList->have()) {
                $tag = new Tag();
                $tagList = new Viewer(new DataProvider(new DataProvider($tag->tagsInId($bookmark->idArray())), $bookmarkList->id));
            }
            $cache->set('bookmark_tag_list',array($bookmarkList,$tagList),60);
        }

        if ($bookmarkList->have()) {
            $this->render(
                    array(
                    'bookmark' => $bookmarkList,
                    'tag' => $tagList,
                    )
            );
            $this->loadView('list');
            $this->loadView('add');
        }else {
            $this->loadView('list');
            $this->loadView('add');
        }
        $this->view();
    }
    public function post() {
        $input = $_POST;
        $bookmark = new BookMark();
        if ($bookmark->saveFromForm($input)) {
            $this->loadView('success');
        }else {
            $this->loadView('fail');
        }
        $this->view();
    }
    public function startSearch() {
        $filed = $_GET['f'];
        $keywords = $_GET['key'];
        $page = $_GET['p'];
        $page = empty($page) ? 1 : $page;
        $bookmark = new BookMark();
        $bookmark->search($filed, $keywords, $page);
        if ($bookmark->have()) {
            $tag = new Tag();
            $tag->follow($bookmark->id);
            $tag->tagsInId($bookmark->idArray());

            $this->render(
                    array(
                    'bookmark' => $bookmark,
                    'tag' => $tag
                    )
            );

            $this->loadView('list');
        }else {
            $this->loadView('empty');
        }
        $this->view();
    }
    public function search() {
        $this->loadView('search');
        $this->view();
    }
    public function add() {
        $this->loadView('add');
    }
    public function del() {
        $id = July::$router->param('id');
        $bookmark = new BookMark();
        if ($bookmark->delete($id)) {
            $this->loadView('success');
        }else {
            $this->loadView('fail');
        }
        $this->view();
    }
}
?>
