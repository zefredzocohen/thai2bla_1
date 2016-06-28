<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function(){
    var table_columns = ["trans_date",'trans_user','trans_inventory',"trans_comment",'store_id'];
    enable_sorting("<?php echo site_url("$controller_name/sorting_detail_info_item"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    $('#start_date').datePicker({startDate: '01-01-1950'}).bind(
        'dpClosed',
        function(e, selectedDates){
            var d = selectedDates[0];
            if (d) {
            	d = new Date(d);
                $('#end_date').dpSetStartDate(d.addDays(0).asString());
            }
        }
    );
    $('#end_date').datePicker().bind(
        'dpClosed',
        function(e, selectedDates){
            var d = selectedDates[0];
            if (d) {
                d = new Date(d);
                $('#start_date').dpSetEndDate(d.addDays(0).asString());
            }
        }
    );
})
</script>
<div id="content_area_wrapper">
<div id="content_area">
<table align="center" style="width: 100%;">
    <div class="field_row clearfix">
        <tr>
            <td style="width: 50%; padding: 3px;">
                <?php echo form_label(lang('items_item_number').': ', 'name',array('class'=>'wide')); echo $item_info->item_number; ?>
            </td>            
            <td style="width: 50%; padding: 3px;">
                <?php 
                echo form_label(lang('items_category').': ', 'category',array('class'=>'wide')); 
                echo $this->Category->get_info($item_info->category)->name;
                ?>                
            </td>
        </tr>       
        <tr>
            <td style="width: 50%; padding: 3px; border-bottom: 1px solid #CDCDCD">
                <?php echo form_label(lang('items_name').': ', 'name',array('class'=>'wide')); ?>
                <?php echo $item_info->name ?>
            </td>
            <td style="width: 50%; padding: 3px; border-bottom: 1px solid #CDCDCD">
                <?php echo form_label(lang('items_current_quantity').': ', 'quantity',array('class'=>'wide')); ?>
                <?php echo format_quantity($item_info->quantity) ?>
            </td>
        </tr>
    </div>	
</table>

<br /><div style="color:#000">

    <table id="title_bar">
            <tr>
                <td id="title_icon">
                         <a href="<?php echo base_url()?>items" ><div class="newface_back"></div></a></td>
                <td id="title">Thông tin chi tiết mặt hàng</td>
                <td id="title_search" style="width: 530px;">
                    <div style="float: right; margin-top: 10px;">
                        <table>
                            <tr>
                                <td>
                                    <input placeholder="Từ ngày" type="text" class="date-pick" id="start_date" name="start_date" 
                                           value='' style=" background-color: #ffffff; width: 82px; font-size: 14px; margin-top: 0px; " />
                                </td>
                                <td>  
                                    <input placeholder="đến ngày" type="text" class="date-pick" id="end_date" name="end_date" 
                                           value='' style=" background-color: #ffffff; width: 82px; font-size: 14px; margin-top: 0px; margin-left: 10px; float: left;" />
                                </td>
                               
                            </tr>
                        </table>	
                    </div>
                    <div style="background: #37b2c9">
                    <?php echo form_open("$controller_name/search_detail_info_item",array('id'=>'search_form', 'style'=>'width: 268px; float:right;background: #37b2c9' )); ?>    
                    
<!--                <img src='<?php //echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner'  />				-->
            </form>
                    </div> 
                </td>
            </tr>
        </table> 
    <table id="contents">
            <tr>
                <td style="width:10px;"></td>
                <td>
                    <div id="item_table">
                        <div id="table_holder">
                            <?php echo $manage_table; ?>
                        </div>
                    </div>
                    <div id="pagination" style="width:945px"> <?php echo $pagination; ?> </div>
                </td>
            </tr>
        </table>
<div id="feedback_bar"></div>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>

