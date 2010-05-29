<script type="text/javascript">
    function compare(node) {
        if (node.getAttribute('oldvalue') != node.value) {
            node.style.backgroundColor = 'FF0000';
        } else {
            node.style.backgroundColor = '';
        }
    }
    function light(node) {
        if (node.checked == true) {
            node.parentNode.parentNode.style.backgroundColor = 'ff0000';
        } else {
            node.parentNode.parentNode.style.backgroundColor = '';
        }
    }
</script>
<?php
$data = unserialize(file_get_contents('./data'));
$current = current($data);
$sortkey = isset($current[$_GET['sort']]) ? $_GET['sort'] : '';
//build index
if ($sortkey != '') {
    foreach ($data as $key => $value) {
        $index[bin2hex($value[$sortkey])] = $key;
    }
    ksort($index,SORT_STRING);
    foreach ($index as $sortkey => $key) {
        $newdata[$key] = $data[$key];
    }
    $data = $newdata;
}
?>
<form action="post.php" method="POST">
<table border="1">
    <thead>
        <tr>
            <?php
            echo "<th>id</th>";
            echo "<th>name</th>";
            echo "<th>upload</th>";
            foreach (current($data) as $key => $each) {
                echo "<th>{$key}</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 0;
        foreach ($data as $key => $row) {
            echo "<tr>";
            $count++;
            echo "<td>{$count}</td>";
            echo "<td>$key<input type=\"hidden\" value=\"$key\"/></td>";
            echo "<td><input name = \"{$key}-upload\" type=\"checkbox\" onClick=\"light(this)\" /></td>";
            $str = '';
            foreach ($row as $key2 => $d) {
                if ($key2 == 'upload') {
                    continue;
                }
                $str .= "<td><input oldvalue=\"{$d}\" onChange=\"compare(this)\" name=\"{$key}-{$key2}\" type=\"text\" value=\"{$d}\" /></td>";
            }
            echo $str;
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
    <input type="submit" />
</form>
