<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/add_textbox/bootstrap.js"></script>
<link href="<?php echo base_url(); ?>js/add_textbox/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />

<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<ul> Chú ý : tên công thức không được trùng nhau! </ul>
<?php
echo form_open('profit/update_1/'.$person_info->id,array('id'=>'employee_form'));
?>
<fieldset id="item_kit_info">
<legend><?php echo lang("profit_input_info"); ?></legend>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_formula').':', 'first_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'first_name',
		'value'=>$person_info->formula_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('common_input1').':', 'item',array('class'=>'required')); ?>
	<div class='form_field'>
		<?php echo form_input(array(
			'name'=>'item',
			'id'=>'item'
		));?>
	</div>
</div>

<table id="item_kit_items">
	<tr>
		<th><?php echo lang('common_delete');?></th>
		<th><?php echo lang('item_kits_item');?></th>
		<th><?php echo lang('item_kits_quantity');?></th>
	</tr>
	<tr>
	   <td><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
	   <td><?php echo $person_info->name; ?></td>
	   <td><input class='quantity' onchange="calculateSuggestedPrices();" id='item_kit_item_<?php echo $item_kit_item->item_id ?>' type='text' size='3' name=item_kit_item[<?php echo $item_kit_item->item_id ?>] value='1'/></td>
	</tr>
</table>

 <?php //$a1 = '1,234' ?>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input2').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_price',
		'id'=>'input_price',
		'value'=>number_format($person_info->fixed_costs),
	));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input8').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_transport',
		'id'=>'input_transport',
		'value'=>number_format($person_info->transport)
	));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input3').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_tax',
		'id'=>'input_tax',
		'value'=>$person_info->tax));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input14').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'advertising_costs',
		'id'=>'advertising_costs',
		'value'=>number_format($person_info->advertising_costs)
	));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input15').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'customer_care',
		'id'=>'customer_care',
		'value'=>number_format($person_info->customer_care)
	));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_input16').' %:', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'commission',
		'id'=>'commission',
		'value'=>number_format($person_info->commission)
	));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_input4').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'profit_price',
		'id'=>'profit_price',
		'value'=>round($person_info->other_costs,3)));?>
	</div>
</div>

<div class="field_row clearfix">
<?php echo form_label(lang('common_input9').':', 'item',array('class'=>'wide')); ?>
	<div class='form_field'>
		<?php echo form_input(array(
			'name'=>'item1',
			'id'=>'item1'
		));?>
	</div>
</div>

<table id="item_kit_items1">
	<tr>
		<th style="text-align: center;"><?php echo lang('common_delete');?></th>
		<th style="text-align: center;"><?php echo lang('common_input10');?></th>
		<th style="text-align: center;"><?php echo lang('common_input11');?></th>
        <th style="text-align: center;"><?php echo lang('common_input13');?></th>
        <th style="text-align: center;"><?php echo lang('common_input12');?></th>
	</tr>
	
	<?php
    $i=100;
     foreach ($profit_info2 as $key=>$profit_info222) {?>
		<tr>
			<td style="padding-left: 20px"><a href="#" onclick='return deleteItemKitRow(this);'>X</a></td>
            <td style="padding-left: 100px"><input type='text' name='empl_name[]'  value='<?php echo $profit_info222['name_empl']; ?>' Readonly='' /></td>
            <td>
            <?php
            $selected='';
            $selected1='';
            if($profit_info222['day_hour']=='day_day') $selected= "selected='selected'";
            if($profit_info222['day_hour']=='hour') $selected1= "selected='selected'";
            ?>
             <select name="day_hour[]" style="margin-left: 40px" id='myselect<?php echo $i; ?>'  onclick='ooption(<?php echo $i; ?>)' onchange='calculate(<?php echo $i; ?>)' >
                <option value="day_day" <?php echo $selected; ?>> Ngày </option>
                <option value="hour"   <?php echo $selected1; ?>> Giờ </option>
              </select>
            </td>
		    <td style="padding-left: 50px"><input class='quantity' onkeyup='calculate(<?php echo $i; ?>)'  id='item_kit_item_<?php echo $i; ?>' type='text' size='3' name='day_hour_num[]' value="<?php echo $profit_info222['day_hour_number']; ?>" /></td>
            <td style="padding-left: 80px"><input type='text' name='geofeld[]' id='geofeld<?php echo $i; ?>' class="geofeld" value="<?php echo str_replace('.00000', '', $profit_info222['salary_empl']); ?>" /></td>
            <td><input type='hidden' id='geofeld111<?php echo $i; ?>' value="<?php echo $profit_info222['salary_empl']; ?>" /></td>
		</tr>
	<?php $i++;} ?>
</table>

<h4>Thêm các chi phí khác </h4>
<div class="control-group" style="margin: 10px;">
	<div class="inc">
        <div class="controls">
	       <input type="text" id="textfield" name="textfield[]" value="chi phí thêm"/>&nbsp;<input type="text" id="textbox1" name="textfield1[]" value="" />&nbsp;<button class="btn btn-info" type="submit" id="append" name="append">Thêm</button>
	       <br/>
	   </div>
   	<?php
     $j=100;
     foreach ($profit_info1 as $key=>$profit_info111) {?>
     <div class='controls'><input type='text' name='textfield[]'  value="<?php echo $profit_info111['cost_name']; ?>" />&nbsp;<input type='text' id='textbox1<?php echo $j; ?>' name='textfield1[]' value="<?php echo $profit_info111['price2']; ?>"  />&nbsp;<a href='#' class='remove_this btn btn-danger'>Xóa</a><br/></div>  
	<?php $j++;} ?>
    </div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input17').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
        <input type="text" name="chi_phi" id="chi_phi" value="<?php echo number_format($this->config->item('meals'))?>" /><span> VND</span>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input5').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
        <input type="text" name="result" id="xuan_bac" value="<?php echo to_currency_unVND($person_info->price); ?>" /><span> VND</span>
	</div>
</div>

<input type="hidden" name="flag" id="flag" value="<?php echo $person_info->flag; ?>" />

<table style="width: 260px"><tr><td>
<b> Giá bán của một sản phẩm là:</b>
</td><td id="xuan_bac1"><?php echo to_currency_unVND($person_info->price); ?> 
</td></tr></table>
<br>
<div  style="float: left;    line-height: 20px;    margin-left: 200px;">
    <span class="myButton" onclick="profit_price1()"> Tính Toán</span>
<?php
echo form_submit(array(
	'value'=>lang('profit_submit'),
	//'class'=>'submit_button float_right')
    'class'=>'btn btn-info',
    'style'=>'margin-top:-3px !important')
);
?>
</div>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>

	$('#input_price').maskMoney();
	$('#input_transport').maskMoney();
	$('#advertising_costs').maskMoney();
	$('#customer_care').maskMoney();
	//$('#textbox1').maskMoney();
	$('.salary222').maskMoney();
	$('.textfield1').maskMoney();
	$('#chi_phi').maskMoney();	
	$('#xuan_bac').maskMoney();


$( "#item" ).autocomplete({
	source: '<?php echo site_url("items/item_search"); ?>',
	delay: 10,
	autoFocus: false,
	minLength: 0,
	select: function( event, ui ) 
	{	
		$( "#item" ).val("");
		if ($("#item_kit_item_"+ui.item.value).length ==1)
		{
			$("#item_kit_item_"+ui.item.value).val(parseFloat($("#item_kit_item_"+ui.item.value).val()) + 1);
		}
		else
		{
			$("#item_kit_items").append("<tr><td><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td><td><input type='text' name='product_name' value='"+ui.item.label+"' /></td><td><input class='quantity' onchange='calculateSuggestedPrices();' id='item_kit_item_"+ui.item.value+"' type='text' size='3' name=item_kit_item["+ui.item.value+"] value='1'/></td></tr>");
		}
		
		calculateSuggestedPrices();
		
		return false;
	}
});
   var counter=1;
$( "#item1" ).autocomplete({
	source: '<?php echo site_url("employees/suggest"); ?>',
	delay: 10,
	autoFocus: false,
	minLength: 0,
	select: function( event, ui ) 
	{	
		$( "#item1" ).val("");
		if ($("#item_kit_item_"+ui.item.value).length ==1)
		{
			$("#item_kit_item_"+ui.item.value).val(parseFloat($("#item_kit_item_"+ui.item.value).val()) + 1);
		}
		else
		{   
            $("#item_kit_items1").append("<tr><td><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td><td><input type='text' name='empl_name[]'  value='"+ui.item.label+"' Readonly='' /></td><td><select name='day_hour[]'  id='myselect"+counter+"'  onclick='ooption("+counter+")' ><option value='day_day' selected='selected'>Ngày</option><option value='hour'>Giờ</option></select></td><td><input class='quantity' onkeyup='calculate("+counter+")'  id='item_kit_item_"+counter+"' type='text' size='3' name='day_hour_num[]' value='30'/></td><td><input type='text' name='geofeld[]' id='geofeld"+counter+"' value='"+ui.item.salary+"'/></td><td><input type='hidden' id='geofeld111"+counter+"' value='"+ui.item.salary+"'/></td></tr>");
            counter++;
            alert(counter);
        }
		
		calculateSuggestedPrices();
		
		return false;
	}
});

//validation and submit handling
$(document).ready(function()
{
    setTimeout(function(){$(":input:visible:first","#employee_form").focus();},100);
	$( "#category" ).autocomplete({
		source: "<?php echo site_url('items/suggest_category');?>",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});
	var submitting = false;
	$('#employee_form').validate({
		submitHandler:function(form)
		{
			if (submitting) return;
			submitting = true;
			$(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
			$(form).ajaxSubmit({
			success:function(response)
			{
				submitting = false;
				tb_remove();
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules:
		{
			last_name:
			{
				required:true,
				remote: 
			    { 
					url: "<?php echo site_url('profit/checkname/'.$person_info->id);?>", 
					type: "post"
				}
			},
			category:"required",
			unit_price: "number",
			cost_price: "number"
		},
		messages:
		{
			last_name:{
	 	    	required: 'Vui lòng nhập tên công thức',
	 	    	remote: 'Tên đã tồn tại, vui lòng chọn tên khác'    	
	 	    },
			category:<?php echo json_encode(lang('items_category_required')); ?>,
			unit_price: <?php echo json_encode(lang('items_unit_price_number')); ?>,
			cost_price: <?php echo json_encode(lang('items_cost_price_number')); ?>
		}
	});
});

function deleteItemKitRow(link)
{
	$(link).parent().parent().remove();
	calculateSuggestedPrices();
	return false;
}

function calculateSuggestedPrices()
{
	var items = [];
	$("#item_kit_items").find('input').each(function(index, element)
	{
		var quantity = parseFloat($(element).val());
		var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
		
		items.push({
			item_id: item_id,
			quantity: quantity
		});
	});
	calculateSuggestedPrices.totalCostOfItems = 0;
	calculateSuggestedPrices.totalPriceOfItems = 0;
	getPrices(items, 0);
}

function getPrices(items, index)
{
	if (index > items.length -1)
	{
		$("#unit_price").val(calculateSuggestedPrices.totalPriceOfItems);
		$("#cost_price").val(calculateSuggestedPrices.totalCostOfItems);
	}
	else
	{
		$.get('<?php echo site_url("items/get_info");?>'+'/'+items[index]['item_id'], {}, function(item_info)
		{
			calculateSuggestedPrices.totalPriceOfItems+=items[index]['quantity'] * parseFloat(item_info.unit_price);
			calculateSuggestedPrices.totalCostOfItems+=items[index]['quantity'] * parseFloat(item_info.cost_price);
			getPrices(items, index+1);
		}, 'json');
	}
}
</script>

<script type="text/javascript">
jQuery(document).ready( function () {
var demfield=2;
$("#append").click( function() {
		$(".inc").append("<div class='controls'><input type='text' name='textfield[]'  value='chi phí thêm' /> <input type='text' id='textbox1"+demfield+"' name='textfield1[]' value='' /><a href='#' class='remove_this btn btn-danger'>Xóa</a><br><br></div>");
		demfield++;
        return false;
	});
	
jQuery('.remove_this').live('click', function() {
    jQuery(this).parent().remove();
    return false;
});
	
	});

function myFunction()
{
    //onkeyup="myFunction()";
    var x=document.getElementById("item_kit_item_2");
    //x.value=x.value.toUpperCase();
    document.getElementById("geofeld2").setAttribute("value",x.value);
}

function calculate(aaa)
{
    //onkeyup="myFunction()";
    var x=document.getElementById("item_kit_item_"+aaa);
    //x.value=x.value.toUpperCase();
    //document.getElementById("geofeld"+aaa).setAttribute("value",x.value);
    var yyy=ooption(aaa);
    //alert(yyy);
    //alert(x.value);
    if(yyy=='day_day')
    {
        var xx=document.getElementById("geofeld111"+aaa).value;
        var xxyy=(x.value)*(xx/30);
        //alert(xxyy);
        document.getElementById("geofeld"+aaa).setAttribute("value",xxyy);
    }
    else
    {
        var yy=document.getElementById("geofeld111"+aaa).value;
        var yy=(x.value)*(yy/240);
        document.getElementById("geofeld"+aaa).setAttribute("value",yy);
    }
}

function ooption(bbb)
{
   //var xxx=document.getElementById("myselect").options[1].value;
   //alert(xxx);
   var e = document.getElementById("myselect"+bbb);
   var strUser = e.options[e.selectedIndex].value;
   return strUser;
}

tong_chi_phi=0;
tong_chi_phi1=0;
tong_chi_phi2=0;

kq=0;
kq_profit=0;

function profit_price1()
{
    var abc0=0;
    var abc1=0;
    var abc2=0;
    var abc3=0;
    var abc4=0;
    var abc5=0;
    var abc6=0;
    var abc7=0;
    var abc8=0;
    var abc9=0;
    
    var abc10=0;
    var abc11=0;
    var abc12=0;
    var abc13=0;
    var abc14=0;
    var abc15=0;
    var abc16=0;
    var abc17=0;
    var abc18=0;
    var abc19=0;
    var abc20=0;
    
    var abc30=0;
    var abc31=0;
    var abc32=0;
    var abc33=0;
    var abc34=0;
    var abc35=0;
    var abc36=0;
    var abc37=0;
    var abc38=0;
    var abc39=0;
    var abc40=0;
    
    var abc50=0;
    var abc51=0;
    var abc52=0;
    var abc53=0;
    var abc54=0;
    var abc55=0;
    var abc56=0;
    var abc57=0;
    var abc58=0;
    var abc59=0;
    
    var flag=1;
    
    if(document.getElementById('geofeld1'))
    { 
        abc0=document.getElementById('geofeld1').value*1;
    }
    
    if(document.getElementById('geofeld2'))
    { 
        abc1=document.getElementById('geofeld2').value*1;
    
    }
    
    if(document.getElementById('geofeld3'))
    { 
        abc3=document.getElementById('geofeld3').value*1;
    
    }
    
    if(document.getElementById('geofeld4'))
    { 
        abc4=document.getElementById('geofeld4').value*1;
    
    }
    
    if(document.getElementById('geofeld5'))
    { 
        abc5=document.getElementById('geofeld5').value*1;
    
    }
    
    if(document.getElementById('geofeld6'))
    { 
        abc6=document.getElementById('geofeld6').value*1;
    
    }
    
    if(document.getElementById('geofeld7'))
    { 
        abc7=document.getElementById('geofeld7').value*1;
    
    }
    
    if(document.getElementById('geofeld8'))
    { 
        abc8=document.getElementById('geofeld8').value*1;
    
    }
    
    if(document.getElementById('geofeld9'))
    { 
        abc9=document.getElementById('geofeld9').value*1;
    }
    
    if(document.getElementById('geofeld100'))
    { 
        abc30=document.getElementById('geofeld100').value*1;
    }
    
    if(document.getElementById('geofeld101'))
    { 
        abc31=document.getElementById('geofeld101').value*1;
    
    }
    
    if(document.getElementById('geofeld102'))
    { 
        abc32=document.getElementById('geofeld102').value*1;
    
    }
    
    if(document.getElementById('geofeld103'))
    { 
        abc33=document.getElementById('geofeld103').value*1;
    
    }
    
    if(document.getElementById('geofeld104'))
    { 
        abc34=document.getElementById('geofeld104').value*1;
    
    }
    
    if(document.getElementById('geofeld105'))
    { 
        abc35=document.getElementById('geofeld105').value*1;
    
    }
    
    if(document.getElementById('geofeld106'))
    { 
        abc36=document.getElementById('geofeld106').value*1;
    
    }
    
    if(document.getElementById('geofeld107'))
    { 
        abc37=document.getElementById('geofeld107').value*1;
    
    }
    
    if(document.getElementById('geofeld108'))
    { 
        abc38=document.getElementById('geofeld108').value*1;
    
    }
    
    if(document.getElementById('geofeld109'))
    { 
        abc39=document.getElementById('geofeld109').value*1;
    }
    
    if(document.getElementById('textbox1'))
    { 
        abc11=document.getElementById('textbox1').value*1;
    }
    
    if(document.getElementById('textbox12'))
    { 
        abc12=document.getElementById('textbox12').value*1;
    }
    
    if(document.getElementById('textbox13'))
    { 
        abc13=document.getElementById('textbox13').value*1;
    }
    
    if(document.getElementById('textbox14'))
    { 
        abc14=document.getElementById('textbox14').value*1;
    }
    
    if(document.getElementById('textbox15'))
    { 
        abc15=document.getElementById('textbox15').value*1;
    }
    
     if(document.getElementById('textbox16'))
    { 
        abc16=document.getElementById('textbox16').value*1;
    }
    
    if(document.getElementById('textbox17'))
    { 
        abc17=document.getElementById('textbox17').value*1;
    }
    
    if(document.getElementById('textbox18'))
    { 
        abc18=document.getElementById('textbox18').value*1;
    }
    
    if(document.getElementById('textbox19'))
    { 
        abc19=document.getElementById('textbox19').value*1;
    }
    
    if(document.getElementById('textbox110'))
    { 
        abc20=document.getElementById('textbox110').value*1;
    }
    
    
    if(document.getElementById('textbox1100'))
    { 
        abc40=document.getElementById('textbox1100').value*1;
    }
    
    if(document.getElementById('textbox1101'))
    { 
        abc51=document.getElementById('textbox1101').value*1;
    }
    
    if(document.getElementById('textbox1102'))
    { 
        abc52=document.getElementById('textbox1102').value*1;
    }
    
    if(document.getElementById('textbox1103'))
    { 
        abc53=document.getElementById('textbox1103').value*1;
    }
    
    if(document.getElementById('textbox1104'))
    { 
        abc54=document.getElementById('textbox1104').value*1;
    }
    
     if(document.getElementById('textbox1105'))
    { 
        abc55=document.getElementById('textbox1105').value*1;
    }
    
    if(document.getElementById('textbox1106'))
    { 
        abc56=document.getElementById('textbox1106').value*1;
    }
    
    if(document.getElementById('textbox1107'))
    { 
        abc57=document.getElementById('textbox1107').value*1;
    }
    
    if(document.getElementById('textbox1108'))
    { 
        abc58=document.getElementById('textbox1108').value*1;
    }
    
    if(document.getElementById('textbox1109'))
    { 
        abc59=document.getElementById('textbox1109').value*1;
    }
    
   flag=document.getElementById('flag').value*1;
   if(flag==1){
		  input_price		= document.getElementById("input_price").value;
	      input_transport	= document.getElementById("input_transport").value;
	      advertising_costs	= document.getElementById("advertising_costs").value;
	      customer_care		=  document.getElementById("customer_care").value;
	      xuan_bac			=  document.getElementById("xuan_bac").value;

	      input_price2		= input_price.replace(/,/g, '');
	      input_transport2	= input_transport.replace(/,/, '');
	      advertising_costs2= advertising_costs.replace(/,/, '');
	      customer_care2	= customer_care.replace(/,/, '');
	      xuan_bac2			= xuan_bac.replace(/,/, '');
	           
	     tong_chi_phi1=abc30+abc31+abc32+abc33+abc34+abc35+abc36+abc37+abc38+abc39+abc40;
	     tong_chi_phi2=abc51+abc52+abc53+abc54+abc55+abc56+abc57+abc58+abc59;
	     tong_chi_phi=
	    	 input_price2*1
	         + input_transport2*1
	         + (
	             (document.getElementById("input_tax").value*1)
	             *(input_price2*1)
	             /100)
	         + advertising_costs2*1
	         + customer_care2*1
	         //+ textbox12*1
	         + document.getElementById("commission").value*1
	         + abc0+abc1+abc2+abc3+abc4+abc5+abc6+abc7+abc8+abc9
	         + abc11+abc12+abc13+abc14+abc15+abc16+abc17+abc18+abc19+abc20
	         + tong_chi_phi1
	         + tong_chi_phi2;
	
	     kq=((document.getElementById("profit_price").value*1)*tong_chi_phi/100)+tong_chi_phi;
	
	    function format(n, currency) {
	 	    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	 	}
	 	kq2= format(kq, '') ;
	 	
	    document.getElementById("xuan_bac").setAttribute("value",kq2);
	 	document.getElementById('xuan_bac1').innerHTML =kq2;
	    //document.getElementById("chi_phi").setAttribute("value",<?php echo number_format($person_info->price)?>);
     }else{
		  input_price		= document.getElementById("input_price").value;
	      input_transport	= document.getElementById("input_transport").value;
	      advertising_costs	= document.getElementById("advertising_costs").value;
	      customer_care		=  document.getElementById("customer_care").value;
	      xuan_bac			=  document.getElementById("xuan_bac").value;

	      input_price2		= input_price.replace(/,/g, '');
	      input_transport2	= input_transport.replace(/,/, '');
	      advertising_costs2= advertising_costs.replace(/,/, '');
	      customer_care2	= customer_care.replace(/,/, '');
	      xuan_bac2			= xuan_bac.replace(/,/, '');
         
	     tong_chi_phi1=abc30+abc31+abc32+abc33+abc34+abc35+abc36+abc37+abc38+abc39+abc40;
	     tong_chi_phi2=abc51+abc52+abc53+abc54+abc55+abc56+abc57+abc58+abc59;   
	     tong_chi_phi=
	    	 input_price2*1
	         + input_transport2*1
	         +(
	             (document.getElementById("input_tax").value*1)
	             *(input_price2*1)
	             /100)
	         + advertising_costs*1
	         + customer_care2*1
	         + document.getElementById("commission").value*1
	         + abc0+abc1+abc2+abc3+abc4+abc5+abc6+abc7+abc8+abc9
	         + abc11+abc12+abc13+abc14+abc15+abc16+abc17+abc18+abc19+abc20
	         + tong_chi_phi1
	         + tong_chi_phi2;
	     kq=(xuan_bac2*1)-tong_chi_phi;
	     kq_profit=(((xuan_bac2*1)-tong_chi_phi)/tong_chi_phi)*100;

	    function format(n, currency) {
	  	    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	  	}
	  	kq2= format(kq, '') ;

	    function format(n, currency) {
	 	    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	 	}
	    kq_profit2= format(kq_profit, '') ;
	     
	     document.getElementById("profit_price").setAttribute("value",kq_profit2);
	     document.getElementById('xuan_bac1').innerHTML ='Lợi nhuận :'+kq2+' VND';
	     //document.getElementById("chi_phi").setAttribute("value",<?php echo $this->config->item('meals')?>);
     }
}

</script>

<style type="text/css">

	
.myButton {
	background: none repeat scroll 0 0 #428BCA;
    border: 1px solid #EEEEEE;
    color: #FFFFFF;
    font-size: 14px;
    font-weight: bold;
    line-height: 30px;
    margin: 10px;
    padding: 10px;
}
.myButton:hover {
	padding: 10px;
	line-height: 30px;
	margin: 10px;
	font-size: 14px;
	font-weight: bold;
	padding-bottom: 10px;
	color: #FFFFFF;
	background: #3276b1;
	border: 1px solid #EEEEEE;
}
.myButton:active {
	position:relative;
	top:1px;
}

</style>
