<?php
function get_file_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_file_tile'),
        lang('common_file_department'),
        lang('common_file_person'),
        lang('common_file_name'),
        lang('common_file_date'),
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
    $table.= get_file_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_file_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_file_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_file_data_row($data,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();
    $namePeople = $controller->getNamePersonUploadFile($data->person_id);
    $nameDepartment = $controller->getNameDepartmentUploadFile($data->person_id);
    $link = "./file/file/".$data->jobs_file_name;
    $table_data_row='<tr>';
        $table_data_row.="<td width='1%'><input type='checkbox' id='person_$data->jobs_file_id' value='".$data->jobs_file_id."'/></td>";
        $table_data_row.='<td width="15%" style="color:#000;height:45px;"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:130px;padding:8px 0 5px 0;">'.$data->jobs_file_title.'</p></td>';
        $table_data_row.='<td width="15%" style="color:#000;height:45px;"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:130px;padding:8px 0 5px 0;">'.$nameDepartment->department_name.'</p></td>';
        $table_data_row.='<td width="15%" style="color:#000;height:45px;"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:120px;padding:8px 0 5px 0;">'.$namePeople->first_name.'</p></td>';
        $table_data_row.='<td width="15%" style="color:#000;height:45px;"><a href='.$link.' style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:120px;padding:8px 0 5px 0;text-decoration:underline;color:blue">'.$data->jobs_file_name.'</a></td>';
        $table_data_row.='<td width="18%" style="color:#000;height:45px;line-height:45px">'.date(get_date_format(),strtotime($data->jobs_file_date)).'</td>';

        $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view/$data->jobs_file_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

