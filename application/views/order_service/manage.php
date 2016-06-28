<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() { 	
	var table_columns = ["",'number',"symbol",'create_date','order_date','','',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting_order_service"); ?>",table_columns, <?php echo $per_page; ?>);
	enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_delete(<?php echo json_encode(lang("common_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
}); 
function post_type_cus_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{ 
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			
			//update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);		
            window.location.reload(true);
		}
		else //refresh entire table
		{
//			do_search(true,function()
//			{
//				//highlight new row
//				//highlight_row(response.customer_type_id);
//				set_feedback(response.message,'success_message',false);		
//			});
            window.location.reload(true);
		}
	}
}
</script>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
		</td>
        <td id="title" style="width: 38%">
			<?php echo lang('common_list_of').' Hóa đơn dịch vụ' ?>
		</td>
		<td id="title_search_new">
		</td>
	</tr>
</table>
<table id="contents">
	<tr>
		<td id="commands">
			<?php $this->load->view('partial/left'); ?>
		</td>
	<td style="width:10px;"></td>
	<td>
		<div style="margin-bottom: 10px;margin-top: 3px;">
			<?= anchor(
                "$controller_name/view_order_service/-1/width~789",
				'Tạo mới hóa đơn',
				array(
                    'class'=>'thickbox none new-1', 
                    'title'=> 'Tạo mới hóa đơn'
                )
            ) ?> /
            <?= anchor(
                "$controller_name/delete_order_service",
                $this->lang->line("common_delete"),
                array('id'=>'delete', 'class'=>'delete_inactive new-1')
            ) ?>	
		</div>
	 	<div id="item_table">
            <div id="table_holder">
                <?= $manage_table ?>
            </div>
            <div id="pagination">
                <?= $pagination; ?>
            </div>
		</div>
	</td>
	</tr>
</table>
<div id="feedback_bar"></div>
</div></div>
<?php $this->load->view("partial/footer"); ?>