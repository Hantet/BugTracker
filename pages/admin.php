<?php
global $user;
$body = new body;
$cfg = new config;
if($user['gmlevel'] >= $cfg->get("mingm"))
{
	$body->adminpanel();
}
else
{
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php">';
	exit();
}
?>