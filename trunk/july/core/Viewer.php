<?php
class Viewer {
    private $dataProvider;
    public function __construct($dataProvider) {
        if ($dataProvider instanceof DataProvider) {
            $this->dataProvider = $dataProvider;
        }
        else {
            throw new Exception("object is not a effective DataProvider\n");
        }
    }
    public function & refer($name) {
        $this->{$name} = null;
        return $this->{$name};
    }
    public function loadData() {
        $current = $this->dataProvider->each();
        if ($current !== false) {
            $this->fillData($current);
            return true;
        }
        else {
            return false;
        }
    }
    private function fillData($data) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
    private function __get($name) {
        $this->$name = 999;
    }
    private function  __call($name,  $arguments) {
        throw new Exception("viewer $name is not ready\n");
    }
    public function length() {
        return $this->dataProvider->length();
    }
    public function have() {
        return $this->dataProvider->have();
    }
    public function next() {
        return $this->dataProvider->next();
    }
}

?>
