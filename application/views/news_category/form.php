<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url()?>ckeditor/ckeditor.js" type="text/javascript"></script>

<div id="content_area_wrapper">
<fieldset id="customer_basic_info" style="border: none">
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <div id="content_area" style="color:#000;">
        <table id="contents">
            <tr>
                <td style="width:10px;"></td>
                <td>
                    <ul id="error_message_box" style="font-size: 12px; margin-bottom: 15px;"></ul>
                    <div id="item_table">
                        <div id="table_holder">
                            <?php
                            echo form_open('news_category/save/'.$item_info->id_cat,array('id'=>'news_category_form'));
                            ?>
                            <div class="field_row clearfix">
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px"><?php echo lang('news_category_name') ?> :</label>
                                    <div class='form_field'>
                                    <?php echo form_input(array(
                                            'name'=>'name',
                                            'id'=>'name',
                                            'style'=>'width:430px',
                                            'value'=>$item_info->name)
                                    );?>
                                    </div>
                            </div>
                            <div class="field_row clearfix">
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px"><?php echo lang('news_category_name_en') ?> :</label>
                                    <div class='form_field'>
                                    <?php echo form_input(array(
                                            'name'=>'en_name',
                                            'id'=>'en_name',
                                            'style'=>'width:230px',
                                            'value'=>$item_info->en_name)
                                    );?>
                                    </div>
                            </div>

                            <div class="field_row clearfix">
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px"><?php echo lang('news_category_active') ?> :</label>
                                <div class='form_field'>
                                <?php
                                echo form_checkbox(array(
                                    'name' => 'active',
                                    'id'   => 'active',
                                    'type' => 'checkbox'
                                    ), true, $item_info->active
                                );
                                ?>
                                </div>
                            </div>

                              <?php echo form_submit(array(
                                'value' => lang('common_submit'),
                                'style' => 'margin-right: 109px; margin-bottom: 20px',
                                'class' => 'submit_button float_right'
                            ));
                            ?>
                            <!--<ul id="error_message_box"></ul>-->
                            <?php
                            echo form_close();
                            ?>
                            </fieldset>
                        </div>
                    </div>

                </td>
            </tr>
        </table>

        <script type='text/javascript'>

        //validation and submit handling
        $(document).ready(function()
        {
            //CKEDITOR.replace( 'mail_content' );
            setTimeout(function(){$(":input:visible:first","#news_category_form").focus();},100);
            var submitting = false;
            $('#news_category_form').validate({
                submitHandler:function(form){
                    if (submitting) return;
                    submitting = true;
                    $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                    $(form).ajaxSubmit({
                        success:function(response){
                            submitting = false;
                            tb_remove();
                            window.location.href = "<?php echo base_url()?>news_category";
                        },
                        dataType:'html'
                    });
                },
                errorLabelContainer: "#error_message_box",
                wrapper: "li",
                rules: {
                    name: "required",
                },
                messages: {
                    title: "Bạn phải nhập tên danh mục tin"
                }
            });
        });
        </script>
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>
