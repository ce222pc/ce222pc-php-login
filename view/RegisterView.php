<?php
namespace view;

class RegisterView {

    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private static $register = 'DoRegistration';

    public function response() {
        $messages = array();
        if ($this->getRequestUserName() || $this->getRequestUserName() === "") {
            $messages[] = "Username has too few characters, at least 3 characters.";
        }
        if ($this->getRequestPassword() || $this->getRequestPassword() === "") {
            $messages[] = "Password has too few characters, at least 6 characters.";
        }

        $message = join("<br/>", $messages);

        return $this->generateRegisterFormHTML($message);
    }

    private function generateRegisterFormHTML($message) {
        return '
            <form action="?register" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$messageId . '">' . $message . '</p>

                    <label for="' . self::$name . '">Username :</label>
                    <input type="text" size="20" id="' . self::$name . '" name="' . self::$name . '" value="" />
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

    private function getRequestUserName() {
        return isset($_POST[self::$name]) ? $_POST[self::$name] : false;
    }

    private function getRequestPassword() {
        return isset($_POST[self::$password]) ? $_POST[self::$password] : false;
    }

    private function getRequestPasswordRepeat() {
        return isset($_POST[self::$passwordRepeat]) ? $_POST[self::$passwordRepeat] : false;
    }

    private function getRequestRegister() {
        return isset($_POST[self::$register]) ? $_POST[self::$register] : false;
    }
}
