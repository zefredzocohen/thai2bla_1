<?php
include_once 'template/LanguageHelper.php';
$object = new LanguageHelper();
$lang = $object->checkLang();
include_once($lang);
if(isset($_GET['lang'])){
    if($_GET['lang'] == 'vi'){
?>
<div class="clearfix">
</div>
<div class="container_fullwidth">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="category leftbar">
                    <h3 class="title">
                        Thời trang nam
                    </h3>
                    <ul>
                        <?php
                        $this->load->model('site/category_model');
                        $category = $this->category_model->get_all(0);
                        foreach ($category as $male):
                        ?>
                        <li>
                            <a href="<?php echo base_url() ?>loai-san-pham/<?=$male->url?>/<?=$male->id_cat?>">
                                <?= $male->name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="branch leftbar">
                    <h3 class="title">
                        Thời trang nữ
                    </h3>
                    <ul>
                        <?php
                        $category_service = $this->category_model->get_all(1);
                        foreach ($category_service as $female):
                        ?>
                        <li>
                            <a href="<?php echo base_url() ?>loai-san-pham/<?=$female->url?>/<?=$female->id_cat?>">
                                <?=$female->name?>
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="price-filter leftbar">
                    <h3 class="title">
                        Giá
                    </h3>
                    <form class="pricing">
                        <label>
                            $ 
                            <input type="number">
                        </label>
                        <span class="separate">
                            - 
                        </span>
                        <label>
                            $ 
                            <input type="number">
                        </label>
                        <input type="submit" value="Go">
                    </form>
                </div>
                <div class="clolr-filter leftbar">
                    <h3 class="title">
                        Color
                    </h3>
                    <ul>
                        <li>
                            <a href="#" class="red-bg">
                                light red
                            </a>
                        </li>
                        <li>
                            <a href="#" class=" yellow-bg">
                                yellow"
                            </a>
                        </li>
                        <li>
                            <a href="#" class="black-bg ">
                                black
                            </a>
                        </li>
                        <li>
                            <a href="#" class="pink-bg">
                                pink
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dkpink-bg">
                                dkpink
                            </a>
                        </li>
                        <li>
                            <a href="#" class="chocolate-bg">
                                chocolate
                            </a>
                        </li>
                        <li>
                            <a href="#" class="orange-bg">
                                orange-bg
                            </a>
                        </li>
                        <li>
                            <a href="#" class="off-white-bg">
                                off-white
                            </a>
                        </li>
                        <li>
                            <a href="#" class="extra-lightgreen-bg">
                                extra-lightgreen
                            </a>
                        </li>
                        <li>
                            <a href="#" class="lightgreen-bg">
                                lightgreen
                            </a>
                        </li>
                        <li>
                            <a href="#" class="biscuit-bg">
                                biscuit
                            </a>
                        </li>
                        <li>
                            <a href="#" class="chocolatelight-bg">
                                chocolatelight
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="product-tag leftbar">
                    <h3 class="title">
                        Products 
                        <strong>
                            Tags
                        </strong>
                    </h3>
                    <ul>
                        <li>
                            <a href="#">
                                Lincoln us
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                SDress for Girl
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Corner
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Window
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                PG
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Oscar
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Bath room
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                PSD
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="others leftbar">
                    <h3 class="title">
                        Others
                    </h3>
                </div>
                <div class="others leftbar">
                    <h3 class="title">
                        Others
                    </h3>
                </div>
                <div class="fbl-box leftbar">
                    <h3 class="title">
                        Facebook
                    </h3>
                    <span class="likebutton">
                        <a href="#">
                            <img src="<?php echo base_url() ?>images/fblike.png" alt="">
                        </a>
                    </span>
                    <p>
                        12k people like Flat Shop.
                    </p>
                    <ul>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                    </ul>
                    <div class="fbplug">
                        <a href="#">
                            <span>
                                <img src="<?php echo base_url() ?>images/fbicon.png" alt="">
                            </span>
                            Facebook social plugin
                        </a>
                    </div>
                </div>
                <div class="leftbanner">
                    <img src="<?php echo base_url() ?>images/banner-small-01.png" alt="">
                </div>
            </div>
<?php }elseif($_GET['lang'] == 'en'){?>
     <div class="clearfix">
</div>
<div class="container_fullwidth">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="category leftbar">
                    <h3 class="title">
                        FASHION MAN
                    </h3>
                    <ul>
                        <?php
                        $this->load->model('site/category_model');
                        $category = $this->category_model->get_all(0);
                        foreach ($category as $male):
                        ?>
                        <li>
                            <a href="<?php echo base_url() ?>loai-san-pham/<?=$male->url?>/<?=$male->id_cat?>">
                                <?= $male->en_name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="branch leftbar">
                    <h3 class="title">
                        FASHION WOMEN
                    </h3>
                    <ul>
                        <?php
                        $category_service = $this->category_model->get_all(1);
                        foreach ($category_service as $female):
                        ?>
                        <li>
                            <a href="<?php echo base_url() ?>loai-san-pham/<?=$female->url?>/<?=$female->id_cat?>">
                                <?=$female->en_name?>
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="price-filter leftbar">
                    <h3 class="title">
                        Giá
                    </h3>
                    <form class="pricing">
                        <label>
                            $ 
                            <input type="number">
                        </label>
                        <span class="separate">
                            - 
                        </span>
                        <label>
                            $ 
                            <input type="number">
                        </label>
                        <input type="submit" value="Go">
                    </form>
                </div>
                <div class="clolr-filter leftbar">
                    <h3 class="title">
                        Color
                    </h3>
                    <ul>
                        <li>
                            <a href="#" class="red-bg">
                                light red
                            </a>
                        </li>
                        <li>
                            <a href="#" class=" yellow-bg">
                                yellow"
                            </a>
                        </li>
                        <li>
                            <a href="#" class="black-bg ">
                                black
                            </a>
                        </li>
                        <li>
                            <a href="#" class="pink-bg">
                                pink
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dkpink-bg">
                                dkpink
                            </a>
                        </li>
                        <li>
                            <a href="#" class="chocolate-bg">
                                chocolate
                            </a>
                        </li>
                        <li>
                            <a href="#" class="orange-bg">
                                orange-bg
                            </a>
                        </li>
                        <li>
                            <a href="#" class="off-white-bg">
                                off-white
                            </a>
                        </li>
                        <li>
                            <a href="#" class="extra-lightgreen-bg">
                                extra-lightgreen
                            </a>
                        </li>
                        <li>
                            <a href="#" class="lightgreen-bg">
                                lightgreen
                            </a>
                        </li>
                        <li>
                            <a href="#" class="biscuit-bg">
                                biscuit
                            </a>
                        </li>
                        <li>
                            <a href="#" class="chocolatelight-bg">
                                chocolatelight
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="product-tag leftbar">
                    <h3 class="title">
                        Products 
                        <strong>
                            Tags
                        </strong>
                    </h3>
                    <ul>
                        <li>
                            <a href="#">
                                Lincoln us
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                SDress for Girl
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Corner
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Window
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                PG
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Oscar
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Bath room
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                PSD
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="others leftbar">
                    <h3 class="title">
                        Others
                    </h3>
                </div>
                <div class="others leftbar">
                    <h3 class="title">
                        Others
                    </h3>
                </div>
                <div class="fbl-box leftbar">
                    <h3 class="title">
                        Facebook
                    </h3>
                    <span class="likebutton">
                        <a href="#">
                            <img src="<?php echo base_url() ?>images/fblike.png" alt="">
                        </a>
                    </span>
                    <p>
                        12k people like Flat Shop.
                    </p>
                    <ul>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                    </ul>
                    <div class="fbplug">
                        <a href="#">
                            <span>
                                <img src="<?php echo base_url() ?>images/fbicon.png" alt="">
                            </span>
                            Facebook social plugin
                        </a>
                    </div>
                </div>
                <div class="leftbanner">
                    <img src="<?php echo base_url() ?>images/banner-small-01.png" alt="">
                </div>
            </div>       
<?php }?>
<?php }else{?>
            <div class="clearfix">
</div>
<div class="container_fullwidth">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="category leftbar">
                    <h3 class="title">
                        Thời trang nam
                    </h3>
                    <ul>
                        <?php
                        $this->load->model('site/category_model');
                        $category = $this->category_model->get_all(0);
                        foreach ($category as $male):
                        ?>
                        <li>
                            <a href="<?php echo base_url() ?>loai-san-pham/<?=$male->url?>/<?=$male->id_cat?>">
                                <?= $male->name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="branch leftbar">
                    <h3 class="title">
                        Thời trang nữ
                    </h3>
                    <ul>
                        <?php
                        $category_service = $this->category_model->get_all(1);
                        foreach ($category_service as $female):
                        ?>
                        <li>
                            <a href="<?php echo base_url() ?>loai-san-pham/<?=$female->url?>/<?=$female->id_cat?>">
                                <?=$female->name?>
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="price-filter leftbar">
                    <h3 class="title">
                        Giá
                    </h3>
                    <form class="pricing">
                        <label>
                            $ 
                            <input type="number">
                        </label>
                        <span class="separate">
                            - 
                        </span>
                        <label>
                            $ 
                            <input type="number">
                        </label>
                        <input type="submit" value="Go">
                    </form>
                </div>
                <div class="clolr-filter leftbar">
                    <h3 class="title">
                        Color
                    </h3>
                    <ul>
                        <li>
                            <a href="#" class="red-bg">
                                light red
                            </a>
                        </li>
                        <li>
                            <a href="#" class=" yellow-bg">
                                yellow"
                            </a>
                        </li>
                        <li>
                            <a href="#" class="black-bg ">
                                black
                            </a>
                        </li>
                        <li>
                            <a href="#" class="pink-bg">
                                pink
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dkpink-bg">
                                dkpink
                            </a>
                        </li>
                        <li>
                            <a href="#" class="chocolate-bg">
                                chocolate
                            </a>
                        </li>
                        <li>
                            <a href="#" class="orange-bg">
                                orange-bg
                            </a>
                        </li>
                        <li>
                            <a href="#" class="off-white-bg">
                                off-white
                            </a>
                        </li>
                        <li>
                            <a href="#" class="extra-lightgreen-bg">
                                extra-lightgreen
                            </a>
                        </li>
                        <li>
                            <a href="#" class="lightgreen-bg">
                                lightgreen
                            </a>
                        </li>
                        <li>
                            <a href="#" class="biscuit-bg">
                                biscuit
                            </a>
                        </li>
                        <li>
                            <a href="#" class="chocolatelight-bg">
                                chocolatelight
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="product-tag leftbar">
                    <h3 class="title">
                        Products 
                        <strong>
                            Tags
                        </strong>
                    </h3>
                    <ul>
                        <li>
                            <a href="#">
                                Lincoln us
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                SDress for Girl
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Corner
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Window
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                PG
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Oscar
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Bath room
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                PSD
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="others leftbar">
                    <h3 class="title">
                        Others
                    </h3>
                </div>
                <div class="others leftbar">
                    <h3 class="title">
                        Others
                    </h3>
                </div>
                <div class="fbl-box leftbar">
                    <h3 class="title">
                        Facebook
                    </h3>
                    <span class="likebutton">
                        <a href="#">
                            <img src="<?php echo base_url() ?>images/fblike.png" alt="">
                        </a>
                    </span>
                    <p>
                        12k people like Flat Shop.
                    </p>
                    <ul>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                            </a>
                        </li>
                    </ul>
                    <div class="fbplug">
                        <a href="#">
                            <span>
                                <img src="<?php echo base_url() ?>images/fbicon.png" alt="">
                            </span>
                            Facebook social plugin
                        </a>
                    </div>
                </div>
                <div class="leftbanner">
                    <img src="<?php echo base_url() ?>images/banner-small-01.png" alt="">
                </div>
            </div>
<?php }?>
