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
                    <td id="title" >Công nợ nhà cung cấp</td>
                    <td style="text-align: right; padding-right: 10px;">
                        <a id="a_return" style="font-size:18px;text-decoration: underline; color: #FFFFFF" 
                           href="<?php echo site_url() ?>tkdus/begin_balance">Trở lại</a>
                    </td>
                </tr>
            </table>
            <div id="tab1" class="tab_content">
                <?= form_open_multipart('tkdus/save_cong_no_ncc'); ?>   
                <fieldset class="bye">
                    <div class='form_field Tet_Den_Roi'  >
                        <label style="margin-top: 11px; ">
                            <a href="#" class="expand">+ Thêm công nợ</a>
                        </label>   
                        <label style="margin-top: 11px; margin-left: 282px">
                            Chọn năm: <?= form_dropdown('oh_year', $oh_year_list, $happy_new_year, 'class=oh_year')
                           ?>
                        </label>
                    </div>
                    <table id="inventory_sale8" class="append_table1 flower_table">
                        <thead style="font-weight: 600">
                            <tr class="title_font">
                                <td style="width: 8%;text-align: center" rowspan="2">Số tài khoản</td>
                                <td style="width: 58%;text-align: center" colspan="2">Nhà cung cấp</td>
                                <td style="width: 14%;text-align: center" rowspan="2">Dư nợ</td>
                                <td style="width: 14%; text-align: center" rowspan="2">Dư có</td>
                                <td style="text-align: center" rowspan="2">Xoá</td>
                            </tr>
                            <tr style="">
                                <td style="width: 15%">Mã nhà cung cấp</td>
                                <td>Tên nhà cung cấp</td>
                            </tr>
                        </thead>
                        <tbody class="tbody_append">
                            <?php
                            if($suppliers->num_rows() == 0){
                                $i = 1;?>
                                <tr>
                                    <td style="width: 9%; text-align: center">331</td>
                                    <td style="width: 59%; text-align: left;" colspan="2">
                                        <?= form_input(array(
                                            'name' => "ncc_search[$i]",
                                            'class' => "ncc_search ncc$i",
                                            placeholder => 'Nhập tên nhà cung cấp ..',
                                        ))?>
                                        <input type=hidden name=person_id[<?= $i ?>] 
                                            value='' class=person_id<?= $i ?> >
                                        <table class="ncc_selected<?= $i ?>">
                                        </table>
                                    </td>
                                    <td style="width: 14%; text-align: right; padding-right: 5px">
                                        <?= form_input(array(
                                            'name' => "du_no[$i]",
                                            id => "du_no_$i",
                                            'class' => 'du_no',
                                            onchange => "sum_du_no($i)"
                                        )) ?>
                                    </td>
                                    <td style="width: 14%; text-align: right; padding-right: 5px">
                                        <?= form_input(array(
                                            'name' => "du_co[$i]",
                                            id => "du_co_$i",
                                            'class' => 'du_co',
                                            onchange => "sum_du_co($i)"
                                        )) ?>
                                    </td>
                                    <td style="width: 4%">
                                        <a href=# onclick="return Xoa_Ten_Em(this, <?= $i ?>)" title=Xóa >X</a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }else{
                                $du_no_total = 0;
                                $du_co_total = 0;
                                foreach ($suppliers->result() as $s){
                                    $i = $s->id; 
                                    $info_ncc = $this->Supplier->get_info($s->person_id);
                                    ?>
                                    <tr>
                                        <td style="width: 9%; text-align: center">331</td>
                                        <td style="width: 59%; text-align: left;" colspan="2">
                                            <?= form_input(array(
                                                'name' => "ncc_search[$i]",
                                                'class' => "ncc_search ncc$i",
                                                placeholder => 'Nhập tên nhà cung cấp ..',
                                            ))?>
                                            <table class="ncc_selected<?= $i ?>">
                                                <tr class=tr_bold >
                                                    <td style="border:none; width: 25%; text-align: left; padding-left: 5px">
                                                        <input type=hidden name=person_id[<?= $i ?>] 
                                                               value='<?= $s->person_id ?>' 
                                                               class="person_id<?= $s->person_id ?> person_id<?= $i ?>" >
                                                        <?= $info_ncc->account_number ?> 
                                                    </td>
                                                    <td style="border:none; width: 68%; text-align: left; padding-left: 5px">
                                                        <?= $info_ncc->company_name ?> 
                                                    </td>
                                                    <td style="border:none; padding-right:10px" >
                                                        <a href=# onclick="return Xoa_Het_Du_Thien(this, <?= $i ?>)" title=Xóa >X</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="width: 14%">
                                            <?= form_input(array(
                                                'name' => "du_no[$i]",
                                                id => "du_no_$i",
                                                'class' => "du_no du_no$i",
                                                'value' => $s->du_no,
                                                onchange => "sum_du_no($i)"
                                            )) ?>
                                        </td>
                                        <td style="width: 14%">
                                            <?= form_input(array(
                                                'name' => "du_co[$i]",
                                                id => "du_co_$i",
                                                'class' => 'du_co',
                                                'value' => $s->du_co,
                                                onchange => "sum_du_co($i)"
                                            )) ?>
                                        </td>
                                        <td style="width: 4%; " >
                                            <a href=# onclick="return Xoa_Ten_Em(this, <?= $i ?>)" title=Xóa >X</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    $du_no_total += $s->du_no;
                                    $du_co_total += $s->du_co;
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
                                <td></td>
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
var i = 1;
auto_search(i);    
function auto_search(i){
    $('.ncc'+i).autocomplete({
        source: '<?= site_url('sales/supplier_search_cost'); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $('.ncc'+i).val('');
            if ($('.person_id'+ ui.item.value).length == 1){  
                alert('Nhà cung cấp này bạn đã chọn rồi !');
            }else{
                $('.ncc'+i).hide();
                $('.ncc_selected'+i).append(
                    '<tr class=tr_bold >'
                        +'<td style="border:none; width: 25%; text-align: left; padding-left: 5px">'
                            +'<input type=hidden name=person_id['+i+'] value='+ui.item.value+' class="person_id'+ui.item.value+' person_id'+i+'" >' 
                            + ui.item.account_number 
                        + '</td>'
                        +'<td style="border:none; width: 68%; text-align: left; padding-left: 5px">' 
                            + ui.item.label 
                        + '</td>'
                        +'<td style="border:none; padding-right:10px" >\n\
                            <a href=# onclick="return Xoa_Het_Du_Thien(this, '+i+')" title=Xóa >X</a></td>'
                    +'</tr>'
                );
            }
            return false;
        }
    });
}    
function append(i){
    $('.expand').click(function(){
        $('.flower_table tbody.tbody_append').append(   
            '<tr>'
                +'<td style="width: 9%">331</td>'
                +'<td style="width: 59%; text-align: left;" colspan="2">'
                    +'<input name=ncc_search['+i+'] \n\
                        class="ncc_search ncc'+i+'" \n\
                        placeholder="Nhập tên nhà cung cấp .." >'
                    +'<table class=ncc_selected'+i+' >'
                    +'</table>'
                +'</td>'
                +'<td style="width: 14%">'
                    +'<input name=du_no['+i+'] class="du_no du_no'+i+'" onchange="sum_du_no('+i+')" >'
                +'</td>'
                +'<td style="width: 14%">'
                    +'<input name=du_co['+i+'] class="du_co du_co'+i+'" onchange="sum_du_co('+i+')" >'
                +'</td>'
                +'<td style="width: 4%">'
                    +'<a href=# onclick="return Xoa_Ten_Em(this, '+i+')" title=Xóa >X</a>'
                +'</td>'
            +'</tr>'
        );
        auto_search(i);
        i++;
        return false;
    });
}
function Xoa_Ten_Em(link, i){
    $(link).parent().parent().remove();
    return false;
}
function Xoa_Het_Du_Thien(link, i){
    $('.ncc'+i).show();
    $(link).parent().parent().remove();
    return false;
}
$(document).ready(function(){
    $(".flower_table").find('.du_no').each(function (index, element) {
        var i = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
        if($('.person_id'+i).val() == ''){
            $('.ncc'+i).show();
        }else{
            $('.ncc'+i).hide();            
        }
        auto_search(i);
    });
    var i = $('.count_i').val();
    append(i);
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
.oh_year{
    font-family: Arial,Helvetica,sans-serif;
    height: 22px;
    margin-top: -5px;
    width: 60px;
}    
.bye, .account_number{
    border: none;
}    
.Tet_Den_Roi{
    font-size: 15px
}
.disable_input_cost {
    display: none;
}
.ncc_search{
    margin-left: 135px;
    padding-left: 4px;
    height: 20px;
    width:40%
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
</style>
<?php $this->load->view("partial/footer"); ?>