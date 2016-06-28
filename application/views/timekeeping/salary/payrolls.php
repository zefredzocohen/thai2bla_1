<?php $this->load->view("partial/header"); ?>
<style type="text/css">
    #main_content{
        min-width: 2200px!important;
        width: auto;
        overflow: hidden;
        background: #F9F9F9;
        border: 1px solid #EEE9E9;
        box-shadow: 0 0 0 1px #f5f5f5;
        margin-top: 15px;
        padding:0 0 150px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        color: #000!important;
        margin-left: 50px;
    }
    table#paypolls {
        border: 1px solid #333;
        border-top: none;
        border-left: none;
        background: #FFFFFF;
       /* overflow: hidden;*/
    }
    table#paypolls tr{
        border: 1px solid #333;
        font-size: 12px;
        font-weight: bold;
        color: #000!important;
    }
    table#paypolls tr td input{
        display: none;
    }
    table#paypolls tr td{
        border: 1px solid #333;
        text-align: center;
        min-width: 60px;
        height: 15px;
        padding: 5px;
        border-right: none;
        border-bottom: none;
    }
    #main_content .field_select {
        width: 300px;
        margin: 8px 20px;
        overflow: hidden;
        display: block;
        height: 30px;
        line-height: 27px;
    }
    #main_content .field_select select{
        float: left;
        width: 90px;
        margin-top: 4px ;
        height: 22px;
        font-size: 12px;
        color: #000;
        border: 1px inset #F5F5F5;
    }
    #main_content .field_select label{
        width: 84px;
        display: inline-block;
        font-size: 13px;
        font-weight: bold;
        float: left;
    }
    #number_one td{
        color: #070707;
    }
    #main_content .min-company{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
        text-decoration: underline;
        text-transform: uppercase;
        font-weight: bold;
        margin: 30px 0 0 70px;
        display: inline-block;
    }
    #main_content #manager_salary_one{
        margin-left: 930px;
        margin-top: 1px;
        height: 100px;
        width: 400px;
        padding: 5px;
        font-family: 'Times New Roman';
        font-size: 14px;
    }
    #main_content .salary_info span.date{
        color: red;
    }

    #main_content #span_one{
        width: 250px;
        display: inline-block;
        height: 109px;
        margin-top: 15px;
        padding: 5px;
    }
    #main_content #report_button,#report_button_manager{
        margin-left: 55%;
        margin-top: 5px;
        height: 30px;
        width: 150px;
        background: cornflowerblue;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    #main_content #report_button:hover,#report_button_manager:hover{
        text-decoration: underline;
    }
</style>
<body>
<div id="main_content">
    <?php  $date = explode('-',date('d-m-Y')); ?>
    <div style="margin-bottom: 50px;margin-top: 50px">
        <div style="text-align:center; font-weight:bold; font-size:20px;height: 50px;margin-top: -15px;width: 80%">BẢNG TỔNG KẾT LƯƠNG THÁNG <span class="month_name" style="color: red"><?php echo $date[1]; ?></span> NĂM <span class="year_name" style="color: red"><?php echo $date[0] ?></span></div>
        <div style="text-align:center; font-size:14px;font-style:italic;height: 20px;margin-top: -15px;margin-bottom: 8px;width: 80%">Bộ phận : Kế toán</div>
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

    <div class="field_select department" style="margin-top: -37px;margin-left: 281px;">
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
    <form accept-charset="UTF-8" method="POST" id="formSalary" action="<?php echo site_url('timekeeping/saveSalary/')?>" >
    <table id="paypolls" width="1000" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="2" style="background:#99cc00">STT</td>
            <td rowspan="2" style="background:#99cc00"><div style="width:150px">Họ tên</div></td>
            <td colspan="7" style="background:#ffc000;text-align: center"><div align="center" style="text-align:center;width: 250px">Lương cơ bản</div></td>
            <td colspan="9" style="background:#b2a1c7"><div align="center" style="width: 500px">Các khoản phụ cấp phúc lợi và khen thưởng</div></td>
            <td rowspan="2" style="background:#fac090">BHXH</td>
            <td rowspan="2" style="background:#99cc00">Tổng lương thực tế</td>
            <td rowspan="2" style="background:#99cc00">Số tiền nợ lương kỳ trước</td>
            <td rowspan="2" style="background:#99cc00">Số tiền công ty tạm giữ 15% kinh doanh + KT</td>
            <td rowspan="2" style="background:#99cc00">Số tiền tạm ứng</td>
            <td rowspan="2" style="background:#99cc00">Tổng tiền thực lĩnh</td>
            <td rowspan="2" style="background:#00b050">Thực tế thanh toán</td>
            <td rowspan="2" style="background:#9bbb59">Số nợ lương </td>
            <td rowspan="2" style="background:#ffff00">Dự tính thanh toán đợt 1</td>
            <td rowspan="2" style="background:#ffff00">Dự tính thanh toán đợt 2</td>
            <td rowspan="2" style="background:#ff0000">Khoản hoàn ứng thu lại</td>
        </tr>
        <tr>
            <td  style="background:#ffc000">Mức lương</td>
            <td  style="background:#ffc000">Mức lương BH</td>
            <td  style="background:#ffc000">Ngày công</td>
            <td  style="background:#ffe45c">Giờ công làm thêm hưởng <?php echo $salary_option->percent_overtime_weekdays ?>%</td>
            <td  style="background:#0099FF">Giờ công làm thêm hưởng <?php echo $salary_option->percent_overtime_sunday ?>%</td>
            <td  style="background:#F5F5F5">Giờ công làm thêm hưởng <?php echo $salary_option->percent_overtime_holiday ?>%</td>
            <td  style="background:#ffc000">Tổng LCB</td>
            <td  style="background:#b2a1c7">PC ăn trưa</td>
            <td  style="background:#b2a1c7">Phụ cấp thâm niên</td>
            <td  style="background:#b2a1c7">PC chức vụ</td>
            <td  style="background:#b2a1c7">Thưởng dự án</td>
            <td  style="background:#b2a1c7">Hỗ trợ bảo dưỡng máy tính</td>
            <td  style="background:#b2a1c7">PC Xăng xe</td>
            <td  style="background:#b2a1c7">PC Điện thoại</td>
            <td  style="background:#b2a1c7">Hỗ trợ thưởng khác</td>
            <td  style="background:#b2a1c7">Tổng</td>
        </tr>

        <a href="<?php echo site_url('timekeeping/payrolls/')?>" style="display: none" id="sendLoad"></a>
        <a href="<?php echo site_url('timekeeping/loadSalary/')?>" style="display: none" id="sendOne"></a>
        <a href="<?php echo site_url('timekeeping/getAllSalarystatic/')?>" style="display: none" id="sendLoadAll"></a>
        <a href="<?php echo site_url('timekeeping/updateTable/')?>" style="display: none" id="updateTable"></a>
        <a href="<?php echo site_url('timekeeping/getEmployees/')?>" style="display: none" id="loadEmployees"></a>
        <a href="<?php echo site_url('timekeeping/ saveComment/')?>" style="display: none" id="saveComment"></a>

        <script type="text/javascript">
                $(document).ready(function(){
                var url = $("#sendOne").attr('href');
                var url_load = $("#sendLoad").attr('href');
                var year = $('.year_info').val();
                var month = $('.month_info').val();
                        $.post(url,{year:year,month:month},function(data,success){
                            if(success){
                                $("#tb-timekeeping-contaner").html(data);
                                $(".month_name").html(month);
                                $(".year_name").html(year);
                            }
                        });


                sendJobsProject();
                sendDuyetLai();

            });
            function getMonth()
            {
                var url = $("#sendOne").attr('href');
                var year = $('.year_info').val();
                var month = $('.month_info').val();
                var url_load = $("#sendLoad").attr('href');
                $.post(url_load,{year:year,month:month},function(data,success){
                });
                $.post(url,{year:year,month:month},function(data,success){
                    if(success){
                        $("#tb-timekeeping-contaner").html(data);
                        $(".month_name").html( month);
                        $(".year_name").html( year);
                    }
                });

            }
            function getYear()
            {
                var url = $("#sendOne").attr('href');
                var year = $('.year_info').val();
                var month = $('.month_info').val();
                var url_load = $("#sendLoad").attr('href');
                $.post(url_load,{year:year,month:month},function(data,success){
                });
                $.post(url,{year:year,month:month},function(data,success){
                    if(success){
                        $("#tb-timekeeping-contaner").html(data);
                        $(".month_name").html( month);
                        $(".year_name").html( year);
                    }
                })
            }
            function getDepartment()
            {
                var url = $("#sendOne").attr('href');
                var year = $('.year_info').val();
                var month = $('.month_info').val();
                var department_id = $(".department_id").val();
                var urlEmployees = $("#loadEmployees").attr('href');
                var url_load = $("#sendLoad").attr('href');
                $.post(url_load,{year:year,month:month},function(data,success){
                });
                $.post(url,{year:year,month:month,department_id:department_id},function(data,success){
                    if(success){
                        $("#tb-timekeeping-contaner").html(data);
                        $(".month_name").html( month);
                        $(".year_name").html( year);
                    }
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
                var url_load = $("#sendLoad").attr('href');
                $.post(url_load,{year:year,month:month},function(data,success){
                });
                $.post(url,{year:year,month:month,department_id:department_id,employees_id:employees_id},function(data,success){
                    if(success){
                        $("#tb-timekeeping-contaner").html(data);
                        $(".month_name").html( month);
                        $(".year_name").html( year);
                    }
                });
            }
            function sendJobsProject()
            {
                $('#report_button').click(function(){
                    var  url = $("#formSalary").attr("action");
                    var year = $('.year_info').val();
                    var month = $('.month_info').val();
                    $('.month_salary').attr('value',month);
                    $('.year_salary').attr('value',year);
                    $.post(
                        url,
                        $("#formSalary :input").serializeArray(),
                        function(data,success){
                            if(success){
                                if(data == '1'){
                                    alert("Bảng lương đã được duyệt thành công !");
                                    $('.thong_tin_phe_duyet').css('margin-top','-50px');
                                    $('.info_month_one').css('margin-top','-50px');
                                }else if(data == '3'){
                                    alert("Yêu cầu lập lại bảng lương đã được xác nhận thành công !");
                                }else{
                                    alert("Bảng lương tháng đã được lập và đang chờ được phê duyệt !");
                                }

                            }
                        }
                    );
                    $("#formSalary").submit( function () {
                        return false;
                    });
                });

            }

            function sendDuyetLai()
            {
                $('#report_button_lap_bang').click(function(){
                    /*var  url = $("#formSalary").attr("action");
                    var year1 = $('.year_info').val();
                    var month1 = $('.month_info').val();
                    var month = $('.month_salary').attr('value',month1).val();
                    var year = $('.year_salary').attr('value',year1).val();*/
                 /*  $.post(
                       url,{year:year,month:month},
                        function(data,success){
                            if(success){
                                alert(data)

                            }
                       }
                    );*/
                    //alert(1);
                });

            }
        </script>

            <tbody id="tb-timekeeping-contaner">
                <tr class="tb-timekeeping-contaner">
                </tr>
            </tbody>

    </table>
        <?php
        if($person_id == 1){ ?>
            <div id="manager_salary_one">
                <?php if($manager_info->status == 0) {?>
                    <input type="submit" name="submit_manager" id="report_button" value=" Phê duyệt" />
                   <!-- <button type="button" name="reset_manager" id="report_button" >Không duyệt</button>-->
                <?php }else{ ?>
                    <input type="submit" name="reset_manager" id="report_button_2" value="Duyệt lại" />
                <?php }?>
                </br>
                <div id="salary_textarea" style="margin: 50px 0 0 110px">
                    <label>Nhận xét/Đánh giá :</label><br/><br/>
                    <textarea name="comment_manager" id="comment_manager" style="height: 100px;width: 250px;padding: 5px"><?php echo $manager_info->comment_manager ?></textarea>
                </div>
            </div>

        <?php }else{ ?>
            <div id="manager_salary_one">
                <?php if($manager_info->status == 0) {?>
                    <input type="button" name="report_button" id="report_button" value="Lập bảng lương" />
                    </br>
                    <div id="salary_textarea" style="margin: 50px 0 0 110px;">
                        <label>Nội dung báo cáo: </label><br/><br/>
                        <textarea name="comment_manager" id="comment_manager" style="height: 100px;width: 250px;padding: 5px"><?php echo $manager_info->comment ?></textarea>
                    </div>
                <?php }else{ ?>
                    <button type="" name="" id="" disabled="disabled" style="width: 220px;height: 30px;margin:58px 0 0 154px" >Bảng lương đã được duyệt</button>
                    </br>
                    <div id="salary_textarea" style="margin: 50px 0 0 110px;">
                        <label>Nội dung báo cáo: </label><br/><br/>
                        <textarea name="comment_manager" id="comment_manager" disabled="disabled" style="height: 100px;width: 250px;padding: 5px"><?php echo $manager_info->comment ?></textarea>
                    </div>
                <?php } ?>
            </div>
        <?php }?>

    </form>
   <div class="salary_info">
      <div class="info_month_one" style="text-align:left; font-size:14px;font-weight:500;padding-left: 10px;height: 18px;float:left;margin-top: -80px;font-family: 'Times New Roman'">
          <div> - Chi lương qua ngân hàng</div>
          <div> - Thực tế lương phải trả tháng <span class="month_name"></span></div>
      </div>
       <?php
            if($person_id == 1){ ?>
                <?php $date_manager = explode('-',$manager_info->date_parent); ?>
                <div class="thong_tin_phe_duyet" style="margin-left:400px; font-size:14px;font-weight:500; width:400px; float:left;margin-top: -80px;font-family: 'Times New Roman'">
                    <div>Hà Nội, Ngày lập <span class="date"> <?php echo $date_manager[2] ?> </span>Tháng <span class="date"><?php echo $date_manager[1] ?></span> Năm <span class="date"> <?php echo $date_manager[0] ?><span></div>
                    <div style="text-indent: 50px">Người lập bảng</div>
                    <div style="text-indent: 40px;font-size: 14px;font-weight: bold;margin-top: 5px"><?php echo $parent_name->first_name ?></div>
                    <div id="span_one">
                        <label>Nội dung báo cáo :</label><br/><br/>
                        <span style="border: 1px solid #CCC;padding: 5px;height: 100px;width: 250px;display: inline-block"><?php echo $manager_info->comment; ?></span>
                    </div>

                </div>
            <?php }else{ ?>
                <?php $date_manager = explode('-',$manager_info->date_parent_manager); ?>
                <div class="thong_tin_phe_duyet" style="margin-left:400px; font-size:14px;font-weight:500; width:400px; float:left;margin-top: -50px;font-family: 'Times New Roman'">
                    <div>Hà Nội, Ngày lập <span class="date"> <?php echo $date_manager[2] ?> </span>Tháng <span class="date"><?php echo $date_manager[1] ?></span> Năm <span class="date"> <?php echo $date_manager[0] ?><span></div>
                    <div style="text-indent: 50px">Người phê duyệt : </div>
                    <div style="text-indent: 40px;font-size: 14px;font-weight: bold;margin-top: 5px"><?php echo $manager_name->first_name ?></div>
                    <div id="span_one">
                        <label>Nhận xét/Đánh giá :</label><br/><br/>
                        <span style="border: 1px solid #CCC;padding: 5px;height: 100px;width: 250px;display: inline-block"><?php echo $manager_info->comment_manager;  ?></span>
                    </div>
                </div>
            <?php }
       ?>
   </div>

</div>
</body>
</html>
