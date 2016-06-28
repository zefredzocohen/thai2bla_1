
<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <style type="text/css">
            .submit_button, .submit_right, .submit_cancel{
                box-sizing: content-box;
                background-color: #4d90fe !important;
                background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed) !important;
                border: 1px solid #3079ed !important;
                box-shadow: none !important;
                color: #fff !important;
                border-radius: 2px !important;
                cursor: pointer !important;
                font-size: 11px !important;
                font-weight: bold !important;
                height: 27px !important;
                line-height: 27px !important;
                margin-right: 16px !important;
                min-width: 54px !important;
                outline: 0 none !important;
                padding: 0 8px !important;
                text-align: center !important;
                white-space: nowrap !important;
                margin-top: 15px;
            }

            #myclass{
                margin-top: 20px;
            }
            .col1{
                float: left;
                width: 470px;
            }
            fieldset div.field_row{
                border-bottom: none;
            }
            .classtable{
                margin-top: 25px;
            }
            #error_message_box{
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
            .input_search{
                font-size: 1.1em;
                padding: 4px 10px;
                width: 470px; 
                margin-top:15px; 

            }
            #add_item_form{
                padding-left: 23px; 
            }
            /* */
            #reg_item_search1{
                background:url("./images/pieces/reg_item_search2.png") no-repeat scroll -9px -9px transparent;
                height:40px;
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
                width:170px

            }
            .item_id, .quantity_inventory{
                border: none;
            }
            .item_id{
                text-align:center;
            }
            .quantity_inventory, .quantity_next{
                text-align:right;
            }
            .quantity_next{
                width: 100px;
                height: 20px;
            }
            #item_kit_items{
                width:100%;	
                margin: 20px auto;
                font-size: 12px;
            }
            #next_warehouse, #transfer, #category{
                padding: 4px 10px;
            }

            #export_store{
                width:100%;	
                margin: 20px auto;
                font-size: 12px;
            }
            #item_kit_items tr td{
                border: 1px solid #CDCDCD;
                padding: 3px 5px;
            }
            #item_kit_items tr th{
                border: 1px solid #CDCDCD;
                background:#158ca0;
                color: #FFFFFF;
                padding: 5px 5px;
            }


        </style>

        <table id="title_bar">
            <tr>
                <td id="title_icon">
                    <a href="<?php echo base_url()?>create_invetorys" ><div class="newface_back"></div></a>
                </td>
                <td id="title">&nbsp;Chuyển kho</td>
            </tr>
        </table>
        <?php echo form_open('items/save_next_inventory', array('id' => 'form_transfer', 'name' => 'save_transfer',)); ?>
        <ul id="error_message_box1"></ul>
        <?php
        $this->load->model('Create_invetory');
        $cats = $this->Create_invetory->get_all()->result_array();
        ?>     

        <div class="field_row clearfix">
            <div class='form_field'>
                <?php echo form_label('Kho chuyển' . ':', 'next_warehouse', array('class' => 'required wide')); ?>
                <select name="next_warehouse" id="next_warehouse" style="width: 150px; margin-right: 20px;">
                    <?php
                    if ($id_store) {
                        echo "<option value='0'>Kho tổng</option>";
                        if ($cats != null) {
                            foreach ($cats as $cat) {
                                if ($cat['id'] == $id_store) {
                                    echo "<option value='" . $cat['id'] . "' selected='selected'>" . $cat['name_inventory'] . "</option>";
                                } else {
                                    echo "<option value='" . $cat['id'] . "'>" . $cat['name_inventory'] . "</option>";
                                }
                            }
                        }
                    } else {
                        echo "<option value='0' selected='selected'>Kho tổng</option>";
                        if ($cats != null) {
                            foreach ($cats as $cat) {
                                echo "<option value='" . $cat['id'] . "'>" . $cat['name_inventory'] . "</option>";
                            }
                        }
                    }
                    ?>
                </select>            
                <?php echo form_label('Kho nhận' . ':', 'next_warehouse', array('class' => 'required wide')); ?>
                <select name="inven_transfer" id="transfer" style="margin-right: 20px;">                    
                    <option value="0">Kho tổng</option>
                    <?php
                    if ($cats != null) {
                        foreach ($cats as $cat) {
                            ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name_inventory']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php echo form_label('Nhóm mặt hàng' . ':', 'next_warehouse', array('class' => 'wide')); ?>
                <select name="category" id="category">
                    <?php
                    if ($id_cate) {
                        echo "<option value='0'>Tất cả</option>";
                        foreach ($category as $val) {
                            if ($val['id_cat'] == $id_cate) {
                                echo "<option value='" . $val['id_cat'] . "' selected='selected'>" . $val['name'] . "</option>";
                            } else {
                                echo "<option value='" . $val['id_cat'] . "'>" . $val['name'] . "</option>";
                            }
                        }
                    } else {
                        echo "<option selected='selected'>Tất cả</option>";
                        foreach ($category as $val) {
                            echo "<option value='" . $val['id_cat'] . "'>" . $val['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
        <div class="field_row clearfix" style="width: 600px;  float: left;">
            <?php echo form_label('Chon mặt hàng:', 'next_warehouse', array('class' => 'required wide')); ?>
            <?php
            echo form_input(array(
                'name' => 'item',
                'id' => 'items_kits',
                'style' => 'width: 250px; height: 26px'
            ));
            ?>

        </div><br>
        <input type="hidden" name="name_items" value="<?php echo $key['item_id'] ?>" id="value_id">
        <br><br>
        <table id="item_kit_items" name="item_kit_items">
            <tr>
                <th width="50px"><?php echo 'Xoá'; ?></th>
                <th width="120px"><?php echo 'Mã mặt hàng'; ?></th>
                <th width="350px"><?php echo 'Tên mặt hàng' ?></th>
                <th width="120px"><?php echo 'SL trong kho' ?></th>
                <th width="130px"><?php echo 'SL cần chuyển' ?></th>
            </tr>
        </table>            
        <br>
        <input type="submit" class="submit_right" id="submit" value="Lưu" name="submit">
        <input type="button" class="submit_cancel" value="Hủy" id="cancle" onclick="clear_cart()">
        <?php echo form_close(); ?>        
    </div>
    <div id="abc"></div>
</div>
</div>
<?php $this->load->view('partial/footer'); ?>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<script  type="text/javascript">
            $("#items_kits").autocomplete({
                source: '<?php echo site_url("items/item_search_new"); ?>',
                delay: 10,
                autoFocus: false,
                minLength: 0,
                select: function (event, ui) {
                    $("#items_kits").val("");
                    if ($("#quantity_next_" + ui.item.id).length == 1) {
                        $("#quantity_next_" + ui.item.id).val(parseFloat($("#quantity_next_" + ui.item.id).val()) + 1);
                    } else {
                        $("#item_kit_items").append(
                                "<tr>"
                                + "<td><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa'>X</a></td>"

                                + "<td><input id='item_id_" + ui.item.id + "' type='hidden' value='" + ui.item.id
                                + "' name='item_id[" + ui.item.id + "]' class='item_id'/>" + ui.item.item_number + "</td>"

                                + "<td style='text-align:left'>" + ui.item.value + "</td>"

                                + "<td><input id='quantity_inventory_" + ui.item.id + "' type='text' value='" + ui.item.quantity
                                + "' name='quantity_inventory[" + ui.item.id + "]' class='quantity_inventory' readonly  /></td>"

                                + "<td><input id='quantity_next_" + ui.item.id + "' type='text' value='1' "
                                + " name='quantity_next[" + ui.item.id + "]' class='quantity_next' / style='padding-right:10px;border: 1px solid #ccc'></td>"

                                + "</tr>"
                                );


                        $('#quantity_next_' + ui.item.id).focus(function () {
                            if ($('#quantity_next_' + ui.item.id).val() == 0) {
                                $('#quantity_next_' + ui.item.id).val('');
                            }
                        });
//                $('#quantity_next_' + ui.item.id).keypress(function (e) {
//                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//                        alert('Số lượng chuyển kho phải là số và phải lớn hơn 0!');
//                        return false;
//                    }
//                });

                        $('#quantity_next_' + ui.item.id).blur(function () {
                            if ($('#quantity_next_' + ui.item.id).val() == '') {
                                $('#quantity_next_' + ui.item.id).val(0);
                            }
                            var quantity_next = ($(this).val()).replace(/,/g, '');
                            var quantity_inventory = $('#quantity_inventory_' + ui.item.id).val().replace(/,/g, "");
                            var qty = quantity_next - quantity_inventory;
                            if (quantity_next < 0) {
                                alert('Số lượng chuyển không được là số âm !');
                                $('#quantity_next_' + ui.item.id).val(0);
                            } else if (qty > 0 && quantity_next != 0) {
                                alert('Số lượng chuyển không thể lớn hơn số lượng trong kho !');
                                $('#quantity_next_' + ui.item.id).val(1);
                                return false;
                            } else {
                                $('#quantity_next_' + ui.item.id).maskMoney({
                                    precision: 2
                                });
                            }
                        });
                        $('#quantity_next_' + ui.item.id).maskMoney({
                            precision: 2
                        });
                    }
                    return false;
                }
            });


            function deleteItemKitRow(link) {
                $(link).parent().parent().remove();
                return false;
            }

            $('#next_warehouse').change(function () {
                $("#item_kit_items tr td").remove();
                $.post('<?php echo site_url("items/set_next_warehouse"); ?>', {next_warehouse: $('#next_warehouse').val()});
            });
            $("#category").change(function () {
                $.post('<?php echo site_url("items/set_cate"); ?>', {categorysearch: $('#category').val()});
            });
            $.validator.addMethod("textnumber", function (value, element) {
                return /^[0-9+]+$/.test(value);
            },
                    "Bạn không được nhập số âm !."
                    );


            $.validator.addMethod("check_quantity", function (value, element) {
                var inquantity = $("#quantity_inventory").val();
                var tranquantity = $("#quantity_next").val();

                if (parseInt(inquantity) < parseInt(tranquantity)) {
                    return false;
                } else
                    return true;

            }, "Số lượng chuyển kho phải nhỏ hơn số lượng trong kho !");

            $("#form_transfer").validate({
                errorLabelContainer: "#error_message_box",
                wrapper: "li",
                rules: {
                    inven_transfer: "required",
                    quantity_next:
                            {
                                required: true,
                                number: true,
                                textnumber: true,
                                // notbumber:true,
                                check_quantity: true,
                            }

                },
                messages: {
                    inven_transfer: "Bạn phải chọn kho nhận !",
                    quantity_next: {
                        required: "SL chuyển kho không được để trống !",
                        number: "Bạn phải nhập vào số !",
                    }
                }
            });

            $('#submit').click(function () {

                var arr_quantity_inventory = [];
                var next_warehouse = $('#next_warehouse').val();
                if ($.trim(next_warehouse) == '') {
                    alert('Bạn chưa chọn kho để chuyển mặt hàng ! Vui lòng chọn kho ');
                    return false;
                }

                var transfer = $('#transfer').val();
                if ($.trim(transfer) == '') {
                    alert('Chưa có kho nhận ! vui lòng chọn lại kho chuyển ');
                    return false;
                }

                if (!$(".item_id").val()) {
                    alert('Bạn chưa chọn mặt hàng nào để chuyển kho . Vui lòng chọn mặt hàng !');
                    return false;
                } else {
                    if ($.trim(next_warehouse) == $.trim(transfer)) {
                        alert('Kho chuyển và kho nhận không được trùng nhau');
                        return false;
                    }
                }

                $("#item_kit_items").find('.quantity_inventory').each(function (index, element) {
                    var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                    if ($("#quantity_inventory_" + item_id).val() <= 0) {
                        arr_quantity_inventory.push(item_id);
                    }
                });

                if (arr_quantity_inventory.length > 0) {
                    alert("Một số mặt hàng có số lượng trong kho không đủ để chuyển . Bạn vui lòng kiểm tra lại");
                    return false;
                }
                alert('Bạn đã chuyển kho thành công');
            });

            function clear_cart() {
                var result = confirm('Bạn muốn xóa các mặt hàng cần chuyển không ?');
                if (result) {
                    window.location = "<?php echo site_url('/items/delete_all_store'); ?>";
                } else {
                    return false;
                }
            }

</script>
<style type="text/css">
    .quantity,.quantity_loss{
        text-align: center;
    }
    .cost,.price{
        text-align: right;
        border: none;
    }  
    .product_as_item,.quantity_now,.quantity_inventory{
        text-align: center;
        border: none;
    }
    #trading_item{
        font-weight: bold;
        background: #41B4EF;
        color: #FFFFFF !important;
        margin: 0px 0px 10px 10px;
        padding: 5px 5px;
    }
    .myButton {
        cursor: pointer;
        background: none repeat scroll 0 0 #428BCA;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        line-height: 20px;
        padding: 9px 10px;
        margin: 0px 20px 0px 0px;
        float: left;
    }
    .myButton:hover {
        background: #3276b1;       
    }

</style>