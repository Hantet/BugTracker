var tr_select = false;
var detail_view = false;
var m_viewdiv = 0;
var m_nowview = -1;

function GetSelectName(id)
{
	switch(id)
	{
		case 1: return "priority";
		case 2: return "type";
		case 3: return "subtype";
		case 4: return "status";
		default: return;
	}
}

function ViewImgOptions(id)
{
	for(var i=1;i<5;i++)
	{
		document.getElementById("img_"+i).style.display = "none";
		if(i != id)
			document.getElementById("tr"+i).style.display = "none";
	}

	var parent = document.getElementById(GetSelectName(id));
	var curval = parent.options[parent.selectedIndex].value;
	var curtext = parent.options[parent.selectedIndex].text;
	var current = document.getElementById("img_"+id);
	var select = document.getElementById("select_"+id);
	var enter = document.getElementById("enter_"+id);

	if(curval == "-1")
	{
		select.style.display = "none";
		document.getElementById("input_11").value = "Цвет";
		enter.style.display = "block";
		current.innerHTML = '<img title="Отменить" src="img/cancel.png" onClick="ViewCancel('+id+')" onMouseOver="this.src=\'img/oncancel.png\';this.style.cursor=\'pointer\'" onMouseOut="this.src=\'img/cancel.png\';this.style.cursor=\'default\'">';
		current.innerHTML += '<img title="Сохранить" src="img/add.png" onClick="SaveInput('+id+',-1,false)" onMouseOver="this.src=\'img/onadd.png\';this.style.cursor=\'pointer\'" onMouseOut="this.src=\'img/add.png\';this.style.cursor=\'default\'">';
		current.style.display = "block";
	}
	else if(curval > "0")
	{
		current.innerHTML = '<img title="Отменить" src="img/cancel.png" onClick="ViewCancel('+id+')" onMouseOver="this.src=\'img/oncancel.png\';this.style.cursor=\'pointer\'" onMouseOut="this.src=\'img/cancel.png\';this.style.cursor=\'default\'">';
		current.innerHTML += '<img title="Изменить" src="img/scissors.png" onClick="ViewInput('+id+')" onMouseOver="this.src=\'img/onscissors.png\';this.style.cursor=\'pointer\'" onMouseOut="this.src=\'img/scissors.png\';this.style.cursor=\'default\'">';
		current.innerHTML += '<img title="Удалить" src="img/trash.png" onclick=\'if(confirm("Вы точно хотите удалить приоритет «'+curtext+'»?\\n\\nЕсли продолжить, все отчёты с этим приоритетом будут автоматически изменены на более низкие по приоритету."))SaveInput('+id+','+curval+',true);\' onMouseOver=\'this.src="img/ontrash.png";this.style.cursor="pointer"\' onMouseOut=\'this.src="img/trash.png";this.style.cursor="default"\'>';
		current.style.display = "block";
	}
}

function GetColorPriorityById(position)
{
	var color = document.getElementById("PriorityColor").innerHTML.split('^');
	return color[position];
}

function ViewInput(id)
{
	var parent = document.getElementById(GetSelectName(id));
	var curtext = parent.options[parent.selectedIndex].text;
	var curid = parent.options[parent.selectedIndex].value;
	document.getElementById("input_"+id).value = curtext;
	var curimg = document.getElementById("img_"+id);
	curimg.innerHTML = '<img title="Отменить" src="img/cancel.png" onClick="ViewCancel('+id+')" onMouseOver="this.src=\'img/oncancel.png\';this.style.cursor=\'pointer\'" onMouseOut="this.src=\'img/cancel.png\';this.style.cursor=\'default\'">';
	curimg.innerHTML += '<img title="Сохранить" src="img/check_mark.png" onClick="SaveInput('+id+','+curid+',false)" onMouseOver="this.src=\'img/oncheck_mark.png\';this.style.cursor=\'pointer\'" onMouseOut="this.src=\'img/check_mark.png\';this.style.cursor=\'default\'">';
	curimg.innerHTML += '<img title="Удалить" src="img/trash.png" onclick=\'if(confirm("Вы точно хотите удалить приоритет «'+curtext+'»?\\n\\nЕсли продолжить, все отчёты с этим приоритетом будут автоматически изменены на более низкие по приоритету."))SaveInput('+id+','+curid+',true);\' onMouseOver=\'this.src="img/ontrash.png";this.style.cursor="pointer"\' onMouseOut=\'this.src="img/trash.png";this.style.cursor="default"\'>';
	if(id == 1)
	{
		var position = parent.selectedIndex - 2;
		document.getElementById("input_11").value = GetColorPriorityById(position);
	}
	document.getElementById("select_"+id).style.display = "none";
	document.getElementById("enter_"+id).style.display = "block";
}

function SaveInput(id,change,del)
{	
	var input1 = document.getElementById("input_"+id).value;
	var input2 = "-1";
	var href = "type="+id+"&input1="+input1;
	if(id == 1)
	{
		input2 = document.getElementById("input_11").value;
		href = "type="+id+"&input1="+input1+"&input2="+input2;
	}
	if(change != -1)
		href += "&change="+change;

	if(del)
		href += "&delete=1";

	if((input1 != "" && input1 != "Название" && input2 != "" && input2 != "Цвет") || del)
	{
		$.ajax({
			type: "POST",
			data: href,
			url: "addtype.php",
			cache: false,
			success: function(html)
			{
				if(html == 1)
					window.location.href = "index.php?a=admin";
				else
					alert(html);
			}
		});
	}
	else
		alert("Необходимо заполнить все поля!");
}

function ViewCancel(id)
{
	document.getElementById("enter_"+id).style.display = "none";
	document.getElementById("select_"+id).style.display = "block";
	document.getElementById("img_"+id).style.display = "none";
	document.getElementById("input_"+id).value = "Название";
	if(id == 1)
		document.getElementById("input_11").value = "Цвет";
	for(var i=1;i<5;i++)
	{
		document.getElementById(GetSelectName(id)).selectedIndex = 1;
		document.getElementById("tr"+i).style.display = "";
	}
}

function searchresult(id)
{
	var tmp = document.getElementById("type");
	var type = tmp.options[tmp.selectedIndex].value;
	var link;
	switch(type)
	{
		case "2":
			link = "http://ru.wowhead.com/quest=";
			break;
		case "3":
			link = "http://ru.wowhead.com/item=";
			break;
		case "4":
			link = "http://ru.wowhead.com/npc=";
			break;
		case "5":
			link = "http://ru.wowhead.com/object=";
			break;
		default:
			return;
	}
	document.getElementById("db").value = link+id;
	document.getElementById("searchview").style.display = "none"
}

function searchfor(val)
{
	if(val.length < 3)
	{
		document.getElementById("searchview").style.display = "none";
		return;
	}

	var tmp = document.getElementById("type");
	var type = tmp.options[tmp.selectedIndex].value;
	var table;
	switch(type)
	{
		case "2":
			table = "quest";
			break;
		case "3":
			table = "item";
			break;
		case "4":
			table = "npc";
			break;
		case "5":
			table = "object";
			break;
		default:
			return;
	}
	$.ajax({
		type: "POST",
		data: "table="+table+"&string="+val,
		url: "search.php",
		cache: false,
		success: function(html)
			{
				var exp = html.split('^');
				if(exp[0] == 0)
					document.getElementById("searchview").style.display = "none";
				else
				{
					document.getElementById("searchview").innerHTML = exp[1];
					document.getElementById("searchview").style.display = "block";
				}
			}
		});
}

function fastchangestatus(id)
{
	var list = document.getElementById("fastchange0");
	var selected = list.options[list.selectedIndex].value;
	window.location.href = "index.php?a=list&changeid="+id+"&faststatus="+selected+"&sort=1&sortto=desc&last=1";
}

function showhide0()
{
	if(document.getElementById("hide0").style.display == "none")
		document.getElementById("hide0").style.display = "block";
	else
	document.getElementById("hide0").style.display = "none";
}

function streamimg(m,pix)
{
	setTimeout(function()
	{
		document.getElementById("stream"+m).style.width = document.getElementById("stream"+m).offsetWidth + 1;
		if(document.getElementById("stream"+m).offsetWidth < pix)
		streamimg(m,pix);
	},20);
}

function saveset()
{
	var title = document.getElementById("name").value;
	var prioroty = document.getElementById("priority").options[document.getElementById("priority").selectedIndex].value;
	var status = document.getElementById("status").options[document.getElementById("status").selectedIndex].value;
	var progress = document.getElementById("progress").options[document.getElementById("progress").selectedIndex].value;
	var listid = document.getElementById("listid").innerHTML;
	var box = document.getElementById("delete");
	var todel = 0;

	if(title != "" || box.checked)
	{
		if(box.checked)
		{
			document.getElementById("spansave").innerHTML = "Удаление...";
			todel = 1;
		}
		else
			document.getElementById("spansave").innerHTML = "Сохранение...";

	$.ajax({
		type: "POST",
		data: "lis="+listid+"&del="+todel+"&tit="+title+"&pri="+prioroty+"&sta="+status+"&pro="+progress,
		url: "saveset.php",
		cache: false,
		success: function(html)
			{
				window.location.reload();
			}
		});
	}
	else
		alert('Необходимо заполнить поле "Заголовок"!');
}

function todelete(status)
{
	status == 1 ? document.getElementById("spansave").innerHTML = "Удалить" : document.getElementById("spansave").innerHTML = "Сохранить";
}

function showauth()
{
	document.getElementById("clickauth").style.display = "none";
	document.getElementById("placeauth").style.display = "block";
}
function checklogout()
{
	document.getElementById("userpanel").style.display = "none";
	document.getElementById("checklogout").style.display = "block";
}
function logoutcancel()
{
	document.getElementById("checklogout").style.display = "none";
	document.getElementById("userpanel").style.display = "block";
}
function ChangeZones(id)
{
	var zn = document.getElementById("zone");
	zn.length = 0;
	var param = map[id].split('*');
	var i=0;
	var opt;
	zn.options[zn.options.length] = new Option("--", "", true, true);
	zn.options[zn.options.length-1].setAttribute("DISABLED", true);

	do
	{
		opt = param[i].split('^');
		zn.options[zn.options.length] = new Option(opt[1], opt[0]);
		i++;
	}while(param[i]);
}
function send()
{
	var i=0;
	var sql = "";

	var area1 = document.getElementById("area1").value;
	var area2 = document.getElementById("area2").value;
	var area3 = document.getElementById("area3").value;
	var area4 = document.getElementById("area4").value;
	var area5 = document.getElementById("userid").innerHTML;

	while(document.getElementById("save"+i))
	{
		var list = document.getElementById("save"+i).innerHTML;
		var param = list.split('^');
		var player = document.getElementById("player");
		var map = document.getElementById("map");
		var method = param[0];
		var vplayer = player.options[param[1]].value;
		var vmap = map.options[param[4]].value;
		sql = sql + method+"^"+vplayer+"^"+param[2]+"^"+param[3]+"^"+vmap+"^"+param[5]+"^"+param[6]+"^"+param[7]+"*";
				//  method     player      type         subtype      map      zone         name         db;
		i++;
	}

	if(sql && (area4 != '' && area3 != '' && area2 != '' && area1 != ''))
	{
		document.getElementById("ajaximg").style.visibility = "visible";
		$.ajax({
			type: "POST",
			data: "a1="+area1+"&a2="+area2+"&a3="+area3+"&a4="+area4+"&a5="+area5+"&sql="+sql,
			url: "send.php",
			cache: false,
			success: function(html)
				{
					document.getElementById("ajaximg").style.visibility = "hidden";
					if(html != "1")
						alert("Ошибка! "+html);
					else
						window.location.href="index.php?a=list&sort=1&sortto=desc&last=1";
				}
		});
	}
	else
		alert('Необходимо заполнить все поля!');
}

function next(id)
{
	document.getElementById("searchview").style.display = "none";
	switch(id)
	{
		case 0:
			close("all");
			for(var i=2;i<6;i++)
				clear(i);
			document.getElementById("var1").style.display = "";
			break;

		case 1:
			for(var i=2;i<7;i++)
			{
				close(i);
				if(i<6)clear(i);
			}
			document.getElementById("var11").style.display = "none";
			document.getElementById("subtype").selectedIndex = 0;
			var val = document.getElementById("type").options[document.getElementById("type").selectedIndex].value;
			if(val == 2 || val == 4 || val == 5)
				open(2);
			else if(val == 1)
				document.getElementById("var11").style.display = "";
			else
				for(var i=4;i<7;i++)
					open(i);
			break;

		case 11:
			for(var i=4;i<7;i++)
			{
				if(i<6)clear(i);
				open(i);
			}
			break;
		
		case 2:
			for(var i=3;i<7;i++)
			{
				if(i<6)clear(i);
				close(i);
			}
			open(3);
			break;

		case 3:
			clear(4);
			clear(5);
			for(var i=4;i<7;i++)
				open(i);
			break;
	}
}

function open(t)
{
	if(t == "all" || t == 11)
		document.getElementById("var11").style.display = "";
	if(t == 11)
		return;
	for(var i=1;i<7;i++)
		if(t == (t == "all" ? t : i))
			document.getElementById("var"+i).style.display = "";
}

function close(t)
{
	for(var i=1;i<7;i++)
		if(t == (t == "all" ? t : i))
			document.getElementById("var"+i).style.display = "none";
	for(var i=11;i<12;i++)
		if(t == (t == "all" ? t : i))
			document.getElementById("var"+i).style.display = "none";
}

function clear(t)
{
	if(t == "all")
	{
		document.getElementById("player").selectedIndex = 0;
		document.getElementById("type").selectedIndex = 0;
		document.getElementById("subtype").selectedIndex = 0;
		document.getElementById("map").selectedIndex = 0;
		document.getElementById("zone").selectedIndex = 0;
		document.getElementById("name").value = "";
		document.getElementById("db").value = "";
	}
	else
	{
		if(t == 0)document.getElementById("player").selectedIndex = 0;
		if(t == 1)document.getElementById("type").selectedIndex = 0;
		if(t == 2)document.getElementById("map").selectedIndex = 0;
		if(t == 3)document.getElementById("zone").selectedIndex = 0;
		if(t == 4)document.getElementById("name").value = "";
		if(t == 5)document.getElementById("db").value = "";
		if(t == 11)document.getElementById("subtype").selectedIndex = 0;
	}
}

function GetNewId(name)
{
	var temp = 0;
	while(1)
	{
		if(document.getElementById(name+temp))
			temp++;
		else
			return temp;
	}
}

function savelist(method,player,type,subtype,map,zone,name,db)
{
	var tag = document.createElement("div");
	tag.id = "save"+GetNewId("save");
	tag.innerHTML = method+"^"+player+"^"+type+"^"+subtype+"^"+map+"^"+zone+"^"+name+"^"+db;
	document.getElementById("saveblock").appendChild(tag);
}

function tolink()
{
	if(m_viewdiv == 1)
	{
		document.getElementById("retype").innerHTML = "Добавить";
		m_viewdiv = 0;
		changestatus(2);
		clear("all");
		close("all");
	}
	else if(document.getElementById("name").value != '' && document.getElementById("db").value != '')
	{
		var selPlayer = document.getElementById("player");
		var selType = document.getElementById("type");
		var selName = document.getElementById("name");
		var selDb = document.getElementById("db");
		var map = -1;
		var zone = -1;
		var subtype = -1;
		var method;
		if(document.getElementById("var2").style.display != "none")
		{
			var selMap = document.getElementById("map");
			map = selMap.options[selMap.selectedIndex].text;
		}
		if(document.getElementById("var3").style.display != "none")
		{
			var selZone = document.getElementById("zone");
			zone = selZone.options[selZone.selectedIndex].value;
		}
		if(document.getElementById("var11").style.display != "none")
		{
			var sub = document.getElementById("subtype");
			subtype = sub.options[sub.selectedIndex].value;
		}
		var player = selPlayer.options[selPlayer.selectedIndex].text;
		var type = selType.options[selType.selectedIndex].value;
		var name = selName.value;
		var db = selDb.value;
		method = 1;
		if(type == 2 || type == 4 || type == 5)
		{
			if(map == -1 || zone == -1)
			{
				alert('Необходимо заполнить все поля!');
				return;
			}
			else
				method = 2;
		}
		else if(type == 1)
			method = 3;

		var pLink = document.getElementById("link").innerHTML;
		var newid = GetNewId("save");
		document.getElementById("link").innerHTML = pLink+"<div id='unic"+newid+"'><a href=\"javascript:removediv('"+newid+"')\"><span style=\"position:relative;top:2px;\" title=\"Удалить\"><img src=\"img/trash.png\"></a></span><a href=\"javascript:viewdiv('"+newid+"')\"><span style=\"position:relative;top:2px;\" title=\"Подробнее\"><img src=\"img/lens.png\"></a></span> ["+player+"]"+" <a target=\"_blank\" href=\""+db+"\">"+name+"</a><br></div>";
		if(method == 3)			
			savelist(3,selPlayer.selectedIndex,selType.selectedIndex,subtype,0,0,name,db);
		else if(method == 2)
			savelist(2,selPlayer.selectedIndex,selType.selectedIndex,0,selMap.selectedIndex,selZone.selectedIndex,name,db);
		else
			savelist(1,selPlayer.selectedIndex,selType.selectedIndex,0,0,0,name,db);
		clear("all");
		close("all");
	}
	else
	{
		alert('Необходимо заполнить все поля!');
	}
}

function removediv(u)
{
	var link = document.getElementById("link");
	var svbk = document.getElementById("saveblock");
	var unic = document.getElementById("unic"+u);
	var save = document.getElementById("save"+u);
	link.removeChild(unic);
	svbk.removeChild(save);
	if(u == m_nowview)
	{
		document.getElementById("retype").innerHTML = "Добавить";
		m_viewdiv = -1;
		changestatus(2);
		clear("all");
		close("all");
	}
}

function viewdiv(u)
{
	clear("all");
	close("all");
	var list = document.getElementById("save"+u).innerHTML;
	var param = list.split('^');
	m_viewdiv = 1;
	m_nowview = u;
	changestatus(1);
	if(param[0] == 3)
	{
		document.getElementById("player").selectedIndex = param[1];
		document.getElementById("type").selectedIndex = param[2];
		document.getElementById("subtype").selectedIndex = param[3];
		document.getElementById("name").value = param[6];
		document.getElementById("db").value = param[7];
		document.getElementById("retype").innerHTML = "Закрыть";
		open(0);
		open(1);
		open(11);
		open(4);
		open(5);
		open(6);
	}
	else if(param[0] == 2)
	{
		ChangeZones(param[3]);
		document.getElementById("player").selectedIndex = param[1];
		document.getElementById("type").selectedIndex = param[2];
		document.getElementById("map").selectedIndex = param[4];
		document.getElementById("zone").selectedIndex = param[5];
		document.getElementById("name").value = param[6];
		document.getElementById("db").value = param[7];
		document.getElementById("retype").innerHTML = "Закрыть";
		open("all");
	}
	else
	{
		document.getElementById("player").selectedIndex = param[1];
		document.getElementById("type").selectedIndex = param[2];
		document.getElementById("name").value = param[6];
		document.getElementById("db").value = param[7];
		document.getElementById("retype").innerHTML = "Закрыть";
		open(0);
		open(1);
		open(4);
		open(5);
		open(6);
	}
}

function changestatus(t)
{
	if(t == 1)
	{
		document.getElementById("player").disabled = true;
		document.getElementById("type").disabled = true;
		document.getElementById("subtype").disabled = true;
		document.getElementById("map").disabled = true;
		document.getElementById("zone").disabled = true;
		document.getElementById("name").readOnly = true;
		document.getElementById("db").readOnly = true;
	}
	else
	{
		document.getElementById("player").disabled = false;
		document.getElementById("type").disabled = false;
		document.getElementById("subtype").disabled = false;
		document.getElementById("map").disabled = false;
		document.getElementById("zone").disabled = false;
		document.getElementById("name").readOnly = false;
		document.getElementById("db").readOnly = false;
	}
}