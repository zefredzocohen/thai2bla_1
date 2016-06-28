<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function()
{
    var table_columns = ['','id_support','',''];
    enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_bulk_edit(<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_cleanup(<?php echo json_encode(lang("items_confirm_cleanup"));?>);


});
<!-- phan lam -->
function post_item_form_submit(response)
{
    if(!response.success)
    {
        set_feedback(response.message,'error_message',true);
    }
    else
    {
        //This is an update, just update one row
        if(jQuery.inArray(response.item_id,get_visible_checkbox_ids()) != -1)
        {
            update_row(response.item_id,'<?php echo site_url("$controller_name/get_row")?>');
            set_feedback(response.message,'success_message',false);
        }
        else //refresh entire table
        {
            do_search(true,function()
            {
                //highlight new row
                highlight_row(response.item_id);
                set_feedback(response.message,'success_message',false);
            });
        }
    }
}
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

     if (confirm(<?php echo json_encode("Bạn có muốn chọn tất cả không ?"); ?>))
    {
            $('#select_inventory').val(1);
            $('#selectall').css('display','none');
            $('#selectnone').css('display','block');
            $.post('<?php echo site_url("items/select_inventory");?>', {select_inventory: $('#select_inventory').val()});
        }

    }
    function select_inv_none(){

            $('#select_inventory').val(0);
            $('#selectnone').css('display','none');
            $('#selectall').css('display','block');
            $.post('<?php echo site_url("items/clear_select_inventory");?>', {select_inventory: $('#select_inventory').val()});

    }


</script>
<table id="title_bar_new">
    <tr>
        <td id="title_icon">
            <?php
                if($controller_name == items){
            ?>
            <img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />
            <?php
            }else{?>
                <a href="<?php echo base_url()?>items" ><div class="newface_back"></div></a>
            <?php
            }
            ?>
        </td>
        <td id="title">
            <?php echo lang('module_'.$controller_name); ?>
        </td>
        <td id="title_search_new">
            <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
                <input type="text" name ='search' id='search' placeholder="Tên hỗ trợ ... "/>
                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
            </form>
        </td>
    </tr>
</table>
<table id="contents">
  <tr>
    <td id="commands"><div id="new_button">
        <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
        <?php echo
                    anchor("$controller_name/view/-1/width~$form_width",
                    'Tạo mới hỗ trợ trực tuyến',
                    array('class'=>'thickbox none new',
                        'title'=>lang($controller_name.'_new')));
                ?>
        <?php } ?>
        <?php
            if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {
                echo anchor(
                    "$controller_name/delete",
                    lang("common_delete"),
                    array('id'=>'delete', 'class'=>'delete_inactive')
                );
                echo anchor(
                    "solutions",
                    'Giải pháp',
                    array('class'=>'none new', 'title'=>'Về chúng tôi')
                );
                echo anchor(
                    "news",
                    'Tin tức',
                    array('class'=>'none new', 'title'=>'Tin tức')
                );
                echo anchor(
                    "news_category",
                    'Danh mục tin',
                    array('class'=>'none new', 'title'=>'Danh mục tin')
                );
                echo anchor(
                    "slider",
                    'Quản lý slider',
                    array('class'=>'none new', 'title'=>'Quản lý slider')
                );
                echo anchor(
                    "resellers",
                    'Đại lý',
                    array('class'=>'none new', 'title'=>'Đại lý')
                );
                echo anchor(
                    "introductions",
                    'Giới thiệu',
                    array('class'=>'none new', 'title'=>'Giới thiệu')
                );
                echo anchor(
                    "vendors",
                    'Đối tác',
                    array('class'=>'none new', 'title'=>'Đối tác')
                );
                echo anchor(
                    "contact_admin",
                    'Liên hệ',
                    array('class'=>'none new', 'title'=>'Liên hệ')
                );
                echo anchor(
                   "shop_guide",
                   'Hướng dẫn mua hàng',
                    array('class'=>'none new', 'title'=>'Hướng dẫn mua hàng')
                );
            }
        ?>
      </div>
    </td>
    <td style="width:10px;"></td>
    <td ><?php if($total_rows > $per_page) { ?>
      <center>
        <div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer"> <?php echo lang('items_all').' <b>'.$per_page.'</b> '.lang('items_select_inventory').' <b style="text-decoration:underline">'.$total_rows.'</b> '.lang('items_select_inventory_total'); ?></div>
        <div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer"> <?php echo '<b>'.$total_rows.'</b> '.lang('items_selected_inventory_total').' '.lang('items_select_inventory_none'); ?></div>
      </center>
      <?php
        }
        echo form_input(array(
        'name'=>'select_inventory',
        'id'=>'select_inventory',
        'style'=>'display:none',
        )
    ); ?>
        <h3>Hỗ trợ bán hàng</h3>
      <div id="item_table">
        <div id="table_holder"> <?php echo $manage_table; ?> </div>
      </div>
      <hr>
      <h3>Đường dẫn Video giới thiệu và Mạng xã hội</h3>
      <code style="float:right">*Lưu ý: Đường dẫn video phải theo mẫu embed sau<br>https://www.youtube.com/embed/<font color="red">AqaFeD4s26Y</font></code>
      <div id="item_table" class="video">
        <div id="table_holder"> <?php echo $manage_video; ?> </div>
      </div>
      <hr>
      <div id="pagination"> <?php echo $pagination;?> </div></td>
  </tr>
</table>
<div id="feedback_bar"></div>
</div></div>
<?php $this->load->view("partial/footer"); ?>
