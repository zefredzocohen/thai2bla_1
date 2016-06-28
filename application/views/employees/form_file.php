<div style="float:left; width: 100%">
    <fieldset id="item_basic_info" style="color:#000 !important">
        <legend><h4 style="color:red;">File đính kèm : </h4></legend>
        <div style="float: left;width: 490px;border-right: 1px solid #CCC;padding: 20px 0 0 10px">
            <label class="field" style="width: 150px;float: left;">Tải lên file CV : </label>
            <?php echo form_upload('curiculum_vitae');?>

            <?php if($person_info->curiculum_vitae == null){?>
                <div class="field_row clearfix" style="border: none">
                    <label style="margin-left: -15px">File CV:</label>

                    <div class='form_field'>
                        <span style="font-size:12px;font-style:italic;font-weight: normal;line-height: 22px;">
                        Chưa cập nhật CV ! </br>( hỗ trợ kiểu file: .doc, .docx, .pdf, .xlsx, .xls)</span>
                    </div>
                </div>
            <?php } else{?>
                <div class="field_row clearfix" style="border: none">
                    <label >File CV:</label>
                    <div class='form_field'> <a href="<?php echo base_url() .'file/'. $person_info->curiculum_vitae ?>" >
                            <span style="font-style:italic;font-weight: normal;line-height: 22px;font-size: 11px">
                            <?php echo $person_info->curiculum_vitae ?></span></a> </div>
                </div>
            <?php }?>
        </div>

        <div style="float: left;width: 480px;padding: 20px 0 0 10px;margin-left: 10px">
            <label class="field" style="width: 150px;border: none;float: left">Tải lên file hợp đồng : </label>
            <?php echo form_upload('labor_contract');?>
            <?php if($person_info->labor_contract == null){?>
                <div class="field_row clearfix" style="border: none">
                    <label style="margin-left: -15px ">File Hợp đồng:</label>
                    <div class='form_field'>
                        <span style="font-style:italic;font-size:12px;font-weight: normal;line-height: 22px;">
                            Chưa cập nhật hợp đồng ! <br>( hỗ trợ kiểu file: .doc, .docx, .pdf, .xlsx, .xls)</span>
                    </div>
                </div>
            <?php } else{?>
                <div class="field_row clearfix">
                    <label>Hợp đồng:</label>
                    <div class='form_field'>
                        <a href="<?php echo base_url() .'file/' .$person_info->labor_contract ?>">
                            <span style="font-size: 11px;font-style:italic;font-weight: normal;line-height: 22px;"><?php echo $person_info->labor_contract ?></span> </a></div>
                </div>
            <?php }?>
        </div>
        </p>
    </fieldset>
</div>