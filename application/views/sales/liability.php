<table id="contents" style="width: 1220px;font-size: 14px!important">
    <tr>
        <td id="item_table">
            <table  id="suspended_sales_table">
                <tr>
                    <th style="width: 5%"><?php echo lang('sales_suspended_sale_id'); ?></th>
                    <th style="width: 5%"><?php echo lang('sales_date'); ?></th>
                    <th style="width: 15%"><?php echo lang('sales_customer'); ?></th>
                    <th style="width: 10%"><?php echo 'Tiền đặt hàng'; ?></th>
                    <th style="width: 20%"><?php echo lang('sales_comments'); ?></th>
                    <th style="width: 10%"><?php echo lang('sales_unsuspend'); ?></th>
                    <th style="width: 20%"><?php echo lang('sales_contract'); ?></th>
                    <th style="width: 10%"><?php echo lang('sales_hoihang'); ?></th>
                    <th style="width: 5%">Hủy</th>
                </tr>

                <?php
                foreach ($liability_sales as $liability_sale) {
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $liability_sale['sale_id']; ?></td>
                        <td style="text-align: center;"><?php echo (date('d-m-Y H:i:s', strtotime($liability_sale['sale_time']))); ?></td>
                        <td>                           
                            <?php
                            if (isset($liability_sale['customer_id'])) {
                                $customer = $this->Customer->get_info($liability_sale['customer_id']);
                                echo $customer->first_name . ' ' . $customer->last_name;
                            } else {
                                ?>
                                &nbsp;
                                <?php
                            }
                            ?>
                        </td>
                        <td><div style="width: 100px !important"><?php 
                        // hải zero 5/5/16
                        if($liability_sale['no_131_money']==0) echo 'Tiền mặt: 0';
                        else{
                            $str = $liability_sale['payment_type'];
                            if(preg_match_all('/([a-zA-Z0-9 ])*:( )*([0-9\,]*)(\<br\/\>)*/s', $str,$_str)){
                                                $str_payment_type_fix = str_replace(',', '', $_str[3]);
                                                $sum_payment_type_fix = 0;
                                                foreach ($str_payment_type_fix as $key => $value){
                                                    $sum_payment_type_fix +=$value;
                                                }
                                                echo 'Tiền mặt: '.number_format($sum_payment_type_fix);
                            }else echo '<==>'.$str.'<===>';
                        }
                        
                        
                        
                        
                        ?></div></td>
                        <td><div style="width: 100px !important"><?php echo $liability_sale['comment']; ?></div></td>
                        <td style="text-align: center;">
                            <?php
                            echo form_open('sales/unsuspend');
                            echo form_hidden('suspended_sale_id', $liability_sale['sale_id']);
                            ?>
                            <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            echo form_open('sales/contract/' . $liability_sale['sale_id'], array('method' => 'get', 'id' => 'form_contract_suspended_sale'));
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
                        <td style="text-align: center;">
                            <?php
                            echo form_open('sales/hoihang/' . $liability_sale['sale_id'], array('method' => 'get', 'id' => 'form_hoihang_suspended_sale'));
                            ?>
                            <input type="submit" name="submit" value="<?php echo lang('sales_hoihang'); ?>" id="submit_receipt" class="submit_button float_right">

                            </form>
                        </td>
                        <!-- end phan lam-->
                        <td style="text-align: center;">
                            <?php
                            echo form_open('sales/delete_suspended_sale', array('id' => 'form_delete_suspended_sale'));
                            echo form_hidden('suspended_sale_id', $liability_sale['sale_id']);
                            ?>

                            <input type="submit" name="submit" value="Hủy" id="submit_delete" class="submit_button float_right">
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