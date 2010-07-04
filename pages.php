<?php
$vars = array("a");
foreach($vars as $item)
	${$item} = (isset($_GET[$item])) ? $_GET[$item] : false;

$body = new body;

$link = array(
	"create"	=> "send.php",
	"list"		=> "list.php",
	"admin"		=> "admin.php");
$name = array(
	"create"	=> "Создать новый баг-репорт",
	"list"		=> "Список баг-репортов",
	"admin"		=> "Админ-панель");

$checkpage = false;
if(in_array($a, array_keys($link)))
{
	$title = $name[$a];
	$content = $link[$a];
	$checkpage = true;
}
else
{
	$cfg = new config;
	$title = $cfg->get("title");
}
?>