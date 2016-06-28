<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="contents">
            <tr>
                <td id="commands">
                    <div id="new_button">
                        <?php $this->load->view('partial/left'); ?>
                    </div>
                </td>
                <td style="width:10px;"></td>
                <td>
                    <ul id="report_list" >
                        <li class="tien" > 
                            <ul class="noibat">	
                                <li class="graphical"><a href="<?php echo site_url('reports/specific_stored');?>">Mặt hàng bán theo kho</a></li>
                                <li class="graphical"><a href="<?php echo site_url('reports/reports_inventory');?>">Báo cáo hàng tồn kho</a></li><br>
                                <li class="detailed"><a href="<?php echo site_url('reports/do_item_inventory');?>">Báo cáo xuất nhập tồn</a></li>
                            </ul>                            
                        </li>     
                        <li class="thu_chi"> 
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('item_kits/import_product'); ?>">Phiếu nhập kho</a></li>
                                <li class="summary"><a href="<?php echo site_url('create_invetorys/export_store_view'); ?>">Phiếu xuất kho</a></li>
                            </ul>                            
                        </li>             
                        
                    </ul>
                </td>
            </tr>
        </table>
    </div></div>
<?php $this->load->view('partial/footer'); ?>
<style>
#report_list{
    margin-top: -3px;
    font-size: 14px
}
ul#report_list > li{
    background: #f2f2f2 none repeat scroll 0 0;
    margin-bottom: 10px
}
ul#report_list > li > h3{
    background: #D2D2D2 none repeat scroll 0 0;
}
.first{
    height: 168px !important;
}
.tien, .mua_hang, .ban_hang, .kho, .thue, .tong_hop{
    height: 86px !important;
}
.tai_chinh{
    height: 128px !important;
}
.thu_chi{
    height: 46px !important;
}
#report_list .noibat{
    margin-left: 130px
}
</style>