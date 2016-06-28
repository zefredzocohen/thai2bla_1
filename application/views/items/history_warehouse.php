<?php $this->load->view('partial/header'); ?>
<script type="text/javascript">
$(document).ready(function(){
    var table_columns = ['','','','','','','','','','',''];
    enable_sorting("<?php echo site_url("items/sorting_warehouse"); ?>",table_columns, <?php echo $per_page; ?>);    
});
</script>
<div id="content_area_wrapper">
    <ul id="error_message_box"></ul>
    <div id="content_area">
        <div id="mytable_get_verifying" style="margin-top:20px;">
            <table id="title_bar_new">
    <tr>
        <td id="title_icon" style="width: 5px !important;">
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
        <td id="title" style="width: 300px !important;">
            <?php echo 'Lịch sử kiểm kho'; ?>
        </td>
        <td style="position: absolute; right: 280px; margin-top: 15px; width: 400px;">
            <?php echo form_open("items/get_verifying_by_date",array('id'=>'get_verifying_by_date_form')); ?>
                <div>
                    <input style="width: 100px;" placeholder="chọn ngày" type="text" class="date-pick" id="start-date"  name="start_date" <?php if($start_date1){?> value= <?php echo date('d-m-Y',strtotime($start_date1)); }?> />
                    <input style="margin-left: 40px;width: 100px; " placeholder="đến ngày" type="text" class="date-pick" id="end-date"  name="end_date" <?php if($end_date1){?> value= <?php echo date('d-m-Y',strtotime($end_date1)); }?> />
                     
                   
                </div>   
            <?php
                echo form_button(array(
                    'type' => 'submit',
                    'name'=>'get_verifying_by_date',
                    'id'=>'get_verifying_by_date',
                    'content'=>'Xem',
                    'style' =>'height: 20px; line-height:16px; width: 45px; margin: 0px 0px 0px 0px')
                );?>
               
            </form>
        </td>
    </tr>
</table>
            
                <br>
                <div id="item_table">
                    <div id="table_holder">
                        <?php echo $manage_table; ?>
                    </div>
                </div>
                <div id="pagination" style="width: 960px;">
                    <?php echo $pagination;?>
                </div>
        </div>
    </div>        
</div>
<?php $this->load->view('partial/footer'); ?>