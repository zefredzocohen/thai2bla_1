<!--    --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@
        HAPPY WOMEN'S DAY VIETNAM 20/10/15  
        from Hưng Audi 
-->
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<?= form_open('chungtus/save/'.$var_info->id,array('id'=>'assets_form'));?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
<legend>Thông tin chứng từ</legend>
<div class="field_row clearfix">	
<?php echo form_label('Đối tượng:', ' chungtu_name', array('class'=>required)); ?>
	<div class='form_field'>
	<?php
    if ($var_info->name != 0) {
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
<table id="person_selected">
    <tr>
        <th style="width: 18%">Xóa</th>
        <th>Nhân viên/ Khách hàng/ Nhà cung cấp</th>
    </tr>
    <?php
    if($var_info->name != 0){
        if($this->Supplier->exists($var_info->name))
            $person_name = $this->Supplier->get_info($var_info->name)->company_name;
        elseif($this->Customer->exists($var_info->name))    
            $person_name = $this->Customer->get_info($var_info->name)->first_name.' '.$this->Customer->get_info($var_info->name)->last_name;
        elseif($this->Employee->exists($var_info->name))    
            $person_name = $this->Employee->get_info($var_info->name)->first_name.' '.$this->Employee->get_info($var_info->name)->last_name;
        ?>
        <tr>
            <td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>
            <td><?= $person_name ?></td>
            <input type='hidden' name='person_id' id=person_id value='<?= $var_info->name ?>'/>
        </tr>
    <?php
    }?>
</table><br>
<div class="field_row clearfix">	
<?php echo form_label(lang('common_ngay_lap').':', 'ngay_lap', array('class'=>'')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'ngay_lap',
		'id'=>'ngay_lap',
		'value'=>$var_info->create_date
    ));?>
	</div>
</div> 
<div class="field_row clearfix">	
	<?php echo form_label('Diễn giải:','content_ctu',array('class'=>'wide')); ?>
	<div class='form_field' >
	<?php echo form_textarea(array(
		'name'=>'content_ctu',
		'id'=>'content_ctu',
		'value'=>$var_info->noidung,
		'rows'=>'5',
		'cols'=>'17')
	);?>
	</div>
</div>
<div class="field_row clearfix" style="margin-bottom: 20px">
    <div class='form_field'  >
        <label style="margin-top: 11px; ">
            <a href="#" class="expand">+ Thêm tài khoản</a>
        </label>    
    </div><br>
    <table class='flower_table'>
        <tr>
            <th style="width: 36%;" class="red_heart">Tài khoản nợ</th>
            <th style="width: 36%" class="red_heart">Tài khoản có</th>
            <th style="width: 20%" class="red_heart">Số tiền</th>
            <th style="width: 8%">Xóa</th>
        </tr>
        <?php
        $chungtu_detail = $this->Chungtu->get_chungtu_detail($chungtu_id);
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
                        'class' => "sotien sotien$i"
                    ));?>
                </td>
                <td style="width: 25%;">
                    <a href='#' class='del' title="Xóa" onclick='return Xoa_Het_Du_Thien(this);'>X</a>
                </td>
            </tr>  
            <?php
            $i++;
        }else{
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
                            value => number_format($cd->sotien)
                        ));?>
                    </td>
                    <td style="width: 25%;">
                        <a href='#' class='del' title="Xóa" onclick='return Xoa_Het_Du_Thien(this);'>X</a>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        echo form_input(array(
            name => count_i,
            'class' => count_i,
            type => hidden,
            value => $i
        ));?>
    </table>
</div>

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'style'=>'margin-right: 262px',
	'value'=>lang('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
<?php echo form_close();?>
<script type='text/javascript'>
$('.sotien').maskMoney();
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
        $(".flower_table").append(   
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
                    +'<input name=sotien['+i+'] class="sotien sotien'+i+'" id=sotien_'+i+' >'
                +'</td>'
                + '<td>'
                    + '<a href=# class=del title="Xóa" onclick="return Xoa_Het_Du_Thien(this);">X</a></td>'
            +"</tr>"
        );
        $('.tk_no'+i).load("<?php echo site_url().'/item_kits/tk_no_list_full' ?>");
        $('.tk_co'+i).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");
        i++;
        $('.sotien').maskMoney();
        return false;
    });
	$('#date_tang').datePicker({startDate: '01-01-1950'});
	$('#ngay_lap').datePicker({startDate: '01-01-1950'});
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
.flower_table {
    text-align: center
}
.flower_table tr{
    height: 35px
}
.flower_table .red_heart{
    color: red; font-size: 13px
}
.flower_table .tk_no, .flower_table .tk_co, .flower_table .sotien{
    width: 90%
}
.flower_table .sotien{
    height: 24px;
    padding: 0px 3px;
}
.disable_input_cost {
    display: none;
}
.td_center, #person_selected tr th{
    text-align: center
}
#person_selected{
    width: 60%;
    margin-left: 20px
}
</style>