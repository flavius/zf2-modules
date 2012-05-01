<?php
namespace Guestbook\Model;

class EntryProvider implements \Iterator {

    protected $shortentries = NULL;
    protected $data;

    private $pos = 0;

    public function __construct($shortentries=NULL) {
        $this->shortentries = $shortentries;

        $this->data = array('foo', 'bar', 'a', 'b', 'c');
    }

    public function setShortentries($shortentries) {
        $this->shortentries = $shortentries;
    }

    public function current() {
        return $this->data[$this->pos];
    }
    public function key() {
        return $this->pos;
    }
    public function next() {
        $this->pos++;
    }
    public function rewind() {
        //TODO here fetch data from DB
        $this->pos = 0;
    }
    public function valid() {
        if($this->shortentries) {
            return isset($this->data[$this->pos]) && $this->pos < $this->shortentries;
        }
        return isset($this->data[$this->pos]);
    }
}
