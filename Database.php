<?php

class Database {
    public $connection;

    function __construct() {
        $this->connection = new PDO("sqlite:./database/database.sqlite3");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
