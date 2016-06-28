<?php
include_once 'template/LanguageHelper.php';
$object = new LanguageHelper();
$lang = $object->checkLang();
include_once($lang);
if(isset($_GET['lang'])){
    if($_GET['lang'] == 'vi'){
?>
<script type="text/javascript">
    function clear_cart() {
        var result = confirm('Bạn có muốn xóa giỏ hàng ?');
        if (result)
        {
            window.location = "<?php echo base_url('site/cart/remove_all'); ?>";
        }
        else {
            return false;
        }
    }

</script> 
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container shopping-cart">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title">
                    Giỏ hàng của bạn
                </h3>
                <div class="clearfix">
                </div>
                <form action="<?php echo base_url() ?>gio-hang.html" method="post">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <th>
                                Hình ảnh
                            </th>
                            <th>
                                Mô tả
                            </th>
                            <th>
                                Giá
                            </th>
                            <th>
                                Thuế(%)
                            </th>
                            <th>
                                Số lượng
                            </th>
                           
                            <th>
                                Thành tiền
                            </th>
                            <th>
                                Xóa
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_money = 0;
                            $total_money1 = 0;
                            $this->load->model('site/category_model');
                            $this->load->model('Unit');

                            $taxes = 0;
                            $total_taxes = 0;
                             if ($_SESSION['cart'] == NULL) {
                            ?>
                        <tr>
                            <td colspan="7">Giỏ hàng của bạn chưa có sản phẩm nào</td>
                        </tr>
                            <?php 
                             }else{
                                 foreach ($_SESSION['cart'] as $listProduct) {
                                 ?>
                                <tr>
                                    <td>
                                        <?php
                                           if($listProduct['images'] == NULL){
                                        ?>
                                        <img src="<?php echo base_url() ?>images/noImage.gif" alt="">
                                         <?php }else{?>
                                        <img src="<?php echo base_url() ?>item/<?php echo $listProduct['images']?>" alt="">
                                         <?php }?>
                                        
                                    </td>
                                    <td>
                                        <div class="shop-details">
                                            <div class="productname">
                                               <?php echo $listProduct['name'];?>
                                            </div>
                                            <p>
                                                <img alt="" src="<?php echo base_url() ?>images/star.png">
                                                <a class="review_num" href="#">
                                                    02 Review(s)
                                                </a>
                                            </p>
                                            <div class="color-choser">
                                                <span class="text">
                                                    Product Color : 
                                                </span>
                                                <ul>
                                                    <li>
                                                        <a class="black-bg " href="#">
                                                            black
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="red-bg" href="#">
                                                            light red
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p>
                                                Product Code : 
                                                <strong class="pcode">
                                                    Dress 120
                                                </strong>
                                            </p>
                                        </div>
                                    </td>
                                     <?php
                                            if ($this->category_model->get_info($listProduct['item_id'])->promo_price > 0) {
                                                $price = $this->category_model->get_info($listProduct['item_id'])->promo_price;
                                            } else {
                                                if ($this->category_model->get_info($listProduct['item_id'])->unit_from == 0) {
                                                     $price = $listProduct['unit_price'];
                                                } else {
                                                     $price = $listProduct['unit_price_rate'];
                                                }
                                            }
                                    ?>
                                    <td>
                                        <h5>
                                           <?php echo number_format($price);?>
                                        </h5>
                                    </td>
                                    <td>
                                       <?php echo number_format($this->category_model->get_info($listProduct['item_id'])->taxes);?>
                                    </td>
                                    <td>
                                       <?php 
                                       echo "<input type='text' name='number[" . $listProduct['item_id'] . "]' value='" . $listProduct['soluong'] . "' size='10' class='number_product'/>";
                                       ?>
                                    </td>
                                    <?php
                                         $taxes = ($price * $listProduct['soluong'] - $price * $listProduct['soluong'] * 0) * $this->category_model->get_info($listProduct['item_id'])->taxes / 100;
                                    $total_taxes += $taxes;
                                    ?>
                                    <td>
                                        <h5>
                                            <strong class="red">
                                                <?php
                                                  echo number_format((str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price) + $taxes);
                                                ?>
                                            </strong>
                                        </h5>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url()?>site/cart/del_cart/<?php echo $listProduct['item_id']?>">
                                            <img src="<?php echo base_url() ?>images/remove.png" alt="">
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                   $total_money += str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price;
                                   $total_money1 = $total_money+$total_taxes;
                                ?>
                              <?php }?>
                          
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <button class="pull-left" onclick="window.location='<?php echo base_url()?>'">
                                    Mua tiếp
                                </button>
                                <button class=" pull-right" type="submit">
                                    Cập nhật giỏ hàng
                                </button>
                               
                                <button class="pull-left" onclick="clear_cart()" style="margin-left:20px; " type="button">
                                    Xóa giỏ hàng
                                </button>
                            </td>
                        </tr>
                      <?php }?>
                    </tfoot>
                </table>
                </form>
                <div class="clearfix">
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <h5>
                                Estimate Shipping And Tax
                            </h5>
                            <form>
                                <label>
                                    Select Country *
                                </label>
                                <select class="">
                                    <option value="AL">
                                        Alabama
                                    </option>

                                    <option value="WY">
                                        Wyoming
                                    </option>
                                </select>
                                <label>
                                    State / Province *
                                </label>
                                <select class="">
                                    <option value="WV">
                                        West Virginia
                                    </option>
                                    <option value="WI">
                                        Wisconsin
                                    </option>
                                    <option value="WY">
                                        Wyoming
                                    </option>
                                </select>
                                <div class="clearfix">
                                </div>
                                <button>
                                    Get A Qoute
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <h5>
                                Discount Codes
                            </h5>
                            <form>
                                <label>
                                    Enter your coupon code if you have one
                                </label>
                                <input type="text" name="">
                                <div class="clearfix">
                                </div>
                                <button>
                                    Get A Qoute
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <div class="grandtotal">
                                <h5>
                                    TỔNG TIỀN 
                                </h5>
                                <span>
                                    <?php echo number_format($total_money1);?>
                                </span>
                            </div>
                            <?php
                              if(!$_SESSION['user']){
                            ?>
                            <button onclick="window.location='<?php echo base_url()?>site/agent/tag_log'">
                               Đặt hàng
                            </button>
                              <?php }else{?>
                            <button onclick="window.location='<?php echo base_url()?>site/cart/save_order'">
                                       Đặt hàng
                            </button>
                              <?php }?>
                        </div>
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
    <?php }elseif($_GET['lang'] == 'en'){?>
<script type="text/javascript">
    function clear_cart() {
        var result = confirm('Are you sure delete all cart ?');
        if (result)
        {
            window.location = "<?php echo base_url('site/cart/remove_all'); ?>";
        }
        else {
            return false;
        }
    }

</script> 
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container shopping-cart">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title">
                    Your cart
                </h3>
                <div class="clearfix">
                </div>
                <form action="<?php echo base_url() ?>gio-hang.html" method="post">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <th>
                                Image
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Taxes(%)
                            </th>
                            <th>
                                Quantity
                            </th>
                           
                            <th>
                                Money
                            </th>
                            <th>
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_money = 0;
                            $total_money1 = 0;
                            $this->load->model('site/category_model');
                            $this->load->model('Unit');

                            $taxes = 0;
                            $total_taxes = 0;
                             if ($_SESSION['cart'] == NULL) {
                            ?>
                        <tr>
                            <td colspan="7">Giỏ hàng của bạn chưa có sản phẩm nào</td>
                        </tr>
                            <?php 
                             }else{
                                 foreach ($_SESSION['cart'] as $listProduct) {
                                 ?>
                                <tr>
                                    <td>
                                        <?php
                                           if($listProduct['images'] == NULL){
                                        ?>
                                        <img src="<?php echo base_url() ?>images/noImage.gif" alt="">
                                         <?php }else{?>
                                        <img src="<?php echo base_url() ?>item/<?php echo $listProduct['images']?>" alt="">
                                         <?php }?>
                                        
                                    </td>
                                    <td>
                                        <div class="shop-details">
                                            <div class="productname">
                                               <?php echo $listProduct['name'];?>
                                            </div>
                                            <p>
                                                <img alt="" src="<?php echo base_url() ?>images/star.png">
                                                <a class="review_num" href="#">
                                                    02 Review(s)
                                                </a>
                                            </p>
                                            <div class="color-choser">
                                                <span class="text">
                                                    Product Color : 
                                                </span>
                                                <ul>
                                                    <li>
                                                        <a class="black-bg " href="#">
                                                            black
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="red-bg" href="#">
                                                            light red
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p>
                                                Product Code : 
                                                <strong class="pcode">
                                                    Dress 120
                                                </strong>
                                            </p>
                                        </div>
                                    </td>
                                     <?php
                                            if ($this->category_model->get_info($listProduct['item_id'])->promo_price > 0) {
                                                $price = $this->category_model->get_info($listProduct['item_id'])->promo_price;
                                            } else {
                                                if ($this->category_model->get_info($listProduct['item_id'])->unit_from == 0) {
                                                     $price = $listProduct['unit_price'];
                                                } else {
                                                     $price = $listProduct['unit_price_rate'];
                                                }
                                            }
                                    ?>
                                    <td>
                                        <h5>
                                           <?php echo number_format($price);?>
                                        </h5>
                                    </td>
                                    <td>
                                       <?php echo number_format($this->category_model->get_info($listProduct['item_id'])->taxes);?>
                                    </td>
                                    <td>
                                       <?php 
                                       echo "<input type='text' name='number[" . $listProduct['item_id'] . "]' value='" . $listProduct['soluong'] . "' size='10' class='number_product'/>";
                                       ?>
                                    </td>
                                    <?php
                                         $taxes = ($price * $listProduct['soluong'] - $price * $listProduct['soluong'] * 0) * $this->category_model->get_info($listProduct['item_id'])->taxes / 100;
                                    $total_taxes += $taxes;
                                    ?>
                                    <td>
                                        <h5>
                                            <strong class="red">
                                                <?php
                                                  echo number_format((str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price) + $taxes);
                                                ?>
                                            </strong>
                                        </h5>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url()?>site/cart/del_cart/<?php echo $listProduct['item_id']?>">
                                            <img src="<?php echo base_url() ?>images/remove.png" alt="">
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                   $total_money += str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price;
                                   $total_money1 = $total_money+$total_taxes;
                                ?>
                              <?php }?>
                          
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <button class="pull-left" onclick="window.location='<?php echo base_url()?>'">
                                   Buy purchase
                                </button>
                                <button class=" pull-right" type="submit">
                                    Update cart
                                </button>
                               
                                <button class="pull-left" onclick="clear_cart()" style="margin-left:20px; " type="button">
                                   Delete cart
                                </button>
                            </td>
                        </tr>
                      <?php }?>
                    </tfoot>
                </table>
                </form>
                <div class="clearfix">
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <h5>
                                Estimate Shipping And Tax
                            </h5>
                            <form>
                                <label>
                                    Select Country *
                                </label>
                                <select class="">
                                    <option value="AL">
                                        Alabama
                                    </option>

                                    <option value="WY">
                                        Wyoming
                                    </option>
                                </select>
                                <label>
                                    State / Province *
                                </label>
                                <select class="">
                                    <option value="WV">
                                        West Virginia
                                    </option>
                                    <option value="WI">
                                        Wisconsin
                                    </option>
                                    <option value="WY">
                                        Wyoming
                                    </option>
                                </select>
                                <div class="clearfix">
                                </div>
                                <button>
                                    Get A Qoute
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <h5>
                                Discount Codes
                            </h5>
                            <form>
                                <label>
                                    Enter your coupon code if you have one
                                </label>
                                <input type="text" name="">
                                <div class="clearfix">
                                </div>
                                <button>
                                    Get A Qoute
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <div class="grandtotal">
                                <h5>
                                    TỔNG TIỀN 
                                </h5>
                                <span>
                                    <?php echo number_format($total_money1);?>
                                </span>
                            </div>
                           <?php
                              if(!$_SESSION['user']){
                            ?>
                            <button onclick="window.location='<?php echo base_url()?>site/agent/tag_log'">
                               Order
                            </button>
                              <?php }else{?>
                            <button onclick="window.location='<?php echo base_url()?>site/cart/save_order'">
                                      Order
                            </button>
                              <?php }?>
                        </div>
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
    <?php }?>
<?php }else{?>
<script type="text/javascript">
    function clear_cart() {
        var result = confirm('Bạn có muốn xóa giỏ hàng ?');
        if (result)
        {
            window.location = "<?php echo base_url('site/cart/remove_all'); ?>";
        }
        else {
            return false;
        }
    }

</script> 
<div class="clearfix"></div>
<div class="container_fullwidth">
    <div class="container shopping-cart">
        <div class="row">
            <div class="col-md-12">
                <h3 class="title">
                    Giỏ hàng của bạn
                </h3>
                <div class="clearfix">
                </div>
                <form action="<?php echo base_url() ?>gio-hang.html" method="post">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <th>
                                Hình ảnh
                            </th>
                            <th>
                                Mô tả
                            </th>
                            <th>
                                Giá
                            </th>
                            <th>
                                Thuế(%)
                            </th>
                            <th>
                                Số lượng
                            </th>
                           
                            <th>
                                Thành tiền
                            </th>
                            <th>
                                Xóa
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_money = 0;
                            $total_money1 = 0;
                            $this->load->model('site/category_model');
                            $this->load->model('Unit');

                            $taxes = 0;
                            $total_taxes = 0;
                             if ($_SESSION['cart'] == NULL) {
                            ?>
                        <tr>
                            <td colspan="7">Giỏ hàng của bạn chưa có sản phẩm nào</td>
                        </tr>
                            <?php 
                             }else{
                                 foreach ($_SESSION['cart'] as $listProduct) {
                                 ?>
                                <tr>
                                    <td>
                                        <?php
                                           if($listProduct['images'] == NULL){
                                        ?>
                                        <img src="<?php echo base_url() ?>images/noImage.gif" alt="">
                                         <?php }else{?>
                                        <img src="<?php echo base_url() ?>item/<?php echo $listProduct['images']?>" alt="">
                                         <?php }?>
                                        
                                    </td>
                                    <td>
                                        <div class="shop-details">
                                            <div class="productname">
                                               <?php echo $listProduct['name'];?>
                                            </div>
                                            <p>
                                                <img alt="" src="<?php echo base_url() ?>images/star.png">
                                                <a class="review_num" href="#">
                                                    02 Review(s)
                                                </a>
                                            </p>
                                            <div class="color-choser">
                                                <span class="text">
                                                    Product Color : 
                                                </span>
                                                <ul>
                                                    <li>
                                                        <a class="black-bg " href="#">
                                                            black
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="red-bg" href="#">
                                                            light red
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p>
                                                Product Code : 
                                                <strong class="pcode">
                                                    Dress 120
                                                </strong>
                                            </p>
                                        </div>
                                    </td>
                                     <?php
                                            if ($this->category_model->get_info($listProduct['item_id'])->promo_price > 0) {
                                                $price = $this->category_model->get_info($listProduct['item_id'])->promo_price;
                                            } else {
                                                if ($this->category_model->get_info($listProduct['item_id'])->unit_from == 0) {
                                                     $price = $listProduct['unit_price'];
                                                } else {
                                                     $price = $listProduct['unit_price_rate'];
                                                }
                                            }
                                    ?>
                                    <td>
                                        <h5>
                                           <?php echo number_format($price);?>
                                        </h5>
                                    </td>
                                    <td>
                                       <?php echo number_format($this->category_model->get_info($listProduct['item_id'])->taxes);?>
                                    </td>
                                    <td>
                                       <?php 
                                       echo "<input type='text' name='number[" . $listProduct['item_id'] . "]' value='" . $listProduct['soluong'] . "' size='10' class='number_product'/>";
                                       ?>
                                    </td>
                                    <?php
                                         $taxes = ($price * $listProduct['soluong'] - $price * $listProduct['soluong'] * 0) * $this->category_model->get_info($listProduct['item_id'])->taxes / 100;
                                    $total_taxes += $taxes;
                                    ?>
                                    <td>
                                        <h5>
                                            <strong class="red">
                                                <?php
                                                  echo number_format((str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price) + $taxes);
                                                ?>
                                            </strong>
                                        </h5>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url()?>site/cart/del_cart/<?php echo $listProduct['item_id']?>">
                                            <img src="<?php echo base_url() ?>images/remove.png" alt="">
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                   $total_money += str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price;
                                   $total_money1 = $total_money+$total_taxes;
                                ?>
                              <?php }?>
                          
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <button class="pull-left" onclick="window.location='<?php echo base_url()?>'">
                                    Mua tiếp
                                </button>
                                <button class=" pull-right" type="submit">
                                    Cập nhật giỏ hàng
                                </button>
                               
                                <button class="pull-left" onclick="clear_cart()" style="margin-left:20px; " type="button">
                                    Xóa giỏ hàng
                                </button>
                            </td>
                        </tr>
                      <?php }?>
                    </tfoot>
                </table>
                </form>
                <div class="clearfix">
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <h5>
                                Estimate Shipping And Tax
                            </h5>
                            <form>
                                <label>
                                    Select Country *
                                </label>
                                <select class="">
                                    <option value="AL">
                                        Alabama
                                    </option>

                                    <option value="WY">
                                        Wyoming
                                    </option>
                                </select>
                                <label>
                                    State / Province *
                                </label>
                                <select class="">
                                    <option value="WV">
                                        West Virginia
                                    </option>
                                    <option value="WI">
                                        Wisconsin
                                    </option>
                                    <option value="WY">
                                        Wyoming
                                    </option>
                                </select>
                                <div class="clearfix">
                                </div>
                                <button>
                                    Get A Qoute
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <h5>
                                Discount Codes
                            </h5>
                            <form>
                                <label>
                                    Enter your coupon code if you have one
                                </label>
                                <input type="text" name="">
                                <div class="clearfix">
                                </div>
                                <button>
                                    Get A Qoute
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="shippingbox">
                            <div class="grandtotal">
                                <h5>
                                    TỔNG TIỀN 
                                </h5>
                                <span>
                                    <?php echo number_format($total_money1);?>
                                </span>
                            </div>
                             <?php
                              if(!$_SESSION['user']){
                            ?>
                            <button onclick="window.location='<?php echo base_url()?>site/agent/tag_log'">
                               Đặt hàng
                            </button>
                              <?php }else{?>
                            <button onclick="window.location='<?php echo base_url()?>site/cart/save_order'">
                                       Đặt hàng
                            </button>
                              <?php }?>
                        </div>
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
<?php }?>