<?php

namespace view;

require_once("DateTimeView.php");

class LayoutView {

    public function render($containerView) {

        $dtv = new \view\DateTimeView();

        echo '<!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Login Example</title>
                </head>
                <body>
                    <h1>Assignment 2</h1>
                    ' . $this->renderRegisterNewUser()
                    . $this->renderIsLoggedIn() . '

                    <div class="container">
                            ' . $containerView->response() . '

                            ' . $dtv->show() . '
                    </div>
                 </body>
            </html>
        ';
    }

    private function renderIsLoggedIn() {
        if ($this->isLoggedIn()) {
            return '<h2>Logged in</h2>';
        }
        else {
            return '<h2>Not logged in</h2>';
        }
    }

    private function renderRegisterNewUser() {
        if ($this->isLoggedIn()) {
            return '';
        }
        else {
            return '<a href="?register">Register a new user</a>';
        }
    }

    private function isLoggedIn() {
        return isset($_SESSION["user"]) && $_SESSION["user"]["isLoggedIn"];
    }
}
