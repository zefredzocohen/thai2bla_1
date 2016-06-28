<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script src="<?php echo base_url(); ?>js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
</head>
<body>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<div id="wrapper" style="margin-bottom:200px;">
<p style="font-size:12px; margin-left:200px;"><?php echo $this->config->item('company'); ?></p>
<p style="font-size:12px; margin-left:200px;"><?php echo $this->config->item('address'); ?></p>

<h4 style="margin-left:200px;">BẢNG TỔNG HỢP TỒN KHO TỪ: <?php echo $start_date; ?> ĐẾN <?php echo $end_date ; ?></h4>
<table id="inventory_item">
	<tr>
		<td class="none"></td>
		<td class="none"></td>
		<td class="none"></td>
		<td class="none"></td>
		<td class="besidetop" colspan="2" style="text-align: center;"><b>Tồn đầu kỳ<b></td>
		<td colspan="4" style="text-align: center;"><b>Phát sinh trong kỳ</b></td>
		<td class="besidetop" colspan="2" style="text-align: center;"><b>Tồn cuối kỳ</b></td>
	</tr>
	<tr>
		<td class="none"></td>
		<td class="none"></td>
		<td class="none"></td>
		<td class="none"></td>
		<td class="beside"></td>
		<td class="none"></td>
		<td colspan="2" style="text-align: center;"><b>Nhập</b></td>
		<td colspan="2" style="text-align: center;"><b>Xuất</b></td>
		<td class="none"></td>
		<td class="none"></td>
	</tr>
	<tr>
		<td style="text-align: center;">Mã VT</td>
		<td style="text-align: center;">Tên Vật Tư</td>
		<td style="text-align: center;">Đơn vị tính</td>
		<td style="text-align: center;">Đơn Giá</td>
		<td style="text-align: center;">Lượng</td>
		<td style="text-align: center;">Tiền</td>
		<td style="text-align: center;">Lượng</td>
		<td style="text-align: center;">Tiền</td>
		<td style="text-align: center;">Lượng</td>
		<td style="text-align: center;">Tiền</td>
		<td style="text-align: center;">Lượng</td>
		<td style="text-align: center;">Tiền</td>
	</tr>
	<?php 
		$tongcot_dauky_all = 0;
		$tongcot_cuoiky_all = 0;
		$tongcotnhap_phatsinh_all = 0;
		$tongcotxuat_phatsinh_all = 0;
	foreach ($categories as $category){ ?>
	<?php  $queries = $this->Item->get_item_category($category['id_cat'],$start_date,$end_date) ; 
		if($queries != null) { 
			$tongtiencot_dauky = 0;
			$tongtiencot_phatsinhnhap = 0;
			$tongtiencot_phatsinhxuat = 0;
			$tongtiencot_cuoiky =0;
	?>
		
	<?php	 foreach ($queries as $query){ ?>
		 
		 <tr> <?php $item_info = $this->Item->get_info($query['trans_items']);  ?>
		 <td style="text-align: center;"><?php echo $item_info->item_number; ?> </td>
		 <td style="text-align: right;"><?php echo $item_info->name; ?> </td>
		 <td style="text-align: right;"><?php echo $this->Unit->item_unit($item_info->unit)->name ; ?></td>
		 <td style="text-align: right;"><?php echo to_currency_unVND($item_info->unit_price); ?> </td>
		 <!-- phan dau ki -->
		 <td style="text-align: right;">
			<?php echo $soluong_tondauky = $this->Item->get_item_category_start_number($query['trans_items'],$start_date)->trans_inventory; ?>
		 </td>
		 <td style="text-align: right;">
			<?php $tien_daukis = $this->Item->get_item_category_start_money($query['trans_items'],$start_date); 
				$tongtien_dauki = 0;
				foreach ($tien_daukis as $tien_dauki){
					$tongtien_dauki += $tien_dauki['trans_money']*$tien_dauki['trans_inventory'] ;
				}
				$tongtiencot_dauky += $tongtien_dauki;
				echo to_currency_unVND($tongtien_dauki);
			?>
		 </td>
		<!-- end phan dau ki -->
		<!--  phat sinh trong ky nhap -->
		<td style="text-align: right;">
			<?php echo $soluongnhap_phatsinh = $this->Item->get_item_category_between_number_nhap($query['trans_items'],$start_date,$end_date)->trans_inventory; ?>
		</td>
		<td style="text-align: right;"> 
			<?php $tien_giuaki_nhaps = $this->Item->get_item_category_between_money_nhap($query['trans_items'],$start_date,$end_date); 
				$tongtien_giuaki_nhap = 0;
				foreach ($tien_giuaki_nhaps as $tien_giuaki_nhap){
					$tongtien_giuaki_nhap += $tien_giuaki_nhap['trans_money']*$tien_giuaki_nhap['trans_inventory'] ;
				}
				$tongtiencot_phatsinhnhap += $tongtien_giuaki_nhap;
				echo to_currency_unVND($tongtien_giuaki_nhap);
			?>
		</td> 
		<!-- end phat sinh trong ky nhap -->
		
		 <!--  phat sinh trong ky xuat -->
		 <td style="text-align: right;">
			<?php echo $soluongxuat_phatsinh = abs($this->Item->get_item_category_between_number_xuat($query['trans_items'],$start_date,$end_date)->trans_inventory); ?>
		 </td> 
		 <td style="text-align: right;"> 
			<?php $tien_giuaki_xuats = $this->Item->get_item_category_between_money_xuat($query['trans_items'],$start_date,$end_date); 
				$tongtien_giuaki_xuat = 0;
				foreach ($tien_giuaki_xuats as $tien_giuaki_xuat){
					$tongtien_giuaki_xuat += $tien_giuaki_xuat['trans_money']*$tien_giuaki_xuat['trans_inventory'] ;
				}
				$tongtiencot_phatsinhxuat += abs($tongtien_giuaki_xuat) ;
				echo to_currency_unVND(abs($tongtien_giuaki_xuat));
			?>
		 </td> 
		 <!-- end phat sinh trong ky xuat -->
		 <!-- phan cuoi ki -->
		 <td style="text-align: right;">
			<?php echo $soluong_toncuoiky =  $soluong_tondauky + ($soluongnhap_phatsinh - $soluongxuat_phatsinh) 
			+ $this->Item->get_item_category_end_number($query['trans_items'],$end_date)->trans_inventory; ?>
		 </td>
		 <td style="text-align: right;">
			<?php  
				$tongtiencot_cuoiky += ($soluong_toncuoiky*$item_info->unit_price);
				echo to_currency_unVND($soluong_toncuoiky*$item_info->unit_price);
			?>
		 </td>
		<!-- end phan cuoi ki -->
		</tr>
	<?php	}	?>
	
		<tr style="background:rgba(195, 196, 202, 0.7);">
			<td colspan="5" style="text-align: right;">
				<?php echo $category['name']; ?>
			</td>
			<td style="text-align: right;">
			<?php 
			$tongcot_dauky_all += $tongtiencot_dauky;
			echo to_currency_unVND($tongtiencot_dauky); ?>
			</td>
			<td style="text-align: right;">
			
			</td>
			<td style="text-align: right;">
			<?php 
			$tongcotnhap_phatsinh_all += $tongtiencot_phatsinhnhap;
			echo to_currency_unVND($tongtiencot_phatsinhnhap) ; ?>
			</td>
			<td style="text-align: right;">
			
			</td>
			<td style="text-align: right;">
			<?php
			$tongcotxuat_phatsinh_all += $tongtiencot_phatsinhxuat;
			echo to_currency_unVND($tongtiencot_phatsinhxuat); ?>
			</td>
			<td style="text-align: right;">
			
			</td>
			<td style="text-align: right;">
			<?php
			$tongcot_cuoiky_all += $tongtiencot_cuoiky;
			echo to_currency_unVND($tongtiencot_cuoiky) ; ?>
			</td>
		</tr>
	<?php }
		
	?>

	<?php } ?>	
	<tr>
		<td colspan="5"> Tổng </td>
		<td><?php echo to_currency_unVND($tongcot_dauky_all); ?> </td>
		<td> </td>
		<td><?php echo to_currency_unVND($tongcotnhap_phatsinh_all) ;?> </td>
		<td> </td>
		<td><?php echo to_currency_unVND($tongcotxuat_phatsinh_all) ; ?> </td>
		<td> </td>
		<td><?php echo to_currency_unVND($tongcot_cuoiky_all); ?></td>
	</tr>
</table>
<table style="margin:30px auto; width:70%">
	<tr>
		<td style="text-align:right;margin-right:20px;" colspan="3"><i>Ngày: <?php echo date('d-m-Y'); ?></i></td>
	</tr>
	<tr>
		<td width="30%">Người lập biểu
						<p><i>(Kỹ tên)</i></p>
		</td>
		<td width="30%" style="text-align:center;">Kế toán trưởng<p><i>(Kỹ tên)</i></p></td>
		<td width="40%" style="text-align:right;">Giám đốc<p><i>(Kỹ tên)</i></p></td>
	</tr>
</table>
<div>
<button style="margin-left:200px;width:87px;" class="submit_button" id="print_button" onClick="print_receipt()" > <?php echo lang('sales_print'); ?> </button>
</div>
</div>
</div></div></div>
</body>
</html>
<script type="text/javascript">
function print_receipt()
 {
	$('#print_button').hide();
  window.print();
 }
</script>
<style type="text/css">
#wrapper{
margin:10px auto;
}
table#inventory_item{
	border:1px solid black;
	margin:10px auto;
	border-collapse: collapse; 
}
table#inventory_item tr td{
	border:1px solid black;
	font-size:14px;
	padding:6px 6px;
}
table#inventory_item tr td.none{
	border:0px;
}
table#inventory_item tr td.beside{
	border-right:0px;
	border-top:0px;
}
table#inventory_item tr td.besidetop{
	border-bottom:0px;
}
</style>