<?php
interface database
{
	function exe($db,$query);
	function res($db,$query);
	function fetch($query);
	function num_rows($query);
}

interface create
{
	function SelectMessage($id);
	function SelectOptions($id);
	function GetNewId();
	function GetNameByGUID($guid);
	function GetAccountNameById($id);
	function GetSections();
	function GetSubType($id);
	function GetMap($id);
	function GetZone($id);
	function GetSectionById($id);
	function GetPercent($id,$one=false);
	function GetPriority($id,$one=false);
	function GetStatus($id,$one=false);
	function GetDate($format);
	function GetPreviousElement($type,$change);
	function SetStatus($statusid=-1,$id=-1);
	
	function LoadZones();
	function LoadChar($acc);
	function LoadStatus($id="0");
	function LoadSection();
	function LoadMap();
	function LoadList($status="all");
	function LoadPriority($id = "0");
	function LoadView($id);
	function LoadSubType();
	
	function login($login,$pass);
	function cookies($login,$pass);
	function AccountRepass($acc,$code);
	function isValidSection($id);
	function PercentList($id=0);
}

interface html
{
	function install();
	function send();
	function viewall($int);
	function progress($int);
	function detail($int);
	function view();
	function edit($id,$text);
	function htmlstart($title);
	function header();
	function end();
	function block($text);
	function blocknot($text);
	function login();
	function success();
	function inc($content);
	function admin();
	function adminconfig();
	function CheckVersion();
	function adminpanel();
	function authorization($login,$pass);
	function failedlogin();
	function cookies();
	function inject($code);
}

require_once("lib/database.php");
require_once("lib/create.php");
require_once("lib/html.php");
?>