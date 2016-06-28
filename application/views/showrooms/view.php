<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!-- saved from url=(0053)http://livedemo00.template-help.com/prestashop_38171/ -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>guitarshop.vn</title>
	<meta name="description" content="Cửa hàng bán guitar uy tín Hà Nội">
	<meta name="keywords" content="shop guitar, ban guitar hà nội">
	<meta name="generator" content="GuitarShop">
	<meta name="robots" content="index,follow">

	<link href="<?php echo base_url(); ?>showroom/css/css.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>showroom/css/css(1).css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>showroom/css/global.css" rel="stylesheet" type="text/css" media="all">
	<script type="text/css" src="<?php echo base_url(); ?>showroom/js/jquery-1.10.1.min.js"></script>
</head>
<body id="index">
<!--[if lt IE 8]><div style='clear:both;height:59px;padding:0 15px 0 15px;position:relative;z-index:10000;text-align:center;'><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." /></a></div><![endif]-->
<div id="wrapper1">
<div id="wrapper2">
<div id="wrapper3">
 
	<div id="header" style="">
		<a id="header_logo" href="#" title="AudioGear">
			<?php echo img(array('src' => $this->Appconfig->get_logo_image())); ?>
		</a>
		<div id="header_right" style="border:1px solid red;">   
		
	<!--- gio hang -->
			<div id="header_user">
				<ul>
					<li id="header_user_info">
					Xin chào,
					(&nbsp;<a href="#"><?php echo $customer_info->first_name; ?></a>&nbsp;)
					</li>
					<li id="your_account"><a href="" title="Your Account">Tài khoản</a></li>
					<li id="shopping_cart">
						<a href="#" title="Your Shopping Cart">Giỏ hàng:</a>
						<span class="ajax_cart_quantity hidden" style="display: none;">0</span>
						<span class="ajax_cart_product_txt hidden" style="display: none;">product</span>
						<span class="ajax_cart_product_txt_s hidden" style="display: none;">products</span>
						<span class="ajax_cart_no_product">( rỗng )</span>
					</li>
				</ul>
			</div>	
		</div>
	</div>
<!---- phan than --->	
	<div id="columns">
<!-- Left -->
	<div id="left_column" class="column">
<!-- Block manufacturers module -->
		<div id="manufacturers_block_left" class="block blockmanufacturer">
			<h4><a href="#" title="Manufacturers">Nhóm sản phẩm</a></h4>
			
			<div class="block_content">
				<ul class="bullet">
				<?php $categories = $this->Category->get_all();
					if($categories != null) { foreach ($categories as $cat){
				?>
					<li class="item"><a href="#" title="More about Aadipisicing"><?php echo $cat['name']; ?></a></li>
				<?php } } ?>
				</ul>
			</div>
		</div>
	</div>
<!-- Center -->
		<div id="center_column" class="center_column">
<!-- MODULE Home Featured Products -->
<div id="featured_products">
	<h4>Sản phẩm hiện có</h4>
	<div class="block_content">
	<ul>
	<?php
		$products = $this->Item->item_info(1);
	foreach($products as $product){ ?>
		
		<li >
				<a class="product_image" href="#" title="Lorem ipsum dolor sit amet conse"><img src="<?php echo $this->Appconfig->get_logo_image(); ?>" alt="Lorem ipsum dolor sit amet conse"></a>
				<div>
					<h5><a class="product_link" href="#" title="Lorem ipsum dolor sit amet conse"><?php echo $product['name']; ?></a></h5>
					<span class="price"><?php echo $product['unit_price']; ?></span>
					<a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_1" href="" title="Add to cart">Add to cart</a>
				</div>
		</li>
	<?php } ?>
	</ul>
		
	</div>
</div>

		</div><!-- /MODULE Home Featured Products -->	
	
	
		<div class="clearblock"></div>
	</div>
</div>
<!-- Footer -->
	<div id="footer_wrapper">
		<div id="footer">

		<!-- /tmbannerblock2 --><!-- TMTextblock -->
		<div  style="float:left; margin-top:10px; margin-left:10px;" >
		<span class="txt1">Địa chỉ công ty:</span>
		<span class="txt2"><?php echo $this->config->item('address'); ?></span>
		</div>
		<!-- /TMTextblock -->
		
	<div style="float:right;" >
	<p>© 2013 Powered by <a href="http://www.pos.vn/">Pos.vn</a>™. All rights reserved</p>
	</div>




			<!-- [[%FOOTER_LINK]] -->		</div>
	</div>
</div>
</div>

</body></html>