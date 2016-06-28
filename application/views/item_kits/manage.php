<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <script type="text/javascript">
            $(document).ready(function ()
            {
                var table_columns = ["", "item_kit_number", "name", 'description', 'unit_price', '', ''];
                enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>", table_columns, <?php echo $per_page; ?>);
                enable_select_all();
                enable_checkboxes();
                enable_row_selection();
                enable_search('<?php echo site_url("$controller_name/suggest"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
                enable_delete(<?php echo json_encode(lang($controller_name . "_confirm_delete")); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);

                $('#generate_barcodes').click(function ()
                {
                    var selected = get_selected_values();
                    if (selected.length == 0)
                    {
                        alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
                        return false;
                    }

                    $(this).attr('href', '<?php echo site_url("item_kits/generate_barcodes"); ?>/' + selected.join('~'));
                });

                $('#generate_barcode_labels').click(function ()
                {
                    var selected = get_selected_values();
                    if (selected.length == 0)
                    {
                        alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
                        return false;
                    }

                    $(this).attr('href', '<?php echo site_url("item_kits/generate_barcode_labels"); ?>/' + selected.join('~'));
                });
            });


            function getb(coun, term, per_page)
            {
                $('#sortable_table tr th').unbind();
                var sort = "<?php echo site_url("$controller_name/searching/"); ?>/";
                head = ['', "item_kit_number", "name", 'description', 'unit_price', '', ''];
                var paginate = "#pagination tr td";
                enable_sorting(sort, head, paginate, coun, per_page, term);


            }

            function init_table_sorting()
            {
                //Only init if there is more than one row
                if ($('.tablesorter tbody tr').length > 1)
                {
                    $("#sortable_table").tablesorter(
                            {
                                sortList: [[1, 0]],
                                headers:
                                        {
                                            0: {sorter: false},
                                            5: {sorter: false}
                                        }

                            });
                }
            }

            function post_item_kit_form_submit(response)
            {
                if (!response.success)
                {
                    set_feedback(response.message, 'error_message', true);
                }
                else
                {
                    //This is an update, just update one row
                    if (jQuery.inArray(response.item_id, get_visible_checkbox_ids()) != -1)
                    {
                        update_row(response.item_id, '<?php echo site_url("$controller_name/get_row") ?>');
                        set_feedback(response.message, 'success_message', false);

                    }
                    else //refresh entire table
                    {
                        do_search(true, function ()
                        {
                            //highlight new row
                            highlight_row(response.item_kit_id);
                            set_feedback(response.message, 'success_message', false);
                        });
                    }
                }
            }
        </script>


        <table id="title_bar">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
                </td>
                <td id="title" style="width: 300px !important;">
                    <?php echo lang('common_list_of') . ' ' . lang('module_' . $controller_name); ?>
                </td>
                <td id="title_search_new" >
                    <?php echo form_open("$controller_name/search", array('id' => 'search_form')); ?>
                    <!-- 1-9-15   Hưng Audi OOOO  -->
                    <div style="position: absolute; right: 475px; margin-top: 1px;">
                        <select name="status" id="status" class='form-control'>                        
                            <option value="" selected="selected">Trạng thái</option>
                            <?php
                            for ($i = 1; $i <= 4; $i++) {
                                if ($i == 1)
                                    $status_name = 'Đang thiết kế mẫu';
                                else if ($i == 2)
                                    $status_name = 'Đang sản xuất mẫu';
                                else if ($i == 3)
                                    $status_name = 'Duyệt sản xuất';
                                else if ($i == 4)
                                    $status_name = 'Đang sản xuất';
                                ?>
                                <option value="<?php echo $i ?>"><?= $status_name ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <!-- end OOOO -->
                    <div style="position: absolute; right: 280px; margin-top: 1px;">
                        <select name="categorysearch" class='form-control'>
                            <option value="" selected="selected">Tất cả</option>
                            <?php foreach ($categories as $catsearch) { ?>
                                <option value="<?php echo $catsearch['id_cat']; ?>" ><?php echo $catsearch['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input name ='search' id='search' type="text" 
                           style="margin-left:0px;padding-right:25px;float: right; margin-top: -5px" />
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
                            echo anchor("$controller_name/view/-1/width~$form_width", lang($controller_name . '_new'), array(
                                'class' => 'thickbox none new',
                                'title' => lang($controller_name . '_new'))
                            );
                        }
                        echo anchor("$controller_name/generate_barcode_labels", lang("common_barcode_labels"), array(
                            'id' => 'generate_barcode_labels',
                            'class' => 'generate_barcodes_inactive',
                            'target' => '_blank',
                            'title' => lang('common_barcode_labels'))
                        );

                        echo anchor("$controller_name/generate_barcodes", lang("common_barcode_sheet"), array(
                            'id' => 'generate_barcodes',
                            'class' => 'generate_barcodes_inactive',
                            'target' => '_blank',
                            'title' => lang('common_barcode_sheet'))
                        );
                        if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {
                            echo anchor("$controller_name/delete", lang("common_delete"), array(
                                'id' => 'delete',
                                'class' => 'delete_inactive')
                            );
                        }
                        echo anchor("$controller_name/processes", lang('item_kits_processes'), array(
                            'id' => 'processes',
                            'class' => 'none new',
                            'title' => lang('item_kits_processes')
                        ));
                        echo anchor("category_processes", lang('module_category_processes'), array(
                            'id' => 'category_processes',
                            'class' => 'none new',
                            'title' => lang('module_category_processes')
                        ));
                        ?>
                    </div>
                </td>
                <td style="width:10px;"></td>
                <td id="item_table">
                    <div id="table_holder">
                        <?php echo $manage_table; ?>
                    </div>
                    <div id="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>
