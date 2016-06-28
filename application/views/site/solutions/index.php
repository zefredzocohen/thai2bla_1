<?php $this->load->view('site/template/left'); ?>
<?php
include_once 'LanguageHelper.php';
$object = new LanguageHelper();
$lang = $object->checkLang();
include_once($lang);

if (isset($_GET['lang'])) {
    if ($_GET['lang'] == "vi") {
    ?>
<div class="col-md-9">
    <div class="banner">
        <div class="bannerslide" id="bannerslide">
            <ul class="slides">
                <li>
                    <a href="#">
                        <img src="<?php echo base_url() ?>images/banner-01.jpg" alt=""/>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="<?php echo base_url() ?>images/banner-02.jpg" alt=""/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="products-list">
        <ul class="products-listItem">
            <?php
               foreach ($list_rese as $list):
            ?>
                <li class="products">
                    <div class="thumbnail">
                        <?php if($list->images == NULL){?>
                        <img src="<?php echo base_url() ?>images/products/small/products-05.png" alt="Product Name">
                        <?php }else{?>
                        <img src="<?php echo base_url() ?>sulotion_images/<?=$list->images?>" alt="Product Name">
                        <?php }?>
                    </div>
                    <div class="product-list-description">
                        <div class="productname">
                            <?=$list->title?>
                        </div>
                        <p>
                            <img src="<?php echo base_url() ?>images/star.png" alt="">
                            <a href="#" class="review_num">
                                02 Review(s)
                            </a>
                        </p>
                        <p>
                            <?=$list->description?>
                        </p>
                        <div class="list_bottom">
                            
                            <div class="button_group">
                                <button class="button" onclick="window.location='<?php echo base_url()?>giai-phap/<?=$list->url?>/<?php echo $list->id?>.html'">
                                    Chi tiết...
                                </button>
                               
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>      
        <div class="toolbar">
            <div class="pager">
                
                <a href="#" class="prev-page">
                    <i class="fa fa-angle-left">
                    </i>
                </a>
                <a href="#" class="active">
                    1
                </a>
                <a href="#">
                    2
                </a>
                <a href="#">
                    3
                </a>
                <a href="#" class="next-page">
                    <i class="fa fa-angle-right">
                    </i>
                </a>
            </div>
        </div>
    </div>
    
</div>
<div class="clearfix">
          </div>
          <div class="our-brand">
            <h3 class="title">
              <strong>
                Đối 
              </strong>
              tác
            </h3>
            <div class="control">
              <a id="prev_brand" class="prev" href="#">
                &lt;
              </a>
              <a id="next_brand" class="next" href="#">
                &gt;
              </a>
            </div>
            <ul id="braldLogo">
              <li>
                <ul class="brand_item">
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <ul class="brand_item">
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
</div>
</div>
</div>

    <?php }elseif ($_GET['lang'] == 'en') {       
    ?>
<div class="col-md-9">
    <div class="banner">
        <div class="bannerslide" id="bannerslide">
            <ul class="slides">
                <li>
                    <a href="#">
                        <img src="<?php echo base_url() ?>images/banner-01.jpg" alt=""/>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="<?php echo base_url() ?>images/banner-02.jpg" alt=""/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="products-list">
        <ul class="products-listItem">
            <?php
               foreach ($list_rese as $list):
            ?>
                <li class="products">
                    <div class="thumbnail">
                        <?php if($list->images == NULL){?>
                        <img src="<?php echo base_url() ?>images/products/small/products-05.png" alt="Product Name">
                        <?php }else{?>
                        <img src="<?php echo base_url() ?>sulotion_images/<?=$list->images?>" alt="Product Name">
                        <?php }?>
                    </div>
                    <div class="product-list-description">
                        <div class="productname">
                            <?=$list->en_title?>
                        </div>
                        <p>
                            <img src="<?php echo base_url() ?>images/star.png" alt="">
                            <a href="#" class="review_num">
                                02 Review(s)
                            </a>
                        </p>
                        <p>
                            <?=$list->en_description?>
                        </p>
                        <div class="list_bottom">
                            
                            <div class="button_group">
                                <button class="button" onclick="window.location='<?php echo base_url()?>giai-phap/<?=$list->url?>/<?php echo $list->id?>.html'">
                                    Detail...
                                </button>
                               
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>      
        <div class="toolbar">
            <div class="pager">
                
                <a href="#" class="prev-page">
                    <i class="fa fa-angle-left">
                    </i>
                </a>
                <a href="#" class="active">
                    1
                </a>
                <a href="#">
                    2
                </a>
                <a href="#">
                    3
                </a>
                <a href="#" class="next-page">
                    <i class="fa fa-angle-right">
                    </i>
                </a>
            </div>
        </div>
    </div>
    
</div>
<div class="clearfix">
          </div>
          <div class="our-brand">
            <h3 class="title">
              <strong>
                VENDOR
              </strong>
              
            </h3>
            <div class="control">
              <a id="prev_brand" class="prev" href="#">
                &lt;
              </a>
              <a id="next_brand" class="next" href="#">
                &gt;
              </a>
            </div>
            <ul id="braldLogo">
              <li>
                <ul class="brand_item">
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <ul class="brand_item">
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
</div>
</div>
</div>

    <?php } ?>
<?php }else{?>
<div class="col-md-9">
    <div class="banner">
        <div class="bannerslide" id="bannerslide">
            <ul class="slides">
                <li>
                    <a href="#">
                        <img src="<?php echo base_url() ?>images/banner-01.jpg" alt=""/>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="<?php echo base_url() ?>images/banner-02.jpg" alt=""/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="products-list">
        <ul class="products-listItem">
            <?php
               foreach ($list_rese as $list):
            ?>
                <li class="products">
                    <div class="thumbnail">
                        <?php if($list->images == NULL){?>
                        <img src="<?php echo base_url() ?>images/products/small/products-05.png" alt="Product Name">
                        <?php }else{?>
                        <img src="<?php echo base_url() ?>resellers_images/<?=$list->images?>" alt="Product Name">
                        <?php }?>
                    </div>
                    <div class="product-list-description">
                        <div class="productname">
                            <?=$list->title?>
                        </div>
                        <p>
                            <img src="<?php echo base_url() ?>images/star.png" alt="">
                            <a href="#" class="review_num">
                                02 Review(s)
                            </a>
                        </p>
                        <p>
                            <?=$list->description?>
                        </p>
                        <div class="list_bottom">
                            
                            <div class="button_group">
                                <button class="button" onclick="window.location='<?php echo base_url()?>giai-phap/<?=$list->url?>/<?php echo $list->id?>.html'">
                                    Chi tiết...
                                </button>
                               
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>      
        <div class="toolbar">
            <div class="pager">
                
                <a href="#" class="prev-page">
                    <i class="fa fa-angle-left">
                    </i>
                </a>
                <a href="#" class="active">
                    1
                </a>
                <a href="#">
                    2
                </a>
                <a href="#">
                    3
                </a>
                <a href="#" class="next-page">
                    <i class="fa fa-angle-right">
                    </i>
                </a>
            </div>
        </div>
    </div>
    
</div>
<div class="clearfix">
          </div>
          <div class="our-brand">
            <h3 class="title">
              <strong>
                Đối 
              </strong>
              tác
            </h3>
            <div class="control">
              <a id="prev_brand" class="prev" href="#">
                &lt;
              </a>
              <a id="next_brand" class="next" href="#">
                &gt;
              </a>
            </div>
            <ul id="braldLogo">
              <li>
                <ul class="brand_item">
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <ul class="brand_item">
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/themeforest.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/photodune.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/activeden.png" alt="">
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="brand-logo">
                        <img src="<?php echo base_url()?>images/envato.png" alt="">
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
</div>
</div>
</div>

<?php } ?>

