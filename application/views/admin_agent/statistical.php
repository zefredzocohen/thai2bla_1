<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#start_date').datePicker({startDate: '01-01-1950'}).bind(
                'dpClosed',
                function (e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('#end_date').dpSetStartDate(d.addDays(0).asString());
                    }
                }
        );
        $('#end_date').datePicker().bind(
                'dpClosed',
                function (e, selectedDates) {
                    var d = selectedDates[0];
                    if (d) {
                        d = new Date(d);
                        $('#start_date').dpSetEndDate(d.addDays(0).asString());
                    }
                }
        );
    })
</script>
<STYLE type="text/css">
    .info{
        width:100%;
        height: 50px;
        background:#6dffff none repeat scroll 0 0;
        line-height: 50px;
        text-align: center;
        font-size: 18px;
        color: #990000;
        text-transform: uppercase;
        font-weight: bold;
    }
    .info1{
        width:100%;
        height: 40px;
        background: #6dffff none repeat scroll 0 0;
        line-height: 40px;
        text-align: center;
        font-size: 14px;
        color: #990000;
        text-transform: uppercase;
        font-weight: bold;
        margin-top: 15px;
    }
    .agent{
        width:20%;
        height: 20px;
        background: #6dffff none repeat scroll 0 0;
        line-height: 20px;
        text-align: center;
        font-size: 12px;
        color: #990000;
        text-transform: uppercase;
        font-weight: bold;
        margin-top: 5px;
    }
    .form-control{
        width: 500px;
    }
    label.error{
        color:red;
    }
    tr td{
        padding: 7px; 
    }
    .title{
        border-bottom: 1px dotted rgb(204, 204, 204);
        padding: 3px 0;
    }
    td{
        border: 1px solid #ccc;
        line-height: 22px;
    }
</style>

<div id="content_area_wrapper">
    <fieldset id="customer_basic_info" style="border: none">
        <div id="content_area" style="color:#000;">
            <?php echo form_open("admin_agent/statistical/".$person_info->person_id, array('id' => 'search_by_date_form')); ?>
            <div class="field_row clearfix">
                <div class='form_field' style="float:left;padding-top: 5px">
                    <input placeholder="Từ ngày" type="text" class="date-pick" id="start_date" name="start_date" value='' style=" background-color: #ffffff; width: 82px; font-size: 14px; margin-top: 0px; " />
                    <input placeholder="đến ngày" type="text" class="date-pick" id="end_date" name="end_date" value='' style=" background-color: #ffffff; width: 82px; font-size: 14px; margin-top: 0px; margin-left: 10px; float: left;" />
                </div>

                <?php
                echo form_button(array(
                    'type' => 'submit',
                    'name' => 'search_by_date',
                    'id' => 'search_by_date',
                    'content' => 'Xem thống kê',
                    'style' => 'height: 20px; line-height:15px;width:100px; margin: 7px 0px 0px 0px')
                );
                ?>
            </div>
            </form>

            <?php 
               $this->load->model('Customer');  
               $start_date1 = $this->input->post('start_date');
                $end_date1 = $this->input->post('end_date');
                $tam = $end_date1;
                $tam .='23:59:59';
                $start_date = date('Y-m-d H:i:s', strtotime($start_date1));
                $end_date = date('Y-m-d H:i:s', strtotime($tam));
            ?>
            <DIV class="info">Thống kê lịch sử mua hàng của <?= $this->Customer->get_info($person_info->person_id)->first_name . ' ' . $this->Customer->get_info($person_info->person_id)->last_name; ?></DIV>

            <table border="0" style="width:100%;margin-top:10px">
                <tr>
                    <td style="font-weight: bold;">STT</td>
                    <td style="font-weight: bold ;">Ngày</td>
                    <td style="font-weight: bold">Tên mặt hàng</td>
                    <?php
                    if ($this->Customer->get_info($person_info->person_id)->status == 1):
                        ?>
                        <td style="font-weight: bold">Điểm mặt hàng</td>
                    <?php endif; ?>
                    <td style="font-weight: bold">Số lượng</td>
                    <td style="font-weight: bold">Ðơn giá</td>
                    <td style="font-weight: bold">Thuế</td>
                    <td style="font-weight: bold">Thành tiền</td>
                </tr>
                <?php
                $this->load->model('Customer');
                $this->load->model('Item');
                $cus_id = $person_info->person_id;
                $stt = 1;
                $money = 0;
                $total_money = 0;
                $poiter = 0;
                $info_sale = $this->Customer->order_sales($cus_id, $start_date, $end_date);
                $info_sale_items = $this->Customer->order_sales_items();

                foreach ($info_sale as $sale) {
                    foreach ($info_sale_items as $sale_item) {
                        if ($sale['sale_id'] == $sale_item['sale_id']) {
                            $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);

                            if ($unit_price['unit_from'] == $sale_item['unit_item']) {
                                $price = $sale_item['item_unit_price_rate'];
                            } else {
                                $price = $sale_item['item_unit_price'];
                            }
                            $taxes = ($price * $sale_item['quantity_purchased'] - $price * $sale_item['quantity_purchased'] * 0) * $sale_item['taxes_percent'] / 100;

                            $money = $taxes + ($sale_item['quantity_purchased'] * $price);
                            $poiter += $sale_item['quantity_purchased'] * $this->Item->get_info($sale_item['item_id'])->poiter;
                            ?>
                            <tr>
                                <td><?= $stt++; ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($sale_item['date'])); ?></td>
                                <td><?= $this->Item->get_info($sale_item['item_id'])->name ?></td>
                                <?php
                                if ($this->Customer->get_info($person_info->person_id)->status == 1):
                                    ?>
                                    <td align="right"><?= $this->Item->get_info($sale_item['item_id'])->poiter ?></td>
                                <?php endif; ?>
                                <td align="right"><?= $sale_item['quantity_purchased']; ?></td>
                                <td align="right"><?= number_format($price); ?></td>
                                <td align="right"><?= $sale_item['taxes_percent']; ?></td>
                                <td align="right"><?= to_currency($money) ?></td>
                            </tr>
                            <?php
                            $total_money += $money;
                        }
                    }
                }
                ?>
                <!--diem dai ly cap duoi-->
                <?php
                $total = 0;
                $cus_id = $person_info->person_id;
                $customer = $this->Customer->person_customer();
                $unit_price = $this->Customer->get_unit_item();
                foreach ($customer->result_array() as $info_cus) {
                    if ($cus_id == $info_cus['agent']) {
                        $get_info_agent = $this->Customer->get_info_agent($info_cus['agent']);
                        foreach ($get_info_agent as $info_agent) {
                            $check = $this->Customer->check_person_id($info_agent->person_id);
                            $info_sale = $this->Customer->order_sales($info_agent->person_id, $start_date, $end_date);
                            $info_sale_items = $this->Customer->order_sales_items();

                            foreach ($info_sale as $sale) {
                                foreach ($info_sale_items as $sale_item) {
                                    if ($sale['sale_id'] == $sale_item['sale_id']) {
                                        $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);
                                        $total += $sale_item['quantity_purchased'] * $this->Item->get_info($sale_item['item_id'])->poiter;
                                    }
                                }
                                ?>


                                <?php
                            }
                        }
                        if ($check == 1) {
                            break;
                        }
                    }
                }
                ?>

                <!--end --->
                <tr>
                    <td colspan="8" style="font-weight: bold">Tống số tiền : <?= to_currency($total_money); ?></td>
                </tr>
                <tr>
                    <td colspan="8" style="font-weight: bold;color: red">Tống điểm : <?= number_format($poiter,2); ?></td>
                </tr>

                <tr>
                    <td colspan="8" style="font-weight: bold;color: red">Tống điểm của cả nhóm: <?= number_format($poiter + $total, 2); ?></td>
                </tr>
                <!-- hoa hong cua đại lý chính-->
                <?php
                $this->load->model('Item');
                $cus_id = $person_info->person_id;
                $info_sale = $this->Customer->order_sales($cus_id, $start_date, $end_date);
                $info_sale_items = $this->Customer->order_sales_items();
                $rose_total = 0;
                foreach ($info_sale as $sale) {
                    foreach ($info_sale_items as $sale_item) {
                        if ($sale['sale_id'] == $sale_item['sale_id']) {
                            $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);

                            if ($unit_price['unit_from'] == $sale_item['unit_item']) {
                                $price = $sale_item['item_unit_price_rate'];
                            } else {
                                $price = $sale_item['item_unit_price'];
                            }
                            $taxes = ($price * $sale_item['quantity_purchased'] - $price * $sale_item['quantity_purchased'] * 0) * $sale_item['taxes_percent'] / 100;
                            $get_poi = $this->Customer->poiter_all();
                            foreach ($get_poi as $key => $poi_value) {
                                if (($total + $poiter) > $poi_value['rose_old'] && ($total + $poiter) <= $poi_value['rose_next_old']) {

                                    $set_poi = $poi_value['percent'];
                                    $rose_total += $price * $sale_item['quantity_purchased'] * $set_poi / 100;
                                }
                            }
                        }
                    }
                }
                ?>
                <!--end đại lý chính-->

                <tr>
                    <td colspan="8" style="font-weight: bold;color: red">Hoa hồng cá nhân: <?= number_format($rose_total, 2); ?></td>
                </tr>
            </table>
            <DIV class="title"></DIV>
            <?php
            if ($this->Customer->get_info($person_info->person_id)->status == 1):
                ?>
                <DIV class="info1">Danh sách các đại lý của bạn</DIV>


                <?php
                $this->load->model('Customer');
                $this->load->model('Item');
                $cus_id = $person_info->person_id;
                $money = 0;
                $total = 0;
                $customer = $this->Customer->person_customer();
                $unit_price = $this->Customer->get_unit_item();
                foreach ($customer->result_array() as $info_cus) {
                    if ($cus_id == $info_cus['agent']) {
                        $get_info_agent = $this->Customer->get_info_agent($info_cus['agent']);
                        foreach ($get_info_agent as $info_agent) {
                            $stt = 1;
                            ?>

                            <DIV class="agent"><?php echo $this->Customer->get_info($info_agent->person_id)->first_name . ' ' . $this->Customer->get_info($info_agent->person_id)->last_name; ?></DIV>

                            <?php
                            $check = $this->Customer->check_person_id($info_agent->person_id);
                            $info_sale = $this->Customer->order_sales($info_agent->person_id, $start_date, $end_date);
                            $info_sale_items = $this->Customer->order_sales_items();
                            $total_money = 0;
                            $poiter_agent = 0;
                            ?>

                            <table border="0" style="width:100%;margin-top:10px">
                                <tr>
                                    <td style="font-weight: bold;">STT</td>
                                    <td style="font-weight: bold ;">Ngày</td>
                                    <td style="font-weight: bold">Tên mặt hàng</td>
                                    <td style="font-weight: bold">Điểm mặt hàng</td>
                                    <td style="font-weight: bold">Số lượng</td>
                                    <td style="font-weight: bold">Ðơn giá</td>
                                    <td style="font-weight: bold">Thuế</td>
                                    <td style="font-weight: bold">Thành tiền</td>
                                </tr>
                                <?php
                                foreach ($info_sale as $sale) {
                                    foreach ($info_sale_items as $sale_item) {
                                        if ($sale['sale_id'] == $sale_item['sale_id']) {
                                            $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);

                                            if ($unit_price['unit_from'] == $sale_item['unit_item']) {
                                                $price = $sale_item['item_unit_price_rate'];
                                            } else {
                                                $price = $sale_item['item_unit_price'];
                                            }

                                            $taxes = ($price * $sale_item['quantity_purchased'] - $price * $sale_item['quantity_purchased'] * 0) * $sale_item['taxes_percent'] / 100;

                                            $money = $taxes + ($sale_item['quantity_purchased'] * $price);
                                            $total_money += $money;
                                            $poiter_agent += $sale_item['quantity_purchased'] * $this->Item->get_info($sale_item['item_id'])->poiter;
                                            $total += $sale_item['quantity_purchased'] * $this->Item->get_info($sale_item['item_id'])->poiter;
                                            //tính % các đại lý
                                            $this->load->model('Customer');
                                            $get_poi1 = $this->Customer->poiter_all();
                                            foreach ($get_poi1 as $key => $poi_value1) {
                                                if ($poiter_agent > $poi_value1['rose_old'] && $poiter_agent <= $poi_value1['rose_next_old']) {
                                                    $p_poi_percent = $poi_value1['percent'];
                                                }
                                            }
                                            ?>


                                            <tr>
                                                <td><?= $stt++; ?></td>
                                                <td><?= date('d-m-Y H:i:s', strtotime($sale_item['date'])); ?></td>
                                                <td><?= $this->Item->get_info($sale_item['item_id'])->name ?></td>
                                                <td align="right"><?= $this->Item->get_info($sale_item['item_id'])->poiter ?></td>
                                                <td align="right"><?=$sale_item['quantity_purchased']; ?></td>
                                                <td align="right"><?= number_format($price); ?></td>
                                                <td align="right"><?= $sale_item['taxes_percent']; ?></td>
                                                <td align="right"><?= to_currency($money) ?></td>
                                            </tr>


                                            <?php
                                        }
                                    }
                                    ?>
                                    <DIV class="title"></DIV>  

                                    <?php
                                }
                                ?> </table>
                            <p style="font-weight: bold;padding-top:5px;">Tổng tiền : <?= to_currency($total_money); ?></p>
                            <p style="font-weight: bold;padding-top:5px; color:red">Tổng điểm : <?= number_format($poiter_agent, 2); ?></p>
                            <p style="font-weight: bold;padding-top:5px; color:red">Phần trăm hoa hồng : <?= number_format($p_poi_percent, 2); ?>%</p>
                            <p style="font-weight: bold;padding-top:5px; color:red">Phần trăm hoa hồng chênh lệch: <?= number_format($set_poi - $p_poi_percent); ?>%</p>
                            <?php
                        }
                        if ($check == 1) {
                            break;
                        }
                    }
                }
                ?>



                <DIV class="info1">Hạn mức hoa hồng tổng cộng </DIV>
                <?php
                $this->load->model('Customer');
                $get_poi = $this->Customer->poiter_all();
                foreach ($get_poi as $key => $poi_value):

                    if (($total + $poiter) > $poi_value['rose_old'] && ($total + $poiter) <= $poi_value['rose_next_old']):
                        $p_poi = $poi_value['percent'];
                        ?>
                    <!--                            <p style="font-weight: bold;padding-top:5px; color:red">Điểm tổng cộng tất cả  : <?= number_format($total + $poiter); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;=> Doanh số phần trăm tổng cộng : <?= $poi_value['percent']; ?>%
                                        </p>
                                        <p style="font-weight: bold;padding-top:5px; color:red">Điểm tổng cộng của đại lý cấp dưới   : <?= number_format($total); ?>
                                        </p>    -->
                        <?php
                    endif;
                endforeach;
                ?>
                <!-- loi nhuan-->
                <?php
                $this->load->model('Customer');
                $this->load->model('Item');
                $cus_id = $person_info->person_id;
                $info_sale = $this->Customer->order_sales($cus_id, $start_date, $end_date);
                $info_sale_items = $this->Customer->order_sales_items();
                $rose_total = 0;
                foreach ($info_sale as $sale) {
                    foreach ($info_sale_items as $sale_item) {
                        if ($sale['sale_id'] == $sale_item['sale_id']) {
                            $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);

                            if ($unit_price['unit_from'] == $sale_item['unit_item']) {
                                $price = $sale_item['item_unit_price_rate'];
                            } else {
                                $price = $sale_item['item_unit_price'];
                            }
                            $taxes = ($price * $sale_item['quantity_purchased'] - $price * $sale_item['quantity_purchased'] * 0) * $sale_item['taxes_percent'] / 100;
                            $get_poi = $this->Customer->poiter_all();
                            foreach ($get_poi as $key => $poi_value) {
                                if (($total + $poiter) > $poi_value['rose_old'] && ($total + $poiter) <= $poi_value['rose_next_old']) {

                                    $set_poi = $poi_value['percent'];
                                    $rose_total += $price * $sale_item['quantity_purchased'] * $set_poi / 100;
                                }
                            }
                        }
                    }
                }
                ?>
                <p style="font-weight: bold;padding-top:5px; color:red">Hoa hồng đại lý <?= $this->Customer->get_info($person_info->person_id)->first_name . ' ' . $this->Customer->get_info($person_info->person_id)->last_name; ?> : <?= number_format($rose_total); ?>
                </p> 

                <!-- loi nhuận từng đại lý -->
                <?php
                $this->load->model('Customer');
                $this->load->model('Item');
                $cus_id = $person_info->person_id;
                $money = 0;
                $total = 0;

                $customer = $this->Customer->person_customer();
                $unit_price = $this->Customer->get_unit_item();
                foreach ($customer->result_array() as $info_cus) {
                    if ($cus_id == $info_cus['agent']) {
                        $get_info_agent = $this->Customer->get_info_agent($info_cus['agent']);
                        foreach ($get_info_agent as $info_agent) {
                            $stt = 1;
                            ?>

                            <DIV class="agent"><?php echo $this->Customer->get_info($info_agent->person_id)->first_name . ' ' . $this->Customer->get_info($info_agent->person_id)->last_name; ?></DIV>

                            <?php
                            $check = $this->Customer->check_person_id($info_agent->person_id);
                            $info_sale = $this->Customer->order_sales($info_agent->person_id, $start_date, $end_date);
                            $info_sale_items = $this->Customer->order_sales_items();
                            $total_money = 0;
                            $poiter_agent = 0;
                            foreach ($info_sale as $sale) {
                                foreach ($info_sale_items as $sale_item) {
                                    if ($sale['sale_id'] == $sale_item['sale_id']) {

                                        $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);

                                        if ($unit_price['unit_from'] == $sale_item['unit_item']) {
                                            $price = $sale_item['item_unit_price_rate'];
                                        } else {
                                            $price = $sale_item['item_unit_price'];
                                        }


                                        $poiter_agent += $sale_item['quantity_purchased'] * $this->Item->get_info($sale_item['item_id'])->poiter;
                                    }
                                }
                                ?>

                                <DIV class="title"></DIV>  

                                <?php
                            }
                            //tính % các đại lý
                            $pt = 0;
                            $get_poi_agent = $this->Customer->poiter_all();
                            foreach ($get_poi_agent as $key => $poi_value_agent) {
                                if ($poiter_agent > $poi_value_agent['rose_old'] && $poiter_agent <= $poi_value_agent['rose_next_old']) {
                                    $p_poi_percent = $poi_value_agent['percent'];
                                    foreach ($info_sale as $sale) {
                                        foreach ($info_sale_items as $sale_item) {
                                            if ($sale['sale_id'] == $sale_item['sale_id']) {

                                                $unit_price = $this->Customer->get_unit_item($sale_item['item_id']);

                                                if ($unit_price['unit_from'] == $sale_item['unit_item']) {
                                                    $price = $sale_item['item_unit_price_rate'];
                                                } else {
                                                    $price = $sale_item['item_unit_price'];
                                                }
                                                $poi_max = $this->Customer->poi_max();
                                                foreach ($poi_max as $p) {
                                                    if ($p_poi_percent >= $p['percent']) {
                                                        $pt += $sale_item['quantity_purchased'] * $price * 2 / 100;
                                                        $total +=$sale_item['quantity_purchased'] * $price * 2 / 100;
                                                    } else {
                                                        $pt += $sale_item['quantity_purchased'] * $price * ($p_poi - $p_poi_percent) / 100;
                                                        $total +=$sale_item['quantity_purchased'] * $price * ($p_poi - $p_poi_percent) / 100;
                                                    }
                                                }
                                                //  $pt += $sale_item['quantity_purchased'] * $price *($p_poi - $p_poi_percent)/100;
                                                //$total +=$sale_item['quantity_purchased'] * $price *($p_poi - $p_poi_percent)/100;
                                            }
                                        }
                                    }
                                }
                            }
                            ?>

                            <p style="font-weight: bold;padding-top:5px; color:red">Hoa hồng đại lý : <?= number_format($pt); ?></p>
                            <?php
                        }
                        if ($check == 1) {
                            break;
                        }
                    }
                }
                ?>
                <!-- end-->
                <p style="font-weight: bold;padding-top:5px; color:red">Tổng tiền hoa hồng cá nhân và đại lý của <?= $this->Customer->get_info($person_info->person_id)->first_name . ' ' . $this->Customer->get_info($person_info->person_id)->last_name; ?> nhận được :<?= number_format($rose_total + $total); ?>
                </p> 
            <?php endif; ?>


        </div>
</div>
<?php $this->load->view("partial/footer"); ?>