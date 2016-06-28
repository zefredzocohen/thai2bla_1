<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url() ?>public/ckeditor/ckeditor.js" type="text/javascript"></script>
<div id="content_area_wrapper">
    <fieldset id="customer_basic_info" style="border: none">
        <legend style="font-size: 14px;font-weight: bold"><?php echo "Nhập thông tin để gửi mail"; ?></legend>
        <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
        <div id="content_area" style="color:#000;">
            <table id="contents">
                <tr>
                    <td id="commands">
                        <div id="new_button">
                            <?php
                            echo anchor("customers/manage_mail", 'Danh sách mail', array('class' => 'none new', 'title' => 'Danh sách mail'));
                            ?>

                        </div>
                    </td>
                    <td style="width:10px;"></td>
                    <td>
                        <ul id="error_message_box" style="font-size: 12px; margin-bottom: 15px;"></ul>
                        <div id="item_table">
                            <div id="table_holder">
<?php
echo form_open('customers/save_mail/' . $mail_info->mail_id, array('id' => 'customer_mail_form'));
?>
                                <div class="field_row clearfix">	
                                    <label style="display: inline-block;text-indent:-1px; width: 65px;">Ghi chú :</label>
                                    <span style="font-size: 12px; font-style: italic; font-weight: initial;">(Dùng các từ gợi ý dưới đây để thay thế cho các từ ngữ tương ứng)</span>
                                    <div class="clearfix"></div>
                                    <style>
                                        .note_one{
                                            font-weight: normal !important;font-size: 0.77em;
                                            margin-top: 10px;
                                            width: 245px;
                                            float: left;
                                            margin-left: 2px;                                
                                        }
                                        .note_one p{
                                            display: block;
                                            margin-top: 3px;
                                        }                            
                                    </style> 
                                    <div class="note_one">
                                        <strong>Khách hàng</strong>                                   
                                        <p>__FIRST_NAME__ = <strong>HỌ</strong></p>                            
                                        <p>__LAST_NAME__ = <strong>TÊN</strong></p>                             
                                        <p>__PHONE_NUMBER__ = <strong>SỐ ĐIỆN THOẠI</strong></p>                           
                                        <p>__EMAIL__ = <strong>EMAIL</strong></p>
                                        <p>__COMPANY_CUSTOMER__ = <strong>TÊN CÔNG TY</strong></p>
                                    </div>   
                                    <div class="note_one">        
                                        <strong>Nhân viên</strong>                                   
                                        <p>__FIRST_NAME_EMPLOYEE__ = <strong>HỌ</strong></p>
                                        <p>__LAST_NAME_EMPLOYEE__ = <strong>TÊN</strong></p>                                  
                                        <p>__PHONE_NUMBER_EMPLOYEE__ = <strong>SỐ ĐIỆN THOẠI</strong></p>
                                        <p>__EMAIL_EMPLOYEE__ = <strong>EMAIL</strong></p>
                                    </div>
                                    <div class="note_one">
                                        <strong>Công ty</strong>
                                        <p>__NAME_COMPANY__ = <strong>TÊN</strong></p>
                                        <p>__ADDRESS_COMPANY__ = <strong>ĐỊA CHỈ</strong></p>
                                        <p>__EMAIL_COMPANY__ = <strong>EMAIL</strong></p>
                                        <p>__FAX_COMPANY__ = <strong>FAX</strong></p>
                                        <p>__WEBSITE_COMPANY__ = <strong>WEBSITE</strong></p>
                                    </div>
                                    <div class="note_one">
                                        <strong>Hợp đồng</strong>
                                        <p>__NAME_CONTRACT__ = <strong>TÊN HĐ</strong></p>
                                        <p>__NUMBER_CONTRACT__ = <strong>SỐ HĐ</strong></p>
                                        <p>__START_DATE__ = <strong>NGÀY KÝ</strong></p>
                                        <p>__EXPIRATION_DATE__ = <strong>NGÀY HẾT HẠN</strong></p>
                                    </div>  
                                    <div class="clear"></div>
                                </div>
                                <div class="field_row clearfix">
                                    <label class="required" style="margin-top: 5px;">Tiêu đề gửi mail :</label>
                                    <div class='form_field'>
<?php
echo form_input(array(
    'name' => 'mail_title',
    'id' => 'mail_title',
    'style' => 'width:230px',
    'value' => $mail_info->mail_title)
);
?>
                                    </div>
                                </div>
                                <div class="field_row clearfix">
                                    <label class="required" style="margin: 5px 0px;">Nội dung gửi mail :</label>
                                    <div class="clearfix"></div>
                                    <div class='form_field'>
                                        <?php
                                        echo form_textarea(array(
                                            'name' => 'mail_content',
                                            'id' => 'mail_content',
                                            'class' => 'ckeditor',
                                            'value' => $mail_info->mail_content)
                                        );
                                        ?>
<?php echo display_ckeditor($ckeditor); ?>
                                    </div>
                                </div>

                                <?php
                                echo form_hidden('row_id', $mail_info->mail_id);
                                echo form_submit(array(
                                    'name' => 'submit',
                                    'id' => 'submit',
                                    'style' => 'margin-right:10px',
                                    'value' => lang('common_submit'),
                                    'class' => 'submit_button float_right')
                                );
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
                $(document).ready(function ()
                {
                    //CKEDITOR.replace( 'mail_content' );
                    setTimeout(function () {
                        $(":input:visible:first", "#customer_mail_form").focus();
                    }, 100);
                    var submitting = false;
                    $('#customer_mail_form').validate({
                        submitHandler: function (form) {
                            if (submitting)
                                return;
                            submitting = true;
                            //$(form).mask(<?//php echo json_encode(lang('common_wait')); ?>);
                            $(form).ajaxSubmit({
                                success: function (response) {
                                    //CKEDITOR.replace( 'mail_content' );
                                    //submitting = false;
                                    //tb_remove();
                                    alert('Thao tác thành công!');
                                    window.location.href = "<?php echo base_url() ?>customers/manage_mail";
                                    //set_feedback(response.message, 'success_message', true);
                                },
                                dataType: 'html'
                            });
                        },
                        errorLabelContainer: "#error_message_box",
                        wrapper: "li",
                        rules: {
                            mail_title: "required",
                            mail_content: {
                                required: function () {
                                    CKEDITOR.instances.mail_content.updateElement();
                                },
                            }
                        },
                        messages: {
                            mail_title: "Bạn phải nhập tiêu đề",
                            mail_content: "Bạn phải nhập nội dung",
                        }
                    });
                });
            </script>
        </div>
</div>
<?php $this->load->view("partial/footer"); ?>