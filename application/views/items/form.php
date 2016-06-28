<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css?<?php echo APPLICATION_VERSION; ?>" />
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open('items/save/' . $item_info->item_id, array('id' => 'item_form'));?>
<fieldset id="item_basic_info">
    <legend style="font-size: 1.4em"><?php echo lang("items_basic_information"); ?></legend>
    <table>
        <tr>
            <td>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_item_number') . ':', 'name', array('class' => 'required wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'item_number',
                            'id' => 'item_number',
                            'value' => $item_info->item_number
                        ));
                        ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_name') . ':', 'name', array('class' => 'required wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'name',
                            'id' => 'name',
                            'value' => $item_info->name
                        ));
                        ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                    <?php echo form_label('Tên SP(English)' . ':', 'name', array('class' => 'required wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'en_name',
                            'id' => 'en_name',
                            'value' => $item_info->en_name
                        ));
                        ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_category') . ':', 'category', array('class' => 'required wide')); ?>
                    <div class='form_field'>
                        <?php echo form_dropdown('category', $cats, $selected_cat); ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                        <?php echo form_label(lang('items_made_in') . ':', 'made_in', array('class' => 'wide')); ?>
                    <div class='form_field'>
                        <?php echo form_textarea(array(
                            'name' => 'made_in',
                            'id' => 'made_in',
                            'value' => $item_info->made_in,
                            'rows' => '5',
                            'cols' => '23'
                        ));
                        ?>
                    </div>
                </div>
                <div class="field_row clearfix">
                    <?php echo form_label('Show to Thực-Đơn', 'product_view_home', array('class' => 'wide')); ?>
                    <div class='form_field'>
                        <?php echo form_checkbox(array(
                            'name' => 'product_view_home',
                            'id' => 'product_view_home',
                            'value' => 1,
                            'checked' => ($item_info->product_view_home) ? 1 : 0
                        ));
                        ?>
                    </div>
                </div>
            </td>
            <td style="text-align: center">
                <!--- phan lam anh -->
                <?php echo form_label(lang('item_add_images') . ':', 'item_image', array('class' => 'wide')); ?>
                <div class="input_file" style="">
                    <?php echo form_input(array(
                        'name' => 'item_image',
                        'id' => 'item_image',
                        'type' => 'file'
                    ));
                    ?>
                </div>

                <div class="field_row clearfix">
                    <?php if ($item_info->images == null) { ?>
                        <div class="" style="border: none">
                            <div class='form_field'>
                                <img src="<?php echo base_url() . 'images/no-images-product.jpg' ?>" style="width:150px; height:150px" />
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="field_row clearfix" style="border-bottom:none">
                            <div class='form_field'>
                                <img src="<?php echo base_url() . 'item/' . $item_info->images ?>" style="width:150px; height:150px" />
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- end phan lam anh -->


                </div>
            </td>
        </tr>
    </table>
</fieldset>
<br>
<table>
    <tr>
        <td>
            <fieldset id="item_basic_info" style="width: 380px; height: 400px">
                <legend style="font-size: 1.4em">Thông tin về giá</legend>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_unit_price_1') . ':', 'cost_price', array('class' => 'required wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'cost_price',
                            'size' => '15',
                            'id' => 'cost_price',
                            'value' => number_format($item_info->cost_price),
                            'style' => 'text-align: right',
                        ));
                        ?> <span style="font-size: 0.75em">VNĐ</span>
                    </div>
                </div>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_unit_price_2') . ':', 'unit_price_2', array('class' => 'required wide')); ?>
                    <div class='form_field'>
                    <?php echo form_input(array(
                        'name' => 'unit_price',
                        'size' => '15',
                        'id' => 'unit_price',
                        'value' => number_format($item_info->unit_price),
                        'style' => 'text-align: right',
                    ));
                    ?> <span style="font-size: 0.75em">VNĐ</span>
                    </div>
                </div>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_promo_price') . ':', 'promo_price', array('class' => 'wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'promo_price',
                            'size' => '8',
                            'id' => 'promo_price',
                            'value' => number_format($item_info->promo_price),
                            'style' => 'text-align: right',
                        ));
                        ?>
                    </div>
                </div>
                <div id="start_date_new">
                    <label><?php echo lang('items_promo_start_date'); ?>:</label>
                    <p>
                    <?php echo form_dropdown('start_day', $days, $selected_start_day, 'id="start_day"'); ?>
                    <?php echo form_dropdown('start_month', $months, $selected_start_month, 'id="start_month"'); ?>
                    <?php echo form_dropdown('start_year', $years, $selected_start_year, 'id="start_year"'); ?>
                    </p>
                </div>
                <div id="end_date_new">
                    <label><?php echo lang('items_promo_end_date'); ?>:</label>
                    <p>
                        <?php echo form_dropdown('end_day', $days, $selected_end_day, 'id="end_day"'); ?>
                        <?php echo form_dropdown('end_month', $months, $selected_end_month, 'id="end_month"'); ?>
                        <?php echo form_dropdown('end_year', $end_years, $selected_end_year, 'id="end_year"'); ?>
                        <input type="hidden" id="hdn_start_date" name="hdn_start_date" value="<?php echo $item_info->start_date; ?>" />
                        <input type="hidden" id="hdn_end_date" name="hdn_end_date" value="<?php echo $item_info->end_date; ?>" />
                    </p>
                </div>
                <div class="field_row clearfix">
                    <?php echo form_label('Thuế:', 'taxes', array('class' => 'wide')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'taxes',
                            'size' => '8',
                            'id' => 'taxes',
                            'value' => $item_info->taxes,
                            'style' => 'text-align: right',
                        ));
                        ?> %
                    </div>
                </div>
                 <div class="field_row clearfix">
                    <?php echo form_label('SP tiêu biểu', 'taxes', array('class' => 'required wide')); ?>
                     <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'top',
                            'size' => '8',
                            'id' => 'top',
                            'value' => $item_info->top,
                            'style' => 'text-align: right',
                        ));
                        ?>
                    </div>
                </div>
                <div class="field_row clearfix">
                                <?php echo form_label('Tài khoản kho:', 'content_ctu', array('class' => 'wide')); ?>
                    <div class='form_field' >
                        <select id="account_store" name="account_store">
                            <option value="0">-Chọn tài khoản-</option>
                            <?php
                            $this->load->model('Tkdu');
                            $list_tk_co = $this->Tkdu->get_tkdu_parent();
                            foreach ($list_tk_co as $parent1) {
                                ?>
                                <option value="<?= $parent1['id'] ?>" <?= $item_info->account_store == $parent1['id'] ? 'selected' : '' ?> >
                                <?= $parent1['id'] . ' - ' . $parent1['name'] ?>
                                </option>
                                <?php
                                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                                foreach ($parents2 as $parent2) {
                                    ?>
                                    <option value="<?= $parent2->id ?>" <?= $parent2->id == $item_info->account_store ? 'selected' : '' ?> >
                                    <?= '---- ' . $parent2->id . ' - ' . $parent2->name ?>
                                    </option>
                                    <?php
                                    $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                                    foreach ($parents3 as $parent3) {
                                        ?>
                                        <option value="<?= $parent3->id ?>" <?= $parent3->id == $item_info->account_store ? 'selected' : '' ?> >
            <?= '----.---- ' . $parent3->id . ' - ' . $parent3->name ?>
                                        </option>
                                <?php
                            }
                        }
                    }
                    ?>
                        </select>
                    </div>
                </div>

                <div class="field_row clearfix">
                                <?php echo form_label('Tài khoản giá vốn:', 'content_ctu', array('class' => 'wide')); ?>
                    <div class='form_field' >
                        <select id="account_reven" name="account_reven">
                            <option value="0">-Chọn tài khoản-</option>
                            <?php
                            $this->load->model('Tkdu');
                            $list_tk_co = $this->Tkdu->get_tkdu_parent();
                            foreach ($list_tk_co as $parent1) {
                                ?>
                                <option value="<?= $parent1['id'] ?>" <?= $item_info->account_reven == $parent1['id'] ? 'selected' : '' ?> >
                                <?= $parent1['id'] . ' - ' . $parent1['name'] ?>
                                </option>
                                <?php
                                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                                foreach ($parents2 as $parent2) {
                                    ?>
                                    <option value="<?= $parent2->id ?>" <?= $parent2->id == $item_info->account_reven ? 'selected' : '' ?> >
                                    <?= '---- ' . $parent2->id . ' - ' . $parent2->name ?>
                                    </option>
                                    <?php
                                    $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                                    foreach ($parents3 as $parent3) {
                                        ?>
                                        <option value="<?= $parent3->id ?>" <?= $parent3->id == $item_info->account_reven ? 'selected' : '' ?> >
            <?= '----.---- ' . $parent3->id . ' - ' . $parent3->name ?>
                                        </option>
                                <?php
                            }
                        }
                    }
                    ?>
                        </select>
                    </div>
                </div>

                <div class="field_row clearfix">
                                <?php echo form_label('Tài khoản dở dang:', 'content_ctu', array('class' => 'wide')); ?>
                    <div class='form_field' >
                        <select id="account_incomplete" name="account_incomplete">
                            <option value="0">-Chọn tài khoản-</option>
                            <?php
                            $this->load->model('Tkdu');
                            $list_tk_co = $this->Tkdu->get_tkdu_parent();
                            foreach ($list_tk_co as $parent1) {
                                ?>
                                <option value="<?= $parent1['id'] ?>" <?= $item_info->account_incomplete == $parent1['id'] ? 'selected' : '' ?> >
                                <?= $parent1['id'] . ' - ' . $parent1['name'] ?>
                                </option>
                                <?php
                                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                                foreach ($parents2 as $parent2) {
                                    ?>
                                    <option value="<?= $parent2->id ?>" <?= $parent2->id == $item_info->account_incomplete ? 'selected' : '' ?> >
                                    <?= '---- ' . $parent2->id . ' - ' . $parent2->name ?>
                                    </option>
                                    <?php
                                    $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                                    foreach ($parents3 as $parent3) {
                                        ?>
                                        <option value="<?= $parent3->id ?>" <?= $parent3->id == $item_info->account_incomplete ? 'selected' : '' ?> >
            <?= '----.---- ' . $parent3->id . ' - ' . $parent3->name ?>
                                        </option>
            <?php
        }
    }
}
?>
                        </select>
                    </div>
                </div>

                <div class="field_row clearfix">
        <?php echo form_label('Tài khoản doanh thu:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <select id="account_cos" name="account_cos">
                <option value="0">-Chọn tài khoản-</option>
                <?php
                $this->load->model('Tkdu');
                $list_tk_co = $this->Tkdu->get_tkdu_parent();
                foreach ($list_tk_co as $parent1) {
                    ?>
                    <option value="<?= $parent1['id'] ?>" <?= $item_info->account_cos == $parent1['id'] ? 'selected' : '' ?> >
                        <?= $parent1['id'] . ' - ' . $parent1['name'] ?>
                    </option>
                    <?php
                    $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                    foreach ($parents2 as $parent2) {
                        ?>
                        <option value="<?= $parent2->id ?>" <?= $parent2->id == $item_info->account_cos ? 'selected' : '' ?> >
                            <?= '---- ' . $parent2->id . ' - ' . $parent2->name ?>
                        </option>
                        <?php
                        $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                        foreach ($parents3 as $parent3) {
                            ?>
                            <option value="<?= $parent3->id ?>" <?= $parent3->id == $item_info->account_cos ? 'selected' : '' ?> >
                                <?= '----.---- ' . $parent3->id . ' - ' . $parent3->name ?>
                            </option>
                            <?php
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>
            </fieldset>
        </td>

        <td>
            <fieldset id="item_basic_info" style="width: 450px; height: 400px">
                <legend style="font-size: 1.4em">Thông tin đơn vị</legend>
                <?php if ($item_info->item_id != null) { ?>
                    <div class="field_row clearfix">
                        <?php echo form_label(lang('items_unit') . ':', 'unit', array('class' => 'required wide', 'style'=>'width: 150px')); ?>
                        <div class='form_field'>
                            <select name="unit">
                                <?php
                                $this->load->model('Unit');
                                $units = $this->Unit->get_all();
                                if ($units != null) {
                                    foreach ($units as $unit) {
                                        ?>
                                        <?php if ($item_info->unit == $unit['id_unit']) { ?>
                                            <option value="<?php echo $unit['id_unit']; ?>" selected="selected"><?php echo $unit['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $unit['id_unit']; ?>"><?php echo $unit['name']; ?></option>
                                        <?php }
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="field_row clearfix">
                        <?php echo form_label(lang('items_unit') . ':', 'unit', array('class' => 'required wide', 'style'=>'width: 150px')); ?>
                        <div class='form_field'>
                            <select name="unit">
                            <?php
                            $this->load->model('Unit');
                            $units = $this->Unit->get_all();
                            if ($units != null) {
                                foreach ($units as $unit) {
                                ?>
                                    <option value="<?php echo $unit['id_unit']; ?>"><?php echo $unit['name']; ?></option>
                                <?php }
                            } ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <!--  -->

                <div class="field_row clearfix">
                    <p>Chuyển đổi đơn vị &nbsp;
                        <input type="checkbox" name="is" id="is" value="1" <?= (($item_info->quantity_first == '') || ($item_info->quantity_first == 0)) ? '' : 'checked=checked' ?>>
                    </p>
                </div>
                <div id="change_rate" <?= (($item_info->quantity_first == '') || ($item_info->quantity_first == 0)) ? 'style="display: none;"' : '' ?>>
                    <div class="field_row clearfix">
                        <?php echo form_label('Đơn vị quy đổi:', 'unt', array('class' => 'required wide', 'style'=>'width: 150px')); ?>
                        <div class='form_field'>
                            <select name="unit_from" id="unit">
                                <option value="">Chọn đơn vị quy đổi</option>
                                <?php foreach ($units as $val) { ?>
                                    <option value="<?= $val['id_unit'] ?>" <?= ($item_info->unit_from == $val['id_unit']) ? 'selected=selected' : '' ?>><?= $val['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="field_row clearfix">
                        <label class="required wide" style="width: 150px"><?php echo lang('items_unit_rate');?>:</label>
                        <div class='form_field'>
                            <input type="text" id="unit_rate" name="unit_rate" value="<?= $item_info->unit_rate ?>"></input>
                        </div>
                    </div>
                    <div class="field_row clearfix">
                        <?php echo form_label(lang('items_cost_price_rate').':', 'quantity', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                        <div class='form_field'>
                            <input type="text" id="cost_price_rate" name="cost_price_rate" value="<?= number_format($item_info->cost_price_rate) ?>"></input>&nbsp; VNĐ
                        </div>
                    </div>
                    <div class="field_row clearfix">
                        <?php echo form_label(lang('items_unit_price_rate').':', 'quantity', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                        <div class='form_field'>
                            <input type="text" id="unit_price_rate" name="unit_price_rate" value="<?= number_format($item_info->unit_price_rate) ?>"></input>&nbsp; VNĐ
                        </div>
                    </div>
                </div>

                <div style ='display:none' class="field_row clearfix">
                    <?php echo form_label(lang('items_warning') . ':', 'warning', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'warning',
                            'id' => 'warning',
                            'value' => $item_info->warning
                        ));
                        ?>
                    </div>
                </div>
                <?php if($item_info->item_id){?>
                    <div class="field_row clearfix">
                        <?php echo form_label('Số lượng trong kho:', 'quantity', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                        <div class='form_field'>
                            <?php echo form_input(array(
                                'name' => 'quantity',
                                'id' => 'quantity',
                                'readonly' => 'readonly',
                                'value' => format_quantity($item_info->quantity)
                            ));
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_reorder_level') . ':', 'reorder_level', array('class' => 'required wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'reorder_level',
                            'id' => 'reorder_level',
                            'value' => $item_info->reorder_level
                        ));
                        ?>
                    </div>
                </div>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_description') . ':', 'description', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php echo form_textarea(array(
                            'name' => 'description',
                            'id' => 'description',
                            'value' => $item_info->description,
                            'rows' => '5',
                            'cols' => '17'
                        ));
                        ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                    <?php echo form_label('Mô tả(English)' . ':', 'en_description', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php echo form_textarea(array(
                            'name' => 'en_description',
                            'id' => 'en_description',
                            'value' => $item_info->en_description,
                            'rows' => '5',
                            'cols' => '17'
                        ));
                        ?>
                    </div>
                </div>
                <div class="field_row clearfix">
                    <?php echo form_label(lang('items_allow_alt_desciption') . ':', 'allow_alt_description', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php echo form_checkbox(array(
                            'name' => 'allow_alt_description',
                            'id' => 'allow_alt_description',
                            'value' => 1,
                            'checked' => ($item_info->allow_alt_description) ? 1 : 0
                        ));
                        ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                    <?php echo form_label('Bán theo mét vuông'  . ':', 'allow_alt_description', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php
//                        echo form_checkbox(array(
//                            'name' => 'stt_m2',
//                            'id' => 'stt_m2',
//                            'value' => 1,
//                            'checked' => ($item_info->stt_m2) ? 1 : 0
//                        ));
                        ?>
                    </div>
                </div>

                <div class="field_row clearfix">
                    <?php echo form_label('Độ ưu tiên:', 'priority', array('class' => 'wide', 'style'=>'width: 150px')); ?>
                    <div class='form_field'>
                        <?php echo form_input(array(
                            'name' => 'priority',
                            'id' => 'priority',
                            'value' => $item_info->priority
                        ));
                        ?>
                    </div>
                </div>

                <?php echo form_submit(array(
                    'value' => lang('common_submit'),
                    'style' => 'margin-right: 109px; margin-bottom: 20px',
                    'class' => 'submit_button float_right'
                ));
                ?>
            </fieldset>
        </td>
    </tr>
</table>

<?php echo form_close();?>
<script type='text/javascript'>
//validation and submit handling
    $(document).ready(function(){
        if ($("#is").is(':checked')){
            $('#change_rate').slideDown("fast");
        } else{
            $('#change_rate').slideUp("fast");
        }
        setTimeout(function(){$(":input:visible:first", "#item_form").focus(); }, 100);
        $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function(){
            $("#hdn_start_date").val($("#start_year").val() + '-' + $("#start_month").val() + '-' + $('#start_day').val());
            $("#hdn_end_date").val($("#end_year").val() + '-' + $("#end_month").val() + '-' + $('#end_day').val());
        });
        $("#category").autocomplete({
            source: "<?php echo site_url('items/suggest_category'); ?>",
            delay: 10,
            autoFocus: false,
            minLength: 0
        });
        var submitting = false;
        $('#item_form').validate({
            submitHandler:function(form){
                if (submitting) return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success:function(response){
                        submitting = false;
                        tb_remove();
                        post_item_form_submit(response);
                    },
                    dataType:'json'
                });
            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:{
                <?php if (!$item_info->item_id) { ?>
                item_number:{
                    required: true,
                    remote:{
                        url: "<?php echo site_url('items/item_number_exists'); ?>",
                        type: "post"
                    }
                },
                <?php } ?>
                name:{
                    required: true,
//                    remote:{
//                        url: "<?php echo site_url('items/checkname/' . $item_info->item_id); ?>",
//                        type: "post"
//                    }
                },
                category:{
                    required: true
                },
//                cost_price:{
//                    required:true,
//                    number:true
//                },
//                unit_price:{
//                    required:true,
//                    number:true
//                },
                tax_percent:{
                    required:true,
                    number:true
                },
                reorder_level:{
                    required:true,
                    number:true
                },
                unit:{
                    required: true
                },
                unit_from:{
                    required: function(){
                        return $("#is").is(":checked");
                    }
                },
                unit_rate:{
                    required: function(){
                        return $("#is").is(":checked");
                    },
                    number: function(){
                        return $("#is").is(":checked");
                    }
                },
                    top:{
                    number:true,
                    min:0,
                    max:4,
                    remote:{
                        url: "<?php echo site_url('items/check_position/' . $item_info->item_id); ?>",
                        type: "post"
                    }
                },
            },

            messages:{
            <?php if (!$item_info->item_id) { ?>
                item_number:{
                    required: 'Vui lòng nhập mã mặt hàng',
                    remote: <?php echo json_encode(lang('items_item_number_exists')); ?>
                },
            <?php } ?>
                name:{
                    required: 'Vui lòng nhập tên mặt hàng',
//                    remote: 'Tên đã tồn tại, vui lòng chọn tên khác'
                },
                category:{
                    required: <?php echo json_encode(lang('items_category_required')); ?>,
                },
//                cost_price:{
//                    required:<?php echo json_encode(lang('items_cost_price_required')); ?>,
//                    number:<?php echo json_encode(lang('items_cost_price_number')); ?>
//                },
//                unit_price:{
//                    required:<?php echo json_encode(lang('items_unit_price_required')); ?>,
//                    number:<?php echo json_encode(lang('items_unit_price_number')); ?>
//                },
                tax_percent:{
                    required:<?php echo json_encode(lang('items_tax_percent_required')); ?>,
                    number:<?php echo json_encode(lang('items_tax_percent_number')); ?>
                },
                reorder_level:{
                    required:<?php echo json_encode(lang('items_reorder_level_required')); ?>,
                    number:<?php echo json_encode(lang('items_reorder_level_number')); ?>
                },
                unit:{
                    required: "Bạn chưa chọn đơn vị"
                },
                unit_from:{
                    required: "Bạn chưa chọn đơn vị quy đổi",
                },
                unit_rate:{
                    required: "Bạn chưa điền số lượng sau quy đổi",
                    number: "Số lượng sau quy đổi phải là số",
                },
                          top:{
                    number: "Vị trí phải là số",
                    min: "Đánh số không được nhỏ hơn 0",
                    max: "Đánh số không được lớn hơn 4",
                    remote: 'Số này đã tồn tại ở sản phẩm khác .Vui lòng kiểm tra lại',
                },
            }
        });
        $("#is").click(function(){
            if ($("#is").is(':checked')){
                $('#change_rate').slideDown("fast");
            } else{
                $('#change_rate').slideUp("fast");
            }
        });
        $("#cost_price,#unit_price,#unit_rate").blur(function(){
            var cost_price = $("#cost_price").val() != 0 ? parseFloat(($("#cost_price").val()).replace(/,/g, "")) : 0;
            var unit_price = $("#unit_price").val() != 0 ? parseFloat(($("#unit_price").val()).replace(/,/g, "")) : 0;
            var unit_rate = $("#unit_rate").val() != 0 ? parseFloat(($("#unit_rate").val()).replace(/,/g, "")) : 0;
            var cost_price_rate = ((cost_price/unit_rate) + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            var unit_price_rate = ((unit_price/unit_rate) + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
            if(unit_rate == '' || unit_rate == 0){
                $("#unit_price_rate").val(0);
                $("#cost_price_rate").val(0);
            }else{
                if(unit_price_rate){
                    $("#unit_price_rate").val(unit_price_rate);
                }else{
                    $("#unit_price_rate").val(0);
                }
                if(cost_price_rate){
                    $("#cost_price_rate").val(cost_price_rate);
                }else{
                    $("#cost_price_rate").val(0);
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $("#unit_price").maskMoney();
        $("#cost_price").maskMoney();
        $("#promo_price").maskMoney();
        $("#taxes").maskMoney();
        $("#cost_price_rate").maskMoney();
        $("#unit_price_rate").maskMoney();
        $("#unit_rate").maskMoney();
    });
</script>
<style>
    #unit_rate,#cost_price_rate, #unit_price_rate, #quantity, #reorder_level{
        text-align: right;
    }
</style>
