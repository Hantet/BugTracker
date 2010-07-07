<?php
require_once("config.php");
require_once("lib/classes.php");
$body = new body;
$cfg = new config;
$sql = new sql;
$str = '';

$fp = fopen('sql/realmd_bugtracker.sql','r');
if($fp)
	while(!feof($fp))
		$str.= fgets($fp, 999);

$i = 0;
$exp = explode(";",$str);
do
{
	if(!$sql->exe($cfg->get("realmd"),$exp[$i]))
		break;
	$i++;
}while($exp[$i]);

if($i == $cfg->get("installquery"))
	echo 'Установка успешно завершена!<br>Выполнено запросов к БД: '.$i.'<br><br>';
else
	echo 'При установке возникли ошибки!<br>Успешно выполнено запросов: '.$i.'.<br>Не применившихся запросов: '.($cfg->get("installquery")-$i).'<br><br>';
echo '<a href="index.php">На главную</a>';
?>