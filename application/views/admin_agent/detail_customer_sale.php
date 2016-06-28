<?php $this->load->view("partial/header"); ?> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<style type="text/css">
    .complete {
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
        text-align: center;
        float: left;
    }
    .print_report_1{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        padding: 5px;
        text-align: center;
    }
    h1 {font-size: 3em; margin: 20px 0; color: #FFF;}
    .container {width: 99%; margin: 10px auto;}
    ul.tabs {
        margin: 0;
        padding: 0;
        float: left;
        list-style: none;
        height: 32px;
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        width: 100%;
    }
    ul.tabs li {
        float: left;
        margin: 0;
        padding: 0;
        height: 31px;
        line-height: 31px;
        border: 1px solid #ccc;
        border-left: none;
        margin-bottom: -1px;
        background: #F0F0F0;
        overflow: hidden;
        position: relative;
    }
    ul.tabs li a {
        text-decoration: none;
        color: #000;
        display: block;
        font-size: 12px;
        font-weight: bold;
        padding: 0 16px;
        border: 1px solid #fff;
        outline: none;
    }
    ul.tabs li a:hover {
        background: #ccc;
    }	
    html ul.tabs li.active, html ul.tabs li.active a:hover  {
        background: #fff;
        border-bottom: 1px solid #fff;
    }
    .tab_container {
        border: 1px solid #ccc;
        border-top: none;
        clear: both;
        float: left; 
        width: 100%;
        background: #fff;
        -moz-border-radius-bottomright: 5px;
        -khtml-border-radius-bottomright: 5px;
        -webkit-border-bottom-right-radius: 5px;
        -moz-border-radius-bottomleft: 5px;
        -khtml-border-radius-bottomleft: 5px;
        -webkit-border-bottom-left-radius: 5px;
    }
    .tab_content {
        padding: 20px;
        font-size: 1.2em;
    }
    .tab_content h2 {
        font-weight: normal;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ddd;
        font-size: 1.8em;
    }
    .tab_content h3 a{
        color: #254588;
    }
    .tab_content img {
        float: left;
        margin: 0 20px 20px 0;
        border: 1px solid #ddd;
        padding: 5px;
    }
    #submit_delete
    {
        background: url("images/pieces/btnUpdate.png") no-repeat scroll left top transparent;
        border: 0 none;
        color: #ffffff;
        cursor: pointer;
        display: block;
        font-family: Arial,Helvetica,sans-serif;
        font-size: 11px;
        height: 24px;
        margin: 0 auto;
        text-align: center;
        width: 60px;
    }
    /* hung dq 28-01 */
    .loadmore,.loadmore2,.loadmore3,.loadmore4,.loadmore5, .loadmore6, .loadmore7 {
        color: #FFF;
        border-radius: 5px;
        width: 10%;
        height: 30px;
        font-size: 15px;
        background: #42B8DD;
        outline: 0;
        margin-left: 400px;
        cursor: pointer;
        line-height: 30px;
    }
    .load_button{
        text-align: center;
    }
</style>
<script type="text/javascript">

    $(document).ready(function () {
        //Default Action
        $(".tab_content").hide(); //Hide all content
        $("ul.tabs li:first").addClass("active").show(); //Activate first tab
        $(".tab_content:first").show(); //Show first tab content

        //On Click Event
        $("ul.tabs li").click(function () {
            $("ul.tabs li").removeClass("active"); //Remove any "active" class
            $(this).addClass("active"); //Add "active" class to selected tab
            $(".tab_content").hide(); //Hide all tab content
            var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
            $(activeTab).fadeIn(); //Fade in the active content
            return false;
        });
    });

    //hung dq 28-01
    //tab ban hang 1
    $(document).on('click', '.loadmore', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale").append(response);
                }
            }
        });
    });
    //tab thu chi 2
    $(document).on('click', '.loadmore2', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more2/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale2").append(response);
                }
            }
        });
    });
    //tab giao dich 3
    $(document).on('click', '.loadmore3', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more3/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale3").append(response);
                }
            }
        });
    });
    //tab cong no 4
    $(document).on('click', '.loadmore4', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more4/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale4").append(response);
                }
            }
        });
    });
    //tab bao gia 5
    $(document).on('click', '.loadmore5', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more5/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale5").append(response);
                }
            }
        });
    });
    //tab gui mail 6
    $(document).on('click', '.loadmore6', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more6/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale6").append(response);
                }
            }
        });
    });
    //tab ban hang 1
    $(document).on('click', '.loadmore7', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('customers/load_more_history_sms/' . $customer_info->person_id); ?>",
            type: 'POST',
            data: {
                page: $(this).data('page'),
            },
            success: function (response) {
                if (response) {
                    ele.hide();
                    $("#inventory_sale7").append(response);
                }
            }
        });
    });
</script>

<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">
        <div style="color:#000;">
            <fieldset id="customer_basic_info" style="margin-bottom: 10px;padding-top: 10px; width: 98% !important">
                <legend style="color: #000000;font-size: 15px;font-weight: bold "><?php echo "Thông tin khách hàng" ?></legend>
                <div id="history_customer" style="width: 700px!important;">
                    <p><label>Họ tên :</label> <span style="color:red;"><?php echo $customer_info->first_name . ' ' . $customer_info->last_name; ?></span></p>
                    <p><label>Số ĐT:</label> <?php echo $customer_info->phone_number; ?> </p>
                    <p><label>Công ty :</label> <?php echo $customer_info->company_name; ?> </p>
                    <p><label>Email :</label> <?php echo $customer_info->email; ?></p>
                    <p><label>Địa chỉ :</label> <?php echo $customer_info->address_1; ?></p>
                    <p><label>Tỉnh thành :</label> <span style="color:#ff0000;"><?php echo $this->Customer->get_city_name($customer_info->city)->name; ?></span></p>
                  <!--  <p style="color: #000000;font-size: 13px;font-weight: bold;margin-bottom: 10px">2. Lịch sử giao dịch</p>-->
                </div>
            </fieldset>

            <div class="container" style="margin-left: -1px;">
                <ul class="tabs"> 
                    <li class="active"><a href="#tab3">Lịch sử giao dịch</a></li>
                    <li class=""><a href="#tab5">Lịch sử báo giá</a></li>
                    <li class=""><a href="#tab1">Lịch sử mua hàng</a></li>                    
                    <li class=""><a href="#tab6">Lịch sử gửi mail</a></li>
                    <li class=""><a href="#tab7">Lịch sử gửi SMS</a></li>
                    <li class=""><a href="#tab2">Lịch sử thu chi</a></li>
                    <li class=""><a href="#tab4">Công nợ</a></li>
                </ul>
                <div class="tab_container">
                    <div style="display: none;" id="tab3" class="tab_content">
                        <!--table view exchange employees -> customer-->
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'customers'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
                                    <?php echo 'Thống kê giao dịch của nhân viên với khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <table id="inventory_sale3" class="inventory_sale">
                            <tr class="title_color">
                                <td style="width: 10%;text-align: center">Mã giao dịch </td>
                                <td style="width: 10%;text-align: left;text-indent: 3px">Ngày giao dịch</td>
                                <td style="width: 30%;text-align:left">Nhân viên giao dịch </td>
                                <td style="width: 30%;text-align:left">Tên giao dịch </td>                                
                                <td style="width: 15%;text-align: center">Chi tiết giao dịch</td>
                                <td style="width: 15%;text-align: center">Tiến độ</td>		
                            </tr>
                            <?php
                            if ($emp_trade != null) {
                                foreach ($emp_trade as $emp_trades) {
                                    ?>
                                    <tr>
                                        <td><a href="#" ><?php echo $emp_trades['id']; ?></a></td>
                                        <td style="text-align: center;"><?php echo date('d-m-Y H:i:s', strtotime($emp_trades['start_date'])); ?></td>
                                        <td><?php echo $this->Employee->get_info($emp_trades['person_id'])->first_name . ' ' . $this->Employee->get_info($emp_trades['person_id'])->last_name;
                            ; ?></td>
                                        <td><?php echo $emp_trades['text'] ?></td>
                                        <td><?php echo $emp_trades['report'] ?></td>
                                        <?php if ($emp_trades['progress'] == 1) { ?>
                                            <td>Hoàn thành</td>
                                        <?php } else { ?>
                                            <td><?php echo $emp_trades['progress'] * 100; ?>%</td>
                                        <?php } ?>
        <!--                            <td><?php //echo $cost_completes['name'];   ?>
                                        <?php //echo $this->Cost->get_info_option($cost_completes['name'])->cost_name;  ?>
        <?php //echo $this->Employee->get_info($cost_completes['cost_employees'])->first_name;   ?> 
                        </td>-->
                                    </tr>
                                    <?php
                                }
                                if ($num_rows3 > $number_of_items_per_page) {
                                    ?>
                                    <tr class="loadbutton3 load_button" >
                                        <td colspan="6"><div class="loadmore3 load_more" data-page="2" >Xem thêm</div></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>                               
                                <tr>
                                    <td colspan="6">Không có giao dịch nào!</td>
                                </tr>
                            </table>
<?php } ?>
                        </table>
                    </div>
                    <!-- tab 5 báo giá -->

<?php //echo form_open("customers/customers_check_payment");  ?>
                    <div style="display: block;" id="tab5" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
<?php echo 'Thống kê báo giá của khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" value="<?php echo $customer_id; ?>" name="customers_id">			
                        <table id="inventory_sale5" class="inventory_sale">
                            <tr class="title_color">
                                <td style="width: 7%;text-align: center">Mã BG</td>
                                <td style="width: 10%;text-align: center">Ngày mua hàng</td>
                                <td style="width: 15%;text-align: center">Nhân viên</td>
                                <td style="width: 20%;text-align: center">Mặt hàng </td> 
                                <td style="width: 10%;text-align: center">Giá trị đơn hàng</td>
                                <td style="width: 12%;text-align: center">Trạng thái</td>
                                <td style="width: 12%;text-align: center">Báo giá</td>
                                <td style="width: 8%;text-align: center">Xóa</td>
                            </tr>
                            <?php $sum_money = 0; ?>
                            <?php
                            if ($sale_materials != null) {
                                foreach ($sale_materials as $sale_complete) {
                                    ?>
                                    <tr class="row_inventory_sale" style="text-align: center;">
                                        <td class="row_sale_id" style="text-align: center;"><a href="<?php echo base_url(); ?>index.php/customers/switch_sale/<?php echo $sale_complete['sale_id']; ?>" ><?php echo $sale_complete['sale_id']; ?></a></td>
                                        <td style="text-align: center;"><?php echo date('d-m-Y H:i:s', strtotime($sale_complete['sale_time'])); ?></td>
                                        <td style="text-align: center;"><?php echo $this->Employee->get_info($sale_complete['employee_id'])->first_name . ' ' . $this->Employee->get_info($sale_complete['employee_id'])->last_name; ?>&nbsp;</td>
                                        <td  style="text-align: left;">
                                            <?php
                                            foreach ($detail_sale_materials as $key => $val) {
                                                if ($key == $sale_complete['sale_id']) {
                                                    foreach ($val as $val1) {
                                                        foreach ($val1 as $val2) {
                                                            echo $val2['name'] . " , <br /> ";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>&nbsp;
                                        </td>
                                        <td style="text-align: right;">
                                            <?php
                                            foreach ($sale_data as $key2 => $val2) {
                                                if ($val2->sale_id == $sale_complete['sale_id']) {
                                                    $total_cost = $val2->later_cost_price;
                                                    echo number_format($total_cost);
                                                    break;
                                                }
                                            }
                                            ?>&nbsp;
                                        </td>
                                        <?php
                                        $data_sale_tam = $this->Sale->get_sales_tam($sale_complete['sale_id']);
                                        $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_complete['sale_id']);
                                        $to = 0;
                                        $do = 0;
                                        ?>
                                            <?php if ($sale_complete['suspended'] == 1) { ?>
                                            <td style="text-align: center; color: red;">
                                            <?php echo 'KH đã ghi nợ'; ?>&nbsp;
                                            </td>
                                            <?php } elseif ($sale_complete['liability'] == 1) { ?>
                                            <td style="text-align: center; color:green;">
                                            <?php echo 'KH đã đặt hàng'; ?>&nbsp;
                                            </td>
                                            <?php } else { ?>
                                            <td style="text-align: center;">
                                            <?php echo ''; ?>&nbsp;
                                            </td>
                                            <?php } ?>
                                        <td style="text-align: center; font-size: 10px;">                                            
                                            <?php
                                            $list_sales_materials = $this->Sale->get_sale_material($sale_complete['sale_id']);
                                            foreach ($list_sales_materials as $key => $item) {
                                                echo "<a id='download_file' href='" . site_url() . "/sales/download_matarial?file=" . $item['name'] . "'>Lần " . ($key + 1) . "</a>&nbsp&nbsp";
                                            }
                                            ?>
                                            <?php
//                                                    $a = $this->Sale->get_sale_material($sale_complete['sale_id']);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo form_open('sales/delete_detail_materials', array('id' => 'form_delete_suspended_sale'));
                                            echo form_hidden('suspended_sale_id', $sale_complete['sale_id']);
                                            echo form_hidden('suspended_customer_id', $sale_complete['customer_id']);
                                            ?>
                                            <input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
                                            </form>
                                        </td>
                                    </tr>
    <?php }
    if ($num_rows5 > $number_of_items_per_page) {
        ?>
                                    <tr class="loadbutton5 load_button" >
                                        <td colspan="8"><div class="loadmore5 load_more" data-page="2" >Xem thêm</div></td>
                                    </tr>
        <?php
    }
} else {
    ?>
                                <tr style="text-align: center">
                                    <td colspan="8"  style="text-align: center !important">Không có giao dịch nào!</td>
                                </tr>
                            </table>
                        <?php } ?>
                        </table>
                        <?php //echo form_close(); ?>

                        <?php
                        echo form_submit(array(
                            'value' => 'In phiếu',
                            'class' => 'print_report_1',
                            'onclick' => "this.style.display='none'")
                        );
                        ?>
                    </div>  

                    <!-- ban hang -->
                    <div style="display: none;" id="tab1" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF; margin-bottom: -20px; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
<?php echo 'Thống kê lịch sử mua hàng của khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <table id="inventory_sale" class="inventory_sale">
                            <tr class="title_color">
                                <td style="width: 5%;text-align: center">Mã ĐH</td>
                                <td style="width: 15%;text-align: center;text-indent: 3px">Ngày mua</td>
                                <td style="width: 20%;text-align:center">Mặt hàng </td> 
                                <td style="width: 5%;text-align:center">Tổng SL</td> 
                                <td style="width: 12%;text-align: center">Nhân viên</td>
                                <td style="width: 5%;text-align:center">Tổng giá trị ĐH </td> 
                                <td style="width: 5%;text-align:center">Chiết khấu </td> 
                                <td style="width: 5%;text-align:center">Còn nợ</td>
                                <td style="width: 20%;text-align: center">Hình thức thanh toán</td>
                            </tr>
                            <?php
                            if ($sale_all_invs != null) {
                                foreach ($sale_all_invs as $sale_all) {
                                    if (!(($sale_all['suspended'] == 0) && ($sale_all['liability'] == 0) && ($sale_all['materials'] == 1))) {  // th báo giá
                                        ?>
                                        <tr>
                                            <td><a href="<?php echo base_url(); ?>index.php/customers/switch_sale/<?php echo $sale_all['sale_id']; ?>" ><?php echo $sale_all['sale_id']; ?></a></td>
                                            <td><?php echo date('d-m-Y h:i:s', strtotime($sale_all['sale_time'])); ?></td>
                                                <?php foreach ($detail_sale_all as $key => $val) {
                                                    if ($key == $sale_all['sale_id']) {
                                                        ?>
                                                    <td>
                                                        <?php
                                                        foreach ($val as $val1) {
                                                            foreach ($val1 as $val2) {
                                                                echo $val2['name'] . "<br /> ";
                                                            }
                                                        }
                                                        ?>
                                                    </td>&nbsp;
                                                    <td><?= $val['total_item'] ?>&nbsp;</td>
                                                    <?php }
                                                } ?>
                                            <td><?php echo $this->Employee->get_info($sale_all['employee_id'])->first_name . ' ' . $this->Employee->get_info($sale_complete['employee_id'])->last_name; ?>&nbsp;</td>

                                            <td style="text-align: right;">
                                                <?php
                                                foreach ($sale_data_all as $key2 => $val2) {
                                                    if ($val2->sale_id == $sale_all['sale_id']) {
                                                        $total_cost = $val2->later_cost_price;
                                                        echo number_format($total_cost);
                                                        break;
                                                    }
                                                }
                                                ?>&nbsp;</td>


                                            <?php
                                            $data_sale = $this->Sale->get_sales_tam($sale_all['sale_id']);
                                            $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_all['sale_id']);
                                            $to = 0;
                                            $do = 0;
                                            foreach ($data_sale as $key => $val) {
                                                $to = $to + $val['pays_amount'];
                                                $do = $do + $val['discount_money'];
                                            }
                                            ?>
                                            <td style="text-align: right;"><?= number_format($do) ?>&nbsp;</td>
                                            <td style="text-align: right;"><?= (($total_cost - $to - $do) > 0) ? number_format($total_cost - $to - $do) : 0 ?>&nbsp;</td>
                                            <td style=""><?php foreach ($data_sale as $key => $val) { ?>
                                            <?= $val['pays_type'] . ': ' . number_format($val['pays_amount']) ?> 
                                                    <br>
            <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                if ($num_rows > $number_of_items_per_page) {
                                    ?>
                                    <tr class="loadbutton load_button" >
                                        <td colspan = "9"  ><div class="loadmore load_more" data-page="2" >Xem thêm</div></td>
                                    </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr style="text-align: center">
                                    <td colspan="9"   style="text-align: center !important">Không có giao dịch nào!</td>
                                </tr>
<?php } ?>
                        </table>
<?php
echo form_submit(array(
    'value' => 'In phiếu',
    'class' => 'print_report',
    'onclick' => "this.style.display='none'")
);
?>



                    </div>
                    <!--<div style="display: block;" id="tab1" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF;width: 903px">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title">
<?php echo 'Thống kê lịch sử mua hàng của khách hàng'; ?>
                                </td>
                            </tr>
                        </table>

                        <table id="inventory_sale"  style="width: 98% !important">
                            <tr>
                                <td style="width: 10%;text-align: center">Mã hàng bán </td>
                                <td style="width: 10%;text-align: left;text-indent: 3px">Ngày mua</td>
                                <td style="width: 20%;text-align:left">Mặt hàng </td>
                                <td style="width: 15%;text-align: center">Nhân viên bán</td>
                                <td style="width: 19%;text-align: left">Hình thức thanh toán</td>
                                <td style="width: 19%;text-align: left">Tổng tiền thanh toán</td>
                                <td style="width: 19%;text-align: left">Còn nợ</td>
                            </tr>
                    <?php
                    if ($sale_complete_invs != null) {
                        foreach ($sale_complete_invs as $sale_complete) {
                            ?>
                                            <tr>
                                                <td><a href="<?php echo base_url(); ?>index.php/customers/switch_sale/<?php echo $sale_complete['sale_id']; ?>" ><?php echo $sale_complete['sale_id']; ?></a></td>
                                                <td><?php echo $sale_complete['sale_time']; ?></td>
                                                <td><?php
                    $item_names = $this->Inventory->find_item_sale_customer($sale_complete['sale_id']);
                    if ($item_names != null) {
                        foreach ($item_names as $item_name) {
                            echo $this->Item->get_info($item_name['item_id'])->name . ", ";
                        }
                    }
                            ?></td>
                                                <td><?php echo $this->Employee->get_info($sale_complete['employee_id'])->first_name; ?></td>
                                                 <td><?php echo $sale_complete['payment_type']; ?></td>
                                                 
                                                
                                                                                        <td>
                            <?php $tongtien = number_format($this->Sale->get_sumary($sale_complete['sale_id'])->total, 0, '', ''); ?>
                            <?php echo $tongtien; ?></td>
                                                                                        <td>
                            <?php
                            if ($this->Sale->check_payment_type_is_tragop_tbl_sales($sale_complete['sale_id'])) {
                                ?>
                                <?php echo "0"; ?>
                                <?php
                            } else {
                                $pay_amout = $this->Sale->get_info_sales_inventory($sale_complete['sale_id'])->pay_amount;
                                $thanhtoan = $this->Sale->get_sumary($sale_complete['sale_id'])->total - $pay_amout;
                                ?>
                                <?php echo $thanhtoan; ?>
                                                                            </td>
                                <?php
                                $sum_money = $sum_money + $thanhtoan;
                                $sum_money_total = $sum_money_total + $tongtien;
                            }
                            ?>
                                                                                                        </tr>
        <?php
    }
} else {
    ?>
                                                                                            <tr>
                                                                                                    <td colspan="7">Không có giao dịch nào!</td>
                                                                                            </tr>
                    <?php } ?>

                                                                        </table>
                    <?php
                    if ($sum_money < 0) {
                        $a = 0;
                        $b = $sum_money;
                    } else {
                        $a = $sum_money;
                        $b = 0;
                    }
                    ?>
                        <div id="sum_money" style="float:right;font-weight:bold;font-size: 15px;margin: 10px auto">
                                <p>Số tiền khách hàng thanh toán: <?php echo number_format(($sum_money_total)) . "<sup>VNĐ</sup>"; ?></p>
                                <p>Số tiền khách còn nợ: <?php echo number_format($a) . "<sup>VNĐ</sup>"; ?></p>
                        </div>
                    </div>-->
                    <div style="display: none;" id="tab2" class="tab_content">
                        <!--table view cost customer-->
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'accountings'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
<?php echo 'Thống kê thu chi của khách hàng'; ?>
                                </td>
                            </tr>
                        </table>           

                        <table id="inventory_sale2" class="inventory_sale">
                            <tr class="title_color">
                                <td style="width: 10%;text-align: center">Mã thu chi </td>
                                <td style="width: 10%;text-align: left;text-indent: 3px">Ngày thu</td>
                                <td style="width: 30%;text-align:left">Ghi chú </td>
                                <td style="width: 15%;text-align: center">Khoản thu</td>
                                <td style="width: 15%;text-align: center">Khoản chi</td>		
                            </tr>
                                <?php
                                if ($cost_complete != null) {
                                    foreach ($cost_complete as $cost_completes) {
                                        ?>
                                    <tr>
                                        <td><a href="#" ><?php echo $cost_completes['id_cost']; ?></a></td>
                                        <td style="text-align: center"><?php echo date('d-m-Y H:i:s', strtotime($cost_completes['date'])); ?></td>
                                        <td><?php echo $cost_completes['comment']; ?></td>
                                        <?php if ($cost_completes['tien_thu'] <> 0) { ?>
                                            <td style="text-align: right;"><?php echo number_format($cost_completes['tien_thu']); ?></td>
                                        <?php } else { ?>
                                            <td style="text-align: right;">0</td>
                                        <?php } ?>
                                        <?php if ($cost_completes['tien_chi'] <> 0) { ?>
                                            <td style="text-align: right;"><?php echo number_format($cost_completes['tien_chi']); ?></td>
                                    <?php } else { ?>
                                            <td style="text-align: right;">0</td>
                                    <?php } ?>
        <!--                            <td><?php //echo $cost_completes['name'];   ?>
        <?php //echo $this->Cost->get_info_option($cost_completes['name'])->cost_name;  ?>
        <?php //echo $this->Employee->get_info($cost_completes['cost_employees'])->first_name;   ?> 
                        </td>-->
                                    </tr>
                                    <?php
                                }
                                if ($num_rows2 > $number_of_items_per_page) {
                                    ?>
                                    <tr class="loadbutton2 load_button" >
                                        <td colspan = '5'><div class="loadmore2 load_more" data-page="2">Xem thêm</div></td>
                                    </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr>
                                    <td colspan="5">Không có giao dịch nào!</td>
                                </tr>
                            </table>
<?php } ?>
                        </table> 
                    </div>

                    <div style="display: none;" id="tab6" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
<?php echo 'Thống kê lịch sử gửi mail của nhân viên cho khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <table id="inventory_sale6" class="inventory_sale">
                            <tr class="title_color">                                
                                <td style="width: 20%;text-align: center">Tiêu đề</td>
                                <td style="width: 20%;text-align: center">Thời gian</td>
                                <td style="width: 10%;text-align: center">Ghi chú</td>
                                <td style="width: 20%;text-align: center">Người gửi</td>
                                <td style="width: 10%;text-align: center">Trạng thái</td>
                                <td style="width: 10%;text-align: center"></td>
                            </tr>
                            <?php
                            if ($mail_history != null) {
                                foreach ($mail_history as $value) {
                                    echo "<tr>";
                                    echo "<td style='text-align: left;'>" . $value['title'] . "</td>";
                                    echo "<td style='text-align: center;'>" . date('d-m-Y H:i:s', strtotime($value['time'])) . "</td>";
                                    echo "<td>" . $value['note'] . "</td>";
                                    echo "<td>";
                                    $info_emp = $this->Employee->get_info_one_hit($value['employee_id']);
                                    echo $info_emp->first_name . " " . $info_emp->last_name;
                                    echo "</td>";
                                    echo "<td>";
                                    if ($value['status'] == 1) {
                                        echo "Gửi thành công";
                                    } else {
                                        echo "Gửi thất bại";
                                    }
                                    echo "</td>";
                                    echo "<td style='text-align: center;'>";
                                    echo "<a class='thickbox' href='" . site_url() . "/customers/view_mail_history/" . $value['id'] . "/width~700'>Xem</a><a class='delete_mail_history' id='" . $value['id'] . "' style='margin-left: 10px; cursor: pointer; color: #2400FF'>Xóa</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                if ($num_rows6 > $number_of_items_per_page) {
                                    ?>
                                    <tr class="loadbutton6 load_button" >
                                        <td colspan="7">
                                            <div class="loadmore6 load_more" data-page="2" >Xem thêm</div>
                                        </td>
                                    </tr>
        <?php
    }
} else {
    echo "<tr>";
    echo "<td colspan='7' style='text-align; center;'>Không có giao dịch nào</td>";
    echo "</tr>";
}
?>
                        </table>                        
                    </div>
                    <!-- tab lich su SMS -->
                    <div style="display: none;" id="tab7" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
                                    <?php echo 'Thống kê lịch sử gửi SMS cho khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <table id="inventory_sale7" class="inventory_sale">
                            <tr class="title_color">                                
                                <td style="width: 5%;text-align: center">Mã SMS</td>
                                <td style="width: 5%;text-align: center">Thời gian</td>
                                <td style="width: 10%;text-align: center">Số điện thoại</td>
                                <td style="width: 30%;text-align: center">Nội dung</td>
                                <td style="width: 10%;text-align: center">Trạng thái</td>
                            </tr>
                            <?php
                            if ($sms_history != null) {
                                foreach ($sms_history as $sh) {
                                    echo "<tr>";
                                        echo "<td style='text-align: center;'>" . $sh['id'] . "</td>";
                                        echo "<td style='text-align: center;'>" . date("d-m-Y H:i:s",strtotime($sh['date_send'])) . "</td>";
                                        echo "<td style='text-align: center;'>" . $sh['mobile'] . "</td>";
                                        echo "<td>".$sh['content_message']."</td>";
                                        echo "<td>";
                                            if($sh['equals'] > 0){
                                                echo "Gửi thành công";
                                            }elseif($sh['equals'] == -1){
                                                echo "Tên đăng nhập hoặc mật khẩu không hợp lệ";
                                            }elseif($sh['equals'] == -2){
                                                echo "NOT_ENOUGHCREDITS";
                                            }elseif($sh['equals'] == -3){
                                                echo "Mạng điện thoại không được hỗ trợ";
                                            }elseif($sh['equals'] == -4){
                                                echo "Địa chỉ IP của khách hàng không được cho phép";
                                            }elseif($sh['equals'] == -7){
                                                echo "Độ dài của tin nhắn không quá 459 kí tự";
                                            }elseif($sh['equals'] == -8){
                                                echo "Hai tin nhắn trong 1 ngày (dest_addr+message)";
                                            }elseif($sh['equals'] == -9){
                                                echo "Brandname chưa đăng ký";
                                            }elseif($sh['equals'] == -10){
                                                echo "Số điện thoại trong danh sách đen của chủ sở hữu hoặc Công ty viễn thông";
                                            }elseif($sh['equals'] == -13){
                                                echo "Số điện thoại sai định dạng";
                                            }elseif($sh['equals'] == -16){
                                                echo "Mẫu tin nhắn chưa được đăng ký";
                                            }elseif($sh['equals'] == -17){
                                                echo "Ký tự không được hỗ trợ trong nội dung tin nhắn";
                                            }elseif($sh['equals'] == -18){
                                                echo "Không đủ tin nhắn";
                                            }elseif($sh['equals'] == -19){
                                                echo "Không đủ tiền";
                                            }elseif($sh['equals'] == -99){
                                                echo "Ngoại lệ";
                                            }else{
                                                echo "No more";
                                            }
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                if ($num_row_history_sms > $number_of_items_per_page) {
                                    ?>
                                    <tr class="loadbutton7 load_button" >
                                        <td colspan="5">
                                            <div class="loadmore7 load_more" data-page="2" >Xem thêm</div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='5' style='text-align; center;'>Không có dữ liệu</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>                        
                    </div>
                    <!-- tab 4 Cong nơ -->
<?php echo form_open("customers/customers_check_payment", array("id" => "form_customers_check_payment")); ?>
                    <div style="display: block;" id="tab4" class="tab_content">
                        <div id="customer_money_return" style="float: right; font-size: 0.6em!important;">
                            <font color="red"><b>Nhập số tiền cần trả: </b></font>
                            <input type="text" id="money_cus" style="padding:5px 5px 0px 0px; text-align: right;" value='0' name="money_cus" class="thutienkhachno"/>
                        </div>
                        <div id="customer_money_return_show" style="float: right; font-size: 0.6em!important;">
                            <font color="red"><b>Nhập số tiền cần trả: </b></font>
                            <input type="text" id="money_cus1" style="padding:5px 5px 0px 0px; text-align: right;" value='0' name="money_cus1" class="thutienkhachno1" disabled='true'/>
                        </div><br>
                        <div id="" style="float: right;padding-left:500px;padding-top:10px;padding-bottom:20px;font-size: 0.6em!important; ">
                            <b>Chiết khấu: </b>
                            <input type="text" id="discount" style="padding:5px 5px 0px 0px; text-align: right;" value='' name="discount_money" class=""/>
                        </div>
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
<?php echo 'Thống kê công nợ của khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" value="<?php echo $customer_id; ?>" name="customers_id">			
                        <table id="inventory_sale4" class="inventory_sale">
                            <tr class="title_color">
                                <td style="width: 10%;text-align: center">Mã đơn hàng</td>
                                <td style="width: 10%;text-align: center">Ngày mua hàng</td>
                                <td style="width: 10%;text-align: center">Mặt hàng </td> 
                                <td style="width: 15%;text-align: center">Nhân viên</td>
                                <td style="width: 10%;text-align: center">Giá trị đơn hàng</td>
                                <td style="width: 10%;text-align: center">Hình thức thanh toán</td>
                                <td style="width: 10%;text-align: center">Chiết khấu</td>
                                <td style="width: 10%;text-align: center">Còn nợ</td>
                                <td style="width: 5%;text-align: center">Chọn</td>
                            </tr>  			                    
<?php $sum_money = 0; ?>			
                                    <?php
                                    if ($sale_complete_invs != null) {
                                        foreach ($sale_complete_invs as $sale_complete) {
                                            ?>
                                    <tr class="row_inventory_sale">
                                        <td class="row_sale_id" style="text-align: center;">
                                            <a href="<?php echo base_url(); ?>index.php/customers/switch_sale/<?php echo $sale_complete['sale_id']; ?>" ><?php echo $sale_complete['sale_id']; ?></a>
                                        </td>
                                        <td style="text-align: center;"><?php echo date('d-m-Y H:i:s', strtotime($sale_complete['sale_time'])); ?></td>
                                        <td  style="text-align: left;"><?php
                                            foreach ($detail_sale as $key => $val) {
                                                if ($key == $sale_complete['sale_id']) {
                                                    foreach ($val as $val1) {
                                                        foreach ($val1 as $val2) {
                                                            echo $val2['name'] . "<br /> ";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>&nbsp;
                                        </td>
                                        <td style="text-align: center;">
                                            <?php echo $this->Employee->get_info($sale_complete['employee_id'])->first_name . ' ' . $this->Employee->get_info($sale_complete['employee_id'])->last_name; ?>&nbsp;
                                        </td>
                                        <td style="text-align: right;"><?php
                                        foreach ($sale_data as $key2 => $val2) {
                                            if ($val2->sale_id == $sale_complete['sale_id']) {
                                                $total_cost = $val2->later_cost_price;
                                                echo number_format($total_cost);
                                                break;
                                            }
                                        }
                                        ?>&nbsp;
                                        </td>
                                                <?php
                                                $data_sale_tam = $this->Sale->get_sales_tam($sale_complete['sale_id']);
                                                $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_complete['sale_id']);
                                                $to = 0; //Tiền khách còn nợ của đơn hàng tương ứng
                                                $do = 0; //Tiền chiết khấu cho khách hàng của đơn hàng tương ứng
                                                ?> 
                                        <td style="text-align: left">
                                            <label>
        <?php foreach ($data_sale_payment as $key => $val) { ?>
                                                <?= $val['payment_type'] . ': ' . number_format($val['payment_amount']) ?>
                                                <?php
                                                $to = $to + $val['payment_amount'];
                                                $do = $do + $val['discount_money'];
                                                ?>
                                                    <br>
                                            <?php } ?>
                                            </label>
                                        </td>
                                        <td style="text-align: right;"><?= number_format($do); ?>&nbsp;</td>
                                        <td style="text-align: right;" class="consideration_paid">
                                            <?php echo number_format($total_cost - $to - $do); ?>
                                        </td>
                                            <?php
                                            $sum_money = $sum_money + $total_cost - $to - $do;
                                            ?>
                                        <td>
                                    <?php if ($total_cost - $to > 0) { ?>
                                        <?php if ($sale_complete['suspended'] == 1) { ?>
                                                    <input type="checkbox"  name="check_customer[]" value="<?php echo $sale_complete['sale_id']; ?>" class="chk" >
                                                    <input type="hidden"  name="check_payment_type" value="1" class="chk1" >
            <?php } else { ?>
                                                    <input type="checkbox"  name="check_customer[]" value="<?php echo $sale_complete['sale_id']; ?>" class="chk" >
                                                    <input type="hidden"  name="check_payment_type" value="2" class="chk1" >
                                        <?php } ?>
                                    <?php } ?>&nbsp;
                                        </td>
                                    </tr>
    <?php }
    if ($num_rows4 > $number_of_items_per_page) {
        ?>
                                    <tr class="loadbutton4 load_button" >
                                        <td colspan="9">
                                            <div class="loadmore4 load_more" data-page="2" >Xem thêm</div>
                                        </td>
                                    </tr>
                                <?php
                            }
                        } else {
                            ?>
                                <tr style="text-align: center">
                                    <td colspan="9"  style="text-align: center !important">Không có giao dịch nào!</td>
                                </tr>
<?php } ?>
                        </table>
                        <a class="delete_all"  ></a>
                        <?php
                        if ($sum_money < 0) {
                            $a = 0;
                            $b = $sum_money;
                        } else {
                            $a = $sum_money;
                            $b = 0;
                        }
                        ?>
                        <div id="sum_money" style="float:right;font-weight:bold;">
                            <p>Tổng giá trị đơn hàng nợ:<?php echo number_format($a) . "<sup>VNĐ</sup>"; ?></p>
                        </div>
                        <input type="hidden" name="sum_money" value="<?= $sum_money ?>"></input>
                        <?php
                        echo form_submit(array(
                            'title' => 'dtable',
                            'name' => 'submit',
                            'id' => 'submit',
                            'value' => 'Thanh toán',
                            'class' => 'complete')
                        );
                        ?>
                    <?php echo form_close(); ?>
                    <?php
                    echo form_submit(array(
                        'value' => 'In phiếu',
                        'class' => 'print_report_1',
                        'onclick' => "this.style.display='none'")
                    );
                    ?>
                        <input type="hidden" id="url_add" value="<?= site_url() ?>/customers/add_sale_payment"></input>
                        <input type="hidden" id="url_del" value="<?= site_url() ?>/customers/del_sale_payment"></input>
                    </div>
                    <!-- tab 5 báo giá -->

<?php //echo form_open("customers/customers_check_payment");  ?>
                    <div style="display: block;" id="tab5" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF; width: 920px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title" style="color: #fff; font-size: 0.6em!important;">
<?php echo 'Thống kê báo giá của khách hàng'; ?>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" value="<?php echo $customer_id; ?>" name="customers_id">			
                        <table id="inventory_sale5" class="inventory_sale">
                            <tr class="title_color">
                                <td style="width: 7%;text-align: center">Mã BG</td>
                                <td style="width: 10%;text-align: center">Ngày mua hàng</td>
                                <td style="width: 15%;text-align: center">Nhân viên</td>
                                <td style="width: 20%;text-align: center">Mặt hàng </td> 
                                <td style="width: 10%;text-align: center">Giá trị đơn hàng</td>
                                <td style="width: 12%;text-align: center">Trạng thái</td>
                                <td style="width: 12%;text-align: center">Báo giá</td>
                                <td style="width: 8%;text-align: center">Xóa</td>
                            </tr>
                            </thead>
                            <tbody>
                                        <?php $sum_money = 0; ?>
                                        <?php
                                        if ($sale_materials != null) {
                                            foreach ($sale_materials as $sale_complete) {
                                                ?>
                                        <tr class="row_inventory_sale" style="text-align: center;">
                                            <td class="row_sale_id" style="text-align: center;"><a href="<?php echo base_url(); ?>index.php/customers/switch_sale/<?php echo $sale_complete['sale_id']; ?>" ><?php echo $sale_complete['sale_id']; ?></a></td>
                                            <td style="text-align: center;"><?php echo date('d-m-Y H:i:s', strtotime($sale_complete['sale_time'])); ?></td>
                                            <td style="text-align: center;"><?php echo $this->Employee->get_info($sale_complete['employee_id'])->first_name . ' ' . $this->Employee->get_info($sale_complete['employee_id'])->last_name; ?>&nbsp;</td>
                                            <td  style="text-align: left;">
                                                <?php
                                                foreach ($detail_sale_materials as $key => $val) {
                                                    if ($key == $sale_complete['sale_id']) {
                                                        foreach ($val as $val1) {
                                                            foreach ($val1 as $val2) {
                                                                echo $val2['name'] . " , <br /> ";
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>&nbsp;
                                            </td>
                                            <td style="text-align: right;">
                                            <?php
                                            foreach ($sale_data as $key2 => $val2) {
                                                if ($val2->sale_id == $sale_complete['sale_id']) {
                                                    $total_cost = $val2->later_cost_price;
                                                    echo number_format($total_cost);
                                                    break;
                                                }
                                            }
                                            ?>&nbsp;
                                            </td>
                                                <?php
                                                $data_sale_tam = $this->Sale->get_sales_tam($sale_complete['sale_id']);
                                                $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_complete['sale_id']);
                                                $to = 0;
                                                $do = 0;
                                                ?>
                                            <?php if ($sale_complete['suspended'] == 1) { ?>
                                                <td style="text-align: center; color: red;">
                                                    <?php echo 'KH đã ghi nợ'; ?>&nbsp;
                                                </td>
                                                <?php } elseif ($sale_complete['liability'] == 1) { ?>
                                                <td style="text-align: center; color:green;">
                                                    <?php echo 'KH đã đặt hàng'; ?>&nbsp;
                                                </td>
                                                <?php } else { ?>
                                                <td style="text-align: center;">
                                                    <?php echo ''; ?>&nbsp;
                                                </td>
                                                <?php } ?>
                                            <td style="text-align: center; font-size: 10px;">                                            
                                                <?php
                                                $list_sales_materials = $this->Sale->get_sale_material($sale_complete['sale_id']);
                                                foreach ($list_sales_materials as $key => $item) {
                                                    echo "<a href='" . site_url() . "/sales/download_matarial?file=" . $item['name'] . "'>Lần " . ($key + 1) . "</a>&nbsp&nbsp";
                                                }
                                                ?>
        <?php
//                                                    $a = $this->Sale->get_sale_material($sale_complete['sale_id']);
        ?>
                                            </td>
                                            <td>
                                        <?php
                                        echo form_open('sales/delete_detail_materials', array('id' => 'form_delete_suspended_sale'));
                                        echo form_hidden('suspended_sale_id', $sale_complete['sale_id']);
                                        echo form_hidden('suspended_customer_id', $sale_complete['customer_id']);
                                        ?>
                                                <input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
                                                </form>
                                            </td>
                                        </tr>
                            <?php } ?>
                                    <tr class="loadbutton5 load_button" >
                                        <td colspan="8"><div class="loadmore5 load_more" data-page="2" >Xem thêm</div></td>
                                    </tr>
                            <?php } else {
                            ?>
                                    <tr style="text-align: center">
                                        <td colspan="8"  style="text-align: center !important">Không có giao dịch nào!</td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>
<?php //echo form_close();  ?>

<?php
echo form_submit(array(
    'value' => 'In phiếu',
    'class' => 'print_report_1',
    'onclick' => "this.style.display='none'")
);
?>
                    </div>
                    <!--End báo giá khách hàng    -->
                </div> 

            </div></div></div>
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
            $("#submit").click(function () {
                var money_cus = $("#money_cus").val();
                if (money_cus == "" || money_cus == 0) {
                    alert("Bạn cần nhập số tiền cần trả");
                    return false;
                }
            });
        });
        function number_format(number, decimals, dec_point, thousands_sep) {
            var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
            var d = dec_point == undefined ? "." : dec_point;
            var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
            var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        }
        function stripNonNumeric(str) {
            str += '';
            var rgx = /^\d|\.|-$/;
            var out = '';
            for (var i = 0; i < str.length; i++) {
                if (rgx.test(str.charAt(i))) {
                    if (!((str.charAt(i) == '.' && out.indexOf('.') != -1) || (str.charAt(i) == '-' && out.length != 0))) {
                        out += str.charAt(i);
                    }
                }
            }
            return out;
        }
        $('#money_cus').maskMoney();
        $('#discount').maskMoney();
        $('#customer_money_return').show();
        $('#customer_money_return_show').hide();
        $(".thutienkhachno").focusout(function ()
        {
            //var c = confirm('Hãy chắc chắn là số tiền bạn xác nhập là đúng');
            if (c) {
                $('#customer_money_return').hide();
                $('#customer_money_return_show').show();
                $('.thutienkhachno1').val($(".thutienkhachno").val());
            } else {
                $('.thutienkhachno').val('');
                return false;
            }
        });
        var sum_value = 0;

        $(".chk").click(function ()
        {
            var data = $(this).parents('tr:eq(0)').find('td:eq(6)').text();
            var target = $(this).parents('.row_inventory_sale');
            var sale_id = target.find('.row_sale_id').text();
            var consideration_paid = target.find('.consideration_paid').text();
            var url_add = $(this).parents('#tab4').find('#url_add').val();
            var url_del = $(this).parents('#tab4').find('#url_del').val();
            var data = $(this).parents('tr:eq(0)').find('td:eq(6)').text();
            data = stripNonNumeric(data);
            if ($(this).is(':checked'))
            {
                $.post(
                        url_add,
                        {sale_id: sale_id, consideration_paid: stripNonNumeric(consideration_paid)},
                function (data, status) {
                }
                );
                $(this).parents('tr').addClass('tr_class');
                sum_value += parseInt(data);
            } else {
                $.post(
                        url_del,
                        {sale_id: sale_id, consideration_paid: consideration_paid},
                function (data, status) {
                }
                );
                $(this).parents('tr').removeClass('tr_class');
                sum_value -= parseInt(data);
            }
        });
        $('.print_report2').click(function ()
        {
            $('.chk').each(function () {
                if ($(this).is(':checked')) {
                    $(this).parents('tr').fadeOut(function () {
                        $(this).remove(); //remove row when animation is finished
                    });
                }
            });
            return false;
        });
        //created by San
        $(".delete_mail_history").click(function () {
            var id = $(this).attr("id");
            var parent = $(this).parent().parent();
            var data = "id=" + id;
            if (confirm("Bạn có chắc chắn muốn xóa?")) {
                $.ajax({
                    type: "post",
                    url: "<?php echo site_url() . '/customers/remove_mail_history'; ?>",
                    data: data,
                    success: function (data) {
                        $(parent).remove();
                    }
                });
            }
            return false;
        });
    </script>
<?php $this->load->view("partial/footer"); ?>
