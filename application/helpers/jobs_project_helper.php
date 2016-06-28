<?php
function get_jobs_project_manage_table_insert($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

        $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_project_name'),
        lang('common_jobs_start_date'),
        lang('common_jobs_end_date'),
        lang('common_jobs_status'),
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
        $table.= '';
        $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_project_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
         $table_data_rows.= get_jobs_project_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
    $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_project_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $jobs_status = $controller->get_status();

    $link = site_url('customers/detail_customer_sale/'.$employees_jobs_info->person_id);
    $table_data_row='<tr>';
        $table_data_row.="<td width='2%'><input  type='checkbox' id='person_$employees_jobs_info->jobs_id' value='".$employees_jobs_info->jobs_id."'/></td>";
        $table_data_row.='<td width="40%" style="color:#000;height:45px;">';
            if($employees_jobs_info->jobs_important == 3){
            $table_data_row .= '<img style="margin:15px 5px 0 -8px;float:left;width:10px;height:10px" src="'.base_url().'images/jobs/project-2.png">';
            }else if($employees_jobs_info->jobs_important == 2){
            $table_data_row .= '<img style="margin:15px 5px 0 -8px;float:left;width:9px;height:11px" src="'.base_url().'images/jobs/project-3.png">';
            }else{
            $table_data_row .= '<img style="margin:15px 5px 0 -8px;float:left;width:11px;height:11px" src="'.base_url().'images/jobs/project-1.png">';
            }
    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:30px;height:auto;float:left;padding:13px 0 5px 0;">'.$employees_jobs_info->jobs_name.'</p></td>';

    $table_data_row.='<td width="13%" style="color:#000;height:45px;line-height:45px">'.date(get_date_format(),strtotime($employees_jobs_info->jobs_start_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;line-height:45px">'.date(get_date_format(),strtotime($employees_jobs_info->jobs_end_date)).'</td>';
    foreach($jobs_status AS $keys => $values){
        if($values->jobs_status_id == $employees_jobs_info->jobs_status_id){
            $table_data_row.='<td style="color: '.$values->jobs_status_color .';width: 15%;text-align:left;font-size: 12px">'. $values->jobs_status_name.' </td>';
        }
    }
    $table_data_row.='<td width="4%" style="font-family: Arial;padding-left:5px" class="rightmost">'.anchor($controller_name."/view/$employees_jobs_info->jobs_id", lang('common_edit'),array('class'=>'update','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}
function get_jobs_project_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

        $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_project_name'),
        lang('common_jobs_start_date'),
        lang('common_jobs_end_date'),
        lang('common_jobs_status'),
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
        $table.= get_jobs_project_manage_table_data_rows($employees_jobs,$controller);
        $table.='</tbody></table>';
    return $table;
}


/*
 * Trạng thái thông tin table
 * */

function get_jobs_status_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_status_name'),
        lang('common_jobs_status_date'),
        lang('common_jobs_status_show'),
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
    $table.= get_jobs_status_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_status_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_jobs_status_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_status_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();

    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$employees_jobs_info->jobs_status_id' value='".$employees_jobs_info->jobs_status_id."'/></td>";
    $table_data_row.='<td width="40%" style="color:#000;height:45px;">';

    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:340px;padding:8px 0 5px 0;">'.$employees_jobs_info->jobs_status_name.'</p></td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($employees_jobs_info->jobs_status_date)).'</td>';
    if( $employees_jobs_info->jobs_status_show == 1){
        $table_data_row.= '<td width="13%"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;">Đang hiện</p></td>';
    }else{
        $table_data_row.= '<td width="13%"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;">Đang bị ẩn</p></td>';
    }


    $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view_status/$employees_jobs_info->jobs_status_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
 * Trạng thái thông tin table important
 * */

function get_jobs_important_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_important_name'),
        lang('common_jobs_important_date'),
        lang('common_jobs_important_show'),
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
    $table.= get_jobs_important_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the security
*/


function get_jobs_important_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_jobs_important_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_important_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();

    $table_data_row='<tr>';
    $table_data_row.="<td width='2%'><input type='checkbox' id='person_$employees_jobs_info->jobs_important_id' value='".$employees_jobs_info->jobs_important_id."'/></td>";
    $table_data_row.='<td width="40%" style="color:#000;height:45px;">';

    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:340px;padding:8px 0 5px 0;">'.$employees_jobs_info->jobs_important_name.'</p></td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($employees_jobs_info->jobs_important_date)).'</td>';
    if( $employees_jobs_info->jobs_important_show == 1){
        $table_data_row.= '<td width="13%"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;">Đang hiện</p></td>';
    }else{
        $table_data_row.= '<td width="13%"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;">Đang bị ẩn</p></td>';
    }


    $table_data_row.='<td width="1%" style="font-family: Arial;border-right: none" class="rightmost">'.anchor($controller_name."/view_important/$employees_jobs_info->jobs_important_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}


/*
Gets the html data rows for the people.
*/
function get_jobs_security_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_security_name'),
        lang('common_jobs_security_date'),
        lang('common_jobs_security_show'),
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
    $table.= get_jobs_security_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}
function get_jobs_security_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_jobs_security_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_security_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_module_width();

    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$employees_jobs_info->jobs_security_id' value='".$employees_jobs_info->jobs_security_id."'/></td>";
    $table_data_row.='<td width="40%" style="color:#000;height:45px;">';

    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:340px;padding:8px 0 5px 0;">'.$employees_jobs_info->jobs_security_name.'</p></td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($employees_jobs_info->jobs_security_date)).'</td>';
    if( $employees_jobs_info->jobs_security_show == 1){
        $table_data_row.= '<td width="13%"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;">Đang hiện</p></td>';
    }else{
        $table_data_row.= '<td width="13%"><p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;">Đang bị ẩn</p></td>';
    }


    $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view_security/$employees_jobs_info->jobs_security_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}





