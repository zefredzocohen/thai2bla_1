<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
    <table id="title_bar_new" style="color: #FFF">
        <tr>
            <td id="title_icon">
                <img src='<?php echo base_url()?>images/menubar/<?php echo 'reports'; ?>.png' alt='title icon' />
            </td>
            <td id="title">
                <?php echo lang('reports_report_input'); ?>
            </td>
        </tr>
    </table>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
	<div style="margin-left:10px; margin-top:20px;">
		<?php  echo lang('reports_export_to_excel'); ?>: 
		<input type="radio" name="export_excel" id="export_excel_yes" value='1' /> 
			<label for="export_excel_yes"><?php  echo lang('common_yes'); ?></label>
			&nbsp;
		<input type="radio" name="export_excel" id="export_excel_no" value='0' checked='checked' /> 
			<label for="export_excel_no"><?php  echo lang('common_no'); ?></label>
	</div>

<?php
echo form_button(array(
	'name'=>'generate_report',
	'id'=>'generate_report5',
	'style'=>'margin-left:10px;',
	'content'=>lang('common_submit'),
	'class'=>'submit_button')
);
?>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$("#generate_report5").click(function()
	{
		var export_excel = 0;
		if ($("#export_excel_yes").attr('checked'))
		{
			export_excel = 1;
		}
		
		window.location = window.location+'/' + export_excel;
	});	
});
</script>