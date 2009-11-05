<?php
session_start();
include_once('include/config.php');
include_once('include/db.class.php');
include_once('include/class.php');
$t = new PF();
$db = new DBC($t);
$db->defineConfig();

$postId = htmlspecialchars(addslashes(trim($_GET['id'])));
$name = htmlspecialchars(addslashes(trim($_POST['name'])));
$email = htmlspecialchars(addslashes(trim($_POST['email'])));
$website = htmlspecialchars(addslashes(trim($_POST['website'])));
$content = htmlspecialchars(addslashes(trim($_POST['content'])));

$content = preg_replace ('/\n/','<br />',$content);

$validate = new Validate();
if ($validate->checkFormSubmit(15)) {
    $comment = new CommentModel();
    $author = new AuthorModel();
    $t->regModel('comment',$comment);
    $t->regModel('commentAuthor',$author);
    $author->setName($name);
    $author->setEmail($email);
    $author->setWebsite($website);
    $comment->setContent($content);
    if ($db->addComment($postId)) {
        $expire = time()+60*60*24*30;
        $path = '/';
        $domain = '';
        setcookie('name', $name, $expire, $path, $domain);
        setcookie('email', $email, $expire, $path, $domain);
        setcookie('website', $website, $expire, $path, $domain);
    }
    echo '<script>window.location = \''.BLOG_URL.'index.php?id='.$postId.'#comment\';</script>';
}else {
    echo '<script>alert(\'reply too fast....\');window.location = \''.BLOG_URL.'index.php?id='.$postId.'#comment\';</script>';
}
?>
