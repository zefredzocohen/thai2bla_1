<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js"
type="text/javascript"></script>
<?php
echo form_open('admin_agent/save/' . $person_info->person_id, array('id' => 'customers_form'));
?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?><br>
    <strong>(Lưu ý :Trường Email và Mật khẩu dùng để đăng nhập hệ thống đại lý)</strong>
</div>
<ul id="error_message_box"></ul>
<table>
    <tr>
        <td>
            <fieldset id="customer_basic_info" style="width: 360px; height: 450px;">
                <legend><?php echo lang("customers_individual_information"); ?></legend>
                <input type="hidden" name="person_id" value="<?php echo $person_info->person_id; ?>" id="person_id">
                <div class="field_row clearfix"><?php echo form_label('Họ tên đệm (*):', 'first_name', array('class' => 'wide required')); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'first_name',
                            'id' => 'first_name',
                            'value' => $person_info->first_name)
                        );
                        ?></div>
                </div>
                <div class="field_row clearfix"><?php echo form_label('Tên (*):', 'last_name', array('class' => 'wide required')); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'last_name',
                            'id' => 'last_name',
                            'value' => $person_info->last_name)
                        );
                        ?></div>
                </div>

                <div class="field_row clearfix"><?php echo form_label('Mã đại lý (*):', 'code_customer', array('class' => 'wide required')); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'code_customer',
                            'id' => 'code_customer',
                            'value' => $person_info->code_customer)
                        );
                        ?></div>
                </div>

                <!-- phan lam loai khach hang --> <?php
                $this->load->model('Agent_model');
                $type_customers = $this->Agent_model->get_Customer_type();
                ?>
<?php if ($person_info->person_id != null) { ?>
                    <div class="field_row clearfix"><?php echo form_label(lang('customer_type') . ' :', 'customer_type'); ?>
                        <div class='form_field'><select name="customer_type">
                                <?php foreach ($type_customers as $type_customer) { ?>
        <?php if ($person_info->type_customer == $type_customer['customer_type_id']) { ?>
                                        <option value="<?php echo $type_customer['customer_type_id']; ?>"
                                                selected="selected"><?php echo $type_customer['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $type_customer['customer_type_id']; ?>"><?php echo $type_customer['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select></div>
                    </div>
<?php } else { ?>
                    <div class="field_row clearfix"><?php echo form_label(lang('customer_type') . ' :', 'customer_type'); ?>
                        <div class='form_field'><select name="customer_type">
                                <?php foreach ($type_customers as $type_customer) { ?>
                                    <option value="<?php echo $type_customer['customer_type_id']; ?>"><?php echo $type_customer['name']; ?></option>
    <?php } ?>
                            </select></div>
                    </div>
<?php } ?>

                <div class="field_row clearfix"><?php echo form_label('Đại lý giới thiệu' . ':', 'email'); ?>
                    <div class='form_field'>
                   <?php
                           $this->load->model('Agent_model');
                           $agent = $this->Agent_model->agent();
                           $agent1 = $this->Agent_model->agent1();

                           if ($this->Agent_model->get_info($person_info->person_id)->agent == 0) {
                               $parent = '';
                           } else {
                               foreach ($agent as $agent_id) {
                                   foreach ($agent1 as $agent_id1) {
                                       if ($agent_id['agent'] == $agent_id1['person_id']) {
                                           $id = $this->Agent_model->get_info($person_info->person_id)->agent;
                                           if ($agent_id1['person_id'] == $id) {
                                               $parent = $this->Agent_model->get_info($id)->code_customer;
                                           }
                                       }
                                   }
                               }
                           }
                   
                        echo form_input(array(
                            'name' => 'agent_input',
                            'id' => 'agent_input',
                            'size' => '30',
                            'placeholder' => 'Nhập mã đại lý giới thiệu...',
                            'style' => 'height:26px',
                            'value' => isset($parent) ? $parent :'',
                        ));
                        ?> 
                        <table id="row_selected">
                        </table>
                    </div>
                </div>

                <div class="field_row clearfix"><?php echo form_label(lang('common_email') . ':', 'email'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'email',
                            'id' => 'email',
                            'value' => $person_info->email)
                        );
                        ?></div>
                </div>

                <div class="field_row clearfix"><?php echo form_label('Mật khẩu' . ':', 'email'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'type' => 'password',
                            'name' => 'password',
                            'id' => 'password')
                        );
                        ?></div>
                </div>

                <div class="field_row clearfix"><?php echo form_label(lang('common_phone_number') . ':', 'phone_number', array('class' => 'wide')); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'phone_number',
                            'id' => 'phone_number',
                            'value' => $person_info->phone_number));
                        ?></div>
                </div>
                <!--		<div class="field_row clearfix"><?php //echo form_label('Chức vụ' . ':', 'positions');  ?>
                                <div class='form_field'><?php
                //echo form_input(array(
//                            'name' => 'positions',
//                            'id' => 'positions',
//                            'value' => $person_info->positions)
//		);
                ?></div>
                                </div>-->

                <div class="field_row clearfix"><?php echo form_label(lang('common_address_1') . ':', 'address_1'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'address_1',
                            'id' => 'address_1',
                            'value' => $person_info->address_1));
                        ?></div>
                </div>
                <!-- phan lam ngay sinh khach hang -->
                <div class="field_row clearfix"><?php echo form_label(lang('common_birth_date') . ':', 'birth_date'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'birth_date',
                            'id' => 'birth_date',
                            'value' => $person_info->birth_date != '1950-01-01' ? date(get_date_format(), strtotime($person_info->birth_date != '' ? $person_info->birth_date : date('d-m-Y'))) : ''
                                )
                        )
                        ;
                        ?></div>
                </div>
<?php if ($person_info->sex != null) { ?>
                    <div class="field_row clearfix"><?php echo form_label('Giới tính:', 'sex', array('class' => '')); ?>
                        <div class='form_field'><select name="sex">
    <?php if ($person_info->sex == 1) { ?>
                                    <option value="1" selected="selected">Nam</option>
                                    <option value="2">Nữ</option>
    <?php } else { ?>
                                    <option value="1">Nam</option>
                                    <option value="2" selected="selected">Nữ</option>
    <?php } ?>
                            </select></div>
                    </div>
<?php } else { ?>
                    <div class="field_row clearfix"><?php echo form_label('Giới tính:', 'sex', array('class' => '')); ?>
                        <div class='form_field'><select name="sex">
                                <option value="1">Nam</option>
                                <option value="2">Nữ</option>
                            </select></div>
                    </div>
<?php } ?> 


                <!-- phan lam city --> 
                <?php
//                $this->load->model('City');
//                $info_city = $this->City->get_info($person_info->city);
                //if($info_city->type == 0){
                ?>
                <!--			<label style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="type" id="radio_city" value="0" checked="checked">Việt Nam&nbsp;</label>
                                        
                                        <label style="">
                                        <input type="radio" name="type" id="radio_world" value="1">&nbsp;&nbsp;Quốc tế</label>-->
<?php //}else{ ?>
                <!--			<label style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="type" id="radio_city" value="0" >Việt Nam&nbsp;</label>
                                        
                                        <label style="">
                                        <input type="radio" name="type" id="radio_world" value="1" checked="checked">&nbsp;&nbsp;Quốc tế</label>-->

<?php //} ?>

                <!--		<div id="city">
<?php //if ($person_info->person_id != null) {  ?>
                                        <div class="field_row clearfix"><?php //echo form_label(lang('common_city') . ':', 'city');  ?>
                                        <div class='form_field'>
                                                <select name="city">
                                                        <option value="">Chọn thành phố</option>
                                                       
                <?php //foreach ($option as $op) { 
                ?>
                <?php //if ($person_info->city == $op['id_city']) {  ?>
                                                        <option value="<?php //echo $op['id_city']; ?>" selected="selected"><?php echo $op['name']; ?></option>
                <?php //} else {  ?>
                                                        <option value="<?php //echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
                <?php
//					}                              
//					}
                ?>
                                                </select>
                                                </div>
                                        </div>
<?php //} else {  ?>
                                        <div class="field_row clearfix"><?php //echo form_label(lang('common_city') . ':', 'city');  ?>
                                        <div class='form_field'>
                                                <select name="city">
                                                        <option value="">Chọn thành phố</option>
                <?php //foreach ($option as $op) { 
                ?>
                                                        <option value="<?php //echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
<?php //}  ?>
                                                </select>
                                                </div>
                                        </div>
<?php //}  ?>
                                </div>-->

                <!--		<div id="world" style="display: none;">
<?php // if ($person_info->person_id != null) {  ?>
                                        <div class="field_row clearfix"><?php /// echo form_label('Đất nước :', 'world');  ?>
                                        <div class='form_field'>
                                                <select name="world">
                                                        <option value="">Chọn đất nước</option>
                <?php //foreach ($option2 as $op) { ?>
                <?php //if ($person_info->city == $op['id_city']) {  ?>
                                                        <option value="<?php //echo $op['id_city']; ?>" selected="selected"><?php //echo $op['name']; ?></option>
                <?php // } else {  ?>
                                                        <option value="<?php // echo $op['id_city']; ?>"><?php //echo $op['name']; ?></option>
                <?php
//					}
//					}
                ?>
                                                </select>
                                                </div>
                                        </div>
<?php //} else {  ?>
                                        <div class="field_row clearfix"><?php //echo form_label('Đất nước :', 'world');  ?>
                                        <div class='form_field'>
                                                <select name="world">
                                                        <option value="">Chọn đất nước</option>
                <?php //foreach ($option2 as $op) {  ?>
                                                        <option value="<?php //echo $op['id_city']; ?>"><?php echo $op['name']; ?></option>
<?php //}  ?>
                                                </select>
                                                </div>
                                        </div>
<?php //}  ?>
                                </div>
                -->


                <!--		<div class="field_row clearfix"><?php //echo form_label('Chồng / Vợ con :');  ?>
                                <div class='form_field'><?php
//		echo form_textarea(array(
//                            'name' => 'wife',
//                            'id' => 'wife',
//                            'style' => 'width:185px;height:30px;',
//                            'value' => $person_info->wife,
//                            'rows' => '8',
//                            'cols' => '17')
//		);
                ?></div>
                                </div>-->
                <?php
//		if ($this->session->userdata('person_id') == 1) {
//			
                ?>
                <!--		<div class="field_row clearfix">//////<?php echo form_label('Nhân viên quản lý'); ?>
                                <div class="form_filed"><select name="employee"
                                        style="padding-left: 5px;">-->
                <?php
//			$employees = $this->Employee->get_list_employee();
//			foreach ($employees as $emp) {
//				if ($person_info->employee_id == $emp['person_id']) {
//					echo "<option style='padding: 2px 0px 2px 5px;' selected='selected' value='" . $emp['person_id'] . "'>" . $emp['first_name'] . " " . $emp['last_name'] . "</option>";
//				} else {
//					echo "<option style='padding: 2px 0px 2px 5px;' value='" . $emp['person_id'] . "'>" . $emp['first_name'] . " " . $emp['last_name'] . "</option>";
//				}
//			}
//			
                ?>
                <!--		</select></div>
                                </div>-->
                <?php
//		} else {
//			echo "";
//		}
                ?>
            </fieldset>
        </td>
        <td>
            <fieldset id="customer_basic_info" style="width: 360px; height: 450px;">
                <legend><?php echo lang("customers_enterprise_information"); ?></legend>

                <div class="field_row clearfix"><?php echo form_label('Tên đại lý' . ' :', 'company_name'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'company_name',
                            'id' => 'customer_company_name',
                            'value' => $person_info->company_name)
                        );
                        ?></div>
                </div>
                <!--
                <div class="field_row clearfix">	
                <?php echo form_label('Chức vụ' . ':', 'manages_name'); ?>
                    <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'positions',
                    'id' => 'positions',
                    'value' => $person_info->positions)
                );
                ?>
                    </div>
                </div>-->
                <div class="field_row clearfix"><?php echo form_label('Người đại diện' . ':', 'manages_name'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'manages_name',
                            'id' => 'manages_name',
                            'value' => $person_info->manages_name
                        ));
                        ?></div>
                </div>


                <div class="field_row clearfix"><?php echo form_label(lang('phone') . ':', 'phone'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'phone',
                            'id' => 'phone',
                            'class' => 'input',
                            'value' => $person_info->phone
                        ));
                        ?></div>
                </div>

                <!--		<div class="field_row clearfix"><?php //echo form_label('Sinh nhật công ty' . ' :', 'birth_date_1'); ?>
                                <div class='form_field'><?php
//		echo form_input(array(
//                            'name' => 'birth_date_1',
//                            'id' => 'birth_date_1',
//                            'value' => $person_info->birth_date_1 != '1950-01-01' ? date(get_date_format(), strtotime($person_info->birth_date_1 != '' ? $person_info->birth_date_1 : date('d-m-Y'))) : ''
//                            )
//                            )
//                            ;
                ?></div>
                                </div>-->



                <div class="field_row clearfix"><?php echo form_label(lang('customers_account_number') . ':', 'account_number'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'account_number',
                            'id' => 'account_number',
                            'value' => $person_info->account_number)
                        );
                        ?></div>
                </div>

                <div class="field_row clearfix"><?php echo form_label('Mã số thuế' . ':', 'code_tax'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'code_tax',
                            'id' => 'code_tax',
                            'value' => $person_info->code_tax)
                        );
                        ?></div>
                </div>

                <!--		<div class="field_row clearfix"><?php //echo form_label(lang('customers_taxable') . ':', 'taxable');  ?>
                                <div class='form_field'><?php //echo form_checkbox('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean) $person_info->taxable);  ?>
                                </div>
                                </div>-->
                <input type="hidden" name="certify" id="certify" value="0">
                <div class="field_row clearfix"><?php echo form_label(lang('common_comments') . ':', 'comments'); ?>
                    <div class='form_field'><?php
                        echo form_textarea(array(
                            'name' => 'comments',
                            'id' => 'comments',
                            'value' => $person_info->comments,
                            'rows' => '5',
                            'cols' => '17')
                        );
                        ?></div>
                </div>
                <div class="field_row clearfix"><?php echo form_label('Hạn mức công nợ:', 'debt'); ?>
                    <div class='form_field'><?php
                        echo form_input(array(
                            'name' => 'debt',
                            'id' => 'debt',
                            'value' => str_replace(array('.00'), '', (to_currency_unVND($person_info->debt))),
                            'rows' => '5',
                            'cols' => '17')
                        );
                        ?></div>
                </div>
<?php
if ($person_info->status_register == 1) {
    ?>
                    <div class="field_row clearfix"><?php echo form_label('Kích hoạt tài khoản:', 'debt'); ?>
                        <div class='form_field'><?php
                            echo form_checkbox(array(
                                'name' => 'status_register',
                                'id' => 'status_register',
                                'value' => 'status_register',
                                'checked' => 'checked'));
                            ?></div>
                    </div>
                        <?php } else { ?>
                    <div class="field_row clearfix"><?php echo form_label('Kích hoạt tài khoản:', 'debt'); ?>
                        <div class='form_field'><?php
                            echo form_checkbox(array(
                                'name' => 'status_register',
                                'id' => 'status_register',
                                'value' => 'status_register',
                                'checked' => $this->input->post('status_register')));
                            ?></div>
                    </div>
<?php } ?>
            </fieldset>
        </td>
    </tr>
</table>
<fieldset style="border: none;"><?php
    echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'style' => 'margin-right: 29px;  ',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    ?></fieldset>

<?php
echo form_close();
?>
<?php $this->load->view("partial/abouts"); ?>
<script type='text/javascript'>
            //validation and submit handling
            $(document).ready(function(){
    $('#birth_date_1').datePicker({startDate: '01-01-1950'});
            $("#debt").maskMoney();
            setTimeout(function() {
            $(":input:visible:first", "#customers_form").focus();
            }, 100);
            $(".module_checkboxes").change(function(){
    if ($(this).attr('checked')){
    $(this).parent().find('input[type=checkbox]').attr('checked', 'checked');
    } else{
    $(this).parent().find('input[type=checkbox]').attr('checked', '');
    }
    });
            var submitting = false;
            $('#customers_form').validate({
    submitHandler: function(form) {
    if (submitting)
            return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
    success: function(response){
    tb_remove();
            post_person_form_submit(response);
            submitting = false;
    },
            dataType: 'json'
    });
    },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:{
            company_name:{
            required:true,
            },
                    code_customer:{
                    required:true,
                                    remote:
                            {
                            url: "<?php echo site_url('admin_agent/check_name_code/' . $person_info->person_id); ?>",
                                    type: "post"
                            }
                    },
                    first_name:{
                    required:true,
                    },
                    last_name: "required",
                    phone_number: {
                    remote:{
                    url: "<?php echo site_url('customers/phone_number_exists'); ?>",
                            type: "post",
                            data:{
                            person_id: function(){
                            return $("#person_id").val();
                            }
                            }
                    }
                    },
                    username:{
<?php if (!$person_info->person_id) { ?>
                        remote:{
                        url: "<?php echo site_url('employees/exmployee_exists'); ?>",
                                type: "post"
                        },
<?php } ?>
                    required:true,
                            minlength: 5
                    },
                    password:{
<?php if ($person_info->person_id == "") { ?>
                        required:true,
<?php } ?>
                    minlength: 8
                    },
                    repeat_password:{
                    equalTo: "#password"
                    },
                    email: "email"
            },
            messages:{
            company_name:{
            required: 'Vui lòng nhập tên đại lý',
            },
                    code_customer:{
                    required: 'Vui lòng nhập mã đại lý',
                            remote: 'Mã đại lý đã tồn tại, vui lòng chọn mã khác'
                    },
                    password:{
                    required: 'Vui lòng nhập mật khẩu',
                    },
                    first_name:{
                    required: 'Vui lòng nhập họ tên đệm',
                    },
                    last_name: 'Vui lòng nhập tên',
                   
                    phone_number:{
                    remote: 'Số điện thoại đã được sử dụng',
                    },
                    username:{
<?php if (!$person_info->person_id) { ?>
                        remote: <?php echo json_encode(lang('employees_username_exists')); ?>,
<?php } ?>
                    required: <?php echo json_encode(lang('employees_username_required')); ?>,
                            minlength: <?php echo json_encode(lang('employees_username_minlength')); ?>
                    },
                    password:{
<?php if ($person_info->person_id == "") { ?>
                        required:<?php echo json_encode(lang('employees_password_required')); ?>,
<?php } ?>
                    minlength: <?php echo json_encode(lang('employees_password_minlength')); ?>
                    },
                    repeat_password:{
                    equalTo: <?php echo json_encode(lang('employees_password_must_match')); ?>
                    },
                    email: <?php echo json_encode(lang('common_email_invalid_format')); ?>
            }
    });
            //hung audi 10-4-15
            if ($("#radio_city").is(':checked')) {
    $("#city").css({'display':'block'});
            $("#world").css({'display':'none'});
    } else{
    $("#world").css({'display':'block'});
            $("#city").css({'display':'none'});
    }


    $("#radio_world").click(function () {
    if ($("#radio_world").is(':checked')) {
    $("#world").css({'display':'block'});
            $("#city").css({'display':'none'});
    }
    });
            $("#radio_city").click(function () {
    if ($("#radio_city").is(':checked')) {
    $("#city").css({'display':'block'});
            $("#world").css({'display':'none'});
    }
    });
            $('#phone').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    });
</script>

<style type="text/css">
    .disable_input_cost {
        display: none;
    }
</style>

<script type="text/javascript" language="javascript">

     $("#agent_input").autocomplete({
        source: '<?php echo site_url("admin_agent/suggest_code"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#agent_input").val("");
            if ($("#row_selected" + ui.item.value).length == 1) {
                $("#row_selected" + ui.item.value).val(parseFloat($("#row_selected" + ui.item.value).val()) + 1);
            } else {
                $("#agent_input").addClass("disable_input_cost");
                $("#row_selected").append("<tr><td width='300px'>" + ui.item.label + "</td><td><a href='#' style='text-decoration: underline;margin-left:-130px;color:blue' onclick='return deleteRow(this);'>Xóa</a></td><td><input type='hidden' size='3' id='agent' name='agent' value='" + ui.item.value + "'/></td></tr>");
                $.post('<?php echo site_url("admin_agent/set_agent"); ?>', {agent: $('#agent').val()});
            }

            return false;
        }
    });

    function deleteRow(link) {
        $("#agent_input").removeClass("disable_input_cost");
        $(link).parent().parent().remove();
        return false;
    }
</script>