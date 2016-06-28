<script type="text/javascript">
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
</script>
<div id="about"> 
  <div class="bgr-extra"></div>
  <!-- ABOUT -->
    <div id="about-story" class="container-fluid" style="">
      <div class="container" style="background:url('images/thai2bala/bg-about.png') no-repeat top center;">
      <p style="overflow: visible"><?php 
      $i=0;
      echo '';
      foreach ($list_rese as $list): 
      ?>
        <h1 class="mAbout text-uppercase text-center"><?=$list->title?></h1>
        
        <?php 
          if ($i++ == 0) {
              echo str_replace('<p>', '<p class="paragraph">', $list->description);
          }
        ?>
      <?php endforeach;?>
      </p>
      </div>
    </div>
  <!-- ABOUT CONNECT -->
    <div id="about-info" class="container-fluid" style="min-height:300px;height:100%;background-color:#fff;"> 
        <div class="container" style="min-height: 640px"> 
        <div class="about-info-connect col-lg-6 col-xs-12">
          <h3 class="text-uppercase">đầu bếp thái lan sẵn sàng phục vụ</h3>
          <div class="dot-line"></div>
          <div class="social" id="mSocial">
            <p><span class="connect-title"></span><span class="text-uppercase">kết nối với chúng tôi</span></p>
            <div class="pull-left social-list">
              <?php foreach ($socials as $social):  ?>
                 <a href="<?php echo $social->url; ?>"><span class="<?php echo $social->name; ?>"></span></a> 
               <?php endforeach; ?>
            </div>
            <p class="hotline-call pull-left"><span class="text-uppercase">Hotline</span><span>
                <?php foreach ($hotline as $key => $hotlines) { 
                    if ($key == 0) {
                        echo $hotlines->phone;
                    }
                } ?>
            </span></p>
          </div>
          <div class="clearfix"></div>
            <div class="frameVideo col-sm-4 col-sm-offset-4 col-md-6 col-md-offset-0">
               <div class="bgr-play">
                    <img class="img-bgr-player" src="<?php echo base_url().'css/images/frame-video.png';?>"/>
                </div>
               <?php foreach ($videos as $video):  
                    if($video==1){
               ?>
                    <source src="<?php echo $video->url; ?>" type="video/youtube">             
                  </video> 
                  
                <div id="video-connect">
                  <iframe id="video" src="<?php echo $video->url; ?>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
                </div>
               <?php }
                  endforeach; 
               ?>
               <button id="btn-video" class="btn-play"></button>
               <button id="btn-pause" class="btn-pause"></button>
            </div>
        </div>
        <div class="about-info-connect col-lg-6 col-xs-12 marginTop100">
          <?php 
            $i=0;
            foreach ($list_rese as $list): ?>
          <?php if ($i++ == 1) { ?>      
          <h3 class="text-uppercase"><?php echo $list->title; ?></h3>
          <div class="dot-line"></div>
          <div class="detail-featured">
            <?php  echo $list->description; ?>
          </div>
          <?php } ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <!-- POLICY -->
    <div id="policy" class="container-fluid" style="background:url('images/thai2bala/bg-chinh-sach.png') no-repeat bottom center">
      <div class="container">
        <div class="col-lg-12 col-md-12">
          <?php 
            $i=0;
            foreach ($list_rese as $list): ?>
          <?php if ($i++ == 2) { ?>      
            <div class="col-lg-4 col-md-4">
              <h3 class="text-uppercase"><?php echo $list->title; ?></h3>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="info-policy" style="min-height: 300px;"><?php  echo str_replace('<p>', '<p class="paragraph">', $list->description); ?></div>
            </div>
          <?php } ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
var player;

    function onYouTubePlayerAPIReady() {
        player = new YT.Player('video', {
          events: {
            'onReady': onPlayerReady
          }
        });
    }
    function onPlayerReady(event) {
      // bind events
        var playButton = document.getElementById("btn-video");
        var pauseButton = document.getElementById("btn-pause");
        playButton.addEventListener("click", function() {
          player.playVideo();
          playButton.style.visibility = 'hidden';
          pauseButton.style.visibility = 'visible';
        });

        var pauseButton = document.getElementById("btn-pause");
        pauseButton.addEventListener("click", function() {
          player.pauseVideo();
        playButton.style.visibility = 'visible';  
          pauseButton.style.visibility = 'hidden';
        });

    }

</script>
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
 
</script>
<style>
    .paragraph{
        margin: 0px !important;
        font-size: 15px;
    }
</style>