<?php
class Cache {
    private $dir;
    /**
     *  new cache object,set a dirctory to cache file.
     * @param dir_path_string $baseDir
     */
    public function __construct($baseDir) {
        if (!is_dir($baseDir)) {
            throw new FileSystemException("$dir is not an effect Dir\n");
        } else {
            $this->dir = realpath($baseDir);
        }
    }
    /**
     *  set $value to a cache file named $name,
     * if file not exists,try to create.
     * if exists,overwrite and touch it.
     * @param string $name
     * @param mixed $value
     * @param int $expire second,0 means never expired
     */
    public function set($name,$value,$expire = 0) {
        $file = $this->dir.'/'.$name.'.cache.php';
        $value = serialize($value);
        if (strlen((string) $expire) > 10) {
            throw new FileSystemException('exprire time is too big,leave it as default means never expired\n');
        } else {
            $expire = str_pad($expire, 10, '0', STR_PAD_LEFT);
        }
        $this->touch($file);
        $value = '<?php exit();?>'.$expire.$value;
        $length = file_put_contents($file,$value);
        if ($length <= 0) {
            throw new FileSystemException("nothing write to $file\n");
        }
    }
    /**
     *  get the cache data from cache named $name
     * @param sting $name the name of cache
     * @return mixed the cache data
     */
    public function get($name) {
        $file = $this->dir.'/'.$name.'.cache.php';
        if (($contents = @file_get_contents($file)) === false) {
            throw new FileSystemException("can not get cache data: $file\n");
        } else {
            $expire = (int) substr($contents, 15,10);
            if ($expire > 0) {
                if (time() > filemtime($file) + $expire) {
                    throw new FileSystemException("cache $name has expired\n");
                }
            }
            if (false === ($data = unserialize(substr($contents, 25)))) {
                throw new FileSystemException("unserialize failed\n");
            }else {
                return $data;
            }
        }
    }
    /**
     *  touch a file,modify the createtime modifytime and actiontime
     * @param string $name filepath
     * @param int $time timestamp
     */
    public function touch($name,$time = null) {
        if ($time === null) {
            if (!touch($name)) {
                throw new FileSystemException("touch $name failed\n");
            }
        }else {
            if (!touch($name,$time)) {
                throw new FileSystemException("touch $name at $time failed\n");
            }
        }
    }
}
?>
