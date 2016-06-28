<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<?php 
	$this->load->model('Customer');
?>
<p style="font-size:12px;"><?php echo $this->config->item('company'); ?></p>
<p style="font-size:12px;"><?php echo  $this->config->item('address'); ?></p>
<div style="margin-top:15px; margin-left:140px;">
<h3 >BẢNG TỔNG HỢP THEO DÕI ĐỐI TƯỢNG PHẢI THU CỦA KHÁCH HÀNG</h3>
<p style="font-size:12px; padding-left:240px;margin-top:10px;"><i>Từ <?php echo $start_date; ?> Đến: <?php echo $end_date; ?></i></p>
</div>
<table id="congnokh">
	<tr>
		<td colspan="2" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"><b>Dư đầu kỳ</b> </td>
		<td colspan="2" style="text-align: center;"><b>Phát sinh trong kỳ</b></td>
		<td colspan="2" style="text-align: center;"><b>Dư cuối kỳ</b></td>
	</tr>
	<tr style="height:30px; font-weight:bold;">
            <td style="text-align: center;">Mã</td>
		<td style="text-align: center;">Tên đối tượng</td>
		<td style="text-align: center;">Nợ</td>
		<td style="text-align: center;">Có</td>
		<td style="text-align: center;">Nợ</td>
		<td style="text-align: center;">Có</td>
		<td style="text-align: center;">Nợ</td>
		<td style="text-align: center;">Có</td>
	</tr>
	<?php $array_tong_cot_tienno_phatsinh_tong = 0;
		$array_tong_cot_tienco_phatsinh_tong = 0;
		$array_tong_cot_tienco_dauky_tong = 0;
		$array_tong_cot_tienno_dauky_tong = 0;
		$array_tong_cot_tienco_cuoiky_tong = 0;
		$array_tong_cot_tienno_cuoiky_tong = 0; ?>
	<?php if($code_cities != null){ foreach ($code_cities as $code_city){ 
		 if($code_city['id_city_code'] != null){
	?>
	<tr >
		<td colspan="8" style="color:green;"><?php  echo $this->City->get_info($code_city['id_city_code'])->name; ?></td>
	</tr>
	<!--- phan tinh nhung nguoi co no -->
	<?php $customers_info = $this->Customer->find_customer($code_city['id_city_code'],$start_date,$end_date) ; 
		$array_tongtienno_phatsinh = array();
		$array_tongtienco_phatsinh = array();
		$array_tongtienco_dauky = array();
		$array_tongtienno_dauky = array();
		$array_tongtienco_cuoiky = array();
		$array_tongtienno_cuoiky = array();
		foreach($customers_info as $cus_info){
	
	?>
	<!---end phan tinh nhung nguoi co no -->
	<tr>
		<td style="text-align: center;"><?php echo $this->Customer->get_info($cus_info['id_customer'])->person_id; ?></td>
		<td style="text-align: right;"><?php echo $this->Customer->get_info($cus_info['id_customer'])->first_name; ?></td>
<!-- dau ky -->
		<td style="text-align: right;">
		<?php 
			$sales_ids_dauky = $this->Customer->find_sale_id_customer_dauky($cus_info['id_customer'],$start_date);
			$tongtienno_dauky = 0;
		foreach($sales_ids_dauky as $sales_id_dauky ){
			 $query_tiennos_dauky = $this->Item->get_price_sale_item($sales_id_dauky['id_sale']);
			 foreach ($query_tiennos_dauky as $query_tienno_dauky){
				$tongtienno_dauky += $query_tienno_dauky['tienno'];
			 }
		 }
		 $array_tongtienno_dauky[] = $tongtienno_dauky ;
		 echo to_currency_unVND($tongtienno_dauky);
		?>
		</td>
		<td style="text-align: right;">
		<?php
		$sales_ids_dauky = $this->Customer->find_sale_id_customer_dauky($cus_info['id_customer'],$start_date);
		 $array_tienco_dauky = array();
		foreach($sales_ids_dauky as $sales_id_dauky ){
		  $hinhthucs_dauky = $this->Customer->find_pay_type_congno_dauky($cus_info['id_customer'],$start_date,$sales_id_dauky['id_sale']);
		  foreach ($hinhthucs_dauky as $hinhthuc_dauky){
			  $tien_cos_dauky = $this->Customer->find_tien_congno_dauky($cus_info['id_customer'],$start_date,$sales_id_dauky['id_sale'],$hinhthuc_dauky['pay_type']);
			 foreach ($tien_cos_dauky as $tien_co_dauky){
				$array_tienco_dauky[] = $tien_co_dauky['pay_amount'];
			 }
		  }
		 }
		  $tongtienco_dauky = 0;
		  for($l = 0; $l < count($array_tienco_dauky); $l++ ){
			 $tongtienco_dauky += $array_tienco_dauky[$l];
		  }
		  $array_tongtienco_dauky[] = $tongtienco_dauky;
		  echo to_currency_unVND($tongtienco_dauky) ;
		 ?>
		</td>
<!-- end dau ky -->
<!-- phat sinh trong ky -->
		<td style="text-align: right;">
		<?php 
		$sales_ids = $this->Customer->find_sale_id_customer($cus_info['id_customer'],$start_date,$end_date);
		$tongtienno = 0;
		foreach($sales_ids as $sales_id ){
			 $query_tiennos = $this->Item->get_price_sale_item($sales_id['id_sale']);
			 foreach ($query_tiennos as $query_tienno){
				$tongtienno += $query_tienno['tienno'];
			 }
		 }
		 $array_tongtienno_phatsinh[] = $tongtienno ;
		 echo to_currency_unVND($tongtienno);
		?>
		</td>
		<td style="text-align: right;">
		<?php
		$sales_ids = $this->Customer->find_sale_id_customer($cus_info['id_customer'],$start_date,$end_date);
		$array_tienco = array();
		foreach($sales_ids as $sales_id ){
		  $hinhthucs = $this->Customer->find_pay_type_congno($cus_info['id_customer'],$start_date,$end_date,$sales_id['id_sale']);
		 foreach ($hinhthucs as $hinhthuc){
			  $tien_cos = $this->Customer->find_tien_congno($cus_info['id_customer'],$start_date,$end_date,$sales_id['id_sale'],$hinhthuc['pay_type']);
			 foreach ($tien_cos as $tien_co){
				$array_tienco[] = $tien_co['pay_amount'];
			 }
		  }
		 }
		 $tongtienco = 0;
		 for($i = 0; $i < count($array_tienco); $i++ ){
			$tongtienco += $array_tienco[$i];
		 }
		 $array_tongtienco_phatsinh[] = $tongtienco;
		 echo to_currency_unVND($tongtienco) ;
		 ?>
		</td>
<!-- end phat sinh trong ky -->
<!-- dau du cuoi ky -->
		<td style="text-align: right;">
			<?php 
			$sales_ids_cuoiky = $this->Customer->find_sale_id_customer_cuoiky($cus_info['id_customer'],$end_date);
			$tongtienno_cuoiky = 0;
		foreach($sales_ids_cuoiky as $sales_id_cuoiky ){
			 $query_tiennos_cuoiky = $this->Item->get_price_sale_item($sales_id_cuoiky['id_sale']);
			 foreach ($query_tiennos_cuoiky as $query_tienno_cuoiky){
				$tongtienno_cuoiky += $query_tienno_cuoiky['tienno'];
			 }
		 }
		 $array_tongtienno_cuoiky[] = $tongtienno_cuoiky+$tongtienno_dauky+$tongtienno ;
		 echo to_currency_unVND($tongtienno_cuoiky+$tongtienno_dauky+$tongtienno);
			?>
		</td>
		<td style="text-align: right;">
		<?php
		$sales_ids_cuoiky = $this->Customer->find_sale_id_customer_cuoiky($cus_info['id_customer'],$end_date);
		 $array_tienco_cuoiky = array();
		foreach($sales_ids_cuoiky as $sales_id_cuoiky ){
		  $hinhthucs_cuoky = $this->Customer->find_pay_type_congno_cuoiky($cus_info['id_customer'],$end_date,$sales_id_cuoiky['id_sale']);
		  foreach ($hinhthucs_cuoky as $hinhthuc_cuoky){
			  $tien_cos_cuoky = $this->Customer->find_tien_congno_cuoky($cus_info['id_customer'],$end_date,$sales_id_cuoiky['id_sale'],$hinhthuc['pay_type']);
			 foreach ($tien_cos_cuoky as $tien_co_cuoky){
				$array_tienco_cuoiky[] = $tien_co_cuoky['pay_amount'];
			 }
		  }
		 }
		  $tongtienco_cuoiky = 0;
		  for($l = 0; $l < count($array_tienco_cuoiky); $l++ ){
			 $tongtienco_cuoiky += $array_tienco_cuoiky[$l];
		  }
		  $array_tongtienco_cuoiky[] = $tongtienco_cuoiky + $tongtienco_dauky+$tongtienco;
		  echo to_currency_unVND($tongtienco_cuoiky + $tongtienco_dauky+$tongtienco) ;
		 ?>
		</td>
<!-- end dau du cuoi ky -->
	</tr>
	<?php  } ?>
	<tr style="background:red;">
		<td colspan="2">Tổng</td>
		<td style="text-align: right;">
		<?php 
		 $tongtienno_dauky_tong = 0;
		 for($m = 0; $m < count($array_tongtienno_dauky); $m++ ){
			$tongtienno_dauky_tong += $array_tongtienno_dauky[$m];
		 }
		 $array_tong_cot_tienno_dauky_tong += $tongtienno_dauky_tong ;
		 echo to_currency_unVND($tongtienno_dauky_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php 
		 $tongtienco_dauky_tong = 0;
		 for($n = 0; $n < count($array_tongtienco_dauky); $n++ ){
			$tongtienco_dauky_tong += $array_tongtienco_dauky[$n];
		 }
		 $array_tong_cot_tienco_dauky_tong += $tongtienco_dauky_tong ;
		 echo to_currency_unVND($tongtienco_dauky_tong) ;
		?>
		</td>
		<td style="text-align: right;"><?php 
		 $tongtienno_phatsinh = 0;
		 for($j = 0; $j < count($array_tongtienno_phatsinh); $j++ ){
			$tongtienno_phatsinh += $array_tongtienno_phatsinh[$j];
		 }
		 $array_tong_cot_tienno_phatsinh_tong += $tongtienno_phatsinh;
		 echo to_currency_unVND($tongtienno_phatsinh) ;
		?></td>
		<td style="text-align: right;"><?php 
		 $tongtienco_phatsinh = 0;
		 for($k = 0; $k < count($array_tongtienco_phatsinh); $k++ ){
			$tongtienco_phatsinh += $array_tongtienco_phatsinh[$k];
		 }
		 $array_tong_cot_tienco_phatsinh_tong += $tongtienco_phatsinh ;
		 echo to_currency_unVND($tongtienco_phatsinh) ;
		?></td>
		<td style="text-align: right;">
		<?php 
		 $tongtienno_cuoiky_tong = 0;
		 for($p = 0; $p < count($array_tongtienno_cuoiky); $p++ ){
			$tongtienno_cuoiky_tong += $array_tongtienno_cuoiky[$p];
		 }
		 $array_tong_cot_tienno_cuoiky_tong += $tongtienno_cuoiky_tong ;
		 echo to_currency_unVND($tongtienno_cuoiky_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php 
		 $tongtienco_cuoiky_tong = 0;
		 for($q = 0; $q < count($array_tongtienco_cuoiky); $q++ ){
			$tongtienco_cuoiky_tong += $array_tongtienco_cuoiky[$q];
		 }
		 $array_tong_cot_tienco_cuoiky_tong += $tongtienco_cuoiky_tong;
		 echo to_currency_unVND($tongtienco_cuoiky_tong) ;
		?>
		</td>
	</tr>
	<?php } } } ?>
	<tr>
		<td colspan="2">Tổng cột</td>
		<td style="text-align: right;">
		<?php
		 echo to_currency_unVND($array_tong_cot_tienno_dauky_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php
		 echo to_currency_unVND($array_tong_cot_tienco_dauky_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php
		 echo to_currency_unVND($array_tong_cot_tienno_phatsinh_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php
		 echo to_currency_unVND($array_tong_cot_tienco_phatsinh_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php
		  echo to_currency_unVND($array_tong_cot_tienno_cuoiky_tong) ;
		?>
		</td>
		<td style="text-align: right;">
		<?php
		  echo to_currency_unVND($array_tong_cot_tienco_cuoiky_tong) ;
		?>
		</td>
	</tr>
</table>
<div style="margin-top:30px; margin-bottom:10px;">
<div style="float:left; padding-left:30px;">
	<p style="font-size:14px;">Lập biểu</p>
	<i style="font-size:14px;">(Ký, họ tên)</i>
</div>
<div style="float:right; padding-right:50px;">
	<p style="font-size:14px;">Ngày ..../...../........</p>
	<p style="font-size:14px;">Kế toán trưởng</p>
	<i style="font-size:14px;">(Ký, họ tên)</i>
</div>
</div>
<div style="margin-top:30px; margin-bottom:25px;padding-left: 330px;" >
	<button   id="print_button" onclick="print_receipt()" > <?php echo lang('sales_print'); ?> </button>
</div></div></div></div>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript">
function print_receipt()
 {
	$('#print_button').hide();
  window.print();
 }
</script>
<style type="text/css">
table#congnokh{
	border:1px solid black;
	margin:10px auto;
}
table#congnokh tr td{
	border:1px solid black;
	padding-left:5px;
	font-size:14px;
}
</style>