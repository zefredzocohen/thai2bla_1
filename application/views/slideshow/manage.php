<?php $this->load->view("partial/header"); ?>
<table id="contents">
  <tr>
      <div id="item_table">
        <div id="table_holder"> <?php echo $manage_table; ?> </div>
      </div>
      <div id="pagination"> <?php echo $pagination;?> </div></td>
  </tr>
</table>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
<style type="text/css">
 nav{
	position:relative;
 }
nav ul { 
    list-style: none; background: rgb(239, 243, 248); padding: 21px 37px; position: relative; 
    left: -10px;
-webkit-border-radius: 8px 0px 0px 8px;
}
nav ul li { display: inline; }
nav ul li a {
	display: block;
	float: left;
	border-top: 1px solid #96d1f8;
	background: #3e779d;
	background: -webkit-gradient(linear, left top, left bottom, from(#65a9d7), to(#3e779d));
	background: -moz-linear-gradient(top,  #65a9d7,  #3e779d);
	height: 17px;
	padding: 0 10px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	-webkit-box-shadow: rgba(0,0,0,1) 0 1px 3px;
	-moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	text-shadow: rgba(0,0,0,.4) 0 1px 0;
	-webkit-text-stroke: 1px transparent;
	font: bold 11px/16px "Lucida Grande", "Verdana", sans-serif;
	color: rgba(255,255,255,.85);
	text-decoration: none; 
	margin: -10px 9px 0 0;
}
nav ul li a:hover {
	cursor:pointer;
	border-top: 1px solid #4789b4;
	background: #28597a;
	background: -webkit-gradient(linear, left top, left bottom, from(#3d789f), to(#28597a));
	background: -moz-linear-gradient(top,  #3d789f,  #28597a);
	color: rgba(255,255,255,.85); 
}	
nav ul li a:active, nav ul li a.current {
	border-top-color: rgb(13, 64, 117);
	background: #1b435e;
	position: relative;
	top: 1px; 
}      
#menutest {
	width:400px;
    position:absolute;
    top:132px;
    left:1;
    right:0;
    background: rgb(239, 243, 248);
    border-radius:0 0 3px 3px;
    -moz-border-radius:0 0 3px 3px;
    border:1px solid #c7cbd3;
    border-top:0;
    border-bottom-color:#b3b7c0;
    box-shadow:0 1px 2px rgba(0,0,0,0.15);
    display:none;
    z-index:40000;
}

#menutest1 {
	width:400px;
    position:absolute;
    top:132px;
    left:1;
    right:0;
    background:#fff;
    border-radius:0 0 3px 3px;
    -moz-border-radius:0 0 3px 3px;
    border:1px solid #c7cbd3;
    border-top:0;
    border-bottom-color:#b3b7c0;
    box-shadow:0 1px 2px rgba(0,0,0,0.15);
    display:none;
    z-index:40000;
}

#menutest2 {
	width:400px;
    position:absolute;
    top:132px;
    left:1;
    right:0;
    background:#fff;
    border-radius:0 0 3px 3px;
    -moz-border-radius:0 0 3px 3px;
    border:1px solid #c7cbd3;
    border-top:0;
    border-bottom-color:#b3b7c0;
    box-shadow:0 1px 2px rgba(0,0,0,0.15);
    display:none;
    z-index:40000;
}

nav ul.group li span{
font-weight:bold;
-webkit-border-radius: 23px 23px 23px 23px;
width:23px;
height:23px;
position:absolute;
color:red;
text-shadow: 1px 1px 0 rgba(0, 0, 0, .2);
text-align: center;
font-size: 15px;
line-height: 27px;
top:-22px;
left:-25px;
}

input#start-date,input#end-date{
-webkit-border-radius: 4px 4px 4px 4px;
height:18px;
border:1px solid rgb(182, 170, 170);
width:92px;
box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .17), 0 1px 1px rgba(0, 0, 0, .2);
background:rgb(77, 119, 173);
}
input#findbirth{
	width:41px; border:1px solid rgb(58, 75, 111);
	background: rgb(71, 121, 250);
	height:31px;
	-webkit-border-radius: 4px 4px 4px 4px;
	text-align: center;
	line-height: 15px;
}
table.mytable{
	margin-bottom:60px;
}
table.mytable th{
	font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica,
	sans-serif;
	color: #6D929B;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	letter-spacing: 2px;
	text-transform: uppercase;
	text-align: left;
	padding: 6px 6px 6px 12px;
	background: #CAE8EA url(images/bg_header.jpg) no-repeat;
}
table.mytable td {
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #6D929B;
}
</style>
