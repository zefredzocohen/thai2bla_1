
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN " "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <base href="<?php echo base_url(); ?>" />
        <title><?php echo $this->config->item('company') ?></title>
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>css/metro.css?<?php echo APPLICATION_VERSION; ?>" />
        <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>css/style-menu.css?<?php echo APPLICATION_VERSION; ?>" />
        <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>css/menu-style.css?<?php echo APPLICATION_VERSION; ?>" />
        <script src="<?php echo base_url() ?>js/modernizr.custom.js?<?php echo APPLICATION_VERSION; ?>"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.10.1.min.js" ></script>
        <script src="<?php echo base_url() ?>js/gen.js"></script> 

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>metro/colorbox/colorbox.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>metro/colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>metro/colorbox/colorbox.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>metro/colorbox/css.css" /> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/component.css?<?php echo APPLICATION_VERSION; ?>">
            <?php
            foreach (get_css_files() as $css_file) {
                ?>
                <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url() . $css_file['path'] . '?' . APPLICATION_VERSION; ?>" media="<?php echo $css_file['media']; ?>" />
                <?php
            }
            ?>	

            <script type="text/javascript">
                var SITE_URL = "<?php echo site_url(); ?>";
            </script>
            <?php
            foreach (get_js_files() as $js_file) {
                ?>
                <script src="<?php echo base_url() . $js_file['path'] . '?' . APPLICATION_VERSION; ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                <?php
            }
            ?>	
            <script type="text/javascript">
                Date.format = '<?php echo get_js_date_format(); ?>';
                $.ajaxSetup({
                    cache: false,
                    headers: {"cache-control": "no-cache"}
                });
            </script>
            <script typy="text/javascript">
                $(document).ready(function () {
                    $("#flip").click(function () {
                        $("#panel").slideToggle("slow");
                    });
                });

                function post_person_form_submit(response) {
                    set_feedback(response.message, 'success_message', false);
                }
            </script>
            <script typy="text/javascript">
                $(document).ready(function () {
                    //Tao dong ho
                    // Tao 2 mang chua ten ngay thang
                    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

                    // Tao moi doi tuong Date()
                    var newDate = new Date();
                    // Lay gia tri thoi gian hien tai
                    newDate.setDate(newDate.getDate());
                    setInterval(function () {
                        // lay gia tri giay trong doi tuong Date()
                        var seconds = new Date().getSeconds();
                        // Chen so 0 vao dang truoc gia tri giay
                        $("#sec").html((seconds < 10 ? "0" : "") + seconds);
                    }, 1000);

                    setInterval(function () {
                        // Tuong tu lay gia tri phut
                        var minutes = new Date().getMinutes();
                        // Chen so 0 vao dang truoc gia tri phut neu gia tri hien tai nho hon 10
                        $("#min").html((minutes < 10 ? "0" : "") + minutes);
                    }, 1000);

                    setInterval(function () {
                        // Lay gia tri gio hien tai
                        var hours = new Date().getHours();
                        // Chen so 0 vao truoc gia tri gio neu gia tri nho hon 10
                        $("#hours").html((hours < 10 ? "0" : "") + hours);
                    }, 1000);
                });
            </script>

            <style type="text/css"> 
                #panel,#flip {
                    padding:1px;
                    text-align:center;
                    border:solid 1px #c3c3c3;
                }
                
                #panel {
                    padding:50px;
                    display:none;
                }

            </style>
    </head>
    <body>
        <div id="flip" style="width:29px; padding-top:10px; margin: 0px auto; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;"></div>
        <div class="topheader">
            <div class="inner">
                <div class="topleftmenu">
                    <table id="footer_info">
                        <tr>
                            <td id="menubar_date_time" class="menu_date">
                                <strong id="hours"></strong> : <strong id="min"></strong> : <strong id="sec"></strong>
                            </td>
                            <td id="menubar_date_day" class="menu_date mini_date">
                                <?php echo date('D') ?> 
                                <br />
                                <?php
                                if ($this->config->item('time_format') != '24_hour') {
                                    echo date('a');
                                }
                                ?>
                            </td>
                            <td id="menubar_date_spacer" class="menu_date">|</td>
                            <td id="menubar_date_date" class="menu_date"><?php echo date('d') ?></td>
                            <td id="menubar_date_monthyr" class="menu_date mini_date">
                                <?php echo date('F') ?>
                                <br />
                                <?php echo date('Y') ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="toprightmenu">
                    <!--add warning-->
                    <a title="Lịch cá nhân" href="<?php echo base_url(); ?>calendar" rel="nofollow" id="hunght_calendar" class="hunght_calendar" style="width: 44px; padding-left: 0px; padding-right: 0px;"></a>
                    <a title="Công nợ" href="#" onclick="return false;"  rel="nofollow" id="hunght_warning_debt" class="hunght_warning_debt" style="width: 44px; padding-left: 0px; padding-right: 0px;">
<?php if ($suspends_date != null) { ?>
                            <span>
                                <div id="hunght_warning_debt" class="notifynumber"><?php echo count($suspends_date); ?></div>
                            </span>
<?php } ?>
                    </a>
                    <a title="Khách hàng mới" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_customer" class="hunght_warning_customer" style="width: 44px; padding-left: 0px; padding-right: 0px;">
<?php if ($register_date != null) { ?>
                            <span>
                                <div  id="hunght_warning_customer" class="notifynumber"><?php echo count($register_date); ?></div>
                            </span>
<?php } ?>
                    </a> 
                    <a title="Đơn hàng mới" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_orders" class="hunght_warning_orders" style="width: 44px; padding-left: 0px; padding-right: 0px;">
<?php if ($suspended_sales != null) { ?>
                            <span>
                                <div id="hunght_warning_orders" class="notifynumber"><?php echo count($suspended_sales); ?></div>
                            </span>
<?php } ?>
                    </a> 
                    <a title="Hợp đồng mới" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning" class="hunght_warning" style="width: 44px; padding-left: 0px; padding-right: 0px;">
                        <span>
                            <div style="display:none"  id="vtlai_notifynumber" class="notifynumber">0</div>
                        </span>
                    </a>
                    <a title="Giỏ hàng từ web" onclick="return false;"   href="#" rel="nofollow" id="hunght_web" class="hunght_web" style="width: 44px; padding-left: 0px; padding-right: 0px;">
<?php if ($payment_date != null) { ?>
                            <span>
                                <div  id="hunght_web" class="notifynumber"><?php echo count($payment_date); ?></div>
                            </span>
<?php } ?>
                    </a>
                    <a title="Công việc cần phê duyệt" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_contract" class="hunght_warning_contract" style="width: 44px; padding-left: 0px; padding-right: 0px;">
<?php if ($warning_reports != null) { ?>
                            <span>
                                <div id="hunght_warning_contract" class="notifynumber"><?php echo count($warning_reports); ?></div>
                            </span>
<?php } ?>
                    </a>
                    <a title="Dự toán tài chính" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_profit" class="hunght_warning_profit" style="width: 44px; padding-left: 0px; padding-right: 0px;">
                        <span>
                            <div style="display:none"  id="hunght_warning_profit" class="notifynumber">0</div>
                        </span>
                    </a>
                    <a title="Hết hàng tồn kho" onclick="return false;"   href="#" rel="nofollow" id="hunght_warning_warehouse" class="hunght_warning_warehouse" style="width: 44px; padding-left: 0px; padding-right: 0px;">
<?php if ($items != null) { ?>
                            <span>
                                <div id="hunght_warning_warehouse" class="notifynumber"><?php echo count($items); ?></div>
                            </span>
<?php } ?>		  
                    </a>
                    <!--end add warning-->
                    <div style="height:40px;line-height:35px;padding-left:10px;float:left;width:227px">
                        <img class="avatar" src="<?php echo base_url() . 'file/' . $person_info->image_face ?>" /> 
                        <span >
<?php
if (strlen($user_info->first_name) > 18) {
    echo "<b>" . substr_replace($user_info->first_name . '' . $user_info->last_name, "...", 18) . "</b>";
} else {
    echo "<b>$user_info->first_name $user_info->last_name </b>";
}
?>
                        </span>
                        <a class="more" onclick="return false;"  href="#"></a>

                        <!--warning-->
                        <ul style="left: 1100px; display: none;" class="drop_warning_debt">
<?php
if ($suspends_date != null) {
    $this->load->model('Customer');
    ?>
                                <li>
                                    <table class="mytable" cellspacing="0">
                                        <thead>
                                            <th style="text-align:center;">Tên</th>
                                            <th style="text-align:center;">SĐT</th>
                                            <th style="text-align:center;">Thành phố</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
    <?php foreach ($suspends_date as $suspend_date) {
        ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo site_url('reports/specific_' . ( 'customer') . '/' . $start_of_time . '/' . $today . '/' . $suspend_date['customer_id'] . '/all/0') ?>">
                                                <?php
                                                if ($suspend_date['customer_id'] != null) {
                                                    echo $this->Customer->get_info($suspend_date['customer_id'])->first_name;
                                                    echo ' ' . $this->Customer->get_info($suspend_date['customer_id'])->last_name;
                                                } else
                                                    echo "Khách hàng ko tên";
                                                ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                            <?php
                                                            if ($this->Customer->get_info($suspend_date['customer_id'])->phone == '') {
                                                                echo "DĐ:" . $this->Customer->get_info($suspend_date['customer_id'])->phone_number;
                                                            } elseif ($this->Customer->get_info($suspend_date['customer_id'])->phone_number == '') {
                                                                echo "Máy bàn:" . $this->Customer->get_info($suspend_date['customer_id'])->phone;
                                                            } elseif ($this->Customer->get_info($suspend_date['customer_id'])->phone_number != '' && $this->Customer->get_info($suspend_date['customer_id'])->phone != '') {
                                                                echo "DĐ:" . $this->Customer->get_info($suspend_date['customer_id'])->phone_number .
                                                                '<br/> Máy bàn:' . $this->Customer->get_info($suspend_date['customer_id'])->phone;
                                                            } elseif ($this->Customer->get_info($suspend_date['customer_id'])->phone == '' && $this->Customer->get_info($suspend_date['customer_id'])->phone_number == '') {
                                                                echo "";
                                                            }
                                                            ?>
                                                    </td>
                                                        <?php
                                                        $this->load->model('customer');
                                                        $name_city = $this->Customer->get_city($this->Customer->get_info($suspend_date['customer_id'])->city);
                                                        ?>
                                                    <td><?php echo $name_city[0]['name']; ?></td>
                                                    <td>
                                                        <?php
                                                        echo form_open('sales/unsuspend');
                                                        echo form_hidden('suspended_sale_id', $suspend_date['sale_id']);
                                                        ?>
                                                        <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
                                                            </form>
                                                    </td>
                                                </tr>
                                                    <?php } ?>
                                        </tbody>
                                    </table>
                                </li>
                                                <?php } else echo "<li>không có công nợ mới</li>"; ?>

                        </ul>


                        <!--Cảnh báo khách hàng mới-->
                        <ul style="left: 1100px; display: none;" class="drop_warning_customer">
<?php
if ($register_date != null) {
    $this->load->model('Customer');
    ?>
                                <li>					 
                                    <table class="mytable" cellspacing="0">
                                        <thead>
                                            <th style="text-align:center;">Tên</th>
                                            <th style="text-align:center;">SĐT</th>
                                            <th style="text-align:center;">Thành phố</th>
                                        </thead>
                                        <tbody>
                                <?php foreach ($register_date as $register_dates) {
                                    ?>
                                                <tr>
                                                    <td><a href="<?php echo site_url('reports/specific_' . ( 'customer') . '/' . $start_of_time . '/' . $today . '/' . $register_dates['person_id'] . '/all/0') ?>"><?php echo $register_dates['first_name'] ?><!-- echo ' ' . $register_dates['last_name'] --></a></td>
                                                    <td>
        <?php
        if ($register_dates['phone'] == '') {
            echo "DĐ:" . $register_dates['phone_number'];
        } elseif ($register_dates['phone_number'] == '') {
            echo "Máy bàn:" . $register_dates['phone'];
        } elseif ($register_dates['phone'] == '' && $register_dates['phone_number'] == '') {
            echo "";
        } elseif ($register_dates['phone'] != '' && $register_dates['phone_number'] != '') {
            echo "DĐ:" . $register_dates['phone_number'] .
            '<br/> Máy bàn:' . $register_dates['phone'];
        }
        ?>
                                                    </td>
                                                        <?php
                                                        $this->load->model('customer');
                                                        $name_city = $this->Customer->get_city($register_dates['city']);
                                                        ?>
                                                    <td><?php echo $name_city[0]['name']; ?></td>
                                                </tr>
                                                    <?php } ?>
                                        </tbody>
                                    </table>
                                </li>
                                                <?php } else echo "<li>không có khách hàng trong hôm nay</li>"; ?>
                        </ul>

                        <ul style="left: 1100px; display: none;" class="drop_warning_orders">
                                            <?php
                                            if ($suspended_sales != null) {
                                                $this->load->model('Customer');
                                                ?>
                                <li>
                                    <table  id="suspended_sales_table"  class="mytable">
                                        <tr>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('sales_suspended_sale_id'); ?></th>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('sales_date'); ?></th>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('sales_customer'); ?></th>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('sales_comments'); ?></th>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('sales_unsuspend'); ?></th>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('sales_receipt'); ?></th>
                                            <th style="text-align:center;font-size: 11px;">Báo giá</th>
                                            <th style="text-align:center;font-size: 11px;">Hợp đồng </th>
                                            <th style="text-align:center;font-size: 11px;">Hỏi hàng</th>
                                            <th style="text-align:center;font-size: 11px;"><?php echo lang('common_delete'); ?></th>
                                        </tr>

    <?php
    foreach ($suspended_sales as $suspended_sale) {
        ?>
                                            <tr>
                                                <td style="text-align:center;" width="5%"><?php echo $suspended_sale['sale_id']; ?></td>
                                                <td><?php echo date(get_date_format(), strtotime($suspended_sale['sale_time'])); ?></td>
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
                                                <td>
                                                    <?php
                                                    echo form_open('sales/unsuspend');
                                                    echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
                                                    ?>
                                                    <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
                                                        </form>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo form_open('sales/receipt/' . $suspended_sale['sale_id'], array('method' => 'get', 'id' => 'form_receipt_suspended_sale'));
                                                    ?>
                                                    <input type="submit" name="submit" value="<?php echo lang('sales_recp'); ?>" id="submit_receipt" class="submit_button float_right">

                                                        </form>
                                                </td>
                                                <!-- phan lam -->
                                                <td width="13%">
                                                    <?php
                                                    echo form_open('sales/baogia/' . $suspended_sale['sale_id'], array('method' => 'get', 'id' => 'form_baogia_suspended_sale'));
                                                    ?>
                                                    <input type="radio" name="baogiabutton" value="1" checked >excel
                                                        <input type="radio" name="baogiabutton" value="0">mail
                                                            <input type="submit" name="submit" value="Báo giá" id="submit_receipt" class="submit_button float_right">

                                                                </form>
                                                                </td>
                                                                <td width="13%">
        <?php
        echo form_open('sales/contract/' . $suspended_sale['sale_id'], array('method' => 'get', 'id' => 'form_contract_suspended_sale'));
        ?>
                                                                    <input type="radio" name="hopdongbutton" value="1" checked >excel
                                                                        <input type="radio" name="hopdongbutton" value="0">mail
                                                                            <input type="submit" name="submit" value="Hợp đồng" id="submit_receipt" class="submit_button float_right">
                                                                                </form>
                                                                                </td>
                                                                                <td>
        <?php
        echo form_open('sales/hoihang/' . $suspended_sale['sale_id'], array('method' => 'get', 'id' => 'form_hoihang_suspended_sale'));
        ?>
                                                                                    <input type="submit" name="submit" value="Hỏi hàng" id="submit_receipt" class="submit_button float_right">

                                                                                        </form>
                                                                                </td>
                                                                                <!-- end phan lam-->
                                                                                <td>
                                                                    <?php
                                                                    echo form_open('sales/delete_suspended_sale', array('id' => 'form_delete_suspended_sale'));
                                                                    echo form_hidden('suspended_sale_id', $suspended_sale['sale_id']);
                                                                    ?>

                                                                                    <input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
                                                                                        </form>
                                                                                </td>
                                                                                </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </table>
                                                                            </li>
<?php } else echo "<li>không có đơn hàng mới</li>"; ?>
                                                                        </ul>
                                                                        <ul style="left: 1100px; display: none;" class="drop_warning_contract">
                                                                            <li>Không có hợp đồng mới</li>
                                                                        </ul>


                                                                        <ul style="left: 1100px; display: none;" class="drop_warning_web">
<?php
if ($payment_date != null) {
    $this->load->model('Customer');
    ?>
                                                                                <li>
                                                                                    <table  id="suspended_sales_table" class="mytable">
                                                                                        <tr>
                                                                                            <th style="text-align:center;font-size:11px;"><?php echo lang('sales_suspended_sale_id'); ?></th>
                                                                                            <th style="text-align:center;font-size:11px;"><?php echo lang('sales_date'); ?></th>
                                                                                            <th style="text-align:center;font-size:11px;"><?php echo lang('sales_customer'); ?></th>
                                                                                            <th style="text-align:center;font-size:11px;"><?php echo lang('sales_total'); ?></th>
                                                                                            <th style="text-align:center;font-size:11px;"><?php echo lang('sales_unsuspend'); ?></th>
                                                                                        </tr>

                                                                                <?php
                                                                                foreach ($payment_date as $payment_dates) {
                                                                                    ?>
                                                                                            <tr>
                                                                                                <td style="text-align:center;font-size:10px;"><?php echo $payment_dates['sale_id']; ?></td>
                                                                                                <td><?php echo date(get_date_format(), strtotime($payment_dates['sale_time'])); ?></td>
                                                                                                <td>
        <?php
        if (isset($payment_dates['customer_id'])) {
            $customer = $this->Customer->get_info($payment_dates['customer_id']);
            echo $customer->first_name. ' ' . $customer->last_name;
        } else {
            ?>
                                                                                                        &nbsp;
            <?php
        }
        ?>
                                                                                                </td>
                                                                                                <td><?php echo number_format($payment_dates['later_cost_price']) . ' VNĐ'; ?></td>
                                                                                                <td style="text-align:center;font-size:12px;">
                                                                                            <?php
                                                                                            echo form_open('sales/unsuspend');
                                                                                            echo form_hidden('suspended_sale_id', $payment_dates['sale_id']);
                                                                                            ?>
                                                                                                    <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
                                                                                                        </form>
                                                                                                </td>                                             
                                                                                            </tr>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                    </table>
                                                                                </li>
                                                                                            <?php } else echo "<li>không có đơn hàng mới từ web</li>"; ?>
                                                                        </ul>
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

                                                                        <ul style="left: 1100px; display: none;" class="drop_warning_jobs">
                                                                            <li>Không có công việc cần phê duyệt</li>
                                                                        </ul>

                                                                        <ul style="left: 1200px; display: none;" class="drop_warning_jobs">		
                                                                            <?php
                                                                            if ($warning_reports != null) {
                                                                                $this->load->model('Jobs_projects');
                                                                                ?>
                                                                                <li>
                                                                                    <table class="mytable" cellspacing="0">
                                                                                        <thead>
                                                                                            <th style="text-align:center;font-size:11px;">Tên công việc</th>
                                                                                            <th style="text-align:center;font-size:11px;">Ngày giao</th>
                                                                                            <th style="text-align:center;font-size:11px;">Tiến độ</th>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            foreach ($warning_reports as $warning_report) {
                                                                                                $text = $this->Jobs_projects->get_info_task($warning_report['id'])->text;
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <a href="<?php echo base_url(); ?>jobs/">
                                                                                                            <?php echo $text ?>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php echo $this->Jobs_projects->get_info_task($warning_report['id'])->start_date; ?>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php echo $this->Jobs_projects->get_info_task($warning_report['id'])->progress * 100; ?> %
                                                                                                    </td>
                                                                                                </tr>
                                                                                        <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </li>
                                                                                        <?php } else echo "<li>Không có công việc mới được giao</li>"; ?>
                                                                        </ul>
                                                                        <ul style="left: 1100px; display: none;" class="drop_warning_profit">
                                                                            <li>Không có dự toán mới</li>
                                                                        </ul>
                                                                        <ul style="left: 1100px; display: none; width: 500px;" class="drop_warning_warehouse">
<?php
if ($items != null) {

    $this->load->model('Customer');
    ?>
                                                                                <li>
                                                                                    <table class="mytable" cellspacing="0" style="width: 95%; margin: 0px auto">
                                                                                        <thead>

                                                                                            <th style="text-align:center;font-size:11px;">Tên</th>

                                                                                            <th style="text-align:center;font-size:11px;">Số lượng</th>

                                                                                            <th style="text-align:center;font-size:11px;">Mức ngưỡng</th>
                                                                                            <th></th>

                                                                                        </thead>

                                                                                        <tbody>

                                                                                <?php
                                                                                for ($i = 0; $i < count($items); $i++) {

                                                                                    $item_info = $this->Item->get_info($items[$i]);
                                                                                    ?>

                                                                                                <tr>

                                                                                                    <td><?php echo $item_info->name; ?></td>

                                                                                                    <td style="text-align: center"><?php echo $item_info->quantity; ?></td>

                                                                                                    <td style="text-align: center"><?php echo $item_info->reorder_level; ?></td>
                                                                                                    <td style="text-align: center"><a href="<?php echo base_url(); ?>items/switch_receving/<?php echo $item_info->item_id; ?>">Nhập hàng</a></td>

                                                                                                </tr>

    <?php } ?>

                                                                                        </tbody>

                                                                                    </table>
                                                                                </li>
                                                                                        <?php } else echo "<li>Chưa có mặt hàng nào hết hàng</li>"; ?>
                                                                        </ul>


                                                                        <!--end warning-->


                                                                        <ul style="left: 1100px; display: none;" class="dropmore">
<?php
$region = $this->Jobs_regions->get_region_id($this->Employee->get_logged_in_employee_info()->person_id);
$city = $this->Jobs_city->get_city_id($this->Employee->get_logged_in_employee_info()->person_id);
$aff = $this->Jobs_affiliates->get_aff_id($this->Employee->get_logged_in_employee_info()->person_id);
$dep = $this->Jobs_department->get_dep_id($this->Employee->get_logged_in_employee_info()->person_id);

if ($this->Employee->get_logged_in_employee_info()->person_id != 1 && $region->num_rows() == 0 && $city->num_rows() == 0 && $aff->num_rows() == 0 && $dep->num_rows() == 0
) {
    $width = 1050;
    ?>
                                                                                <li><a href="<?php echo site_url() . "/employees/view/$user_info->person_id/width~$width" ?>"
                                                                                       class="thickbox edit_emp edit_emp">
                                                                                        Thông tin cá nhân</a>
                                                                                </li>
                                                                                <?php }
                                                                            ?>
                                                                            <li>
<?php
echo anchor(
        "home/form_change_pass/$user_info->person_id/width~400/height~250", 'Đổi mật khẩu', array(
    'class' => 'thickbox',
    'title' => 'Đổi mật khẩu'
        )
)
?>
                                                                                </span> </a>
                                                                            </li>
                                                                            <li> <?php
                                                                            if ($this->config->item('track_cash') && $this->Sale->is_register_log_open()) {
                                                                                echo anchor("sales/closeregister?continue=logout", lang("common_logout"));
                                                                            } else {
                                                                                echo anchor("home/logout", lang("common_logout"));
                                                                            }
                                                                            ?>
                                                                            </li>
                                                                        </ul>
                                                                        <!--change pass form-->
                                                                        <div id="loginform" > <form id="navbar_loginform" action="login.php?do=login" method="post" onsubmit="md5hash(vb_login_password, vb_login_md5password, vb_login_md5password_utf, 0)"> <div>
                                                                                    <label for="navbar_username">Username:</label> 
                                                                                    <input type="text" class="textbox default-value" name="vb_login_username" id="navbar_username" size="10" accesskey="u" tabindex="101" value="Tên tài khoản" /> 
                                                                                    <label for="navbar_password">Password:</label> 
                                                                                    <input type="password" class="textbox" tabindex="102" name="vb_login_password" id="navbar_password" size="10" /> 
                                                                                    <input type="text" class="textbox default-value" tabindex="102" name="vb_login_password_hint" id="navbar_password_hint" size="10" value="Mật khẩu" style="display:none;" /> 
                                                                                </div> 
                                                                                <div id="remember" class="remember"> 
                                                                                    <label for="cb_cookieuser_navbar">
                                                                                        <input type="checkbox" name="cookieuser" value="1" id="cb_cookieuser_navbar" class="cb_cookieuser_navbar" checked accesskey="c" tabindex="103" /> Ghi nhớ?</label>
                                                                                </div>
                                                                                <div class="actionbutton"> 
                                                                                    <input type="submit" class="loginbutton" tabindex="104" value="Ðăng nhập" title="Nhập username và mật khẩu đã cung cấp để đăng nhập, hoặc ấn vào 'đăng ký' để tao 1 tài khoản" accesskey="s" />
                                                                                    <a href="login.php?do=lostpw" rel="nofollow" class="forgotbutton">Quên mật khẩu</a> 
                                                                                </div>
                                                                                <input type="hidden" name="s" value="" />
                                                                                <input type="hidden" name="securitytoken" value="guest" /> 
                                                                                <input type="hidden" name="do" value="login" /> 
                                                                                <input type="hidden" name="vb_login_md5password" />
                                                                                <input type="hidden" name="vb_login_md5password_utf" /> 
                                                                            </form> 
                                                                        </div> 
                                                                        <script type="text/javascript">
                                                                            YAHOO.util.Dom.setStyle('navbar_password_hint', "display", "inline");
                                                                            YAHOO.util.Dom.setStyle('navbar_password', "display", "none");
                                                                            vB_XHTML_Ready.subscribe(function () {
                                                                                //
                                                                                YAHOO.util.Event.on('navbar_username', "focus", navbar_username_focus);
                                                                                YAHOO.util.Event.on('navbar_username', "blur", navbar_username_blur);
                                                                                YAHOO.util.Event.on('navbar_password_hint', "focus", navbar_password_hint);
                                                                                YAHOO.util.Event.on('navbar_password', "blur", navbar_password);
                                                                            });

                                                                            function navbar_username_focus(e) {
                                                                                //
                                                                                var textbox = YAHOO.util.Event.getTarget(e);
                                                                                if (textbox.value == 'Tên tài khoản') {
                                                                                    //
                                                                                    textbox.value = '';
                                                                                    textbox.style.color = '#000000';
                                                                                }
                                                                            }
                                                                            function navbar_username_blur(e) {
                                                                                //
                                                                                var textbox = YAHOO.util.Event.getTarget(e);
                                                                                if (textbox.value == '') {
                                                                                    //
                                                                                    textbox.value = 'Tên tài khoản';
                                                                                    textbox.style.color = '#777777';
                                                                                }
                                                                            }
                                                                            function navbar_password_hint(e) {
                                                                                //
                                                                                var textbox = YAHOO.util.Event.getTarget(e);
                                                                                YAHOO.util.Dom.setStyle('navbar_password_hint', "display", "none");
                                                                                YAHOO.util.Dom.setStyle('navbar_password', "display", "inline");
                                                                                YAHOO.util.Dom.get('navbar_password').focus();
                                                                            }
                                                                            function navbar_password(e) {
                                                                                //
                                                                                var textbox = YAHOO.util.Event.getTarget(e);
                                                                                if (textbox.value == '') {
                                                                                    YAHOO.util.Dom.setStyle('navbar_password_hint', "display", "inline");
                                                                                    YAHOO.util.Dom.setStyle('navbar_password', "display", "none");
                                                                                }
                                                                            }

                                                                        </script>
                                                                        <!--end form--> 

                                                                        </div>
                                                                        </div>
                                                                        </div>  

                                                                        </div>

                                                                        <div class="metro-layout horizontal">
                                                                            <div class="header">
                                                                                <div class="control">
                                                                                    <div style="width:1000px; margin:0 auto;height:100px">
                                                                                        <div class="logo-customer">
                                                                                            <a href="<?php echo site_url('home'); ?>">
<?php
echo img(
        array(
            'src' => $this->Appconfig->get_logo_image(),
            'width' => '170',
            'height' => '70',
));
?>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div style=" float:right; width:830px; height:100px;">
                                                                                            <div class="last">
                                                                                                <span class="number">Hỗ trợ online</span>
                                                                                                <div style="height:50px;line-height:54px;width:780px;">
<?php
$about = $this->About->get_about_header();
foreach ($about as $row) {
    ?>
                                                                                                        <span class="name"><?php echo $row['name_eployee']; ?></span>
                                                                                                        <span class="name">Tel: <?php echo $row['phone']; ?> - Fax: <?php echo $row['fax']; ?></span>
                                                                                                        <span class="name">Email: <?php echo $row['email']; ?></span> 
                                                                                                        <span class="name" style="width: 80px">
                                                                                                            <label style="float: left;display: inline-block">Skype :</label> <a href="skype:<?php echo $row['skype']; ?>?call"><img src="<?php echo base_url(); ?>images/support/skype.png" style="border: none;" width="32" height="32" alt="My status" /></a>
                                                                                                        </span>
                                                                                                        <span class="name" style="min-width: 140px">
                                                                                                            <label style="float: left;display: inline-block">Yahoo :</label><a href="ymsgr:sendIM?<?php echo $row['yahoo']; ?>"><font size="2" face="Arial"><img style="width: 134px;height:25px;margin-top:13px" vspace="5" border="0" align="absmiddle" alt="Click để Chat với nhân viên hỗ trợ !" src="http://opi.yahoo.com/online?u=<?php echo $row['yahoo']; ?>&amp;m=g&amp;t=2&amp;l=us" title="Click để Chat với nhân viên hỗ trợ!"></font></a>
                                                                                                        </span>
                                                                                                <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="alert alert-success" style="display:none"><?php echo lang('common_welcome_message'); ?></div>
                                                                                </div>

                                                                                <div class="controls">
                                                                                    <span class="down" title="Scroll down"></span>
                                                                                    <span class="up" title="Scroll up"></span>
                                                                                    <span class="next" title="Scroll left"></span>
                                                                                    <span class="prev" title="Scroll right"></span>
                                                                                    <span class="toggle-view" title="Toggle layout"></span>
                                                                                </div>

                                                                            </div>
                                                                            <div id="feedback_bar" style=" position: fixed; z-index: 111"></div>
<?php $this->load->view("partial/navigation"); ?>
        
