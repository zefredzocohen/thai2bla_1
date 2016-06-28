<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
	var table_columns = ['','formula_name','name','transport','tax'];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
  
    enable_search('<?php echo site_url("$controller_name/suggest")?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
	
	<!-- phan lam mua hang -->

	<!-- end phanlam mua hang -->
}); 


function post_person_form_submit(response)
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
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				highlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>
<style type="text/css">

table.mytable{
	margin-bottom:60px;
}
table.mytable th{
	font: bold 11px "Trebuchet MS", Verdana, Arial, Helvetica,
	sans-serif;
	color: #6D929B;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	letter-spacing: 2px;
	text-transform: uppercase;
	text-align: left;
	padding: 6px 6px 6px 12px;
	background: #CAE8EA url(images/bg_header.jpg) no-repeat;
}
table.mytable td {
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	background: #fff;
	padding: 6px 6px 6px 12px;
	color: #6D929B;
}
</style>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new" >
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
		</td>
		<td id="title"  style="width: 500px;">
			<?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?>
		</td>

		<td id="title_search_new">
			<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
				
                    <input type="text" name ='search' id='search' placeholder="Nhập tên công thức"/>
				<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
	
			</form>
		</td>
	</tr>
</table>

<table id="contents">
	<tr>
		<td id="commands">
			<div id="new_button">
                
               	<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/view/-3/width~$form_width",
					$this->lang->line($controller_name.'_new_3'),
						array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new_3')));
				}	
				?>
                
                <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/view/-4/width~$form_width",
					$this->lang->line($controller_name.'_new_4'),
						array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new_4')));
				}	
				?>
				
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
					<?php echo anchor("$controller_name/delete",$this->lang->line("common_delete"),array('id'=>'delete', 'class'=>'delete_inactive')); ?>
				<?php } ?>

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
		</td>
	</tr>
</table>
<div id="feedback_bar"></div>
</div></div>
<?php $this->load->view("partial/footer"); ?>