<?php
namespace view;

class RegisterView {

    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private static $register = 'DoRegistration';

    public function response($flashMessage) {

        if ($this->getRequestUserName() && $this->getRequestUserName() === "") {
            $flashMessage->addMessage("Username has too few characters, at least 3 characters.");
        }
        if ($this->getRequestPassword() && $this->getRequestPassword() === "") {
            $flashMessage->add("Password has too few characters, at least 6 characters.");
        }

        $message = $flashMessage->get();

        return $this->generateRegisterFormHTML($message);
    }

    private function generateRegisterFormHTML($message) {
        return '
            <form action="?register" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$messageId . '">' . $message . '</p>

                    <label for="' . self::$name . '">Username :</label>
                    <input type="text" size="20" id="' . self::$name . '" name="' . self::$name . '" value="' . self::getRequestUserName() . '" />
                    <br/>

                    <label for="' . self::$password . '">Password :</label>
                    <input type="password" size="20" id="' . self::$password . '" name="' . self::$password . '" />
                    <br/>

                    <label for="' . self::$passwordRepeat . '">Repeat password :</label>
                    <input type="password" size="20" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" />
                    <br/>

                    <input type="submit" name="' . self::$register . '" value="Register" />
                    <br/>
                </fieldset>
            </form>
        ';
    }

    public function getRequestUserName() {
        return isset($_POST[self::$name]) ? $_POST[self::$name] : false;
    }


    public function getRequestPassword() {
        return isset($_POST[self::$password]) ? $_POST[self::$password] : false;
    }

    public function getRequestPasswordRepeat() {
        return isset($_POST[self::$passwordRepeat]) ? $_POST[self::$passwordRepeat] : false;
    }

    public function getRequestRegister() {
        return isset($_POST[self::$register]) ? $_POST[self::$register] : false;
    }


    public function setRequestUserName($name) {
        $_POST[self::$name] = $name;
    }
}
