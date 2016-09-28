<?php
namespace controller;

require_once('view/LoginView.php');

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
            $this->layoutView->render($this->fmp, $this->loginView);
        } else {
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }

    private static function isLoginPOST() {
        return isset($_POST["LoginView::Login"])
            && $_POST["LoginView::Login"] === "login"
            && (isset($_SESSION["user"]) && !$_SESSION["user"]["isLoggedIn"]);
    }
}
