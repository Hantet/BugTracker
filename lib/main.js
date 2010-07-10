var tr_select = false;
var detail_view = false;

function addcomment(entry)
{
	var text = document.getElementById("comm_text").value;
	var name = document.getElementById("comm_player").options[document.getElementById("comm_player").selectedIndex].value;
	var nametxt = document.getElementById("comm_player").options[document.getElementById("comm_player").selectedIndex].text;
	var account = document.getElementById("userid").innerHTML;
	var query = "player="+name+"&text="+text+"&account="+account+"&entry="+entry;
	if(name == 0)
		alert('Необходимо выбрать персонажа!');
	else if(text == 'Текст сообщения')
		alert('Введите текст комментария!');
	else if(text.length < 50)
		alert('Текст сообщения должен быть не менее 50 символов!\nФлуд в комментариях запрещён!');
	else
	{
		$.ajax({
			type: "POST",
			data: query,
			url: "addcomment.php",
			cache: false,
			success: function(html){
				var old = document.getElementById("textarea2").innerHTML;
				document.getElementById("textarea2").innerHTML = '<div class="pad2">'+html+' ['+nametxt+']:<div class="pad2">'+text+'</div></div><hr>' + old;
			}
		});
	}
}

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

function searchresult(link,name)
{
	document.getElementById("searchview").style.display = "none";
	document.getElementById("name").value = '';
	var old = document.getElementById("links").innerHTML;
	var id = GetNewId("linkid_");
	document.getElementById("links").innerHTML = old + '<div id="linkid_'+id+'"><img src="img/trash.png" onClick="RemoveLink('+id+')" onMouseOver="this.style.cursor=\'pointer\';this.src=\'img/ontrash.png\'" onMouseOut="this.style.cursor=\'default\';this.src=\'img/trash.png\'"> <a href="'+link+'" target="_blank">'+name+'</a></div>';

	var list = document.getElementById("linkslist");
	var div = document.createElement("div");
	var mass = GetNewId("linkmass_");
	div.setAttribute("style", "display:none;");
	div.id = "linkmass_"+mass;
	div.innerHTML = link;
	list.appendChild(div);
}

function RemoveLink(id)
{
	var obj = document.getElementById("links");
	var one = document.getElementById("linkid_"+id);
	obj.removeChild(one);
	
	var main = document.getElementById("linkslist");
	var chld = document.getElementById("linkmass_"+id);
	main.removeChild(chld);
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
	$.ajax({
		type: "POST",
		data: "table="+type+"&string="+val,
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
	document.getElementById("checklogout").style.display = "";
}
function logoutcancel()
{
	document.getElementById("checklogout").style.display = "none";
	document.getElementById("userpanel").style.display = "";
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
function send(player,type,subtype,map,zone,title)
{
	var area1 = document.getElementById("area1").value;
	var area2 = document.getElementById("area2").value;
	var area3 = document.getElementById("area3").value;
	var userid = document.getElementById("userid").innerHTML;
	var i = 0;
	var diff = 0;
	var links = '';
	do
	{
		if(document.getElementById("linkmass_"+i))
		{
			links = links + "('ID_OF_REPORT','" + document.getElementById("linkmass_"+i).innerHTML + "'),";
			i++;
		}
		else if(diff < 5)
		{
			i++;
			diff++;
		}
		else
			break;
	}while(1);

	sql = player+"^"+type+"^"+subtype+"^"+map+"^"+zone+"^"+title;
	if(area1.length > 0 && area2.length > 0 && i > 0)
	{
		$.ajax({
			type: "POST",
			data: "a1="+area1+"&a2="+area2+"&a3="+area3+"&userid="+userid+"&sql="+sql+"&links="+links,
			url: "send.php",
			cache: false,
			success: function(html)
			{
				if(html.length > 0)
					alert("Ошибка! "+html);
				else
					window.location.href="index.php?a=list&sort=1&sortto=desc&last=1";
			}
		});
	}
	else
		alert('Необходимо заполнить два обязательных поля и добавить хотя бы одну ссылку!');
}

function next(id)
{
	document.getElementById("searchview").style.display = "none";
	var type = document.getElementById("type");
	var subtype = document.getElementById("subtype");
	var map = document.getElementById("map");
	var zone = document.getElementById("zone")
	var name = document.getElementById("name");
	switch(id)
	{
		case 1:
			var typeval = type.options[type.selectedIndex].value;
			if(typeval == 1)
			{
				subtype.removeAttribute("DISABLED");
				map.setAttribute("DISABLED", true);
				map.selectedIndex = 0;
				zone.setAttribute("DISABLED", true);
				zone.selectedIndex = 0;
				name.setAttribute("READONLY", true);
				name.value = '';
			}
			else
			{
				name.setAttribute("READONLY", true);
				name.value = '';
				subtype.setAttribute("DISABLED", true);
				subtype.selectedIndex = 0;
				map.setAttribute("DISABLED", true);
				zone.setAttribute("DISABLED", true);
				map.selectedIndex = 0;
				zone.selectedIndex = 0;

				if(typeval == 2 || typeval == 4 || typeval == 5)
				{
					map.removeAttribute("DISABLED");
				}
				else
				{
					name.removeAttribute("READONLY");
					name.focus();
				}
			}
			break;
		case 2:
			name.removeAttribute("READONLY");
			name.focus();
			break;
		case 3:
			ChangeZones(map.value);
			zone.removeAttribute("DISABLED");
			break;
		case 4:
			name.removeAttribute("READONLY");
			name.focus();
			break;
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

function tolink()
{
	var player = document.getElementById("player").options[document.getElementById("player").selectedIndex].value;
	var type = document.getElementById("type").options[document.getElementById("type").selectedIndex].value;
	var subtype = document.getElementById("subtype").options[document.getElementById("subtype").selectedIndex].value;
	var map = document.getElementById("map").options[document.getElementById("map").selectedIndex].value;
	var zone = document.getElementById("zone").options[document.getElementById("zone").selectedIndex].value;
	var title = document.getElementById("title").value;
	var links = document.getElementById("links")
	
	if(player == 0)
		alert('Необходимо выбрать персонажа!');
	else if(type == 0)
		alert('Необходимо выбрать тип!');
	else if(title.length == 0)
		alert('Необходимо ввести заголовок!');
	else if(links.innerHTML == "")
		alert('Необходимо добавить хотя бы одну ссылку!');
	else
		send(player,type,subtype,map,zone,title);
}