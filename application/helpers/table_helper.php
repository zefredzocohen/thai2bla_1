<?php

//////////////////
/*
  Gets the html table to manage categories.
 */
function get_units_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã đơn vị',
        'Tên đơn vị',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_units_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_units_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_unit_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_unit_data_row($unit, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$unit->id_unit' value='" . $unit->id_unit . "'/></td>"; //
    $table_data_row.='<td style="text-align:center" width="23%">' . $unit->id_unit . '</td>'; //
    $table_data_row.='<td style="padding-left:25px" width="50%"><p style="width:343px">' . $unit->name . '</p></td>'; //
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$unit->id_unit/width~$width", //
                    lang('common_edit'), array(
                'class' => 'thickbox',
                'title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

///////////
//////////////////
/*
  Gets the html table to manage categories.
 */
function get_categories_manage_table($categories, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('categories_id_cat'),
        lang('categories_name'),
        lang('categories_parent_name'),
        lang('categories_image'),
        lang('categories_active'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_categories_manage_table_data_rows($categories, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_categories_manage_table_data_rows($categories, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($categories->result() as $category) {
        $table_data_rows.=get_category_data_row($category, $controller);
    }

    if ($categories->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_category_data_row($category, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $cat_name = $CI->Category->get_info($category->parentid);
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$category->id_cat' value='" . $category->id_cat . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="11%">' . $category->code_cat . '</td>';
    $table_data_row.='<td style="padding-left:25px" width="25%"><p style="width:170px">' . $category->name . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="25%"><p style="width:170px">' . $cat_name->name . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="15%"><img style="max-width:32px;max-height:32px" src="' . $category->image . '" alt="'.$category->name.'" /></td>';
    if ($category->active !=0 ) //PHP version as TRUE == chr(0x001)
        $table_data_row.='<td style="text-align:center" width="5%"><img style="max-width:30px;max-height:30px" src="images/checked.png" alt="Hiển thị" /></td>';
    else
        $table_data_row.='<td style="text-align:center" width="5%"><img style="width:15px" src="images/remove.png"/></td>';

    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$category->id_cat/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//////////////////////////////////////////////
/*
  Gets the html table to manage people.
 */
function get_emp_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter table_span" id="sortable_table" style="margin: 16px 0 0 0px;">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_empl_name'),
        lang('common_city'),
        lang('common_email'),
        lang('common_phone_number'),
        lang('common_birth_date'),
        '&nbsp');
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
    $table.= get_emp_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_emp_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_emp_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_emp_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    $start_of_time = date('d-m-Y', 0);
    $today = date('d-m-Y');
    $table_data_row = '<tr>';
    $table_data_row.="<td width='2%' style='width: 10px'><input type='checkbox' id='person_$person->person_id' value='" . $person->person_id . "'/></td>";
    $table_data_row.='<td width="18%"><p style="width:176px;" >' . $person->first_name . '&nbsp' . $person->last_name . '</p></td>';
    $table_data_row.='<td width="18%">' . $CI->City->get_info($person->city)->name . '</td>';
    $table_data_row.='<td width="23%"><p style="width:160px;">' . mailto($person->email, $person->email, array('class' => 'underline')) . '</p></td>';
    $table_data_row.='<td width="14%">' . $person->phone_number . '</td>';
    $table_data_row.='<td width="12%">' . date('d-m-Y', strtotime($person->birth_date)) . '</td>';
    $table_data_row.='<td width="2%" class="rightmost" style="text-indent: 1px">';
    $table_data_row.= anchor($controller_name . "/view/$person->person_id/width~$width", lang('common_edit'), array(
        'class' => 'thickbox edit_emp edit_emp',
        'style' => 'font-size:10px;width:50px;background: #F2F2F2;padding:5px 0;',
        'title' => lang($controller_name . '_update')
    ));
    if ($person->person_id != 1) {
        $table_data_row.= anchor($controller_name . "/permission_warehouse/$person->person_id/width~400/height~200", "Phân quyền kho", array(
            'class' => 'thickbox edit_emp edit_emp',
            'style' => 'font-size:10px;width:50px;background: #F2F2F2;padding:5px 0;',
            'title' => "Phân quyền kho"
        ));
    }
    $table_data_row.='</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

function get_customer_type_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" >';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_customer_type_id'),
        lang('common_customer_type_name'),
        lang('common_customer_type_desc'),
        'Nhóm KH - Đại lý',
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
    $table.=get_customer_type_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_customer_type_manage_table_data_rows($customer_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($customer_type->result() as $customer) {
        $table_data_rows.=get_customer_data_row($customer, $controller);
    }

    if ($customer_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_customer_data_row($customer, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$customer->customer_type_id' name='type[]' value='" . $customer->customer_type_id . "'/></td>";
    $table_data_row.='<td width="18%" style="text-align: center">' . $customer->code . '</td>';
    $table_data_row.='<td width="20%">' . $customer->name . '</td>';
    $table_data_row.='<td width="45%">' . $customer->desc . '</td>';
    if ($customer->status_agent == 0) {
        $stt = "Nhóm KH";
    } else {
        $stt = "<font color='red'>Nhóm Đại lý</font>";
    }
    $table_data_row.='<td width="40%">' . $stt . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$customer->customer_type_id/width~$width", lang('common_edit'), array(
                'class' => 'thickbox',
                'title' => lang($controller_name . '_update')
                    )
            ) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* Get the table to manage timekeeping */

function get_timekeeping_manage_table($timekeeping, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter_one" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('timekeeping_id'),
        lang('timekeeping_name'),
        lang('timekeeping_dates'),
        lang('timekeeping_items'),
        lang('timekeeping_description'),
        '');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_timekeeping_manage_table_data_rows($timekeeping, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_timekeeping_manage_table_data_rows($timekeeping, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($timekeeping->result() as $timekeepingday) {
        $table_data_rows.=get_timekeeping_data_row($timekeepingday, $controller);
    }

    if ($timekeeping->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_timekeeping_data_row($timekeepingday, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $person_info = $controller->get_info_employees();
    $config_info = $controller->get_all_salary_config();

    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='2%'><input type='checkbox' id='person_$timekeepingday->id' value='" . $timekeepingday->id . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="8%">' . $timekeepingday->id . '</td>';
    foreach ($person_info AS $k => $values) {
        if ($values->person_id == $timekeepingday->person_id) {
            $table_data_row.='<td style="text-align:left" width="22%">' . $values->first_name . '</td>';
        }
    }
    $table_data_row.='<td style="text-align: center" width="12%">' . date('d-m-Y', strtotime($timekeepingday->day_keeping)) . '</td>';
    foreach ($config_info AS $k => $values) {
        if ($values['id'] == $timekeepingday->salaryconfig_id) {
            $table_data_row.='<td style="text-align:center;font-size: 11px" width="9%">' . $values['name'] . '</td>';
        }
    }
    foreach ($config_info AS $k => $values) {
        if ($values['id'] == $timekeepingday->salaryconfig_id) {
            $table_data_row.='<td style="text-align:left;" width="30%">' . $values['description'] . '</td>';
        }
    }

    $table_data_row.='<td style="text-align:center" width="1%" class="rightmost">' . anchor($controller_name . "/view/$timekeepingday->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
  Gets the html table to manage mail.
 */

function get_mail_manage_table($mail, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Tiêu đề',
        'Nội dung',
        '&nbsp');
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
    $table.=get_mail_manage_table_data_rows($mail, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the mail.
 */

function get_mail_manage_table_data_rows($mail, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($mail->result() as $m) {
        $table_data_rows.=get_mail_data_row($m, $controller);
    }

    if ($mail->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_mail_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_mail_data_row($mail, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='mail_$mail->mail_id' value='" . $mail->mail_id . "'/></td>";
    $table_data_row.='<td width="30%">' . $mail->mail_title . '</a></td>';
    $table_data_row.='<td width="60%">' . substr($mail->mail_content, 0, 20) . '...</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view_mail/$mail->mail_id", lang('common_edit'), array('title' => ' Sửa mail')) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

//hop dong

function get_hopdong_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('contracts_id'),
        lang('contracts_ma'),
        lang('contracts_employee'),
        lang('contracts_file'),
        lang('contracts_type'),
        lang('contracts_start_date'),
        lang('contracts_end_date'),
        '&nbsp');
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
    $table.=get_hopdong_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_hopdong_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_hopdong_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_hopdong_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link = "./file/" . $person->file_name;
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->id' value='" . $person->id_hopdong . "'/></td>";
    $table_data_row.='<td width="5%">' . $person->id_hopdong . '</td>';
    $table_data_row.='<td width="10%">' . $person->ma_hopdong . '</td>';
    $table_data_row.='<td width="18%">' . $CI->Employee->get_info($person->id_employess)->first_name . '</td>';
    $table_data_row.='<td width="15%" style="color:#000;height:45px;"><a href=' . $link . ' style="display:inline-block;margin:0px 0 0 2px;min-height:20px;height:auto;float:left;width:120px;padding:8px 0 5px 0;text-decoration:underline;color:blue">' . $CI->Employee->get_info_contractemp($person->id_employess)->labor_contract . '</a></td>';
    $table_data_row.='<td width="15%">' . $CI->Contractemp_types->get_info_typeempcontract($person->loai_hopdong)->ten_maloai_hopdong . '</td>';
    $table_data_row.='<td width="12%">' . $person->date_start . '</td>';
    $table_data_row.='<td width="12%">' . $person->date_end . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$person->id_hopdong/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update')))
            . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* End table helper hopdog */
/* Begin table helper of Visa */

function get_visa_manage_table($abouts, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('visa_id'),
        lang('visa_name'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_visa_manage_table_data_rows($abouts, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_visa_manage_table_data_rows($abouts, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($abouts->result() as $about) {
        $table_data_rows.=get_visa_data_row($about, $controller);
    }
    if ($abouts->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_visa_data_row($about, $controller) {

    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    //$width = $controller->get_form_width();   die('ff0');
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='3%'>
    <input type='checkbox' id='person_$about->id_education' value='" . $about->id_visa . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="2%">' . $about->id_visa . '</td>';

    $table_data_row.='<td style="padding-left:8px;text-align: center;" width="10%">' . $about->name_visa . '</td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$about->id_visa/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/* End table helper of Visa */
/* Begin table helper of language */

function get_language_manage_table($abouts, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('bangcap_id'),
        lang('bangcap_name'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_language_manage_table_data_rows($abouts, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_language_manage_table_data_rows($abouts, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($abouts->result() as $about) {
        $table_data_rows.=get_language_data_row($about, $controller);
    }
    if ($abouts->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_language_data_row($about, $controller) {

    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    //$width = $controller->get_form_width();   die('ff0');
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='3%'>
    <input type='checkbox' id='person_$about->id_education' value='" . $about->id_language . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="2%">' . $about->id_language . '</td>';

    $table_data_row.='<td style="padding-left:8px;text-align: center;" width="10%">' . $about->name_language . '</td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/" . $about->id_language . "/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/* End table helper of language */
/* Begin table helper of tinhoc */

function get_tinhoc_manage_table($abouts, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('tinhoc_id'),
        lang('tinhoc_name'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_tinhoc_manage_table_data_rows($abouts, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_tinhoc_manage_table_data_rows($abouts, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($abouts->result() as $about) {
        $table_data_rows.=get_tinhoc_data_row($about, $controller);
    }
    if ($abouts->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_tinhoc_data_row($about, $controller) {

    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    //$width = $controller->get_form_width();   die('ff0');
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='3%'>
    <input type='checkbox' id='person_$about->id_education' value='" . $about->id_tinhoc . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="2%">' . $about->id_tinhoc . '</td>';
    $table_data_row.='<td style="padding-left:8px;text-align: center;" width="10%">' . $about->chungchi_tinhoc . '</td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$about->id_tinhoc/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/* End table helper of tinhoc */

/* Begin table helper of bangcap */

function get_bangcap_manage_table($abouts, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('bangcap_id'),
        lang('bangcap_name'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_bangcap_manage_table_data_rows($abouts, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_bangcap_manage_table_data_rows($abouts, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($abouts->result() as $about) {
        $table_data_rows.=get_bangcap_data_row($about, $controller);
    }
    if ($abouts->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_bangcap_data_row($about, $controller) {

    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    //$width = $controller->get_form_width();   die('ff0');
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='3%'>
    <input type='checkbox' id='person_$about->id_tinhoc' value='" . $about->id_bangcap . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="2%">' . $about->id_bangcap . '</td>';
    $table_data_row.='<td style="padding-left:8px;text-align: center;" width="10%">' . $about->nam_bangcap . '</td>';

    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/" . $about->id_bangcap . "/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/* End table helper of bangcap */

function get_education_manage_table($abouts, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('education_id'),
        lang('education_name'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_educations_manage_table_data_rows($abouts, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_educations_manage_table_data_rows($abouts, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($abouts->result() as $about) {
        $table_data_rows.=get_education_data_row($about, $controller);
    }
    if ($abouts->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_education_data_row($about, $controller) {

    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    //$width = $controller->get_form_width();   die('ff0');
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='3%'>
    <input type='checkbox' id='person_$about->id_education' value='" . $about->id . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="2%">' . $about->id . '</td>';
    $table_data_row.='<td style="padding-left:8px;text-align: center;" width="10%">' . $about->name_education . '</td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$about->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
  Gets the html table to manage abouts.
 */
/* Begin education */

/* End education */

function get_profit_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_formula'),
        lang('common_input1'),
        lang('common_input7'),
        lang('common_input8'),
        '&nbsp');
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
    $table.=get_profit_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_profit_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_profit_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_profit_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    //if($person->last_name == 0){$person->last_name = null;}
    $start_of_time = date('d-m-Y', 0);
    $today = date('d-m-Y');
    //$link = site_url('customers/detail_customer_sale/'.$person->id);
    $link = site_url('profit/detail_profit/' . $person->id);
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->id' value='" . $person->id . "'/></td>";
    $table_data_row.='<td width="15%"><a href="' . $link . '"  class="underline">' . $person->formula_name . '</a></td>';
    //$table_data_row.='<td width="15%">'.$CI->City->get_info($person->city)->name.'</td>';
    //$table_data_row.='<td width="30%">'.mailto($person->email,$person->email, array('class' => 'underline')).'</td>';
    $table_data_row.='<td width="15%">' . $person->name . '</td>';
    $table_data_row.='<td width="15%">' . $person->estimated_number . '</td>';
    $table_data_row.='<td width="15%">' . $person->transport . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$person->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update')))
            //.anchor("costs/add_new_cost/$person->id/width~$width", lang('common_cost'),array('class'=>'thickbox','title'=>'Thực hiện thu chi'))
            . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

function get_abouts_manage_table($abouts, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('abouts_id'),
        lang('abouts_website'),
        lang('abouts_phone_number'),
        lang('abouts_email'),
        lang('abouts_address'),
        lang('abouts_name_eployee'),
        //lang('abouts_yahoo'),
        lang('abouts_skype'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_abouts_manage_table_data_rows($abouts, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_abouts_manage_table_data_rows($abouts, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($abouts->result() as $about) {
        $table_data_rows.=get_about_data_row($about, $controller);
    }

    if ($abouts->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_about_data_row($about, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='3%'><input type='checkbox' id='person_$about->id' value='" . $about->id . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="12%">' . $about->id . '</td>';

    $table_data_row.='<td style="padding-left:8px" width="20%">' . $about->website . '</td>';
    $table_data_row.='<td style="padding-left:8px" width="5%">' . $about->phone_number . '</td>';
    $table_data_row.='<td style="padding-left:8px" width="10%">' . $about->email . '</td>';
    $table_data_row.='<td style="padding-left:8px" width="20%">' . $about->address . '</td>';
    $table_data_row.='<td style="padding-left:8px" width="15%">' . $about->name_eployee . '</td>';
    //$table_data_row.='<td style="padding-left:25px" width="10%">'.$about->yahoo.'</td>';
    $table_data_row.='<td style="padding-left:8px" width="13%">' . $about->skype . '</td>';

    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$about->id_cat/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_slides_manage_table($slides, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('slider_id'),
        lang('slider_name'),
        lang('slider_img'),
        lang('slider_description'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_slides_manage_table_data_rows($slides, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_slides_manage_table_data_rows($slides, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($slides->result() as $slide) {
        $table_data_rows.=get_slide_data_row($slide, $controller);
    }

    if ($slides->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_slide_data_row($slide, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$slide->id' value='" . $slide->id . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="15%">' . $slide->id . '</td>';
    $table_data_row.='<td style="padding-left:20px" width="28%"><p style="width:230px">' . $slide->name . '</p></td>';
    $table_data_row.="<td style='padding-left:20px' width='20%'><img class='ImgList' style='width:156px; height:60px; margin:5px 0 5px 10px;' src='" . base_url(). $slide->img . "'/></td>";
    $table_data_row.='<td style="padding-left:20px" width="28%"><p style="width:170px">' . $slide->description . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="5%" class="rightmost">' . anchor($controller_name . "/view/$slide->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//////////////////
/*SLIDER_COOKER begin*/
function get_slide_manage_table($slides, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array(
        lang('slider_name'),
        lang('slider_img'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_slide_manage_table_data_rows($slides, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_slide_manage_table_data_rows($slides, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($slides->result() as $slide) {
        $table_data_rows.=get_slide_cooker_data_row($slide, $controller);
    }

    if ($slides->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}
function get_slide_cooker_data_row($slide, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.='<td style="padding-left:20px" width="10%"><p style="width:80px">' . $slide->name . '</p></td>';
    $table_data_row.="<td style='padding-left:20px' width='50%'><img class='ImgList' style='width:300px; height:150px; margin:5px 0 5px 10px;' src='" . base_url(). $slide->img . "'/></td>";
    // $table_data_row.='<td style="padding-left:20px" width="30%"><p style="width:170px">' . $slide->description . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="5%" class="rightmost">' . anchor($controller_name . "/view/$slide->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

////////SLIDER_COOKER end //////////
/*
  Gets the html table to manage part.
 */
function get_part_manage_table($part, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('part_id_cat'),
        lang('categories_name'),
        lang('categories_image'),
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_part_manage_table_data_rows($part, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the part.
 */

function get_part_manage_table_data_rows($part, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($part->result() as $category) {
        $table_data_rows.=get_category_data_row($category, $controller);
    }

    if ($part->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_part_data_row($category, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$category->id_cat' value='" . $category->id_cat . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="23%">' . $category->id_cat . '</td>';
    $table_data_row.='<td style="padding-left:25px" width="50%"><p style="width:343px">' . $category->name . '</p></td>';
    $table_data_row.="<td style='padding-left:25px' width='25%'><img class='ImgList' style='width:60px; height:60px; margin:5px 0 5px 5px;' src='http://localhost:8888/pos2014/NEWPOS_2014/front-end/" . $category->anh . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$category->id_cat/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
  Gets the html table to manage people.
 */
function get_people_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" style="">';
    $headers = array('<input style="margin-left: 2px" type="checkbox" id="select_all" />',
        lang('common_name_company'),
        lang('common_namecus'),
        lang('common_email'),
        lang('common_phone_number1'),
        lang('common_adress'),
        '&nbsp');
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
    $table.=get_people_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_people_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_person_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_person_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $start_of_time = date('d-m-Y', 0);
    $today = date('d-m-Y');
    $phone1 = "";
    if ($person->phone == '' && $person->phone_number == '') {
        $phone1 = "";
    } elseif ($person->phone_number == '') {
        $phone1 = "Máy bàn:" . $person->phone;
    } elseif ($person->phone != '' && $person->phone != '') {
        $phone1 = "DĐ:" . $person->phone_number . ' <br/> ' . "Máy bàn:" . $person->phone;
    } elseif ($person->phone == '') {
        $phone1 = "DĐ:" . $person->phone_number;
    }
    $link = site_url('customers/detail_customer_sale/' . $person->person_id);
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='" . $person->person_id . "'/></td>";
    $table_data_row.='<td width="12%"><div style="width:120px"><a href="' . $link . '" class="underline">' . $person->company_name . '</div></td>';
    $table_data_row.='<td width="20%"><p style="width:120px;"><a href="' . $link . '" class="underline">' . $person->first_name . ' ' . $person->last_name . '</a></p></td>';
    $table_data_row.='<td width="23%"><p style="width:100px;">' . mailto($person->email, $person->email, array('class' => 'underline')) . '</p></td>';
    $table_data_row.='<td width="10%"><div style="width:130px">' . $phone1 . '</div></td>';
    $table_data_row.='<td width="11%"><div style="width: 100px">' . $person->address_1 . '</div></td>';
    $table_data_row.='<td width="6%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$person->person_id/width~755", lang('common_edit'), array(
                'class' => 'thickbox',
                'style' => 'font-size :11px;;background: #F2F2F2;border-bottom:1px solid #FFF;display:block;text-align:center;width:52px;overflow: hidden;font-weight:bold;padding:5px;text-align: center',
                'title' => lang($controller_name . '_update')
                    )
            )
            . anchor("costs/add_new_cost/$person->person_id/width~$width", lang('common_cost'), array('class' => 'thickbox', 'style' => 'font-size :11px;display:block;text-align:center;width:52px;overflow: hidden;background: #F2F2F2;font-weight:bold;text-align: center', 'title' => 'Thực hiện thu chi'))
            . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/*
  Gets the html table to manage suppliers.
 */

function get_supplier_manage_table($suppliers, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã nhà cung cấp',
        lang('suppliers_company_name'),
        lang('common_first_name'),
        lang('common_email'),
        lang('common_phone_number'),
        '&nbsp');
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
    $table.=get_supplier_manage_table_data_rows($suppliers, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the supplier.
 */

function get_supplier_manage_table_data_rows($suppliers, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($suppliers->result() as $supplier) {
        $table_data_rows.=get_supplier_data_row($supplier, $controller);
    }

    if ($suppliers->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='8'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_supplier_data_row($supplier, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='person_$supplier->person_id' value='" . $supplier->person_id . "'/></td>";
    $table_data_row.='<td width="10%"><p style="width:100px">' . $supplier->account_number . '</p></td>';
    $table_data_row.='<td width="25%"><p style="width:100px">' . anchor("suppliers/detail_supplier/$supplier->person_id", $supplier->company_name, array('class' => ' new', 'title' => 'Lịch sử giao dịch')) . '</a></p></td>';
    $table_data_row.='<td width="25%"><p style="width:100px">' . $supplier->first_name . ' ' . $supplier->last_name . '</p></td>';
    $table_data_row.='<td width="25%"><p style="width:125px">' . mailto($supplier->email, $supplier->email) . '</p></td>';
    $table_data_row.='<td width="15%">' . $supplier->phone_number . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$supplier->person_id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update')))
            . anchor("costs/add_new_cost/$supplier->person_id/width~$width", lang('common_cost'), array('class' => 'thickbox', 'title' => 'Thực hiện thu chi'))
            . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/*
  Gets the html table to manage items.
 */

function get_items_manage_table($items, $controller) {
    $CI = & get_instance();
    $has_cost_price_permission = $CI->Employee->has_module_action_permission('items', 'see_cost_price', $CI->Employee->get_logged_in_employee_info()->person_id);
    $table = '<table class="tablesorter table_one" id="sortable_table">';

    $headers = array(
        '<input style="margin-left: 8px" type="checkbox" id="select_all" />',
        $CI->lang->line('items_item_number'),
        $CI->lang->line('items_name'),
        $CI->lang->line('View Home'),
        $CI->lang->line('items_images'),
        "ĐVT",
        $CI->lang->line('items_category'),
        $CI->lang->line('items_unit_price'),
        'SL trong kho',
        'SL kho tổng',
        'Tổng SL',
        '&nbsp;'
    );

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
    $table.=get_items_manage_table_data_rows($items, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the items.
 */

function get_items_manage_table_data_rows($items, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($items->result() as $item) {
        $table_data_rows.=get_item_data_row($item, $controller);
    }

    if ($items->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('items_no_items_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_item_data_row($item, $controller) {
    $CI = & get_instance();
    $has_cost_price_permission = $CI->Employee->has_module_action_permission('items', 'see_cost_price', $CI->Employee->get_logged_in_employee_info()->person_id);
    $item_tax_info = $CI->Item_taxes->get_info($item->item_id);
    $tax_percents = '';
    foreach ($item_tax_info as $tax_info) {
        $tax_percents.=$tax_info['percent'] . '%, ';
    }
    $tax_percents = substr($tax_percents, 0, -2);
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $cat_name = $CI->Category->get_info($item->category);
    $unit = $CI->Unit->get_info($item->unit);
    $link_image = base_url() . 'item/' . $item->images;
    $no_image = base_url() . 'images/noImage.gif';
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%' style='text-align: center'><input type='checkbox' id='item_$item->item_id' value='" . $item->item_id . "'/></td>";
    $table_data_row.="<td width='10%' style='text-align: center'>"
            . anchor(
                    $controller_name . "/count_details/$item->item_id", $item->item_number, array('title' => lang($controller_name . '_details_count'))
            ) . "</td>";
    $table_data_row.='<td width="20%">' . $item->name . '</td>';


    if ($item->product_view_home != 0) {
        $table_data_row.='<td width="5%" style="height: 35px; text-align:center;"><img style="width:15px" src="images/checked.png" /></td>';
    } else {
        $table_data_row.='<td width="5%" style="height: 35px;text-align:center"><img style="width:15px" src="images/remove.png"/></td>';
    }




    if ($item->images != null) {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $link_image . '" /></td>';
    } else {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $no_image . '" /></td>';
    }
    $table_data_row .= "<td>" . $unit->name . "</td>";
    $table_data_row.='<td width="18%">' . $cat_name->name . '</td>';
    $price = $item->quantity_first == 1 ? $item->unit_price_rate : $item->unit_price;
    $table_data_row.='<td width="10%" style="text-align: right;">' . number_format($price) . '</td>';
    $table_data_row.='<td width="7%" style="text-align: right;">' . format_quantity($item->quantity_warehouse) . '</td>';
    $table_data_row.='<td width="11%" style="text-align: right;">' . format_quantity($item->quantity_total) . '</td>';
    $table_data_row.='<td width="7%" style="text-align: right;">' . anchor($controller_name . "/detail_quantity_item/$item->item_id/width~500/height~500", format_quantity($item->quantity), array('class' => 'thickbox', 'title' => 'Chi tiết số lượng')) . '</td>';
    $table_data_row.='<td width="8%" style="text-align: center;">'
            . anchor(
                    $controller_name . "/view/$item->item_id/width~860", lang('common_edit'), array('class' => 'thickbox', 'style' => 'background: none', 'title' => lang($controller_name . '_update'))
            ) . '<br>'
            . anchor(
                    $controller_name . "/technical/$item->item_id", 'TS kỹ thuật', array(
                'title' => lang($controller_name . '_technical'),
                'style' => 'color: green !important'
                    )
            ) . '</td>'; //inventory details
    $table_data_row.='</tr>';
    return $table_data_row;
}

/*
  Gets the html table to manage costs.
 */

function get_costs_manage_table($costs, $controller) {
    $CI = & get_instance();

    $table = '<table class="tablesorter table_one" id="sortable_table">';

    $headers = array('<input type="checkbox" style="margin-left: 4px" id="select_all" />',
        '' . $CI->lang->line('costs_date'),
        'Số CT',
        'Ngày CT',
        '&nbsp' . $CI->lang->line('costs_name'),
        'TK nợ',
        'TK có',
        'Tên KH - NCC - NV',
        'Nhân viên',
        'Số tiền',
        'Hình thức',
        '&nbsp;'
    );

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
    $table.=get_costs_manage_table_data_rows($costs, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the costs.
 */

function get_costs_manage_table_data_rows($costs, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($costs->result() as $cost) {
        $table_data_rows.=get_costs_data_row($cost, $controller);
    }

    if ($costs->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>" . lang('no_cost_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_costs_data_row($cost, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $cost_id = $CI->Cost->get_info_name($cost->name);
    $table_data_row = '<tr>';

    $table_data_row.="<td width='1%' style='padding: 0 3px!important'><input type='checkbox' id='item_$cost->id_cost' value='" . $cost->id_cost . "'/></td>";
    $table_data_row.='<td width="10%">' . date('d-m-Y H:i:s', strtotime($cost->date)) . '</td>';
    $table_data_row.='<td width="7%">' . $cost->id_cost . '</td>';
    $table_data_row.='<td width="13%" style="text-align: center">' . date('d-m-Y', strtotime($cost->cost_date_ct)) . '</td>';
    $table_data_row.='<td width="18%">' . $cost->comment . '</td>';
    $table_data_row.='<td width="7%" style="text-align: center">' . $cost->tk_no . '</td>';
    $table_data_row.='<td width="7%" style="text-align: center">' . $cost->tk_co . '</td>';

    if ($CI->Customer->exists($cost->id_customer)) {
        $table_data_row.='<td width="17%">' . $CI->Person->get_info($cost->id_customer)->first_name
                . ' ' . $CI->Person->get_info($cost->id_customer)->last_name . '</td>';
    } else if ($CI->Supplier->exists($cost->supplier_id)) {
        $table_data_row.='<td width="17%">' . $CI->Supplier->get_info($cost->supplier_id)->company_name . '</td>';
    } else if ($CI->Employee->exists($cost->employees_id)) {
        $table_data_row.='<td width="17%">' . $CI->Person->get_info($cost->employees_id)->first_name
                . ' ' . $CI->Person->get_info($cost->employees_id)->last_name . '</td>';
    } else {
        $table_data_row.='<td width="17%">' . $CI->Person->get_info($cost->id_customer)->first_name
                . ' ' . $CI->Person->get_info($cost->id_customer)->last_name . '</td>';
    }
    if($cost->form_cost == 0){
        $table_data_row.='<td width="17%">' . $CI->Person->get_info($cost->cost_employees)->first_name
                . ' ' . $CI->Person->get_info($cost->cost_employees)->last_name . '</td>';

//                                                $t = $CI->Sale->get_info($cost->id_sale)->row()->later_cost_price;
//                                                 $data_sale_payment1 = $CI->Sale->get_payment_sale_by_sale_id($cost->id_sale);
//                                                    $to = 0; //Tiền khách còn nợ của đơn hàng tương ứng
//                                                    $do = 0; //Tiền chiết khấu cho khách hàng của đơn hàng tương ứng
//                                                    foreach ($data_sale_payment1 as $val1) {
//                                                        $to = $to + $val1['payment_amount'];
//                                                        $do = $do + $val1['discount_money'];
//                                                    }
//                                        if($cost->money > ($t-$to-$do)){
//                                            $dungchip_depzai = $t-$to-$do;
//                                        }else{
//                                            $dungchip_depzai = $cost->money;
//                                        }
        $table_data_row.='<td width="10%" style="text-align: right">' .number_format($cost->money) . '</td>';
    }else{
        $table_data_row.='<td width="17%">' . $CI->Person->get_info($cost->cost_employees)->first_name
                . ' ' . $CI->Person->get_info($cost->cost_employees)->last_name . '</td>';

//                                                $t = $CI->Receiving->get_info($cost->id_receiving)->row()->later_cost_price;
//                                                 $data_sale_payment1 = $CI->Sale->get_payment_receiving_by_receiving_id($cost->id_receiving);
//                                                    $to = 0; //Tiền khách còn nợ của đơn hàng tương ứng
//                                                    $do = 0; //Tiền chiết khấu cho khách hàng của đơn hàng tương ứng
//                                                    foreach ($data_sale_payment1 as $val1) {
//                                                        $to = $to + $val1['payment_amount'];
//                                                        $do = $do + $val1['discount_money'];
//                                                    }
//                                        if($cost->money > ($t-$to-$do)){
//                                            $dungchip_depzai = $t-$to-$do;
//                                        }else{
//                                            $dungchip_depzai = $cost->money;
//                                        }
        $table_data_row.='<td width="10%" style="text-align: right">' .number_format($cost->money) . '</td>';
    }
    if ($cost->form_cost == 0) {
        $table_data_row.='<td width="8%"> Thu </td>';
    } else {
        $table_data_row.='<td width="8%"> Chi </td>';
    }
    $image = '<img title="Cập nhật thông tin thu chi" src="' . base_url() . "images/pieces/edit.png" . '"/>';
    $exel_export = "<img title='Xuất excel' src='" . base_url() . "images/pieces/exel.png'/>";
    $print = '<img title="In hóa đơn" src="' . base_url() . "images/pieces/print.png" . '"/>';
    $table_data_row.='<td style="width: 10%;" class="rightmost_one">' . anchor($controller_name . "/view/$cost->id_cost/width~$width", $image, array('title' => lang($controller_name . '_update'), 'style' => 'margin-top: 2px;')) . anchor("costs/export_cost_one/$cost->id_cost ", $exel_export, array('style' => 'margin: 5px 0px;'));
    $table_data_row.= "<a style='margin: 0px 0px 10px 0px;' title='In phiếu' target='_black' href='" . site_url() . "/costs/print_bill/" . $cost->id_cost . "'>$print</a>";
    $table_data_row.='</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/*
  Gets the html table to manage giftcards.
 */

function get_giftcards_manage_table($giftcards, $controller) {
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        lang('giftcards_giftcard_number'),
        lang('giftcards_card_value'),
        lang('giftcards_customer_name'),
        '&nbsp',
    );

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
    $table.=get_giftcards_manage_table_data_rows($giftcards, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the giftcard.
 */

function get_giftcards_manage_table_data_rows($giftcards, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($giftcards->result() as $giftcard) {
        $table_data_rows.=get_giftcard_data_row($giftcard, $controller);
    }

    if ($giftcards->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('giftcards_no_giftcards_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_giftcard_data_row($giftcard, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link = site_url('reports/detailed_' . $controller_name . '/' . $giftcard->customer_id . '/0');
    $cust_info = $CI->Customer->get_info($giftcard->customer_id);

    $table_data_row = '<tr>';
    $table_data_row.="<td width='3%'><input type='checkbox' id='giftcard_$giftcard->giftcard_id' value='" . $giftcard->giftcard_id . "'/></td>";
    $table_data_row.='<td width="15%">' . $giftcard->giftcard_number . '</td>';
    $table_data_row.='<td width="20%">' . to_currency($giftcard->value) . '</td>';
    $table_data_row.='<td width="15%"><a class="underline" href="' . $link . '">' . $cust_info->first_name . ' ' . $cust_info->last_name . '</a></td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$giftcard->giftcard_id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';

    $table_data_row.='</tr>';
    return $table_data_row;
}

/*
  Gets the html table to manage item kits.
 */

function get_item_kits_manage_table($item_kits, $controller) {
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã sản phẩm',
        lang('item_kits_name'),
        'Ảnh',
        lang('item_kits_description'),
        'ĐVT',
        lang('items_unit_price'),
        'Trạng thái',
        '&nbsp',
    );

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
    $table.=get_item_kits_manage_table_data_rows($item_kits, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the item kits.
 */

function get_item_kits_manage_table_data_rows($item_kits, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($item_kits->result() as $item_kit) {
        $table_data_rows.=get_item_kit_data_row($item_kit, $controller);
    }

    if ($item_kits->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('item_kits_no_item_kits_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_item_kit_data_row($item_kit, $controller) {
    $CI = & get_instance();
    $item_kit_tax_info = $CI->Item_kit_taxes->get_info($item_kit->item_kit_id);
    $tax_percents = '';
    foreach ($item_kit_tax_info as $tax_info) {
        $tax_percents.=$tax_info['percent'] . '%, ';
    }
    $tax_percents = substr($tax_percents, 0, -2);
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $images_kit = base_url() . 'item_kit/design_template/' . $item_kit->images;
    $no_image = base_url() . 'images/noImage.gif';

    $table_data_row = '<tr>';
    $table_data_row.="<td width='3%'><input type='checkbox' id='item_kit_$item_kit->item_kit_id' value='" . $item_kit->item_kit_id . "'/></td>";
    $table_data_row.='<td width="10%">' . $item_kit->item_kit_number . '</td>';
    $table_data_row.='<td width="15%">' . $item_kit->name . '</td>';
    if ($item_kit->images != null) {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $images_kit . '" /></td>';
    } else {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $no_image . '" /></td>';
    }
    $table_data_row.='<td width="20%">' . $item_kit->description . '</td>';
    $table_data_row .= "<td>" . $CI->Unit->get_info($item_kit->unit)->name . "</td>";
    $table_data_row.='<td width="10%" align="right">'
            . (!is_null($item_kit->unit_price) ? to_currency($item_kit->unit_price) : '')
            . '</td>';
    if ($item_kit->status == 1) {
        $status = "Đang thiết kế mẫu";
    } else if ($item_kit->status == 2) {
        $status = "Đang sản xuất mẫu";
    } else if ($item_kit->status == 3) {
        $status = "Duyệt sản xuất";
    } else if ($item_kit->status == 4) {
        $status = "Đang sản xuất";
    } else if ($item_kit->status == 5) {
        $status = "Hoàn thành";
    }
    $table_data_row.="<td width='18%'>$status</td>";
    $table_data_row.='<td width="15%" class="rightmost" >';
    $table_data_row.= anchor(
            $controller_name . "/design_template_item_kits/$item_kit->item_kit_id", 'Quản lý mẫu TK', array(
        'id' => 'link_underline',
        'title' => 'Quản lý mẫu TK',
        'style' => 'width: 100px; text-align: left; margin-left: 3px"'
            )
    );
    $table_data_row.= anchor(
            $controller_name . "/view_estimate/$item_kit->item_kit_id", 'Quản lý mẫu SX', array(
        'id' => 'link_underline',
        'title' => 'Quản lý mẫu SX',
        'style' => 'width: 100px; text-align: left; margin-left: 3px'
            )
    );
    $table_data_row.= anchor(
            $controller_name . "/switch_request_production/$item_kit->item_kit_id", 'Yêu cầu sản xuất', array(
        'id' => 'link_underline',
        'title' => 'Yêu cầu sản xuất',
        'style' => 'width: 100px; text-align: left; margin-left: 3px'
            )
    );
    $table_data_row.= anchor(
            $controller_name . "/switch_item_kits/$item_kit->item_kit_id", 'Quản lý sản xuất', array(
        'id' => 'link_underline',
        'title' => 'Quản lý sản xuất',
        'style' => 'width: 100px; text-align: left; margin-left: 3px'
            )
    );
    $table_data_row.= anchor(
            $controller_name . "/view_cost_price/$item_kit->item_kit_id/width~456", 'Tính giá vốn', array(
        'id' => 'link_underline',
        'class' => 'thickbox',
        'title' => 'Tính giá vốn',
        'style' => 'width: 100px; text-align: left; margin-left: 3px'
            )
    );
    $table_data_row.=anchor(
            $controller_name . "/view/$item_kit->item_kit_id/width~$width", lang('common_edit'), array(
        'id' => 'link_underline',
        'class' => 'thickbox',
        'title' => lang($controller_name . '_update'),
        'style' => 'width: 100px; text-align: left; margin-left: 3px'
            )
    );
    $table_data_row.='</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* long.dk */
/* chung tu */

function get_chungtu_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        'Số CT',
        'Ngày CT',
        'Diễn giải',
        'Đối tượng',
        '&nbsp');
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
    $table.=get_chungtu_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_chungtu_manage_table_data_rows($var_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($var_type->result() as $customer) {
        $table_data_rows.=get_chungtu_data_row($customer, $controller);
    }

    if ($var_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

//    --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@
//        HAPPY WOMEN'S DAY VIETNAM 20/10/15
//        from Hưng Audi
function get_chungtu_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    if($CI->Supplier->exists($var->name))
        $person_name = $CI->Supplier->get_info($var->name)->company_name;
    elseif($CI->Customer->exists($var->name))
        $person_name = $CI->Customer->get_info($var->name)->first_name.' '.$CI->Customer->get_info($var->name)->last_name;
    elseif($CI->Employee->exists($var->name))
        $person_name = $CI->Employee->get_info($var->name)->first_name.' '.$CI->Employee->get_info($var->name)->last_name;

    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->id' name='type[]' value='" . $var->id . "'/></td>";
    $table_data_row.='<td width="5%" style="text-align: center">' . $var->id . '</td>';
    $table_data_row.='<td width="12%" style="text-align: center">' . $var->create_date . '</td>';
    $table_data_row.='<td width="50%">' . $var->noidung . '</td>';
    $table_data_row.='<td width="30%">'. $person_name.'</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$var->id/width~678", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end chung tu */
/* dttc */

function get_dttc_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_id_dttcs'),
        lang('common_name_dttcs'),
        '&nbsp');
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
    $table.=get_dttc_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_dttc_manage_table_data_rows($customer_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($customer_type->result() as $customer) {
        $table_data_rows.=get_dttc_data_row($customer, $controller);
    }

    if ($customer_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_dttc_data_row($customer, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$customer->id' name='type[]' value='" . $customer->id . "'/></td>";
    $table_data_row.='<td width="12%" style="text-align: center">' . $customer->id . '</td>';
    $table_data_row.='<td width="85%"><a href="dttcs/lapkehoach/' . $customer->id . '">' . $customer->name . '</a></td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$customer->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end dttc */
/* tài sản */

function get_asset_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_asset_id'),
        lang('common_asset_name'),
        '&nbsp');
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
    $table.=get_asset_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_asset_manage_table_data_rows($customer_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($customer_type->result() as $customer) {
        $table_data_rows.=get_asset_data_row($customer, $controller);
    }

    if ($customer_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_asset_data_row($customer, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='$customer->id' name='type[]' value='" . $customer->id . "'/></td>";
    $table_data_row.='<td width="10%" style="text-align: center">' . $customer->asset_number . '</td>';
    $table_data_row.='<td width="70%">' . $customer->name . '</td>';
    $table_data_row.='<td width="15%" class="rightmost">'
        . anchor(
            $controller_name . "/view/$customer->id/width~$width",
            lang('common_edit'),
            array(
                'class' => 'thickbox',
                'style' => 'width: 88px',
                'title' => lang($controller_name . '_update')
            )
        )
        . anchor(
            $controller_name . "/allocate/$customer->id/width~345",
            'Ngừng phân bổ',
            array(
                'class' => 'thickbox',
                'style' => 'width: 88px',
                'title' => 'Ngừng phân bổ'
            )
        ). '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end tài sản */
/* công cụ */

function get_congcu_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_congcu_id'),
        lang('common_congcu_name'),
        '&nbsp');
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
    $table.=get_congcu_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_congcu_manage_table_data_rows($customer_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($customer_type->result() as $customer) {
        $table_data_rows.=get_congcu_data_row($customer, $controller);
    }

    if ($customer_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_congcu_data_row($customer, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='$customer->id' name='type[]' value='" . $customer->id . "'/></td>";
    $table_data_row.='<td width="10%" style="text-align:center">' . $customer->id . '</td>';
    $table_data_row.='<td width="70%">' . $customer->name . '</td>';
    $table_data_row.='<td width="15%" class="rightmost">'
        . anchor(
            $controller_name . "/view/$customer->id/width~$width",
            lang('common_edit'),
            array(
                'class' => 'thickbox',
                'style' => 'width: 88px',
                'title' => lang($controller_name . '_update')
            )
        )
        . anchor(
            $controller_name . "/allocate/$customer->id/width~345",
            'Ngừng phân bổ',
            array(
                'class' => 'thickbox',
                'style' => 'width: 88px',
                'title' => 'Ngừng phân bổ'
            )
        ) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* end công cụ */
/* template */

function get_template_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_asset_id'),
        lang('common_asset_name'),
        '&nbsp');
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
    $table.=get_template_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_template_manage_table_data_rows($customer_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($customer_type->result() as $customer) {
        $table_data_rows.=get_template_data_row($customer, $controller);
    }

    if ($customer_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_template_data_row($customer, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='$customer->id' name='type[]' value='" . $customer->id . "'/></td>";
    $table_data_row.='<td width="15%">' . $customer->id . '</td>';
    $table_data_row.='<td width="50%">' . $customer->name . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$customer->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end template */
/* tkdu */

function get_tkdu_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_id_tk'),
        lang('common_name_tk'),
        lang('common_tk_level'),
        lang('common_tk_parent'),
        lang('cat_tk'),
        'Ghi chú',
        '&nbsp');
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
    $table.=get_tkdu_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_tkdu_manage_table_data_rows($var_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($var_type->result() as $customer) {
        $table_data_rows.=get_tkdu_data_row($customer, $controller);
    }

    if ($var_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_tkdu_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->id' name='type[]' value='" . $var->id . "'/></td>";
    $table_data_row.='<td width="10%" style="text-align: center">' . $var->id . '</td>';
    $table_data_row.='<td width="30%" style="text-align: center">' . $var->name . '</td>';
    $table_data_row.='<td width="5%">' . $var->level . '</td>';
    $table_data_row.='<td width="20%">' . $CI->Tkdu->get_info($var->id_parent)->name . '</td>';
    $table_data_row.='<td width="20%">' . $CI->Tkdu->get_info_account_type($var->acc_cat_id)->type_name . '</td>';
    $table_data_row.='<td width="15%">' . $var->comment . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$var->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* end tkdu */
/* end long.dk */

// Begin table helper Bộ phận sử dụng
function get_bpsd_manage_table($giftcards, $controller) {
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('bpsd_id'),
        lang('bpsd_name'),
        lang('bpsd_desc'),
        '&nbsp',
    );

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
    $table.=get_bpsd_manage_table_data_rows($giftcards, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_bpsd_manage_table_data_rows($giftcards, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($giftcards->result() as $giftcard) {
        $table_data_rows.=get_bpsd_data_row($giftcard, $controller);
    }

    if ($giftcards->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('giftcards_no_giftcards_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_bpsd_data_row($giftcard, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $height = $controller->get_form_height();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='3%'><input type='checkbox' id_bpsd='giftcard_$giftcard->id_bpsd' value='" . $giftcard->id_bpsd . "'/></td>";
    $table_data_row.='<td width="5%">' . $giftcard->id_bpsd . '</td>';
    $table_data_row.='<td width="15%">' . $giftcard->name_bpsd . '</td>';
    $table_data_row.='<td width="15%">' . $giftcard->desc_bpsd . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$giftcard->id_bpsd/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

// End table helper Bộ phận sử dụng
// Begin table helper nhom tai san , thiet bi
function get_tstb_manage_table($giftcards, $controller) {
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('tstb_id'),
        lang('tstb_name'),
        lang('tstb_desc'),
        '&nbsp',
    );

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
    $table.=get_tstb_manage_table_data_rows($giftcards, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_tstb_manage_table_data_rows($giftcards, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($giftcards->result() as $giftcard) {
        $table_data_rows.=get_tstb_data_row($giftcard, $controller);
    }

    if ($giftcards->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('giftcards_no_giftcards_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_tstb_data_row($giftcard, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $height = $controller->get_form_height();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='3%'><input type='checkbox' id='giftcard_$giftcard->id' value='" . $giftcard->id_tstb . "'/></td>";
    $table_data_row.='<td width="5%">' . $giftcard->id_tstb . '</td>';
    $table_data_row.='<td width="15%">' . $giftcard->name_tstb . '</td>';
    $table_data_row.='<td width="15%">' . $giftcard->desc_tstb . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$giftcard->id_tstb/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

// thangnn
//begin table helper Create Inventory
function get_create_inventory_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã kho',
        'Tên kho',
        'Mô tả',
        'ID Province',
        'Name Province',
        'ID District',
        'Google map offset-x',
        'Google map offset-y',
        '&nbsp');
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
    $table.=get_create_inventory_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_create_inventory_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_create_inventory_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_create_inventory_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link = site_url('create_invetorys/detail_inventory/' . $person->id);
    $table_data_row = '<tr>';
    if ($person->type_warehouse == 1 || $person->type_warehouse == 2) {
        $table_data_row.="<td width='2%''></td>";
    } else {
        $table_data_row.="<td width='2%''><input type='checkbox' id='person_$person->id' value='" . $person->id . "'/></td>";
    }
    $table_data_row.='<td width="5%">' . $person->id . '</td>';
    $table_data_row.='<td width="15%"><a href="' . $link . '" class="underline">' . $person->name_inventory . '</a></td>';
    $table_data_row.='<td width="15%">' . $person->description . '</td>';
    $table_data_row.='<td width="5%">' . $person->id_province . '</td>';
    $table_data_row.='<td width="5%">' . $person->name_province . '</td>';
    $table_data_row.='<td width="5%">' . $person->id_district . '</td>';
    $table_data_row.='<td width="5%">' . $person->map_x . '</td>';
    $table_data_row.='<td width="5%">' . $person->map_y . '</td>';

    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$person->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update')))
            /* .anchor("costs/add_new_cost/$person->id_unit/width~$width", lang('common_cost'),array('class'=>'thickbox','title'=>'Thực hiện thu chi')) */
            . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

// thangnn28082014
// End table helper nhom tai san , thiet bi

/* hung audi 9-3 */
/* chung tu */
function get_follow_bom_manage_table($follow_bom, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" >';
    $headers = array(
        '&nbsp;',
        'Mã lệnh',
        'Tên mẫu/ SL size',
        'Trạng thái',
        'Trạng thái công đoạn',
        'Ngày bắt đầu',
        'Ngày kết thúc',
        '&nbsp;',
        '&nbsp;'
    );
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
    $table.=get_follow_bom_manage_table_data_rows($follow_bom, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_follow_bom_manage_table_data_rows($follow_bom, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($follow_bom->result() as $var) {
        $table_data_rows.=get_follow_bom_data_row($var, $controller);
    }

    if ($follow_bom->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_follow_bom_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $item_ids = $CI->Item_kit->get_item_history_production($var->id);
    $name_item = $name_items;
    $request_feature = $CI->Item_kit->get_feature_in_request_feature($var->request_id);

    if ($var->status == 1) {
        $status = "Chưa xác nhận";
    } else if ($var->status == 2) {
        $status = "Đang sản xuất";
    } else if ($var->status == 3) {
        $status = "Hoàn thành";
    }
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->id' name='type[]' value='" . $var->request_id . "'/></td>";
    $table_data_row.='<td width="10%" style="text-align: center">' . anchor(
                    $controller_name . "/detail_quantity_size/$var->request_id/0/width~700/height~300", $var->request_id . '<br>(chi tiết)', array('class' => 'thickbox', 'title' => "Chi tiết số lượng")
            ) . '</td>';

    //feature size
    $table_data_row.='<td width="20%" style="text-align: center;">';
    foreach ($request_feature as $f) {
        $info_feature = $CI->Item_kit->get_info_item_kit_feature($f->feature_id);
        $info_sizes = $CI->Item_kit->get_size_by_request_feature($var->request_id, $f->feature_id);
        $total_size = 0;
        foreach ($info_sizes as $is) {
            $total_size += $is->quantity;
        }
        $table_data_row.='- ' . $info_feature->name_feature . ': ' . format_quantity($total_size) . '<br><br>';
    }
    $table_data_row.='</td>';
    $table_data_row.='<td width="10%">' . $status . '</td>';

    //last day of august, 2015  ____hover tooltip <3

    $table_data_row.='<td width="10%"><a class="tooltip">';
    $item_kit_processes = $CI->Item_kit->get_all_item_kit_processes($var->request_id);
    foreach ($item_kit_processes->result() as $ip) {
        $processes = $CI->Item_kit->get_info_processes($ip->id_processes);
        $info_item_production = $CI->Item_kit->get_info_item_production_by_request_id($var->request_id);
        $date_kcs_max = $CI->Item_kit->get_info_kcs_history_phase_max_date($var->request_id, $ip->id_processes)->date_kcs;
        $info_kcs_status = $CI->Item_kit->get_info_kcs_status($var->request_id, $ip->id_processes);
        $status = 1;
        $date_kcs_max2 = $date_kcs_max ? $date_kcs_max : date('Y-m-d 23:59:59');

        $date_begin = date("$info_item_production->date_begin 00:00:00");
        $date_end = date("$info_item_production->date_end 23:59:59");

        $info_kcs_status_in_time = $CI->Item_kit->get_info_kcs_status_join_history_in_time($var->request_id, $ip->id_processes, $status, $date_kcs_max2, $date_begin, $date_end);
        $info_kcs_status_out_time = $CI->Item_kit->get_info_kcs_status_join_history_out_time($var->request_id, $ip->id_processes, $status, $date_kcs_max2, $date_end);

        if ($info_kcs_status_in_time->num_rows() == $info_kcs_status->num_rows()) {
            $color = 'green';  //finish in time
        }
        if ($info_kcs_status_out_time->num_rows() == $info_kcs_status->num_rows()) {
            $color = 'blue';    //finish out time
        }
        if ($date_kcs_max2 < $date_end) {
            if ($info_kcs_status_in_time->num_rows() != $info_kcs_status->num_rows()) {
                $color = 'red';     //not finish in time
            }
        }
        if ($date_kcs_max2 > $date_end) {
            if ($info_kcs_status_out_time->num_rows() != $info_kcs_status->num_rows()) {
                $color = 'purple';  //not finish out time
            }
        }
        $table_data_row .= '<div style="color: ' . $color . '" >- ' . $processes->name_processes . '</div><BR>';
    }
    $table_data_row.=
            '<span>
            <table class=tooltip_table>
                <tr style="border: none">
                    <td style="border: none;">
                        <div style="background: green; width: 16px; height: 16px">&nbsp;</div>
                    </td>
                    <td style="border: none;">Hoàn thành trước thời hạn</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">
                        <div style="background: blue">&nbsp;</div>
                    </td>
                    <td style="border: none;">Hoàn thành sau thời hạn</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">
                        <div style="background: red">&nbsp;</div>
                    </td>
                    <td style="border: none;">Chưa hoàn thành trước thời hạn</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">
                        <div style="background: purple">&nbsp;</div>
                    </td>
                    <td style="border: none;">Chưa hoàn thành sau thời hạn</td>
                </tr>
            </table>
        </span>
    </a></td>';
    //end <3

    $table_data_row.='<td width="10%" style="text-align: center">' . date('d-m-Y', strtotime($var->date_begin)) . '</td>';
    $table_data_row.='<td width="10%" style="text-align: center">' . date('d-m-Y', strtotime($var->date_end)) . '</td>';
    $table_data_row.='<td width="10%" style="text-align: left">';

    $table_data_row .= "<ul>";
    if ($var->status == 1) {
        $table_data_row .= "<li class='li_design_template'>" . anchor(
                        $controller_name . "/detail_quantity_size/$var->request_id/1/width~700/height~300", 'Xác nhận SX', array(
                    'class' => 'thickbox',
                    id => link_underline,
                    'title' => "Xác nhận sản xuất"
                        )
                ) . "</li>";
    }
    $table_data_row .= "<li class='li_design_template' style='margin-top: 6px'>" . anchor(
                    $controller_name . "/view_order_warehouse_item/$var->request_id", 'Phiếu xuất NVL', array(
                id => link_underline,
                'target' => 'brank_',
                'title' => 'Phiếu xuất nguyên vật liệu'
                    )
            ) . "</li>";
    $check_processes = $CI->Item_kit->check_kcs($var->request_id);
    if ($var->status == 3) {
        $table_data_row .= "<li class='li_design_template' style='margin-top: 6px'>" . anchor(
                        $controller_name . "/view_request_cost_price/$var->request_id/width~365/height~400", 'Xem giá vốn', array(
                    id => link_underline,
                    'class' => 'thickbox',
                    'title' => 'Xem giá vốn'
                        )
                ) . "</li>";
    }
    $table_data_row .= "</ul>";
    $table_data_row.='</td>';
    $table_data_row.='<td width="10%" style="text-align: left">';
    $table_data_row .= "<ul>";
    $table_data_row .= "<li class='li_design_template'>" . anchor(
                    $controller_name . "/view_list_kcs/$var->id", 'Theo dõi SX', array(
                id => link_underline,
                'title' => 'Theo dõi sản xuất'
                    )
            ) . "</li>";
    $table_data_row .= "<li class='li_design_template' style='margin-top: 6px'>" . anchor(
                    $controller_name . "/view_detail_kcs/$var->request_id/width~$width/height~450", 'Chi tiết', array(
                'class' => 'thickbox',
                id => link_underline,
                'title' => 'Chi tiết cập nhật sản xuất'
                    )
            ) . "</li>";
    $table_data_row .= "</ul>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

//End follow bom
//CREATED BY SAN
function get_services_manage_table($services, $controller) {
    $CI = & get_instance();
    $has_cost_price_permission = $CI->Employee->has_module_action_permission('services', 'see_cost_price', $CI->Employee->get_logged_in_employee_info()->person_id);
    $table = '<table class="tablesorter table_one" id="sortable_table">';
    $headers = array(
        '<input style="margin-left: 8px" type="checkbox" id="select_all" />',
        'Mã dịch vụ',
        'Tên dịch vụ',
        'Loại dịch vụ',
        'Giá dịch vụ',
        '&nbsp'
    );

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
    $table.=get_services_manage_table_data_rows($services, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_services_manage_table_data_rows($services, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($services->result() as $service) {
        $table_data_rows.=get_service_data_row($service, $controller);
    }

    if ($services->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_service_data_row($service, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='items_$service->item_id' value='" . $service->item_id . "'/></td>";
    $table_data_row.='<td width="10%" style="text-align: center">' . $service->item_number . '</td>';
    $table_data_row.='<td width="25%"><p">' . $service->name . '</p></td>';
    $cat_name = $CI->Category->get_info($service->category);
    $table_data_row.='<td width="25%"><p">' . $cat_name->name . '</p></td>';
    $table_data_row.='<td width="15%" style="text-align: right">' . to_currency($service->unit_price) . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$service->item_id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

//hung audi 9-4-15

function get_city2_manage_table($city, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã vùng/Mã nước',
        'Tên thành phố/Tên nước',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_city2_manage_table_data_rows($city, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_city2_manage_table_data_rows($city, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($city->result() as $city2) {
        $table_data_rows.=get_city2_data_row($city2, $controller);
    }

    if ($city->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_city2_data_row($city, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$city->id_city' value='" . $city->id_city . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="23%">' . $city->zip_code . '</td>';
    $table_data_row.='<td style="padding-left:25px" width="50%"><p style="width:343px">' . $city->name . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor(
                    $controller_name . "/view/$city->id_city/width~380", lang('common_edit'), array(
                'class' => 'thickbox',
                'title' => 'Cập nhật thành phố/ tên nước'
                    )
            ) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

//BEGIN SAN
//Brandname
function get_sms_manage_table($sms, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array(
        '<input type="checkbox" id="select_all" />',
        'Mã SMS',
        'Tiêu đề SMS',
        'Nội dung',
        '&nbsp'
    );
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
    $table.=get_sms_manage_table_data_rows($sms, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the mail.
 */

function get_sms_manage_table_data_rows($sms, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($sms->result() as $s) {
        $table_data_rows.=get_sms_data_row($s, $controller);
    }

    if ($sms->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:0px;'>Không có dữ liệu</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_sms_data_row($sms, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    $table_data_row = '<tr>';
    $table_data_row.="<td width='2%'><input type='checkbox' id='sms_$sms->id' value='" . $sms->id . "'/></td>";
    $table_data_row.="<td width='10%' style='text-align: center'>" . $sms->id . "</td>";
    $table_data_row.='<td width="30%">' . $sms->title . '</a></td>';
    $table_data_row.='<td width="50%">' . $sms->message . '</td>';
    $table_data_row.='<td width="8%" class="rightmost">' . anchor($controller_name . "/view_sms/$sms->id/width~450", lang('common_edit'), array('title' => ' Sửa SMS', 'class' => 'thickbox')) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

function get_design_template_manage_table($design_template, $controller) {
    $CI = & get_instance();
    $table = "<table class='tablesorter' id='sortable_table'>";
    $headers = array(
        '&nbsp;',
        lang("item_kits_code_design_template"),
        lang("item_kits_image_design_template"),
        lang("item_kits_date_design_template"),
        lang("item_kits_description_design_template"),
        lang("item_kits_person_design_template"),
        'Công đoạn',
        lang("item_kits_status_design_template"),
        lang("item_kits_command_design_template"),
        '&nbsp;'
    );
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
    $table.=get_design_template_manage_table_data_rows($design_template, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_design_template_manage_table_data_rows($design_template, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($design_template->result() as $var) {
        $table_data_rows.=get_design_template_data_row($var, $controller);
    }
    if ($design_template->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_design_template_data_row($design_template, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $exist_item_kit_feature = $CI->Item_kit->exist_item_kit_feature($design_template->id_design_template);

    $check = $CI->Item_kit->check_id_design_template($design_template->id_design_template);
    $info_employee = $CI->Employee->get_info($design_template->person_id);

    $info_design_template = $CI->Item_kit->get_info_design_template($design_template->id_design_template);
    $processes_item_kit = $CI->Item_kit->get_info_processes_item_kit($info_design_template->item_kit_id);
    $check_processes_design_template = $CI->Item_kit->check_processes_design_template($design_template->id_design_template);

    $table_data_row = "<tr>";
    if (!$check) {
        $table_data_row.="<td width='1%'><input type='checkbox' id='$design_template->id_design_template' name='type[]' value='" . $design_template->id_design_template . "'/></td>";
    } else {
        $table_data_row.="<td width='1%'></td>";
    }
    $table_data_row.='<td width="5%" style="text-align: center">' . $design_template->code_design_template . '</td>';
    $table_data_row.="<td width='12%' style='text-align: left'><img src='./item_kit/design_template/" . $design_template->image_design_template . "' style='width: 70px; height: 70px'></td>";
    $table_data_row.='<td width="10%" style="text-align: left">' . date("d-m-Y H:i:s", strtotime($design_template->date_create)) . '</td>';
    $table_data_row.="<td width='10%'>$design_template->description</td>";

    $table_data_row.='<td width="10%" style="text-align: left">' . $info_employee->first_name . ' ' . $info_employee->last_name . '</td>';
    //last day of august, 2015  ____hover tooltip <3

    $table_data_row.='<td width="23%"><a class="tooltip">';
    foreach ($processes_item_kit->result() as $pig) {//pig: con nhợn (o_o)
        $info_processes = $CI->Item_kit->get_info_processes($pig->id_processes);
        $processes_design_template = $CI->Item_kit->get_processes_design_template($design_template->id_design_template, $pig->id_processes);
        $processes_item_kit_audi = $CI->Item_kit->get_info_processes_item_kit_audi($info_design_template->item_kit_id, $pig->id_processes);
        $color = $processes_design_template->status == 1 ? 'green' : 'red';

        $date_confirm = $processes_design_template->date_confirm;
        $date_finish = $processes_item_kit_audi->date_finish;
        $date_confirm_show = $date_confirm != '0000-00-00' && $date_confirm != '' ? ': ' . date('d-m-Y', strtotime($date_confirm)) : '';
        if ($processes_design_template->status == 1) {//finish
            if ($date_confirm <= $date_finish) {
                $color = 'green';   //in time
            } else {
                $color = 'blue';    //out time
            }
        }
        if ($processes_design_template->status == 0) {//not finish
            if ($date_confirm <= $date_finish) {
                $color = 'red';     //in time
            } else {
                $color = 'purple';  //out time
            }
        }
        $table_data_row .= '<div style="color: ' . $color . '" > - '
                . $info_processes->name_processes . $date_confirm_show . '</div><BR>';
    }
    $table_data_row.=
            '<span>
            <table class=tooltip_table>
                <tr style="border: none">
                    <td style="border: none;">
                        <div style="background: green; width: 16px; height: 16px">&nbsp;</div>
                    </td>
                    <td style="border: none;">Hoàn thành trước thời hạn</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">
                        <div style="background: blue">&nbsp;</div>
                    </td>
                    <td style="border: none;">Hoàn thành sau thời hạn</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">
                        <div style="background: red">&nbsp;</div>
                    </td>
                    <td style="border: none;">Chưa hoàn thành trước thời hạn</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;">
                        <div style="background: purple">&nbsp;</div>
                    </td>
                    <td style="border: none;">Chưa hoàn thành sau thời hạn</td>
                </tr>
            </table>
        </span>
    </a></td>';
    //end <3

    if ($design_template->status == 0)
        $status = "Đề xuất";
    else if ($design_template->status == 1)
        $status = "Đang triển khai";
    else if ($design_template->status == 2)
        $status = "Đang xét duyệt";
    else if ($design_template->status == 3)
        $status = "Duyệt";
    else if ($design_template->status == 4)
        $status = "Không duyệt";
    else if ($design_template->status == 5)
        $status = "Thiết kế lại";
    else
        $status = 'Hủy';

    $table_data_row.='<td width="8%" style="text-align: left">' . $status . '</td>';
    $table_data_row.='<td width="8%" style="text-align: left">' . $design_template->command . '</td>';
    $table_data_row.="<td width='15%' style='text-align: left'>";
    $table_data_row.= "<ul>";

    if ($check_processes_design_template->num_rows() > 0 && $design_template->status != 3) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/confirm_processes/$design_template->id_design_template/width~400/height~200", 'Xác nhận công đoạn', array(
                    'class' => 'thickbox',
                    'id' => 'link_underline',
                    'title' => 'Xác nhận công đoạn'
                        )
                ) . "</li>";
    }
    if ($design_template->status == 0 || $design_template->status == 1 || $design_template->status == 2 || $design_template->status == 5) {
        if ($check_processes_design_template->num_rows() == 0) {
            $table_data_row.= "<li class='li_design_template'>" . anchor(
                            $controller_name . "/feedback_design_template/$design_template->id_design_template/width~400/height~444", lang($controller_name . '_feedback_design_template'), array(
                        'class' => 'thickbox',
                        'id' => 'link_underline',
                        'title' => lang($controller_name . '_feedback_design_template')
                            )
                    ) . "</li>";
        }
    }
    if ($design_template->status == 0 || $design_template->status == 1 || $design_template->status == 2 || $design_template->status == 3 || $design_template->status == 5) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/switch_item_kit_feature/$design_template->id_design_template", 'Quản lý công thức nguyên vật liệu', array(
                    'id' => 'link_underline',
                    'title' => 'Quản lý công thức nguyên vật liệu',
                    'style' => 'width: 140px'
                        )
                ) . "</li>";
    }
    if ($design_template->status == 3) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/request_production_template/$design_template->id_design_template/width~400/height~444", lang($controller_name . '_request_production_template'), array(
                    'id' => 'link_underline',
                    'class' => 'thickbox',
                    'title' => lang($controller_name . '_request_production_template')
                        )
                ) . "</li>";
    }
    if ($exist_item_kit_feature) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/view_production_template/$design_template->id_design_template/width~$width", 'Lệnh sản xuất', array(
                    'id' => 'link_underline',
                    'class' => 'thickbox',
                    'title' => 'Lệnh sản xuất'
                        )
                ) . "</li>";
    }
    if ($design_template->status == 0 || $design_template->status == 5) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/view_design_template/$design_template->id_design_template/width~400/height~444", lang($controller_name . '_update_design_template'), array(
                    'id' => 'link_underline',
                    'class' => 'thickbox',
                    'title' => lang($controller_name . '_update_design_template')
                        )
                ) . "</li>";
    }
    $table_data_row.= "</ul>";
    $table_data_row.="</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

function get_production_flow_template_manage_table($production_flow_template, $controller) {
    $CI = & get_instance();
    $table = "<table class='tablesorter' id='sortable_table'>";
    $headers = array(
        '&nbsp;',
        lang("item_kits_production_order"),
        lang("item_kits_name_processes"),
        lang("item_kits_time_processes"),
        lang("item_kits_unit_time"),
        '&nbsp;'
    );
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
    $table.=get_production_flow_template_manage_table_data_rows($production_flow_template, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_production_flow_template_manage_table_data_rows($production_flow_template, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($production_flow_template->result() as $var) {
        $table_data_rows.=get_production_flow_template_data_row($var, $controller);
    }
    if ($production_flow_template->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></td></tr>";
    }
    return $table_data_rows;
}

function get_production_flow_template_data_row($production_flow_template, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = "<tr>";
    $table_data_row.="<td width='1%'><input type='checkbox' id='$production_flow_template->id_production_flow_template' name='type[]' value='" . $production_flow_template->id_production_flow_template . "'/></td>";
    $table_data_row.="<td width='15%' style='text-align: center'>$production_flow_template->production_order</td>";
    $table_data_row.='<td width="35%" style="text-align: left">' . $production_flow_template->name_processes . '</td>';
    $table_data_row.="<td width='15%' style='text-align: right'>$production_flow_template->time_processes</td>";
    if ($production_flow_template->unit_time == 0) {
        $unit_time = "Giờ";
    } else {
        $unit_time = "Ngày";
    }
    $table_data_row.="<td width='15%' style='text-align: left'>$unit_time</td>";
    $table_data_row.="<td width='19%' style='text-align: left'>" . anchor($controller_name . "/view_production_flow_template/$production_flow_template->id_production_flow_template/width~$width", lang($controller_name . '_update_production_flow_template'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update_production_flow_template'))) . "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

function get_processes_manage_table($processes, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang("item_kits_code_processes"),
        lang("item_kits_name_processes"),
        lang("category_processes"),
        '&nbsp'
    );
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_processes_manage_table_data_rows($processes, $controller); //
    $table.='</tbody></table>';
    return $table;
}

function get_processes_manage_table_data_rows($processes, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($processes->result() as $var) {
        $table_data_rows.=get_processes_data_row($var, $controller);
    }
    if ($processes->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_processes_data_row($processes, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = "<tr>";
    $table_data_row.="<td width='1%'><input type='checkbox' id='$processes->id_processes' name='type[]' value='" . $processes->id_processes . "'/></td>";
    $table_data_row.="<td width='15%' style='text-align: center'>$processes->id_processes</td>";
    $table_data_row.='<td width="40%">' . $processes->name_processes . '</td>';
    $table_data_row.='<td width="40%">' . $CI->M_category_processes->get_info($processes->cat_pro_id)->cat_pro_name . '</td>';
    $table_data_row.="<td width='15%' style='text-align: center'>" . anchor($controller_name . "/view_processes/$processes->id_processes/width~$width", lang($controller_name . '_update_design_template'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update_design_template'))) . "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

//END SAN
//By Loi
function get_verifying_manage_table($items, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter report" id="sortable_table" style="width: 960px;">';
    $headers = array(
        'Số STT',
        'Mã SP',
        'Tên SP',
        'Loại SP',
        'Giá nhập',
        'Kho',
        'SL kho',
        'SL bán',
        'SL kiểm',
        'SL chêch lệch',
        'Ngày kiểm'
    );

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
    $table.=get_verifying_manage_table_data_rows($items, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the items.
 */

function get_verifying_manage_table_data_rows($items, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    $stt = 1;
    foreach ($items->result() as $key => $item) {
        $table_data_rows.=get_verifying_data_row($item, $controller, $stt);
        $stt ++;
    }

    if ($items->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('items_no_items_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_verifying_data_row($item, $controller, $stt) {
    $CI = & get_instance();
    $has_cost_price_permission = $CI->Employee->has_module_action_permission('items', 'see_cost_price', $CI->Employee->get_logged_in_employee_info()->person_id);
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $cat = $CI->Category->get_info($item->category);
    $chech = $item->quantity_inventory - $item->quantity_verifying;
    $table_data_row = '<tr>';
    $table_data_row.='<td width="8%">' . $stt . '</td>';
    $table_data_row.='<td width="12%">' . $item->item_number . '</td>';
    $table_data_row.='<td width="15%">' . $item->name . '</td>';
    $table_data_row.='<td width="15%">' . $cat->name . '</td>';
    $table_data_row.='<td width="10%" style="text-align: center;">' . number_format($item->cost_price) . '</td>';
    if ($item->warehouse_id == 0) {
        $table_data_row.='<td width="8%" style="text-align: center;">Kho tổng</td>';
    } else
        $table_data_row.='<td width="8%" style="text-align: center;">' . $CI->Create_invetory->get_info($item->warehouse_id)->name_inventory . '</td>';
    $table_data_row.='<td width="8%" style="text-align: center;">' . format_quantity($item->quantity_inventory) . '</td>';
    $table_data_row.='<td width="7%" style="text-align: center;">' . format_quantity($item->quantity_sale) . '</td>';
    $table_data_row.='<td width="7%" style="text-align: center;">' . format_quantity($item->quantity_verifying) . '</td>';
    $table_data_row.='<td width="10%" style="text-align: center">' . format_quantity($chech) . '</td>';
    $table_data_row.='<td width="10%" style="text-align: center">' . date('d-m-Y H:i:s', strtotime($item->date)) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

//End Loi
//hung audi 30-5-15 packs
function get_packs_manage_table($packs, $controller) {
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã sản phẩm',
        lang('packs_name'),
        'Ảnh',
        lang('packs_description'),
        lang('items_unit_price'),
        lang('items_tax_percents') . ' %',
        '&nbsp',
    );

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
    $table.=get_packs_manage_table_data_rows($packs, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_packs_manage_table_data_rows($packs, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($packs->result() as $pack) {
        $table_data_rows.=get_pack_data_row($pack, $controller);
    }

    if ($packs->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>" . lang('packs_no_packs_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_pack_data_row($pack, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $images_pack = base_url() . 'packs/' . $pack->images;
    $no_image = base_url() . 'images/noImage.gif';
    $table_data_row = '<tr>';
    $table_data_row.="<td width='3%'><input type='checkbox' id='pack_$pack->pack_id' value='" . $pack->pack_id . "'/></td>";
    $table_data_row.='<td width="15%" align="center">' . $pack->pack_number . '</td>';
    $table_data_row.='<td width="15%" align="center">' . $pack->name . '</td>';
    $table_data_row.='
        <td width="8%" style="height: 55px">
            <img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . ( $pack->images != null ? $images_pack : $no_image) . '" />
        </td>';
    $table_data_row.='<td width="20%" align="center">' . $pack->description . '</td>';
    $table_data_row.='<td width="20%" align="right">' . (!is_null($pack->unit_price) ? to_currency($pack->unit_price) : '') . '</td>';
    $table_data_row.='<td width="20%" align="center">' . $pack->taxes . '</td>';
    $table_data_row.='<td width="5%" class="rightmost">' . anchor($controller_name . "/view/$pack->pack_id/width~770", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

//July 08, 2015 Hưng Audi item_kit_feature
function get_item_kit_feature_manage_table($item_kit_feature, $controller) {
    $CI = & get_instance();
    $table = "<table class='tablesorter' id='sortable_table'>";
    $headers = array(
        '&nbsp;',
        'Mã công thức',
        'Tên công thức',
        '&nbsp;'
    );
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
    $table.=get_item_kit_feature_manage_table_data_rows($item_kit_feature, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_item_kit_feature_manage_table_data_rows($item_kit_feature, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($item_kit_feature->result() as $var) {
        $table_data_rows.=get_item_kit_feature_data_row($var, $controller);
    }
    if ($item_kit_feature->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_item_kit_feature_data_row($item_kit_feature, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = "<tr>";
    $table_data_row.="<td width='5%'><input type='checkbox' id='$item_kit_feature->feature_id' name='type[]' value='" . $item_kit_feature->feature_id . "'/></td>";
    $table_data_row.='<td width="30%" style="text-align: center">' . $item_kit_feature->number_feature . '</td>';
    $table_data_row.="<td width='40%'>$item_kit_feature->name_feature</td>";
    $table_data_row.="<td width='5%' style='text-align: left'>"
            . anchor(
                    $controller_name . "/view_item_kit_feature/$item_kit_feature->feature_id/width~770", lang($controller_name . '_update_design_template'), array('class' => 'thickbox', 'title' => 'Sửa công thức NVL')
    );
    $table_data_row.="</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

//end H.A
//Loi
function get_export_store_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" >';

    $headers = array(
        '&nbsp',
        'HĐ xuất',
        'Ngày tháng',
        'Kho',
        'Nhân viên',
        'Ghi chú',
        'Trạng thái',
        '&nbsp'
    );
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align: center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_export_store_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_export_store_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_export_store_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_export_store_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $name_store = $person->store_id != 0 ? $CI->Create_invetory->get_info($person->store_id)->name_inventory : 'Kho tổng';
    $export_store_items = $CI->Create_invetory->get_all_export_store_item($person->export_store_id)->result();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='1%'>";
    if ($person->status == 0) {
        $table_data_row.="<input type='checkbox' id='person_" . $person->export_store_id . "' value='" . $person->export_store_id . "'/>";
    }
    $table_data_row.="</td>";
    $table_data_row.='<td width="8%" style="text-align: center">' . $person->export_store_id . '</td>';
    $table_data_row.='<td width="10%" style="text-align: center">' . date("d-m-Y H:i:s", strtotime($person->date_export)) . '</td>';
    $table_data_row.='<td width="10%" style="text-align: left">' . $name_store . '</td>';
    $table_data_row.='<td width="12%" style="text-align: left">' . $CI->Employee->get_info($person->employee_id)->first_name . '</td>';
    $table_data_row.='<td width="10%" style="text-align: left">' . $person->comment . '</td>';
    $status = $person->status == 0 ? "Chờ xác nhận" : "Đã xác nhận";
    $table_data_row.='<td width="10%" style="text-align: left">' . $status . '</td>';
    $table_data_row.='<td width="7%" style="text-align: center" class="rightmost"><ul>';
    $check_edit = $CI->Employee->has_module_action_permission($controller_name, "add_update_export_store", $CI->Employee->get_logged_in_employee_info()->person_id);
    $check_confirm = $CI->Employee->has_module_action_permission($controller_name, "confirm_export_store", $CI->Employee->get_logged_in_employee_info()->person_id);
     if ($person->status == 0) {
        if ($check_edit) {
            $table_data_row.= "<li class='li_action'>" . anchor(site_url() . "create_invetorys/export_store/$person->export_store_id/width~950/height~500", 'Sửa', array('id'=>'link_underline', 'class' => 'thickbox', 'title' => 'Cập nhật hóa đơn xuất kho')) . "</li>";
        }
        if ($check_confirm) {
            $table_data_row.= "<li class='li_action'>" . anchor(site_url() . "/create_invetorys/approve/$person->export_store_id", 'Xác nhận', array('id'=>'link_underline', 'class' => 'thickbox', 'title' => 'Xác nhận hóa đơn')) . '</li>';
        }
    }
    $table_data_row.= "<li class='li_action'>" . anchor(site_url() . "create_invetorys/view_export_store/$person->export_store_id", 'Phiếu xuất kho', array('id'=>'link_underline', 'title' => 'Phiếu xuất kho')) . '</li>';
    $table_data_row.='</ul></tr>';
    return $table_data_row;
}

//end Loi
//July 13, Hưng Audi estimate
function get_estimate_manage_table($estimate, $controller) {
    $CI = & get_instance();
    $table = "<table class='tablesorter' id='sortable_table'>";
    $headers = array(
        '&nbsp;',
        'Mã mẫu SX',
        'Hình ảnh',
        'Ngày bắt đầu',
        'Ngày kết thúc',
        'Trạng thái',
        'Ghi chú',
        '&nbsp;'
    );
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
    $table.=get_estimate_manage_table_data_rows($estimate, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_estimate_manage_table_data_rows($estimate, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($estimate->result() as $var) {
        $table_data_rows.=get_estimate_data_row($var, $controller);
    }
    if ($estimate->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='9'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_estimate_data_row($estimate, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    if ($estimate->status == 0 || $estimate->status == 2)
        $image = base_url() . 'images/noImage.gif';
    else
        $image = "./item_kit/$estimate->image_production_template";

    $table_data_row = "<tr>";
    $table_data_row.="<td width='5%'><input type='checkbox' id='$estimate->id_design_template' name='type[]' value='" . $estimate->id_design_template . "'/></td>";
    $table_data_row.='<td width="15%" style="text-align: left">' . $estimate->code_production_template . '</td>';
    $table_data_row.="<td width='15%' style='text-align: center'><img src='$image' style='width: 70px; height: 70px'></td>";
    $table_data_row.='<td width="10%" style="text-align: center">' . date("d-m-Y", strtotime($estimate->start_date)) . '</td>';
    $table_data_row.='<td width="10%" style="text-align: center">' . date("d-m-Y", strtotime($estimate->end_date)) . '</td>';
    if ($estimate->status == 0) {
        $status = "Chờ xác nhận";
    } else if ($estimate->status == 1) {
        $status = "Đã xác nhận";
    } else if ($estimate->status == 2) {
        $status = "Đang sản xuất";
    } else if ($estimate->status == 3) {
        $status = "Hoàn thành";
    } else if ($estimate->status == 4) {
        $status = "Không đạt";
    } else if ($estimate->status == 5) {
        $status = "Duyệt tạm";
    } else if ($estimate->status == 6) {
        $status = "Duyệt sản xuất";
    }
    $table_data_row.='<td width="15%" style="text-align: left">' . $status . '</td>';
    $table_data_row.='<td width="15%" style="text-align: left">' . $estimate->comment . '</td>';
    $table_data_row.="<td width='10%' style='text-align: left'>";
    $table_data_row.= "<ul>";
    if ($estimate->status == 0 || $estimate->status == 2) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/confirm_estimate/$estimate->id_design_template/width~400/height~444", 'Xác nhận', array('class' => 'thickbox', 'title' => 'Xác nhận')
                ) . "</li>";
    }
    if ($estimate->status != 0 && $estimate->status != 1 && $estimate->status != 2) {
        $table_data_row.= "<li class='li_design_template'>"
                . anchor(
                        $controller_name . "/approve_estimate/$estimate->id_design_template/width~400/height~444", 'Phê duyệt', array('class' => 'thickbox', 'title' => 'Phê duyệt')
                ) . "</li>";
    }
    $table_data_row.= "<li class='li_design_template'>"
            . anchor(
                    $controller_name . "/order_request_estimate/$estimate->id_design_template/width~400/height~444", 'Phiếu y/c xuất NVL', array('title' => 'Phiếu yêu cầu xuất nguyên vật liệu', 'target' => '_brank')
            ) . "</li>";
    $table_data_row.= "</ul>";
    $table_data_row.="</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

//hoa don xuat kho
function get_receiving_orders_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" >';
    if ($CI->Employee->has_module_action_permission("receivings", "update_receiving", $CI->Employee->get_logged_in_employee_info()->person_id)) {
        $headers = array(
            '&nbsp',
            'Mã ĐH',
            'Ngày mua',
            'Nhà cung cấp',
            'Nhân viên',
            'Tổng giá trị TT ',
            'Chiết khấu',
            'Hình thức thanh toán',
            'Còn nợ',
            'Trạng thái',
            '&nbsp');
    } else {
        $headers = array(
            '&nbsp',
            'Mã ĐH',
            'Ngày mua',
            'Nhà cung cấp',
            'Nhân viên',
            'Tổng giá trị TT ',
            'Chiết khấu',
            'Hình thức thanh toán',
            'Còn nợ',
            'Trạng thái'
        );
    }
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align: center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_receiving_orders_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_receiving_orders_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_receiving_orders_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_receiving_orders_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $totak = 0;
    $info_receiving_item = $CI->Receiving_order->get_receiving_item();
     foreach ($info_receiving_item as $val){
               if($person->receiving_id == $val['receiving_id']){
                        $net_price1 = $val['item_unit_price'] * $val['quantity_purchased'] - $val['item_unit_price'] * $val['quantity_purchased'] * $val['discount_percent']/100;
                        $totak += $net_price1;
          }
     }

    $total_receiving = $CI->Receiving->get_total_receiving($person->receiving_id);
    $discount = 0;
    $payment = 0;
    $total_taxes = 0;
    foreach ($CI->Receiving_order->get_all()->result() as $key => $val) {
        $receiving_tam_all[] = $CI->Receiving->get_receiving_tam($val->receiving_id);
        $payment_order_all[] = $CI->Receiving->get_receiving_items2($val->receiving_id)->result_array();
    }
    foreach ($receiving_tam_all as $val3) {
        foreach ($val3 as $val4) {
            if ($val4['id_receiving'] == $person->receiving_id) {
                $payment_type = $val4['pays_type'] . ': ' . number_format($val4['pays_amount']) . '<br/>';
                $discount += $val4['discount_money'];
                $payment += $val4['pays_amount'];
            }
        }
    }

    //chi phí
    $cost = $CI->Receiving->get_info($person->receiving_id)->row()->other_cost;
    //thuế
    $info_receiving_item = $CI->Receiving_order->get_receiving_item();
     foreach ($info_receiving_item as $val){
               if($val['receiving_id'] == $person->receiving_id){
                        $net_price = $val['item_unit_price'] * $val['quantity_purchased'] - $val['item_unit_price'] * $val['quantity_purchased'] * $val['discount_percent']/100;
                        $cp = ($net_price / $totak) * $CI->Receiving->get_info($person->receiving_id)->row()->other_cost;

                        $tax = ($net_price + $cp) * $val['taxes'] / 100;

                        $total_taxes+= $tax;
               }
     }

    $return = $CI->Inventory->get_trans_recevings_return($person->receiving_id);
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='1%'>";
    if ($person->status == 1) {
        $table_data_row.="<input type='checkbox' id='person_" . $person->receiving_id . "' value='" . $person->receiving_id . "'/>";
    }
    $table_data_row.="</td>";
    $table_data_row.='<td width="5%" style="text-align: center">' . $person->receiving_id . '</td>';
    $table_data_row.='<td width="8%" style="text-align: center">' . date("d-m-Y H:i:s", strtotime($person->receiving_time)) . '</td>';
//
    $table_data_row.='<td width="10%" style="text-align: left">' . $CI->Supplier->get_info($person->supplier_id)->company_name . '</td>';
    $table_data_row.='<td width="10%" style="text-align: left">' . $CI->Employee->get_info($person->employee_id)->first_name . ' ' .
            $CI->Employee->get_info($person->employee_id)->last_name . '</td>';
    $table_data_row.='<td width="10%" style="text-align: right">'. number_format($total_receiving['total_price']+$cost +$total_taxes) . '</td>';
    $table_data_row.='<td width="8%" style="text-align: right">' .$discount . '</td>';
    $table_data_row.='<td width="8%" style="text-align: left">'.'Trả góp: '.$payment.'</td>';
    if ($total_receiving['total_price'] < 0) {
        $table_data_row.='<td width="8%" style="text-align: right">' . number_format(abs($return == 1 ? 0 : $payment + $total_receiving['total_price'])) . '</td>';
    } else {
        $table_data_row.='<td width="8%" style="text-align: right">' .number_format(abs($return == 1 ? 0 : $total_receiving['total_price'] - $payment +$cost +$total_taxes)) . '</td>';
    }
    $status = $person->status == 0 ? "Chờ xác nhận" : "Đã xác nhận";
    $table_data_row.='<td width="10%" style="text-align: left">' . $status . '</td>';
    if ($CI->Employee->has_module_action_permission("receivings", "update_receiving", $CI->Employee->get_logged_in_employee_info()->person_id)) {
        if ($person->status == 0) {
            $table_data_row.='<td width="3%" style="text-align: center" class="rightmost">';
            $table_data_row.= anchor(site_url() . "/receivings/switch_recv/$person->receiving_id", lang('common_edit'), array('title' => lang($controller_name . '_update')));
            $check_confirm = $CI->Employee->has_module_action_permission($controller_name, "confirm_receiving", $CI->Employee->get_logged_in_employee_info()->person_id);
            if ($check_confirm) {
                $table_data_row.= "" . anchor(site_url() . "/receivings/approve/$person->receiving_id", 'Xác nhận', array('class' => 'thickbox', 'title' => 'Xác nhận hóa đơn')) . '';
            }
            $table_data_row.='</td>';
        }
    }
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* account_type */

function get_account_type_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        'ID',
        'Tên loại tài khoản',
        '&nbsp');
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
    $table.=get_account_type_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_account_type_manage_table_data_rows($var_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($var_type->result() as $customer) {
        $table_data_rows.=get_account_type_data_row($customer, $controller);
    }

    if ($var_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_account_type_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->type_id' name='type[]' value='" . $var->type_id . "'/></td>";
    $table_data_row.='<td width="15%" style="text-align: center">' . $var->type_id . '</td>';
    $table_data_row.='<td width="85%">' . $var->type_name . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$var->type_id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end account_type */

// xem chi tiet mat hang
function get_inventory_item_manage_table($info_item, $controller) {
    $CI = & get_instance();
    $table = "<table class='tablesorter' id='sortable_table' style = 'width : 950px; margin : 0px auto;'>";
    $headers = array(
        'Ngày tháng',
        'Nhân viên',
        'Số lượng',
        'Ghi chú',
        'Kho'
    );
    $table.='<thead><tr>';
    $count = 0;
    foreach ($headers as $header) {
        $table.="<th>$header</th>";
    }
    $table.='</tr></thead><tbody>';
    $table.=get_inventory_item_manage_table_data_rows($info_item, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_inventory_item_manage_table_data_rows($info_item, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($info_item->result() as $var) {
        $table_data_rows.=get_inventory_item_template_data_rows($var, $controller);
    }
    if ($info_item->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></td></tr>";
    }
    return $table_data_rows;
}

function get_inventory_item_template_data_rows($info_item, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $employe = $CI->Employee->get_info($info_item->trans_user);
    $table_data_row = "<tr>";
    $table_data_row.="<td width='20%' style='text-align: center'>" . date('d-m-Y H:i:s', strtotime($info_item->trans_date)) . "</td>";
    $table_data_row.='<td width="20%" style="text-align: left">' . $employe->first_name . ' ' . $employe->last_name;
    '</td>';
    $table_data_row.="<td width='20%' style='text-align: right'>" . format_quantity($info_item->trans_inventory) . "</td>";
    switch ($info_item->trans_comment) {
        case "POS": $comment = "Bán hàng";
            break;
        case "RECV": $comment = "Nhập hàng";
            break;
        case "CHECK": $comment = "Kiểm kho";
            break;
        case "TRANS": $comment = "Chuyển kho";
            break;
        case "RETURN_POS": $comment = "Trả hàng bán";
            break;
        case "RETURN_RECV": $comment = "Trả hàng nhập";
            break;
        case "EXP": $comment = "Xuất kho";
            break;
        case "XLS": $comment = "Import từ file Excel";
            break;
        case "PRO": $comment = "Sản xuất";
            break;
        default: $comment = "Chưa xác định";
            break;
    }
    $table_data_row.="<td width='20%' style='text-align: left'>$comment</td>";
    $store = $CI->Create_invetory->get_info($info_item->store_id);
    // $table_data_row.="<td width='20%' style='text-align: left'>" . ($store->name_inventory == "" ? "Kho tổng" : $store->name_inventory) . "</td>";
    if ($store->name_inventory == '') {
        $store_name = "Kho tổng";
    } else {
        if ($info_item->trans_inventory < 0) {
            $store_name = $store->name_inventory . '&nbsp;(Kho chuyển)';
        } else {
            $store_name = $store->name_inventory . '&nbsp;(Kho nhận)';
        }
    }
    $table_data_row.="<td width='20%' style='text-align: left'>" . $store_name . "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

//hóa đơn bán hàng dungbv
function get_sales_orders_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" >';
    $headers = array(
        '&nbsp',
        'Mã ĐH',
        'Ngày bán',
        'Khách hàng',
        'Nhân viên bán',
        'Tổng giá TT ',
        'Tổng thuế',
        'Chiết khấu',
        'Hình thức thanh toán',
        'Còn nợ',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align: center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_sales_orders_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_sales_orders_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_sales_orders_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_sales_orders_data_row($person, $controller) {
    
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
     $data['payment']=$CI->Sale->payment($person->sale_id);
  
    $total_sale = $CI->Sale->get_total_sale($person->sale_id);
    $discount = 0;
    $payment = 0;
    $total_money = 0;
    $total_taxes = 0;
    foreach ($CI->Sale->get_all()->result() as $key => $val) {
        
        $receiving_tam_all[] = $CI->Sale->get_sale_tam($val->sale_id);
        $payment_order_all[] = $CI->Sale->get_sale_items2($val->sale_id)->result_array();
    }
    
    foreach ($receiving_tam_all as $val3) {
        foreach ($val3 as $val4) {
            if ($val4['id_sale'] == $person->sale_id) {
                $pay += $val4['pays_amount'];
                $payment_type = $val4['pays_type'] . ': ' . number_format(abs($pay)) . '<br/>';
                $discount += $val4['discount_money'];
                $payment += $val4['pays_amount'];
            }
        }
    }
    $return = $CI->Inventory->get_trans_sale_return($person->sale_id);
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='1%'>";
    $table_data_row.="<input type='checkbox' id='person_" . $person->sale_id . "' value='" . $person->sale_id . "'/>";
    $table_data_row.="</td>";
    $table_data_row.='<td width="5%" style="text-align: center">' . $person->sale_id . '</td>';

    //tinh thue
    $taxes = 0;
    $total_money_discount = 0;
    $tax_total = $CI->Sale->get_sale_item_order();
    $get_taxes_item = $CI->Sale->get_taxes_item();
    $all_sales_packs = $CI->Sale->all_sales_pack($person->sale_id);
    foreach ($tax_total as $value) {
        if ($person->sale_id == $value['sale_id']) {
            foreach ($get_taxes_item as $get_value) {
                if ($value['item_id'] == $get_value['item_id']) {
                    if ($value['unit_item'] == $get_value['unit_from']) {
                        $item_price = $value['item_unit_price_rate'];
                    } else {
                        $item_price = $value['item_unit_price'];
                    }
                    $taxes += ($item_price * $value['quantity_purchased'] - $item_price * $value['quantity_purchased'] * $value['discount_percent'] / 100) * $value['taxes_percent'] / 100;

                    $total_money += $value['quantity_purchased'] * ($item_price - ($item_price * $value['discount_percent'] / 100));
                    $total_money_discount += $value['quantity_purchased']*$item_price;
                }
            }
        }
    }

    foreach ($all_sales_packs as $pack){
        $item_price = $pack->pack_unit_price;
        $total_money += $pack->quantity_purchased * ($item_price - ($item_price * $pack->discount_percent / 100));
        $total_money_discount += $pack->quantity_purchased*$item_price;
        $taxes += 0;
    }

    $table_data_row.='<td width="8%" style="text-align: center">' . date("d-m-Y H:i:s", strtotime($person->sale_time)) . '</td>';

    if ($person->customer_id == NULL) {
        $cus_name = 'KHÁCH LẺ';
    } else {
        $cus_name = $CI->Customer->get_info($person->customer_id)->first_name . ' ' . $CI->Customer->get_info($person->customer_id)->last_name;
    }
    $table_data_row.='<td width="10%" style="text-align: left">' . $cus_name . '</td>';
    $table_data_row.='<td width="10%" style="text-align: left">' . $CI->Employee->get_info($person->employee_id)->first_name . ' ' .
            $CI->Employee->get_info($person->employee_id)->last_name . '</td>';
    $table_data_row.='<td width="10%" style="text-align: right">' . number_format(abs($total_money+$taxes)) . '</td>';
    $table_data_row.='<td width="8%" style="text-align: right">' .number_format(abs($taxes)) . '</td>';
    $table_data_row.='<td width="8%" style="text-align: right">' . number_format($total_money_discount-$total_money) . '</td>';
    if($pay >= ($total_money+$taxes)){
        $pay_total = 'Tiền mặt: '.number_format($data['payment'][0]['sum']+$taxes);
    }else{
        $pay_total = $payment_type;
    }
    $CI->load->model('Sale');
    $data['payment']=$CI->Sale->payment($person->sale_id);
    $data['payment'][0]['money'] = $data['payment'][0]['sum'];
    $table_data_row.='<td width="8%" style="text-align: left">' . number_format($data['payment'][0]['sum']) . '</td>';
    if ($person->suspended == 1 || $return != 1) {
        $amount = ($total_money + $tt) - $data['payment'][0]['sum'] - $discount_money;
    } elseif ($return == 1) {
        $amount = 0;
    } else {
        $amount = ($total_money + $tt) - $data['payment'][0]['sum'] - $discount_money;
    }
    $table_data_row.='<td width="8%" style="text-align: right">' . number_format(($amount)) . '</td>';
    $table_data_row.='<td width="3%" style="text-align: center" class="rightmost">';
    $check_confirm = $CI->Employee->has_module_action_permission($controller_name, "confirm_sale", $CI->Employee->get_logged_in_employee_info()->person_id);
    $table_data_row.= "" . anchor(site_url() . "/sales/view_order/$person->sale_id", 'Xem hóa đơn', array('class' => 'thickbox', 'title' => 'Xem hóa đơn')) . '';

    $table_data_row.= anchor(site_url() . "/sales/print_order/$person->sale_id", 'In hóa đơn', array('title' => lang($controller_name . '_print')));
    $table_data_row.='</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

//request estimate
function get_request_production_manage_table($request_production, $controller) {
    $CI = & get_instance();
    $table = "<table class='tablesorter' id='sortable_table'>";
    $headers = array(
        '&nbsp;',
        'Mã yêu cầu',
        'Ghi chú',
        'Trạng thái',
        '&nbsp;'
    );
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
    $table.=get_request_production_manage_table_data_rows($request_production, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_request_production_manage_table_data_rows($request_production, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($request_production->result() as $var) {
        $table_data_rows.=get_request_production_data_row($var, $controller);
    }
    if ($request_production->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_request_production_data_row($request_production, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = "<tr>";
    $table_data_row.="<td width=5% style='text-align: center'><input type=checkbox id=$request_production->request_id name=type[] value=" . $request_production->request_id . "/></td>";
    $table_data_row.='<td width=10% style="text-align: center">' . $request_production->request_id . '</td>';
    $table_data_row.='<td width=45% style="text-align: left">' . $request_production->comment . '</td>';

    if ($request_production->status == 0) {
        $status = "Chưa tiếp nhận";
    } elseif ($request_production->status == 1) {
        $status = "Chờ tiếp nhận";
    } elseif ($request_production->status == 2) {
        $status = "Đã tiếp nhận";
    }

    $table_data_row.='<td width=25% style="text-align: left">' . $status . '</td>';
    $table_data_row.="<td width=20% style='text-align: left'>";
    $table_data_row.= "<ul>";
    $table_data_row.= "<li class=li_design_template>" . anchor(
                    $controller_name . "/request_estimate/$request_production->request_id/width~750/height~500", lang(item_kits_update_design_template), array(
                'class' => thickbox,
                id => link_underline,
                title => lang(item_kits_update_request_estimate)
                    )
            ) . "</li>";
    $table_data_row.= "<li class=li_design_template>" . anchor(
                    $controller_name . "/view_calculate/$request_production->request_id/width~900/height~500", lang(item_kits_calculate_production), array(
                //'class' => thickbox,
                id => link_underline,
                title => lang(item_kits_calculate_production)
                    )
            ) . "</li>";
    $table_data_row.= "<li class=li_design_template>" . anchor(
                    $controller_name . "/view_item_production/$request_production->request_id/width~1000", 'Lệnh sản xuất', array(
                'class' => thickbox,
                id => link_underline,
                title => 'Lệnh sản xuất',
                style => 'width: 140px'
                    )
            ) . "</li>";
    $table_data_row.= "<li class=li_design_template>" . anchor(
                    $controller_name . "/print_request_estimate/$request_production->request_id/width~1000", 'In phiếu yêu cầu', array(
                id => link_underline,
                'title' => 'In phiếu yêu cầu sản xuất',
                "style" => 'width: 140px',
                "target" => "_blank"
                    )
            ) . "</li>";
    $table_data_row.= "</ul>";
    $table_data_row.="</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* 11-9-15
 * Hưng Audi OOOO
 * account_plan */

function get_account_plan_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        'Tên tài khoản',
        'Tài khoản nợ',
        'Tài khoản có',
        '&nbsp');
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
    $table.=get_account_plan_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_account_plan_manage_table_data_rows($var_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';
    foreach ($var_type->result() as $customer) {
        $table_data_rows.=get_account_plan_data_row($customer, $controller);
    }
    if ($var_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }
    return $table_data_rows;
}

function get_account_plan_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->id' name='type[]' value='" . $var->id . "'/></td>";
    $table_data_row.='<td width="40%">' . $var->name . '</td>';
    $table_data_row.='<td width="20%">' . $var->tk_no . '</td>';
    $table_data_row.='<td width="20%">' . $var->tk_co . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor(
                    $controller_name . "/view/$var->id/width~456", lang('common_edit'), array(
                'class' => 'thickbox',
                'title' => 'Cập nhật hoạch định'
                    )
            ) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* end account_plan */


/*
  Gets the html table to manage category_processes.
 */

function get_category_processes_manage_table($category_processes, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array(
        '<input type="checkbox" id="select_all" />',
        lang('categories_id_cat'),
        lang('categories_name'),
        '&nbsp'
    );
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_category_processes_manage_table_data_rows($category_processes, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_category_processes_manage_table_data_rows($category_processes, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($category_processes->result() as $cat_pro) {
        $table_data_rows.=get_category_processes_data_row($cat_pro, $controller);
    }

    if ($category_processes->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_category_processes_data_row($category_processes, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$category_processes->cat_pro_id' value='" . $category_processes->cat_pro_id . "'/></td>";
    $table_data_row.='<td style="text-align:center" width="20%">' . $category_processes->cat_pro_id . '</td>';
    $table_data_row.='<td width="55%">' . $category_processes->cat_pro_name . '</td>';
    $table_data_row.='<td style="text-align:center" width="20%">' . anchor($controller_name . "/view/$category_processes->cat_pro_id/width~400/height~200", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

/* ngoại tệ */

function get_currency_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã ngoại tệ',
        'Tên ngoại tệ',
        'Giá ngoại tệ',
        '&nbsp');
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
    $table.=get_currency_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_currency_manage_table_data_rows($var_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($var_type->result() as $customer) {
        $table_data_rows.=get_currency_data_row($customer, $controller);
    }

    if ($var_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_currency_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->id' name='type[]' value='" . $var->id . "'/></td>";
    $table_data_row.='<td width="15%" style="text-align: center">' . $var->currency_id . '</td>';
    $table_data_row.='<td width="55%">' . $var->currency_name . '</td>';
    $table_data_row.='<td width="35%">' . number_format($var->currency_rate, 2) . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$var->id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end ngoại tệ */

//////////////////////////////////////////////
//admin agent
function get_agent_manage_table($people, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table" style="">';
    $headers = array('<input style="margin-left: 2px" type="checkbox" id="select_all" />',
        'Mã đại lý',
        'Người đại diện',
        'Đại lý cha',
        lang('common_phone_number1'),
        'Trạng thái',
        '&nbsp');
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
    $table.=get_agent_manage_table_data_rows($people, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_agent_manage_table_data_rows($people, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($people->result() as $person) {
        $table_data_rows.=get_agent_data_row($person, $controller);
    }

    if ($people->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_agent_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $start_of_time = date('d-m-Y', 0);
    $today = date('d-m-Y');
    $phone1 = "";
    if ($person->phone == '') {
        $phone1 = "DĐ:" . $person->phone_number;
    } elseif ($person->phone_number == '') {
        $phone1 = "Máy bàn:" . $person->phone;
    } elseif ($person->phone == '' && $person->phone_number == '') {
        $phone1 = "";
    } elseif ($person->phone != '' && $person->phone != '') {
        $phone1 = "DĐ:" . $person->phone_number . ' <br/> ' . "Máy bàn:" . $person->phone;
    }
    $link = site_url('customers/detail_customer_sale/' . $person->person_id);
    $table_data_row = '<tr>';
    $table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='" . $person->person_id . "'/></td>";
    $table_data_row.='<td width="12%"><div style="width:120px"><a href="' . $link . '" class="underline">' . $person->code_customer . '</div></td>';
    $table_data_row.='<td width="20%"><p style="width:120px;"><a href="' . $link . '" class="underline">' . $person->first_name . ' ' . $person->last_name . '</a></p></td>';
    $agent = $CI->Agent_model->agent();
    $agent1 = $CI->Agent_model->agent1();

    if ($CI->Agent_model->get_info($person->person_id)->agent == 0) {
        $parent = "Không có Đại Lý cha";
    } else {
        foreach ($agent as $agent_id) {
            foreach ($agent1 as $agent_id1) {
                if ($agent_id['agent'] == $agent_id1['person_id']) {
                    $id = $CI->Agent_model->get_info($person->person_id)->agent;
                    if ($agent_id1['person_id'] == $id) {
                        $parent = $CI->Agent_model->get_info($id)->code_customer;
                    }
                }
            }
        }
    }

    $table_data_row.='<td width="20%"><p style="width:100px;">' . $parent . '</p></td>';
    $table_data_row.='<td width="10%"><div style="width:100px">' . $phone1 . '</div></td>';
    if ($person->status_register == 0) {
        $stt = "Chưa kích hoạt";
    } else {
        $stt = "<font color='red'>Đã kích hoạt</font>";
    }
    $table_data_row.='<td width="9%"><div style="width: 120px">' . $stt . '</div></td>';
    $table_data_row.='<td width="6%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$person->person_id/width~755", lang('common_edit'), array(
                'class' => 'thickbox',
                'style' => 'font-size :11px;;background: #F2F2F2;border-bottom:1px solid #FFF;display:block;text-align:center;width:52px;overflow: hidden;font-weight:bold;padding:5px;text-align: center',
                'title' => lang($controller_name . '_update')
                    )
            )
            . anchor("admin_agent/statistical/$person->person_id", 'Thống kê', array('style' => 'font-size :11px;display:block;text-align:center;width:52px;overflow: hidden;background: #F2F2F2;font-weight:bold;text-align: center', 'title' => 'Thống kê'))
            . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

//hỗ trợ trực tuyến
function get_support_manage_table($units, $controller) {//
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Tên hỗ trợ',
        'Yahoo',
        'Skype',
        'Phone',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_support_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}
/*
  Gets the html data rows for the people.
 */

function get_support_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_support_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_support_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id_support' value='" . $id_support->id_support . "'/></td>"; //
    $table_data_row.='<td style="text-align:center" width="23%"><p style="width:100px">' . $id_support->name_support . '</p></td>'; //
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->yahoo . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->skype . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->phone . '</p></td>'; //
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id_support/width~$width", //
                    lang('common_edit'), array(
                'class' => 'thickbox',
                'title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}


//Video
function get_video_manage_table($units_video, $controller) {//
    $CI = & get_instance();

    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Tên Video hoặc Mạng xã hội',
        'Đường dẫn',
        'Mô tả',
        'ID',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_video_manage_table_data_rows($units_video, $controller); //
    $table.='</tbody></table>';
    return $table;
}
/*
  Gets the html data rows for the people.
 */

function get_video_manage_table_data_rows($units_video, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units_video->result() as $unit) {//
        $table_data_rows.=get_video_data_row($unit, $controller); //
    }

    if ($units_video->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_video_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $video_controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    $table_data_row.='<td style="text-align:center" width="30%"><p>' . $id_support->name . '</p></td>'; //
    $table_data_row.='<td style="padding-left:25px" width="30%"><p>' . $id_support->url . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="25%"><p>' . $id_support->des . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="5%"><p>' . $id_support->anh . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="5%" class="rightmost">'
            . anchor(
                    $video_controller_name . "/video_view/$id_support->id/width~$width", //
                    lang('common_edit'), array(
                'class' => 'thickbox',
                'title' => lang($video_controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//tin tức
function get_news_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Hình ảnh',
        'Tiêu đề',
        'Mô tả',
        'Nguồn',
        'Ngày đăng',
        'Hiển thị',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_news_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_news_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_news_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='8'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_news_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link_image = base_url() . 'news_title/' . $id_support->images;
    $no_image = base_url() . 'news_title/news-icon.jpg';
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    if ($id_support->images != null) {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $link_image . '" /></td>';
    } else {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $no_image . '" /></td>';
    }
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->title . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . substr($id_support->description, 0, 100) . '...</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->source . '</p></td>'; //
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->date . '</p></td>'; //
    if ($id_support->active == 1)
        $table_data_row.='<td style="text-align:center" width="5%"><img style="max-width:30px;max-height:30px" src="images/checked.png" alt="Hiển thị" /></td>';
    else
        $table_data_row.='<td style="text-align:center" width="5%"><img style="max-width:30px;max-height:30px" src="images/remove.png" alt="Ko hiển thị" /></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id", //
                    lang('common_edit'), array('title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//đại lý
function get_resellers_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Hình ảnh',
        'Tiêu đề',
        'Mô tả',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_resellers_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_resellers_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_resellers_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_resellers_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link_image = base_url() . 'resellers_images/' . $id_support->images;
    $no_image = base_url() . 'resellers_images/noImage.gif';
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    if ($id_support->images != null) {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $link_image . '" /></td>';
    } else {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $no_image . '" /></td>';
    }
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->title . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . substr($id_support->description, 0, 100) . '...</p></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id", //
                    lang('common_edit'), array('title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//đại lý
function get_solutions_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Hình ảnh',
        'Tiêu đề',
        'Mô tả',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_solutions_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_solutions_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_solutions_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_solutions_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link_image = base_url() . 'solutions_images/' . $id_support->images;
    $no_image = base_url() . 'solutions_images/noImage.gif';
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    if ($id_support->images != null) {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $link_image . '" /></td>';
    } else {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $no_image . '" /></td>';
    }
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->title . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . substr($id_support->description, 0, 100) . '...</p></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id", //
                    lang('common_edit'), array('title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//giới thiệu
function get_introductions_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Tiêu đề',
        'Mô tả',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_introductions_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_introductions_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_introductions_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_introductions_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link_image = base_url() . 'solutions_images/' . $id_support->images;
    $no_image = base_url() . 'solutions_images/noImage.gif';
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->title . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . substr($id_support->description, 0, 100) . '...</p></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id", //
                    lang('common_edit'), array('title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//đối tác
function get_vendors_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Hình ảnh',
        'Link',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_vendors_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_vendors_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_vendors_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_vendors_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $link_image = base_url() . 'vendors/' . $id_support->images;
    $no_image = base_url() . 'vendors/noImage.gif';
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    if ($id_support->images != null) {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $link_image . '" /></td>';
    } else {
        $table_data_row.='<td width="8%" style="height: 55px"><img style="width:48px;height:40px;float:left;text-align: center;margin-left: 5px" src="' . $no_image . '" /></td>';
    }
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->link . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id", //
                    lang('common_edit'), array('title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//contact
function get_contact_admin_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Tiêu đề',
        'Họ tên',
        'Email',
        'Tel',
        'Nội dung',
        'Trạng thái',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_contact_admin_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_contact_admin_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_contact_admin_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_contact_admin_data_row($unit, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$unit->id' value='" . $unit->id . "'/></td>"; //
    $table_data_row.='<td style="text-align:center" width="10%"><p style="word-break: break-all;">' . $unit->title . '</p></td>'; //
    $table_data_row.='<td style="text-align:center" width="15%"><p style="word-break: break-all;">' . $unit->fullname . '</p></td>'; //
    $table_data_row.='<td style="" width="20%"><p style="word-break: break-all;">' . $unit->email . '</p></td>'; //
    $table_data_row.='<td style="text-align:center" width="10%"><p>' . $unit->tel . '</p></td>'; //
    $table_data_row.='<td style="" width="40%"><p style="word-break: break-all;">' . $unit->content . '</p></td>'; //
    if ($unit->view > 0) {
        $view = "<font color='red'>Đã xem</font>";
    } else {
        $view = "Chưa xem";
    }
    $table_data_row.='<td width="5%"><p>' . $view . '</p></td>'; //
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$unit->id/width~$width", //
                    'Xem', array(
                'class' => 'thickbox',
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

//hướng dẫn mua hàng
function get_shops_guide_manage_table($units, $controller) {//
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array('<input type="checkbox" id="select_all" />',
        'Mã',
        'Nội dung',
        '&nbsp');
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_shops_guide_manage_table_data_rows($units, $controller); //
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_shops_guide_manage_table_data_rows($units, $controller) {//
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($units->result() as $unit) {//
        $table_data_rows.=get_shops_guide_data_row($unit, $controller); //
    }

    if ($units->num_rows() == 0) {//
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_shops_guide_data_row($id_support, $controller) {//
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$id_support->id' value='" . $id_support->id . "'/></td>"; //
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->id . '</p></td>';
    $table_data_row.='<td style="padding-left:25px" width="20%"><p style="width:100px">' . $id_support->content . '</p></td>';
    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">'
            . anchor(
                    $controller_name . "/view/$id_support->id", //
                    lang('common_edit'), array('title' => lang($controller_name . '_update')
                    )
            ) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}

function get_quotes_contract_manage_table($quotes_contract, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array(
        '<input type="checkbox" id="select_all" />',
        'Mã BG - HĐ',
        'Tiêu đề',
        'Loại mẫu',
        '&nbsp'
    );
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_quotes_contract_manage_table_data_rows($quotes_contract, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */

function get_quotes_contract_manage_table_data_rows($quotes_contract, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($quotes_contract->result() as $val) {
        $table_data_rows.=get_quotes_contract_data_row($val, $controller);
    }

    if ($quotes_contract->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_quotes_contract_data_row($quotes_contract, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $table_data_row = '<tr>';
    $table_data_row .= "<td style='width: 5%; text-align: center'><input type='checkbox' id='person_$quotes_contract->id_quotes_contract' value='" . $quotes_contract->id_quotes_contract . "'/></td>";
    $table_data_row .= "<td style='width: 10%; text-align: center'>$quotes_contract->id_quotes_contract</td>";
    $table_data_row .= "<td style='width: 50%'>$quotes_contract->title_quotes_contract</td>";
    $table_data_row .= "<td style='width: 20%'>" . ($quotes_contract->cat_quotes_contract == 1 ? "Mẫu hợp đồng" : "Mẫu báo giá") . "</td>";
    $table_data_row .= "<td style='width: 15%; text-align: center'>";
    $table_data_row .= "<ul>";
    $table_data_row .= "<li class='li_design_template'><a href='" . base_url($controller_name . '/view/' . $quotes_contract->id_quotes_contract) . "' title='" . lang($controller_name . '_update') . "'>" . lang($controller_name . '_update') . "</a></li>";
    $table_data_row .= "</ul>";
    $table_data_row .= "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}
    //Hưng Audi 0000 Oct 28
    // hello HallOweeN (^_^)
function get_import_product_manage_table($import_product, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array(
        //'<input type="checkbox" id="select_all" />',
        'Số phiếu',
        'Ngày tháng',
        'Số lượng',
        '&nbsp'
    );
    $table.='<thead><tr>';
    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_import_product_manage_table_data_rows($import_product, $controller);
    $table.='</tbody></table>';
    return $table;
}
function get_import_product_manage_table_data_rows($import_product, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($import_product->result() as $val) {
        $table_data_rows.=get_import_product_data_row($val, $controller);
    }

    if ($import_product->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}
function get_import_product_data_row($import_product, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    //$info_inventory = $CI->Inventory->get_inventory_by_import_product_id($import_product->id)->row();
    $quantity = $CI->Inventory->get_inventory_by_import_product_id_2016($import_product->import_product_id)->quantity;

    $table_data_row = '<tr>';
    $table_data_row .= "<td style='width: 20%; text-align: center'>$import_product->import_product_id</td>";
    $table_data_row .= "<td style='width: 30%; text-align: center'>".date('d-m-Y H:i:s', strtotime($import_product->trans_date))."</td>";
    $table_data_row .= "<td style='width: 30%; text-align: right'>$quantity</td>";
    $table_data_row .= "<td style='width: 15%; text-align: center'><a href="
        .site_url('item_kits/switch_order_warehouse/'.$import_product->import_product_id)." id=link_underline >Phiếu nhập kho</a></td>";
    $table_data_row .= "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}
/*
                              /\     /\     /\     /\
                             *==*   *==*   *==*   *==*
                        ____//  \\ //  \\ //  \\ //  \\____           Nhat_Tan_Bridge

                      ~~~~    ~~~~~~~~    ~~~~~~~~    ~~~~                rEd rIvEr
                       ~~~~     ~~~~~   ~~~~~~      ~~~~~~
 */
    //hoa don dich vu by No Name
    //10-11-15 10h11'15s
function get_order_service_manage_table($import_product, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array(
        '<input type="checkbox" id="select_all" />',
        'Số HĐ',
        'Ký hiệu HĐ',
        'Ngày HĐ',
        'Ngày chứng từ',
        'Đối tượng',
        'Diễn giải',
        '&nbsp'
    );
    $table.='<thead><tr>';
    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_order_service_manage_table_data_rows($import_product, $controller);
    $table.='</tbody></table>';
    return $table;
}
function get_order_service_manage_table_data_rows($import_product, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($import_product->result() as $val) {
        $table_data_rows.=get_order_service_data_row($val, $controller);
    }

    if ($import_product->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}
function get_order_service_data_row($ZeNdA, $controller) {
    $CI = & get_instance();
    if($CI->Supplier->exists($ZeNdA->person_id))
        $person_name = $CI->Supplier->get_info($ZeNdA->person_id)->company_name;
    elseif($CI->Customer->exists($ZeNdA->person_id))
        $person_name = $CI->Customer->get_info($ZeNdA->person_id)->first_name.' '.$CI->Customer->get_info($ZeNdA->person_id)->last_name;
    elseif($CI->Employee->exists($ZeNdA->person_id))
        $person_name = $CI->Employee->get_info($ZeNdA->person_id)->first_name.' '.$CI->Employee->get_info($ZeNdA->person_id)->last_name;

    $table_data_row = '<tr>';
    $table_data_row .= "<td style='width: 5%; text-align: center'><input type='checkbox' id='person_$ZeNdA->id' value='" . $ZeNdA->id . "'/></td>";
    $table_data_row .= "<td style='width: 6%; text-align: center'>$ZeNdA->number</td>";
    $table_data_row .= "<td style='width: 10%; text-align: center'>$ZeNdA->symbol</td>";
    $table_data_row .= "<td style='width: 15%; text-align: center'>".date('d-m-Y', strtotime($ZeNdA->create_date))."</td>";
    $table_data_row .= "<td style='width: 15%; text-align: center'>".date('d-m-Y', strtotime($ZeNdA->order_date))."</td>";
    $table_data_row .= "<td style='width: 21%; text-align: left'>$person_name</td>";
    $table_data_row .= "<td style='width: 20%; text-align: left'>$ZeNdA->comment</td>";
    $table_data_row .= "<td style='width: 8%; text-align: center'><a href="
        .site_url('costs/view_order_service/'.$ZeNdA->id.'/width~789')." class=thickbox title='Cập nhật hóa đơn' >Sửa</a></td>";
    $table_data_row .= "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

/* hóa đơn chi phí
 *
 *  dũng chíp (đã có vợ)
 */

function get_bill_cost_manage_table($customer_type, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        'Số CT',
        'Ngày CT',
        'Diễn giải',
        'Đối tượng',
        '&nbsp');
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
    $table.=get_bill_cost_manage_table_data_rows($customer_type, $controller);
    $table.='</tbody></table>';
    return $table;
}

function get_bill_cost_manage_table_data_rows($var_type, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($var_type->result() as $customer) {
        $table_data_rows.=get_bill_cost_data_row($customer, $controller);
    }

    if ($var_type->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}


function get_bill_cost_data_row($var, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();

    if($CI->Supplier->exists($var->id_cus))
        $person_name = $CI->Supplier->get_info($var->id_cus)->company_name;
    elseif($CI->Customer->exists($var->id_cus))
        $person_name = $CI->Customer->get_info($var->id_cus)->first_name.' '.$CI->Customer->get_info($var->id_cus)->last_name;
    elseif($CI->Employee->exists($var->id_cus))
        $person_name = $CI->Employee->get_info($var->id_cus)->first_name.' '.$CI->Employee->get_info($var->id_cus)->last_name;

    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$var->id' name='type[]' value='" . $var->id . "'/></td>";
    $table_data_row.='<td width="5%" style="text-align: center">' . $var->id . '</td>';
    $table_data_row.='<td width="12%" style="text-align: center">' . date('d-m-Y',  strtotime($var->date)) . '</td>';
    $table_data_row.='<td width="50%">' . $var->content . '</td>';
    $table_data_row.='<td width="30%">'. $person_name.'</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$var->id/width~678", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';

    return $table_data_row;
}

/* end chung tu */

//____________________________________say gOOdbye Hưng Audi___________________________________

function get_tkdu_manage_table_audi($result, $vitamin_C) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array('<input type="checkbox" id="select_all" />',
        lang('common_id_tk'),
        lang('common_name_tk'),
        lang('common_tk_level'),
        lang('common_tk_parent'),
        lang('cat_tk'),
        'Ghi chú',
        '&nbsp');
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
    $table.=get_tkdu_manage_table_data_rows_audi($result, $vitamin_C);
    $table.='</tbody></table>';
    return $table;
}

function get_tkdu_manage_table_data_rows_audi($result, $vitamin_C) {
    $CI = & get_instance();
    $table_data_rows = '';

    $vip = array();
    foreach ($result->result() as $parent1){
        $vip[$parent1->id] = $parent1->name;
        $parents2 = $CI->Tkdu->get_all_tk2_by_tk1($parent1->id)->result();
        if($parents2){
            foreach ($parents2 as $parent2){
                $parents3 = $CI->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                if($parents3){
                    $vip[$parent2->id] = $parent2->name;
                    foreach ($parents3 as $parent3){
                        $vip[$parent3->id] = $parent2->name;
                    }
                }else{
                    $vip[$parent2->id] = $parent2->name;
                }
            }
        }else{
            $vip[$parent1->id] = $parent1->name;
        }
    }
    foreach ($vip as $id => $val){
        $table_data_rows.=get_tkdu_data_row_audi($id, $vitamin_C);
    }
    if ($result->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_tkdu_data_row_audi($id, $vitamin_C) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $vitamin_C->get_form_width();
    $info_tkdu = $CI->Tkdu->get_info($id);

    $table_data_row = '<tr>';
    $table_data_row.="<td width='1%'><input type='checkbox' id='$id' name='type[]' value='" . $id . "'/></td>";
    $table_data_row.='<td width="10%">' . $id . '</td>';
    $table_data_row.='<td width="30%">'.$info_tkdu->name.'</td>';
    $table_data_row.='<td width="5%">'.$info_tkdu->level.'</td>';
    $table_data_row.='<td width="20%">' . $CI->Tkdu->get_info($info_tkdu->id_parent)->name . '</td>';
    $table_data_row.='<td width="20%">' . $CI->Tkdu->get_info_account_type($info_tkdu->acc_cat_id)->type_name . '</td>';
    $table_data_row.='<td width="15%">' . $info_tkdu->comment . '</td>';
    $table_data_row.='<td width="1%" class="rightmost">' . anchor($controller_name . "/view/$id/width~$width", lang('common_edit'), array('class' => 'thickbox', 'title' => lang($controller_name . '_update'))) . '</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}

//hóa đơn dịch vụ : Bán hàng
function get_order_service_bh_manage_table($import_product, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';
    $headers = array(
        '<input type="checkbox" id="select_all" />',
        'Số HĐ',
        'Ký hiệu HĐ',
        'Ngày HĐ',
        'Ngày chứng từ',
        'Đối tượng',
        'Diễn giải',
        '&nbsp'
    );
    $table.='<thead><tr>';
    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_order_service_bh_manage_table_data_rows($import_product, $controller);
    $table.='</tbody></table>';
    return $table;
}
function get_order_service_bh_manage_table_data_rows($import_product, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($import_product->result() as $val) {
        $table_data_rows.=get_order_service_bh_data_row($val, $controller);
    }

    if ($import_product->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='5'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}
function get_order_service_bh_data_row($ZeNdA, $controller) {
    $CI = & get_instance();
    if($CI->Supplier->exists($ZeNdA->person_id))
        $person_name = $CI->Supplier->get_info($ZeNdA->person_id)->company_name;
    elseif($CI->Customer->exists($ZeNdA->person_id))
        $person_name = $CI->Customer->get_info($ZeNdA->person_id)->first_name.' '.$CI->Customer->get_info($ZeNdA->person_id)->last_name;
    elseif($CI->Employee->exists($ZeNdA->person_id))
        $person_name = $CI->Employee->get_info($ZeNdA->person_id)->first_name.' '.$CI->Employee->get_info($ZeNdA->person_id)->last_name;

    $table_data_row = '<tr>';
    $table_data_row .= "<td style='width: 5%; text-align: center'><input type='checkbox' id='person_$ZeNdA->id' value='" . $ZeNdA->id . "'/></td>";
    $table_data_row .= "<td style='width: 6%; text-align: center'>$ZeNdA->number</td>";
    $table_data_row .= "<td style='width: 10%; text-align: center'>$ZeNdA->symbol</td>";
    $table_data_row .= "<td style='width: 15%; text-align: center'>".date('d-m-Y', strtotime($ZeNdA->create_date))."</td>";
    $table_data_row .= "<td style='width: 15%; text-align: center'>".date('d-m-Y', strtotime($ZeNdA->order_date))."</td>";
    $table_data_row .= "<td style='width: 21%; text-align: left'>$person_name</td>";
    $table_data_row .= "<td style='width: 20%; text-align: left'>$ZeNdA->comment</td>";
    $table_data_row .= "<td style='width: 8%; text-align: center'><a href="
        .site_url('costs/view_order_service_bh/'.$ZeNdA->id.'/width~789')." class=thickbox title='Cập nhật hóa đơn' >Sửa</a></td>";
    $table_data_row .= "</td>";
    $table_data_row.='</tr>';
    return $table_data_row;
}

//////////////////
/*
  Gets the html table to manage news_category.
 */
function get_news_category_manage_table($news_category, $controller) {
    $CI = & get_instance();
    $table = '<table class="tablesorter" id="sortable_table">';

    $headers = array(
        '<input type="checkbox" id="select_all" />',
        lang('news_category_name'),
        lang('news_category_active'),
        '&nbsp'
    );
    $table.='<thead><tr>';

    $count = 0;
    foreach ($headers as $header) {
        $count++;

        if ($count == 1) {
            $table.="<th style='text-align:center' class='leftmost'>$header</th>";
        } elseif ($count == count($headers)) {
            $table.="<th style='text-align:center' class='rightmost'>$header</th>";
        } else {
            $table.="<th style='text-align:center'>$header</th>";
        }
    }
    $table.='</tr></thead><tbody>';
    $table.=get_news_category_manage_table_data_rows($news_category, $controller);
    $table.='</tbody></table>';
    return $table;
}

/*
  Gets the html data rows for the people.
 */
function get_news_category_manage_table_data_rows($news_category, $controller) {
    $CI = & get_instance();
    $table_data_rows = '';

    foreach ($news_category->result() as $category) {
        $table_data_rows.=get_news_category_data_row($category, $controller);
    }

    if ($news_category->num_rows() == 0) {
        $table_data_rows.="<tr><td colspan='4'><div class='warning_message' style='padding:7px;'>" . lang('common_no_persons_to_display') . "</div></tr></tr>";
    }

    return $table_data_rows;
}

function get_news_category_data_row($news_category, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $width = $controller->get_form_width();
    $table_data_row = '<tr>';
    $table_data_row.="<td style='text-align:center' width='5%'><input type='checkbox' id='person_$news_category->id_cat' value='" . $news_category->id_cat . "'/></td>";
    $table_data_row.='<td style="padding-left:25px" width="35%"><p style="width:170px">' . $news_category->name . '</p></td>';

    if ($news_category->active == 0x001)
        $table_data_row.='<td style="text-align:center" width="5%"><img style="max-width:30px;max-height:30px" src="images/checked.png" alt="Hiển thị" /></td>';
    else
        $table_data_row.='<td style="text-align:center" width="5%">src="images/checked.png" alt="Hiển thị" </td>';

    $table_data_row.='<td style="text-align:center" width="2%" class="rightmost">' . anchor($controller_name . "/view/$news_category->id_cat", lang('common_edit'), array('title' => lang($controller_name . '_update'))) . '</td>';  // link sửa chữa "sửa"

    $table_data_row.='</tr>';

    return $table_data_row;
}


?>
