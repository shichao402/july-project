<?php
//$link = mysql_connect('localhost', 'root', 'root');
//mysql_select_db('dream');
//$query = 'select postrelation.post_id,term.* from postrelation left join term on term.term_id = postrelation.term_id where postrelation.post_id in (40,41,42,43,44) order by post_id';
//$res = mysql_query($query);
//for ($j=0;$j<10;$j++) {
//        $r[] = mysql_fetch_array($res,MYSQL_ASSOC);
//    }
//    print_r($r);
//    echo var_dump($r[8]['term_parent'] === '');
//$query1 = 'SELECT post.*,GROUP_CONCAT(category.term_slug) as category_slug,GROUP_CONCAT(category.term_name) as category_name,GROUP_CONCAT(tag.term_slug) as tag_slug,GROUP_CONCAT(tag.term_name) as tag_name from post left join postrelation on post.post_id=postrelation.post_id left join term as category on category.term_id = postrelation.term_id and category.term_type = \'category\' left join term as tag on tag.term_id = postrelation.term_id and tag.term_type = \'tag\' where post.post_publish = 1 group by post.post_id order by post.post_date desc LIMIT 0,50';
//$query2 = 'select post.* from post where post.post_publish = true order by post.post_date desc limit 0,50';
//$query3 = 'select term.* form term,postrelation where term.term_id = postrelation.term_id and postrelation.post_id = 40';
//for ($i=0;$i<100;$i++) {
//    mysql_query($query2);
//    for ($j=0;$j<100;$j++) {
//        mysql_query($query3);
//    }
//}
define('PREFIX','wheel_');
$input = array(
    'post'=> array(
    'a' => "a",
    'b' => "b",
    'c' => "c",
    'd' => "d",
    'e' => "e"
    ),
    'category'=> array(
    'aa' => "aa",
    'bb' => "bb"
    )
);
$d3stack;
$prefixedColumn = '';
$offset = 0;
$length = 0;
$a = array();
foreach (array_keys($input) as $table) {
//    ${$table.'Offset'} = $offset;
//    ${$table.'Length'} = count($input[$table]);
//    $offset += ${$table.'Length'};
$a[$table]['offset'] = $offset;
$a[$table]['length'] = count($input[$table]);
$offset += $a[$table]['length'];
    foreach ($input[$table] as $column) {
        $prefixedColumn .= '`'.PREFIX.$table.'`.`'.$column.'`,';
    }
}
$prefixedColumn = substr($prefixedColumn, 0, -1);
//echo $prefixedColumn;
//echo $postOffset;
//echo $postLength;
//echo $categoryOffset;
//echo $categoryLength;
//var_dump($a);
$t = array_merge($input['post'],$input['category']);
//$columnNum = count($t);
//echo $columnNum;
$post[] = array(array_slice($t, $a['category']['offset'],$a['category']['length']));
$post[] = array(array_slice($t, $a['category']['offset'],$a['category']['length']));
var_dump($post);
$time_start = microtime_float();
for ($i=0;$i<1;$i++) {
    
}
$time_end = microtime_float();
$time = $time_end - $time_start;
echo "\n $time seconds\n";
echo floor(memory_get_usage()/1024),"Kb used\n";


class a {
    protected $a;
}
class b extends a{
    
}
var_dump(new b());
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
?>
