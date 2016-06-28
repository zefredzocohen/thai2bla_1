<?php //$this->load->view("partial/header"); ?>      
<style type="text/css"> 
.item_kit_size{
    width:99%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
.item_kit_size tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.quantity_request, .quantity_production, .quantity_error{
    border: none;
}
.quantity_production, .quantity_success{
    color: green
} 
.quantity_request, .quantity_production, .quantity_kcs_input, .quantity_success_input, .quantity_error{
    text-align: right
}
.quantity_kcs_input, .quantity_success_input, .quantity_error_input, .cause_error_input{
    padding-right: 4px
}
.item_kit_size tr td, .item_kit_size tr th{
    border: 1px solid #CDCDCD; padding: 3px 5px 
}
.quantity_request, .quantity_production, .quantity_error{
    width: 90%;
}
.cause_error, .status, .item_product_table th, .td_center, .apply{
    text-align: center
}
.disable_input_cost {
    display: none;
}
.item_product{
    border: 1px solid #c0c0c0;
    border-radius: 2px;
    font-family: Arial,Helvetica,sans-serif;
    height: 27px !important;
    line-height: 25px;
    padding: 0 5px;
    width: 190px;
}
.div_div{
    margin-left: 10px
}
.item_product_table{
    margin-top: 10px;
    width: 44%
}
.tr_label{
    padding-left: 10px
}

</style>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<?php echo form_open_multipart("item_kits/save_kcs/$id/$request_id/$id_processes" 
    , array('id' => 'post_item_kit_form_submit')
    ); ?>
<fieldset id="form_kcs">
    <legend>Thông tin KCS</legend>
    <?php
    $processes = $this->Item_kit->get_info_processes($id_processes); 
    $pro_id_min = $this->Item_kit->get_pro_id_min_in_item_kit_processes($request_id)->pro_id;//pro_id cong doan dau tien
    $info_processes_min = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_min);

    $pro_id_max = $this->Item_kit->get_pro_id_max_in_item_kit_processes($request_id)->pro_id;//pro_id cong doan cuoi cung
    $info_processes_max = $this->Item_kit->get_info_item_kit_processes($request_id, $pro_id_max);
    
    foreach ($request_feature as $f){
        $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
        $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id,$f->feature_id);

        foreach ($info_sizes as $is) {
            $info_kcs = $this->Item_kit->get_info_kcs($request_id, $is->id, $id_processes);
            $kcs_id = $info_kcs->kcs_id;
            
            if(!$info_kcs){   
                echo 'Chưa có lệnh sản xuất cho công đoạn này !';die();
            }
            $kcs_id_prev = $this->Item_kit->get_info_kcs_prev($kcs_id)->kcs_id;
            $info_kcs_prev = $this->Item_kit->get_info_kcs_by_kcs_id($kcs_id_prev);
            $info_kcs_history_audi8 = $this->Item_kit->get_info_kcs_history_audi($request_id, $info_kcs_prev->id_processes, $kcs_id_prev);
            $quantity_request_check = $info_processes_min->id_processes == $id_processes 
                                        ? $is->quantity 
                                        : $info_kcs_history_audi8->quantity_success2;
            if( $quantity_request_check == 0){
                echo '&nbsp Có size chưa có số lượng yêu cầu, vui lòng kiểm tra lại công đoạn trước !';die();
            }
        }
    }
    if($info_processes_max->id_processes == $id_processes){
        $product_store = $this->Create_invetory->check_exist_product_store();
        if(!$product_store){
            echo 'Chưa tồn tại kho thành phẩm để nhập kho ! Bạn vui lòng tạo kho thành phẩm';die();
       }
    } 
    ?>
    <table class=item_kit_size>
        <tr style='text-align: center'>
            <th style="width: 15%">Tên mẫu</th> 
            <th style="width: 8%">Size</th> 
            <th style="width: 10%">SL yêu cầu</th>
            <th style="width: 10%">SL sản xuất</th>
            <th style="width: 10%">SL KCS</th>
            <th style="width: 10%">SL KCS đạt</th>
            <th style="width: 10%">SL KCS lỗi</th>
            <th style="width: 15%">Lí do lỗi</th>
            <?= $info_processes_min->id_processes == $id_processes 
                ? '<th>Hoàn thành</th>'
                : '' ?>
            <?= $info_processes_max->id_processes == $id_processes 
                ? '<th>Áp dụng số lượng</th>'
                : '' ?>
        </tr>
        <?php 
        $item_production_info = $this->Item_kit->get_info_item_production($id);
        $item_kit_info = $this->Item_kit->get_info($item_production_info->item_kit_id);
        foreach ($request_feature as $f){
            $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
            $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id,$f->feature_id);
            $count = $this->Item_kit->get_item_kit_request_feature($request_id, $f->feature_id)->num_rows();
            $item_kit_feature_info = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
            
            ?>
            <tr>
                <td rowspan="<?= $count ?>" ><?= $info_feature->name_feature ?></td>
                <?php
                foreach ($info_sizes as $is) {
                    $info_kcs = $this->Item_kit->get_info_kcs_new($request_id, $is->id, $id_processes);
                    $kcs_id = $info_kcs->kcs_id;
                    $kcs_id_prev = $this->Item_kit->get_info_kcs_prev($kcs_id)->kcs_id;
                    $info_kcs_prev = $this->Item_kit->get_info_kcs_by_kcs_id($kcs_id_prev);
                    $info_kcs_history_audi8 = $this->Item_kit->get_info_kcs_history_audi($request_id, $info_kcs_prev->id_processes, $kcs_id_prev);
                    $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);
                    $quantity_production = $this->Item_kit->get_info_kcs_history_bmw($request_id, $id_processes, $kcs_id, date('Y-m-d H:i:s'));
                    $check_exist_kcs_history = $this->Item_kit->check_exist_kcs_history($request_id, $id_processes);
                    ?>
                    <td> 
                        <?=
                        form_input(array(
                            "name" => "size_id[$kcs_id]",
                            "id" => "size_id_$kcs_id",
                            'class' => "size_id",
                            "value" => $kcs_id,
                            "type" => "hidden"
                        )).
                        $is->size ?>
                        <?= $info_processes_max->id_processes == $id_processes
                        ?   form_input(array(
                                "name" => "item_number[$kcs_id]",
                                "id" => "item_number$kcs_id",
                                'class' => "item_number",
                                "value" => $item_kit_info->item_kit_number.$is->size,
                                "type" => "hidden"
                            )). 
                            form_input(array(
                                "name" => "name[$kcs_id]",
                                "id" => "name$kcs_id",
                                'class' => "name",
                                "value" => $item_kit_info->name.' size '.$is->size,
                                "type" => "hidden"
                            ))
                        : ''
                        ?>
                    </td>
                    <td>
                        <?=
                        form_input(array(
                            "name" => "quantity_request[$kcs_id]",
                            "id" => $info_processes_min->id_processes == $id_processes
                                    && $check_exist_kcs_history->num_rows() == 0
                                        ? "quantity_request_min$kcs_id" 
                                        : "quantity_request_other$kcs_id",//lan kcs cong doan dau tien
                            
                            'class' => "quantity_request",
                            "value" => $info_processes_min->id_processes == $id_processes 
                                ? $is->quantity 
                                : $info_kcs_history_audi8->quantity_success2,
                            "readonly" => ''
                        )) ?>
                    </td>
                    <td> 
                        <?=
                        form_input(array(
                            "name" => "quantity_production[$kcs_id]",
                            "id" => "quantity_production$kcs_id",
                            'class' => "quantity_production",
                            "value" => $info_kcs_history_audi->quantity_success2 ? $info_kcs_history_audi->quantity_success2 : 0,
                            "readonly" => ''
                        )) ?>
                    </td>
                    <td class="quantity_kcs">
                        <?=
                        form_input(array(
                            "name" => "quantity_kcs[$kcs_id]",
                            "id" => "quantity_kcs$kcs_id",
                            'class' => "quantity_kcs_input",
                            "size" => 9
                        )) ?>
                    </td>
                    <td class="quantity_success">
                        <?=
                        form_input(array(
                            "name" => "quantity_success[$kcs_id]",
                            "id" => "quantity_success$kcs_id",
                            'class' => "quantity_success_input",
                            "size" => 9
                        )) ?>
                    </td>
                    <td>
                        <?=
                        form_input(array(
                            "name" => "quantity_error[$kcs_id]",
                            "id" => "quantity_error$kcs_id",
                            'class' => "quantity_error",
                            "readonly" => '',
                            "size" => 9
                        )) ?>
                    </td>
                    <td class="cause_error">
                        <?=
                        form_textarea(array(
                            "name" => "cause_error[$kcs_id]",
                            "id" => "cause_error$kcs_id",
                            'class' => "cause_error_input",
                            "rows" => 3,
                            "cols" => 10
                        )) ?>
                    </td>
                    <?php 
                    if($info_processes_min->id_processes == $id_processes){?>
                        <td class="status">
                            <input type="checkbox" name="status[<?= $kcs_id?>]" id="status<?= $kcs_id?>" value="1" 
                                <?= ($info_kcs->status == 0) ? '' : 'checked=checked' ?>>
                        </td>
                    <?php
                    }
                    if($info_processes_max->id_processes == $id_processes){?>
                        <td class="apply">
                            <input type="radio" name="apply" class="apply apply<?= $kcs_id?>" onclick="return apply_quantity(<?= $kcs_id?>)" >
                        </td>
                    <?php
                    }?>
            </tr>
        <?php }
        }?>
    </table><br> 
    
    <?php //Enchanteur charming ~~~~
    if($info_processes_max->id_processes == $id_processes){?>
        <div class="div_div">
            <?php
            echo form_label('Thành phẩm thêm cùng số lượng: ');
            echo form_input(array(
                name => item_product,
                'class' => item_product,
                placeholder => 'Nhập tên thành phẩm ..'
            ));?>
            <table class="item_product_table">
                <tr>
                    <th style="width: 20%">Xoá</th>
                    <th style="">Thành phẩm</th>
                </tr>
            </table>
        </div>
        <input type=hidden class=Fast_Furious_8 >
        <input type=hidden class=quantity_apply_tam >
        <?php
    }?>
    
    <?= form_submit(array(
        'value' => $info_processes_max->id_processes == $id_processes ? 'Nhập kho' : 'Bàn giao',
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_item',
    ));
    ?>
</fieldset><br>
<?php echo form_close(); ?>
<script type='text/javascript'>
    
//Enchanteur charming ~~~~
function apply_quantity(kcs_id){
    $('.apply').val(8);
    
    var quantity_success = $('#quantity_success'+kcs_id).val();
    $('.quantity_apply_tam').val(quantity_success);
    var quantity_apply = $('.quantity_apply_tam').val();
    $('.quantity_apply').val(quantity_apply);
} 
$(".item_product").autocomplete({
    source: '<?php echo site_url("item_kits/item_product_search/$item_production_info->item_kit_id"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui){
        $(".item_product").addClass("disable_input_cost");
        $(".item_product_table").append(
            "<tr>"
                +"<td class=td_center ><a href='#' onclick='return deleteCostCustomerRow(this);'>X</a></td>"
                +"<td class=tr_label ><input type=hidden name=item_product_old_id value=" + ui.item.value + " >" + ui.item.label + "<input type=hidden name=quantity_apply class=quantity_apply  ></td>"
            +"</tr>"
        );
        var quantity_apply = $('.quantity_apply_tam').val();
        $('.quantity_apply').val(quantity_apply);
        
        $('.Fast_Furious_8').val(8);
        return false;
    }
}); 
function deleteCostCustomerRow(link){
    $('.Fast_Furious_8').val('');
    $(".item_product").removeClass("disable_input_cost");
    $(link).parent().parent().remove();
    return false;
}
$('.submit_button').click(function () {
    if( $('.Fast_Furious_8').val() != ''){
        if( $('.apply').val() == ''){
            alert('Bạn chưa chọn size để áp dụng số lượng !');
            return false;
        }
    }
    var arr_quantity_better_request = [];
    var arr_quantity_better_kcs = [];
    
    $('.item_kit_size').find('.size_id').each(function (index, element) {
        var kcs_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
        
        var quantity_request_min = $('#quantity_request_min'+kcs_id).val();
        var quantity_request_other = $('#quantity_request_other'+kcs_id).val();
        var quantity_request = quantity_request_min ? quantity_request_min : quantity_request_other;       

        var quantity_production = $('#quantity_production'+kcs_id).val();        
        var quantity_kcs = $('#quantity_kcs'+kcs_id).val();
        var quantity_success = $('#quantity_success'+kcs_id).val();
        var hieu = +quantity_kcs + +quantity_production - quantity_request;
        var hieu2 = quantity_kcs - quantity_success;
        
        if(quantity_request_other){
            if(hieu > 0){
                arr_quantity_better_request.push(kcs_id);
            }
        }
        if(hieu2 < 0){
            arr_quantity_better_kcs.push(kcs_id);
        }
    });
    if (arr_quantity_better_request.length > 0) {
        alert("Một số size có tổng SL KCS & SL sản xuất lớn hơn SL yêu cầu !");
        return false;
    }
    if (arr_quantity_better_kcs.length > 0) {
        alert("Một số size có SL KCS đạt lớn hơn SL KCS !");
        return false;
    }    
});    
$('.item_kit_size').find('.size_id').each(function (index, element) {
    var kcs_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
    
    var quantity_request_min = $('#quantity_request_min'+kcs_id).val();
    var quantity_request_other = $('#quantity_request_other'+kcs_id).val();
    var quantity_request = quantity_request_min ? quantity_request_min : quantity_request_other;
    
    var quantity_production = $('#quantity_production'+kcs_id).val(); 
    var qty_kcs = quantity_request - quantity_production;

    
    $('#quantity_kcs'+kcs_id).val(qty_kcs);
    $('#quantity_success'+kcs_id).val(qty_kcs);
    $('#quantity_error'+kcs_id).val(0);
    
    $('#quantity_kcs'+kcs_id).blur(function (){//quantity_request_min
        var quantity_request_min = $('#quantity_request_min'+kcs_id).val();
        var quantity_request_other = $('#quantity_request_other'+kcs_id).val();
        var quantity_request = quantity_request_min ? quantity_request_min : quantity_request_other;
        
        var quantity_production = $('#quantity_production'+kcs_id).val(); 
        var quantity_kcs = $('#quantity_kcs'+kcs_id).val();
        var quantity_success = $('#quantity_success'+kcs_id).val();
        var hieu = +quantity_kcs + +quantity_production - quantity_request;
        if(quantity_request_other){
            if(hieu > 0){
                alert('Tổng SL KCS & SL sản xuất không được lớn hơn SL yêu cầu !');return false;
            }
        }
        if(!quantity_kcs){
            $('#quantity_kcs'+kcs_id).val(0);
        }
        var hieu2 = quantity_kcs - quantity_success;
        $('#quantity_error'+kcs_id).val(hieu2);
    });

    $('#quantity_success'+kcs_id).blur(function (){
        var quantity_kcs = $('#quantity_kcs'+kcs_id).val();
        var quantity_success = $('#quantity_success'+kcs_id).val();
        var hieu = quantity_kcs - quantity_success;
        if(hieu < 0){
            alert('SL KCS đạt không được lớn hơn SL KCS !');return false;
        }
        if(!quantity_success){
            $('#quantity_success'+kcs_id).val(0);
        }
        $('#quantity_error'+kcs_id).val(hieu);
    });
});  
$(document).ready(function () { 
    setTimeout(function () {
        $(":input:visible:first", "#post_item_kit_form_submit").focus();
    }, 100);
    var submitting = false;
    $('#post_item_kit_form_submit').validate({
        errorLabelContainer: "#error_message_box",
        wrapper: "li"

    });
});
</script>