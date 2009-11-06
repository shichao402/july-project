<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//显示单篇日志
$id = $_GET['id'];
$post = new Post();
$postCategory = new Category();
if ($post->getPost($id)) {
//可以开始输出post属性
    $post->getName();
    while ($postCategory->getCategoryByPost($id)) {
        $postCategory->getName();
    }
}

//显示日志列表
$postList = new Post();
$relpost = new Post();
$postcategory = new Category();

while ($postList->getPosts()) {
    //显示日志属性
    $postList->getTitle();
    //显示日志所在分类
    while ($postCategory->getCategoryByPost($postList->getId())) {
        $postCategory->getName();
    }
    //根据tag显示相关日志
    while ($relpost->getPostsByTag(5, "tagId")) {
        $relpost->getTitle();
    }
}

//显示分类树
function showCategoryTree($id,$targetArray,$level) {
    foreach($targetArray as $v) {
        if ($v["category_parent_id"] == $id) {
            echo "<ul>";
            break;
        }
    }
    foreach($targetArray as $v) {
        if ($v["category_parent_id"] == $id) {
            echo "<li>";
            echo $v["category_id"];
            echo ":";
            echo $v["category_name"];
            echo "</li>";
            showCategoryTree($v["category_id"],$targetArray,$level + 1);
        }
    }
    foreach($targetArray as $v) {
        if ($v["category_parent_id"] == $id) {
            echo "</ul>";
            break;
        }
    }
}
$category = new Category();
showCategoryTree(0,$category->getCategorys(),0);

//添加日志
$post = new Post();
$post->setTitle($_POST['post_title']);
$post->setSlug($_POST['post_slug']);
$post->setIntro($_POST['post_intro']);
$post->setDate(date("Y-m-d H:i:s"));
$post->setContent($_POST['post_content']);
$post->setAuthor($_POST['author']);
$insertId = $post->savePost();
if ($insertId == false) {
    exit('插入日志错误');
}else {
    $post->savePostCategory($insertId, $_POST['categorys']);
    $tag = new Tag();
    $insertTagIdArray = $tag->saveTags($_POST['tags']);
    $post->savePostTag($insertId, $insertTagIdArray);
}

//修改日志
$post = new Post();
$post->setTitle($_POST['post_title']);
$post->setSlug($_POST['post_slug']);
$post->setIntro($_POST['post_intro']);
$post->setDate($_POST['post_date']);
$post->setContent($_POST['post_content']);
$post->setAuthor($_POST['author']);
$result = $post->updatePost();
if ($result == false) {
    exit('更新日志错误');
}else {
    $post->updatePostCategory($insertId, $_POST['categorys']);
    $post->updatePostCategory($insertId, $_POST['tags']);
}

//删除日志
$post = new Post();
$post->deletePost($_GET['id']);
?>
