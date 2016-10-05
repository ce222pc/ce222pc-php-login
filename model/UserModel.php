<?php
namespace model;
require_once("db.php");

class UserModel {

    public $name;
    private $hash;
    public $isRegistered;
    public $isLoggedIn;

    private static $cookieTimeLimit = 2592000; // 30 days
    private static $cookieNameString = "LoginView::CookieName";
    private static $cookiePasswordString = "LoginView::CookiePassword";

    private $db;

    function __construct($name) {

        // WTF?
        $db = new \Database();
        $this->db = $db->db;

        // Temp
        $this->name = $name;
        $this->hash = "";
        $this->isRegistered = false;
        $this->cookiePassword = null;
        $this->isLoggedIn = isset($_SESSION["user"]["isLoggedIn"]) ? $_SESSION["user"]["isLoggedIn"] : false;

        $user = $this->findOneByName();

        if ($user) {
            $this->isRegistered = true;
            $this->hash = $user["hash"];
            $this->cookiePassword = $user["cookie_password"];
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

    public function generateCookiePassword() {
        return hash("sha256", time());
    }

    public function saveCookiePassword() {
        $cookiePassword = $this->generateCookiePassword();
        $statement = $this->db->prepare("UPDATE user SET cookie_password = :cookiePassword WHERE name = :name");
        $statement->bindParam(":cookiePassword", $cookiePassword);
        $statement->bindParam(":name", $this->name);
        $statement->execute();

        $this->cookiePassword = $cookiePassword;
    }

    public function setCookies() {
        $this->setNameCookie();
        $this->setPasswordCookie();
    }

    public function setNameCookie() {
        setcookie(self::$cookieNameString, $this->name, time() + self::$cookieTimeLimit);
    }

    public function setPasswordCookie() {
        setcookie(self::$cookiePasswordString, $this->cookiePassword, time() + self::$cookieTimeLimit);
    }

    public function deleteCookies() {
        $this->deleteNameCookie();
        $this->deletePasswordCookie();
    }

    public function deleteNameCookie() {
        setcookie(self::$cookieNameString, "", time() - 3600);
    }

    public function deletePasswordCookie() {
        setcookie(self::$cookiePasswordString, "", time() - 3600);
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
        $_SESSION["browser"] = $_SERVER['HTTP_USER_AGENT'];
        if ($keepLoggedIn) {
            $this->saveCookiePassword();
            $this->setCookies();
        }

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
        $this->deleteCookies();
        session_regenerate_id();
    }

    private function findOneByName() {
        $statement = $this->db->prepare("SELECT * FROM user WHERE name=:name");
        $statement->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
