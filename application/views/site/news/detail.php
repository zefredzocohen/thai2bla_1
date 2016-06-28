<div id="details">
  <!-- SLIDER NEWS -->
    <div id="slider-news" class="container-fluid">
      <div class="container content-slider">
        <div class="slider-sales"></div>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
          <?php
            $this->load->model('site/category_model');
            $new_item_advan = $this->category_model->get_advenced();
            $i = 0;
            foreach ($new_item_advan->result_array() as $advan){
              if ($i++ == 1) {  ?>
                <div class="item active">
                      <div class="item-img"></div>
                      <div class="product-img">
                        <img src="<?php echo base_url()?>item/<?php echo $advan['images']?>" class="img-responsive">
                      </div>
                      <div class="carousel-caption">
                      <h3 class="text-uppercase"><?=$advan['name'];?></h3>
                      <hr class="dot-line">
                      <ul class="list-unstyled idetail-product">

                      <?php
                          foreach (explode('-', $advan['description']) as $des) {
                              if (trim($des) != '') {
                      ?>
                                  <li><span class="idetail-bullet"></span><?php echo $des ?></li>
                      <?php
                              }
                          }
                      ?>

                      </ul>
                      <hr class="dot-line">
                      <p class="text-uppercase">Giá:&nbsp&nbsp<span class="price-old"><?php echo number_format($advan['unit_price']) ?></span>&nbsp&nbsp&nbsp&nbsp<span class="price-current"><?=  number_format($advan['promo_price'])?></span></p>
                      <hr class="dot-line">
                      <a href="<?php echo base_url() ?>site/cart/add/<?php echo $advan["item_id"] ?>"><div class="text-center"><span class="btn-buy text-uppercase">chọn món này</span></div></a>
                    </div>
                    </div>
              <?php }
              else {
              ?>
                    <div class="item">
                      <div class="item-img"></div>
                      <div class="product-img">
                        <img src="<?php echo base_url()?>item/<?php echo $advan['images']?>" class="img-responsive">
                      </div>
                      <div class="carousel-caption">
                      <h3 class="text-uppercase"><?=$advan['name'];?></h3>
                      <hr class="dot-line">
                      <ul class="list-unstyled idetail-product">
                        <?php
                            foreach (explode('-', $advan['description']) as $des) {
                                if (trim($des) != '') {
                        ?>
                                    <li><span class="idetail-bullet"></span><?php echo $des ?></li>
                        <?php
                                }
                            }
                        ?>
                      </ul>
                      <hr class="dot-line">
                      <p class="text-uppercase">Giá:&nbsp&nbsp<span class="price-old"><?php echo number_format($advan['unit_price']) ?></span>&nbsp&nbsp&nbsp&nbsp<span class="price-current"><?=  number_format($advan['promo_price'])?></span></p>
                      <hr class="dot-line">
                      <a href="<?php echo base_url() ?>site/cart/add/<?php echo $advan["item_id"] ?>"><div class="text-center"><span class="btn-buy text-uppercase">chọn món này</span></div></a>
                    </div>
                    </div>
          <?php } } ?>
          </div>
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="prev-slider" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="next-slider" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  <div class="border-news"></div>
  <div class="bgr-extra"></div>
  <!-- CONTENT NEWS -->
    <div id="content-news" class="detail container-fluid">
        <div class="container">
          <div class="news-article col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <h1 class="text-uppercase"><?php echo $detail->title; ?></h1>  
            <p class="news-detail col-md-12 col-xs-12">
              <?php echo $detail->full; ?>
            </p>
          </div>
          <div class="story-career col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="news-story">
              <h1 class="text-uppercase">Blog Categories</h1> 
              <ul class="list-inline news-detail">
                <li><span class="list-bullet"></span><a href="">Ẩm thực Thái Lan</a></li>
                <li><span class="list-bullet"></span><a href="">Văn hóa Thái Lan</a></li>
              </ul>
            </div>
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
</script>