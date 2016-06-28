<?php
function get_salary_option_manage_table($salary,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter_one" id="sortable_table">';
	$headers = array('<input type="checkbox" id="select_all" />',
	lang('salary_option_numberdays'),
	lang('salary_option_numberhours'),
	lang('salary_option_percentdays'),
	lang('salary_option_percentsunday'),	
	lang('salary_option_holiday'),
	lang('salary_option_union_dues'),
	lang('salary_option_amount'),
	'');
	$table.='<thead><tr>';

	$count = 0;
	foreach($headers as $header)
	{
		$count++;
		
		if ($count == 1)
		{
			$table.="<th style='text-align:center' class='leftmost'>$header</th>";
		}
		elseif ($count == count($headers))
		{
			$table.="<th style='text-align:center' class='rightmost'>$header</th>";
		}
		else
		{
			$table.="<th style='text-align:center'>$header</th>";		
		}
	}
	$table.='</tr></thead><tbody>';
	$table.=get_salary_option_manage_table_data_rows($salary,$controller);
	$table.='</tbody></table>';
	return $table;
}
function get_salary_option_manage_table_data_rows($salary,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($salary->result() as $salaryoption)
	{
		$table_data_rows.=get_salary_option_data_row($salaryoption,$controller);
	}
	
	if($salary->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".lang('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_salary_option_data_row($salaryoption,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$table_data_row='<tr>';	
	$table_data_row.="<td  width='1%'><input type='checkbox' id='person_$salaryoption->id' value='".$salaryoption->id."'/></td>";
	$table_data_row.='<td style="text-align:center" width="10%">'.$salaryoption->numberdays.'</td>';
	$table_data_row.='<td style="text-align:center" width="8%">'.$salaryoption->numberhours.'</td>';
	$table_data_row.='<td style="text-align:center"  width="18%">'.$salaryoption->percent_overtime_weekdays.'</td>';
	$table_data_row.='<td style="text-align:center" width="16%">'.$salaryoption->percent_overtime_sunday.'</td>';
	$table_data_row.='<td style="text-align:center" width="14%">'.$salaryoption->percent_overtime_holiday.'</td>';
	$table_data_row.='<td style="text-align:center" width="12%">'.$salaryoption->union_dues.'</td>';
	$table_data_row.='<td style="text-align:center" width="11%">'.$salaryoption->exemption_amount.'</td>';
	$table_data_row.='<td style="text-align:center" width="1%" class="rightmost">'.anchor($controller_name."/view/$salaryoption->id/width~$width/height~480", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';		// link sửa chữa "sửa"
	
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

?>