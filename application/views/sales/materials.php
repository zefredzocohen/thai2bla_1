<style type="text/css">
    .submit_button_float_right{
        margin-left: 70px !important;
        display: inline !important ;               
    }
    .select_quotes_contract{
        padding: 2px;
        margin-right: 10px;
        width: 150px;
    }
</style>
<table id="contents" style="width: 1280px; font-size: 12px !important; font-family: Arial,Helvetica,sans-serif">
    <tr>
        <td id="item_table">
            <table  id="suspended_sales_table">
                <tr>
                    <th style="width: 5%;"><?php echo lang('sales_suspended_sale_id'); ?></th>
                    <th style="width: 5% !important; text-align: center;"><?php echo lang('sales_date'); ?></th>
                    <th style="width: 16%;"><?php echo lang('sales_customer'); ?></th>
                    <th style="width: 10%;"><?php echo lang('sales_comments'); ?></th>
                    <th style="width: 5%;">Trạng thái</th>
                    <th style="width: 5%;"><?php echo lang('sales_unsuspend'); ?></th>
                    <th style="width: 22%;"><?php echo lang('sales_baogia'); ?></th>
                    <th style="width: 22%;"><?php echo lang('sales_contract'); ?></th>
                    <th style="width: 5%;"><?php echo lang('sales_hoihang'); ?></th>
                    <th style="width: 5%;"><?php echo lang('common_delete'); ?></th>
                </tr>
                <?php
                foreach ($material_sales as $material_sale) {
                    ?>
                    <tr>
                        <td style="width: 5%; text-align: center;"><?php echo $material_sale['sale_id']; ?></td>
                        <td style="width: 5%; text-align: center;"><?php echo date('d-m-Y H:i:s', strtotime($material_sale['sale_time'])); ?></td>
                        <td style="width: 16%;">
                            <?php
                            if (isset($material_sale['customer_id'])) {
                                $customer = $this->Customer->get_info($material_sale['customer_id']);
                                echo $customer->first_name . ' ' . $customer->last_name;
                            } else {
                                ?>
                                &nbsp;
                                <?php
                            }
                            ?>
                        </td>
                        <td style="width: 10%;"><?php echo $material_sale['comment']; ?></td>
                        <?php if ($material_sale['suspended'] == 1) { ?>
                            <td style="width: 5%; text-align: center; color: red;"><?php echo 'Đã ghi nợ'; ?></td>
                        <?php } elseif ($material_sale['liability'] == 1) { ?>
                            <td style="width: 5%; text-align: center; color:green;"><?php echo 'Đã đặt hàng'; ?></td>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>
                        <td style="width: 5%; text-align: center">
                            <?php
                            echo form_open('sales/unsuspend');
                            echo form_hidden('suspended_sale_id', $material_sale['sale_id']);
                            ?>
                            <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
                            </form>
                        </td>                       
                        <td style="width: 22%;">
                            <?php
                            echo form_open('sales/baogia/' . $material_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_baogia_suspended_sale'
                            ));
                            ?>
                            <div id="div_new" style="margin-left:8px; ">
                                <div style="position: relative; display: block">
                                    <div style="width: 100%; ">
                                        <ul id="value_id_new">
                                            <li>
                                                <label><input type="radio" name="baogiabutton" value="0" checked >Word</label>
                                            </li>
                                            <li>
                                                <label><input type="radio" name="baogiabutton" value="1">Email</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div style="width: 100%; margin-top: 5px;">
                                        <ul id="value_id_new">
                                            <li>
                                                <label><input type="radio" name="cat_baogia" value="0" checked>Tất cả</label>
                                            </li>
                                            <li>
                                                <label><input type="radio" name="cat_baogia" value="1">Hàng hóa</label>
                                            </li>
                                            <li>
                                                <label><input type="radio" name="cat_baogia" value="2">Dịch vụ</label>
                                            </li>
                                        </ul> 
                                    </div>
                                </div>
                                <select name="quotes" class="select_quotes_contract" id="quotes_<?= $material_sale['sale_id']; ?>">
                                    <option value="">Mẫu báo giá</option>
                                    <?php
                                    foreach ($quotes as $val) {
                                        echo "<option value='$val->id_quotes_contract'>$val->title_quotes_contract</option>";
                                    }
                                    ?>
                                </select>
                                <input style="margin-top: 5px;" type="submit" name="submit" value="Thực hiện" id="submit_receipt_quotes_<?= $material_sale['sale_id']; ?>" class="submit_button float_right submit_quotes">
                            </div>
                            </form>
                        </td>
                        <td style="width: 22%;">
                            <?php
                            echo form_open('sales/contract/' . $material_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_contract_suspended_sale'
                            ));
                            ?>
                            <div style="position: relative; display: block">
                                <div style="width: 100%; ">
                                    <ul id="value_id_new">
                                        <li>
                                            <label><input type="radio" name="hopdongbutton" value="0" checked >Word</label>
                                        </li>
                                        <li>
                                            <label><input type="radio" name="hopdongbutton" value="1">Email</label>
                                        </li>
                                    </ul>
                                </div>
                                <div style="width: 100%; margin-top: 5px;">
                                    <ul id="value_id_new">
                                        <li>
                                            <label><input type="radio" name="cat_hopdong" value="0" checked>Tất cả</label>
                                        </li>
                                        <li>
                                            <label><input type="radio" name="cat_hopdong" value="1">Hàng hóa</label>
                                        </li>
                                        <li>
                                            <label><input type="radio" name="cat_hopdong" value="2">Dịch vụ</label>
                                        </li>
                                    </ul> 
                                </div>
                            </div>                   
                            <select name="contract" class="select_quotes_contract" id="contract_<?= $material_sale['sale_id']; ?>">
                                <option value="">Mẫu hợp đồng</option>
                                <?php
                                foreach ($contract as $val) {
                                    echo "<option value='$val->id_quotes_contract'>$val->title_quotes_contract</option>";
                                }
                                ?>
                            </select>
                            <input style="margin-top: 5px;" type="submit" name="submit" value="Thực hiện" id="submit_receipt_quotes_<?= $material_sale['sale_id']; ?>" class="submit_button submit_contract">                            
                            </form>
                        </td>
                        <td style="width: 5%; text-align: center">
                            <?php
                            echo form_open('sales/hoihang/' . $material_sale['sale_id'], array('method' => 'get', 'id' => 'form_hoihang_suspended_sale'));
                            ?>
                            <input type="submit" name="submit" value="<?php echo lang('sales_hoihang'); ?>" id="submit_receipt" class="submit_button float_right">
                            </form>
                        </td>
                        <td style="width: 5%; text-align: center">
                            <?php
                            echo form_open('sales/delete_suspended_sale', array('id' => 'form_delete_suspended_sale'));
                            echo form_hidden('suspended_sale_id', $material_sale['sale_id']);
                            ?>
                            <input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </td>
    </tr>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $("#form_delete_suspended_sale").submit(function () {
            if (!confirm(<?php echo json_encode(lang("sales_delete_confirmation")); ?>)) {
                return false;
            }
        });
        $(".submit_quotes").click(function () {
            var id = $(this).attr("id").substring($(this).attr("id").lastIndexOf("_") + 1);
            if (!$("#quotes_" + id).val()) {
                alert("Vui lòng chọn mẫu báo giá");
                return false;
            }
        });
        $(".submit_contract").click(function () {
            var id = $(this).attr("id").substring($(this).attr("id").lastIndexOf("_") + 1);
            if (!$("#contract_" + id).val()) {
                alert("Vui lòng chọn mẫu hợp đồng");
                return false;
            }
        });
    });
</script>