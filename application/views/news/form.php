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
                            echo form_open('news/save/'.$support_info->id,array('id'=>'customer_mail_form'));
                            ?>
                            <div class="field_row clearfix">
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px">Tiêu đề tin :</label>
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
                                <label style="display: inline-block;height:30px;line-height:24px;text-indent: -1px;margin-bottom: 10px;width:130px">Tiêu đề tin(English) :</label>
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
                                            'class' => 'ckeditor',
                                            'value'=>$support_info->description)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("description");
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
                                            'class' => 'ckeditor',
                                            'value'=>$support_info->en_description)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("en_description");
                                    </script>
                                    </div>
                            </div>
                            <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Nội dung :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'full',
                                            'id'=>'full',
                                            'class' => 'ckeditor',
                                            'value'=>$support_info->full)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("full");
                                    </script>
                                    </div>
                            </div>

                            <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Nội dung(English) :</label>
                            <div class="clearfix"></div>
                                    <div class='form_field'>
                                    <?php echo form_textarea(array(
                                            'name'=>'en_full',
                                            'id'=>'en_full',
                                            'class' => 'ckeditor',
                                            'value'=>$support_info->en_full)
                                    );?>
                                    <script type="text/javascript">
                                        CKEDITOR.replace("en_full");
                                    </script>
                                    </div>
                            </div>

                             <!--- phan lam anh -->
                <?php echo form_label('Ảnh đại diện' . ':', 'item_image', array('class' => 'wide')); ?>
                <div class="input_file" style="">
                    <?php echo form_input(array(
                        'name' => 'img',
                        'id' => 'img',
                        'type' => 'file'
                    ));
                    ?>
                </div>

                <div class="field_row clearfix">
                    <?php if ($support_info->images == null) { ?>
                        <div class="" style="border: none">
                            <div class='form_field'>
                                <img src="<?php echo base_url() . 'news_title/news-icon.jpg' ?>" style="width:150px; height:150px" />
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="field_row clearfix" style="border-bottom:none">
                            <div class='form_field'>
                                <img src="<?php echo base_url() . 'news_title/' . $support_info->images ?>" style="width:150px; height:150px" />
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- end phan lam anh -->


                        <div class="field_row clearfix">
                        <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Nguồn tin :</label>
                        <div class="clearfix"></div>
                                <div class='form_field'>
                                  <?php echo form_input(array(
                                            'name' => 'source',
                                            'id' => 'source',
                                            'type' => 'text',
                                            'value'=>$support_info->source
                                        ));
                                        ?>
                                </div>
                        </div>

                        <div class="field_row clearfix">
                            <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Danh mục tin:</label>

                        <div class="clearfix"></div>
                            <div class='form_field'>
                                <?php echo form_dropdown('category_id', $news_category, $support_info->category_id); ?>
                            </div>
                        </div>

                        <div class="field_row clearfix">
                        <label style="display: block;height:30px;line-height:30px;text-indent: -1px;margin-bottom: 10px">Cho phép hiển thị :</label>
                        <div class="clearfix"></div>
                                <div class='form_field'>
                                  <?php echo form_checkbox(array(
                                            'name' => 'active',
                                            'id' => 'active',
                                            'type' => 'checkbox'
                                        ), true, $support_info->active);
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
        setTimeout(function(){$(":input:visible:first","#customer_mail_form").focus();},100);
        var submitting = false;
        $('#customer_mail_form').validate({
            submitHandler:function(form){
                if (submitting) return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success:function(response){
                        alert("Thêm mới tin tức thành công !");
                        //CKEDITOR.replace( 'mail_content' );
                        submitting = false;
                        tb_remove();
                        window.location.href = "<?php echo base_url()?>news";
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
