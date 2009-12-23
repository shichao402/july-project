<?php
class DataProvider {
    private $provider;
    private $data;
    private $pointer;
    private $length;
    public function __construct($data,& $pointer = 0) {
        if ($data instanceof DataProvider) {
            $this->provider = $data;
            $this->data = $data->current();
        }
        else {
            $this->data = $data;
        }
        if ($pointer == 0) {
            $this->pointer = 0;
        }else {
            $this->relate($pointer);
        }
    }
    public function relate(& $relationKey) {
        $this->pointer = & $relationKey;
    }
    public function current() {
        if ($this->provider !== null) {
            $this->data = $this->provider->current();
        }
        return $this->data[$this->pointer];
    }
    public function each() {
        if ($this->pointer < $this->length()) {
            if ($this->provider !== null) {
                $this->data = $this->provider->current();
            }
            return $this->data[$this->pointer++];
        }
        else {
            return false;
        }
    }
    public function length() {
        if ($this->provider !== null) {
            $this->data = $this->provider->current();
        }
        $this->length = count($this->data);
        return $this->length;
    }
    public function have() {
        if ($this->pointer < $this->length()) {
            return true;
        }
        else {
            return false;
        }
    }
    public function next() {
        if ($this->pointer < $this->length()) {
            $this->pointer++;
            return true;
        }
        else {
            return false;
        }
    }
}
?>
