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
      <?php  echo form_open('login/do_reset_password_notify') ?>
      <div class="logo-customer">
        <?php  echo img(array('src' => $this->Appconfig->get_logo_image()));?>
      </div>
      <div class="form-group ">
        <?php  echo form_input(array(
                                'name'=>'username_or_email',
                                'size'=>'20',
								'placeholder'=>'Username/Email',
								'class'=>'form-control')); ?>
      </div>
      <div class="btn btn-primary btn-sm btn-block" style="color:#fff">
        <?php  echo form_submit('login_button',lang('login_reset_password')); ?>
      </div>
    </div>
    <?php  echo form_close(); ?>
  </div>
</div>
<div class="row">
  <center>
    <ul id="mycarousel" class="jcarousel-skin-tango">
      <li><img src="<?php  echo base_url();?>img/l1.png" width="156" height="60" alt="" /></li>
      <li><img src="<?php  echo base_url();?>img/l2.png" width="156" height="60" alt="" /></li>
      <li><img src="<?php  echo base_url();?>img/l3.png" width="156" height="60" alt="" /></li>
      <li><img src="<?php  echo base_url();?>img/l4.png" width="156" height="60" alt="" /></li>
      <li><img src="<?php  echo base_url();?>img/l5.png" width="156" height="60" alt="" /></li>
      <li><img src="<?php  echo base_url();?>img/l6.png" width="156" height="60" alt="" /></li>
      <li><img src="<?php  echo base_url();?>img/l7.png" width="156" height="60" alt="" /></li>
    </ul>
  </center>
</div>
</div>
<div id="footer">
  <div class="row">
    <div class="container">
      <center>
        <p style="font-weight: bold;">© <?php echo date("Y")?> <a href="http://lifetek.com.vn/">Lifetek</a>. <?php echo lang('login_footer');?></p>
      </center>
    </div>
  </div>
</div>
</div>
</body>
</html>
