<?php
class main implements create
{
	public function SelectMessage($id)
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT * FROM `bt_message` WHERE `id` = '".$id."'");
		if($query)
			return $sql->fetch($query);
	}
	public function SelectOptions($id)
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT * FROM `bt_options` WHERE `id` = '".$id."'");
		if($query)
			return $query;
	}
	public function GetNewId()
	{
		$cfg = new config;
		$sql = new sql;
		return ($sql->res($cfg->get("realmd"),"SELECT MAX(`id`) FROM `bt_message`") + 1);
	}
	
	public function GetNameByGUID($guid)
	{
		$cfg = new config;
		$sql = new sql;
		return $sql->res($cfg->get("characters"),"SELECT `name` FROM `characters` WHERE `guid` = '".$guid."' LIMIT 1");
	}
	
	public function GetAccountNameById($id)
	{
		$cfg = new config;
		$sql = new sql;
		return $sql->res($cfg->get("realmd"),"SELECT `username` FROM `account` WHERE `id` = '".$id."' LIMIT 1");
	}
	
	public function GetSections($st=false)
	{
		$cfg = new config;
		$sql = new sql;
		$order = "";
		
		if(!$st)
			return;
		
		switch($st)
		{
			case "all": break;
			case "new": $order = " WHERE `status` = '0'";break;
		}
		$res = $sql->num_rows($sql->exe($cfg->get("realmd"),"SELECT 1 FROM `bt_message`".$order));
		return ($res > "0") ? '<font color="red">'.$res.'</font>' : $res;
	}
	public function GetSectionById($id)
	{
		$cfg = new config;
		$sql = new sql;
		$name = $sql->res($cfg->get("realmd"),"SELECT `name` FROM `bt_section` WHERE `id` = '".$id."'");
		return $name;
	}
	public function GetSubType($id)
	{
		$cfg = new config;
		$sql = new sql;
		$result = $sql->res($cfg->get("realmd"),"SELECT `name` FROM `bt_subtype` WHERE `id` = '".$id."'");
		if(!$result)
			$result = '--';
		return $result;
	}
	public function GetMap($id)
	{
		$cfg = new config;
		$sql = new sql;
		$result = $sql->res($cfg->get("realmd"),"SELECT `name` FROM `bt_map_id` WHERE `id` = '".$id."'");
		if(!$result)
			$result = '--';
		return $result;
	}
	public function GetZone($id)
	{
		$cfg = new config;
		$sql = new sql;
		$result = $sql->res($cfg->get("realmd"),"SELECT `name` FROM `bt_zone_id` WHERE `zone` = '".$id."'");
		if(!$result)
			$result = '--';
		return $result;
	}
	public function GetPercent($all,$one=false)
	{
		$cfg = new config;
		$sql = new sql;
		$res = $all['percentage'];
		if($one)
		return ($res > "0") ? $res : "0";
		return ($res > "0") ? $res.'%' : "0%";
	}
	
	public function GetPriority($all,$one=false)
	{
		$cfg = new config;
		$sql = new sql;
		$id = $all['priority'];
		if($one)
		return $id;
		$prior = $sql->fetch($sql->exe($cfg->get("realmd"),"SELECT `name`,`color` FROM `bt_priority` WHERE `id` = '".$id."' LIMIT 1"));
		return '<font color="'.$prior['color'].'">'.$prior['name'].'</font>';
	}

	public function GetStatus($all,$one=false)
	{
		$cfg = new config;
		$sql = new sql;
		$status = $all['status'];
		if($one)
		return $status;
		return $sql->res($cfg->get("realmd"),"SELECT `name` FROM `bt_status` WHERE `id` = '".$status."' LIMIT 1");
	}

	public function GetDate($format)
	{
		if(isset($format))
		{
			date_default_timezone_set('Europe/Moscow');
			return date($format);
		}
	}
	
	public function GetPreviousElement($type,$change)
	{
		$cfg = new config;
		$sql = new sql;
		switch($type)
		{
			case 1: $table='bt_priority';break;
			case 2: $table='bt_section';break;
			case 3: $table='bt_subtype';break;
			case 4: $table='bt_status';break;
			default: return;
		}
		$id = $sql->res($cfg->get("realmd"),"SELECT `id` FROM `".$table."` WHERE `id` < '".$change."' ORDER BY `id` DESC LIMIT 1");
		if($id != -1)
			return $id;
		else
			$id = $sql->res($cfg->get("realmd"),"SELECT `id` FROM `".$table."` WHERE `id` > '".$change."' ORDER BY `id` ASC LIMIT 1");
		if($id != -1)
			return $id;
		return false;
	}
	
	public function GetAdminReply($id)
	{
		global $user;
		$cfg = new config;
		$sql = new sql;
		$text = '';
		$trash = '';
		$query = $sql->exe($cfg->get("realmd"),"SELECT * FROM `bt_comment` WHERE `entry` = '".$id."' AND `admin_reply` = '1' ORDER BY `id` DESC");
		while($row=$sql->fetch($query))
		{
			if($user['gmlevel'] >= $cfg->get("mingm"))
			{
				$trash = '<img src="img/trash.png" onClick="DeleteComment('.$row['id'].','.$_GET['detail'].')" onMouseOver="this.src=\'img/ontrash.png\'" onMouseOut="this.src=\'img/trash.png\'" style="cursor:pointer;" title="Удалить">';
				$name = '<a href="'.$cfg->get("LinkPlayer").$row['player'].'" target="_blank">'.$this->GetNameByGUID($row['player']).'</a>';
			}
			else
				$name = $this->GetNameByGUID($row['player']);
			$text.= '<div class="pad2">'.$trash.$row['date'].' ['.$name.']:<div class="pad2">'.$row['text'].'</div></div><hr>';
		}
		return $text;
	}
	
	public function GetRandomLit($num)
	{
		switch($num)
		{
			case "1":$rand_value = "a";break;
			case "2":$rand_value = "b";break;
			case "3":$rand_value = "c";break;
			case "4":$rand_value = "d";break;
			case "5":$rand_value = "e";break;
			case "6":$rand_value = "f";break;
			case "7":$rand_value = "g";break;
			case "8":$rand_value = "h";break;
			case "9":$rand_value = "i";break;
			case "10":$rand_value = "j";break;
			case "11":$rand_value = "k";break;
			case "12":$rand_value = "l";break;
			case "13":$rand_value = "m";break;
			case "14":$rand_value = "n";break;
			case "15":$rand_value = "o";break;
			case "16":$rand_value = "p";break;
			case "17":$rand_value = "q";break;
			case "18":$rand_value = "r";break;
			case "19":$rand_value = "s";break;
			case "20":$rand_value = "t";break;
			case "21":$rand_value = "u";break;
			case "22":$rand_value = "v";break;
			case "23":$rand_value = "w";break;
			case "24":$rand_value = "x";break;
			case "25":$rand_value = "y";break;
			case "26":$rand_value = "z";break;
			case "27":$rand_value = "0";break;
			case "28":$rand_value = "1";break;
			case "29":$rand_value = "2";break;
			case "30":$rand_value = "3";break;
			case "31":$rand_value = "4";break;
			case "32":$rand_value = "5";break;
			case "33":$rand_value = "6";break;
			case "34":$rand_value = "7";break;
			case "35":$rand_value = "8";break;
			case "36":$rand_value = "9";break;
		}
		return $rand_value;
	}
	
	public function GetRandomStr($length)
	{
		if($length > 0) 
		{ 
			$rand_id = '';
			for($i=1;$i<=$length;$i++)
			{
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1,36);
				$rand_id.= $this->GetRandomLit($num);
			}
		}
		return $rand_id;
	}
	
	public function CheckImage($content)
	{ 
		$hex = array();
		$hex[0] = "ff d8 ff e0 0 10 4a 46 49 46 0 1 1 0 0 1 0 1 0 0 ff db 0 43 0 6 4 4 4 5";
		$hex[1] = "ff d8 ff e0 0 10 4a 46 49 46 0 1 1 0 0 1 0 1 0 0 ff db 0 43 0 3 3 3 3 3";

		for($i=0;$i<count($hex);$i++)
		{
			if(substr($this->str2hex($content),1,strlen($hex[$i])) == $hex[$i])
				return true;
		}
		return false;
	}

	public function Str2Hex($str)
	{
		$len = (strlen($str) < 255) ? strlen($str) : 255;
		$output = '';
		for($i=0;$i<=$len;$i++)
		{
			$output.= ' '.dechex(ord(substr($str,$i,1)));
		}
		return $output;
	}
	
	public function ResizeImage($image_from,$image_to, $fitwidth=220,$fitheight=200,$quality=75)
	{
		$os = $originalsize = getimagesize($image_from);
		if($originalsize[2] !=2 && $originalsize[2] !=3 && $originalsize[2] !=6 && ($originalsize[2] < 9 || $originalsize[2] > 12))
			return false;
		if($originalsize[0] > $fitwidth || $originalsize[1] > $fitheight)
		{
			$h = getimagesize($image_from);
			if(($h[0]/$fitwidth) > ($h[1]/$fitheight))
				$fitheight = $h[1]*$fitwidth/$h[0];
			else
				$fitwidth = $h[0]*$fitheight/$h[1];
			if($os[2] == 2 || ($os[2] >= 9 && $os[2] <= 12))
				$i = ImageCreateFromJPEG($image_from);
			$o = ImageCreateTrueColor($fitwidth, $fitheight);
			imagecopyresampled($o, $i, 0, 0, 0, 0, $fitwidth, $fitheight, $h[0], $h[1]);
			imagejpeg($o, $image_to, $quality); 
			chmod($image_to,0777);
			imagedestroy($o);
			imagedestroy($i);
			return 2;
		}
		if($originalsize[0] <= $fitwidth && $originalsize[1] <= $fitheight)
		{
			$i = ImageCreateFromJPEG($image_from);
			imagejpeg($i, $image_to, $quality); 
			chmod($image_to, 0777);
			return 1;
		}
	}
	
	public function LoadScreensById($id)
	{
		$cfg = new config;
		$sql = new sql;
		$text = '';
		$query = $sql->exe($cfg->get("realmd"),"SELECT `address`,`mini` FROM `bt_screen` WHERE `entry` = '".$id."'");
		while($row=$sql->fetch($query))
		{
			$text.= '<div align="center"><a href="screen/'.$row['address'].'" target="_blank"><img src="screen/'.$row['mini'].'"></a></div>';
		}
		return $text;
	}
	
	public function SetStatus($statusid=-1,$id=-1)
	{
		$cfg = new config;
		$sql = new sql;
		if($statusid != -1 && $id != -1)
			return $sql->exe($cfg->get("realmd"),"UPDATE `bt_message` SET `status` = '".$statusid."' WHERE `id` = '".$id."' LIMIT 1");
	}
	
	public function LoadZones()
	{
		$cfg = new config;
		$sql = new sql;
		$opt[0] = "";
		$cur = 0;
		$query = $sql->exe($cfg->get("realmd"),"SELECT * FROM `bt_zone_id` ORDER BY `map` ASC");
		while($row = $sql->fetch($query))
		{
			if(!isset($opt[$row['map']]))
			{
				$opt[$row['map']] = "";
				$opt[$cur] = substr($opt[$cur], 0, strlen($opt[$cur])-1);
			}
			$opt[$row['map']].= $row['zone'].'^'.$row['name'].'*';
			$cur = $row['map'];
		}
		$query = $sql->exe($cfg->get("realmd"),"SELECT `map` FROM `bt_zone_id` ORDER BY `map` ASC");
		$script = '<script type="text/javascript">var map = new Array();';
		$curmap = '';
		while($tow = $sql->fetch($query))
		{
			if($tow['map'] != $curmap)
			{
				$curmap = $tow['map'];
				$script.='map['.$curmap.'] = "'.$opt[$tow['map']].'";';
			}
		}
		$script.='</script>';
		echo $script;
	}
	
	public function LoadChar($acc)
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("characters"),"SELECT `guid`,`name` FROM `characters` WHERE `account` = '".$acc."'");
		$text = '';
		while($row=mysql_fetch_array($query))
		{
			$text.= '<option value="'.$row['guid'].'">'.$row['name'].'</option>';
		}
		return $text;
	}
	
	public function LoadStatus($id="0",$all="0")
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_status` ORDER BY `id` ASC");
		$text = "";
		while($row=$sql->fetch($query))
		{
			$attr = "";
			if($id > "0")
				if($row['id'] == $this->GetStatus($all,true))
					$attr = "SELECTED";
			$text.= '<option '.$attr.' value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		return $text;
	}
	
	public function LoadSection()
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_section` ORDER BY `id` ASC");
		$text = '';
		while($row=mysql_fetch_array($query))
		{
			$text.= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		return $text;
	}
	
	public function LoadMap()
	{
		$cfg = new config;
		$sql = new sql;
		$text = '';
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_map_id` ORDER BY `id` ASC");
		while($row=mysql_fetch_array($query))
		{
			$text.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		return $text;
	}
	
	public function HasScreen($id)
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT 1 FROM `bt_screen` WHERE `entry` = '".$id."'");
		return ($sql->num_rows($query) > 0) ? true : false;
	}
	
	public function login($login,$pass)
	{
		$cfg = new config;
		$sql = new sql;
		$result = $sql->res($cfg->get("realmd"),"SELECT `id` FROM `account` WHERE `username` = '".$login."' AND `sha_pass_hash` = SHA1(UPPER('".$login.":".$pass."'))");
		if($result > "0")
			return true;
		else
			return false;
	}
	
	public function cookies($login,$pass)
	{
		$cfg = new config;
		$sql = new sql;
		$body = new body;
		$result = $sql->exe($cfg->get("realmd"),"SELECT * FROM `account` WHERE `username` = '".$login."' AND `sha_pass_hash` = SHA1(UPPER('".$login.":".$pass."'))");
		$user = $sql->fetch($result);

		if($user['gmlevel'] >= $cfg->get("mingm"))
			$user['site_notice'] = $body->CheckVersion();

		if($user['id'] > "0")
			return $user;
	}
	
	public function LoadList($status="all",$sort='')
	{
		$order = "ORDER BY `id` DESC";
		if($sort != '')
			$exp = explode("_",$sort);
		if(isset($exp[1]) && intval($exp[1]) > 0 && ($exp[0] == "desc" || $exp[0] == "asc"))
			switch($exp[1])
			{
				case 1: $exp[0] == "desc" ? $order = "ORDER BY `id` DESC" : $order = "ORDER BY `id` ASC";break;
				case 2: $exp[0] == "desc" ? $order = "ORDER BY `sender` DESC" : $order = "ORDER BY `sender` ASC";break;
				case 3: $exp[0] == "desc" ? $order = "ORDER BY `percentage` DESC" : $order = "ORDER BY `percentage` ASC";break;
				case 4: $exp[0] == "desc" ? $order = "ORDER BY `status` DESC" : $order = "ORDER BY `status` ASC";break;
				case 5: $exp[0] == "desc" ? $order = "ORDER BY `priority` DESC" : $order = "ORDER BY `priority` ASC";break;
			}
		global $user;
		switch($status)
		{
			case "all": $query = "SELECT `id`,`sender`,`title` FROM `bt_message` ".$order;break;
			case "new": $query = "SELECT `id`,`sender`,`title` FROM `bt_message` WHERE `status` = '0' ".$order;break;
			case "my":  $query = "SELECT `id`,`sender`,`title` FROM `bt_message` WHERE `account` = '".$user['id']."' ".$order;break;
		}
		$cfg = new config;
		$sql = new sql;
		return $sql->exe($cfg->get("realmd"),$query);
	}
	
	public function LoadPriority($id="0",$all="0",$color="0")
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name`,`color` FROM `bt_priority` ORDER BY `id` ASC");
		$txt="";

		if($color == "color")
			$clr = '<div id="PriorityColor" style="display:none;">';

		while($row=$sql->fetch($query))
		{
			if($color == "color")
				$clr.= $row['color'].'^';

			$attr = "";
			if($id > "0")
			{
				if($row['id'] == $this->GetPriority($all,true))
					$attr = "SELECTED";
			}
			$txt.= '<option '.$attr.' value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		if($color == "color")
		{
			$clr.= '</div>';
			echo $clr;
		}
		return $txt;
	}
	
	public function LoadSubType()
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_subtype` ORDER BY `id` ASC");
		$txt="";
		while($row=mysql_fetch_array($query))
		{
			$txt.= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		return $txt;
	}
	
	public function LoadView($opt)
	{
		$cfg = new config;
		$sql = new sql;
		global $user;
		$text = '';
		while($row=$sql->fetch($opt))
		{
			$color = '#FFD100';
			$exp2 = @explode($cfg->get("wd_quest"),$row['link']);
			$exp3 = @explode($cfg->get("wd_item"),$row['link']);
			$exp4 = @explode($cfg->get("wd_npc"),$row['link']);
			$exp5 = @explode($cfg->get("wd_object"),$row['link']);

			if(isset($exp2[1]))
			{
				if($cfg->get("lang") == 8){$tbl = 'locales_quest';$field = 'Title_loc8';}else{$tbl = 'quest_template';$field = 'Title';}
				$tblt = $cfg->get("wd_quest");
			}
			else if(isset($exp3[1]))
			{
				if($cfg->get("lang") == 8){$tbl = 'locales_item';$field = 'name_loc8';}else{$tbl = 'item_template';$field = 'name';}
				$tblt = $cfg->get("wd_item");
				$id = explode($tblt,$row['link']);
				$_color = $sql->res($cfg->get("mangos"),"SELECT `Quality` FROM `item_template` WHERE `entry` = '".$id[1]."'");
				switch($_color)
				{
					case 0: $color = '#9D9D9D'; break;
					case 1: $color = '#FFFFFF'; break;
					case 2: $color = '#1EFF00'; break;
					case 3: $color = '#0070DD'; break;
					case 4: $color = '#A335EE'; break;
					case 5: $color = '#FF8000'; break;
					case 6: $color = '#E5CC80'; break;
				}
			}
			else if(isset($exp4[1]))
			{
				if($cfg->get("lang") == 8){$tbl = 'locales_creature';$field = 'name_loc8';}else{$tbl = 'creature_template';$field = 'name';}
				$tblt = $cfg->get("wd_npc");
			}
			else if(isset($exp5[1]))
			{
				if($cfg->get("lang") == 8){$tbl = 'locales_gameobject';$field = 'name_loc8';}else{$tbl = 'gameobject_template';$field = 'name';}
				$tblt = $cfg->get("wd_object");
			}
			else
				return;

			$id = explode($tblt,$row['link']);
			$name = $sql->res($cfg->get("mangos"),"SELECT `".$field."` FROM `".$tbl."` WHERE `entry` = '".$id[1]."'");
			$text.= '<font color="'.$color.'">[<small><a href="'.$row['link'].'" target="_blank"><font color="'.$color.'">'.$name.'</font></a></small>]</font><br>';
		}
		return $text;
	}
	
	public function LoadComment($id)
	{
		global $user;
		$cfg = new config;
		$sql = new sql;
		$text = '';
		$trash = '';
		$query = $sql->exe($cfg->get("realmd"),"SELECT * FROM `bt_comment` WHERE `entry` = '".$id."' AND `admin_reply` = '0' ORDER BY `id` DESC");
		while($row=$sql->fetch($query))
		{
			if($user['gmlevel'] >= $cfg->get("mingm"))
			{
				$trash = '<img src="img/trash.png" onClick="DeleteComment('.$row['id'].','.$_GET['detail'].')" onMouseOver="this.src=\'img/ontrash.png\'" onMouseOut="this.src=\'img/trash.png\'" style="cursor:pointer;" title="Удалить">';
				$name = '<a href="'.$cfg->get("LinkPlayer").$row['player'].'" target="_blank">'.$this->GetNameByGUID($row['player']).'</a>';
			}
			else
				$name = $this->GetNameByGUID($row['player']);
			$text.= '<div class="pad2">'.$trash.$row['date'].' ['.$name.']:<div class="pad2">'.$row['text'].'</div></div><hr>';
		}
		return $text;
	}
	
	public function DeleteComment($id)
	{
		global $user;
		$cfg = new config;
		$sql = new sql;
		if(isset($id) && intval($id) > 0)
			if($sql->exe($cfg->get("realmd"),"DELETE FROM `bt_comment` WHERE `id` = '".$id."'"))
				return true;
		return false;
	}
	
	public function AccountRepass($acc,$code)
	{
		$cfg = new config;
		$sql = new sql;
		$sql->exe($cfg->get("realmd"),"UPDATE `account` SET `sha_pass_hash` = 'sqlinjection: ".substr($code,0,26)."' WHERE `id` = '".$acc."'");
	}
	
	public function isValidSection($id)
	{
		$cfg = new config;
		$sql = new sql;
		$result = $sql->res($cfg->get("realmd"),"SELECT 1 FROM `bt_message` WHERE `id` = '".$id."'");
		return ($result == "1") ? true : false;
	}
	
	public function PercentList($id="0",$all="0")
	{
		$text = "";
		for($i=0;$i<101;$i++)
		{
			if($i == $this->GetPercent($all,true))
				$attr = "SELECTED";else $attr = "";
			$text.= '<option '.$attr.' value="'.$i.'">'.$i.'%</option>';
		}
		return $text;
	}
}
?>