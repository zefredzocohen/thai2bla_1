<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<style type="text/css">   
#item_kit_items, #item_kit_quantity{
    width:100%;	
    font-size: 12px;
    margin-left: 5px ;
    margin-top: 10px !important;
    font-weight: normal;
}
#item_kit_quantity{
    width:98%;	
}
#item_kit_items tr td, #item_kit_quantity tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_items tr th, #item_kit_quantity tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.quantity, .quantity_store{
    border: none;
    text-align: right;
    padding: 2px 8px;
    width: 80%;
}
.quantity_estimate{
    border: none;
    width: 44%;
    font-size: 16px;
}
.item_id, .item_number{
    border: none;
    text-align: left;
    }
#start_date, #end_date{
    width: 80px; 
    font-size: 14px;
}
.submit_button{
    margin-bottom:20px
}
#request_estimate_checkbox{
    margin-bottom: 10px
}
#quantity{
    border: none;
}    
.expand{
   font-size: 12px;
   color: #FF3C3C !important;
} 
.item_kit_size{
    width:100%;	
    font-size: 12px;
    margin-left: 5px ;
    font-weight: normal;
}
.item_kit_size tr td{
    padding: 3px 5px;
    font-size: 12px;
}
.request_estimate_size{
    padding: 3px 5px;
    text-align: left;
    font-size: 12px;
    border: 1px solid #B3B3B3;
}
.request_estimate_quantity{
    padding: 3px 5px;
    text-align: right;
    border: 1px solid #B3B3B3;
}
.del{
    font-size: 14px; 
    font-family: sans-serif; 
    text-decoration: underline blue
}
#item_kit_feature{
    margin-bottom: 10px;
}
#table_info_item_kit{
    width: 98%;
    margin-left: 5px;
    font-size: 12px;    
}
#table_info_item_kit tr td{
    padding: 4px 0px;
}
#table_info_item_kit .left_table{
    width: 15%;
    font-weight: bold;
}
#table_info_item_kit .right_table{
    width: 35%;
}
</style>
<?php if( $production_design->num_rows() == 0){
    echo 'Chưa có mẫu sản xuất nào được phê duyệt !';exit();
}?>
<div id="required_fields_message">Hãy tích chọn mẫu sản xuất & nhập size tương ứng</div>
<ul id="error_message_box"></ul>
<?php echo form_open_multipart('item_kits/save_request_estimate/' . $info_request_production->request_id, array('id' => 'item_kit_form_approve_estimate')); ?>
<input type="hidden" name="item_kit_id" value="<?= $item_kit_id; ?>">
<fieldset id="item_kit_info">
    <legend>Thông tin sản phẩm</legend>
    <table id="table_info_item_kit">
        <tr>
            <td class="left_table"><?php echo form_label('Mã sản phẩm:', 'name', array('class' => 'wide')); ?></td>
            <td class="right_table"><?=$item_kit_info->item_kit_number;?></td>
            <td class="left_table"><?php echo form_label(lang('item_kits_name') . ':', 'name', array('class' => 'wide')); ?></td>
            <td class="right_table"><?=$item_kit_info->name;?></td>
        </tr>       
        <tr>
            <td class="left_table"><?php echo form_label(lang('item_kits_unit') . ':', 'unit', array('class' => 'wide')); ?></td>
            <td class="right_table"> <?= $this->Unit->get_info($item_kit_info->unit)->name ?></td>
            <td class="left_table"><?php echo form_label(lang('items_category') . ':', 'category', array('class' => 'wide')); ?></td>
            <td class="right_table"><?= $this->Category->get_info($item_kit_info->category)->name ?></td>
        </tr>        
    </table>     
</fieldset>    
<fieldset id="item_kit_feature">
    <legend>Thông tin sản xuất</legend>
    <?php  
    $quantitys = array();
    foreach ($item_kit_feature->result() as $f){
        $info_formula_material = $this->Item_kit->get_info_formula_materials($f->feature_id);
        $request_feature = $this->Item_kit->get_info_item_kit_request_feature($info_request_production->request_id, $f->feature_id);
        ?>
        <div class="field_row clearfix" style="margin-bottom: 20px">
            <div class='form_field'  >
                <label style="margin-top: 10px; width: 299px">
                    <?php if($info_request_production->request_id){?>
                    <input type="checkbox" class='request_estimate_checkbox' <?= $request_feature->feature_id != '' ? 'checked' : ''?>
                           name="request_estimate_checkbox[<?= $f->feature_id ?>]" 
                           id="request_estimate_checkbox_<?= $f->feature_id ?>" >
                    <?php }else{ ?>
                    <input type="checkbox" class='request_estimate_checkbox'
                           name="request_estimate_checkbox[<?= $f->feature_id ?>]" 
                           id="request_estimate_checkbox_<?= $f->feature_id ?>" >
                    <?php } ?>
                        <?= $f->name_feature ?>
                </label>
                
                <label style="margin-top: 11px; ">
                    <a href="#" class="expand" id="expand_<?= $f->feature_id ?>" title="Thêm size mới">+ Thêm size</a>
                </label>    
            </div><br>
            <table class="item_kit_size" id='item_kit_size_<?= $f->feature_id ?>'>
                <tr>
                    <td>
                        <?php echo form_input(array(
                            'name' => "request_estimate_id[$f->feature_id]",
                            'id' => "request_estimate_id_$f->feature_id",
                            'class' => 'request_estimate_id',
                            'value' => $f->feature_id,
                            'type'=>'hidden'
                        ))?>
                    </td>
                </tr>
                <?php
                if($info_request_production->request_id){
                    $sizes = $this->Item_kit->get_item_kit_request_feature_by_feature_id($info_request_production->request_id, $f->feature_id);
                    $i = 1;
                    if($sizes->num_rows() == 0){
                        $size_id_i = $f->feature_id.$i;?>
                        <tr>
                            <td style="width: 10%">Size: 
                                <?php 
                                echo form_input(array(
                                    'name' => "request_estimate_size[$size_id_i]",
                                    'id' => "request_estimate_size_$size_id_i",
                                    'class' => 'request_estimate_size',
                                    'value' => '',
                                ));?>
                            </td>
                            <td style="width: 15%">Số lượng:
                                <?php
                                echo form_input(array(
                                    'name' => "request_estimate_quantity[$size_id_i]",
                                    'id' => "request_estimate_quantity_$size_id_i",
                                    'class' => 'request_estimate_quantity',
                                    'size' => '10',
                                    'value' => '',
                                ))?>
                            </td>
                            <td style="width: 25%;">
                                <a href='#' class='del' title="Xóa" onclick='return deleteItemKitRow(this);'>X</a>
                            </td>
                        </tr>  
                    <?php
                    }else{
                        $size_quantity = 0;
                        foreach ($sizes->result() as $size){
                            $size_id_i = $f->feature_id.$i;?>
                            <tr><td></td></tr>
                            <tr>
                                <td style="width: 10%">Size: 
                                    <?php 
                                    echo form_input(array(
                                        'name' => "request_estimate_size[$size_id_i]",
                                        'id' => "request_estimate_size_$size_id_i",
                                        'class' => 'request_estimate_size',
                                        'value' => $size->size,
                                    ));?>
                                </td>
                                <td style="width: 15%">Số lượng:
                                    <?php
                                    echo form_input(array(
                                        'name' => "request_estimate_quantity[$size_id_i]",
                                        'id' => "request_estimate_quantity_$size_id_i",
                                        'class' => 'request_estimate_quantity',
                                        'size' => '10',
                                        'value' => $size->quantity != '' ? format_quantity($size->quantity) : '',
                                    ))?>
                                </td>
                                <td style="width: 20%;">
                                    <a href='#' class='del' title="Xóa" onclick='return deleteItemKitRow(this);'>X</a>
                                </td>
                            </tr>
                            <?php 
                            $size_quantity += $size->quantity;
                            $i++;
                        }
                        echo form_input(array(
                            'id' => "size",
                            'value' => $i,
                            'type'=>'hidden'
                        ));
                    }
                }else{
                    $i = 1;
                    $size_id_i = $f->feature_id.$i;?>
                        <tr>
                            <td style="width: 10%">Size: 
                                <?php 
                                echo form_input(array(
                                    'name' => "request_estimate_size[$size_id_i]",
                                    'id' => "request_estimate_size_$size_id_i",
                                    'class' => 'request_estimate_size',
                                    'value' => '',
                                ));?>
                            </td>
                            <td style="width: 15%">Số lượng:
                                <?php
                                echo form_input(array(
                                    'name' => "request_estimate_quantity[$size_id_i]",
                                    'id' => "request_estimate_quantity_$size_id_i",
                                    'class' => 'request_estimate_quantity',
                                    'size' => '10',
                                    'value' => '',
                                ))?>
                            </td>
                            <td style="width: 20%;">
                                <a href='#' class='del' title="Xóa" onclick='return deleteItemKitRow(this);'>X</a>
                            </td>
                        </tr> 
                <?php $i++;
                    echo form_input(array(
                        'id' => "size",
                        'value' => $i,
                        'type'=>'hidden'
                    ));
                }?>
            </table>
            <div class="abc" style="margin-left: 567px">SL dự tính: 
                <?= form_input(array(
                    'name' => "quantity_estimate[$f->feature_id]",
                    'id' => "quantity_estimate_$f->feature_id",
                    'class' => 'quantity_estimate',
                    'readonly' => 'readonly',
                ));?>
            </div>
            <table id='item_kit_items'>
                <tr>
                    <th style='width: 20%;'>Mã NVL</th>
                    <th style='width: 30%;'>Tên NVL</th>
                    <th style='width: 20%;'><?= lang('item_kits_unit'); ?></th>
                    <th style='width: 10%;'><?= lang("item_kits_norms"); ?></th>
                    <th style='width: 10%;'>SL trong kho</th>
                    <th style='width: 10%;'>Dự tính</th>
                </tr>
                <?php 
                if($info_formula_material){
                    foreach ($info_formula_material as $fm) { ?>
                    <tr>
                        <?php
                        $info_store = $this->Create_invetory->check_exist_store_materials();
                        $item_info = $this->Item->get_info_in_store_material($fm['item_id'], $info_store['id']);
                        $unit_info = $this->Unit->get_info($fm['unit']);
                        
                        $request_feature_quantity = $request_feature->feature_id != '' ? $fm['quantity'] * $size_quantity : 0;
                        $quantitys[$fm['item_id']] += $request_feature_quantity;
                        $item_id = $fm['item_id'];
                        ?>
                        <td style='text-align: center'>
                        <?php echo form_hidden(array(
                                'name' => "item_id[$item_id]",
                                'id' => "item_id_$item_id",
                            ));?>
                        <?= $item_info->item_number ?>
                        </td>
                        <td style='text-align: left'><?= $item_info->name?>
                        </td>
                        <td style="text-align: left"><?= $unit_info->name;?>
                        </td>
                        <td style="text-align: right">
                            <?= form_input(array(
                                'name' => "quantity[$item_id]",
                                'id' => "quantity_$item_id",
                                'value' => format_quantity($fm['quantity']),
                                'class' => "quantity quantity$f->feature_id$item_id",
                                'readonly' => 'readonly',
                            ));?>
                        </td>
                        <td style='text-align: right'>
                            <?= form_input(array(
                                'name' => "quantity_store[$item_id]",
                                'id' => "quantity_store_$item_id",
                                'value' => format_quantity($item_info->quantity),
                                'class' => "quantity_store quantity_store$f->feature_id$item_id",
                                'readonly' => 'readonly',
                            ));?>
                        </td>
                        <td>
                            <?= form_radio("estimate_item[$f->feature_id]", "$item_id", '', "id=estimate_item_$item_id class='estimate_item estimate_item$f->feature_id estimate_item$f->feature_id$item_id'" )?>
                            <?= form_input(array(
                                id => $item_id,
                                'class' => "audi$f->feature_id",
                                type => hidden,
                            ));?>
                        </td>
                    </tr>
                    <?php
                    }
                }?>
            </table>
        </div>        
        <?php 
    }?>
    <div class="field_row clearfix" style="border-bottom:none">
        <?php echo form_label(lang("item_kits_command_design_template").": ", "comment", array("class" => "wide"));?>
        <div class='form_field'>
            <?php echo form_textarea(array(
                'name' => 'comment',
                'id' => 'comment',
                'value' => $info_request_production->request_id ? $info_request_production->comment : "",
                'style'=>'width: 200px; margin-top:1px'
            ));
            ?>
        </div>
    </div>
    <?php echo form_submit(array(
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right',
        'style' => 'margin-bottom:20px',
        'name' => 'save_estimate'
    ));?>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
$(".request_estimate_quantity").maskMoney();    
function deleteItemKitRow(link) {
    $(link).parent().parent().remove();
    return false;
}
$(document).ready(function(){    
    
    $("#item_kit_feature").find('.expand').each(function (index, element) {
        var feature_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
        
        //quantity_estimate
        var item_id_first = $('.audi'+feature_id).attr('id');
        $('.estimate_item'+feature_id+item_id_first).attr('checked', 'checked');
        var quantity2 = $('.quantity'+feature_id+item_id_first).val().replace(/,/g, "");
        var quantity_store2 = $('#quantity_store_'+item_id_first).val().replace(/,/g, "");
        var quantity_estimate2 = quantity_store2/quantity2;
        $('#quantity_estimate_'+feature_id).val(quantity_estimate2.toFixed(2));
        
        $('.estimate_item'+feature_id).click(function(){
            var item_id = $(this).val();
            var quantity = $('.quantity'+feature_id+item_id).val().replace(/,/g, "");
            var quantity_store = $('.quantity_store'+feature_id+item_id).val().replace(/,/g, "");
            var quantity_estimate = quantity_store/quantity;
            $('#quantity_estimate_'+feature_id).val(quantity_estimate.toFixed(2));
        });
        
        //expand
        var i = $('#size').val();
        $('#expand_' + feature_id).click(function(){
            var size_id = feature_id+i;
            $("#item_kit_size_" + feature_id).append(
                "<tr>"
                + "<td>"
                    + "<input type='hidden' class='request_estimate_id' \n\
                            name = 'request_estimate_id["+ feature_id+"]' \n\
                            id = 'request_estimate_id_"+ feature_id+"' value = "+feature_id+"></td>"
                +"</tr>"    
                +"<tr>"
                + "<td style='width: 10%'>Size: "
                    + "<input type='text' class='request_estimate_size' \n\
                            name = 'request_estimate_size["+ size_id+"]' \n\
                            id = 'request_estimate_size_"+ size_id+"' value=''></td>"
    
                + "<td style='width: 15%'>Số lượng: "
                    + "<input type='text' class='request_estimate_quantity' \n\
                            name = 'request_estimate_quantity["+ size_id+"]' \n\
                            id = 'request_estimate_quantity_"+ size_id+"' value='1' size='10'></td>"
    
                + "<td style='width: 20%;'>"
                    + "<a href='#' class='del' title='Xóa' onclick='return deleteItemKitRow(this);'>X</a></td>"
                +"</tr>"
            );
            $("#request_estimate_quantity_"+size_id).maskMoney();
            i++;
            return false;
        });
    });
        
    /**** July 16, 2015 Beautiful Day  Hưng Audi ****/
    $('.submit_button').click(function(){
        var arr_checkbox = [];
        var arr_size = [];
        var arr_quantity = [];
        var qty_total = 0;
        $("#item_kit_feature").find('.request_estimate_id').each(function (index, element) {
            var feature_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);  
            var size_id = feature_id+1;
            //1
            if($('#request_estimate_checkbox_' + feature_id).is(':checked')){
                $('#request_estimate_checkbox_' + feature_id).val('1');
                //size
                if ($("#request_estimate_size_" + size_id).val() == '') {
                    arr_size.push(size_id);
                }
                //quantity
                if ($("#request_estimate_quantity_" + size_id).val() == '' || $("#request_estimate_quantity_" + size_id).val() == 0) {
                    arr_quantity.push(size_id);
                }
            }else{
                $('#request_estimate_checkbox_' + feature_id).val('');
            }
            if ($("#request_estimate_checkbox_" + feature_id).val() == '1') {
                arr_checkbox.push(feature_id);
            }
            
            //2
            var i = 2;
            $("#item_kit_feature").find('.request_estimate_id').each(function (index, element) {
                var size_id = feature_id+i;
                //checkbox
                if($('#request_estimate_checkbox_' + feature_id).is(':checked')){
                    $('#request_estimate_checkbox_' + feature_id).val('1');
                    //size
                    if ($("#request_estimate_size_" + size_id).val() == '') {
                        arr_size.push(size_id);
                    }
                    //quantity
                    if ($("#request_estimate_quantity_" + size_id).val() == '' || $("#request_estimate_quantity_" + size_id).val() == 0) {
                        arr_quantity.push(size_id);
                    }
                }else{
                    $('#request_estimate_checkbox_' + feature_id).val('');
                }
                if ($("#request_estimate_checkbox_" + feature_id).val() == '1') {
                    arr_checkbox.push(feature_id);
                }
                i++;
            });
        });
        if (arr_checkbox.length < 1) {
            alert("Bạn chưa chọn mẫu nào để sản xuất !");
            return false;
        }
        if (arr_size.length > 0) {
            alert("Mẫu sản xuất đã chọn chưa có size !");
            return false;
        }
        if (arr_quantity.length > 0) {
            alert("Size chưa có số lượng !");
            return false;
        }
    });
    setTimeout(function () {
        $(":input:visible:first", "#item_kit_form_approve_estimate").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_form_approve_estimate').validate({  
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
        errorLabelContainer: "#error_message_box",
        wrapper: "li",        
    });
});
</script>


