<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function()
{
	var table_columns = ["","id",'name','description','value',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_bulk_edit(<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_cleanup(<?php echo json_encode(lang("salaryconfig_confirm_cleanup"));?>);

   	<!-- phan lam -->
	var button = $('#button');
    var menu = $('#menutest');
    
    $('ul li a', menu).each(function() {
        $(this).append('<span />');
    });
    
    button.toggle(function(e) {
        e.preventDefault();
        menu.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
	
	
	
	var button1 = $('#button1');
    var menu1 = $('#menutest1');
    
    $('ul li a', menu1).each(function() {
        $(this).append('<span />');
    });
    
    button1.toggle(function(e) {
        e.preventDefault();
        menu1.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu1.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
	
	
	var button2 = $('#button2');
    var menu2 = $('#menutest2');
    
    $('ul li a', menu1).each(function() {
        $(this).append('<span />');
    });
    
    button2.toggle(function(e) {
        e.preventDefault();
        menu2.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu2.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
	<!---end thong bao -->
});
<!-- phan lam -->
function post_item_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.item_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.item_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.item_id);
				set_feedback(response.message,'success_message',false);
			});
		}
	}
}
<!-- end phan lam -->
function post_bulk_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		set_feedback(response.message,'success_message',false);
		setTimeout(function(){window.location.reload();}, 2500);
	}
}

function select_inv(){
	
	 if (confirm(<?php echo json_encode("This applies to all the items in the inventory"); ?>))
    	{
			$('#select_inventory').val(1);
			$('#selectall').css('display','none');
			$('#selectnone').css('display','block');
			$.post('<?php echo site_url("salaryconfig/select_inventory");?>', {select_inventory: $('#select_inventory').val()});
		}
		
	}
	function select_inv_none(){
	
			$('#select_inventory').val(0);
			$('#selectnone').css('display','none');
			$('#selectall').css('display','block');
			$.post('<?php echo site_url("salaryconfig/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});
			
	}
	


</script>

<table id="title_bar_new">
  <tr>
    <td id="title_icon"><img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /></td>
    <td id="title"><?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?></td>
    <td id="title_search_new" style="width:519px;">
	<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
        <input style="margin-left: 257px;" type="text" name ='search' id='search'/>
      <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
      </form></td>
  </tr>
</table>
<table id="contents">
  <tr>
    <td id="commands"><div id="new_button">
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo 
					anchor("$controller_name/view/-1/width~$form_width",
					lang($controller_name.'_new'),
					array('class'=>'thickbox none new', 
						'title'=>lang($controller_name.'_new')));
				?>
        <?php } ?>
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo 
					anchor("$controller_name/delete",
					lang("common_delete"),
					array('id'=>'delete', 
						'class'=>'delete_inactive')); 
				?>
        <?php } ?>
      </div></td>
    <td style="width:10px;"></td>
    <td ><?php if($total_rows > $per_page) { ?>
      <center>
        <div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer"> <?php echo lang('items_all1').' <b>'.$per_page.'</b> '.lang('items_select_inventory1').' <b style="text-decoration:underline">'.$total_rows.'</b> '.lang('items_select_inventory_total1'); ?></div>
        <div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer"> <?php echo '<b>'.$total_rows.'</b> '.lang('items_selected_inventory_total1').' '.lang('items_select_inventory_none'); ?></div>
      </center>
      <?php 
		}
		echo form_input(array(
		'name'=>'select_inventory',
		'id'=>'select_inventory',
		'style'=>'display:none',
		)		
	); ?>
      <div id="item_table">
        <div id="table_holder"> <?php echo $manage_table; ?> </div>
      </div>
      <div id="pagination"> <?php echo $pagination;?> </div></td>
  </tr>
</table>
<div id="feedback_bar"></div>
</div></div>
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
	background: #CAE8EA url('images/bg_header.jpg') no-repeat;
}
table.mytable td {
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #6D929B;
}
</style>
