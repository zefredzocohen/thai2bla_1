<?
function get_jobs_manage_table($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table='<table class="tablesorter" id="sortable_table">';

        $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_jobs_name'),
        lang('common_jobs_employees_name'),
        //lang('common_jobs_employees_name_parent'),
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
        $table.= get_jobs_manage_table_data_rows($employees_jobs,$controller);
        $table.='</tbody></table>';
    return $table;
}

/*
Gets the html data rows for the people.
*/
function get_jobs_manage_table_data_rows($employees_jobs,$controller)
{
    $CI =& get_instance();
    $table_data_rows='';

    foreach($employees_jobs->result() as $employees_jobs_info)
    {
    $table_data_rows.= get_jobs_data_row($employees_jobs_info,$controller);
    }

    if($employees_jobs->num_rows()==0)
    {
    $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;font-weight:bold;color:#333'>".lang('common_no_jobs_to_display')."</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_jobs_data_row($employees_jobs_info,$controller)
{
    $CI =& get_instance();

    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    if($employees_jobs_info->last_name != '') $employees_jobs_info->last_name == '';
    $link = site_url('customers/detail_customer_sale/'.$employees_jobs_info->person_id);
    $table_data_row='<tr>';
        $table_data_row.="<td width='4%'><input type='checkbox' id='person_$employees_jobs_info->employees_jobs_id' value='".$employees_jobs_info->employees_jobs_id."'/></td>";
        $table_data_row.='<td width="33%" style="color:#000;height:45px;">';
            if($employees_jobs_info->jobs_important == 3){
            $table_data_row .= '<img style="margin:13px 5px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/jobs_one.jpg">';
            }else if($employees_jobs_info->jobs_important == 2){
            $table_data_row .= '<img style="margin:13px 5px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/jobs_two.jpg">';
            }else{
            $table_data_row .= '<img style="margin:14px 5px 0 -8px;float:left;width:15px;height:15px" src="'.base_url().'images/jobs/jobs_3.jpg">';
            }
            $table_data_row.= '<p style="float:left;margin:-25px 0 0 13px;">'.$employees_jobs_info->jobs_name.'</p></td>';
        $table_data_row.='<td width="16%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">'.$employees_jobs_info->first_name.'</a></td>';
        //$table_data_row.='<td width="16%" ><a style="float:left;text-decoration:none;color:#000" href="'.$link.'" class="underline">'.$employees_jobs_info->first_name.'</a></td>';
        $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.substr($employees_jobs_info->jobs_start_date,0,-8).'</td>';
        $table_data_row.='<td width="13%" style="color:#000;height:45px;">'.substr($employees_jobs_info->jobs_end_date,0,-8).'</td>';
        if($employees_jobs_info->jobs_status == 0){
            $table_data_row.='<td id="status_no" style="color: #009900;width: 15%;text-align: left">Chưa bắt đầu</td>';
        }else if( $employees_jobs_info->jobs_status == 3){
             $table_data_row.='<td style="color: #b81900;width: 15%;text-align: left" > Hoàn thành </td>';
        } else if($employees_jobs_info->jobs_status == 2){
            $table_data_row.='<td style="color:#e78f08;width: 13%;text-align: left"> Sắp hết hạn </td>';
        }else{
            $table_data_row.='<td style="color: #0150D1;width: 15%;text-align: left"> Đang tiến hành </td>';
        }

        $table_data_row.='<td width="1%" style="font-family: Arial" class="rightmost">'.anchor($controller_name."/view/$employees_jobs_info->employees_jobs_id/width~$width", lang('common_edit'),array('class'=>'thickbox','title'=>lang($controller_name.'_update'))).'</td>';
        $table_data_row.='</tr>';

    return $table_data_row;
}



