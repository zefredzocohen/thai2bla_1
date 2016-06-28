<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function (){
    var table_columns = ["", 'company_name', "last_name", 'first_name', 'email', 'phone_number', ''];
    enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>", table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
    enable_delete(<?php echo json_encode(lang("common_confirm_delete")); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
});
function getb(coun, term, per_page){
    $('#sortable_table tr th').unbind();
    var sort = "<?php echo site_url("$controller_name/searching/"); ?>/";
    var head = ["", 'company_name', "last_name", 'first_name', 'email', 'phone_number', ''];
    var paginate = "#pagination tr td";
    enable_sorting(sort, head, paginate, coun, per_page, term);
}
function post_type_cus_form_submit(response){
    if (!response.success){
        set_feedback(response.message, 'error_message', true);
    }else{
        if (jQuery.inArray(response.person_id, get_visible_checkbox_ids()) != -1){
            set_feedback(response.message, 'success_message', false);
        }else //refresh entire table
        {
            do_search(true, function (){
                set_feedback(response.message, 'success_message', false);
            });
        }
    }
}
</script>
<table id="title_bar_new">
    <tr>
        <td id="title_icon">
            <a href="<?php echo base_url()?>accountings" title="Quay lại">
                <div class="newface_back" style="margin-right: 10px"></div>
            </a>
        </td>
        <td id="title" style="width: 30%; margin-left: 60px">
            <?php echo lang('common_list_of') . ' ' . lang('module_' . $controller_name); ?>
        </td>
        <td id="title_search_new">
            <?php echo form_open("$controller_name/search", array('id' => 'search_form')); ?>
            <input type="text" name ='search' id='search' placeholder="Nhập tên hoặc mã tài sản..."/>
            <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner' />
            </form>
        </td>
    </tr>
</table>
<table id="contents">
    <tr>
        <td id="commands">
            <?php $this->load->view('partial/left'); ?>
            <?php 
//            echo anchor(
//                "assets/view_buy_increase/width~550", 
//                'Ghi tăng/ mua', 
//                array('class' => 'none import')
//            );
//            echo anchor(
//                "assets/view_decrease/width~550", 
//                'Ghi giảm', 
//                array('class' => 'none import')
//            );
//            echo anchor(
//                "assets/view/-1/width~550", 
//                'Điều chuyển', 
//                array('class' => 'none import')
//            );
            ?>
        </td>
        <td style="width:10px;"></td>
        <td>
            <div style="margin-bottom: 10px;margin-top: 3px;">
                <?php
                echo anchor("$controller_name/view/-1/width~$form_width", lang($controller_name . '_new'), array('class' => 'thickbox none new-1', 'title' => lang($controller_name . '_new')));
                ?>
                /
                <?php echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete', 'class' => 'delete_inactive new-1')); ?>	
                /
                <?php echo anchor("$controller_name/update_value_asset", "Cập nhật giá trị", array('id' => '', 'class' => 'new-1')); ?>	
                / <?= anchor("$controller_name/calculate_allocate/width~555", "Tính phân bổ", array('class' => 'thickbox new-1', 'title' => 'Tính phân bổ'));?>
            </div>
            <div id="item_table">
                <div id="table_holder">
                    <?php echo $manage_table; ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<div id="feedback_bar"></div>
</div></div>
<?php $this->load->view("partial/footer"); ?>