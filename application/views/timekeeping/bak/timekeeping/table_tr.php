<?php
  if( count($kepping_info) > 0){
    $i = 1;
    foreach ($kepping_info AS $key => $value){ ?>
        <tr class="edit tb-timekeeping-contaner" id="<?php echo $value->person_id ?>">
        <td style="text-align: center"><?php echo $i; ?></td>
        <td id="person_id" style="text-align: center"><?php echo $value->person_id; ?></td>
        <td><?php echo $value->first_name; ?></td>
        <td><?php echo date('d-m-Y',strtotime($value->date_start)); ?></td>
        <td><?php echo date('d-m-Y',strtotime($value->date_end)); ?></td>
        <td><?php echo $value->jobs_positions_name; ?></td>
        <?php
        $day_one = explode('-',$day_month);
        $day = cal_days_in_month(CAL_GREGORIAN,$day_one[1],$day_one[0]);
        ?>
        <td>
            <select name ='01' class="date show date_01" >
                <?php
                $dem = 0;
                foreach($date_info01 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 1){
                            $dem++;
                            if($dem > 0){
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='02' class="date show date_02" >
                <?php
                $dem = 0;
                foreach($date_info02 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 2){
                            $dem ++;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='03' class="date show date_03" >
                <?php
                $dem = 0;
                foreach($date_info03 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 3){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='04' class="date show date_04">
                <?php
                $dem = 0;
                foreach($date_info04 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 4){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>
        <td>
            <select name ='05' class="date show date_05" >
                <?php
                $dem = 0;
                foreach($date_info05 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 5){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='06' class=" date show date_06" >
                <?php
                $dem = 0;
                foreach($date_info06 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 6){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='07' class="date show date_07" >
                <?php
                $dem = 0;
                foreach($date_info07 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 7){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>
        <td>
            <select name ='08' class="date show date_08" >
                <?php
                $dem = 0;
                foreach($date_info08 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 8){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='09' class="date show date_09">
                <?php
                $dem = 0;
                foreach($date_info09 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 9){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='10' class="date show date_10" >
                <?php
                $dem = 0;
                if(count($date_info10) > 0){
                    foreach($date_info10 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 10){
                                $dem = 1;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>
        <td>
            <select name ='11' class="date show date_11"  >
                <?php
                $dem = 0;
                foreach($date_info11 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 11){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>
        <td>
            <select name ='12' class="date show date_12" >
                <?php
                $dem = 0;
                foreach($date_info12 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 12){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>

        <td>
            <select name ='13' class="date show date_13" >
                <?php
                $dem = 0;
                foreach($date_info13 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 13){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='14' class="date show date_14" >
                <?php
                $dem = 0;
                foreach($date_info14 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 14){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='15' class="date show date_15" >
                <?php
                $dem = 0;
                foreach($date_info15 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 15){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='16' class=" date date_16" >
                <?php
                $dem = 0;
                foreach($date_info16 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 16){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='17' class="date show date_17"  >
                <?php
                $dem = 0;
                foreach($date_info17 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 17){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>
        <td>
            <select name ='18' class="date show date_18" >
                <?php
                $dem = 0;
                foreach($date_info18 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 18){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>

        <td>
            <select name ='19' class="date show date_19">
                <?php
                $dem = 0;
                foreach($date_info19 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 19){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>

        <td>
            <select name ='20' class="date show date_20" >
                <?php
                $dem = 0;
                foreach($date_info20 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 20){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>

        <td>
            <select name ='21' class="date show date_21" >
                <?php
                $dem = 0;
                foreach($date_info21 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 21){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>

        </td>
        <td>
            <select name ='22' class="date show date_22" >
                <?php
                $dem = 0;
                foreach($date_info22 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 22){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='23' class="date show date_23" >
                <?php
                $dem = 0;
                foreach($date_info23 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 23){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='24' class="date show date_24"  >
                <?php
                $dem = 0;
                foreach($date_info24 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 24){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>
        <td>
            <select name ='25' class="date show date_25" >
                <?php
                $dem = 0;
                foreach($date_info25 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 25){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='26' class=" date date_26" >
                <?php
                $dem = 0;
                foreach($date_info26 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 26){
                            $dem = 1;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='27' class="date show date_27"  >
                <?php
                $dem = 0;
                foreach($date_info27 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 27){
                            $dem ++;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <td>
            <select name ='28' class="date show date_28" >
                <?php
                $dem = 0;
                foreach($date_info28 AS $date_info){
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 28){
                            $dem ++;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }
                }
                if($dem == 0){
                    echo "<option value=''>--</option>";
                    foreach ($data_salary AS $key => $values){ ?>
                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                    <?php }
                }
                ?>
            </select>
        </td>

        <?php if($day == 28){?>
            <td>
                <select name ='29' class="date show date_29" disabled="disabled">
                    <?php
                    $dem = 0;
                    foreach($date_info29 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 29){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='30' class="date show date_30" disabled="disabled" >
                    <?php
                    $dem = 0;
                    foreach($date_info30 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 30){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='31' class="date show date_31" disabled="disabled" >
                    <?php
                    $dem = 0;
                    foreach($date_info31 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 31){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>
        <?php }else if($day == 29){?>
            <td>
                <select name ='29' class="date show date_29">
                    <?php
                    $dem = 0;
                    foreach($date_info29 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 29){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>
            <td>
                <select name ='30' class="date show date_30" disabled="disabled" >
                    <?php
                    $dem = 0;
                    if($value-> person_id == $date_info->person_id ){
                        $date = explode('-', $date_info->day_keeping);
                        if($date[2] == 30){
                            $dem++;
                            foreach ($data_salary AS $key => $values){
                                if($values->id == $date_info->salaryconfig_id){?>
                                    <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                <?php }else{ ?>
                                    <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                <?php }
                            }
                        }
                    }

                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='31' class="date show date_31" disabled="disabled" >
                    <?php
                    $dem = 0;
                    foreach($date_info31 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 31){
                                $dem++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>
        <?php }else if($day == 30){?>
            <td>
                <select name ='29' class="date show date_29" >
                    <?php
                    $dem = 0;
                    foreach($date_info29 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 29){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='30' class="date show date_30" >
                    <?php
                    $dem = 0;
                    foreach($date_info30 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 30){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='31' class="date show date_31" disabled="disabled" >
                    <?php
                    $dem = 0;
                    foreach($date_info31 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 31){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>
        <?php }else if($day == 31){ ?>
            <td>
                <select name ='29' class="date show date_29">
                    <?php
                    $dem = 0;
                    foreach($date_info29 AS $date_info){
                        if($value->person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 29){
                                $dem++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='30' class="date show date_30" >
                    <?php
                    $dem = 0;
                    foreach($date_info30 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 30){
                                $dem ++;
                                foreach ($data_salary AS $key => $values){
                                    if($values->id == $date_info->salaryconfig_id){?>
                                        <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                    <?php }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>

            <td>
                <select name ='31' class="date show date_31" >
                    <?php
                    $dem = 0;
                    foreach($date_info31 AS $date_info){
                        if($value-> person_id == $date_info->person_id ){
                            $date = explode('-', $date_info->day_keeping);
                            if($date[2] == 31){
                                $dem++;
                                if($dem > 0){
                                    foreach ($data_salary AS $key => $values){
                                        if($values->id == $date_info->salaryconfig_id){?>
                                            <option value="<?php $values->id ?>" selected="selected" title="<?php echo $values->description ?>"><?php echo $values->name  ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                                        <?php }
                                    }
                                }
                            }
                        }
                    }
                    if($dem == 0){
                        echo "<option value=''>--</option>";
                        foreach ($data_salary AS $key => $values){ ?>
                            <option value="<?php echo $values->id ?>" title="<?php echo $values->description ?>"><?php echo $values->name ?></option>
                        <?php }
                    }
                    ?>
                </select>
            </td>
        <?php }

        $number_x = $count_x[$i-1]
            +  1/2*$count_x_2[$i-1]
            +  1/2*$count_k_2_x_2[$i-1]
            +  1/2*$count_l_2_x_2[$i-1]
            +  1/2*$count_p_2_x_2[$i-1]
            +  1/2*$count_ts_2_x_2[$i-1]
            +  1/2*$count_kl_2_x_2[$i-1]
            +  1/2*$count_t_2_x_2[$i-1]
            +  1/2*$count_o_2_x_2[$i-1] ;

        $number_p = $count_p[$i-1]
            +  1/2*$count_p_2[$i-1]
            +  1/2*$count_p_2_kl_2[$i-1]
            +  1/2*$count_p_2_x_2[$i-1];

        $number_k = $count_k[$i-1]
            +  1/2*$count_k_2[$i-1]
            +  1/2*$count_k_2_x_2[$i-1];

        $number_t = $count_t[$i-1]
            +  1/2*$count_t_2[$i-1]
            +  1/2*$count_t_2_x_2[$i-1];

        $number_l = $count_l[$i-1]
            +  1/2*$count_l_2[$i-1]
            +  1/2*$count_l_2_x_2[$i-1];

        $number_nb = $count_nb[$i-1];

        $number_h = $count_h[$i-1]
            +  1/2*$count_h_2[$i-1]
            +  1/2*$count_h_2_x_2[$i-1];

        $number_ts = $count_ts[$i-1]
            +  1/2*$count_ts_2[$i-1]
            +  1/2*$count_ts_2_x_2[$i-1];

        $number_o = $count_o[$i-1]
            +  1/2*$count_o_2[$i-1]
            +  1/2*$count_o_2_x_2[$i-1];

        $number_kl = $count_kl[$i-1]
            +  1/2*$count_kl_2[$i-1]
            +  1/2*$count_p_2_kl_2[$i-1]
            +  1/2*$count_kl_2_x_2[$i-1];

        $number_x150 = $count_x150[$i-1]
            +  1/2*$count_x150_2[$i-1];

        $number_x200 = $count_x200[$i-1]
            +  1/2*$count_x200_2[$i-1];

        $number_x300 = $count_x300[$i-1]
            +  1/2*$count_x300_2[$i-1];
        $vacation ='';
        foreach($total_vacation AS $items){
            if($items->person_id == $value->person_id){
                $vacation .= $items->total_vacation;
            }
        }
        //Tính tổng số công cho nhân viên
        $count_all = $number_x + $number_p + $number_k + $number_t + $number_l + $number_nb;
        //Hạn kỳ nghỉ trong tháng này =  kỳ nghỉ hạn trước lưu trong table lifetek_salarystatic + $number_p
        $count_month = $number_p + $vacation ;
        //Số ngày hạn phép còn lại trong 1 năm
        $total_date = $value->em_on_vacation - $count_month;
        ?>

        <td class="count_x"><?php if($number_x > 0)  echo  $number_x; else echo "-"; ?></td>
        <td class="count_c"><?php echo '-' ?></td>
        <td class="count_p"><?php if($number_p > 0) echo $number_p; else echo "-"; ?></td>
        <td class="count_k"><?php if($number_k > 0) echo $number_k; else echo "-"; ?></td>
        <td class="count_t"><?php if($number_t > 0) echo $number_t; else echo "-" ?></td>
        <td class="count_l"><?php if($number_l > 0) echo $number_l; else echo "-" ?></td>
        <td class="count_nb"><?php if($number_nb > 0) echo $number_nb; else echo '-'; ?></td>
        <td class="count_all"><?php if($count_all > 0) echo $count_all; else echo "-"; ?></td>
        <td class="count_all"><?php if($number_x150 > 0) echo $number_x150; else echo "-"; ?></td>
        <td class="count_all"><?php if($number_x200 > 0) echo $number_x200; else echo "-"; ?></td>
        <td class="count_all"><?php if($number_x300 > 0) echo $number_x300; else echo "-"; ?></td>
        <td class="count_h"><?php if($number_h > 0) echo $number_h;else echo "-"; ?></td>
        <td class="count_ts"><?php if($number_ts > 0) echo $number_ts;else echo "-" ?></td>
        <td class="count_o"><?php if($number_o > 0) echo $number_o;else echo "-" ?></td>
        <td class="count_kl"><?php if($number_kl > 0) echo $number_kl; else echo "-" ?></td>
        <td><?php if( !empty($vacation)) echo $vacation; else echo '-'; ?></td>
        <td ><?php if($value->em_on_vacation > 0) echo $value->em_on_vacation; else echo '-'; ?></td>
        <td ><?php if($total_date > 0) echo $total_date; else echo '-'; ?></td>
        <td class="count_vacation"><?php if($count_month > 0) echo $count_month; else echo '-';  ?></td>
        <?php
            $description = '';
            foreach($description_info AS $str){
                if($str->person_id == $value->person_id){
                    if($description == '')
                    $description .= $str->description;
                }
            }
        ?>
        <td class="description_<?php echo $value->person_id; ?>">
            <span class="span_<?php echo $value->person_id; ?> span" style="width: 150px;overflow: hidden;display: block" title="<?php echo $description ?>"...><?php echo $description ?></span>
            <input class="input_<?php echo $value->person_id; ?> input" style="display:none;min-width: 150px;height: 22px;padding: 2px;" value="<?php echo $description ?>".../>
        </td>

        </tr>
        <?php
        $i++;
    }
}else{
     echo '<tr class="tb-timekeeping-contaner">
                <td colspan="54" style="padding: 10px 90px;height: 30px;line-height: 30px;font-size: 13px;color: #555">Cảnh báo: Bạn chưa được phép chấm công trong tháng <span style="color: red;" class="month_name">&nbsp;&nbsp;</span> năm <span style="color:red;" class="year_name"></span></td>
          </tr>';
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.edit').click(function(){
            var person_id = $(this).attr('id');
            $(this).find('.description_'+person_id).click(function(){
                $('td input').hide();
                $(this).find('.input_'+person_id).show();
                $('td span').show();
                $(this).find('.span_'+person_id).hide();

            });
            $(this).find('.date').change(function(){
                var description = $('td .input_'+person_id).val();
                var url = $("#sendOne").attr('href');
                var url_all = $("#sendLoadAll").attr('href');
                var day = $(this).attr('name');
                var year = $('.year_info').val();
                var month = $('.month_info').val();
                var employees_id = $('.employees_id').val();
                var department_id = $('.department_id').val();
                var value = $(this).val();
                var date = year+'-'+month+'-'+day;
                $.post(url,{person_id:person_id,value:value,date:date,month:month,year:year,description:description,department_id:department_id,employees_id:employees_id},function(data,success){
                    if(success){
                        $(".month_name").html(month);
                        $(".year_name").html(year);
                        $("#tb-timekeeping-contaner").html(data);
                        $.post(url_all,{person_id:person_id,month:month,year:year},function(data,success){
                           // alert(data);
                        });
                    }
                });
            });
        });
    });
</script>