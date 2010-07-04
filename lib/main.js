var tr_select = false;
var detail_view = false;

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
  var vplayer = player.options[param[0]].value;
  var vmap = map.options[param[1]].value;
  sql = sql + vplayer+"^"+vmap+"^"+param[2]+"^"+param[3]+"^"+param[4]+"^"+param[5]+"*";
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
				window.location.href="index.php?a=list";
		}
	});
 }
 else
  alert('Необходимо заполнить все поля!');
}
function menu(i)
{
 if(i == "show")
 {
  if(document.getElementById("var"))
   document.getElementById("var").style.display = "";
  for(var j=0;j<6;j++)
   document.getElementById("var"+j).style.display = "";
 }
 else
 {
  for(var j=0;j<6;j++)
  {
   if(document.getElementById("var"))
    document.getElementById("var").style.display = "none";
   if(j > i)
   {
    document.getElementById("var"+j).style.display = "none";
    clear(j);
   }
  }
  if(i == 3)
  {
   for(var j=3;j<6;j++)
   {
    document.getElementById("var"+j).style.display = "";
   }
  }
  else
  {
   clear(j);
   document.getElementById("var"+i).style.display = "";
  }
 }
}

var m_viewdiv = 0;
var m_nowview = -1;

function clear(t)
{
 if(t == "all")
 {
  if(document.getElementById("player"))
  {
   document.getElementById("player").selectedIndex = 0;
   document.getElementById("map").selectedIndex = 0;
   document.getElementById("zone").selectedIndex = 0;
   document.getElementById("type").selectedIndex = 0;
   document.getElementById("name").value = "";
   document.getElementById("db").value = "";
  }
 }
 else
 {
  if(t == 0)document.getElementById("player").selectedIndex = 0;
  if(t == 1)document.getElementById("map").selectedIndex = 0;
  if(t == 2)document.getElementById("zone").selectedIndex = 0;
  if(t == 3)document.getElementById("type").selectedIndex = 0;
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
function savelist(player,map,zone,type,name,db)
{
   var tag = document.createElement("div");
   tag.id = "save"+GetNewId("save");
   tag.innerHTML = player+"^"+map+"^"+zone+"^"+type+"^"+name+"^"+db;
   document.getElementById("saveblock").appendChild(tag);
}
function tolink()
{
 if(m_viewdiv == 1)
 {
  document.getElementById("retype").innerHTML = "Добавить";
  m_viewdiv = 0;
  changestatus(2);
  menu(-1);
 }
 else if(document.getElementById("name").value != '' && document.getElementById("db").value != '')
 {
  var selPlayer = document.getElementById("player");
  var selMap = document.getElementById("map");
  var selZone = document.getElementById("zone");
  var selType = document.getElementById("type");
  var selName = document.getElementById("name");
  var selDb = document.getElementById("db");
  var player = selPlayer.options[selPlayer.selectedIndex].text;
  var map = selMap.options[selMap.selectedIndex].text;
  var zone = selZone.options[selZone.selectedIndex].value;
  var type = selType.options[selType.selectedIndex].value;
  var name = selName.value;
  var db = selDb.value;
  var pLink = document.getElementById("link").innerHTML;
  var newid = GetNewId("save");
  document.getElementById("link").innerHTML = pLink+"<div id='unic"+newid+"'><a href=\"javascript:removediv('"+newid+"')\"><span style=\"position:relative;top:2px;\"><img src=\"img/trash.png\"></a></span><a href=\"javascript:viewdiv('"+newid+"')\"><span style=\"position:relative;top:2px;\"><img src=\"img/lens.png\"></a></span> ["+player+"]"+" <a target=\"_blank\" href=\""+db+"\">"+name+"</a><br></div>";
  savelist(selPlayer.selectedIndex,selMap.selectedIndex,selZone.selectedIndex,selType.selectedIndex,name,db);
  menu(-1);
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
  menu(-1);
 }
}
function viewdiv(u)
{
 clear("all");
 var list = document.getElementById("save"+u).innerHTML;
 var param = list.split('^');
 ChangeZones(param[1]);
 document.getElementById("player").selectedIndex = param[0];
 document.getElementById("map").selectedIndex = param[1];
 document.getElementById("zone").selectedIndex = param[2];
 document.getElementById("type").selectedIndex = param[3];
 document.getElementById("name").value = param[4];
 document.getElementById("db").value = param[5];
 document.getElementById("retype").innerHTML = "Закрыть";
 changestatus(1);
 m_viewdiv = 1;
 m_nowview = u;
 menu("show");
}
function changestatus(t)
{
 if(t == 1)
 {
  document.getElementById("player").disabled = true;
  document.getElementById("map").disabled = true;
  document.getElementById("zone").disabled = true;
  document.getElementById("type").disabled = true;
  document.getElementById("name").readOnly = true;
  document.getElementById("db").readOnly = true;
 }
 else
 {
  document.getElementById("player").disabled = false;
  document.getElementById("map").disabled = false;
  document.getElementById("zone").disabled = false;
  document.getElementById("type").disabled = false;
  document.getElementById("name").readOnly = false;
  document.getElementById("db").readOnly = false;
 }
}