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
		##		mangos:			Name database of world.
		##		realmd:			Name database of account.
		##		characters:		Name database of characters.
		##################################################################################################*/
		"dbhost"		=> "localhost",
		"dbuser"		=> "mangos",
		"dbpass"		=> "mangos",
		"mangos"		=> "mangos"
		"realmd"		=> "realmd",
		"characters"	=> "characters",
		/*##################################################################################################
		## Site sittings
		##		title:			Name of site (viewing in tag <title></title> on main page).
		##		mingm:			Minimum security level for access in adminpanel.
		##		pagepath:		Folder on a site where there are executing files.
		##		main:			IP-address or domain name of site.
		##		progressbar:	Display progress bar in list-page (boolean).
		##		anim:			Animation progress-bar in list-page (boolean).
		##		LinkAccount:	Link to page on deatil view account or false if it is not necessary.
		##		LinkPlayer:		Link to page on deatil view character or false if it is not necessary.
		##		searchlimit:	Limit of query for search (query, creature, item, etc).
		##################################################################################################*/
		"title"			=> "Баг-трекер",
		"mingm"			=> 3,
		"pagepath"		=> "pages/",
		"main"			=> "http://localhost",
		"progressbar"	=> true,
		"anim"			=> false,
		"LinkAccount"	=> "http://localhost/admin/account.php?id=",
		"LinkPlayer"	=> "http://localhost/admin/player.php?guid=",
		"searchlimit"	=> 10,
		/*##################################################################################################
		## Announce of updates
		##		CheckVersion:	Check new version in git page of project (boolean).
		##		version:		Current version of bug-tracker. Do not change!
		##		checkdiff:		Different in days for recheck updates.
		##################################################################################################*/
		"CheckVersion"	=> false,
		"version"		=> 17,
		"checkdiff"		=> 2
		);
		
		if(in_array($id,array_keys($arr)))
			return $arr[$id];
	}
}

$cfg = new config;
@mysql_connect($cfg->get("dbhost"),$cfg->get("dbuser"),$cfg->get("dbpass"));
@mysql_query("SET NAMES 'UTF8'");
?>