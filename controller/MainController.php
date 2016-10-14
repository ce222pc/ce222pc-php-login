<?php

namespace controller;

class MainController {

    public function __construct($flashMessageProvider) {
        $this->fmp = $flashMessageProvider;

        $this->registerController = new \controller\RegisterController($this->fmp);
        $this->loginController = new \controller\LoginController($this->fmp);

        $this->layoutView = new \view\LayoutView();
        $this->loginView = new \view\loginView();
        $this->registerView = new \view\RegisterView();
    }

    public function temp() {
        if ($this->LoginView->isLoggingIn()) {
            $this->loginController->handleLogin();
        } else if ($this->loginView->isLoggingOut())  {
            $this->loginController->handleLogout();
        } else if ($this->registerView->isRegistering()) {
            $this->registerController->handleRegistration();
        } else {
            // Default?
        }
    }

    public function route() {
        if ($this->registerController->shouldRoute()) {
            $this->registerController->route();
        } else if($this->loginController->shouldRoute()) {
            $this->loginController->route();
        } else {
            $this->loginController->route();
        }
    }
}
