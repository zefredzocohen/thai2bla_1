function $aj(url,id,eval_str){
    if(document.getElementById){var x=(window.ActiveXObject)?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest();}
    if(x){x.onreadystatechange=function() {
        el=document.getElementById(id);
        el.innerHTML='Dang tai....';
        if(x.readyState==4&&x.status==200){
            el.innerHTML='';
            el=document.getElementById(id);
            el.innerHTML=x.responseText;
            if (eval_str) eval(eval_str);
            }
        }
    x.open("GET",url,true);x.send(null);
    }
}


function $aj2(url,id,id2,eval_str){
    if(document.getElementById){var x=(window.ActiveXObject)?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest();}
    if(x){x.onreadystatechange=function() {
        el=document.getElementById(id);
        el.innerHTML='Dang tai....';
        if(x.readyState==4&&x.status==200){
            el.innerHTML='';
            el=document.getElementById(id);
            el.innerHTML=x.responseText;
			document.getElementById(id2).innerHTML = "<font color='#00FF6A'><b>Xong</b></font>";
            if (eval_str) eval(eval_str);
            }
        }
    x.open("GET",url,true);x.send(null);
    }
}


function loadcc(key, id)
{
	$aj("showcc.php?key="+key,"t2cc_"+id);
}

function viewcc(id, key)
{
	$aj2("viewcc.php?id="+id+"&key="+key,"view2_"+id,"view_"+id);
}
function viewcc2(id, key)
{
	$aj2("viewcc.php?id="+id+"&key="+key,"view2_"+id,"view_"+id);
}