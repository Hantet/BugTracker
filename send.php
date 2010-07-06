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

	$area1 = htmlspecialchars($_POST['a1'], ENT_QUOTES);
	$area2 = htmlspecialchars($_POST['a2'], ENT_QUOTES);
	$area3 = htmlspecialchars($_POST['a3'], ENT_QUOTES);
	$area4 = htmlspecialchars($_POST['a4'], ENT_QUOTES);
	$area5 = htmlspecialchars($_POST['a5'], ENT_QUOTES);

	$id = $main->GetNewId();
	$opt = explode("*",$_POST['sql']);
	$i=0;
	$t1 = true;
	$t2 = true;
	$query = "";
	$date = $main->GetDate("Y-m-d H:i:s");

	do
	{
		$row = explode("^",$opt[$i]);
		$query.= "('".$id."','".$row[0]."','".$row[1]."','".$row[4]."','".$row[5]."','".$row[2]."','".$row[3]."','".$row[6]."','".$row[7]."'),";
		$i++;
	}while($opt[$i]);

	$query = substr($query, 0, strlen($query)-1);
	if(!$sql->exe($cfg->get("realmd"),"INSERT INTO `bt_message` (`id`,`account`,`sender`,`title`,`priority`,`date`,`text_1`,`text_2`,`text_3`) VALUES ('".$id."','".$area5."','".$row[1]."','".$area4."','1','".$date."','".$area1."','".$area2."','".$area3."')"))
	{
		echo 'Таблица `bt_message` недоступна или повреждена! Данные не записаны!';
		$t1 = false;
	}
	if(!$sql->exe($cfg->get("realmd"),"INSERT INTO `bt_options` (`id`,`method`,`guid`,`map`,`zone`,`type`,`subtype`,`name`,`link`) VALUES ".$query))
	{
		echo 'Таблица `bt_options` недоступна или повреждена! Данные не записаны!';
		$t2 = false;
	}
	if($t1 && $t2)
		echo 1;
}
?>