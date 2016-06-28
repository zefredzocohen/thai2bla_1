	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN " "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<title><?php echo $this->config->item('company')?></title>
    <!--<title><?php echo lang('common_jobs_name_update ') ?></title> -->

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <base href="<?php echo base_url();?>" />
    <link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon"/>
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
    <script type="text/javascript" src="<?php echo base_url()?>ckeditor/sample.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/jsForm.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/jobsCSS.css" />
</head>
<body>
