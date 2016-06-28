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
                        <li class="thu_chi" > 
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Bảng kê hợp đồng mua vào</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Bảng kê hợp đồng bán ra</a></li>
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