<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color:#000;line-height: 35px;height: 200px">
    <a class="back_to_HallOweeN" href="<?= site_url()?>accountings/mua_hang">Trở lại</a>
<h3 style="margin-left: 50px;padding-bottom: 10px;">Chọn ngày xuất</h3>
<?php echo form_open("costs/do_diary_recv",array('id'=>'excel_export')); ?>
			<div>
			<input required="required" placeholder="chọn ngày" type="text" class="date-pick" id="start-date"  name="start_date" />
			<input required="required" placeholder="đến ngày" type="text" class="date-pick" id="end-date"  name="end_date" />
			</div>
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
<style type="text/css">
input#start-date,input#end-date{
    height:26px;
    width:123px;
    margin-left:50px;
}
.back_to_HallOweeN{
    font-size:18px;
    text-decoration: underline; 
    margin-left:789px;
}
</style>