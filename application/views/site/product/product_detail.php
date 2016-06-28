<?php
include_once 'template/LanguageHelper.php';
$object = new LanguageHelper();
$lang = $object->checkLang();
include_once($lang);
$vi = $top['en-vi'];
$en = $top['en-en'];


if (isset($_GET['lang'])) {
     if ($_GET['lang'] == "vi") {

    ?>
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container">
        <div class="products-details">
            <div class="preview_image">
                <div class="preview-small">
                    <?php
                    if ($product_detail->images == NULL) {
                        ?>
                        <img id="zoom_03" src="<?php echo base_url() ?>images/noImage.gif" data-zoom-image="images/products/Large/products-01.jpg" alt="">
                    <?php } else { ?>
                        <img id="zoom_03" src="<?php echo base_url() ?>item/<?php echo $product_detail->images ?>" data-zoom-image="images/products/Large/products-01.jpg" alt="" style="padding: 0px 0px 0px 90px">
                    <?php } ?>

                </div>
                <div class="thum-image">
                    <ul id="gallery_01" class="prev-thum">

                        <li>
                            <a href="#" data-image="<?php echo base_url() ?>images/products/medium/products-05.jpg" data-zoom-image="images/products/Large/products-05.jpg">
                                <img src="<?php echo base_url() ?>images/products/thum/products-05.png" alt="">
                            </a>
                        </li>
                    </ul>
                    <a class="control-left" id="thum-prev" href="javascript:void(0);">
                        <i class="fa fa-chevron-left">
                        </i>
                    </a>
                    <a class="control-right" id="thum-next" href="javascript:void(0);">
                        <i class="fa fa-chevron-right">
                        </i>
                    </a>
                </div>
            </div>
            <div class="products-description">
                <h5 class="name">
                    <?php echo $product_detail->name; ?>
                </h5>
                <p>
                    <img alt="" src="<?php echo base_url() ?>images/star.png">
                    <a class="review_num" href="#">
                        02 Review(s)
                    </a>
                </p>
                <p>
                    Availability: 
                    <span class=" light-red">
                        In Stock
                    </span>
                </p>
                <p>
                    <?php echo $product_detail->description ?>
                </p>
                <hr class="border">
                <div class="price">
                    Giá : 
                    <span class="new_price">
                        <?php
                        $this->load->model('Item');
                        if ($this->Item->get_info($product_detail->item_id)->promo_price > 0) {
                            echo number_format($product_detail->promo_price);
                        } else {
                            if ($this->Item->get_info($product_detail->item_id)->unit_from == 0) {
                                echo number_format($product_detail->unit_price);
                            } else {
                                echo number_format($product_detail->unit_price_rate);
                            }
                        }
                        ?>
                        <sup>
                            VNĐ
                        </sup>
                    </span>
                    <span class="old_price">
                        <?php
                        if ($this->Item->get_info($product_detail->item_id)->promo_price > 0) {

                            if ($this->Item->get_info($product_detail->item_id)->unit_from == 0) {
                                ?>
                                <?php echo number_format($product_detail->unit_price); ?>
                                <sup>
                                    VNĐ
                                </sup>
                            <?php } else { ?>
                                <?php echo number_format($product_detail->unit_price_rate); ?>
                                <sup>
                                    VNĐ
                                </sup>
                            <?php } ?>
                        <?php } ?>
                    </span>
                </div>
                <hr class="border">
                <div class="wided">

                    <div class="button_group">
                        <button class="button" onclick="window.location = '<?php echo base_url() ?>site/cart/add/<?php echo $product_detail->item_id ?>'">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
                <div class="clearfix">
                </div>
                <hr class="border">
                <img src="<?php echo base_url() ?>images/share.png" alt="" class="pull-right">
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="tab-box">
            <div id="tabnav">
                <ul>
                    <li>
                        <a href="#Descraption">
                            MÔ TẢ
                        </a>
                    </li>
                    <li>
                        <a href="#Reviews">
                            CHI TIẾT
                        </a>
                    </li>
                    <li>
                        <a href="#tags">
                            THÔNG SỐ KỸ THUẬT
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content-wrap">
                <div class="tab-content" id="Descraption">
                    <p>
                        <?php echo $product_detail->description ?>
                    </p>

                </div>
                <div class="tab-content" id="Reviews">
                    <form>

                        <?php echo $product_detail->details ?>
                    </form>
                </div>
                <div class="tab-content" >
                    <div class="review">
                        <p class="rating">
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star-half-o gray">
                            </i>
                            <i class="fa fa-star-o gray">
                            </i>
                        </p>
                        <h5 class="reviewer">
                            Reviewer name
                        </h5>
                        <p class="review-date">
                            Date: 01-01-2014
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque.
                        </p>
                    </div>
                    <div class="review">
                        <p class="rating">
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star-half-o gray">
                            </i>
                            <i class="fa fa-star-o gray">
                            </i>
                        </p>
                        <h5 class="reviewer">
                            Reviewer name
                        </h5>
                        <p class="review-date">
                            Date: 01-01-2014
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque.
                        </p>
                    </div>
                </div>
                <div class="tab-content" id="tags">
                    <?php echo $product_detail->technical ?>
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div id="productsDetails" class="hot-products">
            <h3 class="title">
                <strong>
                    SẢN PHẨM
                </strong>
                CÙNG LOẠI
            </h3>
            <div class="control">
                <a id="prev_hot" class="prev" href="#">
                    &lt;
                </a>
                <a id="next_hot" class="next" href="#">
                    &gt;
                </a>
            </div>
            <ul id="hot">
                
                  <li>
                    <div class="row">
                        <?php
                $this->load->model('Item');
                $cate_id = $this->Item->get_info($product_detail->item_id)->category;
                $similar = $this->category_model->similar($cate_id);
                foreach ($similar as $tag):
                ?>
                      <div class="col-md-4 col-sm-4">
                        <div class="products">
                          <div class="offer">
                            Mới
                          </div>
                          <div class="thumbnail">
                            <?php
                               if($tag->images == NULL){
                            ?>
                              <img src="<?php echo base_url()?>images/noImage.gif" alt="" style="height: 200px;width: 180px;">
                               <?php }else{?>
                              <img src="<?php echo base_url()?>item/<?=$tag->images?>" alt="" style="height: 200px;width: 180px;">
                               <?php }?>
                          </div>
                          <div class="productname">
                            <?php echo $tag->name?>
                          </div>
                          <h4 class="price">
                            <?php
                            $this->load->model('Item');
                               if($this->Item->get_info($tag->item_id)->promo_price > 0){
                                   echo number_format($tag->promo_price);
                               }else{
                                   if($this->Item->get_info($tag->item_id)->unit_from == 0){
                                       echo number_format($tag->unit_price);
                                   }else{
                                       echo number_format($tag->unit_price_rate);
                                   }
                               }
                            ?>
                          </h4>
                          <div class="button_group">
                            <button class="button add-cart" type="button" onclick="window.location = '<?php echo base_url() ?>site/cart/add/<?php echo $tag->item_id ?>'">
                              Thêm vào giỏ hàng
                            </button>
                          </div>
                        </div>
                      </div>
                    <?php endforeach;?>
                    </div>
                  </li>
                </ul>
        </div>
        <div class="clearfix">
        </div>


        <div class="clearfix">
        </div>
        <div class="our-brand">
            <h3 class="title">
                <strong>
                   ĐỐI
                </strong>
                TÁC
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
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
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
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
     <?php }elseif ($_GET['lang'] == 'en') { 
    ?>
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container">
        <div class="products-details">
            <div class="preview_image">
                <div class="preview-small">
                    <?php
                    if ($product_detail->images == NULL) {
                        ?>
                        <img id="zoom_03" src="<?php echo base_url() ?>images/noImage.gif" data-zoom-image="images/products/Large/products-01.jpg" alt="">
                    <?php } else { ?>
                        <img id="zoom_03" src="<?php echo base_url() ?>item/<?php echo $product_detail->images ?>" data-zoom-image="images/products/Large/products-01.jpg" alt="" style="padding: 0px 0px 0px 90px">
                    <?php } ?>

                </div>
                <div class="thum-image">
                    <ul id="gallery_01" class="prev-thum">

                        <li>
                            <a href="#" data-image="<?php echo base_url() ?>images/products/medium/products-05.jpg" data-zoom-image="images/products/Large/products-05.jpg">
                                <img src="<?php echo base_url() ?>images/products/thum/products-05.png" alt="">
                            </a>
                        </li>
                    </ul>
                    <a class="control-left" id="thum-prev" href="javascript:void(0);">
                        <i class="fa fa-chevron-left">
                        </i>
                    </a>
                    <a class="control-right" id="thum-next" href="javascript:void(0);">
                        <i class="fa fa-chevron-right">
                        </i>
                    </a>
                </div>
            </div>
            <div class="products-description">
                <h5 class="name">
                    <?php echo $product_detail->en_name; ?>
                </h5>
                <p>
                    <img alt="" src="<?php echo base_url() ?>images/star.png">
                    <a class="review_num" href="#">
                        02 Review(s)
                    </a>
                </p>
                <p>
                    Availability: 
                    <span class=" light-red">
                        In Stock
                    </span>
                </p>
                <p>
                    <?php echo $product_detail->en_description ?>
                </p>
                <hr class="border">
                <div class="price">
                    Giá : 
                    <span class="new_price">
                        <?php
                        $this->load->model('Item');
                        if ($this->Item->get_info($product_detail->item_id)->promo_price > 0) {
                            echo number_format($product_detail->promo_price);
                        } else {
                            if ($this->Item->get_info($product_detail->item_id)->unit_from == 0) {
                                echo number_format($product_detail->unit_price);
                            } else {
                                echo number_format($product_detail->unit_price_rate);
                            }
                        }
                        ?>
                        <sup>
                            VNĐ
                        </sup>
                    </span>
                    <span class="old_price">
                        <?php
                        if ($this->Item->get_info($product_detail->item_id)->promo_price > 0) {

                            if ($this->Item->get_info($product_detail->item_id)->unit_from == 0) {
                                ?>
                                <?php echo number_format($product_detail->unit_price); ?>
                                <sup>
                                    VNĐ
                                </sup>
                            <?php } else { ?>
                                <?php echo number_format($product_detail->unit_price_rate); ?>
                                <sup>
                                    VNĐ
                                </sup>
                            <?php } ?>
                        <?php } ?>
                    </span>
                </div>
                <hr class="border">
                <div class="wided">

                    <div class="button_group">
                        <button class="button" onclick="window.location = '<?php echo base_url() ?>site/cart/add/<?php echo $product_detail->item_id ?>'">
                            Add to cart
                        </button>
                    </div>
                </div>
                <div class="clearfix">
                </div>
                <hr class="border">
                <img src="<?php echo base_url() ?>images/share.png" alt="" class="pull-right">
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="tab-box">
            <div id="tabnav">
                <ul>
                    <li>
                        <a href="#Descraption">
                            DESCRIPTION
                        </a>
                    </li>
                    <li>
                        <a href="#Reviews">
                            REVIEW
                        </a>
                    </li>
                    <li>
                        <a href="#tags">
                            PRODUCT TAGS
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content-wrap">
                <div class="tab-content" id="Descraption">
                    <p>
                        <?php echo $product_detail->en_description ?>
                    </p>

                </div>
                <div class="tab-content" id="Reviews">
                    <form>

                        <?php echo $product_detail->en_details ?>
                    </form>
                </div>
                <div class="tab-content" >
                    <div class="review">
                        <p class="rating">
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star-half-o gray">
                            </i>
                            <i class="fa fa-star-o gray">
                            </i>
                        </p>
                        <h5 class="reviewer">
                            Reviewer name
                        </h5>
                        <p class="review-date">
                            Date: 01-01-2014
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque.
                        </p>
                    </div>
                    <div class="review">
                        <p class="rating">
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star-half-o gray">
                            </i>
                            <i class="fa fa-star-o gray">
                            </i>
                        </p>
                        <h5 class="reviewer">
                            Reviewer name
                        </h5>
                        <p class="review-date">
                            Date: 01-01-2014
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque.
                        </p>
                    </div>
                </div>
                <div class="tab-content" id="tags">
                    <?php echo $product_detail->en_technical ?>
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div id="productsDetails" class="hot-products">
            <h3 class="title">
                <strong>
                    PRODUCT
                </strong>
                SIMILAR
            </h3>
            <div class="control">
                <a id="prev_hot" class="prev" href="#">
                    &lt;
                </a>
                <a id="next_hot" class="next" href="#">
                    &gt;
                </a>
            </div>
            <ul id="hot">
                
                  <li>
                    <div class="row">
                        <?php
                $this->load->model('Item');
                $cate_id = $this->Item->get_info($product_detail->item_id)->category;
                $similar = $this->category_model->similar($cate_id);
                foreach ($similar as $tag):
                ?>
                      <div class="col-md-4 col-sm-4">
                        <div class="products">
                          <div class="offer">
                            Mới
                          </div>
                          <div class="thumbnail">
                            <?php
                               if($tag->images == NULL){
                            ?>
                              <img src="<?php echo base_url()?>images/noImage.gif" alt="" style="height: 200px;width: 180px;">
                               <?php }else{?>
                              <img src="<?php echo base_url()?>item/<?=$tag->images?>" alt="" style="height: 200px;width: 180px;">
                               <?php }?>
                          </div>
                          <div class="productname">
                            <?php echo $tag->name?>
                          </div>
                          <h4 class="price">
                            <?php
                            $this->load->model('Item');
                               if($this->Item->get_info($tag->item_id)->promo_price > 0){
                                   echo number_format($tag->promo_price);
                               }else{
                                   if($this->Item->get_info($tag->item_id)->unit_from == 0){
                                       echo number_format($tag->unit_price);
                                   }else{
                                       echo number_format($tag->unit_price_rate);
                                   }
                               }
                            ?>
                          </h4>
                          <div class="button_group">
                            <button class="button add-cart" type="button" onclick="window.location = '<?php echo base_url() ?>site/cart/add/<?php echo $tag->item_id ?>'">
                              Add to cart
                            </button>
                          </div>
                        </div>
                      </div>
                    <?php endforeach;?>
                    </div>
                  </li>
                </ul>
        </div>
        <div class="clearfix">
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
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
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
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
     <?php } ?>
<?php }else{?>
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container">
        <div class="products-details">
            <div class="preview_image">
                <div class="preview-small">
                    <?php
                    if ($product_detail->images == NULL) {
                        ?>
                        <img id="zoom_03" src="<?php echo base_url() ?>images/noImage.gif" data-zoom-image="images/products/Large/products-01.jpg" alt="">
                    <?php } else { ?>
                        <img id="zoom_03" src="<?php echo base_url() ?>item/<?php echo $product_detail->images ?>" data-zoom-image="images/products/Large/products-01.jpg" alt="" style="padding: 0px 0px 0px 90px">
                    <?php } ?>

                </div>
                <div class="thum-image">
                    <ul id="gallery_01" class="prev-thum">

                        <li>
                            <a href="#" data-image="<?php echo base_url() ?>images/products/medium/products-05.jpg" data-zoom-image="images/products/Large/products-05.jpg">
                                <img src="<?php echo base_url() ?>images/products/thum/products-05.png" alt="">
                            </a>
                        </li>
                    </ul>
                    <a class="control-left" id="thum-prev" href="javascript:void(0);">
                        <i class="fa fa-chevron-left">
                        </i>
                    </a>
                    <a class="control-right" id="thum-next" href="javascript:void(0);">
                        <i class="fa fa-chevron-right">
                        </i>
                    </a>
                </div>
            </div>
            <div class="products-description">
                <h5 class="name">
                    <?php echo $product_detail->name; ?>
                </h5>
                <p>
                    <img alt="" src="<?php echo base_url() ?>images/star.png">
                    <a class="review_num" href="#">
                        02 Review(s)
                    </a>
                </p>
                <p>
                    Availability: 
                    <span class=" light-red">
                        In Stock
                    </span>
                </p>
                <p>
                    <?php echo $product_detail->description ?>
                </p>
                <hr class="border">
                <div class="price">
                    Giá : 
                    <span class="new_price">
                        <?php
                        $this->load->model('Item');
                        if ($this->Item->get_info($product_detail->item_id)->promo_price > 0) {
                            echo number_format($product_detail->promo_price);
                        } else {
                            if ($this->Item->get_info($product_detail->item_id)->unit_from == 0) {
                                echo number_format($product_detail->unit_price);
                            } else {
                                echo number_format($product_detail->unit_price_rate);
                            }
                        }
                        ?>
                        <sup>
                            VNĐ
                        </sup>
                    </span>
                    <span class="old_price">
                        <?php
                        if ($this->Item->get_info($product_detail->item_id)->promo_price > 0) {

                            if ($this->Item->get_info($product_detail->item_id)->unit_from == 0) {
                                ?>
                                <?php echo number_format($product_detail->unit_price); ?>
                                <sup>
                                    VNĐ
                                </sup>
                            <?php } else { ?>
                                <?php echo number_format($product_detail->unit_price_rate); ?>
                                <sup>
                                    VNĐ
                                </sup>
                            <?php } ?>
                        <?php } ?>
                    </span>
                </div>
                <hr class="border">
                <div class="wided">

                    <div class="button_group">
                        <button class="button" onclick="window.location = '<?php echo base_url() ?>site/cart/add/<?php echo $product_detail->item_id ?>'">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
                <div class="clearfix">
                </div>
                <hr class="border">
                <img src="<?php echo base_url() ?>images/share.png" alt="" class="pull-right">
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div class="tab-box">
            <div id="tabnav">
                <ul>
                    <li>
                        <a href="#Descraption">
                            MÔ TẢ
                        </a>
                    </li>
                    <li>
                        <a href="#Reviews">
                            CHI TIẾT
                        </a>
                    </li>
                    <li>
                        <a href="#tags">
                           THÔNG SỐ KỸ THUẬT
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content-wrap">
                <div class="tab-content" id="Descraption">
                    <p>
                        <?php echo $product_detail->description ?>
                    </p>

                </div>
                <div class="tab-content" id="Reviews">
                    <form>

                        <?php echo $product_detail->details ?>
                    </form>
                </div>
                <div class="tab-content" >
                    <div class="review">
                        <p class="rating">
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star-half-o gray">
                            </i>
                            <i class="fa fa-star-o gray">
                            </i>
                        </p>
                        <h5 class="reviewer">
                            Reviewer name
                        </h5>
                        <p class="review-date">
                            Date: 01-01-2014
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque.
                        </p>
                    </div>
                    <div class="review">
                        <p class="rating">
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star light-red">
                            </i>
                            <i class="fa fa-star-half-o gray">
                            </i>
                            <i class="fa fa-star-o gray">
                            </i>
                        </p>
                        <h5 class="reviewer">
                            Reviewer name
                        </h5>
                        <p class="review-date">
                            Date: 01-01-2014
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a eros neque. In sapien est, malesuada non interdum id, cursus vel neque.
                        </p>
                    </div>
                </div>
                <div class="tab-content" id="tags">
                    <?php echo $product_detail->technical ?>
                </div>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <div id="productsDetails" class="hot-products">
            <h3 class="title">
                <strong>
                    SẢN PHẨM
                </strong>
                CÙNG LOẠI
            </h3>
            <div class="control">
                <a id="prev_hot" class="prev" href="#">
                    &lt;
                </a>
                <a id="next_hot" class="next" href="#">
                    &gt;
                </a>
            </div>
            <ul id="hot">
                
                  <li>
                    <div class="row">
                        <?php
                $this->load->model('Item');
                $cate_id = $this->Item->get_info($product_detail->item_id)->category;
                $similar = $this->category_model->similar($cate_id);
                foreach ($similar as $tag):
                ?>
                      <div class="col-md-4 col-sm-4">
                        <div class="products">
                          <div class="offer">
                            Mới
                          </div>
                          <div class="thumbnail">
                            <?php
                               if($tag->images == NULL){
                            ?>
                              <img src="<?php echo base_url()?>images/noImage.gif" alt="" style="height: 200px;width: 180px;">
                               <?php }else{?>
                              <img src="<?php echo base_url()?>item/<?=$tag->images?>" alt="" style="height: 200px;width: 180px;">
                               <?php }?>
                          </div>
                          <div class="productname">
                            <?php echo $tag->name?>
                          </div>
                          <h4 class="price">
                            <?php
                            $this->load->model('Item');
                               if($this->Item->get_info($tag->item_id)->promo_price > 0){
                                   echo number_format($tag->promo_price);
                               }else{
                                   if($this->Item->get_info($tag->item_id)->unit_from == 0){
                                       echo number_format($tag->unit_price);
                                   }else{
                                       echo number_format($tag->unit_price_rate);
                                   }
                               }
                            ?>
                          </h4>
                          <div class="button_group">
                            <button class="button add-cart" type="button" onclick="window.location = '<?php echo base_url() ?>site/cart/add/<?php echo $tag->item_id ?>'">
                              Thêm vào giỏ hàng
                            </button>
                          </div>
                        </div>
                      </div>
                    <?php endforeach;?>
                    </div>
                  </li>
                </ul>
        </div>
        <div class="clearfix">
        </div>


        <div class="clearfix">
        </div>
        <div class="our-brand">
            <h3 class="title">
                <strong>
                   ĐỐI
                </strong>
                TÁC
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
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
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
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/themeforest.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/photodune.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/activeden.png" alt="">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="brand-logo">
                                    <img src="<?php echo base_url() ?>images/envato.png" alt="">
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php } ?>

