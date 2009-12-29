
<?php
class test2 {
    public $e = '!!!!!!!!!!!!!';
}
class test {
    public function t() {
        $this->xiashu = new test2();
        $this->xiashu->parent = $this;
    }
}
$ss = new test();
$ss->t();
$ss->testststststst = 'fdsafsdf';
var_dump($ss->xiashu);
?>
