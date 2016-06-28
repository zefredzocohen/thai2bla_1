<?php
function get_regions_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';
    if($controller->checkUpdate() > 0){
        $headers = array('<input type="checkbox" id="select_all" />',
            lang('common_regions_name'),
            lang('common_regions_description'),
            lang('common_regions_manager'),
            /*lang('common_regions_important'),
             lang('common_regions_status'),*/
            '&nbsp');
    }else{
        $headers = array('<input type="hidden" id="select_all" />',
            lang('common_regions_name'),
            lang('common_regions_description'),
            lang('common_regions_manager'),
            /*lang('common_regions_important'),  
            lang('common_regions_status'),*/
            '&nbsp');
    }

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
    $table.= get_regions_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_regions_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_regions_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:5px;font-weight:bold;color:#333'>".lang('common_no_regions_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_regions_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();
    $manager_person = $controller->get_manager_info();

    $table_data_row='<tr>';
    if($controller->checkUpdate() > 0){
        $table_data_row.="<td width='1%'><input type='checkbox' id='person_$employees_jobs_info->jobs_regions_id' value='".$employees_jobs_info->jobs_regions_id."'/></td>";
    }else{
        $table_data_row.="<td width='1%'></td>";
    }

        $table_data_row.='<td width=30%" style="color:#000;height:45px;color:'.$employees_jobs_info->jobs_regions_color.'""><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:150px;padding:8px 0 5px 0;">'
        .anchor("employees/switch_jobs_regions/$employees_jobs_info->jobs_regions_id", $employees_jobs_info->jobs_regions_name,array( 'title'=>lang($controller_name.'_update'))).
        '</p></td>';
        $table_data_row.='<td width="30%" style="color:#000;height:45px;">'.$employees_jobs_info->jobs_regions_description.'</td>';
        /* giang 8/4/2014 */
        $table_data_row.='<td style="color: #000;width: 22%;text-align:left;font-size: 12px">'. $employees_jobs_info->first_name.' </td>';
//        foreach($manager_person AS $keys => $values){
//            if($values->person_id == $employees_jobs_info->person_id){
//                $table_data_row.='<td style="color: #000;width: 22%;text-align:left;font-size: 12px">'. $values->first_name.' </td>';
//            }
//        }
        /* giang 8/4/2014 */
    if($controller->checkUpdate() > 0){
        $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'. anchor($controller_name."/view/$employees_jobs_info->jobs_regions_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    }else{
        $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost"></td>';
    }
    $table_data_row.='</tr>';

    return $table_data_row;
}

