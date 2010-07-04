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
	
	public function GetNewSections()
	{
		$cfg = new config;
		$sql = new sql;
		$res = $sql->num_rows($sql->exe($cfg->get("realmd"),"SELECT 1 FROM `bt_message` WHERE `status` = '0'"));
		return ($res > "0") ? '<font color="red">'.$res.'</font>' : $res;
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
	
	public function LoadZones()
	{
		$cfg = new config;
		$sql = new sql;
		$opt[0] = "";
		$cur = 0;
		$query = $sql->exe($cfg->get("realmd"),"SELECT * FROM `bt_zone_id` ORDER BY `map` ASC");
		while($row = mysql_fetch_array($query))
		{
			if(!$opt[$row['map']])
			{
				$opt[$row['map']] = "";
				$opt[$cur] = substr($opt[$cur], 0, strlen($opt[$cur])-1);
			}
			$opt[$row['map']].= $row['zone'].'^'.$row['name'].'*';
			$cur = $row['map'];
		}
		$query = $sql->exe($cfg->get("realmd"),"SELECT `map` FROM `bt_zone_id` ORDER BY `map` ASC");
		echo '<script type="text/javascript">var map = new Array();';
		while($tow = mysql_fetch_array($query))
		{
			if($tow['map'] != $curmap)
			{
				$curmap = $tow['map'];
				echo 'map['.$curmap.'] = "'.$opt[$tow['map']].'";';
			}
		}
		echo '</script>';
	}
	
	public function LoadChar($acc)
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("characters"),"SELECT `guid`,`name` FROM `characters` WHERE `account` = '".$acc."'");
		while($row=mysql_fetch_array($query))
		{
			echo '<option value="'.$row['guid'].'">'.$row['name'].'</option>';
		}
	}
	
	public function LoadStatus($id="0",$all="0")
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_status` ORDER BY `id` ASC");
		$text = "";
		while($row=$sql->fetch($query))
		{
			if($id > "0")
			if($row['id'] == $this->GetStatus($all,true))
			$attr = "SELECTED";else $attr = "";
			$text.= '<option '.$attr.' value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		return $text;
	}
	
	public function LoadSection()
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_section` ORDER BY `id` ASC");
		while($row=mysql_fetch_array($query))
		{
			echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
	}
	
	public function LoadMap()
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_map_id` ORDER BY `id` ASC");
		while($row=mysql_fetch_array($query))
		{
			echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
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
		$result = $sql->exe($cfg->get("realmd"),"SELECT * FROM `account` WHERE `username` = '".$login."' AND `sha_pass_hash` = SHA1(UPPER('".$login.":".$pass."'))");
		$user = $sql->fetch($result);
		if($user['id'] > "0")
			return $user;
	}
	
	public function LoadList($status="all",$sort='')
	{
		$order = "ORDER BY `id` DESC";
		if($sort != '')
			$exp = explode("_",$sort);
		if(intval($exp[1]) > 0 && ($exp[0] == "desc" || $exp[0] == "asc"))
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
	
	public function LoadPriority($id="0",$all="0")
	{
		$cfg = new config;
		$sql = new sql;
		$query = $sql->exe($cfg->get("realmd"),"SELECT `id`,`name` FROM `bt_priority` ORDER BY `id` ASC");
		$txt="";
		while($row=mysql_fetch_array($query))
		{
			if($id > "0")
			{
				if($row['id'] == $this->GetPriority($all,true))
				{
					$attr = "SELECTED";
				}
				else
				{
					$attr = "";
				}
			}
			$txt.= '<option '.$attr.' value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		if($id > "0")
			return $txt;
		echo $txt;
	}
	
	public function LoadView($opt)
	{
		$cfg = new config;
		$sql = new sql;
		$u=0;
		echo '<div id="link">';
		while($row=$sql->fetch($opt))
		{
			echo '<div id="unic'.$u.'"><a href="javascript:viewdiv('.$u.')"><span style="position:relative;top:2px;"><img src="img/lens.png"></a></span> ['.$this->GetNameByGUID(intval($row['guid'])).'] <a target="_blank" href="'.$row['link'].'">'.$row['name'].'</a><br></div>';
			echo '<div id="save'.$u.'" style="display:none;">'.$row['guid'].'^'.$row['map'].'^'.$row['zone'].'^'.$row['type'].'^'.$row['name'].'^'.$row['link'].'</div>';
			$u++;
		}
		echo '</div>';
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