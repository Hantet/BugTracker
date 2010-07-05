<?php
require_once("config.php");
require_once("lib/classes.php");
require_once("pages.php");
require_once("special.php");

$body = new body;
$cfg = new config;

if($_COOKIE['wul'] != "" && $_COOKIE['wup'] != "")
	$user = $body->cookies();

if(isset($_POST['login']) && isset($_POST['passw']) && !$user)
	$body->failedlogin();

if($user['id'] != "-1")
	$body->success();

if($user['gmlevel'] >= $cfg->get("mingm"))
	$body->admin();

if($checkpage && $user['id'] != "-1")
	$body->inc($content);

if($user['id'] == "-1")
{
	$body->login();
	$body->block("Здравствуйте!<br><br>Для того, чтобы оставить свой баг-репорт или посмотреть другие, вам необходимо авторизироваться, используя логин и пароль для входа в игру. Спасибо.");
}

$body->end();
?>