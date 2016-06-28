<style>
*, *:before, *:after{
    -moz-box-sizing:inherit;
}
.discount_money {
    border: 1px solid #999999;
    border-radius: 4px;
    font-size: 1.5em;
    padding: 1px 5px;
    text-align: right;
    width: 190px;
}
#employees_id{
    border: 1px solid #999999;
    border-radius: 4px;
    font-size: 0.9em;
    padding: 1px 5px;
    text-align: left;
    width: 190px;
}
#delivery_employee ,#discount_money ,#amount_tendered{
    border: 1px solid #999999;
    border-radius: 4px;
    font-size: 0.9em;
    padding: 1px 5px;
    text-align: right;
    width: 190px;
}
#store{
    width:160px!important;
}
.disable_input_cost {
    display: none;
}
/*//Nov 3*/
.tr_bank{
    border: 1px solid #eee9e9;
}
.bank_account{
    border: 1px solid #ccc;
    height: 22px;
}
</style>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker.js"></script>
<?php $this->load->library('sale_lib');?>
<div id="content_area_wrapper" style="min-height: 1050px">    
    <div id="content_area" style="min-height: 740px;padding: 10px 5px;">
        <div <?php if (isset($sale_id)) echo "style='visibility: visible; margin-bottom: 8px;margin-top: -16px;'"; ?> >
            <!--huyen -->
            <?php
            if ($this->Sale->get_sale_id_liability($sale_id) == 1) {
                echo '<div id="customer_name" style="color:red;margin-bottom: 0px;margin-top: 7px;font-size: 15px;">' . 'Đơn đặt hàng số: ' . $sale_id . '</div>';
            } elseif ($this->Sale->get_sale_id_suspended($sale_id) == 1) {
                echo '<div id="customer_name" style="color:red;margin-bottom: 0px;margin-top: 7px;font-size: 15px;">' . 'Sổ nợ số: ' . $sale_id . '</div>';
            }
            ?>
        </div>
        <div id='TB_load'><img src='<?php echo base_url() ?>images/loading_animation.gif'/></div>
        <table>
            <tr>
                <td id="register_items_container">
                    <table id="title_section">
                        <tr>
                            <td id="title_icon">
                                <a href="<?php echo base_url() ?><?php echo $controller_name; ?>"><img src='<?php echo base_url() ?>images/menubar/sales.png' alt='title icon' /></a>
                            </td>                            
                            <td id="title" style="width:230px !important; text-align:left;">
                                <span style="font-size:15px;width: 90px;"><?php echo lang('receivings_store'); ?>:</span>
                                <select id="store" name="store">
                                    <?php
                                    if ($this->Employee->get_logged_in_employee_info()->person_id == 1) {
                                        ?>
                                        <option value="0" <?= $this->session->userdata('store') == 0 ? 'selected' : '' ?> >Kho tổng</option>                                    
                                        <option value="1999" <?= $this->session->userdata('store') == 1999 ? 'selected' : '' ?> >Kho sản phẩm</option>
                                        <?php
                                        foreach ($inventory as $value) {
                                            if ($value['id'] == $this->session->userdata('store')) {
                                                echo "<option value='" . $value['id'] . "' selected>" . $value['name_inventory'] . "</option>";
                                            } else {
                                                echo "<option value='" . $value['id'] . "'>" . $value['name_inventory'] . "</option>";
                                            }
                                        }
                                        ?>
                                        <?php
                                    } else {
                                         ?>
                                        <option value="1999" <?= $this->session->userdata('store') == 1999 ? 'selected' : '' ?> >Kho sản phẩm</option>
                                        <?php
                                        $info_emp = $this->Employee->get_info_in_table_employee($this->Employee->get_logged_in_employee_info()->person_id);
                                        $info_warehouse = $this->Create_invetory->get_info($info_emp->warehouse_sale);
                                        if ($this->session->userdata('store') == $info_warehouse->id) {
//                                            echo "<option value=''>Chọn kho</option>";
                                            echo "<option value='" . $info_warehouse->id . "' selected='selected'>" . $info_warehouse->name_inventory . "</option>";
                                        } else {
//                                            echo "<option value='' selected='selected'>Chọn kho</option>";
                                            echo "<option value='" . $info_warehouse->id . "'>" . $info_warehouse->name_inventory . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td id="register_wrapper" style="width: 155px; text-align: left;">
                                <?php echo form_open("sales/change_mode", array('id' => 'mode_form')); ?>
                                <span><?php echo lang('sales_mode') ?> : </span>
                                <?php echo form_dropdown('mode', $modes, $mode, 'id="mode"'); ?>
                                </form>
                            </td>
                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'price_alert', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                <td id="show_materials_button">
                                    <?php
                                    echo anchor("sales/materialed/width~1290", "<div class='small_button'>" . 'Báo giá' . "</div>", array('class' => 'thickbox none', 'title' => 'Báo giá khách hàng'));
                                    ?>
                                </td>
                            <?php } ?>
                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'paybook', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                <td id="show_suspended_sales">
                                    <?php
                                    echo anchor("sales/suspended/width~1305", "<div class='small_button'>" . 'Sổ nợ KH' . "</div>", array('class' => 'thickbox none', 'title' => 'Danh sách sổ nợ khách hàng'));
                                    ?>
                                </td>
                            <?php } ?>
                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'orders', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                                <td id="show_suspended_sales_button">
                                    <?php
                                    echo anchor("sales/liabilityed/width~1225", "<div id='show_suspended_sales_button_new' class='small_button'>" . 'Các đơn đặt hàng' . "</div>", array('class' => 'thickbox none', 'title' => 'Danh sách các đơn đặt hàng'));
                                    s
                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                    </table>
                    <div id="reg_item_search">
                        <?php echo form_open("sales/add", array('id' => 'add_item_form')); ?>
                        <?php echo form_input(array('name' => 'item', 'id' => 'item', 'size' => '40', 'accesskey' => 'i', 'placeholder' => 'Nhập tên sản phẩm hoặc Quét mã vạch ...')); ?>
                        <div id="new_item_button_register" >
                            <?php
                            echo anchor("items/view/-1/width~850", "<div class='small_button'><span style='font-size:12px!important'>" . lang('sales_new_item') . "</span></div>", array('class' => 'thickbox none', 'title' => lang('sales_new_item'), 'style' => 'font-size:12px!important'));
                            ?>
                        </div>

                        <div id="new_item_button_register" style="margin-top: 5px">
                            <?php
                            echo anchor(site_url() . 'sales/sales_order', "<div class='small_button'>Hóa đơn</div>", array('title' => 'Đơn hàng nhập'));
                            ?>

                        </div>	

                        </form>
                    </div>
                    <?php
                    $total_owe = 0;
                    foreach ($payments as $payment) {
                        $total_owe += $payment['payment_amount'] + $payment['discount_money'];
                    }
                    $info_sale = $this->Sale->get_info_sale($sale_id);
                    ?>
                    <div id="register_holder" style="margin-top: 10px">
                        <table id="register">
                            <thead>
                                <tr>
                                    <th id="reg_item_del" >
                                        <a href="<?php echo base_url(); ?>sales/delete_all" id="delete_all">
                                            <span style="color:#fff;">Xóa</span>
                                        </a>
                                    </th>
                                    <th id="reg_item_number"><?php echo lang('sales_item_number'); ?></th>
                                    <th id="reg_item_name"><?php echo lang('sales_item_name'); ?></th>                                    
                                    <th id="reg_item_stock"><?php echo lang('sales_stock'); ?></th>
                                    <th id="reg_item_unit"><?php echo lang('sales_unit'); ?></th>
                                    <th id="reg_item_qty"><?php echo lang('sales_quantity'); ?>
                                    </th>
                                    <th id="reg_item_price"><?php echo lang('sales_price'); ?></th>                                    
                                    <th id="reg_item_discount"><?php echo lang('sales_discount'); ?></th>
                                    <th id="reg_item_taxes"><?php echo lang('sales_tax_percent'); ?></th>
                                    <th id="reg_item_total"><?php echo lang('sales_total'); ?></th>
                                </tr>
                            </thead>
                            <tbody id="cart_contents" class="cart_contents">

                                <?php if (count($cart) == 0) { ?>
                                    <tr>
                                        <td colspan='10' style="height:60px;border:none;">
                                            <div class='warning_message' style='padding:7px;'><?php  echo lang('sales_no_items_in_cart'); ?></div>
                                        </td>
                                    </tr>

                                    <?php
                                } else {
                                    foreach (array_reverse($cart, true) as $line => $item) {
                                        $cur_item_info = isset($item['item_id']) ? $this->Item->get_info($item['item_id']) : $this->Item_kit->get_info($item['item_kit_id']);
                                        $cur_item_info23 = $this->Item->get_info_warehouse_items($item['item_id'], $item['stored_id']);
                                        ?>
                                        <tr>

                                            <td colspan='10'>
                                                <?php echo form_open("sales/edit_item/$line", array('class' => 'line_item_form')); ?>                                                
                                                <table>	
                                                    <input type="hidden" name="item_id" value="<?php echo isset($item['item_id']) ? $item['item_id'] : $item['item_kit_id'] ?>">
                                                    <input type="hidden" name="type_item" value="<?php echo isset($item['item_id']) ? 'item' : 'item_kit' ?>">
                                                    <tr id="reg_item_top">
                                                        <td id="reg_item_del" ><?php echo anchor("sales/delete_item/$line", lang('common_delete_one'), array('class' => 'delete_item')); ?></td>
                                                        
                                                        <td id="reg_item_number"><?php echo isset($item['item_id']) ? $item['item_number'] : $item['pack_number']; ?></td>
                                                        <td id="reg_item_name">
                                                            <?php
                                                            echo $item['name'];
                                                            ?></td>                                                        
                                                        <?php if ($item['stored_id'] == '') { ?>
                                                            <?php if ($item['unit'] == "unit") { ?>
                                                                <td id="reg_item_stock" style="width: 58px; text-align: right; padding-right: 2px;">
                                                                    <?php
                                                                    if ($cur_item_info->unit_rate != 0) {
                                                                        echo property_exists($cur_item_info, 'quantity') ? format_quantity($cur_item_info->quantity_total / $cur_item_info->unit_rate) : '';
                                                                    } else {
                                                                        echo property_exists($cur_item_info, 'quantity') ? format_quantity($cur_item_info->quantity_total) : 0;
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td id="reg_item_stock" style="width: 58px; text-align: right; padding-right: 2px;">
                                                                    <?php echo property_exists($cur_item_info, 'quantity') ? format_quantity($cur_item_info->quantity_total) : ''; ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <?php if ($item['unit'] == "unit") { ?>
                                                                <td id="reg_item_stock" style="width: 58px; text-align: right; padding-right: 2px;">
                                                                    <?php
                                                                    if ($cur_item_info->unit_rate != 0) {
                                                                        echo property_exists($cur_item_info23, 'quantity') ? format_quantity($cur_item_info23->quantity / $cur_item_info->unit_rate) : '';
                                                                    } else {
                                                                        echo property_exists($cur_item_info23, 'quantity') ? format_quantity($cur_item_info23->quantity) : 0;
                                                                    }
                                                                    ?>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td id="reg_item_stock" style="width: 58px; text-align: right; padding-right: 2px;">
                                                                    <?php echo property_exists($cur_item_info23, 'quantity') ? $cur_item_info23->quantity : ''; ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <td id="reg_item_unit" style="width: 100px; text-align: center">


                                                            <?php
                                                            if ($item['item_id']) { //item                                                                
                                                                $info_item = $this->Item->get_info($item['item_id']);
                                                                $info_unit = $this->Unit->get_info($info_item->unit);
                                                                if ($info_item->unit_from) {
                                                                    $info_unit_from = $this->Unit->get_info($info_item->unit_from);
                                                                    if ($info_sale['suspended'] != 1) {
                                                                        ?>
                                                                        <select name="unit" id="unit" class="unit" style="width: 85%; padding: 2px 0px;">
                                                                            <?php if ($item['unit'] == "unit") { ?>
                                                                                <option value="unit_from"><?php echo $info_unit_from->name; ?></option>
                                                                                <option value="unit" selected="selected"><?php echo $info_unit->name; ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="unit_from" selected="selected"><?php echo $info_unit_from->name; ?></option>
                                                                                <option value="unit"><?php echo $info_unit->name; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <?php
                                                                    } else {
                                                                        if ($item['unit'] == "unit") {
                                                                            echo $info_unit->name;
                                                                            echo form_hidden('unit', 'unit');
                                                                        } else {
                                                                            echo $info_unit_from->name;
                                                                            echo form_hidden('unit', 'unit_from');
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo $info_unit->name;
                                                                    echo form_hidden('unit', 'unit');
                                                                }
                                                            } else { //pack
                                                                $info_pack = $this->Pack->get_info($item['pack_id']);
                                                                $info_unit = $this->Unit->get_info($info_pack->unit);
                                                                echo $info_unit->name;
                                                                echo form_hidden('unit', 'unit');
                                                            }
                                                            ?>
                                                        </td>
                                                        <td id="reg_item_qty">

                                                            <?php
                                                            if ($info_sale['suspended'] != 1) {

                                                                if (isset($item['is_serialized']) && $item['is_serialized'] == 1) {
                                                                    echo $item['quantity'];
                                                                    echo form_hidden('quantity', $item['quantity']);
                                                                } else {
                                                                    echo form_input(array(
                                                                        'name' => 'quantity',
                                                                        'value' => $item['quantity'],
                                                                        'size' => '2',
                                                                        'id' => 'quantity_' . $line,
                                                                        'style' => 'text-align: right;',
                                                                        'class' => 'input_quantity',
                                                                    ));
                                                                }
                                                            } else {
                                                                echo $item['quantity'];
                                                                echo form_hidden('quantity', $item['quantity']);
                                                            }
                                                            ?>
                                                        </td>

                                                            <?php if ($this->Employee->has_module_action_permission('sales', 'edit_sale_price', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
            <?php if ($info_sale['suspended'] != 1) { ?>
                                                                <td style="width:88px; text-align: right; padding-right: 2px;" id="reg_item_price">
                                                                <?php
                                                                if ($info_item->unit_from) {
                                                                    if ($item['unit'] == "unit") {
                                                                        echo form_input(array(
                                                                            'name' => 'price',
                                                                            'value' => str_replace(array('.00'), '', (to_currency_unVND($item['price']))),
                                                                            'size' => '15',
                                                                            'class' => 'input_price',
                                                                            'id' => 'price_' . $line,
                                                                            'style' => 'text-align: right;'
                                                                        ));
                                                                        echo form_hidden('price_rate', to_currency_unVND($item['price_rate']));
                                                                    } else {
                                                                        echo form_input(array(
                                                                            'name' => 'price_rate',
                                                                            'value' => str_replace(array('.00'), '', (to_currency_unVND($item['price_rate']))),
                                                                            'size' => '15',
                                                                            'class' => 'input_price',
                                                                            'id' => 'price_rate_' . $line,
                                                                            'style' => 'text-align: right;'
                                                                        ));
                                                                        echo form_hidden('price', to_currency_unVND($item['price']));
                                                                        echo form_hidden('type_price', 1);
                                                                    }
                                                                } else {
                                                                    echo form_input(array(
                                                                        'name' => 'price',
                                                                        'value' => str_replace(array('.00'), '', (to_currency_unVND($item['price']))),
                                                                        'size' => '15',
                                                                        'class' => 'input_price',
                                                                        'id' => 'price_' . $line,
                                                                        'style' => 'text-align: right;'
                                                                    ));
                                                                }
                                                                ?>
                                                                </td>
                                                                    <?php
                                                                } else {
                                                                    if ($item['unit'] == "unit") {
                                                                        ?>
                                                                    <td style="width:88px; text-align: right; padding-right: 2px;" id="reg_item_price"><?php echo str_replace(array('.00'), '', (to_currency_unVND($item['price']))); ?></td>
                                                                    <?php echo form_hidden('price', to_currency_unVND($item['price'])); ?>
                                                                <?php } else { ?>
                                                                    <td  style="width:88px; text-align: right; padding-right: 2px;" id="reg_item_price"><?php echo str_replace(array('.00'), '', (to_currency_unVND($item['price_rate']))); ?></td>
                                                                    <?php echo form_hidden('price_rate', to_currency_unVND($item['price_rate'])); ?>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>


                                                        <td id="reg_item_discount">
        <?php
        if ($info_sale['suspended'] != 1) {
            echo form_input(array(
                'name' => 'discount',
                'class' => 'input_discount',
                'value' => $item['discount'],
                'size' => '3',
                'id' => 'discount_' . $line
            ));
        } else {
            echo $item['discount'];
            echo form_hidden('discount', $item['discount']);
        }
        ?>
                                                        </td>

                                                        <td id="reg_item_taxes">
                                                            <?php
                                                               echo form_input(array(
                                                                'name' => 'taxes',
                                                                'class' => 'input_taxes',
                                                                'value' => $item['taxes'],
                                                                'size' => '3',
                                                                'id' => 'taxes_' . $line
                                                            ));
                                                            ?>
                                                            <?php //echo $item['taxes']; ?>
                                                        </td>
                                                        <td id="reg_item_total">                                                            
        <?php
        if ($item['unit'] == 'unit') {
            echo number_format($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100);
        } else {
            echo number_format($item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100);
        }
        ?>
                                                        </td>
                                                    </tr>

                                                    <tr id="reg_item_top" style="border-bottom: 1px solid #eee9e9;">
                                                        <td id="reg_item_descrip_label"><?php echo lang('sales_description_abbrv') . ':'; ?></td>
                                                        <td id="reg_item_descrip" colspan="7">
        <?php
        if (isset($item['allow_alt_description']) && $item['allow_alt_description'] == 1) {
            echo form_input(array('name' => 'description', 'value' => $item['description'], 'size' => '20', 'id' => 'description_' . $line));
        } else {
            if ($item['description'] != '') {
                echo $item['description'];
                echo form_hidden('description', $item['description']);
            } else {
                echo 'None';
                echo form_hidden('description', '');
            }
        }
        ?>
                                                        </td>
                                                        <td id="reg_item_serial_label">
                                                            <?php
                                                            if (isset($item['is_serialized']) && $item['is_serialized'] == 1) {
                                                                echo lang('sales_serial') . ':';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td id="reg_item_serial" colspan="2">
                                                            <?php
                                                            if (isset($item['is_serialized']) && $item['is_serialized'] == 1) {
                                                                echo form_input(array('name' => 'serialnumber', 'value' => $item['serialnumber'], 'size' => '20', 'id' => 'serialnumber_' . $line));
                                                            } else {
                                                                echo form_hidden('serialnumber', '');
                                                            }
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
                                <?php //echo "<pre>"; print_r($cart);    ?>
                    </div>
                    <div id="reg_item_base"></div>
                        <?php if ($this->config->item('track_cash')) { ?>
                        <div>
                        <?php echo anchor(site_url('sales/closeregister?continue=home'), lang('sales_close_register')); ?>
                        </div>
                        <?php } ?>
                    <div id="sales_search" >
                    <?php
                    echo
                    anchor("reports/sales_generator", "Tìm kiếm đơn hàng", array('class' => 'none',
                        'title' => lang('sales_search_reports')));
                    ?> 
                    </div>	
                </td>
                <td style="width:8px;"></td>
                <td id="over_all_sale_container" style="min-height: 710px!important;">
                    <div id="overall_sale">
                        <div id="suspend_cancel">
<?php
//only show this materials 
if ((!$payments) && (count($cart) > 0)) {
    ?>
                                <div id="suspend" <?php
                                if (count($cart) > 0) {
                                    echo "style='visibility: visible;'";
                                }
                                ?>>
                                <?php if (count($cart) > 0) { ?>
                                        <div class='small_button' id='suspend_sale_button_baogia' style="margin-left:91px;margin-top:0px">  
                                            <span><?php echo 'Báo giá'; ?></span>
                                        </div>
    <?php } ?>
                                </div>
                                <?php } else { ?>
                                <div id="suspend" <?php
                                    foreach ($payments as $payment_id => $payment) {
                                        if ($payment['payment_amount'] >= 0) {
                                            echo "style='visibility: visible;'";
                                        }
                                    }
                                    ?>>	
                                <?php
                                // Only show this part if there are Items already in the sale.


                                if (count($cart) > 0) {
                                    ?>
                                             <?php if (($total_order + $total_taxes - $total_owe) > 0) { ?>
                                            <div class='small_button' id='suspend_sale_button'> 
                                                <span><?php echo "Ghi vào sổ nợ"; ?></span>
                                            </div>
            <?php if ($info_sale['suspended'] != 1) { ?>
                                                <div class='small_button' id='suspend_sale_button_trahang' style="margin-left:91px;margin-top:-22px">
                                                    <span><?php echo 'Đặt hàng'; ?></span>
                                                </div>
                <?php
            }
        } else {
            if ($info_sale['suspended'] != 1) {
                ?>
                                                <div class='small_button' id='suspend_sale_button_trahang' style="margin-left:91px;margin-top:0px">
                                                    <span><?php echo 'Đặt hàng'; ?></span>
                                                </div>
                <?php
            }
        }
        ?>
                                    <?php } ?>
                                </div>
                                <?php } ?>

                            <div id="cancel" <?php
                            if (count($cart) > 0) {
                                echo "style='visibility: visible;'";
                            }
                            ?>>
                            <?php
// Only show this part if there are Items already in the sale.
                            if (count($cart) > 0) {
                                ?>
                                         <?php echo form_open("sales/cancel_sale", array('id' => 'cancel_sale_form')); ?>
                                    <div class='small_button' id='cancel_sale_button'>
                                        <span><?php echo 'Hủy'; ?></span>
                                    </div>
                                    </form>
<?php } ?>
                            </div>
                        </div>

                        <div id="customer_info_shell">
<?php
if (!empty($customer_email)) {
    echo '<div id="comment_label" class="comment_label">';
    echo form_checkbox(array(
        'name' => 'email_receipt',
        'id' => 'email_receipt',
        'value' => '1',
        'checked' => (boolean) $email_receipt,
    )) . ' ' . lang('sales_email_receipt') . ' : <br /><b style="padding-left: 17px;">' . character_limiter($customer_email, 25) . '</b><br />';
    echo '</div>';
}
?>
                            <?php
                            if (isset($customer)) {
                                echo "<div id='customer_info_filled'>";
                                echo '<div id="customer_name">' . character_limiter($customer, 25) . '</div>';
                                echo '<div id="customer_edit">'
                                . anchor(
                                        "customers/view/$customer_id/width~755", lang('common_edit'), array(
                                    'class' => 'thickbox none',
                                    'title' => lang('customers_update')
                                        )
                                ) . '</div>';
                                if ($info_sale['suspended'] != 1) {
                                    echo '<div id="customer_remove">' . anchor("sales/delete_customer", lang('sales_detach'), array('id' => 'delete_customer')) . '</div>';
                                }
                                echo "</div>";
                            } else {
                                ?>
                                <div id='customer_info_empty' <?php
                                if (count($cart) == 0)
                                    echo 'style="margin-top: -24px;"';
                                else
                                    echo 'style="margin-top: -1px"'
                                    ?>>
                                <?php echo form_open("sales/select_customer", array('id' => 'select_customer_form')); ?>
                                    <label id="customer_label" class="label_one" for="customer" <?php if (count($cart) > 0) echo 'style="margin-left: 5px;margin-bottom: 2px "' ?>>
                                     <?php echo lang('sales_select_customer'); ?>
                                    </label>
                                        <?php echo form_input(array('name' => 'customer', 'id' => 'customer', 'size' => '30', 'placeholder' => lang('sales_start_typing_customer_name'), 'accesskey' => 'c')); ?>
                                    </form>
                                    <div id="add_customer_info">
                                        <div id="common_or">
    <?php echo lang('common_or'); ?>
                                        </div>
                                            <?php
                                            echo anchor("customers/view/-1/width~750", "<div class='small_button' style='margin:0 auto;font-size:11px;font-weight: bold'> <span>" . lang('sales_new_customer') . "</span> </div>", array('class' => 'thickbox none', 'title' => lang('sales_new_customer')));
                                            ?>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                </div>
<?php } ?>

                        </div>


                        <div id='sale_details'>
                            <table id="sales_items">
                                <tr>
                                    <td class="left"><?php echo lang('sales_items_in_cart'); ?>:</td>
                                    <td class="right" style="text-align: left;padding-left: 5px"><?php echo $items_in_cart; ?></td>
                                </tr>
<?php foreach ($payments as $payment) { ?>
    <?php if (strpos($payment['payment_type'], lang('sales_giftcard')) !== FALSE) { ?>
                                        <tr>
                                            <td class="left"><?php echo $payment['payment_type'] . ' ' . lang('sales_balance') ?>:</td>
                                            <td class="right" style="text-align: left;padding-left: 5px"><?php echo to_currency($this->Giftcard->get_giftcard_value(end(explode(':', $payment['payment_type']))) - $payment['payment_amount']); ?></td>
                                        </tr>
    <?php } ?>
<?php } ?>
                                <tr>
                                    <td class="left"><?php echo lang('sales_sub_total'); ?>:</td>
                                    <td class="right" style="text-align: right;padding-left: 5px"><?php echo to_currency($total_order); ?></td>
                                </tr>
                                <tr>
                                    <td class="left"><?php echo lang('sales_total_taxes'); ?>:</td>
                                    <td class="right" style="text-align: right;padding-left: 5px">
<?php echo to_currency($total_taxes); ?>
                                    </td>
                                </tr>
                            </table>
                            <table id="sales_items_total" style="border: none">
                                <tr style="border: none">
                                    <td class="left" style="border: none">Tổng tiền:</td>
                                    <td class="right" style="text-align: right;padding-left: 5px;border:none;font-size: 15px">
<?php echo to_currency($total_order + $total_taxes); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

<?php
// Only show this part if there are Items already in the sale.
if (count($cart) > 0) {
    ?>
                            <div id="Payment_Types">
                            <?php
                            // Only show this part if there is at least one payment entered.
                            if (count($payments) > 0) {
                                ?>
                                    <table id="register">
                                        <thead>
                                            <tr>
                                                <th id="pt_delete"></th>
                                                <th id="pt_type"><?php echo lang('sales_type'); ?></th>
                                                <th id="pt_type"><?php echo lang('sales_amount'); ?></th>
                                                <th id="pt_amount"><?php echo 'CKTM'; ?></th>

                                            </tr>
                                        </thead>
                                        <tbody id="payment_contents">
        <?php
        foreach ($payments as $payment_id => $payment) {
            echo form_open("sales/edit_payment/" . rawurlencode($payment_id), array('id' => 'edit_payment_form' . $payment_id));
            ?>
                                                <tr>
                                                    <td id="pt_delete"><?php echo anchor("sales/delete_payment/" . rawurlencode($payment_id), '[' . lang('common_delete') . ']', array('class' => 'delete_payment')); ?></td>


                                                    <td id="pt_type"><?php echo $payment['payment_type'] ?> </td>
                                                    <td id="pt_amount"><?php echo to_currency($payment['payment_amount']) ?>  </td>
                                                    <td id="pt_amount"><?php echo to_currency($payment['discount_money']) ?>  </td>

                                                </tr>
                                                </form>
            <?php
        }
        ?>
                                        </tbody>
                                    </table>
                                        <?php } ?>

                                <table id="amount_due">
                                    <input type="hidden" value="<?= ($total_order + $total_taxes - $total_owe) ?>" id="amount_final"></input>
    <?php if (($total_order + $total_taxes - $total_owe) > 0) { ?>
                                        <tr class="<?php
        if ($payments_cover_total1) {
            echo 'covered';
        }
        ?>">
                                            <td>
                                                <div class="float_left" style="font-size:.8em;width: 122px;">
                                            <?php echo lang('sales_amount_due'); ?>:
                                                </div>
                                            </td>
                                            <td style="text-align:right; ">
                                                <div class="float_left" style="text-align:right;font-weight:bold;width: 105px;">
        <?php echo to_currency($total_order + $total_taxes - $total_owe); ?>
                                                </div>
                                            </td>

                                        </tr>
    <?php } else { ?>
                                        <tr class="<?php
        if ($payments_cover_total1) {
            echo 'covered';
        }
        ?>">
                                            <td>
                                                <div class="float_left" style="font-size:.8em;width: 122px;"><?php echo lang('sales_amount_due_du'); ?>:</div>
                                            </td>
                                            <td style="text-align:right; ">
                                                <div class="float_left" style="text-align:right;font-weight:bold;width: 105px;">
        <?php echo to_currency(abs($total_order + $total_taxes - $total_owe)); ?>
                                                </div>
                                            </td>
                                        </tr>
    <?php } ?>
                                </table>
                                <div id="make_payment">
                                    <?php echo form_open("sales/add_payment", array('id' => 'add_payment_form')); ?>
                                    <table id="make_payment_table">
                                        <tr id="mpt_top">
                                            <td>
                                                <label style="margin-left: -9px; padding: 0; width: 124px"><?php echo lang('sales_payment') . ':'; ?></label>
                                                <span id="span_one" style="display: inline-block; ">
                                                    <?= form_dropdown('payment_type', $payment_options, $payment_type, 'id ="payment_type"'); ?>
                                                </span>
                                            </td>
                                            
                                             
                                        </tr>
                                        <tr class="tr_bank">
                                            <td colspan="2">
                                                <?= form_dropdown('bank_account', $bank_list, $bank_account, 'class=bank_account'); ?>
                                            </td>
                                        </tr>
                                        <!-- Tiền khách trả-->
                                        <tr>
                                            <td colspan="2">
                                                <label style="font-size: .85em;line-height: 33px;margin-left: -5px; margin-top: 15px">Nhập tiền khách hàng trả</label>

    <?php
    echo form_input(array(
        'name' => 'amount_tendered',
        'id' => 'amount_tendered',
        'size' => '28', 'accesskey' => 'p',
        'placeholder' => 'Nhập tiền khách trả...',
        'style' => 'height:26px;',
        'value' => str_replace(array('.00'), '', ''),
    ));
    ?> 

                                            </td>
                                        </tr>
                                        <!-- end//-->

                                        <!-- ck tiền mặt-->
                                        <tr>
                                            <td colspan="2">
                                                <label style="font-size: .85em;line-height: 33px;margin-left: -5px; margin-top: 15px">Chiết khấu tiền mặt</label>

    <?php
    echo form_input(array(
        'name' => 'discount_money',
        'id' => 'discount_money',
        'size' => '28',
        'placeholder' => 'Chiết khấu tiền mặt...',
        'style' => 'height:26px;',
        'value' => str_replace(array('.00'), '', (to_currency_unVND($discount_money))),
    ));
    ?> 

                                            </td>
                                        </tr>
                                        <!-- end //-->

                                        <tr>
                                            <td colspan="2">
                                                <label style="font-size: .85em;line-height: 33px;margin-left: -5px; margin-top: 15px">Nhân viên báo giá</label>
    <?php
    $sale_info = $this->Sale->get_info($sale_id)->row_array();
    $selected_employees2 = $this->Employee->get_info($sale_info['employees_id'])->person_id;
    echo form_input(array(
        'name' => 'employeess_id_input',
        'id' => 'employeess_id_input',
        'size' => '30',
        'placeholder' => 'Nhập tên nhân viên báo giá...',
        'style' => 'height:26px;',
        'value' => isset($employees) ? $employees : ''
    ));
    ?> 
                                                <table id="row_selected1" style="margin-top: 30px">
                                                </table><br>                                              
                                            </td>
                                        </tr>

                                        <!-- nv giao hàng dungbv-->
    <?php
    if ($this->config->item('delivery') == 1) {
        ?>
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;margin-top: -15px">Nhân viên giao hàng</label>
        <?php
        $sale_info1 = $this->Sale->get_info($sale_id)->row_array();
        $selected_employees3 = $this->Employee->get_info($sale_info1['delivery_employee'])->person_id;
        ?>
                                                    <div class='form_field' style="height: 40px">
                                                    <?php
                                                    echo form_input(array(
                                                        'name' => 'delivery_employee_input',
                                                        'id' => 'delivery_employee_input',
                                                        'size' => '30',
                                                        'placeholder' => 'Nhập tên nhân viên giao hàng...',
                                                        'style' => 'height:26px',
                                                        'value' => isset($delivery) ? $delivery : ''
                                                    ));
                                                    ?> 
                                                        <table id="row_selected" style="margin-top: 30px">
                                                        </table><br>
                                                    </div>	
                                                </td>
                                            </tr>	                                            
    <?php } ?>
                                            
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;">Ký hiệu hóa đơn</label>
                                       
                                                    <div class='form_field' style="height: 40px">
                                                    <?php
                                                   
                                                    echo form_input(array(
                                                        'name' => 'symbol_order',
                                                        'id' => 'symbol_order',
                                                        'size' => '30',
                                                        'placeholder' => 'Ký hiệu hóa đơn...',
                                                        'style' => 'height:26px',
                                                        'value' => isset($symbol_order) ? $symbol_order :''
                                                    ));
                                                    ?> 
                                                       
                                                    </div>	
                                                </td>
                                            </tr>
                                            
                                             <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;margin-top: 15px">Số hóa đơn</label>
       
                                                    <div class='form_field' style="height: 40px">
                                                    <?php
                                                    echo form_input(array(
                                                        'name' => 'number_order',
                                                        'id' => 'number_order',
                                                        'size' => '30',
                                                        'placeholder' => 'Số hóa đơn...',
                                                        'style' => 'height:26px',
                                                        'value' => isset($number_order) ?  $number_order :''
                                                    ));
                                                    ?> 
                                                       
                                                    </div>	
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;margin-top: 30px">Ngày hóa đơn</label>
       
                                                    <div class='form_field' style="height: 40px">
                                                        <input type="text" name="date_debt1" id="date_debt1" value="<?php echo $date_debt1; ?>" required = "required"/>
                                                       
                                                    </div>	
                                                </td>
                                            </tr>
                                            
                                            <?php
                                             $arr = array();
                                            $gia_ca = array();
                                            foreach (array_reverse($cart, true) as $line => $item) {
                                                $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                                                $gia_ca[$this->Item->get_info($item['item_id'])->account_cos] += $net_price;
                                                foreach ($gia_ca as $k1 => $v1){
                                                     $arr[$k1] = $v1;
                                                }
                                                
                                            }
                                                ?>
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;margin-top: 10px"></label>
       
                                                    <div class='form_field' style="height: 40px">
                                                        <?php
                                                            foreach ($arr as $k => $v){?>
                                                       
                                                        <input type="text" disabled="true" size="30" value="<?='Có '.$k.': '.number_format($v)?>"/>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>	
                                                </td>
                                            </tr>
                                          
                                        <!--end-->
                                           <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;margin-top: 10px"></label>
       
                                                    <div class='form_field' style="height: 40px">
                                                        <input type="text" disabled="true" size="30" value="<?='Có 1331:'.number_format($total_taxes)?>" name="load_account"/>
                                                    </div>	
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="2">
                                                    <label style="font-size: .85em;line-height: 33px;margin-left: -5px;margin-top: 10px"></label>
       
                                                    <div class='form_field' style="height: 40px">
                                                        <input type="text" disabled="true" size="30" value="<?='Nợ 131:'.  number_format($total_taxes+$total_order)?>"/>
                                                    </div>	
                                                </td>
                                            </tr>
                                    </table>


                                    <div class='small_button' id='add_payment_button' style="margin-top:70px;margin-left: -10px">
                                        <span><?php echo lang('sales_add_payment'); ?></span>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- phan lam 2/9/2013 -->
                            <div>
                                <label style="margin-top:-7px;">Ngày hoạch toán : </label>
                                <input type="text" name="date_debt" id="date_debt" value="<?php echo $date_debt; ?>" required = "required" />
                            </div>
                            
                            <!-- end phan lam -->
                            <div id="finish_sale">
    <?php echo form_open("sales/complete", array('id' => 'finish_sale_form')); ?>
    <?php
    echo '<label id="comment_label" for="comment" style="width: 54px;float: left;margin-top: 15px;">';
    echo lang('common_comments');
    echo ':</label><br />';
    echo form_textarea(array('name' => 'comment', 'id' => 'comment', 'value' => $comment, 'rows' => '1', 'accesskey' => 'o'));
    // Only show this part if there is at least one payment entered.
    if (count($payments) > 0 && !is_sale_integrated_cc_processing()) {
        if ($payments_cover_total1) {
            echo "<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>" . lang('sales_complete_sale') . "</span></div>";
        }
        ?>
                                    </form>
                                </div>                                
                                <?php } elseif (count($payments) > 0) { ?>
                                <div id="finish_sale">
                                <?php
                                echo form_open("sales/complete", array('id' => 'finish_sale_form'));
                                if ($payments_cover_total1) {
                                    echo "<div class='small_button' id='finish_sale_button' style='float:left;margin-top:5px;'><span>" . lang('sales_complete_sale') . "</span></div>";
                                }
                                ?>
                                    </form>
                                </div>                                
                                <?php } ?>
<?php } ?>
                    </div><!-- END OVERALL-->		
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
<?php $this->load->view("partial/abouts"); ?>
    </div></div>
<?php
if (isset($error)) {
    echo "set_feedback(" . json_encode($error) . ",'error_message',false);";
}
if (isset($warning)) {
    echo "set_feedback(" . json_encode($warning) . ",'warning_message',false);";
}
if (isset($success)) {
    echo "set_feedback(" . json_encode($success) . ",'success_message',false);";
}?>
<script type="text/javascript" language="javascript">
    //Nov 3
    if( $('#payment_type').val() == 'CKNH'){
        $('.tr_bank').show();
    }else{
        $('.tr_bank').hide();
    }
    $('#payment_type').change(function(){
        if( $('#payment_type').val() == 'CKNH'){
            $('.tr_bank').show();
        }else{
            $('.tr_bank').hide();
        }
    });
    $('#payment_type').change(function (){
        $.post('<?php echo site_url("sales/set_payment_type"); ?>', {payment_type: $('#payment_type').val()});
    });
    $('.bank_account').change(function () {
        $.post('<?php echo site_url("sales/set_bank_account"); ?>', {bank_account: $('.bank_account').val()});
    });//end Nov 3
    
    //nv giao hang
    $("#delivery_employee_input").autocomplete({
        source: '<?php echo site_url("employees/info_name_employee_suggest"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#delivery_employee_input").val("");
            if ($("#row_selected" + ui.item.value).length == 1) {
                $("#row_selected" + ui.item.value).val(parseFloat($("#row_selected" + ui.item.value).val()) + 1);
            } else {
                $("#delivery_employee_input").addClass("disable_input_cost");
                $("#row_selected").append("<tr><td width='300px'>" + ui.item.label + "</td><td><a href='#' style='text-decoration: underline' onclick='return deleteRow(this);'>Xóa</a></td><td><input type='hidden' size='3' id='delivery_employee' name='delivery_employee' value='" + ui.item.value + "'/></td></tr>");
                $.post('<?php echo site_url("sales/set_employees_delivery"); ?>', {delivery_employee: $('#delivery_employee').val()});
            }

            return false;
        }
    });
    function deleteRow(link) {
        $("#delivery_employee_input").removeClass("disable_input_cost");
        $(link).parent().parent().remove();
        return false;
    }////nv giao hang
    
    //nv báo giá
    $("#employeess_id_input").autocomplete({
        source: '<?php echo site_url("employees/info_name_employee_suggest"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#employeess_id_input").val("");
            if ($("#row_selected1" + ui.item.value).length == 1) {
                $("#row_selected1" + ui.item.value).val(parseFloat($("#row_selected1" + ui.item.value).val()) + 1);
            } else {
                $("#employeess_id_input").addClass("disable_input_cost");
                $("#row_selected1").append("<tr><td width='300px'>" + ui.item.label + "</td><td><a href='#' style='text-decoration: underline' onclick='return deleteRow1(this);'>Xóa</a></td><td><input type='hidden' size='3' id='employees_id' name='employees_id' value='" + ui.item.value + "'/></td></tr>");
                $.post('<?php echo site_url("sales/set_employees_id"); ?>', {employees_id: $('#employees_id').val()});
            }

            return false;
        }
    });
    function deleteRow1(link) {
        $("#employeess_id_input").removeClass("disable_input_cost");
        $(link).parent().parent().remove();
        return false;
    }//end nv bao gia
    
    $(document).ready(function () {
        <?php
        if ($this->Sale->get_sale_id_liability($sale_id) == 1) {
            $stt = 0;
            foreach ($payments as $payment_id => $payment) {
                $aa += $payment['payment_amount'] + $payment['discount_money'];
                if ($amount_due1 <= 0 && $stt < 1) {?>
                    $('#finish_sale_button').show();
                <?php 
                } elseif (($aa == $total || $aa > $total) && $stt >= 1) {?>
                    $('#finish_sale_button').show();
                    <?php
                } 
                $stt++;
            }
        }?>
                
                  
//        $('#date_debt').datePicker().bind('dpClosed', function (e, selectedDates) {
//            var d = selectedDates[0];
//            if (d) {
//                d = new Date(d);
//                $('#start-date').dpSetEndDate(d.addDays(-1).asString());
//            }
//        });
//        
//        $('#date_debt1').datePicker().bind('dpClosed', function (e, selectedDates) {
//            var d = selectedDates[0];
//            if (d) {
//                d = new Date(d);
//                $('#start-date').dpSetEndDate(d.addDays(-1).asString());
//            }
//        });
 

 
         $('#date_debt').datePicker({startDate: '01-01-1950'}).bind(
            'dpClosed',
            function (e, selectedDates) {
                var d = selectedDates[0];
                if (d) {
                    d = new Date(d);
                    $('#date_debt').dpSetStartDate(d.addDays(0).asString());
                }
            }
    );

    $('#date_debt1').datePicker({startDate: '01-01-1950'}).bind(
            'dpClosed',
            function (e, selectedDates) {
                var d = selectedDates[0];
                if (d) {
                    d = new Date(d);
                    $('#date_debt1').dpSetStartDate(d.addDays(0).asString());
                }
            }
    );
        
        $(".input_price").maskMoney();
        $("#amount_tendered").maskMoney();
        $("#discount_money").maskMoney();

        var my_ar = new Array("reg_item_total", "reg_item_discount", "reg_item_qty", "reg_item_price", "reg_item_stock", "reg_item_number", "reg_item_name", "reg_item_del", "reg_item_unit", "reg_item_taxes");
        for (i = 0; i < my_ar.length; i++) {
            my_th = $("th#" + my_ar[i]);
            my_td = $("td#" + my_ar[i]);
            my_td.each(function (i) {
                $(this).width(my_th.width());
            });
        }
        AddCSS();
        $('a.thickbox, area.thickbox, input.thickbox').each(function (i) {
            $(this).unbind('click');
        });
        tb_init('a.thickbox, area.thickbox, input.thickbox');
        $('#add_item_form, #mode_form, #select_customer_form, #add_payment_form, #add_date_debt_form').ajaxForm({
            target: "#register_container",
            beforeSubmit: salesBeforeSubmit, success: salesSuccess
        });
        $("#cart_contents input").change(function () {
            var toFocusId = $(":input[type!=hidden]:eq(" + ($(":input[type!=hidden]").index(this) + 1) + ")").attr('id');
            $(this.form).ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: function () {
                    salesSuccess();
                    setTimeout(function () {
                        $('#item').focus();
                    }, 10);
                }
            });
        });
        $(".input_price").focusout(function () {
            var toFocusId = $(":input[type!=hidden]:eq(" + ($(":input[type!=hidden]").index(this) + 1) + ")").attr('id');
            $(this.form).ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: function () {
                    salesSuccess();
                    setTimeout(function () {
                        $('#' + toFocusId).focus().select();
                    }, 10);
                }
            });
        });
        $(".input_quantity").focusout(function () {
            var toFocusId = $(":input[type!=hidden]:eq(" + ($(":input[type!=hidden]").index(this) + 1) + ")").attr('id');
            $(this.form).ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: function () {
                    salesSuccess();
                    setTimeout(function () {
                        $('#' + toFocusId).focus().select();
                    }, 50);
                }
            });
        });
        $(".unit").change(function () {
            var toFocusId = $(":input[type!=hidden]:eq(" + ($(":input[type!=hidden]").index(this) + 1) + ")").attr('id');
            $(this.form).ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: function () {
                    salesSuccess();
                }
            });
        });
        $("#item").autocomplete({
            source: '<?php echo site_url("sales/item_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui) {
                event.preventDefault();
                $("#item").val(ui.item.value);
                $('#add_item_form').ajaxSubmit({
                    target: "#register_container",
                    beforeSubmit: salesBeforeSubmit,
                    success: salesSuccess
                });
            },
            change: function (event, ui) {
                if ($(this).attr('value') != '' && $(this).attr('value') != <?php echo json_encode(lang('sales_start_typing_item_name')); ?>) {
                    $("#add_item_form").ajaxSubmit({
                        target: "#register_container",
                        beforeSubmit: salesBeforeSubmit,
                        success: salesSuccess
                    });
                }
                $(this).attr('value',<?php echo json_encode(lang('sales_start_typing_item_name')); ?>);
            }
        });
        setTimeout(function () {
            $('#item').focus();
        }, 10);
        $('#item,#customer').click(function () {
            $(this).attr('value', '');
        });
        $("#customer").autocomplete({
            source: '<?php echo site_url("sales/customer_search"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui) {
                $("#customer").val(ui.item.value);
                $('#select_customer_form').ajaxSubmit({
                    target: "#register_container",
                    beforeSubmit: salesBeforeSubmit,
                    success: salesSuccess
                });
            }
        });
        $('#customer').blur(function () {
            $(this).attr('value',<?php echo json_encode(lang('sales_start_typing_customer_name')); ?>);
        });
        $('#store').change(function () {
            $.post('<?php echo site_url("sales/set_store"); ?>', {store: $('#store').val()});
        });
        $('#comment').change(function () {
            $.post('<?php echo site_url("sales/set_comment"); ?>', {comment: $('#comment').val()});
        });
        $('#discount_money').change(function () {
            $.post('<?php echo site_url("sales/set_discount_money"); ?>', {discount_money: $('#discount_money').val()});
        });
        $('#date_debt').change(function () {
            $.post('<?php echo site_url("sales/add_date_debt"); ?>', {date_debt: $('#date_debt').val()});
        });
        
          $('#date_debt1').change(function () {
            $.post('<?php echo site_url("sales/add_date_debt1"); ?>', {date_debt1: $('#date_debt1').val()});
        });
        
          $('#symbol_order').change(function () {
            $.post('<?php echo site_url("sales/set_symbol_order"); ?>', {symbol_order: $('#symbol_order').val()});
        });
        
        $('#number_order').change(function () {
            $.post('<?php echo site_url("sales/set_number_order"); ?>', {number_order: $('#number_order').val()});
        });
        
        $('#show_comment_on_receipt').change(function () {
            $.post('<?php echo site_url("sales/set_comment_on_receipt"); ?>', {show_comment_on_receipt: $('#show_comment_on_receipt').is(':checked') ? '1' : '0'});
        });

        $('#email_receipt').change(function () {
            $.post('<?php echo site_url("sales/set_email_receipt"); ?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
        });

        $.post('<?php echo site_url("sales/add_load_account"); ?>', {load_account: $('#load_account').val()});

        $("#finish_sale_button").click(function () {
            <?php 
            if (!$this->config->item('disable_confirmation_sale')) { ?>
                if (confirm(<?php echo json_encode(lang("sales_confirm_finish_sale")); ?>)){
            <?php 
            } ?>
                    $('#finish_sale_form').submit();
            <?php 
            if (!$this->config->item('disable_confirmation_sale')) { ?>
                }
            <?php 
            } ?>
        });
        $("#suspend_sale_button").click(function () {
            var customer_id = "<?php echo $customer_id; ?>";
            var amount_final = $("#amount_final").val();
            var data = "customer_id=" + customer_id + "&amount_final=" + amount_final;
            $.ajax({
                type: "post",
                url: "<?php echo site_url() . 'sales/check_cong_no'; ?>",
                data: data,
                success: function (data) {
                    if (data == 1) {
                        if (confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>)) {
                            $("#register_container").load('<?php echo site_url("sales/suspend"); ?>');
                        }
                    } else {
                        alert("Công nợ đã vượt ngưỡng cho phép! Không thể tiếp tục ghi nợ");
                        return false;
                    }
                }
            });
        });
        $("#suspend_sale_button_trahang").click(function () {
            if (confirm(<?php echo json_encode('Bạn có chắc chắn muốn đặt đơn hàng này không?'); ?>)) {
                $("#register_container").load('<?php echo site_url("sales/liability"); ?>');
            }
        });
        $("#suspend_sale_button_baogia").click(function () {
            if (confirm(<?php echo json_encode('Bạn có chắc chắn muốn thực hiện báo giá này không?'); ?>)) {
                $("#register_container").load('<?php echo site_url("sales/materials"); ?>');
            }
        });
        $("#cancel_sale_button").click(function () {
            if (confirm(<?php echo json_encode(lang("sales_confirm_cancel_sale")); ?>)) {
                $('#cancel_sale_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
            }
        });
        $("#cancel_sale_button_trahang").click(function () {
            if (confirm(<?php echo json_encode(lang("sales_confirm_cancel_sale")); ?>)) {
                $('#cancel_sale_form_trahang').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
            }
        });
        $("#add_payment_button").click(function () {
            //Nov 5
            if( $('#payment_type').val() == ''){
                alert('Bạn chưa chọn hình thức thanh toán');return false;
            }else if( $('#payment_type').val() == 'CKNH' && $('.bank_account').val() == ''){
                alert('Bạn chưa chọn tài khoản ngân hàng');return false;
            }
            
            var amount = $('#amount_final').val();
            $('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
<?php if ($this->Sale->get_sale_id_liability($sale_id) == 1) { ?>
                $('.finish_final').show();
<?php } ?>
        });
        $("#payment_types").change(checkPaymentTypetrahang).ready(checkPaymentTypetrahang);
        $("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard);
        $('#mode').change(function () {
            $('#mode_form').ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: salesSuccess
            });
        });
        $('.delete_item, .delete_payment, #delete_customer, #delete_all').click(function (event) {
            event.preventDefault();
            $("#register_container").load($(this).attr('href'));
        });
    });
    function post_item_form_submit(response) {
        if (response.success) {
            $("#item").attr("value", response.item_id);
            $('#add_item_form').ajaxSubmit({
                target: "#register_container",
                beforeSubmit: salesBeforeSubmit,
                success: salesSuccess
            });
        }
    }
    function post_person_form_submit(response) {
        if (response.success) {
            if ($("#select_customer_form").length == 1) {
                $("#customer").attr("value", response.person_id);
                $('#select_customer_form').ajaxSubmit({
                    target: "#register_container",
                    beforeSubmit: salesBeforeSubmit,
                    success: salesSuccess
                });
            } else {
                $("#register_container").load('<?php echo site_url("sales/reload"); ?>');
            }
        }
    }
    function checkPaymentTypetrahang() {
        $("#suspend_cancel").show();
        $("#finish_sale_trahang").hide();
    }
    function checkPaymentTypeGiftcard() {
        if ($("#payment_types").val() == <?php echo json_encode(lang('sales_giftcard')); ?>) {
            $("#amount_tendered_label").html(<?php echo json_encode(lang('sales_giftcard_number')); ?>);
            $("#amount_tendered").val('');
            $("#amount_tendered").focus();
        } else {
            $("#amount_tendered_label").html(<?php echo json_encode(lang('sales_amount_tendered')); ?>);
        }
    }
    function salesBeforeSubmit(formData, jqForm, options) {
        $("#add_payment_button").hide();
        $("#TB_load").show();
    }
    function salesSuccess(responseText, statusText, xhr, $form) {}
    function AddCSS() {
        $('#item').change(function () {
            $('ul').addClass('css_new');
        });
    }
</script>





