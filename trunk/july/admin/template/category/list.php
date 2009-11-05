<table>
<?php foreach ($dbconnect->result as $row){?>
<tr>
   <td><a href="article.php?action=edit&id=<?php echo $row["id"] ?>"><?php echo $row["title"] ?></a></td>
   <td><?php echo $row["date"] ?></td>
   <td><a href="article.php?action=delete&id=<?php echo $row["id"] ?>">删除</a></td>
   <td><a href="article.php?action=edit&id=<?php echo $row["id"] ?>">修改</a></td>
   <td><a href="comment.php?id=<?php echo $row["id"] ?>">评论</a></td>
</tr>
<?php }?>
</table>
<a href="article.php?action=add">添加</a>