<table cellpadding="5" cellspacing="0" border="1">
<?php foreach ($dbconnect->result as $row){?>
<tr>
   <td><?php echo $row["id"] ?></td>
   <td><?php echo $row["loginid"] ?></td>
   <td><?php echo $row["password"] ?></td>
   <td><?php echo $row["name"] ?></td>
   <td><?php echo $row["email"] ?></td>
   <td><?php echo $row["website"] ?></td>
   <td><?php echo $row["level"] ?></td>
   <td><?php echo $row["regdate"] ?></td>
   <td><a href="user.php?action=delete&id=<?php echo $row["id"] ?>">删除</a></td>
   <td><a href="user.php?action=edit&id=<?php echo $row["id"] ?>">修改</a></td>
</tr>
<?php }?>
</table>
<a href="user.php?action=add">添加</a>