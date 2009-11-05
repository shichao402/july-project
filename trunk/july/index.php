<?php
include_once('include/config.php');
include_once('include/db.class.php');
include_once('include/class.php');
$t = new PF();
$db = new DBC($t);
$db->defineConfig();
$action = 'default';
if (!isset($_GET['page'])) {
    $page = 1;
}else {
    $page = $_GET['page'];
}
if (isset($_GET['id'])) {
    $action = 'id';
    $postId = (int) $_GET['id'];
}elseif (isset($_GET['category'])) {
    $action = 'listbycategory';
    $categoryId = (int) $_GET['category'];
}elseif (isset($_GET['tag'])) {
    $action = 'listbytag';
    $tagId = (int) $_GET['tag'];
}elseif (isset($_GET['addcomment'])) {
    $action = 'addcomment';
    $postId = (int) $_GET['addcomment'];
}
switch ($action) {
    case 'default':
        $db->getPosts($page);
        $db->getCategorys();
        include_once('template/header.php');
        include_once('template/list.php');
        break;
    case 'id':
        $db->getPostById($postId);
        $db->getCommentsByPostId($postId);
        $db->getCategorys();
        include_once('template/header.php');
        include_once('template/post.php');
        break;
    case 'listbycategory':
        $db->getPostsByCategoryId($categoryId,$page);
        $db->getCategorys();
        include_once('template/header.php');
        include_once('template/list.php');
        break;
    case 'listbytag':
        $db->getPostsByTagId($tagId,$page);
        $db->getCategorys();
        include_once('template/header.php');
        include_once('template/list.php');
        break;
}
include_once('template/widget.php');
include_once('template/footer.php');
?>