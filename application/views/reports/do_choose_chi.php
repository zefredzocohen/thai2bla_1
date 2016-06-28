<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
.submit_right{
    box-sizing: content-box;
   background-color: #4d90fe !important;
    background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed) !important;
    border: 1px solid #3079ed !important;
    box-shadow: none !important;
    color: #fff !important;
    border-radius: 2px !important;
    cursor: default !important;
    font-size: 11px !important;
    font-weight: bold !important;
    height: 27px !important;
    line-height: 27px !important;
    margin-right: 16px !important;
    min-width: 54px !important;
    outline: 0 none !important;
    padding: 0 8px !important;
    text-align: center !important;
    white-space: nowrap !important;
    float: right;
}
h4{
   font-family: icon;
    font-size: 28px;
    text-align: center;
}
</style>
<div>
<a style="font-size:18px;text-decoration: underline; margin-left:850px" href="<?php echo base_url();?>reports/do_choose_date_chi">Trở lại</a>
<h5 style="text-align:left"><?php echo $company; ?></h4>
<h5 style="text-align:left"><?php echo $address; ?></h4>
<?php echo '<h4 style=" margin-bottom: 5px;margin-top: 15px;">Các khoản chi</h4>' ?>
<h5 style="text-align:center">Từ <?php echo date('d-m-Y H:i:s', strtotime($start_date))  ?> đến <?php echo date('d-m-Y H:i:s', strtotime($end_date)) ?></h4>
</div>
<div style="margin-top:16px;">
	 <table id="contents" style="margin-top:5px;">
             <tr>
                <td id="item_table">
                    <div id="table_holder" style="width: 960px;">
                        <table class="tablesorter report" id="sortable_table">
                            <thead>
                                <tr style="font-size: 15px !important;">
                                    <th>STT</th>
                                    <th>Ngày thu</th>
                                    <th>Số chứng từ</th>
                                    <th>Ngày chứng từ</th>
                                     <th style="text-align: center!important;">Nội dung</th>
                                    <th style="display:none">TK đối ứng</th>
                                    <th>Tên KH - NCC</th>
                                    <th>Nhân viên</th>
                                    <th>Tiền chi</th>
                                </tr>
                            </thead>    
                           <tbody style="font-family: arial;font-size: 15px;">
                           		<?php $stt=1; ?>
                           		<?php foreach ($chi_date as $key): ?>                       		
                           			<tr>
                           				<td><?php echo $stt; ?></td>
                           				<td><?php echo date('d-m-Y H:i:s', strtotime($key['date']))  ?></td>
                           				<td><?php echo $key['chungtu'] ?></td>
                           				<td><?php echo date('d-m-Y', strtotime($key['cost_date_ct']))  ?></td>
                           				<td><?php echo $key['comment'] ?></td>
                           				<td style="display:none"><?php echo $key['tk_du'] ?></td>
                           				<td><?php echo $this->Customer->get_info($key['id_customer'])->first_name.' '.
                           								$this->Customer->get_info($key['id_customer'])->last_name ?></td>
                           				<td><?php echo $this->Person->get_info($key['cost_employees'])->first_name.' '.
                           								$this->Person->get_info($key['cost_employees'])->last_name ?></td>                    				
                           				<?php if ($key['tien_chi']>0): ?>
                           					<td><?php echo to_currency($key['tien_chi']) ?></td>
                           				<?php else: ?>
                           					<td><?php echo to_currency('0') ?></td>
                           				<?php endif ?>

                           			</tr>
                           			<?php $stt++; ?>
                               		<?php $subtotal+=$key['tien_chi']?>
                           		<?php endforeach ?>
                               <tr>
                               <td colspan="7" style="font-weight:bold;font-size:18px; text-align: right;">Tổng tiền</td>
                               <td style="font-weight:bold"><?php echo to_currency($subtotal);?></td>
                               </tr>
                           </tbody>
                           
                        </table>
                    </div>
                </td>
         	 </tr>
        </table> 
	</div>
</div></div></div>
<?php $this->load->view('partial/footer'); ?>