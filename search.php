<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && 
	!empty($_POST['table']) &&
	!empty($_POST['string']))
{
	require_once("config.php");
	require_once("lib/classes.php");

	$sql = new sql;
	$main = new main;
	$cfg = new config;

	$string = htmlspecialchars($_POST['string'], ENT_QUOTES);
	$table = htmlspecialchars($_POST['table'], ENT_QUOTES);
	
	$query = "";
	switch($table)
	{
		case "2":
			$query = "SELECT `name`,`id` FROM `quest_template` WHERE `name` LIKE '".$string."%';
			break;
		case "3":
			$query = "SELECT `name`,`id` FROM `item_template` WHERE `name` LIKE '".$string."%';
			break;
		case "4":
			$query = "SELECT `name`,`entry` FROM `creature_template` WHERE `name` LIKE '".$string."%';
			break;
		case "5":
			$query = "SELECT `name`,`entry` FROM `gameobject_template` WHERE `name` LIKE '".$string."%'";
			break;
	}
	$result = $sql->exe($cfg->get("mangos"),$query." LIMIT ".$cfg->get("searchlimit"));
	$text = '';
	while($row=$sql->fetch($result))
	{
		$text.= '<div class="search"><a href="#" onClick="searchresult('.$row[1].')">'.$row[0].'</a></div>';
	}
	echo $text;
}
?>