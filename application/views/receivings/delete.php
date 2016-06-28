<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div id="edit_sale_wrapper">
<?php 
if ($success)
{
?>
	<h1 style="width: 588px;font-size: 20px;color: #000;margin-top: 100px;"><?php echo lang('receivings_delete_successful'); ?></h1>
<?php	
}
else
{
?>
	<h1 style="width: 588px;font-size: 20px;color: #000;margin-top: 100px;"><?php echo lang('receivings_delete_unsuccessful'); ?></h1>
<?php
}
?>
</div>
</div>
</div>
<?php $this->load->view("partial/footer"); ?>