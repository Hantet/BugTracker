<?php
class sql implements database
{
	public function exe($db,$query)
	{
		if(mysql_select_db($db))
			if($result = mysql_query($query))
				return $result;
		return false;
	}
	public function res($db,$query)
	{
		$db = mysql_select_db($db);
		if($db)
		{
			$query = mysql_query($query);
			if($query)
			{
				$result = @mysql_result($query,0);
				if($result)
				{
					return $result;
				}
			}
		}
	}
	public function fetch($query)
	{
		if($query)
			return @mysql_fetch_array($query);
	}
	public function num_rows($query)
	{
		if($query)
			return @mysql_num_rows($query);
	}
}
?>