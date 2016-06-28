<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.price_format.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#currency_id").change(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>imports/load_rate",
                data: {id:
                            $(this).val()},
                type: "POST",
                success: function (data) {
                    $("#rate").html(data);
                }
            });
        });
    });
</script> 

<div id="content_area_wrapper">
    <div id="content_area" style="padding: 10px 4px 0 5px">
        <div id='TB_load'><img src='<?php echo base_url() ?>images/loading_animation.gif'/></div>
        <table>
            <tr>
            <style>
                #suspend_cancel #cancel_sale_button{
                    background: none repeat scroll 0 0 cornflowerblue;
                    color: rgb(255, 255, 255);
                    cursor: pointer;
                    display: block;
                    float: right;
                    font-size: 13px !important;
                    font-weight: bold;
                    height: 23px;
                    line-height: 20px;
                    margin-right: -68px;
                    text-align: center;
                    width: 100px;
                }
                #suspend_cancel #suspend_sale_button{
                    width: 105px;
                    margin-left: 3px;
                }
                #span_one select{
                    width: 77px!important;
                    margin-top: -6px!important;
                }


            </style>

            <td id="register_items_container">
                <table id="title_section">
                    <tr>
                        <td id="title_icon">
                            <a href="<?php echo base_url() ?>imports"><img src='<?php echo base_url() ?>images/menubar/receivings.png' alt='title icon' /></a>
                        </td>
                        <?php
                        $recv_id = $this->import_lib->get_recv();
                        if ($recv_id != '') {
                            echo "MĐH :" . $recv_id;
                        }
                        ?>
                        <td id="title">
                            <a href="<?php echo base_url() ?>imports"><?php echo lang('receivings_register_imports'); ?></a>
                        </td>

                        <td>
                            <form action="<?= site_url('imports/set_store'); ?>" method="post" id="store_form">
                                <?php
                                $recv_id = $this->import_lib->get_recv();
                                $disabled = $recv_id != '' ? 'disabled="disabled"' : '';
                                ?>

                                <span style="font-size: 12px"><?php echo 'Chọn kho :'; ?></span>
                                <select id="inventory" name="inventory" style="width:80px">
                                    <?php if ($store_active == 0) { ?>
                                        <option value='0' selected="selected">Kho tổng</option>
                                    <?php } else { ?>
                                        <option value='0'>Kho tổng</option>
                                    <?php } ?>                                                
                                    <?php
                                    foreach ($stores as $value) {
                                        if ($store_active == $value['id']) {
                                            echo "<option value='" . $value['id'] . "' selected='selected'>" . $value['name_inventory'] . "</option>";
                                        } else {
                                            echo "<option value='" . $value['id'] . "'>" . $value['name_inventory'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </form>  
                        </td>
                        <td>

                            <span style="font-size: 12px"><?php echo 'Ngoại tệ :'; ?></span>
                            <select style="width:60px" name="currency_id" id="currency_id">
                                <option value="0">-Chọn-</option>
                                <?php
                               $currency = $this->Inventory->getCurrency();
                                foreach ($currency as $v) {
                                    if ($active_currency == $v->id) {
                                        echo "<option value='" . $v->id . "' selected='selected'>" . $v->currency_id . "</option>";
                                    } else {
                                        echo "<option value='" . $v->id . "'>" . $v->currency_id . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </td>
                        <td id="register_wrapper">
                            <?php echo form_open("imports/change_mode", array('id' => 'mode_form')); ?>
                            <span><?php echo lang('receivings_mode') ?></span>
                            <?php $disabled = $recv_id != '' ? 'disabled="disabled"' : ''; ?>
                            <?php
                            $return = $this->Inventory->get_trans_recevings_return($recv_id) == 1 ? 'return' : 'receive';
                            echo $recv_id != '' ? form_dropdown('mode', $modes, $return, $disabled, "id='mode'") : form_dropdown('mode', $modes, $mode, "id='mode'");
                            ?>
                            </form>
                        </td>
                        <td id="show_suspended_sales_button">
                            <?php
                            echo anchor("imports/suspended/width~1125", "<div class='small_button'>" . 'Sổ nợ NCC' . "</div>", array('class' => 'thickbox none', 'title' => 'Sổ nợ nhà cung cấp'));
                            ?>
                        </td>
                    </tr>
                </table>

                <div id="reg_item_search">
                    <?php echo form_open("imports/add", array('id' => 'add_item_form')); ?>
                    <?php echo form_input(array('name' => 'item', 'id' => 'item', 'size' => '30', 'placeholder' => 'Điền tên mặt hàng cần nhập ... ')); ?>
                    <div id="new_item_button_register" >
                        <?php
                        echo anchor("items/view/-1/width~850", "<div class='small_button'><span>" . lang('items_new_item') . "</span></div>", array('class' => 'thickbox none', 'title' => lang('items_new_item')));
                        ?>

                    </div>
                    <?php //if ($this->Employee->has_module_action_permission("receivings", "receiving_order", $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                    <!--                        <div id="new_item_button_register" style="margin-top:5px;text-align: inherit">-->
                    <?php
                    //echo anchor(site_url() . '/receivings/receiving_order', "<div class='small_button'>Hóa đơn</div>", array('title' => 'Đơn hàng nhập'));
                    ?>
                    <!--                        </div>-->
                    <!--                        &nbsp;-->
                    <?php //} ?>
                    </form>
                </div>
                <div id="register_holder" style="margin-top: 15px">
                    <form method="post" action="<?= site_url('imports/set_rate'); ?>" id="form_input_rate">
                        <label style="font-size: 13px;color: whitesmoke;font-weight: bold">Nhập tý giá: 
                            <input type="text" name="rate_currency" id="rate_currency" value="<?= $this->import_lib->get_rate() ?>"/>

                        </label> 

<!--                        <select name="rate" id="rate" disabled style="width:120px;color:red">  
                            <option value="0">Tỷ giá ngoại tệ</option>  
                        </select>-->
                    </form>
                    <table id="register">

                        <thead>
                            <tr>
                                <th id="reg_item_del">
                                    <a href="<?php echo base_url(); ?>imports/delete_all" id="delete_all"><span style="color:#fff;">Xóa</span></a>
                                </th>
                                <th>Mã MH #</th>
                                <th><?php echo lang('receivings_item_name'); ?></th>
                                <th id="reg_item_price"><?php echo lang('receivings_cost'); ?></th>
                                <th id="reg_item_qty"><?php echo lang('receivings_quantity'); ?></th>
                                <th id="reg_item_rate">Tỉ lệ qui đổi</th>
                                <th id="reg_item_discount"><?php echo lang('receivings_discount'); ?></th>
                                <th id="reg_item_taxe" style="width:50px">Thuế%</th>
                                <th id="reg_item_total"><?php echo lang('receivings_total'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="cart_contents">
                            <?php
                            if (count($cart_import) == 0) {
                                ?>
                                <tr><td colspan='9' style="height:60px;border:none;">
                                        <div class='warning_message' style='padding:7px;'><?php echo lang('sales_no_items_in_cart'); ?></div>
                                    </td>
                                </tr>
                                <?php
                            } else {
                                foreach (array_reverse($cart_import, true) as $line => $item) {
                                    $cur_item_info = $this->Item->get_info($item['item_id']);
                                    ?>
                                    <tr>
                                        <td colspan='9'>
                                            <?php
                                            echo form_open("imports/edit_item/$line");
                                            ?><table>
                                                <tr id="reg_item_top">
                                                    <td style="width:38px; text-align: center">
                                                        <?php echo anchor("imports/delete_item/$line", lang('common_delete'), array('class' => 'delete_item')); ?>
                                                    </td>
                                                    <td align='center' style="width:101px;"><?php echo $this->Item->get_info($item['item_id'])->item_number; ?></td>
                                                    <td style="width:168px; padding-left: 3px;"><?php echo $item['name']; ?></td>
                                                    <?php if ($items_module_allowed) { ?>
                                                        <td style="width:79px; text-align: center" class="reg_item_price">
                                                            <?php echo form_input(array('name' => 'price', 'value' => str_replace(array('.00'), '', (to_currency_unVND($item['price']))), 'size' => '15', 'class' => 'input_price', 'id' => 'price_' . $line)); ?>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td style="width:79px; text-align: center">
                                                            <?php echo $item['price']; ?>
                                                        </td>
                                                        <?php echo form_hidden('price', $item['price']); ?>
                                                    <?php } ?>
                                                    <td style="width:56px; text-align: center" class="reg_item_qty">
                                                        <?php echo form_input(array('name' => 'quantity', 'value' => $item['quantity'], 'size' => '2', 'id' => 'quantity_' . $line)); ?>
                                                    </td>
                                                    <td style="width:73px; text-align: center">
                                                        <?php
                                                        if ($item['unit_rate'] > 0 && $item['quantity_first'] > 0) {
                                                            echo $item['quantity_first'] . ' : ' . $item['unit_rate'];
                                                        } else {
                                                            echo '1 : 1';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="width:47px; text-align: center" class="reg_item_discount">
                                                        <?php echo form_input(array('name' => 'discount', 'value' => $item['discount'], 'size' => '3', 'id' => 'discount_' . $line)); ?>
                                                    </td>
                                                    <td style="width:50px; text-align: center" class="reg_item_taxe">
                                                        <?php echo form_input(array('name' => 'taxe', 'value' => $item['taxe'], 'size' => '3', 'id' => 'taxe_' . $line)); ?>
                                                    </td>
                                                    <td style="width:87px; padding-left: 3px;">                                                                                                        <?php
                                                        $price_curv = (str_replace(array(',', '.00'), '', ($this->import_lib->get_rate())) * $item['price']);
                                                        $tax = ($price_curv * $item['quantity'] - $price_curv * $item['quantity'] * $item['discount'] / 100) * $item['taxe'] / 100;
                                                        echo to_currency($tax + ($price_curv * $item['quantity'] - $price_curv * $item['quantity'] * $item['discount'] / 100));
                                                        ?>     
                                                    </td>
                                                </tr>
                                                <tr id="reg_item_bottom" style="border-bottom: 1px solid #eee9e9;">
                                                    <td id="reg_item_descrip_label"><?php echo lang('sales_description_abbrv') . ':'; ?></td>
                                                    <td id="reg_item_descrip" colspan="8">

                                                        <?php
                                                        echo $item['description'];
                                                        echo form_hidden('description', $item['description']);
                                                        ?>
                                                    </td>
                                                </tr>		
                                            </table>
                                            </form>		
                                        </td>
                                    </tr>	
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="reg_item_base"></div>
            </td>
            <td style="width:8px;"></td>
            <td id="over_all_sale_container">
                <div id="overall_sale">

                    <div id="suspend_cancel">
                        <div id="suspend" <?php
                            if (count($cart_import) > 0) {
                                echo "style='visibility: visible;'";
                            }
                            ?>>	
                             <?php
                                 // Only show this part if there are Items already in the sale.
                                 if (count($cart_import) > 0) {
                                     ?>

                                <?php //if($amount_due1 > 0) {  ?>
                                <div class='small_button' id='suspend_sale_button'> 
                                    <span><?php echo "Ghi vào sổ nợ"; ?></span>
                                </div>

                                <?php //}  ?>

                            <?php } ?>
                        </div>
                        <div id="cancel" <?php
                            if (count($cart_import) > 0) {
                                echo "style='visibility: visible;'";
                            }
                            ?>>											
                             <?php
                                 // Only show this part if there are Items already in the sale.
                                 if (count($cart_import) > 0) {
                                     ?>
                                     <?php echo form_open("imports/cancel_receiving", array('id' => 'cancel_sale_form')); ?>
                                <div class='small_button' id='cancel_sale_button'>
                                    <span>
                                        <?php
                                        echo lang('receivings_cancel_receiving');
                                        ?>
                                    </span>
                                </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>

                    <div id="customer_info_shell" style="margin-top:40px;">
                        <?php
                        if (isset($supplier)) {
                            echo "<div id='customer_info_filled'>";
                            echo '<div id="customer_name" style="font-weight: bold;margin-top: -25px"> Nhà cung cấp : </div>';
                            echo '<div id="customer_name" style="margin-top: -11px;margin-left: 13px">' . character_limiter($supplier, 55) . '</div>';
                            echo '<div id="customer_email"></div>';
                            echo '<div id="customer_edit">' . anchor("suppliers/view/$supplier_id/width~490", lang('common_edit'), array('class' => 'thickbox none', 'title' => lang('suppliers_update'))) . '</div>';
                            echo '<div id="customer_remove">' . anchor("imports/delete_supplier", lang('sales_detach'), array('id' => 'delete_supplier')) . '</div>';
                            echo "</div>";
                        } else {
                            ?>
                            <div id='customer_info_empty' <?php if ($supplier == 0) echo 'style="margin-top: -24px"'; ?>>
                                <?php echo form_open("imports/select_supplier", array('id' => 'select_supplier_form')); ?>
                                <label id="customer_label" for="supplier" style="margin-left: 0px">
                                    <?php echo lang('receivings_select_supplier'); ?>
                                </label>
                                <?php echo form_input(array('name' => 'supplier', 'id' => 'supplier', 'size' => '30', 'placeholder' => lang('receivings_start_typing_supplier_name'))); ?>
                                </form>
                                <div id="add_customer_info">
                                    <div id="common_or" >
                                        <?php echo lang('common_or'); ?>
                                    </div>
                                    <?php
                                    echo anchor("suppliers/view/-1/width~490", "<div class='small_button' style='margin:0 auto;'><span>" . lang('receivings_new_supplier') . "</span></div>", array('class' => 'thickbox none', 'title' => lang('receivings_new_supplier')));
                                    ?>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                            </div>
                        <?php } ?>
                    </div>

                    <div id='sale_details' style="float:left;width:220px">
                        <table id="sales_items_total">
                            <tr>
                                <td class="left">Tổng tiền:</td>
                                <?php
                                $total1 = 0;
                                foreach (array_reverse($cart_import, true) as $line => $item) {
                                 $price = (str_replace(array(',', '.00'), '', ($this->import_lib->get_rate())) * $item['price']);
                                    $tax = ($price * $item['quantity'] - $price * $item['quantity'] * $item['discount'] / 100) * $item['taxe'] / 100;
                                    $total1 += $tax + ($price * $item['quantity'] - $price * $item['quantity'] * $item['discount'] / 100);
                                }
                                ?> 
                                <td name="right" class="right"><?php echo to_currency($total1); ?></td>
                            <input type="hidden" value="<?php echo $total1; ?>" name="total_total" class="total_total"/>			
                            </tr>

                        </table>
                    </div>

                    <?php
                    // Only show this part if there are Items already in the Table.
                    if (count($cart_import) > 0) {
                        ?>

                        <div id="finish_sale">

                            <?php echo form_open("imports/complete", array('id' => 'finish_sale_form')); ?>

                            <div id="make_payment" style="float:left">
                                <table id="make_payment_table">
                                    <tr id="mpt_top">
                                        <td>
                                            <label style="margin-left: -9px;padding: 0;width: 124px"><?php echo lang('sales_payment') . ':'; ?></label>
                                            <span id="span_one" style="display: inline-block;margin-top: 7px;"><?php echo form_dropdown('payment_type', $payment_options, $this->config->item('default_payment_type'), 'id ="payment_type"'); ?></span>
                                        </td>
                                    </tr>
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -58px;margin-bottom: -11px;line-height: 22px;">Nhập tiền cần trả</label>
                                            <?php echo form_input(array('name' => 'amount_tendered', 'id' => 'amount_tendered', 'class' => 'amount_tendered', 'value' => '', 'size' => '10')); ?>
                                            <?php //echo form_input(array('name'=>'amount_tendered_hidden','id' => 'amount_tendered_hidden', 'class' => 'amount_tendered_hidden','value' =>str_replace(array('.00'),'', (to_currency_unVND($amount_tendered))), 'size' => 25));   ?>									
                                        </td>
                                    </tr>
                                    <!--<tr id="mpt_bottom">
                                            <td id="tender" colspan="2">
                                                    <label style="font-size: .85em;margin-left: -58px;margin-bottom: -11px;line-height: 22px;">Chiết khấu tiền mặt</label>
                                    <?php echo form_input(array('name' => 'discount_money', 'id' => 'discount_money', 'class' => 'discount_money', 'value' => str_replace(array('.00'), '', (to_currency_unVND($discount_money))), 'size' => '10')); ?>										
                                            </td>
                                    </tr>
                                    -->
                                    <tr style="height:10px;">
                                        <td colspan="2">&nbsp</td>
                                    </tr>
                                </table>

                            </div>

                            <label id="comment_label" for="comment"><?php echo lang('common_comments'); ?>:</label>
                            <?php echo form_textarea(array('name' => 'comment', 'id' => 'comment', 'value' => '', 'rows' => '4', 'style' => 'width: 192px;margin: -4px 12px 12px 14px;border: 1px inset #EEE9E9')); ?>
                            <div id="suspend_cancel">

                            </div>

                            <?php echo "<div class='small_button' id='finish_sale_button' style='margin-top:5px;'><span style='margin-top: -23px;margin-right: 13px;'>" . lang('receivings_complete_receiving') . "</span></div>"; ?>

                        </div>

                        </form>
                    <?php } ?>

                </div><!-- END OVERALL-->		
            </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
        <?php $this->load->view("partial/abouts"); ?>
    </div></div>

<script type="text/javascript">
<?php
if (isset($error)) {
    echo "set_feedback(" . json_encode($error) . ",'error_message',false);";
}
if (isset($warning)) {
    echo "set_feedback(" . json_encode($warning) . ",'warning_message',false);";
}
if (isset($success)) {
    echo "set_feedback(" . json_encode($success) . ",'success_message',false);";
}
?>
</script>

<script type="text/javascript" language="javascript">
    $(document).ready(function ()
    {

        $('#amount_tendered').keyup(function ()
        {
            var tongtien_2 = ($('#amount_tendered').val()).replace(",", "");
            $.post('<?php echo site_url("imports/set_amount_tendered"); ?>', {amount_tendered: tongtien_2});

        });

        $(".amount_tendered").maskMoney();
        var my_ar = new Array("reg_item_total", "reg_item_discount", "reg_item_taxe", "reg_item_qty", "reg_item_price", "reg_item_stock", "reg_item_number", "reg_item_name", "reg_item_del");
        for (i = 0; i < my_ar.length; i++)
        {
            my_th = $("th#" + my_ar[i]);
            my_td = $("td#" + my_ar[i]);
            my_td.each(function (i)
            {
                $(this).width(my_th.width());
            });
        }
        ;

        $('#inventory').change(function ()
        {
            $('#store_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
        });

        $(".input_price23555").focusout(function () {
            $("#cart_form_money").ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: function ()
                {
                    receivingsSuccess();
                    setTimeout(function () {
                        $('#item').focus();
                    }, 10);
                }
            });
        })

        $(".input_price").focusout(function ()
        {
            var toFocusId = $(":input[type!=hidden]:eq(" + ($(":input[type!=hidden]").index(this) + 1) + ")").attr('id');
            $(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: function ()
                {
                    salesSuccess();
                    setTimeout(function () {
                        $('#item').focus();
                    }, 10);
                }
            });
        });

        $('#rate_currency').change(function ()
        {
//            $('#rate_currency').maskMoney({
//             precision: 2
//             });

            $('#form_input_rate').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
             
        });
        
//        $('#rate_currency').priceFormat({
//                clearPrefix: true
//            });

        $('a.thickbox, area.thickbox, input.thickbox').each(function (i)
        {
            $(this).unbind('click');
        });

        tb_init('a.thickbox, area.thickbox, input.thickbox');

        $('#add_item_form, #mode_form, #select_supplier,').ajaxForm({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});

        $("#item").autocomplete({
            source: '<?php echo site_url("imports/item_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui)
            {
                event.preventDefault();
                $("#item").val(ui.item.value);
                $('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
            },
            change: function (event, ui)
            {
                if ($(this).attr('value') != '' && $(this).attr('value') != <?php echo json_encode(lang('sales_start_typing_item_name')); ?>)
                {
                    $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
                }

                $(this).attr('value',<?php echo json_encode(lang('sales_start_typing_item_name')); ?>);
            }
        });

        $("#cart_contents input").change(function ()
        {
            var toFocusId = $(":input[type!=hidden]:eq(" + ($(":input[type!=hidden]").index(this) + 1) + ")").attr('id');
            $(this.form).ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: function ()
                {
                    receivingsSuccess();
                    setTimeout(function () {
                        $('#' + toFocusId).focus();
                    }, 10);

                }
            });
        });

        setTimeout(function () {
            $('#item').focus();
        }, 10);

        $('#item,#supplier').click(function ()
        {
            $(this).attr('value', '');
        });

        $('#amount_tendered_hidden').change(function ()
        {
            $.post('<?php echo site_url("sales/set_amount_tendered_hidden"); ?>', {amount_tendered_hidden: $('#amount_tendered_hidden').val()});
        });
        $('#discount_money').change(function ()
        {
            $.post('<?php echo site_url("imports/set_discount_money"); ?>', {discount_money: $('#discount_money').val()});
        });
        $('#comment').change(function ()
        {
            $.post('<?php echo site_url("imports/set_comment"); ?>', {comment: $('#comment').val()});
        });
        $('#payment_type').change(function ()
        {
            $.post('<?php echo site_url("imports/set_payment_type"); ?>', {payment_type: $('#payment_type').val()});
        });

        $('#rate_currency').change(function ()
        {
            $.post('<?php echo site_url("imports/set_rate"); ?>', {rate_currency: $('#rate_currency').val()});
        })

        $('#currency_id').change(function ()
        {
            $.post('<?php echo site_url("imports/set_currency_id"); ?>', {currency_id: $('#currency_id').val()});
        })



        $('#mode').change(function ()
        {
            $('#mode_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
        });

        $("#supplier").autocomplete({
            source: '<?php echo site_url("imports/supplier_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui)
            {
                $("#supplier").val(ui.item.value);
                $('#select_supplier_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
            }
        });

        $('#supplier').blur(function ()
        {
            $(this).attr('value',<?php echo json_encode(lang('receivings_start_typing_supplier_name')); ?>);
        });

        $("#finish_sale_button").click(function ()
        {
            var rate_currency = $('#rate_currency').val();
            if ($.trim(rate_currency) == '') {
                alert('Vui lòng nhập tỷ giá ngoại tệ!');
                return;
            }

            var amount_tendered = $("#amount_tendered").val();
            $("#register_container").load('<?php echo site_url("imports/suspend"); ?>', {amount_tendered: amount_tendered});
            $('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});


        });




        $("#suspend_sale_button").click(function ()
        {
            var amount_tendered = $("#amount_tendered").val();
            if (confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>))
            {
                $("#register_container").load('<?php echo site_url("imports/suspend"); ?>');
            }
        });

        $("#cancel_sale_button").click(function ()
        {
            if (confirm(<?php echo json_encode(lang("receivings_confirm_cancel_receiving")); ?>))
            {
                $('#cancel_sale_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
            }
        });

        $('.delete_item, #delete_supplier,#delete_all').click(function (event)
        {
            event.preventDefault();
            $("#register_container").load($(this).attr('href'));
        });




    });

  function post_item_form_submit(response)
    {
        if (response.success)
        {
            $("#item").attr("value", response.item_id);
            $('#add_item_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
        }
    }

    function post_person_form_submit(response)
    {
        if (response.success)
        {
            $("#supplier").attr("value", response.person_id);
            $('#select_supplier_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});

        }
    }

    function receivingsBeforeSubmit(formData, jqForm, options)
    {
        $("#finish_sale_button").hide();
        $("#TB_load").show();
    }

    function receivingsSuccess(responseText, statusText, xhr, $form)
    {
    }
    function salesBeforeSubmit() {

    }
    function salesSuccess() {

    }



</script>

