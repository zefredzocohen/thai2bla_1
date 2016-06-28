<?php $this->load->view('partial/header');?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function()
{
	var table_columns = ["","id_cat",'name','parentid','anh',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_bulk_edit(<?php echo json_encode(lang($controller_name."_none_selected"));?>);
   <?php /*?> enable_cleanup(<?php echo json_encode(lang("items_confirm_cleanup"));?>);<?php */?>

    $('#generate_barcodes').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("items/generate_barcodes");?>/'+selected.join('~'));
    });

	$('#generate_barcode_labels').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
    		return false;
    	}

    	$(this).attr('href','<?php echo site_url("items/generate_barcode_labels");?>/'+selected.join('~'));
    });
	$('#shopping_item').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_shopping')); ?>);
    		return false;
    	}
		// alert(selected);
    	 $(this).attr('href','<?php echo site_url("items/shopping");?>/'+selected.join('~'));
    });
	$('#trading_item').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_trading')); ?>);
    		return false;
    	}
		// alert(selected);
    	 $(this).attr('href','<?php echo site_url("items/trading");?>/'+selected.join('~'));
    });
	<!-- phan lam thong bao -->

<!-- phan lam -->
function post_bangcap_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.id_bangcap,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.id_bangcap,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);

		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.id_bangcap);
				set_feedback(response.message,'success_message',false);
			});
		}
	}
}
<!-- end phan lam -->
function post_bulk_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);
	}
	else
	{
		set_feedback(response.message,'success_message',false);
		setTimeout(function(){window.location.reload();}, 2500);
	}
}

function select_inv(){
	
	 if (confirm(<?php echo json_encode("This applies to all the items in the inventory"); ?>))
    	{
			$('#select_inventory').val(1);
			$('#selectall').css('display','none');
			$('#selectnone').css('display','block');
			$.post('<?php echo site_url("items/select_inventory");?>', {select_inventory: $('#select_inventory').val()});
		}
		
	}
	function select_inv_none(){
	
			$('#select_inventory').val(0);
			$('#selectnone').css('display','none');
			$('#selectall').css('display','block');
			$.post('<?php echo site_url("items/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});
			
	}
	


</script>
<!-- todo  -->
<table id="title_bar_new">
  <tr>
    <td id="title_icon"><img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /></td>
    <td id="title"><?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?></td>
    <td id="title_search_new" style="width:519px;">
	<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
      <!--<select name="categorysearch"  class='form-control'>
        <option value="" selected="selected">Tất cả</option>
        <?php foreach ($categories as $catsearch){ ?>
        <option value="<?php echo $catsearch['id_cat']; ?>" >
		<?php echo $catsearch['name']; ?></option>
        <?php } ?>
      </select>-->
                <input type="text" name ='search' id='search' placeholder="Nhập tên hoặc mã bằng cấp..."/>
      <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
      </form>
      </td>
  </tr>
</table>
<!-- end header -->
<table id="contents">
  <tr>
    <td id="commands"><div id="new_button">
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo 
          anchor("$controller_name/view/-1/width~$form_width",
          lang($controller_name.'_new'),	
          array('class'=>'thickbox none  new-1', 
            'title'=>lang($controller_name.'_new')));
        ?>
        <?php } ?>
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo 
          anchor("$controller_name/delete",
          lang("common_delete"),
          array('id'=>'delete', 
            'class'=>'delete_inactive new-1')); 
			
        ?> 
        	
        <?php } ?>
      </div></td>
    <td style="width:10px;"></td>
    <td ><?php if($total_rows > $per_page) { ?>
      <center>
        <div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer"> <?php echo lang('items_all').' <b>'.$per_page.'</b> '.lang('items_select_inventory').' <b style="text-decoration:underline">'.$total_rows.'</b> '.lang('items_select_inventory_total'); ?></div>
        <div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer"> <?php echo '<b>'.$total_rows.'</b> '.lang('items_selected_inventory_total').' '.lang('items_select_inventory_none'); ?></div>
      </center>
      <?php 
    }
    echo form_input(array(
    'name'=>'select_inventory',
    'id'=>'select_inventory',
    'style'=>'display:none',
    )   
  ); ?>
      <div id="item_table">
        <div id="table_holder"> <?php echo $manage_table; ?> </div>
      </div>
      <div id="pagination"> <?php echo $pagination;?> </div></td>
  </tr>
</table>
</div><!--end content-->
</div><!-- end wrapper-->
<?php $this->load->view('partial/footer');?>

