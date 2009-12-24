<?php
class Cache {
    private $dir;
    public function __construct($baseDir) {
        if (!is_dir($baseDir)) {
            throw new Exception("$dir is not an effect Dir\n");
        } else {
            $this->dir = realpath($baseDir);
        }
    }
    public function set($name,$value,$expire = 0) {
        $file = $this->dir.'/'.$name.'.cache.php';
        $value = serialize($value);
        if (strlen((string) $expire) > 10) {
            throw new Exception('exprire time is too big,leave it as default means never expired\n');
        } else {
            $expire = str_pad($expire, 10, '0', STR_PAD_LEFT);
        }
        $this->touch($file);
        $value = '<?php exit();?>'.$expire.$value;
        $length = file_put_contents($file,$value);
        if ($length <= 0) {
            throw new Exception("nothing write to $file\n");
        }
    }
    public function get($name) {
        $file = $this->dir.'/'.$name.'.cache.php';
        if (($contents = @file_get_contents($file)) === false) {
            throw new Exception("can not get cache data: $file\n");
        } else {
            $expire = (int) substr($contents, 15,10);
            if ($expire > 0) {
                if (time() > filemtime($file) + $expire) {
                    throw new Exception("cache $name has expired\n");
                }
            }
            if (false === ($data = unserialize(substr($contents, 25)))) {
                throw new Exception("unserialize failed\n");
            }else {
                return $data;
            }
        }
    }
    public function touch($name,$time = null) {
        if ($time === null) {
            if (!touch($name)) {
                throw new Exception("touch $name failed\n");
            }
        }else {
            if (!touch($name,$time)) {
                throw new Exception("touch $name at $time failed\n");
            }
        }
    }
}
?>
