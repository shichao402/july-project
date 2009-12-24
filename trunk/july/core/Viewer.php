<?php
class Viewer {
    private $dataProvider;
    /**
     * create new viewer
     * @param <type> $dataProvider provide data to viewer
     */
    public function __construct($dataProvider) {
        if ($dataProvider instanceof DataProvider) {
            $this->dataProvider = $dataProvider;
        } else {
            throw new Exception("object is not a effective DataProvider\n");
        }
    }
    /**
     *  get property's reference.if property is not exists,create as null.
     * @param string $name the name wants to refer
     * @return reference
     */
    public function & refer($name) {
        $this->{$name} = null;
        return $this->{$name};
    }
    /**
     *  load data from dataprovider,make them to property
     * @return boolean
     */
    public function loadData() {
        $current = $this->dataProvider->each();
        if ($current !== false) {
            $this->fillData($current);
            return true;
        } else {
            return false;
        }
    }
    /**
     *  make data to object's property
     * @param array $data
     */
    private function fillData($data) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
    private function __get($name) {
        throw new Exception("$name was not defined\n");
    }
    private function  __call($name,  $arguments) {
        throw new Exception("viewer $name is not ready\n");
    }
    /**
     *  get length of this viewer's provider
     * @return int
     */
    public function length() {
        return $this->dataProvider->length();
    }
    /**
     * check provider has any data to provide
     * @return boolean
     */
    public function have() {
        return $this->dataProvider->have();
    }
    /**
     *  next one
     * @return boolean
     */
    public function next() {
        return $this->dataProvider->next();
    }
}

?>
