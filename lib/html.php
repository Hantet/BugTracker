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
		$text = '
		<table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
		 <tr>
		  <td width="365px" valign="top"><div class="pad">Сейчас так:</div>
		   <textarea class="textarea" id="area1" style="height:80px;"></textarea><div class="pad">А должно быть так:</div>
		   <textarea class="textarea" id="area2" style="height:80px;"></textarea><div class="pad">Пояснение:</div>
		   <textarea class="textarea" id="area3"></textarea>
		  </td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td width="236px" valign="top">
		   <table class="t2" border="0" cellpadding="0" cellspacing="0" align="center">
		    <tr>
		     <td class="block2">Персонаж:</td>
		     <td align="right"><select class="input" id="player"><option DISABLED SELECTED value="0"></option>'.$main->LoadChar($user['id']).'</select></td>
		    </tr>
		    <tr>
		     <td class="block2">Тип:</td>
		     <td align="right"><select class="input" onchange="next(1)" id="type"><option DISABLED SELECTED value="0"></option>'.$main->LoadSection().'</select></td>
		    </tr>
			<tr>
			 <td class="block2">Подтип:</td>
			 <td align="right"><select class="input" onchange="next(2)" id="subtype" DISABLED><option DISABLED SELECTED value="0"></option>'.$main->LoadSubType().'</select></td>
			</tr>
		    <tr>
		     <td class="block2">Местность:</td>
		     <td align="right"><select class="input" onchange="ChangeZones(this.options[this.selectedIndex].value);next(3)" id="map" DISABLED><option DISABLED SELECTED value="0"></option>'.$main->LoadMap().'</select></td>
		    </tr>
		    <tr>
		     <td class="block2">Зона: </td>
		     <td align="right"><select class="input" onchange="next(4)" id="zone" DISABLED><option DISABLED SELECTED value="0"></option></select></td>
		    </tr>
		    <tr>
			 <td class="block2">Заголовок:</td>
			 <td align="right"><input id="title" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text"></td>
			</tr>
		    <tr>
		     <td class="block2">Название:</td>
		     <td align="right"><input id="name" onKeyUp="searchfor(this.value)" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'" class="input" type="text" READONLY></td>
		    </tr>
		    <tr>
		     <td class="block2"></td>
		     <td align="right"><div class="butt" onClick="tolink()">Отправить</div></td>
		    </tr>
			<tr style="height:10px;"><td></td><td></td></tr>
			<tr style="height:1px;background-color: #000;"><td></td><td></td></tr>
			<tr style="height:5px;"><td></td><td></td></tr>
		   </table>
		   <div class="pad">Ссылки:<br><br>
		    <div id="links"></div>
		   </div>
		  </td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td valign="top">
		   <div id="searchview" style="display:none;"></div>
		  </td>
		 </tr>
		</table>
		<span id="userid" style="display:none;">'.$user['id'].'</span>
		<span id="linkslist" style="display:none;"></span>';
		$this->blocknot($text);
		}
	}
	public function viewall($all)
	{
		global $user;
		$cfg = new config;
		$main = new main;
		$title = $all['title'];
		$date = $all['date'];
		$priority = $main->GetPriority($all);

		$exp_date = explode("-",$date);
		$exp_space = explode(" ",$exp_date[2]);
		$exp_time = explode(":",$exp_space[1]);

		$year = $exp_date[0];
		$month = $exp_date[1];
		$day = $exp_space[0];
		
		$hours = $exp_time[0];
		$minute = $exp_time[1];
		$seconds = $exp_time[2];

		$text = '
		<table border="0" height="100%" cellpadding="0" cellspacing="0" align="left">
		 <tr>
		  <td><div class="pad">'.$day.'.'.$month.'.'.$year.'</div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad">'.$hours.':'.$minute.':'.$seconds.'</div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad">Приоритет: <b>'.$priority.'</b></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad">Название: <b>'.$title.'</b></div></td>
		 </tr>
		</table>';
		return $text;
	}
	public function progress($all)
	{
		$pcn = $all['percentage'];
		$pix = str_replace("%","",$pcn)*9.58;
		$text = '
		<table border="0" height="100%" cellpadding="0" cellspacing="0" align="left">
		 <tr>
		  <td><div class="pad"><div style="height:20px;width:'.$pix.'px;background-color:#006400;"></div></div></td>
		 </tr>
		</table>';
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
		$this->blocknot($this->viewall($all));
		$this->blocknot($this->progress($all));

		$area3 = '';
		if($all['text_3'])
			$area3 = '<div class="pad">Пояснение:</div><textarea class="textarea" id="area3" READONLY>'.$all['text_3'].'</textarea>';

		echo '<script>detail_view=true;</script>';
		$text = '
		<table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
		 <tr>
		  <td width="365px" valign="top"><div class="pad">Сейчас так:</div>
		   <textarea class="textarea" id="area1" style="height:80px;" READONLY>'.$all['text_1'].'</textarea><div class="pad">А должно быть так:</div>
		   <textarea class="textarea" id="area2" style="height:80px;" READONLY>'.$all['text_2'].'</textarea>'.$area3.'
		  </td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td width="236px" valign="top">
		   <table class="t2" border="0" cellpadding="0" cellspacing="0" align="center">
		    <tr>
		     <td class="block2">Персонаж:</td>
		     <td class="block3" align="right" id="player">'.$main->GetNameByGUID($all['sender']).'</td>
		    </tr>
		    <tr>
		     <td class="block2">Тип:</td>
		     <td class="block3" align="right" id="type">'.$main->GetSectionById($all['type']).'</td>
		    </tr>
			<tr>
			 <td class="block2">Подтип:</td>
			 <td class="block3" align="right" id="subtype">'.$main->GetSubType($all['subtype']).'</td>
			</tr>
		    <tr>
		     <td class="block2">Местность:</td>
		     <td class="block3" align="right" id="map">'.$main->GetMap($all['map']).'</td>
		    </tr>
		    <tr>
		     <td class="block2" valign="top">Зона: </td>
		     <td class="block3" align="right" id="zone">'.$main->GetZone($all['zone']).'</td>
		    </tr>
			<tr style="height:10px;"><td></td><td></td></tr>
			<tr style="height:1px;background-color: #000;"><td></td><td></td></tr>
			<tr style="height:5px;"><td></td><td></td></tr>
		   </table>
		   <div class="pad">Ссылки:<div align="right">'.$main->LoadView($opt,$all['type']).'</div></div>
		  </td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td valign="top" width="365px">
		   <div class="pad">Комментарии:</div>
		  </td>
		 </tr>
		</table>';
		$this->blocknot($text);
	}
	public function view()
	{
		global $user;
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
				2 => array("513px","Заголовок"),
				3 => array("120px","Отправитель"),
				4 => array("100px","Прогресс"),
				5 => array("100px","Статус"),
				6 => array("100px","Приоритет"));
				
			$text = '
			<table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
			 <tr>';
			for($i=1;$i<count($mass)+1;$i++)
				if(($i == 4 && $cfg->get("progressbar")) || $i != 4)
				{
					$text.= '<td style="width:'.$mass[$i][0].';background-color:#666;" onClick="window.location.href=\''.$href.'&sort='.$i.'&sortto='.$sortto.'&last='.$sort.'\';" onMouseover="this.style.cursor=\'pointer\';this.style.backgroundColor=\'#777\';" onMouseout="this.style.cursor=\'default\';this.style.backgroundColor=\'#666\';"><div class="pad"><b>'.$mass[$i][1].'</b></div></td>';
					if($i != count($mass))
						$text.= '<td width="1px" style="background-color: #000;"></td>';
				}
			$text.= '
			 </tr>
			</table>';
			$this->blocknot($text);
			$text = '<table width="100%" height="19px" border="0" cellpadding="0" cellspacing="0" align="left">';
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
				if($m > 0)
				{
					$text.= '
					<tr style="height:1px;background-color: #000;">
					 <td></td><td></td><td></td>
					 <td></td><td></td><td></td>
					 <td></td><td></td><td></td>';
				if($cfg->get("progressbar"))
					$text.= '
					 <td></td><td></td>';
				$text.= '
					</tr>';
				}
				
				$all = $main->SelectMessage($row['id']);
				$opt = $main->SelectOptions($row['id']);

				$title = $all['title'];
				$pcn = $main->GetPercent($all);
				$pix = str_replace("%","",$pcn);
				$stream = 'stream'.$row['id'];
				$width = ($cfg->get("anim") == true) ? 0 : $pix;
				$img = '<div id="stream'.$m.'" style="height:19px;width:'.$width.'px;background-color:#006400;"></div>';
			
				$text.= '
				<tr style="background-color: #666;" onClick="if(tr_select)window.location.href=\'index.php?a=admin&edit='.$row['id'].'\';else window.location.href=\'index.php?a=list&detail='.$row['id'].'\';" onMouseover="this.style.cursor=\'pointer\';this.style.backgroundColor=\'#888\';" onMouseout="this.style.cursor=\'default\';this.style.backgroundColor=\'#666\';">
				 <td width="'.$mass[1][0].'" class="view"><div class="pad">'.$row['id'].'</div></td>
				 <td width="1px" style="background-color: #000;"></td>
				 <td width="'.$mass[2][0].'" class="view"><div class="pad"><div id="namelimit1" title="'.$title.'"><div style="position:absolute;">'.$title.'</div></div></div></td>
				 <td width="1px" style="background-color: #000;"></td>
				 <td width="'.$mass[3][0].'" class="view"><div class="pad">'.$main->GetNameByGUID(intval($row['sender'])).'</div></td>
				 <td width="1px" style="background-color: #000;"></td>';
				if($cfg->get("progressbar"))
					$text.= '
				 <td width="'.$mass[4][0].'" class="view" style="padding:0;margin:0;">'.$img.'</td>
				 <td width="1px" style="background-color: #000;"></td>';
				$text.= '
				 <td width="'.$mass[5][0].'" class="view"><div class="pad">'.$main->GetStatus($all).'</div></td>
				 <td width="1px" style="background-color: #000;"></td>
				 <td width="'.$mass[6][0].'" class="view"><div class="pad">'.$main->GetPriority($all).'</div></td>
				</tr>';

				if($cfg->get("anim") && $pix > "0")
				{
					$js.= 'streamimg('.$m.','.$pix.');';
				}
				$m++;
			}
			$text.= '</table>';
			$text.= '<script>'.$js.'</script>';
			if($m > 1)
				$this->blocknot($text);
			else if($m > 0)
				$this->blocknot($text,'','','ultramini');
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
				if($cfg->get("LinkAccount"))$username = '<a href="'.$cfg->get("LinkAccount").$userid.'" target="_blank">'.$username.'</a>';

				$charguid = $all['sender'];
				$charname = $main->GetNameByGUID($charguid);
				if($cfg->get("LinkPlayer"))$charname = '<a href="'.$cfg->get("LinkPlayer").$charguid.'" target="_blank">'.$charname.'</a>';

				$text = '
				<table border="0" align="center" width="324" cellpadding="0" cellspacing="0">
				 <tr>
				  <td class="block" width="100" align="left">Заголовок:</td>
				  <td align="right"><input type="text" value="'.$all['title'].'" id="name" style="border:0px;width:100%;" onFocus="this.style.backgroundColor=\'#CCC\'" onBlur="this.style.backgroundColor=\'#FFF\'"></td>
				  <td width="88"></td>
			     </tr>
				 <tr>
				  <td class="block" align="left">Приоритет:</td>
				  <td align="right"><select class="input" id="priority" style="border:0px;width:100%;">'.$main->LoadPriority($id,$all).'</select></td>
				  <td></td>
				 </tr>
				 <tr>
				  <td class="block" align="left">Статус:</td>
				  <td align="right"><select class="input" id="status" style="border:0px;width:100%;">'.$main->LoadStatus($id,$all).'</select></td>
				  <td></td>
				 </tr>
				 <tr>
				  <td class="block" align="left">Прогресс:</td>
				  <td align="right"><select class="input" id="progress" style="border:0px;width:100%;">'.$main->PercentList($id,$all).'</select></td>
				  <td></td>
				 </tr>
				 <tr>
				  <td class="block" align="left">Удалить?</td>
				  <td align="right"><input type="checkbox" id="delete" onClick="if(this.checked)todelete(1);else todelete(2);"></td>
				  <td></td>
				 </tr>
				 <tr>
				  <td></td>
				  <td align="right"><div class="butt" onClick="saveset()" id="spansave">Сохранить</div><br></td>
				  <td></td>
				 </tr>
				 <tr>
				  <td class="block" align="left">Аккаунт:</td>
				  <td class="block" align="right">'.$username.'</td>
				  <td></td>
				 </tr>
				 <tr>
				  <td class="block" class="block" align="left">Персонаж:</td>
				  <td class="block" align="right">'.$charname.'</td>
				  <td></td>
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
	public function blocknot($text,$style='',$id='',$subclass='mini')
	{
		if($id)$id='id="'.$id.'"';
		echo '
		<table class="t0" '.$id.' cellpadding="0" cellspacing="0" align="center" style="'.$style.'">
		 <tr>
		  <td class="'.$subclass.'">'.$text.'</td>
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
		$txt1 = '
		   <table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
		    <tr>
		     <td><div class="pad">Здравствуйте, <b>'.$user['username'].'</b>!</div></td>
		     <td width="1px" style="background-color: #000;"></td>
		     <td><div class="pad"><a href="#" onClick="checklogout()">Выход</a></div></td>
		    </tr>
		   </table>';
	
		$txt2 = '
		   <table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
		    <tr>
		     <td><div class="pad">Точно выйти?</div></td>
		     <td width="1px" style="background-color: #000;"></td>
		     <td><div class="pad"><button onClick="window.location.href=\'index.php?logout=1\';">Да</button></div></td>
		     <td width="1px" style="background-color: #000;"></td>
		     <td><div class="pad"><button onClick="logoutcancel()">Отмена</button></div></td>
		    </tr>
		   </table>';

		$txt3 = '
		<table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
		 <tr>
		  <td><div class="pad"><a href="index.php?a=create">Создать</a></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad"><a href="index.php?a=list&sort=1&sortto=desc&last=1">Все</a></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad"><a href="index.php?a=list&type=1&sort=1&sortto=desc&last=1">Новые</a></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad"><a href="index.php?a=list&type=2&sort=1&sortto=desc&last=1">Мои</a></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad"><a href="'.$cfg->get("main").'">Сайт сервера</a></div></td>
		 </tr>
		</table>';
		
		$this->blocknot($txt1,"","userpanel");
		$this->blocknot($txt2,"display:none;","checklogout");
		$this->blocknot($txt3);
	}
	public function inc($content)
	{
		global $user;
		$cfg = new config;
		require_once($cfg->get("pagepath").$content);
	}
	public function admin()
	{
		$main = new main;
		if(isset($_GET['faststatus']) && 
		isset($_GET['changeid']) && 
		intval($_GET['changeid']) > 0)
			$main->SetStatus($_GET['faststatus'],$_GET['changeid']);

		if(isset($_GET['detail']))
		{
			$id = $_GET['detail'];
			$all = $main->SelectMessage($id);
		}
		else
			$id = "0";
		$text = '
		<table height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
		 <tr>';

		 if($id > "0")
			$text.= '
			<td><div class="pad">Быстрый ответ: <select id="fastchange0" onchange="fastchangestatus('.$all['id'].')">'.$main->LoadStatus(1,$all).'</select></td>
			<td width="1px" style="background-color: #000;"></td>
			<td><div class="pad"><a href="#">Расширенный ответ</a></div></td>
			<td width="1px" style="background-color: #000;"></td>';

		  $text.= '
		  <td><div class="pad">Новых: <a href="index.php?a=list&type=1&sort=1&sortto=desc&last=1">'.$main->GetSections("new").'</a></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad"><a href="index.php?a=admin">Управление БД</a></div></td>
		  <td width="1px" style="background-color: #000;"></td>
		  <td><div class="pad"><a href="index.php?a=admin&sort=1">Поиск и сортировка</a></div></td>';
		
		if(isset($_GET['a']) && $_GET['a'] == "list" && $main->GetSections("all") > "0")
			$text.= '
			<td width="1px" style="background-color: #000;"></td>
			<td><div class="pad"><a href="#" onClick="if(detail_view)window.location.href=\'index.php?a=admin&edit='.$id.'\';else{if(tr_select){tr_select=false;this.innerHTML=\'Изменить\';}else {tr_select=true;this.innerHTML=\'Отменить изменение\';}}">Изменить</a></div></td>';
		
		$text.= '</tr></table>';
		$this->blocknot($text);
	}
	public function CheckVersion()
	{
		$main = new main;
		$cfg = new config;
		if(!$cfg->get("CheckVersion"))
			return;
		
		$created = true;
		$fp = @fopen("lib/lastupdate", 'r');
		if(!$fp)
			$created = false;
		$str = @fgets($fp, 1024);
		@fclose($fp);
		
		if($str == $main->GetDate("d"))
			return;

		if($main->GetDate("d") % $cfg->get("checkdiff") != 0 || !$created)
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
					fwrite($fp,$main->GetDate("d"));
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
		else
		{
			$this->adminconfig();
		}
	}
	public function adminconfig()
	{
		global $user;
		$cfg = new config;
		$main = new main;
				$text = '
				<table border="0" align="center" width="324" cellpadding="0" cellspacing="0">
				 <tr id="tr1">
				  <td class="block" width="100" align="left" valign="top">Приоритет:</td>
				  <td width="136px">
				   <div id="select_1">
				    <select class="input" id="priority" onchange="ViewImgOptions(1)" style="border:0px;width:100%;">
				     <option value="-1">Добавить</option>
				     <option DISABLED SELECTED>--</option>'.$main->LoadPriority(0,0,"color").'
				    </select>
				   </div>
				   <div id="enter_1" style="display:none;">
					<input id="input_1" type="text" value="Название" style="width:100%;" onFocus="if(this.value==\'Название\')this.value=\'\';" onBlur="if(this.value==\'\')this.value=\'Название\';"><br>
					<input id="input_11" type="text" value="Цвет" style="width:100%;" onFocus="if(this.value==\'Цвет\')this.value=\'\';" onBlur="if(this.value==\'\')this.value=\'Цвет\';">
				   </div>
				   </td>
				  <td align="left" width="88" valign="top"><div style="display:none;" id="img_1"></div></td>
				 </tr>
				 <tr id="tr2">
				  <td class="block" width="100" align="left">Тип:</td>
				  <td align="right">
				   <div id="select_2">
				    <select class="input" id="type" onchange="ViewImgOptions(2)" style="border:0px;width:100%;">
				     <option value="-1">Добавить</option>
				     <option DISABLED SELECTED>--</option>'.$main->LoadSection().'
				    </select>
				   </div>
				   <div id="enter_2" style="display:none;">
					<input id="input_2" type="text" value="Название" style="width:100%;" onFocus="if(this.value==\'Название\')this.value=\'\';" onBlur="if(this.value==\'\')this.value=\'Название\';">
				   </div>
				  </td>
				  <td align="left" width="88" valign="top"><div style="display:none;" id="img_2"></div></td>
				 </tr>
				 <tr id="tr3">
				  <td class="block" width="100" align="left">Подтип:</td>
				  <td align="right">
				   <div id="select_3">
				    <select class="input" id="subtype" onchange="ViewImgOptions(3)" style="border:0px;width:100%;">
				     <option value="-1">Добавить</option>
				     <option DISABLED SELECTED>--</option>'.$main->LoadSubType().'
				    </select>
				   </div>
				   <div id="enter_3" style="display:none;">
					<input id="input_3" type="text" value="Название" style="width:100%;" onFocus="if(this.value==\'Название\')this.value=\'\';" onBlur="if(this.value==\'\')this.value=\'Название\';">
				   </div>
				  </td>
				  <td align="left" width="88" valign="top"><div style="display:none;" id="img_3"></div></td>
				 </tr>
				 <tr id="tr4">
				  <td class="block" width="100" align="left">Статус:</td>
				  <td align="right">
				   <div id="select_4">
				    <select class="input" id="status" onchange="ViewImgOptions(4)" style="border:0px;width:100%;">
				     <option value="-1">Добавить</option>
				     <option DISABLED SELECTED>--</option>'.$main->LoadStatus().'
				    </select>
				   </div>
				   <div id="enter_4" style="display:none;">
					<input id="input_4" type="text" value="Название" style="width:100%;" onFocus="if(this.value==\'Название\')this.value=\'\';" onBlur="if(this.value==\'\')this.value=\'Название\';">
				   </div>
				  </td>
				  <td align="left" width="88" valign="top"><div style="display:none;" id="img_4"></div></td>
				 </tr>
				</table>';

				$this->block($text);
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
		echo '<div class="border"><div id="hellotxt">Ошибка! Такой комбинации логин/пароль не существует!</div></div>';
	}
	public function cookies()
	{
		$main = new main;
		return $main->cookies(addslashes($_COOKIE['wul']),addslashes($_COOKIE['wup']));
	}
	public function install()
	{
		$main = new main;
		$this->block('Здравствуйте!<br><br>Для работы баг-трекера требуется создать несколько таблиц в базе данных.<br><a href="install.php">Начать установку!</a>');
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