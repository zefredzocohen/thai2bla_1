<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
<div id="content_area" style="color:#000; line-height: 30px">
    <div style="width:900px">
<?php echo anchor("dttcs/suspended/$id/width~800",
						"<div class='small_button'>".lang('sales_suspended_sales')."</div>",
						array('class'=>'thickbox none','title'=>lang('sales_suspended_sales')));
?>
<h3>Tạo mới</h3>
<?php 
	echo form_open('dttcs/do_lapkehoach/'.$id,array('id'=>'dttc_detail_form'));
?>
Tên dự án: <input type="text" name="name_detail" value=" "/>
Tên khách hàng: <input type="text" name="name_customer" value=" "/>
Chọn hình thức:
<select name='method'>
	<option value="0">Thu</option>
	<option value="1">Chi</option>
</select>
<br />
<br />
Tổng giá trị hợp đồng: <input type="text" name="cost_contract" /> 
<br />
<br />
Tiền ngày 1: <input type="text" name="date_1" />
Tiền ngày 2: <input type="text" name="date_2" />
Tiền ngày 3: <input type="text" name="date_3" />
<br />
Tiền ngày 4: <input type="text" name="date_4" />
Tiền ngày 5: <input type="text" name="date_5" />
Tiền ngày 6: <input type="text" name="date_6" />
<br />
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
);
?>

<div class="datagrid">
<table>
	<thead>
		<th>Tên dự án, công việc</th>
		<th><?php echo $dttc->date_1; ?></th>
		<th><?php echo $dttc->date_2; ?></th>
		<th><?php echo $dttc->date_3; ?></th>
		<th><?php echo $dttc->date_4; ?></th>
		<th><?php echo $dttc->date_5; ?></th>
		<th><?php echo $dttc->date_6; ?></th>
	</thead>
	<tbody>
	<?php if($dttc_details !=null){
		foreach($dttc_details as $dttc_detail){
	?>
		<tr>
			<td><a href="<?php echo base_url(); ?>dttcs/edit_dttc_detail/<?php echo $id;  ?>/<?php echo $dttc_detail['id'] ;?>"><?php echo $dttc_detail['name']; ?></a></td>
			<td><?php echo $dttc_detail['date_1']; ?></td>
			<td><?php echo $dttc_detail['date_2']; ?></td>
			<td><?php echo $dttc_detail['date_3']; ?></td>
			<td><?php echo $dttc_detail['date_4']; ?></td>
			<td><?php echo $dttc_detail['date_5']; ?></td>
			<td><?php echo $dttc_detail['date_6']; ?></td>
		</tr>
	<?php }} ?>
	</tbody>
</table>
</div>
<a href="<?php echo base_url(); ?>dttcs/export_lapkehoach/<?php echo $id; ?>">In excel</a>
    </div></div></div>
<?php $this->load->view('partial/footer'); ?> 
<style type="text/css">
.datagrid{
	margin:10px 10px;
}
.datagrid table { 
	border-collapse: collapse; 
	text-align: left; width: 100%; 
	} 
.datagrid {
	font: normal 12px/150% Arial, Helvetica, sans-serif; 
	background: #fff; overflow: hidden; 
	border: 1px solid #8C8C8C; 
	-webkit-border-radius: 3px; 
	-moz-border-radius: 3px; 
	border-radius: 3px; }
.datagrid table td, .datagrid table th { padding: 3px 20px; }
.datagrid table thead th {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8C8C8C), color-stop(1, #7D7D7D) );
	background:-moz-linear-gradient( center top, #8C8C8C 5%, #7D7D7D 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8C8C8C', endColorstr='#7D7D7D');
	background-color:#8C8C8C; 
	color:#FFFFFF; 
	font-size: 15px; 
	font-weight: bold; 
	border-left: 1px solid #A3A3A3; } 
.datagrid table thead th:first-child { border: none; }
.datagrid table tbody td { 
	color: #7D7D7D; 
	border-left: 1px solid #DBDBDB;
	font-size: 12px;font-weight: normal; }
.datagrid table tbody tr:nth-child(even) td { background: #EBEBEB; color: #7D7D7D; }
.datagrid table tbody td:first-child { border-left: none; }
.datagrid table tbody tr:last-child td { border-bottom: none; }
.datagrid table thead th.midle{ background:#fff; border-top:none;}
</style>