<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color: #000">
            <table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<?php 
				if($controller_name == return_money){
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
                    <span style="color: #fff">Trả tiền cho thẻ thanh toán</span>
		</td>
		
	</tr>
</table>
<div id="print_form" style="">
 <fieldset class="form_fieldset" id="fieldset_giaoca">
 		<legend style=" font-size:20px;margin-left:100px;font-weight:bold;">HÓA ĐƠN NẠP TIỀN</legend>  
	 	
	 <div class="field_row clearfix">
		  <?php  echo form_label('Ngày'); ?>
		  <div class='form_field'>
		<?php   echo form_input(array('id'=>'thoidiemgiaoca','name'=>'thoidiemgiaoca','class'=>'thoidiemgiaoca','size'=>25,'value'=>date('d-m-Y  h:i:s'))); ?>
		  </div>
	</div>
	 <div class="field_row clearfix">
		  <?php echo form_label('Tên khách hàng'); ?>
		  <div class='form_field'>
			<?php   echo form_input(array('id'=>'money_input','value'=>$this->Giftcard->get_user($giftcards->customer_id),'class'=>'tongtien','size'=>25)); ?>
		  </div>
	  </div>
	 <div class="field_row clearfix">
		  <?php echo form_label('Số tiền gốc'); ?>
		  <div class='form_field'>
				<?php echo form_input(array('name'=>'tiengoc','id'=>'money_db','size'=>'25','value'=>$giftcards->value,'accesskey' => 'c'));?>
		  </div>
	 </div>
	<div class="field_row clearfix">
		  <?php  echo form_label('Số tiền trả lại '); ?>
		  <div class='form_field'>
			<input type="text" name="money_add" id="money_add">
		  </div>
	</div>
	<div class="field_row clearfix">
		  <?php  echo form_label('Số tiền còn lại'); ?>
		  <div class='form_field'>
			<?php    echo form_input(array('id'=>'sum_money_affter','name'=>'sum_money_affter','size'=>25)); ?>
		  </div>
		 
	</div>
		<div id="canhbao"></div>
	</fieldset>
	  <?php echo form_close(); ?>
</div>

<?php $this->load->Model('Giftcard'); ?>
<div id="add_money">
	<?php  // echo form_open('giftcards/update_get_money');?>
	<?php echo form_fieldset('Tiến hành trả tiền',array('id'=>'fieldset','class'=>'form_fieldset')); ?>
	  <div class="field_row clearfix">
		  <?php echo form_label('Mã số thẻ quà tặng:'); ?>
		  <div class='form_field'>
			<?php   echo form_input(array('id'=>'topic','name'=>'topic','value'=>$giftcards->giftcard_number,'size'=>30, 'disabled'=>'true')); ?>
		</div>
	  </div>
	  <div class="field_row clearfix">
		  <?php echo form_label('Số tiền'); ?>
		  <div class='form_field disabled'>
			<?php   echo form_label(number_format($giftcards->value)); ?>
		  </div>
	  </div>
	  <input type="hidden" name="sotien" value="<?php echo $giftcards->value; ?>" id="so_tien_goc">
	  <div class="field_row clearfix">
		  <?php echo form_label('Tên khách hàng'); ?>
		  <div class='form_field'>
				<?php echo form_input(array('name'=>'search','id'=>'customer','size'=>'30','value'=>$this->Giftcard->get_user($giftcards->customer_id),'disabled'=>'true'));?>
		  </div>
	  </div>
	  
	   <div class="field_row clearfix">
		  <?php echo form_label('Số tiền trả lại'); ?>
		  <div class='form_field'>
			<?php   echo form_input(array('id'=>'price_cost1','name'=>'pricecost','class'=>'info','size'=>30)); ?>
		  </div>
	  </div>
	<input type="hidden" value="<?php echo $giftcards->giftcard_id; ?>" name="id_giftcard" id="id_giftcard">
<input type="hidden" value="<?php echo $this->Giftcard->get_company_customer($giftcards->customer_id); ?>" id="company_name">
	  <?php
			echo form_submit(array(
				'name'=>'submit',
				'id'=>'submit',
				'value'=>'Thực hiện',
				'class'=>'submit_button_float_right')
			);
			?>
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?>

</div></div></div>
<?php $this->load->view("partial/footer"); ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.number.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.number.min.js" type="text/javascript"></script>
<script type="text/javascript">
// Numeric only control handler
jQuery.fn.ForceNumericOnly = function () {
    return this.each(function () {
        $(this).keydown(function (e) {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
        key == 8 || key == 9 || key == 46 || (key >= 37 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
        });
    });
}; // JavaScript Document
$(document).ready(function () {
	$('#print_form').hide();
	$('#price_cost1').number(true);
	$('#money_db').number(true);
	$('#money_add').number(true);
	$('#sum_money_affter').number(true);
	$('#price_cost1').keyup(function(){
		var money_txt=$('#price_cost1').val();
		$('#money_add').val(money_txt);
		$('#sum_money_affter').val(Number($('#money_db').val())-Number($('#money_add').val()));
	});
	$('.submit_button_float_right').click(function(){
		if($('#company_name').val()!=0){
			$('#money_add').removeAttr('value');
			alert('Không thể trả lại tiền cho khách hàng này');
			return false;
		}
		 if(Number($('#so_tien_goc').val()) < Number($('#money_add').val())){
		 	alert('Số tiền trả lại không thể lớn hơn số tiền gốc');
		 	return false;
		 }
		else
		{
		var summoney=$("#sum_money_affter").val();
		var idgiftcard=$("#id_giftcard").val();
		jQuery.ajax({
			type:'Post',
			url:'<?php echo site_url("giftcards/update_get_money") ?>',
			data:"sum_money="+summoney+"&id_giftcards="+idgiftcard,
			success:function(data){
				if(data="true"){
					$("#add_money").slideUp('slow');
					$('#print_form').slideDown(1000,function(){
						window.print();
					});
				}
			}
		});
		}
	});
    $('#price_cost123').ForceNumericOnly();
});
</script>