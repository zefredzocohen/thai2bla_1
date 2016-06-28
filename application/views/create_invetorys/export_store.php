<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id = "all_page">
    <?php
    if ($export_store_id) {
        echo "<p>Mã đơn hàng: <span style='color: red'>" . $export_store_id . "</span></p>";
}
    ?>
    <ul id="error_message_box1"></ul>
    <?php echo form_open('create_invetorys/save_export_store', array('id' => 'form_transfer', 'name' => 'export_store')); ?>   
    <div style="padding: 10px 0px;">
        <?php echo form_label('Hình thức xuất kho:', '', array('class' => 'wide')); ?>
        <select name="form_export" id="form_export">
            <?php if ($info_export_store->form == 1) { ?>
                <option value="0">Xuất trực tiếp</option>
                <option value="1" selected="selected">Xuất sản xuất hàng loạt</option>
                <option value="2">Xuất sản xuất mẫu</option>
            <?php } else if ($info_export_store->form == 2) { ?>
                <option value="0">Xuất trực tiếp</option>
                <option value="1">Xuất sản xuất hàng loạt</option>
                <option value="2" selected="selected">Xuất sản xuất mẫu</option>
            <?php } else { ?>
                <option value="0" selected="selected">Xuất trực tiếp</option>
                <option value="1">Xuất sản xuất hàng loạt</option>
                <option value="2">Xuất sản xuất mẫu</option>
            <?php } ?>
        </select>
    </div>

    <?php 
    $this->load->model('Create_invetory');
    $cats = $this->Create_invetory->get_all_inventory()->result_array();
    ?>
    <div id="export_normal" class="block">
        <div style="position: relative; width: 100%; display: block; overflow: hidden">
            <div style="float: left; margin: 0px 50px 0px 0px;">
                <?php echo form_label('Kho' . ':', 'next_warehouse', array('class' => 'wide')); ?>
                <select name="next_warehouse" id="next_warehouse">
                    <option value="0">Kho tổng</option>
                    <?php
                    if ($cats != null) {
                        foreach ($cats as $cat) {
                            ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $store == $cat['id'] ? 'selected' : '' ?> >
                                <?php echo $cat['name_inventory']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div style="float: left; margin: 0px 50px 0px 0px;">
                <?php echo form_label('Nhóm mặt hàng' . ':', 'category', array('class' => 'wide')); ?>            
                <select name="category" id="category">
                    <option value="0" <?php echo $id_category != 0 ? "" : "selected"; ?>>Tất cả</option>
                    <?php foreach ($category as $val) { ?>
                        <option value="<?= $val['id_cat'] ?>" <?php echo $id_category == $val['id_cat'] ? 'selected' : '' ?>><?= $val['name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div>           
                <?php echo form_label('Mặt hàng:', 'label_item', array('class' => 'wide')); ?>
                <?php
                echo form_input(array(
                    'name' => 'item',
                    'id' => 'items',
                    'style' => 'width: 300px; padding: 5px 10px; border-radius: 2px; border: 1px solid #cdcdcd;',
                    'placeholder' => 'Chọn mặt hàng để xuất kho'
                ));
                ?>           
            </div>
        </div>    
        <table id="export_store" class="table_export">
            <tr>
                <th width="4%">Xoá</th>
                <th width="10%">Mã mặt hàng</th>
                <th width="20%">Tên mặt hàng</th>
                <th width="10%">ĐVT</th>
                <th width="10%">SL kho</th>
                <th width="10%">SL xuất</th>
                <th width="18%">Giá vốn</th>
                <th width="18%">Thành tiền</th>
            </tr>
            <?php
            if ($export_store_id) {
                foreach (array_reverse($export_store_item, true) as $line => $item) {
                    $item_info = $this->Item->get_info($item->item_id);
                    $export_store_item_info = $this->Create_invetory->get_info_export_store_item($export_store_id, $item->item_id);
                    $quantity = $store == 0 ? $item_info->quantity_total : $this->Item->get_info_warehouse_items($item->item_id, $store)->quantity;
                    ?>			
                    <tr style="text-align: center;">
                        <td><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
                        <td>
                            <input id='item_id_<?= $item->item_id ?>' type='hidden' 
                                   value='<?= $item->item_id ?>' 
                                   name='item_id[<?= $item->item_id ?>]' 
                                   class='item_id' readonly />
                                   <?= $item_info->item_number ?>
                        </td>
                        <td style="text-align: left;"><?= $item_info->name ?></td>
                        <td style="text-align: left;"><?= $this->Unit->get_info($export_store_item_info->unit_export)->name ?></td>
                        <td style="text-align: right;">
                            <input id='quantity_<?= $item->item_id ?>' type='text' 
                                   value='<?= format_quantity($quantity) ?>' readonly="readonly" 
                                   name='quantity[<?= $item->item_id ?>]' class='quantity' />
                        </td>
                        <td style="text-align: right;">
                            <input id='quantity_export_<?= $item->item_id ?>' type='text' 
                                   value='<?= format_quantity($export_store_item_info->quantity_export) ?>' size='8'
                                   name='quantity_export[<?= $item->item_id ?>]' class='quantity_export' 
                                   onchange='calculateSuggestedPrices();' /></input>
                        </td>
                        <td style="text-align: right;">
                            <input id='cost_price_export_<?= $item->item_id ?>' type='text' 
                                   value='<?= number_format($export_store_item_info->cost_price_export) ?>' size='16' readonly="readonly"
                                   name='cost_price_export[<?= $item->item_id ?>]' class='cost_price_export' 
                                   onchange='calculateSuggestedPrices();' /></input>

                            <input id='cost_price_export2_<?= $item->item_id ?>' type="hidden" 
                                   value='<?= $export_store_item_info->cost_price_export ?>' name='cost_price_export2[<?= $item->item_id ?>]' 
                                   class='cost_price_export2' onchange='calculateSuggestedPrices();' />
                        </td>
                        <td style="text-align: right;">
                            <input id='money_<?= $item->item_id ?>' type='text' size=20 readonly="readonly"  class='money'
                                   value='<?= number_format($export_store_item_info->cost_price_export * $export_store_item_info->quantity_export) ?>'
                                   name='money[<?= $item->item_id ?>]' onchange='calculateSuggestedPrices();' />
                        </td>	
                    </tr>		
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <!--------dungchip-------->
    <div id="export_request" class="hide">
        <div id="order">           
            <?php
            echo form_label('Chọn phiếu: ', 'label_item', array('class' => 'wide required'));
            echo form_input(array(
                'name' => 'order_number',
                'id' => 'order_number',
                'style' => 'width: 300px; padding: 4px 8px; border-radius: 2px; border: 1px solid #cdcdcd; margin-bottom: 6px',
                'placeholder' => 'Nhập mã phiếu yêu cầu xuất kho'
            ));
            if ($export_store_id) {
                echo "<input type='hidden' name='item_production_id' value='" . $info_export_store->item_production_id . "'>";
            }
            ?>

        </div>
        <?php
        if ($info_export_store->item_production_id) {
            echo "Số phiếu yêu cầu: " . $info_export_store->item_production_id;
        }
        $info_store_material = $this->Create_invetory->check_exist_store_materials();
        echo "<input type='hidden' name='store' value='" . $info_store_material['id'] . "'>";
        ?>
        <table id="export_store_request" class="table_export">
            <thead>
                <tr>
                    <th width="2%">Xoá</th>
                    <th width="10%">Mã mặt hàng</th>
                    <th width="20%">Tên mặt hàng</th>
                    <th width="5%">ĐVT</th>
                    <th width="10%">SL kho</th>
                    <th width="10%">SL YC</th>
                    <th width="10%">SL đã xuất</th>
                    <th width="10%">SL xuất</th>
                    <th width="15%">Giá vốn</th>
                    <th width="15%">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($export_store_id) {
                    foreach ($export_store_item as $line => $item) {
                        $info_item_formula_materials = $this->Item_kit->get_info_formula_materials_item($item->item_id);
                        $info_item = $this->Item->get_info($item->item_id);
                        $unit = $info_item->quantity_first == 0 ? $info_item->unit : $info_item->unit_from;
                        $info_unit = $this->Unit->get_info($unit);
                        $info_store_material = $this->Create_invetory->check_exist_store_materials();
                        $info_item_material = $this->Item->get_id_Items_warehouse($info_store_material['id'], $item->item_id);
                        $export_store_item_info = $this->Create_invetory->get_info_export_store_item($export_store_id, $item->item_id);

                        //Hưng Audi 7-9-15
                        $info_item_production = $this->Item_kit->get_info_item_production($info_export_store->item_production_id);
                        $info_request = $this->Item_kit->get_info_item_production_by_request_id($info_item_production->request_id);
                        $export_store_ids = $this->Create_invetory->get_export_store_by_item_production_id($info_request->id);
                        $mang_ids = array();
                        foreach ($export_store_ids as $val) {
                            $mang_ids[] = $val->export_store_id;
                        }
                        if ($mang_ids) {
                            $get_sum_exported = $this->Create_invetory->get_sum_quantity_exported($mang_ids, $item->item_id);
                        }
                        ?>                   
                        <tr><input type='hidden' value='<?= $info_request->item_kit_id ?>' name='item_kit_id' />
                    <td style='text-align: center'><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a></td>
                    <td style='text-align: center'>
                        <input id='item_id_<?= $item->item_id; ?>' type='hidden' value='<?= $item->item_id; ?>' name='item_id[<?= $item->item_id; ?>]' class='item_id' />
                        <?= $info_item->item_number; ?>
                    </td>
                    <td><?= $info_item->name ?></td>
                    <td><?= $info_unit->name ?></td>
                    <td style='text-align: right'>
                        <input id='quantity_<?= $item->item_id; ?>' type='text' 
                               value='<?= format_quantity($info_item_material->quantity) ?>' 
                               name='quantity[<?= $item->item_id; ?>]' 
                               class='quantity' readonly size=8 />
                    </td>
                    <td style='text-align: right'>
                        <input id='quantity_request_<?= $item->item_id; ?>' type='text' 
                               value='<?= format_quantity($item->quantity_request); ?>' 
                               name='quantity_request[<?= $item->item_id; ?>]' 
                               class='quantity_request' readonly size=8 />
                    </td>
                    <td><input id='quantity_exported_<?= $item->item_id; ?>' type='text' 
                               value='<?= format_quantity($get_sum_exported->quantity_exported); ?>' 
                               name='quantity_exported[<?= $item->item_id; ?>]' 
                               class='quantity_exported' readonly size='8'>
                    </td>
                    <td style='text-align: center'>
                        <input id='quantity_export_<?= $item->item_id; ?>' type='text' 
                               value='<?= format_quantity($export_store_item_info->quantity_export); ?>' size=6 
                               name='quantity_export2[<?= $item->item_id; ?>]' 
                               class='quantity_export' onchange='calculateSuggestedPricesRequest();' />
                    </td>
                    <td style='text-align: right'>
                        <input id='cost_price_export_<?= $item->item_id; ?>' type='text' size=16 
                               value='0' 
                               name='cost_price_export[<?= $item->item_id; ?>]' 
                               class='cost_price_export' readonly onchange='calculateSuggestedPricesRequest();' />
                    </td>
                    <td style='text-align: right'>
                        <input id='money_<?= $item->item_id; ?>' type='text' size=20 
                               value='<?= number_format($export_store_item_info->cost_price_export * $export_store_item_info->quantity_export) ?>' 
                               name='money[<?= $item->item_id; ?>]' class='money' 
                               onchange='calculateSuggestedPricesRequest();' readonly />
                    </td>
                    </tr>        
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        <div style="position: relative">    
            <?= form_label('Tài khoản nợ - có: ', 'tk_no_co', array('class' => 'wide required')); ?>&nbsp;&nbsp;
            <?php $data[tk_no] = $info_export_store->tk_no; ?>
            <select name="tk_no" class="tk_no">
                <?php $this->load->view('item_kits/tk_no_list', $data) ?>
            </select>&nbsp;&nbsp;&nbsp;
            <?php $data[tk_co] = $info_export_store->tk_co; ?>
            <select name="tk_co" class="tk_co">
                <?php $this->load->view('item_kits/tk_co_list', $data) ?>
            </select>
        </div><br>
    </div>
    <!-----------dungchip----------->
    <div id="export_pro_template" class="hide">
        <div id="order_pro_template">         
            <label class="required">Chọn phiếu:</label>
            <input type="text" id="input_order_pro_template" style="width: 300px; padding: 4px 8px; border-radius: 2px; border: 1px solid #cdcdcd; margin-bottom: 6px" placeholder="Nhập mã phiếu yêu cầu xuất kho"/><br>
            <?php
            if ($export_store_id) {
                echo "<input type='hidden' name='request_template_id' value='" . $info_export_store->request_template_id . "'>";
            }
            if ($info_export_store->request_template_id) {
                echo "Số phiếu yêu cầu: " . $info_export_store->request_template_id;
            }
            $info_store_material1 = $this->Create_invetory->check_exist_store_materials();
            echo "<input type='hidden' name='store' value='" . $info_store_material1['id'] . "'>";
            ?>
            <table id="export_store_pro_template" class="table_export">
                <thead>
                    <tr>
                        <th width="4%">Xoá</th>
                        <th width="10%">Mã mặt hàng</th>
                        <th width="20%">Tên mặt hàng</th>
                        <th width="10%">ĐVT</th>
                        <th width="10%">SL kho</th>
                        <th width="10%">SL YC</th>
                        <th width="10%">SL đã xuất</th>
                        <th width="10%">SL xuất</th>
                        <th width="18%">Giá vốn</th>
                        <th width="18%">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($export_store_id) {
                        foreach ($export_store_item as $line => $item) {
                            $item_info = $this->Item->get_info($item->item_id);
                            $export_store_item_info = $this->Create_invetory->get_info_export_store_item($export_store_id, $item->item_id);
                            $quantity = $store == 0 ? $item_info->quantity_total : $this->Item->get_info_warehouse_items($item->item_id, $store)->quantity;
                            //$export_store_ids = $this->Create_invetory->get_export_store_item_by_request_template_id($info_export_store->request_template_id);
                            $export_store_ids = $this->Create_invetory->get_export_store_item_by_request_template_id($info_export_store->item_production_id);
                            $mang_ids = array();
                            foreach ($export_store_ids as $val) {
                                $mang_ids[] = $val->export_store_id;
                            }

                            if ($mang_ids) {
                                $get_sum_exported = $this->Create_invetory->get_sum_quantity_exported($mang_ids, $item->item_id);
                            }
                            ?>
                            <tr>
                                <td style='text-align: center'>
                                    <a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a>
                                </td>
                                <td style='text-align: center'>
                                    <input id='item_id_<?= $item->item_id ?>' type='hidden' value='<?= $item->item_id ?>' name='item_id[<?= $item->item_id ?>]' class='item_id' readonly />
                                    <?= $item_info->item_number ?>
                                </td>
                                <td><?= $item_info->name ?></td>
                                <td><?= $this->Unit->get_info($export_store_item_info->unit_export)->name ?></td>
                                <td style='text-align: right'>
                                    <input id='quantity_<?= $item->item_id ?>' type='text' 
                                           value='<?= format_quantity($quantity) ?>' readonly="readonly" 
                                           name='quantity[<?= $item->item_id ?>]' class='quantity' />
                                </td>
                                <td style='text-align: right'>
                                    <input id='quantity_request_<?= $item->item_id; ?>' type='text' 
                                           value='<?= format_quantity($item->quantity_request); ?>' 
                                           name='quantity_request[<?= $item->item_id; ?>]' 
                                           class='quantity_request' readonly size=8 />
                                </td>
                                <td><input id='quantity_exported_<?= $item->item_id; ?>' type='text' 
                                           value='<?= format_quantity($get_sum_exported->quantity_exported); ?>' 
                                           name='quantity_exported[<?= $item->item_id; ?>]' 
                                           class='quantity_exported' readonly size='8'>
                                </td>
                                <td style='text-align: center'>
                                    <input id='quantity_export_<?= $item->item_id; ?>' type='text' 
                                           value='0' size=6 
                                           name='quantity_export2[<?= $item->item_id; ?>]' 
                                           class='quantity_export' onchange='calculateSuggestedPricesRequestTemplate();' />
                                </td>
                                <td style='text-align: right'>
                                    <input id='cost_price_export_<?= $item->item_id; ?>' type='text' size=16 
                                           value='<?= number_format($item_info->quantity_first == 1 ? $item_info->cost_price_rate : $item_info->cost_price); ?>' 
                                           name='cost_price_export[<?= $item->item_id; ?>]' 
                                           class='cost_price_export' readonly onchange='calculateSuggestedPricesRequestTemplate();' />
                                </td>
                                <td style='text-align: right'>
                                    <input id='money_<?= $item->item_id; ?>' type='text' size=20 
                                           value='<?= number_format($export_store_item_info->cost_price_export * $export_store_item_info->quantity_export) ?>' 
                                           name='money[<?= $item->item_id; ?>]' class='money' 
                                           onchange='calculateSuggestedPricesRequestTemplate();' readonly />
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="position: relative">    
        <?php
        echo form_label('Ghi chú:', 'label_comment', array(
            'id' => 'label_comment',
            'style' => 'position: absolute; top: 0px ; left: 0px;'
        ));
        ?>
        <textarea rows="3" cols="80" id="comment" name="comment" style="padding: 10px; margin-left: 100px;">
            <?php
            if ($export_store_id) {
                echo trim($info_export_store->comment);
            }
            ?>
        </textarea>
    </div>
    <ul style="width:800px">
        <input type="submit" class="submit_right" id="submit" value="Thực hiện" name="submit" > 
    </ul>
    <?php echo form_close(); ?>
    <input type="button" class="cancel" id="cancel" name="cancel" value="Hủy">
</div>
<script  type="text/javascript">
    $(document).ready(function () {
        calculateSuggestedPrices();
        calculateSuggestedPricesRequest();
        calculateSuggestedPricesRequestTemplate();
        var value = $("#form_export").val();
        if (value == 0) {
            $("#export_normal").removeClass("hide").addClass("block");
            $("#export_request").removeClass("block").addClass("hide");
            $("#export_pro_template").removeClass("block").addClass("hide");
        } else if (value == 1) {
            $("#export_normal").removeClass("block").addClass("hide");
            $("#export_request").removeClass("hide").addClass("block");
            $("#export_pro_template").removeClass("block").addClass("hide");
        } else {
            $("#export_normal").removeClass("block").addClass("hide");
            $("#export_request").removeClass("block").addClass("hide");
            $("#export_pro_template").removeClass("hide").addClass("block");
        }
        $("#form_export").change(function () {
            var value = $("#form_export").val();
            if (value == 0) {
                $("#export_normal").removeClass("hide").addClass("block");
                $("#export_request").removeClass("block").addClass("hide");
                $("#export_pro_template").removeClass("block").addClass("hide");
            } else if (value == 1) {
                $("#export_normal").removeClass("block").addClass("hide");
                $("#export_request").removeClass("hide").addClass("block");
                $("#export_pro_template").removeClass("block").addClass("hide");
            } else {
                $("#export_normal").removeClass("block").addClass("hide");
                $("#export_request").removeClass("block").addClass("hide");
                $("#export_pro_template").removeClass("hide").addClass("block");
            }
        });
        $("#cancel").click(function () {
            if ($(".item_id").val()) {
                if (confirm(<?php echo json_encode('Bạn có chắc muốn xóa hàng xuất kho không? Tất cả mặt hàng sẽ bị xóa.'); ?>)) {
                    $('#all_page').load('<?php echo site_url("create_invetorys/cancel_export_store"); ?>');
                }
            }
        });
        $("#items").autocomplete({
            source: '<?php echo site_url("items/item_search_item"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui) {
                $("#items").val("");
                if ($("#quantity_export_" + ui.item.id).length == 1) {
                    $("#quantity_export_" + ui.item.id).val(parseFloat($("#quantity_export_" + ui.item.id).val()) + 1);
                } else {
                    $("#export_store").append(
                            "<tr style='text-align: center'>"
                            + "<td><a href='#' onclick='return deleteItemKitRow(this);' title='Xóa' id='delete'>X</a></td>"

                            + "<td><input id='item_id_" + ui.item.id + "' type='hidden' value='" + ui.item.id
                            + "' name='item_id[" + ui.item.id + "]' class='item_id' />" + ui.item.item_number + "</td>"

                            + "<td style='text-align: left'>" + ui.item.label + "</td>"
                            + "<td style='text-align: left'>" + ui.item.unit + "</td>"

                            + "<td><input id='quantity_" + ui.item.id + "' type='text' value='" + ui.item.quantity
                            + "' name='quantity[" + ui.item.id + "]' class='quantity' readonly size=8 /></td>"

                            + "<td><input id='quantity_export_" + ui.item.id + "' type='text' value='0' size=6 "
                            + "' name='quantity_export[" + ui.item.id + "]' class='quantity_export' onchange='calculateSuggestedPrices();' /></td>"

                            + "<td><input id='cost_price_export_" + ui.item.id + "' type='text' size=16 value='" + ui.item.cost_price_export
                            + "' name='cost_price_export[" + ui.item.id + "]' class='cost_price_export' readonly onchange='calculateSuggestedPrices();' /></td>"

                            + "<input id='cost_price_export2_" + ui.item.id + "' type='hidden' value='" + ui.item.cost_price_export2
                            + "' name='cost_price_export2[" + ui.item.id + "]' class='cost_price_export2' onchange='calculateSuggestedPrices();' />"

                            + "<td><input id='money_" + ui.item.id + "' type='text' size=20 value='0'"
                            + " name='money[" + ui.item.id + "]' class='money' onchange='calculateSuggestedPrices();' readonly /></td>"
                            + "</tr>"
                            );
                    $('#quantity_export_' + ui.item.id).blur(function () {
                        if ($('#quantity_export_' + ui.item.id).val() == '') {
                            $('#quantity_export_' + ui.item.id).val(0);
                        }
                        var quantity_export = ($(this).val()).replace(/,/g, "");
                        var quantity = ($('#export_store #quantity_' + ui.item.id).val()).replace(/,/g, "");
                        var cost_price_export = ($("#export_store #cost_price_export2_" + ui.item.id).val()).replace(/,/g, '');
                        var money = parseInt(quantity_export * cost_price_export) + "";

                        $("#export_store #money_" + ui.item.id).val(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                        var hieu = quantity_export - quantity;
                        if (quantity_export < 0) {
                            alert('Bạn không được nhập số âm !');
                            $('#export_store #quantity_export_' + ui.item.id).val(0);
                            $("#export_store #money_" + ui.item.id).val(0);
                        } else if (hieu > 0 && quantity_export != 0) {
                            alert('Số lượng xuất không thể lớn hơn số lượng trong kho !');
                            $('#export_store #quantity_export_' + ui.item.id).val(0);
                            $("#export_store #money_" + ui.item.id).val(0);
                            return false;
                        } else {
                            $("#export_store #quantity_export_' + ui.item.id").keydown(function (e) {
                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                    return;
                                }
                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                    e.preventDefault();
                                }
                            });
                        }
                    });
                    $("#export_store #quantity_export_' + ui.item.id").keydown(function (e) {
                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                            return;
                        }
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                            e.preventDefault();
                        }
                    });
                }
                calculateSuggestedPrices();
                return false;
            }
        });

        $("#order_number").autocomplete({
            source: '<?php echo site_url("create_invetorys/search_order_request"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui) {
                $("#order_number").val("");
                $("#order #item_production_id").remove();
                $("#order").append("<input type='hidden' name='item_production_id' id='item_production_id' value='" + ui.item.id + "'>");
                $.ajax({
                    url: "<?= site_url("create_invetorys/get_list_item_material"); ?>",
                    data: {request_id: ui.item.request_id},
                    type: "POST",
                    success: function (response) {
                        $("#export_store_request tbody").remove();
                        $("#export_store_request").append(response);
                        $("#export_store_request").find('.quantity_export').each(function (index, element) {
                            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                            $(element).blur(function () {
                                if ($('#export_store_request #quantity_export_' + item_id).val() == '') {
                                    $('#export_store_request #quantity_export_' + item_id).val(0);
                                }
                                var quantity_export = ($(this).val()).replace(/,/g, "");
                                var quantity = ($('#export_store_request #quantity_' + item_id).val()).replace(/,/g, "");
                                var cost_price_export = ($("#export_store_request #cost_price_export_" + item_id).val()).replace(/,/g, '');
                                var money = parseInt(quantity_export * cost_price_export) + "";
                                var quantity_request = ($('#export_store_request #quantity_request_' + item_id).val()).replace(/,/g, "");
                                var quantity_exported = ($('#export_store_request #quantity_exported_' + item_id).val()).replace(/,/g, "");
                                $("#export_store_request #money_" + item_id).val(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                                var hieu = quantity_export - quantity;
                                if (quantity_export < 0) {
                                    alert('Bạn không được nhập số âm !');
                                    $('#export_store_request #quantity_export_' + item_id).val(0);
                                    $("#export_store_request #money_" + item_id).val(0);
                                } else if (hieu > 0 && quantity_export != 0) {
                                    alert('Số lượng xuất không thể lớn hơn số lượng trong kho !');
                                    $('#export_store_request #quantity_export_' + item_id).val(0);
                                    $("#export_store_request #money_" + item_id).val(0);
                                    return false;
                                } else if (quantity_export > (quantity_request - quantity_exported)) {
                                    alert('Số lượng xuất không thể lớn hơn số lượng còn lại cần phải xuất !');
                                    $('#export_store_request #quantity_export_' + item_id).val(0);
                                    $("#export_store_request #money_" + item_id).val(0);
                                    return false;
                                } else {
                                    $("#export_store_request #quantity_export_" + item_id).keydown(function (e) {
                                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                            return;
                                        }
                                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                            e.preventDefault();
                                        }
                                    });
                                }
                            });
                            $("#export_store_request .quantity_export").keydown(function (e) {
                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                    return;
                                }
                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                    e.preventDefault();
                                }
                            });
                        });
                    },
                });
                calculateSuggestedPricesRequest();
                return false;
            }
        });

        $("#input_order_pro_template").autocomplete({
            source: '<?php echo site_url("create_invetorys/search_order_pro_template"); ?>',
            delay: 10,
            autoFocus: false,
            minLength: 0,
            select: function (event, ui) {
                $("#input_order_pro_template").val("");
                $("#order #item_production_id").remove();
                $("#order_pro_template").append("<input type='hidden' name='item_production_id' id='item_production_id' value='" + ui.item.id + "'>");
                $.ajax({
                    url: "<?= base_url("create_invetorys/get_list_item_of_request"); ?>",
                    data: {request_id: ui.item.id},
                    type: "POST",
                    success: function (data) {
                        $("#export_store_pro_template tbody tr").remove();
                        $("#export_store_pro_template tbody").append(data);
                        $("#export_store_pro_template").find('.quantity_export').each(function (index, element) {
                            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                            $(element).blur(function () {
                                if ($('#export_store_pro_template #quantity_export_' + item_id).val() == '') {
                                    $('#export_store_pro_template #quantity_export_' + item_id).val(0);
                                }
                                var quantity_export = ($(this).val()).replace(/,/g, "");
                                var quantity = ($('#export_store_pro_template #quantity_' + item_id).val()).replace(/,/g, "");
                                var cost_price_export = ($("#export_store_pro_template #cost_price_export_" + item_id).val()).replace(/,/g, '');
                                var money = parseInt(quantity_export * cost_price_export) + "";
                                var quantity_request = ($('#export_store_pro_template #quantity_request_' + item_id).val()).replace(/,/g, "");
                                var quantity_exported = ($('#export_store_pro_template #quantity_exported_' + item_id).val()).replace(/,/g, "");
                                $("#export_store_pro_template #money_" + item_id).val(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                                var hieu = quantity_export - quantity;
                                if (quantity_export < 0) {
                                    alert('Bạn không được nhập số âm !');
                                    $('#export_store_pro_template #quantity_export_' + item_id).val(0);
                                    $("#export_store_pro_template #money_" + item_id).val(0);
                                } else if (hieu > 0 && quantity_export != 0) {
                                    alert('Số lượng xuất không thể lớn hơn số lượng trong kho !');
                                    $('#export_store_pro_template #quantity_export_' + item_id).val(0);
                                    $("#export_store_pro_template #money_" + item_id).val(0);
                                    return false;
                                } else if (quantity_export > (quantity_request - quantity_exported)) {
                                    alert('Số lượng xuất không thể lớn hơn số lượng còn lại cần phải xuất !');
                                    $('#export_store_pro_template #quantity_export_' + item_id).val(0);
                                    $("#export_store_pro_template #money_" + item_id).val(0);
                                    return false;
                                } else {
                                    $("#export_store_pro_template #quantity_export_" + item_id).keydown(function (e) {
                                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                            return;
                                        }
                                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                            e.preventDefault();
                                        }
                                    });
                                }
                            });
                            $("#export_store_pro_template .quantity_export").keydown(function (e) {
                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                    return;
                                }
                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                    e.preventDefault();
                                }
                            });
                        });
                    },
                });

                calculateSuggestedPricesRequestTemplate();
                return false;
            }
        });
    });
    function deleteItemKitRow(link) {
        $(link).parent().parent().remove();
        return false;
    }
    function calculateSuggestedPrices() {
        $("#export_store").find('.quantity_export').each(function (index, element) {
            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var quantity_export = ($(element).val()).replace(/,/g, '') > 0 ? ($(element).val()).replace(/,/g, '') : 0;
            var cost_price_export = ($("#cost_price_export2_" + item_id).val()).replace(/,/g, '');
            var money = parseInt(quantity_export * cost_price_export) + "";
            $("#export_store #money_" + item_id).val(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $(element).blur(function () {
                if ($(this).val() == '') {
                    $(this).val(0);
                }
                var quantity_export = ($(this).val()).replace(/,/g, "");
                var quantity = ($('#export_store #quantity_' + item_id).val()).replace(/,/g, "");
                var hieu = quantity_export - quantity;
                var money_blur = parseInt(quantity_export * cost_price_export) + "";
                $("#export_store #money_" + item_id).val(money_blur.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                if (quantity_export < 0) {
                    alert('Bạn không được nhập số âm !');
                    $(this).val(0);
                    $("#export_store #money_" + item_id).val(0)
                } else if (hieu > 0 && quantity_export != 0) {
                    alert('Số lượng xuất không thể lớn hơn số lượng trong kho !');
                    $(this).val(0);
                    $("#export_store #money_" + item_id).val(0);
                    return false;
                }
            });
            $(element).keydown(function (e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });
    }
    $('#next_warehouse').change(function () {
        $("#export_store tr td").remove();
        $.post('<?php echo site_url("create_invetorys/set_inventory"); ?>', {next_warehouse: $('#next_warehouse').val()});
    });
    $("#category").change(function () {
        $.post('<?php echo site_url("categories/set_category"); ?>', {category: $('#category').val()});
    });
    $('#submit').click(function () {
        if (!$(".item_id").val()) {
            alert('Bạn chưa chọn mặt hàng nào để xuất. Vui lòng chọn !');
            return false;
        }
        if ($("#form_export").val() == 0) {
            var arr_quantity = [];
            var arr_quantity_export = [];
            $("#export_store").find('.quantity').each(function (index, element) {
                var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                if ($("#export_store #quantity_" + item_id).val() <= 0) {
                    arr_quantity.push(item_id);
                }
            });
            if (arr_quantity.length > 0) {
                alert("Một số mặt hàng có số lượng trong kho không đủ số lượng để xuất. Bạn vui lòng kiểm tra lại");
                return false;
            } else {
                $("#export_store").find('.quantity_export').each(function (index, element) {
                    var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                    if ($("#export_store #quantity_export_" + item_id).val() == 0) {
                        arr_quantity_export.push(item_id);
                    }
                });
                if (arr_quantity_export.length > 0) {
                    alert("Một số mặt hàng chưa có số lượng xuất. Bạn vui lòng kiểm tra lại");
                    return false;
                }
            }
        } else if ($("#form_export").val() == 1) {
            var arr_quantity1 = [];
            var arr_quantity_export1 = [];
            $("#export_store_request").find('.quantity').each(function (index, element) {
                var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                if ($("#export_store_request #quantity_" + item_id).val() <= 0) {
                    arr_quantity1.push(item_id);
                }
            });
            if (arr_quantity1.length > 0) {
                alert("Một số mặt hàng có số lượng trong kho không đủ số lượng để xuất. Bạn vui lòng kiểm tra lại");
                return false;
            } else {
                $("#export_store_request").find('.quantity_export').each(function (index, element) {
                    var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                    if ($("#export_store_request #quantity_export_" + item_id).val() == 0) {
                        arr_quantity_export1.push(item_id);
                    }
                });
                if (arr_quantity_export1.length > 0) {
                    alert("Một số mặt hàng chưa có số lượng xuất. Bạn vui lòng kiểm tra lại");
                    return false;
                }
            }
        } else {
            var arr_quantity1 = [];
            var arr_quantity_export1 = [];
            $("#export_store_pro_template").find('.quantity').each(function (index, element) {
                var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                if ($("#export_store_pro_template #quantity_" + item_id).val() <= 0) {
                    arr_quantity1.push(item_id);
                }
            });
            if (arr_quantity1.length > 0) {
                alert("Một số mặt hàng có số lượng trong kho không đủ số lượng để xuất. Bạn vui lòng kiểm tra lại");
                return false;
            } else {
                $("#export_store_pro_template").find('.quantity_export').each(function (index, element) {
                    var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                    if ($("#export_store_pro_template #quantity_export_" + item_id).val() == 0) {
                        arr_quantity_export1.push(item_id);
                    }
                });
                if (arr_quantity_export1.length > 0) {
                    alert("Một số mặt hàng chưa có số lượng xuất. Bạn vui lòng kiểm tra lại");
                    return false;
                }
            }
        }
        if ($(".item_kit_id").val()) {
            if (!$(".tk_no").val()) {
                alert('Bạn chưa chọn tài khoản nợ !');
                return false;
            }
            if (!$(".tk_co").val()) {
                alert('Bạn chưa chọn tài khoản có !');
                return false;
            }
        }
    });
    function calculateSuggestedPricesRequest() {
        $("#export_store_request").find('.quantity_export').each(function (index, element) {
            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var quantity_export = ($(element).val()).replace(/,/g, '') > 0 ? ($(element).val()).replace(/,/g, '') : 0;
            var cost_price_export = ($("#export_store_request #cost_price_export_" + item_id).val()).replace(/,/g, '');
            var money = parseInt(quantity_export * cost_price_export) + "";
            $("#export_store_request #money_" + item_id).val(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $(element).blur(function () {
                if ($(this).val() == '') {
                    $(this).val(0);
                }
                var quantity_export = ($(this).val()).replace(/,/g, "");
                var quantity = ($('#export_store_request #quantity_' + item_id).val()).replace(/,/g, "");
                var hieu = quantity_export - quantity;
                var money_blur = parseInt(quantity_export * cost_price_export) + "";
                $("#export_store_request #money_" + item_id).val(money_blur.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                if (quantity_export < 0) {
                    alert('Bạn không được nhập số âm !');
                    $(this).val(0);
                    $("#export_store_request #money_" + item_id).val(0)
                } else if (hieu > 0 && quantity_export != 0) {
                    alert('Số lượng xuất không thể lớn hơn số lượng trong kho !');
                    $(this).val(0);
                    $("#export_store_request #money_" + item_id).val(0);
                    return false;
                } else {
                    $("#export_store_request #quantity_export_' + item_id").keydown(function (e) {
                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                            return;
                        }
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                            e.preventDefault();
                        }
                    });
                }
            });

            $("#export_store_request .quantity_export").keydown(function (e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });
    }

    function calculateSuggestedPricesRequestTemplate() {
        $("#export_store_pro_template").find('.quantity_export').each(function (index, element) {
            var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var quantity_export = ($(element).val()).replace(/,/g, '') > 0 ? ($(element).val()).replace(/,/g, '') : 0;
            var cost_price_export = ($("#export_store_pro_template #cost_price_export_" + item_id).val()).replace(/,/g, '');
            var money = parseInt(quantity_export * cost_price_export) + "";
            $("#export_store_pro_template #money_" + item_id).val(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            $(element).blur(function () {
                if ($(this).val() == '') {
                    $(this).val(0);
                }
                var quantity_export = ($(this).val()).replace(/,/g, "");
                var quantity = ($('#export_store_pro_template #quantity_' + item_id).val()).replace(/,/g, "");
                var hieu = quantity_export - quantity;
                var money_blur = parseInt(quantity_export * cost_price_export) + "";
                var quantity_request = ($('#export_store_pro_template #quantity_request_' + item_id).val()).replace(/,/g, "");
                var quantity_exported = ($('#export_store_pro_template #quantity_exported_' + item_id).val()).replace(/,/g, "");
                $("#export_store_pro_template #money_" + item_id).val(money_blur.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                if (quantity_export < 0) {
                    alert('Bạn không được nhập số âm !');
                    $(this).val(0);
                    $("#export_store_pro_template #money_" + item_id).val(0);
                    return false;
                } else if (hieu > 0 && quantity_export != 0) {
                    alert('Số lượng xuất không thể lớn hơn số lượng trong kho !');
                    $(this).val(0);
                    $("#export_store_pro_template #money_" + item_id).val(0);
                    return false;
                } else if (quantity_export > (quantity_request - quantity_exported)) {
                    alert('Số lượng xuất không thể lớn hơn số lượng còn lại cần phải xuất!');
                    $('#export_store_pro_template #quantity_export_' + item_id).val(0);
                    $("#export_store_pro_template #money_" + item_id).val(0);
                    return false;
                }
            });

            $("#export_store_pro_template .quantity_export").keydown(function (e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });
        return false;
    }
</script>
<style type="text/css"> 
    .submit_right, .cancel{
        box-sizing: content-box;
        background-color: #4d90fe !important;
        background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed) !important;
        border: 1px solid #3079ed !important;
        box-shadow: none !important;
        color: #fff !important;
        border-radius: 2px !important;
        font-size: 12px !important;
        font-weight: bold !important;
        height: 27px !important;
        line-height: 27px !important;
        margin-left: 36px !important;
        margin-top: 36px !important;
        min-width: 54px !important;
        outline: 0 none !important;
        padding: 0 8px !important;
        text-align: center !important;
        white-space: nowrap !important;
        float: left;
        cursor: pointer;
    }

    .table_export{
        width:100%;	
        margin: 10px auto;
        font-size: 12px;
    }
    .table_export tr td{
        border: 1px solid #CDCDCD;
        padding: 3px 5px;
    }
    .table_export tr th{
        border: 1px solid #CDCDCD;
        background: #1E5A96;
        color: #FFFFFF;
        padding: 5px 5px;
    }
    .quantity_export{
        text-align: right;
        padding: 3px;
        width: 90%;
    }
    .quantity, .cost_price_export, .money, .quantity_request, .quantity_exported{
        text-align:right;
        border: none;
    }
    .quantity, .quantity_request, .quantity_exported{
        width:100%;
    }
    #comment{
        border: 1px solid #ccc; 
        border-radius: 5px;
    }
    #next_warehouse, #category, #form_export{
        padding: 4px 10px;
        border: 1px solid #CDCDCD;
        border-radius: 2px;
    }
    .hide{
        display: none;
    }
    .block{
        display: block;
    }
    .tk_no, .tk_co{
        width: 141px
    }
</style>
