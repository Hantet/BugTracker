<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && 
	!empty($_POST['a1']) && 
	!empty($_POST['a2']) && 
	!empty($_POST['a3']) && 
	!empty($_POST['a4']) && 
	!empty($_POST['a5']) && 
	!empty($_POST['sql']))
{
	require_once("config.php");
	require_once("lib/classes.php");

	$sql = new sql;
	$main = new main;
	$cfg = new config;

	$op = $_POST['sql'];
	$a1 = $_POST['a1'];
	$a2 = $_POST['a2'];
	$a3 = $_POST['a3'];
	$a4 = $_POST['a4'];
	$a5 = $_POST['a5'];

	$area1 = htmlspecialchars(addslashes($a1), ENT_QUOTES);
	$area2 = htmlspecialchars(addslashes($a2), ENT_QUOTES);
	$area3 = htmlspecialchars(addslashes($a3), ENT_QUOTES);
	$area4 = htmlspecialchars(addslashes($a4), ENT_QUOTES);
	$area5 = htmlspecialchars(addslashes($a5), ENT_QUOTES);

	$id = $main->GetNewId();
	$opt = explode("*",$op);
	$i=0;
	$t1 = true;
	$t2 = true;
	$query = "";
	$date = date("Y-m-d H:i:s");

	do
	{
		$row = explode("^",$opt[$i]);
		$query.= "('".$id."','".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."'),";
		$i++;
	}while($opt[$i]);

	$query = substr($query, 0, strlen($query)-1);
	if(!$sql->exe($cfg->get("realmd"),"INSERT INTO `bt_message` (`id`,`account`,`sender`,`title`,`priority`,`date`,`text_1`,`text_2`,`text_3`) VALUES ('".$id."','".$area5."','".$row[0]."','".$area4."','1','".$date."','".$area1."','".$area2."','".$area3."')"))
	{
		echo 'Таблица `bt_message` недоступна или повреждена! Данные не записаны!';
		$t1 = false;
	}
	if(!$sql->exe($cfg->get("realmd"),"INSERT INTO `bt_options` (`id`,`guid`,`map`,`zone`,`type`,`name`,`link`) VALUES ".$query))
	{
		echo 'Таблица `bt_options` недоступна или повреждена! Данные не записаны!';
		$t2 = false;
	}
	if($t1 && $t2)
		echo 1;
}
?>