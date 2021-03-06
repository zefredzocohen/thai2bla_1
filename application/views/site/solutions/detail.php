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
        <h3><?= $detail->title?></h3>
        <p>
           <?= $detail->full?>
        </p>
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

    <?php }elseif($_GET['lang'] == 'en'){?>
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
        <h3><?= $detail->en_title?></h3>
        <p>
           <?= $detail->en_full?>
        </p>
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
        <h3><?= $detail->title?></h3>
        <p>
           <?= $detail->full?>
        </p>
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

