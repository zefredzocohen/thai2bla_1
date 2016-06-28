<div id='cook-table'>
<!-- CATEGORIES -->
<?php echo 'tesst   aaaaaaaaaa ';var_dump($is_promo);?>
    <div id="dat-hang" class="container-fluid" style="background:url('<?php echo base_url(); ?>images/bg-categories.png') no-repeat top center">
        <div class="container text-center">
            <ul class="list-inline col-sm-12 sliderload">
            <?php
                if (isset($categories)) {
                    foreach ($categories as $category) {
            ?>
                        <li class="col-md-6 col-xs-4">
                            <a href="<?php echo base_url(); ?>thuc-don/<?php echo $category->url ?>.html">
                                <div class="category-thumb">
                                    <img src="<?php echo base_url(); ?><?php echo $category->image ?>" class="img-responsive">
                                </div>
                                <span><?php echo $category->name ?></span>
                            </a>
                        </li>
            <?php
                    }
                }
            ?>
            </ul>
        </div>
    </div>
<!-- PRODUCT -->
    <div id="product" class="container-fluid">
        <div class="container">
            <div class="grid-product col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <?php
                $now_date = date('Y/m/d');
                    if (isset($items)) {
                        foreach ($items as $item) {
                            if(strtotime($now_date)<=strtotime($item->end_date)&&
                                           strtotime($now_date)>=strtotime($item->start_date)){
                                            $price=$item->promo_price;
                                        }
                                            else $price=$item->unit_price;
                ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="detail-extra click-expand">
                                <div class="hover_event" id="p<?php echo $item->item_id ?>">
                                    <div class="product-thumb">
                                        <img src="<?php echo base_url(); ?>item/<?php echo $item->images ?>" class="img-responsive">
                                    </div>
                                    <div class="product-info text-uppercase">
                                        <h2 class="pull-left"><?php echo $item->name ?></h2>
                                        <span class="pull-right" style="width:70px;"><?php echo number_format($price); ?>VNĐ</span>
                                        <span class="solid-space"></span>
                                    </div>
                                    <div class="product-description items p<?php echo $item->item_id ?>" id="item<?php echo $item->item_id ?>">
                                        <h2 class="text-uppercase"><?php echo $item->name ?></h2>
                                        <div class="dot-line"></div>
                                        <ul>
                                        <?php
                                            foreach (explode('-', $item->description) as $des) {
                                                if (trim($des) != '') {
                                        ?>
                                                    <li><?php echo $des ?></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                        </ul>
                                        <div class="dot-line"></div>
                                        <!-- <span class="text-uppercase">Giá: <?php echo $item->unit_price ?>VNĐ</span>
                                        <div class="dot-line"></div> -->
                                    </div>
                                </div>
                                <a href="javascript:void(0)" onclick="addItemToCart(<?php echo $item->item_id ?>)"><div class="btn-chon-mon text-center text-uppercase">chọn món này</div></a>
                            </div>
                        </div>
            <?php
                    }
                }
            ?>
                <div class="clearfix"></div>
                <!-- Pagination -->
                <nav id="product-pagination" class="text-center">
                    <?php echo $pagination;?>
                </nav>
            </div>
            <div class="sidebar-right  col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="select-shop col-lg-12 col-sm-12">
                    <h3 class="text-uppercase">mời bạn chọn cửa hàng trước khi chọn món</h3>
                    <?php echo form_dropdown('inventory_id', $inventories, '', 'class="selectpicker"'); ?>
                </div>
                <div class="table-pay col-lg-12 col-sm-12">
                    <h3 class="text-uppercase">phần ăn bạn đã chọn</h3>
                    <div class="dot-line"></div>
                    <h4 class="text-center">Bạn hãy đặt hàng trực tuyến từ 9h00” đến 21h hàng ngày</h4>
                    <div class="dot-line marginBottom40"></div>
                    <div class="cart-item <?php if ( !isset( $cart ) || count($cart) == 0 ) echo 'text-center' ?>">
                        <?php
                            $html = 'Giỏ hàng rỗng';$now_date = date('Y/m/d');
                            if ( isset( $cart ) && count($cart) > 0 ) {
                                $totalPrice = 0;
                                $html = '';
                                foreach ($cart as $key => $itemCart) {
                                    //hải zero
                                //check promo_price
                                    
                                    if(strtotime($now_date)<=strtotime($itemCart['end_date'])&&strtotime($now_date)>=strtotime($itemCart['start_date'])){
                                            $real_price=$itemCart['promo_price'];
                                        }
                                    else $real_price=$itemCart['unit_price'];
                                    $html .= '<div class="add-cart">';
                                    $html .= '<span class="remover-cart" onclick="removeItemFromCart('.$key.')"></span>';
                                    $html .= '<span class="text-uppercase pull-left">'.$itemCart['name'].'</span>';
                                    $html .= '<div class="text-right">';
                                    $html .=     '<label class="label-qty">Số lượng:</label>';
                                    $html .=     '<input type="number" class="qty form-control" placeholder="1" value="'.$itemCart['soluong'].'" onchange="changeQuantityItemFromCart('.$key.', this.value)">';
                                    $html .= '</div>';
                                    
                                    $html .= '<p class="text-right"><span class="label-price">Giá:</span><span>'.number_format($real_price*$itemCart['soluong']).' vnđ</span></p>';
                                    $html .= '</div>';
                                    $html .= '<div class="dot-line"></div>';

                                    $totalPrice += $real_price*$itemCart['soluong']; 
                                }
                            }
                            echo $html;
                        ?>
                    </div>
                    <div class="dot-line line-mCart"></div>
                    <ul class="list-unstyled note-order">
                        <li><span class="list-note"></span>Đơn hàng tối thiểu 80.000</li>
                        <li><span class="list-note"></span>Miễn phí giao hàng</li>
                    </ul>
                    <div class="dot-line"></div>
                    <div class="btn count-pay"><span class="text-uppercase pull-left">Tổng:</span><span class="pull-left total-price"><?php echo isset($totalPrice) ? $totalPrice : 0; ?></span><span>VNĐ</span></div><br>
                    <a href="#" class="order-product" data-toggle="modal" data-target="#popup_order"><div class="text-center"><span class="text-uppercase">Đặt hàng</span></div></a>
                </div>
            </div>
        </div>
    </div>
<!-- SHIPPING -->
    <div id="shipping" class="container-fluid" style="background:url('<?php echo base_url(); ?>upload/banner/banner-shipping.png') no-repeat top center;">
        <div class="container text-center">
            <div class="shipper">
                <img src="<?php echo base_url(); ?>images/bg-shipping.png" class="img-responsive">
            </div>
            <div class="order"></div>
            <a href="thuc-don.html" class="link-order">
                <span class="text-uppercase">đặt hàng</span>
                <span class="text-uppercase">tại đây</span>
            </a>
            <div class="call-hotline text-left">
                <p>
                    <span>hoặc</span>
                    <span class=" text-uppercase">gọi số điện </span>
                    <span>
                        <?php foreach ($hotline as $key => $hotlines) { 
                            if ($key == 0) {
                                echo $hotlines->phone;
                            }
                        } ?>
                    </span><br>
                    <span class="service-tan-rang">để được phục vụ " tận răng "</span>
                </p>
            </div>
        </div>
    </div>
<!-- Popup order -->
    <div class="modal fade" id="popup_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">đặt hàng trực tuyến</h4>
          </div>
          <div class="modal-body">
            <div class="">
                <form id="dathangtructuyen">
                  <div class="form-group">
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Họ và tên">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="address_1" name="address_1" placeholder="Địa chỉ">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="address_2" name="address_2" placeholder="Thành phố">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Số điện thoại">
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <!--?php echo form_dropdown('stored_id', $inventories, '', 'class="form-control"'); ? -->
                    <input type="hidden" id="stored_id" name="stored_id" value="" />
                    <button type="submit" class="form-control text-uppercase" style="width: 50%;margin: 0 auto;">Đặt hàng</button>
                  </div>
                  </form>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Javascript Hover Products multiple elementID -->
<script type="text/javascript">
function formatNumber(number)
{
    number = number.toFixed(0) + '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
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
    $(".hover_event").mouseover(function() {
      $(".items").css("opacity", 0);
      $(".items").css("height", 'auto');
      $(".detail-extra").css("z-index", '-1');
      $(".product-description").css("z-index", '1');
      id = $(this).attr('id');
      $("."+id).css("opacity", 1);
    }).mouseleave(function() {
        id = $(this).attr('id');
        $(".items").addClass('trs');
        $(".items").css("height", 'auto');
        $("."+id).css("opacity", 0);
        $(".detail-extra").css("z-index", '1');
        $(".product-description").css("z-index", '-1');
    });

    function addItemToCart(item_id) {
        $.post('<?php echo base_url(); ?>site/cart/addItemToCart', { item_id: item_id }, function(data){
            var obj = jQuery.parseJSON( data );
            var html = '';
            var totalPrice = 0;
            $.each(obj, function(key, item){
                html += '<div class="add-cart">';
                html += '<span class="remover-cart" onclick="removeItemFromCart('+key+')"></span>';
                html += '<span class="text-uppercase pull-left">'+item.name+'</span>';
                html += '<div class="text-right">';
                html +=     '<label class="label-qty">Số lượng:</label>';
                html +=     '<input type="number" class="qty form-control" placeholder="1" value="'+item.soluong+'" onchange="changeQuantityItemFromCart('+key+', this.value)">';
                html += '</div>';
                var gia = item.real_price*item.soluong;
               
                html += '<p class="text-right"><span class="label-price">Giá:</span><span>'+ formatNumber(gia); +' vnđ</span></p>';
                html += '</div>';
                html += '<div class="dot-line"></div>';

                totalPrice += item.real_price*item.soluong;
            })
            $('.total-price').html(formatNumber(totalPrice));

            $('.cart-item').html(html);
        })
    }

    function removeItemFromCart(item_id) {
        $.post('<?php echo base_url(); ?>site/cart/removeItemFromCart', { item_id: item_id }, function(data){
            var obj = jQuery.parseJSON( data );
            var html = '';
            var totalPrice = 0;
            $.each(obj, function(key, item){
                html += '<div class="add-cart">';
                html += '<span class="remover-cart" onclick="removeItemFromCart('+key+')"></span>';
                html += '<span class="text-uppercase pull-left">'+item.name+'</span>';
                html += '<div class="text-right">';
                html +=     '<label class="label-qty">Số lượng:</label>';
                html +=     '<input type="number" class="qty form-control" placeholder="1" value="'+item.soluong+'" onchange="changeQuantityItemFromCart('+key+', this.value)">';
                html += '</div>';
                var gia = item.real_price*item.soluong
                html += '<p class="text-right"><span class="label-price">Giá:</span><span>'+formatNumber(gia) +' vnđ</span></p>';
                html += '</div>';
                html += '<div class="dot-line"></div>';

                totalPrice += item.real_price*item.soluong;
            })
            $('.total-price').html(formatNumber(totalPrice));
            $('.cart-item').html(html);
        })
    }

    function changeQuantityItemFromCart(item_id, quantity) {
        $.post('<?php echo base_url(); ?>site/cart/changeQuantityItemFromCart', { item_id: item_id, quantity: quantity }, function(data){
            var obj = jQuery.parseJSON( data );
            var html = '';
            var totalPrice = 0;
            $.each(obj, function(key, item){
                html += '<div class="add-cart">';
                html += '<span class="remover-cart" onclick="removeItemFromCart('+key+')"></span>';
                html += '<span class="text-uppercase pull-left">'+item.name+'</span>';
                html += '<div class="text-right">';
                html +=     '<label class="label-qty">Số lượng:</label>';
                html +=     '<input type="number" class="qty form-control" placeholder="1" value="'+item.soluong+'" onchange="changeQuantityItemFromCart('+key+', this.value)">';
                html += '</div>';
                var gia = item.real_price*item.soluong;
                
                html += '<p class="text-right"><span class="label-price">Giá:</span><span>'+formatNumber(gia)+' vnđ</span></p>';
                html += '</div>';
                html += '<div class="dot-line"></div>';

                totalPrice += item.real_price*item.soluong;
            })
            $('.total-price').html(formatNumber(totalPrice));
            $('.cart-item').html(html);
        })
    }

    $(function(){
        $('select[name=inventory_id]').change(function(){
            var curInven = $(this).val();
            $('input[name=stored_id]').val(curInven);
        });
        // $('select[name=stored_id]').change(function(){
        //     var curInven = $(this).val();
        //     $('select[name=inventory_id]').val(curInven);
        // });
        $('#dathangtructuyen').submit(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>site/cart/save_order_customer',
                data: $( this ).serializeArray(),
                success: function(resp){
                    if (resp.success) {
                        alert('Mua hàng thành công!');
                        window.location.reload(true);
                    }
                    if (resp.error) {
                        alert(resp.error);
                    }
                },
                dataType: 'json'
            });
        });
    })
</script>
