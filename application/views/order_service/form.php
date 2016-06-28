<!--    --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@
        HAPPY WOMEN'S DAY VIETNAM 20/10/15  
        from Hưng Audi       
                                       
                              /\     /\     /\     /\
                             *==*   *==*   *==*   *==*
                        ____//  \\ //  \\ //  \\ //  \\____           Nhat_Tan_Bridge   
                            
                      ~~~~    ~~~~~~~~    ~~~~~~~~    ~~~~                rEd rIvEr
                       ~~~~     ~~~~~   ~~~~~~      ~~~~~~
-->


<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<?= form_open('costs/save_order_service/'.$var_info->id,array('id'=>'assets_form'));?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend>Thông tin hoá đơn dịch vụ</legend>
<table class="Nhat_Tan_Bridge">
    <tr><td style="width:333px">
    <div class="field_row clearfix">	
    <?php echo form_label('Đối tượng:', ' chungtu_name', array('class'=>required)); ?>
        <div class='form_field'>
        <?php
        if ($var_info->person_id != 0) {
            echo form_input(array(
                'name' => 'person',
                'id' => 'person2',
                placeholder => 'Nhập tên đối tượng ..'
            ));
        } else {
            echo form_input(array(
                'name' => 'person',
                'id' => 'person',
                placeholder => 'Nhập tên đối tượng ..'
            ));
        }?>
        </div>
    </div>
</td><td style="width:333px">
    <div class="field_row clearfix">	
    <?php echo form_label('Ký hiệu hóa đơn:', 'ngay_lap', array('class'=>'')); ?>
        <div class='form_field'>
        <?php echo form_input(array(
            'name'=>'symbol',
            'id'=>'symbol',
            'value'=>$var_info->symbol
        ));?>
        </div>
    </div>
</td></tr>
<tr><td>           
        <table id="person_selected" style="margin-left: -15px">
        <tr>
            <th style="width: 18%">Xóa</th>
            <th>Nhân viên/ Khách hàng/ Nhà cung cấp</th>
        </tr>
        <?php
        if($var_info->person_id != 0){
            if($this->Supplier->exists($var_info->person_id))
                $person_name = $this->Supplier->get_info($var_info->person_id)->company_name;
            elseif($this->Customer->exists($var_info->person_id))    
                $person_name = $this->Customer->get_info($var_info->person_id)->first_name.' '.$this->Customer->get_info($var_info->person_id)->last_name;
            elseif($this->Employee->exists($var_info->person_id))    
                $person_name = $this->Employee->get_info($var_info->person_id)->first_name.' '.$this->Employee->get_info($var_info->person_id)->last_name;
            ?>
            <tr>
                <td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>
                <td><?= $person_name ?></td>
                <input type='hidden' name='person_id' id=person_id value='<?= $var_info->person_id ?>'/>
            </tr>
        <?php
        }?>
    </table><br>
</td><td>
    <div class="field_row clearfix">	
    <?php echo form_label('Số hóa đơn:', 'ngay_lap', array('class'=>'')); ?>
        <div class='form_field'>
        <?php echo form_input(array(
            'name'=>'number',
            'id'=>'number',
            'value'=>$var_info->number
        ));?>
        </div>
    </div>
</td></tr>
<tr><td> 
    <div class="field_row clearfix">	
    <?php echo form_label(lang('common_ngay_lap').':', 'ngay_lap', array('class'=>'')); ?>
        <div class='form_field'>
        <?php echo form_input(array(
            'name'=>'create_date',
            'id'=>'create_date',
            'value'=> $var_info->create_date ? date('d-m-Y', strtotime($var_info->create_date)) : ''
        ));?>
        </div>
    </div>
</td><td>
    <div class="field_row clearfix">	
    <?php echo form_label('Ngày hóa đơn:', 'ngay_lap', array('class'=>'')); ?>
        <div class='form_field'>
        <?php echo form_input(array(
            'name'=>'order_date',
            'id'=>'order_date',
            'value'=> $var_info->order_date ? date('d-m-Y', strtotime($var_info->order_date)) : ''
        ));?>
        </div>
    </div>
</td></tr>
<tr><td>
    <div class="field_row clearfix">	
        <?php echo form_label('Diễn giải:','content_ctu',array('class'=>'wide')); ?>
        <div class='form_field' >
        <?php echo form_textarea(array(
            'name'=>'comment',
            'id'=>'comment',
            'value'=>$var_info->comment,
            'rows'=>'5',
            'cols'=>'22',
            'style'=>'width: 194px'
        ));?>
        </div>
    </div>
    </td><td>
    <div class="field_row clearfix taxi_Vic">	
    <?php echo form_label('Thuế %:', 'ngay_lap', array('class'=>'')); ?>
        <div class='form_field'>
        <?php echo form_input(array(
            name    => tax_percent,
            'class' => tax_percent,
            value   => $var_info->tax_percent
        ));?>
        </div>
    </div>
</td></tr>
</table>  

<div class="field_row clearfix">
    <div class='form_field'  >
        <label style="margin-top: 11px; ">
            <a href="#" class="expand">+ Thêm tài khoản</a>
        </label>    
    </div><br>
    <table class='flower_table'>
        <thead>
            <tr>
                <th style="width: 36%;" class="red_heart">Tài khoản nợ</th>
                <th style="width: 36%" class="red_heart">Tài khoản có</th>
                <th style="width: 20%" class="red_heart">Số tiền</th>
                <th style="width: 8%">Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $chungtu_detail = $this->Cost->get_chungtu_detail_order_service($id);
            if($chungtu_detail->num_rows() == 0){
                $i = 1;?>
                <tr>
                    <td>
                        <select name="tk_no[<?= $i ?>]" class="tk_no tk_no<?= $i ?>">
                            <?php $this->load->view('item_kits/tk_no_list', $data)?>
                        </select>
                    </td>
                    <td>
                        <select name="tk_co[<?= $i ?>]" class="tk_co tk_co<?= $i ?>">
                            <?php $this->load->view('item_kits/tk_co_list', $data)?>
                        </select>
                    </td>
                    <td><?= form_input(array(
                            name => "sotien[$i]",
                            id => "sotien_$i",
                            'class' => "sotien sotien$i",
                            onchange => "calculate_cost($i)"
                        ));?>
                    </td>
                    <td style="width: 25%;">
                        <a href='#' class='del' title="Xóa" onclick='return Xoa_Het_Du_Thien(this);'>X</a>
                    </td>
                </tr>  
                <?php
                $i++;
            }else{
                $money_order = 0;
                foreach ($chungtu_detail->result() as $cd){
                    $i = $cd->id ; ?>
                    <tr>
                        <td><?php $data['tk_no'] = $cd->tk_no ?>
                            <select name="tk_no[<?= $i ?>]" class="tk_no tk_no<?= $i ?>">
                                <?php $this->load->view('item_kits/tk_no_list', $data)?>
                            </select>
                        </td>
                        <td><?php $data['tk_co'] = $cd->tk_co ?>
                            <select name="tk_co[<?= $i ?>]" class="tk_co tk_co<?= $i ?>">
                                <?php $this->load->view('item_kits/tk_co_list', $data)?>
                            </select>
                        </td>
                        <td><?= form_input(array(
                                name => "sotien[$i]",
                                id => "sotien_$i",
                                'class' => "sotien sotien$i",
                                value => number_format($cd->sotien),
                                onchange => "calculate_cost()"
                            ));?>
                        </td>
                        <td style="width: 25%;">
                            <a href='#' class='del' title="Xóa" onclick='return Xoa_Het_Du_Thien(this);'>X</a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    $money_order += $cd->sotien;
                }
            }
            $tax_money = $money_order * $var_info->tax_percent / 100;
            echo form_input(array(
                name => count_i,
                'class' => count_i,
                type => hidden,
                value => $i
            ));?>
        </tbody>
        <tfoot>
            <tr class="right_foot">
                <td colspan="2">Tổng tiền hàng: </td>
                <td><?= 
                    form_input(array(
                        name => money_order,
                        'class' => money_order,
                        readonly => '',
                        value => number_format($money_order)
                    ))?>
                </td>
                <td></td>
            </tr>
            <tr class="right_foot">
                <td colspan="2">Tiền thuế: </td>
                <td><?= 
                    form_input(array(
                        name => tax_money,
                        'class' => tax_money,
                        readonly => '',
                        value => number_format($tax_money)
                    ))?>
                </td>
                <td></td>
            </tr>
            <tr class="right_foot">
                <td colspan="2">Tổng thanh toán: </td>
                <td><?= 
                    form_input(array(
                        name => money_total,
                        'class' => money_total,
                        readonly => '',
                        value => number_format($money_order + $tax_money)
                    ))?>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
<?= form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'style'=>'margin-right: 68px',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right'
))?>
</fieldset>
<?php echo form_close();?>
<script type='text/javascript'>
// at 11h11'15s on 11/11/15
//blur tax_percent
$('.tax_percent').blur(function(){
    var tax_percent = +$('.tax_percent').val().replace(/,/g, "");
    var money_order = +$('.money_order').val().replace(/,/g, "");
    var tax_money = money_order * tax_percent / 100;

    $('.tax_money').val((tax_money+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    $('.money_total').val((money_order + tax_money+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
});

//blur sotien
function calculate_cost() {
    var money_order=0;
    $('.sotien').each(function () {
        money_order += +$(this).val().replace(/,/g, "");
    });
    $('.money_order').val((money_order+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
    
    var tax_percent = +$('.tax_percent').val().replace(/,/g, "");
    var tax_money = money_order * tax_percent / 100;
    $('.tax_money').val((tax_money+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    
    var money_total = money_order + tax_money;
    $('.money_total').val((money_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
}

$(document).ready(function(){
    $('.submit_button').click(function(){
        var arr_tk_no = [];
        var arr_tk_co = [];
        var arr_sotien = [];
        $(".flower_table").find('.sotien').each(function (index, element) {
            var i = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);  
            if ( ! $(".tk_no" + i).val()) {
                arr_tk_no.push(i);
            }
            if ( ! $(".tk_co" + i).val()) {
                arr_tk_co.push(i);
            }
            if ( ! $(".sotien" + i).val() || $(".sotien" + i).val() == 0) {
                arr_sotien.push(i);
            }
        });
        if (arr_tk_no.length > 0) {
            alert("Bạn chưa chọn tài khoản nợ !");
            return false;
        }
        if (arr_tk_co.length > 0) {
            alert("Bạn chưa chọn tài khoản có !");
            return false;
        }
        if (arr_sotien.length > 0) {
            alert("Bạn chưa chọn số tiền !");
            return false;
        }
    });
    
    //expand
    var i = $('.count_i').val();
    $('.expand').click(function(){
        $(".flower_table tbody").append(   
            '<tr>'
                +'<td>'
                    +'<select name=tk_no['+i+'] class="tk_no tk_no'+i+'" >'
                    +'</select>'
                +'</td>'
                +'<td>'
                    +'<select name=tk_co['+i+'] class="tk_co tk_co'+i+'" >'
                    +'</select>'
                +'</td>'
                +'<td>'
                    +'<input name=sotien['+i+'] class="sotien sotien'+i+'" id=sotien_'+i+' onchange="calculate_cost('+i+')" >'
                +'</td>'
                + '<td>'
                    + '<a href=# class=del title="Xóa" onclick="return Xoa_Het_Du_Thien(this);">X</a></td>'
            +"</tr>"
        );
        $('.tk_no'+i).load("<?php echo site_url().'/item_kits/tk_no_list_full' ?>");
        $('.tk_co'+i).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");
        i++;
        return false;
    });
	$('#create_date').datePicker({startDate: '01-01-1950'});
	$('#order_date').datePicker({startDate: '01-01-1950'});
    setTimeout(function(){$(":input:visible:first","#customer_type_form").focus();},100);
	var submitting = false;
	
	$('#assets_form').validate({
		submitHandler:function(form)
		{
			//alert(0);
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{
				submitting = false;
				tb_remove();
				post_type_cus_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: {
            person:{
                required: function () {
                    return $("#person_id").val() ? false : true;
                }
            }
   		},
		messages: {
     		person: "Bạn cần nhập Đối tượng",
		}
	});
});
function Xoa_Het_Du_Thien(link) {
    $(link).parent().parent().remove();
    calculate_cost();
    return false;
}
function deleteCostSupplierRow(link){
    $("#person").removeClass("disable_input_cost");
    $("#person2").removeClass("disable_input_cost");
    $(link).parent().parent().remove();
    return false;
}
$("#person").autocomplete({
    source: '<?php echo site_url("chungtus/person_search_cost"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui) {
        $("#person").val("");
        if ($("#person_selected" + ui.item.value).length == 1){
            $("#person_selected" + ui.item.value).val(parseFloat($("#person_selected" + ui.item.value).val()) + 1);
        } else {
            $("#person").addClass("disable_input_cost");
            $("#person_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<input  type='hidden' size='3' name='person_id' id=person_id value='" + ui.item.value + "'/>"
                +"</tr>"
            );
        }
        return false;
    }
});
$("#person2").autocomplete({
    source: '<?php echo site_url("chungtus/person_search_cost"); ?>',
    delay: 10,
    autoFocus: false,
    minLength: 0,
    select: function (event, ui) {
        $("#person2").val("");
        if ($("#person_selected" + ui.item.value).length == 1){
            $("#person_selected" + ui.item.value).val(parseFloat($("#person_selected" + ui.item.value).val()) + 1);
        } else {
            $("#person2").addClass("disable_input_cost");
            $("#person_selected").append(
                "<tr class=tr_bold >"
                    +"<td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>"
                    +"<td>" + ui.item.label + "</td>"
                    +"<input  type='hidden' size='3' name='person_id' id=person_id value='" + ui.item.value + "'/>"
                +"</tr>"
            );
        }
        return false;
    }
});
$("#person2").addClass("disable_input_cost");
</script>
<style type="text/css">
.money_order, .tax_money, .money_total{
    border: none;
    text-align: right
}    
.right_foot{
    text-align: right;
    font-size: 12px;
}    
.right_foot td:first-child{
    padding-right: 13px
} 
.right_foot td:nth-child(2){
    padding-right: 4px
}

.taxi_Vic{
    margin-top: -51px!important
}
.flower_table {
    text-align: center
}
.flower_table tr{
    height: 35px
}
.red_heart{
    color: red; font-size: 12px
}
.flower_table .tk_no, .flower_table .tk_co, .sotien{
    width: 90%
}
.sotien{
    height: 24px;
    padding: 0px 5px;
    text-align: right
}
.disable_input_cost {
    display: none;
}
.td_center, #person_selected tr th{
    text-align: center
}
#person_selected{
    width: 100%;
    margin-left: 20px
}
</style>