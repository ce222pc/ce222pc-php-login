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
        return self::isLoginPOST();
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
                // var_dump($passwordIsCorrect);
                if ($passwordIsCorrect) {
                    $this->user->login($keepLoggedIn);
                } else {
                    $this->fmp->add("Wrong name or password");
                }
            }
            // echo '<pre>' . var_export($_SESSION, true) . '</pre>';
            $this->layoutView->render($this->fmp, $this->loginView);
        } else {
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }

    private static function isLoginPOST() {
        return isset($_POST["LoginView::Login"])
            && $_POST["LoginView::Login"] === "login";
    }
}
