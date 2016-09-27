<?php
namespace controller;

require_once('view/RegisterView.php');

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
        if (isset($_GET["register"])) {
            $this->layoutView->render($this->fmp, $this->registerView);
        }
    }
}
