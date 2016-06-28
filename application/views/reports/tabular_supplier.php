<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?>' />
                </td>
                <td id="title" style="font-size: 20px;"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
                <td><a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px; color: #FFF" href=<?php echo site_url() . '/reports/summary_suppliers' ?>>Trở lại</a></td>
            </tr>
            <tr style="margin-top: 8px;">
                <td>&nbsp;</td>
                <td><small style="font-size: 15px; font-style: italic"><?php echo $subtitle ?></small></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br /><div style="color:#000">
            <table id="contents">
                <tr>
                    <td id="item_table">
                        <div id="table_holder" style="width: 960px;">
                            <table class="tablesorter report" id="sortable_table" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th><a href="#" class="expand_all" style="font: 14px solid; color:#FFFFFF; margin-left: -25px">+</a></th>
                                        <th style="text-align: center">Nhà cung cấp</th>
                                        <th style="text-align: center">Số lượng</th>
                                        <th style="text-align: center">Tổng tiền thanh toán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //$total_other_taxes = 0;
                                    $data_supplier = $this->Sale->get_supplier_in_receiving($start_date, $end_date);
                                    foreach ($data_supplier as $value) {
                                      
                                        $info_supplier = $this->Supplier->get_info($value['supplier_id']);
                                        $data_receiving = $this->Sale->get_receiving_by_supplier($value['supplier_id'], $sale_type, $start_date, $end_date);                           
                                        $data_receiving1 = $this->Sale->get_receiving_by_supplier_other_taxes($value['supplier_id'], $sale_type, $start_date, $end_date);                           
                                        foreach ($data_receiving1 as $receiving1) {
                                                  $total_other_taxes += $this->Receiving->get_info($receiving1['receiving_id'])->row()->other_cost + $this->Receiving->get_info($receiving1['receiving_id'])->row()->money_1331;
                                                }
                                        if ($data_receiving) {
                                            
                                            ?>
                                            <tr>
                                                <td><a href='#' class='expand' style='font: 12px solid'>+</a></td>
                                                <td style="text-align: center"><?php echo $info_supplier->company_name ?></td>
                                                <?php
                                                $total_quantity = 0;
                                                $pay_amount = 0;
                                                
                                                foreach ($data_receiving as $receiving) {
//                                                    
                                                    if ($receiving['supplier_id'] == $value['supplier_id']) {
                                                        $total_quantity += $receiving['quantity_purchased'];
                                                        $pay_amount += $receiving['quantity_purchased'] * $receiving['item_unit_price'] - $receiving['quantity_purchased'] * $receiving['item_unit_price'] * $receiving['discount_percent'] / 100 ;
                                                    }
                                                }
                                                ?>
                                                <td style='text-align: right;'><?php echo format_quantity($total_quantity) ?></td>
                                                <td style='text-align: right;'><?php echo to_currency_unVND_nomar($pay_amount+$total_other_taxes) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan='4' class='innertable'>
                                                    <table class='innertable' style='font-size: 12px'>
                                                        <thead>
                                                            <tr>
                                                                <th>Mã MH</th>
                                                                <th>Tên MH</th>
                                                                <th>ĐVT</th>
                                                                <th>Số lượng</th>
                                                                <th>Giá bán</th>
                                                                <th>CK %</th>
                                                                <th>Thành tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($data_receiving as $receiving) {
                                                                if ($receiving['supplier_id'] == $value['supplier_id']) {
                                                                    $info_item = $this->Item->get_info($receiving['item_id']);
                                                                    $info_unit = $this->Unit->get_info($info_item->unit);
                                                                    $amount = $receiving['quantity_purchased'] * $receiving['item_unit_price'] - $receiving['quantity_purchased'] * $receiving['item_unit_price'] * $receiving['discount_percent'] / 100;
                                                                    $total_other_taxes = $this->Receiving->get_info($value['receiving_id'])->row()->other_cost + $this->Receiving->get_info($value['receiving_id'])->row()->money_1331;
                                                                    ?>
                                                                    <tr>
                                                                       	<td><?php echo $info_item->item_number ?></td>
                                                                        <td><?php echo $info_item->name ?></td>
                                                                        <td style='text-align: center'><?php echo $receiving['quantity_purchased'] ?></td>
                                                                        <td style='text-align: right'><?php echo format_quantity($receiving['quantity_purchased']) ?></td>
                                                                        <td style='text-align: right'><?php echo to_currency_unVND_nomar($receiving['item_unit_price']) ?></td>
                                                                        <td style='text-align: right'><?php echo $receiving['discount_percent'] ?></td>
                                                                        <td style='text-align: right'><?php echo to_currency_unVND_nomar($amount) ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>                                         
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $total_money += $pay_amount;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                            <div class="summary_row"><strong>Tổng tiền thanh toán: </strong><?php echo to_currency($total_money); ?></div>
                        </div>
                    </td>
                </tr>
            </table>
            <div id="feedback_bar"></div>
        </div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
    function init_table_sorting()
    {
        //Only init if there is more than one row
        if ($('.tablesorter tbody tr').length > 1)
        {
            $("#sortable_table").tablesorter();
        }
    }
    $(document).ready(function ()
    {
        init_table_sorting();
    });
</script>