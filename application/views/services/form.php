<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<link rel="stylesheet" rev="stylesheet" href="<?php  echo base_url();?>css/bootstrap.min.css?<?php  echo APPLICATION_VERSION; ?>" />

<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<?php echo form_open('services/save/'.$item_info->item_id,array('id'=>'services_form'));?> 
<fieldset id="item_basic_info">
<legend style="font-size: 1.4em"><?php echo lang("services_basic_information"); ?></legend>
<table>
    <tr>
        <td>	
            <div class="field_row clearfix">
                <?php echo form_label(lang('services_item_number').':', 'name',array('class'=>'required wide')); ?>
                <div class='form_field'>
                <?php echo form_input(array(
                    'name'=>'item_number',
                    'id'=>'item_number',
                    'value'=>$item_info->item_number)
                );?>
                </div>
            </div>

            <div class="field_row clearfix">
                <?php echo form_label(lang('services_name').':', 'name',array('class'=>'required wide')); ?>
                <div class='form_field'>
                <?php echo form_input(array(
                    'name'=>'name',
                    'id'=>'name',
                    'value'=>$item_info->name)
                );?>
                </div>
            </div>
            
            <div class="field_row clearfix">
                <?php echo form_label(lang('services_category').':', 'category',array('class'=>'wide')); ?>
                <div class='form_field'>
                    <select name='category'>
                        <?php foreach ($cats as $cat){
                            if($cat['id_cat']==$item_info->category){?>
                                <option value='<?php echo $cat['id_cat']?>' selected><?php echo $cat['name']?></option>
                            <?php }else{ ?>
                                <option value='<?php echo $cat['id_cat']?>'><?php echo $cat['name']?></option>
                        <?php 
                            }
                        } ?>
                    </select>
                </div>
            </div>
        </td>
        <td style="text-align: center">	           
            <?php echo form_label(lang('item_add_images').':', 'item_image',array('class'=>'wide')); ?>
            <div class="input_file">
                <?php echo form_input(array(
                    'name'=>'item_image',
                    'id'=>'item_image',
                    'type'=>'file'
                ));?>
            </div>

            <div class="field_row clearfix">
                <?php if($item_info->images == null){?>
                    <div class="" style="border: none">                    
                        <div class='form_field'>
                               <img src="<?php echo base_url() .'images/no-images-product.jpg'?>" style="width:100px; height:100px" />
                        </div>
                    </div>
                <?php }else{?>
                    <div class="field_row clearfix" style="border-bottom:none">
                        <div class='form_field'>
                            <img src="<?php echo base_url() .'items/'.$item_info->images ?>" style="width:100px; height:100px" />
                         </div>
                    </div>
                <?php }?>
            </div>
        </td>
    </tr>
</table>
</fieldset>
<br>
<table>
    <tr>
        <td>
            <fieldset id="item_basic_info" style="width: 380px; height: 400px">
                <div class="field_row clearfix">
                <?php echo form_label(lang('items_unit_price_2').':', 'unit_price_2',array('class'=>'wide required')); ?>
                        <div class='form_field'>
                        <?php echo form_input(array(
                                'name'=>'unit_price',
                                'size'=>'15',
                                'id'=>'unit_price',
                                'value'=>to_currency_unVND($item_info->unit_price))
                        );?> <span style="font-size: 0.75em">VNĐ</span>
                        </div>
                </div>
                <div class="field_row clearfix" style="display: none">
                    <?php echo form_label(lang('items_promo_price').':', 'promo_price',array('class'=>'wide')); ?>
                    <div class='form_field'>
                    <?php echo form_input(array(
                        'name'=>'promo_price',
                        'size'=>'8',
                        'id'=>'promo_price',
                        'value'=>to_currency_unVND($item_info->promo_price))
                    );?>
                    </div>
                </div>
                <?php if($item_info->item_id != null){ ?>
                    <div class="field_row clearfix">
                        <?php echo form_label(lang('items_unit').':', 'unit',array('class'=>'wide')); ?>
                        <div class='form_field'>
                            <select name="unit">
                                <?php                                   
                                    foreach($units as $unit){ 
                                        if($item_info->unit == $unit['id_unit']){ ?>
                                            <option value="<?php echo $unit['id_unit']; ?>" selected><?php echo $unit['name']; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo $unit['id_unit']; ?>"><?php echo $unit['name']; ?></option>
                                        <?php }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="field_row clearfix">
                        <?php echo form_label(lang('items_unit').':', 'unit',array('class'=>'required wide')); ?>
                        <div class='form_field'>
                            <select name="unit">
                                <?php $this->load->model('Unit'); 
                                    $units = $this->Unit->get_all();
                                    if($units != null){
                                        foreach($units as $unit){ ?>
                                            <option value="<?php echo $unit['id_unit']; ?>"><?php echo $unit['name']; ?></option>
                                        <?php
                                        }                                
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <div style ='display:none' class="field_row clearfix">
                <?php echo form_label(lang('items_warning').':', 'warning',array('class'=>'wide')); ?>
                        <div class='form_field'>
                        <?php echo form_input(array(
                                'name'=>'warning',
                                'id'=>'warning',
                                'value'=>$item_info->warning)
                        );?>
                        </div>
                </div> 		
                
                <div class="field_row clearfix">
                <?php echo form_label(lang('items_description').':', 'description',array('class'=>'wide')); ?>
                        <div class='form_field'>
                        <?php echo form_textarea(array(
                                'name'=>'description',
                                'id'=>'description',
                                'value'=>$item_info->description,
                                'rows'=>'5',
                                'cols'=>'17')
                        );?>
                        </div>
                </div>
                <div class="field_row clearfix">
                <?php echo form_label(lang('items_allow_alt_desciption').':', 'allow_alt_description',array('class'=>'wide')); ?>
                        <div class='form_field'>
                        <?php echo form_checkbox(array(
                                'name'=>'allow_alt_description',
                                'id'=>'allow_alt_description',
                                'value'=>1,
                                'checked'=>($item_info->allow_alt_description)? 1  :0)
                        );?>
                        </div>
                </div>
                <?php
                echo form_submit(array(
                    'value'=>lang('common_submit'),
                    'style'=>'margin-right: 109px; margin-bottom: 20px',
                    'class'=>'submit_button float_right')
                );
                ?>
            </fieldset>
        </td>        
    </tr>
</table>
<?php echo form_close();?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function(){
    setTimeout(function(){$(":input:visible:first","#item_form").focus();},100);
    $('#start_year,#start_month,#start_day,#end_year,#end_month,#end_day').change(function(){
        $("#hdn_start_date").val($("#start_year").val()+'-'+$("#start_month").val()+'-'+$('#start_day').val());
        $("#hdn_end_date").val($("#end_year").val()+'-'+$("#end_month").val()+'-'+$('#end_day').val());
    });
    $( "#category" ).autocomplete({
        source: "<?php echo site_url('items/suggest_category');?>",
        delay: 10,
        autoFocus: false,
        minLength: 0
    });

    var submitting = false;
    $('#services_form').validate({
        submitHandler:function(form){
            if (submitting) return;
            submitting = true;
            $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
            $(form).ajaxSubmit({
                success:function(response){
                    submitting = false;
                    tb_remove();
                    post_item_form_submit(response);
                },
                dataType:'json'
            });
        },
        errorLabelContainer: "#error_message_box",
        wrapper: "li",
        rules:{
        <?php if(!$item_info->item_id) {  ?>
            item_number:{
                required: true,
                remote:{ 
                    url: "<?php echo site_url('services/check_item_number_services');?>", 
                    type: "post"
                } 
            },
        <?php } ?>
            name:{
                required: true,
//                remote: { 
//                    url: "<?php echo site_url('services/check_name_services/'.$item_info->item_id);?>", 
//                    type: "post"
//                } 
            },
            unit_price:{
                required:true,
                number:true
            },            
        },
        messages:{
            <?php if(!$item_info->item_id) {  ?>
            item_number:{
                required: 'Vui lòng nhập mã dịch vụ',
                remote: 'Mã dịch vụ đã tồn tại',
            },
            <?php } ?>
            name:{
                required: 'Vui lòng nhập tên dịch vụ',
//                remote: 'Tên dịch vụ đã tồn tại, vui lòng chọn tên khác'    	
            }, 
            unit_price:{
                required:<?php echo json_encode(lang('services_unit_price_required')); ?>,
                number:<?php echo json_encode(lang('services_unit_price_number')); ?>
            },
        }
    });
    $("#is").click(function(){
        if ($("#is").is(':checked')){
            $('#change_rate').slideDown("fast");
        }else{
            $('#change_rate').slideUp("fast");
        }
    });
});
</script>
<script type="text/javascript">
    $(function() { 
        $("#unit_price").maskMoney();
        $("#cost_price").maskMoney();
        $("#promo_price").maskMoney();
  });
</script>