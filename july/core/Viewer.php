<?php
class Viewer {
    private $data;
    private $dataProvider;
    /**
     * create new viewer
     * @param <type> $dataProvider provide data to viewer
     */
    public function __construct($dataProvider) {
        if ($dataProvider instanceof DataProvider) {
            $this->dataProvider = $dataProvider;
        } else {
            $this->dataProvider = null;
            $this->data = $dataProvider;
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
        if ($this->dataProvider === null) {
            $current = $this->data;
        }else {
            $current = $this->dataProvider->each();
        }
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
        if ($this->dataProvider === null) {
            return 1;
        }else {
            return $this->dataProvider->length();
        }
    }
    /**
     * check provider has any data to provide
     * @return boolean
     */
    public function have() {
        if ($this->dataProvider === null) {
            return empty($this->data);
        }else {
            return $this->dataProvider->have();
        }
    }
    /**
     *  next one
     * @return boolean
     */
    public function next() {
        if ($this->dataProvider === null) {
            return false;
        }else {
            return $this->dataProvider->have();
        }
    }
}

?>
