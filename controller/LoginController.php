<?php
namespace controller;

require_once('view/LoginView.php');

class LoginController {

    private $layoutView;
    private $loginView;

    public function __construct($flashMessageProvider) {
        $this->fmp = $flashMessageProvider;
        $this->layoutView = new \view\LayoutView();
        $this->registerView = new \view\LoginView();
    }
    public function shouldRoute() {
        return isset($_POST["LoginView::Login"])
            && $_POST["LoginView::Login"] === "login"
            && !$_SESSION["user"]["isLoggedIn"];
    }
    public function route() {
        if (isset($_GET["register"])) {
            $this->layoutView->render($this->fmp, $this->registerView);
        }
    }
}
