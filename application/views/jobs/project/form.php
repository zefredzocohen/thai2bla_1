<div id="content_area_wrapper">
<div id="content_area">
<form action="<?php echo base_url()?>jobs/save/<?php echo $jobs_info->jobs_id ?>" id="jobs_project" method="POST" enctype="multipart/form-data" />
<ul id="warning"></ul>
<fieldset style="border: none">
    <?php if(empty($jobs_info->jobs_id)){ ?>
         <?php $this->load->view("jobs/project/form_info_insert"); ?>
    <?php } else {?>
        <?php $this->load->view("jobs/project/form_info_update"); }?>

</fieldset>
</form>

<div id="table_insert" style="display: none">
    <div class="field_row clearfix insert_info" id="status_module">
        <?php echo form_label(lang('common_jobs_parent').':', 'jobs_name',array('class'=>'')); ?>
        <div class='form_field'>
            <?php echo form_open("$controller_name/search_insert",array('id'=>'search_form')); ?>
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
</div></div>
<script type="text/javascript">
    $(document).ready(function()
    {
        var table_columns = ['','jobs_name','first_name','jobs_start_date','jobs_end_date','jobs_important'];
        enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
        enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
        enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
        get_selected_values();
        $('#jobs_start_date').datePicker({startDate: '01-01-1960'});
        $('#jobs_end_date').datePicker({startDate: '01-01-1960'});
        checkName();
        sendJobsProject();
    });
</script>



