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
                        <li class="ban_hang" > 
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/tong_hop_cnkh'); ?>">Tổng hợp công nợ phải thu</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/report_cong_no_khach_hang'); ?>">Chi tiết công nợ</a></li><br>
                               <li class="summary" style="margin-left: 263px;margin-top: 14px;"><a href="<?php echo site_url('costs/nkbh'); ?>">Nhật ký bán hàng</a></li>
                            </ul>                            
                        </li>     
                        <li class="hoa_don"> 
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/order_service_bh'); ?>">Hóa đơn dịch vụ</a></li><br>
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
.ban_hang{
    height: 46px !important;
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