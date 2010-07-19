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
		"mangos"		=> "mangos",
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
		##		lang:			Translate search result to russian language? (8: russian, 1: english).
		##		size_limit:		Limit (in bytes) on the size of the loaded image.
		##################################################################################################*/
		"title"			=> "Баг-трекер",
		"mingm"			=> 3,
		"pagepath"		=> "pages/",
		"main"			=> "http://localhost",
		"progressbar"	=> true,
		"anim"			=> false,
		"LinkAccount"	=> "http://localhost/admin/account.php?id=",
		"LinkPlayer"	=> "http://localhost/admin/player.php?guid=",
		"searchlimit"	=> 17,
		"lang"			=> 8,
		"size_limit"	=> 500000,
		/*##################################################################################################
		## Admin settings
		##		CheckVersion:	Check new version in git page of project (boolean).
		##		version:		Current version of bug-tracker. Do not change!
		##		checkdiff:		Different in days for recheck updates.
		##		installquery:	Count of query for install. Do not change!
		##################################################################################################*/
		"CheckVersion"	=> false,
		"version"		=> 37,
		"checkdiff"		=> 2,
		"installquery"	=> 215,
		/*##################################################################################################
		## Outer resources
		##		Database:		Link to the wow database site. Default: http://ru.wowhead.com/.
		##		wd_quest:		http://ru.wowhead.com/quest=. Default: quest.
		##		wd_item:		http://ru.wowhead.com/item=. Default: item.
		##		wd_npc:			http://ru.wowhead.com/npc=. Default: npc.
		##		wd_object:		http://ru.wowhead.com/object=. Default: object.
		##
		##		Example:		http://wowdata.ru/item.html?id=26051
		##
		##						"http://wowdata.ru/" - is Database.
		##						"item.html?id=" - is wd_item.
		*/##################################################################################################
		"Database"		=> "http://ru.wowhead.com/",
		"wd_quest"		=> "quest=",
		"wd_item"		=> "item=",
		"wd_npc"		=> "npc=",
		"wd_object"		=> "object="
		);
		
		if(in_array($id,array_keys($arr)))
			return $arr[$id];
	}
}

$cfg = new config;
@mysql_connect($cfg->get("dbhost"),$cfg->get("dbuser"),$cfg->get("dbpass"));
@mysql_query("SET NAMES 'UTF8'");
?>