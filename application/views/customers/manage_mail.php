<?php $this->load->view("partial/header"); ?>

<div id="content_area_wrapper">

    <div id="content_area">
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">                    
                    <a href="<?php echo base_url('customers') ?>" ><div class="newface_back"></div></a>
                </td>
                <td id="title" style="width: 300px">&nbsp;Mail template</td>               
                <td id="title_search_new"></td>
            </tr>
        </table>
        <table id="contents">
            <tr>
                <td id="commands">           

                    <div id="new_button">
                        <?php
                        echo anchor("$controller_name/view_mail/-1", 'Tạo mới mail', array('class' => 'none new', 'title' => 'Tạo mới mail'));
                        echo anchor("$controller_name/delete_mail", $this->lang->line("common_delete"), array('id' => 'delete', 'class' => 'delete_inactive'));
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
        <script type="text/javascript">
            $(document).ready(function ()
            {
                var table_columns = ["", "mail_title", '', ''];
                enable_sorting("<?php echo site_url("$controller_name/sorting_mail"); ?>", table_columns, <?php echo $per_page; ?>);
                enable_select_all();
                enable_checkboxes();
                enable_row_selection();

                enable_delete(<?php echo json_encode('Bạn muốn xóa mail này?'); ?>,<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);
                //enable_bulk_edit(<?php echo json_encode(lang($controller_name . "_none_selected")); ?>);


            });



        </script>
        <div id="feedback_bar"></div>
    </div></div>
<?php $this->load->view("partial/footer"); ?>