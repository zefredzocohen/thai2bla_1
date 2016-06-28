<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function()
{
	 var table_columns = [];
	 enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
     enable_select_all();
     enable_checkboxes();
    // enable_row_selection();
     //enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
     enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    // enable_bulk_edit(<?php echo json_encode(lang($controller_name."_none_selected"));?>);
     enable_cleanup(<?php echo json_encode(lang($controller_name."_confirm_cleanup"));?>);

});
<!-- phan lam -->
function tstb_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.id_tstb,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.id_tstb,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.id_tstb);
				set_feedback(response.message,'success_message',false);
			});
		} 
		set_feedback(response.message,'success_message',false);
	} 
}
<!-- end phan lam -->
// function post_bulk_form_submit(response)
// {
// 	if(!response.success)
// 	{
// 		set_feedback(response.message,'error_message',true);
// 	}
// 	else
// 	{
// 		set_feedback(response.message,'success_message',false);
// 		setTimeout(function(){window.location.reload();}, 2500);
// 	}
// }

// function select_inv(){
	
// 	 if (confirm(<?php echo json_encode("This applies to all the items in the inventory"); ?>))
//     	{
// 			$('#select_inventory').val(1);
// 			$('#selectall').css('display','none');
// 			$('#selectnone').css('display','block');
// 			$.post('<?php echo site_url("items/select_inventory");?>', {select_inventory: $('#select_inventory').val()});
// 		}
		
// 	}
// 	function select_inv_none(){
	
// 			$('#select_inventory').val(0);
// 			$('#selectnone').css('display','none');
// 			$('#selectall').css('display','block');
// 			$.post('<?php echo site_url("items/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});
			
// 	}
	
</script>
<?php 
	// $this->load->model('Nhomts_thietbis');
	// $data=$this->Nhomts_thietbis->count_all();
	// print_r($data);
 ?>
 <div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
		</td>
		<td id="title" >
			<?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?>
		</td>
		<td id="title_search_new">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
				<input  type="text" name ='search' id='search' placeholder="Nhập tên nhóm thiết bị..."/>
				<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
			</form>
		</td>
	</tr>
</table>
<table id="contents">
	<tr>
		<td id="commands">
			<div id="new_button">
			
				<?php echo 
					anchor("$controller_name/view/-1/width~$form_width",
					lang($controller_name.'_new'),
					array('class'=>'thickbox none new', 
						'title'=>lang($controller_name.'_new')));
				?>

				<?php echo 
					anchor("$controller_name/delete",
					lang("common_delete"),
					array('id'=>'delete', 
						'class'=>'delete_inactive')); 
				?>
				
			</div>
		</td>
		<td style="width:10px;"></td>
		<td >
		<?php if($total_rows > $per_page) { ?>
		<center><div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer">
		<?php echo lang('items_all').' <b>'.$per_page.'</b> '.lang('items_select_inventory').' <b style="text-decoration:underline">'.$total_rows.'</b> '.lang('items_select_inventory_total'); ?></div>
		<div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer">
		<?php echo '<b>'.$total_rows.'</b> '.lang('items_selected_inventory_total').' '.lang('items_select_inventory_none'); ?></div></center>
		<?php 
		}
		echo form_input(array(
		'name'=>'select_inventory',
		'id'=>'select_inventory',
		'style'=>'display:none',
		)		
	); ?>
		  <div id="item_table">
			<div id="table_holder">
			<?php echo $manage_table; ?>
			</div>
			</div>
			<div id="pagination">
				<?php echo $pagination;?>
			</div>
		</td>
	</tr>
</table>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script>
$(document).ready(function()
{	
	$('#start-date').datePicker({startDate: '01-01-1950'});
	$('#end-date').datePicker({startDate: '01-01-1950'});
});
</script>
