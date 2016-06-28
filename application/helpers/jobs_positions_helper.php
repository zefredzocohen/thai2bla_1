<?php
function get_positions_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_positions_name'),
        lang('common_positions_manager'),
/*         lang('common_positions_parent'), */
        lang('common_positions_date'),
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
    $table.= get_positions_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_positions_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_positions_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_positions_data_row($data,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();

    $table_data_row='<tr>';
        $table_data_row.="<td width='1%'><input type='checkbox' id='person_$data->jobs_positions_id' value='".$data->jobs_positions_id."'/></td>";
        $table_data_row.='<td width="25%" style="color:#000;color:'.$data->positions_color.'""><p style="display:inline-block;margin:0px 0 0 2px;float:left;width:130px;color:'.$data->positions_color.'">'.$data->jobs_positions_name.'</p></td>';
        $table_data_row.='<td width="35%" style="color:#000">'.$data->jobs_positions_description.'</td>';
        $table_data_row.='<td width="13%" style="color:#000;">'.date('d-m-Y',strtotime($data->jobs_positions_date)).'</td>';
        $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view/$data->jobs_positions_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

