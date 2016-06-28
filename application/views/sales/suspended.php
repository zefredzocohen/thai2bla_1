<table id="contents" style="width: 1300px;font-size: 14px!important">
    <tr>
        <td id="item_table">
            <table  id="suspended_sales_table">
                <tr>
                    <th style="width: 5%"><?php echo 'Mã ĐH'; ?></th>
                    <th style="width: 5%"><?php echo lang('sales_date'); ?></th>
                    <th style="width: 20%"><?php echo lang('sales_customer'); ?></th>
                    <th style="width: 20%"><?php echo lang('sales_comments'); ?></th>
                    <th style="width: 20%">Hợp đồng</th>
                    <th style="width: 10%">Biên bản bàn giao nghiệm thu</th>
                    <th style="width: 5%">Thanh lý</th>
                    <th style="width: 5%"><?php echo lang('sales_receipt'); ?></th>
                    <th style="width: 5%">Đề nghị thanh toán</th>
                    <th style="width: 5%">Hỏi hàng</th>
                </tr>
                <?php
                foreach ($suspended_sales as $suspended_sale) {
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo $suspended_sale['sale_id']; ?></td>
                        <td style="text-align: center"><?php echo (date('d-m-Y H:i:s', strtotime($suspended_sale['sale_time']))); ?></td>
                        <td>
                            <?php
                            if (isset($suspended_sale['customer_id'])) {
                                $customer = $this->Customer->get_info($suspended_sale['customer_id']);
                                echo $customer->first_name . ' ' . $customer->last_name;
                            } else {
                                ?>
                                &nbsp;
                                <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $suspended_sale['comment']; ?></td>    
                        <td style="text-align: center">
                            <?php
                            echo form_open('sales/contract/' . $suspended_sale['sale_id'], array('method' => 'get', 'id' => 'form_contract_suspended_sale'));
                            ?>
                            <div id="div_new"  style="margin-left:8px;">                                
                                <ul id="value_id_new">
                                    <li>
                                        <input type="radio" name="hopdongbutton" value="1" checked >Excel
                                    </li>
                                    <li><input type="radio" name="hopdongbutton" value="0">Email</li>
                                </ul>
                                <div style="clear: both; text-align: center">
                                    <input style="margin-top: 5px;" type="submit" name="submit" value="Hợp đồng" id="submit_receipt" class="submit_button float_right">
                                </div>
                            </div>
                            </form>
                        </td>
                        <td style="text-align: center">
                            <?php
                            echo form_open('sales/bienban/' . $suspended_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_hoihang_suspended_sale'
                            ));
                            ?>
                            <input type="submit" name="submit" value="Biên bản" id="submit_receipt" class="submit_button float_right">
                            </form>
                        </td>
                        <td style="text-align: center">
                            <?php
                            echo form_open('sales/thanhly/' . $suspended_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_hoihang_suspended_sale'
                            ));
                            ?>
                            <input type="submit" name="submit" value="Thanh lý" id="submit_receipt" class="submit_button float_right">
                            </form>
                        </td>
                        <td style="text-align: center">                            
                            <?php
                            echo form_open('sales/receipt/' . $suspended_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_receipt_suspended_sale'
                            ));
                            ?>                            
                            <input type="submit" name="submit" value="Xuất hóa đơn" id="submit_receipt" class="submit_button float_right"/>
                            </form>
                        </td>
                        <td style="text-align: center">
                            <?php
                            echo form_open('sales/thanhtoan/' . $suspended_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_hoihang_suspended_sale'
                            ));
                            ?>
                            <input type="submit" name="submit" value="Thanh toán" id="submit_receipt" class="submit_button float_right">
                            </form>
                        </td>
                        <td style="text-align: center">
                            <?php
                            echo form_open('sales/hoihang/' . $suspended_sale['sale_id'], array(
                                'method' => 'get',
                                'id' => 'form_hoihang_suspended_sale'
                            ));
                            ?>
                            <input type="submit" name="submit" value="Hỏi hàng" id="submit_receipt" class="submit_button float_right">
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

    $(document).ready(function ()
    {
        $("#form_delete_suspended_sale").submit(function ()
        {
            if (!confirm(<?php echo json_encode(lang("sales_delete_confirmation")); ?>))
            {
                return false;
            }
        });
    });
</script>