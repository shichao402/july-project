<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>newtag</title>
    </head>
    <body>
        <form action="<?php echo $_SERVER['SCRIPT_FILE'].'?c=Controller_CP&m=newtag&submit';?>" method="POST">
            <input type="text" name="name" value="" size="200" />
            <input type="text" name="slug" value="" size="200" />
            <textarea name="desc" rows="4" cols="20"></textarea>
            <input type="hidden" name="type" value="tag" size="200" />
            <input type="submit" value="提交" />
        </form>
    </body>
</html>