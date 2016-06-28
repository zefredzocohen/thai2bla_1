<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="error_message_box"></div>
<?php echo form_open_multipart('item_kits/save_estimate/' . $item_kit_info->item_kit_id, array('id' => 'item_kit_form_estimate')); ?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_info"); ?></legend>
    <div style="width: 230px; float: right;">       
        <?php
        if ($item_kit_info->images != '') {
            echo form_label(lang('item_kits_add_images') . ':', 'item_kit_image', array('class' => 'wide', 'style' => 'font-weight: bold; font-size: 0.95em!important;'));
            ?>
            <div class="field_row clearfix" style="border-bottom:none">
                <div class='form_field' style="width: 40px;float: right;margin-right: 110px;">
                    <img src="<?php echo base_url() . 'item_kits/' . $item_kit_info->images ?>" style="width:100px; height:100px" />
                </div>
            </div>
<?php } ?>           
    </div>
    <div class="field_row clearfix" style="width: 400px;  float: left;">
<?php echo form_label('Mã sản phẩm:', 'name', array('class' => 'wide')); ?>
        <div class='form_field' style="font-weight: normal; color: red"><?php echo $item_kit_info->item_kit_number; ?></div>
        <input type="hidden" name="item_kit_number" value="<?php echo $item_kit_info->item_kit_number; ?>">
    </div>        
    <div class="field_row clearfix" style="width: 400px;  float: left;">
<?php echo form_label(lang('item_kits_name') . ':', 'name', array('class' => 'wide')); ?>
        <div class='form_field' style="font-weight: normal;"><?php echo $item_kit_info->name; ?></div>
    </div>
    <!-- phan goi san pham dat hang hay mau -->
    <!--
    <?php if ($item_kit_info->order != null) { ?>
                <div class="field_row clearfix" style="width: 400px;  float: left;">
        <?php echo form_label(lang('item_kits_order') . ':', 'item_kits_order'); ?>
    <?php if ($item_kit_info->order == 0) { ?>
                                <div class='form_field'>
                                    <select name="item_kits_order" style="width: 202px;">
                                        <option value="0" selected="selected" >Bộ sản phẩm mẫu</option>
                                        <option value="1">Bộ sản phẩm khách đặt </option>
                                    </select>
                                </div>
    <?php } else { ?>
                                <select name="item_kits_order" style="width: 202px;">
                                    <option value="0">Bộ sản phẩm mẫu</option>
                                    <option value="1" selected="selected" >Bộ sản phẩm khách đặt</option>
                                </select>
        <?php } ?>
                </div>
    <?php } else { ?>
                <div class="field_row clearfix" style="width: 400px;  float: left;">
    <?php echo form_label(lang('item_kits_order') . ':', 'item_kits_order'); ?>
                    <div class='form_field'>
                        <select name="item_kits_order" style="width: 202px;">
                            <option value="0">Bộ sản phẩm mẫu</option>
                            <option value="1">Bộ sản phẩm khách đặt</option>
                        </select>
                    </div>
                </div>
<?php } ?>
    -->
    <!-- end dat hang mau -->
    <!-- phan category item -->   
    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('items_category') . ':', 'category', array('class' => 'wide')); ?>
        <div class='form_field' style="font-weight: normal;">         
            <?php
            $this->load->model('Category');
            $cats = $this->Category->get_info($item_kit_info->category);
            echo $cats->name;
            ?>
        </div>
    </div>
    <!-- end category item -->
        <?php if ($item_kit_info->description != "") { ?>
        <div class="field_row clearfix" style="width: 400px;  float: left;">
    <?php echo form_label(lang('item_kits_description') . ':', 'description', array('class' => 'wide')); ?>
            <div class='form_field' style="font-weight: normal;"><?php echo $item_kit_info->description; ?></div>
        </div>
    <?php } ?>
        <?php if ($item_kit_info->location) { ?>
        <div class="field_row clearfix" style="width: 400px;  float: left;">
    <?php echo form_label(lang('items_item_location') . ':', 'location', array('class' => 'wide')); ?>
            <div class='form_field' style="font-weight: normal;"><?php echo $item_kit_info->location; ?></div>
        </div>
<?php } ?>
</fieldset>
<fieldset style="margin-top: 10px;">
    <legend>Công thức sản phẩm</legend>
    <div class="field_row clearfix" style="width: 600px;  float: left;">
            <?php echo form_label('Chọn nguyên vật liệu:', 'item', array('class' => 'wide', 'style' => 'width: 200px')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'item',
                'id' => 'items_kits'
            ));
            ?>
        </div>
    </div>    
    <table id="item_kit_items" style="margin: 20px 0px;">
        <tr>
            <th><?php echo lang('common_delete'); ?></th>
            <th></th>
            <th><?php echo lang('item_kits_item'); ?></th>
            <th><?php echo 'NVL tồn hiện tại'; ?></th>
            <th><?php echo lang('item_kits_quantity'); ?></th>
            <th>SL hao hụt</th>
            <th>Giá nhập NVL (VNĐ)</th>
            <th>Giá xuất NVL (VNĐ)</th>
            <th>Sản phẩm tương ứng</th>
            <th>NVL tồn dự kiến</th>
        </tr>
            <?php foreach ($this->Item_kit_items->get_info($item_kit_info->item_kit_id) as $item_kit_item) { ?>
            <tr>
                <?php
                $info_store = $this->Create_invetory->check_exist_store_materials();
                $item_info = $this->Item->get_info_in_store_material($item_kit_item->item_id, $info_store['id']);
                ?>
                <td><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
                <td><input class="select_checbox" id="item_<?php echo $item_kit_item->item_id ?>" type="checkbox" value="<?php echo $item_kit_item->item_id ?>"/></td>
                <td> <?php echo $item_info->name; ?></td>
                <td>                  
                    <input class="quantity_now" onchange="calculateSuggestedPrices();" id="quantity_now_<?php echo $item_kit_item->item_id ?>" type='text' size="5" name=quantity_now[<?php echo $item_kit_item->item_id ?>] value="<?php echo $item_info->quantity; ?>" readonly/>
                </td>
                <td> 
                    <input class="quantity" onchange="calculateSuggestedPrices();" id="item_kit_item_<?php echo $item_kit_item->item_id ?>" type='text' size='5' name=item_kit_item[<?php echo $item_kit_item->item_id ?>] value='<?php echo $item_kit_item->quantity ?>'/>
                </td>
                <td> 
                    <input class="quantity_loss" onchange="calculateSuggestedPrices();" id="quantity_loss_<?php echo $item_kit_item->item_id ?>" type='text' size='5' name=quantity_loss[<?php echo $item_kit_item->item_id ?>] value='<?php echo $item_kit_item->quantity_loss ?>'/>
                </td>
                <td>                   
                    <input class='cost' onchange="calculateSuggestedPrices();" id='cost_<?php echo $item_kit_item->item_id ?>' type='text' size='9' name=cost[<?php echo $item_kit_item->item_id ?>] value='<?php echo number_format($item_kit_item->cost) ?>' readonly/>
                </td>
                <td>                   
                    <input class='price' onchange="calculateSuggestedPrices();" id='price_<?php echo $item_kit_item->item_id ?>' type='text' size='9' name=price[<?php echo $item_kit_item->item_id ?>] value='<?php echo number_format($item_kit_item->price) ?>' readonly/>
                </td>
                <td>
                    <input class='product_as_item' onchange="calculateSuggestedPrices();" id='product_as_item_<?php echo $item_kit_item->item_id ?>' type='text' size='9' name=product_as_item[<?php echo $item_kit_item->item_id ?>] value='<?php echo $item_kit_item->product_as_item ?>' readonly/>
                </td>
                <td>
                    <input class='quantity_inventory' onchange="calculateSuggestedPrices();" id='quantity_inventory_<?php echo $item_kit_item->item_id ?>' type='text' size='9' name=quantity_inventory[<?php echo $item_kit_item->item_id ?>] value='<?php echo $item_kit_item->quantity_inventory ?>' readonly/>                  
                </td>
            </tr>
<?php } ?>
    </table>
    <!-- phan nhap hang -->
    <?php
    echo anchor("$controller_name/item_kits/trading", lang("supplier_trading"), array(
        'id' => 'trading_item',
        'class' => 'delete_inactive',
        'title' => 'Nhập hàng',
            )
    );
    ?>
    <!-- end phan nhap hang -->
    <div class="field_row clearfix"  style="margin-top: 15px;">
        <?php echo form_label('Chi phí NVL/1SP:', 'cost_price', array('class' => 'wide','style'=>'width: 200px')); ?>
        <div class='form_field'>
            <input type="text" name="cost_price" id="cost_price" readonly value="0" style="text-align: right"/>&nbsp; VND
        </div>
    </div>
    <div class="field_row clearfix">
    <?php echo form_label('Chi phí nhân công/1SP:', 'cost_labor', array('class' => 'wide','style'=>'width: 200px')); ?>
        <div class='form_field'>
            <input type="text" name="cost_labor" id="cost_labor" onchange="calculateSuggestedPrices();" value="<?php echo number_format($item_kit_info->cost_labor);?>" style="text-align: right"/>&nbsp; VND
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Chi phí khác/1SP:', 'cost_other', array('class' => 'wide','style'=>'width: 200px')); ?>
        <div class='form_field'>
            <input type="text" name="cost_other" id="cost_other" onchange="calculateSuggestedPrices();" value="<?php echo number_format($item_kit_info->cost_other);?>" style="text-align: right"/>&nbsp; VND
        </div>
    </div>       
    <div class="field_row clearfix">
        <?php echo form_label('Số lượng dự tính:', 'total_product', array('class' => 'wide','style'=>'width: 200px')); ?>
        <div class='form_field'>
            <input type="text" name="total_product" id="total_product" readonly style="width: 50px; text-align: center;"/>           
        </div>
    </div>
    <div class="field_row clearfix">
        <?php echo form_label('Giá trị SP:', 'price_item_kit', array('class' => 'wide','style'=>'width: 200px')); ?>
        <div class='form_field'>
            <input type="text" name="price_item_kit" id="price_item_kit" readonly value="<?php echo number_format($item_kit_info->unit_price);?>" style="text-align: right"/>&nbsp; VND
        </div>
    </div>
    <br>
    <div style="float: left; line-height: 20px; margin-left: 300px; margin-bottom: 20px; position: relative; display: block; overflow: hidden">
        <span class="myButton" onclick="calculate()"> Tính Toán</span>
        <?php
        echo form_submit(array(
            'value' => 'Lưu lại',
            'class' => 'submit_button float_right',
            'style' => 'margin-bottom:20px',
            'name' => 'save_item',
            'id' => 'save_item',
            'style' => 'margin-top:0px !important')
        );
        ?>
    </div>
        <?php
//        echo form_submit(array(
//            'value' => 'Lưu lại',
//            'class' => 'submit_button float_right',
//            'style' => 'margin-bottom:20px',
//            'name' => 'save_item',
//            'id' => 'save_item'
//        ));
        ?>
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
    $("#items_kits").autocomplete({
        source: '<?php echo site_url("items/item_search_product_store"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#items_kits").val("");
            if ($("#item_kit_item_" + ui.item.value).length == 1) {
                $("#item_kit_item_" + ui.item.value).val(parseFloat($("#item_kit_item_" + ui.item.value).val()) + 1);
            } else {
                $("#item_kit_items").append(
                        "<tr><td><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td>"
                        + "<td><input class='select_checbox' id='item_" + ui.item.value + "' type='checkbox' value='" + ui.item.value + "'/></td>"
                        + "<td>" + ui.item.label + "</td>"
                        + "<td><input class='quantity_now' onchange='calculateSuggestedPrices();' id='quantity_now_" + ui.item.value + "' type='text' size='5' name='quantity_now[" + ui.item.value + "]' value='" + ui.item.quantity + "' readonly/></td>"
                        + "<td><input class='quantity' onchange='calculateSuggestedPrices();' id='item_kit_item_" + ui.item.value + "' type='text' size='3' name=item_kit_item[" + ui.item.value + "] value='1'/></td>"
                        + "<td><input class='quantity_loss' onchange='calculateSuggestedPrices();' id='quantity_loss_" + ui.item.value + "' type='text' size='3' name=quantity_loss[" + ui.item.value + "] value='0'/></td>"
                        + "<td><input class='cost' id='cost_" + ui.item.value + "' onchange='calculateSuggestedPrices();' type='text' size='9' name=cost[" + ui.item.value + "] value='" + ui.item.cost_price + "' readonly/></td>"
                        + "<td><input class='price' id='price_" + ui.item.value + "' onchange='calculateSuggestedPrices();' type='text' size='9' name=price[" + ui.item.value + "] value='" + ui.item.unit_price + "' readonly/></td>"
                        + "<td><input class='product_as_item' onchange='calculateSuggestedPrices();' id='product_as_item_" + ui.item.value + "' type='text' size='9' name=product_as_item[" + ui.item.value + "] value='0' readonly/></td>"
                        + "<td><input class='quantity_inventory' onchange='calculateSuggestedPrices();' id='quantity_inventory_" + ui.item.value + "' type='text' size='9' name=quantity_inventory[" + ui.item.value + "] value='0' readonly/></td>"
                        + "</tr>"
                        );
            }
            calculateSuggestedPrices();
            return false;
        }
    });
//validation and submit handling
    $(document).ready(function () {
        $("#cost_labor").maskMoney();
        $("#cost_other").maskMoney();
        calculateSuggestedPrices();

        setTimeout(function () {
            $(":input:visible:first", "#item_kit_form_estimate").focus();
        }, 100);
        var submitting = false;
        $('#item_kit_form_estimate').validate({
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_item_kit_form_submit(response);
                    },
                    dataType: 'json'
                });
            },
        });
        $('#trading_item').click(function () {
            var selected = get_selected_values_estimate();
            if (selected.length == 0) {
                alert(<?php echo json_encode(lang('items_must_select_item_for_trading')); ?>);
                return false;
            }
            $(this).attr('href', '<?php echo site_url("item_kits/trading"); ?>/' + selected.join('~'));
        });
        $("#cost_labor, #cost_other").blur(function () {
            var cost_labor = $("#cost_labor").val();
            if (cost_labor == "") {
                $("#cost_labor").val(0);
            }
            var cost_other = $("#cost_other").val();
            if (cost_other == "") {
                $("#cost_other").val(0);
            }
        });
    });
    function calculate() {
        var cost_labor = $("#cost_labor").val();
        if (cost_labor == "") {
            $("#cost_labor").val(0);
        }
        var cost_other = $("#cost_other").val();
        if (cost_other == "") {
            $("#cost_other").val(0);
        }
        var unit_price = $("#cost_price").val();
        var quantity = $("#total_product").val();
        var price = decimalAdjust('round', (parseFloat(cost_labor.replace(/,/g, "")) + parseFloat(cost_other.replace(/,/g, "")) + parseFloat(unit_price.replace(/,/g, ""))), 0);
        $("#price_item_kit").val((price + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    }
    function get_selected_values_estimate() {
        var a = new Array();
        $("#item_kit_items tbody :checkbox:checked").each(function () {
            a.push($(this).val())
        });
        return a
    }
    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();
        calculateSuggestedPrices();
        return false;
    }

    function calculateSuggestedPrices() {
        var items = [];
        var number = [];
        $("#item_kit_items").find('input').each(function (index, element) {
            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var quantity = $("#item_kit_item_" + item_id).val(); //Số lượng NVL cần 
            var quantity_loss = $("#quantity_loss_" + item_id).val(); //So luong NVL hao hut
            var quantity_now = $("#quantity_now_" + item_id).val() > 0 ? $("#quantity_now_" + item_id).val() : 0; //Số lượng tồn hiện tại
            var quantity_request = parseFloat(quantity) + parseFloat(quantity_loss); //Tong so luong NVL can /1SP
            var total_product = parseInt(quantity_now / quantity_request);
            if (quantity_now > quantity_request) {
                $("#item_" + item_id).css({'display': 'none'});
            } else {
                $("#item_" + item_id).css({'display': 'block'});
            }
            number.push(total_product); //Mảng lưu trữ số sản phẩm có thể SX tương ứng với NVL
            $("#product_as_item_" + item_id).val(parseInt(quantity_now / quantity_request)); //Số lượng sản phẩm có thể SX tương ứng với NVL
            items.push({
                item_id: item_id,
                quantity: quantity_request,
                quantity_now: quantity_now,
            });
        });
        //calculateSuggestedPrices.cost_a_item = price;
        calculateSuggestedPrices.totalCostOfItems = 0;
        calculateSuggestedPrices.totalPriceOfItems = 0;
        if (number.length > 0) {
            calculateSuggestedPrices.totalProduct = Math.min.apply(Math, number);
            //calculateSuggestedPrices.cost_a_item = parseFloat((parseFloat(cost_labor.replace(",", ""))+parseFloat(cost_other.replace(",", "")))/(Math.min.apply(Math, number)));
        } else {
            calculateSuggestedPrices.totalProduct = 0;
            //calculateSuggestedPrices.cost_a_item = 0;
        }
        calculateSuggestedPrices.totalCost = 0;
        calculateSuggestedPrices.totalSalePrice = 0;
        getPrices(items, 0);
    }
    function getPrices(items, index) {
        if (index > items.length - 8) {
            $("#cost_price").val(((decimalAdjust('round', calculateSuggestedPrices.totalCostOfItems, 0)) + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $("#total_product").val(calculateSuggestedPrices.totalProduct);
            $("#total_cost").val((calculateSuggestedPrices.totalCost + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $("#total_sale_price").val((calculateSuggestedPrices.totalSalePrice + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $("#unit_price").val((calculateSuggestedPrices.totalPriceOfItems + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        } else {
            $.get('<?php echo site_url("items/get_info"); ?>' + '/' + items[index]['item_id'], {}, function (item_info) {
                price_item = '#price_' + items[index]['item_id'];
                price = $(price_item).val();
                quantity = items[index]['quantity'];
                totalCost = quantity * parseFloat(item_info.cost_price);
                totalPrice = quantity * parseFloat(price.replace(",", ""));
                calculateSuggestedPrices.totalCostOfItems += totalCost;
                calculateSuggestedPrices.totalPriceOfItems += totalPrice;
//                calculateSuggestedPrices.totalCost = calculateSuggestedPrices.totalCostOfItems;
//                calculateSuggestedPrices.totalSalePrice = calculateSuggestedPrices.totalPriceOfItems;
                //$("#quantity_inventory_" + items[index]['item_id']).val(items[index]['quantity_now'] - calculateSuggestedPrices.totalProduct * quantity);
                $("#quantity_inventory_" + items[index]['item_id']).val(decimalAdjust('round', (items[index]['quantity_now'] - calculateSuggestedPrices.totalProduct * quantity), -2));
                getPrices(items, index + 8);
            }, 'json');
        }
    }
    function decimalAdjust(type, value, exp) {
        // If the exp is undefined or zero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
        Math.round10 = function (value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function (value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function (value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
</script>
<style>
    .quantity,.quantity_loss{
        text-align: center;
    }
    .cost,.price{
        text-align: right;
        border: none;
    }  
    .product_as_item,.quantity_now,.quantity_inventory{
        text-align: center;
        border: none;
    }
    #trading_item{
        font-weight: bold;
        background: #41B4EF;
        color: #FFFFFF !important;
        margin: 0px 0px 10px 10px;
        padding: 5px 5px;
    }
    .myButton {
         cursor: pointer;
         background: none repeat scroll 0 0 #428BCA;
         border: 1px solid #EEEEEE;
         color: #FFFFFF;
         font-size: 12px;
         font-weight: bold;
         line-height: 20px;
         padding: 9px 10px;
         margin: 0px 20px 0px 0px;
         float: left;
     }
     .myButton:hover {
         background: #3276b1;       
     }
</style>