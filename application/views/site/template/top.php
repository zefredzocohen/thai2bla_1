<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="images/favicon.png">
        <title><?php echo isset($title)&&  trim($title)!=''?$title: 'Thai2bla'; ?></title>
        <link href="<?php echo base_url() ?>css/thai2bala/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>css/thai2bala/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>css/jquery.bxslider.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>css/thai2bala/clingify.css" rel="stylesheet">
        <SCRIPT src="<?php echo base_url(); ?>js/jquery.js" type="text/javascript"></SCRIPT>
        <SCRIPT src="<?php echo base_url(); ?>js/bootstrap.min.js" type="text/javascript"></SCRIPT>
        <SCRIPT src="<?php echo base_url(); ?>js/jquery.clingify.js" type="text/javascript"></SCRIPT>
        <script src="<?php echo base_url(); ?>js/jquery.bxslider.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/category-thumb.js" type="text/javascript"></script>
        <script type="text/javascript">
            $('#banner-home').carousel();
        </script>
    </head>
<body>   
        <?php
        include_once 'LanguageHelper.php';
        $object = new LanguageHelper();
        $lang = $object->checkLang();
        include_once($lang);
        $vi = $top['en-vi'];
        $en = $top['en-en'];
        $language = $top['language'];
        $welcome = $top['welcome'];
        $author = $top['author'];
        $service = $top['service'];
        $new = $top['new'];
        $resellers = $top['resellers'];
        $recruit = $top['recruit'];
        $login = $top['login'];
        $register = $top['register'];
        $home = $top['home'];
        $vendors = $top['vendors'];
        $product = $top['product'];
        $contact = $top['contact'];
        $shop = $top['shop'];
        ?>
<!-- HEADER -->
    <div id="header" style="background: url('<?php echo base_url() ?>images/thai2bala/bg-topheader.png') no-repeat bottom;">
        <div id="dNav" class="container">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="link pull-left col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <a href="<?php echo base_url();?>" class="to-home"></a>
                    <a href="<?php echo base_url();?>thuc-don.html"><span>Thực đơn</span></a>
                    <a href="<?php echo base_url();?>gioi-thieu.html"><span>THÁI 2BLA' STORY</span></a>
                </div>
                <div class="logo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>images/thai2bala/logo.png"></a>
                </div>
                <div class="link pull-right col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <a href="<?php echo base_url();?>tin-tuc.html"><span>Tin tức - sự kiện</span></a>
                    <a href="<?php echo base_url();?>lien-he.html"><span>Liên hệ</span></a>
                </div>
            </div>
        </div>
        <div id="mNav" class="col-xs-12 logo text-center">
            <a href="#" class="col-xs-2" id="mSearch"><span class="glyphicon glyphicon-search"></span></a>
            <a href="index.html" class="m-logo col-xs-8"><img src="<?php echo base_url() ?>images/thai2bala/logo.png" class="img-responsive"></a>
            <div class="col-xs-2" id="mMenu">
                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs_Nav" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    </div>
                </nav>
            </div>
        </div>
        <div class="input-group col-xs-12 mSearchbox" id="mSearchboxs" style="opacity:0">
            <input type="text" class="form-control input-xs" placeholder="Tìm kiếm" />
            <span class="input-group-btn">
                <button class="btn btn-info btn-xs" type="button">SEARCH</button>
            </span>
        </div>
        <div class="mNavlink collapse navbar-collapse" id="bs_Nav">
            <ul class="list-inline">
                <li><span class="glyphicon glyphicon-chevron-right"></span><a href="#">desserts</a></li>
                <li><span class="glyphicon glyphicon-chevron-right"></span><a href="#">ice cream</a></li>
                <li><span class="glyphicon glyphicon-chevron-right"></span><a href="#">smoothies</a></li>
            </ul>
            <hr>
            <ul class="list-inline">
                <li><span class="glyphicon glyphicon-chevron-right"></span><a href="#">tea</a></li>
                <li><span class="glyphicon glyphicon-chevron-right"></span><a href="#">bread</a></li>
                <li><span class="glyphicon glyphicon-chevron-right"></span><a href="#">BIG SALE</a></li>
            </ul>
        </div>
    </div>
