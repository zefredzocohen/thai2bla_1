<?php
function get_culture_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_culture_name'),
        lang('common_culture_manager'),
        lang('common_culture_parent'),
        lang('common_culture_date'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach($headers as $header)
    {
        $count++;
        if ($count == 1)
        {
            $table.="<th class='leftmost'>$header</th>";
        }
        elseif ($count==count($headers))
        {
            $table.="<th class='rightmost'>$header</th>";
        }
        else
        {
            $table.="<th>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.= get_culture_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_culture_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_culture_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_culture_data_row($data,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();
    $name = $controller->get_name($data->person_id);

    $table_data_row='<tr>';
        $table_data_row.="<td width='1%'><input type='checkbox' id='person_$data->jobs_culture_id' value='".$data->jobs_culture_id."'/></td>";
        $table_data_row.='<td width="15%" style="color:#000;height:25px;color:'.$data->culture_color.'""><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:130px;padding:8px 0 5px 0;color:'.$data->culture_color.'">'.$data->jobs_culture_name.'</p></td>';
        $table_data_row.='<td width="35%" style="color:#000;height:25px;line-height:25px">'.$data->jobs_culture_description.'</td>';
        $table_data_row.='<td width="20%" style="color:#000;height:25px;line-height:25px">'.$name->first_name.'</td>';
        $table_data_row.='<td width="13%" style="color:#000;height:25px;line-height:25px">'.date('d-m-Y',strtotime($data->jobs_culture_date)).'</td>';
        $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view/$data->jobs_culture_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

