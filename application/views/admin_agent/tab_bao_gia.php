


<?php $sum_money = 0; ?>
                                <?php
                                if ($num_rows > 0) {
                                    foreach ($sale_materials as $sale_complete) {
                                        ?>
                                        <tr class="row_inventory_sale" style="text-align: center;">
                                            <td class="row_sale_id" style="text-align: center;"><a href="<?php echo base_url(); ?>customers/switch_sale/<?php echo $sale_complete['sale_id']; ?>" ><?php echo $sale_complete['sale_id']; ?></a></td>
                                            <td style="text-align: center;"><?php echo $sale_complete['sale_time']; ?></td>
                                            <td style="text-align: center;"><?php echo $this->Employee->get_info($sale_complete['employee_id'])->first_name; ?>&nbsp;</td>
                                            <td  style="text-align: left;">
                                            <?php
                                            foreach($detail_sale_materials as $key=>$val){
                                                if($key==$sale_complete['sale_id']){
                                                    foreach($val as $val1){
                                                        foreach($val1 as $val2){
                                                            echo $val2['name']." , <br /> ";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>&nbsp;
                                            </td>
                                            <td style="text-align: right;">
                                            <?php
                                            foreach($sale_data as $key2=>$val2){
                                                if($val2->sale_id==$sale_complete['sale_id']){
                                                    $total_cost = $val2->later_cost_price;
                                                    echo number_format($total_cost);
                                                    break;
                                                }
                                            }
                                             ?>&nbsp;
                                            </td>
                                            <?php 
                                                $data_sale_tam = $this->Sale->get_sales_tam($sale_complete['sale_id']);
                                                $data_sale_payment = $this->Sale->get_payment_sale_by_sale_id($sale_complete['sale_id']); 
                                                $to = 0;
                                                $do = 0;
                                            ?>
                                            <?php if($sale_complete['suspended'] == 1){?>
                                            <td style="text-align: center; color: red;">
                                                <?php echo 'KH đã ghi nợ';?>&nbsp;
                                            </td>
                                            <?php }elseif($sale_complete['liability'] == 1) {?>
                                            <td style="text-align: center; color:green;">
                                                <?php echo 'KH đã đặt hàng';?>&nbsp;
                                            </td>
                                            <?php }else {?>
                                            <td style="text-align: center;">
                                                <?php echo '';?>&nbsp;
                                            </td>
                                            <?php }?>
                                            <td style="text-align: center; font-size: 10px;">                                            
                                                <?php
                                                $list_sales_materials = $this->Sale->get_sale_material($sale_complete['sale_id']);
                                                foreach($list_sales_materials as $key=>$item){
                                                    echo "<a href='".site_url()."/sales/download_matarial?file=".$item['name']."'>Lần ".($key+1)."</a>&nbsp&nbsp";
                                                }
                                                ?>
                                                <?php
//                                                    $a = $this->Sale->get_sale_material($sale_complete['sale_id']);
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                echo form_open('sales/delete_detail_materials', array('id' => 'form_delete_suspended_sale'));
                                                echo form_hidden('suspended_sale_id', $sale_complete['sale_id']);
                                                echo form_hidden('suspended_customer_id', $sale_complete['customer_id']);
                                                ?>
                                                <input type="submit" name="submit" value="<?php echo lang('common_delete'); ?>" id="submit_delete" class="submit_button float_right">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php 
                                    } 
                                } 
                                if($num_rows == $resultsPerPage){
								    $loadpage= $paged+1;
								    echo "<tr class='loadbutton5'>
								    	<td colspan = '8'><div class='loadmore5' data-page='".$loadpage."'>Xem thêm</div>
								    	</td></tr>";
								}else{
								    echo "<tr class='loadbutton5'> </tr>";
								}	   
                                
                                ?>