<?php
function get_jobs_employees_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_children_name_manager'),
        lang('common_jobs_employees_name'),
        lang('common_jobs_children_start_date'),
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
    $table.= get_jobs_employees_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_employees_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    $number_row = $controller->get($employees_jobs->result());
    $number = "<p style='border: 1px solid #CCC;float:left;position:absolute;top:432px;left:350px'>(".$number_row.")</p>";

    foreach($employees_jobs->result() as $data)
    {

        $table_data_rows.= get_jobs_employees_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}
/*============================================================*/
function get_jobs_employees_data_row($data,$controller)
{
    $CI =& get_instance();

    ///print_r($data);

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $parent = $controller->get_name_people_parent();


    $link = site_url('jobs_employee/detail_index_jobs/'.$data->jobs_id);
    $table_data_row='<tr>';

    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$data->jobs_id' value='".$data->jobs_id."'/></td>";
    $table_data_row.='<td style="width:40%;color:#000;min-height:10px;height: auto">';
    if($data->jobs_important == 3){
        $table_data_row .= '<img style="margin:12px 5px 0 -5px;float:left;width:10px;height:10px;" src="'.base_url().'images/jobs/project-2.png">';
    }else if($data->jobs_important == 2){
        $table_data_row .= '<img style="margin:12px 5px 0 -5px;float:left;width:9px;height:11px" src="'.base_url().'images/jobs/project-3.png">';
    }else{
        $table_data_row .= '<img style="margin:12px 5px 0 -5px;float:left;width:11px;height:11px;" src="'.base_url().'images/jobs/project-1.png">';
    }
    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:300px;padding:8px 0 5px 0;"><a href="'.$link.'">'.$data->jobs_name.'</a></p></td>';

    $table_data_row.='<td width="17%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">'.$data->first_name."</a></td>";
    $table_data_row.='<td width="12%" style="color:#000;height:45px;text-align:center">'.date(get_date_format(),strtotime($data->employees_jobs_date)).'</td>';
    $jobs_status = $controller->get_status();
    foreach($jobs_status AS $keys => $values){
        if($values->jobs_status_id == $data->jobs_status_id){
            $table_data_row.='<td style="color: '.$values->jobs_status_color .';width: 15%;text-align:left;font-size: 12px">'. $values->jobs_status_name.' </td>';
        }
    }
    $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost"></td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
 * Information for table module child
 *
 * */

function get_jobs_employees_child_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array(
        lang('common_jobs_children_name'),
        lang('common_jobs_children_employees_name'),
        lang('common_jobs_children_start_date'),
        lang('common_jobs_status'));
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
    $table.= get_jobs_employees_child_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_employees_child_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_jobs_employees_child_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_employees_child_data_row($data,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $parent = $controller->get_name_people_parent();


   $link = site_url('jobs_employee/detail_index_jobs/'.$data->jobs_id);
    $table_data_row='<tr>';

    $table_data_row.='<td style="width:40%;color:#000;min-height:10px;height: auto">';
    if($data->jobs_important == 3){
        $table_data_row .= '<img style="margin:12px 5px 0 -5px;float:left;width:10px;height:10px;" src="'.base_url().'images/jobs/project-2.png">';
    }else if($data->jobs_important == 2){
        $table_data_row .= '<img style="margin:12px 5px 0 -5px;float:left;width:9px;height:11px" src="'.base_url().'images/jobs/project-3.png">';
    }else{
        $table_data_row .= '<img style="margin:12px 5px 0 -5px;float:left;width:11px;height:11px;" src="'.base_url().'images/jobs/project-1.png">';
    }
    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:300px;padding:8px 0 5px 0;"><a href="'.$link.'">'.$data->jobs_name.'</a></p></td>';

    $table_data_row.='<td width="17%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">';
    foreach($parent AS $key=>$values){
        if($values['employees_jobs_parent_id'] == $data->employees_jobs_parent_id){
            $table_data_row .= $values['first_name'];
        }
    }
    $table_data_row .="</a></td>";
    $table_data_row.='<td width="12%" style="color:#000;height:45px;text-align:center">'.date(get_date_format(),strtotime($data->employees_jobs_date)).'</td>';
    $jobs_status = $controller->get_status();
    foreach($jobs_status AS $keys => $values){
        if($values->jobs_status_id == $data->jobs_status_id){
            $table_data_row.='<td style="color: '.$values->jobs_status_color .';width: 15%;text-align:left;font-size: 12px">'. $values->jobs_status_name.' </td>';
        }
    }

    $table_data_row.='</tr>';

    return $table_data_row;
}


/**
    - get table my word
 */

function get_my_jobs_employees_index_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_my_name'),
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

function get_my_jobs_employees_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_my_name'),
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
    $table.= get_my_jobs_employees_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_my_jobs_employees_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_my_jobs_employees_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_my_jobs_employees_data_row($data,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

   $link = site_url('jobs_employee/detail_index_jobs/'.$data->jobs_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$data->jobs_id' value='".$data->jobs_id."'/></td>";
    $table_data_row.='<td width="40%" style="color:#000;height:45px;">';
    if($data->jobs_important == 3){
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:10px;height:10px" src="'.base_url().'images/jobs/project-2.png">';
    }else if($data->jobs_important == 2){
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:9px;height:11px" src="'.base_url().'images/jobs/project-3.png">';
    }else{
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:11px;height:11px" src="'.base_url().'images/jobs/project-1.png">';
    }
    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:300px;padding:8px 0 5px 0;"><a href="'.$link.'">'.$data->jobs_name.'</a></p></td>';

    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($data->jobs_start_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($data->jobs_end_date)).'</td>';

    if($data->jobs_approve == 1){
        $table_data_row.='<td id="status_no" style="color: #009900;width: 13%;text-align: left"> <img style="margin:1px 7px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/check.png"> Đã duyệt</td>';
    }else{
        $table_data_row.='<td style="color: #b81900;width: 14%;text-align: left" > <img style="margin:1px 3px 0 -8px;float:left;width:13px;height:13px" src="'.base_url().'images/jobs/no_check.png"> Chưa duyệt</td>';
    }
    
    $table_data_row.='<td width="4%" style="font-family: Arial" class="rightmost;font-size:11px">'.anchor($controller_name."/my_view/$data->jobs_id", lang('common_edit'),array('class'=>'update','title'=>lang($controller_name.'_update'))).'</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/**
 FOR TABLE EMPLOYEES NAME

 */

function get_jobs_manage_table_one($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table_employees" style="width: 220px;position: absolute;left: 263px;top: -44px;">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_employees_name'));
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
    $table.= get_jobs_manage_table_data_rows_one($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_manage_table_data_rows_one($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_jobs_data_row_one($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='2'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_data_row_one($data,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    if($data->last_name != '') $data->last_name == '';
    $link = site_url('customers/detail_customer_sale/'.$data->person_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$data->person_id' value='".$data->person_id."'/></td>";
    $table_data_row.='<td width="100%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">'.$data->first_name.'</a></td>';

    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
 *  GET JOBS MANAGER INFORMATION
 * */
function get_approve_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_my_name'),
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
    $table.= get_my_approve_manage_table_data_rows($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

function get_my_approve_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_my_approve_data_row($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_my_approve_data_row($data,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    $link = site_url('jobs_employee/detail_index_jobs/'.$data->jobs_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$data->jobs_id' value='".$data->jobs_id."'/></td>";
    $table_data_row.='<td width="25%" style="color:#000;height:60px;">';
    if($data->jobs_important == 3){
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:10px;height:10px" src="'.base_url().'images/jobs/project-2.png">';
    }else if($data->jobs_important == 2){
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:9px;height:11px" src="'.base_url().'images/jobs/project-3.png">';
    }else{
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:11px;height:11px" src="'.base_url().'images/jobs/project-1.png">';
    }
    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;"><a href="'.$link.'">'.$data->jobs_name.'</a></p></td>';

    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($data->jobs_start_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($data->jobs_end_date)).'</td>';

    if($data->jobs_approve == 1){
        $table_data_row.='<td id="status_no" style="color: #009900;width: 11%;text-align: left"> <img style="margin:1px 7px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/check.png"> Đã duyệt</td>';
    }else{
        $table_data_row.='<td style="color: #b81900;width: 11%;text-align: left" > <img style="margin:1px 3px 0 -8px;float:left;width:13px;height:13px" src="'.base_url().'images/jobs/no_check.png"> Chưa duyệt</td>';
    }

    $table_data_row.='<td width="4%" style="font-family: Arial" class="rightmost;font-size:11px">
    <form accept-charset="UTF-8" class="formApprove" method="POST" action="'.site_url('jobs_employee/save_manager_approve/'.$data->jobs_id).'">
            <input type="hidden" value="'.$data->jobs_id.'" />
            <textarea class="manager_approve_'.$data->jobs_id.'" name="approve_content" cols=15 rows=3 style="padding:3px;float:left;margin: 3px 0"></textarea>
            <button class="buttonApprove" type="submit" style="margin-top:0px;margin-bottom:5px;height: 25px;line-height:25px;cursor:pointer;width: 72px;font-size:11px">Duyệt</button>
    </form></td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}
/*
 * Function manage table
 * */
function get_approve_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_my_name'),
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
    $table.= get_approve_one_table($employees_jobs,$controller);
    $table.='</tbody></table>';
    return $table;
}

function get_approve_one_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $data)
    {
        $table_data_rows.= get_approve_one_rows_table($data,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_approve_one_rows_table($data,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));


    $link = site_url('jobs_employee/detail_index_jobs/'.$data->jobs_id);
    $table_data_row='<tr>';
    $table_data_row.="<td width='4%'><input type='checkbox' id='person_$data->jobs_id' value='".$data->jobs_id."'/></td>";
    $table_data_row.='<td width="40%" style="color:#000;height:60px;">';
    if($data->jobs_important == 3){
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:10px;height:10px" src="'.base_url().'images/jobs/project-2.png">';
    }else if($data->jobs_important == 2){
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:9px;height:11px" src="'.base_url().'images/jobs/project-3.png">';
    }else{
        $table_data_row .= '<img style="margin:12px 5px 0 -8px;float:left;width:11px;height:11px" src="'.base_url().'images/jobs/project-1.png">';
    }
    $table_data_row.= '<p style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;padding:8px 0 5px 0;min-width:300px"><a href="'.$link.'">'.$data->jobs_name.'</a></p></td>';

    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($data->jobs_start_date)).'</td>';
    $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.date(get_date_format(),strtotime($data->jobs_end_date)).'</td>';

    if($data->jobs_approve == 1){
        $table_data_row.='<td id="status_no" style="color: #009900;width: 11%;text-align: left"> <img style="margin:1px 7px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/check.png"> Đã duyệt</td>';
    }else{
        $table_data_row.='<td style="color: #b81900;width: 11%;text-align: left" > <img style="margin:1px 3px 0 -8px;float:left;width:13px;height:13px" src="'.base_url().'images/jobs/no_check.png"> Chưa duyệt</td>';
    }
    $table_data_row.='<td width="4%" style="font-family: Arial;" class="rightmost;font-size:11px"></td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}
