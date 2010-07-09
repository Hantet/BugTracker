<?php
require_once("config.php");
require_once("lib/classes.php");
require_once("pages.php");
require_once("special.php");

$body = new body;
$cfg = new config;
$sql = new sql;

if(isset($_COOKIE['wul']) && isset($_COOKIE['wup']) && $_COOKIE['wul'] != '' && $_COOKIE['wup'] != '')
	$user = $body->cookies();
	
$body->header();

if(isset($_POST['login']) && isset($_POST['passw']) && $user['id'] == "-1")
	$body->failedlogin();

if(file_exists("install.php"))
{
	if($sql->exe($cfg->get("realmd"),"SELECT 1 FROM `bt_message`"))
		$body->blocknot('<div class="pad">Внимание!<br><br>Необходимо удалить файл <b>install.php</b> в корневой директории баг-трекера.</div>');
	else
		$body->install();
	$body->end();
	exit();
}

if($user['id'] != "-1")
	$body->success();

if($user['gmlevel'] >= $cfg->get("mingm"))
	$body->admin();

if($checkpage && $user['id'] != "-1")
	$body->inc($content);

if($user['id'] == "-1")
{
	$body->login();
	$body->blocknot('<div class="pad">Здравствуйте!<br><br>Для того, чтобы оставить свой баг-репорт или посмотреть другие, вам необходимо авторизироваться, используя логин и пароль для входа в игру. Спасибо.</div>');
}

$body->end();
?>