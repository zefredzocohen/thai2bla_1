<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div id="title_bar_newone">
    <img style="width: 22px;height: 22px;margin: 11px;float: left" src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php echo lang('reports_welcome_message'); ?>' />
    <?php echo $title ?>
</div>
<br />

<script type="text/javascript">
(function($) 
{
  	$.fn.tokenize = function(options)
	{
		var settings = $.extend({}, {prePopulate: false}, options);
    	return this.each(function() 
		{
      		$(this).tokenInput('<?php echo site_url("reports/sales_generator"); ?>?act=autocomplete',
			{
				theme: "facebook",
				queryParam: "term",
				extraParam: "w",
				hintText: <?php echo json_encode(lang("reports_sales_generator_autocomplete_hintText"));?>,
				noResultsText: <?php echo json_encode(lang("reports_sales_generator_autocomplete_noResultsText"));?>,
				searchingText: <?php echo json_encode(lang("reports_sales_generator_autocomplete_searchingText"));?>,
				preventDuplicates: true,
				prePopulate: settings.prePopulate
			});
    	});
 	}
})(jQuery);

$("#matchType").live("change", function() {
	if ($(this).val() == 'matchType_All')
		$(".actions span.actionCondition").html(<?php echo json_encode(lang("reports_sales_generator_matchType_All_TEXT"));?>);
	else 
		$(".actions span.actionCondition").html(<?php echo json_encode(lang("reports_sales_generator_matchType_Or_TEXT"));?>);
});

$("a.AddCondition").live("click", function(e) {
	var sInput = $("<input />").attr({"type": "text", "name": "value[]", "w":"", "value":""});
	$('.conditions tr.duplicate:last').clone().insertAfter($('.conditions tr.duplicate:last'));
	$("input", $('.conditions tr.duplicate:last')).parent().html("").append(sInput).children("input").tokenize();
	$("option", $('.conditions tr.duplicate:last select')).removeAttr("disabled").removeAttr("selected").first().attr("selected", "selected");
	
	$('.conditions tr.duplicate:last').trigger('change');
	e.preventDefault();
})

$("a.DelCondition").live("click", function(e) {
	if ($(this).parent().parent().parent().children().length > 1)
		$(this).parent().parent().remove();
	
	e.preventDefault();
})

$(".selectField").live("change", function() {
	var sInput = $("<input />").attr({"type": "text", "name": "value[]", "w":"", "value":""});
	var field = $(this);
	// Remove Value Field
	field.parent().parent().children("td.value").html("");
	if ($(this).val() == 0) 
	{
		field.parent().parent().children("td.condition").children(".selectCondition").attr("disabled", "disabled");	
		field.parent().parent().children("td.value").append(sInput.attr("disabled", "disabled"));		
	} 
	else 
	{
		field.parent().parent().children("td.condition").children(".selectCondition").removeAttr("disabled");	
		if ($(this).val() == 2 || $(this).val() == 7 || $(this).val() == 10) 
		{
			field.parent().parent().children("td.value").append(sInput);		
		} 
		else 
		{
			if ($(this).val() == 6) 
			{
				field.parent().parent().children("td.value").append($("<input />").attr({"type": "hidden", "name": "value[]", "value":""}));		
			} 
			else 
			{
				field.parent().parent().children("td.value").append(sInput.attr("w", $("option:selected", field).attr('rel'))).children("input").tokenize();		
			}
		}
		disableConditions(field, true);
	}
});

$(function() {
	<?php
		if (isset($prepopulate) and count($prepopulate) > 0) {
			echo "var prepopulate = $.parseJSON('".json_encode($prepopulate)."');";
		}
	?>
	var sInput = $("<input />").attr({"type": "text", "name": "value[]", "w":"", "value":""});
	$(".selectField").each(function(i) {
		if ($(this).val() == 0) {
			$(this).parent().parent().children("td.condition").children(".selectCondition").attr("disabled", "disabled");
			$(this).parent().parent().children("td.value").html("").append(sInput.attr("disabled", "disabled"));	
		} else {
			if ($(this).val() != 2 && $(this).val() != 6 && $(this).val() != 7 && $(this).val() != 10) {
				$(this).parent().parent().children("td.value").children("input").attr("w", $("option:selected", $(this)).attr('rel')).tokenize({prePopulate: prepopulate.field[i][$(this).val()] });	
			}
			if ($(this).val() == 6) {
				$(this).parent().parent().children("td.value").html("").append($("<input />").attr({"type": "hidden", "name": "value[]", "value":""}));	
			}
			disableConditions($(this), false);
		}
	});
	
	$("#start_month, #start_day, #start_year, #end_month, #end_day, #end_year").change(function()
	{
		$("#complex_radio").attr('checked', 'checked');
	});

	$("#report_date_range_simple").change(function()
	{
		$("#simple_radio").attr('checked', 'checked');
	});
});

function disableConditions(elm, q) {
	var allowed1 = ['1', '2'];
	var allowed2 = ['7', '8', '9'];
	var allowed3 = ['10', '11'];
	var allowed4 = ['1', '2', '7', '8', '9'];
	var allowed5 = ['1'];
	var disabled = elm.parent().parent().children("td.condition").children(".selectCondition");
	
	if (q == true)
		$("option", disabled).removeAttr("selected");
	
	$("option", disabled).attr("disabled", "disabled");
	$("option", disabled).each(function() {
		if (elm.val() == 11 && $.inArray($(this).attr("value"), allowed5) != -1) {
			$(this).removeAttr("disabled");
		}else if (elm.val() == 10 && $.inArray($(this).attr("value"), allowed4) != -1) {
			$(this).removeAttr("disabled");
		} else if (elm.val() == 6 && $.inArray($(this).attr("value"), allowed3) != -1) {
			$(this).removeAttr("disabled");
		} else if (elm.val() == 7 && $.inArray($(this).attr("value"), allowed2) != -1) {
			$(this).removeAttr("disabled");
		} else if (elm.val() != 6 && elm.val() != 7 && elm.val() != 10 && elm.val() != 11 && $.inArray($(this).attr("value"), allowed1) != -1) {
			$(this).removeAttr("disabled");
		} 
	});
	
	if (q == true)
		$("option:not(:disabled)", disabled).first().attr("selected", "selected");
}

</script>
<div style="color:#000">
<form name="salesReportGenerator" action="<?php echo site_url("reports/sales_generator"); ?>" method="post">
<table id="contents">
	<tr>
		<td class="item_table">
			<?php echo form_label(lang('reports_date_range'), 'report_date_range_label', array('class'=>'required','id'=>'label_new')); ?>
			<div id='report_date_range_simple'>
				<input type="radio" name="report_type" id="simple_radio" value='simple'<?php if ($report_type != 'complex') { echo " checked='checked'"; }?>/>
				<?php echo form_dropdown('report_date_range_simple',$report_date_range_simple, $sreport_date_range_simple, 'id="report_date_range_simple"'); ?>
			</div>
			<div id='report_date_range_complex'>
				<input type="radio" name="report_type" id="complex_radio" value='complex'<?php if ($report_type == 'complex') { echo " checked='checked'"; }?>/>
				<?php echo form_dropdown('start_day',$days, $start_day, 'id="start_day"'); ?>
				<?php echo form_dropdown('start_month',$months, $start_month, 'id="start_month"'); ?>
				<?php echo form_dropdown('start_year',$years, $start_year, 'id="start_year"'); ?>
				-
				<?php echo form_dropdown('end_day',$days, $end_day, 'id="end_day"'); ?>
				<?php echo form_dropdown('end_month',$months, $end_month, 'id="end_month"'); ?>
				<?php echo form_dropdown('end_year',$years, $end_year, 'id="end_year"'); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td class="item_table">&nbsp;</td>
	</tr>
	<tr>
		<td class="item_table">
            <?php echo form_label(lang('reports_sales_generator_matchType'), 'matchType', array('class'=>'required','id'=>'label_new')); ?>
			<select name="matchType" id="matchType">
				<option value="matchType_All"<?php if ($matchType != 'matchType_All') { echo " selected='selected'"; }?>><?php echo lang('reports_sales_generator_matchType_All')?></option>
				<option value="matchType_Or"<?php if ($matchType == 'matchType_Or') { echo " selected='selected'"; }?>><?php echo lang('reports_sales_generator_matchType_Or')?></option>
			</select>
			<br />
			<em>
				<?php echo lang('reports_sales_generator_matchType_Help')?>
			</em>
		</td>
	</tr>
	<tr>
		<td class="item_table">&nbsp;</td>
	</tr>
	<tr>
		<td class="item_table">
			<table class="conditions" style="border: none">
				<?php
					if (isset($field) and $field[0] > 0) {
						foreach ($field as $k => $v) {
				?>
				<tr class="duplicate">
					<td class="field">
						<select name="field[]" class="selectField">
							<option value="0"><?php echo lang("reports_sales_generator_selectField_0") ?></option>						
							<option value="1" rel="customers"<?php if($field[$k] == 1) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_1") ?></option>
							<option value="2" rel="itemsSN"<?php if($field[$k] == 2) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_2") ?></option>
							<option value="3" rel="employees"<?php if($field[$k] == 3) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_3") ?></option>
							<option value="4" rel="itemsCategory"<?php if($field[$k] == 4) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_4") ?></option>
							<option value="5" rel="suppliers"<?php if($field[$k] == 5) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_5") ?></option>
							<option value="6" rel="saleType"<?php if($field[$k] == 6) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_6") ?></option>
							<option value="7" rel="saleAmount"<?php if($field[$k] == 7) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_7") ?></option>
							<option value="8" rel="itemsKitName"<?php if($field[$k] == 8) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_8") ?></option>
							<option value="9" rel="itemsName"<?php if($field[$k] == 9) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_9") ?></option>
							<option value="10" rel="saleID"<?php if($field[$k] == 10) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_10") ?></option>
							<option value="11" rel="paymentType"<?php if($field[$k] == 11) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectField_11") ?></option>
						</select>
					</td>
					<td class="condition">
						<select name="condition[]" class="selectCondition">
							<option value="1"<?php if($condition[$k] == 1) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_1")?></option>
							<option value="2"<?php if($condition[$k] == 2) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_2")?></option>
							<option value="7"<?php if($condition[$k] == 7) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_7")?></option>
							<option value="8"<?php if($condition[$k] == 8) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_8")?></option>
							<option value="9"<?php if($condition[$k] == 9) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_9")?></option>
							<option value="10"<?php if($condition[$k] == 10) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_10")?></option>
							<option value="11"<?php if($condition[$k] == 11) echo " selected='selected'";?>><?php echo lang("reports_sales_generator_selectCondition_11")?></option>
						</select>
					</td>
					<td class="value">
						<input style="width: 400px !important;" type="text" name="value[]" w="" value="<?php echo $value[$k]; ?>"/>
					</td>
					<td class="actions">
						<span class="actionCondition">
						<?php 
							if ($matchType == 'matchType_Or') {
								echo lang("reports_sales_generator_matchType_Or_TEXT");
							} else {
								echo lang("reports_sales_generator_matchType_All_TEXT");					
							}
						?>
						</span>
						<a class="AddCondition" href="#" title="<?php echo lang("reports_sales_generator_addCondition")?>"><?php echo lang("reports_sales_generator_addCondition")?></a>
						<a class="DelCondition" href="#" title="<?php echo lang("reports_sales_generator_delCondition")?>"><?php echo lang("reports_sales_generator_delCondition")?></a>
					</td>
				</tr>				
				<?php
						}
					} else {
				?>
				<tr class="duplicate">
					<td class="field">
						<select name="field[]" class="selectField">
							<option value="0"><?php echo lang("reports_sales_generator_selectField_0") ?></option>						
							<option value="1" rel="customers"><?php echo lang("reports_sales_generator_selectField_1") ?></option>
							<option value="2" rel="itemsSN"><?php echo lang("reports_sales_generator_selectField_2") ?></option>
							<option value="3" rel="employees"><?php echo lang("reports_sales_generator_selectField_3") ?></option>
							<option value="4" rel="itemsCategory"><?php echo lang("reports_sales_generator_selectField_4") ?></option>
							<option value="5" rel="suppliers"><?php echo lang("reports_sales_generator_selectField_5") ?></option>
							<option value="6" rel="saleType"><?php echo lang("reports_sales_generator_selectField_6") ?></option>
							<option value="7" rel="saleAmount"><?php echo lang("reports_sales_generator_selectField_7") ?></option>
							<option value="8" rel="itemsKitName"><?php echo lang("reports_sales_generator_selectField_8") ?></option>
							<option value="9" rel="itemsName"><?php echo lang("reports_sales_generator_selectField_9") ?></option>
							<option value="10" rel="saleID"><?php echo lang("reports_sales_generator_selectField_10") ?></option>
							<option value="11" rel="paymentType"><?php echo lang("reports_sales_generator_selectField_11") ?></option>
						</select>
					</td>
					<td class="condition">
						<select name="condition[]" class="selectCondition">
							<option value="1"><?php echo lang("reports_sales_generator_selectCondition_1")?></option>
							<option value="2"><?php echo lang("reports_sales_generator_selectCondition_2")?></option>
							<option value="7"><?php echo lang("reports_sales_generator_selectCondition_7")?></option>
							<option value="8"><?php echo lang("reports_sales_generator_selectCondition_8")?></option>
							<option value="9"><?php echo lang("reports_sales_generator_selectCondition_9")?></option>
							<option value="10"><?php echo lang("reports_sales_generator_selectCondition_10")?></option>
							<option value="11"><?php echo lang("reports_sales_generator_selectCondition_11")?></option>
						</select>
					</td>
					<td class="value">
						<input type="text" name="value[]" w="" value=""/>
					</td>
					<td class="actions">
						<span class="actionCondition">
						<?php 
							if ($matchType == 'matchType_Or') {
								echo lang("reports_sales_generator_matchType_Or_TEXT");
							} else {
								echo lang("reports_sales_generator_matchType_All_TEXT");					
							}
						?>
						</span>
						<a class="AddCondition" href="#" title="<?php echo lang("reports_sales_generator_addCondition")?>"><?php echo lang("reports_sales_generator_addCondition")?></a>
						<a class="DelCondition" href="#" title="<?php echo lang("reports_sales_generator_delCondition")?>"><?php echo lang("reports_sales_generator_delCondition")?></a>
					</td>
				</tr>
			
				<?php
					}
				?>
			</table>
		</td>
	</tr>	
	<tr>
		<td class="item_table" style="padding-top: 15px;">
			<button id="button_one" name="generate_report" type="submit" value="1" id="generate_report" class="submit_button"><?php echo lang('common_submit')?></button>
		</td>
	</tr>		
</table>
</form>

<?php 
	if (isset($results)) echo $results;
?>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>