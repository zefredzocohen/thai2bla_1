<div id="homepage">
<!-- BANNER TOP -->
   <div id="banner-top" class="container-fluid" style="background:url('images/upload/banner/banner-top-home.png') no-repeat left center">
      <div class="container">
         <div id="banner-home" class="carousel slide" data-ride="carousel">
           <ol class="carousel-indicators">
            <?php
            foreach ($sliders as $key => $slider) {
            ?>
                 <li data-target="#banner-home" data-slide-to="<?php echo $key ?>" class="<?php if ($key == 0) echo 'active' ?>"></li>
            <?php
            }
            ?>
           </ol>
           <div class="carousel-inner" role="listbox">
            <?php
            foreach ($sliders as $key => $slider) {
            ?>
                 <div class="item <?php if ($key == 0) echo 'active' ?>">
                   <div class="row">
                      <div class="col-lg-12 col-md-12 col-xs-12">
                         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left ani-left">
                            <img src="<?php echo base_url();?><?php echo $slider->img ?>" class="img-responsive">
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
                            <img src="images/thai2bala/moment.png" class="img-responsive" style="margin-left: -35px;">
                         </div>
                      </div>
                   </div>
                 </div>
            <?php
            }
            ?>
           </div>
         </div>
      </div>
   </div>
<!-- Sticker -->
   <div class="order" id="sticker">
      <a href="<?php echo base_url();?>thuc-don.html" class="link-order">
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
                   <span>
                        <?php foreach ($hotline as $key => $hotlines) { 
                            if ($key == 0) {
                                echo $hotlines->phone;
                            }
                        } ?>
                  </span><br>
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
                if (isset($categories)) {
                    foreach ($categories as $category) {
            ?>
                        <li class="col-md-6 col-xs-4">
                            <a href="<?php echo base_url(); ?>thuc-don/<?php echo $category->url ?>.html">
                                <div class="category-thumb">
                                    <img src="<?php echo base_url(); ?><?php echo $category->image ?>" class="img-responsive">
                                </div>
                                <span><?php echo $category->name ?></span>
                            </a>
                        </li>
            <?php
                    }
                }
            ?>
         </ul>
      </div>
   </div>
<!-- CONNECT -->
   <div id="connect" class="container-fluid">
      <div class=" row cooker">
         <div class="pull-left col-lg-4 col-md-4">
            <?php foreach ($cooker as $key => $cookers) { if ($key == 0){ ?>
              <img src="<?php echo base_url(); echo $cookers->img ?>" class="img-responsive" style="min-height:580px;">
            <?php }} ?>
         </div>
         <div class="connect-cooker col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <h3 class="text-uppercase">đầu bếp thái lan sẵn sàng phục vụ</h3>
            <div class="dot-line"></div>
            <div class="social" id="mSocial">
               <p><span class="connect-title"></span><span class="text-uppercase">kết nối với chúng tôi</span></p>
               <div class="social-list">
                  <?php foreach ($socials as $social):  ?>
                     <a href="<?php echo $social->url; ?>"><span class="<?php echo $social->name; ?>"></span></a>
                  <?php endforeach; ?>

                  <?php foreach ($hotline as $hotlines):  ?>
                  <p class="hotline-call"><span class="text-uppercase">Hotline</span><span><?php echo $hotlines->phone; ?></span></p>
                  <?php endforeach; ?>
               </div>
            </div>
            <div class="social" id="dSocial">
                  <?php foreach ($socials as $social):  ?>
                     <a href="<?php echo $social->url; ?>"><span class="<?php echo $social->name; ?>"></span></a>
                  <?php endforeach; ?>
            </div>
            <div class="frameVideo col-sm-4 col-sm-offset-4 col-md-6 col-md-offset-0">
               <div class="bgr-play"></div>

               <?php foreach ($video as $videos):  ?>
                  <!-- <video id="video-connect">
                    <source src="<?php echo $videos->url; ?>" type="video/youtube">
                  </video> -->
                <div id="video-connect">
                  <!-- <iframe id="ytube" src="//www.youtube.com/embed/9B7te184ZpQ?rel=0" frameborder="0" allowfullscreen></iframe> -->
                  <iframe id="video" src="<?php echo $videos->url; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                </div>
               <?php endforeach; ?>
               <button id="btn-video" class="btn-play"></button>
            </div>
         </div>
         <div class="pull-right col-lg-4 col-md-4">
            <img src="images/thai2bala/icon-cooker.png" class="img-responsive">
            <img src="images/thai2bala/bg-connect.png" class="img-responsive">
         </div>
        </div>
     </div>
</div>
<script type="text/javascript">
  //Search
      document.onclick = function(event){
        var hasParent = false;
          for(var node = event.target; node != document.body; node = node.parentNode)
          {
            if(node.id == 'mSearch'){
              hasParent = true;
              break;
            }
          }
        if(hasParent){
          $(".mSearchbox").css("opacity", 1);
          $("#mSearch .glyphicon").addClass('a_hover');
        // else
        //   $(".mSearchbox").css("opacity", 0);
          $("body").click(function(e) {
              if (e.target.id == "mSearchboxs" || $(e.target).parents("#mSearchboxs").size()) {
                  //alert("Inside div");
              } else {
                 $(".mSearchbox").css("opacity", 0);
              }
          })
        }
        else{$("#mSearch .glyphicon").removeClass('a_hover');}

      }
  //Sticker
      $(function() {
          $('#sticker').clingify({
              breakpoint : 768,
              extraClass : 'sidebarClingy'
          });
      });
  //Play Video Homepage
      // var myVideo = document.getElementById("ytube");
      // function playPause() {
      //     $('#btn-video').removeClass('btn-play');

      //     if (myVideo.paused){
      //         myVideo.play();
      //         $('#btn-video').removeClass('btn-play');
      //         //$('#btn-video').addClass('btn-pause');
      //         $('#btn-video').addClass('btn-pause-hide');
      //     }
      //     else{
      //         myVideo.pause();
      //         $('#btn-video').removeClass('btn-pause');
      //         $('#btn-video').addClass('btn-play');
      //     }
      // }
      // myVideo.addEventListener("ended", function(){
      //     //$('#btn-video').removeClass('btn-pause');
      //     $('#btn-video').removeClass('btn-pause-hide');
      //     $('#btn-video').addClass('btn-play');
      // });
      $(document).ready(function() {
        $('#btn-video').on('click', function(ev) {

          $("#video")[0].src += "&autoplay=1";
          $('#btn-video').removeClass('btn-play');
          //$('#btn-video').addClass('btn-pause');
          $('#btn-video').addClass('btn-pause-hide');
          ev.preventDefault();

        });
      });

  //Hidden btn Chọn món
  $(function() {
    $("#footer .chon-mon-img").addClass('hide');
  });
</script>
