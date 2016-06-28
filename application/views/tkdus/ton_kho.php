<!-- Hưng Audi say gOOdbye \/ -->
<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
    <div id="content_area" style="height: auto;float: left;">
        <div style="color:#000;">
            <table id="title_bar_new">
                <tr>
                    <td id="title_icon">
                        <img src='<?php echo base_url() ?>images/menubar/chungtus.png' alt='title icon' />
                    </td>
                    <td id="title" >Tồn kho vật tư, hàng hóa</td>
                    <td style="text-align: right; padding-right: 10px;">
                        <a id="a_return" style="font-size:18px;text-decoration: underline; color: #FFFFFF" 
                           href="<?php echo site_url() ?>tkdus/begin_balance">Trở lại</a>
                    </td>
                </tr>
            </table>
            <div id="tab1" class="tab_content">
                <?= form_open_multipart('tkdus/update_item'); ?>   
                <fieldset class="bye">
                    <table id="inventory_sale8" class="append_table1">
                        <tr class="title_font">
                            <td style="width: 20%;text-align: center">Mã hàng</td>
                            <td style="width: 40%;text-align: center">Tên hàng</td>
                            <td style="width: 10%;text-align: center">ĐVT</td>
                            <td style="width: 10%;text-align: center">Số lượng</td>
                            <td style="width: 20%; text-align: center">Giá trị tồn</td>
                        </tr>
                        <?php
                        $quantity_inv_total = 0;
                        $money_inv_total = 0;
                        foreach ($item->result() as $s){?>
                            <tr>
                                <td style="text-align: left; padding-left: 5px;"><?= $s->item_number ?></td>
                                <td style="text-align: left; padding-left: 5px; "><?= $s->name ?></td>
                                <td style="text-align: left; padding-left: 5px">
                                    <?= $this->Unit->get_info($s->unit_rate == 0 ? $s->unit : $s->rate)->name ?>
                                </td>
                                <td style="">
                                    <?= form_input(array(
                                        'name' => "quantity_inv[$s->item_id]",
                                        id => "quantity_inv_$s->item_id",
                                        'class' => 'quantity_inv',
                                        'value' => $s->quantity_inv,
                                        onchange => "sum_quantity_inv($s->item_id)"
                                    )) ?>
                                </td>
                                <td style="">
                                    <?= form_input(array(
                                        'name' => "money_inv[$s->item_id]",
                                        id => "money_inv_$s->item_id",
                                        'class' => 'money_inv',
                                        'value' => $s->money_inv,
                                        onchange => "sum_money_inv($s->item_id)"
                                    )) ?>
                                </td>
                            </tr>
                            <?php
                            $quantity_inv_total += $s->quantity_inv;
                            $money_inv_total += $s->money_inv;
                        }?>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: 600">Tổng cộng &nbsp</td>
                            <td>
                            <?= form_input(array(
                                'class' => 'quantity_inv_total',
                                'value' => number_format($quantity_inv_total)
                            )) ?>
                            </td>
                            <td>
                            <?= form_input(array(
                                'class' => 'money_inv_total',
                                'value' => number_format($money_inv_total)
                            )) ?>
                            </td>
                        </tr>
                    </table>
                    <?= form_submit(array(
                            value => lang(common_submit),
                            'class' => 'submit_button float_right',
                            style => 'margin-bottom:20px',
                            name => save_cave
                        ))?>
                </fieldset>
                <?= form_close(); ?>    
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
function sum_quantity_inv(id) {
    var sum_cost=0;
    $('.quantity_inv').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_cost += +a;
    });
    $('.quantity_inv_total').val((sum_cost+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
}
function sum_money_inv(id) {
    var sum_cost=0;
    $('.money_inv').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_cost += +a;
    });
    $('.money_inv_total').val((sum_cost+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
}
</script>
<style type="text/css">
.bye{
    border: none;
}    
.quantity_inv_total, .money_inv_total{
    border: none;
    text-align: right;
    padding-right: 8px;
}
.quantity_inv, .money_inv{
    text-align: right;
    padding-right: 4px;
    margin: 2px;
    height: 20px;
    width:80%
}    
#inventory_sale8{
    font-family: Arial, Helvetica, sans-serif;
    border:1px solid black;
    margin:15px auto;
    border-collapse: collapse;
}
#inventory_sale8 tr td{
    text-align: center;
    border:1px solid #CCC;
    font-size: 12px;
    padding: 3px 2px;
    line-height: 20px
}
.append_table2 td.innertable3 {
    display: none;
    border-bottom: 4px solid #111111;
    padding: 0px;
}    
.append_table1 td.innertable2 {
    display: none;
    border-bottom: 4px solid #111111;
    padding: 0px;
}
.append_table2{
    width: 100%;
    padding: 9px;
}
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
    font-size: 1em;
    padding: 0 10px;
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
    padding: 0 20px;
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
.title_font{
    font-weight: bold;
}
</style>
<?php $this->load->view("partial/footer"); ?>