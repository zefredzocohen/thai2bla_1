<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/add_textbox/bootstrap.js"></script>
<link href="<?php echo base_url(); ?>js/add_textbox/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />

<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<ul><h4> Chú ý : Tên công thức không được trùng nhau! </h4></ul>
<?php
//echo form_open_multipart('profit/save/'.$item_kit_info->item_kit_id,array('id'=>'item_kit_form'));
//echo form_open('profit/save_3/'.$person_info->id,array('id'=>'employee_form'));
echo form_open('profit/save_3/'.$person_info->id,array('id'=>'employee_form'));
?>
<fieldset id="item_kit_info">
<legend><?php echo lang("profit_input_info"); ?></legend>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_formula').':', 'last_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'last_name',
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
</table>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input2').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_price',
		'id'=>'input_price',
		'value'=>0,
	));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input8').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_transport',
		'id'=>'input_transport',
		'value'=>0));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input3').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'input_tax',
		'id'=>'input_tax',
		'value'=>0));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input14').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'advertising_costs',
		'id'=>'advertising_costs',
		'value'=>0));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input15').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'customer_care',
		'id'=>'customer_care',
		'value'=>0));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_input16').' %:', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'commission',
		'id'=>'commission',
		'value'=>0));?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label(lang('common_input4').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'profit_price',
		'id'=>'profit_price',
		'value'=>0));?>
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
</table>

<h4>Thêm các chi phí khác </h4>
<div class="control-group" style="margin: 10px;">
	<div class="inc">
        <div class="controls">
	       <input type="text" id="textfield" name="textfield[]" value="chi phí thêm"/>&nbsp;<input type="text" id="textbox1" name="textfield1[]" value="0" />&nbsp;<button class="" type="submit" id="append" name="append">Thêm</button>
	       <br/>
	   </div>
    </div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_input5').':', 'phone_number',array('class'=>'wide')); ?>
	<div class='form_field'>
       <input type="text" name="profit_price2" id="xuan_bac" value="0"/><span><b>VND</b></span>
       <p id="chi_phi"></p>
	</div>
</div>

<div style="float: left;    line-height: 20px;    margin-left: 200px;">
    <span class="myButton" onclick="profit_price1()"> Tính Toán</span>
<?php
echo form_submit(array(
	'value'=>lang('profit_submit'),
	//'class'=>'submit_button float_right')
        'class'=>'btn btn-info',
        'style'=>'margin-top:-3px !important'
    )
);
?>
</div>


</fieldset>
<?php
echo form_close();
$working_days=(int)$this->config->item('working_days');
?>
<script type='text/javascript'>
     

	$('#input_price').maskMoney();
	$('#input_transport').maskMoney();
	$('#advertising_costs').maskMoney();
	$('#customer_care').maskMoney();
	//$('#textbox1').maskMoney();
	//$('.salary222').maskMoney();
	//$('.textfield1').maskMoney();
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
            $("#item_kit_items1").append("<tr><td><a href='#' onclick='return deleteItemKitRow(this);'>X</a></td><td><input type='text' name='empl_name[]'  style='width: 156px;'  value='"+ui.item.label+"' Readonly='' /></td><td><select name='day_hour[]'  id='myselect"+counter+"'  onclick='ooption("+counter+")' onchange='calculate("+counter+")' ><option value='day_day' selected='selected'>Ngày</option><option value='hour'>Giờ</option></select></td><td><input class='quantity' onkeyup='calculate("+counter+")'  id='item_kit_item_"+counter+"' type='text' size='3' name='day_hour_num[]' value='<?php echo $working_days; ?>'/></td><td><input type='text' name='geofeld[]' id='geofeld"+counter+"' class='salary222' value='"+ui.item.salary+"'/></td><td><input type='hidden' id='geofeld111"+counter+"' value='"+ui.item.salary+"'/></td></tr>");
            counter++;
            //alert(counter);
            alert('Bạn vừa chọn nhân viên :'+ui.item.label);
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
					url: "<?php echo site_url('profit/checkname/'. $person_info->id);?>", 
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
		$(".inc").append("<div class='controls'><input type='text' name='textfield[]'  value='chi phí thêm' /> <input type='text' id='textbox1"+demfield+"' name='textfield1[]' value='' /> <a href='#' class='remove_this btn btn-danger'>Xóa</a><br><br></div>");
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
        var xxyy=(x.value)*(xx/<?php echo $working_days; ?>);
        //var xxyy=(x.value)*(xx/30);
        //alert(xxyy);
        document.getElementById("geofeld"+aaa).setAttribute("value",xxyy);
    }
    else
    {
        var yy=document.getElementById("geofeld111"+aaa).value;
        var yy=(x.value)*(yy/(<?php echo $working_days; ?>*8));
        //var yy=(x.value)*(yy/240);
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

    var tong_chi_phi=0;
    var kq=0;
  
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
	
	  input_price		= document.getElementById("input_price").value;
      input_transport	= document.getElementById("input_transport").value;
      advertising_costs	= document.getElementById("advertising_costs").value;
      customer_care		=  document.getElementById("customer_care").value;
      textbox1			=  document.getElementById("textbox1").value;

      input_price2		= input_price.replace(/,/g, '');
      input_transport2	= input_transport.replace(/,/, '');
      advertising_costs2= advertising_costs.replace(/,/, '');
      customer_care2	= customer_care.replace(/,/, '');
      
    tong_chi_phi=
      input_price2*1
      + input_transport2*1
      + (
          (document.getElementById("input_tax").value*1)
          *(input_price2*1)
          /100)
      + advertising_costs2*1
      + customer_care2*1
      + textbox1*1
      + document.getElementById("commission").value*1
      + abc0+abc1+abc2+abc3+abc4+abc5+abc6+abc7+abc8+abc9
      + abc11+abc12+abc13+abc14+abc15+abc16+abc17+abc18+abc19+abc20;
    
  kq=tong_chi_phi*(((document.getElementById("profit_price").value*1)/100)+1);
  
  function format(n, currency) {
	    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
	}
	kq2= format(kq, '') ;
	
  document.getElementById('chi_phi').innerHTML ='Tổng chi phí :'+kq2+' VND';
  document.getElementById("xuan_bac").setAttribute("value",kq2);
}
</script>

<style type="text/css">
<!--
	
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
-->
</style>
