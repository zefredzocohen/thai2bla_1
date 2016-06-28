<?php $this->load->view("partial/header"); ?>

<meta charset="UTF-8">
<div style="height:200px;">
<style type="text/css">
    .header-timekeeping{
        width: 100%;
        overflow:  hidden;
        float:left;
        font-weight: bold;
        padding: 10px 20px 40px 20px;
    }
    .min-company{
        font-size: 16px;
        width: 200px;
        float:left;
        text-decoration: underline;
        text-transform: uppercase;
        margin-top: 35px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .max-company {
        font-size: 18px;
        width: 1000px;
        text-align: center;
        text-transform: uppercase;
        margin-left: 400px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .max-company p{
        text-align: center;
        float:left;
        font-family: Arial, Helvetica, sans-serif;
    }

	#table_timekeeping .tb-timekeepingtr{
        background: #006699;
	    border-right: 1px solid #F7F7F7;
		color: #FFFFFF;
		text-align: left;
	}
    #table_timekeeping  .tb-timekeepingtr td{
        padding: 0 5px;
        text-align: center;
        border:thin #CCC 1px;
    }
    .field_select label{
        color: #000!important;
    }
    #table_timekeeping .tb-timekeeping label{
		padding-left:10px;
	}
    #table_timekeeping .tb-timekeeping-contaner td
	{
		background-color: #F7F7F7;
        border-right: 1px solid #FFF;
        border-top: 1px solid #FFF;
        border-bottom: none;
        border-left: none;
		color: #333!important;
		padding: 0 10px;
		vertical-align: middle;
	}
    #table_timekeeping .title-timekeeping{
		padding:0 10px;
		float:left;
		line-height:28px;
	}
    #table_timekeeping {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    #table_timekeeping tr{
        border-right: 1px solid #F5F5F5;
        border-top: 1px solid #F5F5F5;
        border-bottom: none;
        border-left: none;
    }
    #table_timekeeping tr td{
        border-right: 1px solid #F5F5F5;
        border-top: 1px solid #F5F5F5;
        border-bottom: none;
        border-left: none;
    }

    #tb-timekeeping-contaner tr td{
        height: 30px;
        border-right: 1px solid #CCC;
        border-top: 1px solid #CCC;
        border-bottom: none;
        border-left: none;
    }
    #tb-timekeeping-contaner tr td select{
        color: #333!important;
        font-size: 11px;
        height: 23px;
        border: 1px solid #DDDBD2;
        text-align: center;
    }
    #tb-timekeeping-contaner tr td select option{
        padding-top: 5px;
        height: 20px;
        border: 1px dotted #f5f5f5;
        text-align: left;
    }
    #item_basic_info .field_select {
        width: 300px;
        margin: 8px 20px;
        overflow: hidden;
        display: block;
        height: 30px;
        line-height: 27px;
    }


    #item_basic_info .field_select select{
        float: left;
        width: 90px;
        margin-top: 2px ;
        height: 22px;
        font-size: 12px;
        color: #000!important;
        border: 1px inset #F5F5F5;
        cursor: pointer;
    }
    #item_basic_info .field_select label{
        width: 120px;
        display: inline-block;
        font-size: 13px;
        font-weight: bold;
        float: left;
    }

</style>
<!--<script type="text/javascript" src="<?php /*echo base_url()*/?>js/jquery-1.10.1.min.js"></script>-->
<fieldset id="item_basic_info" style="margin-left: 48px">
<div class="header-timekeeping">
    <?php  $date = explode('-',date('d-m-Y')); ?>
    <div class="max-company " style="text-align:center; font-weight:bold; font-size:20px;height: 30px;color: #555!important;padding-top: 30px">BẢNG  CHẤM CÔNG THÁNG <span class="month_name" style="color: red"><?php echo $date[1]; ?></span> NĂM <span class="year_name" style="color: red"><?php echo $date[0] ?></span></div>
</div>

  <div class="field_select year_select">
        <?php echo form_label(lang('common_select_month').':', 'salarystatic_date'); ?>
        <div class='form_field'>
            <select name="month_info" class="month_info" required="required"  onchange="getMonth();" >
                <?php
                $date = explode('-',date('d-m-Y'));
                for($i = 1 ;$i <= 12; $i++){
                    if($i == $date['1']){?>
                        <option value="<?php echo $i; ?>" selected="selected"><?php echo 'Tháng '.$i ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $i; ?>"><?php echo 'Tháng '.$i ?></option>
                    <?php }
                    ?>

                <?php } ?>
            </select>
        </div>
    </div>

    <div class="field_select year_select">
        <?php echo form_label(lang('common_select_year').':', 'salarystatic_date'); ?>
        <div class='form_field'>
            <select name="selName" class="year_info" required="required" onchange="getYear();">
                <?php
                $date = explode('-',date('d-m-Y'));
                for($i = 2010 ;$i <= 2020; $i++){
                    if($i == $date[0] ){?>
                        <option value="<?php echo $i; ?>" selected="selected"><?php echo 'Năm '.$i ?></option>
                    <?php } else{ ?>
                        <option value="<?php echo $i; ?>"><?php echo 'Năm '.$i ?></option>
                    <?php }
                } ?>
            </select>
        </div>
    </div>

    <div class="field_select" style="float: left;margin-top: -77px;margin-left: 281px;">
        <?php echo form_label('Chọn phòng ban '.':', 'salarystatic_date'); ?>
        <div class='form_field'>
             <select name="department_id" style="width: 150px" class="department_id"  onchange="getDepartment();" >
                 <option value="" style="display: none"> -- Chọn phòng ban -- </option>
                    <?php foreach ($department_info AS $key => $values){ ?>
                             <option value="<?php echo $values->department_id ; ?>"><?php echo $values->department_name ?></option>
                    <?php } ?>
             </select>
        </div>
    </div>

    <div class="field_select department" style="float: left;margin-top: -37px;margin-left: 281px;">
        <?php echo form_label('Chọn nhân viên '.':', 'salarystatic_date'); ?>
        <div class='form_field form_employees'>
            <select name="employees_id" style="width: 150px" class="employees_id"  onchange="getEmployees();" >
                <option value="" style="display: none"> -- Chọn nhân viên -- </option>
                <?php foreach ($employees_info AS $key => $values){ ?>
                    <option value="<?php echo $values->person_id ; ?>"><?php echo $values->first_name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

<a href="<?php echo site_url('timekeeping/loadDefault/')?>" style="display: none" id="loadDefault"></a>
<a href="<?php echo site_url('timekeeping/getAllThu/')?>" style="display: none" id="loadThu"></a>
<a href="<?php echo site_url('timekeeping/getEmployees/')?>" style="display: none" id="loadEmployees"></a>
<a href="<?php echo site_url('timekeeping/loadUpdate/')?>" style="display: none" id="sendLoad"></a>
<a href="<?php echo site_url('timekeeping/loadUpdate/')?>" style="display: none" id="sendOne"></a>
<a href="<?php echo site_url('timekeeping/getAllSalarystatic/')?>" style="display: none" id="sendLoadAll"></a>

<script type="text/javascript">
    $(document).ready(function(){
        var url = $("#loadDefault").attr('href');
        var year = $('.year_info').val();
        var month = $('.month_info').val();
        var url_day = $("#loadThu").attr('href');
        $.post(url,{year:year,month:month},function(data,success){
            if(success){
                $("#tb-timekeeping-contaner").html(data);
                $(".month_name").html( month);
                $(".year_name").html( year);
            }
        });
        $.post(url_day,{month:month,year:year},function(data,success){
            $(".day_of_week").html(data);
        });
    });

    function getMonth()
    {
        var url = $("#sendOne").attr('href');
        var url_day = $("#loadThu").attr('href');
        var year = $('.year_info').val();
        var month = $('.month_info').val();

        $.post(url,{year:year,month:month},function(data,success){
            if(success){
                $("#tb-timekeeping-contaner").html(data);
                $(".month_name").html( month);
                $(".year_name").html( year);
            }
        });
        $.post(url_day,{month:month,year:year},function(data,success){
            $(".day_of_week").html(data);
        });
    }

    function getYear()
    {
        var url = $("#sendOne").attr('href');
        var year = $('.year_info').val();
        var month = $('.month_info').val();
        var url_day = $("#loadThu").attr('href');

        $.post(url,{year:year,month:month},function(data,success){
            if(success){
                $("#tb-timekeeping-contaner").html(data);
                $(".month_name").html( month);
                $(".year_name").html( year);
            }
        });
        $.post(url_day,{month:month,year:year},function(data,success){
            $(".day_of_week").html(data);
        });
    }
    function getDepartment()
    {
        var url = $("#sendOne").attr('href');
        var year = $('.year_info').val();
        var month = $('.month_info').val();
        var department_id = $(".department_id").val();
        var url_day = $("#loadThu").attr('href');
        var urlEmployees = $("#loadEmployees").attr('href');

        $.post(url,{year:year,month:month,department_id:department_id},function(data,success){
            if(success){
                $("#tb-timekeeping-contaner").html(data);
                $(".month_name").html(month);
                $(".year_name").html(year);
            }
        });
        $.post(url_day,{month:month,year:year},function(data,success){
            $(".day_of_week").html(data);
        });
        $.post(urlEmployees,{department_id:department_id},function(data,success){
            $(".form_employees").html(data);
        });
    }

    function getEmployees()
    {
        var url = $("#sendOne").attr('href');
        var year = $('.year_info').val();
        var month = $('.month_info').val();
        var department_id = $(".department_id").val();
        var employees_id = $(".employees_id").val();
        var url_day = $("#loadThu").attr('href');

        $.post(url,{year:year,month:month,department_id:department_id,employees_id:employees_id},function(data,success){
            if(success){
                $("#tb-timekeeping-contaner").html(data);
                $(".month_name").html(month);
                $(".year_name").html(year);
            }
        });
        $.post(url_day,{month:month,year:year},function(data,success){
            $(".day_of_week").html(data);
        });

    }
</script>
    <table id="table_timekeeping" width="1000" cellpadding="0" cellspacing="0">
      <tr class="tb-timekeepingtr">
        <td rowspan="2">STT</td>
        <td rowspan="2"><div style="width: 50px">Mã NV</div></td>
        <td rowspan="2"><div style="width: 150px">Họ và tên</div></td>
        <td rowspan="2"><div style="width: 90px">Ngày bắt đầu</div></td>
        <td rowspan="2"><div style="width: 90px">Ngày ký HĐLĐ</div></td>
        <td rowspan="2" ><div style="width: 150px">Đối tượng</div></td>
        <td height="31" colspan="31">Các ngày trong tháng</td>
        <td rowspan="2">Ngày công &quot;X&quot;</td>
        <td rowspan="2">Làm ca &quot;C&quot;</td>
        <td rowspan="2">Nghỉ phép năm &quot;P&quot;</td>
        <td rowspan="2">Nghỉ kết hôn &quot;K&quot;</td>
        <td rowspan="2">Nghỉ tang lễ &quot;T&quot;</td>
        <td rowspan="2">Nghỉ ngày lễ &quot;L&quot;</td>
        <td rowspan="2">Nghỉ ngày lễ &quot;NB&quot;</td>
        <td rowspan="2">Tổng số ngày đi làm hưởng lương bình thường</td>
        <td rowspan="2">Tổng số ngày đi làm hương lương (150%)</td>
        <td rowspan="2">Tổng số ngày đi làm hương lương (200%)</td>
        <td rowspan="2">Tổng số ngày đi làm hương lương (300%)</td>
        <td rowspan="2">Công tác hoặc đi học &quot;H&quot;</td>
        <td rowspan="2">Nghỉ thai sản &quot;TS&quot;</td>
        <td rowspan="2">Nghỉ ốm hưởng lương BHXH &quot;O&quot;</td>
        <td rowspan="2">Nghỉ không lương &quot;KL&quot;</td>
        <td rowspan="2">Lũy kế  phép đến thời điểm tháng trước</td>
        <td rowspan="2">Tổng ngày phép có trong năm</td>
        <td rowspan="2">Số phép còn lại</td>
        <td rowspan="2">Lũy kế  phép đến thời điểm tháng hiện tại</td>
        <td rowspan="2">Ghi chú</td>
      </tr>

        <tr class="day_of_week tb-timekeepingtr">
            <?php
                for($i=1;$i<=31;$i++){
                    if($i<=9) $i = '0'.$i;
                    echo "<td>$i</td>";
                }
            ?>
        </tr>
        <tbody id="tb-timekeeping-contaner">
            <tr class="tb-timekeeping-contaner" >
                <?php
                for($i=1;$i<= 57;$i++){
                    echo "<td>&nbsp;</td>";
                }
                ?>
            </tr>
      </tbody>
    </table>
</div>
