<?php $this->load->view('site/template/left'); ?>

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
            foreach ($category_product as $value) {
                ?>
                <li class="products">
                    <div class="offer">
                        New
                    </div>
                    <div class="thumbnail">
                        <img src="<?php echo base_url() ?>images/products/small/products-05.png" alt="Product Name">
                    </div>
                    <div class="product-list-description">
                        <div class="productname">
                            <?= $value->name ?>
                        </div>
                        <p>
                            <img src="<?php echo base_url() ?>images/star.png" alt="">
                            <a href="#" class="review_num">
                                02 Review(s)
                            </a>
                        </p>
                        <p>
                            <?php echo $value->description;?>
                        </p>
                        <div class="list_bottom">
                            <div class="price">
                                <span class="new_price">
                                    <?php
                                    if ($value->promo_price > 0) {
                                        echo number_format($value->promo_price);
                                    } else {
                                        if ($value->quantity_first > 0) {
                                            echo number_format($value->unit_price_rate);
                                        } else {
                                            echo number_format($value->unit_price);
                                        }
                                    }
                                    ?>
                                    <sup>
                                        VNĐ
                                    </sup>
                                </span>
                                <span class="old_price">
                                    <?php
                                    if ($value->promo_price > 0) {
                                        if ($value->quantity_first > 0) {
                                            echo number_format($value->unit_price_rate);
                                        } else {
                                            echo number_format($value->unit_price);
                                        }
                                        ?>

                                        <sup>
                                            VNĐ
                                        </sup>
                                    <?php }
                                    ?>
                                </span>
                            </div>
                            <div class="button_group">
                                <button class="button">
                                    Thêm vào giỏ hàng
                                </button>
                               
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>      
        <?php echo $this->pagination->create_links(); ?> 
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

