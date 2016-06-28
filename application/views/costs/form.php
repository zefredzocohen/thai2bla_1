<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js"
type="text/javascript"></script>
<div id="content_area_wrapper">
    <div id="content_area">
        <div id="aa"></div>
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
                </td>
                <td id="title" >
                    <?php echo lang('common_list_of') . ' ' . lang('module_' . $controller_name); ?>
                </td>
                <td id="title_search" style="display: none;">
                    <?php echo form_open("$controller_name/search", array('id' => 'search_form')); ?>
                    <input  type="text" name ='search' id='search'/>
                    <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner' />
                    </form>
                </td>
                <td style="text-align: right; padding-right: 10px;">
                    <a id="a_return" style="font-size:18px;text-decoration: underline; color: #FFFFFF" href="<?php echo site_url() ?>costs">Trở lại</a>
                </td>
            </tr>
        </table>       
        <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
        <ul id="error_message_box" style="font-size: 13px;"></ul>
        <?= form_open('costs/save/' . $cost_info->id_cost, array('id' => 'item_form'));?>
        <fieldset
            id="item_basic_info"><legend><?php echo "Thông tin chi phí"; ?></legend>
            <div style="margin-bottom: 5px;">
                <input type=hidden id=id_cost value="<?= $cost_info->id_cost ? $cost_info->id_cost : -1 ?>" >
                <label><input type="radio" name="radio" id="radio_emp" value="1"
                    <?= $this->Employee->exists($cost_info->employees_id) ? 'checked="checked"' : '' ?> >
                    Thu chi Nội bộ
                </label>&nbsp; 
                <label><input type="radio" name="radio" id="radio_cus" value="2" 
                    <?= $this->Customer->exists($cost_info->id_customer) ? 'checked="checked"' : '' ?> >
                    Thu chi Khách hàng
                </label>&nbsp;
                <label><input type="radio" name="radio" id="radio_sup" value="3" 
                    <?= $this->Supplier->exists($cost_info->supplier_id) ? 'checked="checked"' : '' ?> >
                    Thu chi Nhà cung cấp
                </label> 
                <label><input type="radio" name="radio" id="radio_dif" value="4" 
                        <?= ! $this->Customer->exists($cost_info->id_customer)
                        && ! $this->Employee->exists($cost_info->employees_id)    
                        && ! $this->Supplier->exists($cost_info->supplier_id)
                            ? 'checked="checked"' : '' ?> >
                    Thu chi khác
                </label>
            </div>
            <!-- test nhân viên-->
            <div id="cost_emp" style="display: none;">
                <div class="field_row clearfix">
                    <?php echo form_label('Tên nhân viên:', 'cost_employees_search', array('class' => 'required wide')); ?>
                    <div class='form_field'><?php
                        if ($this->Employee->exists($cost_info->employees_id)) {
                            echo form_input(array(
                                'name' => 'cost_employees_search',
                                'id' => 'cost_employees2',
                                'value' => $cost_info->employees_id)
                            );
                        } else {
                            echo form_input(array(
                                'name' => 'cost_employees_search',
                                'id' => 'cost_employees',
                                'value' => $cost_info->employees_id
                                )
                            );
                        }?>
                    </div>
                </div>
                <table id="cost_emp_selected">
                    <tr>
                        <th style="width: 110px"><?php echo lang('common_delete'); ?></th>
                        <th style="width: 400px"><?php echo 'Tên nhân viên'; ?></th>
                        <th><?php echo lang('common_list_of'); ?></th>
                    </tr>
                    <?php
                    if ( $this->Employee->exists($cost_info->employees_id)) {
                        $employee_info = $this->Employee->get_info($cost_info->employees_id);?>
                        <tr class=tr_bold >
                            <td class=td_center ><a href='#' onclick='return deleteCostCustomerRow(this);'>X</a></td>
                            <td><?php echo $employee_info->first_name . ' ' . $employee_info->last_name; ?></td>
                            <td>
                                <p>Di động: <?php echo $employee_info->phone_number; ?></p>
                                <p>Công ty: <?php echo $employee_info->company_name; ?></p>
                                <input type='hidden' size='3' name='cost_emp' id=cost_emp_val value='<?php echo $employee_info->person_id; ?>' />
                            </td>
                        </tr>
                    <?php 
                    } ?>
                </table>
            </div>
            <!--end  nhân viên-->  
            <!-- khach hang -->
            <div id="cost_cus" style="display: none;">
                <div id="cus">
                    <div class="field_row clearfix">
                        <?php echo form_label('Tên khách hàng:', 'cost_customer_search', array('class' => 'required wide')); ?>
                        <div class='form_field'><?php
                            if ($this->Customer->exists($cost_info->id_customer)) {
                                echo form_input(array(
                                    'name' => 'cost_customer_search',
                                    'id' => 'cost_customer2',
                                    placeholder => 'Nhập tên khách hàng ..'
                                ));
                            } else {
                                echo form_input(array(
                                    'name' => 'cost_customer_search',
                                    'id' => 'cost_customer',
                                    placeholder => 'Nhập tên khách hàng ..'
                                ));
                            }?></div>
                    </div>
                    <table id="cost_customer_selected">
                        <tr>
                            <th style="width: 110px"><?php echo lang('common_delete'); ?></th>
                            <th style="width: 400px"><?php echo 'Khách hàng'; ?></th>
                            <th><?php echo lang('common_list_of'); ?></th>
                        </tr>
                        <?php
                        if ( $this->Customer->exists($cost_info->id_customer)) {
                            $cus_info = $this->Customer->get_info($cost_info->id_customer);?>
                            <tr class=tr_bold >
                                <td class=td_center ><a href='#' onclick='return deleteCostCustomerRow(this);'>X</a></td>
                                <td><?php echo $cus_info->first_name . ' ' . $cus_info->last_name; ?></td>
                                <td>
                                    <p>Di động: <?php echo $cus_info->phone_number; ?></p>
                                    <p>Công ty: <?php echo $cus_info->company_name; ?></p>
                                    <input type='hidden' size='3' name='cost_customer' id=cost_cus_val
                                           value='<?php echo $cus_info->person_id; ?>' /></td>
                            </tr>
                        <?php 
                        } ?>
                    </table>
                    <?php
                    $data_customer = $this->Cost->get_cost_detail2($cost_info->id_cost);
                    $str .= "<table id='table_order' class=table_order_cus8 ><tr>";
                    $str .= "<th style= 'width: 10%'>Chọn</td>";
                    $str .= "<th style= 'width: 15%'>Mã đơn hàng</td>";
                    $str .= "<th style= 'width: 30%'>Giá trị đơn hàng</td>";
                    $str .= "<th style= 'width: 30%'>Thuế đơn hàng</td>";
                    $str .= "<th style= 'width: 15%'>Còn nợ </td>";
                    $str .= "</tr>";
                    if($data_customer){
                        foreach ($data_customer as $data1){                
                            $customer_money = $this->Cost->get_sale_item_by_id($data1['sale_id']);
                            $sub_total_order=0;
                            $thue=0;
                            foreach ($customer_money as $tam1){
                                $unit = $this->Item->get_info($tam['unit_item']);
                                
                                $unit_price = $unit->quantity_first == 0 ? $tam1['item_unit_price'] : $tam1['item_unit_price_rate'];
                                $NET_price = $unit_price * $tam1['quantity_purchased']
                                            - $unit_price * $tam1['quantity_purchased'] * $tam1['discount_percent']/100;
                                $sub_total_order += $NET_price;
                                $thue += $NET_price * $tam1['taxes_percent']/100;
                            }
                            $customer_payment = $this->Cost->get_payment_by_sale_id($data1['sale_id']);
                            $payment = 0;
                            foreach ($customer_payment as $tam2){
                                $payment += $tam2['pays_amount']+$tam2['discount_money'];
                            }
                            //Oct 14
                            $checked = $data1['sale_id'] == $cost_info->id_sale ? 'checked' : '';
                            $info_cost_detail_sale = $this->Cost->get_info_cost_detail_sale( $cost_info->id_cost, $data1['sale_id']);
                            $total_no += $info_cost_detail_sale->money_debt;
                            $str .= "<tr>";
                            $str .= "<td class=td_center >"
                                . "<input type = 'checkbox' name = 'check_dh[".$data1['sale_id']."][".$thue."]' $checked value = '".$info_cost_detail_sale->money_debt."'>"
                                . "</td>";
                            $str .= "<td class=td_center >".$data1['sale_id']."</td>";
                            $str .= "<td class=td_right >".number_format($sub_total_order)."</td>";
                            $str .= "<td class=td_right >".number_format($thue)."</td>";
                            $str .= "<td class=td_right >".number_format($info_cost_detail_sale->money_debt)."</td>";
                            $str .= "</tr>";
                        }            
                    }
                    $str .= "<tr style='font-weight: bold;'>"
                            . "<td class=td_right colspan ='4'>Tổng tiền đơn hàng nợ:&nbsp</td>"
                            . "<td class=td_right >".number_format($total_no)."</td>"
                            . "<input id='total_no' name ='total_no' type='hidden' value='".$total_no."'>"
                        . "</tr>";
                    $str .="</table>";
                    echo $str;?>
                </div>
            </div>
            <!-- khach hang --> 
            <!-- nha cung cap -->
            <div id="cost_sup" style="display: none;">
                <div class="field_row clearfix">
                    <?php echo form_label('Tên nhà cung cấp:', 'cost_supplier_search', array('class' => 'required wide')); ?>
                    <div class='form_field'><?php
                        if ($this->Supplier->exists($cost_info->supplier_id)) {
                            echo form_input(array(
                                'name' => 'cost_supplier_search',
                                'id' => 'cost_supplier2',
                                placeholder => 'Nhập tên nhà cung cấp ..'
                            ));
                        } else {
                            echo form_input(array(
                                'name' => 'cost_supplier_search',
                                'id' => 'cost_supplier',
                                placeholder => 'Nhập tên nhà cung cấp ..'
                            ));
                        }?>
                    </div>
                </div>
                <table id="cost_supplier_selected">
                    <tr>
                        <th style="width: 10%"><?php echo lang('common_delete'); ?></th>
                        <th><?php echo 'Nhà cung cấp'; ?></th>
                        <th style="width: 35%"><?php echo lang('common_list_of'); ?></th>
                    </tr>
                    <?php
                    if ( $this->Supplier->exists($cost_info->supplier_id)) {
                        $sup_info = $this->Supplier->get_info($cost_info->supplier_id);
                        ?>
                        <tr class=tr_bold >
                            <td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>
                            <td><?php echo $sup_info->company_name; ?></td>
                            <td>
                                <p>Di động: <?php echo $sup_info->phone_number; ?></p>
                                <input type='hidden' size='3' name='cost_supplier' id=cost_sup_val
                                       value='<?php echo $sup_info->person_id; ?>' /></td>
                        </tr>
                    <?php 
                    }?>
                </table>
                <?php
                $data_supplier = $this->Cost->get_cost_detail($cost_info->id_cost);
                $str .= "<table id='table_order' class=table_order_sup8 ><tr>";
                $str .= "<th style= 'width: 10%'>Chọn</td>";
                $str .= "<th style= 'width: 20%'>Mã đơn hàng</td>";
                $str .= "<th style= 'width: 35%'>Giá trị đơn hàng</td>";
                $str .= "<th style= 'width: 35%'>Còn nợ</td>";
                $str .= "</tr>";
                if($data_supplier){
                    foreach ($data_supplier as $data1){                
                        $receiving_money = $this->Cost->get_receiving_item_by_id($data1['receiving_id']);
                        $money=0;
                        foreach ($receiving_money as $tam1){
                            $money += $tam1['item_unit_price'] * $tam1['quantity_purchased']
                                    - $tam1['item_unit_price'] * $tam1['quantity_purchased'] * $tam1['discount_percent'] / 100;
                        }
                        $receving_pament = $this->Cost->get_payment_by_recv_id($data1['receiving_id']);
                        $payment = 0;
                        foreach ($receving_pament as $tam2){
                            $payment += $tam2['pays_amount']+$tam2['discount_money'];
                        }               
                        $total_no += $money-$payment;
                        
                        $checked = $data1['receiving_id'] == $cost_info->id_receiving ? 'checked' : '';
                        $info_cost_detail_recv = $this->Cost->get_info_cost_detail_recv( $cost_info->id_cost, $data1['receiving_id']);
                        
                        $str .= "<tr>";
                        $str .= "<td class=td_center ><input type=checkbox name='check_dh[".$data1['receiving_id']."]' $checked value = '".$info_cost_detail_recv->money_debt."'></td>";
                        $str .= "<td class=td_center >".$data1['receiving_id']."</td>";
                        $str .= "<td class=td_right >".number_format($money)."</td>";
                        $str .= "<td class=td_right >".number_format($info_cost_detail_recv->money_debt)."</td>";
                        $str .= "</tr>";
                    }            
                }
                $str .= "<tr style='font-weight: bold;'>"
                        . "<td class=td_right colspan ='3'>Tổng tiền đơn hàng nợ:&nbsp</td>"
                        . "<td class=td_right >".number_format($total_no)."</td>"
                        . "<input id='total_no' name ='total_no' type='hidden' value='".$total_no."'>"
                    . "</tr>";
                $str .="</table>";
                echo $str;?>
            </div>
            <br>
            <div id="cost_other">
                <div class="field_row clearfix">
                    <?php echo form_label('Nhập tên người:', 'human', array('class' => 'required')); ?>
                    <div class='form_field'>
                        <?= form_input(array(
                            'name' => 'human',
                            'id' => 'human',
                            'value' => $cost_info->human,
                        ));?>
                    </div>
                </div>
            </div>
            <table style="margin-top: 10px;">
                <tr>
                    <td><div class="field_row clearfix">
                            <?php echo form_label(lang('costs_method') . ':', 'costs_method', array('class' => 'required'));?>
                            <select name="costs_method" id="costs_method" >
                                <option value="1" <?= $cost_info->form_cost == 0 ? 'selected' : '' ?> >Thu</option>
                                <option value="2" <?= $cost_info->form_cost == 1 ? 'selected' : '' ?> >Chi</option>
                            </select>                            
                        </div>
                    </td>
                    <td>
                        <div class="field_row clearfix">
                            <?php echo form_label('Thanh toán:', 'payment_type', array('class' => 'required')); ?>
                            <div class='form_field'>
                                <select name="payment_type" id="payment_type">
                                    <option value="1" <?= $cost_info->payment_type == 1 ? 'selected' : '' ?> >
                                        Tiền mặt
                                    </option>
                                    <option value="2" <?= $cost_info->payment_type == 2 ? 'selected' : '' ?> >
                                        CKNH
                                    </option>
                                    <option value="3" <?= $cost_info->payment_type == 3 ? 'selected' : '' ?> >
                                        COD
                                    </option>
                                    <option value="4" <?= $cost_info->payment_type == 4 ? 'selected' : '' ?> >
                                        Trả góp
                                    </option>
                                    <option value="5" <?= $cost_info->payment_type == 5 ? 'selected' : '' ?> >
                                        Trả nhiều lần
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="field_row clearfix tr_bank">
                            <?= form_label('Tài khoản ngân hàng: ', 'bank_account', array('class' => 'required')); ?>
                            <div class="form_field">
                                <?= form_dropdown('bank_account', $bank_list, $bank_account->bank_account, 'class=bank_account'); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><div class="field_row clearfix">
                            <?php echo form_label('Số tiền:', 'price_cost', array('class' => 'required wide')); ?>
                            <div class='form_field'>
                                <?= form_input(array(
                                    'name' => 'price_cost',
                                    'id' => 'price_cost',
                                    'value' => $cost_info->money,
                                ));?> VND
                            </div>
                        </div>
                    </td>
                    <td><div class="field_row clearfix">
                            <?php echo form_label('Chiết khấu:', 'discount_money', array('class' => '')); ?>
                            <div class='form_field'><?php
                                echo form_input(array(
                                    'name' => 'discount_money',
                                    'id' => 'discount_money',
                                    'value' => '',)
                                );?> VND
                            </div>
                        </div>
                    </td>   
                </tr>
                <tr>
                    <td>
                        <div class="field_row clearfix">
                            <?= form_label(lang('costs_date_ct') . ':', 'cost_date_ct'); ?>
                            <div class='form_field'>
                                <?= form_input(array(
                                    'name' => 'cost_date_ct',
                                    'id' => 'cost_date_ct',
                                    'value' => $cost_info->cost_date_ct != '1950-01-01' 
                                        ? date(
                                            get_date_format(), 
                                            strtotime(
                                                $cost_info->cost_date_ct != '' 
                                                ? $cost_info->cost_date_ct 
                                                : date('d-m-Y')
                                            )
                                        ) : ''
                                    ));
                                ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="field_row clearfix">
                            <?php echo form_label(lang('costs_date') . ':', 'cost_date'); ?>
                            <div class='form_field'>
                                <?= form_input(array(
                                    'name' => 'cost_date',
                                    'id' => 'cost_date',
                                    'value' => $cost_info->date != '1950-01-01' 
                                        ? date(
                                            get_date_format(), 
                                            strtotime(
                                                $cost_info->date != '' 
                                                ? $cost_info->date 
                                                : date('d-m-Y')
                                            )
                                        ) 
                                        : ''
                                    ));
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="account" class="field_row clearfix">
                            <?php echo form_label('Tiêu chí hoạch định:', 'tk_no', array('class' => 'required wide')); ?>
                            <div class='form_field'>
                                <?php echo form_dropdown('account_plan', $account_plan, $cost_info->account_plan, 'id=account_plan'); ?>
                            </div>
                        </div>
                        <div id="tk_no" class="field_row clearfix">
                            <?php echo form_label('Tài khoản nợ:', 'tk_no', array('class' => 'wide')); ?>
                            <?php $data[tk_no] = $cost_info->tk_no ?>
                            <select name="tk_no" class="tk_no">
                                <?php $this->load->view('item_kits/tk_no_list', $data)?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div id="append_no" class="field_row clearfix" style="margin-top: -8px" >
                            <?php
                            echo form_label('Tài khoản nợ:', 'tk_no');?>
                            <?= form_input(array(
                                'name' => 'tk_no_append',
                                'id' => 'tk_no_append',
                                'value' => $cost_info->tk_no,
                                readonly => ''
                            ));?>
                        </div>
                        <div id="tk_co" class="field_row clearfix"  >
                            <?php echo form_label('Tài khoản có:', 'tk_co', array('class' => 'wide')); ?>
                            <?php $data[tk_co] = $cost_info->tk_co ?>
                            <select name="tk_co" class="tk_co">
                                <?php $this->load->view('item_kits/tk_co_list', $data)?>
                            </select>
                        </div>
                    </td>
                <tr>
                    <td>
                        <div class="field_row clearfix">
                            <?php echo form_label('Lý do thu chi: ', 'description', array('class' => 'wide')); ?>
                            <div class='form_field'>
                                <?= form_textarea(array(
                                    'name' => 'description',
                                    'id' => 'description',
                                    'value' => $cost_info->comment,
                                    'rows' => '5',
                                    'cols' => '17'
                                ));
                                ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div id="append_co" class="field_row clearfix" style="margin-top: -50px">
                            <?php
                            echo form_label('Tài khoản có:', 'tk_co');?>
                            <?= form_input(array(
                                'name' => 'tk_co_append',
                                'id' => 'tk_co_append',
                                'value' => $cost_info->tk_co,
                                readonly => ''
                            ));?>
                    </td>        
                </tr>
            </table>
            <!-- hung audi -->
            <br>
            <!-- nhà cung cấp --> 
            <?php
            echo form_submit(array(
                'name' => 'submit',
                'id' => 'submit',
                'value' => lang('common_submit'),
                'class' => 'submit_button float_right')
            );
            ?>
        </fieldset>
        <?php
        echo form_close();
        ?>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>
<script type='text/javascript'>
//Nov 3
if( $('#payment_type').val() == '2'){
    $('.tr_bank').show();
}else{
    $('.tr_bank').hide();
}
$('#payment_type').change(function(){
    if( $('#payment_type').val() == '2'){
        $('.tr_bank').show();
    }else{
        $('.tr_bank').hide();
    }
});    
    
$('#account_plan').change(function(){
    var account_plan = $('#account_plan').val();
    //tk_no
    $.post(
        '<?php echo site_url("costs/set_tk_no"); ?>', 
        {account_plan: account_plan},
        function (data) {
            $('#tk_no_append').val(data);
        }
    );
    //tk_co
    $.post(
        '<?php echo site_url("costs/set_tk_co"); ?>', 
        {account_plan: account_plan},
        function (data) {
            $('#tk_co_append').val(data);
        }
    );
});    
    
//khach hang
$("#cost_customer").autocomplete({
    source: '<?php echo site_url("sales/customer_search"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $("#cost_customer").val("");
        if ($("#cost_customer_selected" + ui.item.value).length == 1){
            $("#cost_customer_selected" + ui.item.value).val(parseFloat($("#cost_customer_selected" + ui.item.value).val()) + 1);
        }else{
            $("#cost_customer").addClass("disable_input_cost");
            $("#cost_customer_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostCustomerRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<td>"
                        +"<p>Di động: " + ui.item.cost_phone + "</p>"
                        +"<p>Công ty: " + ui.item.cost_company + "</p> "
                        +"<input  type='hidden' size='3' name='cost_customer' id=cost_cus_val value='" + ui.item.value + "'/>"
                    +"</td>"
                +"</tr>"
            );
            var data = "customer_id=" + ui.item.value;
            $.ajax({
                type: "post",
                url: "<?php echo site_url() . '/costs/cong_no_khach_hang'; ?>",
                data: data,
                success: function (data) {
                    $("#cost_cus").append(data);
                }
            });
        }
        return false;
    }
});
//hung audi
$("#cost_customer2").autocomplete({
    source: '<?php echo site_url("sales/customer_search"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $("#cost_customer2").val("");
        if ($("#cost_customer_selected" + ui.item.value).length == 1){
            $("#cost_customer_selected" + ui.item.value).val(parseFloat($("#cost_customer_selected" + ui.item.value).val()) + 1);
        }else{
            $("#cost_customer2").addClass("disable_input_cost");
            $("#cost_customer_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostCustomerRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<td>"
                        +"<p>Di động: " + ui.item.cost_phone + "</p>"
                        +"<p>Công ty: " + ui.item.cost_company + "</p> "
                        +"<input  type='hidden' size='3' name='cost_customer' id=cost_cus_val value='" + ui.item.value + "'/>"
                    +"</td>"
                +"</tr>"
            );
            var data = "customer_id=" + ui.item.value;
            $.ajax({
                type: "post",
                url: "<?php echo site_url() . '/costs/cong_no_khach_hang'; ?>",
                data: data,
                success: function (data) {
                    $("#cost_cus").append(data);
                }
            });
        }
        return false;
    }
});
$("#cost_customer2").addClass("disable_input_cost");
//end hung audi
function deleteCostCustomerRow(link){
    $("#cost_customer").removeClass("disable_input_cost");
    $("#cost_customer2").removeClass("disable_input_cost");
    $(link).parent().parent().remove();
    $(".table_order_cus").remove();
    $(".table_order_cus8").remove();
    return false;
}
//nhan vien
$("#cost_employees").autocomplete({
    source: '<?php echo site_url("employees/info_name_employee_suggest"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $("#cost_employees").val("");
        if ($("#cost_emp_selected" + ui.item.value).length == 1){
            $("#cost_emp_selected" + ui.item.value).val(parseFloat($("#cost_emp_selected" + ui.item.value).val()) + 1);
        }else{
            $("#cost_employees").addClass("disable_input_cost");
            $("#cost_emp_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostempRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<td>"
                        +"<p>Di động: " + ui.item.phone + "</p> "
                        +"<input type='hidden' size='3' name='cost_emp' id=cost_emp_val value='" + ui.item.value + "'/>"
                    +"</td>"
                +"</tr>"
            );
        }
        return false;
    }
});
$("#cost_employees2").autocomplete({
    source: '<?php echo site_url("employees/info_name_employee_suggest"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $("#cost_employees2").val("");
        if ($("#cost_emp_selected" + ui.item.value).length == 1){
            $("#cost_emp_selected" + ui.item.value).val(parseFloat($("#cost_emp_selected" + ui.item.value).val()) + 1);
        }else{
            $("#cost_employees2").addClass("disable_input_cost");
            $("#cost_emp_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostempRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<td>"
                        +"<p>Di động: " + ui.item.phone + "</p> "
                        +"<input  type='text' size='3' name='cost_emp' id=cost_emp_val value='" + ui.item.value + "'/>"
                    +"</td>"
                +"</tr>"
            );
        }
        return false;
    }
});
$("#cost_employees2").addClass("disable_input_cost");
//end nhân viên
function deleteCostempRow(link){
    $("#cost_employees").removeClass("disable_input_cost");
    $("#cost_employees2").removeClass("disable_input_cost");
    $(link).parent().parent().remove();
    return false;
}
//nha cung cap
$("#cost_supplier").autocomplete({
    source: '<?php echo site_url("sales/supplier_search_cost"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui) {
        $("#cost_supplier").val("");
        if ($("#cost_supplier_selected" + ui.item.value).length == 1){
            $("#cost_supplier_selected" + ui.item.value).val(parseFloat($("#cost_supplier_selected" + ui.item.value).val()) + 1);
        } else {
            $("#cost_supplier").addClass("disable_input_cost");
            $("#cost_supplier_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<td>"
                        +"<p>Di động: " + ui.item.cost_phone + "</p>"
                        +"<input  type='hidden' size='3' name='cost_supplier' id=cost_sup_val value='" + ui.item.value + "'/>"
                    +"</td>"
                +"</tr>"
            );
            var data = "supplier_id=" + ui.item.value;
            $.ajax({
                type: "post",
                url: "<?php echo site_url() . '/costs/cong_no_ncc'; ?>",
                data: data,
                success: function (data) {
                    $("#cost_sup").append(data);
                }
            });
        }
        return false;
    }
});
$("#cost_supplier2").autocomplete({
    source: '<?php echo site_url("sales/supplier_search_cost"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui) {
        $("#cost_supplier2").val("");
        if ($("#cost_supplier_selected" + ui.item.value).length == 1){
            $("#cost_supplier_selected" + ui.item.value).val(parseFloat($("#cost_supplier_selected" + ui.item.value).val()) + 1);
        } else {
            $("#cost_supplier2").addClass("disable_input_cost");
            $("#cost_supplier_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<td>"
                        +"<p>Di động: " + ui.item.cost_phone + "</p>"
                        +"<input  type='hidden' size='3' name='cost_supplier' id=cost_sup_val value='" + ui.item.value + "'/>"
                    +"</td>"
                +"</tr>"
            );
            var data = "supplier_id=" + ui.item.value;
            $.ajax({
                type: "post",
                url: "<?php echo site_url() . '/costs/cong_no_ncc'; ?>",
                data: data,
                success: function (data) {
                    $("#cost_sup").append(data);
                }
            });
        }
        return false;
    }
});
$("#cost_supplier2").addClass("disable_input_cost");
function deleteCostSupplierRow(link){
    $("#cost_supplier").removeClass("disable_input_cost");
    $("#cost_supplier2").removeClass("disable_input_cost");
    $(link).parent().parent().remove();
    $(".table_order_sup").remove();
    $(".table_order_sup8").remove();
    return false;
}
$("#price_cost").maskMoney();
$("#discount_money").maskMoney();

//checked old
if ($("#radio_emp").is(':checked')) {
    $("#cost_emp").css({'display': 'block'});
    $("#cost_cus").css({'display': 'none'});
    $("#cost_sup").css({'display': 'none'});
    $("#cost_other").css({'display': 'none'});
    $('#account').css({'display': 'block'});
    $('#append_no').css({'display': 'block'});
    $('#append_co').css({'display': 'block'});
    $("#tk_no").css({'display': 'none'});
    $("#tk_co").css({'display': 'none'});
    
} else if ($("#radio_cus").is(':checked')) {
    $("#cost_emp").css({'display': 'none'});
    $("#cost_cus").css({'display': 'block'});
    $("#cost_sup").css({'display': 'none'});
    $("#cost_other").css({'display': 'none'});
    $('#account').css({'display': 'none'});
    $('#append_no').css({'display': 'none'});
    $('#append_co').css({'display': 'none'});
    $("#tk_no").css({'display': 'block'});
    $("#tk_co").css({'display': 'block'});    
    $(".table_order_sup8").css({'display': 'none'});
    
    //change tk no - co
//    change_no_co_kh();
    $('#costs_method').change(function(){
        $('#payment_type').change(function(){
            change_no_co_kh();
        });
    });
    $('#payment_type').change(function(){
        $('#costs_method').change(function(){
            change_no_co_kh();
        });
    });
    $('#payment_type').change(function(){
        change_no_co_kh();
    });
    $('#costs_method').change(function(){
        change_no_co_kh();
    });

} else if ($("#radio_sup").is(':checked')) {
    $("#cost_emp").css({'display': 'none'});
    $("#cost_cus").css({'display': 'none'});
    $("#cost_sup").css({'display': 'block'});
    $("#cost_other").css({'display': 'none'});    
    $('#account').css({'display': 'none'});
    $('#append_no').css({'display': 'none'});
    $('#append_co').css({'display': 'none'});
    $("#tk_no").css({'display': 'block'});
    $("#tk_co").css({'display': 'block'});
    $(".table_order_cus8").css({'display': 'none'});
    //change tk no - co
//    change_no_co_ncc();
    $('#costs_method').change(function(){
        $('#payment_type').change(function(){
            change_no_co_ncc();
        });
    });
    $('#payment_type').change(function(){
        $('#costs_method').change(function(){
            change_no_co_ncc();
        });
    });
    $('#payment_type').change(function(){
        change_no_co_ncc();
    });
    $('#costs_method').change(function(){
        change_no_co_ncc();
    });
        
} else if ($("#radio_dif").is(":checked")) {
    $("#cost_emp").css({'display': 'none'});
    $("#cost_cus").css({'display': 'none'});
    $("#cost_sup").css({'display': 'none'});
    $("#cost_other").css({'display': 'block'});    
    $('#account').css({'display': 'block'});
    $('#append_no').css({'display': 'block'});
    $('#append_co').css({'display': 'block'});
    $("#tk_no").css({'display': 'none'});
    $("#tk_co").css({'display': 'none'});
}

//click new
$("#radio_emp").click(function () {
    if ($("#radio_emp").is(':checked')) {
        $("#cost_emp").css({'display': 'block'});
        $("#cost_cus").css({'display': 'none'});
        $("#cost_sup").css({'display': 'none'});
        $("#cost_other").css({'display': 'none'});
        $('#account').css({'display': 'block'});
        $("#tk_no").css({'display': 'none'});
        $("#tk_co").css({'display': 'none'});        
        $('#append_no').css({'display': 'block'});
        $('#append_co').css({'display': 'block'});
    }
});
$("#radio_cus").click(function () {
    if ($("#radio_cus").is(':checked')) {
        $("#cost_emp").css({'display': 'none'});
        $("#cost_cus").css({'display': 'block'});
        $("#cost_sup").css({'display': 'none'});
        $("#cost_other").css({'display': 'none'});
        $('#account').css({'display': 'none'});
        $("#tk_no").css({'display': 'block'});
        $("#tk_co").css({'display': 'block'});
        $('#append_no').css({'display': 'none'});
        $('#append_co').css({'display': 'none'});
        //display table_order
        if( $('#id_cost').val() != -1){
            $(".table_order_cus").css({'display': 'block'});        
            $(".table_order_sup").css({'display': 'none'});
        }else{
            $(".table_order_sup8").css({'display': 'none'});
            $(".table_order_cus8").css({'display': 'none'});            
        }
        //change tk no - co
        change_no_co_kh();
        $('#costs_method').change(function(){
            $('#payment_type').change(function(){
                change_no_co_kh();
            });
        });
        $('#payment_type').change(function(){
            $('#costs_method').change(function(){
                change_no_co_kh();
            });
        });
        $('#payment_type').change(function(){
            change_no_co_kh();
        });
        $('#costs_method').change(function(){
            change_no_co_kh();
        });
    }
});
$("#radio_sup").click(function () {
    if ($("#radio_sup").is(':checked')) {
        $("#cost_emp").css({'display': 'none'});
        $("#cost_cus").css({'display': 'none'});
        $("#cost_sup").css({'display': 'block'});
        $("#cost_other").css({'display': 'none'});
        $('#account').css({'display': 'none'});
        $("#tk_no").css({'display': 'block'});
        $("#tk_co").css({'display': 'block'});
        $('#append_no').css({'display': 'none'});
        $('#append_co').css({'display': 'none'});
        //display table_order
        if( $('#id_cost').val() != -1){
            $(".table_order_cus8").css({'display': 'none'});
        }else{
            $(".table_order_sup8").css({'display': 'none'});
            $(".table_order_cus8").css({'display': 'none'});            
        }
        //change tk no - co
        change_no_co_ncc();
        $('#costs_method').change(function(){
            $('#payment_type').change(function(){
                change_no_co_ncc();
            });
        });
        $('#payment_type').change(function(){
            $('#costs_method').change(function(){
                change_no_co_ncc();
            });
        });
        $('#payment_type').change(function(){
            change_no_co_ncc();
        });
        $('#costs_method').change(function(){
            change_no_co_ncc();
        });
    }
});
$("#radio_dif").click(function () {
    if ($("#radio_dif").is(':checked')) {
        $("#cost_emp").css({'display': 'none'});
        $("#cost_cus").css({'display': 'none'});
        $("#cost_sup").css({'display': 'none'});
        $("#cost_other").css({'display': 'block'});
        $('#account').css({'display': 'block'});
        $("#tk_no").css({'display': 'none'});
        $("#tk_co").css({'display': 'none'});        
        $('#append_no').css({'display': 'block'});
        $('#append_co').css({'display': 'block'});    
    }
});
function change_no_co_kh(){
    var no = 68;
    var co = 68;
    //no
    if($('#costs_method').val() == 1){
        if($('#payment_type').val() == 2)
            no = 112;
        else if($('#payment_type').val() == 1)
            no = 111;
        else
            no = '';
    }else{
        no = $('#payment_type').val() == 1 || $('#payment_type').val() == 2 ? 131 : '';
    }
    $('.tk_no').val(no);
    
    //co
    if($('#costs_method').val() == 2){
        if($('#payment_type').val() == 2)
            co = 112;
        else if($('#payment_type').val() == 1)
            co = 111;
        else
            co = '';
    }else{
        co = $('#payment_type').val() == 1 || $('#payment_type').val() == 2 ? 131 : '';
    }
    $('.tk_co').val(co);
}
function change_no_co_ncc(){
    var no = 68;
    var co = 68;
    //no
    if($('#costs_method').val() == 1){
        if($('#payment_type').val() == 2)
            no = 112;
        else if($('#payment_type').val() == 1)
            no = 111;
        else
            no = '';
    }else{
        no = $('#payment_type').val() == 1 || $('#payment_type').val() == 2 ? 331 : '';
    }
    $('.tk_no').val(no);
    
    //co
    if($('#costs_method').val() == 2){
        if($('#payment_type').val() == 2)
            co = 112;
        else if($('#payment_type').val() == 1)
            co = 111;
        else
            co = '';
    }else{
        co = $('#payment_type').val() == 1 || $('#payment_type').val() == 2 ? 331 : '';
    }
    $('.tk_co').val(co);
}
$('#cost_date').datePicker({startDate: '01-01-1950'});
$('#cost_date_ct').datePicker({startDate: '01-01-1950'});
setTimeout(function () {
    $(":input:visible:first", "#item_form").focus();
}, 100);
var submitting = false;
$('#item_form').validate({
    errorLabelContainer: "#error_message_box",
    wrapper: "li",
    rules:{
        price_cost: "required",
        payment_type: "required",
        costs_method: "required",
        human: {
            required: function () {
                return $("#radio_dif").is(":checked")
                    ? true
                    : false;
            }
        },        
        cost_employees_search: {
            required: function () {
                return $("#radio_emp").is(":checked")
                    ? ( $("#cost_emp_val").val() ? false : true )
                    : false;
            }
        },
        cost_customer_search: {
            required: function () {
                return $("#radio_cus").is(":checked")
                    ? ( $("#cost_cus_val").val() ? false : true )
                    : false;
            }
        },
        cost_supplier_search: {
            required: function () {
                return $("#radio_sup").is(":checked")
                    ? ( $("#cost_sup_val").val() ? false : true )
                    : false;
            }
        },
        account_plan: {
            required: function () {
                return $("#radio_emp").is(":checked") || $("#radio_dif").is(":checked")
                    ? true
                    : false;
            }
        },
//        tk_no: {
//            required: function () {
//                return $("#radio_cus").is(":checked") || $("#radio_sup").is(":checked")
//                    ? true
//                    : false;
//            }
//        },
//        tk_co: {
//            required: function () {
//                return $("#radio_cus").is(":checked") || $("#radio_sup").is(":checked")
//                    ? true
//                    : false;
//            }
//        },
    },
    messages:{
        price_cost: "Bạn cần nhập số tiền",
        human: "Bạn cần nhập tên người khác",
        payment_type: 'Bạn cần chọn hình thức thanh toán',
        costs_method: 'Bạn cần chọn hình thức thu chi',
        cost_employees_search: "Bạn cần chọn nhân viên",
        cost_customer_search: "Bạn cần chọn khách hàng",
        cost_supplier_search: "Bạn cần chọn nhà cung cấp",
        account_plan: "Bạn cần nhập Tiêu chí hoạch định",
//        tk_no: "Bạn cần nhập Tài khoản nợ",
//        tk_co: "Bạn cần nhập Tài khoản có",
    }
});
$('#submit').click(function(){
    if($('#price_cost').val() == 0){
        alert("Bạn cần nhập số tiền");return false;
    }
});
</script>
<style type="text/css">
.disable_input_cost {
    display: none;
}
#cost_sup, #cost_cus, #cost_emp{
    font-size: 13px;
}
#cost_supplier_selected tr, #cost_customer_selected tr, #cost_emp_selected tr{
    font-weight: bold
}
#table_order{
    line-height: 22px;
    margin-top: 16px
}
#table_order tr th{
    text-align: center;
    background-color: #999999;
}
#table_order tr td{
    padding-top: 3px 
}
#table_order tr, #table_order tr th, #table_order tr td{
    border: 1px solid #999999; 
}
.td_center{
    text-align: center
}
.td_right{
    text-align: right; padding-right: 5px
}
#tk_no_append, #tk_co_append{
    border: none
}
#costs_method{
    width: 138px;
}
</style>