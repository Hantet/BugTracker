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
	public function SelectMessage($id);
	public function SelectOptions($id);
	public function GetNewId();
	public function GetNameByGUID($guid);
	public function GetAccountNameById($id);
	public function GetSections();
	public function GetPercent($id,$one=false);
	public function GetPriority($id,$one=false);
	public function GetStatus($id,$one=false);
	
	public function LoadZones();
	public function LoadChar($acc);
	public function LoadStatus($id="0");
	public function LoadSection();
	public function LoadMap();
	public function LoadList($status="all");
	public function LoadPriority($id = "0");
	public function LoadView($id);

	public function login($login,$pass);
	public function cookies($login,$pass);
	public function AccountRepass($acc,$code);
	public function isValidSection($id);
	public function PercentList($id=0);
}

interface html
{
	function send();
	function viewall($int);
	function viewdate($int);
	function progress($int);
	function detail($int);
	function view();
	function edit($id,$text);
	function htmlstart($title);
	function header();
	function end();
	function block($text);
	function login();
	function success();
	function inc($content);
	function admin();
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