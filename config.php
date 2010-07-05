<?php
class config
{
	function get($id)
	{
		$arr = array(
		/*##################################################################################################
		## Connect to database
		##		dbhost:			IP-address or domain name where is started server MySQL.
		##		dbuser:			Username for connect to server MySQL.
		##		dbpass:			Password for connect to server MySQL.
		##		realmd:			Name database of account.
		##		characters:		Name database of characters.
		##################################################################################################*/
		"dbhost"		=> "localhost",
		"dbuser"		=> "mangos",
		"dbpass"		=> "mangos",
		"realmd"		=> "realmd",
		"characters"	=> "characters",
		/*##################################################################################################
		## Site sittings
		##		title:			Name of site (viewing in tag <title></title> on main page).
		##		mingm:			Minimum security level for access in adminpanel.
		##		pagepath:		Folder on a site where there are executing files.
		##		main:			IP-address or domain name of site.
		##		anim:			Animation progress-bar in list-page (boolean).
		##		LinkAccount:	Link to page on deatil view account or false if it is not necessary.
		##		LinkPlayer:		Link to page on deatil view character or false if it is not necessary.
		##################################################################################################*/
		"title"			=> "Баг-трекер",
		"mingm"			=> "3",
		"pagepath"		=> "pages/",
		"main"			=> "http://bug",
		"anim"			=> true,
		"LinkAccount"	=> "http://yoursite.ru/admin/account.php?id=",
		"LinkPlayer"	=> "http://yoursite.ru/admin/player.php?guid=",
		/*##################################################################################################
		## Announce of updates
		##		CheckVersion:	Check new version in git page of project (boolean).
		##		version:		Current version of bug-tracker. Do not change!
		##		checkdiff:		Different in days for recheck updates.
		##		defaultdate:	Current php time-zone of server.
		##################################################################################################*/
		"CheckVersion"	=> true,
		"version"		=> "11",
		"checkdiff"		=> 2,
		"defaultdate"	=> date_default_timezone_set('Europe/Moscow'));
		
		if(in_array($id,array_keys($arr)))
			return $arr[$id];
	}
}

$cfg = new config;
@mysql_connect($cfg->get("dbhost"),$cfg->get("dbuser"),$cfg->get("dbpass"));
@mysql_query("SET NAMES 'UTF8'");
?>
