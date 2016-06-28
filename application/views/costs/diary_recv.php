<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<div style="color:#000">
<style type="text/css">
.table_cost{ 
    width: 80%;
    margin-left: 80px;
    font-size: 14px;
}
.table_cost tr td{ 
    padding: 4px;
    border:1px solid black ;
}
.back_to_HallOweeN{
    font-size:18px;
    text-decoration: underline; 
    margin-left:789px;
}
.tr_HallOweeN{
    text-align:center; 
    font-weight:bold; 
    font-size:13px; 
    height: 20px
}
</style>
<a class="back_to_HallOweeN" href="<?= site_url()?>costs/diary_recv">Trở lại</a><br><br>
<div style="text-align:center; font-weight:bold;padding: 5px; text-transform: uppercase">nhật ký mua hàng</div>
<div style="text-align:center; font-style:italic; font-size:13px; font-weight: 600">
    Từ ngày : <?php echo date('d-m-Y H:i:s', strtotime($start_date)); ?> 
    đến ngày: <?php echo date('d-m-Y H:i:s', strtotime($end_date)); ?>
</div><br>
<table class="table_cost" border="1px">
<tr class="tr_HallOweeN">
	<td width="15%">Ngày hoạch toán</td>
	<td width="10%"> Số chứng từ</td>
<!--	<td width="10%">Mã mua hàng</td>-->
	<td width="15%">Diễn giải</td>
	<td width="15%">Hàng hóa</td>
	<td width="15%">Nguyên vật liệu</td>
	<td width="20%">Tiền hàng</td>
</tr>
<?php
      $hh = 0;
      $vnl = 0;
foreach($receiving_HallOweeN->result() as $HallOweeN){
    $info_cost = $this->Receiving->get_info_cost_by_date_HallOweeN($HallOweeN->receiving_id, $HallOweeN->receiving_time);
    $info_recv = $this->Receiving->get_info($HallOweeN->receiving_id)->row();
    $info_store = $this->Create_invetory->get_info($info_recv->inventory_id);

    ?>
<tr style="height: 20px">
    <td style="text-align: center"><?= date('d-m-Y', strtotime($HallOweeN->date_debt)) ?></td>
    <td style="text-align: center">
        <a href="<?= site_url().'receivings/switch_recv/'.$HallOweeN->receiving_id ?>" > 
            <?= $info_cost->id_cost ?>
        </a></td>
<!--    <td style="text-align: center">
        <a href="<?= site_url().'receivings/switch_recv/'.$HallOweeN->receiving_id ?>" >             
            <?= $HallOweeN->receiving_id ?>
        </a>
    </td>-->
       
    <td><?= $HallOweeN->comment ?></td>
    <?php
                  $recv_items = $this->Receiving->getall_receiving_items();
                    foreach ($recv_items->result() as $id_receiving){
                        if($id_receiving->receiving_id == $HallOweeN->receiving_id){
                            if($id_receiving->tk_no_recv == 156){
                                $hh += $id_receiving->money_tk_no;
                            }elseif($id_receiving->tk_no_recv == 152){
                                $nvl += $id_receiving->money_tk_no;
                            }
                        }
                    }
    ?>
    <td><?=  number_format($hh)?></td>
    <td><?=  number_format($nvl)?></td>
    <td style="text-align: right"><?= number_format($hh+$nvl) ?></td>
</tr>    
    <?php
}
?>


</table>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>