<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url()?>public/ckeditor/ckeditor.js" type="text/javascript"></script>

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
                            
                            <?php echo form_open('items/save_update/' . $item_info->item_id, array('id' => 'item_form'));?>
                            
                            <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Chi tiết sản phẩm :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'details',
                                            'id'=>'details',
                                            'class' => 'ckeditor',
                                            'value'=>$item_info->details)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("details");
                                    </script>
                                    </div>
                            </div>
                            
                            <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">CTSP(English) :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'en_details',
                                            'id'=>'en_details',
                                            'class' => 'ckeditor',
                                            'value'=>$item_info->en_details)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("en_details");
                                    </script>
                                    </div>
                            </div>
                            
                             <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Thông số kỹ thuật :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'technical',
                                            'id'=>'technical',
                                            'class' => 'ckeditor',
                                            'value'=>$item_info->technical)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("technical");
                                    </script>
                                    </div>
                            </div>
 <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">TSKT(English):</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'en_technical',
                                            'id'=>'en_technical',
                                            'class' => 'ckeditor',
                                            'value'=>$item_info->en_technical)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("en_technical");
                                    </script>
                                    </div>
                            </div>
                            
                              <?php echo form_submit(array(
                                'value' => lang('common_submit'),
                                'style' => 'margin-right: 109px; margin-bottom: 20px',
                                'class' => 'submit_button float_right'
                            ));
                            ?>
                         
    <?php echo form_close();?>
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
            setTimeout(function(){$(":input:visible:first","#customer_mail_form").focus();},100);
            var submitting = false;
            $('#customer_mail_form').validate({
                submitHandler:function(form){
                    if (submitting) return;
                    submitting = true;
                    $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                    $(form).ajaxSubmit({
                        success:function(response){	
                            //CKEDITOR.replace( 'mail_content' );
                            submitting = false;
                            tb_remove();
                            window.location.href = "<?php echo base_url()?>news";                            
                            set_feedback(response.message,'success_message',true);
                        },
                        dataType:'html'
                    });
                },
                errorLabelContainer: "#error_message_box",
                wrapper: "li",
                rules: {	                                   
                    title: "required",
                    description: "required",
                    full: "required",
                    source :"required"
                },
                messages: {
                    title: "Bạn phải nhập tiêu đề tin",
                    description: "Bạn phải nhập mô tả",
                    full: "Bạn phải nhập nội dung tin",
                    source: "Bạn phải nhập nguồn tin"
                }
            });
        });
        </script>
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>