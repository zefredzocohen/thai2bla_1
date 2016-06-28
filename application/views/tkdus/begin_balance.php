<!-- Hưng Audi say gOOdbye \/ -->
<?php $this->load->view('partial/header'); ?>
<div id="content_area_wrapper">
    <div id="content_area">
        <table id="title_bar_new8">
            <tr>
                <td id="title_icon">
                    <a href="<?php echo site_url()?>accountings/tong_hop" ><div class="newface_back"></div></a>
                </td>
                <td id="title" style="line-height: 22px;">&nbsp; Số dư đầu kỳ
                </td>
                <td id="title_search_new">
                </td>
            </tr>
        </table>
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
                                <li class="summary"><a href="<?php echo site_url('tkdus/tkdu_showbiz'); ?>">Số dư tài khoản</a></li>
                                <li class="summary"><a href="<?php echo site_url('tkdus/ton_kho'); ?>">Tồn kho vật tư, hàng hóa</a></li><br>
                                <li class="summary"><a href="<?php echo site_url('tkdus/cong_no_ncc'); ?>">Công nợ nhà cung cấp</a></li>
                                <li class="summary"><a href="<?php echo site_url('tkdus/cong_no_kh'); ?>">Công nợ khách hàng</a></li><br>
                                <li class="summary"><a href="<?php echo site_url('tkdus/cong_no_khac'); ?>">Công nợ khác</a></li>
                            </ul>                            
                        </li>     
                    </ul>
                </td>
            </tr>
        </table>
    </div></div>
<?php $this->load->view('partial/footer'); ?>
<style>
#title_bar_new8 {
    background: #37b2c9 none repeat scroll 0 0;
    color: #fff;
    font-size: 1.75em;
    height: 50px;
    margin: auto auto 8px 0px;
    width: 957px;
}
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
.thu_chi{
    height: 128px !important;
}
#report_list .noibat{
    margin-left: 130px
}
</style>