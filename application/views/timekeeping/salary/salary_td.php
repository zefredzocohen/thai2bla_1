<?php
$i = 1;
$t_count_lcb = 0;
$t_count_pc_an_trua = 0;
$t_count_pc_chuc_vu = 0;
$t_count_pc_tham_nien = 0;
$t_count_pc_thuong_du_an = 0;
$t_count_pc_may_tinh = 0;
$t_count_pc_dt_xang_xe = 0;
$t_count_pc_ho_tro_khac = 0;
$t_tong_pc = 0;
$t_BHXH = 0;
$t_luong_thuc_te = 0;
$t_so_no_ky_truoc = 0;
$t_tien_tam_giu = 0;
$t_tien_tam_ung = 0;
$t_tong_tien_thuc_linh = 0;
$t_tien_thuc_te_thanh_toan = 0;
$t_tong_so_no_luong = 0;
$t_du_tinh_thanh_toan_dot_1 = 0;
$t_du_tinh_thanh_toan_dot_2 = 0;
$t_hoan_ung_thu_lai = 0;
$t_count_pc_dt = 0;

if(count($person_info) > 0 ){
    foreach($person_info AS $key => $values){
    echo "<tr id='".$values->person_id."' class='edit_tr'>";
    ?>
    <td><?php echo $i ?></td>

    <td style="text-align: left;font-size: 12px"><?php echo $values->first_name ?></td>
    <td style="font-weight: 500" class="edit_td">
        <input type="hidden" name="month_salary" class="month_salary" value="" >
        <input type="hidden" name="year_salary" class="year_salary" value="" >

        <span class="text_<?php echo $values->person_id ?> text text_em_salary_basic_<?php echo $values->person_id ?>" > <?php echo number_format($values->em_salary_basic*$values->hs_salary,0,"",",");?></span>
        <input class="input_<?php echo $values->person_id ?> input input_em_salary_basic_<?php echo $values->person_id ?>"  type="text" style="width: 68px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php echo number_format($values->em_salary_basic*$values->hs_salary,0,"",","); ?>" />
    </td>

    <td style="font-weight: 500" class="edit_td">
        <span class="text_<?php echo $values->person_id ?> text text_em_wage_level_coverage_<?php echo $values->person_id ?>" > <?php if(empty($values->em_wage_level_coverage)) echo "-"; else echo number_format($values->em_wage_level_coverage,0,"",","); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_em_wage_level_coverage_<?php echo $values->person_id ?>"  type="text" style="width: 68px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($values->em_wage_level_coverage)) echo "-"; else echo number_format($values->em_wage_level_coverage,0,"",","); ?>" />
    </td>

    <?php
    $item_total = '';
    foreach($salarycongfig_info AS $key=>$item) {
        if($item->person_id == $values->person_id){
            if($item_total == '')
            $item_total .= $item->total_all;
        }
    }?>
    <td style="font-weight: 500"><?php if(empty($item_total)) echo '-';else echo $item_total; ?></td>

    <?php
        $total_x150 = '';
        $total_x200 = '';
        $total_x300 = '';
        foreach($salarycongfig_info AS $item){
            if($item->person_id == $values->person_id ){
                if($total_x150 == '') $total_x150 .= $item->total_x150;
                if($total_x200 == '') $total_x200 .= $item->total_x200;
                if($total_x300 == '') $total_x300 .= $item->total_x300;
            }
        }
    ?>
    <td style="font-weight: 500" class="edit_td">
        <span class="text_<?php echo $values->person_id ?> text text_total_x150_<?php echo $values->person_id ?>"><?php if(empty($total_x150)) echo '-';else echo $total_x150; ?> </span>
       <!-- <input class="input_<?php /*echo $values->person_id */?> input input_total_x150_<?php /*echo $values->person_id */?>" type="text" style="width: 28px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php /*if(empty($total_x150)) echo '-';else echo $total_x150; */?>" />-->
    </td>
    <td style="font-weight: 500" class="edit_td">
        <span class="text_<?php echo $values->person_id ?> text text_total_x200_<?php echo $values->person_id ?>"><?php if(empty($total_x200)) echo '-';else echo $total_x200; ?> </span>
       <!-- <input class="input_<?php /*echo $values->person_id */?> input input_total_x200_<?php /*echo $values->person_id */?>" type="text" style="width: 28px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php /*if(empty($total_x200)) echo '-';else echo $total_x200 */?>" />-->
    </td>
    <td style="font-weight: 500" class="edit_td">
        <span class="text_<?php echo $values->person_id ?> text text_total_x300_<?php echo $values->person_id ?>"><?php if(empty($total_x300)) echo '-';else echo $total_x300; ?> </span>
       <!-- <input class="input_<?php /*echo $values->person_id */?> input input_total_x300_<?php /*echo $values->person_id */?>" type="text" style="width: 28px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php /*if(empty($total_x300)) echo '-';else echo $total_x300 */?>" />-->
    </td>

    <?php
    /*
     * Khai báo các biến tổng lương cơ bản cho nhân viên
     * */
    $count_lcb = $values->em_salary_basic/$salary_option->numberdays*($item_total
                       + $total_x150*$salary_option->percent_overtime_weekdays/100
                       + $total_x200*$salary_option->percent_overtime_weekdays/100
                       + $total_x300*$salary_option->percent_overtime_weekdays/100);
    $t_count_lcb = $t_count_lcb + $count_lcb;
    $number_pc = 0;
    $number_thucte = 0;
    ?>
    <!--TÔNG LUONG CO BẢN-->
    <td><?php echo number_format($count_lcb,0,"",","); ?></td>
    <!--Phụ cấp ăn trưa-->
    <?php
    $pc_lunch= "";
   /* foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_lunch.= $item->pc_lunch;
        }
    }*/
    $number_pc += $this->Timekeepings->getConfigSalary('meals');
    $t_count_pc_an_trua = $t_count_pc_an_trua + $this->Timekeepings->getConfigSalary('meals');
    ?>
    <td style='font-weight: 500'>
        <?php if($number_pc > 0){ ?>
            <span <!--class="text_<?php /*echo $values->person_id */?> text text_pc_lunch_--><?php /*echo $values->person_id */?>"><?php if(empty($number_pc)) echo "-";else echo number_format($number_pc,0,'',','); ?></span>
        <!--<input class="input_<?php /*echo $values->person_id */?> input input_pc_lunch_<?php /*echo $values->person_id */?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php /*if(empty($number_pc)) echo "-";else echo number_format($number_pc,0,'',','); */?>" />-->
        <?php }else{ ?>
            <span>-</span>
        <?php }?>
    </td>

    <?php
    //HỖ TRỢ THÂM NIÊN
    $pc_seniority= "";
    foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_seniority .= $item->pc_seniority;
        }
    }
    $number_pc += $pc_seniority;
    $t_count_pc_tham_nien = $t_count_pc_tham_nien + $pc_seniority;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?> text text_pc_seniority_<?php echo $values->person_id ?>"><?php if(empty($pc_seniority)) echo '-';else  echo  number_format($pc_seniority,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_pc_seniority_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($pc_seniority)) echo '-';else echo number_format($pc_seniority,0,'',',');  ?>" />
    </td>

    <?php
    //Hỗ trợ chức vụ
    $pc_position= "";
    foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_position .= $item->pc_position;
        }
    }
    $number_pc += $pc_position;
    $t_count_pc_chuc_vu = $t_count_pc_chuc_vu + $pc_position;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?> text text_pc_position_<?php echo $values->person_id ?>"><?php if(empty($pc_position)) echo "-";else echo number_format($pc_position,0,'',',');  ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_pc_position_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($pc_position)) echo "-";else echo number_format($pc_position,0,'',','); ?>" />
    </td>

    <?php
    //Hô trợ thưởng dụ án
    $pc_project = "";
    foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_project .= $item->pc_project;
        }
    }
    $number_pc += $pc_project;
    $t_count_pc_thuong_du_an = $t_count_pc_thuong_du_an + $pc_project;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?> text text_pc_project_<?php echo $values->person_id ?>"><?php if(empty($pc_project)) echo "-";else echo number_format($pc_project,0,'',',');  ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_pc_project_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($pc_project)) echo "-";else echo number_format($pc_project,0,'',','); ?>" />
    </td>

    <?php
    //Phụ cấp máy tính cho nhân viên
    $pc_computer= "";
    foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_computer .= $item->pc_computer;
        }
    }
    $number_pc += $pc_computer;
    $t_count_pc_may_tinh = $t_count_pc_may_tinh + $pc_computer;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?> text text_pc_computer_<?php echo $values->person_id ?>"><?php if(empty($pc_computer)) echo '-';else echo number_format($pc_computer,0,'',',');  ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_pc_computer_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($pc_computer)) echo '-';else echo number_format($pc_computer,0,'',',');  ?>" />
    </td>
    <!-- PHỤ CẤP XĂNG XE-->
    <?php
    $pc_petrol_phone= "";
    foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_petrol_phone .= $item->pc_petrol_phone;
        }
    }
    $number_pc += $pc_petrol_phone;
    $t_count_pc_dt_xang_xe = $t_count_pc_dt_xang_xe + $pc_petrol_phone;
    ?>

    <td style='font-weight: 500'>
        <?php if($values->check_petrol == 1) {?>
            <span class="text_<?php echo $values->person_id ?> text text_pc_petrol_phone_--><?php echo $values->person_id ?>"><?php if(empty($pc_petrol_phone)) echo '-';else echo number_format($pc_petrol_phone,0,'',','); ?></span>
            <input class="input_<?php echo $values->person_id ?> input input_pc_petrol_phone_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php  if(empty($pc_petrol_phone)) echo '-';else echo number_format($pc_petrol_phone,0,'',','); ?>" />
        <?php }else{ ?>
            <span>-</span>
        <?php }?>

    </td>

    </td>
    <!-- PHỤ CẤP DIỆN THOẠI-->
    <?php
    $pc_petrol_phone= "";
 /*   foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_petrol_phone .= $item->pc_petrol_phone;
        }
    }*/
    $number_dt += $this->Timekeepings->getConfigSalary('config_phone_support');
    $t_count_pc_dt = $t_count_pc_dt + $number_dt;
    ?>

    <td style='font-weight: 500'>
        <?php if($values->check_phone == 1){?>
          <span class="text_<?php echo $values->person_id ?> text text_pc_phone_<?php echo $values->person_id ?>"><?php if(empty($number_dt)) echo '-';else echo number_format($number_dt,0,'',','); ?></span>
          <input class="input_<?php echo $values->person_id ?> input input_pc_phone_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($number_dt)) echo '-';else echo number_format($number_dt,0,'',','); ?>" />
        <?php }else{ ?>
            <span>-</span>
        <?php }?>
    </td>

    <?php
    //Hỗ trợ khác cho nhân viên
    $pc_other_support= "";
    foreach($rewards_info AS $key=>$item){
        if($item->person_id == $values->person_id){
            $pc_other_support .= $item->pc_other_support;
        }
    }
    $number_pc += $pc_other_support;
    $t_count_pc_ho_tro_khac = $t_count_pc_ho_tro_khac + $pc_other_support;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?> text text_pc_other_support_<?php echo $values->person_id ?>"><?php if(empty($pc_other_support)) echo '-';else echo number_format($pc_other_support,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_pc_other_support_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($pc_other_support)) echo '-';else echo number_format($pc_other_support,0,'',','); ?>" />
    </td>
    <!--TỔNG LƯƠNG PHỤ CẤP KHEN THƯỞNG CHO NHÂN VIÊN TRONG 1 NGAY-->
    <td><?php if($number_pc == 0) echo '-'; else echo number_format($number_pc,0,'',','); ?></td>
    <?php
    //TỔNG TẤT CẢ KHEN THUONGR PHỤ CẤP CHO NHÂN VIÊN TRONG 1 THÁNG
    $t_tong_pc = $t_tong_pc + $number_pc;
    ?>
    <!--Số tiền bảo hiểm xã hôi cho toàn nhân viên-->
    <td style="font-weight: 500"><?php if($values->em_social_insurance != 0) echo number_format($values->em_social_insurance,0,'',','); else echo '-'; ?></td>
    <?php $t_BHXH = $t_BHXH + $values->em_social_insurance; ?>
    <!-- Tổng tiền lương thực tế cho nhân viên -->
    <?php
    $number_thucte = $number_pc + $count_lcb - $values->em_social_insurance;
    $t_luong_thuc_te = $t_luong_thuc_te +  $number_thucte;
    ?>
    <td><?php if($number_thucte != 0) echo number_format($number_thucte,0,'',',') ;else echo '-' ?></td>

    <?php
    /*
     * Số tiền kỳ trước còn nợ
     * */
    $money_amount_owed = '';
    foreach( $salary_info AS $key=> $items){
        if($items->person_id == $values->person_id){
            $money_amount_owed .= $items->money_amount_owed;
        }
    }
    $t_so_no_ky_truoc = $money_amount_owed + $t_so_no_ky_truoc;
    ?>

    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?>  text text_money_amount_owed_<?php echo $values->person_id ?>"><?php if(empty($money_amount_owed)) echo '-';else echo number_format($money_amount_owed,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_money_amount_owed_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if($money_amount_owed == 0) echo '-';else echo number_format($money_amount_owed,0,'',',');  ?>" />
    </td>

    <?php
    //Số tiền tạm giữ
    $money_custody = '';
    foreach( $salary_info AS $key=> $items){
        if($items->person_id == $values->person_id){
            $money_custody .= $items->money_custody;
        }
    }
    $t_tien_tam_giu = $t_tien_tam_giu + $money_custody;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?>  text  text_money_custody_<?php echo $values->person_id ?>"><?php if(empty($money_custody)) echo '-';else echo number_format($money_custody,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input  input_money_custody_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($money_custody)) echo '0'; else echo number_format($money_custody,0,'',',');  ?>" />
    </td>

    <?php
    //Số tiền tạm ứng cho nhân viên
    $money_advance = '';
    foreach( $salary_info AS $key=> $items){
        if($items->person_id == $values->person_id){
            $money_advance .= $items->money_advance;
        }
    }
    $t_tien_tam_ung = $t_tien_tam_ung + $money_advance;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?>  text text_money_advance_<?php echo $values->person_id ?>"><?php if(empty($money_advance)) echo '-';else echo number_format($money_advance,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_money_advance_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($money_advance)) echo '0';else echo number_format($money_advance,0,'',',');  ?>" />
    </td>

    <?php
    //Tổng số tiền thực lĩnh cửa nhân viên
    $num_thuc_linh = $number_thucte + $money_amount_owed  - $money_advance - $money_custody;
    $t_tong_tien_thuc_linh = $t_tong_tien_thuc_linh + $num_thuc_linh;
    $total_real_wages = ''; ?>

    <td style='font-weight: bold;color: red'>
        <?php  echo number_format($num_thuc_linh,0,'',','); ?>
    </td>
    <!-- Thực tế thanh toán -->
    <?php foreach( $salary_info AS $key=> $items){
        if($items->person_id == $values->person_id){
            $total_real_wages .= $items->total_real_wages;
        }
    }
    $t_tien_thuc_te_thanh_toan = $total_real_wages + $t_tien_thuc_te_thanh_toan
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?> text text_total_real_wages_<?php echo $values->person_id ?>"><?php if(empty($total_real_wages)) echo '-';else echo number_format($total_real_wages,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_total_real_wages_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($total_real_wages)) echo '-';else echo number_format($total_real_wages,0,'',',');  ?>" />
    </td>
    <!--SỐ NỢ LƯƠNG-->
    <?php
    $expected_salary_11 = '';
    foreach( $salary_info AS $key => $items){
        if($items->person_id == $values->person_id){
            $expected_salary_11 .= $items->expected_salary_1;
        }
    }
    $expected_salary_12 = '';
    foreach( $salary_info AS $key => $items){
        if($items->person_id == $values->person_id){
            $expected_salary_12 .= $items->expected_salary_2;
        }
    }
    $so_no_luong = $num_thuc_linh - $total_real_wages - $expected_salary_11 - $expected_salary_12;
    $t_tong_so_no_luong = $t_tong_so_no_luong + $so_no_luong;
    ?>
    <input type="hidden" name="tong_tien_thuc_linh[]" class="tong_tien_thuc_linh" value="<?php echo $num_thuc_linh.'#'.$values->person_id .'#'.$so_no_luong ?>" >
    <td style='font-weight: 500'>
        <?php if(empty($so_no_luong)) echo '-';else echo number_format($so_no_luong,0,'',',') ;  ?>
    </td>

    <?php
    //Số tiền dự toán đợt 1
    $expected_salary_1 = '';
    foreach( $salary_info AS $key => $items){
        if($items->person_id == $values->person_id){
            $expected_salary_1 .= $items->expected_salary_1;
        }
    }
    $t_du_tinh_thanh_toan_dot_1 = $t_du_tinh_thanh_toan_dot_1 + $expected_salary_1;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?>  text  text_expected_salary_1_<?php echo $values->person_id ?>"><?php if(empty($expected_salary_1)) echo '-';else echo number_format($expected_salary_1,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_expected_salary_1_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($expected_salary_1)) echo '-';else echo number_format($expected_salary_1,0,'',',');  ?>" />
    </td>

    <?php
    //Số tiền dự toán đợt 2
    $expected_salary_2 = '';
    foreach( $salary_info AS $key=> $items){
        if($items->person_id == $values->person_id){
            $expected_salary_2 .= $items->expected_salary_2;
        }
    }
    $t_du_tinh_thanh_toan_dot_2 = $t_du_tinh_thanh_toan_dot_2 + $expected_salary_2;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?>  text  text_expected_salary_2_<?php echo $values->person_id ?>"><?php if(empty($expected_salary_2)) echo '-';else echo number_format($expected_salary_2,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input  input_expected_salary_2_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php if(empty($expected_salary_2)) echo '-';else echo number_format($expected_salary_2,0,'',','); ?>" />
    </td>

    <?php
    //Số tiền dự toán đợt 2
    $account_complete_again = '';
    foreach( $salary_info AS $key=> $items){
        if($items->person_id == $values->person_id){
            $account_complete_again .= $items->account_complete_again;
        }
    }
    $t_hoan_ung_thu_lai = $t_hoan_ung_thu_lai + $account_complete_again;
    ?>
    <td style='font-weight: 500'>
        <span class="text_<?php echo $values->person_id ?>  text input_account_complete_again_<?php echo $values->person_id ?>"><?php if(empty($account_complete_again)) echo '-';else echo number_format($account_complete_again,0,'',','); ?></span>
        <input class="input_<?php echo $values->person_id ?> input input_account_complete_again_<?php echo $values->person_id ?>" type="text" style="width: 60px;height:15px;font-size: 12px;padding: 2px 3px;border: 1px inset #CCC" value="<?php  if(empty($account_complete_again)) echo '-';else echo number_format($account_complete_again,0,'',','); ?>" />
    </td>


    <?php
    echo "</tr>";
    $i++;
    }
}else{
    echo '<tr class="tb-timekeeping-contaner">
                <td colspan="30" style="padding: 10px 0px;height: 20px;line-height: 30px;font-size: 12px;color: #333;font-family: Arial, Helvetica, sans-serif;font-weight: 500">Thông báo: Chưa có nhân viên nào được tính lương trong <span style="color: red;" class="month_name">&nbsp;&nbsp;</span> năm <span style="color:red;" class="year_name"></span></td>
          </tr>';
}
?>


<tr id="number_one">
    <td>&nbsp;</td>
    <td bgcolor="#00b050">Tổng</td>
    <td bgcolor="#00b050">&nbsp;</td>
    <td bgcolor="#00b050">&nbsp;</td>
    <td bgcolor="#00b050">&nbsp;</td>
    <td bgcolor="#00b050">&nbsp;</td>
    <td bgcolor="#00b050">&nbsp;</td>
    <td bgcolor="#00b050">&nbsp;</td>
    <td bgcolor="#00b050"><?php if($t_count_lcb == 0) echo 0; else echo number_format($t_count_lcb,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_an_trua == 0) echo 0; else echo number_format($t_count_pc_an_trua,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_tham_nien == 0) echo 0;else echo number_format($t_count_pc_tham_nien,0,'',','); ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_chuc_vu == 0) echo 0;else echo number_format($t_count_pc_chuc_vu,0,'',','); ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_thuong_du_an == 0) echo 0; else echo number_format($t_count_pc_thuong_du_an,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_may_tinh == 0) echo 0; else echo number_format($t_count_pc_may_tinh,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_dt_xang_xe == 0) echo 0; else echo number_format($t_count_pc_dt_xang_xe,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_dt == 0) echo 0; else echo number_format($t_count_pc_dt,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_count_pc_ho_tro_khac == 0) echo 0; else echo number_format($t_count_pc_ho_tro_khac,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_tong_pc == 0) echo '-'; else echo number_format($t_tong_pc,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_BHXH == 0) echo 0; else echo number_format($t_BHXH,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_luong_thuc_te == 0) echo 0; else echo number_format($t_luong_thuc_te,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_so_no_ky_truoc == 0) echo 0; else echo number_format($t_so_no_ky_truoc,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_tien_tam_giu == 0) echo '0'; else echo number_format($t_tien_tam_giu,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_tien_tam_ung == 0) echo '0'; else echo number_format($t_tien_tam_ung,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_tong_tien_thuc_linh == 0) echo '0'; else echo number_format($t_tong_tien_thuc_linh,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_tien_thuc_te_thanh_toan == 0) echo '0'; else echo number_format($t_tien_thuc_te_thanh_toan,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_tong_so_no_luong == 0) echo '0'; else echo number_format($t_tong_so_no_luong,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_du_tinh_thanh_toan_dot_1 == 0) echo '0'; else echo number_format($t_du_tinh_thanh_toan_dot_1,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_du_tinh_thanh_toan_dot_2 == 0) echo '0'; else echo number_format($t_du_tinh_thanh_toan_dot_1,0,'',',');  ?></td>
    <td bgcolor="#00b050"><?php if($t_hoan_ung_thu_lai == 0) echo '0'; else echo number_format($t_hoan_ung_thu_lai,0,'',',');  ?></td>


</tr>

<script type="text/javascript">
    function autoRefresh(){
        location.reload(true);
    }
    $(document).ready(function(){
        $('.edit_tr').click(function(){
            $("#main_content").css('width','2220px');
                var id = $(this).attr('id');
                $('.input').hide();
                $('.input_'+id).show();
                $('.text').show();
                $('.text_'+id).hide();
        }).change(function(){
                var id = $(this).attr('id');
                var url = $("#updateTable").attr('href');
                var em_salary_basic = $('.input_em_salary_basic_'+id).val();
                var em_wage_level_coverage = $('.input_em_wage_level_coverage_'+id).val();
                var total_x150 = $('.input_total_x150_'+id).val();
                var total_x200 = $('.input_total_x200_'+id).val();
                var total_x300 = $('.input_total_x300_'+id).val();
                var pc_lunch = $('.input_pc_lunch_'+id).val();
                var pc_seniority = $('.input_pc_seniority_'+id).val();
                var pc_position = $('.input_pc_position_'+id).val();
                var pc_project = $('.input_pc_project_'+id).val();
                var pc_computer = $('.input_pc_computer_'+id).val();
                var pc_petrol_phone = $('.input_pc_petrol_phone_'+id).val();
                var pc_other_support = $('.input_pc_other_support_'+id).val();
                var money_amount_owed = $('.input_money_amount_owed_'+id).val();
                var money_custody = $('.input_money_custody_'+id).val();
                var money_advance = $('.input_money_advance_'+id).val();
                var total_real_wages = $('.input_total_real_wages_'+id).val();
                var expected_salary_1 = $('.input_expected_salary_1_'+id).val();
                var expected_salary_2 = $('.input_expected_salary_2_'+id).val();
                var account_complete_again = $('.input_account_complete_again_'+id).val();
                var year = $('.year_info').val();
                var month = $('.month_info').val();
                $.post(url,
                    {
                        person_id:id,
                        em_salary_basic:em_salary_basic,
                        em_wage_level_coverage:em_wage_level_coverage,
                        total_x150:total_x150,
                        total_x200:total_x200,
                        total_x300:total_x300,
                        pc_lunch:pc_lunch,
                        pc_seniority:pc_seniority,
                        pc_position:pc_position,
                        pc_computer:pc_computer,
                        pc_project:pc_project,
                        pc_petrol_phone:pc_petrol_phone,
                        pc_other_support:pc_other_support,
                        money_amount_owed:money_amount_owed,
                        money_custody:money_custody,
                        money_advance:money_advance,
                        total_real_wages:total_real_wages,
                        expected_salary_1:expected_salary_1,
                        expected_salary_2:expected_salary_2,
                        account_complete_again:account_complete_again,
                        year:year,
                        month:month
                    },function(data,success){
                        if(success){
                            $("#tb-timekeeping-contaner").html(data);
                        }
                    }
                )
            });

    });
    function reportSalary()
    {
        var year = $('.year_info').val();
        var month = $('.month_info').val();
        var url_salary = $("#formSalary").attr('action');
       /* var person_id = $('.person_id').attr('name');
        var so_no_luong = $('.so_no_luong').attr('name');
        var tong_tien_thuc_linh = $('.tong_tien_thuc_linh').attr('name');*/

       /* $.post(url_salary,{so_no_luong:so_no_luong,tong_tien_thuc_linh:tong_tien_thuc_linh,person_id:person_id,month:month,year:year},function(data,success){*/
          //  alert(url_salary);
        /*});*/
    }

</script>