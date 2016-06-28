<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
	var table_columns = ['','last_name','first_name','email','phone_number','birth_date'];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
	$('.date-pick').datePicker()
	$('#start-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
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
    
    var button4 = $('#button4');
    var menu4 = $('#menutest4');
    
    $('ul li a', menu4).each(function() {
        $(this).append('<span />');
    });
    
    button4.toggle(function(e) {
        e.preventDefault();
        menu4.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu4.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
	
	var button5 = $('#button5');
    var menu5 = $('#menutest5');
    
    $('ul li a', menu5).each(function() {
        $(this).append('<span />');
    });
    
    button5.toggle(function(e) {
        e.preventDefault();
        menu5.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu5.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
	<!-- end phan lam -->
	
	<!-- phan lam mua hang -->
	$('#shoping_customer').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('customers_must_select_for_shopping')); ?>);
    		return false;
    	}
		if (selected.length > 1)
    	{
    		alert(<?php echo json_encode(lang('customers_must_select_1_for_shopping')); ?>);
    		return false;
    	}
		// alert(selected);
    	 $(this).attr('href','<?php echo site_url("customers/shopping");?>/'+selected);
    });
	<!-- end phanlam mua hang -->
}); 


function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>
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
    top:45px;
    left:0;
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
    top:45px;
    left:0;
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
    top:45px;
    left:0;
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
	overflow:scroll;
	height:500px;
}

#menutest4 {
	width:400px;
    position:absolute;
    top:45px;
    left:0;
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

#menutest5 {
	width:400px;
    position:absolute;
    top:45px;
    left:0;
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
<?php if ($controller_name == 'customers'){?>
<div style="margin-top: -30px; float: right; margin-right: -20px;">
		<nav>
		      <ul class="group">
		      	
					<?php 
					$this->load->model('sale');
					$date_pay = null ;
					 // $this->Customer->find_customer_payment()
					?>
					<li style="position:relative;"><a id="button5">Nợ</a>
					<?php if($suspends_date != null){ ?>
					<span id="spankhn" class="kh"><?php echo count($suspends_date); ?></span> </li>
					<?php } ?>
					
		      	  <li style="position:relative;"><a id="button4">Khách hàng mới</a>
				  <?php if($register_date != null){ ?>
				  <span id="spankh" class="kh"><?php echo count($register_date); ?></span> </li>
				  <?php } ?>
		          <li style="position:relative;"><a id="button">Sinh nhật</a>
				  <?php if ($customer != null) { ?>
				  <span id="spansn"><?php echo count($customer); ?></span> </li>
				  <?php } ?>
		          <li style="position:relative;"><a class="thickbox none"
				  href="<?php echo base_url(); ?>salestraining/suspended/width~600"
				  >Đơn hàng</a> 
				  <?php if ($suspended_sales != null) { ?>
				  <span id="spansn"><?php echo count($suspended_sales); ?></span> </li>
				  <?php } ?>
				  </li>
		          <li style="position:relative;"><a id="button2" >Hết hàng</a>
				  <?php if($items != null){ ?>
				  <span  ><?php echo count($items); ?></span>
				  <?php } ?>
				  </li>
		      </ul>
			  
			  <div id="menutest">
                    <?php 
					$start_of_time =  date('d-m-Y', 0);
					$today = date('d-m-Y');
					if ($customer != null){
					$this->load->model('Customer');
					?>
					<table class="mytable" cellspacing="0">
						<thead>
							<th>Tên</th>
							<th>Birth_date</th>
						</thead>
						<tbody>
							<?php foreach ($customer as $customer1){
						$customer2=$this->Customer->findPerson($customer1['person_id']);
							?>
							<tr>
							<td><a href="<?php echo site_url('reports/specific_'.( 'customer').'/'.$start_of_time.'/'.$today.'/'.$customer2[0]['person_id'].'/all/0') ?>"><?php echo $customer2[0]['first_name']; ?></a></td>
							<td><?php echo $customer2[0]['birth_date']; ?></td>
							</tr>
						<?php	} ?>
						</tbody>
					</table>
					<?php } else echo "không có ai sinh nhật trong tháng này"; ?>
				</div>
				
				<div id="menutest4">
                    <?php 
					//$start_of_time =  date('d-m-Y', 0);
					//$today = date('d-m-Y');
					if ($register_date != null){
					$this->load->model('Customer');
					// print_r($register_date);
					?>
					<table class="mytable" cellspacing="0">
						<thead>
							<th>Tên</th>
							<th>SĐT</th>
							<th>Thành phố</th>
						</thead>
						<tbody>
							<?php foreach ($register_date as $register_dates){
							?>
							<tr>
							<td><a href="<?php echo site_url('reports/specific_'.( 'customer').'/'.$start_of_time.'/'.$today.'/'.$register_dates['person_id'].'/all/0') ?>"><?php echo $register_dates['first_name'] ?></a></td>
							<td><?php echo $register_dates['phone_number']; ?></td>
							<?php 
							$this->load->model('customer');
							$name_city = $this->Customer->get_city($register_dates['city']);
							 ?>
							<td><?php echo $name_city[0]['name']; ?></td>
							</tr>
						<?php	} ?>
						</tbody>
					</table>
					<?php } else echo "không có khách hàng trong hôm nay"; ?>
				</div>
				
				<div id="menutest5">
                    <?php 
					//$start_of_time =  date('d-m-Y', 0);
					//$today = date('d-m-Y');
					if ($register_date != null){
					$this->load->model('Customer');
					?>
					<table class="mytable" cellspacing="0">
						<thead>
							<th>Tên</th>
							<th>SĐT</th>
							<th>Thành phố</th>
						</thead>
						<tbody>
							<?php foreach ($suspends_date as $suspend_date){
							?>
							<tr>
							<td>
							<a href="<?php echo site_url('reports/specific_'.( 'customer').'/'.$start_of_time.'/'.$today.'/'.$suspend_date['customer_id'].'/all/0') ?>">
							<?php 
							if($suspend_date['customer_id'] != null){
							echo $this->Customer->get_info($suspend_date['customer_id'])->first_name; 
							}else echo "Khách hàng ko tên";
							?>
							</a>
							</td>
							<td><?php echo $this->Customer->get_info($suspend_date['customer_id'])->phone_number; ?></td>
							<?php 
							$this->load->model('customer');
							$name_city = $this->Customer->get_city($this->Customer->get_info($suspend_date['customer_id'])->city);
							 ?>
							<td><?php echo $name_city[0]['name']; ?></td>
							<td>
							<?php 
							echo form_open('salestraining/unsuspend');
							echo form_hidden('suspended_sale_id', $suspend_date['sale_id']);
							?>
							<input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
							</form>
							</td>
							</tr>
						<?php	} ?>
						</tbody>
					</table>
					<?php } else echo "không có khách hàng trong hôm nay"; ?>
				</div>
				
				<div id="menutest2">
					<?php
                    if ($items != null){
					$this->load->model('Customer');
					?>
					<table class="mytable" cellspacing="0">
						<thead>
							<th>Tên</th>
							<th>Số lượng</th>
							<th>Mức ngưỡng</th>
						</thead>
						<tbody>
							<?php for ($i=0;$i< count($items);$i++){
						$item_info=$this->Item->get_info($items[$i]);
							?>
							<tr>
							<td><?php echo $item_info->name; ?></td>
							<td><?php echo $item_info->quantity; ?></td>
							<td><?php echo $item_info->reorder_level; ?></td>
							
							</tr>
						<?php	} ?>
						</tbody>
					</table>
					<?php } else echo "Chưa có mặt hàng nào hết hàng"; ?>
				</div>
		  </nav>
		  
		  

</div>
<?php } ?>
<table id="title_bar">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
		</td>
		<td id="title">
			<?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?>
		</td>

		<td id="title_search">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
				
				<input type="text" name ='search' id='search'/>
				<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
	
			</form>
		</td>
	</tr>
</table>

<table id="contents">
	<tr>
		<td id="commands">
			<div id="new_button">
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/view/-1/width~$form_width",
					$this->lang->line($controller_name.'_new'),
						array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));
				}	
				?>
				<!-- phan lam -->
				<?php
				if ($controller_name == 'customers' ) {	
				if ($this->sale_lib->get_customer() == -1){
					echo anchor("$controller_name/shopping",
					lang('customers_shopping'),
					array('class'=>'none','id'=>'shoping_customer'));
				}
				else {
					echo anchor("$controller_name",
					lang('customers_shopping_exits'),
					array('class'=>'none','id'=>'shoping_customer'));
				}
				}
				?>
				
				<style type="text/css">
				#shoping_customer{background-position: -10px -130px;}
				</style>
				<!-- end phan lam -->
				
				<?php
				if ($controller_name == 'customers' ) {	
					echo anchor("$controller_name/excel_export",
					lang('common_excel_export'),
					array('class'=>'none import'));
					
			     // echo anchor("$controller_name/excel_import_update/width~$form_width",
					// lang('common_excel_import_update'),
					// array('class'=>'thickbox none import',
						// 'title'=>lang('customers_import_customers_from_excel')));
			
				}
				
				?>
				
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/delete",$this->lang->line("common_delete"),array('id'=>'delete', 'class'=>'delete_inactive')); ?>
				<?php } ?>
				
				<?php if ($controller_name =='customers') {?>
					<?php echo 
						anchor("$controller_name/cleanup",
						lang("customers_cleanup_old_customers"),
						array('id'=>'cleanup', 
							'class'=>'cleanup')); 
					?>
				<?php } ?>

			</div>
		</td>
		<td style="width:10px;"></td>
<td>
 <div id="item_table">
			<div id="table_holder">
			<?php echo $manage_table; ?>
			</div>
			</div>
			<div id="pagination">
				<?php echo $pagination;?>
			</div>
		</td>
	</tr>
</table>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>