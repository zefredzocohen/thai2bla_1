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
                    <td id="title" >Công nợ khác</td>
                    <td style="text-align: right; padding-right: 10px;">
                        <a id="a_return" style="font-size:18px;text-decoration: underline; color: #FFFFFF" 
                           href="<?php echo site_url() ?>tkdus/begin_balance">Trở lại</a>
                    </td>
                </tr>
            </table>
            <div id="tab1" class="tab_content">
                <?= form_open_multipart('tkdus/save_cong_no_khac'); ?>   
                <fieldset class="bye">
                    <div class='form_field'  >
                        <label style="margin-top: 11px; ">
                            <a href="#" class="expand">+ Thêm công nợ</a>
                        </label>    
                    </div>
                    <table id="inventory_sale8" class="append_table1 flower_table">
                        <thead>
                            <tr class="title_font">
                                <td style="width: 10%;text-align: center">Số tài khoản</td>
                                <td style="width: 20%;text-align: center">Mã đối tượng</td>
                                <td style="width: 40%;text-align: center">Tên đối tượng</td>
                                <td style="width: 15%;text-align: center">Dư nợ</td>
                                <td style="text-align: center">Dư có</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($nguoi_khac->num_rows() == 0){
                                $i = 1;?>
                                <tr>
                                    <td style="text-align: center">
                                        <?= form_input(array(
                                            'name' => "account[$i]",
                                            id => "account_$i",
                                            'class' => 'account'
                                        )) ?>
                                    </td>
                                    <td style="text-align: left; padding-left: 5px">
                                        <?= form_input(array(
                                            'name' => "code[$i]",
                                            id => "code_$i",
                                            'class' => 'code',
                                        )) ?>
                                    </td>
                                    <td style="text-align: left; padding-left: 5px">
                                        <?= form_input(array(
                                            'name' => "name[$i]",
                                            id => "name_$i",
                                            'class' => 'names',
                                        )) ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 5px">
                                        <?= form_input(array(
                                            'name' => "du_no[$i]",
                                            id => "du_no_$i",
                                            'class' => 'du_no',
                                            'value' => $n->du_no,
                                            onchange => "sum_du_no($i)"
                                        )) ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 5px">
                                        <?= form_input(array(
                                            'name' => "du_co[$i]",
                                            id => "du_co_$i",
                                            'class' => 'du_co',
                                            'value' => $n->du_co,
                                            onchange => "sum_du_co($i)"
                                        )) ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }else{
                                $du_no_total = 0;
                                $du_co_total = 0;
                                foreach ($nguoi_khac->result() as $n){
                                    $i = $n->id; ?>
                                    <tr>
                                        <td>
                                            <?= form_input(array(
                                                'name' => "account[$i]",
                                                id => "account_$i",
                                                'class' => 'account',
                                                'value' => $n->account
                                            )) ?>
                                        </td>
                                        <td>
                                            <?= form_input(array(
                                                'name' => "code[$i]",
                                                id => "code_$i",
                                                'class' => 'code',
                                                'value' => $n->code
                                            )) ?>
                                        </td>
                                        <td>
                                            <?= form_input(array(
                                                'name' => "name[$i]",
                                                id => "name_$i",
                                                'class' => 'names',
                                                'value' => $n->name
                                            )) ?>
                                        </td>
                                        <td>
                                            <?= form_input(array(
                                                'name' => "du_no[$i]",
                                                id => "du_no_$i",
                                                'class' => 'du_no',
                                                'value' => $n->du_no,
                                                onchange => "sum_du_no($i)"
                                            )) ?>
                                        </td>
                                        <td>
                                            <?= form_input(array(
                                                'name' => "du_co[$i]",
                                                id => "du_co_$i",
                                                'class' => 'du_co',
                                                'value' => $n->du_co,
                                                onchange => "sum_du_co($i)"
                                            )) ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    $du_no_total += $n->du_no;
                                    $du_co_total += $n->du_co;
                                }
                            }echo form_input(array(
                                name => count_i,
                                'class' => count_i,
                                type => hidden,
                                value => $i
                            ));?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: 600">Tổng cộng &nbsp</td>
                                <td>
                                <?= form_input(array(
                                    'class' => 'du_no_total',
                                    'value' => number_format($du_no_total)
                                )) ?>
                                </td>
                                <td>
                                <?= form_input(array(
                                    'class' => 'du_co_total',
                                    'value' => number_format($du_co_total)
                                )) ?>
                                </td>
                            </tr>
                        </tfoot>
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
$(document).ready(function(){
    //expand
    var i = $('.count_i').val();
    $('.expand').click(function(){
        $(".flower_table tbody").append(   
            '<tr>'
                +'<td>'
                    +'<input name=account['+i+'] class="account account'+i+'" id=account_'+i+' >'
                +'</td>'
                +'<td>'
                    +'<input name=code['+i+'] class="code code'+i+'" >'
                +'</td>'
                +'<td>'
                    +'<input name=name['+i+'] class="names names'+i+'" >'
                +'</td>'
                +'<td>'
                    +'<input name=du_no['+i+'] class="du_no du_no'+i+'" onchange="sum_du_no('+i+')" >'
                +'</td>'
                +'<td>'
                    +'<input name=du_co['+i+'] class="du_co du_co'+i+'" onchange="sum_du_co('+i+')" >'
                +'</td>'
            +"</tr>"
        );
        i++;
        return false;
    });
});
    
function sum_du_no(id) {
    var sum_cost=0;
    $('.du_no').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_cost += +a;
    });
    $('.du_no_total').val((sum_cost+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
}
function sum_du_co(id) {
    var sum_cost=0;
    $('.du_co').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_cost += +a;
    });
    $('.du_co_total').val((sum_cost+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
}
</script>
<style type="text/css">
.bye{
    border: none;
}    
.expand{
    font-size: 15px
}
.du_no_total, .du_co_total{
    border: none;
    text-align: right;
    padding-right: 8px;
}
.account, .code, .du_no, .du_co{
    text-align: right;
    padding-right: 4px;
    margin: 4px;
    height: 20px;
    width:86%
}  
.names{
    text-align: right;
    padding-right: 4px;
    margin: 4px;
    height: 20px;
    width:95%
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