<?php
class test {
    private $id = 0;
    public function a($name,$p) {
        extract($p);
        $sss=array(1=>1);
        include($name);
    }
}
$b = array(
'id' =>'qqq','b' =>'www','c' =>'eee'
);
$s = new test();
$s->a("temp.php",$b);
echo "\n";
$sl_diff = array(
                1=> 6,
                2=> 11,
                3=>	22,
                4=>	33,
                5=>	44,
                6=>	55,
                7=>	110,
                8=>	220,
                9=>	330,
                10=>440,
                11=>550,
                12=>1100,
                13=>2500,
                14=>3300,
                15=>4500,
                16=>5500,
                17=>11000,
                18=>22000,
                19=>33000
            );
            $level = 1;
            $diff = $sl_diff[$level];
            $upgrade_exp = 2*(20*$level+$diff)*(45+25*$level);
            
?>