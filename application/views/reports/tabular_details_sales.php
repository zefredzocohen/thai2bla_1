<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <script type="text/javascript">

            $(document).ready(function () {
                $(".print_report").click(function () {
                    window.print();
                });
            });
        </script>
        <style type="text/css">
            .print_report{
                background: none repeat scroll 0 0 #1E5A96;
                border: 1px solid #EEEEEE;
                color: #FFFFFF;
                font-size: 14px;
                font-weight: bold;
                line-height: 30px;
                margin-left: 9px;
                padding: 5px;
                text-align: center;
                width: 100px;
            }
        </style>
<?php 
$this->load->model('sale');
$this->load->model('person');?>
        <table id="title_bar">
            <tr>
                <td id="title_icon">
                    <img src='<?php echo base_url() ?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
                </td>
                <td id="title"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
                <td>
                    <a style="font-size:18px;text-decoration: underline;color:#FFF;" href="<?php echo base_url(); ?>reports/detailed_sales">Trở lại</a>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="font-size: 18px; font-style: italic;"><small><?php echo $subtitle ?></small></td>
                <td></td>
            </tr>
        </table>
        <br />		

        <div style="margin-top:30px;"><h3>Lịch sử giao dịch</h3></div>
        <table id="contents">
            <tr>
                <td id="item_table">
                    <div id="table_holder" style="width: 960px;">
                        <table class="tablesorter report" id="sortable_table">
                            <thead>
                                <tr>
                                    <th><a href="#" class="expand_all" style="font: 17px solid">+</a></th>
                                    <th>Mã ĐH</th>
                                    <th style="width:60px">Ngày</th>
                                    <th style="width:90px">Nhân viên bán</th>
                                    <th>Tên khách hàng</th>
                                    <th>Số lượng</th>

                                    <th>Giá trị đơn hàng</th>
                                    <th>Tổng chiết khấu</th>
                                    <th>Thuế</th>
                                    <th>Doanh thu</th>
                                    <?php if ($item_type == '4') { ?>
                                        <th>Thực thu</th>
                                    <?php } ?>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php // echo "<pre>"; print_r($data_sale_item);
                                foreach ($data_sale_item as $key => $val){ 
                                    foreach ($val as $key1 => $val1){?>
                                    <tr>
                                        <td><a href="#" class="expand" style="font: 17px solid">+</a></td>
                                        <td><a href="#">ĐH&nbsp;<?= $key ?></a></td>
                                        <?php
                                        $tam =  $this->Sale->get_info($key)->row_array();
                                        $customer = $this->Person->get_info($tam['customer_id']);
                                        $employe = $this->Person->get_info($tam['employee_id']);
                                        ?>
                                        <td><?= date('d-m-Y H:i:s', strtotime($tam['sale_time'])) ?></td>
                                        <td><?= $employe->first_name . ' ' . $employe->last_name ?></td>
                                        <?php
                                          if($tam['customer_id'] == NULL){
                                              $name = "Khách lẻ";
                                          }else{
                                              if($this->Customer->get_info($tam['customer_id'])->company_name != NULL){
                                                  $name = $this->Customer->get_info($tam['customer_id'])->company_name;
                                              }elseif($this->Customer->get_info($tam['customer_id'])->manages_name != NULL){
                                                   $name = $this->Customer->get_info($tam['customer_id'])->manages_name;
                                              }else{
                                                  $name = $customer->first_name . ' ' . $customer->last_name ;
                                              }
                                          }
                                        ?>
                                        <td><?= $name;?></td>                                        
                                        <?php 
                                        $quan_puc = 0;
                                        $discount_percent = 0;
                                        $tax = 0;
                                        $total_sale = 0;
                                        $discount_money = 0;
                                        $pay_amount = 0;
                                        foreach ($val1 as $val2){
                                            $quan_puc += $val2['quantity_purchased'];
                                            if($val2['unit_from']){
                                                if($val2['unit_from'] == $val2['unit_item']){
                                                    $item_unit_price = $val2['item_unit_price_rate'];
                                                }else{
                                                    $item_unit_price = $val2['item_unit_price'];
                                                }
                                            }
                                            else{
                                                $item_unit_price = $val2['item_unit_price'];
                                            }                                            
                                            $discount_percent += $item_unit_price*$val2['quantity_purchased']*$val2['discount_percent']/100;
                                            $tax += ($item_unit_price*$val2['quantity_purchased']-$item_unit_price*$val2['quantity_purchased']*$val2['discount_percent']/100)*$val2['taxes_percent']/100;
                                            $total_sale += $item_unit_price*$val2['quantity_purchased'];
                                        }                                                                               
                                        $sale_tam = $this->Sale->get_sales_tam($key);
                                        foreach ($sale_tam as $val3){
                                            $pay_amount += $val3['pays_amount'];
                                            $discount_money += $val3['discount_money'];
                                        }
                                        $total_tax += $tax;
                                        if($pay_amount >= ($total_sale-$discount_percent+$tax-$discount_money)){
                                            $total_real += ($total_sale-$discount_percent+$tax-$discount_money);
                                        }else{
                                            $total_real += $pay_amount;
                                        }
                                        if($item_type == 4){
                                            $total_discount_money += $discount_money + $discount_percent;
                                            $total_cost += $total_sale-$discount_percent+$tax- $discount_money;
                                        }else{
                                            $total_discount_money += $discount_percent;
                                            $total_cost += $total_sale-$discount_percent+$tax;
                                        }
                                        ?>
                                        <td style="text-align: right"><?php echo format_quantity($quan_puc);?></td>
                                        <td style="text-align: right"><?php echo number_format($total_sale);?></td>
                                        <td style="text-align: right">
                                            <?php if($item_type == 4){
                                                echo number_format($discount_percent + $discount_money);                                                
                                            }else{
                                                echo number_format($discount_percent);
                                            }?>
                                        </td>
                                        <td style="text-align: right"><?php echo number_format($tax);?></td>
                                        <td style="text-align: right">
                                            <?php 
                                            if($item_type == 4){
                                                echo number_format($total_sale-$discount_percent+$tax-$discount_money);
                                            }else{
                                                echo number_format($total_sale-$discount_percent+$tax);}?>
                                        </td>
                                        <?php if ($item_type == '4') { ?>
                                        <?php
                                           if($pay_amount >= ($total_sale-$discount_percent+$tax-$discount_money)){
                                        ?>
                                        <td style="text-align: right"><?php echo number_format($total_sale-$discount_percent+$tax-$discount_money);?></td>
                                           <?php }else{?>
                                        <td style="text-align: right"><?php echo number_format($pay_amount);?></td>
                                           <?php }?>
                                        <?php }?>
                                        <td style="text-align: right"><?php echo $tam['comment']?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="13" class="innertable" style="font-size: 0.95em!important;">
                                            <table class="innertable">
                                                <thead>
                                                    <tr>
                                                        <th>Mã MH</th>
                                                        <th>Tên MH</th>
                                                        <th>ĐVT</th>
                                                        <th>Số lượng</th>
                                                        <th>Giá bán</th>
                                                        <th>CK %</th>
                                                        <th>Thuế %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $discount_percent2 = 0;
                                                    foreach ($val1 as $val4){
//                                                  echo "<pre>"; print_r($val4);
                                                        if($val4['unit_from']){
                                                            if($val4['unit_from'] == $val4['unit_item']){
                                                                $item_unit_price = $val4['item_unit_price_rate'];
                                                                $unit = $this->Unit->get_info($val4['unit_from']);
                                                            }else{
                                                                $item_unit_price = $val4['item_unit_price'];
                                                                $unit = $this->Unit->get_info($val4['unit']);
                                                            }
                                                        }
                                                        else{
                                                            $item_unit_price = $val4['item_unit_price'];
                                                            $unit = $this->Unit->get_info($val4['unit']);
                                                        } 
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                if($val4['item_id']){
                                                                    echo $this->Item->get_info($val4['item_id'])->item_number;
                                                                }else{
                                                                    echo $this->Pack->get_info($val4['pack_id'])->pack_number;
                                                                }?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if($val4['item_id']){
                                                                    echo $this->Item->get_info($val4['item_id'])->name;
                                                                }else{
                                                                    echo $this->Pack->get_info($val4['pack_id'])->name;
                                                                }?>
                                                            </td>
                                                            <td style="text-align: right"><?php echo $unit->name?></td>
                                                            <td style="text-align: right"><?php echo format_quantity($val4['quantity_purchased'])?></td>
                                                            <td style="text-align: right"><?php echo number_format($item_unit_price)?></td>
                                                            <td style="text-align: right"><?php echo number_format($val4['discount_percent'])?></td>
                                                            <td style="text-align: right"><?php echo number_format($val4['taxes_percent'])?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    
                                    <?php }
                                }?>
                            </tbody>
                        </table>
                    </div>
                    <div id="report_summary" class="tablesorter report" style="margin-right: 10px;">
                    <div class="summary_row"><strong>Tổng doanh thu: </strong><?= to_currency($total_cost) ?>
                    <div class="summary_row"><strong>Tổng chiết khấu: </strong><?= to_currency($total_discount_money) ?>
                    <div class="summary_row"><strong>Tổng thuế: </strong><?= to_currency($total_tax) ?>
                    <?php if($item_type == 4){?>
                    <div class="summary_row"><strong>Tổng thực thu: </strong><?= to_currency($total_real) ?></div>
                    <?php }?>
                </td>
            </tr>
        </table>

        <input id="submit" name="submit" class="print_report" value="In hóa đơn" onclick="this.style.display = 'none';
                                        window.print();" />

</div></div>
<?php $this->load->view("partial/footer"); ?>
                        <script type="text/javascript" language="javascript">
                            $(document).ready(function ()
                            {
                                $(".tablesorter a.expand").click(function (event)
                                {
                                    console.log('abcd');
                                    $(event.target).parent().parent().next().find('td.innertable').toggle();

                                    if ($(event.target).text() == '+')
                                    {
                                        $(event.target).text('-');
                                    }
                                    else
                                    {
                                        $(event.target).text('+');
                                    }
                                    return false;
                                });

                                $(".tablesorter a.expand_all").click(function (event)
                                {
                                    $('td.innertable').toggle();

                                    if ($(event.target).text() == '+')
                                    {
                                        $(event.target).text('-');
                                    }
                                    else
                                    {
                                        $(event.target).text('+');
                                    }
                                    return false;
                                });




                            });
                        </script>