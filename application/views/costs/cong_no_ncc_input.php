<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color:#000;line-height: 35px;height: 200px">
<a style="font-size:18px;text-decoration: underline; margin-left:850px;" href=" <?= site_url()?>accountings/mua_hang">Trở lại</a>
<h3 style="margin-left: 50px;padding-bottom: 10px; margin-top: -30px">Chọn ngày xuất</h3>
<?php echo form_open("costs/do_report_cong_no_ncc",array('id'=>'excel_export')); ?>   
    <ul id="error_message_box"></ul>
    <div>
    <input required="required" placeholder="chọn ngày" type="text" class="date-pick" id="start-date"  name="start_date" />
    <input required="required" placeholder="đến ngày" type="text" class="date-pick" id="end-date"  name="end_date" /> (*)
    </div>
    <div style="margin-left: 50px;" class='form_field'>
        <select name="supplier_id" id="supplier_id">            
            <option>Chọn nhà cung cấp</option>
            <?php $tam = $this->Supplier->get_all_supplier();
            foreach ($tam as $tam1){?>            
            <option value= '<?php echo $tam1['person_id']?>'><?=$tam1['company_name']?></option>
            <?php }
            ?>
        </select> (*)
    </div>
<!--    <div style="margin-top:10px;margin-left: 48px;">
            <?php  echo lang('reports_export_to_excel'); ?>: 
            <input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
                    <label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
                    &nbsp;
            <input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
                    <label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
    </div>-->
    <input type="hidden" name="tkdu" value="0" />
    <?php
            echo form_button(array(
                    'type' => 'submit',
                    'name'=>'generate_report',
                    'id'=>'generate_report',
                    'style'=>'margin-right: 845px',
                    'content'=>lang('common_submit'),
                    'class'=>'submit_button')
            );
    ?>
<?php echo form_close(); ?>
</div></div>
<?php $this->load->view("partial/footer"); ?>
<script>
$(document).ready(function(){
    
        $('#start-date').datePicker({startDate: '01-01-1950'}).bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end-date').datePicker().bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
$('#excel_export').validate({
            submitHandler: function (form)
            {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        submitting = false;
                        tb_remove();
                        post_type_cus_form_submit(response);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        customer_id: "required"
                    },
            messages:
                    {                        
                        customer_id: "Bạn phải chọn khách hàng"
                    }
        });
});

</script>
<style type="text/css">
input#start-date,input#end-date{
height:26px;
width:123px;
margin-left:50px;
padding-left: 5px;
padding-right: 5px;
}

</style>