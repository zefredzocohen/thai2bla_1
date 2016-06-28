<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new">
	<tr>
		<td id="title_icon">
            <a href="<?= "item_kits/view_list_kcs/$id" ?>" ><div class="newface_back"></div></a>
		</td>
        <td id="title" style="width: 600px">&nbsp; Nhập kho thành phẩm
		</td>
        <td id="title_search_new" style="width: 200px;">
		</td>
	</tr>
</table>
<?php echo form_open_multipart("item_kits/save_import_kcs/$id/$request_id/$id_processes", array('id' => 'post_item_kit_form_submit')); ?>
<div id="content_order">
        <table class="item_kit_size">
            <tr style="height: 26px">
                <th style="width: 15%">Tên mẫu</th>
                <th style="width: 10%">Size</th>
                <th style="width: 20%">Mã sản phẩm</th>
                <th style="width: 10%">SL</th>
                <th style="width: 20%">Giá nhập</th>
                <th style="width: 20%">Giá bán</th>
            </tr>
            <?php
            $item_production_info = $this->Item_kit->get_info_item_production($id);
            $item_kit_info = $this->Item_kit->get_info($item_production_info->item_kit_id);
            $date_kcs = $this->Item_kit->get_info_kcs_history_phase_max_date($request_id, $id_processes)->date_kcs;
            $info_history_kcs = $this->Item_kit->get_info_kcs_history_phase_by_date($request_id, $id_processes, $date_kcs)->result();
            
            foreach ($info_history_kcs as $ihk){
                foreach ($request_feature as $f){
                    $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
                    $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id,$f->feature_id);
                    $count = $this->Item_kit->get_item_kit_request_feature($request_id, $f->feature_id)->num_rows();
                    $item_kit_feature_info = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
                    ?>
                    <tr>
                        <td rowspan="<?= $count ?>" ><?= $info_feature->name_feature ?></td>
                        <?php
                        foreach ($info_sizes as $is) {
                            $info_kcs = $this->Item_kit->get_info_kcs($request_id, $is->id, $id_processes);
                            $kcs_id = $info_kcs->kcs_id;
                            $info_kcs_history_audi = $this->Item_kit->get_info_kcs_history_audi($request_id, $id_processes, $kcs_id);
                            ?>
                            <td><?= 
                                form_input(array(
                                    name => "size_id[$kcs_id]",
                                    id => "size_id$kcs_id",
                                    'class' => size_id,
                                    value => $kcs_id,
                                    type => hidden
                                )).$is->size ?>
                            </td>
                            <td><?= 
                                form_input(array(
                                    name => "item_number[$kcs_id]",
                                    id => "item_number$kcs_id",
                                    'class' => item_number,
                                    value => $item_kit_info->item_kit_number.'_'.$item_kit_feature_info->number_feature.'_'.$is->size,
                                ))?>
                            </td>
                            <td><?= 
                                form_input(array(
                                    name => "quantity[$kcs_id]",
                                    id => "quantity$kcs_id",
                                    'class' => quantity,
                                    value => $info_kcs_history_audi->quantity_success2,
                                    readonly => ''
                                ))?>
                            </td>
                            <td><?= 
                                form_input(array(
                                    name => "cost_price[$kcs_id]",
                                    id => "cost_price$kcs_id",
                                    'class' => cost_price,
                                    size => 21
                                ))?>
                            </td>
                            <td><?= 
                                form_input(array(
                                    name => "unit_price[$kcs_id]",
                                    id => "unit_price$kcs_id",
                                    'class' => unit_price,
                                    size => 21
                                ))?>
                            </td>
                    </tr>
                <?php }
                }
            }?>
        </table> 
        <?php
        echo form_submit(array(
            'value' => 'Thực hiện',
            'class' => 'submit_button float_right',
            'style' => 'margin-bottom:20px',
            'name' => 'save_item'
        ));
        ?>
</div>
</div></div>
<?php $this->load->view("partial/footer"); ?>
<script>
$(".submit_button").click(function (){alert('abc');
    $.ajax({
        type: "post",
        url: "<?php echo site_url() . '/item_kits/check_product_store'; ?>",
        success: function (data) {
            if (data == 0) {
                alert('Chưa tồn tại kho thành phẩm ! Vui lòng kiểm tra lại');return false;
            }
        }
    });
    alert('abc');
    return false;
});    
</script>

<style>
.submit_button{    
    padding: 8px 10px;
    line-height: 20px;
    font-size: 12px;
    font-weight: bold;
    color: #FFFFFF;
    background: #428BCA;
    border: 1px solid #EEEEEE;
    cursor: pointer;
    float: left !important;
    margin-left: 20px;
    margin-top: 20px;    
}
.item_kit_size{
    width:99%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
.item_kit_size tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.item_number, .quantity{
    border: none;
    background: inherit
} 
.quantity{
    text-align: right
}
.cost_price, .unit_price{
    text-align: right;
    padding-right: 4px
} 
.item_kit_size tr td, .item_kit_size tr th{
    border: 1px solid #CDCDCD; padding: 3px 8px 
}
#content_order{
    width: 800px;
    margin: 0px auto;
}
</style>