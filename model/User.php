<?php
namespace model;
require_once("Database.php");

class User {

    private $db;
    public $name;
    public $hash;
    public $isRegistered;
    public $isLoggedIn;
    public $cookiePassword;

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

    public function generateCookiePassword() {
        return hash("sha256", rand());
    }

    public function saveCookiePassword() {

    }

    public static function validateNameCharacters($name) {
        return $name === htmlspecialchars($name);
    }

    public static function validateNameLength($name) {
        return strlen($name) >= 3;
    }

    public static function validatePasswordLength($name) {
        return strlen($name) >= 6;
    }

    public static function validatePasswordMatch($password, $passwordRepeat) {
        return $password === $passwordRepeat;
    }

    public function verifyPassword($candidate) {
        return password_verify($candidate, $this->hash);
    }

    public function login($keepLoggedIn=false) {

    }

    public function logout() {

    }

}
