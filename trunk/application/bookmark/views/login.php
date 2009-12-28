<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>login</title>
    </head>
    <body>
        <form action="<?php echo $_SERVER['SCRIPT_FILE'].'?c=Controler_Authenticate&m=login';?>" method="POST">
            <input type="text" name="account" value="" size="200" />
            <input type="text" name="password" value="" size="200" />
            <input type="checkbox" name="remember" value="1"/>
            <input type="submit" value="login" />
        </form>
    </body>
</html>