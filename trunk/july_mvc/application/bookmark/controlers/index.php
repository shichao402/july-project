<?php
class index extends Controller {
    function index() {
        $bookmark = new BookMark();
        $this->data['bookmarkList'] = $bookmark->bookmarks();
        
        $this->loadView('index');
        $this->render();  //transfer data to template with $data
        $this->view();
    }
}

?>
