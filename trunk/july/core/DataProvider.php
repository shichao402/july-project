<?php
class DataProvider {
    /**
     *  this provider 's data provider
     * @var object
     */
    private $provider;
    /**
     *  this provider 's data
     * @var array
     */
    private $data;
    /**
     *  this data 's pointer
     * @var int
     */
    private $pointer;
    /**
     *  this data 's length
     * @var int
     */
    private $length;
    /**
     *  create an object to provide data
     * @param mixed $data
     * @param int $pointer pointer reference
     */
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
    /**
     *  relate the pointer
     * @param mixed $relationKey
     */
    public function relate(& $relationKey) {
        $this->pointer = & $relationKey;
    }
    /**
     *  get the current data
     * @return mixed
     */
    public function current() {
        if ($this->provider !== null) {
            $this->data = $this->provider->current();
        }
        return $this->data[$this->pointer];
    }
    /**
     *  get current data,and the pointer will point to the next node
     * @return <type> 
     */
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
    /**
     *  get length of this provider 's data
     * @return int
     */
    public function length() {
        if ($this->provider !== null) {
            $this->data = $this->provider->current();
        }
        $this->length = count($this->data);
        return $this->length;
    }
    /**
     *  check this provider has any data to provide
     * @return boolean
     */
    public function have() {
        if ($this->pointer < $this->length()) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     *  make the pointer point to the next node
     * @return boolean
     */
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
