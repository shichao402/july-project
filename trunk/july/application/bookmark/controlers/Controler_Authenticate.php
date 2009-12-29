<?php
class Controler_Authenticate extends Controller {
    public function  __construct() {
        $this->authenticate = new User();
    }
    public function loginPage() {
        $this->loadView('login');
        $this->view();
    }
    public function login() {
        try {
            $this->authenticate->login($_POST['account'], $_POST['password']);
            if($_POST['remember'] == 1) {
                $this->authenticate->remember(604800, APP_PATH);
            } else {
                $this->authenticate->remember(0, APP_PATH);
            }
            if (empty($_GET['referrer'])) {
                $this->redirect('Controler_Bookmark', 'index');
            }else {
                header("location: ".$_GET['referrer']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function authenticate() {
        try {
            if (!$this->authenticate->authenticate($_COOKIE['token'])) {
                $this->redirect('Controler_Authenticate','loginPage','http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
