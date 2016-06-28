<?php $this->load->view('partial/header'); ?>
<table id="contents">
	<tr>
		<td id="commands">
			<div id="new_button">

				<?php $this->load->view('partial/left'); ?>
				
			</div>
		</td>
		<td style="width:10px;"></td>
		<td>
		<ul id="report_list">
		<li class="first"> 
				<h3>Báo cáo</h3>
				<ul class="noibat">
					<li class="summary"><a href="<?php echo site_url('costs/report_cdkts');?>">Bảng cân đối kế toán</a></li>
					<li class="detailed"><a href="<?php echo site_url('costs/report_dongtien');?>">Lưu chuyển tiền tệ</a></li>				
				</ul>
		</li>
		<li class="second">
				<h3>Báo cáo</h3>
				<ul class="noibat">
					<li class="summary"><a href="<?php echo site_url('reports/detailed_trading');?>">Sản xuất kinh doanh</a></li>
					<li class="detailed"><a href="<?php echo site_url('costs/excel_export');?>">Tài khoản</a></li>				
				</ul>
		</li>
		</ul>
		</td>
	</tr>
</table>
<?php $this->load->view('partial/footer'); ?>