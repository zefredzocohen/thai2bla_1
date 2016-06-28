<?php $this->load->view('partial/header'); ?>
<?php 
	echo form_open('dttcs/do_edit_lapkehoach/'.$id_dttc,array('id'=>'dttc_detail_form'));
?>
<input type="hidden" value="<?php echo $detail_dttc->id; ?>" name="id_detail_dttc" />
Tên dự án: <input type="text" name="name_detail" value="<?php echo $detail_dttc->name; ?> "/>
Tên khách hàng: <input type="text" name="name_customer" value=" <?php echo $detail_dttc->name_customer; ?>"/>
<br />
<br />
Tổng giá trị hợp đồng: <input type="text" name="cost_contract" value="<?php echo $detail_dttc->cost_contract; ?>" /> 
<br />
<br />
Tiền ngày 1: <input type="text" name="date_1" value=" <?php echo $detail_dttc->date_1; ?>" />
Tiền ngày 2: <input type="text" name="date_2" value=" <?php echo $detail_dttc->date_2; ?>"/>
Tiền ngày 3: <input type="text" name="date_3" value=" <?php echo $detail_dttc->date_3; ?>"/>
<br />
Tiền ngày 4: <input type="text" name="date_4" value=" <?php echo $detail_dttc->date_4; ?>"/>
Tiền ngày 5: <input type="text" name="date_5" value=" <?php echo $detail_dttc->date_5; ?>"/>
Tiền ngày 6: <input type="text" name="date_6" value=" <?php echo $detail_dttc->date_6; ?>"/>
<br />
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>"Sửa lại",
	'class'=>'submit_button float_right')
);
?>
<?php $this->load->view('partial/footer'); ?>