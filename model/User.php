<?php
namespace model;
require_once("Database.php");

class User {

    private $db;
    public $name;
    public $hash;
    public $isRegistered;
    public $isLoggedIn;

    function __construct() {
        $db = new \Database();
        $this->db = $db->connection;
    }

    public function findOneByName($username) {
        $statement = $this->db->prepare("SELECT * FROM user WHERE name=:name");
        $statement->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function loadFromDatabase($username) {

    }

    public function register($password, $passwordRepeat) {

    }

}
