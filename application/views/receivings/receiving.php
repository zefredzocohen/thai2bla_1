
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
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
                /*//Nov 3*/
                .tr_bank{
                    border: 1px solid #eee9e9;
                }
                .bank_account{
                    border: 1px solid #ccc;
                    height: 22px;
                }
            </style>
            <td id="register_items_container">
                <table id="title_section">
                    <tr>
                        <td id="title_icon">
                            <a href="<?php echo base_url() ?><?php echo "receivings"; ?>">
                                <img src='<?php echo base_url() ?>images/menubar/receivings.png' alt='title icon' />
                            </a>
                        </td>
                        <?php
                        $recv_id = $this->receiving_lib->get_recv();
                        if ($recv_id != '') {
                            echo "MĐH :" . $recv_id;
                        }
                        ?>
                        <td id="title">
                            <a href="<?php echo base_url() ?><?php echo "receivings"; ?>"><?php echo lang('receivings_register'); ?></a>
                        </td>
                        <td>
                            <form action="<?= site_url('receivings/set_store'); ?>" method="post" id="store_form">
                                <?php
                                $recv_id = $this->receiving_lib->get_recv();
                                $disabled = $recv_id != '' ? 'disabled="disabled"' : '';
                                ?>

                                <span style="font-size: 12px"><?php echo 'Chọn kho :'; ?></span>
                                <select id="inventory" name="inventory">

                                    <?php
                                    if ($this->Employee->get_logged_in_employee_info()->person_id == 1) {
                                        ?>
                                        <?php if ($store_active == 0) { ?>
                                            <option value='0' selected="selected">Kho tổng</option>
                                        <?php } else { ?>
                                            <option value='0'>Kho tổng</option>
                                        <?php } ?>                                                
                                        <?php
                                        foreach ($stores as $value) {
                                            if ($this->session->userdata('stores') == $value['id']) {
                                                echo "<option value='" . $value['id'] . "' selected='selected'>" . $value['name_inventory'] . "</option>";
                                            } else {
                                                echo "<option value='" . $value['id'] . "'>" . $value['name_inventory'] . "</option>";
                                            }
                                        }
                                        ?>
                                    <?php } else { ?>
                                            
                                        <?php
                                        
                                        $info_emp = $this->Employee->get_info_in_table_employee($this->Employee->get_logged_in_employee_info()->person_id);
                                        $info_warehouse = $this->Create_invetory->get_info($info_emp->warehouse_import);
//                                        echo "<option value=''>Chọn kho</option>";
                                        if ($this->session->userdata('stores') == $info_warehouse->id) {
                                            //echo "<option value=''>Chọn kho</option>";
                                            echo "<option value='" . $info_warehouse->id . "' selected='selected'>" . $info_warehouse->name_inventory . "</option>";
                                        } else {
                                            //echo "<option value='' selected='selected'>Chọn kho</option>";
                                            echo "<option value='" . $info_warehouse->id . "'>" . $info_warehouse->name_inventory . "</option>";
                                        }
                                        ?>
                                    <?php } ?>
                                </select>
                            </form>  
                        </td>
                        <td id="register_wrapper">
                            <?php echo form_open("receivings/change_mode", array('id' => 'mode_form')); ?>
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
                            echo anchor("receivings/suspended/width~1125", "<div class='small_button'>" . 'Sổ nợ NCC' . "</div>", array(
                                'class' => 'thickbox none',
                                'title' => 'Sổ nợ nhà cung cấp'
                            ));
                            ?>
                        </td>
                    </tr>
                </table>

                <div id="reg_item_search">
                    <?php echo form_open("receivings/add", array('id' => 'add_item_form')); ?>
                    <?php
                    echo form_input(array(
                        'name' => 'item',
                        'id' => 'item',
                        'size' => '30',
                        'placeholder' => 'Điền tên mặt hàng cần nhập ... '
                    ));
                    ?>
                    <div id="new_item_button_register" >
                        <?php
                        echo anchor("items/view/-1/width~850", "<div class='small_button'><span>" . lang('items_new_item') . "</span></div>", array(
                            'class' => 'thickbox none',
                            'title' => lang('items_new_item')
                        ));
                        ?>
                    </div>
                    <?php if ($this->Employee->has_module_action_permission("receivings", "receiving_order", $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                        <div id="new_item_button_register" style="margin-top:5px;text-align: inherit">
                            <?php echo anchor(site_url() . 'receivings/receiving_order', "<div class='small_button'>Hóa đơn</div>", array('title' => 'Đơn hàng nhập')); ?>
                        </div>
                        &nbsp;
                    <?php } ?>
                    </form>
                </div>

                <div id="register_holder" style="margin-top: 15px">
                    <form method="post" action="<?= site_url('receivings/set_other_cost'); ?>" id="form_input_other_cost">
                        <label style="font-size: 13px;color: whitesmoke;font-weight: bold">Chi phí khác: 
                            <input type="text" name="other_cost" id="other_cost" value="<?=$other_cost ? $other_cost : ''?>"/>

                        </label> 

                    </form>

                    <table id="register">
                        <thead>
                            <tr>
                                <th id="reg_item_del" style="width: 5%">
                                    <a href="<?php echo base_url(); ?>receivings/delete_all" id="delete_all">
                                        <span style="color:#fff;">Xóa</span>
                                    </a>
                                </th>
                                <th style="width: 10%">Mã MH #</th>
                                <th style="width: 20%"><?php echo lang('receivings_item_name'); ?></th>
                                <th style="width: 8%">ĐVT</th>
                                <th id="reg_item_qty" style="width: 8%"><?php echo lang('receivings_quantity'); ?></th>
                                <th id="reg_item_price" style="width: 10%"><?php echo lang('receivings_cost'); ?></th>
                                <th id="reg_item_rate" style="width: 6%">Tỉ lệ qui đổi</th>
                                <th id="reg_item_discount" style="width: 8%"><?php echo lang('receivings_discount'); ?></th>
                                <th id="reg_item_total" style="width: 10%">Thành tiền</th>
                                <th id="reg_item_taxe" style="width: 5%">Thuế %</th>
                                <th style="width: 8%">Chi phí</th>
                            </tr>
                        </thead>
                        <tbody id="cart_contents">
                            <?php
                            if (count($cart) == 0) {
                                ?>
                                <tr>
                                    <td colspan='11' style="height:60px;border:none;">
                                        <div class='warning_message' style='padding:7px;'><?php echo lang('sales_no_items_in_cart'); ?></div>
                                    </td>
                                </tr>
                                <?php
                            } else {
                                $total_cost_line = 0;
                                foreach (array_reverse($cart, true) as $line => $item) {
                                    $cur_item_info = $this->Item->get_info($item['item_id']);
                                    ?>
                                    <tr>
                                        <td colspan='11'>
                                            <?php echo form_open("receivings/edit_item/$line"); ?>			
                                            <table>
                                                <tr id="reg_item_top">
                                                    <td style="width: 5%; text-align: center">
                                                        <?php
                                                        echo anchor("receivings/delete_item/$line", lang('common_delete'), array(
                                                            'class' => 'delete_item'
                                                        ));
                                                        ?>
                                                    </td>
                                                    <td align='center' style="width: 10%">
                                                        <?php echo $this->Item->get_info($item['item_id'])->item_number; ?>
                                                    </td>
                                                    <td style="width: 20%; padding-left: 3px;">
                                                        <?php echo $item['name']; ?>
                                                    </td>
                                                    <td align='center' style="width: 8%">
                                                        <?= $this->Unit->get_info($item['unit'])->name; ?>
                                                    </td>
                                                    <td style="width: 8%; text-align: center" class="reg_item_qty">
                                                        <?php
                                                        echo form_input(array(
                                                            'name' => 'quantity',
                                                            'value' => $item['quantity'],
                                                            'size' => '2',
                                                            'id' => 'quantity_' . $line,
                                                            'class' => 'quantity'
                                                        ));
                                                        ?>
                                                    </td>
                                                    <?php if ($items_module_allowed) { ?>
                                                        <td style="width: 10%; text-align: center" class="reg_item_price">
                                                            <?php
                                                            echo form_input(array(
                                                                'name' => 'price',
                                                                'value' => str_replace(array('.00'), '', (to_currency_unVND($item['price']))),
                                                                'size' => '15',
                                                                'class' => 'input_price',
                                                                'id' => 'price_' . $line
                                                            ));
                                                            ?>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td style="width: 10%; text-align: center"><?php echo $item['price']; ?></td>
                                                        <?php echo form_hidden('price', $item['price']); ?>
                                                    <?php } ?>

                                                    <td style="width: 6%; text-align: center">
                                                        <?php
                                                        if ($item['unit_rate'] > 0 && $item['quantity_first'] > 0) {
                                                            echo $item['quantity_first'] . ' : ' . $item['unit_rate'];
                                                        } else {
                                                            echo '1 : 1';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="width: 8%; text-align: center" class="reg_item_discount">
                                                        <?php
                                                        echo form_input(array(
                                                            'name' => 'discount',
                                                            'value' => $item['discount'],
                                                            'size' => '3',
                                                            'id' => 'discount_' . $line
                                                        ));
                                                        ?>
                                                    </td>
                                                    <td style="width: 10%; padding-left: 3px;">
                                                        <?php
                                                        $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                                                        echo to_currency($net_price);
                                                        ?>

                                                    </td>
                                                    <td style="width: 5%; text-align: center" class="reg_item_taxe">
                                                        <?php echo form_input(array('name' => 'taxes', 'value' => $item['taxes'], 'size' => '3', 'id' => 'taxes_' . $line)); ?>
                                                    </td>
                                                    <td style="width: 8%; text-align: center">
                                                        <?php
                                                        $total_cost_line += ($net_price / $total_order) * $this->receiving_lib->get_other_cost();
                                                        echo to_currency(($net_price / $total_order) * $this->receiving_lib->get_other_cost());
                                                        ?>
                                                    </td>

                                                </tr>
                                                <tr id="reg_item_bottom" style="border-bottom: 1px solid #eee9e9;">
                                                    <td id="reg_item_descrip_label"><?php echo lang('sales_description_abbrv') . ':'; ?></td>
                                                    <td id="reg_item_descrip" colspan="7">
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
                        if (count($cart) > 0) {
                            echo "style='visibility: visible;'";
                        }
                        ?>>	
                                 <?php
                                 // Only show this part if there are Items already in the sale.
                                 if (count($cart) > 0) {
                                     ?>

                                <?php //if($amount_due1 > 0) {     ?>
                                <div class='small_button' id='suspend_sale_button'> 
                                    <span><?php echo "Ghi vào sổ nợ"; ?></span>
                                </div>

                                <?php //}     ?>

                            <?php } ?>
                        </div>
                        <div id="cancel" <?php
                        if (count($cart) > 0) {
                            echo "style='visibility: visible;'";
                        }
                        ?>>											
                                 <?php
                                 // Only show this part if there are Items already in the sale.
                                 if (count($cart) > 0) {
                                     ?>
                                     <?php echo form_open("receivings/cancel_receiving", array('id' => 'cancel_sale_form')); ?>
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
                            echo '<div id="customer_edit">' . anchor("suppliers/view/$supplier_id/width~490", lang('common_edit'), array(
                                'class' => 'thickbox none',
                                'title' => lang('suppliers_update')
                            )) . '</div>';
                            echo '<div id="customer_remove">' . anchor("receivings/delete_supplier", lang('sales_detach'), array(
                                'id' => 'delete_supplier'
                            )) . '</div>';
                            echo "</div>";
                        } else {
                            ?>
                            <div id='customer_info_empty' <?php if ($supplier == 0) echo 'style="margin-top: -24px"'; ?>>
                                <?php echo form_open("receivings/select_supplier", array('id' => 'select_supplier_form')); ?>
                                <label id="customer_label" for="supplier" style="margin-left: 0px">
                                    <?php echo lang('receivings_select_supplier'); ?>
                                </label>
                                <?php
                                echo form_input(array(
                                    'name' => 'supplier',
                                    'id' => 'supplier',
                                    'size' => '30',
                                    'placeholder' => lang('receivings_start_typing_supplier_name')
                                ));
                                ?>
                                </form>
                                <div id="add_customer_info">
                                    <div id="common_or" ><?php echo lang('common_or'); ?></div>
                                    <?php
                                    echo anchor("suppliers/view/-1/width~490", "<div class='small_button' style='margin:0 auto;'><span>" . lang('receivings_new_supplier') . "</span></div>", array('class' => 'thickbox none', 'title' => lang('receivings_new_supplier')));
                                    ?>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                            </div>
                        <?php } ?>
                    </div>
                    <div id='sale_details' style="float:left;width:220px">
                        <table id="sales_items" style="margin-top:10px">
                            <tr>
                                <td class="left"><?php echo lang('sales_sub_total'); ?>:</td>
                                <td class="right" style="text-align: right;padding-left: 5px">
                                    <?php echo to_currency($total_order); ?></td>
                            </tr>
                            <tr>
                                <td class="left"><?php echo lang('sales_total_taxes'); ?>:</td>
                                <td class="right" style="text-align: right;padding-left: 5px">
                                    <?php echo to_currency($total_taxes); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="left"><?php echo 'Tổng chi phí'; ?>:</td>
                                <td class="right" style="text-align: right;padding-left: 5px">
                                    <?php echo to_currency($this->receiving_lib->get_other_cost()); ?>
                                </td>
                            </tr>
                        </table>
                        <table id="sales_items_total">
                            <tr>
                                <td class="left">Tổng thanh toán:</td>
                                <td name="right" class="right"><?php echo to_currency($total + $this->receiving_lib->get_other_cost()); ?></td>
                            <input type="hidden" value="<?php echo $total; ?>" name="total_total" class="total_total">
                            </tr>
                        </table>
                    </div>

                    <?php
                    // Only show this part if there are Items already in the Table.
                    if (count($cart) > 0) {
                        ?>
                        <div id="finish_sale">
                            <?php echo form_open("receivings/complete", array('id' => 'finish_sale_form')); ?>
                            <div id="make_payment" style="float:left">
                                <table id="make_payment_table">
                                    <tr id="mpt_top">
                                        <td>
                                            <label style="margin-left: -9px; padding: 0; width: 124px"><?php echo lang('sales_payment') . ':'; ?></label>
                                            <span id="span_one" style="display: inline-block;margin-top: 7px;">
                                                <?php echo form_dropdown('payment_type', $payment_options, $pays_type, 'id ="payment_type"'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="tr_bank">
                                        <td>
                                            <?= form_dropdown('bank_account', $bank_list, $bank_account, 'class=bank_account'); ?>
                                        </td>
                                    </tr>
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -58px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;">Nhập tiền cần trả</label>
                                            <?php
                                            echo form_input(array(
                                                'name' => 'amount_tendered',
                                                'id' => 'amount_tendered',
                                                'class' => 'amount_tendered',
                                                'value' => $amount_tendered,
                                                'size' => '10'
                                            ));
                                            ?>			
                                        </td>

                                    </tr>   
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -68px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;">Ký hiệu hóa đơn</label>
                                            <?php
                                            echo form_input(array(
                                                'name' => 'symbol_order',
                                                'id' => 'symbol_order',
                                                'class' => 'symbol_order',
                                                'value' => $symbol_order ? $symbol_order : '',
                                                'size' => '10',
                                                'style' => 'font-size:16px'
                                            ));
                                            ?>			
                                        </td>

                                    </tr>  
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -88px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;">Số hóa đơn</label>
                                            <?php
                                            echo form_input(array(
                                                'name' => 'number_order',
                                                'id' => 'number_order',
                                                'class' => 'number_order',
                                                'value' => $number_order ? $number_order : '',
                                                'size' => '10',
                                                'style' => 'font-size:16px'
                                            ));
                                            ?>			
                                        </td>

                                    </tr>  
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -88px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;">Mã số thuế</label>
                                            <?php
                                            echo form_input(array(
                                                'name' => 'number_taxes',
                                                'id' => 'number_taxes',
                                                'class' => 'number_taxes',
                                                'value' => $number_taxes ? $number_taxes : '',
                                                'size' => '10',
                                                'style' => 'font-size:16px'
                                            ));
                                            ?>			
                                        </td>

                                    </tr> 
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -78px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;">Ngày hóa đơn</label>

                                            <input type="text" name="date_debt1" id="date_debt1" value="<?= $date_debt1 ? date('d-m-Y', strtotime($date_debt1)) : '' ?>" style="width:150px;font-size: 16px"/>

                                        </td>

                                    </tr> 

                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -98px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;"></label>
                                            <?php
                                            $this->load->model('Item');
                                            
                                           
                                            $arr = array();
                                            $gia_ca = array();
                                            foreach (array_reverse($cart, true) as $line => $item) {
                                                $net_price = $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
                                                $x = ($net_price / $total_order) * $this->receiving_lib->get_other_cost();
                                                $gia_ca[$this->Item->get_info($item['item_id'])->account_store] += $net_price + $x;
                                                foreach ($gia_ca as $k1 => $v1){
                                                     $arr[$k1] = $v1;
                                                }
                                            } 
                                            foreach ($arr as $k => $v){?>
                                                <input disabled="true" type="text"
                                                       value="<?= "Nợ $k: ".number_format($v) ?>" style="font-size: 16px"/>
                                                <?php
                                            }?>
                                        </td>
                                    </tr>
                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -88px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;"></label>
                                            <input disabled="true" 
                                                   value="<?= 'Nợ 1331:' . number_format($total_taxes) ?>" style="font-size: 16px"/> 
                                            <input type="hidden" name="load_account" id="load_account"
                                                       value="<?= $total_taxes ?>" /> 
                                        </td>

                                    </tr> 

                                    <tr id="mpt_bottom">
                                        <td id="tender" colspan="2">
                                            <label style="font-size: .85em;margin-left: -88px;margin-bottom: -11px; margin-top: 10px; line-height: 22px;"></label>
                                            <input disabled="true" type="text" name="load_account_khac" id="load_account_khac" value="<?= 'Có 331:' . number_format($total + $this->receiving_lib->get_other_cost()) ?>" style="font-size: 16px"/> 

                                        </td>

                                    </tr> 

                                    <tr style="height:10px;">
                                        <td colspan="2">&nbsp</td>
                                    </tr>
                                </table>
                            </div>
                            <label id="comment_label" for="comment"><?php echo lang('common_comments'); ?>:</label>
    <?php
    echo form_textarea(array(
        'name' => 'comment',
        'id' => 'comment',
        'value' => $comment ? $comment :'',
        'rows' => '4',
        'style' => 'width: 192px;margin: -4px 12px 12px 14px;border: 1px inset #EEE9E9'
    ));
    ?>
                    
                            <div>
                                <label style="margin-top:-7px;">Ngày hoạch toán: </label>
                                <input type="text" name="date_debt" id="date_debt" value="<?= $date_debt ? date('d-m-Y', strtotime($date_debt)) : '' ?>" />
                            </div>
                            <br><br><br><br>
                            <div id="suspend_cancel"></div>
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
    $.post('<?php echo site_url("receivings/add_load_account"); ?>', {load_account: $('#load_account').val()});
    
    //Nov 3
    if ($('#payment_type').val() == 'CKNH') {
        $('.tr_bank').show();
    } else {
        $('.tr_bank').hide();
    }
    $('#payment_type').change(function () {
        if ($('#payment_type').val() == 'CKNH') {
            $('.tr_bank').show();
        } else {
            $('.tr_bank').hide();
        }
    });
    $('.bank_account').change(function () {
        $.post('<?php echo site_url("receivings/set_bank_account"); ?>', {bank_account: $('.bank_account').val()});
    });

    // say goodbye hAllOwwEen (^_^), hello nOvEmbEr - hi wIntEr 2015
//    $('#date_debt').datePicker().bind('dpClosed', function (e, selectedDates) {
//        var d = selectedDates[0];
//        if (d) {
//            d = new Date(d);
//            $('#start-date').dpSetEndDate(d.addDays(0).asString());
//        }
//    });

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

//    $('#date_debt1').datePicker().bind('dpClosed', function (e, selectedDates) {
//        var d = selectedDates[0];
//        if (d) {
//            d = new Date(d);
//            $('#start-date').dpSetStartDate(d.addDays(0).asString());
//        }
//    });

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

    $('#date_debt').change(function () {
        $.post('<?php echo site_url("receivings/add_date_debt"); ?>', {date_debt: $('#date_debt').val()});
    });

    $('#date_debt1').change(function () {
        $.post('<?php echo site_url("receivings/add_date_debt1"); ?>', {date_debt1: $('#date_debt1').val()});
    });

    $(".quantity").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $(document).ready(function () {
        $('#amount_tendered').keyup(function ()
        {
            var tongtien_2 = ($('#amount_tendered').val()).replace(",", "");
            $.post('<?php echo site_url("receivings/set_amount_tendered"); ?>', {amount_tendered: tongtien_2});

        });

        $(".amount_tendered").maskMoney();
        var my_ar = new Array("reg_item_total", "reg_item_discount", "reg_item_qty", "reg_item_price", "reg_item_stock", "reg_item_number", "reg_item_name", "reg_item_del");
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

//        $('#inventory').change(function ()
//        {
//            $('#store_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
//        });

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


        $('#other_cost').change(function ()
        {

            $('#form_input_other_cost').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});

        });

        $('a.thickbox, area.thickbox, input.thickbox').each(function (i)
        {
            $(this).unbind('click');
        });

        tb_init('a.thickbox, area.thickbox, input.thickbox');

        $('#add_item_form, #mode_form, #select_supplier').ajaxForm({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});

        $("#item").autocomplete({
            source: '<?php echo site_url("receivings/item_search"); ?>',
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
            $.post('<?php echo site_url("receivings/set_discount_money"); ?>', {discount_money: $('#discount_money').val()});
        });
        $('#comment').change(function ()
        {
            $.post('<?php echo site_url("receivings/set_comment"); ?>', {comment: $('#comment').val()});
        });
        $('#payment_type').change(function ()
        {
            $.post('<?php echo site_url("receivings/set_payment_type"); ?>', {payment_type: $('#payment_type').val()});
        });

        $('#mode').change(function ()
        {
            $('#mode_form').ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: receivingsSuccess});
        });

        $('#symbol_order').change(function ()
        {
            $.post('<?php echo site_url("receivings/set_symbol_order"); ?>', {symbol_order: $('#symbol_order').val()});
        });

        $('#number_order').change(function ()
        {
            $.post('<?php echo site_url("receivings/set_number_order"); ?>', {number_order: $('#number_order').val()});
        });

        $('#number_taxes').change(function ()
        {
            $.post('<?php echo site_url("receivings/set_number_taxes"); ?>', {number_taxes: $('#number_taxes').val()});
        });

        $('#other_cost').change(function ()
        {
            $.post('<?php echo site_url("receivings/set_other_cost"); ?>', {other_cost: $('#other_cost').val()});

        });


        $('#inventory').change(function () {
            $.post('<?php echo site_url("receivings/set_inventory"); ?>', {inventory: $('#inventory').val()});
        });
//         
        $("#supplier").autocomplete({
            source: '<?php echo site_url("receivings/supplier_search"); ?>',
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

        $("#finish_sale_button").click(function () {
            if ($('#payment_type').val() == '') {
                alert('Bạn chưa chọn hình thức thanh toán');
                return false;
            } else if ($('#payment_type').val() == 'CKNH' && $('.bank_account').val() == '') {
                alert('Bạn chưa chọn tài khoản ngân hàng');
                return false;
            }
            var amount_tendered = $("#amount_tendered").val();
            $("#register_container").load('<?php echo site_url("receivings/suspend"); ?>', {amount_tendered: amount_tendered});
            $('#add_payment_form').ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, success: salesSuccess});
        });

        $("#suspend_sale_button").click(function ()
        {
            var amount_tendered = $("#amount_tendered").val();
            if (confirm(<?php echo json_encode(lang("sales_confirm_suspend_sale")); ?>))
            {
                $("#register_container").load('<?php echo site_url("receivings/suspend"); ?>');
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
    $(".input_price").maskMoney();


</script>
