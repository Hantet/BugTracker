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
		case 2:
			$table = $cfg->get("wd_quest");
			if($cfg->get("lang") == 8)
				$query = "SELECT `Title_loc8`,`entry` FROM `locales_quest` WHERE `Title_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `Title`,`entry` FROM `quest_template` WHERE `Title` LIKE '%".$string."%'";
			break;
		case 3:
			$table = $cfg->get("wd_item");
			if($cfg->get("lang") == 8)
				$query = "SELECT `name_loc8`,`entry` FROM `locales_item` WHERE `name_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `name`,`entry` FROM `item_template` WHERE `name` LIKE '%".$string."%'";
			break;
		case 4:
			$table = $cfg->get("wd_npc");
			if($cfg->get("lang") == 8)
				$query = "SELECT `name_loc8`,`entry` FROM `locales_creature` WHERE `name_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `name`,`entry` FROM `creature_template` WHERE `name` LIKE '%".$string."%'";
			break;
		case 5:
			$table = $cfg->get("wd_object");
			if($cfg->get("lang") == 8)
				$query = "SELECT `name_loc8`,`entry` FROM `locales_gameobject` WHERE `name_loc8` LIKE '%".$string."%'";
			else if($cfg->get("lang") == 1)
				$query = "SELECT `name`,`entry` FROM `gameobject_template` WHERE `name` LIKE '%".$string."%'";
			break;
	}
	$result = $sql->exe($cfg->get("mangos"),$query." LIMIT ".$cfg->get("searchlimit"));
	$text = '<div class="pad">Результаты поиска:</div><br><table border="0" align="left" width="100%" cellpadding="0" cellspacing="0" style="padding: 3px;">';
	$i=0;
	while($row=$sql->fetch($result))
	{
		$name = str_replace("'","",$row[0]);
		$pname = preg_replace('/('.$string.')/iu', '<font color="gold">\0</font>', $name);
		$entry = $row[1];
		$link = '<a href="12345">1</a>';
		$text.= '
		<tr>
		 <td width="16" valign="top"><div style="cursor:pointer;" onClick=\'searchresult("'.$cfg->get("Database").$table.$entry.'","'.$name.'")\' title="Добавить"><img src="img/add.png"></div></td>
		 <td><div class="search"><a href="'.$cfg->get("Database").$table.$entry.'" target="_blank">'.$pname.'</a></div></td>
		</tr>';
		$i++;
	}
	echo $i.'^'.$text.'</table>';
}
?>