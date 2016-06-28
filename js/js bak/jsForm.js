function get_selected_values()
{
    var selected_values = new Array();
    $("#sortable_table tbody :checkbox:checked").each(function(){
        selected_values.push($(this).val());
    });
    var a = $('#parent_id_hidden').attr('value',selected_values);
    //alert(a.val());
}
/*
*
* */
function get_selected_values_jobs()
{
    var selected_values = new Array();
    $("#sortable_table tbody :checkbox:checked").each(function(){
        selected_values.push($(this).val());
    });

    var a = $('#jobs_id_hidden').attr('value',selected_values);
    alert(a.val());
}

function get_selected_values_employees()
{
    var selected_values = new Array();
    $("#sortable_table_employees tbody :checkbox:checked").each(function(){
        selected_values.push($(this).val());
    });
   var a = $('#person_id_hidden').attr('value',selected_values);

    alert(a.val());
}

 function OpenPopup(name){
    window.open("http://localhost/phuongchinh/"+name," ",'width=1200,height=500');
}
function _alert(text)
{
    alert(text);
}
/********
 * Author : @SnguyenOne
 * Function: previousPage
 * Description: Th?c hi?n load l?i trang tr??c trang hi?n th?i
 * Param:
 * Return: previous of page
 * *********/
function previousPage(){
    window.history.back();
}
function hideForm()
{
    $('.select_jobs_parent').hide('500');
    $('.status_module_none').show('500');
    $('#table_insert').show('500');
}
function showForm()
{
    $('.status_module_none').hide('500');
    $('#table_insert').hide('500');
    $('.select_jobs_parent').show('500');
}
function hideEmployeeForm()
{
    $('.select_jobs_parent').hide('500');
    $('.status_module_none').show('500');
    $('#table_insert_employees').show('500');
}
function showEmployeeForm()
{
    $('.status_module_none').hide('500');
    $('#table_insert_employees').hide('500');
    $('.select_jobs_parent').show('500');
}

/**
 *  For employees
 * */
function sendJobsEmployees()
{
    $('#submit').click(function(){
        var startDate = $("#jobs_start_date").val();
        var endDate = $('#jobs_end_date').val();

        var start_date = parseDate(startDate).getTime();
        var end_date = parseDate(endDate).getTime();

        if(start_date >= end_date){
            _message('alert_error','Lưu ý ngày kết thúc dự án không được nhỏ hơn ngày bắt đầu dự án ');
            $('#jobs_end_date').focus();
        }else

            $.post(
                $("#jobs_employees").attr("action"),
                $("#jobs_employees :input").serializeArray(),
                function(data){
                    if(data == "true"){
                        _message('alert_success',data);
                        _location('jobs_employee');
                    }else{
                        _location('jobs_employee/view');
                    }
                }
            );

        $("#jobs_employees").submit( function () {
            return false;
        });
    });

}
/*
 * SEBF EMLOYEES_JOBS
 * */


function checkNameEmployees()
{
    if($('#jobs_name').val() == ''){
        $('#jobs_name').focus();
    }

    $('#jobs_name').change(function(){
        var url = $("#jobs_employees").attr("action");
        var job_name = $('#jobs_name').val() ;
        $.post(url,{jobs_name:job_name},function(data,success){
            $('#jobs_name').focus();
            _smallMessage('alert_warning',data);
        });
    });
}

function sendJobsProject()
{
    $('#submit').click(function(){
        var startDate = $("#jobs_start_date").val();
        var endDate = $('#jobs_end_date').val();

        var start_date = parseDate(startDate).getTime();
        var end_date = parseDate(endDate).getTime();

        if(start_date >= end_date){
            _message('alert_error','Lưu ý ngày kết thúc dự án không được nhỏ hơn ngày bắt đầu dự án ');
            $('#jobs_end_date').focus();
        }else

            $.post(
                $("#jobs_project").attr("action"),
                $("#jobs_project :input").serializeArray(),
                function(data){
                    if(data == "true"){
                        _message('alert_success',data);
                        _location('jobs_project');
                    }else{
                        _location('jobs_project/view');
                    }
                }
            );

        $("#jobs_project").submit( function () {
            return false;
        });
   });

}
/*
* SEBF EMLOYEES_JOBS
* */


function checkName()
{
    if($('#jobs_name').val() == ''){
        $('#jobs_name').focus();
    }

    $('#jobs_name').change(function(){
        var url = $("#jobs_project").attr("action");
        var job_name = $('#jobs_name').val() ;
        $.post(url,{jobs_name:job_name},function(data,success){
            $('#jobs_name').focus();
            _smallMessage('alert_warning',data);
        });
    });
}
// hide message

function _smallMessage(msg_type ,msg_text){
    $("#error").html('<h4 class="'+msg_type+'"><div class="message_top">'+msg_text+'</div></h4>').slideDown('slow').delay(3000).slideUp('slow');
}

function checkDate()
{
    $('#jobs_end_date').mouseleave(function(){
        var a = $('#jobs_start_date').val();
        var b = $('#jobs_end_date').val();

        var c = parseDate(a).getTime();
        var d = parseDate(b).getTime();

        if(c >= d){
            //$('#jobs_end_date').focus();
            _message('alert_error','Lưu ý ngày kết thúc công việc không được nhỏ hơn ngày bắt đầu công việc của bạn ');


        }
    });
}

function _location(name){
    window.location = 'index.php/'+name;
}
function _message(msg_type ,msg_text){
    $("#warning").html('<h4 class="'+msg_type+'">'+msg_text+'</h4>').slideDown('slow').stop(1000).delay(3000).slideUp('slow');
}
function parseDate(str) {
    var mdy = str.split('-');
    return new Date(mdy[2], mdy[1], mdy[0]);
}
function previousPage(){
    window.history.back();
}
