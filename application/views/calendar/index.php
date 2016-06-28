<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN " "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<title><?php echo $this->config->item('company')?> - Dự án công việc</title>
	<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/metro.css?<?php  echo APPLICATION_VERSION; ?>" />

	<script src="<?php echo base_url()?>js/modernizr.custom.js?<?php  echo APPLICATION_VERSION; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.10.1.min.js" ></script>
	<script src="<?php echo base_url()?>js/gen.js"></script> 
	<script type="text/javascript" src="<?php echo base_url()?>metro/colorbox/jquery.colorbox.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>metro/colorbox/colorbox.js"></script>


	<?php
	foreach(get_css_files() as $css_file)
	{
	?>
		<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url().$css_file['path'].'?'.APPLICATION_VERSION;?>" media="<?php echo $css_file['media'];?>" />
	<?php
	}
	?>	
    
	<script type="text/javascript">
	var SITE_URL= "<?php echo site_url(); ?>";
	</script>
	<?php
	foreach(get_js_files() as $js_file)
	{
	?>
		<script src="<?php echo base_url().$js_file['path'].'?'.APPLICATION_VERSION;?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<?php
	}
	?>	
	<script type="text/javascript">
	Date.format = '<?php echo get_js_date_format(); ?>';
	$.ajaxSetup ({
		cache: false,
		headers: { "cache-control": "no-cache" }
	});
	</script>
</head>
<body onload="init();">
<!--<div id="flip" style="width:29px; margin: 0px auto; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
    <img src="<?php echo base_url();?>images/header/spriter.png" />
</div>
<div id="panel" style="border: none!important;"><?php $this->load->view('bieudo')?></div>-->

<div class="topheader">
  <div class="inner">
    <div class="topleftmenu">
    <table id="footer_info">
  <tr>
   <td id="menubar_date_time" class="menu_date">
    <?php
    if($this->config->item('time_format') == '24_hour')
    {
     echo date('H:i');     
    }
    else
    {
     echo date('h:i');
    }
    ?>
   </td>
   <td id="menubar_date_day" class="menu_date mini_date">
    <?php echo date('D') ?> 
    <br />
    <?php
    if($this->config->item('time_format') != '24_hour')
    {
     echo date('a');
    }
    ?>
   </td>
   <td id="menubar_date_spacer" class="menu_date">
    |
   </td>
   <td id="menubar_date_date" class="menu_date">
    <?php echo date('d') ?>
   </td>
   <td id="menubar_date_monthyr" class="menu_date mini_date">
    <?php echo date('F') ?>
    <br />
    <?php echo date('Y') ?>
   </td>
  </tr>
 </table>
    </div>
      <div class="toprightmenu">
	  <!--add warning-->
	  <a title="Lịch cá nhân" href="<?php echo base_url();?>calendar" rel="nofollow" id="hunght_calendar" class="hunght_calendar" style="width: 44px; padding-left: 0px; padding-right: 0px;"></a>
	  
	  <a title="Công nợ" href="#" onclick="return false;"  rel="nofollow" id="hunght_warning_debt" class="hunght_warning_debt" style="width: 44px; padding-left: 0px; padding-right: 0px;">
		  <?php if($suspends_date != null){ ?>
			<span>
				<div id="hunght_warning_debt" class="notifynumber"><?php echo count($suspends_date); ?></div>
		  </span>
		<?php } ?>  	  
	  </a>
	    
	  <a title="Khách hàng mới" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_customer" class="hunght_warning_customer" style="width: 44px; padding-left: 0px; padding-right: 0px;">
	   <?php if($register_date != null){ ?>
		  <span>
			<div  id="hunght_warning_customer" class="notifynumber"><?php echo count($register_date); ?></div>
		  </span>
		  <?php } ?>
	  </a> 
	    
	  <a title="Đơn hàng mới" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_orders" class="hunght_warning_orders" style="width: 44px; padding-left: 0px; padding-right: 0px;">
		  <?php if ($suspended_sales != null) { ?>
				<span>
				<div id="hunght_warning_orders" class="notifynumber"><?php echo count($suspended_sales); ?></div>
				</span>
			<?php } ?>
		  
	  </a> 
	  	  
	  <a title="Hợp đồng mới" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning" class="hunght_warning" style="width: 44px; padding-left: 0px; padding-right: 0px;">
		  <span>
			<div style="display:none"  id="vtlai_notifynumber" class="notifynumber">0</div>
		  </span>
	  </a>
	  
	  <a title="Giỏ hàng từ web" onclick="return false;"   href="#" rel="nofollow" id="hunght_web" class="hunght_web" style="width: 44px; padding-left: 0px; padding-right: 0px;">
		  <?php if ($payment_date!= null) { ?>
				<span>
			<div  id="hunght_web" class="notifynumber"><?php echo count($payment_date); ?></div>
		  </span>
			<?php } ?>
		  
	  </a>
	
	  <a title="Công việc cần phê duyệt" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_contract" class="hunght_warning_contract" style="width: 44px; padding-left: 0px; padding-right: 0px;">
                <?php if($warning_reports != null){ ?>
		  <span>
			<div id="hunght_warning_contract" class="notifynumber"><?php echo count($warning_reports); ?></div>
		  </span>
                <?php }?>
	  </a>
	  
	  <a title="Dự toán tài chính" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_profit" class="hunght_warning_profit" style="width: 44px; padding-left: 0px; padding-right: 0px;">
		  <span>
			<div style="display:none"  id="hunght_warning_profit" class="notifynumber">0</div>
		  </span>
	  </a>
	  
	  <a title="Hết hàng tồn kho" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_warehouse" class="hunght_warning_warehouse" style="width: 44px; padding-left: 0px; padding-right: 0px;">
		  <?php if($items != null){ ?>
				<span>
					<div id="hunght_warning_warehouse" class="notifynumber"><?php echo count($items); ?></div>
				</span>
			<?php } ?>		  
	  </a>
	    
	   <!--end add warning-->
    <div style="height:40px;line-height:35px;padding-left:10px;float:left;width:227px">

	<img class="avatar" src="<?php echo base_url() .'file/' .$person_info->image_face ?>" /> 
	<span >
     <?php echo lang('')." <b> $user_info->first_name $user_info->last_name</b>"; ?>
	 </span>
	 <a class="more" onclick="return false;"  href="#"></a>
	 
	 
	 	 <!--warning-->
	 <ul style="left: 1100px; display: none;" class="drop_warning_debt">
	  <?php 

					//$start_of_time =  date('Y-m-d', 0);

					//$today = date('Y-m-d');

					if ($suspends_date != null){

					$this->load->model('Customer');

					?>
				<li>
					<table class="mytable" cellspacing="0">
					  <thead>
					   <th>Tên</th>
					   <th>SĐT</th>
					   <th>Thành phố</th>
					   <th></th>
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
					   echo form_open('sales/unsuspend');
					   echo form_hidden('suspended_sale_id', $suspend_date['sale_id']);
					   ?>
					   <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
					   </form>
					   </td>
					   </tr>
					  <?php } ?>
					  </tbody>
					 </table>
				</li>
			<?php } else echo "<li>không có công nợ mới</li>"; ?>
		
	 </ul>
	 
 
	 <!--Cảnh báo khách hàng mới-->
			<ul style="left: 1100px; display: none;" class="drop_warning_customer">
                    <?php 
					//$start_of_time =  date('Y-m-d', 0);
					//$today = date('Y-m-d');
					if ($register_date != null){
					$this->load->model('Customer');
					// print_r($register_date);
					?>
					<li>					 
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
					</li>
					<?php } else echo "<li>không có khách hàng trong hôm nay</li>"; ?>
				</ul>

	  <ul style="left: 1100px; display: none;" class="drop_warning_orders">
	  <?php
		 if ($suspended_sales != null) { 
		$this->load->model('Customer');
	  ?>
	  <li>
	  <table  id="suspended_sales_table"  class="mytable">
				<tr>
					<th><?php echo lang('sales_suspended_sale_id'); ?></th>
					<th><?php echo lang('sales_date'); ?></th>
					<th><?php echo lang('sales_customer'); ?></th>
					<th><?php echo lang('sales_comments'); ?></th>
					<th><?php echo lang('sales_unsuspend'); ?></th>
					<th><?php echo lang('sales_receipt'); ?></th>
					<th>Báo giá</th>
					<th>Hợp đồng </th>
					<th>Hỏi hàng</th>
					<th><?php echo lang('common_delete'); ?></th>
				</tr>
				
				<?php
				foreach ($suspended_sales as $suspended_sale)
				{
				?>
					<tr>
						<td width="5%"><?php echo $suspended_sale['sale_id'];?></td>
						<td><?php echo date(get_date_format(),strtotime($suspended_sale['sale_time']));?></td>
						<td>
							<?php
							if (isset($suspended_sale['customer_id']))
							{
								$customer = $this->Customer->get_info($suspended_sale['customer_id']);
								echo $customer->first_name. ' '. $customer->last_name;
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						<td><?php echo $suspended_sale['comment'];?></td>
						<td>
							<?php 
							echo form_open('sales/unsuspend');
							echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
							?>
							<input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
							</form>
						</td>
						<td>
							<?php 
							echo form_open('sales/receipt/'.$suspended_sale['sale_id'], array('method'=>'get', 'id' => 'form_receipt_suspended_sale'));
							?>
							<input type="submit" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="submit_button float_right">
							
							</form>
						</td>
						<!-- phan lam -->
						<td width="13%">
							<?php 
							echo form_open('sales/baogia/'.$suspended_sale['sale_id'], array('method'=>'get', 'id' => 'form_baogia_suspended_sale'));
							?>
							<input type="radio" name="baogiabutton" value="1" checked >excel
							<input type="radio" name="baogiabutton" value="0">mail
							<input type="submit" name="submit" value="Báo giá" id="submit_receipt" class="submit_button float_right">
							
							</form>
						</td>
						<td width="13%">
							<?php 
							echo form_open('sales/contract/'.$suspended_sale['sale_id'], array('method'=>'get', 'id' => 'form_contract_suspended_sale'));
							?>
							<input type="radio" name="hopdongbutton" value="1" checked >excel
							<input type="radio" name="hopdongbutton" value="0">mail
							<input type="submit" name="submit" value="Hợp đồng" id="submit_receipt" class="submit_button float_right">
							</form>
						</td>
						<td>
							<?php 
							echo form_open('sales/hoihang/'.$suspended_sale['sale_id'], array('method'=>'get', 'id' => 'form_hoihang_suspended_sale'));
							?>
							<input type="submit" name="submit" value="Hỏi hàng" id="submit_receipt" class="submit_button float_right">
							
							</form>
						</td>
						<!-- end phan lam-->
						<td>
							<?php 
							echo form_open('sales/delete_suspended_sale', array('id' => 'form_delete_suspended_sale'));
							echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
							?>
							
							<input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
							</form>
						</td>
					</tr>
				<?php
				}
				?>
			</table>
			</li>
				<?php } else echo "<li>không có đơn hàng mới</li>"; ?>
	 </ul>
	 <ul style="left: 1100px; display: none;" class="drop_warning_contract">
		<li>không có hợp đồng mới</li>
	 </ul>
	
		
	 <ul style="left: 1100px; display: none;" class="drop_warning_web">
		<?php 
		
		if ($payment_date != null){
			$this->load->model('Customer');
		?>
	 <li>
		<table  id="suspended_sales_table" class="mytable">
				<tr>
					<th><?php echo lang('sales_suspended_sale_id'); ?></th>
					<th><?php echo lang('sales_date'); ?></th>
					<th><?php echo lang('sales_customer'); ?></th>
					<th><?php echo lang('sales_total'); ?></th>
					<th><?php echo lang('sales_unsuspend'); ?></th>
					<th><?php echo lang('sales_receipt'); ?></th>
				</tr>
				
				<?php
				foreach ($payment_date as $payment_dates)
				{
				?>
					<tr>
						<td><?php echo $payment_dates['order_id'];?></td>
						<td><?php echo date(get_date_format(),strtotime($payment_dates['order_date']));?></td>
						<td>
							<?php
							if (isset($payment_dates['customer_id']))
							{
								$customer = $this->Customer->omc_get_info($payment_dates['customer_id']);
								echo $customer->customer_first_name. ' '. $customer->customer_last_name;
							}
							else
							{
							?>
								&nbsp;
							<?php
							}
							?>
						</td>
						<td><?php echo $payment_dates['total'].' VNĐ';?></td>
						<td>
							<?php 
							echo form_open('sales/unsuspend_web');
							echo form_hidden('suspended_order_id', $payment_dates['order_id']);
							?>
                            <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/LIFETEK/POS2014/front-end/orders/control'?>" class="open-front-end" target="_blank">Mở lại</a>
							<?php /*?><input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right"><?php */?>
							</form>
						</td>
						<td>
							<?php 
							echo form_open('sales/receipt_web/'.$payment_dates['order_id'], array('method'=>'get', 'id' => 'form_receipt_suspended_sale'));
							?>
							<input type="submit" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="submit_button float_right">
							</form>
						</td>
                        
						
					</tr>
				<?php
				}
				?>
			</table>
			</li>
				<?php } else echo "<li>không có đơn hàng mới từ web</li>"; ?>
	 </ul>
	 
	 <script type="text/javascript">
		$(document).ready(function()
		{
			$("#form_delete_suspended_sale").submit(function()
			{
				if (!confirm(<?php echo json_encode(lang("sales_delete_confirmation")); ?>))
				{
					return false;
				}
			});
		});
</script>

	 <ul style="left: 1100px; display: none;" class="drop_warning_jobs">
		<li>không có công việc cần phê duyệt</li>
	 </ul>
	 
	 <ul style="left: 1100px; display: none;" class="drop_warning_jobs">		
		    <?php
                    if ($warning_reports != null){
			$this->load->model('Jobs_projects');
                    ?>
				<li>
					<table class="mytable" cellspacing="0">

						<thead>

							<th>Tên công việc</th>

							<th>Ngày giao</th>

							<th>Tiến độ</th>

						</thead>

						<tbody>
                                                 <?php foreach ($warning_reports as $warning_report){
                                                 $text = $this->Jobs_projects->get_info_task($warning_report['id'])->text; 
							?>

							<tr>
                                                            <td><a href="<?php echo base_url(); ?>jobs/"><?php echo mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');?></a></td>
							<td><?php echo $this->Jobs_projects->get_info_task($warning_report['id'])->start_date; ?></td>

							<td><?php echo $this->Jobs_projects->get_info_task($warning_report['id'])->progress *100; ?> %</td>

							</tr>

						<?php	} ?>

						</tbody>

					</table>
				</li>
					<?php } else echo "<li>Không có công việc mới được giao</li>"; ?>
	 </ul>
	 
	 <ul style="left: 1100px; display: none;" class="drop_warning_profit">
		<li>không có dự toán mới</li>
	 </ul>
	 
	 
	 <ul style="left: 1100px; display: none;" class="drop_warning_warehouse">
				
					<?php

                    if ($items != null){

					$this->load->model('Customer');

					?>
				<li>
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

							<td><a href="<?php echo base_url(); ?>items/switch_receving/<?php echo $item_info->item_id;  ?>"><?php echo $item_info->name; ?></a></td>

							<td><?php echo $item_info->quantity; ?></td>

							<td><?php echo $item_info->reorder_level; ?></td>

							</tr>

						<?php	} ?>

						</tbody>

					</table>
				</li>
					<?php } else echo "<li>Chưa có mặt hàng nào hết hàng</li>"; ?>
				</ul>
 
	 
	 <!--end warning-->
	 
	
	 <ul style="left: 1100px; display: none;" class="dropmore">
	  <li><a rel="nofollow" href="#loginform" class="username colorboxinline"> <span>Đổi mật khẩu</span> </a></li>
	  <!--<li><a href="#">Trang cá nhân</a></li>
	  <li><a href="#">Bản điều chỉnh cá nhân</a></li>-->
  <li> <?php
   if ($this->config->item('track_cash') && $this->Sale->is_register_log_open()) {
    echo anchor("sales/closeregister?continue=logout",lang("common_logout"));
   } else {
    echo anchor("home/logout",lang("common_logout"));
   }
   ?></li>
	</ul>
      <!--change pass form-->
<div id="loginform"> <form id="navbar_loginform" action="login.php?do=login" method="post" onsubmit="md5hash(vb_login_password, vb_login_md5password, vb_login_md5password_utf, 0)"> <div>
 <label for="navbar_username">Username:</label> 
 <input type="text" class="textbox default-value" name="vb_login_username" id="navbar_username" size="10" accesskey="u" tabindex="101" value="Tên tài khoản" /> 
 <label for="navbar_password">Password:</label> 
 <input type="password" class="textbox" tabindex="102" name="vb_login_password" id="navbar_password" size="10" /> 
 <input type="text" class="textbox default-value" tabindex="102" name="vb_login_password_hint" id="navbar_password_hint" size="10" value="Mật khẩu" style="display:none;" /> 
 </div> 
 <div id="remember" class="remember"> 
 <label for="cb_cookieuser_navbar">
 <input type="checkbox" name="cookieuser" value="1" id="cb_cookieuser_navbar" class="cb_cookieuser_navbar" checked accesskey="c" tabindex="103" /> Ghi nhớ?</label>
 </div>
 <div class="actionbutton"> 
 <input type="submit" class="loginbutton" tabindex="104" value="Ðăng nhập" title="Nhập username và mật khẩu đã cung cấp để đăng nhập, hoặc ấn vào 'đăng ký' để tao 1 tài khoản" accesskey="s" />
 <a href="login.php?do=lostpw" rel="nofollow" class="forgotbutton">Quên mật khẩu</a> 
 </div>
 <input type="hidden" name="s" value="" />
 <input type="hidden" name="securitytoken" value="guest" /> 
 <input type="hidden" name="do" value="login" /> 
 <input type="hidden" name="vb_login_md5password" />
 <input type="hidden" name="vb_login_md5password_utf" /> 
 </form> 
 </div> 
 <script type="text/javascript">
                                                                                                    YAHOO.util.Dom.setStyle('navbar_password_hint', "display", "inline");
                                                                                                    YAHOO.util.Dom.setStyle('navbar_password', "display", "none");
                                                                                                    vB_XHTML_Ready.subscribe(function () {
                                                                                                        //
                                                                                                        YAHOO.util.Event.on('navbar_username', "focus", navbar_username_focus);
                                                                                                        YAHOO.util.Event.on('navbar_username', "blur", navbar_username_blur);
                                                                                                        YAHOO.util.Event.on('navbar_password_hint', "focus", navbar_password_hint);
                                                                                                        YAHOO.util.Event.on('navbar_password', "blur", navbar_password);
                                                                                                    });

                                                                                                    function navbar_username_focus(e) {
                                                                                                        //
                                                                                                        var textbox = YAHOO.util.Event.getTarget(e);
                                                                                                        if (textbox.value == 'Tên tài khoản') {
                                                                                                            //
                                                                                                            textbox.value = '';
                                                                                                            textbox.style.color = '#000000';
                                                                                                        }
                                                                                                    }function navbar_username_blur(e) {
                                                                                                        //
                                                                                                        var textbox = YAHOO.util.Event.getTarget(e);
                                                                                                        if (textbox.value == '') {
                                                                                                            //
                                                                                                            textbox.value = 'Tên tài khoản';
                                                                                                            textbox.style.color = '#777777';
                                                                                                        }
                                                                                                    }function navbar_password_hint(e) {
                                                                                                        //
                                                                                                        var textbox = YAHOO.util.Event.getTarget(e);
                                                                                                        YAHOO.util.Dom.setStyle('navbar_password_hint', "display", "none");
                                                                                                        YAHOO.util.Dom.setStyle('navbar_password', "display", "inline");
                                                                                                        YAHOO.util.Dom.get('navbar_password').focus();
                                                                                                    }function navbar_password(e) {
                                                                                                        //
                                                                                                        var textbox = YAHOO.util.Event.getTarget(e);
                                                                                                        if (textbox.value == '') {
                                                                                                            YAHOO.util.Dom.setStyle('navbar_password_hint', "display", "inline");
                                                                                                            YAHOO.util.Dom.setStyle('navbar_password', "display", "none");
                                                                                                        }
                                                                                                    }
                                                                                                
                                                                                                </script>
<!--end form--> 
   
   </div>
  </div>
</div>  

</div>

<div class="metro-layout horizontal">
	<div class="header">
			<div class="control">
            <div style="width:1000px; margin:0 auto;height:100px">
            <div class="logo-customer">
				<a href="<?php echo site_url(); ?>">
					<?php echo img(
                    array(
                        'src' => $this->Appconfig->get_logo_image(),
						'width'=>'170',
						'height'=>'70',
                    )); ?>
                </a>
                </div>
                <div style=" float:right; width:830px; height:100px;">
                	<div class="last">
                        <span class="number">Hỗ trợ online</span>
                        <div style="height:50px;line-height:54px;width:780px;">
                         <?php 
				 		 $about = $this->About->get_about_header();	
						 foreach ($about as $row){ ?>
                        <span class="name"><?php echo $row['name_eployee'];?></span>
                        <span class="name">Tel: <?php echo $row['phone'];?> - Fax: <?php echo $row['fax'];?></span>
                        <span class="name">Email: <?php echo $row['email'];?></span>                        
                        <?php /*?><span class="name"><a target="_blank" href="<?php echo $row['website'];?>"><?php echo $row['website'];?></a></span>
                        <span class="name"><?php echo $row['address'];?></span><?php */?>
                        <span class="name" style="width: 80px">
                      		<label style="float: left;display: inline-block">Skype :</label> <a href="skype:<?php echo $row['skype'];?>?call"><img src="<?php echo base_url();?>images/support/skype.png" style="border: none;" width="32" height="32" alt="My status" /></a>
                        </span>
                        <span class="name" style="min-width: 140px">
							<label style="float: left;display: inline-block">Yahoo :</label><a href="ymsgr:sendIM?<?php echo $row['yahoo'];?>"><font size="2" face="Arial"><img style="width: 134px;height:25px;margin-top:13px" vspace="5" border="0" align="absmiddle" alt="Click để Chat với nhân viên hỗ trợ !" src="http://opi.yahoo.com/online?u=<?php echo $row['yahoo'];?>&amp;m=g&amp;t=2&amp;l=us" title="Click để Chat với nhân viên hỗ trợ!"></font></a>
						</span>
                     <?php }?>
                     </div>
       				</div>
                </div>
                </div>
                <div class="alert alert-success" style="display:none"><?php echo lang('common_welcome_message'); ?></div>
			</div>
		</div>

<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>calendar/codebase/dhtmlxscheduler.css" type="text/css" title="no title" charset="utf-8">
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_year_view.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_active_links.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_multiselect.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_map_view.js" type="text/javascript" charset="utf-8"></script>
<script src='<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_tooltip.js' type="text/javascript" charset="utf-8"></script>
<script src='<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
<script src='<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_treetimeline.js' type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_multiselect.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_quick_info.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_recurring.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo base_url(); ?>calendar/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css" media="screen">
    html, body{
        margin:0px;
        padding:0px;
        height:100%;
        
    }	
	.menu_date {
    color: #FFFFFF;
    font-size: 1.5em;
    text-align: center;
}
.mini_date {
    font-size: 0.55em;
}
    .dhx_multi_select_userselect input {
        vertical-align: middle;
    }
    .dhx_multi_select_fruitselect input {
        vertical-align: middle;
    }
</style>

<script type="text/javascript" charset="utf-8">
    function init() {

                        
                        scheduler.config.xml_date = "%Y-%m-%d %H:%i";
			scheduler.config.prevent_cache = true;

			

			scheduler.xy.map_date_width = 180; // date column width
			scheduler.xy.map_description_width = 400; // description column width

			// updating dates to display on before view change
			scheduler.attachEvent("onBeforeViewChange", function(old_mode, old_date, new_mode, new_date) {
				scheduler.config.map_start = scheduler.date.month_start(new Date((new_date || old_date).valueOf()));
				scheduler.config.map_end = scheduler.date.add(scheduler.config.map_start, 1, "month");
				return true;
			});

			// defining add function for prev/next arrows
			scheduler.date.add_map = function(date, inc) {
				return scheduler.date.add(date, inc, "month");
			};

			// defining date header
			var format = scheduler.date.date_to_str("%Y-%m-%d");
			scheduler.templates.map_date = function(start, end, mode) {
				return format(start) + " — " + format(end);
			};
                        
                        scheduler.locale.labels.map_tab = "Bản đồ";
			scheduler.locale.labels.section_location = "Địa điểm";
                        scheduler.locale.labels.section_userselect = "Tên";
                        //scheduler.locale.labels.section_description = "Name";
			// lightbox sections
			scheduler.config.lightbox.sections = [
				{ name: "description", height: 50, map_to: "text", type: "textarea", focus: true },
				{ name: "location", height: 43, map_to: "event_location", type: "textarea"  },
                { name:"userselect", height:70, map_to:"person_id", type:"multiselect", options: scheduler.serverList("person_id"), vertical:"true"  },
				{ name:"time", height:150, type:"calendar_time", map_to:"auto" }
			];

			scheduler.config.map_inital_zoom = 8;
                        scheduler.templates.event_text = function(start, end, event) {
			var result = event.text+"<br/>Users: ";
			
			var users=[];
			if (event.person_id){
				users = event.person_id.split(",");
				for (var i=0; i < users.length; i++)
					users[i] = scheduler.getLabel("person_id",users[i])
			}
			result += users.join(",");
			
			return result;
		};
			//scheduler.init('scheduler_here', Date("%Y,%m,%d"), "map");
			 scheduler.init('scheduler_here', new Date(2014, 1, 10), "map");
			scheduler.load("<?php echo base_url(); ?>calendar/common/events_map_view.php");
			var dp2 = new dataProcessor("<?php echo base_url(); ?>calendar/common/events_map_view.php");
			dp2.init(scheduler);

    }
    
</script>


    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
        <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>            
            <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
            <!--<div class="dhx_cal_tab" name="back_page" style="right:500px;" onclick="previousPage()"></div>-->
			<!--<button type="button" style="left:14px; right: auto;top: 14px; height: 31px; line-height: 25px; width: 70px;position: relative" onclick="previousPage()" class="dhx_cal_tab dhx_cal_tab_standalone">Quay lại</button>-->
            <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
            <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
            <div class="dhx_cal_tab" name="year_tab" style="left:280px !important;"></div>
            <div class="dhx_cal_tab" name="map_tab" style="right:280px;"></div>          
        </div>
        <div class="dhx_cal_header">
        </div>
        <div class="dhx_cal_data">
        </div>		
    </div>
</body>
<script type="text/javascript">
function previousPage(){
    window.history.back();
}
</script>