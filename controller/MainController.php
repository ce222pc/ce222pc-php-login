<?php

namespace controller;

class MainController {

    public function __construct() {
        $this->layoutView = new \view\LayoutView();
        $this->loginView = new \view\loginView();
        $this->registerView = new \view\RegisterView();
    }

    public function route() {
        if (isset($_GET["register"])) {
            $this->layoutView->render($this->registerView);
        } else {
            $this->layoutView->render($this->loginView);
        }
    }
}
