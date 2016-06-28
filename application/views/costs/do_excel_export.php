<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
table.table_cost tr td{ border:1px solid black ;}
</style>
<a style="font-size:18px;text-decoration: underline; margin-left:850px" href="<?php echo base_url()?>reports/excel_export_costs">Trở lại</a>
<table class="table_cost" border="1px">

<tr>
	<td colspan ="7" style="text-align:center; font-weight:bold;padding: 5px;">SỔ QUỸ TÀI KHOẢN - TIỀN MẶT</td>
</tr>
<tr>
	<td colspan ="7" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y', strtotime($end_date)); ?></td>
</tr>
<tr>
	<td colspan ="7">&nbsp</td>
</tr>

<tr style="text-align:center; font-weight:bold; font-size:13px;">
	<td style="padding: 5px;" width="10%">NGÀY GS</td>
	<td width="10%"> SỐ CT</td>
	<td width="10%"> Ngày CT</td>
	<td width="30%">NỘI DUNG</td>
	<td width="10%">NHÂN VIÊN</td> 
      <?php if($cost_type == 'thu' || $cost_type == 'all'){ ?>
	<td width="15%">TIỀN THU</td> 
      <?php }if ($cost_type == 'chi' || $cost_type == 'all') { ?>        
	<td width="15%">TIỀN CHI</td>
      <?php }?>
</tr>
 
<?php if($cost_exports != null){
	foreach($cost_exports as $cost){ ?>
<tr style="font-size:15px;font-family:Arial, Helvetica, sans-serif">
	<td width="10%" style="text-align:center"><?php echo date('d-m-Y H:i:s', strtotime($cost['date'])); ?></td>
	<td width="10%" style="text-align:center"><?php echo $cost['chungtu']; ?></td>
	<td width="10%" style="text-align:center"><?php echo date("d/m/Y", strtotime($cost['cost_date_ct'])); ?></td>
    <?php if($cost_id != '')
    {?>
	<td width="30%" style="text-align:center"><?php echo $this->Cost->get_name_cost_select($cost['name']) ;?></td>
    <?php } else { ?>
    <td width="30%" style="text-align:center"><?php echo $cost['comment'] ;?></td>
    <?php } ?>
	<td width="10%" style="text-align:center"><?php echo $this->Person->get_info($cost['cost_employees'])->first_name.' '.$this->Person->get_info($cost['cost_employees'])->last_name; ?></td>
        <?php if($cost_type == 'thu' || $cost_type == 'all'){ ?>
	<td width="15%" style="text-align: right;"><?php
		if($cost['form_cost']==0) echo to_currency($cost['money']); 
		else echo null ; ?>
	</td>
        <?php }if ($cost_type == 'chi' || $cost_type == 'all') {?>
	<td width="15%" style="text-align: right;"><?php 
		if($cost['form_cost']==1) echo to_currency($cost['money']); 
		else echo null ; 
	?></td>
        <?php }?>
        
        
</tr>
<?php  } }
	else { ?>
	<tr><td colspan ="7">No data</td></tr>
<?php	
	}
 ?>
<tr style="font-weight:bold; height:30px;">	
    <td style="text-align:center" colspan="5">TỔNG CỘNG</td>
         <?php if($cost_type == 'thu' || $cost_type == 'all'){ ?>
	<td style="text-align:right;"><?php echo to_currency($cost_tien_thu); ?></td>
         <?php }if ($cost_type == 'chi' || $cost_type == 'all') {?>
	<td style="text-align:right;"><?php echo to_currency($cost_tien_chi); ?></td>
         <?php }?>
</tr>
</table>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>