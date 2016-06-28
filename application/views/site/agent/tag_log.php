<STYLE type="text/css">

    label.error{
        color:red;
    }
</style>
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
                    Thông tin giỏ hàng
                </h3>
                <div class="clearfix">
                </div>
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
                                         echo "<label class='number_product'>". $listProduct['soluong']."</label>";
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
                                    
                                </tr>
                                <?php
                                   $total_money += str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price;
                                   $total_money1 = $total_money+$total_taxes;
                                ?>
                              <?php }?>
                          
                    </tbody>

                    
                      <?php }?>
                    <tr>
                        <td colspan="6" align="right">Tổng tiền: <font color="red"><?php echo number_format($total_money1)?></font></td>
                    </tr>
                    
                </table>
              
            </div>
        </div>
        
        <div class="portlet-body">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>site/cart/save_order_customer" enctype="multipart/form-data">
            <div class="form-row">
                <label class="lebel-abs">
                    Họ tên đệm 
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="first_name" id="first_name" >
            </div>
            <div class="form-row">
                <label class="lebel-abs">
                    Tên 
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="last_name" id="last_name">
            </div>
           
            
           
            <div class="form-row">
                <label class="lebel-abs">
                    Email
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="email" id="email" placeholder="">
            </div>
           
            <div class="form-row">
                <label class="lebel-abs">
                    Số điện thoại
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="phone" id="phone" placeholder="">
            </div>
             <div class="form-row">
                <label class="lebel-abs">
                    Địa chỉ
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="address" id="address" placeholder="">
            </div>
            
           <div class="form-row">
                <label class="lebel-abs">
                    Mã số thuế #
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="account_number" id="account_number" placeholder="">
            </div>
            
           
            <div class="button_group">
                <button class="button add-cart" type="submit">Đặt hàng</button>
                <button class="button add-cart" type="reset">Hủy bỏ</button>
            </div>
            
        </form>
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
                            <td colspan="7">Cart empty</td>
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
                                       echo "<label class='number_product'>". $listProduct['soluong']."</label>";
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
                                    
                                </tr>
                                <?php
                                   $total_money += str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price;
                                   $total_money1 = $total_money+$total_taxes;
                                ?>
                              <?php }?>
                          
                    </tbody>

                   
                         <tr>
                        <td colspan="6" align="right">Total money: <font color="red"><?php echo number_format($total_money1)?></font></td>
                    </tr>
                      <?php }?>
                    
                </table>
                
                
                <div class="clearfix">
                </div>
                <div class="portlet-body">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>site/cart/save_order_customer" enctype="multipart/form-data">
            <div class="form-row">
                <label class="lebel-abs">
                    First name 
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="first_name" id="first_name" >
            </div>
            <div class="form-row">
                <label class="lebel-abs">
                   Last name
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="last_name" id="last_name">
            </div>
           
            
           
            <div class="form-row">
                <label class="lebel-abs">
                    Email
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="email" id="email" placeholder="">
            </div>
           
            <div class="form-row">
                <label class="lebel-abs">
                    Phone
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="phone" id="phone" placeholder="">
            </div>
             <div class="form-row">
                <label class="lebel-abs">
                    Address
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="address" id="address" placeholder="">
            </div>
            <div class="form-row">
                <label class="lebel-abs">
                    Account_number #
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="account_number" id="account_number" placeholder="">
            </div>
           
            
           
            <div class="button_group">
                <button class="button add-cart" type="submit">Order</button>
                <button class="button add-cart" type="reset">Cancle</button>
            </div>
            
        </form>
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
                                      echo "<label class='number_product'>". $listProduct['soluong']."</label>";
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
                                   
                                </tr>
                                <?php
                                   $total_money += str_replace(array(',', '.00'), '', $listProduct['soluong'])*$price;
                                   $total_money1 = $total_money+$total_taxes;
                                ?>
                              <?php }?>
                          
                    </tbody>

                    <tfoot>
                        <tr>
                        <td colspan="6" align="right">Tổng tiền: <font color="red"><?php echo number_format($total_money1)?></font></td>
                    </tr>
                        </tr>
                      <?php }?>
                    </tfoot>
                </table>
               
                <div class="clearfix">
                </div>
                <div class="portlet-body">
        <form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>site/cart/save_order_customer" enctype="multipart/form-data">
            <div class="form-row">
                <label class="lebel-abs">
                    Họ tên đệm 
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="first_name" id="first_name" >
            </div>
            <div class="form-row">
                <label class="lebel-abs">
                    Tên 
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="last_name" id="last_name">
            </div>
           
            
           
            <div class="form-row">
                <label class="lebel-abs">
                    Email
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="email" id="email" placeholder="">
            </div>
           
            <div class="form-row">
                <label class="lebel-abs">
                    Số điện thoại
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="phone" id="phone" placeholder="">
            </div>
             <div class="form-row">
                <label class="lebel-abs">
                    Địa chỉ
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="address" id="address" placeholder="">
            </div>
            <div class="form-row">
                <label class="lebel-abs">
                    Mã số thuế #
                    <strong class="red">
                        *
                    </strong>
                </label>
                <input type="text" class="input namefild" name="account_number" id="account_number" placeholder="">
            </div>
            <div class="button_group">
                <button class="button add-cart" type="submit">Đặt hàng</button>
                <button class="button add-cart" type="reset">Hủy bỏ</button>
            </div>
            
        </form>
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

<script type="text/javascript">
    $(document).ready(function () {
        var validator = $(".form-horizontal").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                address: "required",
                company: "required",
                manage_name: "required",
                phone: {
                    required: true,
                    number: true
                },
                
            },
            messages: {
                first_name: "Họ tên đệm cần nhập",
                last_name: "Tên cần nhập",
                email: {
                    required: "Email cần nhập",
                    email: "Địa chỉ email không hợp lệ"
                },
                address: "Địa chỉ cần nhập",
                company: "Tên đại lý cần nhập",
                manage_name: "Người đại diện cần nhập",
                password: {
                    required: "Mật khẩu cần nhập",
                    minlength: "Mật khẩu ít nhất là 8 ký tự"
                },
                phone: {
                    required: "Số điện thoại cần nhập",
                    number: "Số điện thoại phải là số"
                },
                
            }
        });
    })
</script>  