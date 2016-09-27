<?php

require_once('model/FlashMessage.php');

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');

require_once("controller/MainController.php");
require_once("controller/RegisterController.php");
require_once("controller/LoginController.php");
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

session_start();

$flash = new \model\FlashMessage();


$mainController = new \controller\MainController($flash);
$mainController->route();


//CREATE OBJECTS OF THE VIEWS
// $v = new LoginView();
// $dtv = new DateTimeView();
// $lv = new LayoutView();
//
// $lv->render(false, $v, $dtv);
//
// require_once("model/UserModel.php");
//
// $u = new \model\User("Admin");
// $u->login();
// echo '<pre>' . var_export($u, true) . '</pre>';
// echo '<pre>' . var_export($_SESSION, true) . '</pre>';


// $u = new \model\User("bAdmin");
// echo '<pre>' . var_export($u, true) . '</pre>';
