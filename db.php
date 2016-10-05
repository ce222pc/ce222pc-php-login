<?php

class Database {
    public $db;

    function __construct() {
        $this->db = new PDO("sqlite:./database/database.sqlite3");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(!$this->databaseExists()) {
            $this->$db->exec("CREATE TABLE user (
                id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255) UNIQUE NOT NULL,
                hash VARCHAR(255) NOT NULL,
                cookie_password VARCHAR(255)
            )"
        );

            $user = array(":name" => "Admin", ":hash" => password_hash("Password", PASSWORD_DEFAULT));
            $insertUser = $db->prepare("INSERT INTO user(name, hash) values(:name, :hash)");
            $insertUser->execute($user);
        }
    }

    private function databaseExists() {
        try {
            return $this->db->query("SELECT 1 FROM user");
        } catch(Exception $e) {

        }
    }
}
