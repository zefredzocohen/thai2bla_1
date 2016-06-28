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
                    <ul id="report_list">
                        <li class="tong_hop"> 
                            <h3>Tổng hợp</h3>
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/super_account'); ?>">Sổ cái tài khoản</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/detail_account'); ?>">Sổ chi tiết tài khoản</a></li><br>
                                <li class="summary"><a href="<?php echo site_url('costs/public_diary'); ?>">Nhật ký chung</a></li>
                            </ul>                            
                        </li>
                        <li class="tien"> 
                            <h3>Tiền</h3>
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/excel_export_thuchi'); ?>">Sổ quỹ tiền mặt</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/diary_proceeds'); ?>">Nhật ký thu tiền</a></li><br>
                                <li class="summary"><a href="<?php echo site_url('costs/bank_account_money'); ?>">Sổ tiền ngân hàng</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/diary_spending'); ?>">Nhật ký chi tiền</a></li>
                            </ul>                            
                        </li>             
                        <li class="mua_hang"> 
                            <h3>Mua hàng</h3>
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/tong_hop_cn_ncc'); ?>">Tổng hợp công nợ phải trả</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/report_cong_no_ncc'); ?>">Chi tiết công nợ</a></li><br>
                                <!--<li class="summary"><a href="<?php echo site_url('costs/diary_recv'); ?>">Nhật ký mua hàng</a></li>-->
                            </ul>                            
                        </li>
                        <li class="ban_hang"> 
                            <h3>Bán hàng</h3>
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/tong_hop_cnkh'); ?>">Tổng hợp công nợ phải trả</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/report_cong_no_khach_hang'); ?>">Chi tiết công nợ</a></li><br>
                                <!--<li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Nhật ký bán hàng</a></li>-->
                            </ul>                            
                        </li>
                        <li class="kho"> 
                            <h3>Kho</h3>
                            <ul class="noibat">	
                                <li class="graphical"><a href="<?php echo site_url('reports/specific_stored');?>">Mặt hàng bán theo kho</a></li>
                                <li class="graphical"><a href="<?php echo site_url('reports/reports_inventory');?>">Báo cáo hàng tồn kho</a></li><br>
                                <li class="detailed"><a href="<?php echo site_url('reports/do_item_inventory');?>">Báo cáo xuất nhập tồn</a></li>
                            </ul>                            
                        </li>
<!--                        <li class="thue"> 
                            <h3>Báo cáo thuế</h3>
                            <ul class="noibat">	
                                <li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Bảng kê hợp đồng mua vào</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Bảng kê hợp đồng bán ra</a></li><br>
                                <li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Bút toán kết chuyển cuối kỳ </a></li>
                            </ul>                            
                        </li>-->
                        <li class="tai_chinh"> 
                            <h3>Báo cáo tài chính</h3>
                            <ul class="noibat">	
                                <!--<li class="summary"><a href="<?php echo site_url('costs/audi'); ?>">Bảng cân đối phát sinh</a></li>-->
                                <li class="summary"><a href="<?php echo site_url('costs/result_business'); ?>">Kết quả hoạt động kinh doanh</a></li>
                                <li class="summary"><a href="<?php echo site_url('costs/report_cdkts'); ?>">Bảng cân đối kế toán</a></li><br>
                                
                                <li class="summary"><a href="<?php echo site_url('costs/report_dongtien'); ?>">Lưu chuyển tiền tệ</a></li>
                                <li class="summary"><a href="<?php echo site_url('reports/report_bctc'); ?>">Thuyết minh báo cáo tài chính</a></li>
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
/*#report_list > h3{
    font-size: 14px
}    */
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
.mua_hang, .ban_hang{
    height: 44px !important;
}
.tai_chinh{
    height: 128px !important;
}
</style>