
<script src="<?php echo base_url(); ?>js/jquery.maskMoney.js" type="text/javascript"></script>
<?= form_open('bill_cost/save/' . $var_info->id, array('id' => 'assets_form')); ?>
<div id="required_fields_message"><?php echo lang('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="supplier_basic_info">
    <legend>Thông tin chứng từ</legend>
    <div class="field_row clearfix">	
        <?php echo form_label('Đối tượng:', ' chungtu_name', array('class' => required)); ?>
        <div class='form_field'>
            <?php
            if ($var_info->name != 0) {
                echo form_input(array(
                    'name' => 'person',
                    'id' => 'person2',
                    placeholder => 'Nhập tên đối tượng ..'
                ));
            } else {
                echo form_input(array(
                    'name' => 'person',
                    'id' => 'person',
                    placeholder => 'Nhập tên đối tượng ..'
                ));
            }
            ?>
        </div>
    </div>
    <table id="person_selected">
        <tr>
            <th style="width: 18%">Xóa</th>
            <th>Nhà cung cấp</th>
        </tr>
        <?php
        if ($var_info->id_cus != 0) {
            if ($this->Supplier->exists($var_info->id_cus))
                $person_name = $this->Supplier->get_info($var_info->id_cus)->company_name;
            ?>
            <tr>
                <td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>
                <td><?= $person_name ?></td>
            <input type="hidden" name='person_id' id=person_id value='<?= $var_info->id_cus ?>'/>
            </tr>
        <?php }
        ?>
    </table><br>
    <div class="field_row clearfix">	
        <?php echo form_label('Tài khoản có:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <select id="tk_co" name="tk_co">
                <option value="0">-Chọn tài khoản-</option>
                <?php
                $this->load->model('Tkdu');
                $list_tk_co = $this->Tkdu->get_tkdu_parent();
                foreach ($list_tk_co as $parent1) {
                    ?>
                    <option value="<?= $parent1['id'] ?>" <?= $var_info->tk_co == $parent1['id'] ? 'selected' : '' ?> >
                        <?= $parent1['id'] . ' - ' . $parent1['name'] ?>
                    </option>
                    <?php
                    $parents2 = $this->Tkdu->get_all_tk2_by_tk1($parent1['id'])->result();
                    foreach ($parents2 as $parent2) {
                        ?>
                        <option value="<?= $parent2->id ?>" <?= $parent2->id == $var_info->tk_co ? 'selected' : '' ?> >
                            <?= '---- ' . $parent2->id . ' - ' . $parent2->name ?>
                        </option>
                        <?php
                        $parents3 = $this->Tkdu->get_all_tk2_by_tk1($parent2->id)->result();
                        foreach ($parents3 as $parent3) {
                            ?>
                            <option value="<?= $parent3->id ?>" <?= $parent3->id == $var_info->tk_co ? 'selected' : '' ?> >
                                <?= '----.---- ' . $parent3->id . ' - ' . $parent3->name ?>
                            </option>
                            <?php
                        }
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="field_row clearfix">	
        <?php echo form_label('Mã số thuế:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <?php
            echo form_input(array(
                'name' => 'code_taxe',
                'id' => 'code_taxe',
                'value' => $var_info->code_taxe,
                    )
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">	
        <?php echo form_label('Thuế(%):', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <?php
            echo form_input(array(
                'name' => 'taxe_percent',
                'id' => 'taxe_percent',
                'value' => $var_info->taxe_percent,
                    )
            );
            ?>
        </div>
    </div>
     <div class="field_row clearfix">	
        <?php echo form_label('Ký hiệu hóa đơn:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <?php
            echo form_input(array(
                'name' => 'symbol_order',
                'id' => 'symbol_order',
                'value' => $var_info->symbol_order,
                    )
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">	
        <?php echo form_label('Số hóa đơn:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <?php
            echo form_input(array(
                'name' => 'number_order',
                'id' => 'number_order',
                'value' => $var_info->number_order,
                    )
            );
            ?>
        </div>
    </div>
    <div class="field_row clearfix">	
        <?php echo form_label('Ngày hóa đơn' . ':', 'ngay_lap', array('class' => '')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'date_order',
                'id' => 'date_order',
                'value' => $var_info->date_order
            ));
            ?>
        </div>
    </div> 
    <div class="field_row clearfix">	
        <?php echo form_label('Ngày lập chi phí' . ':', 'ngay_lap', array('class' => '')); ?>
        <div class='form_field'>
            <?php
            echo form_input(array(
                'name' => 'ngay_lap',
                'id' => 'ngay_lap',
                'value' => $var_info->date
            ));
            ?>
        </div>
    </div> 
    <div class="field_row clearfix">	
        <?php echo form_label('Nội dung:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <?php
            echo form_textarea(array(
                'name' => 'content_ctu',
                'id' => 'content_ctu',
                'value' => $var_info->content,
                'rows' => '5',
                'cols' => '17')
            );
            ?>
        </div>
    </div>

    <div class="field_row clearfix">	
        <?php echo form_label('Số phiếu nhập:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <select id="id_cost" name="id_cost">
                <option value="0">-Số chứng từ-</option>
                <?php
                $list = $this->Bill_cost_model->get_recv();
                foreach ($list->result() as $recv) {
                    if ($var_info->id_recv == $recv->id_cost) {
                        echo "<option value='" . $recv->id_cost . "' selected>" . $recv->id_cost . "</option>";
                    } else {
                        echo "<option value='" . $recv->id_cost . "'>" . $recv->id_cost . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>

    
   
     <div class="field_row clearfix">	
        <?php echo form_label('Số tiền:', 'content_ctu', array('class' => 'wide')); ?>
        <div class='form_field' >
            <?php
            echo form_input(array(
                'name' => 'money',
                'id' => 'money',
                'value' => $var_info->money,
                    )
            );
            ?>
        </div>
    </div>
    <?php
   
    $this->load->model('Cost');
    if ($var_info->id_recv != 0) {
            ?>
            <a href="<?php echo base_url() ?>bill_cost/approve/<?= $this->Cost->get_info($var_info->id_recv)->id_receiving ?>/<?=$var_info->id?>" target="_blank" style="padding:8px 10px;background: #37B2C9;font-weight: bold;color: white" class="phieu_nhap">Phân bổ</a>
          
    <?php } else { ?>
            <a href="" class="phieu_nhap" target="_blank" style="padding:8px 10px;background: #37B2C9;font-weight: bold;color: white">Phân bổ</a>
      
    <?php } ?>
       

    <?php
    echo form_submit(array(
        'name' => 'submit',
        'id' => 'submit',
        'style' => 'margin-right: 262px',
        'value' => lang('common_submit'),
        'class' => 'submit_button float_right')
    );
    ?>
</fieldset>
<?php echo form_close(); ?>
<script type='text/javascript'>
    $('#id_cost,#money,#taxe_percent').change(function () {
        var money = $("#money").val();
        var taxe_percent = $("#taxe_percent").val();
        $.ajax({
            url: '<?= site_url() . 'bill_cost/info_cost' ?>',
            type: 'post',
            data: {id_cost: $('#id_cost').val()},
            success: function (info) {
                $('.phieu_nhap').attr('href', '<?= site_url() . 'bill_cost/approve/' ?>' + info + '/1/' + money + '/' + taxe_percent);
            }
        });
    });
 
 
   
    $('.sotien').maskMoney();
    $(document).ready(function () {
        $('#date_tang').datePicker({startDate: '01-01-1950'});
        $('#ngay_lap').datePicker({startDate: '01-01-1950'});
        $('#date_order').datePicker({startDate: '01-01-1950'});
        setTimeout(function () {
            $(":input:visible:first", "#item_form").focus();
        }, 100);
        var submitting = false;

        $('#assets_form').validate({
            submitHandler: function (form)
            {
                if (submitting)
                    return;
                submitting = true;
                $(form).mask(<?php echo json_encode(lang('common_wait')); ?>);
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        submitting = false;
                        tb_remove();
                        post_item_form_submit(response);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules: {
                person: {
                    required: function () {
                        return $("#person_id").val() ? false : true;
                    }
                }
            },
            messages: {
                person: "Bạn cần nhập Đối tượng",
            }
        });
    });

     

    function Xoa_Het_Du_Thien(link) {
        $(link).parent().parent().remove();
        return false;
    }
    function deleteCostSupplierRow(link) {
        $("#person").removeClass("disable_input_cost");
        $("#person2").removeClass("disable_input_cost");
        $(link).parent().parent().remove();
        return false;
    }
    $("#person").autocomplete({
        source: '<?php echo site_url("bill_cost/person_search_cost"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#person").val("");
            if ($("#person_selected" + ui.item.value).length == 1) {
                $("#person_selected" + ui.item.value).val(parseFloat($("#person_selected" + ui.item.value).val()) + 1);
            } else {
                $("#person").addClass("disable_input_cost");
                $("#person_selected").append(
                        "<tr class=tr_bold >"
                        + "<td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>"
                        + "<td>" + ui.item.label + "</td>"
                        + "<input  type='hidden' size='3' name='person_id' id=person_id value='" + ui.item.value + "'/>"
                        + "</tr>"
                        );
            }
            return false;
        }
    });



    $("#person2").autocomplete({
        source: '<?php echo site_url("bill_cost/person_search_cost"); ?>',
        delay: 10,
        autoFocus: false,
        minLength: 0,
        select: function (event, ui) {
            $("#person2").val("");
            if ($("#person_selected" + ui.item.value).length == 1) {
                $("#person_selected" + ui.item.value).val(parseFloat($("#person_selected" + ui.item.value).val()) + 1);
            } else {
                $("#person2").addClass("disable_input_cost");
                $("#person_selected").append(
                        "<tr class=tr_bold >"
                        + "<td class=td_center ><a href='#' onclick='return deleteCostSupplierRow(this);'>X</a></td>"
                        + "<td>" + ui.item.label + "</td>"
                        + "<input  type='hidden' size='3' name='person_id' id=person_id value='" + ui.item.value + "'/>"
                        + "</tr>"
                        );
            }
            return false;
        }
    });
    $("#person2").addClass("disable_input_cost");
   

</script>
<style type="text/css">
    .flower_table {
        text-align: center
    }
    .flower_table tr{
        height: 35px
    }
    .flower_table .red_heart{
        color: red; font-size: 13px
    }
    .flower_table .tk_no, .flower_table .tk_co, .flower_table .sotien{
        width: 90%
    }
    .flower_table .sotien{
        height: 24px;
        padding: 0px 3px;
    }
    .disable_input_cost {
        display: none;
    }
    .td_center, #person_selected tr th{
        text-align: center
    }
    #person_selected{
        width: 60%;
        margin-left: 20px
    }
</style>

<script type="text/javascript" language="javascript">
  $(document).ready(function(){
    $('#money').change(function () {
        $.post('<?php echo site_url("bill_cost/set_money"); ?>', {money: $('#money').val()});
     });
 });
</script>