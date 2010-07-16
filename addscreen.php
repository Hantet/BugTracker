<?php
require_once("config.php");
require_once("lib/classes.php");
$cfg = new config;
$main = new main;

if($_FILES['myfile']['type'] != "image/jpeg" && $_FILES['uploaded']['type'] != "image/pjpeg")
	die('<script type="text/javascript">window.top.window.stopUpload("1^Ошибка! Разрешено загружать только файлы с расширениями jpg или jpeg!");</script>');
	
if($_FILES['myfile']['size'] > $cfg->get("size_limit"))
	die('<script type="text/javascript">window.top.window.stopUpload("1^Ошибка! Размер выбранного изображения слишком большой! Допустимый размер: до '.($cfg->get("size_limit")/1000).' Кбайт.);</script>');

	
$rand = $main->GetRandomStr(16);
$exp = explode('.',$_FILES['myfile']['name']);
$newname = $rand.'.'.$exp[1];

$path = getcwd().'/screen/';
$target_path = $path.basename($newname);
if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path))
{
	$content = file_get_contents($target_path);
	if(!$main->checkImage($content))
	{
		unlink($target_path);
		die('<script type="text/javascript">window.top.window.stopUpload("1^Ошибка! Выбранное изображение не является подлинным. Видимо, оно было изменено в сторонней программе.");</script>');
	}

	$m_name = $newname;
	$m_mini = $main->GetRandomStr(16).'.jpg';
	$m_size = $_FILES['myfile']['size'];

	$main->ResizeImage($target_path,$path.$m_mini,160,200,75);
	echo '<script type="text/javascript">window.top.window.stopUpload("2^'.$m_mini.'^'.substr($m_size, 0, strlen($m_size)-3).'^'.$m_name.'");</script>';
}
?>