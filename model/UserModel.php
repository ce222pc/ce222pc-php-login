<?php
namespace model;
require_once("db.php");

class User {

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
        $this->isLoggedIn = false;

        $user = $this->findOneByName();

        if ($user) {
            $this->isRegistered = true;
            $this->hash = $user["hash"];
        }
    }

    public function verifyPassword($candidate) {
        return password_verify($candidate, $this->hash);
    }

    public function login($keepLoggedIn=false) {
        $_SESSION["user"] = array(
            "name" => $this->name,
            "isRegistered"=> $this->isRegistered,
            "isLoggedIn"=> $this->isLoggedIn
        );
    }

    public function logout($keepLoggedIn) {
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
