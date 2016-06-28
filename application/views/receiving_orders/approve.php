<?= form_open("receivings/save_approve/$receiving_id", array('id' => 'approve_form'));?>
<fieldset id="info_order">
  <?php $info_emp = $this->Employee->get_info($info_receiving->employee_id);?>
    <legend>Thông tin hóa đơn nhập hàng</legend>
    <p>Mã hóa đơn: <?php echo $receiving_id;?></p>
    <p>Người tạo hóa đơn: <?= $info_emp->first_name." ".$info_emp->last_name;?></p>
    <p>Ngày tháng: <?= date("d-m-Y H:i:s",  strtotime($this->Receiving->get_info($receiving_id)->row()->receiving_time)); ?></p>
    <p>Ghi chú: <?php echo $info_receiving->comment?></p>
    
    <p>Kho nhận : <font color='red'><?= $info_receiving->inventory_id == 0 ? "Kho tổng" :$this->Create_invetory->get_info($info_receiving->inventory_id)->name_inventory ;?></font></p>
</fieldset>
<fieldset>
    <legend>Danh sách mặt hàng đã nhập</legend>
    <table id="table_export_item">
        <tr>
            <th>STT</th>
            <th>Mã MH</th>
            <th>Tên MH</th>
            <th>ĐVT</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
        <?php
        $info_receiving_item = $this->Receiving_order->get_receiving_item();
        foreach ($info_receiving_item as $val){
               if($val['receiving_id'] == $receiving_id){
                        $net_price1 = $val['item_unit_price'] * $val['quantity_purchased'] - $val['item_unit_price'] * $val['quantity_purchased'] * $val['discount_percent']/100;
                        $totak += $net_price1;
               }
         }
    
        
        $stt = 1;
        $total_quan = 0;
        $total_money = 0;
        $total_dis = 0;
        $total_chiphi = 0;
        $total_taxes = 0;
           if($info_receiving_item != null):
               foreach ($info_receiving_item as $val):
               if($val['receiving_id'] == $receiving_id):
               $item_name = $this->Item->get_info($val['item_id'])->name;
               $unit = $this->Item->get_info($val['item_id'])->unit;
               $unit_name = $this->Unit->get_info($unit)->name;
               $total_quan += $val['quantity_purchased'];
        ?>
        <tr>
            <td style="width: 5%; text-align: center"><?php echo $stt++;?></td>
            <td style="width: 10%; text-align: center"><?php echo $val['item_id']?></td>
            <td style="width: 37%"><?php echo $item_name;?></td>
            <td style="width: 8%; text-align: left"><?php echo $unit_name;?></td>
            <td style=" text-align: right"><?php echo number_format($val['item_unit_price'])?></td>
            <td style="width: 10%; text-align: right"><?php echo number_format($val['quantity_purchased'])?></td>

            <?php
              //giá.. = so luong * ( giá - (giá * ck % / 100 ) )
               $money = $val['quantity_purchased'] *($val['item_unit_price']-($val['item_unit_price']*$val['discount_percent']/100));
               
            ?>
            <td style="width: 10%; text-align: right"><?php echo number_format($money);?></td>
            <?php
              $total_money += $money;
              $total_dis+=$val['discount_percent'];
              
              
              
              //thuế
            $net_price = $val['item_unit_price'] * $val['quantity_purchased'] - $val['item_unit_price'] * $val['quantity_purchased'] * $val['discount_percent']/100;
            
            $cp = ($net_price / $totak) * $this->Receiving->get_info($receiving_id)->row()->other_cost;
            
            $tax = ($net_price + $cp) * $val['taxes'] / 100;
            
            $total_taxes+= $tax;
            ?>
        </tr>   
        <?php endif;?>
        <?php endforeach;?>
        <?php endif;?>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold">Tổng</td>
            <td style="width: 10%; text-align: right"><?php echo number_format($total_quan);?></td>
            <td style="width: 10%; text-align: right"><?php echo number_format($total_money);?></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">Tổng tiền hàng: <?=  number_format($total_money);?></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">Tổng thuế: <?=  number_format($total_taxes);?></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">Tổng chi phí: <?= number_format($this->Receiving->get_info($receiving_id)->row()->other_cost);?></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">Tổng cộng tất cả: <?= number_format($this->Receiving->get_info($receiving_id)->row()->other_cost + $total_money + $total_taxes);?></td>
        </tr>
    </table>   
    <?php echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => "float: right; margin-right: 20px;",
    ));?>
</fieldset>
</form>
<script>
$(document).ready(function(){
    setTimeout(function () {
        $(":input:visible:first", "#approve_form").focus();
    }, 100);
    var submitting = false;
    $('#approve_form').validate({
        submitHandler: function (form){
            if (submitting)
                return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success: function (response){
                    submitting = false;
                    tb_remove();
                    post_receiving_form_submit(response);
                },
                dataType: 'json'
            });
        }
    });
});
</script>
<style>  
    #info_order p{
        padding-left: 10px;
        font-size: 14px;
    }
    #table_export_item{
        border-collapse: collapse;
        width: 100%;
        margin: 0px auto;
    }
    #table_export_item tr th{
        border: 1px solid #999999;
        padding: 3px 0px;
        background: #158ca0 ;
        color: #FFFFFF;
        text-align: center;
    }
    #table_export_item tr td{
        border: 1px solid #999999;
        padding: 3px 5px;
    }
</style>