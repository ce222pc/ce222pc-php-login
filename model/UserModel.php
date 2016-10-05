<?php
namespace model;
require_once("db.php");

class UserModel {

    public $name;
    private $hash;
    public $isRegistered;
    public $isLoggedIn;

    private $db;

    function __construct($name) {

        // WTF?
        $db = new \Database();
        $this->db = $db->db;

        // Temp
        $this->name = $name;
        $this->hash = "";
        $this->isRegistered = false;
        $this->isLoggedIn = isset($_SESSION["user"]["isLoggedIn"]);

        $user = $this->findOneByName();

        if ($user) {
            $this->isRegistered = true;
            $this->hash = $user["hash"];
        }
        $this->saveToSession();
    }

    public function register($password) {
        $this->hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = $this->db->prepare("INSERT INTO user (name, hash) values (?, ?)");
        $statement->bindValue(1, $this->name);
        $statement->bindValue(2, $this->hash);
        $statement->execute();
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
        $this->isLoggedIn = true;
        $this->saveToSession();
    }

    public function saveToSession() {
        $_SESSION["user"] = array(
            "name" => $this->name,
            "isRegistered"=> $this->isRegistered,
            "isLoggedIn"=> $this->isLoggedIn
        );
    }

    public function logout() {
        unset($_SESSION["user"]);
        session_regenerate_id();
    }

    private function findOneByName() {
        $statement = $this->db->prepare("SELECT * FROM user WHERE name=:name");
        $statement->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
