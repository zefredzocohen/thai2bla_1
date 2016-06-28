  <?php
    echo form_open_multipart('contractcustomer/save/' . $item_info->id, array('id' => 'contractcustomers_form'));
    ?>
    <div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
    <ul id="error_message_box"></ul>  
    <fieldset id="item_basic_info">
        <legend><?php echo lang("contractcustomer_information"); ?></legend>


        <div class="field_row clearfix">
            <?php echo form_label(lang('contractcustomer_name') . ':', 'name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'contractcustomer_name',
                    'id' => 'contractcustomer_name',
                    'value' => $item_info->name)
                );
                ?>
            </div>
        </div>
         <?php if($item_info->person_id!=null){
		$items_info = $this->Customer->get_info($item_info->person_id);
		?>
        <div class="field_row clearfix">
            <?php echo form_label('Tên khách hàng', 'type_sup', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(
                        array(
                            'name' => 'type_sup',
                            'id' => 'type_sup',
                            'value' => $items_info->first_name." ".$items_info->last_name
                        )
                );
                ?>
            </div>
        </div>
		<?php } else {?>
		 <div class="field_row clearfix">
            <?php echo form_label('Tên khách hàng', 'type_sup', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(
                        array(
                            'name' => 'type_sup',
                            'id' => 'type_sup',
                            'value' => $item_info->person_id
                        )
                );
                ?>
            </div>
        </div>
		<?php }?>
        <input type="hidden" id="name_customer" name="name_customer" value="" />
        <input type="hidden" name="id_sup1" id="value_person_id" value="">

        <div class="field_row clearfix">
                <?php echo form_label(lang('contractcustomer_number') . ':', 'name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'contractcustomer_number',
                    'id' => 'contractcustomer_number',
                    'value' => $item_info->number_contract)
                );
                ?>
            </div>
        </div>
        <div class="field_row clearfix">
                <?php echo form_label(lang('contractcustomer_code') . ':', 'name', array('class' => 'required wide')); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'contractcustomer_code',
                    'id' => 'contractcustomer_code',
                    'value' => $item_info->code_contract)
                );
                ?>
            </div>
        </div>
        <div class="field_row clearfix">	
                <?php echo form_label(lang('contract_start_date') . ':', 'contract_start_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'contract_start_date',
                    'id' => 'contract_start_date',
                    'value' => $item_info->start_date != '1950-01-01' ? date(get_date_format(), strtotime($item_info->start_date != '' ? $item_info->start_date : date('d-m-Y'))) : ''
                        )
                )
                ;
                ?>
            </div>
        </div>
        <div class="field_row clearfix">	
                <?php echo form_label(lang('contract_end_date') . ':', 'contract_end_date'); ?>
            <div class='form_field'>
                <?php
                echo form_input(array(
                    'name' => 'contract_end_date',
                    'id' => 'contract_end_date',
                    'value' => $item_info->end_date != '1950-01-01' ? date(get_date_format(), strtotime($item_info->end_date != '' ? $item_info->end_date : date('d-m-Y'))) : ''
                        )
                )
                ;
                ?>
            </div>
        </div>

<?php $contract_type = $this->Contractcustomers->get_Contract_type(); ?>
 <?php if ($item_info->person_id != null) { ?>
 <div class="field_row clearfix">
    <?php echo form_label(lang('contract_type') . ':', 'contract_type'); ?>
                <div class='form_field'>
                    <select name="contract_type">
            <?php foreach ($contract_type as $contract_types) { ?>
                    <?php if ($item_info->catecontract_id == $contract_types['id']) { ?>
                                <option value="<?php echo $contract_types['id']; ?>" selected="selected"><?php echo $contract_types['name']; ?></option>
        <?php } else { ?>
                                <option value="<?php echo $contract_types['id']; ?>"><?php echo $contract_types['name']; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
        <?php } else { ?>
            <div class="field_row clearfix">
    <?php echo form_label(lang('contract_type') . ':', 'contract_type'); ?>
                <div class='form_field'>
                    <select name="contract_type">
    <?php foreach ($contract_type as $contract_types) { ?>
                            <option value="<?php echo $contract_types['id']; ?>"><?php echo $contract_types['name']; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <?php } ?>


        <div class="field_row clearfix"> <?php echo form_label(lang('contract_file') . ':', 'contract_file'); ?>
            
            <?php if($item_info->contract_file == null){?>              
                  <div class='form_field'> <span style="font-size:0.81em;font-style:italic;font-weight: normal;line-height: 22px;">Chưa cập nhật file hợp đồng!</span> </div>
                <?php } else{?>
                <div class='form_field'><a href="<?php echo base_url() . 'file/contract/' . $item_info->contract_file ?>"><?php echo $item_info->contract_file ?></a></div>
                <?php }?>
            <div class='form_field'>
                <input name="contract_file" style="margin-left: 135px;width: 293px;margin-top: 10px;" type="file"/>
            </div>
            <div class='form_field' style="margin-left: 135px;width: 293px;">
                <em><h5>(hỗ trợ kiểu file: .doc, .docx, .pdf, .xls)</h5></em>
            </div>
        </div>

        <div class="field_row clearfix">	
        <?php echo form_label(lang('contract_description') . ':', 'description'); ?>
            <div class='form_field'>
        <?php
        echo form_textarea(array(
            'name' => 'description',
            'id' => 'description',
            'value' => $item_info->description,
            'rows' => '5',
            'cols' => '17')
        );
        ?>
            </div>
        </div>
<?php
echo form_submit(array(
    //'name'=>'submit',
    //'id'=>'submit',
    'value' => lang('common_submit'),
    'class' => 'submit_button float_right',
    'style'=>'margin-right: 27px!important;')
);
?>
    </fieldset>
<?php
echo form_close();
?>   
 <script type='text/javascript'>
        //validation and submit handling
        $(document).ready(function()
        {

			$(".module_checkboxes").change(function()
			{
				if ($(this).attr('checked'))
				{
					$(this).parent().find('input[type=checkbox]').attr('checked', 'checked');
				}
				else
				{
					$(this).parent().find('input[type=checkbox]').attr('checked', '');
				}
			});

				$('#contract_start_date').datePicker({startDate: '01-01-1950'});
				$('#contract_end_date').datePicker({startDate: '01-01-1950'});


				$("#category").autocomplete({
					source: "<?php echo site_url('contractcustomer/suggest'); ?>",
					delay: 10,
					autoFocus: false,
					minLength: 0
				});

            
            $( "#type_sup" ).autocomplete({
                source: '<?php echo site_url("contractcustomer/type_sup_search"); ?>',
                delay: 10,
                autoFocus: false,
                minLength: 0,
                select: function( event, ui ) 
                { 
                  $("#value_person_id").val(ui.item.id);
                }
               });
		setTimeout(function(){$(":input:visible:first","#contractcustomers_form").focus();},100);
        $(".module_checkboxes").change(function()
        {
            if ($(this).attr('checked'))
            {
                $(this).parent().find('input[type=checkbox]').attr('checked', 'checked');
            }
            else
            {
                $(this).parent().find('input[type=checkbox]').attr('checked', '');
            }
        });

        var submitting = false;

        $('#contractcustomers_form').validate({
            submitHandler:function(form) {
                if (submitting) return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);

                $(form).ajaxSubmit({
                    success:function(response)
                    {
                        tb_remove();
                        post_type_cus_form_submit(response);
                        submitting = false;
                    },
                    dataType:'json'
                });

            }
        });
			
         });
    </script>