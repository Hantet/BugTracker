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
		case "quest":
			if($cfg->get("lang") == 8)
				$query = "SELECT `Title_loc8`,`entry` FROM `locales_quest` WHERE `Title_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `Title`,`entry` FROM `quest_template` WHERE `Title` LIKE '%".$string."%'";
			break;
		case "item":
			if($cfg->get("lang") == 8)
				$query = "SELECT `name_loc8`,`entry` FROM `locales_item` WHERE `name_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `name`,`entry` FROM `item_template` WHERE `name` LIKE '%".$string."%'";
			break;
		case "npc":
			if($cfg->get("lang") == 8)
				$query = "SELECT `name_loc8`,`entry` FROM `locales_creature` WHERE `name_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `name`,`entry` FROM `creature_template` WHERE `name` LIKE '%".$string."%'";
			break;
		case "object":
			if($cfg->get("lang") == 8)
				$query = "SELECT `name_loc8`,`entry` FROM `locales_gameobject` WHERE `name_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `name`,`entry` FROM `gameobject_template` WHERE `name` LIKE '%".$string."%'";
			break;
	}
	$result = $sql->exe($cfg->get("mangos"),$query." LIMIT ".$cfg->get("searchlimit"));
	$text = '<br><table border="0" align="center" width="95%" cellpadding="0" cellspacing="0" style="text-align: left;border: 1px;border-color: black;border-style:solid;padding: 3px;">';
	$i=0;
	while($row=$sql->fetch($result))
	{
		$name = str_replace("'","",$row[0]);
		$pname = preg_replace('/('.$string.')/iu', '<font color="gold">\0</font>', $name);
		$entry = $row[1];
		$text.= '
		<tr>
		 <td><div style="cursor:pointer;" onClick=\'document.getElementById("name").value="'.$name.'";searchresult('.$entry.');\'><img src="img/add.png"></div></td>
		 <td><div class="search"><a href="http://ru.wowhead.com/'.$table.'='.$entry.'" target="_blank">'.$pname.'</a></div></td>
		</tr>';
		$i++;
	}
	echo $i.'^'.$text.'</table><br>';
}
?>