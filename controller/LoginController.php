<?php
namespace controller;

require_once('view/LoginView.php');
require_once('model/UserModel.php');

require_once("exceptions/UsernameEmptyException.php");
require_once("exceptions/PasswordEmptyException.php");

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
        $this->handleCookieLogin();

        // On login POST
        if (self::isLoginPOST()) {
            $this->doLoginPOST();

        // On logout POST
        } else if (self::isLogoutPOST() && isset($_SESSION["user"])) {
            $this->doLogoutPOST();
        } else {
            $this->preventSessionHijack();
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }

    private function handleCookieLogin() {
        if ($this->loginView->getCookieUserName()) {
            $this->user = new \model\UserModel($this->loginView->getCookieUserName());
            if ($this->user->cookiePassword === $this->loginView->getCookiePassword()) {
                if (!$this->user->isLoggedIn) {
                    $this->user->login(true);
                    $this->fmp->add("Welcome back with cookie");
                    $this->redirectAndDie();
                }
            } else {
                $this->fmp->add("Wrong information in cookies");
                $this->user->logout();
                $this->redirectAndDie();
            }
        }
    }

    private function preventSessionHijack() {
        if (isset($_SESSION["browser"]) && isset($_SESSION["user"]) && $_SESSION["user"]["isLoggedIn"]) {
            $this->user = new \model\UserModel($_SESSION["user"]["name"]);
            if ($_SESSION["browser"] !== $_SERVER['HTTP_USER_AGENT']) {
                $this->user->logout();
            }
        }
    }

    private static function isLoginPOST() {
        return isset($_POST["LoginView::Login"]);
    }

    private static function isLogoutPOST() {
        return isset($_POST["LoginView::Logout"]) && $_POST["LoginView::Logout"] === "logout";
    }

    private function doLoginPOST() {
        try {
            $name = $this->loginView->getRequestUserName();
            $password = $this->loginView->getRequestPassword();
            $keepLoggedIn = $this->loginView->getRequestKeep();

            $this->user = new \model\UserModel($name);
            $passwordIsCorrect = $this->user->verifyPassword($password);
            $userIsLoggedIn = $_SESSION["user"]["isLoggedIn"];
            if ($passwordIsCorrect) {
                $this->user->login($keepLoggedIn);
                if(!$userIsLoggedIn) {
                    $this->fmp->add("Welcome");
                }
                $this->redirectAndDie();
            } else {
                $this->fmp->add("Wrong name or password");
            }
        } catch (\UsernameEmptyException $e) {
            $this->fmp->add("Username is missing");
        } catch (\PasswordEmptyException $e) {
            $this->fmp->add("Password is missing");
        } finally {
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }

    private function redirectAndDie() {
        header('Location: ' . $_SERVER['PHP_SELF']);
        die;
    }

    private function doLogoutPOST() {
        $this->user = new \model\UserModel($_SESSION["user"]["name"]);
        $this->user->logout();
        $this->fmp->add("Bye bye!");
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }
}
