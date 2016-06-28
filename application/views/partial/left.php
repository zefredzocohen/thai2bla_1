<?php
//tien
echo anchor("accountings/tien", Tiền, array('class' => 'none import'));

//mua hang _new
echo anchor("accountings/mua_hang", 'Mua hàng', array('class' => 'none import'));

//ban hang _new
echo anchor("accountings/ban_hang", 'Bán hàng', array('class' => 'none import'));

// hang ton kho _new
echo anchor("accountings/hang_ton_kho", 'Hàng tồn kho', array('class' => 'none import'));

//ccdc (tbsd)
echo anchor("congcus", 'Công cụ dụng cụ', array('class' => 'none import'));

//tscd (tssd)
echo anchor("assets", 'Tài sản cố định', array('class' => 'none import'));

//thue _new
echo anchor("accountings/thue", 'Thuế', array('class' => 'none import'));

//tong hop
echo anchor("accountings/tong_hop", 'Tổng hợp', array('class' => 'none import'));

//tai khoan
echo anchor("tkdus", lang('module_tkdu'), array('class' => 'none import'));

//loai tk
echo anchor("account_type", lang('module_account_type'), array('class' => 'none import'));

//hoach dinh
echo anchor("account_plan",
        'Hoạch định tài khoản',
        array('class'=>'none import')
    );

//ngoai te
echo anchor("currencys", 'Ngoại tệ', array('class' => 'none import'));

//du toan tai chinh
echo anchor("dttcs", lang('module_dttcs'), array('class' => 'none import'));

//du toan loi nhuan du an
echo anchor("profit", lang('module_profit'), array('class' => 'none import'));

?>