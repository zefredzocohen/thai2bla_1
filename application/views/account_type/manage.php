<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function ()
    {
        var table_columns = ["", 'type_id', "type_name", ''];
        enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>", table_columns, <?php echo $per_page; ?>);
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
        enable_search('<?php echo site_url("$controller_name/suggest"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
        // enable_email('<?php echo site_url("$controller_name/mailto") ?>');
        enable_delete(<?php echo json_encode(lang("common_confirm_delete")); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);


    });


   
    function post_item_form_submit(response)
    {
        if (!response.success)
        {
            set_feedback(response.message, 'error_message', true);
        }
        else
        {
            //This is an update, just update one row
            if (jQuery.inArray(response.person_id, get_visible_checkbox_ids()) != -1)
            {

                //update_row(response.person_id,'<?php echo site_url("$controller_name/get_row") ?>');
                set_feedback(response.message, 'success_message', false);
            }
            else //refresh entire table
            {
                do_search(true, function ()
                {
                    //highlight new row
                    //highlight_row(response.customer_type_id);
                    set_feedback(response.message, 'success_message', false);
                });
            }
        }
    }
    
    function select_inv(){
	
	 if (confirm(<?php echo json_encode("Bạn có muốn chọn tất cả đơn vị sản phẩm không ?"); ?>))
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
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new">
            <tr>
<!--    		<td id="title_icon">
                            <img src='<?php echo base_url() ?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
                            
                    </td>-->
                <td id="title">
                    <?php echo lang('common_list_of') . ' ' . lang('module_' . $controller_name); ?>
                </td>
                <td id="title_search_new">
                    <?php echo form_open("$controller_name/search", array('id' => 'search_form')); ?>
                    <input type="text" name ='search' id='search' placeholder="Nhập tên hoặc mã loại tài khoản..."/>
                    <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner' />
                    </form>
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
                        <?php
                        echo anchor("$controller_name/view/-1/width~$form_width", lang($controller_name . '_new'), array('class' => 'thickbox none new-1', 'title' => lang($controller_name . '_new')));
                        ?>
                        /
                        <?php echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete', 'class' => 'delete_inactive new-1')); ?>	
                    </div>
                    <div id="item_table">
                        <div id="table_holder">
                            <?php echo $manage_table; ?>
                        </div>
                    </div>
                    <div id="pagination">
                        <?php echo $pagination; ?>
                    </div>
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>