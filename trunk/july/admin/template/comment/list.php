


<table cellpadding="5" cellspacing="0" border="1">
<?php foreach ($dbconnect->result as $row){?>
<tr>
	<td><?php echo $row["id"] ?></td>
    <td><?php echo $row["name"] ?></td>
    <td><?php echo $row["content"] ?></td>
    <td><?php echo $row["email"] ?></td>
    <td><?php echo $row["website"] ?></td>
    <td><?php echo $row["date"] ?></td>
    <td><?php echo $row["title"] ?></td>
   	<td><a href="comment.php?action=delete&id=<?php echo $row["id"] ?>">删除</a></td>
</tr>
<?php }?>
</table>
<a href="comment.php?action=add<?php echo "&id=".$targetid ?>">添加</a>
