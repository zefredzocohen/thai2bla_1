<div style="float:left; width: 100%;padding: 20px 0">
    <fieldset id="item_basic_info" style="overflow: hidden">
        <legend><h4 style="color:red;">Thông tin nghề nghiệp : </h4></legend>

        <div id="careers_employees" style="margin-top:10px;">
            <div id="careers_info" style="margin-top: 10px;float: left;overflow: hidden">
                <p>
                    <label class="field" >Ngày vào làm : </label>
                    <?php
                    echo form_input(array(
                            'name'=>'date_working',
                            'id'=>'date_working',
                            'style'=>'margin-left:15px',
                            'value'=>$person_info->date_working != '1950-01-01' ? date(get_date_format(),strtotime($person_info->date_working != ''?$person_info->date_working: date('d-m-Y'))):''
                        )
                    )
                    ;?>
                </p>			
				<p>
                    <label class="field" >Ngày hết hạn HĐ: </label>
                    <?php
                    echo form_input(array(
                            'name'=>'end_working',
                            'id'=>'end_working',
                            'style'=>'margin-left:15px',
                            'value'=>$person_info->end_working != '1950-01-01' ? date(get_date_format(),strtotime($person_info->end_working != ''?$person_info->end_working: date('d-m-Y'))):''
                        )
                    )
                    ;?>
                </p>
                <p>
                    <?php echo form_label(lang('common_city_regions_name').':', 'jobs_name',array('class'=>'')); ?>
                    <select name='jobs_regions_id' id='jobs_regions_id' onchange="clickSendRegions()">
                        <option value="" style="display: none">--- Chọn khu vực ---</option>
                        <?php foreach($regions_info AS $key => $values): ?>
                            <?php if($values->jobs_regions_id == $city_regions->jobs_regions_id ){?>
                                <option value="<?php echo $values->jobs_regions_id;?>" selected="selected"><?php echo $values->jobs_regions_name; ?></option>
                            <?php } else{ ?>
                                <option value="<?php echo $values->jobs_regions_id;?>"><?php echo $values->jobs_regions_name; ?></option>
                            <?php }endforeach; ?>
                    </select>      
                </p>
                <div class="action_show">
                    <p>
                        <?php echo form_label(lang('common_affiliates_city_name').':', 'jobs_name',array('class'=>'')); ?>
                        <select name='jobs_city_id' id='jobs_city_id' onchange="clickSendCity();">
                            <option value="" style="display: none">--- Chọn thành phố ---</option>
                            <?php foreach($city_info AS $key => $values): ?>
                                <?php if($values->jobs_city_id == $city_regions->jobs_city_id ){?>
                                    <option value="<?php echo $values->jobs_city_id;?>" selected="selected"><?php echo $values->jobs_city_name; ?></option>
                                <?php } else{ ?>
                                    <option value="<?php echo $values->jobs_city_id;?>"><?php echo $values->jobs_city_name; ?></option>
                                <?php }endforeach; ?>
                        </select>    
                    </p>                    
                    <div id="city_show">
                       <p>
                           <?php echo form_label(lang('common_affiliates_name').':', 'jobs_name',array('class'=>'')); ?>
                           <select name='jobs_affiliates_id' id='jobs_affiliates_id' onchange="clickSendAffiliates()">
                               <option value="" style="display: none">--- Chọn chi nhánh ---</option>
                               <?php foreach($affiliates_info AS $key => $values): ?>
                                   <?php if($values->jobs_affiliates_id == $city_regions->jobs_affiliates_id ){?>
                                       <option value="<?php echo $values->jobs_affiliates_id;?>" selected="selected"><?php echo $values->jobs_affiliates_name; ?></option>
                                   <?php } else{ ?>
                                       <option value="<?php echo $values->jobs_affiliates_id;?>"><?php echo $values->jobs_affiliates_name; ?></option>
                                   <?php }endforeach; ?>
                           </select>   
                        </p>
                        <div id="affiliates_show">
                           <p>
                               <?php echo form_label(lang('common_department_name').':', 'jobs_name',array('class'=>'')); ?>
                               <select name='department_id' id='department_id' onchange="clickSendDepartment()">
                                   <option value="" style="display: none">--- Chọn phòng ban ---</option>
                                   <?php foreach($department_info AS $key => $values): ?>
                                       <?php if($values->department_id == $city_regions->department_id ){?>
                                           <option value="<?php echo $values->department_id;?>" selected="selected"><?php echo $values->department_name; ?></option>
                                       <?php } else{ ?>
                                           <option value="<?php echo $values->department_id;?>"><?php echo $values->department_name; ?></option>
                                       <?php }endforeach; ?>
                               </select>    
                            </p>
                        </div><!--end #affiliates_show-->
                    </div><!--end #city_show-->
                </div><!--end #action_show-->
                <a href="<?php echo site_url('employees/loadRegions/'.$person_info->person_id)?>" style="display: none" id="hrefview"></a>
                <a href="<?php echo site_url('employees/loadCity/'.$person_info->person_id)?>" style="display: none" id="showCity"></a>
                <a href="<?php echo site_url('employees/loadAffiliates/'.$person_info->person_id)?>" style="display: none" id="showAffiliates"></a>
                <a href="<?php echo site_url('employees/loadDepartment/'.$person_info->person_id)?>" style="display: none" id="showDepartment"></a>

                <script type="text/javascript">
                    /*
                     * Th?c  hi?n load toàn b? thông tin khi ta th?c hiên ch?n select Khu v?c
                     * */
                    function clickSendRegions()
                    {
                        var url = $("#hrefview").attr('href');
                        var jobs_regions_id = $("#jobs_regions_id").val();

                        $.post(url,{jobs_regions_id:jobs_regions_id},function(data,success){
                            if(success){
                                $(".action_show").html(data);
                            }
                        });
                    }
                    /*
                     * Th?c hi?n load thông tin khi ch?n thành ph?
                     */
                    function clickSendCity()
                    {
                        var jobs_city_id = $("#jobs_city_id").val();
                        var url = $("#showCity").attr('href');
                        $.post(url,{jobs_city_id:jobs_city_id},function(data,success){
                            if(success){
                                $("#city_show").html(data);
                            }
                        });
                    }
                    /*
                     * Th?c hi?n load thông tin khi ch?n thành ph?
                     */
                    function clickSendAffiliates()
                    {
                        var jobs_affiliates_id = $("#jobs_affiliates_id").val();
                        var url = $("#showAffiliates").attr('href');
                        $.post(url,{jobs_affiliates_id:jobs_affiliates_id},function(data,success){
                            if(success){
                                $("#affiliates_show").html(data);
                            }
                        });
                    }
                    /*
                     * Th?c hi?n load thông tin khi ch?n thành ph?
                     */
                    function clickSendDepartment()
                    {
                        var department_id = $("#department_id").val();
                        var url = $("#showDepartment").attr('href');
                        $.post(url,{department_id:department_id},function(data,success){
                            if(success){
                                $("#showEmployees").html(data);
                            }
                        });
                    }
                    /*
                     *  Function th?c hiên l?y ten department trong khu v?c
                     * */
                    function getDepartment()
                    {
                        var department_id = $("#department_id").val();

                        alert(department_id);
                    }
                </script>

             </div>


            <div id="second_careers_info" style="margin-top: 10px;float: left">
			
                <p>
                    <label class="field">Chức vụ : </label>
                    <select name='positions_id' >
                    <option value="">-- Chọn chức vụ --</option>
                    <?php foreach($jobs_position AS  $jobs_positions): ?>
                        <?php if($jobs_positions['jobs_positions_id'] == $person_info->positions_id ){?>
                            <option value="<?php echo $jobs_positions['jobs_positions_id'];?>" selected="selected"><?php echo $jobs_positions['jobs_positions_name']  ?></option>
                        <?php } else{ ?>
                            <option value="<?php echo $jobs_positions['jobs_positions_id']?>"><?php echo $jobs_positions['jobs_positions_name'] ?></option>
                        <?php }
                    endforeach; ?>
                    </select>
                </p>

                <p><label class="field">Tài khoản NH: </label>
                    <?php echo form_input(array(
                        'name'=>'bank_account',
                        'id'=>'bank_account',
                        'value'=>$person_info->bank_account
                    ));?>
                </p>
                <p><label class="field">Tên ngân hàng : </label>
                    <?php echo form_input(array(
                        'name'=>'name_bank',
                        'id'=>'name_bank',
                        'value'=>$person_info->name_bank
                    ));?>
                </p>
                <p><label class="field">L.Cơ bản : </label>
                    <?php echo form_input(array(
                        'name'=>'em_salary_basic',
                        'id'=>'em_salary_basic',
                        'value'=>$person_info->em_salary_basic
                    ));?>
                </p>
                <p><label class="field">L.Bảo hiểm : </label>
                    <?php echo form_input(array(
                        'name'=>'em_social_insurance',
                        'id'=>'em_social_insurance',
                        'value'=>$person_info->em_social_insurance
                    ));?>
                </p>
				
				<p><label class="field">Hệ số lương : </label>
                    <?php echo form_input(array(
                        'name'=>'hs_salary',
                        'id'=>'hs_salary',
                        'value'=>$person_info->hs_salary
                    ));?>
                </p>
            </div>

            <div id="thirt_careers_info" style="margin: 227px 20px 0 0 ;float: right">
                
                <p><label class="field">Pc.Thâm niên : </label>
                        <?php echo form_input(array(
                            'name'=>'pc_seniority',
                            'id'=>'pc_seniority',
                            'value'=>$pc_info->pc_seniority
                        )
                     );?>
                </p>
                <p><label class="field">Pc.Chức vụ : </label>
                    <?php echo form_input(array(
                        'name'=>'pc_position',
                        'id'=>'pc_position',
                        'value'=>$pc_info->pc_position
                    ));?>
                </p>
                <p><label class="field">Hỗ trợ xăng xe : </label>
				<?php echo form_checkbox('check_petrol', '1', $person_info->check_petrol == '' ? False : (boolean)$person_info->check_petrol);?> 
				</p>
                <p><label class="field">Hỗ trợ điện thoại : </label>
				<?php echo form_checkbox('check_phone', '1', $person_info->check_phone == '' ? False : (boolean)$person_info->check_phone);?> 
                </p>
                <p><label class="field" >Nhân viên KD : </label>
                    <input type="checkbox" name="dienthaoi_employees" value="0" id="input_check"></p>
                <div id="em_business">
                    <p><label class="field">Doanh số : </label>
                        <?php echo form_input(array(
                            'name'=>'emp_expense',
                            'id'=>'emp_expense',
                            'value'=>$person_info->emp_expense));?>
                    </p>
					<p><label class="field">Lương Cty Giữ : </label>
                        <?php echo form_input(array(
                            'name'=>'emp_deposit',
                            'id'=>'emp_deposit',
                            'value'=>$person_info->emp_deposit));?>
                    </p>
                </div>
        </div>
    </fieldset>
</div>