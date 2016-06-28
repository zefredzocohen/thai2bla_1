<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <script type="text/javascript">
            $(document).ready(function ()
            {
                var table_columns = ["", 'id', "name_inventory", 'description', ''];
                enable_sorting("<?php echo base_url("$controller_name/sorting"); ?>", table_columns, <?php echo $per_page; ?>);
                enable_select_all();
                enable_checkboxes();
                enable_row_selection();
                enable_search('<?php echo base_url("$controller_name/suggest"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
                enable_delete(<?php echo json_encode(lang($controller_name . "_confirm_delete")); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
            });

            function getb(coun, term, per_page)
            {
                $('#sortable_table tr th').unbind();
                var sort = "<?php echo base_url("$controller_name/searching/"); ?>/";
                var head = ["", 'company_name', "last_name", 'first_name', 'email', 'phone_number', ''];
                var paginate = "#pagination tr td";
                enable_sorting(sort, head, paginate, coun, per_page, term);

            }
            function post_inventory_form_submit(response)
            {
                if (!response.success)
                {
                    set_feedback(response.message, 'error_message', true);
                }
                else
                {
                    //This is an update, just update one row
                    if (jQuery.inArray(response.id, get_visible_checkbox_ids()) != -1)
                    {

                        update_row(response.id, '<?php echo base_url("$controller_name/get_row") ?>');
                        set_feedback(response.message, 'success_message', false);
                    }
                    else //refresh entire table
                    {
                        do_search(true, function ()
                        {
                            //highlight new row
                            highlight_row(response.id);
                            set_feedback(response.message, 'success_message', false);
                        });
                    }
                }
            }
        </script>
        <table id="title_bar">
            <tr>
                <td id="title_icon">
                    <a href="<?php echo base_url()?>items" ><div class="newface_back"></div></a>
                </td>
                <td id="title">
                    &nbsp;<?php echo lang('module_' . $controller_name); ?>
                </td>
                <td id="title_search">
                    <?php echo form_open("$controller_name/search", array('id' => 'search_form')); ?>
                    <input type="text" name ='search' id='search'/>
                    <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner' />
                    </form>
                </td>
            </tr>
        </table>
        <table id="contents">
            <tr>
                <td id="commands">
                    <div id="new_button">		
                        <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>					
                            <?php
                            echo anchor("$controller_name/view/-1/width~$form_width", lang($controller_name . '_new'), array('class' => 'thickbox none new', 'title' => lang($controller_name . '_new')));
                            ?>
                        <?php } ?>
                        <!-- phan lam -->	
                        <a href="<?= base_url() ?>items/warehouse" class=" none new">Kiểm kho</a>
                        <a href="<?= base_url() ?>items/next_inventory" class=" none new">Chuyển kho</a>
                        <a href="<?= base_url() ?>items/history_warehouse" class=" none new">Lịch sử kiểm kho</a>
                        <?php echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete', 'class' => 'delete_inactive')); ?>							
                    </div>
                </td>
                <td style="width:10px;"></td>
                <td>
                    <div id="item_table">
                        <div id="table_holder">
                            <?php echo $manage_table; ?>
                        </div>
                    </div>
                    <div id="pagination"> <?php echo $pagination; ?> </div>
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>