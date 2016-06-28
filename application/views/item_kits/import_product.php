<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
<script type="text/javascript">
    $(document).ready(function () {
        var table_columns = ["import_product_id", '', '',''];
        enable_sorting("<?php echo site_url("$controller_name/sorting_import_product"); ?>", table_columns, <?php echo $per_page; ?>);
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
    });
</script>
        <table id="title_bar">
            <tr>
                <td id="title_icon"><img
                        src='<?php echo base_url() ?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /></td>
                <td id="title">Thông tin Hóa đơn nhập kho thành phẩm</td>
                <td id="title_search" style="width: 530px;">
                </td>
            </tr>
        </table>
        <table id="contents">
            <tr>
                <td>
                    <div id="item_table" style=" ">
                        <div id="table_holder" style="width: 100% !important"><?= $manage_table; ?></div>
                    </div>
                    <div id="pagination" style="width: 100% !important"><?= $pagination; ?></div>
                </td>
            </tr>
        </table>
        <div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>