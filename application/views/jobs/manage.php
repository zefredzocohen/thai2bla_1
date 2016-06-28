<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url();?>" />
<title><?php echo $this->config->item('company').' -- '.lang('common_powered_by').' PHP Point Of Sale' ?></title>
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/metro.css?<?php  echo APPLICATION_VERSION; ?>" />
<link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/style-menu.css?<?php  echo APPLICATION_VERSION; ?>" />

<?php
	foreach(get_css_files() as $css_file)
	{
	?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url().$css_file['path'].'?'.APPLICATION_VERSION;?>" media="<?php echo $css_file['media'];?>" />
<?php
	}
	?>
</head>
<body>
<div class="topheader">
  <div class="inner">
    <div class="topleftmenu">
      <table id="footer_info">
        <tr>
          <td id="menubar_date_time" class="menu_date"><?php
    if($this->config->item('time_format') == '24_hour')
    {
     echo date('H:i');     
    }
    else
    {
     echo date('h:i');
    }
    ?></td>
          <td id="menubar_date_day" class="menu_date mini_date"><?php echo date('D') ?> <br />
            <?php
    if($this->config->item('time_format') != '24_hour')
    {
     echo date('a');
    }
    ?></td>
          <td id="menubar_date_spacer" class="menu_date"> | </td>
          <td id="menubar_date_date" class="menu_date"><?php echo date('d') ?></td>
          <td id="menubar_date_monthyr" class="menu_date mini_date"><?php echo date('F') ?> <br />
            <?php echo date('Y') ?></td>
        </tr>
      </table>
    </div>
    <div class="toprightmenu">
      <div style="height:40px;line-height:35px;"> <?php echo lang('common_welcome')." <b> $user_info->first_name $user_info->last_name! | </b>"; ?>
        <?php
   if ($this->config->item('track_cash') && $this->Sale->is_register_log_open()) {
    echo anchor("sales/closeregister?continue=logout",lang("common_logout"));
   } else {
    echo anchor("home/logout",lang("common_logout"));
   }
   ?>
      </div>
    </div>
  </div>
</div>
<div class="control" style="margin-top:45px;">
            <div style="width:1000px; margin:0 auto;height:100px;">
				<a href="<?php echo site_url(); ?>">
					<?php echo img(
                    array(
                        'src' => $this->Appconfig->get_logo_image(),
						'width'=>'170',
						'height'=>'70',
                    )); ?>
                </a>
                <div style="float:right; width:830px; height:100px;">
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
                        <span class="name">
                      		Skype: <a href="skype:<?php echo $row['skype'];?>?call"><img src="<?php echo base_url();?>images/support/skype.png" style="border: none;" width="32" height="32" alt="My status" /></a>
                        </span>
                        <span class="name">
							Yahoo:<a href="ymsgr:sendIM?<?php echo $row['yahoo'];?>"><font size="2" face="Arial"><img vspace="5" border="0" align="absmiddle" alt="Click để Chat với nhân viên hỗ trợ !" src="http://opi.yahoo.com/online?u=<?php echo $row['yahoo'];?>&amp;m=g&amp;t=2&amp;l=us" title="Click để Chat với nhân viên hỗ trợ!"></font></a>
						</span>
                     <?php }?>
                     </div>
       				</div>
                </div>
                </div>
<div id="content_area_wrapper" style="margin-top:10px;">
  <div id="content_area"  style="height: 570px;   color: #555555;
    font-family: 'Open Sans',arial;
    font-size: 28px;
    font-weight: 200;
    text-shadow: 1px 1px 1px #989898;">
     <div id="header">
    <div class="google-header-bar  centered" style="text-align: center; margin-bottom:20px">
      <div class="header content clearfix"> <img src="<?php  echo base_url();?>/images/logosp/lifetek.png" alt="Hệ thống quản lý giám sát mạng Viễn Thông" class="lifepos_logo"/></div>
    </div>
  </div>
    <div style="text-align:center"> COMING SOON! </div>
  </div>
</div>
</body>
