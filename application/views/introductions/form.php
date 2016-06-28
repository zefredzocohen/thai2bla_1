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
                            <?php
                            echo form_open('introductions/save/'.$support_info->id,array('id'=>'customer_mail_form'));
                            ?>
                            <div class="field_row clearfix">
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px">Tiêu đề :</label>
                                    <div class='form_field'>
                                    <?php echo form_input(array(
                                            'name'=>'title',
                                            'id'=>'title',
                                            'style'=>'width:230px',
                                            'value'=>$support_info->title)
                                    );?>
                                    </div>
                            </div>
                            <div class="field_row clearfix">
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px">Tiêu đề(English) :</label>
                                    <div class='form_field'>
                                    <?php echo form_input(array(
                                            'name'=>'en_title',
                                            'id'=>'en_title',
                                            'style'=>'width:230px',
                                            'value'=>$support_info->en_title)
                                    );?>
                                    </div>
                            </div>
                            <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Mô tả :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'description',
                                        'id'=>'description',
                                        'style'=>'width:919px',
                                         'class' => 'ckeditor',
                                           'value'=>$support_info->description)
                                    );?>
                               <script type="text/javascript">
                                           //CKEDITOR.replace( 'description' );
                                           $(document).ready(function(){
                            $("textarea#ckeditor").ckeditor(function(){}, { resize_enabled : false });});
                                           var content = $j('#description').val();
                                      var content = CKEDITOR.instances.CMSeditor.getData();
                               </script>
                                    </div>
                            </div>
                            <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Mô tả(English) :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                        
                                    <?php echo form_textarea(array(
                                            'name'=>'en_description',
                                            'id'=>'en_description',
                                        'style'=>'width:919px',
                                          'class' => 'ckeditor',
                                            'value'=>$support_info->en_description)
                                    );?>
                                    <script type="text/javascript">
                                      $(document).ready(function(){
                            $("textarea#ckeditor").ckeditor(function(){}, { resize_enabled : false });});
                                           var content = $j('#en_description').val();
                                      var content = CKEDITOR.instances.CMSeditor.getData();
                                   
                                    </script>
                                  
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
            setTimeout(function(){$(":input:visible:first","#customer_mail_form").focus();},100);
            var submitting = false;
            $('#customer_mail_form').validate({
                submitHandler:function(form){
                    if (submitting) return;
                    submitting = true;
                    $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                    $(form).ajaxSubmit({
                        success:function(response){	
                            alert ('Lưu thành công giới thiệu !');
                            //CKEDITOR.replace( 'mail_content' );
                            submitting = false;
                            tb_remove();
                            window.location.href = "<?php echo base_url()?>introductions";                            
                           // set_feedback(response.message,'success_message',true);
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