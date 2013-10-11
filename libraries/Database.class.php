<?php

class Database {

    private $mysqli;
    private $connected = false;

    public function connect() {
        $this->mysqli = new mysqli("HOST", "USERNAME", "PASSWORD", "DBNAME");

        if (!$this->mysqli->connect_errno) {
            $this->connected = true;
        }
    }

    public function disconnect() {
        $this->mysqli = null;
        $this->connected = false;
    }

    public function query($query) {
        if ($this->connected) {
            return $this->mysqli->query($query);
        } else {
            return false;
        }
    }

    function escape($value) {
        return $this->mysqli->real_escape_string($value);
    }

}

?>
