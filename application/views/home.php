<?php $this->load->view("partial/header"); ?>
<div class="content clearfix">
    <div class="items isotope">
        <?php
        foreach ($allowed_modules_home->result() as $module) {
            ?>
            <a  class="box color-box-<?php echo $module->module_id; ?>" href="<?php echo site_url("$module->module_id"); ?>">
                <img class="icon" src="<?php echo base_url() . 'images/menubar/' . $module->module_id . '.png'; ?>" border="0" alt="Menubar Image" />
                <span><?php echo lang("module_" . $module->module_id) ?>
                    <?php /* ?><br />
                      <?php echo lang('module_'.$module->module_id.'_desc');?><?php */ ?>
                </span>
            </a>		
            <?php
        }
        ?>

<?php $this->load->view("partial/footer"); ?>