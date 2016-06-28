<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
.table_cost{ 
    width: 80%;
    margin-left: 80px;
    font-size: 14px;
}
.table_cost tr td{ 
    padding: 4px;
    border:1px solid black ;
}
.back_to_HallOweeN{
    font-size:18px;
    text-decoration: underline; 
    margin-left:789px;
}
.tr_HallOweeN{
    text-align:center; 
    font-weight:bold; 
    font-size:13px; 
    height: 20px
}
</style>
<a class="back_to_HallOweeN" href="<?= site_url()?>costs/nkbh">Trở lại</a><br><br>
<div style="text-align:center; font-weight:bold;padding: 5px; text-transform: uppercase">nhật ký bán hàng</div>
<div style="text-align:center; font-style:italic; font-size:13px; font-weight: 600">
    Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> 
    đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?>
</div><br>
<table class="table_cost" border="1px">
<tr class="tr_HallOweeN">
	<td width="15%">Ngày hoạch toán</td>
        <td width="15%">Ngày hóa đơn</td>
	<td width="10%">Số chứng từ</td>
	<td width="15%">Diễn giải</td>
	<td width="15%">Hàng hóa</td>
	<td width="15%">Dịch vụ</td>
</tr>
<?php
      $hh = 0;
      $vnl = 0;
foreach($receiving_HallOweeN->result() as $HallOweeN){


    ?>
<tr style="height: 20px">
    <td style="text-align: center"><?= date('d-m-Y', strtotime($HallOweeN->date_debt)) ?></td>
    <td style="text-align: center"><?= date('d-m-Y', strtotime($HallOweeN->date_debt1)) ?></td>
    <td style="text-align: center">
        <?=$HallOweeN->sale_id?>
    </td>     
    <td><?= $HallOweeN->comment ?></td>
    
    <td>
        tiền hàng hóa
    </td>
    
    <td>tiền dịch vụ</td>
</tr>    
    <?php
}
?>


</table>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>