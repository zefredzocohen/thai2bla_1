
<ul id="error_message_box"></ul>
<?php echo form_open("items/save_item_verifying" ,array('id'=>'save_verifying')); ?>
  <!-- <form name="save_verifying" action="items/save_item_verifying" onsubmit="return validateForm()" method="post">                          -->
<table id="contents">
	<tr>
		<td id="item_table">
			<div id="table_holder" style="width: 960px;">
				<table class="tablesorter report" id="sortable_table">
					<thead>
<!-- <table > 
	<thead> -->
		<tr>
			<th colspan="" rowspan="" headers="">Mã SP</th>
			<th colspan="" rowspan="" headers="">Tên SP</th>
			<th colspan="" rowspan="" headers="">Đơn vị tính</th>
			<th colspan="" rowspan="" headers="">Giá nhập</th>
			<th colspan="" rowspan="" headers="" style="display:none">SL nhập</th>
			<th colspan="" rowspan="" headers="">Kho</th>
			<th colspan="" rowspan="" headers="">SL kho</th>
			<th colspan="" rowspan="" headers="">SL bán</th>
			<!-- <td colspan="" rowspan="" headers="">Thực tế</td>
			<td colspan="" rowspan="" headers="">Chêch lệch</td> -->
		</tr>
	</thead>
	<tbody>
		
		<tr>
			<?php foreach ($store as $key): ?>
			<?php 

				$quantity_inventory=$key['quantity_item'];
				$quantity_sales=$key['buys'];

				$quantity_input=$quantity_inventory+$quantity_sales;


			 ?>


			<td colspan="" rowspan="" headers=""><?php echo $key['item_id'] ?>
				<input type="hidden" name="id_item" value="<?php echo $key['item_id'] ?>">
			</td>
			<td colspan="" rowspan="" headers=""><?php echo $key['name'] ?>
				
			</td>
			<td colspan="" rowspan="" headers=""><?php echo $this->Unit->get_info1($key['unit'])->name ?>
			</td>
			<td colspan="" rowspan="" headers=""><?php echo to_currency_unVND($key['cost_price']) ?>
				
			</td>

			<td colspan="" rowspan="" headers="" style="display:none"><?php echo $quantity_input ?>
				<input type="hidden" name="txt_input" value="<?php echo $quantity_input ?>">
			</td>
			
			<td colspan="" rowspan="" headers="">
                        <?php  if ($store_kho!=0){?>	
                         	<?php echo $key['name_inventory'] ?>
                         	<input type="hidden" name="warehouse_id" value="<?php echo $key['warehouse_id'] ?>">
                         <?php }else{?>
                         	<?php echo 'Kho tổng' ?>
                         	<input type="hidden" name="warehouse_id" value="0">
                         <?php }?>
            </td>
			
			<td colspan="" rowspan="" headers="" >
					<?php if ($store_kho!=0){ ?>	
				 		<?php echo $key['quan'] ?>
						<input type="hidden" name="txt_kho" value="<?php echo $key['quan'] ?>">
					<?php }else{ ?>
						<?php echo $key['quantity_item'] ?>
						<input type="hidden" name="txt_kho" value="<?php echo $key['quantity_item'] ?>">
					<?php } ?>
					
			</td>
			

			<td colspan="" rowspan="" headers="">
			  	<?php foreach ($get_buy as $gb) {?>
					<?php echo $gb['buy2'];?>
					<input type="hidden" name="txtbuys" value="<?php echo $gb['buy2'];?>">
				<?php }?>	
			</td>
		<?php endforeach ?>	
		</tr>

				</tbody>
				</table>
			</div>
		</td>
	</tr>

</table>
<div style="float:right; margin-top:18px;padding-right:5px">
<h4 style="color:#3B3A35;font-size:12px;"> SL kiểm kê thực tế</h4>
<input type="text" name="name_kt" value="" id="numbers" class="classinput" >
<br>

<?php if (isset($store)): ?>
	<input type="submit" class="submit_button1" id="submit" value="Lưu" name="submit">
<?php endif ?>

</div>
<?php echo form_close(); ?>


