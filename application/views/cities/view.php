<style type="text/css">
.datagrid{
	margin:10px 200px;
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
<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div class="datagrid">
<table id="city">
	<thead>
		<th>Mã vùng</th>
		<th>Thành phố</th>
	</thead>
	<tbody>
		<?php 
			if($cities != null ){
				foreach($cities as $city){
		
		?><tr>
			<td><?php echo $city['id_city']; ?></td>
			<td><?php echo $city['name']; ?></td>	
		 </tr>
		<?php	} } else { ?>
		<tr>
			<td colspan="2">Không có dữ liệu </td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>
<?php $this->load->view("partial/abouts"); ?>
</div></div>
<?php $this->load->view("partial/footer"); ?>