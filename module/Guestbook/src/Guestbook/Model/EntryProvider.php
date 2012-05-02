<?php
namespace Guestbook\Model;

class EntryProvider implements \Iterator, \Zend\Loader\LocatorAware {

    protected $shortentries = NULL;

    protected $dbconnection;
    protected $locator;

    protected $stmt;

    protected $row;

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
    }
    public function rewind() {
        $locator = $this->getLocator();
        try {
            //TODO howto PDO::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ?
            $this->dbconnection = @$this->getLocator()->get('masterdb');
            $this->dbconnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //TODO do this in local.config.php instead
            $this->stmt = $this->dbconnection->prepare('SELECT gb_entry_id as id, text, date FROM `entries` ORDER BY date DESC LIMIT :limit');//TODO LIMIT, order by, etc
            $this->stmt->bindValue(':limit', $this->shortentries, \PDO::PARAM_INT);
            $this->stmt->execute();
            $this->row = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_REL, 0);
        }
        catch(\PDOException $e) {
            $this->row = array();
            var_dump($this->dbconnection->errorCode());
            echo $e;
            //TODO error logging
        }
        $this->pos = 0;
    }
    public function valid() {
        return (bool)$this->row;
    }
    public function getLocator() {
        return $this->locator;
    }
    public function setLocator(\Zend\Di\Locator $locator) {
        $this->locator = $locator;
    }
}
