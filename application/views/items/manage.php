<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function()
{
	var table_columns = ["","item_number",'name','','category','unit_price','quantity_warehouse','quantity','quantity_total','',''];
	enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);
    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_bulk_edit(<?php echo json_encode(lang($controller_name."_none_selected"));?>);
    enable_cleanup(<?php echo json_encode(lang("items_confirm_cleanup"));?>);

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
    //Created by San
    var button = $('#button');
    var menu = $('#menutest');
    
    var button1 = $('#button1');
    var menu1 = $('#menutest1');
    
    var button2 = $('#button2');
    var menu2 = $('#menutest2');
    
    var button3 = $('#button3');
    var menu3 = $('#menutest3');
    
    menu.css({display: 'none'});
    button.click(function(){
        menu.toggle();
        menu2.css({'display':'none'});
        menu3.css({'display':'none'});
    });
    
    menu2.css({display: 'none'});
    button2.click(function(){
        menu2.toggle();
        menu.css({'display':'none'});
        menu3.css({'display':'none'});
    });
    
    menu3.css({display: 'none'});
    button3.click(function(){
        menu3.toggle();
        menu.css({'display':'none'});
        menu2.css({'display':'none'});
    });
    <!---end thong bao -->
<!-- phan lam -->
});
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
			update_row(response.item_id,' <?php echo site_url("$controller_name/get_row")?>');
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
        
         //location.reload();
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
	
	 if (confirm(<?php echo json_encode("Bạn có muốn chọn hết tất cả các mặt hàng không"); ?>))
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
	
	function click_module(){
		alert("ccc");
	}

</script>
<div style="margin-top: -10px; float: right; margin-right: 10px;">
    <nav>
        <ul class="group">
            <?php $this->load->model('sale');?>			
            <li>
                <a id="button" >Bán hàng</a>
                <?php 
                    if($shopping_items != null){
                ?>
                <span id="spansn" style="left: 37px"><?php echo count($shopping_items); ?></span>
                <?php } ?>
                <div id="menutest" class="menu-togged" style="width: 500px !important; display: none;">                    
                    <table class="mytable" cellspacing="0" style="width: 100%; margin: 0px !important;">
                        <thead>
                            <th style="text-align:center;">Mã mặt hàng</th>
                            <th style="text-align:center;">Tên mặt hàng</th>
                        </thead>
                        <tbody>
                            <?php 
                            if ($shopping_items != null){
                                foreach ($shopping_items as $shopping_item){
                                ?>
                                <tr>
                                <td style="width: 25%; padding: 5px 10px;"><?php echo $shopping_item['item_number']; ?></td>
                                <td style="width: 75%; padding: 5px 10px;"><?php echo $shopping_item['name']; ?></td>
                                </tr>
                        <?php	} ?>
                        <tr>
                            <td colspan ="2">
                                <a href="<?php echo base_url(); ?>sales" style="width: 140px !important">Vào module bán hàng</a>
                            </td>
                        </tr>                        
                        <?php } else{
                            echo "<tr>";
                                echo "<td colspan='2' style='text-align: center; padding: 5px 10px;'>Không có mặt hàng nào trong mua hàng</td>";
                            echo "</tr>";
                        } ?>
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <a id="button2" >Nhập hàng</a>
                <?php if($trading_items != null){ ?>
                <span style="left: 41px"><?php echo count($trading_items); ?></span>
                <?php } ?>
                <div id="menutest2" class="menu-togged" style="width: 500px !important; display: none;">                    
                    <table class="mytable" cellspacing="0" style="width: 100%; margin: 0px !important;">
                        <thead>
                            <th style="text-align:center;">Mã mặt hàng</th>
                            <th style="text-align:center;">Tên mặt hàng</th>
                        </thead>
                        <tbody>
                            <?php
                            if ($trading_items != null){
                                foreach ($trading_items as $trading_item){
                                    $this->load->library('receiving_lib');
                            ?>
                            <tr>
                                <td style="width: 25%;  padding: 5px 10px;"><?php echo $this->Item->get_info($trading_item['item_id'])->item_number; ?></td>
                                <td style="width: 75%;  padding: 5px 10px;"><?php echo $trading_item['name']; ?></td>
                            </tr>
                                <?php } ?>
                            <tr>
                                <td colspan ="3">
                                    <a href="<?php echo base_url(); ?>receivings" style="width: 140px !important">Vào module nhập hàng</a>
                                </td>
                            </tr>
                            <?php } else {
                                echo "<tr>";
                                echo "<td colspan='2' style='text-align: center; padding: 5px 10px;'>Không có mặt hàng nào trong nhập hàng</td>"; 
                                echo "</tr>";
                            }?>
                        </tbody>
                    </table>                    
                </div>
            </li>
            <li>
                <a id="button3" >Hết hàng tồn kho</a>
                <?php if($items != null){ ?>
                <span style="left: 41px"><?php echo count($items); ?></span>
                <?php } ?>
                <div id="menutest3" class="menu-togged" style="width: 500px !important; display: none;"> 
                    
                    
                    <!-- show ra chỗ hết hàng tồn kho -->
                    <table class="mytable" cellspacing="0" style="width: 100%; margin: 0px !important;">
                        <thead>
                            <th style="text-align:center;">Tên</th>
                            <th style="text-align:center;">Số lượng</th>
                            <th style="text-align:center;">Mức ngưỡng</th>
                            <th style="text-align:center;"></th>
                        </thead>
                        <tbody>
                            <?php
                            if ($items != null){
                                for ($i=0;$i< count($items);$i++){
                                    $item_info=$this->Item->get_info($items[$i]);
                                    ?>
                                    <tr>
                                        <td><?php echo $item_info->name; ?></td>
                                        <td><?php echo $item_info->quantity; ?></td>
                                        <td><?php echo $item_info->reorder_level; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>items/switch_receving/<?php echo $item_info->item_id;  ?>">Nhập hàng</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>  
                      <!-- end show ra chỗ hết hàng tồn kho -->
                    
                </div>
            </li>
        </ul>
    </nav>
</div>
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
            <?php echo lang('module_'.$controller_name); ?>
        </td>
        <td id="title_search_new">
            <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
                <div style="position: absolute; right: 475px; margin-top: 1px;">
                    <select name="stores"  id="stores" class='form-control'>                        
                        <option value="0">Kho tổng</option>
                        <?php foreach ($warehouse as $key){ ?>
                                <option value="<?php echo $key['id']; ?>"><?php echo $key['name_inventory']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div style="position: absolute; right: 280px; margin-top: 1px;">
                    <select name="categorysearch" id="categorysearch" class='form-control'>	
                        <option value="" selected="selected">Tất cả</option>
                        <?php foreach ($categories as $catsearch){ ?>
                                <option value="<?php echo $catsearch['id_cat']; ?>" ><?php echo $catsearch['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input style="margin-left:0px;padding-right:25px;float: right;" type="text" name ='search' id='search'/>
                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
            </form>
        </td>
    </tr>
</table>
<table id="contents">
	<tr>
		<td id="commands">
			<div id="new_button">
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
				<?php echo 
					anchor("$controller_name/view/-1/width~900",
					lang($controller_name.'_new'),
					array('class'=>'thickbox none new', 
						'title'=>lang($controller_name.'_new')));
				?>
		
				<?php } ?>
				
				<?php echo 
					anchor("categories",
					'Nhóm mặt hàng - dịch vụ',
					array('class'=>'none new', 
						'title'=>'Nhóm mặt hàng - dịch vụ'));
				?>
                <a href="<?= base_url() ?>create_invetorys/export_store_view" class=" none new">Xuất kho</a>
                <?= anchor("create_invetorys",
					lang("module_create_invetorys"),
					array('class'=>'none import'));
				?>
                <?php echo
					anchor("$controller_name/bulk_edit/width~490",
					lang("items_bulk_edit"),
					array('id'=>'bulk_edit',
						'class' => 'bulk_edit_inactive',
						'title'=>lang('items_edit_multiple_items'))); 
				?>
                
				<?php echo 
					anchor("$controller_name/generate_barcode_labels",
					lang("common_barcode_labels"),
					array('id'=>'generate_barcode_labels', 
						'class' => 'generate_barcodes_inactive',
						'target' =>'_blank',
						'title'=>lang('common_barcode_labels'))); 
				?>
                <?php echo 
					anchor("$controller_name/generate_barcodes",
					lang("common_barcode_sheet"),
					array('id'=>'generate_barcodes', 
						'class' => 'generate_barcodes_inactive',
						'target' =>'_blank',
						'title'=>lang('common_barcode_sheet'))); 
				?>
                
				<?php echo 
					anchor("$controller_name/items/shopping",
					'Bán hàng',
					array('id'=>'shopping_item', 
						'class'=>'delete_inactive')); 
				?>
				<style type="text/css">
				#shopping_item,#trading_item{background-position: -10px -10px;};
				</style>
				<!-- phan nhap hang -->
				<?php echo 
					anchor("$controller_name/items/trading",
					lang("supplier_trading"),
					array('id'=>'trading_item', 
						'class'=>'delete_inactive')); 
				?>
				<!-- end phan nhap hang -->
				
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>		
				<?php echo anchor("$controller_name/excel_import/width~450/height~220",
					lang('common_excel_import'),
					array('class'=>'thickbox none import',
						'title'=>lang('items_import_items_from_excel')));
				?>
				<?php }?>
				<?php echo anchor("$controller_name/excel_export",
					lang('common_excel_export'),
					array('class'=>'none import'));
				?>
				<?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>				
				
				<?php echo 
					anchor("$controller_name/delete",
					lang("common_delete"),
					array('id'=>'delete', 
						'class'=>'delete_inactive')); 
				?>
				
				<?php echo 
					anchor("$controller_name/cleanup",
					lang("items_cleanup_old_items"),
					array('id'=>'cleanup', 
						'class'=>'cleanup')); 
				?>
				<?php } ?>
			</div>
		</td>
		<td style="width:10px;"></td>
		<td >
		<?php if($total_rows > $per_page) { ?>
		<center><div id="selectall" class="selectall" onclick="select_inv()" style="display:none;cursor:pointer;border:1px solid #b94a48; border-radius:4px;padding:5px 0; margin-bottom:5px; color:#b94a48">
		<?php echo lang('items_all').' <b>'.$per_page.'</b> '.lang('items_select_inventory').' <b style="text-decoration:underline">'.$total_rows.'</b> '.lang('items_select_inventory_total'); ?></div>
		<div id="selectnone" class="selectnone" onclick="select_inv_none()" style="display:none; cursor:pointer">
		<?php echo '<b>'.$total_rows.'</b> '.lang('items_selected_inventory_total').' '.lang('items_select_inventory_none'); ?></div></center>
		<?php 
		}
		echo form_input(array(
		'name'=>'select_inventory',
		'id'=>'select_inventory',
		'style'=>'display:none',
		)		
	); ?>
		  <div id="item_table">
			<div id="table_holder">
			<?php echo $manage_table; ?>
			</div>
			</div>
			<div id="pagination">
				<?php echo $pagination;?>
			</div>
		</td>
	</tr>
</table>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/abouts"); ?>
</div></div>
<?php $this->load->view("partial/footer"); ?>

<style>
    #menutest3 .mytable tbody a:hover{
        text-decoration: underline;
    }
    #sortable_table a{
        line-height: 20px;
    }
    #item_table th{
        line-height: 10px;
    }
</style>
