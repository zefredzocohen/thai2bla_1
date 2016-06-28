<?php $this->load->view('partial/header'); ?>
<!--<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>css/all.css?<?php echo APPLICATION_VERSION; ?>" />-->
<div id="content_area_wrapper">
    <ul id="error_message_box"></ul>
    <div id="content_area">
        <style type="text/css">
            .submit_button{
                background: none repeat scroll 0 0 #386da2 !important;
                border-radius: 2px;
                box-sizing: content-box;
                color: #fff;
                cursor: pointer;
                font-size: 12px !important;
                font-weight: bold;
                height: 23px;
                line-height: 20px;
                margin-right: 16px;
                margin-top: 14px;
                width: 71px !important;
            }
            #mytable{
                margin-top: 80px;
            }           
            .submit_button1{
                box-sizing: content-box;
                background-color: #4d90fe;
                background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed);
                border: 1px solid #3079ed;
                box-shadow: none;
                color: #fff;
                border-radius: 2px;
                cursor: default;
                font-size: 11px;
                font-weight: bold;
                height: 27px;
                line-height: 27px;
                margin-right: 16px;
                min-width: 54px;
                outline: 0 none;
                padding: 0 8px;
                text-align: center;
                white-space: nowrap;   
            }
            .classinput{
                background-color: #ffffff;
                border: 1px solid #cccccc;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
                border-radius: 4px;
                color: #555555;
                display: inline-block;
                font-size: 14px;
                height: 20px;
                line-height: 20px;
                margin-bottom: 10px;
                padding: 4px 6px;
                vertical-align: middle;
                margin-top: 10px;
            }
            #error_message_box{
                margin-left: 0px;
                background-color: #fcf8e3;
                border: 1px solid #fbeed5;
                border-radius: 4px;
                margin-bottom: 20px;
                padding: 8px 35px 8px 14px;
                text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
                display: none;
                list-style: none;
                color: #b94a48;
            }

            #reg_item_search1{               
                padding:11px 11px 14px;
            } 
            #reg_item_search1 form {
                vertical-align: middle;
            }

            #reg_item_search1 input {
                background: url("./images/pieces/reg_item_search2.png") no-repeat scroll -20px -20px transparent;
                border: medium none;
                font-size: 1.1em;
                padding: 8px 10px;
                width: 460px;
            }
            #new_item_button_register3{
                background:url("./images/pieces/reg_item_search2.png") repeat scroll -559px -80px transparent;
                float:right;
                font-size:.8em;
                height:30px;
                width:170px;
            }
            select{
                height: 30px;
            }
        </style>
        <script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
        <div id='TB_load'><img src='<?php echo base_url() ?>images/loading_animation.gif'/></div>
        <?php
        $this->load->model('Create_invetory');
        $cats = $this->Create_invetory->get_all()->result_array();
        ?>
        <div id="reg_item_search1">
            <?php echo form_open("items/save_item_verifying", array('id' => 'save_verifying')); ?>  
            <div class="field_row clearfix" style="width:100%;">
                <div class='form_field'>
                    <?php echo form_label('Kho kiểm' . ':', 'next_warehouse', array('class' => 'required wide')); ?>
                    <select name="next_warehouse" id="next_warehouse" style="width: 150px;">                        
                        <option value="0" > Kho tổng</option>
                        <?php
                        if ($cats != null) {
                            foreach ($cats as $cat) {
                                if($cat['id'] == ($this->session->userdata('next_warehouse'))){
                                ?>
                                    <option value="<?php echo $cat['id']; ?>" selected="selected"><?php echo $cat['name_inventory']; ?></option>
                                <?php }else{ ?>                                    
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name_inventory']; ?></option>
                            <?php }
                            }
                        }
                        ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <?php 
                        $this->load->model('Category');
                        $category = $this->Category->get_all();
                    ?>
                    <?php echo form_label('Loại sản phẩm' . ':', 'category_item', array('class' => 'wide')); ?>
                    <select name="category_item" id="category_item" style="width: 150px;">
                        <option value="" selected="selected">--Tất cả--</option>                        
                        <?php
                        if ($category != null) {
                            foreach ($category as $value) {
                                if($value['id_cat'] == $this->session->userdata('category_item')){
                                ?>
                                    <option value="<?php echo $value['id_cat']; ?>" selected><?php echo $value['name']; ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $value['id_cat']; ?>"><?php echo $value['name']; ?></option>
                                <?php }
                            }
                        }
                        ?>
                    </select>
                </div>                
            </div>
            <br>
            <?php echo form_input(array('name' => 'item', 'id' => 'item', 'size' => '40', 'accesskey' => 'i')); ?>
            <div id="new_item_button_register3" >
                <?php
                echo anchor("items/view/-1/width~550", "<div class='small_button'><span style='color: #fff;   line-height: 30px;margin-left: 15px;'>" . lang('sales_new_item') . "</span></div>", array('class' => 'thickbox none', 'title' => lang('sales_new_item')));
                ?>
            </div>
            <input type="hidden" name="name_items" value="" id="value_id" placeholder="">  
            <div id="mytable">          
                <table id="contents">
                    <tr>
                        <td id="item_table">
                            <div id="table_holder" style="width: 960px;">
                                <table class="tablesorter report" id="sortable_table">
                                    <thead>
                                        <tr>
                                            <th colspan="" rowspan="" headers=""></th>
                                            <th colspan="" rowspan="" headers="">Mã SP</th>
                                            <th colspan="" rowspan="" headers="">Tên SP</th>
                                            <th colspan="" rowspan="" headers="">Đơn vị tính</th>
                                            <th colspan="" rowspan="" headers="">Giá nhập</th>
                                            <th colspan="" rowspan="" headers="" style="display:none">SL nhập</th>
                                            <th colspan="" rowspan="" headers="">Kho</th>
                                            <th colspan="" rowspan="" headers="">SL kho</th>
                                            <th colspan="" rowspan="" headers="">SL bán</th>
                                            <th colspan="" rowspan="" headers="">SL kiểm</th>
                                            <th colspan="" rowspan="" headers="">Ghi chú</th>
                                        </tr>
                                    </thead>                                
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="submit" class="submit_button" id="submit" value="Thực hiện" name="submit">
            <?php echo form_close(); ?>
            </div>
            <div id="mytable_get_verifying" style="margin-top:20px;">
                <?php $this->load->view('items/get_verifying'); ?>
            </div>
        </div>        
    </div>    
</div>
<?php $this->load->view('partial/footer'); ?>
<script  type="text/javascript">
    $("#item").autocomplete({
        source: '<?php echo site_url("items/item_search_inventory"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#item").val("");
            if ($("#quantity_verifying_" + ui.item.id + "_" + ui.item.id_store).length == 1) {
                $("#quantity_verifying_" + ui.item.id + "_" + ui.item.id_store).val(parseFloat($("#quantity_verifying_" + ui.item.id + "_" + ui.item.id_store).val()) + 1);
            } else {
                $("#mytable #item_table #sortable_table").append(
                    "<tr>"
                        + "<td style='text-align: center; width: 10px;'>"
                            + "<a href='#' onclick='return deleteItemKitRow(this);' title='Xóa'>X</a>"
                        + "</td>"
                        + "<td style='text-align: center'>"
                            +"<input type='hidden' name=item_id[" + ui.item.id + "] value='" + ui.item.id + "'/>" + ui.item.item_number
                        + "</td>"
                        + "<td>" + ui.item.label + "</td>"
                        + "<td>" + ui.item.unit_name + "</td>"
                        + "<td style='text-align: right;'>" + ui.item.cost_price + "</td>"
                        + "<td>"
                            + "<input type='hidden' name=store[" + ui.item.id + "] value='" + ui.item.id_store + "'>" + ui.item.name_inventory
                        + "</td>"
                        + "<td style='text-align: center'>"
                            + "<input type='hidden' name=quantity[" + ui.item.id + "] value='" + ui.item.quantity + "'>" + ui.item.quantity
                        + "</td>"
                        + "<td style='text-align: center'>"
                            + "<input type='hidden' name=quantity_sale[" + ui.item.id + "] value='" + ((ui.item.quantity_sale !== null) ? ui.item.quantity_sale : 0) + "'>" + ((ui.item.quantity_sale !== null) ? ui.item.quantity_sale : 0)
                        + "</td>"
                        + "<td style='text-align: center; padding: 5px 5px;'>"
                            + "<input style='width: 50px; background: none; border: 1px solid #C0C0C0; padding: 5px 5px; text-align: center' type='text' name=quantity_verifying[" + ui.item.id + "] value='0.00' id='quantity_verifying_" + ui.item.id + "' class='quantity_verifying'>"
                        + "</td>"
                        + "<td style='text-align: center; padding: 10px 0px;'>"
                            + "<textarea name=command[" + ui.item.id + "] rows='2' cols='8' style='padding: 5px; font-size: 10px;'></textarea>"
                        + "</td>"
                    + "</tr>"
                );
            }
            $(".quantity_verifying").maskMoney({
                precision: 2
            });
            return false;
        }
    });
    $('#next_warehouse').change(function () {
        $("#mytable #item_table #sortable_table tr td").remove();
        if ($('#next_warehouse').val() != "") {
            $.post('<?php echo site_url("items/set_next_warehouse"); ?>', {next_warehouse: $('#next_warehouse').val()});
        }
    });
    $("#category_item").change(function(){
        $.post('<?php echo site_url("items/set_category_item"); ?>', {category_item: $('#category_item').val()});
    });
    $("#save_verifying").validate({
        // submitHandler: function() {
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules: {            
            next_warehouse:{
                required: true,
            }
        },
        messages: {
            next_warehouse:{
                required: 'Bạn chưa chọn kho cần kiểm kê',
            }
        }
    });
    $("#submit").click(function(){
        if(!$(".quantity_verifying").val()){
            alert("Bạn chưa chọn mặt hàng cần kiểm");
            return false;
        }        
    });
    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();        
        return false;
    }
</script>

