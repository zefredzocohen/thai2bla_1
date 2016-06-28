<!-- BANNER TOP -->
   <div id="banner-top" class="container-fluid" style="background:url('images/upload/banner/banner-top-home.png') no-repeat left center">
      <div class="container">
         <div id="banner-home" class="carousel slide" data-ride="carousel">
           <ol class="carousel-indicators">
             <li data-target="#banner-home" data-slide-to="0" class="active"></li>
             <li data-target="#banner-home" data-slide-to="1"></li>
             <li data-target="#banner-home" data-slide-to="2"></li>
           </ol>
           <div class="carousel-inner" role="listbox">
             <div class="item active">
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left ani-left">
                        <img src="images/upload/mon-an/demo-1.png" class="img-responsive">
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                        <img src="images/thai2bala/moment.png" class="img-responsive" style="margin-left: -35px;">
                     </div>
                  </div>
               </div>
             </div>
             <div class="item">
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left ani-left">
                        <img src="images/upload/mon-an/demo-2.png" class="img-responsive">
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                        <img src="images/thai2bala/moment.png" class="img-responsive" style="margin-left: -35px;">
                     </div>
                  </div>
               </div>
             </div>
             <div class="item">
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12">
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left ani-left">
                        <img src="images/upload/mon-an/demo-2.png" class="img-responsive">
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                        <img src="images/thai2bala/moment.png" class="img-responsive" style="margin-left: -35px;">
                     </div>
                  </div>
               </div>
             </div>
           </div>
         </div>
      </div>
   </div>
<!-- Sticker -->
   <div class="order" id="sticker">
      <a href="<?php echo base_url();?>thuc-don" class="link-order">
         <span class="text-uppercase">đặt hàng</span>
         <span class="text-uppercase">tại đây</span>
      </a>
   </div>
<!-- SHIPPING -->
   <div id="shipping" class="container-fluid" style="background:url('images/upload/banner/banner-shipping.png') no-repeat top center;">
      <div class="container text-center">
         <div class="shipper">
            <img src="images/thai2bala/bg-shipping.png" class="img-responsive">
         </div>
         <div class="call-hotline text-left">
            <p>
               <span>hoặc</span>
               <span class=" text-uppercase">gọi</span>
               <span>1900 2222</span><br>
               <span class="service-tan-rang">để được phục vụ " tận răng "</span>
            </p>
         </div>
      </div>
   </div>
<!-- CATEGORIES -->
   <div id="dat-hang" class="container-fluid" style="background:url('images/thai2bala/bg-categories.png') no-repeat top center"> 
      <div class="container text-center">
         <ul class="list-inline col-sm-12">
         <?php
            $this->load->model('site/category_model');
            $category = $this->category_model->get_all(0);
            foreach ($category as $male):
         ?>
            <li class="col-md-6 col-xs-4">
               <a href="<?php echo base_url() ?>loai-san-pham/<?=$male->url?>/<?=$male->id_cat?>">
                  <div class="category-thumb">
                     <img src="images/upload/categories/bread.png" class="img-responsive">
                  </div>
                  <span><?= $male->name; ?></span>
               </a>
            </li>
         <?php endforeach; ?>

         </ul>
      </div>
   </div>
<!-- CONNECT -->
   <div id="connect" class="container-fluid">
      <div class="cooker">
         <div class="pull-left col-lg-4 col-md-4"><img src="images/thai2bala/cooking.png" class="img-responsive"></div>
         <div class="connect-cooker col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <h3 class="text-uppercase">đầu bếp thái lan sẵn sàng phục vụ</h3>
            <div class="dot-line"></div>
            <div class="social" id="mSocial">
               <p><span class="connect-title"></span><span class="text-uppercase">kết nối với chúng tôi</span></p>
               <div class="social-list">
                  <a href="http://facebook.com/thai2bla"><span class="facebook"></span></a>
                  <a href="http://twitter.com/thai2bla"><span class="twitter"></span></a>
                  <a href="http://pinterest.com/thai2bla"><span class="pinterest"></span></a>
                  <p class="hotline-call"><span class="text-uppercase">Hotline</span><span>1900 2222</span></p>
               </div>
            </div>
            <div class="social" id="dSocial">
               <a href="http://facebook.com/thai2bla"><span class="facebook"></span></a>
               <a href="http://twitter.com/thai2bla"><span class="twitter"></span></a>
               <a href="http://pinterest.com/thai2bla"><span class="pinterest"></span></a>
            </div>
            <div class="frameVideo col-sm-4 col-sm-offset-4 col-md-6 col-md-offset-0">
               <div class="bgr-play"></div>
               <video id="video-connect">
                 <source src="http://www.w3schools.com/html/movie.mp4" type="video/mp4">
               </video>
               <button id="btn-video" class="btn-play" onclick="playPause()"></btn>
            </div>
         </div>
         <div class="pull-right col-lg-4 col-md-4">
            <img src="images/thai2bala/icon-cooker.png" class="img-responsive">
            <img src="images/thai2bala/bg-connect.png" class="img-responsive">
         </div>
      </div>
   </div>