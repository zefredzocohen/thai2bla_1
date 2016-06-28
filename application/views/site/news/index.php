<div id="news">
  <!-- SLIDER NEWS -->
    <div id="slider-news" class="container-fluid">
      <div class="container content-slider">
        <div class="slider-sales"></div>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
          <?php
            $this->load->model('site/category_model');
            $new_item_advan= $this->category_model->get_advenced_promo(date('Y/m/d'));
            $i = 0;
            $new_item_advances_promo = $new_item_advan->result_array();
            foreach ( $new_item_advances_promo as $advan){
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
              else if( $i<=count($new_item_advances_promo) ){
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
          <?php }} ?>
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
  <div id="content-news" class="container-fluid">
      <div class="container">
        <div class="news-article col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <h2 class="text-uppercase">tin tức mới nhất<br>về thái2bla</h2> 
          <?php
             foreach ($list_news as $list):
            ?>
          <!-- Begin list News -->
          <p class="news-detail col-md-12 col-xs-12">
            <img class="img-circle img-responsive col-md-4 col-sm-6 col-xs-6" src="<?php echo base_url() ?>news_title/<?=$list->images?>">
            <span class="col-xs-12">
            <?php
              $content = $list->description;
              echo mb_strimwidth($content, 0, 168, '...');
            ?>
            </span>
            <a class="col-xs-12" href="<?php echo base_url()?>tin-tuc/<?=$list->url?>/<?php echo $list->id?>.html">Xem chi tiết</a>
          </p>
          <?php endforeach;?>
          <div class="clearfix"></div>
          <!-- Pagination -->
          <nav id="product-pagination" class="text-center">
              <?php echo $pagination;?>
          </nav>
        </div>
        <div class="story-career col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="news-story">
            <h2 class="text-uppercase">báo chí nói về thái2bla</h2> 
            <ul class="list-inline news-detail">
              <?php
                  foreach ($list_news_baochi as $key):
               ?>
                <li style="padding: 0px 15px;">
                    <!--<span class="list-bullet">-->
                    <p style="min-height: 180px;">
                        <img class="img-circle img-responsive col-md-4 col-sm-6 col-xs-6" style="border: 3px dotted #6e1f60;padding: 5px;float: left;min-height: 180px; min-width: 180px;" src="<?php echo base_url() ?>news_title/<?php echo $key->images;?>">
                    </p>
                    <p>
                      <?php
                        $content = $key->title;
                        echo mb_strimwidth($content, 0, 168, '...'); 
                      ?> 
                    <!--</span>-->
                    <a class="col-xs-12 dot-line-fix" href="<?php echo base_url().'tin-tuc/'.$key->url.'/'.$key->id.'.html';?>">Xem chi tiết</a>
                    </p>
                  
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="news-career">
            <h2 class="text-uppercase">tin tuyển dụng</h2>  
            <ul class="list-inline news-detail">
              <?php
                  foreach ($list_news_tuyendung as $key_td):
               ?>
                <li style="padding: 0px 15px;">
                    <!--<span class="list-bullet">-->
                    <p style="min-height: 180px;">
                        <img class="img-circle img-responsive col-md-4 col-sm-6 col-xs-6" style="border: 3px dotted #6e1f60;padding: 5px;float: left;height: 180px; min-width: 180px;" src="<?php echo base_url() ?>news_title/<?php echo $key_td->images;?>">
                    </p>
                    <p>
                      <?php
                        $content = $key_td->title;
                        echo mb_strimwidth($content, 0, 168, '...'); 
                      ?> 
                    <!--</span>-->
                    <a class="col-xs-12 dot-line-fix" href="<?php echo base_url().'tin-tuc/'.$key_td->url.'/'.$key_td->id.'.html';?>">Xem chi tiết</a>
                    </p>
                  
                </li>
              <?php endforeach; ?>
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
<style>
/*    ul.news-detail li:before{
		content: '';
		display: block;
		border-top: 2px dotted #6e1f60;
		padding-bottom: 35px;
		width: 85%;
	}*/
.dot-line-fix:after{
    content: '';
display: block;
border-top: 2px dotted #6e1f60;
padding-bottom: 35px;
width: 85%;
}
</style>