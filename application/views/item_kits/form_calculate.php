<?php //Hưng Audi from July to September 2015
$this->load->view("partial/header"); ?>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new">
            <tr>
                <td id="title_icon">
                    <a href="index.php/item_kits/manager_request_production" >
                        <div class="newface_back"></div></a>
                </td>
                <td id="title" style="width: 600px">&nbsp; Dự tính sản xuất
                </td>
                <td id="title_search_new" style="width: 200px;">
                </td>
            </tr>
        </table>
<?php if( $production_design->num_rows() == 0){
    echo 'Chưa có mẫu sản xuất nào được phê duyệt !';exit();
}?>
<ul id="error_message_box"></ul> 
<fieldset id="item_kit_info">
    <legend>Thông tin sản phẩm</legend>
    <table id="table_info_item_kit">
        <tr>
            <td class="left_table"><?php echo form_label('Mã sản phẩm:', name, array('class' => wide)); ?></td>
            <td class="right_table"><?=$item_kit_info->item_kit_number;?></td>
            <td class="left_table"><?php echo form_label(lang(item_kits_name) . ':', name, array('class' => wide)); ?></td>
            <td class="right_table"><?=$item_kit_info->name;?></td>
        </tr>
        <tr>
            <td class="left_table"><?php echo form_label(lang(item_kits_unit) . ':', unit, array('class' => wide)); ?></td>
            <td class="right_table"> <?= $this->Unit->get_info($item_kit_info->unit)->name ?></td>
            <td class="left_table"><?php echo form_label(lang(items_category) . ':', category, array('class' => wide)); ?></td>
            <td class="right_table"><?= $this->Category->get_info($item_kit_info->category)->name ?></td>
        </tr>
    </table>     
</fieldset>
<?php echo form_open_multipart('item_kits/save_item_kit_processes/' . $request_id, array(id => item_kit_form_approve_estimate)); ?>    
<fieldset id="item_kit_feature">
    <legend>Thông tin sản xuất</legend>
    <div class="field_row clearfix">
        <?php echo form_label('Mã yêu cầu:', request_id, array('class' => wide)); ?>
        <div class='form_field'><?= $info_request_production->request_id ?></div>
    </div>
    <h5>&nbsp;* Tổng hợp mẫu sản xuất : </h5>
    <table id=item_kit_size>
        <tr style='text-align: center'>
            <th style="width: 10%" rowspan="2">Tên mẫu</th> 
            <th colspan="2">Thông tin size</th>
            <th colspan="9">Công thức nguyên vật liệu</th>
        </tr>
        <tr>
            <th style="width: 5%">Size</th> 
            <th style="width: 5%">SL size</th>
            <th style="width: 10%">Mã NVL</th>
            <th style="width: 10%">Tên NVL</th>
            <th style="width: 6%">ĐVT</th>
            <th style="width: 7%">Định mức/SP</th>
            <th style="width: 7%">Tổng định mức</th>
            <th style="width: 10%">Giá nhập</th>
            <th style="width: 10%">Giá xuất</th>
            <th style="width: 10%">SL trong kho</th>
            <th style="width: 10%">SL còn lại</th>
           
        </tr>
        <?php $total_size = 0;
        $total_norms_per_item = 0;
        $total_norms = 0;
        $total_money_norms = 0;
        foreach ($request_feature as $f){
            $i = $this->Item_kit->count_formula_materials($f->feature_id);
            $info_feature = $this->Item_kit->get_info_item_kit_feature($f->feature_id);
            ?>
            <tr>
                <td style='text-align: left; width: 10%;' rowspan="<?= $i ?>"><?= $info_feature->name_feature ?></td> 
                <?php $info_sizes = $this->Item_kit->get_size_by_request_feature($f->request_id,$f->feature_id);?>
                <td rowspan="<?= $i ?>" style="width: 5%;">
                    <table id="size_detail">
                        <?php foreach ($info_sizes as $is) {?>
                        <tr>
                            <td>
                                <?= $is->size?>
                            </td>                            
                        </tr>
                        <?php
                        }?>
                    </table>
                </td>
                <td rowspan="<?= $i ?>" style="text-align: right; width: 5%">
                    <table id="quantity_detail">
                        <?php                         
                        foreach ($info_sizes as $is) {
                            $total_size += $is->quantity?>
                            <tr>
                                <td>
                                    <?= $is->quantity?>
                                </td>
                            </tr>
                        <?php
                        }?>
                    </table>
                </td>
                    <?php                
                $info_formula_material = $this->Item_kit->get_info_formula_materials($f->feature_id);
                foreach ($info_formula_material as $fm) {
                    $info_store = $this->Create_invetory->check_exist_store_materials();
                    $item_info = $this->Item->get_info_in_store_material($fm[item_id], $info_store[id]);
                    $info_formula_material_item = $this->Item_kit->get_info_formula_materials_item($fm[item_id]);
                    $unit_info = $this->Unit->get_info($info_formula_material_item->unit);
                    $total_size_of_feature_request = 0;
                    foreach ($info_sizes as $val){
                        $total_size_of_feature_request += $val->quantity;
                    }
                    $item_size = $this->Item_kit->get_info_item_size($f->feature_id, $fm[item_id]);
                    $total_quantity = $total_size_of_feature_request * $item_size->quantity;
                    $cost_price = $item_info->quantity_first != 0 ? $item_info->cost_price_rate : $item_info->cost_price;
                    
                    $total_norms_per_item += $item_size->quantity;
                    $total_norms += $total_quantity;
                    $total_money_norms += $total_quantity * $cost_price;
                    ?>
                    <td style="text-align: center; width: 10%;"><?= $item_info->item_number?></td>
                    <td style="width: 10%;"><?= $item_info->name?></td>
                    <td style="width: 6%;"><?= $unit_info->name?></td>
                    <td style="text-align: right; width: 7%;"><?= format_quantity($item_size->quantity)?></td>
                    <td style="text-align: right; width: 7%;"><?= format_quantity($total_quantity)?></td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($cost_price) ?>
                    </td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($item_info->quantity_first != 0 ? $item_info->unit_price_rate : $item_info->unit_price) ?>
                    </td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($item_info->quantity);?>
                    </td>
                    <td style="text-align: right; width: 10%;">
                        <?= format_quantity($item_info->quantity - $total_quantity >= 0 ? $item_info->quantity - $total_quantity : 0)?>
                    </td>
                </tr>
             <?php  
            }
        }
        ?>
        <tfoot style="font-weight: bold">
            <td colspan="2"> Tổng</td>
            <td style="text-align: right;"><?= $total_size?></td>
            <td colspan="4" style="background: #e8e8e8"></td>
            <td style="text-align: right;"><?= $total_norms ?></td>
            <td colspan="4" style="background: #e8e8e8"></td>
        </tfoot>
    </table>
    <?php
    foreach ($request_feature as $f){
        $size_quantity = 0;
        $sizes = $this->Item_kit->get_item_kit_request_feature_by_feature_id($request_id, $f->feature_id);
        foreach ($sizes->result() as $size){
            $size_quantity += $size->quantity;
        }
        $info_formula_material = $this->Item_kit->get_info_formula_materials($f->feature_id);
        if($info_formula_material){
            foreach ($info_formula_material as $fm) {
                $request_feature_quantity = $fm['quantity'] * $size_quantity;
                $quantitys[$fm['item_id']] += $request_feature_quantity;
            }
        }
    }?><br>
    <nav>
        <ul class="group">
            <li>
                <a href="<?php echo base_url(); ?>index.php/item_kits/trading_product" id="trading_item" style="width: 60px !important; ">Nhập hàng</a>
            </li>
        </ul>
    </nav>
    <h5>&nbsp;* Tổng hợp số lượng vật tư : </h5>

    <table id=item_kit_size3>
        
        <tr style='text-align: center'>
            <th style="width: 10%">STT</th>
            <th style="width: 20%">Tên vật tư</th> 
            <th style="width: 20%">Tổng định mức vật tư</th>
            <th style="width: 20%">Số lượng vật tư trong kho</th>
            <th style="width: 20%">Số lượng vật tư còn lại</th>
            <th style="width: 10%">Nhập kho</th>
        </tr>
        <?php
        $stt = 0;
        foreach ($quantitys as $item_id => $quantity){
            $item_fm = $this->Item_kit->get_item_fm($feature_ids, $item_id);
            $info_store = $this->Create_invetory->check_exist_store_materials();
            $item_info = $this->Item->get_info_in_store_material($item_id, $info_store[id]);
            $stt++;
            ?>
            <tr>
                <td style="text-align: center"><?= $stt ?></td>
                <td><?php
                echo form_input(array(
                    name => "item_id[$item_id]",
                    type => hidden,
                    value => $item_id
                ));
                echo $this->Item->get_info($item_id)->name ?></td>
                <td><?php $quantity2 = 0;
                    foreach ($item_fm->result() as $if){

                        $info_sizes = $this->Item_kit->get_size_by_request_feature($request_id,$if->feature_id);
                        $total_size_of_feature_request = 0;
                        foreach ($info_sizes as $val){
                            $total_size_of_feature_request += $val->quantity;
                        }
                        $item_size = $this->Item_kit->get_info_item_size($if->feature_id, $item_id);
                        $total_quantity = $total_size_of_feature_request * $item_size->quantity;
                        $quantity2 += $total_quantity;
                        echo form_input(array(
                            'id' => "qty_old$item_id",
                            'class' => "qty_old$if->feature_id$item_id",
                            type => hidden,
                            value => $total_quantity
                        ));
                    }
                    $norms_item_info = $this->Item_kit->get_info_item_kit_norms_item($request_id, $item_id);
                    $qty_total = $norms_item_info->quantity_total ? $norms_item_info->quantity_total : $quantity2;          
                    echo form_input(array(
                        name => "quantity_total[$item_id]",
                        'class' => "qty_total qty_total$item_id",
                        id => "qty_total_$item_id",
                        value => number_format($qty_total)
                    ))?>
                </td>
                <td><?= 
                    form_input(array(
                        'class' => "qty_store qty_store$item_id",
                        value => number_format($item_info->quantity),
                        readonly => ''
                    )) ?>
                </td>
                <td><?= 
                    form_input(array(
                        'class' => "qty_remain qty_remain$item_id",
                        readonly => '',
                        value => number_format($item_info->quantity - $qty_total)
                    )) ?>
                </td>
                <td style="text-align: center">
                    <input type='checkbox' id='item_<?= $item_id ?>' 
                        value='<?= $item_id ?>'
                        class="import<?= $item_id ?>" />
                </td>
            </tr>
        <?php
        }?> 
    </table><br>
    <h5>&nbsp;* Tổng hợp công đoạn SX : </h5>
    <?php
    $check = $this->Item_kit->check_item_production_finish($request_id);
    if ($check->num_rows() == 1) {//các công đoạn hoàn thành hết ?>
        <table id="brand_table">  
            <tr style="border: 1px solid green">
                <th style="width: 10%">STT</th>
                <th style="width: 30%">Công đoạn</th>
                <th style="width: 10%">Thời gian</th>
                <th style="width: 20%">Đơn vị thời gian</th>
                <th style="width: 30%">Chi phí công đoạn</th>
            </tr>
            <?php
            $unit_time = array(
                ''=>'-- Chọn đơn vị thời gian --',
                0=>Giờ, 
                1=>Ngày
            );
            $processes_money_total = 0;
            $pro_id = 1;
            $stt = 1;
            $time_processes_total = 0;
            foreach ($item_kit_processes->result() as $ip){
                $pro_id = $ip->pro_id;
                $processes_money_total += $ip->processes_money;
                $processes_cost = $this->Item_kit->get_info_processes_cost($request_id, $ip->id_processes);
                $time_processes_total += $ip->unit_time == 0 ? $ip->time_processes/8 : $ip->time_processes;
                ?>
                <tr class=brand_tr id=brand_tr_<?= $pro_id?>>
                    <td><?= $stt ?></td>
                    <td style="text-align: left; padding-left: 10px;"><?= $this->Item_kit->get_info_processes($ip->id_processes)->name_processes; ?></td>
                    <td style="text-align: right; padding-right: 10px;"><?= $ip->time_processes ?></td>
                    <td><?= $ip->unit_time == 0 ? Giờ : Ngày ?></td>
                    <td style="text-align: right; padding-right: 20px;"><?= number_format($ip->processes_money) ?></td>
                </tr>
                <tr id=car_tr_<?= $pro_id?>>
                    <td colspan="6" style="padding: 0px;">
                        <table class=car_table id=car_table_<?= $pro_id?>>  
                            <tr class=car_th>
                                <th style="width: 30%"><?= $processes_cost->row()->outsource == 0 ? 'Tên chi phí/ Nhân công/ Máy móc' : 'Tên nhà cung cấp' ?></th>
                                <th style="width: 20%">Giá chi phí</th>
                                <th style="width: 10%">Tài khoản nợ</th>
                                <th style="width: 10%">Tài khoản có</th>
                                <th style="width: 20%">Ghi chú</th>
                            </tr>
                            <?php $i=1;
                            $processes_cost = $this->Item_kit->get_info_processes_cost($request_id, $ip->id_processes);
                            foreach ($processes_cost->result() as $pc){
                                $pro_id_i = $pro_id.$i;
                                $info_employee = $this->Employee->get_info($pc->labor);
                                $info_asset = $this->Asset->get_info($pc->machine);
                                $info_supplier = $this->Supplier->get_info($pc->outsource);
                                ?>
                                <tr class=car_tr >
                                    <td id=align_left >
                                        <?php
                                        if($pc->cost_name != '' )
                                            echo $pc->cost_name;
                                        if($pc->labor != 0 )
                                            echo $info_employee->first_name.' '.$info_employee->last_name;
                                        if($pc->machine != 0 )
                                            echo $info_asset->name;
                                        if($pc->outsource != 0 )
                                            echo $info_supplier->company_name;
                                        ?>
                                    </td>
                                    <td id=align_right >
                                        <?= number_format($pc->cost_money) ?>
                                    </td>
                                    <td id=align_left >
                                        <?= $pc->tk_no ?>
                                    </td>
                                    <td id=align_left >
                                        <?= $pc->tk_co ?>
                                    </td>
                                    <td id=align_right ><?= $pc->comment ?>
                                    </td>
                                </tr>
                            <?php $i++;
                            }?>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="6" id="space_tr_<?= $pro_id ?>" class=space_tr></td></tr>
                <?php
                $pro_id++;
                $stt++;
            } ?>
        </table>
    <?php
    }else{?>
        <table id="brand_table">
            <tr>
                <td colspan="6" style="text-align: left" >
                    <a href="#" class="append" id="append_<?= $item_kit_id?>" >+ Thêm công đoạn </a>
                </td>
            </tr>    
            <tr style="border: 1px solid green">
                <th style="width: 5%">STT</th>
                <th style="width: 30%">Công đoạn</th>
                <th style="width: 10%">Thời gian</th>
                <th style="width: 20%">Đơn vị thời gian</th>
                <th style="width: 20%">Chi phí công đoạn</th>
                <th style="width: 10%">Xóa</th>
            </tr>
            <?php
            $unit_time = array(
                ''=>'-- Chọn đơn vị thời gian --',
                0=>Giờ, 
                1=>Ngày
            );
            $processes_money_total = 0;
            if($item_kit_processes->num_rows() == 0){
                $pro_id = 1;?>
                <tr class=brand_tr id=brand_tr_<?= $pro_id?> >
                    <td><?=
                        form_input(array(
                            name => "pro_id[$pro_id]",
                            id => "pro_id_$pro_id",
                            'class' => pro_id,
                            type => hidden,
                        ));
                        ?><?= $pro_id?></td>
                    <td><?=
                        form_dropdown("id_processes[$pro_id]", $processes, '', "class=id_processes id=id_processes_$pro_id")
                        ?></td>
                    <td><?=
                        form_input(array(
                            name => "time_processes[$pro_id]",
                            id => "time_processes_$pro_id",
                            'class' => time_processes,
                        ));
                        ?></td>
                    <td><?=
                        form_dropdown("unit_time[$pro_id]", $unit_time, '', "class=unit_time id=unit_time_$pro_id")
                        ?></td>
                    <td><?=
                        form_input(array(
                            name => "processes_money[$pro_id]",
                            id => "processes_money_$pro_id",
                            'class' => processes_money,
                            readonly=>""
                        ));
                        ?></td>
                    <td><a href=# class=delete title='Xóa' onclick='return deleteBrandRow(this, <?= $pro_id?>);' >X</a></td>
                </tr>
                <tr id=car_tr_<?= $pro_id?>>
                    <td colspan="6" style="padding: 0px;">
                        <table class=car_table id=car_table_<?= $pro_id?>>
                            <tr id=car_table_tr_first>
                                <td colspan="4" style="text-align: left" >
                                    <a href=# class=append_car_labor id=append_car_labor_<?= $pro_id?> >+ Thêm nhân công</a>
                                    <a href=# class=append_car_machine id=append_car_machine_<?= $pro_id?> >+ Thêm máy móc</a>
                                    <a href=# class=append_car id=append_car_<?= $pro_id?> >+ Thêm chi phí khác</a>
                                <td colspan="2">
                                    <label>
                                        <input type="checkbox" name="chk[<?= $pro_id?>]" id="chk_<?= $pro_id?>" value="1" ><em>Thuê ngoài</em>
                                    </label>
                                </td>
                            </tr>    
                            <tr class=car_th>
                                <th style="width: 30%" class="title_cost<?= $pro_id?>">

                                    Tên chi phí/ Nhân công/ Máy móc
                                </th>
                                <th style="width: 30%" class="title_cost2<?= $pro_id?>">
                                    Tên nhà cung cấp
                                </th>

                                <th style="width: 30%">Giá chi phí</th>
                                <th style="width: 15%">Tài khoản nợ</th>
                                <th style="width: 15%">Tài khoản có</th>
                                <th style="width: 15%">Ghi chú</th>
                                <th style="width: 5%">Xóa</th>
                            </tr>
                            <?php $i=1;
                            $pro_id_i = $pro_id.$i;?>
                            <!-- tr cost name-->
                            <tr class="car_tr car_tr_cost_name<?= $pro_id ?>" >
                                <td><?= form_input(array(
                                        name => "cost_name[$pro_id_i]",
                                        id => "cost_name_$pro_id_i",
                                        'class' => cost_name,
                                    ));?>
                                </td>
                                <td><?= form_input(array(
                                        name => "cost_money[$pro_id_i]",
                                        id => "cost_money_$pro_id_i",
                                        'class' => "cost_money cost_money$pro_id",
                                        onchange => "calculate_cost($pro_id)"
                                    ));?>
                                </td> 
                                <td><?php $data[tk_no] = '';?>
                                    <select name="tk_no[<?= $pro_id_i ?>]" class="tk_no tk_no<?= $pro_id_i ?>">
                                        <?php $this->load->view('item_kits/tk_no_list', $data)?>
                                    </select>    
                                </td>
                                <td><?php $data[tk_co] = '';?>
                                    <select name="tk_co[<?= $pro_id_i ?>]" class="tk_co tk_co<?= $pro_id_i ?>">
                                        <?php $this->load->view('item_kits/tk_co_list', $data)?>
                                    </select>    
                                </td>
                                <td><?=
                                    form_textarea(array(
                                        name => "comment[$pro_id_i]",
                                        id => "comment_$pro_id_i",
                                        'class' => "comment comment$pro_id",
                                        'rows' => 3,
                                        'cols' => 20,
                                    ));?>
                                </td>
                                <td><a href=# class=delete title='Xóa' onclick='return deleteCarRow(this, <?= $pro_id ?>);' >X</a></td>
                                </td>
                            </tr>

                            <!--car_tr_chk --> 
                            <tr class="car_tr car_tr_chk<?= $pro_id ?>" >
                            </tr>  
                        </table>
                    </td>
                </tr>
                <tr><td colspan="6" id="space_tr_<?= $pro_id ?>" class=space_tr></td></tr>
                <?php
                echo form_input(array(
                    'class' => count_car,
                    type => hidden,
                    value => $pro_id
                ));
                $pro_id++;
            }else{
                $pro_id = 1;
                $stt = 1;
                foreach ($item_kit_processes->result() as $ip){
                    $pro_id = $ip->pro_id;
                    $processes_money_total += $ip->processes_money;
                    $processes_cost = $this->Item_kit->get_info_processes_cost($request_id, $ip->id_processes);
                            ?>
                    <tr class=brand_tr id=brand_tr_<?= $pro_id?>>
                        <td><?=
                            form_input(array(
                                name => "pro_id[$pro_id]",
                                id => "pro_id_$pro_id",
                                'class' => pro_id,
                                type => hidden,
                            ));
                            ?><?= $stt?></td>
                        <td><?=
                            form_dropdown("id_processes[$pro_id]", $processes, $ip->id_processes, "class=id_processes id=id_processes_$pro_id")
                            ?></td>
                        <td><?=
                            form_input(array(
                                name => "time_processes[$pro_id]",
                                id => "time_processes_$pro_id",
                                'class' => time_processes,
                                value => $ip->time_processes,
                            ));
                            ?></td>
                        <td><?=
                            form_dropdown("unit_time[$pro_id]", $unit_time, $ip->unit_time, "class=unit_time id=unit_time_$pro_id")
                            ?></td>
                        <td><?=
                            form_input(array(
                                name => "processes_money[$pro_id]",
                                id => "processes_money_$pro_id",
                                'class' => processes_money,
                                value => number_format($ip->processes_money),
                                readonly=>""
                            ));
                            ?></td>
                        <td><a href=# class=delete title='Xóa' onclick='return deleteBrandRow(this, <?= $pro_id?>);' >X</a></td>
                    </tr>
                    <tr id=car_tr_<?= $pro_id?>>
                        <td colspan="6" style="padding: 0px;">
                            <table class=car_table id=car_table_<?= $pro_id?> >
                                <tr id=car_table_tr_first>
                                    <td colspan="4" style="text-align: left" >
                                        <a href=# class=append_car_labor id=append_car_labor_<?= $pro_id?> >+ Thêm nhân công</a>
                                        <a href=# class=append_car_machine id=append_car_machine_<?= $pro_id?> >+ Thêm máy móc</a>
                                        <a href=# class=append_car id=append_car_<?= $pro_id?> >+ Thêm chi phí khác</a>
                                    </td>
                                    <td colspan="2">
                                        <label style=" ">
                                            <input type="checkbox" name="chk[<?= $pro_id?>]" id="chk_<?= $pro_id?>" value="1" <?= ($processes_cost->row()->outsource == 0) ? '' : 'checked=checked' ?>><em>Thuê ngoài</em>
                                        </label>
                                    </td>
                                </tr>    
                                <tr class=car_th>
                                    <th style="width: 30%" class="title_cost<?= $pro_id?>">

                                        Tên chi phí/ Nhân công/ Máy móc
                                    </th>
                                    <th style="width: 30%" class="title_cost2<?= $pro_id?>">
                                        Tên nhà cung cấp
                                    </th>

                                    <th style="width: 20%">Giá chi phí</th>
                                    <th style="width: 15%">Tài khoản nợ</th>
                                    <th style="width: 15%">Tài khoản có</th>
                                    <th style="width: 15%">Ghi chú</th>
                                    <th style="width: 5%">Xóa</th>
                                </tr>
                                <?php $i=1;
                                if ( $processes_cost->row()->outsource == 0){
                                    foreach ($processes_cost->result() as $pc){
                                        $pro_id_i = $pro_id.$i;?>
                                        <!-- row cost name -->
                                        <tr class="car_tr car_tr_cost_name<?= $pro_id ?>">
                                            <td>
                                                <?php
                                                if($pc->cost_name != '' ){
                                                    echo form_input(array(
                                                        name => "cost_name[$pro_id_i]",
                                                        id => "cost_name_$pro_id_i",
                                                        'class' => cost_name,
                                                        value => $pc->cost_name ,
                                                    ));
                                                }
                                                if($pc->labor != 0){?>
                                                    <table id="row_selected_labor">
                                                        <?php
                                                        $info_employee = $this->Employee->get_info($pc->labor);?>
                                                        <tr >
                                                            <td width="200px" >
                                                                <?=
                                                                form_input(array(
                                                                    name => "labor[$pro_id_i]",
                                                                    id => "labor_$pro_id_i",
                                                                    'class' => labor,
                                                                    value => $pc->labor,
                                                                    type => hidden
                                                                ));?>
                                                                <?= $info_employee->first_name.' '.$info_employee->last_name ?>
                                                            </td>
                                                            <td><a href=# class=delete title='Xóa' onclick="return deleteRow2(this, <?= $pro_id_i ?>)">X</a>
                                                            </td>
                                                        </tr>
                                                    </table>     
                                                    <div class="part_labor<?= $pro_id_i ?>">
                                                        <?php
                                                        echo form_input(array(
                                                            id => "labor_input_$pro_id_i",
                                                            'class' => labor_input,
                                                            placeholder => "Nhập tên nhân công"
                                                        )); ?>
                                                        <table id="row_selected_labor<?= $pro_id_i ?>" >
                                                        </table>
                                                    </div>
                                                    <?php
                                                }
                                                if($pc->machine != 0){?>
                                                    <table id="row_selected_machine" >
                                                        <?php
                                                        $info_asset = $this->Asset->get_info($pc->machine);?>
                                                        <tr>
                                                            <td width="200px">
                                                                <?=
                                                                form_input(array(
                                                                    name => "machine[$pro_id_i]",
                                                                    id => "machine_$pro_id_i",
                                                                    'class' => machine,
                                                                    value => $pc->machine,
                                                                    type => hidden
                                                                ));?>
                                                                <?= $info_asset->name ?>
                                                            </td>
                                                            <td><a href=# class=delete title='Xóa' onclick="return deleteRow3(this, <?= $pro_id_i ?>)">X</a>
                                                            </td>
                                                        </tr>
                                                    </table>     
                                                    <div class="part_machine<?= $pro_id_i ?>">
                                                        <?php
                                                        echo form_input(array(
                                                            id => "machine_input_$pro_id_i",
                                                            'class' => machine_input,
                                                            placeholder => "Nhập tên máy móc"
                                                        )); ?>
                                                        <table id="row_selected_machine<?= $pro_id_i ?>" >
                                                        </table>
                                                    </div>
                                                    <?php
                                                }?>
                                            </td>
                                            <td><?php
                                                if($pc->cost_name != ''){
                                                    echo form_input(array(
                                                        name => "cost_money[$pro_id_i]",
                                                        id => "cost_money_$pro_id_i",
                                                        'class' => "cost_money cost_money$pro_id cost_money_cost_name$pro_id_i",
                                                        value => number_format($pc->cost_money),
                                                        onchange => "calculate_cost($pro_id)"
                                                    ));
                                                }
                                                if($pc->labor != 0){
                                                    echo form_input(array(
                                                        name => "cost_money_labor[$pro_id_i]",
                                                        id => "cost_money_$pro_id_i",
                                                        'class' => "cost_money cost_money$pro_id cost_money_labor cost_money_labor$pro_id_i",
                                                        value => number_format($pc->cost_money),
                                                        onchange => "calculate_cost($pro_id)",
                                                        readonly => ''
                                                    ));
                                                }
                                                if($pc->machine != 0){
                                                    echo form_input(array(
                                                        name => "cost_money_machine[$pro_id_i]",
                                                        id => "cost_money_$pro_id_i",
                                                        'class' => "cost_money cost_money$pro_id cost_money_machine cost_money_machine$pro_id_i",
                                                        value => number_format($pc->cost_money),
                                                        onchange => "calculate_cost($pro_id)",
                                                        readonly => ''
                                                    ));
                                                }?>
                                            </td>
                                            <td><?php $data[tk_no] = $pc->tk_no;
                                                if($pc->cost_name != ''){?>
                                                    <select name="tk_no[<?= $pro_id_i ?>]" class="tk_no tk_no<?= $pro_id_i ?>">
                                                        <?php $this->load->view('item_kits/tk_no_list', $data)?>
                                                    </select>   
                                                <?php
                                                }
                                                if($pc->labor != 0){?>
                                                    <select name="tk_no_labor[<?= $pro_id_i ?>]" class="tk_no tk_no<?= $pro_id_i ?>">
                                                        <?php $this->load->view('item_kits/tk_no_list', $data)?>
                                                    </select>   
                                                <?php
                                                }
                                                if($pc->machine != 0){?>
                                                    <select name="tk_no_machine[<?= $pro_id_i ?>]" class="tk_no tk_no<?= $pro_id_i ?>">
                                                        <?php $this->load->view('item_kits/tk_no_list', $data)?>
                                                    </select>   
                                                <?php
                                                }?>
                                            </td>
                                            <td><?php $data[tk_co] = $pc->tk_co;
                                                if($pc->cost_name != ''){?>
                                                    <select name="tk_co[<?= $pro_id_i ?>]" class="tk_co tk_co<?= $pro_id_i ?>">
                                                        <?php $this->load->view('item_kits/tk_co_list', $data)?>
                                                    </select>   
                                                <?php
                                                }
                                                if($pc->labor != 0){?>
                                                    <select name="tk_co_labor[<?= $pro_id_i ?>]" class="tk_co tk_co<?= $pro_id_i ?>">
                                                        <?php $this->load->view('item_kits/tk_co_list', $data)?>
                                                    </select>   
                                                <?php
                                                }
                                                if($pc->machine != 0){?>
                                                    <select name="tk_co_machine[<?= $pro_id_i ?>]" class="tk_co tk_co<?= $pro_id_i ?>">
                                                        <?php $this->load->view('item_kits/tk_co_list', $data)?>
                                                    </select>   
                                                <?php
                                                }?>  
                                            </td>
                                            <td><?php
                                                if($pc->cost_name != '')
                                                    $comment_class = "comment_cost_name$pro_id_i";
                                                if($pc->labor != 0)
                                                    $comment_class = "comment_labor$pro_id_i";
                                                if($pc->machine != 0)
                                                    $comment_class = "comment_machine$pro_id_i";

                                                echo form_textarea(array(
                                                    name => "comment[$pro_id_i]",
                                                    id => "comment_$pro_id_i",
                                                    'class' => "comment comment$pro_id $comment_class",
                                                    value => $pc->comment,
                                                    rows => 3,
                                                    cols => 20,
                                                ));?>
                                            </td>
                                            <td><a href=# class=delete title='Xóa' onclick='return deleteCarRow(this, <?= $pro_id ?>);' >X</a></td>
                                        </tr>
                                    <?php $i++;
                                    }//end foreach
                                }else{?>
                                    <!-- row outsource -->
                                    <tr class="car_tr car_tr_outsource<?= $pro_id ?>" >
                                        <td>
                                            <table id="row_selected_outsource" >
                                                <?php
                                                $info_supplier = $this->Supplier->get_info($processes_cost->row()->outsource);?>
                                                <tr>
                                                    <td width="200px">
                                                        <?=
                                                        form_input(array(
                                                            name => "outsource[$pro_id]",
                                                            id => "outsource_$pro_id",
                                                            'class' => outsource,
                                                            value => $processes_cost->row()->outsource,
                                                            type => hidden
                                                        ));?>
                                                        <?= $info_supplier->company_name?>
                                                    </td>
                                                    <td><a href=# class=delete title='Xóa' onclick="return deleteRow(this, <?= $pro_id ?>)">X</a>
                                                    </td>
                                                </tr>
                                            </table>     

                                            <div class="part_outsource<?= $pro_id ?>">
                                                <?php
                                                echo form_input(array(
                                                    id => "outsource_input_$pro_id",
                                                    'class' => outsource_input,
                                                    placeholder => "Nhập tên nhà cung cấp"
                                                )); ?>
                                                <table id="row_selected_outsource<?= $pro_id ?>" >
                                                </table>
                                            </div>
                                        </td>
                                        <td><?=
                                            form_input(array(
                                                name => "cost_money_outsource[$pro_id]",
                                                id => "cost_money_$pro_id",
                                                'class' => "cost_money cost_money$pro_id",
                                                value => number_format($processes_cost->row()->cost_money),
                                                onchange => "calculate_cost($pro_id)"
                                            ));?>
                                        </td>
                                        <td>
                                            <?php $data[tk_no] = $processes_cost->row()->tk_no;?>
                                            <select name="tk_no_outsource[<?= $pro_id ?>]" class="tk_no tk_no<?= pro_id ?>">
                                                <?php $this->load->view('item_kits/tk_no_list', $data)?>
                                            </select>    
                                        </td>
                                        <td>
                                            <?php $data[tk_co] = $processes_cost->row()->tk_co;?>
                                            <select name="tk_co_outsource[<?= $pro_id ?>]" class="tk_co tk_co<?= pro_id ?>">
                                                <?php $this->load->view('item_kits/tk_co_list', $data)?>
                                            </select>    
                                        </td>
                                        <td><?=
                                            form_textarea(array(
                                                name => "comment[$pro_id]",
                                                id => "comment_$pro_id",
                                                'class' => "comment comment$pro_id",
                                                value => $processes_cost->row()->comment,
                                                rows => 3,
                                                cols => 20,
                                            ));?>
                                        </td>
                                        <td><a href=# class=delete title='Xóa' onclick='return deleteCarRow(this, <?= $pro_id ?>);' >X</a></td>
                                    </tr> 
                                <?php $i++;
                                }//end else $processes_cost->row()->outsource != 0
                                echo form_input(array(
                                    id => "count_car_$pro_id",
                                    'class' => count_car,
                                    type => hidden,
                                    value => $i
                                ));?> 

                                <!--car_tr_chk --> 
                                <tr class="car_tr car_tr_chk<?= $pro_id ?>" >
                                </tr>   

                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="6" id="space_tr_<?= $pro_id ?>" class=space_tr></td></tr>
                    <?php
                    $pro_id++;
                    $stt++;
                }//end foreach processes
            }//end else processes->num_rows
           echo form_input(array(
                name => count_pro_id,
                'class' => count_pro_id,
                type => hidden,
                value => $pro_id
            ));
            ?>
        </table>
    <?php    
    }?>
    <h5>&nbsp;* Tổng hợp chi phí SX: </h5>
    <table id=item_kit_money>
        <tr style="text-align: center">
            <th style='width: 33%;'>Tổng chi phí NVL</th>
            <th style='width: 33%;'>Tổng chi phí công đoạn SX</th>
            <th style='width: 33%;'>Tổng tiền</th>
        </tr>
            <tr style='text-align: right'>
                <td><?= form_input(array(
                    name => total_money_norms,
                    'class' => total_money_norms,
                    value => number_format($total_money_norms),
                    readonly => ''
                ))?>
                </td>
                <td><?= form_input(array(
                    name => processes_money_total,
                    'class' => processes_money_total,
                    readonly => '',
                    value => number_format($processes_money_total)
                ));?>
                </td>
                <td><?= form_input(array(
                    name => money_total,
                    'class' => money_total,
                    readonly => '',
                    value => number_format($total_money_norms + $processes_money_total)
                ));?>
                </td>
            </tr>
    </table>
    <br>
    <?php 
    if ($check->num_rows() != 1) {//các công đoạn hoàn thành hết
        echo form_submit(array(
            value => lang(common_submit),
            'class' => 'submit_button float_right',
            style => 'margin-bottom:20px',
            name => save_estimate
        ));
    }?>
</fieldset>
<?php echo form_close(); ?>
    </div></div>
<?php $this->load->view("partial/footer"); ?>
<script type="text/javascript">
    $('#trading_item').click(function(){
    	var selected = get_selected_values2();
    	if (selected.length == 0)
    	{
    		alert(<?php echo json_encode(lang('items_must_select_item_for_trading')); ?>);
    		return false;
    	}
        $(this).attr('href','<?php echo site_url("item_kits/trading_product");?>/'+selected.join('~'));
    });
    
    $('#item_kit_size3').find('.qty_total').each(function (index, element) {
        var item_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
        
        $('.qty_total'+item_id).blur(function (){
            var qty_store = $('.qty_store'+item_id).val().replace(/,/g, "");
            var qty_total = $('.qty_total'+item_id).val().replace(/,/g, "");
            var qty_remain = qty_store - qty_total;
            
            $('.qty_remain'+item_id).val((qty_remain+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            var qty_remain = $('.qty_remain'+item_id).val().replace(/,/g, "");
            if(qty_remain < 0){
                $('.import'+item_id).removeClass('class_hide');
            }else{
                $('.import'+item_id).addClass('class_hide');
            }
        });
        var qty_remain = $('.qty_remain'+item_id).val().replace(/,/g, "");
        if(qty_remain < 0){
            $('.import'+item_id).removeClass('class_hide');
        }else{
            $('.import'+item_id).addClass('class_hide');
        }
        $('.qty_total'+item_id).maskMoney();
    });
    
    //append cost of processes old
    if($('.count_car').val() == 1){
        $("#brand_table").find('.brand_tr').each(function(index, element){
            var pro_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var i = 2; 
            
            status_checkbox(pro_id);
            append_cost_and_click_checkbox(pro_id, i);
        });
    }else{
        $("#brand_table").find('.brand_tr').each(function(index, element){
            var pro_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
            var i = $('#count_car_'+pro_id).val();             
            
            $("#car_table_"+pro_id).find('.comment').each(function(index, element){
                var pro_id_i = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
                //labor
                $('.part_labor'+pro_id_i).hide();
                auto_complete_labor(pro_id, i);
                //machine
                $('.part_machine'+pro_id_i).hide();
                auto_complete_machine(pro_id, i);
            });
            status_checkbox(pro_id);
            append_cost_and_click_checkbox(pro_id, i);
        });
    }
//$(document).ready(function(){
    //append processes & cost new
    var pro_id = $('.count_pro_id').val();
    var stt = $('#brand_table .brand_tr').length + 1;
    var i = 1;
    $('.append').click(function(){
        $('#brand_table').append(
            '<tr class=brand_tr id=brand_tr_'+pro_id+'>'
                +'<td><input type=hidden name=pro_id['+pro_id+'] id="pro_id_'+pro_id+'" class=pro_id value='+pro_id+' >'+stt+'</td>'
                +'<td>'
                    +'<select name=id_processes['+pro_id+'] class=id_processes id=id_processes_'+pro_id+' >'
                        +'<option value= >-- Chọn công đoạn --</option>'
                        +'<?php foreach($this->Item_kit->get_all_processes_new()->result_array() as $r){ ?>'
                            +'<option value=<?= $r['id_processes']?> > <?= $r['name_processes']?></option>'
                        +'<?php }?>'
                    +'</select>'
                +'</td>'
                +'<td><input name=time_processes['+pro_id+'] id=time_processes_'+pro_id+' class=time_processes ></td>'
                +'<td>'
                    +'<select name=unit_time['+pro_id+'] id=unit_time_'+pro_id+' class=unit_time >'
                        +'<option value= >-- Chọn đơn vị thời gian --</option>'
                        +'<option value=0 >Giờ</option>'
                        +'<option value=1 >Ngày</option>'
                    +'</select>'
                +'</td>'
                +'<td><input name=processes_money['+pro_id+'] id=processes_money_'+pro_id+' \n\
                        class=processes_money readonly ></td>'
                +'<td><a href=# class=delete title="Xóa" onclick="return deleteBrandRow(this, '+pro_id+');" >X</a></td>'
            +'</tr>'
            +'<tr id=car_tr_'+pro_id+'>'        
                +'<td colspan="6" style="padding: 0px;">'
                    +'<table class=car_table id=car_table_'+pro_id+'>'
                        +'<tr id=car_table_tr_first>'
                            +'<td colspan=4 style="text-align: left" >'
                                +'<a href=# class=append_car_labor id=append_car_labor_'+pro_id+' >+ Thêm nhân công</a>'
                                +'<a href=# class=append_car_machine id=append_car_machine_'+pro_id+' > + Thêm máy móc</a>'
                                +'<a href=# class=append_car id=append_car_'+pro_id+' > + Thêm chi phí khác</a>'
                            +'</td>'
                            +'<td colspan=2 >'
                                +'<label style="">'
                                    +'<input type=checkbox name=chk id=chk_'+pro_id+' value=1 ><em> Thuê ngoài</em>'
                                +'</label>'
                            +'</td>'
                        +'</tr>'  
                        +'<tr class=car_th>'
                            +'<th style="width: 30%" class=title_cost'+pro_id+'>Tên chi phí/ Nhân công/ Máy móc</th>'
                            +'<th style="width: 30%; display:none" class=title_cost2'+pro_id+'>Tên nhà cung cấp</th>'
                            +'<th style="width: 20%">Giá chi phí</th>'
                            +'<th style="width: 15%">Tài khoản nợ</th>'
                            +'<th style="width: 15%">Tài khoản có</th>'
                            +'<th style="width: 15%">Ghi chú</th>'
                            +'<th style="width: 5%">Xóa</th>'
                        +'</tr>'
                        +'<tr class="car_tr car_tr_cost_name'+pro_id+'">'
                            +'<td>'
                                +'<input name=cost_name['+pro_id+i+'] id=cost_name_'+pro_id+i+' class=cost_name >'
                            +'</td>'
                            +'<td>'
                                +'<input name=cost_money['+pro_id+i+'] id=cost_money_'+pro_id+i+' \n\
                                    class="cost_money cost_money'+pro_id+'" onchange="calculate_cost('+pro_id+')" >'
                            +'</td>'
                            +'<td>'
                                +'<select name=tk_no['+pro_id+i+'] class="tk_no tk_no'+pro_id+i+'" >'
                                +'</select>'
                            +'</td>'
                            +'<td>'
                                +'<select name=tk_co['+pro_id+i+'] class="tk_co tk_co'+pro_id+i+'" >'
                                +'</select>'
                            +'</td>'
                            +'<td><textarea name=comment['+pro_id+i+'] id=comment_'+pro_id+i+' \n\
                        class="comment comment'+pro_id+'" type=textarea cols=20 rows=3 ></textarea></td>'
                            +'<td><a href=# class=delete title="Xóa" onclick="return deleteCarRow(this, '+pro_id+')" >X</a></td>'
                        +'</tr>'
                        +'<tr class="car_tr car_tr_chk'+pro_id+'" >'
                        +'</tr>' 
                    +'</table>'
                +'</td>'
            +'</tr>'
            +'<tr><td colspan="6" id=space_tr_'+pro_id+' class=space_tr></td></tr>'
        );
        $('.tk_no'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_no_list' ?>");
        $('.tk_co'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");        
        //only enter number
        $(".time_processes").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
              (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        $(".cost_money").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
              (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });    
        append_cost_and_click_checkbox(pro_id, 2);
        pro_id++;
        stt++;
        return false;
    });
    
//}); 
    setTimeout(function () {
        $(":input:visible:first", "#item_kit_form_approve_estimate").focus();
    }, 100);
    var submitting = false;
    $('#item_kit_form_approve_estimate').validate({  
//        submitHandler: function (form) {
//            if (submitting)
//                return;
//            submitting = true;
//            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
//            $(form).ajaxSubmit({
//                success: function (response) {
//                    submitting = false;
//                    tb_remove();
//                    post_item_kit_form_submit(response);
//                },
//                dataType: 'json'
//            });
//        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",        
    });
function status_checkbox(pro_id){
    if ($('#chk_'+pro_id).is(':checked')){
        //title
        $('#car_table_'+pro_id+' .car_th .title_cost'+pro_id).hide();
        $('#car_table_'+pro_id+' .car_th .title_cost2'+pro_id).show();
        //link append
        $('#append_car_'+pro_id).hide();
        $('#append_car_labor_'+pro_id).hide();
        $('#append_car_machine_'+pro_id).hide();
        //hide div
        $('.part_outsource'+pro_id).hide();
        //hide show tr
        $('.car_tr_cost_name'+pro_id).hide();
        $('.car_tr_outsource'+pro_id).show();
        auto_complete_outsource(pro_id);
    } else{
        //title
        $('#car_table_'+pro_id+' .car_th .title_cost'+pro_id).show();
        $('#car_table_'+pro_id+' .car_th .title_cost2'+pro_id).hide();
        //link append
        $('#append_car_'+pro_id).show();
        $('#append_car_labor_'+pro_id).show();
        $('#append_car_machine_'+pro_id).show();        
        //hide show tr
        $('.car_tr_cost_name'+pro_id).show();
        $('.car_tr_outsource'+pro_id).hide();
    }     
}
function append_cost_and_click_checkbox(pro_id, i){
    append_cost(pro_id, i);
    append_labor(pro_id, i);
    append_machine(pro_id, i);
    $('#chk_'+pro_id).click(function(){
        if ($('#chk_'+pro_id).is(':checked')){
            //title
            $('#car_table_'+pro_id+' .car_th .title_cost'+pro_id).hide();
            $('#car_table_'+pro_id+' .car_th .title_cost2'+pro_id).show();
            //link append
            $('#append_car_'+pro_id).hide();
            $('#append_car_labor_'+pro_id).hide();
            $('#append_car_machine_'+pro_id).hide();
            //remove tr chk
            $('.car_tr_cost_name'+pro_id+' td').remove();
            $('.car_tr_chk'+pro_id+' td').remove();
            
            append_outsource_chk(pro_id);
        } else{
            //title
            $('#car_table_'+pro_id+' .car_th .title_cost'+pro_id).show();
            $('#car_table_'+pro_id+' .car_th .title_cost2'+pro_id).hide();
            //link append
            $('#append_car_'+pro_id).show(); 
            $('#append_car_labor_'+pro_id).show(); 
            $('#append_car_machine_'+pro_id).show(); 
            //remove tr chk  
            $('.car_tr_outsource'+pro_id).remove();
            $('.car_tr_chk'+pro_id+' td').remove();
            
            append_cost_name_chk(pro_id);
        }
        calculate_cost(pro_id);
    });
}    
function append_labor(pro_id, i){
    $('#append_car_labor_'+pro_id).click(function(){
        $('#car_table_'+pro_id).append(
            '<tr class="car_tr car_tr_cost_name'+pro_id+'" >'
                +'<td>'
                    +'<div class=part_labor'+pro_id+i+'>'
                        +'<input id=labor_input_'+pro_id+i+' class=labor_input placeholder = "Nhập tên nhân công" >'
                        +'<table id=row_selected_labor'+pro_id+i+' >'
                        +'</table>'
                    +'</div>'
                +'</td>'
                +'<td><input name=cost_money_labor['+pro_id+i+'] id=cost_money_'+pro_id+i+' \n\
                    class="cost_money cost_money'+pro_id+' cost_money_labor cost_money_labor'+pro_id+i+'" \n\
                    onchange="calculate_cost('+pro_id+')" readonly >'
                +'</td>'
                +'<td>'
                    +'<select name=tk_no_labor['+pro_id+i+'] class="tk_no tk_no_labor'+pro_id+i+'" >'
                    +'</select>'
                +'</td>'
                +'<td>'
                    +'<select name=tk_co_labor['+pro_id+i+'] class="tk_co tk_co_labor'+pro_id+i+'" >'
                    +'</select>'
                +'</td>'    
                +'<td><textarea name=comment['+pro_id+i+'] id=comment_'+pro_id+i+' \n\
                    class="comment comment'+pro_id+'" type=textarea cols=20 rows=3 ></textarea></td>'
                +'<td><a href=# class=delete title="Xóa" onclick="return deleteCarRow(this, '+pro_id+');" >X</a></td>'
            +'</tr>'
        );
        $('.tk_no_labor'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_no_list' ?>");
        $('.tk_co_labor'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");        
        auto_complete_labor(pro_id, i);
        i++;
        return false;
    });
}
function append_machine(pro_id, i){
    $('#append_car_machine_'+pro_id).click(function(){
        $('#car_table_'+pro_id).append(
            '<tr class="car_tr car_tr_cost_name'+pro_id+'" >'
                +'<td>'
                    +'<div class=part_machine'+pro_id+i+'>'
                        +'<input id=machine_input_'+pro_id+i+' class=machine_input placeholder = "Nhập tên máy móc" >' 
                        +'<table id=row_selected_machine'+pro_id+i+' >'
                        +'</table>'
                    +'</div>'
                +'</td>'
                +'<td><input name=cost_money_machine['+pro_id+i+'] id=cost_money_'+pro_id+i+'  \n\
                    class="cost_money cost_money'+pro_id+' cost_money'+pro_id+i+' cost_money_machine cost_money_machine'+pro_id+i+'" \n\
                    onchange="calculate_cost('+pro_id+')" readonly >'
                +'</td>'
                +'<td>'
                    +'<select name=tk_no_machine['+pro_id+i+'] class="tk_no tk_no_machine'+pro_id+i+'" >'
                    +'</select>'
                +'</td>'
                +'<td>'
                    +'<select name=tk_co_machine['+pro_id+i+'] class="tk_co tk_co_machine'+pro_id+i+'" >'
                    +'</select>'
                +'</td>' 
                +'<td><textarea name=comment['+pro_id+i+'] id=comment_'+pro_id+i+' \n\
                class="comment comment'+pro_id+'" type=textarea cols=20 rows=3 ></textarea></td>'
                +'<td><a href=# class=delete title="Xóa" onclick="return deleteCarRow(this, '+pro_id+');" >X</a></td>'
            +'</tr>'
        );
        $('.tk_no_machine'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_no_list' ?>");
        $('.tk_co_machine'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");        
        auto_complete_machine(pro_id, i);
        i++;
        return false;
    });
}
function append_cost(pro_id, i){
    $('#append_car_'+pro_id).click(function(){
        $('#car_table_'+pro_id).append(
            '<tr class="car_tr car_tr_cost_name'+pro_id+'" >'
                +'<td><input name=cost_name['+pro_id+i+'] id=cost_name_'+pro_id+i+' class="cost_name cost_name'+pro_id+'" ></td>'
                +'<td><input name=cost_money['+pro_id+i+'] id=cost_money_'+pro_id+i+' \n\
                    class="cost_money cost_money'+pro_id+'" onchange="calculate_cost('+pro_id+')" >'
                +'</td>'
                +'<td>'
                    +'<select name=tk_no['+pro_id+i+'] class="tk_no tk_no'+pro_id+i+'" >'
                    +'</select>'
                +'</td>'
                +'<td>'
                    +'<select name=tk_co['+pro_id+i+'] class="tk_co tk_co'+pro_id+i+'" >'
                    +'</select>'
                +'</td>'
                +'<td><textarea name=comment['+pro_id+i+'] id=comment_'+pro_id+i+' \n\
                class="comment comment'+pro_id+'" type=textarea cols=20 rows=3 ></textarea></td>'
                +'<td><a href=# class=delete title="Xóa" onclick="return deleteCarRow(this, '+pro_id+');" >X</a></td>'
            +'</tr>'
        );
        $('.tk_no'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_no_list' ?>");
        $('.tk_co'+pro_id+i).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");

        $(".cost_money").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
              (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        i++;
        return false;
    }); 
}
function append_cost_name_chk(pro_id){
    $('.car_tr_chk'+pro_id).append(
        '<td>'
            +'<input id=cost_name_'+pro_id+' class="cost_name cost_name'+pro_id+'" name=cost_name['+pro_id+'] >'
        +'</td>'
        +'<td>'
            +'<input name=cost_money['+pro_id+'] id=cost_money_'+pro_id+' class="cost_money cost_money'+pro_id+'" onchange="calculate_cost('+pro_id+')" >'
        +'</td>'
        +'<td>'
            +'<select name=tk_no['+pro_id+'] class="tk_no tk_no'+pro_id+'" >'
            +'</select>'
        +'</td>'
        +'<td>'
            +'<select name=tk_co['+pro_id+'] class="tk_co tk_co'+pro_id+'" >'
            +'</select>'
        +'</td>'
        +'<td>'
            +'<textarea name=comment['+pro_id+'] id=comment_'+pro_id+' class="comment comment'+pro_id+'" rows=3 cols=20 ></textarea>'
        +'</td>'
        +'<td><a href=# class=delete title="Xóa" onclick="return deleteCarRow(this, '+pro_id+')" >X</a></td>'
    );
    $('.tk_no'+pro_id).load("<?php echo site_url().'/item_kits/tk_no_list' ?>");
    $('.tk_co'+pro_id).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");    
    
    $(".cost_money").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
          (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
          (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
}
function append_outsource_chk(pro_id){
    $('.car_tr_chk'+pro_id).append(
        '<td>'
            +'<div class=part_outsource'+pro_id+'>'
                +'<input id=outsource_input_'+pro_id+' class=outsource_input placeholder = "Nhập tên nhà cung cấp" >'
                +'<table id=row_selected_outsource'+pro_id+' >'
                +'</table>'
            +'</div>'
        +'</td>'
        +'<td>'
            +'<input name=cost_money_outsource['+pro_id+'] id=cost_money_'+pro_id+' \n\
                class="cost_money cost_money'+pro_id+'" onchange="calculate_cost('+pro_id+')" >'
        +'</td>'
        +'<td>'
            +'<select name=tk_no_outsource['+pro_id+'] class="tk_no tk_no'+pro_id+'" >'
            +'</select>'
        +'</td>'
        +'<td>'
            +'<select name=tk_co_outsource['+pro_id+'] class="tk_co tk_co'+pro_id+'" >'
            +'</select>'
        +'</td>'
        +'<td>'
            +'<textarea name=comment['+pro_id+'] id=comment_'+pro_id+' class="comment comment'+pro_id+'" rows=3 cols=20 ></textarea>'
        +'</td>'
        +'<td><a href=# class=delete title="Xóa" onclick="return deleteCarRow(this, '+pro_id+')" >X</a></td>'
    );
    $('.tk_no'+pro_id).load("<?php echo site_url().'/item_kits/tk_no_list' ?>");
    $('.tk_co'+pro_id).load("<?php echo site_url().'/item_kits/tk_co_list' ?>");    
    
    auto_complete_outsource(pro_id);
    $(".cost_money").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
          (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
          (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
}
function auto_complete_outsource(pro_id){
    $("#outsource_input_"+pro_id).autocomplete({
        source: '<?php echo site_url("sales/supplier_search_cost"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui){
            $('#outsource_input_'+pro_id).hide();
            $("#row_selected_outsource"+pro_id).append(
                '<tr style="border: none">'
                +'<td width="80%" style="border: none"><input type=hidden id=outsource_'+pro_id+' name=outsource['+pro_id+'] value=' + ui.item.value + ' />' + ui.item.label + '</td>'
                +'<td style="border: none"><a href=# class=delete title="Xóa" onclick="return deleteRow(this, '+pro_id+')">X</a></td>'
                +'</tr>'
            );
            return false;
        }
    }); 
}
function auto_complete_labor(pro_id, i){
    $("#labor_input_"+pro_id+i).autocomplete({
        source: '<?php echo site_url("employees/search_suggestions_audi"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui){
            if( $('#id_processes_'+pro_id).val() == ''){
                alert('Bạn chưa chọn tên công đoạn này !');return false;
            }
            if( $('#time_processes_'+pro_id).val() == '0'
             || $('#time_processes_'+pro_id).val() == ''){
                alert('Công đoạn đã chọn chưa có thời gian !');return false;
            }
            if( $('#unit_time_'+pro_id).val() == ''){
                alert('Công đoạn đã chọn chưa có đơn vị thời gian !');return false;
            }
            $('#labor_input_'+pro_id+i).hide();
            $("#row_selected_labor"+pro_id+i).append(
                '<tr style="border: none">'
                +'<td width="80%" style="border: none"><input type=hidden id=labor_'+pro_id+i+' name=labor['+pro_id+i+'] value=' + ui.item.value + ' />' + ui.item.label + '</td>'
                +'<td style="border: none"><a href=# class=delete title="Xóa" onclick="return deleteRow2(this, '+pro_id+i+')">X</a></td>'
                +'</tr>'
            );
            var cost_money_audi = $('#unit_time_'+pro_id).val() == 1 
                ? ui.item.cost_money * $('#time_processes_'+pro_id).val() 
                : ui.item.cost_money * $('#time_processes_'+pro_id).val() / 8;
            var cost_money = cost_money_audi.toFixed(2);
            $('.cost_money_labor'+pro_id+i).val((cost_money+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show                
            calculate_cost(pro_id);
            return false;
        }
    }); 
}
function auto_complete_machine(pro_id, i){
    $("#machine_input_"+pro_id+i).autocomplete({
        source: '<?php echo site_url("assets/suggest"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui){
            if( $('#id_processes_'+pro_id).val() == ''){
                alert('Bạn chưa chọn tên công đoạn này !');return false;
            }
            if( $('#time_processes_'+pro_id).val() == '0'
             || $('#time_processes_'+pro_id).val() == ''){
                alert('Công đoạn đã chọn chưa có thời gian !');return false;
            }
            if( $('#unit_time_'+pro_id).val() == ''){
                alert('Công đoạn đã chọn chưa có đơn vị thời gian !');return false;
            }
            $('#machine_input_'+pro_id+i).hide();
            $("#row_selected_machine"+pro_id+i).append(
                '<tr style="border: none">'
                +'<td width="80%" style="border: none"><input type=hidden id=machine_'+pro_id+i+' name=machine['+pro_id+i+'] value=' + ui.item.value + ' />' + ui.item.label + '</td>'
                +'<td style="border: none"><a href=# class=delete title="Xóa" onclick="return deleteRow3(this, '+pro_id+i+')">X</a></td>'
                +'</tr>'
            );
            var cost_money = ui.item.cost_money.toFixed(2);
            $('.cost_money_machine'+pro_id+i).val((cost_money+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show                
            calculate_cost(pro_id);
            return false;
        }
    }); 
}
function deleteRow(link, pro_id){
    $('#outsource_input_'+pro_id).show();
    $(link).parent().parent().remove();
    return false;
} 
function deleteRow2(link, pro_id_i){
    $('#labor_input_'+pro_id_i).show();
    $('.part_labor'+pro_id_i).show();
    $(link).parent().parent().remove();
    return false;
}
function deleteRow3(link, pro_id_i){
    $('#machine_input_'+pro_id_i).show();
    $('.part_machine'+pro_id_i).show();
    $(link).parent().parent().remove();
    return false;
}
function deleteBrandRow(link, pro_id){
    var count_tr_brand = $('#brand_table .brand_tr').length;
    if(count_tr_brand == 1){
        alert('Bạn không thể xóa hết công đoạn !');
        return false;
    } 
    $(link).parent().parent().remove();
    $('#car_tr_'+pro_id).remove();
    $('#space_tr_'+pro_id).remove();
    calculate_cost(pro_id);
    return false;
}
function deleteCarRow(link, pro_id){
    $(link).parent().parent().remove();
    calculate_cost(pro_id);
    return false;
}
function calculate_cost(pro_id) {
    var sum_cost=0;
    $('.cost_money'+pro_id).each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_cost += +a;
    });
    var sum_cost_audi = sum_cost.toFixed(2);
    $('#processes_money_'+pro_id).val((sum_cost_audi+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
    
    var sum_processes=0;
    $('.processes_money').each(function () {
        var a = $(this).val().replace(/,/g, "");
        sum_processes += +a;
    });
    $('.processes_money_total').val((sum_processes+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show
    
    var money_totals = +$('.total_money_norms').val().replace(/,/g, "") + sum_processes;
    var money_total = money_totals.toFixed(2);
    $('.money_total').val((money_total+'').replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));//add ',' to show    
}    
$('.submit_button').click(function () {
    var arr_id_processes        = [];
    var arr_id_processes_none   = [];
    var arr_time_processes      = [];
    var arr_unit_time           = [];
    var arr_cost_name           = [];
    var arr_outsource           = [];
    var arr_labor               = [];
    var arr_machine             = [];
    var arr_cost_money          = [];
    var arr_tk_no               = [];
    var arr_tk_co               = [];
    
    $(".brand_tr").find('.pro_id').each(function (index, element) {
        var pro_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);
        
        if($('#id_processes_' + pro_id).val()){
            arr_id_processes.push(pro_id);
            
            if ( ! $('#time_processes_' + pro_id).val() 
                || $('#time_processes_' + pro_id).val() == 0) {
                arr_time_processes.push(pro_id);
            }
            if ( ! $('#unit_time_' + pro_id).val()) {
                arr_unit_time.push(pro_id);
            }
        }else{
            if( ! $('#id_processes_' + pro_id).val()){
                arr_id_processes_none.push(pro_id);
            }
        }
        $(".car_tr").find('.cost_name').each(function (index, element) {
            var pro_id_i = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);  
            
            if ( ! $('#cost_name_' + pro_id_i).val()) {
                arr_cost_name.push(pro_id_i);
            }
            if ( ! $('#cost_money_' + pro_id_i).val()
                || $('#cost_money_' + pro_id_i).val() == 0) {
                arr_cost_money.push(pro_id_i);
            }  
            if ( $('.tk_no' + pro_id_i).val() == '') {
                arr_tk_no.push(pro_id_i);
            }
            if ( $('.tk_co' + pro_id_i).val() == '') {
                arr_tk_co.push(pro_id_i);
            }
        });
        $(".car_tr").find('.outsource_input').each(function (index, element) {
            var pro_id = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);  
            
            if ( ! $('#outsource_' + pro_id).val()) {
                arr_outsource.push(pro_id);
            }
            if ( ! $('#cost_money_' + pro_id).val()
                || $('#cost_money_' + pro_id).val() == 0) {
                arr_cost_money.push(pro_id);
            }  
            if ( $('.tk_no' + pro_id).val() == '') {
                arr_tk_no.push(pro_id);
            }
            if ( $('.tk_co' + pro_id).val() == '') {
                arr_tk_co.push(pro_id);
            }
        });
        $(".car_tr").find('.labor_input').each(function (index, element) {
            var pro_id_i = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);  
            
            if ( ! $('#labor_' + pro_id_i).val()) {
                arr_labor.push(pro_id_i);
            }
            if ( $('.tk_no_labor' + pro_id_i).val() == '') {
                arr_tk_no.push(pro_id_i);
            }
            if ( $('.tk_co_labor' + pro_id_i).val() == '') {
                arr_tk_co.push(pro_id_i);
            }
        });
        $(".car_tr").find('.machine_input').each(function (index, element) {
            var pro_id_i = $(element).attr('id').substring($(element).attr('id').lastIndexOf('_') + 1);  
            
            if ( ! $('#machine_' + pro_id_i).val()) {
                arr_machine.push(pro_id_i);
            }
            if ( $('.tk_no_machine' + pro_id_i).val() == '') {
                arr_tk_no.push(pro_id_i);
            }
            if ( $('.tk_co_machine' + pro_id_i).val() == '') {
                arr_tk_co.push(pro_id_i);
            }
        });
    });
    if (arr_id_processes.length < 1) {
        alert("Bạn chưa chọn công đoạn nào !");
        return false;
    }
    if (arr_id_processes_none.length > 0) {
        alert("Có công đoạn chưa thấy chọn !");
        return false;
    }
    if (arr_time_processes.length > 0) {
        alert("Công đoạn đã chọn chưa có thời gian !");
        return false;
    }
    if (arr_unit_time.length > 0) {
        alert("Công đoạn đã chọn chưa có đơn vị thời gian !");
        return false;
    }
    if (arr_cost_name.length > 0) {
        alert("Bạn chưa điền tên chi phí !");
        return false;
    }
    if (arr_outsource.length > 0) {
        alert("Bạn chưa nhập tên nhà cung cấp !");
        return false;
    }
    if (arr_labor.length > 0) {
        alert("Bạn chưa nhập tên nhân công !");
        return false;
    }
    if (arr_machine.length > 0) {
        alert("Bạn chưa nhập tên máy móc !");
        return false;
    }
    if (arr_cost_money.length > 0) {
        alert("Bạn chưa điền giá chi phí !");
        return false;
    }
    if (arr_tk_no.length > 0) {
        alert("Bạn chưa chọn tài khoản nợ !");
        return false;
    }
    if (arr_tk_co.length > 0) {
        alert("Bạn chưa chọn tài khoản có !");
        return false;
    }
    //return false;
});
//$('.cost_money').maskMoney();//ko onchange dc..........
$('.processes_money').maskMoney();
//only enter number
$(".time_processes").keydown(function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
      (e.keyCode >= 35 && e.keyCode <= 40)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});    
$(".cost_money").keydown(function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
      (e.keyCode >= 35 && e.keyCode <= 40)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>
<style type="text/css"> 
.tk_no, .tk_co{
    width: 141px
}     
.cost_money_labor, 
.cost_money_machine,
#row_selected_labor tr:first-child, 
#row_selected_machine tr:first-child,
#row_selected_labor tr td:first-child, 
#row_selected_labor tr td:last-child,
#row_selected_machine tr td:first-child, 
#row_selected_machine tr td:last-child,
tr#car_table_tr_first td, 
tr#car_table_tr_first, 
#row_selected_outsource tr, 
#row_selected_outsource tr td{
    border: none;
}
#item_kit_size{
    width:99%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important; 
}
#item_kit_size tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_size tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.submit_button{
    margin-bottom:20px
}
#item_kit_feature{
    margin-bottom: 10px;
}
#size_detail tr td, #quantity_detail tr td{
    line-height: 290%;
    border: none;
    border-top: 1px solid #CDCDCD;
}
#size_detail tr:first-child td, #quantity_detail tr:first-child td{
    border-top: none;
}

#item_kit_money{
    width:100%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
#item_kit_money{
    width:99%;
}
#item_kit_money tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_money tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
#table_info_item_kit{
    width: 98%;
    margin-left: 5px;
    font-size: 12px;    
}
#table_info_item_kit tr td{
    padding: 4px 0px;
}
#table_info_item_kit .left_table{
    width: 15%;
    font-weight: bold;
}
#table_info_item_kit .right_table{
    width: 35%;
}    
/*//Hưng Audi 3-8-15*/
.item_kit_processes tr td{
    padding: 3px 5px;
}
.time_processes, .processes_money{
    height: 20px;
    text-align: right;
    padding-right: 6px;
}
.id_processes, .unit_time{
    height: 22px;
    padding-left: 5px;
    text-align: left;
}
.cost_money{
    height: 20px;
    text-align: right;
    padding-right: 6px;
}
.cost_name, .outsource_input, .labor_input, .machine_input{
    height: 20px;
    width: 200px;
    text-align: left;
    padding-left: 6px;    
}
#brand_table{
    width: 100%;
    border: 1px solid #CDCDCD;
    font-size: 12px;
}    
#brand_table tr, #brand_table tr td, #brand_table tr th{
    border: 1px solid #CDCDCD;
    text-align: center;
    padding: 5px
}
#car_table{
    color: green;
}
.car_th{
    background: #e8e8e8;
}
.brand_tr, .processes_money{
    background: #E1E6FF;
}
.space_tr{
    background: #d1d1d1
}
.processes_money, .total_money_norms, .processes_money_total, .money_total{
    text-align: right;
    margin-right: 5px;
    border: none
}
.disable_input_cost, .class_hide{
	display: none;
}
.title_cost{
    border: none;
    background: #e8e8e8;
    font-size: 13px;
    font-weight: bold;
}
.append_car, .append_car_machine{
    margin-left: 30px;
}
#item_kit_size3{
    width:99%;	
    font: 13px solid;
    margin-left: 5px ;
    margin-top: 10px !important;
}
#item_kit_size3 tr td{
    border: 1px solid #CDCDCD;
    padding: 3px 5px;
}
#item_kit_size3 tr th{
    border: 1px solid #CDCDCD;
    background: #e8e8e8;
    color: #000;
    padding: 5px 5px;
}
.qty_store, .qty_remain, .quantity_size{
    border: none;
    text-align: right;
    font: 13px solid;
    width: 100%
}
.qty_total{
    text-align: right;
    font: 13px solid;
    width: 95%;
    padding-right: 5px;
}
.append_car_labor, .append_car_machine, .append_car{
    background: #e0522f none repeat scroll 0 0;
    border-bottom: 1px solid #ffffff;
    color: #ffffff;
    padding: 3px;
    text-align: left;
    text-decoration: none;
    text-shadow: 1px 1px 1px #000;
}
.append{
    background: #3C9445 none repeat scroll 0 0;
    border-bottom: 1px solid #ffffff;
    color: #ffffff;
    padding: 3px;
    text-align: left;
    text-decoration: none;
    text-shadow: 1px 1px 1px #000;
}
.delete{
    text-decoration: underline;
    color: black
}
</style>