<?php
//$conn=mysql_connect("192.168.0.3","xj","i*&^hj786hj;#d7(!6");//指定数据库连接参数
//function mysql_import($file,$database)//导入的函数，参数为SQL文件路径和导入的库名。
//{
//mysql_select_db($database);
//mysql_query("source '".$file."';");
//echo "导入".$file."文件到".$database."数据库完毕";
//}
//mysql_import("sql", "xjtest_1");
//mysql_close($conn);
echo system('/usr/local/mysql/bin/mysqldump -uxj -pi*&^hj786hj;#d7(!6 xjtest_1 alias > sql.sql',$a);
echo '!'.$a;
?>