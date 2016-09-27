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

    public function route() {
        if ($this->registerController->shouldRoute()) {
            // echo("REGISTER CONTROLLER");
            $this->registerController->route();
        } else if($this->loginController->shouldRoute()) {
            // echo("LOGIN CONTROLLER");
            $this->loginController->route();
        } else {
            // Render index page
            // echo("DEFAULT ROUTE (LOGIN CONTROLLER)");
            $this->layoutView->render($this->fmp, $this->loginView);
        }
    }
}
