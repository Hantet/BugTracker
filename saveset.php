<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && isset($_POST['lis']) && ($_POST['del'] == "1" || (isset($_POST['tit']) && isset($_POST['pri']) && isset($_POST['sta']) && isset($_POST['pro']))))
{
	require_once("config.php");
	require_once("lib/classes.php");

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

		$query = "UPDATE `bt_message` SET `title` = '".$title."', `status` = '".$status."', `percentage` = '".$progress."', `priority` = '".$priority."' WHERE `id` = '".$listid."'";
	}
	else
	{
		$query = "DELETE FROM `bt_message` WHERE `id` = '".$_POST['lis']."'";
	}

	$sql = new sql;
	$cfg = new config;

	if($sql->exe($cfg->get("realmd"),$query))
		echo 1;
	else
		echo 'Ошибка! Таблица `bt_message` недоступна или повреждена!';
}
?>