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
        font-size: 1.2em;
        padding: 0 20px;
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
    #title_tab
    {
        font-size: 0.6em;
    }
    .title_font
    {
        font-weight: bold;
    }
    /* tab cong no  */
    .loadmore {
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
    .loadbutton{
        text-align: center;

    }
    /* tab nhap hang  */
    .loadmore2 {
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
    .loadbutton2{
        text-align: center;
    }
    /* tab thu chi  */
    .loadmore3 {
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
    .loadbutton3{
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

    //tab cong no
    $(document).on('click', '.loadmore', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('suppliers/load_more/' . $supplier_info->person_id); ?>",
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
    //tab nhap hang
    $(document).on('click', '.loadmore2', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('suppliers/load_more2/' . $supplier_info->person_id); ?>",
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
  //tab thu chi
    $(document).on('click', '.loadmore3', function () {
        $(this).text('Đang tải...');
        var ele = $(this).parent('td');
        $.ajax({
            url: "<?php echo site_url('suppliers/load_more3/' . $supplier_info->person_id); ?>",
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

</script>


<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">
        <div style="color:#000;">
            <fieldset id="customer_basic_info" style="margin-bottom: 10px;padding-top: 10px; width: 98% !important">
                <legend style="color: #000000;font-size: 15px;font-weight: bold "><?php echo "Thông tin nhà cung cấp" ?></legend>
                <div id="history_customer" style="width: 700px!important;">
                    <p><label>Công ty :</label><b style="font-size: 16px;"> <?php echo $supplier_info->company_name; ?></b> </p>
                    <p><label>Email :</label> <?php echo $supplier_info->email; ?></p>
                    <p><label>Địa chỉ :</label> <?php echo $supplier_info->address_1; ?></p>                
                </div>
            </fieldset>
            <div class="container" style="margin-left: -1px;">
                <ul class="tabs">    
                    <li class="active"><a href="#tab1">Lịch sử nhập hàng</a></li>
                	<li class=""><a href="#tab3">Lịch sử thu chi</a></li>                                
                    <li class=""><a href="#tab2">Công nợ</a></li>
                </ul>
                <div class="tab_container">
                
                	<div style="display: none;" id="tab1" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF;width:920px!important;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' />
                                </td>
                                <td id="title_tab" style="color: #000">
                                    <?php echo 'Thống kê lịch sử nhập hàng NCC ' . $supplier_info->company_name; ?>
                                </td>
                            </tr>
                        </table>
                        <table id="inventory_sale2">
                            <tr class="title_font">
                                <td style="width: 5%;text-align: center">Mã ĐH</td>
                                <td style="width: 5%;text-align: center">Ngày mua</td>
                                <td style="width: 20%;text-align:center">Mặt hàng </td>
                                <td style="width: 20%;text-align: center">Nhân viên</td>
                                <td style="width: 10%;text-align:center">Tổng giá trị ĐH </td> 
                                <td style="width: 10%;text-align:center">Chiết khấu </td> 
                                <td style="width: 20%;text-align: center">Hình thức thanh toán</td>
                                <td style="width: 10%;text-align:center">Còn nợ</td>

                            </tr>
                            <?php
                            $totak = 0;
                            $total_taxes = 0;
                            if ($receiving_all != null) {                               
                                foreach ($receiving_all as $val) {
                                    $total_receiving = $this->Receiving->get_total_receiving($val['receiving_id']);
                                foreach ($info_receiving_item as $kt1){
                                       if($kt1['receiving_id'] == $val['receiving_id']){
                                                $total_taxes = ($total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost)*$kt1['taxes']/100; 
                                                
                                       }
                                 }    
                                    
                                    
                                    $discount = 0;
                                    ?>
                                    <tr class="row_inventory_sale">
                                        <td class="row_sale_id" style="text-align: center;"><?= $val['receiving_id']; ?></td>
                                        <td style="text-align: center;"><?= date("d-m-Y H:i:s",strtotime($val['receiving_time'])); ?></td>
                                        <td  style="text-align: left;"><?php
                                            foreach ($payment_order_all as $key1 => $val1) {
                                                
                                                foreach ($val1 as $val2) {
                                                    if ($val2['receiving_id'] == $val['receiving_id']) {
                                                        echo $val2['name'] . "<br /> ";
                                                        $discount += $val2['discount_percent']*$val2['item_unit_price']*$val2['quantity_purchased']/100;
                                                    }
                                                }
                                            }
                                            ?>&nbsp;
                                        </td>
                                        <td style="padding-left: 10px;">
                                            <?php echo $this->Employee->get_info($val['employee_id'])->last_name.' '.$this->Employee->get_info($val['employee_id'])->first_name; ?>&nbsp;
                                        </td>
                                        <td style="text-align: right;">
                                            <?php
                                            //$total_receiving = $this->Receiving->get_total_receiving($val['receiving_id']);
                                            echo number_format($total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost);
                                            ?>&nbsp;
                                        </td>
                                        
                                        <td style="text-align: right;"><?= number_format($discount); ?>&nbsp;</td>
                                        <td style="text-align: left;">
                                            <label>
                                                <?php
                                                 $payment1 = 0;
                                                foreach ($receiving_tam_all as $val3) {
                                                    
                                                    foreach ($val3 as $val4) {
                                                        if ($val4['id_receiving'] == $val['receiving_id']) {  
                                                             $text = $val4['pays_type'].': '.number_format($val4['pays_amount']).'<br/>'; 
                                                            $payment1 = $payment1 + $val4['pays_amount'];
                                                        }
                                                    }
                                                    
                                                }
                                                 if($payment1 >= $total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost)        {
                                                     echo 'Trả góp: '.number_format($total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost);
                                                 }else{
                                                $payment = 0;
                                                ?>
                                                <?php foreach ($receiving_tam_all as $val3) { ?>
                                                    <?php
                                                    foreach ($val3 as $val4) {
                                                        if ($val4['id_receiving'] == $val['receiving_id']) {  
                                                            echo $val4['pays_type'].': '.number_format($val4['pays_amount']).'<br/>'; 
                                                            $payment = $payment + $val4['pays_amount'];
                                                        }
                                                    }
                                                    ?>
                                                <?php } ?>
                                                 <?php }?>
                                            </label>
                                            &nbsp;
                                        </td>                                        
                                        <td style="text-align: right;" class="consideration_paid">
                                            <?php if(($total_receiving['total_price']+ $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost)-$payment1 > 0){
                                                echo number_format($total_receiving['total_price']+ $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost-$payment1);
                                            }else{
                                                echo 0;
                                            
                                            } ?>&nbsp;
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ($num_rows1 > $number_of_items_per_page) {
                                ?>
                                    <tr class="loadbutton2" >
                                        <td colspan = "9"  >
                                            <div class="loadmore2" data-page="2" >Xem thêm</div>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                            ?>
                            <tr style="text-align: center">
                                <td colspan="9"  style="text-align: center !important">Không có giao dịch nào!</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                	
                	<!-- tab thu chi -->
                	<div  id="tab3" class="tab_content">
                        <table id="title_bar_new" style="color: #FFF;width:920px!important;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' />
                                </td>
                                <td id="title_tab" style="color: #000">
                                    <?php echo 'Thống kê lịch sử thu chi ' ?>
                                </td>
                            </tr>
                        </table>
                        <table id="inventory_sale3">
                            <tr class="title_font">
                                <td style="width: 10%;text-align: center">Mã thu chi </td>
                                <td style="width: 10%;text-align: left;text-indent: 3px">Ngày thu</td>
                                <td style="width: 30%;text-align:left">Ghi chú </td>
                                <td style="width: 15%;text-align: center">Khoản thu</td>
                                <td style="width: 15%;text-align: center">Khoản chi</td>		
                            </tr>
                            
                             <?php
                            $totak = 0;
                            $total_taxes = 0;
                            if ($receiving_all != null) {                               
                                foreach ($receiving_all as $val) {
                                  foreach ($cost_complete as $cost_completes) {
                                      if($cost_completes['id_receiving'] == $val['receiving_id'])
                                        $total_receiving = $this->Receiving->get_total_receiving($val['receiving_id']);
                                        foreach ($info_receiving_item as $kt1){
                                               if($kt1['receiving_id'] == $val['receiving_id']){
                                                        $total_taxes = ($total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost)*$kt1['taxes']/100; 
                                                   
                                               }
                                         }
                                         $tong = $total_receiving['total_price'] + $total_taxes + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost;
                                }
                            }
                            
                         }  
                         
                      
                         
                                 ?>
                            
                            <?php
                            if ($cost_complete != null) {
                                foreach ($cost_complete as $cost_completes) {
                                        ?>
                                    <tr class="row_inventory_sale">
                                        <td><a ><?php echo $cost_completes['id_cost']; ?></a></td>
                                        <td style="text-align: center"><?php echo date('d-m-Y H:i:s', strtotime($cost_completes['date'])); ?></td>
                                        <td><?php echo $cost_completes['comment']; ?></td>
                                        <td style="text-align: right;">
                                            <?= number_format($cost_completes['form_cost'] == 0 ? $cost_completes['money'] : 0); ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?php
                                              $this->load->model('Receiving');
                                              $t = $this->Receiving->get_info($cost_completes['id_receiving'])->row()->later_cost_price;
                                             $data_sale_payment1 = $this->Sale->get_payment_receiving_by_receiving_id($cost_completes['id_receiving']);
                                                $to = 0; 
                                                $do = 0; 
                                                foreach ($data_sale_payment1 as $val1) {
                                                    $to = $to + $val1['payment_amount'];
                                                    $do = $do + $val1['discount_money'];
                                                }

                                               
                                                
                                            if($cost_completes['form_cost'] == 1){
//                                                if($cost_completes['money'] >= ($t-$to-$do)){
//                                                    echo number_format(($t-$to-$do));
//                                                }else{
                                                    echo number_format($cost_completes['money']);
                                                //}
                                            }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <?php
                                }
                            	if ($num_rows3 > $number_of_items_per_page) {
                                    ?>
                                    <tr class="loadbutton3" >
                                        <td colspan = '5'><div class="loadmore3" data-page="2">Xem thêm</div></td>
                                    </tr>
                                <?php
                            	}
                            } else {
                            ?>
                            <tr style="text-align: center">
                                <td colspan="5"  style="text-align: center !important">Không có giao dịch nào!</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                
                    <!-- tab 2 Cong nơ -->
                    <?php echo form_open("suppliers/receiving_check_payment"); ?>
                    <div style="display: block;" id="tab2" class="tab_content">
                        <div id="customer_money_return" style="float: right; font-size: 17px; margin-top:10px">
                            <font color="red"><b>Nhập số tiền cần trả:</b></font>
                            <input type="text" id="money_cus" style="padding:5px 5px 0px 0px; text-align: right;" value='0' name="money_cus" class="thutienkhachno"/>
                        </div>                        
                        <br>
                        <div id="" style="float: right;padding-left:500px;padding-top:10px;padding-bottom:10px;font-size: 17px;">
                            <b>Chiết khấu:</b>
                            <input type="text" id="" style="padding:5px 5px 0px 0px; text-align: right;" value='' name="discount_money" class="discount_money"/>
                        </div>
                        <table id="title_bar_new" style="color: #FFF;width: 920px; margin-bottom: -18px;">
                            <tr>
                                <td id="title_icon">
                                    <img src='<?php echo base_url() ?>images/menubar/<?php echo 'sales'; ?>.png' alt='title icon' style="border:none" />
                                </td>
                                <td id="title_tab">
<?php echo 'Thống kê công nợ nhà sản xuất'; ?>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" value="<?php echo $supplier_info->person_id; ?>" name="supplier_id">
                        <table id="inventory_sale">
                            <tr class="title_font">
                                <td style="width: 5%;text-align: center">Mã ĐH</td>
                                <td style="width: 10%;text-align: center">Ngày mua hàng</td>
                                <td style="width: 15%;text-align: center">Mặt hàng </td> 
                                <td style="width: 20%;text-align: center">Nhân viên</td>
                                <td style="width: 10%;text-align: center">Giá trị đơn hàng</td>
                                <td style="width: 15%;text-align: center">Hình thức thanh toán</td>
                                <td style="width: 10%;text-align: center">Chiết khấu</td>
                                <td style="width: 10%;text-align: center">Còn nợ</td>
                                <td style="width: 5%;text-align: center">Chọn</td>
                            </tr>
                            <tbody>
                            <?php
                            $total_taxes = 0;
                            $totak = 0;
                            if ($order_owe != null) {
                                $sum_money = 0;
                                foreach ($order_owe as $val) {
                                 $total_receiving = $this->Receiving->get_total_receiving($val['receiving_id']);
                               // foreach ($info_receiving_item as $kt){
//                                       if($kt['receiving_id'] == $val['receiving_id']){
//                                                $net_price1 = $kt['item_unit_price'] * $kt['quantity_purchased'] - $kt['item_unit_price'] * $kt['quantity_purchased'] * $kt['discount_percent']/100;
//                                                $totak += $net_price1;
//                                       }
//                                 }
                                foreach ($info_receiving_item as $kt1){
                                       if($kt1['receiving_id'] == $val['receiving_id']){
//                                                $net_price = $kt1['item_unit_price'] * $kt1['quantity_purchased'] - $kt1['item_unit_price'] * $kt1['quantity_purchased'] * $kt1['discount_percent']/100;
//                                                $cp = ($net_price / $totak) * $this->Receiving->get_info($val['receiving_id'])->row()->other_cost;
//                                                $tax = ($net_price + $cp) * $kt1['taxes'] / 100;

                                                $total_taxes = ($total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost)*$kt1['taxes']/100; 
                                                
                                       }
                                 }    
                                ?>
                                <tr class="row_inventory_sale">
                                    <td class="row_sale_id" style="text-align: center;"><?= $val['receiving_id']; ?></td>
                                    <td style="text-align: center;"><?= date("d-m-Y H:i:s", strtotime($val['receiving_time'])); ?></td>
                                    <td  style="text-align: left;"><?php
                                        foreach ($payment_order as $key1 => $val1) {
                                            foreach ($val1 as $val2) {
                                                if ($val2['receiving_id'] == $val['receiving_id']) {
                                                    echo $val2['name'] . "<br /> ";
                                                        
                                                    
                                                }
                                            }
                                        }
                                        ?>&nbsp;
                                    </td>
                                    <td style="text-align: left">
                                        <?php echo $this->Employee->get_info($val['employee_id'])->first_name.' '.$this->Employee->get_info($val['employee_id'])->last_name; ?>&nbsp;
                                    </td>
                                    <td style="text-align: right;">
                                        <?php
                                        $total_receiving = $this->Receiving->get_total_receiving($val['receiving_id']);
                                        echo number_format($total_receiving['total_price'] + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost);
                                        ?>&nbsp;
                                    </td>
                                    <td style="text-align: left">
                                        <label>
                                            <?php
                                            $discount = 0;
                                            $payment = 0;
                                            foreach ($receiving_tam as $val3) {
                                                foreach ($val3 as $val4) {
                                                    if ($val4['id_receiving'] == $val['receiving_id']) {
                                                        echo $val4['pays_type'] . ': ' . number_format($val4['pays_amount']).'<br>';
                                                        $discount = $discount + $val4['discount_money'];
                                                        $payment = $payment + $val4['pays_amount'];
                                                    }
                                                }
                                            } ?>
                                        </label>
                                        &nbsp;
                                    </td>
                                    <?php $sum_money = $sum_money + $total_receiving['total_price'] - $payment - $discount + $total_taxes + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost?>
                                    <td style="text-align: right;"><?= number_format($discount); ?></td>
                                    <td style="text-align: right;" class="consideration_paid">
                                        <?php
                                           if($total_receiving['total_price'] < 0){
                                               echo number_format(abs(($payment+$total_receiving['total_price']) - $discount + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost));
                                           }else{
                                        ?>
                                           <?php echo number_format(abs($total_receiving['total_price'] - $payment - $discount  + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost)); }?>&nbsp;
                                           
                                           <?php
                                             $hieu =  $total_receiving['total_price'] - $payment - $discount  + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost;
                                             if($hieu <= 0){
                                                 $data_recv = array('suspended'=>0);
                                                 $this->Receiving->update_recv_congno($data_recv,$val['receiving_id']);
                                             }
                                           ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if($total_receiving['total_price']+ $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost - $payment - $discount > 0) { ?>
                                        <input type="checkbox"  name="check_customer[]" value="<?php echo $val['receiving_id']; ?>" class="chk" >                                    </td>	
                                    <?php } ?>&nbsp;
                                    </td>
                                </tr>
                                <?php
                                }
                                if ($num_rows > $number_of_items_per_page) {
                                ?>
                                    <tr class="loadbutton" >
                                        <td colspan = "9"  ><div class="loadmore" data-page="2" >Xem thêm</div></td>
                                    </tr>
                                <?php }
                            } else {
                            ?>
                                <tr style="text-align: center">
                                    <td colspan="9"  style="text-align: center !important">Không có giao dịch nào!</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>                        
                        <div id="sum_money" style="float:right;font-weight:bold;">
                            <p>Tổng giá trị đơn hàng nợ: <?php echo number_format($sum_money) . "<sup>VNĐ</sup>"; ?></p>
                        </div>
                        <input type="hidden" name="sum_money" value="<?= $sum_money ?>"></input>
                    <a class="delete_all"  ></a>
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
                        <input type="hidden" id="url_add" value="<?= site_url() ?>/suppliers/add_receiving_payment"></input>
                        <input type="hidden" id="url_del" value="<?= site_url() ?>/suppliers/del_receiving_payment"></input>
                    </div>
                    
                    
                </div> 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
                if (!((str.charAt(i) == '.' && out.indexOf('.') != -1) ||
                        (str.charAt(i) == '-' && out.length != 0))) {
                    out += str.charAt(i);
                }
            }
        }
        return out;
    }

    $('.thutienkhachno').maskMoney();
    $('.discount_money').maskMoney();
    $('#customer_money_return').show();
    $('#customer_money_return_show').hide();

    var sum_value = 0;

    $(".chk").click(function (){
        //$("input:checkbox").attr('checked', true);
        var data = $(this).parents('tr:eq(0)').find('td:eq(6)').text();
        var target = $(this).parents('.row_inventory_sale');
        var receiving_id = target.find('.row_sale_id').text();
        var consideration_paid = target.find('.consideration_paid').text();
        var url_add = $(this).parents('#tab2').find('#url_add').val();
        var url_del = $(this).parents('#tab2').find('#url_del').val();
        var data = $(this).parents('tr:eq(0)').find('td:eq(6)').text();
        data = stripNonNumeric(data);
        if ($(this).is(':checked')){
            $.post(url_add,{receiving_id: receiving_id,consideration_paid: stripNonNumeric(consideration_paid)},function (data, status){});
            $(this).parents('tr').addClass('tr_class');
            sum_value += parseInt(data);
        }else{
            $.post(url_del,{receiving_id: receiving_id,consideration_paid: consideration_paid},function (data, status) {});
            $(this).parents('tr').removeClass('tr_class');
            sum_value -= parseInt(data);
        }
        if (sum_value > 0){
            $('#khach_no').html('<b>Số tiền khách nợ:' + number_format(sum_value, 0) + '<sup>VNĐ</sup></b>');
            $('#tra_khach').html('<b>Số tiền phải trả khách:0 <sup>VNĐ</sup></b>');
            if ($('#money_cus').val() < sum_value) {
                //alert('Số tiền thanh toán lớn hơn số tiền cần trả là: ' + (sum_value - Number($('#money_cus').val())) + ' VNĐ Bạn vẫn muốn tiếp tục?');
            }
        }else{
            $('#khach_no').html('<b>Số tiền khách nợ:0 <sup>VNĐ</sup></b>');
            $('#tra_khach').html('<b>Số tiền phải trả khách:' + sum_value * (-1) + '<sup>VNĐ</sup></b>');
        }
    });
    $('.print_report2').click(function (){
        $('.chk').each(function () {
            if ($(this).is(':checked')) {
                $(this).parents('tr').fadeOut(function () {
                    $(this).remove(); //remove row when animation is finished
                });
            }
        });
        return false;
    });
    $("#submit").click(function(){
        var money_cus = $("#money_cus").val();
        if(money_cus <=0){
            alert("Bạn chưa nhập số tiền cần trả");
            return false;
        }
    });
</script>
<?php $this->load->view("partial/footer"); ?>