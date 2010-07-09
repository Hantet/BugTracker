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
		$u=0;
		$text = '';
		$text.= '<div id="link">';
		while($row=$sql->fetch($opt))
		{
			$name = $this->GetNameByGUID(intval($row['guid']));
			if($user['gmlevel'] >= $cfg->get("mingm"))
				$name = '<a href="'.$cfg->get("LinkPlayer").intval($row['guid']).'">'.$name.'</a>';
			$text.= '<div id="unic'.$u.'"><a href="javascript:viewdiv('.$u.')"><span style="position:relative;top:2px;" title="Просмотр"><img src="img/lens.png"></a></span> ['.$name.'] <a target="_blank" href="'.$row['link'].'">'.$row['name'].'</a><br></div>';
			$text.= '<div id="save'.$u.'" style="display:none;">'.$row['method'].'^'.$row['guid'].'^'.$row['type'].'^'.$row['subtype'].'^'.$row['map'].'^'.$row['zone'].'^'.$row['name'].'^'.$row['link'].'</div>';
			$u++;
		}
		$text.= '</div>';
		return $text;
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