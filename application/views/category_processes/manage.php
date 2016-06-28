<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <script type="text/javascript">
            $(document).ready(function () {
                var table_columns = ["", "cat_pro_id", 'cat_pro_name', ''];
                enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>", table_columns, <?php echo $per_page; ?>);
                enable_select_all();
                enable_checkboxes();
                enable_row_selection();
                enable_search('<?php echo site_url("$controller_name/suggest"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
                enable_delete("Bạn có chắc chắn muốn xóa dữ liệu đã chọn?", "Bạn chưa chọn dữ liệu cần xóa!");
                enable_cleanup(<?php echo json_encode(lang("items_confirm_cleanup")); ?>);
            }
            );
            function post_item_form_submit(response) {
                if (!response.success) {
                    set_feedback(response.message, 'error_message', true);
                } else {
                    //This is an update, just update one row
                    if (jQuery.inArray(response.item_id, get_visible_checkbox_ids()) != -1) {
                        update_row(response.item_id, '<?php echo site_url("$controller_name/get_row") ?>');
                        set_feedback(response.message, 'success_message', false);
                    } else { //refresh entire table
                        do_search(true, function () {
                            //highlight new row
                            highlight_row(response.item_id);
                            set_feedback(response.message, 'success_message', false);
                        });
                    }
                }
            }
        </script>

        <table id="title_bar_new">
            <tr>
                <td id="title_icon">                   
                    <a href="<?= site_url("/item_kits");?>"><div class="newface_back"></div></a>                 
                </td>
                <td id="title" style="width: 300px">
                    &nbsp;<?php echo lang('module_' . $controller_name); ?>
                </td>               
                <td id="title_search_new">
                    <?php echo form_open("$controller_name/search", array('id' => 'search_form')); ?>
                    <input type="text" name ='search' id='search' placeholder="Nhập nhóm sản phẩm ... "/>
                    <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner' />
                    </form>                    
                </td>
            </tr>
        </table>
        <table id="contents">
            <tr>
                <td id="commands">
                    <div id="new_button">
                        <?php
                        if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {
                            echo anchor("$controller_name/view/-1/width~400/height~200", "Tạo mới nhóm công đoạn", array(
                                'class' => 'thickbox none new',
                                'title' => "Tạo mới nhóm công đoạn")
                            );
                        }
                        if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {
                            echo anchor("$controller_name/delete", lang("common_delete"), array(
                                'id' => 'delete',
                                'class' => 'delete_inactive'
                            ));
                        }
                        ?>
                    </div>
                </td>
                <td style="width:10px;"></td>
                <td >            
                    <div id="item_table">
                        <div id="table_holder"> <?php echo $manage_table; ?> </div>
                    </div>
                    <div id="pagination"> <?php echo $pagination; ?> </div></td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>