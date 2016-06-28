<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function (){
    var table_columns = ["", "id", 'name','', ''];
    enable_sorting("<?php echo site_url("$controller_name/sorting_sms"); ?>", table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
	enable_search('<?php echo site_url("$controller_name/suggest_sms");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode('Bạn muốn xóa SMS này?'); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
});
function post_item_form_submit(response){
    if(!response.success){
        set_feedback(response.message,'error_message',true);
    }else{
        //This is an update, just update one row
        if(jQuery.inArray(response.item_id,get_visible_checkbox_ids()) !== -1){
            update_row(response.item_id,'<?php echo site_url("$controller_name/get_row_sms")?>');
            set_feedback(response.message,'success_message',false);
        }else{ //refresh entire table
            do_search(true,function(){
                //highlight new row
                highlight_row(response.item_id);
                set_feedback(response.message,'success_message',false);
            });
        } 
        set_feedback(response.message,'success_message',false);
    } 
}
</script>
<div id="content_area_wrapper">
    <div id="content_area">
		<table id="title_bar_new">
            <tr>
                <td id="title_icon" style="width: 5px !important;">
                    <a href="index.php/customers" ><div class="newface_back"></div></a>
                </td>
                <td id="title" style="width: 300px !important;">Quản lý SMS Brandname</td>
                <td id="title_search_new">
                    <?php echo form_open("$controller_name/search_sms",array('id'=>'search_form')); ?>                        
                        <input style="margin-left:0px;padding-right:25px;float: right;" type="text" name ='search' id='search'/>
                        <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
                    </form>
                </td>
            </tr>
        </table>
        <table id="contents">
            <tr>
                <td id="commands">
                    <div id="new_button">
                        <?php echo anchor("customers", 'Danh sách khách hàng', array('class' => 'none new', 'title' => 'Danh sách mail'));?>
                    </div>
                    <div id="new_button">
                    <?php
                    echo anchor("$controller_name/view_sms/-1/width~450", 'Tạo mới SMS', array(
                        'class' => 'thickbox none new',
                        'title' => 'Tạo mới SMS'
                    ));
                    echo anchor("$controller_name/delete_sms", $this->lang->line("common_delete"), array(
                        'id' => 'delete',
                        'class' => 'delete_inactive',
                        'title' => 'Xóa'
                    ));
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
                        <?php echo $pagination; ?>
                    </div>
                </td>
            </tr>
        </table>        
        <div id="feedback_bar"></div>
    </div>      
</div>
<?php $this->load->view("partial/footer"); ?>