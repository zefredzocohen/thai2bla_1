<form action="<?php echo base_url()?>jobs_employee/save/<?php echo $employees_jobs_id->employees_jobs_id ?>" id="jobs_project" method="POST" enctype="multipart/form-data" />
<ul id="warning"></ul>

<fieldset style="border: none">
    <?php if(empty($jobs_info->jobs_id)){
    $this->load->view("jobs/employees/form_info_insert");
} else {
    $this->load->view("jobs/employees/form_info_update"); }
?>

</fieldset>
</form>

<div id="table_insert" style="background: none;display: block;min-height: 200px;height:auto;bottom: 1220px;width: 97%;border-bottom:1px dotted #F5F5F5;">
    <div class="field_row clearfix insert_info" id="status_module">
        <label style="color: #009900;font-size: 15px;padding-left: 13px;display: block"><?php echo lang('common_jobs_name_manager_project_label')?>:</label>
        <div class='form_field' style="background: none">
            <?php echo form_open("$controller_name/search",array('id'=>'search_form','style'=>'background:none')); ?>
            <input type="text" name ='search' id='search'/>
            <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
            </form>
        </div>
    </div>
    <table id="contents" class="show_insert" style="position: absolute;">
        <tr>
            <td>
                <div id="item_table">
                    <div id="table_holder">
                        <?php echo $manage_table; ?>
                    </div>
                </div>

            </td>
        </tr>
    </table>
</div>

<div id="table_insert_employees" style="background-image: none;display: block;left:7px;min-height: 200px;height: auto;bottom: 1147px;position: relative;border-bottom:1px dotted #F5F5F5; ">
    <div class="field_row clearfix insert_info" id="status_module">
        <label style="color: #009900;font-size: 15px;padding-left: 13px;display: block;"><?php echo lang('common_jobs_name_manager_employees_label')?>:</label>
    </div>
    <table id="contents" class="show_insert" style="position: absolute;">
        <tr>
            <td>
                <div id="item_table">
                    <div id="table_holder">
                        <?php echo $manage_table_employees; ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
   $(document).ready(function()
    {
        var table_columns = ['','jobs_name','first_name','jobs_start_date','jobs_end_date','jobs_important'];
        enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
        enable_search('<?php echo site_url("$controller_name/suggest_manager");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
        enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
        get_selected_values_jobs();
        get_selected_values_employees();
        $('#employees_jobs_date').datePicker({startDate: '01-01-1960'});

        checkName();
        sendSearch();
        sendJobsEmployeesProject();

    });
    function sendSearch()
    {
        $("#search").change(function(){
            var search = $("#search").val();
            var url = $("#search_form").attr('action');

            $.post(url,{search:search},function(data,success){
                if(success){
                    var getData = $.parseJSON(data);
                   $('#sortable_table').text('');
                    $(getData.manage_table).appendTo('#sortable_table');
                    $(getData.pagination).appendTo('#pagination');
                }
            });
        });

    }
    function sendEmployeesSearch()
    {
        $("#search_employees").change(function(){
            var search = $("#search_employees").val();
            var url = $("#search_form_employees").attr('action');
            var table_columns = ['','first_name'];


            $.post(url,{search_employees:search},function(data,success){
                /*if(success){
                    var getData = $.parseJSON(data);
                    $('#sortable_table_employees').text('');
                    $(getData.manage_table).appendTo('#sortable_table_employees');
                    $(getData.pagination).appendTo('#pagination');
                }*/
              //  alert(data);

            });
        });
    }
</script>
<link src="<?echo base_url()?>css/indexJobs.css" rel="stylesheet" type="text/css" />



