<?php

require_once('model/FlashMessage.php');
require_once('model/UserModel.php');

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');

require_once("controller/MainController.php");
require_once("controller/RegisterController.php");
require_once("controller/LoginController.php");

require_once("exceptions/PasswordEmptyException.php");
require_once("exceptions/PasswordMismatchException.php");
require_once("exceptions/PasswordTooShortException.php");
require_once("exceptions/UsernameContainsIllegalCharactersException.php");
require_once("exceptions/UsernameEmptyException.php");
require_once("exceptions/UsernameTakenException.php");
require_once("exceptions/UsernameTooShortException.php");

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

$flashMessageProvider = new \model\FlashMessage();
$mainController = new \controller\MainController($flashMessageProvider);
$mainController->route();

// echo "<hr />";
// echo "<strong>\$_SESSION</strong>";
// echo '<pre>' . var_export($_SESSION, true) . '</pre>';
// echo "<hr />";
// echo "<strong>\$_COOKIE</strong>";
// echo '<pre>' . var_export($_COOKIE, true) . '</pre>';
