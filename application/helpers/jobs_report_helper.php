<?php
function get_jobs_report_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_report_name'),
        lang('common_jobs_report_project'),
        lang('common_jobs_report_manager'),
        lang('common_jobs_report_date'),
        lang('common_jobs_report_result'),
        lang('common_jobs_report_status'),
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
    $table.= get_jobs_report_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_report_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_jobs_report_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()== 0)
    {
        $table_data_rows.="<tr><td colspan='8'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_report_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_report_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $parent = $controller->get_name_people_parent();

    if($employees_jobs_info->last_name != '') $employees_jobs_info->last_name == '';
    $link = site_url('customers/detail_customer_sale/'.$employees_jobs_info->person_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$employees_jobs_info->jobs_reports_id' value='".$employees_jobs_info->jobs_reports_id."'/></td>";
    $table_data_row.='<td style="color: #000;width: 16%;text-align: left" >'.$employees_jobs_info->jobs_reports_name.'</td>';
    $table_data_row.='<td width="28%" style="color: #000;height:45px;"><p style="float:left;margin:0px 0 0 2px;">'.$employees_jobs_info->jobs_name.'</p></td>';
    $table_data_row.='<td width="18%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">';
    foreach($parent AS $key=>$values){
        if($values['employees_jobs_parent_id'] == $employees_jobs_info->employees_jobs_parent_id){
            $table_data_row .= $values['first_name'];
        }
    }
    $table_data_row .="</a></td>";
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date('d-m-Y',strtotime($employees_jobs_info->jobs_reports_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;text-align:center">'.$employees_jobs_info->jobs_reports_result.' %</td>';

    if($employees_jobs_info->jobs_reports_status > 0){
        $table_data_row.='<td id="status_no" style="color: #009900;width: 13%;text-align: left"> <img style="margin:1px 7px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/check.png"> Đã duyệt</td>';
    }else{
        $table_data_row.='<td style="color: #b81900;width: 14%;text-align: left" > <img style="margin:1px 3px 0 -8px;float:left;width:13px;height:13px" src="'.base_url().'images/jobs/no_check.png"> Chưa duyệt</td>';
    }
    $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view/$employees_jobs_info->jobs_reports_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
 * Function child for manager
 * */
function get_jobs_report_child_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_report_name'),
        lang('common_jobs_report_employees'),
        lang('common_jobs_report_employees'),
        lang('common_jobs_report_date'),
        lang('common_jobs_report_result'),
        lang('common_jobs_report_status'),
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
    $table.= get_jobs_report_child_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_report_child_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_jobs_report_child_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()== 0)
    {
        $table_data_rows.="<tr><td colspan='8'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_report_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_report_child_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();


    if($employees_jobs_info->last_name != '') $employees_jobs_info->last_name == '';
    $link = site_url('customers/detail_customer_sale/'.$employees_jobs_info->person_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$employees_jobs_info->jobs_reports_id' value='".$employees_jobs_info->jobs_reports_id."'/></td>";
    $table_data_row.='<td style="color: #000;width: 16%;text-align: left" >'.$employees_jobs_info->jobs_reports_name.'</td>';
    $table_data_row.='<td width="28%" style="color: #000;height:45px;"><p style="float:left;margin:0px 0 0 2px;">'.$employees_jobs_info->jobs_name.'</p></td>';
    $table_data_row.='<td width="18%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">'.$employees_jobs_info->first_name.'</a></td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date('d-m-Y',strtotime($employees_jobs_info->jobs_reports_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;text-align:center">'.$employees_jobs_info->jobs_reports_result.' %</td>';

    if($employees_jobs_info->jobs_reports_status > 0){
        $table_data_row.='<td id="status_no" style="color: #009900;width: 13%;text-align: left"> <img style="margin:1px 7px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/check.png"> Đã duyệt</td>';
    }else{
        $table_data_row.='<td style="color: #b81900;width: 14%;text-align: left" > <img style="margin:1px 3px 0 -8px;float:left;width:13px;height:13px" src="'.base_url().'images/jobs/no_check.png"> Chưa duyệt</td>';
    }
    $table_data_row.='<td width="1%" style="font-family: Arial;" class="rightmost">'.anchor($controller_name."/show/$employees_jobs_info->jobs_reports_id/width~$width", lang('common_edit_manager'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
 * Function child for manager
 * */
function get_jobs_report_moth_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_report_name'),
        lang('common_jobs_report_employees'),
        lang('common_jobs_report_employees'),
        lang('common_jobs_report_date'),
        lang('common_jobs_report_result'),
        lang('common_jobs_report_status'),
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
    $table.= get_jobs_report_month_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_report_month_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
        $table_data_rows.= get_jobs_report_child_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()== 0)
    {
        $table_data_rows.="<tr><td colspan='8'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_report_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_report_month_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();


    if($employees_jobs_info->last_name != '') $employees_jobs_info->last_name == '';
    $link = site_url('customers/detail_customer_sale/'.$employees_jobs_info->person_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$employees_jobs_info->jobs_reports_id' value='".$employees_jobs_info->jobs_reports_id."'/></td>";
    $table_data_row.='<td style="color: #000;width: 16%;text-align: left" >'.$employees_jobs_info->jobs_reports_name.'</td>';
    $table_data_row.='<td width="28%" style="color: #000;height:45px;"><p style="float:left;margin:0px 0 0 2px;">'.$employees_jobs_info->jobs_name.'</p></td>';
    $table_data_row.='<td width="18%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">'.$employees_jobs_info->first_name.'</a></td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date('d-m-Y',strtotime($employees_jobs_info->jobs_reports_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;text-align:center">'.$employees_jobs_info->jobs_reports_result.' %</td>';

    if($employees_jobs_info->jobs_reports_status > 0){
        $table_data_row.='<td id="status_no" style="color: #009900;width: 13%;text-align: left"> <img style="margin:1px 7px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/check.png"> ?ã duy?t</td>';
    }else{
        $table_data_row.='<td style="color: #b81900;width: 14%;text-align: left" > <img style="margin:1px 3px 0 -8px;float:left;width:13px;height:13px" src="'.base_url().'images/jobs/no_check.png"> Ch?a duy?t</td>';
    }
    $table_data_row.='<td width="1%" style="font-family: Arial;" class="rightmost">'.anchor($controller_name."/show/$employees_jobs_info->jobs_reports_id/width~$width", lang('common_edit_manager'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}


