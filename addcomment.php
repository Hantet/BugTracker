<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && 
	!empty($_POST['entry']) && 
	!empty($_POST['player']) && 
	!empty($_POST['text']) && 
	!empty($_POST['account']))
{
	require_once("config.php");
	require_once("lib/classes.php");
	$sql = new sql;
	$main = new main;
	
	$entry = intval($_POST['entry']);
	$account = intval($_POST['account']);
	$player = intval($_POST['player']);
	$text = htmlspecialchars($_POST['text'], ENT_QUOTES);
	$date = $main->GetDate("Y-m-d H:i:s");
	
	$query = "INSERT INTO `bt_comment` (`entry`,`account`,`player`,`text`,`date`) VALUES ('".$entry."','".$account."','".$player."','".$text."','".$date."')";	
	if(isset($_POST['admin']) && $_POST['admin'] == "1")
		$query = "INSERT INTO `bt_comment` (`entry`,`account`,`player`,`text`,`date`,`admin_reply`) VALUES ('".$entry."','".$account."','".$player."','".$text."','".$date."','1')";

	$sql->exe($cfg->get("realmd"),$query);
	echo $date;
}
?>