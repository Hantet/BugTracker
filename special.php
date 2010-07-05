<?php
$body = new body;
$body->redirect();
$body->htmlstart($title);

if(isset($_POST['login']) && isset($_POST['passw']))
{
	$log = htmlspecialchars(addslashes($_POST['login']));
	$pas = htmlspecialchars(addslashes($_POST['passw']));
	if($body->authorization($log,$pas))
	{
		$hash = md5($pas.":".$pas);
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?cookies=1&l='.$log.'&p='.$pas.'&hash='.$hash.'">';
		exit();
	}
	else
		$body->failedlogin();
}

$user['id'] = "-1";
$user['gmlevel'] = "0";
?>