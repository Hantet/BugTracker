<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && 
	!empty($_POST['a1']) &&
	!empty($_POST['a2']) &&
	!empty($_POST['userid']) &&
	!empty($_POST['sql']) && 
	!empty($_POST['links']))
{
	require_once("config.php");
	require_once("lib/classes.php");

	$sql = new sql;
	$main = new main;
	$cfg = new config;
	$id = $main->GetNewId();
	$date = $main->GetDate("Y-m-d H:i:s");

	$link_query = substr($_POST['links'], 0, strlen($_POST['links'])-1);
	$link_query = str_replace("ID_OF_REPORT",$id,$link_query);
	$link_query = stripslashes($link_query);
	$area1 = htmlspecialchars($_POST['a1'], ENT_QUOTES);
	$area2 = htmlspecialchars($_POST['a2'], ENT_QUOTES);
	$area3 = '';
	$userid = htmlspecialchars($_POST['userid'], ENT_QUOTES);

	if(!empty($_POST['a3']))
		$area3 = htmlspecialchars($_POST['a3'], ENT_QUOTES);

	if(isset($_POST['countscreen']) && intval($_POST['countscreen']) > 0)
	{
		$sc_count = $_POST['countscreen'];
		$sc_names = $_POST['screens'];
		$exp = explode("*",$sc_names);
		$screen = "INSERT INTO `bt_screen` (`entry`,`address`,`mini`) VALUES ";
		for($i=0;$i<$sc_count;$i++)
		{
			$links = explode("^",$exp[$i]);
			$screen.= "('".$id."','".$links[0]."','".$links[1]."'),";
		}
		$query = substr($screen, 0, strlen($screen)-1);
		if(!$sql->exe($cfg->get("realmd"),$query))
			echo 'Таблица `bt_screen` недоступна или повреждена. Данные не записаны!';
	}

	$row = explode("^", $_POST['sql']);
	$query = "('".$id."','".$_POST['userid']."','".$row[0]."','".$row[5]."','1','".$row[1]."','".$area1."','".$area2."','".$area3."','".$row[2]."','".$row[3]."','".$row[4]."','".$date."')";

	if(!$sql->exe($cfg->get("realmd"),"INSERT INTO `bt_message` (`id`,`account`,`sender`,`title`,`priority`,`type`,`text_1`,`text_2`,`text_3`,`subtype`,`map`,`zone`,`date`) VALUES ".$query))
		echo 'Таблица `bt_message` недоступна или повреждена! Данные не записаны!';

	if(!$sql->exe($cfg->get("realmd"),"INSERT INTO `bt_options` (`id`,`link`) VALUES ".$link_query))
		echo 'Таблица `bt_options` недоступна или повреждена! Данные не записаны!';
}
?>