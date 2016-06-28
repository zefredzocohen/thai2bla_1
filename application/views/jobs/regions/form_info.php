<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_regions_name').':', 'jobs_regions_name',array('class'=>'required')); ?>
    <div class='form_field'>
        <?php echo form_input(array(
                'name'=>'jobs_regions_name',
                'id'=>'jobs_regions_name',
                'required'=>'',
                'value'=>$jobs_regions->jobs_regions_name)
        );?>
    </div>
</div>

<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_regions_description').':', 'jobs_regions_description'); ?>
    <div class='form_field'>
        <?php echo form_textarea(array(
                'name'=>'jobs_regions_description',
                'id'=>'jobs_description',
                'value'=>$jobs_regions->jobs_regions_description,
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
                'name'=>'jobs_regions_date',
                'id'=>'jobs_regions_date',
                'value'=>$jobs_regions->jobs_regions_date != '1950-01-01'? date(get_date_format(),strtotime($jobs_regions->jobs_regions_date  != '' ? $jobs_regions->jobs_regions_date : date('d-m-Y'))) : ''
            )
        )
        ;?>
    </div>
</div>

<div class="field_row clearfix" style="border: none" id="status_module">
    <div class='form_field'>
        <?php echo form_label(lang('common_regions_person_name').':', 'jobs_name' ); ?>
        <select name='person_id' >
			<option value=''>-- Chọn người quản lý --</option>
            <?php foreach($name_peron_info AS $key => $values): ?>
                <?php
                	if($values->person_id == $jobs_regions->person_id ){?>
			                    <option value="<?php echo $values->person_id;?>" selected="selected"><?php echo $values->first_name; ?></option>
			  <?php } else{
	                	if( $values->person_id !=1 
	                		&& $this->Jobs_regions->get_region_id($values->person_id)->num_rows() == 0
	                		 && $this->Jobs_city->get_city_id($values->person_id)->num_rows() == 0
	                		  && $this->Jobs_affiliates->get_aff_id($values->person_id)->num_rows() == 0
	                		   && $this->Jobs_department->get_dep_id($values->person_id)->num_rows() == 0 
	                	){ ?>
			                <option value="<?php echo $values->person_id;?>"><?php echo $values->first_name; ?></option>
			       <?php }
                	}
			    endforeach; 
                		
                ?>
        </select>
    </div>
</div>



<div class="field_row clearfix" id="status_module">
    <?php echo form_label(lang('common_jobs_regions_color').':', 'jobs_regions_color'); ?>
    <div class='form_field'>
        <?php
        echo form_input(array(
                'name'=>'jobs_regions_color',
                'id'=>'jobs_regions_color',
                'type'=>'color',
                'style'=>'width:13px;height:13px',
                'value'=>$jobs_regions->jobs_regions_color
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
    #status_module input{
        height: 15px;
    }
    #status_module input,textarea{
        width: 220px;
    }
    #status_module select{
        width: 232px;
        padding: 0px;
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


<script type='text/javascript'>

    $(document).ready(function()
    {
        $('#jobs_regions_date').datePicker({startDate: '01-01-1960'});
    });
</script>


