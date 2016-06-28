<?php
function get_salary_manage_table($salary,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter_one" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',
	lang('salary_id'),
	lang('salary_name'),
	lang('salary_description'),
	/*lang('salary_value'),*/
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
	$table.=get_salary_manage_table_data_rows($salary,$controller);
	$table.='</tbody></table>';
	return $table;
}
function get_salary_manage_table_data_rows($salary,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($salary->result() as $salaryconfig)
	{
		$table_data_rows.=get_salary_data_row($salaryconfig,$controller);
	}
	
	if($salary->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".lang('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_salary_data_row($salaryconfig,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$table_data_row='<tr>';	
	$table_data_row.="<td style='text-align:center' width='1%'><input type='checkbox' id='person_$salaryconfig->id' value='".$salaryconfig->id."'/></td>";
	$table_data_row.='<td style="text-align:center" width="8%">'.$salaryconfig->id.'</td>';
	$table_data_row.='<td style="text-indent: 7px;font-size:11px" width="10%">'.$salaryconfig->name.'</td>';
	$table_data_row.='<td  width="75%">'.$salaryconfig->description.'</td>';
	/*$table_data_row.='<td style="padding-left:8px" width="10%">'.$salaryconfig->value.'</td>';*/
	$table_data_row.='<td style="text-align:center" width="1%" class="rightmost">'.anchor($controller_name."/view/$salaryconfig->id/width~400/height~400", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';		// link sửa chữa "sửa"
	
	$table_data_row.='</tr>';
	
	return $table_data_row;
}



?>
