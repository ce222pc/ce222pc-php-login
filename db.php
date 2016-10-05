<?php

class Database {
    public $db;

    function __construct() {
        $this->db = new PDO("sqlite:./database/database.sqlite3");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
