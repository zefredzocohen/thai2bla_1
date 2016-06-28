<style>
    .wide{
        color:red;
    }
</style>
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<div style="height:200px;">
<?php
echo form_open('contact_admin/view/'.$contact_info->id,array('id'=>'categories_form'));
?>
<fieldset id="item_basic_info">
<legend><?php echo 'Thông tin khách hàng liên hệ'; ?></legend>

<?php echo form_label('Họ tên người liên hệ'.':', 'name',array('class'=>'wide')); ?>
    <div class='form_field'>
         <?php echo $this->Contacts_admin->get_info($contact_info->id)->fullname;?>
    </div>
<br>
<?php echo form_label('Tiêu đề'.':', 'name',array('class'=>'wide')); ?>
    <div class='form_field'>
         <?php echo $this->Contacts_admin->get_info($contact_info->id)->title;?>
    </div>
<br>
<?php echo form_label('Email người liên hệ'.':', 'name',array('class'=>'wide')); ?>
    <div class='form_field'>
         <?php echo $this->Contacts_admin->get_info($contact_info->id)->email;?>
    </div>
<br>
<?php echo form_label('Điện thoại'.':', 'name',array('class'=>'wide')); ?>
    <div class='form_field'>
         <?php echo $this->Contacts_admin->get_info($contact_info->id)->tel;?>
    </div>
<br>
    <?php echo form_label('Nội dung'.':', 'name',array('class'=>'wide')); ?><br>
    <div class='form_field' style="word-break: break-all;">
         <?php echo $this->Contacts_admin->get_info($contact_info->id)->content;?>
    </div>
</div>
 <?php
    $this->load->model('Contacts_admin');
    $id = $contact_info->id;
    $view = $this->Contacts_admin->get_info($id)->view;
    $count_view = $view + 1;
    $data = array('view' => $count_view);
    $this->Contacts_admin->update_contact($data,$id);
 ?>

</fieldset>
<?php echo form_close();?>
</div>
