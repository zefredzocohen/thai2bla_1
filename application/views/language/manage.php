<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area" >
<script type="text/javascript">
$(document).ready(function()
{
    var table_columns = ["","id",'website','phone_number','E_Mail','address','eployee','skype',''];
    enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang('language_confirm_delete'));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_bulk_edit(<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_cleanup(<?php echo json_encode(lang("abouts_confirm_cleanup"));?>);

    $('#generate_barcodes').click(function()
    {
        var selected = get_selected_values();
        if (selected.length == 0)
        {
            alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
            return false;
        }

        $(this).attr('href','<?php echo site_url("items/generate_barcodes");?>/'+selected.join('~'));
    });

    $('#generate_barcode_labels').click(function()
    {
        var selected = get_selected_values();
        if (selected.length == 0)
        {
            alert(<?php echo json_encode(lang('items_must_select_item_for_barcode')); ?>);
            return false;
        }

        $(this).attr('href','<?php echo site_url("items/generate_barcode_labels");?>/'+selected.join('~'));
    });
    $('#shopping_item').click(function()
    {
        var selected = get_selected_values();
        if (selected.length == 0)
        {
            alert(<?php echo json_encode(lang('items_must_select_item_for_shopping')); ?>);
            return false;
        }
        // alert(selected);
         $(this).attr('href','<?php echo site_url("items/shopping");?>/'+selected.join('~'));
    });
    $('#trading_item').click(function()
    {
        var selected = get_selected_values();
        if (selected.length == 0)
        {
            alert(<?php echo json_encode(lang('items_must_select_item_for_trading')); ?>);
            return false;
        }
        // alert(selected);
         $(this).attr('href','<?php echo site_url("items/trading");?>/'+selected.join('~'));
    });
    <!-- phan lam thong bao -->
    
    <!-- phan lam -->
    var button = $('#button');
    var menu = $('#menutest');
    
    $('ul li a', menu).each(function() {
        $(this).append('<span />');
    });
    
    button.toggle(function(e) {
        e.preventDefault();
        menu.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
    
    
    
    var button1 = $('#button1');
    var menu1 = $('#menutest1');
    
    $('ul li a', menu1).each(function() {
        $(this).append('<span />');
    });
    
    button1.toggle(function(e) {
        e.preventDefault();
        menu1.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu1.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
    
    
    var button2 = $('#button2');
    var menu2 = $('#menutest2');
    
    $('ul li a', menu1).each(function() {
        $(this).append('<span />');
    });
    
    button2.toggle(function(e) {
        e.preventDefault();
        menu2.css({display: 'block'});
        $('.ar', this).html('&#9650;').css({top: '3px'});
        $(this).addClass('active');
    },function() {
        menu2.css({display: 'none'});
        $('.ar', this).html('&#9660;').css({top: '5px'});
        $(this).removeClass('active');
    });
    <!---end thong bao -->
});

function post_type_cus_form_submit(response)
{
    if(!response.success)
    {
        set_feedback(response.message,'error_message',true);    
    }
    else
    { 
        //This is an update, just update one row
        if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
        {
            
            update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
            set_feedback(response.message,'success_message',false);     
        }
        else //refresh entire table
        {
            do_search(true,function()
            {
                //highlight new row
                highlight_row(response.customer_type_id);
                set_feedback(response.message,'success_message',false);     
            });
        }
    }
}
<!-- end phan lam -->
function post_bulk_form_submit(response)
{
    if(!response.success)
    {
        set_feedback(response.message,'error_message',true);
    }
    else
    {
        set_feedback(response.message,'success_message',false);
        setTimeout(function(){window.location.reload();}, 2500);
    }
}

function select_inv(){
    
     if (confirm(<?php echo json_encode("This applies to all the items in the inventory"); ?>))
        {
            $('#select_inventory').val(1);
            $('#selectall').css('display','none');
            $('#selectnone').css('display','block');
            $.post('<?php echo site_url("abouts/select_inventory");?>', {select_inventory: $('#select_inventory').val()});
        }
        
    }
    function select_inv_none(){
    
            $('#select_inventory').val(0);
            $('#selectnone').css('display','none');
            $('#selectall').css('display','block');
            $.post('<?php echo site_url("abouts/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});
            
    }
    


</script>

<table id="title_bar_new">
  <tr>
    <td id="title_icon"><img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /></td>
    <td id="title"><?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?></td>
    <td id="title_search_new" style="width:519px;">
    <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
      <?php /*?><select name="categorysearch" class='select_search' style="width:170px" >
        <option value="" selected="selected">Tất cả</option>
        <?php foreach ($categories as $catsearch){ ?>
        <option value="<?php echo $catsearch['id']; ?>" ><?php echo $catsearch['name']; ?></option>
        <?php } ?>
      </select><?php */?>
        <input style="" type="text" name ='search' id='search' placeholder="Nhập tên hoặc mã bằng cấp...."/>
      <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
      </form></td>
  </tr>
</table>
<table id="contents">
  <tr>
    <td id="commands"><div id="new_button">
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo 
                    anchor("$controller_name/view/-1/width~$form_width",
                    lang($controller_name.'_new'),
                    array('class'=>'thickbox none new', 
                        'title'=>lang($controller_name.'_new')));
                ?>
        <?php } ?>
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo 
                    anchor("$controller_name/delete",
                    lang("common_delete"),
                    array('id'=>'delete', 
                        'class'=>'delete_inactive')); 
                ?> 
              
        <?php } ?>
      </div></td>
    <td style="width:10px;"></td>
    <td ><?php if($total_rows > $per_page) { ?>
      <center>
        <div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer"> <?php echo lang('items_all1').' <b>'.$per_page.'</b> '.lang('items_select_inventory1').' <b style="text-decoration:underline">'.$total_rows.'</b> '.lang('items_select_inventory_total1'); ?></div>
        <div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer"> <?php echo '<b>'.$total_rows.'</b> '.lang('items_selected_inventory_total1').' '.lang('items_select_inventory_none'); ?></div>
      </center>
      <?php 
        }
        echo form_input(array(
        'name'=>'select_inventory',
        'id'=>'select_inventory',
        'style'=>'display:none',
        )       
    ); ?>
      <div id="item_table">
        <div id="table_holder"> <?php echo $manage_table; ?> </div>
      </div>
      <div id="pagination"> <?php echo $pagination;?> </div></td>
  </tr>
</table>
<div id="feedback_bar"></div>
</div></div>
<?php $this->load->view("partial/footer"); ?>

    