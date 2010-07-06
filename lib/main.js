var tr_select = false;
var detail_view = false;
var m_viewdiv = 0;
var m_nowview = -1;

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
	document.getElementById("searchblock").style.display = "none";
	document.getElementById("searchview").style.display = "none"
}

function searchview()
{
	if(document.getElementById("searchview").style.display == "none")
	{
		document.getElementById("searchblock").style.display = "none";
		document.getElementById("searchview").style.display = "block";
	}
	else
	{
		document.getElementById("searchblock").style.display = "block";
		document.getElementById("searchview").style.display = "none";
	}
}

function searchfor(val)
{
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
				{
					document.getElementById("searchblock").style.display = "none";
					document.getElementById("searchview").style.display = "none";
				}
				else
				{
					document.getElementById("searchblock").innerHTML = exp[1];
					document.getElementById("searchview").innerHTML = exp[2];
					document.getElementById("searchblock").style.display = "block";
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
		var vmap = map.options[param[3]].value;
		sql = sql + method+"^"+vplayer+"^"+param[2]+"^"+vmap+"^"+param[4]+"^"+param[5]+"^"+param[6]+"*";
				//  method     player      type         map      zone         name         db;
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
	switch(id)
	{
		case 0:
			close("all");
			for(var i=2;i<6;i++)
				clear(i);
			document.getElementById("var1").style.display = "";
			break;

		case 1:
			var val = document.getElementById("type").options[document.getElementById("type").selectedIndex].value;
			if(val == 2 || val == 4 || val == 5)
			{
				for(var i=2;i<7;i++)
				{
					if(i<6)clear(i);
					close(i);
				}
				document.getElementById("var2").style.display = "";
			}
			else
			{
				document.getElementById("var2").style.display = "none";
				document.getElementById("var3").style.display = "none";
				for(var i=4;i<7;i++)
					document.getElementById("var"+i).style.display = "";
			}
			break;

		case 2:
			for(var i=3;i<7;i++)
			{
				if(i<6)clear(i);
				close(i);
			}
			document.getElementById("var3").style.display = "";
			break;

		case 3:
			for(var i=4;i<7;i++)
				document.getElementById("var"+i).style.display = "";
			break;
	}
}

function open(t)
{
	for(var i=1;i<7;i++)
		if(t == (t == "all" ? t : i))
			document.getElementById("var"+i).style.display = "";
}

function close(t)
{
	for(var i=1;i<7;i++)
		if(t == (t == "all" ? t : i))
			document.getElementById("var"+i).style.display = "none";
}

function clear(t)
{
	if(t == "all")
	{
		document.getElementById("player").selectedIndex = 0;
		document.getElementById("type").selectedIndex = 0;
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

function savelist(method,player,type,map,zone,name,db)
{
	var tag = document.createElement("div");
	tag.id = "save"+GetNewId("save");
	tag.innerHTML = method+"^"+player+"^"+type+"^"+map+"^"+zone+"^"+name+"^"+db;
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

		if(document.getElementById("var2").style.display != "none")
		{
			var selMap = document.getElementById("map");
			var map = selMap.options[selMap.selectedIndex].text;
		}
		if(document.getElementById("var3").style.display != "none")
		{
			var selZone = document.getElementById("zone");
			var zone = selZone.options[selZone.selectedIndex].value;
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
		var pLink = document.getElementById("link").innerHTML;
		var newid = GetNewId("save");
		document.getElementById("link").innerHTML = pLink+"<div id='unic"+newid+"'><a href=\"javascript:removediv('"+newid+"')\"><span style=\"position:relative;top:2px;\" title=\"Удалить\"><img src=\"img/trash.png\"></a></span><a href=\"javascript:viewdiv('"+newid+"')\"><span style=\"position:relative;top:2px;\" title=\"Подробнее\"><img src=\"img/lens.png\"></a></span> ["+player+"]"+" <a target=\"_blank\" href=\""+db+"\">"+name+"</a><br></div>";
		if(method == 2){
			savelist(2,selPlayer.selectedIndex,selType.selectedIndex,selMap.selectedIndex,selZone.selectedIndex,name,db);}
		else{
			savelist(1,selPlayer.selectedIndex,selType.selectedIndex,0,0,name,db);}
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
	if(param[0] == 2)
	{
		ChangeZones(param[2]);
		document.getElementById("player").selectedIndex = param[1];
		document.getElementById("type").selectedIndex = param[2];
		document.getElementById("map").selectedIndex = param[3];
		document.getElementById("zone").selectedIndex = param[4];
		document.getElementById("name").value = param[5];
		document.getElementById("db").value = param[6];
		document.getElementById("retype").innerHTML = "Закрыть";
		open("all");
	}
	else
	{
		document.getElementById("player").selectedIndex = param[1];
		document.getElementById("type").selectedIndex = param[2];
		document.getElementById("name").value = param[5];
		document.getElementById("db").value = param[6];
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
		document.getElementById("map").disabled = true;
		document.getElementById("zone").disabled = true;
		document.getElementById("name").readOnly = true;
		document.getElementById("db").readOnly = true;
	}
	else
	{
		document.getElementById("player").disabled = false;
		document.getElementById("type").disabled = false;
		document.getElementById("map").disabled = false;
		document.getElementById("zone").disabled = false;
		document.getElementById("name").readOnly = false;
		document.getElementById("db").readOnly = false;
	}
}