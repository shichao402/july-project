<?php
set_time_limit(0);
$i =0;
$r = array();
$total = 0;
    if (($handle = opendir('/var/log/xhprof')) !== false) {
        while (($file = readdir($handle)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $total++;
            $s = file_get_contents('/var/log/xhprof/'.$file);
            $test[] = unserialize($s);

            $i++;
            if ($i > 500) {
                $r = save($test,$r);
                $test = array();
                $i = 0;
            }
        }
        if ($i > 0) {
                $r = save($test,$r);
               
            }
        closedir($handle);
    }

function save($test,$r) {
    static $countArray;
    $num = count($test);
    for ($i =0;$i< $num;$i++) {
        foreach ($test[$i] as $key=> $each) {
            $r[$key]['ct'] += $each['ct'];
            $r[$key]['wt'] += $each['wt'];
            $r[$key]['count']++;
        }
    }
    return $r;
}

foreach ($r as $key => $value) {
    $ss[$key]['ct'] = $value['ct']/$total;
    $ss[$key]['wt'] = $value['wt']/$total;
    $ss[$key]['count'] = $value['count'];
}
echo "<pre>";
print_r($ss);
echo "</pre>";
echo $total;
?>