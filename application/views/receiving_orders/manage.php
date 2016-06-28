<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <script type="text/javascript">
            $(document).ready(function () {
                var table_columns = ["receiving_id", 'receiving_time', '', 'supplier_id', 'employee_id', '', '', '', '', ''];
                enable_sorting("<?php echo site_url("receivings/receiving_order_sorting"); ?>", table_columns, <?php echo $per_page; ?>);
                enable_search('<?php echo site_url("receivings/receiving_order_suggest"); ?>',<?php echo json_encode(lang("common_confirm_search")); ?>);
                enable_select_all();
                enable_checkboxes();
                enable_row_selection();
                enable_delete(<?php echo json_encode(lang($controller_name . "_confirm_delete")); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
               $('#start_date').datePicker({startDate: '01-01-1950'}).bind(
                        'dpClosed',
                        function (e, selectedDates) {
                            var d = selectedDates[0];
                            if (d) {
                                d = new Date(d);
                                $('#end_date').dpSetStartDate(d.addDays(0).asString());
                            }
                        }
                );
                $('#end_date').datePicker().bind(
                        'dpClosed',
                        function (e, selectedDates) {
                            var d = selectedDates[0];
                            if (d) {
                                d = new Date(d);
                                $('#start_date').dpSetEndDate(d.addDays(0).asString());
                            }
                        }
                );
            });
            function post_receiving_form_submit(response)
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
                            highlight_row(response.item_id);
                            set_feedback(response.message, 'success_message', false);
                        });
                    }
                }
            }
        </script>
         <table id="title_bar">
            <tr>
                <td id="title_icon">
                         <a href="<?php echo base_url()?>receivings" ><div class="newface_back"></div></a></td>
                <td id="title">Thông tin hóa đơn nhập hàng</td>
                <td id="title_search" style="width: 530px;">
                    <div style="float: left; margin-top: 10px;">
                        <table>
                            <tr>
                                <td>
                                    <input placeholder="Từ ngày" type="text" class="date-pick" id="start_date" name="start_date" 
                                           value='' style=" background-color: #ffffff; width: 82px; font-size: 14px; margin-top: 0px; " />
                                </td>
                                <td>  
                                    <input placeholder="đến ngày" type="text" class="date-pick" id="end_date" name="end_date" 
                                           value='' style=" background-color: #ffffff; width: 82px; font-size: 14px; margin-top: 0px; margin-left: 10px; float: left;" />
                                </td>
                                <td>
                                       <?php echo form_open("receivings/receiving_order_search", array('id' => 'search_form', 'style' => 'width: 268px; float:right; ')); ?>    
                                    <input type="text" name ='search' id='search' placeholder='Nhập mã nhập hàng' style="font-size: 14px; "/>
                                    <img src='<?php echo base_url() ?>images/spinner_small.gif' alt='spinner' id='spinner'  />				
                                    </form>
                                </td>
                            </tr>
                        </table>	
                    </div>                    
                </td>
            </tr>
        </table>                                
        <table id="contents">
            <tr>
                <td id="commands">
                    <div id="new_button">		    
                        <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
                            <?php
                            echo
                            anchor("$controller_name/delete_receiving", lang("common_delete"), array('id' => 'delete',
                                'class' => 'delete_inactive'));
                            ?> 
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
                    <div id="pagination"> <?php echo $pagination; ?> </div>
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>