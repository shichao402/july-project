<?php
class Controler_bookmark extends Controller {
    public function index() {
        $page = empty($_GET['p']) ? 1 : $_GET['p'];
        $cache = new Cache(APP_ROOT.'/cache');
        try {
            list($bookmarkList,$tagList) = $cache->get('bookmark_tag_list_'.$page);
            list($bookmarkList->page,$bookmarkList->totalPage) = $cache->get('bookmark_tag_list');
        } catch (Exception $e) {
            echo $e->getMessage();

            $cache->touch('bookmark_tag_list');
            $cache->touch('bookmark_tag_list_'.$page);
            
            $bookmark = new BookMark();
            $bookmarkList = new Viewer(new DataProvider($bookmark->bookmarks($page,PAGE_LENGTH)));
            if ($bookmarkList->have()) {
                $bookmarkList->page = $page;
                $bookmarkList->totalPage = $bookmark->totalPage(PAGE_LENGTH);
                $cache->set('bookmark_tag_list',array($bookmarkList->page,$bookmarkList->totalPage),5);
                $tag = new Tag();
                $tagList = new Viewer(new DataProvider(new DataProvider($tag->tagsInId($bookmark->idArray())), $bookmarkList->id));
                $cache->set('bookmark_tag_list_'.$page,array($bookmarkList,$tagList),5);
            }
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
            $this->loadView('empty');
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
            $this->loadView('failure');
        }
        $this->view();
    }
    public function startSearch() {
        $filed = $_GET['f'];
        $keywords = $_GET['key'];
        $page = empty($_GET['p']) ? 1 : $_GET['p'];

        $cache = new Cache(APP_ROOT.'/cache/search');
        try {
            list($bookmarkList,$tagList) = $cache->get('search_'.$keywords.'_'.$page);
        } catch (Exception $e) {
            echo $e->getMessage();
            $bookmark = new BookMark();
            $bookmark->search($filed, $keywords, $page ,PAGE_LENGTH);
            $bookmarkList->page = $page;
            $bookmarkList->totalPage = $bookmark->totalPage(PAGE_LENGTH);
            if ($bookmark->have()) {
                $tag = new Tag();
                $tag->follow($bookmark->id);
                $tag->tagsInId($bookmark->idArray());
            }
        }
        if ($bookmark->have()) {
            $this->render(
                    array(
                    'bookmark' => $bookmarkList,
                    'tag' => $tagList
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
        $id = $_GET['id'];
        $bookmark = new BookMark();
        if ($bookmark->delete($id)) {
            $this->loadView('success');
        }else {
            $this->loadView('failure');
        }
        $this->view();
    }
}
?>
