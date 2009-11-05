<?php
require_once("../include/db.class.php");
require_once("../include/template_admin.php");
if ($_GET["action"] == "add" ) {
	//$s = file("php://input");
	//var_dump($s);
	//var_dump($_POST["tag_id"]);
	//var_dump($_POST["category_id"]);
	$article_title = $_POST["article_title"];
	$article_date = $_POST["article_date"];
	$article_slug = $_POST["article_slug"];
	$article_content = $_POST["article_content"];
	$article_excerpt = $_POST["article_excerpt"];
	$article_status = $_POST["article_status"];
	
	$category_id = $_POST["category_id"];
	$tag_name = $_POST["tag_name"];
	$user_id = 0;
	
	//insert article
	$q = "INSERT INTO `articles`";
	$q .= "(`article_id`,`article_slug`,`article_title`,`article_content`,`article_excerpt`,`article_date`)";
	$q .= "VALUES";
	$q .= "(NULL,'$article_slug','$article_title','$article_content','$article_excerpt','$article_date');";
	$r = $db_connection->query($q,true);
	$a_id = $db_connection->getLastId();
	echo "插入文章信息：$r";
	echo "<br />";
	
	
	//insert category
	/*
	$q = "INSERT INTO categorys ";
	$q .= "('category_id','category_name','category_slug','category_desc')"
	$q .= "VALUES ";
	for () {
		$q .= "($category_id,$category_name,$category_slug,$category_desc),";
	}
	*/
	//insert category relation
	
	if ($category_id == NULL) {
		$q = "INSERT INTO categorys_relation ";
		$q .= "(`category_id`,`category_relation_id`)";
		$q .= "VALUES ";
		$q .= "('0','$a_id')";
		$r = $db_connection->query($q);
		echo "插入分类信息：$r";
		echo "<br />";
	}else {
		$q = "INSERT INTO categorys_relation ";
		$q .= "(`category_id`,`category_relation_id`)";
		$q .= "VALUES ";
		for ($i = sizeof($category_id);$i > 0;$i--) {
			if ($i == 1) {	 
				$c_id = $category_id[0];
				$q .= "('$c_id','$a_id')";
			}else {
				
				$c_id = $category_id[$i - 1];
				$q .= "('$c_id','$a_id'),";
			}
		}
		$r = $db_connection->query($q);
		echo "插入分类信息：$r";
		echo "<br />";
	}
	//insert tags
	$a = explode(",",$tag_name);
	for ($i = sizeof($a);$i > 0;$i--) {
		$tag_name = $a[$i - 1];
		$tag_slug = $tag_name;
		$tag_desc = $tag_name;
		$q = "INSERT INTO tags ";
		$q .= "(`tag_name`,`tag_slug`,`tag_desc`) ";
		$q .= "VALUES ";
		$q .= "('$tag_name','$tag_slug','$tag_desc');";
		$r = $db_connection->query($q);
		echo "插入tag信息：$r";
		echo "<br />";
		if ($r == true) {
			$last_tag_id = $db_connection->getLastId();
		}else{
			$q = "SELECT tag_id FROM tags WHERE tag_slug = '$tag_slug';";
			$db_connection->query($q);
			$db_connection->getNextRow();
			$last_tag_id = $db_connection->row_result["tag_id"];
		}
		$q = "INSERT INTO tags_relation ";
		$q .= "(`tag_id`,`tag_relation_id`)";
		$q .= "VALUES ";
		$q .= "('$last_tag_id','$a_id')";
		$r = $db_connection->query($q);
		echo "插入tag关联信息：$r";
		echo "<br />";
	}
}
include("template/article/add.php");
/*require_once("../include/db.class.php");
$action = isset($_GET["action"])?$_GET["action"]:NULL;
switch($action) {
	case "delete":
		$db = new db("localhost","root","root","phptest");
		$db->query("DELETE FROM article WHERE ID=".$_GET["id"]);
		include("template/redirect.php");
		break;
	case "add":
		if (isset($_POST['title'])) {
			$title = $_POST['title'];
			$date= $_POST['date'];
			$content = $_POST['content'];
			$db = new db("localhost","root","root","phptest");
			$db->query("insert into articles (article_title,article_date,article_content) values ('$title','$date','$content')");
			include("template/redirect.php");
		}else {
			$date = date("Y-m-d G:i:s");
			include("template/article/add.php");
		}
		break;
	case "edit":
		if (isset($_POST['id'])) {
			$id=$_POST['id'];
			$title=$_POST['title'];
			$content=$_POST['content'];
			$date=$_POST['date'];
			$dbconnect = new db("localhost","root","root","phptest");
			$row = $dbconnect->query("UPDATE article SET title='$title',content='$content',date='$date' WHERE id='$id'");
			include("template/redirect.php");
		} else {
			if (isset($_GET["id"])) {
				$dbconnect = new db("localhost","root","root","phptest");
				$row = $dbconnect->query("SELECT * FROM article WHERE id=".$_GET["id"]);
				$id = $row[0]['id'];
				$title = $row[0]['title'];
				$date = $row[0]['date'];
				$content = $row[0]['content'];
				include("template/article/update.php");
			}else {
				echo "没有此篇文章！";
			}
		}
		break;
	case "comment":
		if (isset($_POST['id'])) {
			$id=$_POST['id'];
			$title=$_POST['title'];
			$content=$_POST['content'];
			$date=$_POST['date'];
			$dbconnect = new db("localhost","root","root","phptest");
			$row = $dbconnect->query("UPDATE article SET title='$title',content='$content',date='$date' WHERE id='$id'");
			include("template/redirect.php");
		} else {
			if (isset($_GET["id"])) {
				$dbconnect = new db("localhost","root","root","phptest");
				$row = $dbconnect->query("SELECT * FROM article WHERE id=".$_GET["id"]);
				$id = $row[0]['id'];
				$title = $row[0]['title'];
				$date = $row[0]['date'];
				$content = $row[0]['content'];
				include("template/article/update.php");
			}else {
				echo "没有此篇文章！";
			}
		}
		break;
	default://show article list
		$dbconnect = new db("localhost","root","root","phptest");
		$dbconnect->query("SELECT id, title, date FROM article ORDER BY date DESC");
		include("template/article/list.php");
}*/
?>