<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && isset($_POST['type']) && isset($_POST['input1']))
{
	$type = intval($_POST['type']);
	$input1 = $_POST['input1'];
	$change = false;
	$delete = false;
	
	if(isset($_POST['input2']))	
		$input2 = $_POST['input2'];

	if(isset($_POST['change']))
		$change = $_POST['change'];
	
	if(isset($_POST['delete']))
		$delete = true;

	require_once("config.php");
	require_once("lib/classes.php");
	$sql = new sql;
	$main = new main;
	
	if(!$change && !$delete)
	{
		switch($type)
		{
			case 1:
				$query = "INSERT INTO `bt_priority` (`name`,`color`) VALUES ('".$input1."','".$input2."')";
				break;
			case 2:
				$query = "INSERT INTO `bt_section` (`name`) VALUES ('".$input1."')";
				break;
			case 3:
				$query = "INSERT INTO `bt_subtype` (`name`) VALUES ('".$input1."')";
				break;
			case 4:
				$query = "INSERT INTO `bt_status` (`name`) VALUES ('".$input1."')";
				break;
			default:
				$query = false;
		}
	}
	else if(!$delete)
	{
		switch($type)
		{
			case 1:
				$query = "UPDATE `bt_priority` SET `name` = '".$input1."', `color` = '".$input2."' WHERE `id` = '".$change."'";
				break;
			case 2:
				$query = "UPDATE `bt_section` SET `name` = '".$input1."' WHERE `id` = '".$change."'";
				break;
			case 3:
				$query = "UPDATE `bt_subtype` SET `name` = '".$input1."' WHERE `id` = '".$change."'";
				break;
			case 4:
				$query = "UPDATE `bt_status` SET `name` = '".$input1."' WHERE `id` = '".$change."'";
				break;
			default:
				$query = false;
		}
	}
	else if($delete)
	{
		switch($type)
		{
			case 1:
				$query = "DELETE FROM `bt_priority` WHERE `id` = '".$change."' LIMIT 1";
				break;
			case 2:
				$query = "DELETE FROM `bt_section` WHERE `id` = '".$change."' LIMIT 1";
				break;
			case 3:
				$query = "DELETE FROM `bt_subtype` WHERE `id` = '".$change."' LIMIT 1";
				break;
			case 4:
				$query = "DELETE FROM `bt_status` WHERE `id` = '".$change."' LIMIT 1";
				break;
			default:
				$query = false;
		}
	}
	if($query)
	{
		if($delete)
		{
			$id = $main->GetPreviousElement($type,$change);
			switch($type)
			{
				case 1:
					$upd = "UPDATE `bt_message` SET `priority` = '".$id."' WHERE `priority` = '".$change."'";
					break;
				case 2:
					$upd = "UPDATE `bt_options` SET `type` = '".$id."' WHERE `type` = '".$change."'";
					break;
				case 3:
					$upd = "UPDATE `bt_options` SET `subtype` = '".$id."' WHERE `subtype` = '".$change."'";
					break;
				case 4:
					$upd = "UPDATE `bt_message` SET `status` = '".$id."' WHERE `status` = '".$change."'";
					break;
				default:
					$upd = false;
			}
			if($upd)
			{
				if(!$sql->exe($cfg->get("realmd"),$upd))
					echo 'Ошибка переноса! MySQL код некорректен!';
			}
			else
				echo 'Ошибка! Тип '.$type.' не опознан!';
		}
		if($sql->exe($cfg->get("realmd"),$query))
			echo 1;
		else
			echo 'Ошибка! MySQL код некорректен!';
	}
	else
		echo 'Ошибка! Тип '.$type.' не опознан!';
}
else
	echo 'Параметры не переданы!';
?>