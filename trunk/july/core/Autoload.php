<?php
class Autoload {
    private $folder = array();
    private $pathIndex = array();
    public function __construct() {
        spl_autoload_register(array($this,'load'));
    }
    public function setIndex($index) {
        if (empty($index)) {
            throw new Exception("indexArray is empty\n");
        } else {
            $this->pathIndex = $index;
        }
    }
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
