<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <ul>
<?php
while ($bookmark->loadData()) {
?>
    <li>
        <span><a href="<?php echo $bookmark->url;?>"><?php echo $bookmark->name;?></a></span>
        <span><?php echo $bookmark->intro;?></span>
        <span><?php echo $bookmark->addDate;?></span>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'?m=del&id='.$bookmark->id;?>">delete</a></span>
    </li>
<?php
}
?>
    </ul>
    <div>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'index.php?p='.($bookmark->page-1); ?>"><<</a></span>
        <span><?php echo $bookmark->page.'/'.$bookmark->totalPage;?></span>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'index.php?p='.($bookmark->page+1); ?>">>></a></span>
    </div>
  </body>
</html>