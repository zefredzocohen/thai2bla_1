<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
.table_cost tr td{
    border:1px solid black ;
    padding-left: 5PX;
    padding-right: 5PX;
}
table tr td{
    font-size: 12px;
}
div {
    font-size: 12px;
}
</style>
<a style="font-size:18px;text-decoration: underline; margin-left:850px" href=" <?php echo site_url()?>/costs/bank_account_money">Trở lại</a>
<div style="text-align:center; font-weight:bold;padding: 5px; font-size: 13px;">SỔ TIỀN GỬI NGÂN HÀNG</div>
<div style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>
<div >&nbsp</div>
<table class="table_cost" border="1px">	

<tr style="text-align:center; font-weight:bold; font-size:13px;">
	<td style="padding: 5px;" width="8%" >NGÀY GS</td>
	<td width="6%"> SỐ CT</td>
	<td width="8%"> NGÀY CT</td>
	<td width="25%">NỘI DUNG</td>
	<td width="12%">NHÂN VIÊN</td> 
        <td width="6%">TK_NỢ</td> 
        <td width="6%">TK_CÓ</td>     
	<td width="9%">THU(GỬI VÀO)</td> 
	<td width="9%">CHI(RÚT RA)</td>
        <td width="10%">CÒN LẠI</td> 
     
</tr>
 
<?php if($cost_exports != null){
	foreach($cost_exports as $cost){ 
            $this->load->model('Cost');
            $no = $this->Cost->get_no_111($cost['id_cost'],$acc_id,$acc_arr);            
            $money_no = 0;
            $money_co = 0;
            foreach ($no as $no1){
                $money_no += $no1['money'];
                
            }            
            $co = $this->Cost->get_co_111($cost['id_cost'],$acc_id,$acc_arr);
            foreach ($co as $co1){
                $money_co += $co1['money'];
            }
            ?>
<tr style="font-size:12px;font-family:Arial, Helvetica, sans-serif">
	<td style="text-align:center"><?php echo date('d-m-Y H:i:s', strtotime($cost['date'])); ?></td>
	<td style="text-align:center"><?php echo $cost['id_cost']; ?></td>
	<td  style="text-align:center"><?php echo date("d/m/Y", strtotime($cost['cost_date_ct'])); ?></td>
    <?php if($cost_id != '')
    {?>
	<td style="text-align:center"><?php echo $this->Cost->get_name_cost_select($cost['name']) ;?></td>
    <?php } else { ?>
    <td style="text-align:left"><?php echo $cost['comment'] ;?></td>
    <?php } ?>
	<td style="text-align:left"><?php echo $this->Person->get_info($cost['cost_employees'])->first_name.' '.$this->Person->get_info($cost['cost_employees'])->last_name; ?></td>
        <td style="text-align: center;"><?php echo $cost['tk_no'] ; ?></td>
        <td style="text-align: center;"><?php echo $cost['tk_co']; ?></td>       
	<td style="text-align: right;"><?php
		if($cost['form_cost']==0) echo number_format($cost['money']); 
		else echo 0 ; ?>
	</td>     
	<td style="text-align: right;"><?php 
		if($cost['form_cost']==1) echo number_format($cost['money']); 
		else echo 0 ; 
	?></td>
        <td style="text-align: right;"><?php echo number_format($money_no-$money_co); ?></td>  
</tr>
<?php    
    }}
	else { ?>
	<tr><td colspan ="7">No data</td></tr>
<?php	
	}
 ?>
<tr style="font-weight:bold; height:30px;">	
        <td style="text-align:center" colspan="7">TỔNG CỘNG</td>        
        <td style="text-align:right;"><?php echo number_format ($cost_tien_thu); ?></td>        
        <td style="text-align:right;"><?php echo number_format($cost_tien_chi); ?></td>
        <td style="text-align:right;"><?php echo number_format($money_no-$money_co); ?></td>
         
</tr>
</table>
<br>
<div>Sổ này có <?php if(count($cost_exports) >0){ echo (int)(count($cost_exports)/30 +1);}else{ echo 0;} ?> trang</div>
<div>Ngày mở sổ: <?php echo date('d-m-Y H:i:s')?></div>
<table id="ky_ten">
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: center; font-weight: bold">Ngày ... tháng ... năm ...  </td>
    </tr>
    <tr style="text-align: center; margin-top:5px;">
        <td style="width: 33%">NGƯỜI GHI SỔ</td>
        <td style="width: 33%">KẾ TOÁN</td>
        <td style="width: 34%">GIÁM ĐỐC</td>
    </tr>
    <tr style="text-align: center;">
        <td>(ký, họ tên)</td>
        <td>(ký, họ tên)</td>
        <td>(ký, họ tên, đóng dấu)</td>
    </tr>
</table>
<br>
<br>
<div style="font-size: 14px; text-align: center;">
    <a href = "<?= site_url() ?>/accountings" id="submit" class="print_report" onclick = "this.style.display = 'none'; window.print();">In sổ</a>
</div>   
<br>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>