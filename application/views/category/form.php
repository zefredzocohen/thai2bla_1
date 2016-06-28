<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div style="height:200px;">
    <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>
    <fieldset id="item_basic_info">
        <legend><?php echo lang("categories_basic_information"); ?></legend>
        <div class="field_row clearfix">
            <label>Loại:</label>
            <?php if($item_info->cat_service == 0){?>
                <label id='label_item' style="float: none; position: relative; margin-right: 20px;">
                    <input id="cat_item" style="width: auto" type="radio" name="cat_service" value="0" checked="checked"/>
                    <span>Mặt hàng</span>
                </label>
                <label id='label_service' style="float: none; position: relative">
                    <input id="cat_service" style="width: auto" type="radio" name="cat_service" value="1"/>
                    <span>Dịch vụ</span>
                </label>
            <?php }else{ ?>
                <label id='label_item' style="float: none; position: relative; margin-right: 20px;">
                    <input id="cat_item" style="width: auto" type="radio" name="cat_service" value="0"/>
                    <span>Mặt hàng</span>
                </label>
                <label id='label_service' style="float: none; position: relative">
                    <input id="cat_service" style="width: auto" type="radio" name="cat_service" value="1" checked="checked"/>
                    <span>Dịch vụ</span>
                </label>
            <?php } ?>
        </div>
        <div id="category_item">
            <?php echo form_open_multipart('categories/save/' . $item_info->id_cat, array('id' => 'categories_form_item'));?>
            <div class="field_row clearfix">
                <?php echo form_label('Mã nhóm mặt hàng:', 'name', array('class' => 'wide required')); ?>
                <div class='form_field'>
                    <?php echo form_input(array(
                        'name' => 'code_cat_item',
                        'id' => 'code_cat_item',
                        'value' => $item_info->code_cat)
                    );
                    ?>
                </div>
            </div>
            <div class="field_row clearfix">
                <?php echo form_label('Tên nhóm mặt hàng:', 'name', array('class' => 'required wide')); ?>
                <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'name_item',
                    'id' => 'name_item',
                    'value' => $item_info->name)
                );
                ?>
                </div>
            </div>

            <div class="field_row clearfix">
                <?php echo form_label('Tên nhóm mặt hàng (English):', 'name', array('class' => 'required wide')); ?>
                <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'en_name',
                    'id' => 'en_name',
                    'value' => $item_info->en_name)
                );
                ?>
                </div>
            </div>
            <div class="field_row clearfix">
                <?php echo form_label('Ảnh:', 'image', array('class' => 'required wide')); ?>
                <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'image',
                    'id' => 'image',
                    'type' => 'file')
                );
                ?>
                </div>
            </div>

            <div class="field_row clearfix">
                <?php echo form_label(lang('categories_parent_name') . ':', 'category', array('class' => 'wide'));
                $this->load->model('Category');
                $this->db->where('parentid', 0);
                $this->db->where('cat_service', 0);
                $menu2 = $this->db->get('categories_item');
                if ($menu2->num_rows() > 0) {
                    ?>
                    <select name="category_item">
                        <option value="0"></option>
                        <?php
                        foreach ($menu2->result_array() as $row3) {
                            $menu3 = $this->Category->check($row3['id_cat']);
                            if ($item_info->parentid == $row3['id_cat']) {
                                ?>
                                <option  value="<?php echo $row3['id_cat'] ?>" selected="selected"   >-<?php echo $row3['name'] ?></option>
                                <?php } else {
                                ?>
                                <option value="<?php echo $row3['id_cat'] ?>" >-<?php echo $row3['name'] ?></option>
                                <?php
                            }
                            foreach ($menu3->result_array() as $row4) {
                                $menu4 = $this->Category->check($row4['id_cat']);
                                if ($item_info->parentid == $row4['id_cat']) {
                                    ?>
                                    <option value="<?php echo $row4['id_cat'] ?>" selected="selected" >---<?php echo $row4['name'] ?></option>
                                    <?php } else {
                                    ?>
                                    <option value="<?php echo $row4['id_cat'] ?>" >---<?php echo $row4['name'] ?></option>
                                    <?php
                                }
                                foreach ($menu4->result_array() as $row5) {
                                    $menu5 = $this->Category->check($row5['id_cat']);
                                    if ($item_info->parentid == $row5['id_cat']) {
                                        ?>
                                        <option value="<?php echo $row5['id_cat'] ?>" selected="selected" >-----<?php echo $row5['name'] ?></option>
                                        <?php } else {
                                        ?>
                                        <option value="<?php echo $row5['id_cat'] ?>" >-----<?php echo $row5['name'] ?></option>
                                        <?php
                                    }
                                    foreach ($menu5->result_array() as $row6) {
                                        $menu6 = $this->Category->check($row6['id_cat']);
                                        if ($item_info->parentid == $row6['id_cat']) {
                                            ?>
                                            <option value="<?php echo $row6['id_cat'] ?>" selected="selected" >-------<?php echo $row6['name'] ?></option>
                                            <?php } else {
                                            ?>
                                            <option value="<?php echo $row6['id_cat'] ?>" >-------<?php echo $row6['name'] ?></option>
                                            <?php
                                        }
                                        foreach ($menu6->result_array() as $row7) {
                                            $menu7 = $this->Category->check($row7['id_cat']);
                                            if ($item_info->parentid == $row7['id_cat']) {
                                                ?>
                                                <option value="<?php echo $row7['id_cat'] ?>" selected="selected" >---------<?php echo $row7['name'] ?></option>
                                                <?php } else {
                                                ?>
                                                <option value="<?php echo $row7['id_cat'] ?>" >---------<?php echo $row7['name'] ?></option>
                                                <?php
                                            }
                                            foreach ($menu7->result_array() as $row8) {
                                                $menu8 = $this->Category->check($row8['id_cat']);
                                                if ($item_info->parentid == $row8['id_cat']) {
                                                    ?>
                                                    <option value="<?php echo $row8['id_cat'] ?>" selected="selected" >-----------<?php echo $row8['name'] ?></option>
                                                    <?php } else {
                                                    ?>
                                                    <option value="<?php echo $row8['id_cat'] ?>" >-----------<?php echo $row8['name'] ?></option>
                                                    <?php
                                                }
                                                foreach ($menu8->result_array() as $row9) {
                                                    $menu9 = $this->Category->check($row9['id_cat']);
                                                    if ($item_info->parentid == $row9['id_cat']) {
                                                        ?>
                                                        <option value="<?php echo $row9['id_cat'] ?>" selected="selected" >-------------<?php echo $row9['name'] ?></option>
                                                        <?php } else {
                                                        ?>
                                                        <option value="<?php echo $row9['id_cat'] ?>" >-------------<?php echo $row9['name'] ?></option>
                                                        <?php
                                                    }
                                                    foreach ($menu9->result_array() as $row10) {
                                                        $menu10 = $this->Category->check($row10['id_cat']);
                                                        if ($item_info->parentid == $row10['id_cat']) {
                                                            ?>
                                                            <option value="<?php echo $row10['id_cat'] ?>" selected="selected" >---------------<?php echo $row10['name'] ?></option>
                                                            <?php } else {
                                                            ?>
                                                            <option value="<?php echo $row10['id_cat'] ?>" >---------------<?php echo $row10['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    </select>
                    <?php
                    }
                    ?>
            </div>

            <div class="field_row clearfix">
                <?php echo form_label('Hiển thị', 'active', array('class' => 'wide')); ?>
                <div class='form_field'>
                <?php
                echo form_checkbox(array(
                    'name' => 'active',
                    'id'   => 'active',
                    'type' => 'checkbox',
                    'value' => 1,
                    'checked' => ($item_info->active) ? 1 : 0
                    ));
                ?>
                </div>
            </div>

            <?php echo form_hidden('submit_item', true); ?>
            <?php echo form_submit(array(
                'value' => lang('common_submit'),
                'class' => 'submit_button float_right')
            );
            ?>
            <?php echo form_close();?>
        </div>
        <!--===DICH VU===-->
        <div id="category_service">
            <?php echo form_open_multipart('categories/save/' . $item_info->id_cat, array('id' => 'categories_form_service'));?>
            <div class="field_row clearfix">
                <?php echo form_label('Mã nhóm dịch vụ:', 'name', array('class' => 'wide required')); ?>
                <div class='form_field'>
                    <?php echo form_input(array(
                        'name' => 'code_cat_service',
                        'id' => 'code_cat_service',
                        'value' => $item_info->code_cat)
                    );
                    ?>
                </div>
            </div>
            <div class="field_row clearfix">
                <?php echo form_label('Tên nhóm dịch vụ:', 'name', array('class' => 'required wide')); ?>
                <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'name_service',
                    'id' => 'name_service',
                    'value' => $item_info->name)
                );
                ?>
                </div>
            </div>
            <div class="field_row clearfix">
                <?php echo form_label('Tên nhóm dịch vụ(English):', 'name', array('class' => 'required wide')); ?>
                <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'en_name_service',
                    'id' => 'en_name_service',
                    'value' => $item_info->en_name)
                );
                ?>
                </div>
            </div>
            <div class="field_row clearfix">
                <?php echo form_label('Ảnh:', 'image', array('class' => 'required wide')); ?>
                <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'image',
                    'id' => 'image',
                    'type' => 'file')
                );
                ?>
                </div>
            </div>

            <div class="field_row clearfix">
                <?php echo form_label(lang('categories_parent_name') . ':', 'category', array('class' => 'wide'));
                if ($cat_service) {
                    ?>
                    <select name="category_service">
                        <option value="0"></option>
                        <?php
                        foreach ($cat_service as $row3) {
                            $menu3 = $this->Category->check($row3['id_cat']);
                            if ($item_info->parentid == $row3['id_cat']) {
                                ?>
                                <option  value="<?php echo $row3['id_cat'] ?>" selected="selected"   >-<?php echo $row3['name'] ?></option>
                                <?php } else {
                                ?>
                                <option value="<?php echo $row3['id_cat'] ?>" >-<?php echo $row3['name'] ?></option>
                                <?php
                            }
                            foreach ($menu3->result_array() as $row4) {
                                $menu4 = $this->Category->check($row4['id_cat']);
                                if ($item_info->parentid == $row4['id_cat']) {
                                    ?>
                                    <option value="<?php echo $row4['id_cat'] ?>" selected="selected" >---<?php echo $row4['name'] ?></option>
                                    <?php } else {
                                    ?>
                                    <option value="<?php echo $row4['id_cat'] ?>" >---<?php echo $row4['name'] ?></option>
                                    <?php
                                }
                                foreach ($menu4->result_array() as $row5) {
                                    $menu5 = $this->Category->check($row5['id_cat']);
                                    if ($item_info->parentid == $row5['id_cat']) {
                                        ?>
                                        <option value="<?php echo $row5['id_cat'] ?>" selected="selected" >-----<?php echo $row5['name'] ?></option>
                                        <?php } else {
                                        ?>
                                        <option value="<?php echo $row5['id_cat'] ?>" >-----<?php echo $row5['name'] ?></option>
                                        <?php
                                    }
                                    foreach ($menu5->result_array() as $row6) {
                                        $menu6 = $this->Category->check($row6['id_cat']);
                                        if ($item_info->parentid == $row6['id_cat']) {
                                            ?>
                                            <option value="<?php echo $row6['id_cat'] ?>" selected="selected" >-------<?php echo $row6['name'] ?></option>
                                            <?php } else {
                                            ?>
                                            <option value="<?php echo $row6['id_cat'] ?>" >-------<?php echo $row6['name'] ?></option>
                                            <?php
                                        }
                                        foreach ($menu6->result_array() as $row7) {
                                            $menu7 = $this->Category->check($row7['id_cat']);
                                            if ($item_info->parentid == $row7['id_cat']) {
                                                ?>
                                                <option value="<?php echo $row7['id_cat'] ?>" selected="selected" >---------<?php echo $row7['name'] ?></option>
                                                <?php } else {
                                                ?>
                                                <option value="<?php echo $row7['id_cat'] ?>" >---------<?php echo $row7['name'] ?></option>
                                                <?php
                                            }
                                            foreach ($menu7->result_array() as $row8) {
                                                $menu8 = $this->Category->check($row8['id_cat']);
                                                if ($item_info->parentid == $row8['id_cat']) {
                                                    ?>
                                                    <option value="<?php echo $row8['id_cat'] ?>" selected="selected" >-----------<?php echo $row8['name'] ?></option>
                                                    <?php } else {
                                                    ?>
                                                    <option value="<?php echo $row8['id_cat'] ?>" >-----------<?php echo $row8['name'] ?></option>
                                                    <?php
                                                }
                                                foreach ($menu8->result_array() as $row9) {
                                                    $menu9 = $this->Category->check($row9['id_cat']);
                                                    if ($item_info->parentid == $row9['id_cat']) {
                                                        ?>
                                                        <option value="<?php echo $row9['id_cat'] ?>" selected="selected" >-------------<?php echo $row9['name'] ?></option>
                                                        <?php } else {
                                                        ?>
                                                        <option value="<?php echo $row9['id_cat'] ?>" >-------------<?php echo $row9['name'] ?></option>
                                                        <?php
                                                    }
                                                    foreach ($menu9->result_array() as $row10) {
                                                        $menu10 = $this->Category->check($row10['id_cat']);
                                                        if ($item_info->parentid == $row10['id_cat']) {
                                                            ?>
                                                            <option value="<?php echo $row10['id_cat'] ?>" selected="selected" >---------------<?php echo $row10['name'] ?></option>
                                                            <?php } else {
                                                            ?>
                                                            <option value="<?php echo $row10['id_cat'] ?>" >---------------<?php echo $row10['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    </select>
                    <?php
                    }
                    ?>
            </div>

            <div class="field_row clearfix">
                <?php echo form_label('Hiển thị', 'active', array('class' => 'wide')); ?>
                <div class='form_field'>
                <?php
                echo form_checkbox(array(
                    'name' => 'active',
                    'id'   => 'active',
                    'type' => 'checkbox'
                    ), true, $item_info->active == 1 ? true : false
                );
                ?>
                </div>
            </div>
            <?php echo form_hidden('submit_service', true); ?>
            <?php echo form_submit(array(
                'value' => lang('common_submit'),
                'class' => 'submit_button float_right')
            );
            ?>
            <?php echo form_close(); ?>
        </div>
    </fieldset>
<script type='text/javascript'>
    //validation and submit handling
    $(document).ready(function(){
        setTimeout(function(){$(":input:visible:first", "#item_form").focus(); }, 100);
        var submitting = false;
        $('#categories_form_item').validate({ /*sau khi them submit no se goi lai manage*/
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
                code_cat_item:{
                    required: true,
                },
                name_item:{
                    required: true,
                },
            },
            messages:{
                code_cat_item:{
                    required: 'Bạn chưa điền mã nhóm mặt hàng',
                },
                name_item:{
                    required: 'Bạn chưa điền tên nhóm mặt hàng',
                },
            }
        });

        $('#categories_form_service').validate({ /*sau khi them submit no se goi lai manage*/
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
                code_cat_service:{
                    required: true,
                },
                name_service:{
                    required: true,
                },
            },
            messages:{
                code_cat_service:{
                    required: 'Bạn chưa điền mã nhóm dịch vụ',
                },
                name_service:{
                    required: 'Bạn chưa điền tên nhóm dịch vụ',
                },
            }
        });
        if($("#cat_item").is(":checked")){
            $("#category_item").css({"display":"block"});
            $("#category_service").css({"display":"none"});
        }
        if($("#cat_service").is(":checked")){
            $("#category_item").css({"display":"none"});
            $("#category_service").css({"display":"block"});
        }

        $("#cat_item").click(function(){
            if($("#cat_item").is(":checked")){
                $("#category_item").css({"display":"block"});
                $("#category_service").css({"display":"none"});
            }
        });
        $("#cat_service").click(function(){
            if($("#cat_service").is(":checked")){
                $("#category_item").css({"display":"none"});
                $("#category_service").css({"display":"block"});
            }
        });
    });
</script>
    <script type="text/javascript">
                $(function() {
                $("#unit_price").maskMoney();
                        $("#cost_price").maskMoney();
                });
    </script>
</div>
