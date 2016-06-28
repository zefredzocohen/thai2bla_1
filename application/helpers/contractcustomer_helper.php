<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * created by Hunght
 */

//get table contract customer type
function get_contract_customer_type_manage_table($contract_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('contractcustomer_type_id'),
        lang('contractcustomer_type_name'),
        lang('contractcustomer_type_desc'),
        '');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th class='rightmost'>$header</th>";
        } else {
            $table.="<th>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_contract_customer_type_manage_table_data_rows($contract_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_contract_customer_type_manage_table_data_rows($contract_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($contract_type->result() as $contract_types) {
        $table_data_rows.=get_contract_customer_type_data_row($contract_types, $controller);
    }

    if ($contract_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_contract_customer_type_data_row($contract_types, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$contract_types->id' name='type[]' value='" . $contract_types->id . "'/></td>";
    $table_data_row.='<td width="15%" style="text-align: center">' . $contract_types->code . '</td>';
    $table_data_row.='<td width="35%">' . $contract_types->name . '</td>';
    $table_data_row.='<td width="47%">' . $contract_types->description . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$contract_types->id/width~$width/height~440", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

//get table detail contract customer
function get_contract_customer_manage_table($contract_cus, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter table_new" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('contractcustomer_code'),
        lang('contractcustomer_name'),
        lang('contractcustomer_namecus'),
        lang('contractcustomer_number'),
        lang('contractcustomer_startdate'),
        lang('contractcustomer_type'),
        '');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th class='rightmost'>$header</th>";
        } else {
            $table.="<th>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_contract_customer_manage_table_data_rows($contract_cus, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_contract_customer_manage_table_data_rows($contract_cus, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($contract_cus->result() as $contract_cuss) {
        $table_data_rows.=get_contract_customer_data_row($contract_cuss, $controller);
    }

    if ($contract_cus->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_contract_customer_data_row($contract_cuss, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='3%'style='padding 0 7px;text-align: center'><input type='checkbox' id='$contract_cuss->id' name='type[]' value='" . $contract_cuss->id . "'/></td>";
    $table_data_row.='<td width="15%"> ' . $contract_cuss->code_contract . '</td>';
    $table_data_row.='<td width="20%">' . $contract_cuss->name . '</td>';
    $table_data_row.='<td width="15%">' . $CI->Customer->get_info($contract_cuss->person_id)->first_name . " " . $CI->Customer->get_info($contract_cuss->person_id)->last_name . '</td>';
    '</td>';
    $table_data_row.='<td width="11%" style="text-align: center">' . $contract_cuss->number_contract . '</td>';
    $table_data_row.='<td width="8%">' . date('d-m-Y', strtotime($contract_cuss->start_date)) . '</td>';
    $table_data_row.='<td width="15%">' . $CI->Contractcustomers->get_info_typecontract($contract_cuss->catecontract_id)->name . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$contract_cuss->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

//get table contract employees type
function get_contract_employees_type_manage_table($contractemp_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('contractemp_type_id'),
        lang('contractemp_type_name'),
        lang('contractemp_type_desc'),
        '');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th class='rightmost'>$header</th>";
        } else {
            $table.="<th>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_contract_employees_type_manage_table_data_rows($contractemp_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_contract_employees_type_manage_table_data_rows($contractemp_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($contractemp_type->result() as $contractemp_types) {
        $table_data_rows.=get_contract_employees_type_data_row($contractemp_types, $controller);
    }

    if ($contractemp_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_contract_employees_type_data_row($contractemp_types, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$contractemp_types->id_ma_hopdong' name='type[]' value='" . $contractemp_types->id_ma_hopdong . "'/></td>";
    $table_data_row.='<td width="15%" style="text-align: center">' . $contractemp_types->code . '</td>';
    $table_data_row.='<td width="35%">' . $contractemp_types->ten_maloai_hopdong . '</td>';
    $table_data_row.='<td width="47%">' . $contractemp_types->mota_loaihopdong . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$contractemp_types->id_ma_hopdong/width~$width/height~440", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}
