<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <ul>
<?php
for ($i=0;$i<$bookmarkList['num'];$i++) {
?>
    <li>
        <span><a href="<?php echo $bookmarkList[$i]['url'];?>"><?php echo $bookmarkList[$i]['name'];?></a></span>
        <span><?php echo $bookmarkList[$i]['intro'];?></span>
        <span><?php echo $bookmarkList[$i]['addDate'];?></span>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'?m=del&id='.$bookmarkList[$i]['id'];?>">delete</a></span>
    </li>
<?php
}
?>
    </ul>
    <div>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'index.php?p='.($currentPage-1); ?>"><<</a></span>
        <span><?php echo $currentPage.'/'.$bookmarkList['totalPage'];?></span>
        <span><a href="<?php echo $_SERVER['SCRIPT_FILE'].'index.php?p='.($currentPage+1); ?>">>></a></span>
    </div>
  </body>
</html>