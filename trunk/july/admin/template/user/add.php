<form action="user.php?action=add" method="post">
loginid<input name="loginid" type="text" />
password<input name="password" type="text" />
name<input name="name" type="text" />
email<input name="email" type="text" />
website<input name="website" type="text" />
regdate<input name="regdate" type="text" value="<?php echo $date ?>"/>
level<select name="level">
	<option value="admin">admin</option>
    <option value="user" selected="selected">user</option>
</select>
<input type="submit" value="submit" />
</form>
<a href="user.php">列表</a>