<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && isset($_POST['lis']) && ($_POST['del'] == "1" || (isset($_POST['tit']) && isset($_POST['pri']) && isset($_POST['sta']) && isset($_POST['pro']))))
{
	require_once("config.php");
	require_once("lib/classes.php");
	$sql = new sql;
	$cfg = new config;
	
	if($_POST['del'] == "0")
	{
		$listid		= $_POST['lis'];
		$title		= $_POST['tit'];
		$priority	= $_POST['pri'];
		$status		= $_POST['sta'];
		$progress	= $_POST['pro'];

		$listid		= htmlspecialchars(addslashes($listid), ENT_QUOTES);
		$title		= htmlspecialchars(addslashes($title), ENT_QUOTES);
		$priority	= htmlspecialchars(addslashes($priority), ENT_QUOTES);
		$status		= htmlspecialchars(addslashes($status), ENT_QUOTES);
		$progress	= htmlspecialchars(addslashes($progress), ENT_QUOTES);

		if($sql->exe($cfg->get("realmd"),"UPDATE `bt_message` SET `title` = '".$title."', `status` = '".$status."', `percentage` = '".$progress."', `priority` = '".$priority."' WHERE `id` = '".$listid."'"))
			echo 1;
		else
			echo 'Ошибка! Таблица `bt_message` недоступна или повреждена!';
	}
	else
	{
		if($sql->exe($cfg->get("realmd"),"DELETE FROM `bt_message` WHERE `id` = '".$_POST['lis']."'"))
			$m1 = 1;
		if($sql->exe($cfg->get("realmd"),"DELETE FROM `bt_options` WHERE `id` = '".$_POST['lis']."'"))
			$m2 = 1;
		if($sql->exe($cfg->get("realmd"),"DELETE FROM `bt_comment` WHERE `entry` = '".$_POST['lis']."'"))
			$m3 = 1;
		if($m1 == 1 && $m2 == 1 && $m3 == 1)
			echo 1;
		else
			echo 'Ошибка! Таблица `bt_message` и/или `bt_options` недоступна или повреждена!';
	}
}
?>