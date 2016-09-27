<?php
namespace model;

class FlashMessage {
    private $messages = array();

    public function add($message) {
        $this->messages[] = $message;
    }

    public function get() {
        $joinedMessages = join("<br>", $this->messages);
        $this->messages = array();
        return $joinedMessages;
    }

    public function render() {
        echo $this->getMessages();
    }
}
