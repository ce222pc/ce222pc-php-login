<?php
namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	public function response() {
		$message = '';

		if ($this->getRequestUserName() === "") {
			$message = "Username is missing";
		} else if ($this->getRequestPassword() === "") {
            $message = "Password is missing";
        }

		$response = $this->generateLoginFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	private function generateLoginFormHTML($message) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		return isset($_POST[self::$name]) ? $_POST[self::$name] : false;
	}

    private function getRequestPassword() {
        return isset($_POST[self::$password]) ? $_POST[self::$password] : false;
    }

    private function getRequestKeep() {
        return isset($_POST[self::$keep]) ? $_POST[self::$password] : false;
    }

    private function getRequestLogin() {
        return isset($_POST[self::$login]) ? $_POST[self::$login] : false;
    }

    public function getLoginDetails() {
        $name = self::getRequestUserName();
        $password = self::getRequestPassword();
        $keep = self::getRequestKeep();
    }

}
