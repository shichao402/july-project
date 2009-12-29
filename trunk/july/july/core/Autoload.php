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
                    throw new FileSystemException("{$path} is not an effect dir\n");
                }
            }
        }
    }
    /**
     *  magic method.registered in __construct.
     *  use classname to find classpath in pathindex use the key.
     * if not,this method will throw an exception
     * and try to find path again or thrown an exception.
     */
    private function load($className) {
        if (isset($this->pathIndex[$className])) {
            require($this->pathIndex[$className]);
        }else {
            eval("class $className {};");
            throw new ClassException("$className can not be found\n");
        }
    }
    /**
     * return an array,include class name and classfilepath
     * @return array
     */
    public function getPathIndex() {
        return $this->pathIndex;
    }

}
?>
