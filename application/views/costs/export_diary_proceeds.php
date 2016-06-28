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
<div><?php echo $company?></div>
<div><?php echo $C_address?></div>
<br>
<div style="font-size: 15px; text-align:center; font-weight:bold;padding: 5px;">SỔ NHẬT KÝ THU TIỀN</div>
<div colspan ="11" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></div>

<table class="table_cost" border="1px">
<tr style="text-align:center; font-weight:bold;background-color: #999999">
	<td rowspan ="3" width="8%">NGÀY THÁNG GHI SỔ</td>
        <td colspan="2">CHỨNG TỪ</td>
        <td rowspan="3" width="24%">DIỄN GIẢI</td> 
        <td rowspan="3" width="9%">GHI NỢ TÀI KHOẢN 111, 112</td>
        <td colspan="6">GHI CÓ CÁC TÀI KHOẢN</td>
</tr>
<br>
<tr style="text-align:center; font-weight:bold; background-color: #999999">
        <td rowspan="2" width="5%">SỐ HIỆU</td>
	<td rowspan="2" width="8%">NGÀY THÁNG</td>
        <td rowspan="2" width="8%">131</td>
	<td rowspan="2" width="8%">511</td>
        <td rowspan="2" width="8%">515</td>
        <td rowspan="2" width="8%">711</td>
        <td colspan="2">TÀI KHOẢN KHÁC</td>
</tr>
<tr style="text-align:center; font-weight:bold;background-color: #999999">
	<td width="9%">SỐ TIỀN</td>
	<td width="5%">SỐ HIỆU</td>
</tr>
<?php 
if(count($diary)>0){
    foreach ($diary as $data_diary){
        $total_money += $data_diary['money'];?>
<tr style="font-size: 12px;">
    <td style="text-align: center;"> <?php echo date('d-m-Y H:i:s',strtotime($data_diary['date']))?></td>
    <td style="text-align: center;"><?php echo $data_diary['id_cost']?></td>
    <td style="text-align: center;"><?php echo date('d-m-Y H:i:s',strtotime($data_diary['cost_date_ct']))?></td>
    <td><?php echo $data_diary['comment']?></td>
    <td style="text-align: right;"><?php echo number_format($data_diary['money'])?></td>
    <td style="text-align: right;"><?php if($data_diary['tk_co']=='131'){echo number_format($data_diary['money']);}?></td>
    <td style="text-align: right;"><?php if($data_diary['tk_co']=='511'){echo number_format($data_diary['money']);}?></td>
    <td style="text-align: right;"><?php if($data_diary['tk_co']=='515'){echo number_format($data_diary['money']);}?></td>
    <td style="text-align: right;"><?php if($data_diary['tk_co']=='711'){echo number_format($data_diary['money']);}?></td>    
    <?php if($data_diary['tk_co']!= '711' && $data_diary['tk_co']!= '515' && $data_diary['tk_co']!='511' && $data_diary['tk_co']!='131'){?>
        <td style="text-align: right;"> <?php echo number_format($data_diary['money']);?></td>
        <td style="text-align: center;"><?php echo $data_diary['tk_co']?></td>
    <?php }else{?>
        <td></td>
        <td></td>
    <?php }?>
</tr>
    <?php }
}else{?>
<tr>
    <td colspan="11">No data</td>
</tr>
<?php }
?>
<tr style="font-weight: bold">
    <td colspan="4" style="text-align: right;">Tổng cộng</td>
    <td style="text-align: right;"> <?php echo number_format($total_money)?></td>
</tr>
</table>
<br>
<div>Sổ này có <?php if(count($diary) >0){ echo (int)(count($diary)/30 +1);}else{ echo 0;} ?> trang</div>
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
    <a href = "<?= site_url() ?>/accountings" id="submit" class="print_report" onclick = "this.style.display = 'none'; window.print();">In nhật ký</a>
</div>   
<br>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>
<style>
    table tr td {
        font-size: 12px;
    }
    div{
        font-size: 12px;
    }
</style>>