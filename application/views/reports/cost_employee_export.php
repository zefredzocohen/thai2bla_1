<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
table.table_cost tr td{ border:1px solid black ;}
</style>
<a style="font-size:18px;text-decoration: underline; margin-left:850px" href="<?php echo site_url()?>/reports">Trở lại</a>
<table class="table_cost" border="1px">

<tr>
	<td colspan ="7" style="text-align:center; font-weight:bold;padding: 5px;">BÁO CÁO THU CHI NHÂN VIÊN </td>
</tr>
<tr>
	<td colspan ="7" style="text-align:center; font-style:italic; font-size:13px">Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?></td>
</tr>
<tr>
	<td colspan ="7">&nbsp</td>
</tr>
<tr style="text-align:center; font-weight:bold; font-size:13px;">
	<td style="padding: 5px;" width="3%"> STT</td>
	<td width="12%"> NGÀY THU CHI</td>
	<td width="20%">NHÂN VIÊN THỰC HIỆN</td>
	<td width="25%">NỘI DUNG THU CHI</td>
        <td width="20">ĐỐI TƯỢNG NHẬN THU CHI</td>
        <?php if($cost_type == 'thu' || $cost_type == 'all'){?>
	<td width="11%">TIỀN THU</td>
        <?php }if($cost_type == 'chi' || $cost_type == 'all'){?>
	<td width="11%">TIỀN CHI</td>
        <?php }?>
</tr>
<?php
$this->load->model('Person');
$emp_name=$this->Employee->get_info($this->session->userdata('person_id'));
 $name_emp=$emp_name->first_name.' '.$emp_name->last_name;

 foreach($cost_exports as $cost){
 $name_p= $this->Person->get_info($cost['cost_employees'])->first_name.' '.$this->Person->get_info($cost['cost_employees'])->last_name;
}


//if($name_emp==$name_p){
   
if($cost_exports != null){
        $i=1;
	foreach($cost_exports as $cost){ ?>
<tr style="font-size:15px;font-family:Arial, Helvetica, sans-serif">
	<td width="3%" style="text-align:center"><?php echo $i; ?></td>
	<td width="12%" style="text-align:center"><?php echo date("d/m/Y", strtotime($cost['cost_date_ct'])); ?></td>
	<td width="20%" style="text-align:left"><?php echo $this->Person->get_info($cost['cost_employees'])->first_name;
                                                        echo ' '.$this->Person->get_info($cost['cost_employees'])->last_name?></td>
   
	<td width="29%" style="text-align:left; line-height: 20px"><div style="margin: 3px"><?php echo str_replace(' hình thức', '<br> hình thức', $cost['comment'])?></td>
        <?php
        if($cost['id_customer']==-1){
        ?>
        <td width="20%" style="text-align:center">Khách lẻ</td>
        <?php }else {
             if($this->Customer->get_info($cost['id_customer'])->company_name != NULL){    
        ?>
              <td width="20%" style="text-align:left"><?php echo $this->Customer->get_info($cost['id_customer'])->company_name;?></td>
          <?php }elseif($this->Customer->get_info($cost['id_customer'])->manages_name != NULL){?>
               <td width="20%" style="text-align:left"><?php echo $this->Customer->get_info($cost['id_customer'])->manages_name;?></td>
          <?php }else{?>
	<td width="20%" style="text-align:left"><?php echo $this->Person->get_info($cost['id_customer'])->first_name
													.' '. $this->Person->get_info($cost['id_customer'])->last_name;?></td>
          <?php }?>
        <?php }?>
         <?php if($cost_type == 'thu' || $cost_type == 'all'){?>                                               
	<td width="11%" style="text-align: right;"><?php
		if($cost['form_cost'] == 0) echo to_currency($cost['money']); 
		else echo null ; ?>
	</td>
         <?php }if($cost_type == 'chi' || $cost_type == 'all'){?>
	<td width="11%" style="text-align: right;"><?php 
		if($cost['form_cost'] == 1) echo to_currency($cost['money']); 
		else echo null ; 
	?></td>
         <?php }?>
</tr>
<?php $i++; }  }
	else { ?>
	<tr><td colspan ="7">Không có dữ liệu thu chi của nhân viên !</td></tr>
<?php	
	}
 ?>
<tr style="font-weight:bold; height:30px;">
    <td style="text-align:center" colspan="5">TỔNG CỘNG</td>
      <?php if($cost_type == 'thu' || $cost_type == 'all'){?>
	<td style="text-align:right;"><?php echo to_currency($cost_tien_thu); ?></td>
      <?php }if($cost_type == 'chi' || $cost_type == 'all'){?>
	<td style="text-align:right;"><?php echo to_currency($cost_tien_chi); ?></td>
          <?php }?>


</tr>

</table>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>