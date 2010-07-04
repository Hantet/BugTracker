<?php
class config
{
	function get($id)
	{
		$arr = array(
		"dbhost"		=> "localhost",			// Адрес MySQL сервера
		"dbuser"		=> "mangos",			// Логин MySQL сервера
		"dbpass"		=> "mangos",			// Пароль MySQL сервера
		"realmd"		=> "realmd",			// Имя базы данных аккаунтов
		"characters"	=> "characters",		// Имя базы данных персонажей
		"title"			=> "Баг-трекер",		// Имя главной страницы
		"mingm"			=> "3",					// Минимальный уровень ГМ для доступа в админ-панель
		"pagepath"		=> "pages/",			// Папка к include-файлам (не трогайте, если не уверены)
		"main"			=> "http://bug",		// Ip-адрес (домен) основного сайта
		"anim"			=> true,				// Анимировать прогресс-бар в списках? Да: true, Нет: false.
		"LinkAccount"	=> "http://yoursite.ru/admin/account.php?id=",	// Используется в админке, ссылка на аккаунт, например в MMFPM.
																		// false (без кавычек) - если использовать ссылку не нужно.
		"LinkPlayer"	=> "http://yoursite.ru/admin/player.php?guid="	// Используется в админке, ссылка на персонажа, например в MMFPM.
																		// false (без кавычек) - если использовать ссылку не нужно.
		);
		if(in_array($id,array_keys($arr)))
			return $arr[$id];
	}
}

$cfg = new config;
mysql_connect($cfg->get("dbhost"),$cfg->get("dbuser"),$cfg->get("dbpass"));
mysql_query("SET NAMES 'UTF8'");
?>
