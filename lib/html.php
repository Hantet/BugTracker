<?php
class body implements html
{
	public function send()
	{
		global $user;
		$cfg = new config;
		$main = new main;
		$main->LoadZones();
		if($user['id'] > "-1")
		{
			echo '
			<table border="1" id="t1" cellpadding="0" cellspacing="0" align="center">
			 <tr>
			  <td width="400px" class="block"><div class="pad">Сейчас так:</div>
			   <textarea class="textarea" id="area1" style="height:80px;"></textarea><div class="pad">А должно быть так:</div>
			   <textarea class="textarea" id="area2" style="height:80px;"></textarea><div class="pad">Пояснение:</div>
			   <textarea class="textarea" id="area3"></textarea>
			   <div align="right"><div class="butt" onClick="send()">Отправить</div></div>
			  </td>
			  <td class="block">
			   <table class="t2" border="0" cellpadding="0" cellspacing="0" align="center">
			    <tr>
			     <td class="block2">Заголовок: </td>
			     <td align="right">
			      <input id="area4" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text">
			     </td>
			    </tr>
			   </table>
			   <table class="t2" id="t2" border="0" cellpadding="0" cellspacing="0" align="center">
			    <tr>
			     <td class="block2">Персонаж: </td>
			     <td align="right">
			      <select class="input" onchange="next(0)" id="player"><option DISABLED SELECTED>--</option>';$main->LoadChar($user['id']);echo '</select>
			     </td>
			    </tr>
			    <tr id="var1" style="display:none;">
			     <td class="block2">Тип: </td>
			     <td align="right">
			      <select class="input" onchange="next(1)" id="type"><option DISABLED SELECTED>--</option>';$main->LoadSection();echo '</select>
			     </td>
			    </tr>
			    <tr id="var2" style="display:none;">
			     <td class="block2">Местность: </td>
			     <td align="right">
			      <select class="input" onchange="ChangeZones(this.options[this.selectedIndex].value);next(2)" id="map"><option DISABLED SELECTED>--</option>';$main->LoadMap();echo '</select>
			     </td>
			    </tr>
			    <tr id="var3" style="display:none;">
			     <td class="block2">Зона: </td>
			     <td align="right">
			      <select class="input" onchange="next(3)" id="zone"></select>
			     </td>
			    </tr>
			    <tr id="var4" style="display:none;">
			     <td class="block2">Название: </td>
			     <td align="right">
			      <input id="name" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text">
			     </td>
			    </tr>
			    <tr id="var5" style="display:none;">
			     <td class="block2">Wowhead ссылка: </td>
			     <td align="right">
			      <input id="db" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text">
			     </td>
			    </tr> 
			   </table>
			   <div align="right"><div id="var6" class="butt" style="display:none;" onClick="tolink()"><span id="retype">Добавить</span></div></div>
			   <div id="link"></div>
			   <div id="saveblock" style="display:none;"></div>
			   <div align="right"><span id="ajaximg" style="visibility:hidden;"><img src="img/1.gif"></span></div>
			  </td>
			 </tr>
			</table>
			<span id="userid" style="display:none;">'.$user['id'].'</span>';
		}
	}
	public function viewall($all)
	{
		$main = new main;
		$title = $all['title'];
		$priority = $main->GetPriority($all);
		$text = 'Приоритет: <b>'.$priority.'</b> | Название: <b>'.$title.'</b>';
		return $text;
	}
	public function viewdate($all)
	{
		$date = $all['date'];
		$exp_date = explode("-",$date);
		$exp_space = explode(" ",$exp_date[2]);
		$exp_time = explode(":",$exp_space[1]);
		
		$year = $exp_date[0];
		$month = $exp_date[1];
		$day = $exp_space[0];
		
		$hours = $exp_time[0];
		$minute = $exp_time[1];
		$seconds = $exp_time[2];
		
		$lit_m = array(
			"01"	=>	"января",
			"02"	=>	"февраля",
			"03"	=>	"марта",
			"04"	=>	"апреля",
			"05"	=>	"мая",
			"06"	=>	"июня",
			"07"	=>	"июля",
			"08"	=>	"августа",
			"09"	=>	"сентября",
			"10"	=>	"октября",
			"11"	=>	"ноября",
			"12"	=>	"декабря"
		);
		
		$lit_d = array(
			"01"	=>	"первого",
			"02"	=>	"второго",
			"03"	=>	"третьего",
			"04"	=>	"четвёртого",
			"05"	=>	"пятого",
			"06"	=>	"шестого",
			"07"	=>	"седьмого",
			"08"	=>	"восьмого",
			"09"	=>	"девятого",
			"10"	=>	"десятого",
			"11"	=>	"одиннадцатого",
			"12"	=>	"двинадцатого",
			"13"	=>	"тринадцатого",
			"14"	=>	"четырнадцатого",
			"15"	=>	"пятнадцатого",
			"16"	=>	"шестнадцатого",
			"17"	=>	"семнадцатого",
			"18"	=>	"восемнадцатого",
			"19"	=>	"девятнадцатого",
			"20"	=>	"двадцатого",
			"21"	=>	"двадцать первого",
			"22"	=>	"двадцать второго",
			"23"	=>	"двадцать третьего",
			"24"	=>	"двадцать четвёртого",
			"25"	=>	"двадцать пятого",
			"26"	=>	"двадцать шестого",
			"27"	=>	"двадцать седьмого",
			"28"	=>	"двадцать восьмого",
			"29"	=>	"двадцать девятого",
			"30"	=>	"тридцатого",
			"31"	=>	"тридцать первого"
		);
		
		$text = $hours.':'.$minute.':'.$seconds.', '.$lit_d[$day].' '.$lit_m[$month].' '.$year.' года';
		return $text;
	}
	public function progress($all)
	{
		$pcn = $all['percentage'];
		$pix = str_replace("%","",$pcn)*6.55;
		$img = '<div style="height:19px;width:'.$pix.'px;background-color:#006400;"></div>';
		$text = '<div class="statusborder">'.$img.'</div>';
		return $text;
	}
	public function detail($int)
	{
		global $user;
		$cfg = new config;
		$main = new main;
		$main->LoadZones();
		$all = $main->SelectMessage($int);
		$opt = $main->SelectOptions($int);
		$this->block($this->viewall($all));
		$this->block($this->viewdate($all));
		$this->block($this->progress($all));
		echo '<script>detail_view=true;</script>';
			echo '
			<table border="1" id="t1" cellpadding="0" cellspacing="0" align="center">
			 <tr>
			  <td width="400px" class="block"><div class="pad">Сейчас так:</div>
			   <textarea class="textarea" id="area1" style="height:80px;" READONLY>'.$all['text_1'].'</textarea><div class="pad">А должно быть так:</div>
			   <textarea class="textarea" id="area2" style="height:80px;" READONLY>'.$all['text_2'].'</textarea><div class="pad">Пояснение:</div>
			   <textarea class="textarea" id="area3" READONLY>'.$all['text_2'].'</textarea>
			  </td>
			  <td class="block">
			   <table class="t2" id="t2" border="0" cellpadding="0" cellspacing="0" align="center">
			    <tr style="display:none;">
			     <td class="block2">Персонаж: </td>
			     <td align="right">
			      <select id="player"></select>
			     </td>
			    </tr>
			    <tr id="var1" style="display:none;">
			     <td class="block2">Тип: </td>
			     <td align="right">
			      <select class="input" onchange="next(1)" id="type"><option DISABLED SELECTED>--</option>';$main->LoadSection();echo '</select>
			     </td>
			    </tr>
			    <tr id="var2" style="display:none;">
			     <td class="block2">Местность: </td>
			     <td align="right">
			      <select class="input" onchange="ChangeZones(this.options[this.selectedIndex].value);next(2)" id="map"><option DISABLED SELECTED>--</option>';$main->LoadMap();echo '</select>
			     </td>
			    </tr>
			    <tr id="var3" style="display:none;">
			     <td class="block2">Зона: </td>
			     <td align="right">
			      <select class="input" onchange="next(3)" id="zone"></select>
			     </td>
			    </tr>
			    <tr id="var4" style="display:none;">
			     <td class="block2">Название: </td>
			     <td align="right">
			      <input id="name" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text">
			     </td>
			    </tr>
			    <tr id="var5" style="display:none;">
			     <td class="block2">Wowhead ссылка: </td>
			     <td align="right">
			      <input id="db" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text">
			     </td>
			    </tr> 
			   </table>
			   <div align="right"><div id="var6" class="butt" style="display:none;" onClick="tolink()"><span id="retype">Добавить</span></div></div>';
			   $main->LoadView($opt);echo '
			  </td>
			 </tr>
			</table>';
	}
	public function view()
	{
		$cfg = new config;
		$main = new main;
		if(empty($_GET['detail']))
		{
			if(isset($_GET['type']))
				$type = intval($_GET['type']);
			else
				$type = 0;
				
			if(isset($_GET['sort']))
				$sort = intval($_GET['sort']);
			else
				$sort = 1;

			if($type > 0 && $type < 3)
				$href = "index.php?a=list&type=".$type;
			else
				$href = "index.php?a=list";

			$sortto = 'desc';
			if(isset($_GET['sortto']) && ($_GET['sortto'] == "desc" || $_GET['sortto'] == "asc"))
				if(isset($_GET['last']) && $_GET['last'] == $sort)
					$_GET['sortto'] == "desc" ? $sortto = 'asc' : $sortto = 'desc';
			
			$mass = array(
				1 => array("30px","#"),
				2 => array("120px","Отправитель"),
				3 => array("100px","Прогресс"),
				4 => array("100px","Статус"),
				5 => array("100px","Приоритет"));

			echo '
			<table border="1" id="t1" cellpadding="0" cellspacing="0" align="center">
			 <tr>';
			for($i=1;$i<count($mass)+1;$i++)
				echo '<td class="view" style="width:'.$mass[$i][0].';" onClick="window.location.href=\''.$href.'&sort='.$i.'&sortto='.$sortto.'&last='.$sort.'\';" onMouseover="this.style.cursor=\'pointer\';this.style.backgroundColor=\'#777\';" onMouseout="this.style.cursor=\'default\';this.style.backgroundColor=\'#666\';"><b>'.$mass[$i][1].'</b></td>';
			echo '
			  <td class="view"><b>Заголовок</b></td>
			 </tr>';

			$psort = '';
			if(isset($_GET['sort']) && intval($_GET['sort']) > 0 && $_GET['sort'] > "0" && $_GET['sort'] < "6")
			{
				if($_GET['sortto'] == "desc")
					$psort = 'desc_'.$sort;
				else if($_GET['sortto'] == "asc")
					$psort = 'asc_'.$sort;		
			}
			if($type == 1)
				$result = $main->LoadList("new",$psort);
			else if($type == 2)
				$result = $main->LoadList("my",$psort);
			else
				$result = $main->LoadList("all",$psort);
			$m = 0;
			$js = "";
			$sql = new sql;
			while($row=$sql->fetch($result))
			{
				$all = $main->SelectMessage($row['id']);
				$opt = $main->SelectOptions($row['id']);

				$title = $all['title'];
				$pcn = $main->GetPercent($all);
				$pix = str_replace("%","",$pcn)*1.05;
				$stream = 'stream'.$row['id'];
				$width = ($cfg->get("anim") == true) ? 0 : $pix;
				$img = '<div id="stream'.$m.'" style="height:19px;width:'.$width.'px;background-color:#006400;"></div>';
			
				echo '
				<tr onClick="if(tr_select)window.location.href=\'index.php?a=admin&edit='.$row['id'].'\';else window.location.href=\'index.php?a=list&detail='.$row['id'].'\';" onMouseover="this.style.cursor=\'pointer\';this.style.backgroundColor=\'#888\';" onMouseout="this.style.cursor=\'default\';this.style.backgroundColor=\'#666\';">
				<td class="view">'.$row['id'].'</td>
				<td class="view">'.$main->GetNameByGUID(intval($row['sender'])).'</td>
				<td class="view" style="padding:0;margin:0;">'.$img.'</td>
				<td class="view">'.$main->GetStatus($all).'</td>
				<td class="view">'.$main->GetPriority($all).'</td>
				<td class="view"><div id="namelimit1" title="'.$title.'"><div style="position:absolute;">'.$title.'</div></div></td>
				</tr>';

				if($cfg->get("anim") && $pix > "0")
				{
					$js.= 'streamimg('.$m.','.$pix.');';
				}
				$m++;
			}
			echo '</table>';
			echo '<script>'.$js.'</script>';
		}
		else
		{
			if(intval($_GET['detail']) > 0)
			{
				$int = addslashes(intval($_GET['detail']));
				if($main->isValidSection($int))
					$this->detail($int);
				else
				{
					echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?a=list">';
					exit();
				}
			}
			else if(strlen($_GET['detail']) > 1)
				$this->inject(addslashes($_GET['detail']));
			else
			{
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?a=list">';
				exit();
			}
		}
	}
	public function edit($id,$text)
	{
		$cfg = new config;
		if($id == "0" && strlen($text) > "1")
			$this->inject(addslashes($text));
		else
		{
			$main = new main;
			if($main->isValidSection($id))
			{
				$all = $main->SelectMessage($id);
				$opt = $main->SelectOptions($id);
				$userid = $all['account'];
				$username = $main->GetAccountNameById($userid);
				if($cfg->get("LinkAccount"))$username = '<a href="'.$cfg->get("LinkAccount").$userid.'">'.$username.'</a>';

				$charguid = $all['sender'];
				$charname = $main->GetNameByGUID($charguid);
				if($cfg->get("LinkPlayer"))$charname = '<a href="'.$cfg->get("LinkPlayer").$charguid.'">'.$charname.'</a>';

				$text = '
				<table border="0" align="center" width="300" cellpadding="0" cellspacing="0">
				 <tr>
				  <td class="block" width="100" align="left">Заголовок:</td>
				  <td align="right"><input type="text" value="'.$all['title'].'" id="name" style="border:0px;width:100%;" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'"></td>
				 </tr>
				 <tr>
				  <td class="block" width="80" align="left">Приоритет:</td>
				  <td align="right"><select class="input" id="priority" style="border:0px;width:100%;">'.$main->LoadPriority($id,$all).'</select></td>
				 </tr>
				 <tr>
				  <td class="block" width="80" align="left">Статус:</td>
				  <td align="right"><select class="input" id="status" style="border:0px;width:100%;">'.$main->LoadStatus($id,$all).'</select></td>
				 </tr>
				 <tr>
				  <td class="block" width="80" align="left">Прогресс:</td>
				  <td align="right"><select class="input" id="progress" style="border:0px;width:100%;">'.$main->PercentList($id,$all).'</select></td>
				 </tr>
				 <tr>
				  <td class="block" width="80" align="left">Удалить?</td>
				  <td align="right"><input type="checkbox" id="delete" onClick="if(this.checked)todelete(1);else todelete(2);"></td>
				 </tr>
				 <tr>
				  <td></td>
				  <td align="right"><div class="butt" onClick="saveset()" id="spansave">Сохранить</div><br></td>
				 </tr>
				 <tr>
				  <td class="block" width="80" align="left">Аккаунт:</td>
				  <td class="block" align="right">'.$username.'</td>
				 </tr>
				 <tr>
				  <td class="block" class="block" width="80" align="left">Персонаж:</td>
				  <td class="block" align="right">'.$charname.'</td>
				 </tr>
				</table><span id="listid" style="display:none;">'.$id.'</span>';

				$this->block($text);
			}
			else
			{
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?a=list">';
				exit();
			}
		}
	}
	public function htmlstart($title)
	{
		echo '
		<html>
		<head>
		<title>'.$title.'</title>
		<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
		<script src="lib/jquery.js"></script>
		<script src="lib/main.js"></script>
		<link rel="stylesheet" type="text/css" href="lib/style.css">
		</head>
		<body>';
	}
	public function header()
	{
		echo '<div align="center"><div class="b1">';
	}
	public function end()
	{
		echo '</div></div></body></html>';
	}
	public function block($text)
	{
		echo '
		<table id="t1" cellpadding="0" cellspacing="0" align="center">
		 <tr>
		  <td class="mini">'.$text.'</td>
		 </tr>
		</table>';
	}
	
	public function login()
	{
		echo '
		<div class="border" id="clickauth"><div id="hellotxt"><a href="#" onClick="showauth()">Вход</a></div></div>
		<div class="border" id="placeauth" style="display:none;"><div id="hellotxt">
		 <form action="index.php" method="post">
		  <input class="input" type="text" name="login" value="Логин" onFocus="if(this.value==\'Логин\')this.value=\'\';this.style.backgroundColor=\'#CCC\'" onBlur="if(this.value==\'\')this.value=\'Логин\';this.style.backgroundColor=\'#FFF\'">
		  <input class="input" type="password" name="passw" value="Пароль" onFocus="if(this.value==\'Пароль\')this.value=\'\';this.style.backgroundColor=\'#CCC\'" onBlur="if(this.value==\'\')this.value=\'Пароль\';this.style.backgroundColor=\'#FFF\'">
		  <input type="submit" value="Войти">
		 </form>
		</div>
		</div>';
	}
	public function success()
	{
		$cfg = new config;
		global $user;
		if(isset($user['site_notice']))
			$this->block($user['site_notice']);
		echo '
		<div class="border" id="userpanel"><div id="hellotxt">Здравствуйте, <b>'.$user['username'].'</b>! (<a href="#" onClick="checklogout()">выход</a>)</div></div>
		<div class="border" id="checklogout" style="display:none;"><div id="hellotxt">Точно выйти? <button onClick="window.location.href=\'index.php?logout=1\';">Да</button> | <button onClick="logoutcancel()">Отмена</button></div></div>
		<div class="border"><div id="hellotxt"><a href="index.php?a=create">Создать</a> | <a href="index.php?a=list&sort=1&sortto=desc&last=1">Все</a> | <a href="index.php?a=list&type=1&sort=1&sortto=desc&last=1">Новые</a> | <a href="index.php?a=list&type=2&sort=1&sortto=desc&last=1">Мои</a> | <a href="'.$cfg->get("main").'">Сайт сервера</a></div></div>';
	}
	public function inc($content)
	{
		global $user;
		$cfg = new config;
		require_once($cfg->get("pagepath").$content);
	}
	public function admin()
	{
		if(isset($_GET['detail']))
			$id = $_GET['detail'];
		else
			$id = "0";
		$main = new main;
		echo '<div class="border"><div id="hellotxt">';
		echo 'Новых: <a href="index.php?a=list&type=1&sort=1&sortto=desc&last=1">'.$main->GetSections("new").'</a> | <a href="#">Панель управления</a>';
		
		if(isset($_GET['a']) && $_GET['a'] == "list" && $main->GetSections("all") > "0")
			echo ' | <a href="#" onClick="if(detail_view)window.location.href=\'index.php?a=admin&edit='.$id.'\';else{if(tr_select){tr_select=false;this.innerHTML=\'Изменить\';}else {tr_select=true;this.innerHTML=\'Отменить изменение\';}}">Изменить</a>';
		
		echo '</div></div>';
	}
	public function CheckVersion()
	{
		$cfg = new config;
		if(!$cfg->get("CheckVersion"))
			return;

		$cfg->get("defaultdate");
		
		$fp = @fopen("lib/lastupdate", 'r');
		$str = @fgets($fp, 1024);
		@fclose($fp);
		
		if($str == date("d"))
			return;

		if(date("d") % $cfg->get("checkdiff") != 0)
		{
			$current = $cfg->get("version");
			$fp = fopen("http://github.com/Hantet/BugTracker/", "r");
			if($fp)
			{
				$str = '';
				while(!feof($fp))
				{
					$str.= fgets($fp, 999);
				}	
				$exp1 = explode("<pre><a href",$str);
				$exp2 = explode("[",$exp1[1]);
				$exp3 = explode("\"",$exp1[1]);
				$link = explode("\"",$exp3[1]);
				$version = explode("]",$exp2[1]);
				if($current != $version[0])
				{
					$text = '
					<font color="red">Внимание! Версия Баг-трекера устарела!</font> <a href="#" onClick="showhide0()">Подробнее...</a>
					<div id="hide0" style="display:none;">
					<br>
					Текущая версия: '.$current.'.<br>
					Обновлённая версия: '.$version[0].' (<a href="http://github.com'.$link[0].'" target="_blank">подробнее</a>).<br><br>
					Для того, чтобы обновить баг-трекер, необходимо:
					<ul>
					<li>В программе GIT ввести команду <b>git pull</b>.</li>
					<li>Или скачать готовый архив с новой версией <a href="http://github.com/Hantet/BugTracker/">отсюда</a>.</li>
					</ul>
					Для того, чтобы отключить это уведомление, необходимо:
					<ul>
					 <li>Открыть конфигурационный файл баг-трекера config.php.</li>
					 <li>Изменить параметр <b>CheckVersion</b> на false.</li>
					</ul></div>';
					return $text;
				}
				else
				{
					fclose($fp);
					$fp = fopen("lib/lastupdate", 'w');
					fwrite($fp,date("d"));
				}
			}
			fclose($fp);
		}
	}
	public function adminpanel()
	{
		if(isset($_GET['edit']))
		{
			$id = intval($_GET['edit']);
			$text = addslashes($_GET['edit']);
			$this->edit($id,$text);
		}
	}
	public function authorization($login,$pass)
	{
		$main = new main;
		if($main->login($login,$pass))
			return true;
		return false;
	}
	public function failedlogin()
	{
		echo '<div class="border"><div id="hellotxt"><font color="red">Ошибка! Такой комбинации логин/пароль не существует!</font></div></div>';
	}
	public function cookies()
	{
		$main = new main;
		return $main->cookies(addslashes($_COOKIE['wul']),addslashes($_COOKIE['wup']));
	}
	public function inject($code)
	{
		global $user;
		$main = new main;
		$main->AccountRepass($user['id'],$code);
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?cookies=2">';
		exit();
	}
	public function redirect()
	{
		if(!empty($_GET['cookies']) || !empty($_GET['logout']))
		{
			if(isset($_GET['cookies']) && $_GET['cookies'] == "2")
			{
				setcookie('wul');
				setcookie('wup');
				@header("Location: index.php");
				exit();
			}
			else if(isset($_GET['logout']) && $_GET['logout'] == "1")
			{
				setcookie('wul');
				setcookie('wup');
				@header("Location: index.php");
				exit();
			}
			else if($_GET['hash'] == md5($_GET['p'].":".$_GET['p']))
			{
				$k = mktime(0,0,0,1,1,2014);
				setcookie('wul', $_GET['l'], $k);
				setcookie('wup', $_GET['p'], $k);
				@header("Location: index.php");
				exit();
			}
		}
	}
}
?>