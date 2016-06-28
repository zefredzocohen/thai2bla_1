<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_affiliates_name').':', 'jobs_affiliates_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_affiliates_name',
                'id'=>'jobs_affiliates_name',
                'required'=>'',
                'value'=>$jobs_affiliates->jobs_affiliates_name)
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_affiliates_description').':', 'jobs_affiliates_description'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'jobs_affiliates_description',
                'id'=>'jobs_description',
                'value'=>$jobs_affiliates->jobs_affiliates_place,
                'rows'=>'5',
                'cols'=>'37')
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_report_date').':', 'jobs_status_date'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_affiliates_date',
                'id'=>'jobs_affiliates_date',
                'value'=>$jobs_affiliates->jobs_affiliates_date != '1950-01-01'? date(get_date_format(),strtotime($jobs_affiliates->jobs_affiliates_date  != '' ? $jobs_affiliates->jobs_affiliates_date : date('Y-m-d'))) : ''
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_regions_person_name').':', 'jobs_name'); ?>
        <select name='person_id' >
			<option value="">-- Chọn người quản lý --</option>
            <?php foreach($name_peron_info AS $key => $values): ?>
                <?php
                	if($values->person_id == $jobs_affiliates->person_id ){?>
                    	<option value="<?php echo $values->person_id;?>" selected="selected"><?php echo $values->first_name; ?></option>
              <?php } else{ 
	                	if( $values->person_id !=1 
	                		&& $this->Jobs_regions->get_region_id($values->person_id)->num_rows() == 0
	                		 && $this->Jobs_city->get_city_id($values->person_id)->num_rows() == 0
	                		  && $this->Jobs_affiliates->get_aff_id($values->person_id)->num_rows() == 0
	                		   && $this->Jobs_department->get_dep_id($values->person_id)->num_rows() == 0 
	                	){?>
                    <option value="<?php echo $values->person_id;?>"><?php echo $values->first_name; ?></option>
                <?php }
                	}
                endforeach; ?>
        </select>
    </div>
</div>

<!--<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php /*echo form_label(lang('common_city_regions_name').':', 'jobs_name',array('class'=>'')); */?>
        <select name='jobs_affiliates_status'  required="">
            <?php /*if($jobs_affiliates->jobs_affiliates_status == 1) {*/?>
              <option value="1" selected="selected"><?php /*echo lang('common_status_doing');*/?></option>
              <option value="0"><?php /*echo lang('common_status_end');*/?></option>
            <?php /*}else{*/?>
                 <option value="0" selected="selected"><?php /*echo lang('common_status_end');*/?></option>
                 <option value="1"><?php /*echo lang('common_status_doing');*/?></option>
            <?php /*}*/?>
        </select>
    </div>
</div>-->

<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_city_regions_name').':', 'jobs_name',array('class'=>'')); ?>
        <select name='jobs_regions_id' id='jobs_regions_id'  required="required" onclick="clickSendRegions()">
			<option value="">-- Chọn khu vực --</option>
            <?php foreach($regions_info AS $key => $values): ?>
                <?php if($values->jobs_regions_id == $city_regions->jobs_regions_id ){?>
                    <option value="<?php echo $values->jobs_regions_id;?>" selected="selected"><?php echo $values->jobs_regions_name; ?></option>
                <?php } else{ ?>
                    <option value="<?php echo $values->jobs_regions_id;?>"><?php echo $values->jobs_regions_name; ?></option>
                <?php }endforeach; ?>
        </select>
    </div>
</div>

<a href="<?php echo site_url('affiliates/loadCity/'.$jobs_affiliates->jobs_regions_id)?>" style="display: none" id="hrefview"></a>
<a href="<?php echo site_url('affiliates/loadAffiliates/'.$jobs_affiliates->jobs_regions_id)?>" style="display: none" id="showAffiliates"></a>
<script type="text/javascript">
    /*
    * Thực  hiện load toàn bộ thông tin khi ta thực hiên chọn select Khu vục
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
    * Thực hiện load thông tin khi chọn thành phố
    * */
    function clickSendCity()
    {
        var jobs_city_id = $("#jobs_city_id").val();
        var url = $("#showAffiliates").attr('href');
        $.post(url,{jobs_city_id:jobs_city_id},function(data,success){
            if(success){
                $(".clearfix_affiliates").html(data);
            }
        });
    }
</script>
<div class="action_show">
    <div class="field_row clearfix_city" style="border: none" id="status_module">
        <div class='form_field'>
            <?php echo form_label(lang('common_affiliates_city_name').':', 'jobs_name',array('class'=>'required')); ?>
            <select name='jobs_city_id' id='jobs_city_id' required="required" onclick="clickSendCity()">
				<option value="">-- Chọn thành phố --</option>
                <?php foreach($city_info AS $key => $values): ?>
                    <?php if($values->jobs_city_id == $jobs_affiliates->jobs_city_id ){?>
                        <option value="<?php echo $values->jobs_city_id;?>" selected="selected"><?php echo $values->jobs_city_name; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values->jobs_city_id;?>"><?php echo $values->jobs_city_name; ?></option>
                    <?php }endforeach; ?>
            </select>
        </div>
    </div>

    <div class="field_row clearfix_affiliates" style="border: none" id="status_module">
        <div class='form_field'>
            <?php echo form_label(lang('common_affiliates_parent').':', 'jobs_name',array('class'=>'')); ?>
            <select name='jobs_parent_id'>
				<option value="">-- Chọn chi nhánh --</option>
                <?php foreach($affiliates_parent AS $key => $values): ?>
                    <?php if($values->jobs_affiliates_id == $jobs_affiliates->jobs_affiliates_id ){?>
                        <option value="<?php echo $values->jobs_affiliates_id;?>" selected="selected"><?php echo $values->jobs_affiliates_name; ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $values->jobs_affiliates_id;?>"><?php echo $values->jobs_affiliates_name; ?></option>
                    <?php }endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_affiliates_color').':', 'jobs_name',array('class'=>'','style'=>'margin-left:3px;')); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_affiliates_color',
                'id'=>'jobs_affiliates_color',
                'type'=>'color',
                'style'=>'width:20px',
                'value'=>$jobs_affiliates->jobs_affiliates_color
            )
        )
        ;?>
    </div>
</div>

<style>
    fieldset div.field_row{
        border-bottom: none;
    }

    .field_row input{
        border: none;
        width: 150px;
        height: 15px;
    }
    .field_row select{
        height: 27px;
        padding: 0;
    }
    .field_row label{
        font-family: "Helvetica";
        font-size: 13px;
        display: inline-block;
    }
    #status_module input,textarea{
        width: 220px;
    }
    #status_module select{
        width: 232px;
    }

    #status_module label{
        float: left;
        display: inline-block;
        width: 120px;
    }

    fieldset div.field_row{
        border-bottom: none;
    }

    .field_row input{
        border: none;
        width: 150px;
        height: 15px;
    }
    .field_row select{
        height: 27px;
        padding: 0;
    }
    .field_row label{
        font-family: "Helvetica";
        font-size: 13px;
        display: inline-block;
    }
    label{
        float: left;
        display: inline-block;
        width: 150px;
    }
    #jobs_name{
        float: left;
        border: 1px solid #CCC;
        height: 27px;
        width: 325px;
        background-color: #F5F5F5;
    }
    #jobs_reports_result{
        width: 50px;
    }
    #jobs_reports_name{
        width: 313px;
    }
    .field_row #radio_result{
        position: relative;
        margin-left:  190px;
        list-style: none;
    }
    .field_row #radio_result li{
        float: left;
    }
    .field_row #radio_result li span{
        display: inline-block;
        font-weight: normal;
        font-size: 12px;
        float: left;
    }
    #jobs_reports_status{
        margin-left: -58px;
    }

    #radio_result{
        list-style: none;
    }

    #radio_result li{
        margin-left: -59px;
        margin-top: 5px;
    }

</style>



