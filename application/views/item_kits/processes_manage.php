<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <script type="text/javascript">
            $(document).ready(function () {
                var table_columns = ['', 'id_processes', 'name_processes', 'cat_pro_id', ''];
                enable_sorting("<?php echo site_url("$controller_name/sorting_processes"); ?>", table_columns, <?php echo $per_page; ?>);
                enable_select_all();
                enable_checkboxes();
                enable_row_selection();
                enable_search('<?php echo site_url("$controller_name/suggest_processes"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
                enable_delete(<?php echo json_encode("Bạn có chắc chắn muốn xóa các công đoạn đã chọn?"); ?>,<?php echo json_encode("Vui lòng chọn công đoạn cần xóa!"); ?>);
            });
            function post_item_kit_form_submit(response) {
                if (!response.success) {
                    set_feedback(response.message, 'error_message', true);
                } else {
                    //This is an update, just update one row
                    if (jQuery.inArray(response.item_id, get_visible_checkbox_ids()) != -1) {
                        update_row(response.item_id, '<?php echo site_url("$controller_name/get_processes_data_row") ?>');
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
                    <?php
                    if ($controller_name == items) {
                        ?>
                        <img src='<?php echo base_url() ?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
                    <?php } else {
                        ?>
                        <a href="<?php echo base_url()?>item_kits" ><div class="newface_back"></div></a>
                        <?php
                    }
                    ?>
                </td>
                <td id="title" style="width: 600px">
                    <?php echo '&nbsp;' . lang('item_kits_processes'); ?>
                </td>
                <td id="title_search_new">
                    <?php echo form_open("$controller_name/search_processes", array('id' => 'search_form')); ?>
                    <div style="position: absolute; right: 280px;">
                        <select name="cat_pro" id="cat_pro">
                            <option value="">Chọn nhóm công đoạn</option>
                            <?php
                            foreach ($category_processes as $cat_pro) {
                                echo "<option value='" . $cat_pro->cat_pro_id . "'>$cat_pro->cat_pro_name</option>";
                            }
                            ?>
                        </select>
                    </div>                    
                    <input type="text" name ='search' id='search' placeholder="<?= lang("item_kits_input_processes_search"); ?>"/>
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
                        echo anchor("$controller_name/view_processes/-1/width~500", lang($controller_name . '_new_processes'), array(
                            'class' => 'thickbox none new',
                            'title' => lang($controller_name . '_new_processes')
                        ));
                        echo anchor("$controller_name/delete_process", lang("common_delete"), array(
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
                <div id="table_holder">  <?php echo $manage_table; ?></div>
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
    #cat_pro{
        padding: 2px;
    }
    #cat_pro option{
        padding: 3px 2px;
    }
</style>