<?php
namespace Guestbook\Model;

class EntryProvider implements \Iterator, \Zend\Loader\LocatorAware {

    protected $shortentries = NULL;

    protected $dbconnection;
    protected $locator;

    protected $stmt;

    protected $row;

    protected $pos=0;

    public function setShortentries($shortentries) {
        $this->shortentries = $shortentries;
    }
    public function setDbconnection($dbconnection) {
        $this->dbconnection = $dbconnection;
    }

    public function current() {
        return $this->row;
    }
    public function key() {
        $this->row['id'];
    }
    public function next() {
        $this->row = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_REL, 1);
        $this->pos++;
    }
    public function rewind() {
        $this->stmt = $this->dbconnection->query('SELECT gb_entry_id as id, text, date FROM entries');//TODO LIMIT, order by, etc
        $this->row = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_REL, 0);
        $this->pos = 0;
    }
    public function valid() {
        return (bool)$this->row && $this->pos < $this->shortentries;
    }
    public function getLocator() {
        return $this->locator;
    }
    public function setLocator(\Zend\Di\Locator $locator) {
        $this->locator = $locator;
    }
}
