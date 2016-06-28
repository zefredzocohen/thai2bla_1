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
                    <td id="title" >Số dư tài khoản</td>
                    <td style="text-align: right; padding-right: 10px;">
                        <a id="a_return" style="font-size:18px;text-decoration: underline; color: #FFFFFF" 
                           href="<?php echo site_url() ?>tkdus/begin_balance">Trở lại</a>
                    </td>
                </tr>
            </table>
            <div id="tab1" class="tab_content">
                <?= form_open_multipart('tkdus/update_tkdu'); ?>   
                <fieldset class="bye">
                <table id="inventory_sale8" class="append_table1">
                    <tr class="title_font">
                        <td style="width: 5%"></td>
                        <td style="width: 15%;text-align: center">Số tài khoản</td>
                        <td style="width: 40%;text-align: center">Tên tài khoản</td>
                        <td style="width: 20%;text-align: center">Dư nợ</td>
                        <td style="text-align: center">Dư có</td>
                    </tr>

                    <?php
                    $total_no_all = 0;
                    $total_co_all = 0;
                    foreach ($list_tkdu as $parent1){
                        $id = $parent1['id'];
                        $parents2 = $this->Tkdu->get_all_tk2_by_tk1($id)->result();
                        
                        $total_no_all += $parent1['du_no'];
                        $total_co_all += $parent1['du_co'];
                        
                        $total_no2 = 0;
                        $total_co2 = 0;
                        foreach ($parents2 as $parent2){
                            $total_no2 += $parent2->du_no;
                            $total_co2 += $parent2->du_co;
                        }?>
                        <tr>
                            <td><?= $parents2 ? '<a href="#" class="expand" style="font: 19px solid; ">+</a>' : '' ?></td>
                            <td style="text-align: left; padding: 0px 6px"><?= $parent1['id'] ?></td>
                            <td style="text-align: left; padding: 0px 6px"><?= $parent1['name'] ?></td>
                            <td><?= $parents2 
                                ? form_input(array(
                                    'name' => "du_no[$id]",
                                    'class' => "du_no_none du_no_none1$id du_no1",
                                    'value' => number_format($total_no2),
                                    readonly => '',
                                ))
                                : form_input(array(
                                    'name' => "du_no[$id]",
                                    'class' => 'du_no du_no1',
                                    'value' => number_format($parent1['du_no']),
                                    onchange => "cal_no_all()"
                                ))?>
                            </td>
                            <td><?= $parents2 
                                ? form_input(array(
                                    'name' => "du_co[$id]",
                                    'class' => "du_co_none du_co_none1$id du_co1",
                                    'value' => number_format($total_co2),
                                    readonly => ''
                                ))
                                : form_input(array(
                                    'name' => "du_co[$id]",
                                    'class' => 'du_co du_co1',
                                    'value' => number_format($parent1['du_co']),
                                    onchange => "cal_co_all()"
                                ))?>
                            </td>
                        </tr>
                        <?php 
                        if($parents2){?>
                            <tr>
                                <td colspan="5" class="innertable2" style="font-size: 0.95em !important; ">
                                    <table class="append_table2">
                                        <?php
                                        foreach ($parents2 as $parent2){
                                            $id2 = $parent2->id;
                                            $parents3 = $this->Tkdu->get_all_tk2_by_tk1($id2)->result();
                                            
                                            $total_no3 = 0;
                                            $total_co3 = 0;
                                            foreach ($parents3 as $parent3){
                                                $total_no3 += $parent3->du_no;
                                                $total_co3 += $parent3->du_co;
                                            }?>
                                            <tr>
                                                <td style="width: 5%;border-top: none;border-left: none;">
                                                    <?= $parents3 ? '<a href="#" class="expand2" style="font: 19px solid; ">+</a>' : '' ?>
                                                </td>
                                                <td style="width: 15%;text-align: left; padding: 0px 6px; border-top: none; ">
                                                    - <?= $id2 ?>
                                                </td>
                                                <td style="width: 40%;text-align: left; border-top: none; padding: 0px 6px">
                                                    <?= $parent2->name ?>
                                                </td>
                                                <td style="width: 20%;text-align: center; border-top: none; padding: 0px 6px">
                                                <?= $parents3 
                                                    ? form_input(array(
                                                        'name' => "du_no[$id2]",
                                                        'class' => "du_no_none du_no_none2$id2 du_no2$id",
                                                        'value' => number_format($total_no3),
                                                        readonly => '',
                                                    ))
                                                    : form_input(array(
                                                        'name' => "du_no[$id2]",
                                                        'class' => "du_no du_no2$id",
                                                        'value' => number_format($parent2->du_no),
                                                        onchange => "cal_no2($id)"
                                                    )) ?>
                                                </td>
                                                <td style="text-align: center; border-top: none; border-right: none; padding: 0px 6px">
                                                <?= $parents3 
                                                    ? form_input(array(
                                                        'name' => "du_co[$id2]",
                                                        'class' => "du_co_none du_co_none2$id2 du_co2$id",
                                                        'value' => number_format($total_co3),
                                                        readonly => ''
                                                    ))
                                                    : form_input(array(
                                                        'name' => "du_co[$id2]",
                                                        'class' => "du_co du_co2$id",
                                                        'value' => number_format($parent2->du_co),
                                                        onchange => "cal_co2($id)"
                                                    )) ?>
                                                </td>
                                            </tr>
                                            <?php 
                                            if($parents3){?>
                                                <tr>
                                                    <td colspan="5" class="innertable3" style="font-size: 0.95em !important; ">
                                                        <table class="append_table3">
                                                            <?php
                                                            foreach ($parents3 as $parent3){
                                                                $id3 = $parent3->id; ?>
                                                                <tr>
                                                                    <td style="width: 5%;border-top: none;border-left: none;"></td>
                                                                    <td style="width: 15%;text-align: left; padding: 0px 6px; border-top: none; ">
                                                                        -- <?= $id3 ?>
                                                                    </td>
                                                                    <td style="width: 40%;text-align: left; border-top: none; padding: 0px 6px">
                                                                        <?= $parent3->name ?>
                                                                    </td>
                                                                    <td style="width: 20%;text-align: center; border-top: none; padding: 0px 6px">
                                                                    <?= form_input(array(
                                                                        'name' => "du_no[$id3]",
                                                                        'class' => "du_no du_no3$id2",
                                                                        'value' => number_format($parent3->du_no),
                                                                        onchange => "cal_no3($id2, $id)"
                                                                    ))?>
                                                                    </td>
                                                                    <td style="text-align: center; border-top: none; border-right: none; padding: 0px 6px">
                                                                    <?= form_input(array(
                                                                        'name' => "du_co[$id3]",
                                                                        'class' => "du_co du_co3$id2",
                                                                        'value' => number_format($parent3->du_co),
                                                                        onchange => "cal_co3($id2, $id)"
                                                                    ))?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }?>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }?>
                                    </table>
                                </td>
                            </tr>
                        <?php
                        }
                    }?>
                    <tr>
                        <td colspan="3" style="font-weight: 600; text-align: right">Tổng tiền:&nbsp</td>
                        <td><?= form_input(array(
                            'name' => "total_no_all",
                            'class' => 'total_no_all',
                            'value' => number_format($total_no_all),
                            readonly => ''
                            ))?>
                        </td>
                        <td><?= form_input(array(
                            'name' => "total_co_all",
                            'class' => 'total_co_all',
                            'value' => number_format($total_co_all),
                            readonly => ''
                            ))?>
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
//__________no
function cal_no3(id2, id1){
    //3
    var sum2=0;
    $('.du_no3'+id2).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum2 += +a;
    });
    $('.du_no_none2'+id2).val((sum2+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
    
    //2
    var sum1=0;
    $('.du_no2'+id1).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum1 += +a;
    });
    $('.du_no_none1'+id1).val((sum1+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    
    //1
    var sum_total=0;
    $('.du_no1').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_total += +a;
    });
    $('.total_no_all').val((sum_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
function cal_no2(id1){
    //2
    var sum1=0;
    $('.du_no2'+id1).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum1 += +a;
    });
    $('.du_no_none1'+id1).val((sum1+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    
    //1
    var sum_total=0;
    $('.du_no1').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_total += +a;
    });
    $('.total_no_all').val((sum_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
function cal_no_all(){
    var sum_total=0;
    $('.du_no1').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_total += +a;
    });
    $('.total_no_all').val((sum_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
//__________co
function cal_co3(id2, id1){
    //3
    var sum2=0;
    $('.du_co3'+id2).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum2 += +a;
    });
    $('.du_co_none2'+id2).val((sum2+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    
    //2
    var sum1=0;
    $('.du_co2'+id1).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum1 += +a;
    });
    $('.du_co_none1'+id1).val((sum1+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    
    //1
    var sum_total=0;
    $('.du_co1').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_total += +a;
    });
    $('.total_co_all').val((sum_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
function cal_co2(id1){
    //2
    var sum1=0;
    $('.du_co2'+id1).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum1 += +a;
    });
    $('.du_co_none1'+id1).val((sum1+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    
    //1
    var sum_total=0;
    $('.du_co1').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_total += +a;
    });
    $('.total_co_all').val((sum_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}
function cal_co_all(){
    var sum_total=0;
    $('.du_co1').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_total += +a;
    });
    $('.total_co_all').val((sum_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}

$(document).ready(function () {
    $(".append_table1 a.expand").click(function (event){
        $(event.target).parent().parent().next().find('td.innertable2').toggle();
        if ($(event.target).text() == '+')
            $(event.target).text('-');
        else
            $(event.target).text('+');
        return false;
    });
    $(".append_table2 a.expand2").click(function (event){
        $(event.target).parent().parent().next().find('td.innertable3').toggle();
        if ($(event.target).text() == '+')
            $(event.target).text('-');
        else
            $(event.target).text('+');
        return false;
    });
});
</script>
<style type="text/css">
.bye{
    border: none;
}
.du_no_none, .du_co_none, .total_no_all, .total_co_all{
    text-align: right;
    padding-right: 4px;
    height: 20px;
    border: none;
}
.du_no, .du_co{
    text-align: right;
    padding-right: 4px;
    height: 20px
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
    line-height: 30px
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