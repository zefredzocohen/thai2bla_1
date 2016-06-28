<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
		</td>
		<td id="title"><?php echo lang('reports_reports'); ?></td>
		<td> 
		</td>
	</tr>
</table>

<ul id="report_list">
<li class="first"> 
		<h3>Báo cáo tiêu chí</h3>
		<ul class="noibat">		
			<li><a href="<?php echo site_url('reports/sales_generator');?>"><?php echo lang('reports_sales_search'); ?></a></li>		
		</ul>
	</li>
	<li class="full">
		<h3>Giao dịch</h3>
		<ul class="noibat">
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_sales');?>">Báo cáo đơn hàng</a></li>
			<li class="summary"><a href="<?php echo site_url('reports/detailed_trading');?>">Báo cáo xuất hàng</a></li>
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_receiving');?>">Báo cáo nhập hàng</a></li>				
		</ul>
	</li>
	<li class="second">
		<h3><?php echo lang('reports_inventory_reports'); ?></h3>
		<ul class="noibat">
			<li class="summary"><a href="<?php echo site_url('reports/summary_items');?>">Tổng hợp mặt hàng</a></li>
			<li class="detailed"><a href="<?php echo site_url('reports/item_inventory');?>"><?php echo "Chi tiết tồn kho"; ?></a></li>	
			<li class="summary"><a href="<?php echo site_url('reports/congnokh'); ?>">Báo cáo công nợ</a></li>
		</ul>
	</li>
<li class="second"> 
		<h3><?php  echo lang('reports_customers'); ?></h3>
		<ul>	
			<li class="summary"><a href="<?php  echo site_url('reports/summary_customers');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php  echo site_url('reports/specific_customer');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>		
		</ul>
	</li>
	<li class="full">
		<h3><?php  echo lang('reports_employees'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_employees');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_employees');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php  echo site_url('reports/specific_employee');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>
		</ul>
	</li>
	<li class="full">
		<h3><?php  echo lang('reports_sales'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_sales');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_sales');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php  echo site_url('reports/detailed_sales');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('reports_categories'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_categories');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_categories');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>		
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('reports_discounts'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_discounts');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_discounts');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('reports_items'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_items');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_items');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>		
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('module_item_kits'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_item_kits');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_item_kits');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('reports_payments'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_payments');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_payments');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>	
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('reports_suppliers'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_suppliers');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_suppliers');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>
			<li class="detailed"><a href="<?php  echo site_url('reports/specific_supplier');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>					
		</ul>
	</li>
	<li class="second">
		<h3><?php  echo lang('reports_taxes'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/graphical_summary_taxes');?>"><?php  echo lang('reports_graphical_reports'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_taxes');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>			
		</ul>
	</li>
	<li class="first">
	<!-- <li class="third"> -->
		<h3><?php  echo lang('reports_receivings'); ?></h3>
		<ul>
			<li class="detailed"><a href="<?php  echo site_url('reports/detailed_receivings');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>

	</li>
	<li class="second">
		<h3><?php  echo lang('reports_inventory_reports'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/inventory_low');?>"><?php  echo lang('reports_low_inventory'); ?></a></li>
			<li class="summary"><a href="<?php  echo site_url('reports/inventory_summary');?>"><?php  echo lang('reports_inventory_summary'); ?></a></li>	                      
		</ul>
	</li>
	<li class="first">
		<h3><?php  echo lang('reports_deleted_sales'); ?></h3>
		<ul>
			<li class="graphical"><a href="<?php  echo site_url('reports/deleted_sales');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>
		</ul>
	</li>	

	<li class="full">
		<h3><?php  echo lang('reports_giftcards'); ?></h3>
		<ul>
			<li>&nbsp;</li>
			<li class="summary"><a href="<?php  echo site_url('reports/summary_giftcards');?>"><?php  echo lang('reports_summary_reports'); ?></a></li>			
			<li class="detailed"><a href="<?php  echo site_url('reports/detailed_giftcards');?>"><?php  echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>
	<!-- <li class="first"> 
		<h3>Báo cáo tiêu chí</h3>
		<ul>		
			<li><a href="<?php echo site_url('reports/sales_generator');?>"><?php echo lang('reports_sales_search'); ?></a></li>		
		</ul>
	</li> -->

	<li class="first">
		<h3><?php echo lang('reports_register_log_title'); ?></h3>
		<ul>
			
			<li class="detailed"><a href="<?php echo site_url('reports/detailed_register_log');?>"><?php echo lang('reports_detailed_reports'); ?></a></li>			
		</ul>
	</li>

	</ul>
    </div></div>
<?php $this->load->view("partial/footer"); ?>