<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
<script type="text/javascript">
    $(document).ready(function () {
        var table_columns = ['', 'request_id', 'comment', 'status', ''];
        enable_sorting("<?php echo site_url("$controller_name/sorting_request_production"); ?>", table_columns, <?php echo $per_page; ?>);
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
        enable_search('<?php echo site_url("$controller_name/suggest_request_production"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);               
        enable_delete(<?php echo json_encode('Bạn có chắc chắn muốn xóa những yêu cầu sản xuất đã chọn ?'); ?>,<?php echo json_encode('Bạn chưa chọn yêu cầu sản xuất nào để xóa !'); ?>);         
    });
    function post_item_kit_form_submit(response) {
        if (!response.success) {
            set_feedback(response.message, 'error_message', true);
        } else {
            //This is an update, just update one row
            if (jQuery.inArray(response.item_id, get_visible_checkbox_ids()) != -1) {
                update_row(response.item_id, '<?php echo site_url("$controller_name/get_request_production_data_row") ?>');
                set_feedback(response.message, 'success_message', false);

            } else { //refresh entire table
                do_search(true, function () {
                    //highlight new row
                    highlight_row(response.item_kit_id);
                    set_feedback(response.message, 'success_message', false);
                });
            }
        }
    }
</script>

        <table id="title_bar_new">
            <tr>
                <td id="title_icon">                    
                    <a href="<?php echo base_url()?>item_kits" ><div class="newface_back"></div></a>                       
                </td>
                <td id="title" style="width: 600px">
                    <?php echo '&nbsp; Yêu cầu sản xuất: ' . $info_item_kit->name; ?>
                </td>
                <td id="title_search_new" style="width: 200px;">
                    <?php echo form_open("$controller_name/search_request_production", array('id' => 'search_form')); ?>
                    <input type="text" name ='search' id='search' placeholder="Mã yêu cầu sản xuất ... "/>
                    <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner' />
                    </form>
                </td>
            </tr>
        </table>

        <table id="contents" >
            <tr>
                <td id="commands">
                    <div id="new_button">
                        <?php 
                        echo anchor("$controller_name/request_estimate/-1/width~750/height~500", lang("item_kits_new_request_estimate"), array(                                
                                'class' => 'thickbox none new',
                                'title' => lang("item_kits_new_request_estimate")
                            ));
                        echo anchor("$controller_name/delete_request_production", lang("common_delete"), array(
                                'id' => 'delete',
                                'class' => 'delete_inactive'
                            ));
                        ?>
                    </div>
                </td>
                <td style="width:10px;"></td>
                <td>
                    <?php if ($total_rows > $per_page) { ?>
                    <center>
                        <div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer">
                            <?php echo lang('items_all') . ' <b>' . $per_page . '</b> ' . lang('items_select_inventory') . ' <b style="text-decoration:underline">' . $total_rows . '</b> ' . lang('items_select_inventory_total'); ?>
                        </div>
                        <div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer">
                             <?php echo '<b>' . $total_rows . '</b> ' . lang('items_selected_inventory_total') . ' ' . lang('items_select_inventory_none'); ?>
                        </div>
                    </center>
                    <?php
                    }
                    echo form_input(array(
                        'name' => 'select_inventory',
                        'id' => 'select_inventory',
                        'style' => 'display:none',
                    ));
                    ?>
                    <div id="item_table">
                        <div id="table_holder">  <?php echo $manage_table;?></div>
                    </div>
                    <div id="pagination"> <?php echo $pagination; ?> </div>
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>
<style type="text/css">
    .li_design_template{
        padding: 3px 0px;
    }
</style>