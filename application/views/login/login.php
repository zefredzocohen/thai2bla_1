<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php  echo base_url();?>favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/login.css?<?php  echo APPLICATION_VERSION; ?>" />
<link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/skin.css?<?php  echo APPLICATION_VERSION; ?>" />
<link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/bootstrap.min.css?<?php  echo APPLICATION_VERSION; ?>" />
<script type="text/javascript" src="<?php  echo base_url();?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();?>js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php  echo base_url();?>js/alert.js"></script>
<script type="text/javascript" src="<?php  echo base_url();?>js/bootstrap.js"></script>
<script type="text/javascript">

function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};


jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 3,
        wrap: 'last',
        initCallback: mycarousel_initCallback
    });
});

</script>
<title>LifeTek POS -
<?php  echo lang('login_login'); ?>
</title>
</head>
<body>

<div id="outer-wrapper">
  <div id="header">
    <div class="google-header-bar  centered" style="text-align: center">
      <div class="header content clearfix"> <img src="<?php  echo base_url();?>/images/logosp/lifetek.png" alt="Hệ thống quản lý giám sát mạng Viễn Thông" class="lifepos_logo"/></div>
    </div>
  </div>
  <div id="main">
    <div class="container ">
      <div class="banner">
        <h1>
          <?php  echo lang('login_welcome_message'); ?>
        </h1>
        <h2 class="hidden-small">
          <?php  echo lang('login_warning_message'); ?>
        </h2>
		<?php  if (validation_errors()) {?>
        <div class="alert alert-warning">
          <?php  echo validation_errors(); ?>
          </div>
        <?php  } ?>
      </div>      
        
      </div>
      <div class="taovietmoi">
        <?php  echo form_open('login') ?>
        <div class="logo-customer">
          <?php  echo img(array('src' => $this->Appconfig->get_logo_image()));?>
        </div>
        <div class="form-group ">
          <?php /*?> <?php  echo lang('login_username'); ?>:<?php */?>
          <?php  echo form_input(array( 'name'=>'username', 'value'=> '', 'size'=>'20','placeholder'=>' Username','class'=>'form-control')); ?>
        </div>
        <div class="form-group">
          <?php /*?> <?php  echo lang('login_password'); ?>  :<?php */?>
          <?php  echo form_password(array( 'name'=>'password', 'value'=>'','size'=>'20','placeholder'=>' Password','class'=>'form-control')); ?>
        </div>
        <div class="btn btn-primary btn-sm btn-block" style="color:#fff">
          <?php  echo form_submit('login_button',lang('login_login')); ?>
        </div>
        <div class="checkbox">
          <?php  echo anchor('login/reset_password', lang('login_reset_password')); ?>
          <?php  echo date("Y")?>
          <?php  echo lang('login_version'); ?>
          <?php  echo APPLICATION_VERSION; ?>
        </div>
        <?php  echo form_close(); ?>
      </div>
    </div>
    <div class="row">
      <center>
        <ul id="mycarousel" class="jcarousel-skin-tango">
          <?php foreach ($ads as $key): ?>
          	<li>
            <a href="<?php $key['url'] ?>">
            	<img src="<?php echo base_url().'images/slider/'.$key['img'] ?>" height="60" width="156">
            </a>
            </li>
          <?php endforeach ?>
        </ul>
      </center>
    </div>
  </div>
  <div id="footer">
    <div class="row">
      <div class="container">
        <center>
          <p style="font-weight: bold;">© <?php echo date("Y")?> <a href="http://lifetek.com.vn/">LifeTek</a>. <?php echo lang('login_footer');?></p>
        </center>
		<script>
		setinterval(function(){$.get('ping.php');},120000);//2 phút 1 lần
	</script>
      </div>
    </div>
  </div>
</div>

</body>
</html>