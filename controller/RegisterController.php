<?php
namespace controller;

require_once('view/RegisterView.php');
require_once('model/UserModel.php');

class RegisterController {

    private $layoutView;
    private $registerView;

    public function __construct($flashMessageProvider) {
        $this->fmp = $flashMessageProvider;
        $this->layoutView = new \view\LayoutView();
        $this->registerView = new \view\RegisterView();
    }
    public function shouldRoute() {
        return isset($_GET["register"]);
    }
    public function route() {
        if (isset($_GET["register"]) && $_SERVER["REQUEST_METHOD"] === "GET") {
            $this->layoutView->render($this->fmp, $this->registerView);
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $register = $this->registerView->getRequestRegister();
            $name = $this->registerView->getRequestUserName();
            $password = $this->registerView->getRequestPassword();
            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            $valid = true;

            if(!\model\UserModel::validateNameCharacters($name)) {
                $valid = false;
                $this->fmp->add("Username contains invalid characters.");
                $this->registerView->setRequestUserName(strip_tags($this->registerView->getRequestUserName()));
            }
            if(!\model\UserModel::validateNameLength($name)) {
                $valid = false;
                $this->fmp->add("Username has too few characters, at least 3 characters.");
            }
            if(!\model\UserModel::validatePasswordLength($password)) {
                $valid = false;
                $this->fmp->add("Password has too few characters, at least 6 characters.");
            }
            if(!\model\UserModel::validatePasswordMatch($password, $passwordRepeat)) {
                $valid = false;
                $this->fmp->add("Passwords do not match.");
            }

            if($valid) {
                $this->user = new \model\UserModel($name);
                $this->user->register($password);
                $this->fmp->add("Registered new user.");
                header('Location: ' . $_SERVER['PHP_SELF']);
                die;
            } else {
                $this->layoutView->render($this->fmp, $this->registerView);
            }

        }
    }
}
