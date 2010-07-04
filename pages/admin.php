<?php
global $user;
$body = new body;
if($user['gmlevel'] >= $mingm)
{
	$body->adminpanel();
}
else
{
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php">';
	exit();
}
?>