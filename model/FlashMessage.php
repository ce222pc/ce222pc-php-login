<?php
namespace model;

class FlashMessage {
    public function __construct() {
        $this->session();
    }

    public function add($message) {
        $_SESSION["flash"][] = $message;
    }

    public function get() {
        $joinedMessages = join("<br>", $_SESSION["flash"]);
        $_SESSION["flash"] = array();
        return $joinedMessages;
    }

    private function session() {
        if (!isset($_SESSION["flash"])) {
            $_SESSION["flash"] = array();
        }
    }
}
