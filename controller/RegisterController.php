<?php
namespace controller;

require_once('view/RegisterView.php');

class MainController {
    public function route() {
        if (isset($_GET["register"])) {
            echo "<h1>fff</h1>";
        }
    }
}
