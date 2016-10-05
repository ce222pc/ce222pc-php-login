<?php
namespace controller;

require_once('view/LoginView.php');
require_once('model/UserModel.php');

class LoginController {

    private $layoutView;
    private $loginView;

    public function __construct($flashMessageProvider) {
        $this->fmp = $flashMessageProvider;
        $this->layoutView = new \view\LayoutView();
        $this->loginView = new \view\LoginView();
    }
    public function shouldRoute() {
        return self::isLoginPOST() || self::isLogoutPOST();
    }
    public function route() {

        if ($this->loginView->getCookieUserName()) {
            $this->user = new \model\UserModel($this->loginView->getCookieUserName());
            $this->user->saveCookiePassword();
            $this->user->setCookies();
            if ($this->user->cookiePassword === $this->loginView->getCookiePassword() && !$this->user->isLoggedIn) {
                $this->user->login(true);
                $this->fmp->add("Welcome back with cookie");
                header('Location: ' . $_SERVER['PHP_SELF']);
                die;
            }
        }

        // On login POST
        if (self::isLoginPOST()) {
            $name = $this->loginView->getRequestUserName();
            $password = $this->loginView->getRequestPassword();
            $keepLoggedIn = $this->loginView->getRequestKeep();

            if ($name === "") {
    			$this->fmp->add("Username is missing");
    		} else if ($password === "") {
                $this->fmp->add("Password is missing");
            } else {
                $this->user = new \model\UserModel($name);
                $passwordIsCorrect = $this->user->verifyPassword($password);
                $userIsLoggedIn = $_SESSION["user"]["isLoggedIn"];
                if ($passwordIsCorrect) {
                    $this->user->login($keepLoggedIn);
                    if(!$userIsLoggedIn) {
                        $this->fmp->add("Welcome");
                    }
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    die;
                } else {
                    $this->fmp->add("Wrong name or password");
                }
            }
            $this->layoutView->render($this->fmp, $this->loginView);

        // On logout POST
        } else if (self::isLogoutPOST() && isset($_SESSION["user"])) {
            $this->user = new \model\UserModel($_SESSION["user"]["name"]);
            $this->user->logout();
            $this->fmp->add("Bye bye!");
            header('Location: '.$_SERVER['PHP_SELF']);
            die;
        } else {
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }

    private static function isLoginPOST() {
        return isset($_POST["LoginView::Login"]);
    }

    private static function isLogoutPOST() {
        return isset($_POST["LoginView::Logout"])
            && $_POST["LoginView::Logout"] === "logout";
    }
}
