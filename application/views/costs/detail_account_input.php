<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color:#000;line-height: 35px;height: 200px">
<h3 style="margin-left: 50px;padding-bottom: 10px;">Chọn ngày xuất</h3>
<?php echo form_open("costs/do_detail_account",array('id'=>'excel_export')); ?>   
    <ul id="error_message_box"></ul>
    <div>
    <input required="required" placeholder="chọn ngày" type="text" class="date-pick" id="start-date"  name="start_date" />
    <input required="required" placeholder="đến ngày" type="text" class="date-pick" id="end-date"  name="end_date" /> (*)
    </div>
    <div style="margin-left: 50px;" class='form_field'>
        <select name="account" id="account">
            <option value="">Chọn tài khoản</option>
            <?php 
            $list_tkdu_parents = $this->Tkdu->get_tkdu_parent();
            foreach ($list_tkdu_parents as $parent1){
                if($cost_info->tk_co == $parent1['id']){?>
                    <option value="<?=$parent1['id']?>" selected="selected"><?=$parent1['id'].'-'.$parent1['name'] ?></option>
                <?php }else{?>
                    <option value="<?=$parent1['id']?>"><?=$parent1['id'].'-'.$parent1['name'] ?></option>
                <?php }
                $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                foreach ($parents2 as $parent2){
                    if($parent2->id == $var_info->id_parent){?>
                        <option value="<?=$parent2->id?>" selected="selected"><?='----'.$parent2->id.'-'.$parent2->name ?></option>
                    <?php }
                    else{?>
                       <option value="<?=$parent2->id?>"><?='----'.$parent2->id.'-'.$parent2->name ?></option> 
                    <?php }
                $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                foreach ($parents3 as $parent3){
                    if($parent3->id == $var_info->id_parent){?>
                        <option value="<?=$parent3->id?>" selected="selected"><?='----'.$parent3->id.'-'.$parent3->name ?></option>
                    <?php }
                    else{?>
                       <option value="<?=$parent3->id?>"><?='----.-----'.$parent3->id.'-'.$parent3->name ?></option> 
                    <?php }}
                }}?>
        </select> (*) </div>
    <div style="margin-top:10px;margin-left: 48px;">
            <?php  echo lang('reports_export_to_excel'); ?>: 
            <input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
                    <label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
                    &nbsp;
            <input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
                    <label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
    </div>
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
});
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
                        account: "required"
                    },
            messages:
                    {                        
                        account: "Bạn phải chọn tài khoản"
                    }
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