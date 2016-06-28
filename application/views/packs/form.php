<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('packs/save/' . $pack_info->pack_id, array('id' => 'pack_form')); ?>
<fieldset id="pack_info">
    <legend><?php echo lang("packs_info"); ?></legend>
    <div style="width: 230px; float: right;">
        <?php echo form_label(lang('packs_add_images') . ':', 'pack_image', array('class' => 'wide', 'style' => 'font-weight: bold; font-size: 0.95em!important;')); ?>
        <?php if ($pack_info->images == null) { ?>
            <div class="" style="border: none">                    
                <div class='form_field' style="width: 60px;float: right;margin-right: 110px;">
                    <img src="<?php echo base_url() . 'images/no-images-product.jpg' ?>" style="width:100px; height:100px" />
                    <?php
                    echo form_input(array(
                        'name' => 'pack_image',
                        'id' => 'pack_image',
                        'type' => 'file',
                        'style' => 'float:right; margin-right:-100px;'
                    ));
                    ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="field_row clearfix" style="border-bottom:none">
                <div class='form_field' style="width: 40px;float: right;margin-right: 110px;">
                    <img src="<?php echo base_url() . 'item_kits/' . $pack_info->images ?>" style="width:100px; height:100px" />
                    <?php
                    echo form_input(array(
                        'name' => 'pack_image',
                        'id' => 'pack_image',
                        'type' => 'file',
                        'style' => 'float:right; margin-right:-100px;'
                    ));
                    ?>
                </div>
            </div>
        <?php } ?>  
       
    </div>
    
    
    <div class="field_row clearfix" style="width: 400px;  float: left;">
        <?php echo form_label('Mã sản phẩm:', 'name', array('class' => 'wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'pack_number',
                'id' => 'pack_number',
                'value' => $pack_info->pack_number)
            );
            ?>
        </div>
    </div>        
    <div class="field_row clearfix" style="width: 400px;  float: left;">
        <?php echo form_label(lang('packs_name') . ':', 'name', array('class' => 'wide required')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'name',
                'id' => 'name',
                'value' => $pack_info->name)
            );
            ?>
        </div>
    </div>
    <!-- phan category item -->
    <?php if ($pack_info->pack_id != null) { ?>
        <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('items_category') . ':', 'category', array('class' => 'wide')); ?>
            <div class='form_field'>
                <select name="category" style="width: 202px;">
                    <?php
                    $this->load->model('Category');
                    $cats = $this->Category->get_all();
                    if ($cats != null) {
                        foreach ($cats as $cat) {
                            ?>
                            <?php if ($pack_info->category == $cat['id_cat']) { ?>
                                <option value="<?php echo $cat['id_cat']; ?>" selected="selected"><?php echo $cat['name']; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $cat['id_cat']; ?>"><?php echo $cat['name']; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    <?php } else { ?>
        <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('items_category') . ':', 'category', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <select name="category" style="width: 202px;">
                    <?php
                    $this->load->model('Category');
                    $cats = $this->Category->get_all();
                    if ($cats != null) {
                        foreach ($cats as $cat) {
                            ?>
                            <option value="<?php echo $cat['id_cat']; ?>"><?php echo $cat['name']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    <?php } ?>
    <!-- end category item -->

    <div class="field_row clearfix">
        <?php echo form_label(lang('items_unit') . ':', 'unit', array('class' => 'required wide')); ?>
        <div class='form_field'>
            <select id="unit" name="unit">
                <?php
                $this->load->model('Unit');
                $units = $this->Unit->get_all();
                foreach ($units as $value) {
                    if ($pack_info->unit == $value['id_unit']) {
                        ?>
                        <option value="<?php echo $value['id_unit']; ?>" selected="selected"><?php echo $value['name'] ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $value['id_unit']; ?>"><?php echo $value['name'] ?></option>
    <?php }
}
?>
            </select>
        </div>
    </div>

    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('packs_description') . ':', 'description', array('class' => 'wide')); ?>
        <div class='form_field'>
            <?php
            echo form_textarea(array(
                'name' => 'description',
                'id' => 'description',
                'value' => $pack_info->description,
                'rows' => '5',
                'cols' => '17')
            );
            ?>
        </div>
    </div>
    
    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label('Hiển thị báo giá'. ':', 'description', array('class' => 'wide required')); ?>
        <div class='form_field'>
            <?php echo form_checkbox(array(
                            'name' => 'status_material',
                            'id' => 'status_material',
                            'value' => 1,
                            'checked' => ($pack_info->status_material) ? 1 : 0
                        ));
                        ?>
        </div>
    </div>
    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('packs_add_item') . ':', 'item', array('class' => 'wide')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'item',
                'id' => 'items_kits'
            ));
            ?>
        </div>
    </div>

    <table id="pack_items">
        <tr>
            <th><?php echo lang('common_delete'); ?></th>
            <th><?php echo lang('packs_item'); ?></th>
            <th><?php echo 'Tồn hiện tại'; ?></th>
            <th><?php echo lang('packs_quantity'); ?></th>
            <th>ĐVT</th>
            <th>Giá xuất</th>
            <th>Thuế %</th>
            <th>SP tương ứng</th>
            <th>Tồn dự kiến</th>
        </tr>
<?php foreach ($this->Pack_items->get_info($pack_info->pack_id) as $pack_item) { ?>
            <tr>
    <?php $item_info = $this->Item->get_info($pack_item->item_id); ?>
                <td style="text-align: center; width: 5%;"><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
                <td style="width: 25%;"><?php echo $item_info->name; ?></td>
                <td style="text-align: right; width: 10%;">                  
                    <input class="quantity_now" onchange="calculateSuggestedPrices();" 
                           id="quantity_now_<?php echo $pack_item->item_id ?>" type='text' size="5" 
                           name=quantity_now[<?php echo $pack_item->item_id ?>] 
                           value="<?php echo format_quantity($item_info->quantity_total); ?>" readonly/>
                </td>
                <td style="text-align: center; width: 12%;"> 
                    <input class="quantity" onchange="calculateSuggestedPrices();" 
                           id="pack_item_<?php echo $pack_item->item_id ?>" type='text' size='5' 
                           name=pack_item[<?php echo $pack_item->item_id ?>] 
                           value='<?php echo format_quantity($pack_item->quantity) ?>'/>
                </td>
                <td style="width: 10%;"><?php echo $this->Unit->get_info($item_info->quantity_first == 0 ? $item_info->unit : $item_info->unit_from )->name ?></td>
                <td style="width: 10%;">                   
                    <input class='price' onchange="calculateSuggestedPrices();" 
                           id='price_<?php echo $pack_item->item_id ?>' type='text' size='9' 
                           name=price[<?php echo $pack_item->item_id ?>] 
                           value='<?php echo number_format($pack_item->price) ?>' readonly/>
                </td>
                <td style="text-align: right; width: 8%;"><?php echo $item_info->taxes ?></td>
                <td style="text-align: right; width: 10%;">
                    <input class='product_as_item' onchange="calculateSuggestedPrices();" 
                           id='product_as_item_<?php echo $pack_item->item_id ?>' type='text' size='9' 
                           name=product_as_item[<?php echo $pack_item->item_id ?>] 
                           value='<?php echo format_quantity($pack_item->product_as_item) ?>' readonly/>
                </td>
                <td style="text-align: right; width: 10%;">
                    <input class='quantity_inventory' onchange="calculateSuggestedPrices();" 
                           id='quantity_inventory_<?php echo $pack_item->item_id ?>' type='text' size='9' 
                           name=quantity_inventory[<?php echo $pack_item->item_id ?>] 
                           value='<?php echo format_quantity($pack_item->quantity_inventory) ?>' readonly/>                  
                </td>
            </tr>
        <?php } ?>
    </table> 
    <div class="field_row clearfix">
<?php echo form_label('Chi phí SP:', 'cost_price', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input type="text" name="cost_price" id="cost_price" readonly 
                   value="<?php echo number_format($pack_info->cost_price); ?>"/>&nbsp; VND
        </div>
    </div>
    <div class="field_row clearfix">
<?php echo form_label('Giá trị SP:', 'value_price', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input type="text" name="value_price" id="value_price" readonly 
                   value="<?php echo number_format($pack_info->value_price); ?>"/>&nbsp; VND
        </div>
    </div>
    <div class="field_row clearfix">
<?php echo form_label('Giá bán SP:', 'unit_price', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input type="text" name="unit_price" id="unit_price" 
                   value="<?php echo number_format($pack_info->unit_price); ?>"/>&nbsp; VND
        </div>
    </div>
    <div class="field_row clearfix">
<?php echo form_label('Tổng sản phẩm:', 'total_product', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input type="text" name="total_product" id="total_product" readonly 
                   value="<?php echo $pack_info->total_quantity ?>"/>            
        </div>
    </div>
    <div class="field_row clearfix">
<?php echo form_label('Tổng chi phí:', 'total_cost', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input type="text" name="total_cost" id="total_cost" readonly 
                   value="<?php echo number_format($pack_info->total_quantity * $pack_info->cost_price); ?>"/>&nbsp; VND       
        </div>
    </div>
    <div class="field_row clearfix">
<?php echo form_label('Tổng giá bán:', 'total_sale_price', array('class' => 'wide')); ?>
        <div class='form_field'>
            <input type="text" name="total_sale_price" id="total_sale_price" readonly 
                   value="<?php echo number_format($pack_info->total_quantity * $pack_info->unit_price); ?>"/>&nbsp; VND         
        </div>
    </div>

    <?php
    echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_item'
    ));
    ?>
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
    $("#items_kits").autocomplete({
        source: '<?php echo site_url("items/item_search"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#items_kits").val("");
            if ($("#pack_item_" + ui.item.value).length == 1) {
                $("#pack_item_" + ui.item.value).val(parseFloat($("#pack_item_" + ui.item.value).val()) + 1);
            } else {
                $("#pack_items").append(
                        "<tr><td style='text-align: center; width: 5%;'><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td>"
                        + "<td style='width: 25%;'>" + ui.item.label + "</td>"
                        + "<td style='text-align: right; width: 10%;'><input class='quantity_now' onchange='calculateSuggestedPrices();' id='quantity_now_" + ui.item.value + "' type='text' size='5' name='quantity_now[" + ui.item.value + "]' value='" + ui.item.quantity + "' readonly/></td>"
                        + "<td style='text-align: center; width: 12%;'><input class='quantity' onchange='calculateSuggestedPrices();' id='pack_item_" + ui.item.value + "' type='text' size='2' name=pack_item[" + ui.item.value + "] value='1'/></td>"
                        + "<td style='width: 10%;'><input class='unit_item' id='unit_item_" + ui.item.value + "' type='text' size='7' name=unit_item[" + ui.item.value + "] value='" + ui.item.unit_item + "' readonly/></td>"
                        + "<td style='width: 10%;'><input class='price' id='price_" + ui.item.value + "' onchange='calculateSuggestedPrices();' type='text' size='9' name=price[" + ui.item.value + "] value='" + ui.item.unit_price + "' readonly/></td>"
                        + "<td style='text-align: right; width: 8%;'><input class='taxes_item' id='taxes_item_" + ui.item.value + "' type='text' size='3' name=taxes_item[" + ui.item.value + "] value='" + ui.item.taxes_item + "' readonly/></td>"
                        + "<td style='text-align: right; width: 10%;'><input class='product_as_item' onchange='calculateSuggestedPrices();' id='product_as_item_" + ui.item.value + "' type='text' size='9' name=product_as_item[" + ui.item.value + "] value='0' readonly/></td>"
                        + "<td style='text-align: right; width: 10%;'><input class='quantity_inventory' onchange='calculateSuggestedPrices();' id='quantity_inventory_" + ui.item.value + "' type='text' size='9' name=quantity_inventory[" + ui.item.value + "] value='0' readonly/></td>"
                        + "</tr>"
                        );
                $(".quantity").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: home, end, left, right, down, up
                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });
            }
            calculateSuggestedPrices();
            return false;
        }
    });
//validation and submit handling
    $(document).ready(function () {
        setTimeout(function () {
            $(":input:visible:first", "#pack_form").focus();
        }, 100);
        $("#category").autocomplete({
            source: "<?php echo site_url('items/suggest_category'); ?>",
            delay: 10,
            autoFocus: false,
            minLength: 0
        });
        var submitting = false;
        $('#pack_form').validate({
            submitHandler: function (form) {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response) {
                        submitting = false;
                        tb_remove();
                        post_pack_form_submit(response);
                    },
                    dataType: 'json'
                });
            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules: {
                name: {
                    required: true,
                    remote: {
                        url: "<?php echo site_url('packs/checkname/' . $pack_info->pack_id); ?>",
                        type: "post"
                    }
                },
                category: "required",
                unit_price: "number",
                value_price: "number",
                cost_price: "number",
                discount: "number",
            },
            messages: {
                name: {
                    required: 'Vui lòng nhập tên',
                    remote: 'Tên đã tồn tại, vui lòng chọn tên khác'
                },
                category:<?php echo json_encode(lang('items_category_required')); ?>,
                unit_price: <?php echo json_encode(lang('items_unit_price_number')); ?>,
                value_price: 'Giá trị phải là số',
                cost_price: <?php echo json_encode(lang('items_cost_price_number')); ?>,
                discount: <?php echo json_encode(lang('items_kit_discount_number')); ?>,
            }
        });
        $(".quantity").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: home, end, left, right, down, up
                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                // let it happen, don't do anything
                                return;
                            }
                            // Ensure that it is a number and stop the keypress
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });
    });

    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();
        calculateSuggestedPrices();
        return false;
    }

    function calculateSuggestedPrices() {
        var items = [];
        var number = [];
        $("#pack_items").find('input').each(function (index, element) {
            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var quantity = $("#pack_item_" + item_id).val(); //Số lượng NVL cần 
            var quantity_now = $("#quantity_now_" + item_id).val() > 0 ? $("#quantity_now_" + item_id).val() : 0; //Số lượng tồn hiện tại
            var total_product = parseInt(quantity_now / quantity);
            number.push(total_product); //Mảng lưu trữ số sản phẩm có thể SX tương ứng với NVL
            $("#product_as_item_" + item_id).val(parseInt(quantity_now / quantity)); //Số lượng sản phẩm có thể SX tương ứng với NVL
            items.push({
                item_id: item_id,
                quantity: quantity,
                quantity_now: quantity_now,
            });
        });
        calculateSuggestedPrices.totalCostOfItems = 0;
        calculateSuggestedPrices.totalPriceOfItems = 0;
        calculateSuggestedPrices.totalProduct = Math.min.apply(Math, number);
        calculateSuggestedPrices.totalCost = 0;
        calculateSuggestedPrices.totalSalePrice = 0;
        getPrices(items, 0);
    }
    function getPrices(items, index) {
        if (index > items.length - 5) {
            $("#cost_price").val((calculateSuggestedPrices.totalCostOfItems + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $("#value_price").val((calculateSuggestedPrices.totalPriceOfItems + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $("#total_product").val(calculateSuggestedPrices.totalProduct);
            $("#total_cost").val((calculateSuggestedPrices.totalCost + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $("#total_sale_price").val((calculateSuggestedPrices.totalSalePrice + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        } else {
            $.get('<?php echo site_url("items/get_info"); ?>' + '/' + items[index]['item_id'], {}, function (item_info) {
                price_item = '#price_' + items[index]['item_id'];
                price = $(price_item).val();
                item_info.cost_price8 = item_info.quantity_first != 0 ? item_info.cost_price_rate : item_info.cost_price;

                quantity = items[index]['quantity'];
                totalCost = quantity * parseFloat(item_info.cost_price8);
                //totalPrice = quantity * (parseFloat(price.replace(",", "")) + parseFloat(price.replace(",", "")) * item_info.taxes / 100);
                totalPrice = quantity * (parseFloat(price.replace(",", "")) + parseFloat(price.replace(",", "")) * item_info.taxes / 100);
                calculateSuggestedPrices.totalCostOfItems += totalCost;
                calculateSuggestedPrices.totalPriceOfItems += totalPrice;
                calculateSuggestedPrices.totalCost = calculateSuggestedPrices.totalCostOfItems * calculateSuggestedPrices.totalProduct;
                calculateSuggestedPrices.totalSalePrice = calculateSuggestedPrices.totalPriceOfItems * calculateSuggestedPrices.totalProduct;
                $("#quantity_inventory_" + items[index]['item_id']).val(items[index]['quantity_now'] - calculateSuggestedPrices.totalProduct * quantity);
                getPrices(items, index + 7);
            }, 'json');
        }
    }
    $(function () {
        $("#unit_price").maskMoney();
    });
</script>
<style>
    .quantity{
        text-align: right;
        width: 70%;
        padding: 2px 2px;
        font-size: 12px;
    }
    .price{
        text-align: right;
        border: none;
    }  
    .del,.product_as_item,.quantity_now,.quantity_inventory,.unit_item, .taxes_item, .price{
        text-align: right;
        border: none;
        width: 100%;
        font-size: 12px;
    }
    #cost_price, #value_price, #unit_price, #total_product, #total_cost, #total_sale_price{
        text-align: right;
    }
    #pack_items{
        border-collapse: collapse;
        width: 98%;
        margin: 20px auto;
        font-size: 12px;
    }

    #pack_items tr th{
        padding: 3px 0px;
        text-align: center;
        background: #E8E8E8;
        border: 1px solid #CDCDCD;
    }

    #pack_items tr td{
        border: 1px solid #CDCDCD;
        padding: 3px 2px;
    }

</style>