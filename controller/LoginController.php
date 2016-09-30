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
        if (self::isLoginPOST()) {
            // Handle post data

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
                if ($passwordIsCorrect) {
                    $this->user->login($keepLoggedIn);
                    $this->fmp->add("Welcome");
                    header('Location: '.$_SERVER['PHP_SELF']);
                    die;
                } else {
                    $this->fmp->add("Wrong name or password");
                }
            }
            // echo '<pre>' . var_export($_SESSION, true) . '</pre>';
            $this->layoutView->render($this->fmp, $this->loginView);
        } else if (self::isLogoutPOST()) {
            $this->user = new \model\UserModel($_SESSION["user"]["name"]);
            $this->user->logout();
            $this->fmp->add("Bye bye!");
            header('Location: '.$_SERVER['PHP_SELF']);
            die;
            // $this->layoutView->render($this->fmp, $this->loginView);
        } else {
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }

    private static function isLoginPOST() {
        return isset($_POST["LoginView::Login"])
            && $_POST["LoginView::Login"] === "login";
    }

    private static function isLogoutPOST() {
        return isset($_POST["LoginView::Logout"])
            && $_POST["LoginView::Logout"] === "logout";
    }
}
