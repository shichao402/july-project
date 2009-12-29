<?php
class Autoload {
    /**
     *  folder path,use to build index.
     * @var array
     */
    private $folder = array();
    /**
     *  path index,use to get class filepath
     * @var array
     */
    private $pathIndex = array();
    /**
     * create autoload
     */
    public function __construct() {
        spl_autoload_register(array($this,'load'));
    }
    /**
     *  set a array as autoload classfile path index
     * @param array $index
     */
    public function setIndex($index) {
        if (empty($index)) {
            throw new Exception("indexArray is empty\n");
        } else {
            $this->pathIndex = $index;
        }
    }
    /**
     * get all files' name and path in the folder set,store the name and path as array
     */
    public function buildIndex() {
        if (empty($this->folder)) {
            throw new Exception("you need add pathfolder at least one\n");
        } else {
            $this->pathIndex = array();
            foreach ($this->folder as $folder) {
                if (false !== ($handle = opendir($folder))) {
                    while (false !== ($fileName = readdir($handle))) {
                        if ($fileName == "." || $fileName == "..") {
                            continue;
                        } else {
                            list($className,$ext) = explode('.', $fileName);
                            $this->pathIndex[$className] = $folder.'/'.$fileName;
                        }
                    }
                    closedir($handle);
                }
            }
        }
    }
    /**
     *  add a path want to build index
     * @param path string $pathArray
     */
    public function addPath($pathArray) {
        if (empty($pathArray)) {
            throw new Exception("pathArray is empty\n");
        } elseif (!is_array($pathArray)) {
            throw new Exception("pathArray is not Array\n");
        } else {
            foreach ($pathArray as $path) {
                if (is_dir($path)) {
                    $this->folder[] = realpath($path);
                } else {
                    throw new Exception("{$path} is not an effect dir\n");
                }
            }
        }
    }
    /**
     *  magic method.registered in __construct.
     *  use classname to find classpath in pathindex use the key.\n
     * if not,this method will rebuild the pathindex use the folder set in config file,\n
     * and try to find path again or thrown an exception.
     */
    private function load($className) {
        if (isset($this->pathIndex[$className])) {
            require($this->pathIndex[$className]);
        }else {
            $cache = July::instance('cache');
            require APP_ROOT.'/config/autoload.php';
            $this->addPath($folder);
            try {
                $this->buildIndex();
                $cache->set('autoload_index',$this->pathIndex);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            if (isset($this->pathIndex[$className])) {
                require($this->pathIndex[$className]);
            }else {
                eval("class $className {};");
                throw new Exception("$className can not be found\n");
            }
        }
    }
}
?>
