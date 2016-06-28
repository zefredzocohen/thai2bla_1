
<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color: #000">
    <table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<?php 
				if($controller_name == create_new_giftcard){
			?>
			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
			<?php
			}else{?>
				<a href="<?php echo base_url()?>giftcards" ><div class="newface_back"></div></a>
			<?php
			}
			?>
		</td>
		<td id="title">
                    <span style="color: #fff">Tạo mới thẻ thanh toán</span>
		</td>
		
	</tr>
</table>
<div id="add_giftcard" style="">
	<?php echo form_fieldset('Tạo mới thẻ thanh toán',array('id'=>'fieldset','class'=>'form_fieldset')); ?>
	  <div class="field_row clearfix">
		  <?php echo form_label('Mã số thẻ thanh toán:'); ?>
		 <div class='form_field'>
			<?php   echo form_input(array('id'=>'id_giftcard','name'=>'id_giftcard','size'=>30)); ?>
		</div>
	  </div>
	  <div class="field_row clearfix">
		  <?php echo form_label('Số tiền '); ?>
		  <div class='form_field'>
			<?php echo form_input(array('id'=>'money_giftcard','name'=>'money_giftcard','size'=>30)); ?>
		</div>
	  </div>
	
	<?php $this->load->model('Customer'); 
	$data['drop']=$this->Customer->get_select_dropdown();
	?>
<div class="field_row clearfix">
<?php echo form_label(lang('giftcards_customer_name').':', 'customer_id',array('class'=>'wide')); ?>
	<div class='form_field'>
		<select id="cus_name" name="cus">
	<option selected="selected" value="">Chọn khách hàng hoặc công ty</option> 
	<?php  foreach ($data['drop'] as  $value) { ?>
	<option value="<?php echo $value['person_id']; ?>"><?php echo $value['first_name']; ?></option>
	
	<?php }?>
	</select>
	</div>
</div>


	  <div class="field_row clearfix">
	<?php echo form_label(lang('giftcard_chietkhau').':', 'name_chietkhau',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_checkbox(array(
		'name'=>'name_chietkhau',
		'id'=>'name_chietkhau',
		'value'=>1,
	)
	);?>
	</div>
	</div>
	  <?php
			echo form_submit(array(
				'name'=>'submit',
				'id'=>'submit',
				'value'=>'Thực hiện',
				'class'=>'submit_button_float_right')
			);
			?>
	<?php echo form_fieldset_close(); ?>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.number.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.number.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
	$('#money_giftcard').number(true);
	$('.submit_button_float_right').click(function(){
		var id_giftcards=$("#id_giftcard").val();
		var value_giftcarts=$("#money_giftcard").val();
		var id_cus_name=$("#cus_name").val();
		 var test = $('input:checked').length ? $('input:checked').val() : '0';
		 jQuery.ajax({
			 type:'Post',
			 url:'<?php echo site_url("giftcards/new_giftcarded") ?>',
			 data:'id_g='+id_giftcards+'&value_g='+value_giftcarts+'&cus_id='+id_cus_name+'&check_dis='+test,
			 success:function(data){
				 if(data=="true")
				 {
						 window.print();
                                                 // header('Location:'.base_url().'index.php/giftcards');
                                                 
				 }
				 else
				 {
				 alert('Có lỗi xảy ra trong quá trình lưu dữ liệu.Hãy thực hiện lại');
				 }
			 }
	 });
	});   
});
</script>