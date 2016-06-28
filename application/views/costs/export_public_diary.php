<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
table.table_cost tr td{
    border:1px solid black ;
}
#first_child{
    border:none;
}
</style>
<a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/public_diary">Trở lại</a>
<table class="table_cost" border="1px">

<tr>
	<td colspan ="6" style="text-align:center; font-weight:bold;padding: 5px;">SỔ NHẬT KÝ CHUNG</td>
</tr>
<tr>
	<td colspan ="6" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></td>
</tr>
<tr>
	<td colspan ="6">&nbsp</td>
</tr>
<tr style="text-align:center; font-weight:bold; font-size:13px; background-color: #999999">
	<td colspan ="2">CHỨNG TỪ</td>
        <td  rowspan="2" width="35%">NỘI DUNG</td>
        <td  rowspan="2" width="7%">SỐ HIỆU TÀI KHOẢN</td> 
        <td colspan="2">SỐ TIỀN</td>
</tr>

<tr style="text-align:center; font-weight:bold; font-size:13px; background-color: #999999">
	<td width="6%">SỐ HIỆU</td>
	<td width="10%">NGÀY THÁNG</td>        
        <td width="10%">NỢ</td>
        <td width="10%">CÓ</td>
</tr>
        
<?php if(count($diary)>0){
    foreach ($diary as $data){?>     
<tr style="font-size:11px;font-family:Arial, Helvetica, sans-serif">
    <td style="text-align: center;"><?php echo $data['id_cost']?></td>
    <td style="text-align: center;"><?php echo $data['date']?></td>
    <td style="text-align: left;"><?php echo $data['comment']?></td>
    <td style="text-align: center;"> <?php echo $data['tk_no']?></td>
    <td style="text-align: right;"><?php echo number_format($data['money'])?></td>
    <td></td>
</tr>
<tr style="font-size:11px;font-family:Arial, Helvetica, sans-serif">
    <td style="text-align: center;"><?php echo $data['id_cost']?></td>
    <td style="text-align: center;"><?php echo $data['date']?></td>
    <td style="text-align: left;"><?php echo $this->Tkdu->get_info($data['tk_co'])->name?></td>
    <td style="text-align: center;"> <?php echo $data['tk_co']?></td>
    <td></td>
    <td style="text-align: right;"><?php echo number_format($data['money'])?></td>   
</tr>
<?php 
    $money_diary += $data['money'];
    }}else{ ?>
	<tr><td colspan ="6">No data</td></tr>
<?php	
	}
 ?>
<tr style="font-weight:bold; height:30px; background-color: #999999">	
    <td style="text-align:center" colspan="4">TỔNG CỘNG</td>        
    <td style="text-align:right;"><?php echo number_format ($money_diary); ?></td>        
    <td style="text-align:right;"><?php echo number_format($money_diary); ?></td>       
</tr>
</table>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>