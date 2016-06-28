<style> 
    #pack_items{
        width: 98%;
        margin: 0px auto;
        border-collapse: collapse;
    }
    #pack_items tr th{
        text-align: center;
        padding: 3px;
        border: 1px solid #CDCDCD;
        color: #FFFFFF;
        background: #428BCA;
    }
    #pack_items tr td{
        padding: 3px 10px;
        border: 1px solid #CDCDCD;
    }
    #del_td {
        text-align: center;
    }
    #date_finish, #end_date, #date_finish2, #end_date2{
        padding-left: 4px;
        padding-top: 3px;
        padding-right: 3px;
    }
    #date_finish, #date_finish2{
        background-color: #ffffff; 
        width: 82px; 
        font-size: 14px; 
        margin-top: 0px;
    }
    #end_date, #end_date2{
        background-color: #ffffff; 
        width: 82px; 
        font-size: 14px; 
        margin-top: 0px;
        margin-left: 20px;
        float: left;
    }

</style>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php
if ($item_kit_info->item_kit_id == "") {
    echo form_open_multipart('item_kits/save/' . $item_kit_info->item_kit_id, array('id' => 'item_kit_form'));
} else {
    echo form_open_multipart('item_kits/update_item_kit/' . $item_kit_info->item_kit_id, array('id' => 'item_kit_form'));
}
?>
<fieldset id="item_kit_info">
    <legend><?php echo lang("item_kits_info"); ?></legend>
    <div style="width: 230px; float: right;">
        <?php echo form_label(lang('item_kits_add_images') . ':', 'item_kit_image', array('class' => 'wide', 'style' => 'font-weight: bold; font-size: 0.95em!important;')); ?>
        <?php if ($item_kit_info->images == null) { ?>
            <div class="" style="border: none">
                <div class='form_field' style="width: 60px;float: right;margin-right: 110px;">
                    <img src="<?php echo base_url() . 'images/no-images-product.jpg' ?>" style="width:100px; height:100px" />                          </div>
            </div>
            <?php } else {
            ?>
            <div class="field_row clearfix" style="border-bottom:none">
                <div class='form_field' style="width: 40px;float: right;margin-right: 110px;">
                    <img src="<?php echo base_url() . 'item_kit/' . $item_kit_info->images ?>" style="width:100px; height:100px" />
                    <?php
                    echo form_input(array(
                        'name' => 'item_kit_image',
                        'id' => 'item_kit_image',
                        'type' => 'file',
                        'style' => 'float:right; margin-right:-90px; width: 200px'
                    ));
                    ?>
                </div>
            </div>
            <?php }
        ?>           
    </div>
    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label('Mã sản phẩm:', 'name', array('class' => 'wide required')); ?>
        <div class='form_field'>
            <?php
            if ($item_kit_info->item_kit_id != "") {
                echo $item_kit_info->item_kit_number;
                echo "<input type='hidden' name='item_number' value='" . $item_kit_info->item_kit_number . "'>";
            } else {
                echo form_input(array(
                    'name' => 'item_kit_number',
                    'id' => 'item_kit_number',
                    'value' => $item_kit_info->item_kit_number)
                );
            }
            ?>
        </div>
    </div>        
    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('item_kits_name') . ':', 'name', array('class' => 'wide required')); ?>
        <div class='form_field'>
            <?php
            if ($item_kit_info->item_kit_id != "") {
                echo $item_kit_info->name;
            } else {
                echo form_input(array(
                    'name' => 'name',
                    'id' => 'name',
                    'value' => $item_kit_info->name)
                );
            }
            ?>
        </div>
    </div>
    <div class="field_row clearfix" style="width: 400px;  float: left;">
                <?php echo form_label(lang('item_kits_unit') . ':', 'unit', array('class' => 'wide')); ?>
        <div class='form_field'>
            <select style="width: 202px" name="unit">
                    <?php
                    foreach ($unit as $value) {
                        if ($item_kit_info->unit == $value['id_unit']) {
                            ?>
                        <option value="<?php echo $value['id_unit']; ?>" selected="selected" style="padding-left: 5px;">
                            <?= $value['name'] ?>
                        </option>
                        <?php } else {
                        ?>
                        <option value="<?php echo $value['id_unit']; ?>" style="padding-left: 5px;">
                        <?= $value['name'] ?>
                        </option>
        <?php
    }
}
?>
            </select>
        </div>
    </div>   
    <!-- phan category item -->    
                <?php if ($item_kit_info->item_kit_id != null) { ?>
        <div class="field_row clearfix" style="width: 400px;  float: left;">
                    <?php echo form_label(lang('items_category') . ':', 'category', array('class' => 'wide')); ?>
            <div class='form_field'>
                <select name="category" style="width: 202px;">
                    <?php
                    $this->load->model('Category');
                    $cats = $this->Category->get_all();
                    if ($cats != null) {
                        foreach ($cats as $cat) {
                            if ($item_kit_info->category == $cat['id_cat']) {
                                ?>
                                <option value="<?php echo $cat['id_cat']; ?>" selected="selected" style="padding-left: 5px;">
                                    <?php echo $cat['name']; ?>
                                </option>
                                <?php } else {
                                ?>
                                <option value="<?php echo $cat['id_cat']; ?>" style="padding-left: 5px;">
                                <?php echo $cat['name']; ?>
                                </option>
                <?php
            }
        }
    }
    ?>
                </select>
            </div>
        </div>
                    <?php } else {
                    ?>
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
                            <option value="<?php echo $cat['id_cat']; ?>" style="padding-left: 5px;">
                <?php echo $cat['name']; ?>
                            </option>
                <?php
            }
        }
        ?>
                </select>
            </div>
        </div>
                <?php }
            ?>
    <!-- end category item -->
    <div class="field_row clearfix" style="width: 400px;  float: left;">
            <?php echo form_label(lang('item_kits_description') . ':', 'description', array('class' => 'wide')); ?>
        <div class='form_field'>
<?php
echo form_textarea(array(
    'name' => 'description',
    'id' => 'description',
    'value' => $item_kit_info->description,
    'rows' => '5',
    'cols' => '17'
));
?>
        </div>
    </div>

</fieldset>
<fieldset id="item_kit_info2">
    <legend>Thông tin công đoạn thiết kế</legend>
    <?php
    $check = $this->Item_kit->check_design_template_by_item_kit_id($item_kit_info->item_kit_id);
    if ($check->num_rows == 0) {
        $arr = array();
        foreach ($processes_item_kit->result() as $pig) {
            //kiem tra da ton tai cong doan nao da hoan thanh chua
            //da hoan thanh thi ko chon nhom cong doan khac nua
            //Chua hoan thanh thi duoc chon nhom khac
            $check1 = $this->Item_kit->check_processes_design_template_audi($item_kit_info->item_kit_id, $pig->id_processes);
            if ($check1->num_rows() == 1) {
                $arr[] = $pig->id_processes;
            }
        }
        if (count($arr) == 0) {
            ?>
            <div class="field_row clearfix" style="width: 400px;  float: left;" >
            <?php echo form_label("Nhóm công đoạn: ", "cat_pro", array("class" => "wide")); ?>
                <div class='form_field'>
                    <select name="cat_pro_id" id="cat_pro_id">
                        <option value="">---Chọn nhóm công đoạn---</option>
        <?php foreach ($category_processes as $cat_pro) { ?>
                            <option value="<?= $cat_pro->cat_pro_id; ?>"><?= $cat_pro->cat_pro_name; ?></option>
        <?php } ?>
                    </select>
                </div>
            </div>
                <?php }
            }
            ?>
    <table id="pack_items">
        <thead>
            <tr style="height: 26px !important">
                <th style="width: 10%">Xóa</th>
                <th style="width: 50%">Tên công đoạn</th>
                <th style="width: 40%">Thời gian hoàn thành</th>
            </tr>
        </thead>
        <tbody>
                           <?php
                           foreach ($processes_item_kit->result() as $pig) {
                               $info_processes = $this->Item_kit->get_info_processes($pig->id_processes);
                               $check = $this->Item_kit->check_processes_design_template_audi($item_kit_info->item_kit_id, $pig->id_processes);
                               ?>
                <tr>
                    <td id=del_td ><?= $check->num_rows() > 0 ? '' : '<a href=# onclick="return deleteItemKitRow(this);">X</a>' ?></td>
                    <td id=name_td >
                        <input type=hidden class="id_processes" id="id_processes_<?= $pig->id_processes ?>" 
                               name="id_processes[<?= $pig->id_processes ?>]"
                               value=<?= $pig->id_processes ?> >
                        <?= $info_processes->name_processes ?>
                    </td>
                    <td id=date_td>
    <?php if ($check->num_rows() > 0) { ?>
                            <div style="font: 16px solid; font-weight: bold">
                                <input class="date_finish2<?= $pig->id_processes ?>" 
                                       name="date_finish[<?= $pig->id_processes ?>]" 
                                       value="<?= date('d-m-Y', strtotime($pig->date_finish)) ?>" type="hidden" />
        <?= date('d-m-Y', strtotime($pig->date_finish)) ?>
                            </div>
                    <?php } else {
                    ?>
                            <input placeholder="Chọn ngày" 
                                   class="date-pick date_finish2<?= $pig->id_processes ?> date_finish<?= $pig->id_processes ?>" 
                                   id="date_finish" name="date_finish[<?= $pig->id_processes ?>]" 
                                   value="<?= date('d-m-Y', strtotime($pig->date_finish)) ?>" /> 
            <?php }
        ?>
                    </td>
                </tr>
    <?php }
?>
        </tbody>
    </table> 
<?php
echo form_submit(array(
    'value' => lang('common_submit'),
    'class' => 'submit_button float_right',
    'style' => 'margin-top:10px; margin-right:30px; margin-bottom: 20px;',
    'name' => 'save_item'
));
?> 
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
    $('.submit_button').click(function () {
        var arr_date_finish = [];
        $('#pack_items').find('.id_processes').each(function (index, element) {
            var id_processes = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var date_finish = $('.date_finish2' + id_processes).val();
            if (!date_finish) {
                arr_date_finish.push(id_processes);
            }
        });
        if (arr_date_finish.length > 0) {
            alert("Một số công đoạn chưa có thời gian hoàn thành !");
            return false;
        }
    });
    $(document).ready(function () {
        /*~~~~ Hưng Audi 8-9-15 >>>>*/
        $('#pack_items').find('.id_processes').each(function (index, element) {
            var id_processes = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);

            $('.date_finish' + id_processes).datePicker({startDate: '01-01-1950'}).bind(
                    'dpClosed',
                    function (e, selectedDates) {
                        var d = selectedDates[0];
                        if (d) {
                            d = new Date(d);
                        }
                    }
            );
        });

        setTimeout(function () {
            $(":input:visible:first", "#item_kit_form").focus();
        }, 100);
        var submitting = false;
        $('#item_kit_form').validate({
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
            rules: {
                item_kit_number: {
                    required: true,
                    remote: {
                        url: "<?php echo site_url('item_kits/checkItemKitNumber/' . $item_kit_info->item_kit_id); ?>",
                        type: "post"
                    }
                },
                name: {
                    required: true,
                    remote: {
                        url: "<?php echo site_url('item_kits/checkname/' . $item_kit_info->item_kit_id); ?>",
                        type: "post"
                    }
                },
                category: "required",
                unit_price: "number",
                cost_price: "number",
                discount: "number"
            },
            messages: {
                item_kit_number: {
                    required: <?php echo json_encode(lang('item_kits_input_code')); ?>,
                    remote: <?php echo json_encode(lang('item_kits_exist_code')); ?>
                },
                name: {
                    required: <?php echo json_encode(lang('item_kits_input_name')); ?>,
                    remote: <?php echo json_encode(lang('item_kits_exist_name')); ?>
                },
                category:<?php echo json_encode(lang('items_category_required')); ?>,
                unit_price: <?php echo json_encode(lang('items_unit_price_number')); ?>,
                cost_price: <?php echo json_encode(lang('items_cost_price_number')); ?>,
                discount: <?php echo json_encode(lang('items_kit_discount_number')); ?>
            }
        });

        $("#cat_pro_id").change(function () {
            $("#pack_items tbody tr").remove();
            $.ajax({
                type: "POST",
                url: "<?= site_url('item_kits/get_list_processes_by_cat_pro_id'); ?>",
                data: {cat_pro_id: $(this).val()},
                success: function (data) {
                    $(data).each(function (i, e) {
                        $("#pack_items tbody").append(
                                '<tr>'
                                + '<td id=del_td ><a href=# onclick="return deleteItemKitRow(this);">X</a></td>'
                                + '<td id=name_td ><input type=hidden class="id_processes" \n\
                                    id="id_processes_' + e.id_processes + '" \n\
                                    name="id_processes[' + e.id_processes + ']" \n\
                                    value=' + e.id_processes + ' >' + e.name_processes + '</td>'

                                + '<td id=date_td ><input placeholder="Chọn ngày" class="date-pick date_finish2' + e.id_processes + ' date_finish' + e.id_processes + '" \n\
                                    id="date_finish" \n\
                                    name="date_finish[' + e.id_processes + ']" \n\
                                    value="" />'
                                + '</td>'
                                + '</tr>'
                                );
                        $('.date_finish' + e.id_processes).datePicker({startDate: '01-01-1950'}).bind(
                                'dpClosed',
                                function (a, selectedDates) {
                                    var d = selectedDates[0];
                                    if (d) {
                                        d = new Date(d);
                                    }
                                }
                        );
                    });
                    return false;
                },
                dataType: 'json'
            });
        });
    });
    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();
        return false;
    }
</script>