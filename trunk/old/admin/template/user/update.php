<form action="user.php?action=edit" method="post">
<input name="id" type="hidden" value="<?php echo $id ?>" />
loginid<input name="loginid" type="text" value="<?php echo $loginid ?>" />
password<input name="password" type="text" value="<?php echo $password ?>" />
name<input name="name" type="text" value="<?php echo $name ?>" />
email<input name="email" type="text" value="<?php echo $email ?>" />
website<input name="website" type="text" value="<?php echo $website ?>" />
regdate<input name="regdate" type="text" value="<?php echo $regdate ?>" />
level<select name="level">
	<option value="admin" <?php if ($level == "admin") echo "selected=\"selected\""?> >admin</option>
    <option value="user" <?php if ($level == "admin") echo "selected=\"selected\""?> >user</option>
</select>
<input type="submit" value="submit" />
</form>
<a href="user.php">列表</a>