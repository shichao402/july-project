<?php
function getActionUrl($action_name,$action_value) {
	echo "http://localhost/".$_SERVER['PHP_SELF']."?".$action_name."=".$action_value;
}
function getNowDate() {
	echo $date = date("Y-m-d G:i:s");
}

function widget_getCategoryList() {
	global $db_connection;
	$limit = 10;
	$db_connection->query("SELECT category_id,category_name,category_slug FROM categorys");
	if ($db_connection->row_num == 0) {
		echo "nothing!";
	} else {
		while ($db_connection->hasRow()) {
			echo $db_connection->hasRow();
			$db_connection->getRow();
			echo $db_connection->row_result["category_id"];
			echo "<br />";
			echo $db_connection->row_result["category_name"];
			echo "<br />";
			echo $db_connection->row_result["category_slug"];
			echo "<br />";
		}
	}
}
//Article

function hasArticle() {
	$db_connection->query("SELECT article_id,article_title FROM articles");
	global $db_connection;
	return $db_connection->hasRow();
}
//Categorys
function hasCategorys() {
	global $db_connection;
	if (!isset($db_connection->query_result_array["getCategorys"])) {
		$db_connection->query("getCategorys","SELECT category_id,category_name FROM categorys");
	}
	return $db_connection->getRow("getCategorys");
}
function getCategoryId() {
	global $db_connection;
	echo $db_connection->result["category_id"];
	return $db_connection->result["category_id"];
}
function getCategoryName() {
	global $db_connection;
	echo $db_connection->result["category_name"];
	return $db_connection->result["category_name"];
}
//tags
function getTags() {
	global $db_connection;
	if (!isset($db_connection->query_result_array["getTags"])) {
		$db_connection->query("getTags","SELECT tag_id,tag_name FROM tags");
	}
	return $db_connection->getRow("getTags");
}
function getTagsById() {
	global $db_connection;
	if (!isset($db_connection->query_result_array["getTagsById"])) {
		$db_connection->query("getTagsById","SELECT tag_id,tag_name FROM tags where category_id=".$db_connection->result["category_id"]);
	}
	return $db_connection->getRow("getTagsById");
}
function getTagId() {
	global $db_connection;
	echo $db_connection->result["tag_id"];
	return $db_connection->result["tag_id"];
}
function getTagName() {
	global $db_connection;
	echo $db_connection->result["tag_name"];
	return $db_connection->result["tag_name"];
}
?>