<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function()
{
    var table_columns = ["",'giftcard_number',"value",'',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
	enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	
	$('#generate_barcodes').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("giftcards/generate_barcodes");?>/'+selected.join('~'));
    });

$('#get_money').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("giftcards/get_money");?>/'+selected.join('~'));
    });

$('#return_money').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("giftcards/return_money");?>/'+selected.join('~'));
    });
	$('#generate_barcode_labels').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("giftcards/generate_barcode_labels");?>/'+selected.join('~'));
    });
});

function getb(coun,term,per_page)
{	
	$('#sortable_table tr th').unbind();
	var sort="<?php echo site_url("$controller_name/searching/"); ?>/";
	var head = ["",'giftcard_number',"value",'',''];
	var paginate="#pagination tr td";
	enable_sorting(sort,head,paginate,coun,per_page,term);
 }

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{
			sortList: [[1,0]],
			headers:
			{
				0: { sorter: false},
				3: { sorter: false}
			}
		});
	}
}

function post_giftcard_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.giftcard_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.giftcard_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.giftcard_id);
				set_feedback(response.message,'success_message',false);
			});
		}
	}
}

//
function post_giftcard_form_submit1(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.giftcard_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.giftcard_id,'<?php echo site_url("$controller_name/get_money")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.giftcard_id);
				set_feedback(response.message,'success_message',false);
			});
		}
	}
}

</script>

<table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
		</td>
		<td id="title">
			<?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?>
		</td>
		<td id="title_search_new">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
                    <input type="text" name ='search' id='search' style="margin: 0 !important" placeholder="Nhập mã thẻ..."/>
				<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
			</form>
		</td>
	</tr>
</table>


<table id="contents">
	<tr>
		<td id="commands">
			<div id="new_button">
				<?php //echo 
					//anchor("$controller_name/view/-1/width~$form_width",
					//lang($controller_name.'_new'),
					//array('class'=>'thickbox none new', 
					//	'title'=>lang($controller_name.'_new')));
				?>
				<!-- add new in hoa don-->
				<?php echo anchor("$controller_name/create_new_giftcard",
					lang($controller_name.'_new'),
					array('class'=>'none import',
							'id'=>'add_new'
						));
				?>
				
				<!--uyen them-->
				<?php echo anchor("$controller_name/get_money",
					lang('giftcards_get_money'),
					array('class'=>'none import',
							'id'=>'get_money'
						));
				?>
				<?php echo anchor("$controller_name/return_money",
					lang('giftcards_money_return'),
					array('class'=>'none import',
							'id'=>'return_money'

						));
				?>
				<!--end uyen them-->
				<?php echo 
					anchor("$controller_name/generate_barcode_labels",
					lang("common_barcode_labels"),
					array('id'=>'generate_barcode_labels', 
						'class' => 'generate_barcodes_inactive',
						
						'title'=>lang('common_barcode_labels'))); 
				?>
				
				<?php echo 
					anchor("$controller_name/generate_barcodes",
					lang("common_barcode_sheet"),
					array('id'=>'generate_barcodes', 
						'class' => 'generate_barcodes_inactive',
						'target' =>'_blank',
						'title'=>lang('common_barcode_sheet'))); 
				?>
					
				<?php echo 
					anchor("$controller_name/delete1",
					lang("common_delete"),
					array('id'=>'delete', 
						'class'=>'delete_inactive')); 
				?>
				
				<?php echo anchor("$controller_name/excel_export",
					lang('common_excel_export'),
					array('class'=>'none import'));
				?>

			</div>
		</td>
		<td style="width:10px;"></td>
		<td>
 <div id="item_table">
			<div id="table_holder">
			<?php echo $manage_table; ?>
			</div>
			</div>
		<div id="pagination">
				<?php echo $pagination;?>
			</div>
		</tr>
</table>
<div id="feedback_bar"></div>
</div></div>
<?php $this->load->view("partial/footer"); ?>
	