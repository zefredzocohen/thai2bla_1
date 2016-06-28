<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "site/default_home";
$route['admin'] = "login";
$route['translate_uri_dashes'] = FALSE;
$route['404_override'] = '';
$route['no_access/(:any)'] = "no_access/index/$1";
$route['reports/(summary_giftcards)/(:any)'] = "reports/$1/$2";
$route['reports/summary_giftcards'] = "reports/excel_export";
$route['reports/summary_suppliers'] = "reports/date_input_summary_suppliers";
$route['reports/(summary_:any)/(:any)/(:any)/(:any)'] = "reports/$1/$2/$3/$4";
$route['reports/summary_:any'] = "reports/date_input_excel_export_items";

$route['reports/summary_payments'] = "reports/date_input_excel_export_payments";
$route['reports/summary_discounts'] = "reports/date_input_excel_export_discounts";

$route['reports/(summary_categories)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/summary_categories'] = "reports/summary_categories_input";

$route['reports/export_store'] = "reports/export_store_input";

$route['reports/detailed_imports'] = "reports/date_input_imports";
//$route['reports/summary_categories'] = "reports/date_input_excel_register_log";
$route['reports/(graphical_:any)/(:any)/(:any)/(:any)'] = "reports/$1/$2/$3/$4";
//$route['reports/graphical_:any'] = "reports/date_input";
$route['reports/graphical_:any'] = "reports/date_input_grap";
$route['reports/(inventory_:any)/(:any)'] = "reports/$1/$2";
$route['reports/inventory_:any'] = "reports/excel_export";
/** added for register log */
$route['reports/detailed_register_log'] = 'reports/date_input_excel_export_register_log';
$route['reports/(detailed_register_log)/(:any)/(:any)/(:any)'] = 'reports/$1/$2/$3/$4';
/** added for register log */
//$route['reports/graphical_summary_suppliers'] = 'reports/date_input_grap';
//$route['reports/(graphical_summary_suppliers)/(:any)/(:any)/(:any)'] = 'reports/$1/$2/$3/$4';

$route['reports/(detailed_sales)/(:any)/(:any)/(:any)'] = "reports/$1/$2/$3/$4";
$route['reports/detailed_sales'] = "reports/date_input_excel_export_detail_sales";
$route['reports/(detailed_receivings)/(:any)/(:any)/(:any)'] = "reports/$1/$2/$3/$4";
//$route['reports/detailed_receivings'] = "reports/date_input_excel_export";
$route['reports/detailed_receivings'] = "reports/date_input_receivings";
//banhang
$route['reports/(do_detailed_trading)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/do_detailed_trading'] = "reports/date_detailed_trading";
//end banhang
//tồn kho NVL
$route['reports/(do_item_inventory)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/do_item_inventory'] = "reports/date_item_inventory";

//Bc hang ton kho
$route['reports/(reports_inventory)'] = "reports/$1/$2";
$route['reports/reports_inventory'] = "reports/input_reports_inventory";
//tồn kho kiểm kho
$route['reports/(do_verifying_resport)/(:any)/(:any)'] = "reports/$1/$2/$3";
//$route['reports/do_verifying_resport'] = "reports/date_verifying_resport";
$route['reports/do_verifying_resport'] = "reports/verifying_resport_input";
//tồn kho chuyển kho
$route['reports/(do_transfer_ware)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/do_transfer_ware'] = "reports/date_transfer_ware";

$route['reports/(detailed_giftcards)/(:any)/(:any)'] = "reports/$1/$2/$3";
//$route['reports/detailed_giftcards'] = "reports/detailed_giftcards_input";
$route['reports/detailed_giftcards'] = "reports/excel_export";

$route['reports/(specific_:any)/(:any)/(:any)/(:any)'] = "reports/$1/$2/$3/$4";
$route['reports/specific_customer'] = "reports/specific_customer_input";
$route['reports/specific_employee'] = "reports/specific_employee_input";
$route['reports/specific_supplier'] = "reports/specific_supplier_input";
$route['reports/(deleted_sales)/(:any)/(:any)/(:any)'] = "reports/$1/$2/$3/$4";
$route['reports/(deleted_sales)'] = "reports/date_input_excel_export_deleted";
$route['reports/revenue_employee'] = "reports/revenue_employee_input";
$route['reports/specific_stored'] = "reports/specific_stored_input";
$route['reports/revenue_profit'] = "reports/revenue_profit_input";
$route['reports/revenue_profit_cat_item'] = "reports/revenue_profit_cat_item_input";

$route['reports/(liabilities_customer)/(:any)'] = "reports/$1/$2";
$route['reports/liabilities_customer'] = "reports/liabilities_customer_input";

$route['reports/(liabilities_supplier)/(:any)'] = "reports/$1/$2";
$route['reports/liabilities_supplier'] = "reports/liabilities_supplier_input";
//bc thu chi
$route['reports/(excel_export_costs)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/excel_export_costs'] = "reports/date_input_excel_export_cost";

$route['reports/(cost_employee)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/cost_employee'] = "reports/cost_employees_input";

$route['reports/(do_choose_date_thu)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/do_choose_date_thu'] = "reports/choose_date_thu";

$route['reports/(do_choose_date_chi)/(:any)/(:any)'] = "reports/$1/$2/$3";
$route['reports/do_choose_date_chi'] = "reports/choose_date_chi";
/* End of file routes.php */
/* Location: ./application/config/routes.php */
$route['(loai-san-pham)/(:any)/(:num)'] = 'site/default_home/category/$1';

$route['(san-pham)/(:any)/(:num).html'] = 'site/default_home/product_detail/$1';
$route['dang-nhap.html'] = 'site/agent/login';
$route['dang-ky.html'] = 'site/agent/index';
$route['gio-hang.html'] = 'site/cart';
$route['tin-tuc.html'] = 'site/news_home';
$route['thuc-don.html'] = 'site/thucdon/index/1';
$route['thuc-don/(:num).html'] = 'site/thucdon/index/$1';
$route['thuc-don/(:any).html'] = 'site/thucdon/getListItemsByCategoryUrl/$1';
$route['thuc-don/(:any)/(:num).html'] = 'site/thucdon/getListItemsByCategoryUrl/$1/$2';
$route['(tin-tuc)/(:any)/(:num).html'] = 'site/news_home/detail/$1';
$route['gioi-thieu.html'] = 'site/introductions';
$route['(gioi-thieu)/(:any)/(:num).html'] = 'site/introductions/detail/$1';
$route['giai-phap.html'] = 'site/solutions';
$route['(giai-phap)/(:any)/(:num).html'] = 'site/solutions/detail/$1';
$route['dai-ly.html'] = 'site/resellers';
$route['(dai-ly)/(:any)/(:num).html'] = 'site/resellers/detail/$1';
$route['lien-he.html'] = 'site/default_home/contact';
$route['thanh-cong.html'] = 'site/default_home/save_contact';