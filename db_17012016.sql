/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50614
Source Host           : 127.0.0.1:3306
Source Database       : trunghoa88_name1

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2016-01-17 10:43:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lifetek_abouts
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_abouts`;
CREATE TABLE `lifetek_abouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yahoo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `skype` varchar(50) CHARACTER SET latin1 NOT NULL,
  `deleted` int(1) DEFAULT '0',
  `active` int(1) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `parts_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `fax` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_abouts
-- ----------------------------
INSERT INTO `lifetek_abouts` VALUES ('1', 'support.lifetek', 'support.lifetek', '0', '1', '', '2', 'support@lifetek.com.vn', '04. 3762 1194', '04. 3762 1194');

-- ----------------------------
-- Table structure for lifetek_account_plan
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_account_plan`;
CREATE TABLE `lifetek_account_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tk_co` int(11) NOT NULL,
  `tk_no` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_account_plan
-- ----------------------------
INSERT INTO `lifetek_account_plan` VALUES ('6', 'Tạm ứng', '141', '1111');
INSERT INTO `lifetek_account_plan` VALUES ('7', 'BH', '131', '111');
INSERT INTO `lifetek_account_plan` VALUES ('8', 'Chi phí nhân công', '111', '622');
INSERT INTO `lifetek_account_plan` VALUES ('9', 'chi ph van chuyen', '1562', '111');
INSERT INTO `lifetek_account_plan` VALUES ('10', 'testdemo1', '711', '111');
INSERT INTO `lifetek_account_plan` VALUES ('11', 'testdemo2', '515', '1111');
INSERT INTO `lifetek_account_plan` VALUES ('12', 'testdemo3', '511', '111');
INSERT INTO `lifetek_account_plan` VALUES ('13', 'testdemo4', '6417', '111');
INSERT INTO `lifetek_account_plan` VALUES ('14', 'testdemo5', '111', '158');
INSERT INTO `lifetek_account_plan` VALUES ('15', 'testdemo6', '344', '112');
INSERT INTO `lifetek_account_plan` VALUES ('16', 'testdemo7', '2135', '1111');
INSERT INTO `lifetek_account_plan` VALUES ('17', 'Chi cho khách hàng', '111', '521');
INSERT INTO `lifetek_account_plan` VALUES ('18', 'Chi cho khách hàng', '1111', '521');
INSERT INTO `lifetek_account_plan` VALUES ('19', 'Tài khoản trung hạn', '111', '55333');
INSERT INTO `lifetek_account_plan` VALUES ('20', 'demo', '115', '1111');
INSERT INTO `lifetek_account_plan` VALUES ('21', 'demo2', '121', '111');

-- ----------------------------
-- Table structure for lifetek_account_type
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_account_type`;
CREATE TABLE `lifetek_account_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_account_type
-- ----------------------------
INSERT INTO `lifetek_account_type` VALUES ('3', 'Nợ phải thu');
INSERT INTO `lifetek_account_type` VALUES ('6', 'Tài khoản tiền gửi');
INSERT INTO `lifetek_account_type` VALUES ('7', 'Tài khoản tiền mặt');
INSERT INTO `lifetek_account_type` VALUES ('8', 'Nguồn vốn');
INSERT INTO `lifetek_account_type` VALUES ('9', 'Tài sản ');
INSERT INTO `lifetek_account_type` VALUES ('10', 'Nợ phải trả');
INSERT INTO `lifetek_account_type` VALUES ('15', 'Doanh thu');
INSERT INTO `lifetek_account_type` VALUES ('16', 'Chi phí');
INSERT INTO `lifetek_account_type` VALUES ('17', 'Chờ phân bổ');
INSERT INTO `lifetek_account_type` VALUES ('18', 'Kho');

-- ----------------------------
-- Table structure for lifetek_acl_actions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_acl_actions`;
CREATE TABLE `lifetek_acl_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(254) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_acl_actions
-- ----------------------------
INSERT INTO `lifetek_acl_actions` VALUES ('1', 'Add');
INSERT INTO `lifetek_acl_actions` VALUES ('3', 'Delete');
INSERT INTO `lifetek_acl_actions` VALUES ('2', 'Edit');

-- ----------------------------
-- Table structure for lifetek_acl_groups
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_acl_groups`;
CREATE TABLE `lifetek_acl_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(254) NOT NULL,
  `link` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_acl_groups
-- ----------------------------
INSERT INTO `lifetek_acl_groups` VALUES ('1', '1', '10', 'Member', null);
INSERT INTO `lifetek_acl_groups` VALUES ('2', '2', '9', 'Administrator', null);
INSERT INTO `lifetek_acl_groups` VALUES ('4', '7', '8', 'Bán hàng', '0');
INSERT INTO `lifetek_acl_groups` VALUES ('6', '5', '6', 'Nội dung', '0');
INSERT INTO `lifetek_acl_groups` VALUES ('7', '3', '4', 'Kinh doanh', '0');

-- ----------------------------
-- Table structure for lifetek_acl_permissions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_acl_permissions`;
CREATE TABLE `lifetek_acl_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned NOT NULL DEFAULT '0',
  `aco_id` int(10) unsigned NOT NULL DEFAULT '0',
  `allow` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aro_id` (`aro_id`),
  KEY `aco_id` (`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_acl_permissions
-- ----------------------------
INSERT INTO `lifetek_acl_permissions` VALUES ('1', '2', '1', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('2', '4', '5', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('3', '4', '2', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('4', '4', '4', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('7', '4', '20', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('8', '1', '6', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('15', '6', '28', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('16', '6', '24', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('17', '7', '20', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('18', '7', '36', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('20', '7', '34', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('23', '1', '24', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('24', '7', '35', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('26', '7', '41', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('27', '7', '25', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('28', '7', '14', 'Y');
INSERT INTO `lifetek_acl_permissions` VALUES ('29', '7', '40', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('30', '7', '8', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('31', '7', '9', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('32', '7', '10', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('33', '7', '29', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('34', '7', '30', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('35', '7', '31', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('36', '7', '27', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('37', '7', '32', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('38', '7', '33', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('39', '7', '24', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('40', '7', '5', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('41', '7', '4', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('42', '7', '6', 'y');
INSERT INTO `lifetek_acl_permissions` VALUES ('43', '7', '7', 'N');
INSERT INTO `lifetek_acl_permissions` VALUES ('44', '7', '3', 'N');

-- ----------------------------
-- Table structure for lifetek_acl_permission_actions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_acl_permission_actions`;
CREATE TABLE `lifetek_acl_permission_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_id` int(10) unsigned NOT NULL DEFAULT '0',
  `axo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `allow` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_id` (`access_id`),
  KEY `axo_id` (`axo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_acl_permission_actions
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_acl_resources
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_acl_resources`;
CREATE TABLE `lifetek_acl_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(254) NOT NULL,
  `link` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_acl_resources
-- ----------------------------
INSERT INTO `lifetek_acl_resources` VALUES ('1', '1', '74', 'Site', null);
INSERT INTO `lifetek_acl_resources` VALUES ('2', '18', '73', 'Control Panel', null);
INSERT INTO `lifetek_acl_resources` VALUES ('3', '49', '68', 'System', null);
INSERT INTO `lifetek_acl_resources` VALUES ('4', '62', '63', 'Members', null);
INSERT INTO `lifetek_acl_resources` VALUES ('5', '52', '61', 'Access Control', null);
INSERT INTO `lifetek_acl_resources` VALUES ('6', '64', '65', 'Settings', null);
INSERT INTO `lifetek_acl_resources` VALUES ('7', '66', '67', 'Utilities', null);
INSERT INTO `lifetek_acl_resources` VALUES ('8', '59', '60', 'Permissions', null);
INSERT INTO `lifetek_acl_resources` VALUES ('9', '57', '58', 'Groups', null);
INSERT INTO `lifetek_acl_resources` VALUES ('10', '55', '56', 'Resources', null);
INSERT INTO `lifetek_acl_resources` VALUES ('11', '53', '54', 'Actions', null);
INSERT INTO `lifetek_acl_resources` VALUES ('12', '2', '17', 'Order', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('13', '15', '16', 'Calendar', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('14', '13', '14', 'Categories', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('15', '11', '12', 'Customers', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('17', '9', '10', 'Messages', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('19', '7', '8', 'Pages', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('20', '69', '72', 'Products', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('22', '5', '6', 'Admins', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('24', '37', '48', 'Interface', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('25', '46', '47', 'Support', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('26', '44', '45', 'Parts', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('27', '42', '43', 'Bottom', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('28', '29', '36', 'Content', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('29', '34', '35', 'Sections', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('30', '32', '33', 'Categories_news', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('31', '30', '31', '_Content', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('32', '40', '41', 'Positions', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('33', '38', '39', 'Banner', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('34', '3', '4', 'Orders', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('35', '50', '51', 'Filemanager', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('36', '21', '28', 'QLTT', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('37', '26', '27', 'BoTT', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('38', '24', '25', 'NhomTT', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('39', '22', '23', 'ThuocTinh', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('40', '19', '20', 'Attributes', '0');
INSERT INTO `lifetek_acl_resources` VALUES ('41', '70', '71', 'NCC', '0');

-- ----------------------------
-- Table structure for lifetek_app_config
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_app_config`;
CREATE TABLE `lifetek_app_config` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_app_config
-- ----------------------------
INSERT INTO `lifetek_app_config` VALUES ('additional_payment_types', ' trả góp,trả trước, trả ngắn hạn');
INSERT INTO `lifetek_app_config` VALUES ('address', '88 - Lý Thường Kiệt - T.T Thắng - Hiệp Hòa - Bắc Giang ');
INSERT INTO `lifetek_app_config` VALUES ('amazon_access_key', '');
INSERT INTO `lifetek_app_config` VALUES ('amazon_secret_key', '');
INSERT INTO `lifetek_app_config` VALUES ('brandname', 'SoLienLacDT');
INSERT INTO `lifetek_app_config` VALUES ('check_auto', '0');
INSERT INTO `lifetek_app_config` VALUES ('check_auto_birthday', '1');
INSERT INTO `lifetek_app_config` VALUES ('check_auto_calendar', '1');
INSERT INTO `lifetek_app_config` VALUES ('check_auto_contact', '1');
INSERT INTO `lifetek_app_config` VALUES ('company', 'Công Ty CP xây dựng và sản xuất Việt Đức');
INSERT INTO `lifetek_app_config` VALUES ('company_logo', '5');
INSERT INTO `lifetek_app_config` VALUES ('config_phone_support', '7,555,555');
INSERT INTO `lifetek_app_config` VALUES ('cong_no', '0');
INSERT INTO `lifetek_app_config` VALUES ('constract_materialed', 'HỢP ĐỒNG KINH TẾ 6');
INSERT INTO `lifetek_app_config` VALUES ('corp_bank_affiliate', 'Cầu Giấy');
INSERT INTO `lifetek_app_config` VALUES ('corp_bank_name', 'Vietcombank');
INSERT INTO `lifetek_app_config` VALUES ('corp_master_account', 'Phạm Thành Long');
INSERT INTO `lifetek_app_config` VALUES ('corp_number_account', '98756543211');
INSERT INTO `lifetek_app_config` VALUES ('currency_symbol', 'VNĐ');
INSERT INTO `lifetek_app_config` VALUES ('currency_symbol_possition', '1');
INSERT INTO `lifetek_app_config` VALUES ('date_format', 'little_endian');
INSERT INTO `lifetek_app_config` VALUES ('default_payment_type', 'Tiền mặt');
INSERT INTO `lifetek_app_config` VALUES ('default_tax_1_name', '0');
INSERT INTO `lifetek_app_config` VALUES ('default_tax_1_rate', '0');
INSERT INTO `lifetek_app_config` VALUES ('default_tax_2_cumulative', '0');
INSERT INTO `lifetek_app_config` VALUES ('default_tax_2_name', '0');
INSERT INTO `lifetek_app_config` VALUES ('default_tax_2_rate', '0');
INSERT INTO `lifetek_app_config` VALUES ('default_tax_rate', '8');
INSERT INTO `lifetek_app_config` VALUES ('delivery', '1');
INSERT INTO `lifetek_app_config` VALUES ('disable_confirmation_sale', '1');
INSERT INTO `lifetek_app_config` VALUES ('email', 'dungchip88@gmail.com');
INSERT INTO `lifetek_app_config` VALUES ('email_cc', '');
INSERT INTO `lifetek_app_config` VALUES ('enable_credit_card_processing', '1');
INSERT INTO `lifetek_app_config` VALUES ('expired_contract', '30');
INSERT INTO `lifetek_app_config` VALUES ('fax', '04 6265 00655');
INSERT INTO `lifetek_app_config` VALUES ('gasoline', '88,888,885');
INSERT INTO `lifetek_app_config` VALUES ('hide_signature', '1');
INSERT INTO `lifetek_app_config` VALUES ('hide_suspended_sales_in_reports', '1');
INSERT INTO `lifetek_app_config` VALUES ('language', 'vietnam');
INSERT INTO `lifetek_app_config` VALUES ('mail_template', '7');
INSERT INTO `lifetek_app_config` VALUES ('mail_template_birthday', '2');
INSERT INTO `lifetek_app_config` VALUES ('mail_template_calendar', '1');
INSERT INTO `lifetek_app_config` VALUES ('mail_template_contact', '1');
INSERT INTO `lifetek_app_config` VALUES ('mailchimp_api_key', '33db57921a738d9e0c774c9f222979bc');
INSERT INTO `lifetek_app_config` VALUES ('meals', '66,665');
INSERT INTO `lifetek_app_config` VALUES ('merchant_id', 'admin');
INSERT INTO `lifetek_app_config` VALUES ('merchant_password', '12345678');
INSERT INTO `lifetek_app_config` VALUES ('nghiemthu_suspended', 'BIÊN BẢN BÀN GIAO, NGHIỆM THU 7');
INSERT INTO `lifetek_app_config` VALUES ('number_of_items_per_page', '10');
INSERT INTO `lifetek_app_config` VALUES ('pass_email', 'dungchiplananh');
INSERT INTO `lifetek_app_config` VALUES ('pass_sms', 'v1m4@2e3');
INSERT INTO `lifetek_app_config` VALUES ('phone', ': 02403 569 869   DĐ: 0904 998 438 - 0936 629 222 - 0962 352 333.');
INSERT INTO `lifetek_app_config` VALUES ('phone_support', '100000');
INSERT INTO `lifetek_app_config` VALUES ('print_after_sale', '1');
INSERT INTO `lifetek_app_config` VALUES ('print_excel', 'print');
INSERT INTO `lifetek_app_config` VALUES ('private_bank_affiliate', 'Cầu Giấy');
INSERT INTO `lifetek_app_config` VALUES ('private_bank_name', 'Vietcombankk');
INSERT INTO `lifetek_app_config` VALUES ('private_master_account', 'Phạm Thành Longg');
INSERT INTO `lifetek_app_config` VALUES ('private_number_account', '9876543211');
INSERT INTO `lifetek_app_config` VALUES ('receive_stock_alert', '0');
INSERT INTO `lifetek_app_config` VALUES ('report_logo', 'logo.png');
INSERT INTO `lifetek_app_config` VALUES ('return_policy', 'LifeOne');
INSERT INTO `lifetek_app_config` VALUES ('speed_up_search_queries', '0');
INSERT INTO `lifetek_app_config` VALUES ('stock_alert_email', 'luuthithanh2009@gmail.com');
INSERT INTO `lifetek_app_config` VALUES ('thanhly_suspended', 'BIÊN BẢN THANH LÝ HỢP ĐỒNG 8');
INSERT INTO `lifetek_app_config` VALUES ('time_format', '24_hour');
INSERT INTO `lifetek_app_config` VALUES ('timezone', 'Asia/Bangkok');
INSERT INTO `lifetek_app_config` VALUES ('title_contract', 'CUNG CẤP PHẦN MỀM  ỨNG DỤNG');
INSERT INTO `lifetek_app_config` VALUES ('track_cash', '0');
INSERT INTO `lifetek_app_config` VALUES ('user_sms', 'vmic');
INSERT INTO `lifetek_app_config` VALUES ('website', 'www.lifetek.com.vnn');

-- ----------------------------
-- Table structure for lifetek_app_files
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_app_files`;
CREATE TABLE `lifetek_app_files` (
  `file_id` int(10) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_data` longblob NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_app_files
-- ----------------------------
INSERT INTO `lifetek_app_files` VALUES ('5', 'logo.png', 0x89504E470D0A1A0A0000000D49484452000000430000003C08060000003DBE076700000E09494441546881EDDA7F8CDF757D07F0C7EB766B6E4DD335BD5BD7740721E5C40E0956C71011B1634814C360F8B3A8DB1C2AC2550921841C0B316C911B0162982D4C71BA69D20386E81C43C6109131C4828CD4AA5D3DBA5A0ED275D7E6D23497EE72B9D7FE787DEE47DBEBF5EEDAF217AFE4D3EFF5F3797FDE9FF7EBF97EFD7EBD799D5EA7D7E9759A3DC56BF1913D9D5D8465D25BF10EAC4A4E0E96A2AD1936867DD885EDC973C1A694DB3A065E3AF05AACF38482B1A7F30DADE459F8282E52CCEFC2D6E67A4501309A2C0C3A702A4EC7C9588C17D08787B1BB7DA0FF84ADF7848031D8D9D512ACC6750A84A1E4BBC13FE355C5E432ACC012B46238D91DF57C2FC6C8B3B19638ABDECB7B88FBDA07FA874EC4BA8F3B187B3ABB96A4FC7488CFE200BE8CEFA023B934B8C0E4AE2F400B4884510C2B305E50E03DA340BB166BC8E7899BC9E7DB075E1A3B9E6B3FAE60ECE9ECEAC21770211EC29794045C85354A0DE64223D8866F2A40DF8ABFC042FC1536B60FF48F1C8FB5731CC1D8D3D975063660A502E40974E363589A521CE173E3CF72DA052562142F36F36E57409C8BDB84F5ED2FF71F17037B5CC0D8D3D9751ABE8EE5CA4EEC4E793B716E8CABC134742840D9C071E8A2A6803514DC89FB70232EC7171A408E59425A8F7582C1934EED90BEA8ECC0D5CA4E7C3DC4AAF1313349C5D4E7C5F0E1F231FE6E94B1BD19BF8DDB94CDE99176EDF99DAE8DEDAF1C9BA7392630F67476B54A372891BD0E43F83B9C3675DC918098548D9872EFA8B4009FC1A8529B154A6D3663CB9C9998424714E159D21A7C32F986B2FAB76B80A81D9E917661FF38F3CDF857A529E27EC4395A1520EF5106B555B865EF496F683BD20BB3A17983B1A7B3AB4D89ECAE28AF713DCE1E7F3E935A34F404764C193F9AF2E18CD85B77A637A753A88DBC11ADC95DB828332F9E332353E85824E362C5FC5D4A1A3E34DD7C33C8C78F3030E5FF23217E14253166A3302956E0C628B7BB15D7EF39A96BDED2312F30F67476B5A4BC1AFD785405444BA61B7BB86720E588D2EF81BA9754B0B54DB9CE59500A64BA00672A5BB55A3A6F6EDC4C50CB9CC1D8D3D905AB429C83FBD1857366FB7EE3170615D3FF8DB146A5F6A950FC102398CDBF87CA588CFF2CC2C7D5A60CE2E37B3A4F9D353F5369BE6A7281B2EADFC52558349797A3246228E5F634613077A51CC24F0F1BEDC84A53FEC8B959E1FD53389F583C97F5343477C9205BF0874A4777298FB2193BA719BC5F458E9B9AF1E3B4451A267628F590EC8C887D4A32F61F32CF5EE245A54653F39141E2E73810E5DEBFA75CED2AF3A0F948465BB22AE56615712E243F9C15199AB00A3C9DE9ED781BFE2033AF9B22E8CF09A35159EABE461576B4BFDC3F26ED36E165927477CA37E35DB84101358CBFC49BF14EF436DFD98231E98C469DE74263F300239604CB42FC1427930B8896C9B03B2403C1551196E027E4AF44DCDF88FA18B664D52C5AB18B18C17F0D76769DDDE843134AC67784EB42BC073F53758D45F85B057E377EA13CDA29D88D41E18D478D72A6A1F948C6E2948B8A09CB89C3A2D8104F2ABBD08365C4B69874A3BBB153E6F94AA477262351005EA22A5FFFA922CC7B1560BFA782BA4D2ABDFFA64A083F59F36B6B7E35CF3BE7C1DBD87CC2F1B6100B94B8AE4C5AA649ACF64681D481C79478AF563ABD037B45BCA59963475418BFBF19B34CD9A031E51D4695DB6CC5598AD121950B2D9CF2D98568218753B4CD27039D3318C9584CF3B7837622CE54CC3CA5C2E69FE2F9E6E1D6946321BAF02BBCA4B2DC911027E39494DB94513C2FC58B51127661B3DE16AC4E9E8F52A7D5CDBC63528B88C33667B6346730A2B2D203AA6639D4303DD6307B075A43AE213E90F2CE10FFA3AA560DE5738DEB5BA93CD00BD811A24DA9CDE90AC49D29AE8BA62E925C16FC3EAEC00DC1952ABEB85819CFD39A4A591BF6BF5636635F732D5776A355254CCBF11C7E4C1CC06D216E54B6A243B9BEB16473B022E592069061726BF3FE12BC29C47088FE2895F8363E4B0EABA08C0AF2EEC765CDBD57952D1A6BE6D81907BBE059D17C6CC65003C2EFE201DC83DF6AAE717A028F2BB0DFA4F4F963188C8A2DCE0FB150017080F8B1CA6F5A9564B428237A99C6CD86786333F71D53BEF31B29DF18625FB38EA5CDF58BCCB9CBC63CD42446526E51BA3A983C5625FE1C1BAF4DD46F3689675006F167F884328A6F51116C4763809FC2FB9A4FACA82BB7E019E24F95842C35F36EBF909CD7B8F82D1DAFBC3457D6E66340730CDF57BB765AF0C758879683D3F6981A433FAD80F879E346CF6802B3C55199E7161375108B82538867F109E17C997729499AB60EA624F5D2284077E6449C32379AB3CD689A384FE040CA0FE39F30AC0C601BDAA2F99D725D887B93FEA81C626553F168ADBF2D512A234A62CE50B9CA19D206939DB7C3E66EFEFF340E9017E1D18E81FEE1D7040CC8B4038F87F88812FB471DDD60BD274AAF4F37D13208AA83D6A118A6007A738D8F2F63F1F4695A369741558CBE2CC5226558E745F302A3E3957E598C75A4FCA8AA74BD7A94D7E003CDD8A959EECAACD862714E3278A18A3E3B8E5C1E0AC458663E98F2555C193C9593F1CC9C69DE95AE28D17C2CC4A79B5B77A9A2CD116882A9B72A5518A7E5C11921DACAE6046530574C7CE9E0F7A7D2E688F85288ABB14CBAB363A07F743EFC700C60B40FF48F6655A5C7925BF020F18043D465BC283383A35B46BEA3461E3A2A67FA6B972A06AFC29FE081AC0D9A37FDDAB1BC7CE36F2EDDA598FFB390ADC41D8DDF5FA9D9D2F1D2CC0C05E236A293F8F5F1BEC9E4D849A938E4DE106E4CB923C43D4A45AFE978E5D81AD2C7D42A687FB95F467C257880F80C2E0F71AD830CEA513385565312AEE9413BE8DEA04AFC3685D8D0BC7B43FB40FFC0342FCE898EB56FA2E3E55F0E47C40D2A3BFDBCAA9277E3AB2A8799031D356ADCAE729217B23CC829E4B5ED03FD4FCEED3BD3D33183014B5FFEE55E7C0A8F283DBE59D9912BB15D056A33D0B85D39A2148D6023F96E2571FF185558BA8A78E838B080E30406B40FF40F6645997FA332CBEFA9E4E9EDC42D6674BD472CFA8EAA00EFBD59ED88AB717F329CF2FDC443ED03FDC7ED8CC6713FAC32D8796A4B53A6BB4D59FAEF08B74BDB525E14E25255A459814593AA1194040CA970FA7195B1EEC44754C76E39FE1EB7B40FF4EF3EDE6B3F21C798F69EF40699D9813F6F4479852ADBF5E1599369FD321580B528FB329E116B6AA497927F1462B9B249B7E3D9F663882566A2137CC0ADAB45317D71CAB521C603AE01959AEFD41C70535E61992AEC9EACC2F39D291F0BF14D6C9639D23E8F6C74B67442C118A7A66CDF86E5C9EA9067AAFAC4783157CAD1A62E31A0CA842FA83EC97E61B4FDE51377CA6F9C5E13300EA5069C0552AB9838E036268C61F444A9C1EB34079A5132BA7B3776C8F8488461DCB7BE67ED617582EEDEBE45385F3A799AD9C68287D7F7AC7D75CAF855584BFE2FF1B50DCD9CEB7AFB5A928BA5B745F8BF4C5FDB70D3E47BEB7AFB1690E7C85895B44CF69D8DA86FECEEBEB58FB09CBC80586CBCF457D5B6FE0D3D6B1F9F89DF192B5D215608BD5931C2239ABEE8414054F1E572916D13CB8324E470466C75708CF151DC24DD277C75FC66662E26AE17D6245B83F5E3CFAEE9ED6B4D6E26AE1179507D23198AB459C5342B65F68958DDB40DA6F0E241E5AEE707C6645C182D4788942F173E847DC457C93D53BF9E62CC94867477EFC605D245CDF31FE0FC75BD7D4FAEEF593B8295C2E9CD279FCEB0B2FBD6BE2D1B6E5A3B127528E673B5DEF81A5E9EB286910CAFAEEBED5B90E9461167AB26775F6387A0256771DE6B5635D0C9BAEE2475F7F6C1079537B823E52D77F75C31B3E1CB388D5C256290D88E9E64DBBADEBE1D29CF516EF84003544F86EB1598EF8FCC4519F16072FDDD3D6B0FEDD25BD7DBB742B858A9CD0DC2C31B7AD6CE86BD099A051885C2E182916DC4191891F91F77DF74C5E8BADEBE16B466E6047AC1E8FA9EB5633547AE09B1487A16A7883C875893F201E2DD2AF8DA2B0D08E7453AB7BBB76F006766440B7E182C5877EBC6E5191319EE1839949C227508BBF1CC5C81982518D35388C5A5E70ED44E83B3926B45B434C7094645F4E2E7DDBD1B5BF05EB448FF8A77AA9AE5FBF182B4BAC17D930AD597AB46F44326EBA3BB7067469CC5C406ED27AE96B95444AB6A3CCFABAE314B3066A8431EAC3E2B94476815B15019DC7B6B8A582E9CDBDC7B527857DDCF3111AB85151895BE1F6177322AAC69AAE92D5356D0A64E01302119E3CB4C22E69DB81D058CF12EC5E11FC88A0CF7A986CFD2E6DE33F8A0C825C46D229725AEB9B50F792EB1447A3E427FF22D5C24E20732DF492C1006F1745614DA4F9E96E9ACD0485E5886CF865830059C31EC8D88859939AAA468899290E309C6C4B6B7910BBA7B3792E345DB1C96B945C429917176776FDF131B7AD6EEC6E3DDBD7DCBC8FDC43288D0425CD2C0F8948C61E151A51E55B0A94F6D8DC8FEAC5EED535825E2924C5B840BD5299D6FACEF593BE8105AD7DBB7A351D7E5C159EB7A373EB6BEE78A398171B4A06B15FE5D5A2C3C40FC64CAE34DAA0B760F86A47BC8C166CA45B856582CBD4F7851B5175790EF969E8808C9C5E442195FC74291B786B8B9D9F5CBF02D723B7195F46DA145FA8AF0D2F829A064387824D9276D103E197532E85E9500521E66FB869EB54FCCC4EFD12463179E152E22AFA86B02C3BF5667A9DEADE28DCFCB711BD2F459C5FEC6AC9C8D15C90E62F3869BCAD2AFEBED7B24B95D6823F7113F5CDF7881EEDEBE4DCA609EAC54E16ED5C6FC1C5936248988BDE4D60D3D576CEABEB5AF1767A73C9DF8E2041B654B1E5485A2F981B1A167ED5077EFC64FD441D3581251F336F2B439EAB4CDA7927F08968BC6D06588486AE7B6293DBE32D825277539534B44FC1B7E460C2B691B7FB88BB82A4247CADD223E4FFE0B5686689974DF39D2C42C226CAFCD89F3EBA85539DF2C373FCBC3B6AFD3EB7428FD3F03CF151DB8B2B1580000000049454E44AE426082);

-- ----------------------------
-- Table structure for lifetek_assets
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_assets`;
CREATE TABLE `lifetek_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asset_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `lydotang` text COLLATE utf8_unicode_ci NOT NULL,
  `date_tang` date NOT NULL,
  `date_kh` date NOT NULL,
  `ky_khauhao` int(11) NOT NULL,
  `ppkh` int(11) NOT NULL,
  `tktk` int(11) NOT NULL,
  `tkkh` int(11) NOT NULL,
  `tkcp` int(11) NOT NULL,
  `id_tstb` int(11) NOT NULL,
  `id_bpsd` int(11) NOT NULL,
  `value_remain` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `allocate` int(11) NOT NULL,
  `han_khauhao` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_assets
-- ----------------------------
INSERT INTO `lifetek_assets` VALUES ('1', 'Tivi samsung 42 inch', '1', '0', '', '2015-09-14', '2015-09-14', '4', '0', '2133', '214', '6422', '0', '0', '12000000', '24000000', '0', '2016-01-14');
INSERT INTO `lifetek_assets` VALUES ('7', 'Máy Khâu', 'MM', '0', 'mua mới', '2015-11-18', '2015-11-18', '12', '0', '0', '242', '142', '0', '0', '0', '2000000', '0', '2016-11-18');
INSERT INTO `lifetek_assets` VALUES ('8', 'Máy Giặt Là', 'MGL', '0', '', '2015-11-18', '2015-11-18', '12', '0', '0', '242', '142', '0', '0', '0', '4000000', '0', '2016-11-18');

-- ----------------------------
-- Table structure for lifetek_bangcap
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_bangcap`;
CREATE TABLE `lifetek_bangcap` (
  `id_bangcap` int(11) NOT NULL AUTO_INCREMENT,
  `nam_bangcap` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_bangcap`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_bangcap
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_bank_account
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_bank_account`;
CREATE TABLE `lifetek_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account` int(11) NOT NULL,
  `receiving_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_bank_account
-- ----------------------------
INSERT INTO `lifetek_bank_account` VALUES ('1', '11211', '832', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('2', '11211', '833', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('3', '11211', '846', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('4', '11211', '0', '2506', '0');
INSERT INTO `lifetek_bank_account` VALUES ('5', '11212', '847', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('6', '11211', '0', '2508', '0');
INSERT INTO `lifetek_bank_account` VALUES ('7', '11212', '0', '2509', '0');
INSERT INTO `lifetek_bank_account` VALUES ('8', '11212', '0', '0', '2013');
INSERT INTO `lifetek_bank_account` VALUES ('9', '11211', '0', '2510', '0');
INSERT INTO `lifetek_bank_account` VALUES ('10', '11212', '0', '2511', '0');
INSERT INTO `lifetek_bank_account` VALUES ('11', '11211', '0', '2517', '0');
INSERT INTO `lifetek_bank_account` VALUES ('12', '11212', '0', '0', '2030');
INSERT INTO `lifetek_bank_account` VALUES ('13', '11211', '849', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('14', '11212', '851', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('15', '11212', '0', '2522', '0');
INSERT INTO `lifetek_bank_account` VALUES ('16', '11212', '0', '2523', '0');
INSERT INTO `lifetek_bank_account` VALUES ('17', '11212', '0', '2524', '0');
INSERT INTO `lifetek_bank_account` VALUES ('18', '11212', '0', '2525', '0');
INSERT INTO `lifetek_bank_account` VALUES ('19', '11212', '0', '2526', '0');
INSERT INTO `lifetek_bank_account` VALUES ('20', '11212', '0', '2527', '0');
INSERT INTO `lifetek_bank_account` VALUES ('21', '11212', '0', '2528', '0');
INSERT INTO `lifetek_bank_account` VALUES ('22', '11212', '0', '2529', '0');
INSERT INTO `lifetek_bank_account` VALUES ('23', '11212', '0', '2530', '0');
INSERT INTO `lifetek_bank_account` VALUES ('24', '11212', '0', '2531', '0');
INSERT INTO `lifetek_bank_account` VALUES ('25', '11212', '0', '2532', '0');
INSERT INTO `lifetek_bank_account` VALUES ('26', '11212', '860', '0', '2066');
INSERT INTO `lifetek_bank_account` VALUES ('28', '11211', '861', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('31', '11211', '0', '2539', '0');
INSERT INTO `lifetek_bank_account` VALUES ('32', '11212', '0', '2540', '0');
INSERT INTO `lifetek_bank_account` VALUES ('33', '11212', '0', '2542', '2072');
INSERT INTO `lifetek_bank_account` VALUES ('34', '11211', '0', '2544', '2074');
INSERT INTO `lifetek_bank_account` VALUES ('35', '11211', '0', '0', '2077');
INSERT INTO `lifetek_bank_account` VALUES ('36', '11212', '0', '2548', '2087');
INSERT INTO `lifetek_bank_account` VALUES ('37', '11212', '0', '2551', '2090');
INSERT INTO `lifetek_bank_account` VALUES ('40', '11212', '0', '2552', '2102');
INSERT INTO `lifetek_bank_account` VALUES ('41', '11212', '0', '0', '2103');
INSERT INTO `lifetek_bank_account` VALUES ('42', '11212', '0', '0', '2104');
INSERT INTO `lifetek_bank_account` VALUES ('43', '11212', '0', '0', '2108');
INSERT INTO `lifetek_bank_account` VALUES ('46', '11212', '0', '2556', '2133');
INSERT INTO `lifetek_bank_account` VALUES ('47', '11212', '0', '2557', '2134');
INSERT INTO `lifetek_bank_account` VALUES ('50', '11212', '0', '0', '2149');
INSERT INTO `lifetek_bank_account` VALUES ('51', '0', '0', '0', '2148');
INSERT INTO `lifetek_bank_account` VALUES ('52', '11212', '0', '0', '2154');
INSERT INTO `lifetek_bank_account` VALUES ('53', '11211', '0', '2569', '2155');
INSERT INTO `lifetek_bank_account` VALUES ('54', '11212', '0', '2571', '2157');
INSERT INTO `lifetek_bank_account` VALUES ('55', '11212', '0', '2572', '2158');
INSERT INTO `lifetek_bank_account` VALUES ('56', '11212', '0', '2577', '2163');
INSERT INTO `lifetek_bank_account` VALUES ('57', '11212', '0', '2578', '2164');
INSERT INTO `lifetek_bank_account` VALUES ('58', '11212', '0', '2579', '2165');
INSERT INTO `lifetek_bank_account` VALUES ('59', '11212', '0', '2580', '2166');
INSERT INTO `lifetek_bank_account` VALUES ('60', '11212', '0', '2585', '2174');
INSERT INTO `lifetek_bank_account` VALUES ('61', '11211', '0', '2589', '2183');
INSERT INTO `lifetek_bank_account` VALUES ('62', '11212', '0', '2590', '2184');
INSERT INTO `lifetek_bank_account` VALUES ('63', '11211', '0', '2592', '2186');
INSERT INTO `lifetek_bank_account` VALUES ('64', '11211', '0', '2593', '2187');
INSERT INTO `lifetek_bank_account` VALUES ('65', '11212', '0', '2595', '2194');
INSERT INTO `lifetek_bank_account` VALUES ('66', '11212', '0', '2597', '2199');
INSERT INTO `lifetek_bank_account` VALUES ('67', '11212', '0', '2603', '2206');
INSERT INTO `lifetek_bank_account` VALUES ('68', '11212', '0', '2609', '2213');
INSERT INTO `lifetek_bank_account` VALUES ('69', '11212', '0', '2613', '2217');
INSERT INTO `lifetek_bank_account` VALUES ('70', '11211', '0', '2616', '2220');
INSERT INTO `lifetek_bank_account` VALUES ('71', '11211', '0', '2624', '2228');
INSERT INTO `lifetek_bank_account` VALUES ('72', '11212', '0', '2642', '2247');
INSERT INTO `lifetek_bank_account` VALUES ('73', '11212', '939', '0', '2434');
INSERT INTO `lifetek_bank_account` VALUES ('74', '11213', '940', '0', '2435');
INSERT INTO `lifetek_bank_account` VALUES ('75', '11213', '942', '0', '2444');
INSERT INTO `lifetek_bank_account` VALUES ('76', '11211', '945', '0', '2510');
INSERT INTO `lifetek_bank_account` VALUES ('77', '11211', '0', '2699', '2480');
INSERT INTO `lifetek_bank_account` VALUES ('78', '11211', '952', '0', '2482');
INSERT INTO `lifetek_bank_account` VALUES ('79', '11212', '956', '0', '2499');
INSERT INTO `lifetek_bank_account` VALUES ('80', '11211', '957', '0', '0');
INSERT INTO `lifetek_bank_account` VALUES ('81', '11211', '958', '0', '2501');
INSERT INTO `lifetek_bank_account` VALUES ('82', '11211', '0', '2714', '2517');
INSERT INTO `lifetek_bank_account` VALUES ('83', '11212', '0', '2717', '2520');
INSERT INTO `lifetek_bank_account` VALUES ('84', '11212', '0', '2718', '2521');
INSERT INTO `lifetek_bank_account` VALUES ('85', '11212', '963', '0', '2528');
INSERT INTO `lifetek_bank_account` VALUES ('86', '11211', '0', '2734', '2578');
INSERT INTO `lifetek_bank_account` VALUES ('87', '11211', '0', '2752', '2609');
INSERT INTO `lifetek_bank_account` VALUES ('88', '11211', '0', '2786', '2645');
INSERT INTO `lifetek_bank_account` VALUES ('89', '11212', '0', '2789', '2651');
INSERT INTO `lifetek_bank_account` VALUES ('90', '11211', '0', '2790', '2658');
INSERT INTO `lifetek_bank_account` VALUES ('91', '11211', '985', '0', '2825');
INSERT INTO `lifetek_bank_account` VALUES ('92', '11211', '987', '0', '2829');
INSERT INTO `lifetek_bank_account` VALUES ('93', '11211', '0', '2858', '2844');
INSERT INTO `lifetek_bank_account` VALUES ('94', '11211', '0', '2859', '2845');
INSERT INTO `lifetek_bank_account` VALUES ('95', '11211', '0', '2866', '2863');
INSERT INTO `lifetek_bank_account` VALUES ('96', '11212', '1018', '0', '2922');
INSERT INTO `lifetek_bank_account` VALUES ('97', '11211', '1034', '0', '2968');
INSERT INTO `lifetek_bank_account` VALUES ('98', '11211', '0', '2925', '3012');
INSERT INTO `lifetek_bank_account` VALUES ('99', '11212', '0', '2929', '3023');
INSERT INTO `lifetek_bank_account` VALUES ('100', '11211', '0', '2961', '3148');
INSERT INTO `lifetek_bank_account` VALUES ('101', '11211', '0', '2974', '3202');
INSERT INTO `lifetek_bank_account` VALUES ('102', '11212', '0', '3000', '3270');
INSERT INTO `lifetek_bank_account` VALUES ('103', '11211', '0', '3034', '3384');
INSERT INTO `lifetek_bank_account` VALUES ('104', '11211', '0', '3069', '3457');
INSERT INTO `lifetek_bank_account` VALUES ('105', '11212', '0', '3131', '3680');
INSERT INTO `lifetek_bank_account` VALUES ('106', '11211', '0', '3186', '3991');
INSERT INTO `lifetek_bank_account` VALUES ('107', '11211', '0', '3246', '4125');

-- ----------------------------
-- Table structure for lifetek_bill_cost
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_bill_cost`;
CREATE TABLE `lifetek_bill_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cus` int(11) NOT NULL,
  `date` date NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `id_recv` int(11) NOT NULL,
  `tk_co` int(11) NOT NULL,
  `symbol_order` varchar(255) NOT NULL,
  `number_order` varchar(255) NOT NULL,
  `date_order` date NOT NULL,
  `code_taxe` varchar(255) NOT NULL,
  `money` decimal(15,0) NOT NULL,
  `taxe_percent` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_bill_cost
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_bpsd
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_bpsd`;
CREATE TABLE `lifetek_bpsd` (
  `id_bpsd` int(11) NOT NULL AUTO_INCREMENT,
  `name_bpsd` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `desc_bpsd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_bpsd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_bpsd
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_categories_item
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_categories_item`;
CREATE TABLE `lifetek_categories_item` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `code_cat` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mã tự quy định',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_name` text COLLATE utf8_unicode_ci NOT NULL,
  `parentid` int(11) NOT NULL,
  `parent_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `anh` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `cat_service` tinyint(4) NOT NULL COMMENT '0: Loại sản phẩm - 1: Loại dịch vụ',
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_categories_item
-- ----------------------------
INSERT INTO `lifetek_categories_item` VALUES ('90', 'desserts', 'desserts', 'desserts', '0', '', '0', null, '0', '0', 'desserts', 'upload/categories/desserts1.png', '');
INSERT INTO `lifetek_categories_item` VALUES ('91', 'ice cream', 'ice cream', 'ice cream', '0', '', '0', null, '0', '0', 'ice-cream', 'upload/categories/ice-cream1.png', '');
INSERT INTO `lifetek_categories_item` VALUES ('92', 'smoothies', 'smoothies', 'smoothies', '0', '', '0', null, '0', '0', 'smoothies', 'upload/categories/smoothies1.png', '');
INSERT INTO `lifetek_categories_item` VALUES ('93', 'tea', 'tea', 'tea', '0', '', '0', null, '0', '0', 'tea', 'upload/categories/tea1.png', '');
INSERT INTO `lifetek_categories_item` VALUES ('94', 'bread', 'bread', 'bread', '0', '', '0', null, '0', '0', 'bread', 'upload/categories/bread1.png', '');
INSERT INTO `lifetek_categories_item` VALUES ('95', 'XoiChe', 'XoiChe', 'XoiChe', '0', '', '0', null, '0', '0', 'xoiche', 'upload/categories/trovehanhtinh.jpg', '');
INSERT INTO `lifetek_categories_item` VALUES ('96', '44444444444', '4', '4', '0', '', '0', null, '0', '0', '4', null, '\0');
INSERT INTO `lifetek_categories_item` VALUES ('97', '1', '1', '1', '0', '', '0', null, '0', '0', '1', null, '\0');

-- ----------------------------
-- Table structure for lifetek_category_processes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_category_processes`;
CREATE TABLE `lifetek_category_processes` (
  `cat_pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_pro_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`cat_pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_category_processes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_chungtus
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_chungtus`;
CREATE TABLE `lifetek_chungtus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` date NOT NULL,
  `diachi_lap` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diachi_nhan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `noidung` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_chungtus
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_chungtu_detail
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_chungtu_detail`;
CREATE TABLE `lifetek_chungtu_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chungtu_id` int(11) NOT NULL,
  `sotien` decimal(15,0) NOT NULL,
  `tk_no` int(11) NOT NULL,
  `tk_co` int(11) NOT NULL,
  `mark` int(11) NOT NULL COMMENT '0: chứng từ, 1: hóa đơn dịch vụ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_chungtu_detail
-- ----------------------------
INSERT INTO `lifetek_chungtu_detail` VALUES ('5', '4', '8600', '111', '1113', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('6', '4', '9999', '1123', '1212', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('7', '4', '8888', '1281', '1131', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('15', '8', '2421180', '6422', '3383', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('16', '8', '403530', '6422', '3384', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('17', '8', '134510', '6422', '3388', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('18', '9', '100000', '0', '0', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('19', '10', '10000000', '622', '3341', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('20', '10', '1000000', '0', '0', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('21', '11', '100000', '1121', '1131', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('22', '2', '0', '0', '0', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('23', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('24', '6', '10000', '111', '331', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('25', '6', '20000', '111', '243', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('26', '6', '30000', '111', '331', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('27', '3', '100000', '111', '331', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('28', '3', '120000', '111', '2288', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('29', '13', '2', '1113', '1111', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('30', '14', '15000', '331', '711', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('33', '15', '1000', '128', '1281', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('34', '15', '500000', '1281', '1132', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('35', '16', '100000', '128', '1123', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('49', '2', '1000000', '1111', '1112', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('53', '3', '1233330', '1211', '1212', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('54', '4', '3333333330', '1131', '1122', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('58', '1', '80000', '1113', '2133', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('59', '1', '1000', '1212', '1281', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('62', '17', '10', '1111', '1212', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('63', '17', '800', '1122', '1121', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('64', '5', '100000', '111', '113', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('65', '5', '100000', '2133', '1281', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('68', '6', '200000', '1211', '113', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('69', '6', '100000', '11211', '11211', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('70', '6', '100000', '113', '11212', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('74', '7', '500000', '1211', '1211', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('75', '7', '1000000', '1211', '1131', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('78', '8', '100000000', '1211', '1212', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('90', '12', '10000000', '1212', '1132', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('95', '13', '1400000', '1211', '1122', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('97', '10', '10000000', '1212', '121', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('98', '11', '230000', '1132', '1212', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('106', '9', '234000', '1131', '1132', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('110', '16', '10000000000', '121', '1132', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('111', '14', '200000', '121', '1131', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('112', '15', '90000000', '121', '113', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('115', '17', '100000', '128', '1131', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('116', '17', '200000', '1123', '11212', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('117', '7', '120000', '622', '334', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('118', '7', '100000', '642', '334', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('121', '18', '10000000', '1211', '121', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('122', '18', '20000000', '113', '121', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('124', '18', '145222000', '642', '11211', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('125', '19', '450000', '1211', '1211', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('126', '19', '10', '1211', '1132', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('128', '20', '50000000', '211', '331', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('129', '20', '12000000', '242', '331', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('131', '21', '1000000', '1121', '1332', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('132', '23', '111', '1332', '1123', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('133', '24', '200000', '1332', '138', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('134', '25', '150000', '1331', '121', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('135', '26', '135000', '1332', '121', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('138', '27', '100000', '1331', '133', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('139', '27', '200000', '121', '133', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('141', '28', '100000', '121', '131', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('142', '29', '200000', '131', '11212', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('143', '30', '200000', '131', '111', '1');
INSERT INTO `lifetek_chungtu_detail` VALUES ('144', '20', '200000', '131', '11211', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('145', '21', '2000000', '131', '111', '0');
INSERT INTO `lifetek_chungtu_detail` VALUES ('146', '22', '200000', '131', '331', '0');

-- ----------------------------
-- Table structure for lifetek_cities
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_cities`;
CREATE TABLE `lifetek_cities` (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `zip_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  PRIMARY KEY (`id_city`),
  UNIQUE KEY `zip_code` (`zip_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_cities
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_ci_sessions`;
CREATE TABLE `lifetek_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `user_data` text NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_ci_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_clip
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_clip`;
CREATE TABLE `lifetek_clip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `des` text,
  `anh` varchar(300) DEFAULT NULL,
  `anh_con` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_clip
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_comments
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_comments`;
CREATE TABLE `lifetek_comments` (
  `id_comment` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(20) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `dateport` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_comments
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_congcus
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_congcus`;
CREATE TABLE `lifetek_congcus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `congcu_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_parent` int(11) NOT NULL,
  `lydotang` text COLLATE utf8_unicode_ci NOT NULL,
  `date_tang` date NOT NULL,
  `date_kh` date NOT NULL,
  `ky_khauhao` int(11) NOT NULL,
  `ppkh` int(11) NOT NULL,
  `tktk` int(11) NOT NULL,
  `tkkh` int(11) NOT NULL,
  `tkcp` int(11) NOT NULL,
  `id_tstb` int(11) NOT NULL,
  `id_bpsd` int(11) NOT NULL,
  `value_remain` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `allocate` int(11) NOT NULL,
  `han_khauhao` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_congcus
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_cong_no_kh
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_cong_no_kh`;
CREATE TABLE `lifetek_cong_no_kh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  `oh_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_cong_no_kh
-- ----------------------------
INSERT INTO `lifetek_cong_no_kh` VALUES ('23', '2183', '100000', '0', '2015');
INSERT INTO `lifetek_cong_no_kh` VALUES ('24', '2250', '12000', '0', '2015');
INSERT INTO `lifetek_cong_no_kh` VALUES ('25', '2134', '100000', '0', '2015');
INSERT INTO `lifetek_cong_no_kh` VALUES ('26', '2277', '100000', '0', '2015');

-- ----------------------------
-- Table structure for lifetek_cong_no_khac
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_cong_no_khac`;
CREATE TABLE `lifetek_cong_no_khac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) NOT NULL,
  `code` varchar(25) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_cong_no_khac
-- ----------------------------
INSERT INTO `lifetek_cong_no_khac` VALUES ('10', '111', '1a', 'hung', '1000', '1200');
INSERT INTO `lifetek_cong_no_khac` VALUES ('11', '122', '2v', 'thuong', '2000', '2400');
INSERT INTO `lifetek_cong_no_khac` VALUES ('12', '0', '', '', '0', '0');
INSERT INTO `lifetek_cong_no_khac` VALUES ('13', '0', '', '', '0', '0');

-- ----------------------------
-- Table structure for lifetek_cong_no_ncc
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_cong_no_ncc`;
CREATE TABLE `lifetek_cong_no_ncc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  `oh_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_cong_no_ncc
-- ----------------------------
INSERT INTO `lifetek_cong_no_ncc` VALUES ('56', '2240', '0', '100000', '2010');
INSERT INTO `lifetek_cong_no_ncc` VALUES ('57', '2255', '0', '1000000', '2010');

-- ----------------------------
-- Table structure for lifetek_contact
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_contact`;
CREATE TABLE `lifetek_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_contact
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_contact_home
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_contact_home`;
CREATE TABLE `lifetek_contact_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` text NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_contact_home
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_contraccustomer
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_contraccustomer`;
CREATE TABLE `lifetek_contraccustomer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `code_contract` varchar(150) NOT NULL,
  `number_contract` varchar(150) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `person_id` int(11) NOT NULL,
  `catecontract_id` int(11) NOT NULL,
  `contract_file` varchar(250) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_contraccustomer
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_contract_type
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_contract_type`;
CREATE TABLE `lifetek_contract_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_contract_type
-- ----------------------------
INSERT INTO `lifetek_contract_type` VALUES ('7', 'HĐKT', 'hợp đồng kinh tế', 'hợp đồng kinh tế mang giá trị thời hạn 01 năm', '0');
INSERT INTO `lifetek_contract_type` VALUES ('8', 'HĐKTPM', 'hợp đồng phần mềm', '', '0');
INSERT INTO `lifetek_contract_type` VALUES ('9', 'HĐMB', 'Hợp Đồng Mua Bán', 'hợp đồng mua bán nhà đất', '0');

-- ----------------------------
-- Table structure for lifetek_costs
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_costs`;
CREATE TABLE `lifetek_costs` (
  `id_cost` int(11) NOT NULL AUTO_INCREMENT,
  `id_sale` int(11) NOT NULL,
  `id_receiving` int(11) NOT NULL COMMENT 'mã nhập hàng',
  `id_customer` int(11) DEFAULT NULL COMMENT 'mã nhà cung cấp khi nhập hàng, mã KH khi bán hàng',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` int(11) NOT NULL,
  `money_du` float NOT NULL COMMENT 'số tiền thu thực',
  `form_cost` tinyint(4) NOT NULL COMMENT '0: thu, 1: chi',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(2) NOT NULL,
  `tk_no` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tài khoản nợ',
  `tk_co` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tài khoản có',
  `chungtu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost_date_ct` date NOT NULL,
  `print_cost` int(2) NOT NULL DEFAULT '0',
  `cost_customer` int(11) DEFAULT NULL COMMENT 'mã khách  hàng khi thêm mới thu chi',
  `cost_employees` int(11) DEFAULT NULL COMMENT 'nhân viên chi tiền',
  `employees_id` int(11) NOT NULL COMMENT 'nhân viên đc chi tiền',
  `stt_thu` int(1) NOT NULL DEFAULT '0' COMMENT 'trang thái khi tạo thu trong thu chi',
  `supplier_id` int(11) NOT NULL,
  `VAT_acount` int(11) DEFAULT NULL COMMENT 'tài khoản thuế',
  `VAT_money` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL COMMENT 'mã tài sản',
  `export_store_id` int(11) NOT NULL COMMENT 'mã xuất kho',
  `item_kit_id` int(11) NOT NULL,
  `processes_cost_id` int(11) NOT NULL COMMENT 'mã chi phí công đoạn',
  `human` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'người khác',
  `payment_type` int(11) NOT NULL COMMENT 'hình thức thanh toán',
  `account_plan` int(11) NOT NULL,
  `stt` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'thu công nợ kh',
  PRIMARY KEY (`id_cost`)
) ENGINE=MyISAM AUTO_INCREMENT=4330 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_costs
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_cost_detail
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_cost_detail`;
CREATE TABLE `lifetek_cost_detail` (
  `id` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `receiving_id` int(11) NOT NULL,
  `money_debt` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_cost_detail
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_cost_select
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_cost_select`;
CREATE TABLE `lifetek_cost_select` (
  `cost_id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cost_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_cost_select
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_create_invetory
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_create_invetory`;
CREATE TABLE `lifetek_create_invetory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_inventory` varchar(255) NOT NULL,
  `address` varchar(150) NOT NULL,
  `created_date` datetime NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type_warehouse` tinyint(4) NOT NULL COMMENT ' 0: Kho khác - 1: Kho thành phẩm - 2: Kho nguyên vật liệu',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_create_invetory
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_culture
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_culture`;
CREATE TABLE `lifetek_culture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `culture_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_culture
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_currency
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_currency`;
CREATE TABLE `lifetek_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `currency_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `currency_rate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_currency
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_customers
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_customers`;
CREATE TABLE `lifetek_customers` (
  `person_id` int(10) NOT NULL,
  `code_customer` varchar(250) NOT NULL,
  `account_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_tax` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `money_birth` int(11) DEFAULT NULL,
  `taxable` int(3) NOT NULL DEFAULT '1',
  `birth_date_1` date DEFAULT NULL,
  `wife` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `deleted` int(2) NOT NULL DEFAULT '0',
  `type_customer` int(11) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `positions` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `manages_name` varchar(255) NOT NULL,
  `debt` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Hạn mức công nợ',
  `employee_id` int(11) NOT NULL COMMENT 'nhân viên quản lý',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `agent` tinyint(1) NOT NULL DEFAULT '0',
  `status_register` tinyint(1) NOT NULL DEFAULT '0',
  `account_implicit` int(11) NOT NULL COMMENT 'tài khoản ngầm định',
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  KEY `person_id` (`person_id`),
  CONSTRAINT `lifetek_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_customers
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_customer_type
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_customer_type`;
CREATE TABLE `lifetek_customer_type` (
  `customer_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `status_agent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_customer_type
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_dttcs
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_dttcs`;
CREATE TABLE `lifetek_dttcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_1` date DEFAULT NULL,
  `date_2` date DEFAULT NULL,
  `date_3` date DEFAULT NULL,
  `date_4` date DEFAULT NULL,
  `date_5` date DEFAULT NULL,
  `date_6` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_dttcs
-- ----------------------------
INSERT INTO `lifetek_dttcs` VALUES ('3', 'b', '2015-11-07', '2015-11-07', '2015-11-07', '2015-11-07', '2015-11-07', '2015-11-07');
INSERT INTO `lifetek_dttcs` VALUES ('4', 'Nguyễn Văn Định', '2015-11-13', '2015-11-13', '2015-11-13', '2015-11-13', '2015-11-13', '2015-11-13');

-- ----------------------------
-- Table structure for lifetek_dttcs_detail
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_dttcs_detail`;
CREATE TABLE `lifetek_dttcs_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_1` int(11) NOT NULL,
  `date_2` int(11) NOT NULL,
  `date_3` int(11) NOT NULL,
  `date_4` int(11) NOT NULL,
  `date_5` int(11) NOT NULL,
  `date_6` int(11) NOT NULL,
  `id_sale` int(11) NOT NULL,
  `cost_contract` int(11) NOT NULL,
  `id_dttc` int(11) NOT NULL,
  `name_customer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_dttcs_detail
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_education
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_education`;
CREATE TABLE `lifetek_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_education` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_education
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_emails
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_emails`;
CREATE TABLE `lifetek_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_emails
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_employees
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_employees`;
CREATE TABLE `lifetek_employees` (
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) NOT NULL,
  `emp_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `identity_card` int(11) DEFAULT NULL COMMENT 'Chứng minh thư nhân dân',
  `date_identity_card` date DEFAULT NULL COMMENT 'Ngày cấp chứng minh thư nhân dân',
  `date_working` date DEFAULT NULL COMMENT 'Ngày bắt đầu làm việc',
  `hs_salary` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Hệ số lương cơ bản',
  `bank_account` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tài khoản ngân hàng',
  `name_bank` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tên ngân hàng',
  `id_language` int(5) DEFAULT NULL COMMENT 'Trình độ ngoại ngữ',
  `id_education` int(5) DEFAULT NULL COMMENT 'Trình độ học vấn',
  `name_nation` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Kinh' COMMENT 'Dân tộc',
  `id_visa` int(5) DEFAULT NULL COMMENT 'Tên quốc tịch nhân viên',
  `id_diplomas` int(5) DEFAULT NULL COMMENT 'Bằng cấp',
  `id_informatics` int(5) DEFAULT NULL COMMENT 'Tin học',
  `check_petrol` int(11) DEFAULT NULL,
  `check_phone` int(11) DEFAULT NULL,
  `curiculum_vitae` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tên file CV của nhân viên nếu có',
  `labor_contract` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tên file Hợp đồng nhân viên nếu có',
  `deleted` int(1) DEFAULT '0',
  `positions_id` int(11) DEFAULT NULL COMMENT 'Chức danh',
  `parent_id` int(11) DEFAULT NULL,
  `em_salary_basic` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Lương cơ bản',
  `em_wage_level_coverage` float DEFAULT NULL,
  `em_social_insurance` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Mức lương bảo hiểm',
  `em_on_vacation` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL COMMENT 'Tên phòng nhân viên làm việc',
  `emp_expense` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `emp_deposit` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image_face` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_working` datetime NOT NULL,
  `warehouse_sale` int(11) NOT NULL COMMENT 'Kho bán',
  `warehouse_import` int(11) NOT NULL COMMENT 'Kho nhập',
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`),
  KEY `deleted` (`deleted`),
  CONSTRAINT `lifetek_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_employees
-- ----------------------------
INSERT INTO `lifetek_employees` VALUES ('admin', '25d55ad283aa400af464c76d713c07ad', '1', 'NV001', '1507920321', '2015-12-14', '2014-01-01', '2', 'VietBankV', 'VietBank', '5', '0', 'Kinh', '1', '0', '2', '1', '1', '', 'Book16.xls', '0', '0', '1', '5000000', '0', '1500000', '0', '5', '80.00', '760000.00', 'logo-soft1223.png', '1970-01-01 00:00:00', '0', '0');

-- ----------------------------
-- Table structure for lifetek_events_map
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_events_map`;
CREATE TABLE `lifetek_events_map` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(127) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `details` text NOT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_events_map
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_event_user
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_event_user`;
CREATE TABLE `lifetek_event_user` (
  `event_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`event_user_id`,`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_event_user
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_export_store
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_export_store`;
CREATE TABLE `lifetek_export_store` (
  `export_store_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_export` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `follow` tinyint(4) NOT NULL,
  `store_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `employee_id` int(11) NOT NULL,
  `item_production_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Mã phiếu yêu cầu xuất kho',
  `tk_no` varchar(20) NOT NULL,
  `tk_co` varchar(20) NOT NULL,
  `form` int(11) NOT NULL,
  PRIMARY KEY (`export_store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_export_store
-- ----------------------------
INSERT INTO `lifetek_export_store` VALUES ('1', '2015-07-31 15:46:01', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('2', '2015-08-05 09:59:40', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('3', '2015-08-05 10:00:28', '1', '0', '5', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('5', '2015-08-05 10:03:34', '1', '0', '5', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('7', '2015-08-05 15:20:40', '1', '0', '0', 'Xuất kho', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('8', '2015-08-07 11:00:40', '1', '0', '0', '                                        ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('9', '2015-08-07 11:28:25', '1', '0', '0', '                                        ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('10', '2015-08-08 10:12:49', '1', '0', '10', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('11', '2015-08-10 09:56:28', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('12', '2015-08-13 10:13:39', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('13', '2015-08-13 15:25:53', '1', '0', '0', '                   khkh ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('14', '2015-08-13 16:08:15', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('15', '2015-08-14 15:08:28', '1', '0', '6', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('16', '2015-08-14 16:31:09', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('17', '2015-08-15 11:45:49', '1', '0', '0', '                                        ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('18', '2015-08-15 11:45:42', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('19', '2015-08-19 09:33:56', '1', '0', '0', '                                        ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('20', '2015-08-19 09:35:51', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('21', '2015-08-19 17:16:15', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('22', '2015-08-20 15:29:49', '1', '0', '3', '                                        ', '1', '30', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('23', '2015-08-20 15:31:40', '1', '0', '3', '                  heloo  ', '1', '30', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('24', '2015-08-20 15:34:57', '1', '0', '3', '                    xuất kho để sản xuất', '1', '30', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('25', '2015-08-20 15:39:49', '1', '0', '3', '         âsas           ', '1', '29', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('26', '2015-08-20 16:15:01', '1', '0', '3', '                    ', '1', '37', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('27', '2015-08-20 16:30:34', '1', '0', '0', '                  aloo  ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('28', '2015-08-20 16:33:08', '1', '0', '3', '                    ', '1', '27', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('29', '2015-08-22 08:23:32', '1', '0', '3', '                    ', '1', '31', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('30', '2015-08-31 09:48:17', '1', '0', '3', '                                        ', '1', '8', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('31', '2015-08-26 14:18:12', '1', '0', '0', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('32', '2015-08-31 09:32:19', '1', '0', '6', '                    ', '1', '0', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('33', '2015-09-07 12:06:24', '1', '0', '3', '                                        ', '1', '73', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('34', '2015-09-07 12:07:57', '1', '0', '3', '                                                            ', '1', '73', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('35', '2015-09-07 15:50:49', '1', '0', '3', '                    ', '1', '73', '0', '0', '0');
INSERT INTO `lifetek_export_store` VALUES ('36', '2015-09-24 11:02:30', '1', '0', '3', '                                                                                                                                                                                                        ', '1', '66', '6277', '1281', '0');
INSERT INTO `lifetek_export_store` VALUES ('37', '2015-09-24 09:08:35', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('38', '2015-09-24 11:11:11', '1', '0', '3', '                                                                                ', '1', '32', '621', '1112', '0');
INSERT INTO `lifetek_export_store` VALUES ('39', '2015-09-24 14:01:02', '1', '0', '3', '                                        ', '1', '77', '6211', '129', '0');
INSERT INTO `lifetek_export_store` VALUES ('41', '2015-10-16 14:59:30', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('42', '2015-10-20 11:00:13', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('45', '2015-10-26 14:33:21', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('46', '2015-10-26 15:08:51', '1', '0', '0', '       Cần gấp            ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('47', '2015-10-26 22:02:00', '1', '0', '0', '           nhanh và luôn         ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('49', '2015-10-28 14:18:23', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('50', '2015-10-29 11:12:07', '1', '0', '0', '     aaaaaaa               ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('51', '2015-10-29 12:11:15', '1', '0', '3', '                    ', '1', '11', '6211', '1121', '1');
INSERT INTO `lifetek_export_store` VALUES ('52', '2015-10-29 12:13:40', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('53', '2015-11-12 09:04:07', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('54', '2015-11-12 14:26:45', '1', '0', '0', '     xuất dùng nội bộ               ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('55', '2015-11-13 14:58:27', '0', '0', '0', '   xuất điều chuyển                 ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('56', '2015-11-26 10:23:49', '0', '0', '3', '                    ', '1', '11', '154', '152', '1');
INSERT INTO `lifetek_export_store` VALUES ('57', '2015-11-26 13:41:01', '0', '0', '3', '                    ', '1', '6', '154', '152', '1');
INSERT INTO `lifetek_export_store` VALUES ('58', '2015-11-26 13:50:25', '0', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('59', '2015-12-08 15:11:19', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('60', '2015-12-11 10:34:01', '1', '0', '3', '                    ', '1', '6', '111', '331', '1');
INSERT INTO `lifetek_export_store` VALUES ('62', '2015-12-16 11:15:55', '1', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('63', '2015-12-18 12:12:29', '0', '0', '3', '                    ', '1', '25', '131', '111', '1');
INSERT INTO `lifetek_export_store` VALUES ('64', '2015-12-22 14:41:58', '0', '0', '9', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('65', '2015-12-22 14:43:15', '0', '0', '9', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('67', '2015-12-23 09:56:58', '1', '0', '3', '                    ', '1', '32', '111', '1111', '1');
INSERT INTO `lifetek_export_store` VALUES ('68', '2015-12-24 09:10:31', '0', '0', '0', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('69', '2015-12-24 10:26:15', '0', '0', '2', '                    ', '1', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('70', '2015-12-24 10:27:21', '0', '0', '3', '                    ', '1', '33', '111', '1111', '1');
INSERT INTO `lifetek_export_store` VALUES ('71', '2015-12-25 10:24:47', '0', '0', '2', '                    ', '2394', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('72', '2015-12-25 10:27:48', '0', '0', '3', '                    ', '2394', '12', '111', '131', '1');
INSERT INTO `lifetek_export_store` VALUES ('73', '2015-12-25 10:30:07', '0', '0', '0', '                    ', '2394', '0', '', '', '0');
INSERT INTO `lifetek_export_store` VALUES ('74', '2015-12-25 14:29:28', '0', '0', '0', '                    ', '2394', '0', '', '', '0');

-- ----------------------------
-- Table structure for lifetek_export_store_item
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_export_store_item`;
CREATE TABLE `lifetek_export_store_item` (
  `export_store_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_request` double(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Số lượng yêu cầu, mặc định là 0',
  `quantity_export` double(20,2) NOT NULL,
  `cost_price_export` decimal(15,0) NOT NULL,
  `unit_export` int(11) NOT NULL,
  `unit_convert` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_export_store_item
-- ----------------------------
INSERT INTO `lifetek_export_store_item` VALUES ('1', '4106', '0.00', '1.00', '0', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('2', '4125', '0.00', '2.00', '100000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('3', '4125', '0.00', '1.00', '100000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('5', '4125', '0.00', '1.00', '100000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('7', '4120', '0.00', '2.00', '100000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('7', '4119', '0.00', '6.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('8', '4120', '0.00', '5.00', '100000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('9', '4120', '0.00', '4.00', '100000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('10', '4143', '0.00', '2.00', '0', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('11', '4128', '0.00', '1.11', '500000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('12', '4123', '0.00', '7.00', '250000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('13', '4106', '0.00', '1.00', '0', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('14', '4109', '0.00', '84.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('15', '4158', '0.00', '1.00', '100000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('16', '4196', '0.00', '5.00', '0', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('18', '4206', '0.00', '10.00', '100000', '12', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('18', '4205', '0.00', '10.00', '150000', '12', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('18', '4204', '0.00', '15.00', '200000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('17', '4206', '0.00', '10.00', '100000', '12', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('19', '4182', '0.00', '7.00', '120000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('20', '4216', '0.00', '50.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('20', '4218', '0.00', '70.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('20', '4217', '0.00', '150.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('20', '4215', '0.00', '100.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('21', '4172', '0.00', '11.00', '5000000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('22', '4159', '3.00', '1.00', '100000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('22', '4158', '3.00', '1.00', '100000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('23', '4158', '3.00', '1.50', '100000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('23', '4159', '3.00', '1.50', '100000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('24', '4158', '3.00', '0.50', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('24', '4159', '3.00', '0.50', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('25', '4158', '12.00', '1.90', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('25', '4159', '12.00', '11.90', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('26', '4158', '117.00', '0.10', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('26', '4159', '39.00', '0.10', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('26', '4172', '78.00', '1.00', '5000000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('26', '4199', '156.00', '1.00', '100000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('26', '4200', '195.00', '195.00', '8000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('26', '4216', '234.00', '50.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('27', '4210', '0.00', '3.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('28', '4199', '50.00', '39.54', '100000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('28', '4200', '150.00', '4.32', '8000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('29', '4159', '5.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('31', '4159', '0.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('32', '4158', '0.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('30', '4199', '0.00', '1.00', '100000', '3', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('33', '4282', '108.00', '1.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('33', '4281', '120.00', '1.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('33', '4280', '44445.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('33', '4279', '444906.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('33', '4278', '5551067.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('33', '4277', '2147483647.00', '70.89', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('34', '4277', '2147483647.00', '10.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('34', '4278', '5551067.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('34', '4279', '444906.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('34', '4280', '44445.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('34', '4281', '120.00', '1.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('34', '4282', '108.00', '1.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('35', '4277', '2147483647.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('35', '4278', '5551067.00', '1.68', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('35', '4279', '444906.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('35', '4280', '44445.00', '1.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('35', '4281', '120.00', '1.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('35', '4282', '108.00', '1.00', '0', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('37', '4159', '0.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4158', '110.00', '110.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4294', '115.00', '115.00', '1', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4293', '115.00', '115.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4292', '1155.00', '1155.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4291', '160.00', '160.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4290', '10.00', '10.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4289', '10.00', '10.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('36', '4280', '10.00', '11.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('38', '4159', '4.00', '2.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('38', '4158', '2.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('39', '4292', '20.00', '2.00', '1000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('39', '4255', '70.00', '1.00', '10000', '1', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('39', '4158', '70.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('41', '4178', '0.00', '10.00', '500000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('42', '4159', '0.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('45', '4159', '0.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('46', '4180', '0.00', '10.00', '140000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('47', '4179', '0.00', '10.00', '120000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('49', '4180', '0.00', '10.00', '140000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('50', '4176', '0.00', '1.00', '900', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('51', '4110', '30.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('51', '4111', '200.00', '12.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('52', '4329', '0.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('53', '4164', '0.00', '1.00', '180000', '2', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('54', '4329', '0.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('55', '4385', '0.00', '2.00', '0', '5', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('56', '4110', '30.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('56', '4111', '200.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('57', '4108', '15.00', '10.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('57', '4111', '90.00', '10.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('58', '4329', '0.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('58', '4379', '0.00', '1.00', '0', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('59', '4193', '0.00', '3.00', '0', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('60', '4108', '15.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('60', '4111', '90.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('62', '4495', '0.00', '1.00', '0', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('63', '4158', '2.00', '2.00', '10000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('63', '4159', '4.00', '1.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('64', '4328', '0.00', '2.00', '30000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('65', '4385', '0.00', '5.00', '0', '5', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('67', '4158', '2.00', '1.00', '10000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('67', '4159', '4.00', '2.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('68', '4495', '0.00', '10.00', '0', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('69', '4385', '0.00', '10.00', '0', '5', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('69', '4516', '0.00', '10.00', '200000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('70', '4158', '3030.00', '10.00', '10000', '8', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('70', '4159', '2020.00', '10.00', '10000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('71', '4385', '0.00', '10.00', '0', '5', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('71', '4516', '0.00', '10.00', '200000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('72', '4108', '3.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('72', '4111', '3.00', '1.00', '0', '0', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('73', '4249', '0.00', '1.00', '10000', '11', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('73', '4436', '0.00', '1.00', '4500000', '7', '0');
INSERT INTO `lifetek_export_store_item` VALUES ('74', '4436', '0.00', '10.00', '4500000', '7', '0');

-- ----------------------------
-- Table structure for lifetek_gantt_links
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_gantt_links`;
CREATE TABLE `lifetek_gantt_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `type` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_gantt_links
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_gantt_project
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_gantt_project`;
CREATE TABLE `lifetek_gantt_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `progress` float NOT NULL,
  `sortorder` double NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `report` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `emp_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_gantt_project
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_giftcards
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_giftcards`;
CREATE TABLE `lifetek_giftcards` (
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `date_get_money` datetime NOT NULL,
  `chiet_khau` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`giftcard_id`),
  UNIQUE KEY `giftcard_number` (`giftcard_number`),
  KEY `deleted` (`deleted`),
  KEY `phppos_giftcards_ibfk_1` (`customer_id`),
  CONSTRAINT `lifetek_giftcards_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `lifetek_customers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_giftcards
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_groups
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_groups`;
CREATE TABLE `lifetek_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_groups
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_groups_asset
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_groups_asset`;
CREATE TABLE `lifetek_groups_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_groups_asset
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_hopdong
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_hopdong`;
CREATE TABLE `lifetek_hopdong` (
  `id_hopdong` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ma_hopdong` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_employess` int(5) NOT NULL,
  `loai_hopdong` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY (`id_hopdong`),
  KEY `id_employess` (`id_employess`),
  CONSTRAINT `lifetek_hopdong_ibfk_1` FOREIGN KEY (`id_employess`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_hopdong
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_import_product
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_import_product`;
CREATE TABLE `lifetek_import_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_import_product
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_introductions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_introductions`;
CREATE TABLE `lifetek_introductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 NOT NULL,
  `en_title` text NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `en_description` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_introductions
-- ----------------------------
INSERT INTO `lifetek_introductions` VALUES ('1', 'Giới thiệu công ty Hành tinh xanh', 'title', '<p>c&ocirc;ng ty ch&uacute;ng t&ocirc;i chuy&ecirc;n cung cấp c&aacute;c dịch vụ CMS cho c&aacute;c doanh nghiệp vừa v&agrave; nhỏ</p>\n', '', 'gioi-thieu-cong-ty-hanh-tinh-xanh');
INSERT INTO `lifetek_introductions` VALUES ('4', 'công ty A', '', '<p>chuy&ecirc;n mua</p>\n', '', 'cong-ty-a');

-- ----------------------------
-- Table structure for lifetek_inventory
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_inventory`;
CREATE TABLE `lifetek_inventory` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_packs` int(11) DEFAULT NULL,
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_people` int(11) NOT NULL,
  `trans_date` timestamp NULL DEFAULT NULL,
  `trans_money` decimal(15,1) NOT NULL,
  `trans_catid` int(11) NOT NULL,
  `trans_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `trans_inventory` double(20,2) NOT NULL DEFAULT '0.00',
  `trans_sale` int(11) NOT NULL,
  `trans_recevings` int(11) NOT NULL COMMENT 'mã nhập hàng',
  `store_id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL COMMENT 'mã yêu cầu sx',
  `import_product_id` int(11) NOT NULL COMMENT 'mã nhập kho thành phẩm',
  PRIMARY KEY (`trans_id`),
  KEY `phppos_inventory_ibfk_1` (`trans_items`),
  KEY `phppos_inventory_ibfk_2` (`trans_user`),
  CONSTRAINT `lifetek_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `lifetek_items` (`item_id`),
  CONSTRAINT `lifetek_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `lifetek_employees` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_inventory
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_items
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_items`;
CREATE TABLE `lifetek_items` (
  `item_code` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `images` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `made_in` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Xuất sứ',
  `item_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_description` text COLLATE utf8_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8 NOT NULL,
  `en_details` text COLLATE utf8_unicode_ci NOT NULL,
  `technical` text CHARACTER SET utf8 NOT NULL,
  `en_technical` text COLLATE utf8_unicode_ci NOT NULL,
  `cost_price` decimal(15,0) NOT NULL,
  `unit_price` decimal(15,0) NOT NULL,
  `quantity` double(20,2) NOT NULL DEFAULT '0.00',
  `reorder_level` int(11) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `allow_alt_description` tinyint(1) NOT NULL,
  `unit` int(11) NOT NULL,
  `deleted` int(2) NOT NULL,
  `location` int(255) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `motangan` text COLLATE utf8_unicode_ci NOT NULL,
  `khuyen_mai` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `bao_hanh` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `co_vat` tinyint(1) NOT NULL DEFAULT '0',
  `co_hang` tinyint(1) NOT NULL DEFAULT '0',
  `sp_banchay` tinyint(1) NOT NULL DEFAULT '0',
  `sp_km` tinyint(1) NOT NULL DEFAULT '0',
  `sp_moi` tinyint(1) NOT NULL DEFAULT '0',
  `sp_tot` tinyint(1) NOT NULL DEFAULT '0',
  `sp_giamgia` tinyint(1) NOT NULL DEFAULT '0',
  `anh` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `anh_con` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_bo_tt` int(10) NOT NULL,
  `ngaytao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '0',
  `sp_depvadoc` tinyint(1) NOT NULL DEFAULT '0',
  `count_view` int(20) DEFAULT '1',
  `like` int(11) DEFAULT '1',
  `unlike` int(11) DEFAULT '1',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8_unicode_ci,
  `ads_left` int(11) NOT NULL DEFAULT '0',
  `ads_right` int(11) NOT NULL DEFAULT '0',
  `url_video` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_now` int(10) DEFAULT '0',
  `is_go_in` int(10) DEFAULT '0',
  `product_view_home` tinyint(1) NOT NULL DEFAULT '0',
  `view_img_slider` tinyint(1) DEFAULT '0',
  `method_cost` int(11) NOT NULL,
  `promo_price` decimal(15,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `unit_from` int(11) NOT NULL COMMENT 'đơn vị ban đầu',
  `unit_rate` float NOT NULL COMMENT 'tỉ lệ chuyển đổi',
  `cost_price_rate` decimal(15,0) NOT NULL COMMENT 'Giá nhập sau quy đổi',
  `unit_price_rate` decimal(15,0) NOT NULL COMMENT 'Giá bán sau quy đổi',
  `quantity_total` double(20,2) NOT NULL DEFAULT '0.00' COMMENT 'số lượng kho tổng ',
  `quantity_first` int(11) NOT NULL DEFAULT '0',
  `hanghoa` int(1) NOT NULL DEFAULT '0' COMMENT 'phân biệt NVL với hàng hóa',
  `taxes` float NOT NULL COMMENT 'Thuế',
  `service` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: Mặt hàng - 1: Dịch vụ',
  `produce` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: Mặt hàng nhập - 1: Tự sản xuất',
  `top` tinyint(4) NOT NULL DEFAULT '0',
  `item_kit_id` int(11) DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `account_store` int(11) NOT NULL COMMENT 'tài khoản kho',
  `account_reven` int(11) NOT NULL COMMENT 'tài khoản giá vốn',
  `account_incomplete` int(11) NOT NULL COMMENT 'tài khoản dở dang',
  `account_cos` int(11) NOT NULL COMMENT 'tài khoản doanh thu',
  `quantity_inv` int(11) NOT NULL,
  `money_inv` decimal(15,0) NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`),
  KEY `phppos_items_ibfk_1` (`supplier_id`),
  KEY `name` (`name`),
  KEY `category` (`category`),
  CONSTRAINT `lifetek_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `lifetek_suppliers` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_items
-- ----------------------------
INSERT INTO `lifetek_items` VALUES ('0', 'Chè Đào', 'dao', 'xoi-xoai.png', '90', null, '', '1', '-1 bát ăn cơm xôi gạo Thái đồ thơm cùng lá dứa, đậu xanh-1/2 trái xoài chín tươi, ngọt-Ăn kèm nước cốt dừa đã qua chế biến của đầu bếp Thái Lan', '', '', '', '', '', '19000', '55000', '0.00', '200', '1', '0', '1', '0', '0', '0', '', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '1', '1', '1', '', '', null, '0', '0', '', '0', '0', '0', '0', '0', '0.00', '1969-01-01', '1969-01-01', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', null, 'che-dao', '0', '0', '0', '0', '0', '0');
INSERT INTO `lifetek_items` VALUES ('0', 'Chè Cam', 'cam', 'che-hat-luu1.png', '90', null, '', '2', '-1 bát ăn cơm xôi gạo Thái đồ thơm cùng lá dứa, đậu xanh-1/2 trái xoài chín tươi, ngọt-Ăn kèm nước cốt dừa đã qua chế biến của đầu bếp Thái Lan', '', '', '', '', '', '18000', '52000', '0.00', '200', '2', '0', '1', '0', '0', '0', '', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '1', '1', '1', null, null, null, '0', '0', null, '0', '0', '0', '0', '0', '0.00', '1969-01-01', '1969-01-01', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', null, 'che-cam', '0', '0', '0', '0', '0', '0');
INSERT INTO `lifetek_items` VALUES ('0', 'Chè Canh', 'canh', 'xoi-xoai1.png', '90', null, '', '3', '-1 bát ăn cơm xôi gạo Thái đồ thơm cùng lá dứa, đậu xanh-1/2 trái xoài chín tươi, ngọt-Ăn kèm nước cốt dừa đã qua chế biến của đầu bếp Thái Lan', '', '', '', '', '', '15000', '50000', '0.00', '200', '3', '0', '1', '0', '0', '0', '', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '1', '1', '1', null, null, null, '0', '0', null, '0', '0', '0', '0', '0', '0.00', '1969-01-01', '1969-01-01', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', null, 'che-canh', '0', '0', '0', '0', '0', '0');
INSERT INTO `lifetek_items` VALUES ('0', 'Chè Xạm', 'xam', 'che-hat-luu1.png', '90', null, '', '4', '-1 bát ăn cơm xôi gạo Thái đồ thơm cùng lá dứa, đậu xanh-1/2 trái xoài chín tươi, ngọt-Ăn kèm nước cốt dừa đã qua chế biến của đầu bếp Thái Lan', '', '', '', '', '', '12000', '50000', '0.00', '200', '4', '0', '1', '0', '0', '0', '', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '1', '1', '1', null, null, null, '0', '0', null, '0', '0', '0', '0', '0', null, null, null, '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', null, '', '0', '0', '0', '0', '0', '0');
INSERT INTO `lifetek_items` VALUES ('0', 'Chè Quýt', 'quyt', 'che-hat-luu1.png', '90', null, '', '5', '-1 bát ăn cơm xôi gạo Thái đồ thơm cùng lá dứa, đậu xanh-1/2 trái xoài chín tươi, ngọt-Ăn kèm nước cốt dừa đã qua chế biến của đầu bếp Thái Lan', '', '', '', '', '', '1000', '5000', '0.00', '200', '5', '0', '1', '0', '0', '0', '', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '1', '1', '1', null, null, null, '0', '0', null, '0', '0', '0', '0', '0', null, null, null, '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', null, '', '0', '0', '0', '0', '0', '0');
INSERT INTO `lifetek_items` VALUES ('0', 'Chè Thạch', 'thach', 'che-hat-luu1.png', '90', null, '', '6', '-1 bát ăn cơm xôi gạo Thái đồ thơm cùng lá dứa, đậu xanh-1/2 trái xoài chín tươi, ngọt-Ăn kèm nước cốt dừa đã qua chế biến của đầu bếp Thái Lan', '', '', '', '', '', '25000', '50000', '0.00', '200', '6', '0', '0', '0', '0', '0', '', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '', '0', '0', '1', '1', '1', null, null, null, '0', '0', null, '0', '0', '0', '0', '0', null, null, null, '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', null, '', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for lifetek_items_taxes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_items_taxes`;
CREATE TABLE `lifetek_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`,`name`,`percent`),
  CONSTRAINT `lifetek_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_items_taxes
-- ----------------------------
INSERT INTO `lifetek_items_taxes` VALUES ('1', 'Thuế', '0', '0');
INSERT INTO `lifetek_items_taxes` VALUES ('2', 'Thuế', '0', '0');
INSERT INTO `lifetek_items_taxes` VALUES ('3', 'Thuế', '0', '0');

-- ----------------------------
-- Table structure for lifetek_items_verifying
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_items_verifying`;
CREATE TABLE `lifetek_items_verifying` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `quantity_input` double(20,2) NOT NULL,
  `quantity_inventory` double(20,2) NOT NULL COMMENT 'SL kho',
  `quantity_verifying` double(20,2) NOT NULL COMMENT 'SL kiểm kê',
  `quantity_sale` double(20,2) NOT NULL COMMENT 'sl bán',
  `warehouse_id` int(11) NOT NULL COMMENT 'Kho kiểm kê',
  `command` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lý do kiểm kho',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_items_verifying
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_history_production
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_history_production`;
CREATE TABLE `lifetek_item_history_production` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_production_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_production` double(20,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='lịch sử sản xuất thành phẩm';

-- ----------------------------
-- Records of lifetek_item_history_production
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kits
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kits`;
CREATE TABLE `lifetek_item_kits` (
  `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` decimal(15,0) DEFAULT NULL,
  `cost_price` decimal(15,0) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `location` int(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `images` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity_max` int(11) NOT NULL COMMENT 'Số lượng tối đa có thể sản xuất',
  `cost_labor` decimal(15,0) NOT NULL COMMENT 'Chi phí nhân công',
  `cost_other` decimal(15,0) NOT NULL COMMENT 'Cho phí khác',
  `cost_item_kit` decimal(15,0) NOT NULL COMMENT 'Chi phí NVL',
  `status` tinyint(4) NOT NULL COMMENT '1: đang TK mẫu, 2: đang SX mẫu, 3: duyệt SX, 4: đang SX, 5: hoàn thành',
  `click` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: Không chọn - 1: đang chọn',
  PRIMARY KEY (`item_kit_id`),
  KEY `name` (`name`),
  KEY `deleted` (`deleted`),
  KEY `item_kit_number` (`item_kit_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_item_kits
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kits_taxes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kits_taxes`;
CREATE TABLE `lifetek_item_kits_taxes` (
  `item_kit_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_kit_id`,`name`,`percent`),
  CONSTRAINT `lifetek_item_kits_taxes_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_item_kits_taxes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_cost_price
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_cost_price`;
CREATE TABLE `lifetek_item_kit_cost_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) NOT NULL,
  `quantity` double(18,2) NOT NULL,
  `money_labor` int(11) NOT NULL,
  `money_machine` int(11) NOT NULL,
  `money_outsource` int(11) NOT NULL,
  `money_other` int(11) NOT NULL,
  `cost_price` double(20,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `money_norm` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='giá vốn sản phẩm';

-- ----------------------------
-- Records of lifetek_item_kit_cost_price
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_design_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_design_template`;
CREATE TABLE `lifetek_item_kit_design_template` (
  `id_design_template` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) DEFAULT NULL,
  `code_design_template` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_design_template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
  `description` text COLLATE utf8_unicode_ci,
  `person_id` int(11) DEFAULT NULL COMMENT 'Người thiết kế',
  `status` tinyint(255) DEFAULT NULL COMMENT '0: Đề xuất, 1: Đang triển khai, 2: Đang xét duyệt, 3: Duyệt, 4: Không duyệt, 5: Thiết kế lại, 6: Hủy',
  `command` text COLLATE utf8_unicode_ci COMMENT 'Ghi chú',
  `delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_design_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='thông tin mẫu tk';

-- ----------------------------
-- Records of lifetek_item_kit_design_template
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_feature
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_feature`;
CREATE TABLE `lifetek_item_kit_feature` (
  `feature_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) NOT NULL,
  `number_feature` varchar(15) NOT NULL,
  `name_feature` varchar(50) NOT NULL,
  `delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`feature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='công thức nvl trong từng mẫu';

-- ----------------------------
-- Records of lifetek_item_kit_feature
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_formula_materials
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_formula_materials`;
CREATE TABLE `lifetek_item_kit_formula_materials` (
  `feature_id` int(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit` tinyint(4) DEFAULT NULL,
  `quantity_begin` float DEFAULT NULL,
  `quantity` double(20,2) DEFAULT NULL,
  `quantity_loss` float DEFAULT NULL,
  `cost` decimal(15,0) DEFAULT NULL,
  `price` decimal(15,0) DEFAULT NULL,
  `product_as_item` int(11) DEFAULT NULL,
  `quantity_inventory` float DEFAULT NULL,
  PRIMARY KEY (`feature_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='công thức nvl theo mặt hàng';

-- ----------------------------
-- Records of lifetek_item_kit_formula_materials
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_items
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_items`;
CREATE TABLE `lifetek_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_begin` float NOT NULL COMMENT 'Số lượng tồn ban đầu',
  `quantity` float NOT NULL,
  `quantity_loss` float NOT NULL COMMENT 'So luong hao hut',
  `cost` decimal(15,0) NOT NULL COMMENT 'Giá nhập',
  `price` decimal(15,0) NOT NULL COMMENT 'giá cho từng nguyên vật liệu khi thêm vào gói',
  `product_as_item` int(11) NOT NULL COMMENT 'Số lượng sản phẩm có thể SX tương ứng với NVL',
  `quantity_inventory` float NOT NULL COMMENT 'Số lượng tồn dự kiến',
  PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`),
  KEY `phppos_item_kit_items_ibfk_2` (`item_id`),
  CONSTRAINT `lifetek_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  CONSTRAINT `lifetek_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_item_kit_items
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_norms_item
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_norms_item`;
CREATE TABLE `lifetek_item_kit_norms_item` (
  `request_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tổng định mức nvl theo lệnh sx';

-- ----------------------------
-- Records of lifetek_item_kit_norms_item
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_processes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_processes`;
CREATE TABLE `lifetek_item_kit_processes` (
  `pro_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `time_processes` double(15,2) NOT NULL,
  `unit_time` int(11) NOT NULL,
  `processes_money` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='công đoạn trong lệnh sx';

-- ----------------------------
-- Records of lifetek_item_kit_processes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_processes_cost
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_processes_cost`;
CREATE TABLE `lifetek_item_kit_processes_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `cost_name` varchar(255) DEFAULT NULL,
  `outsource` int(11) NOT NULL,
  `labor` int(11) NOT NULL,
  `machine` int(11) NOT NULL,
  `cost_money` decimal(15,0) NOT NULL,
  `tk_no` varchar(20) NOT NULL,
  `tk_co` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='chi phí từng công đoạn trong lệnh sx';

-- ----------------------------
-- Records of lifetek_item_kit_processes_cost
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_production_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_production_template`;
CREATE TABLE `lifetek_item_kit_production_template` (
  `id_production_template` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) NOT NULL,
  `code_production_template` varchar(50) NOT NULL,
  `image_production_template` varchar(50) NOT NULL,
  `date_create` datetime NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` int(11) NOT NULL COMMENT '0: chờ xác nhận, 1: đã xác nhận, 2: đang sản xuất, 3: hoàn thành, 4: không duyệt, 5: duyệt tạm, 6: duyệt sản xuất',
  `comment` text NOT NULL,
  `delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_production_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='thông tin lệnh sx theo từng mẫu';

-- ----------------------------
-- Records of lifetek_item_kit_production_template
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_request_cost_price
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_request_cost_price`;
CREATE TABLE `lifetek_item_kit_request_cost_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `quantity` double(18,2) NOT NULL,
  `money_labor` int(11) NOT NULL,
  `money_machine` int(11) NOT NULL,
  `money_outsource` int(11) NOT NULL,
  `money_other` int(11) NOT NULL,
  `cost_price` double(20,2) NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='giá vốn lệnh sx';

-- ----------------------------
-- Records of lifetek_item_kit_request_cost_price
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_request_feature
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_request_feature`;
CREATE TABLE `lifetek_item_kit_request_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `size` varchar(8) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='lệnh sx theo size';

-- ----------------------------
-- Records of lifetek_item_kit_request_feature
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_request_production
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_request_production`;
CREATE TABLE `lifetek_item_kit_request_production` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: Chưa tiếp nhận, 1: Chờ tiếp nhận, 2: Đã tiếp nhận',
  `delete` tinyint(4) NOT NULL,
  `total_money_norms` int(11) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='lệnh sx';

-- ----------------------------
-- Records of lifetek_item_kit_request_production
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_kit_request_production_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_kit_request_production_template`;
CREATE TABLE `lifetek_item_kit_request_production_template` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `quantity_request` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='lệnh sx theo từng mẫu';

-- ----------------------------
-- Records of lifetek_item_kit_request_production_template
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_item_production
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_item_production`;
CREATE TABLE `lifetek_item_production` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `quantity_production` int(11) NOT NULL COMMENT 'Số lượng cần sản xuất',
  `number_production` int(11) NOT NULL COMMENT 'Số lượng đã sản xuất',
  `cost_production` decimal(15,0) NOT NULL COMMENT 'Chi phí sản xuất',
  `price_production` decimal(15,0) NOT NULL COMMENT 'Giá sản phẩm sau sản xuất',
  `date_begin` date NOT NULL COMMENT 'Ngày bắt đầu',
  `date_end` date NOT NULL COMMENT 'Ngày kết thúc',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: chưa xác nhận, 2: đang sx, 3: hoàn thành',
  `export_store` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Xác nhận xuất kho',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=199 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='thông tin lệnh sản xuất';

-- ----------------------------
-- Records of lifetek_item_production
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs`;
CREATE TABLE `lifetek_jobs` (
  `jobs_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_url_file` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_important` int(11) NOT NULL,
  `jobs_parent` int(11) DEFAULT NULL,
  `jobs_end_date` date DEFAULT NULL,
  `jobs_start_date` date DEFAULT NULL,
  `jobs_status_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL COMMENT 'Người tạo công việc này',
  `jobs_security_id` int(11) NOT NULL,
  `project_status` int(2) DEFAULT NULL COMMENT 'Xác định xem đây có phải là dự án hay không',
  `jobs_approve` mediumint(1) DEFAULT NULL COMMENT 'Xác định xem công việc này đã được phê duyệt hay chưa nếu công việc hay dự án chưa được phê duyệt thì không cho phép thực hiên',
  `jobs_approve_content` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nội dung đính kèm nhận xét khi được phê duyệt là gì',
  `jobs_approve_date` date DEFAULT NULL COMMENT 'Ngày phê duyệt công việc',
  `Duration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `leaf` int(1) DEFAULT '0',
  `DurationUnit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PercentDone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cls` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PhantomId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PhantomParentId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `StartDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EndDate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`jobs_id`,`jobs_important`,`jobs_status_id`,`jobs_security_id`),
  KEY `jobs_content` (`jobs_content`),
  KEY `jobs_name` (`jobs_name`),
  KEY `jobs_important` (`jobs_important`),
  KEY `jobs_status_id` (`jobs_status_id`),
  KEY `jobs_security_id` (`jobs_security_id`),
  CONSTRAINT `lifetek_jobs_ibfk_1` FOREIGN KEY (`jobs_important`) REFERENCES `lifetek_jobs_important` (`jobs_important_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lifetek_jobs_ibfk_3` FOREIGN KEY (`jobs_security_id`) REFERENCES `lifetek_jobs_security` (`jobs_security_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs2014
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs2014`;
CREATE TABLE `lifetek_jobs2014` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `PhantomId` varchar(255) DEFAULT NULL,
  `PhantomParentId` varchar(255) DEFAULT NULL,
  `leaf` int(1) DEFAULT '0',
  `Name` varchar(255) DEFAULT NULL,
  `StartDate` varchar(255) DEFAULT NULL,
  `EndDate` varchar(255) DEFAULT NULL,
  `Duration` varchar(255) DEFAULT NULL,
  `DurationUnit` varchar(255) DEFAULT NULL,
  `PercentDone` varchar(255) DEFAULT NULL,
  `Cls` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_jobs2014
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_affiliates
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_affiliates`;
CREATE TABLE `lifetek_jobs_affiliates` (
  `jobs_affiliates_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_affiliates_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_affiliates_place` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_city_id` int(11) NOT NULL,
  `jobs_affiliates_parent_id` int(4) DEFAULT NULL,
  `jobs_affiliates_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT '#000000',
  `jobs_affiliates_status` int(2) DEFAULT '1',
  `person_id` int(11) NOT NULL,
  `jobs_affiliates_date` date DEFAULT NULL,
  PRIMARY KEY (`jobs_affiliates_id`,`jobs_city_id`,`person_id`),
  KEY `jobs_city_id` (`jobs_city_id`),
  CONSTRAINT `lifetek_jobs_affiliates_ibfk_1` FOREIGN KEY (`jobs_city_id`) REFERENCES `lifetek_jobs_city` (`jobs_city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_affiliates
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_city
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_city`;
CREATE TABLE `lifetek_jobs_city` (
  `jobs_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_city_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_city_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_regions_id` int(11) NOT NULL,
  `jobs_city_status` int(2) DEFAULT '1',
  `jobs_city_color` varchar(200) COLLATE utf8_unicode_ci DEFAULT '#000000',
  `jobs_city_date` date DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`jobs_city_id`,`jobs_regions_id`),
  KEY `jobs_regions_id` (`jobs_regions_id`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `lifetek_jobs_city_ibfk_1` FOREIGN KEY (`jobs_regions_id`) REFERENCES `lifetek_jobs_regions` (`jobs_regions_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lifetek_jobs_city_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_city
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_department
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_department`;
CREATE TABLE `lifetek_jobs_department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_place` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `jobs_affiliates_id` int(11) DEFAULT NULL,
  `department_color` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `department_date` date DEFAULT NULL,
  `department_status` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`department_id`,`person_id`),
  KEY `person_id` (`person_id`),
  KEY `jobs_affiliates_id` (`jobs_affiliates_id`),
  CONSTRAINT `lifetek_jobs_department_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lifetek_jobs_department_ibfk_2` FOREIGN KEY (`jobs_affiliates_id`) REFERENCES `lifetek_jobs_affiliates` (`jobs_affiliates_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_department
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_employees
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_employees`;
CREATE TABLE `lifetek_jobs_employees` (
  `employees_jobs_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `employees_jobs_parent_id` int(11) DEFAULT NULL,
  `employees_jobs_date` date DEFAULT NULL,
  `employees_jobs_content` text COLLATE utf8_unicode_ci,
  `employees_jobs_expired` smallint(6) DEFAULT NULL,
  `employees_jobs_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`employees_jobs_id`,`jobs_id`,`person_id`),
  KEY `person_id` (`person_id`),
  KEY `jobs_id` (`jobs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_employees
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_file
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_file`;
CREATE TABLE `lifetek_jobs_file` (
  `jobs_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_file_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `jobs_file_date` date DEFAULT NULL,
  PRIMARY KEY (`jobs_file_id`,`person_id`),
  KEY `phppos_jobs_file_ibfk_1` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_file
-- ----------------------------
INSERT INTO `lifetek_jobs_file` VALUES ('2', 'Luồng sx', '', null, '1', '2015-08-10');
INSERT INTO `lifetek_jobs_file` VALUES ('4', 'Mẫu khởi tạo excel', '', 'import_items1.xlsx', '1', '2015-08-10');
INSERT INTO `lifetek_jobs_file` VALUES ('6', 'Quy trình 4biz', ':D', 'import_items3.xlsx', '1', '2015-08-10');
INSERT INTO `lifetek_jobs_file` VALUES ('8', 'Danh sách khách hàng', 'Danh sách tổng hợp khách hàng.', 'Copy_of_import_customers1.xlsx', '1', '2015-08-11');
INSERT INTO `lifetek_jobs_file` VALUES ('9', 'Tài liệu dự án kinh doanh đất', 'abcz', null, '1', '2015-10-27');
INSERT INTO `lifetek_jobs_file` VALUES ('14', 'thành phố hoàng gia', '', null, '1', '2015-11-13');
INSERT INTO `lifetek_jobs_file` VALUES ('15', '0', '', null, '1', '1970-01-01');
INSERT INTO `lifetek_jobs_file` VALUES ('16', 'HDSD', '', 'import_customers_khach_hang1.xlsx', '1', '2015-11-19');
INSERT INTO `lifetek_jobs_file` VALUES ('17', '0', '', null, '1', '1970-01-01');
INSERT INTO `lifetek_jobs_file` VALUES ('18', 'bao cao ban hang', '', 'baocao_banhang-22-12-20151.xlsx', '1', '2015-12-23');

-- ----------------------------
-- Table structure for lifetek_jobs_important
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_important`;
CREATE TABLE `lifetek_jobs_important` (
  `jobs_important_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_important_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_important_date` date DEFAULT NULL,
  `jobs_important_show` int(4) DEFAULT '1',
  `person_id` int(11) DEFAULT NULL,
  `jobs_important_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`jobs_important_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_important
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_positions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_positions`;
CREATE TABLE `lifetek_jobs_positions` (
  `jobs_positions_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_positions_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_positions_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_positions_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_positions_date` date NOT NULL,
  `delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`jobs_positions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_positions
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_regions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_regions`;
CREATE TABLE `lifetek_jobs_regions` (
  `jobs_regions_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_regions_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_regions_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_regions_date` date DEFAULT NULL,
  `jobs_regions_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT '#FFFFFF',
  `jobs_status_id` int(11) NOT NULL,
  `jobs_important_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL COMMENT 'Người quản lý khu vực',
  PRIMARY KEY (`jobs_regions_id`,`jobs_status_id`,`jobs_important_id`,`person_id`),
  KEY `jobs_important_id` (`jobs_important_id`),
  KEY `jobs_status_id` (`jobs_status_id`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `lifetek_jobs_regions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_regions
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_report
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_report`;
CREATE TABLE `lifetek_jobs_report` (
  `jobs_reports_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_reports_name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employees_jobs_id` int(11) NOT NULL,
  `jobs_reports_date` datetime DEFAULT NULL,
  `jobs_reports_content` text COLLATE utf8_unicode_ci,
  `jobs_reports_comment` text COLLATE utf8_unicode_ci,
  `jobs_reports_result` tinyint(4) DEFAULT NULL,
  `jobs_reports_status` tinyint(2) DEFAULT '0',
  `jobs_reports_result_manager` bigint(4) DEFAULT NULL,
  `jobs_reports_date_manager` date DEFAULT NULL,
  PRIMARY KEY (`jobs_reports_id`,`employees_jobs_id`),
  KEY `employees_jobs_id` (`employees_jobs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_report
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_security
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_security`;
CREATE TABLE `lifetek_jobs_security` (
  `jobs_security_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_security_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_security_date` date DEFAULT NULL,
  `jobs_security_show` int(2) DEFAULT '1',
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`jobs_security_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_security
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_jobs_status
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_jobs_status`;
CREATE TABLE `lifetek_jobs_status` (
  `jobs_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_status_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_status_date` date DEFAULT NULL,
  `jobs_status_show` tinyint(4) DEFAULT '1',
  `person_id` int(11) DEFAULT NULL,
  `jobs_status_color` varchar(10) COLLATE utf8_unicode_ci DEFAULT '#FFFFFF',
  PRIMARY KEY (`jobs_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_jobs_status
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_kcs
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_kcs`;
CREATE TABLE `lifetek_kcs` (
  `kcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `feature_size_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `quantity_request` int(11) NOT NULL COMMENT 'sl yêu cầu',
  `quantity_production` int(11) NOT NULL COMMENT 'sl đã sản xuất',
  `status` tinyint(4) NOT NULL,
  `import_product_id` int(11) NOT NULL,
  PRIMARY KEY (`kcs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=679 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_kcs
-- ----------------------------
INSERT INTO `lifetek_kcs` VALUES ('126', '53', '111', '4', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('127', '54', '112', '6', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('128', '54', '113', '6', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('129', '55', '114', '5', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('130', '55', '115', '5', '5', '5', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('131', '55', '114', '5', '2', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('132', '55', '115', '5', '5', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('133', '57', '125', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('134', '57', '125', '5', '10', '2', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('135', '57', '126', '4', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('136', '57', '126', '5', '5', '3', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('137', '57', '127', '4', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('138', '57', '127', '5', '5', '3', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('139', '58', '128', '4', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('140', '58', '128', '6', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('141', '58', '129', '4', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('142', '58', '129', '6', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('143', '58', '130', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('144', '58', '130', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('145', '50', '106', '4', '8', '8', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('146', '50', '106', '5', '8', '8', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('147', '50', '107', '4', '80', '80', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('148', '50', '107', '5', '80', '79', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('149', '60', '134', '4', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('150', '60', '134', '5', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('151', '60', '134', '6', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('152', '60', '135', '4', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('153', '60', '135', '5', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('154', '60', '135', '6', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('155', '60', '136', '4', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('156', '60', '136', '5', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('157', '60', '136', '6', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('158', '61', '137', '1', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('159', '61', '137', '2', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('160', '61', '138', '1', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('161', '61', '138', '2', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('162', '61', '139', '1', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('163', '61', '139', '2', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('164', '61', '140', '1', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('165', '61', '140', '2', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('166', '61', '141', '1', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('167', '61', '141', '2', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('168', '61', '142', '1', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('169', '61', '142', '2', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('170', '62', '143', '1', '10', '5', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('171', '62', '144', '1', '10', '5', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('172', '62', '145', '1', '10', '4', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('173', '62', '146', '1', '10', '5', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('174', '62', '147', '1', '10', '4', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('175', '62', '148', '1', '10', '4', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('176', '63', '149', '3', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('177', '63', '150', '3', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('178', '67', '160', '4', '17', '17', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('179', '67', '160', '7', '17', '17', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('180', '67', '161', '4', '17', '17', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('181', '67', '161', '7', '17', '17', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('182', '67', '162', '4', '17', '17', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('183', '67', '162', '7', '17', '17', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('184', '73', '182', '4', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('185', '73', '182', '4', '1', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('186', '75', '187', '8', '1', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('187', '77', '191', '7', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('188', '77', '192', '7', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('189', '77', '193', '7', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('190', '77', '194', '7', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('191', '80', '201', '4', '35', '35', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('192', '80', '202', '4', '35', '35', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('193', '80', '203', '4', '35', '34', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('194', '83', '212', '4', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('195', '83', '212', '5', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('196', '83', '212', '6', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('197', '83', '213', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('198', '83', '213', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('199', '83', '213', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('200', '83', '214', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('201', '83', '214', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('202', '83', '214', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('203', '83', '215', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('204', '83', '215', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('205', '83', '215', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('206', '81', '204', '1', '100', '100', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('207', '81', '204', '2', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('208', '81', '204', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('209', '81', '204', '7', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('210', '81', '205', '1', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('211', '81', '205', '2', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('212', '81', '205', '5', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('213', '81', '205', '7', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('214', '81', '206', '1', '10000', '10000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('215', '81', '206', '2', '10000', '10000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('216', '81', '206', '5', '10000', '10000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('217', '81', '206', '7', '10000', '10000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('218', '81', '207', '1', '100000', '100000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('219', '81', '207', '2', '100000', '100000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('220', '81', '207', '5', '100000', '100000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('221', '81', '207', '7', '100000', '100000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('222', '84', '220', '3', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('223', '84', '221', '3', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('224', '85', '222', '1', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('225', '85', '222', '2', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('226', '85', '223', '1', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('227', '85', '223', '2', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('228', '80', '216', '4', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('229', '80', '217', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('230', '80', '218', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('231', '80', '219', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('232', '80', '216', '4', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('233', '80', '217', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('234', '80', '218', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('235', '80', '219', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('236', '80', '216', '4', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('237', '80', '217', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('238', '80', '218', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('239', '80', '219', '4', '35', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('240', '80', '216', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('241', '80', '217', '6', '35', '35', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('242', '80', '218', '6', '35', '35', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('243', '80', '219', '6', '35', '35', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('244', '91', '259', '4', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('245', '91', '259', '5', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('246', '91', '260', '4', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('247', '91', '260', '5', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('248', '91', '261', '4', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('249', '91', '261', '5', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('250', '91', '262', '4', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('251', '91', '262', '5', '28', '28', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('252', '92', '263', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('253', '92', '263', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('254', '92', '264', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('255', '92', '264', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('256', '92', '265', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('257', '92', '265', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('258', '92', '266', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('259', '92', '266', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('260', '93', '267', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('261', '93', '267', '5', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('262', '93', '267', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('263', '93', '268', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('264', '93', '268', '5', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('265', '93', '268', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('266', '93', '269', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('267', '93', '269', '5', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('268', '93', '269', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('269', '93', '270', '4', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('270', '93', '270', '5', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('271', '93', '270', '7', '31', '31', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('272', '97', '276', '4', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('273', '97', '276', '5', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('274', '97', '277', '4', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('275', '97', '277', '5', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('276', '100', '280', '4', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('277', '100', '280', '6', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('278', '101', '281', '4', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('279', '101', '281', '6', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('280', '101', '282', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('281', '101', '282', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('282', '102', '283', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('283', '102', '283', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('284', '105', '286', '4', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('285', '106', '287', '4', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('286', '106', '288', '4', '40', '40', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('287', '106', '289', '4', '30', '30', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('288', '103', '284', '1', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('289', '107', '290', '4', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('290', '107', '290', '6', '20', '20', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('291', '107', '291', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('292', '107', '291', '6', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('293', '111', '299', '4', '13', '13', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('294', '111', '299', '4', '13', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('295', '117', '306', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('296', '117', '307', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('297', '117', '308', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('298', '116', '309', '1', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('299', '116', '309', '2', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('300', '116', '309', '7', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('301', '116', '310', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('302', '116', '310', '2', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('303', '116', '310', '7', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('304', '115', '304', '2', '100', '12', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('305', '119', '312', '1', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('306', '119', '312', '2', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('307', '120', '313', '1', '3', '0', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('308', '120', '313', '2', '0', '6', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('309', '120', '313', '4', '6', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('310', '121', '314', '2', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('312', '122', '315', '1', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('313', '122', '315', '2', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('314', '124', '317', '1', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('315', '124', '317', '3', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('316', '126', '326', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('317', '126', '327', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('318', '126', '328', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('319', '127', '329', '1', '100', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('320', '128', '331', '1', '200', '200', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('321', '129', '332', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('322', '129', '332', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('323', '129', '333', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('324', '129', '333', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('325', '129', '334', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('326', '129', '334', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('327', '129', '335', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('328', '129', '335', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('329', '129', '336', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('330', '129', '336', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('331', '129', '337', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('332', '129', '337', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('333', '130', '338', '1', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('334', '131', '339', '1', '400', '400', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('335', '132', '340', '1', '11', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('336', '132', '340', '2', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('337', '132', '340', '6', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('338', '132', '340', '8', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('339', '133', '341', '6', '12', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('340', '134', '342', '1', '12', '12', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('341', '134', '342', '2', '12', '12', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('342', '134', '342', '1', '12', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('343', '134', '342', '2', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('344', '135', '343', '2', '122', '122', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('345', '137', '346', '1', '122', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('346', '139', '350', '3', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('347', '139', '350', '4', '1000', '1000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('348', '139', '351', '3', '10000', '10000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('349', '139', '351', '4', '10000', '10000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('350', '139', '352', '3', '100000', '100000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('351', '139', '352', '4', '100000', '100000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('352', '139', '353', '3', '1000000', '1000000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('353', '139', '353', '4', '1000000', '1000000', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('354', '140', '354', '1', '1000000', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('355', '140', '354', '6', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('356', '140', '355', '1', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('357', '140', '355', '6', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('358', '141', '356', '1', '122', '122', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('359', '141', '356', '2', '122', '122', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('360', '144', '360', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('361', '144', '360', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('362', '144', '360', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('363', '144', '360', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('364', '144', '361', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('365', '144', '361', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('366', '144', '361', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('367', '144', '361', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('368', '144', '362', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('369', '144', '362', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('370', '144', '362', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('371', '144', '362', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('372', '144', '363', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('373', '144', '363', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('374', '144', '363', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('375', '144', '363', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('376', '144', '364', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('377', '144', '364', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('378', '144', '364', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('379', '144', '364', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('380', '144', '365', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('381', '144', '365', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('382', '144', '365', '4', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('383', '144', '365', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('384', '145', '366', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('385', '145', '366', '2', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('386', '145', '366', '5', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('387', '145', '366', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('388', '148', '369', '1', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('389', '148', '369', '2', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('390', '148', '369', '4', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('391', '148', '369', '7', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('392', '149', '370', '1', '210', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('393', '149', '370', '2', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('394', '149', '370', '4', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('395', '149', '370', '5', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('396', '150', '371', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('397', '150', '372', '4', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('398', '151', '373', '9', '5', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('399', '151', '373', '10', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('400', '151', '373', '11', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('401', '151', '373', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('402', '151', '374', '9', '3', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('403', '151', '374', '10', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('404', '151', '374', '11', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('405', '151', '374', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('406', '151', '375', '9', '2', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('407', '151', '375', '10', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('408', '151', '375', '11', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('409', '151', '375', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('410', '152', '376', '1', '3', '3', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('411', '152', '376', '4', '3', '2', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('412', '152', '376', '8', '2', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('413', '152', '376', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('414', '152', '377', '1', '2', '2', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('415', '152', '377', '4', '2', '1', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('416', '152', '377', '8', '1', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('417', '152', '377', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('418', '152', '378', '1', '5', '5', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('419', '152', '378', '4', '5', '2', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('420', '152', '378', '8', '2', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('421', '152', '378', '12', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('422', '153', '379', '1', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('423', '153', '379', '2', '120', '120', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('424', '153', '380', '1', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('425', '153', '380', '2', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('426', '153', '381', '1', '134', '134', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('427', '153', '381', '2', '134', '134', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('428', '155', '385', '1', '3', '3', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('429', '155', '385', '2', '3', '3', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('430', '155', '385', '6', '3', '3', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('431', '155', '385', '12', '3', '3', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('432', '155', '386', '1', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('433', '155', '386', '2', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('434', '155', '386', '6', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('435', '155', '386', '12', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('436', '155', '387', '1', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('437', '155', '387', '2', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('438', '155', '387', '6', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('439', '155', '387', '12', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('440', '157', '390', '1', '4', '4', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('441', '157', '390', '4', '4', '4', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('442', '157', '390', '5', '4', '4', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('443', '157', '390', '8', '4', '4', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('444', '157', '390', '12', '4', '4', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('445', '157', '391', '1', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('446', '157', '391', '4', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('447', '157', '391', '5', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('448', '157', '391', '8', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('449', '157', '391', '12', '5', '5', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('450', '157', '392', '1', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('451', '157', '392', '4', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('452', '157', '392', '5', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('453', '157', '392', '8', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('454', '157', '392', '12', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('455', '158', '393', '9', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('456', '158', '393', '10', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('457', '158', '393', '11', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('458', '158', '393', '12', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('459', '158', '394', '9', '150', '150', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('460', '158', '394', '10', '150', '150', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('461', '158', '394', '11', '150', '150', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('462', '158', '394', '12', '150', '150', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('463', '158', '395', '9', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('464', '158', '395', '10', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('465', '158', '395', '11', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('466', '158', '395', '12', '100', '100', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('467', '158', '396', '9', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('468', '158', '396', '10', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('469', '158', '396', '11', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('470', '158', '396', '12', '50', '50', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('471', '160', '400', '4', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('472', '160', '401', '4', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('473', '160', '402', '4', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('474', '161', '403', '1', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('475', '161', '403', '2', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('476', '161', '404', '1', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('477', '161', '404', '2', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('482', '166', '422', '6', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('483', '166', '423', '6', '100', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('484', '166', '424', '6', '20', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('485', '166', '425', '6', '100', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('490', '168', '428', '11', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('491', '168', '429', '11', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('492', '168', '428', '11', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('493', '168', '429', '11', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('494', '168', '430', '11', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('495', '168', '431', '11', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('507', '171', '441', '5', '500', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('508', '171', '442', '5', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('509', '171', '443', '5', '40', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('510', '171', '441', '9', '500', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('511', '171', '442', '9', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('512', '171', '443', '9', '40', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('513', '171', '445', '9', '50', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('514', '171', '446', '9', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('515', '171', '447', '9', '40', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('516', '171', '445', '9', '50', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('517', '171', '446', '9', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('518', '171', '447', '9', '40', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('519', '176', '451', '5', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('520', '176', '451', '6', '2', '2', '1', '11');
INSERT INTO `lifetek_kcs` VALUES ('521', '176', '452', '5', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('522', '176', '452', '6', '1', '1', '1', '11');
INSERT INTO `lifetek_kcs` VALUES ('523', '177', '453', '5', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('524', '177', '454', '5', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('525', '177', '455', '5', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('526', '180', '461', '5', '10', '10', '1', '13');
INSERT INTO `lifetek_kcs` VALUES ('527', '180', '462', '5', '1', '1', '1', '13');
INSERT INTO `lifetek_kcs` VALUES ('528', '180', '463', '5', '1', '1', '1', '13');
INSERT INTO `lifetek_kcs` VALUES ('529', '181', '464', '5', '20', '20', '1', '16');
INSERT INTO `lifetek_kcs` VALUES ('530', '182', '465', '20', '5', '5', '1', '18');
INSERT INTO `lifetek_kcs` VALUES ('531', '182', '466', '20', '3', '3', '1', '18');
INSERT INTO `lifetek_kcs` VALUES ('532', '182', '467', '20', '2', '2', '1', '18');
INSERT INTO `lifetek_kcs` VALUES ('533', '183', '468', '10', '10', '10', '1', '19');
INSERT INTO `lifetek_kcs` VALUES ('534', '183', '469', '10', '2', '2', '1', '19');
INSERT INTO `lifetek_kcs` VALUES ('535', '184', '470', '10', '10', '10', '1', '20');
INSERT INTO `lifetek_kcs` VALUES ('536', '184', '471', '10', '2', '2', '1', '20');
INSERT INTO `lifetek_kcs` VALUES ('537', '185', '472', '16', '2', '2', '1', '21');
INSERT INTO `lifetek_kcs` VALUES ('538', '186', '473', '26', '1', '1', '1', '22');
INSERT INTO `lifetek_kcs` VALUES ('539', '187', '474', '26', '1', '1', '1', '23');
INSERT INTO `lifetek_kcs` VALUES ('540', '188', '475', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('541', '188', '475', '20', '10', '10', '1', '24');
INSERT INTO `lifetek_kcs` VALUES ('542', '188', '476', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('543', '188', '476', '20', '10', '10', '1', '24');
INSERT INTO `lifetek_kcs` VALUES ('544', '188', '477', '5', '15', '15', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('545', '188', '477', '20', '15', '5', '1', '24');
INSERT INTO `lifetek_kcs` VALUES ('546', '188', '478', '5', '15', '15', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('547', '188', '478', '20', '15', '15', '1', '24');
INSERT INTO `lifetek_kcs` VALUES ('548', '189', '479', '22', '1', '1', '1', '25');
INSERT INTO `lifetek_kcs` VALUES ('549', '190', '480', '22', '1', '1', '1', '26');
INSERT INTO `lifetek_kcs` VALUES ('550', '190', '481', '22', '1', '1', '1', '26');
INSERT INTO `lifetek_kcs` VALUES ('551', '191', '482', '16', '1', '1', '1', '27');
INSERT INTO `lifetek_kcs` VALUES ('552', '192', '483', '22', '5', '5', '1', '29');
INSERT INTO `lifetek_kcs` VALUES ('553', '192', '484', '22', '6', '6', '1', '29');
INSERT INTO `lifetek_kcs` VALUES ('554', '192', '485', '22', '7', '7', '1', '29');
INSERT INTO `lifetek_kcs` VALUES ('555', '193', '486', '16', '10', '10', '1', '30');
INSERT INTO `lifetek_kcs` VALUES ('556', '194', '487', '16', '2', '2', '1', '31');
INSERT INTO `lifetek_kcs` VALUES ('557', '195', '488', '16', '5', '5', '1', '32');
INSERT INTO `lifetek_kcs` VALUES ('558', '195', '489', '16', '12', '12', '1', '32');
INSERT INTO `lifetek_kcs` VALUES ('559', '195', '490', '16', '4', '4', '1', '32');
INSERT INTO `lifetek_kcs` VALUES ('560', '195', '491', '16', '3', '3', '1', '32');
INSERT INTO `lifetek_kcs` VALUES ('561', '195', '488', '16', '5', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('562', '195', '489', '16', '12', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('563', '195', '490', '16', '4', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('564', '195', '491', '16', '3', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('565', '196', '492', '11', '7', '7', '1', '33');
INSERT INTO `lifetek_kcs` VALUES ('566', '197', '493', '16', '10', '10', '1', '34');
INSERT INTO `lifetek_kcs` VALUES ('567', '197', '494', '16', '1', '1', '1', '34');
INSERT INTO `lifetek_kcs` VALUES ('568', '197', '495', '16', '2', '2', '1', '34');
INSERT INTO `lifetek_kcs` VALUES ('569', '199', '498', '22', '2', '2', '1', '35');
INSERT INTO `lifetek_kcs` VALUES ('570', '198', '496', '16', '10', '10', '1', '36');
INSERT INTO `lifetek_kcs` VALUES ('571', '198', '497', '16', '2', '2', '1', '36');
INSERT INTO `lifetek_kcs` VALUES ('572', '201', '500', '22', '5', '5', '1', '38');
INSERT INTO `lifetek_kcs` VALUES ('573', '201', '501', '22', '2', '2', '1', '38');
INSERT INTO `lifetek_kcs` VALUES ('574', '201', '502', '22', '4', '4', '1', '38');
INSERT INTO `lifetek_kcs` VALUES ('575', '201', '503', '22', '3', '3', '1', '38');
INSERT INTO `lifetek_kcs` VALUES ('576', '201', '504', '22', '1', '1', '1', '38');
INSERT INTO `lifetek_kcs` VALUES ('577', '202', '505', '16', '3', '3', '1', '39');
INSERT INTO `lifetek_kcs` VALUES ('578', '203', '506', '16', '4', '4', '1', '40');
INSERT INTO `lifetek_kcs` VALUES ('579', '204', '507', '21', '2', '2', '1', '41');
INSERT INTO `lifetek_kcs` VALUES ('580', '204', '508', '21', '2', '2', '1', '41');
INSERT INTO `lifetek_kcs` VALUES ('581', '204', '509', '21', '2', '2', '1', '41');
INSERT INTO `lifetek_kcs` VALUES ('582', '205', '510', '14', '10', '10', '1', '42');
INSERT INTO `lifetek_kcs` VALUES ('583', '205', '511', '14', '10', '5', '1', '42');
INSERT INTO `lifetek_kcs` VALUES ('584', '205', '512', '14', '10', '10', '1', '42');
INSERT INTO `lifetek_kcs` VALUES ('585', '206', '513', '14', '3', '2', '1', '43');
INSERT INTO `lifetek_kcs` VALUES ('586', '206', '513', '14', '3', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('587', '206', '513', '14', '3', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('588', '207', '514', '16', '2', '2', '1', '44');
INSERT INTO `lifetek_kcs` VALUES ('589', '209', '519', '9', '1', '1', '1', '45');
INSERT INTO `lifetek_kcs` VALUES ('590', '209', '520', '9', '1', '1', '1', '45');
INSERT INTO `lifetek_kcs` VALUES ('591', '210', '521', '9', '10', '10', '1', '46');
INSERT INTO `lifetek_kcs` VALUES ('592', '210', '522', '9', '1', '1', '1', '46');
INSERT INTO `lifetek_kcs` VALUES ('593', '213', '526', '9', '1', '1', '1', '47');
INSERT INTO `lifetek_kcs` VALUES ('594', '214', '527', '14', '100', '100', '1', '48');
INSERT INTO `lifetek_kcs` VALUES ('595', '216', '531', '13', '10', '10', '1', '49');
INSERT INTO `lifetek_kcs` VALUES ('596', '216', '532', '13', '10', '10', '1', '49');
INSERT INTO `lifetek_kcs` VALUES ('597', '216', '533', '13', '10', '10', '1', '49');
INSERT INTO `lifetek_kcs` VALUES ('598', '217', '534', '9', '5', '5', '1', '50');
INSERT INTO `lifetek_kcs` VALUES ('599', '217', '534', '9', '5', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('600', '215', '528', '6', '10', '10', '1', '52');
INSERT INTO `lifetek_kcs` VALUES ('601', '215', '529', '6', '10', '10', '1', '52');
INSERT INTO `lifetek_kcs` VALUES ('602', '215', '530', '6', '10', '10', '1', '52');
INSERT INTO `lifetek_kcs` VALUES ('603', '218', '535', '22', '2', '2', '1', '53');
INSERT INTO `lifetek_kcs` VALUES ('604', '218', '536', '22', '1', '1', '1', '53');
INSERT INTO `lifetek_kcs` VALUES ('605', '218', '537', '22', '3', '3', '1', '53');
INSERT INTO `lifetek_kcs` VALUES ('606', '220', '540', '16', '2', '2', '1', '54');
INSERT INTO `lifetek_kcs` VALUES ('607', '220', '541', '16', '1', '1', '1', '54');
INSERT INTO `lifetek_kcs` VALUES ('608', '220', '542', '16', '1', '1', '1', '54');
INSERT INTO `lifetek_kcs` VALUES ('609', '221', '543', '16', '10', '10', '1', '55');
INSERT INTO `lifetek_kcs` VALUES ('610', '222', '544', '16', '1', '1', '1', '56');
INSERT INTO `lifetek_kcs` VALUES ('611', '223', '545', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('612', '223', '545', '9', '10', '10', '1', '57');
INSERT INTO `lifetek_kcs` VALUES ('613', '223', '546', '5', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('614', '223', '546', '9', '10', '10', '1', '57');
INSERT INTO `lifetek_kcs` VALUES ('615', '223', '547', '5', '90', '90', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('616', '223', '547', '9', '90', '90', '1', '57');
INSERT INTO `lifetek_kcs` VALUES ('617', '224', '548', '5', '10', '10', '1', '58');
INSERT INTO `lifetek_kcs` VALUES ('618', '225', '550', '9', '98', '98', '1', '59');
INSERT INTO `lifetek_kcs` VALUES ('619', '226', '551', '9', '10', '10', '1', '60');
INSERT INTO `lifetek_kcs` VALUES ('620', '227', '552', '9', '1', '1', '1', '61');
INSERT INTO `lifetek_kcs` VALUES ('621', '228', '553', '20', '100', '100', '1', '62');
INSERT INTO `lifetek_kcs` VALUES ('622', '229', '554', '9', '10', '10', '1', '63');
INSERT INTO `lifetek_kcs` VALUES ('623', '230', '555', '9', '100', '100', '1', '64');
INSERT INTO `lifetek_kcs` VALUES ('624', '231', '556', '9', '200', '200', '1', '65');
INSERT INTO `lifetek_kcs` VALUES ('625', '232', '557', '15', '100', '100', '1', '66');
INSERT INTO `lifetek_kcs` VALUES ('626', '233', '558', '15', '5', '5', '1', '67');
INSERT INTO `lifetek_kcs` VALUES ('627', '234', '559', '14', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('628', '234', '559', '16', '10', '10', '1', '68');
INSERT INTO `lifetek_kcs` VALUES ('629', '234', '560', '14', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('630', '234', '560', '16', '10', '10', '1', '68');
INSERT INTO `lifetek_kcs` VALUES ('631', '236', '562', '21', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('632', '236', '562', '22', '10', '10', '1', '69');
INSERT INTO `lifetek_kcs` VALUES ('633', '236', '563', '21', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('634', '236', '563', '22', '10', '10', '1', '69');
INSERT INTO `lifetek_kcs` VALUES ('635', '236', '564', '21', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('636', '236', '564', '22', '10', '10', '1', '69');
INSERT INTO `lifetek_kcs` VALUES ('637', '236', '562', '21', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('638', '236', '562', '22', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('639', '236', '563', '21', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('640', '236', '563', '22', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('641', '236', '564', '21', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('642', '236', '564', '22', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('643', '237', '565', '21', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('644', '237', '565', '22', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('645', '237', '565', '20', '10', '10', '1', '70');
INSERT INTO `lifetek_kcs` VALUES ('646', '237', '566', '21', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('647', '237', '566', '22', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('648', '237', '566', '20', '10', '10', '1', '70');
INSERT INTO `lifetek_kcs` VALUES ('649', '237', '567', '21', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('650', '237', '567', '22', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('651', '237', '567', '20', '10', '10', '1', '70');
INSERT INTO `lifetek_kcs` VALUES ('652', '237', '565', '21', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('653', '237', '565', '22', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('654', '237', '565', '20', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('655', '237', '566', '21', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('656', '237', '566', '22', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('657', '237', '566', '20', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('658', '237', '567', '21', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('659', '237', '567', '22', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('660', '237', '567', '20', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('661', '238', '568', '5', '10', '10', '1', '71');
INSERT INTO `lifetek_kcs` VALUES ('662', '239', '569', '14', '10', '10', '1', '72');
INSERT INTO `lifetek_kcs` VALUES ('663', '241', '571', '34', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('664', '241', '571', '35', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('665', '241', '571', '36', '2', '2', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('666', '241', '571', '37', '2', '2', '1', '73');
INSERT INTO `lifetek_kcs` VALUES ('667', '242', '572', '14', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('668', '242', '572', '15', '10', '10', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('669', '242', '572', '16', '10', '10', '1', '74');
INSERT INTO `lifetek_kcs` VALUES ('670', '242', '573', '14', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('671', '242', '573', '15', '1', '1', '1', '0');
INSERT INTO `lifetek_kcs` VALUES ('672', '242', '573', '16', '1', '1', '1', '74');
INSERT INTO `lifetek_kcs` VALUES ('673', '242', '572', '14', '10', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('674', '242', '572', '15', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('675', '242', '572', '16', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('676', '242', '573', '14', '1', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('677', '242', '573', '15', '0', '0', '0', '0');
INSERT INTO `lifetek_kcs` VALUES ('678', '242', '573', '16', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for lifetek_kcs_history
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_kcs_history`;
CREATE TABLE `lifetek_kcs_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kcs_history_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `feature_size_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `quantity_kcs` int(11) NOT NULL,
  `quantity_success` int(11) NOT NULL,
  `quantity_error` int(11) NOT NULL,
  `cause_error` text CHARACTER SET utf8 NOT NULL,
  `date_kcs` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=805 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_kcs_history
-- ----------------------------
INSERT INTO `lifetek_kcs_history` VALUES ('149', '126', '53', '111', '4', '2', '1', '1', '', '2015-08-29 11:54:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('150', '126', '53', '111', '4', '1', '1', '0', '', '2015-08-29 11:54:55', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('151', '128', '54', '113', '6', '30', '20', '10', '', '2015-08-29 13:58:14', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('152', '127', '54', '112', '6', '20', '10', '10', '', '2015-08-29 13:58:14', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('153', '128', '54', '113', '6', '10', '10', '0', '', '2015-08-29 13:59:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('154', '127', '54', '112', '6', '10', '10', '0', '', '2015-08-29 13:59:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('155', '128', '54', '113', '6', '0', '0', '0', '', '2015-08-29 14:01:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('156', '127', '54', '112', '6', '0', '0', '0', '', '2015-08-29 14:01:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('157', '129', '55', '114', '5', '2', '0', '2', '', '2015-08-29 15:40:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('158', '130', '55', '115', '5', '5', '5', '0', '', '2015-08-29 15:40:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('159', '129', '55', '114', '5', '2', '1', '1', '', '2015-08-29 15:42:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('160', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-29 15:42:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('161', '129', '55', '114', '5', '1', '1', '0', '', '2015-08-29 15:43:40', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('162', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-29 15:43:40', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('163', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:05:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('164', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:05:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('165', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:05:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('166', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:05:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('167', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:06:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('168', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:06:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('169', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:08:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('170', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:08:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('171', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:09:10', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('172', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:09:10', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('173', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:09:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('174', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:09:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('175', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('176', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('177', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:10:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('178', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:10:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('179', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('180', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('181', '129', '55', '114', '5', '0', '0', '0', '', '2015-08-31 11:14:57', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('182', '130', '55', '115', '5', '0', '0', '0', '', '2015-08-31 11:14:57', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('183', '133', '57', '125', '4', '10', '10', '0', '', '2015-09-01 08:50:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('184', '135', '57', '126', '4', '5', '5', '0', '', '2015-09-01 08:50:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('185', '137', '57', '127', '4', '5', '3', '2', '', '2015-09-01 08:50:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('186', '133', '57', '125', '4', '0', '0', '0', '', '2015-09-01 08:51:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('187', '135', '57', '126', '4', '0', '0', '0', '', '2015-09-01 08:51:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('188', '137', '57', '127', '4', '2', '2', '0', '', '2015-09-01 08:51:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('189', '134', '57', '125', '5', '10', '1', '9', '', '2015-09-01 10:53:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('190', '136', '57', '126', '5', '5', '2', '3', '', '2015-09-01 10:53:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('191', '138', '57', '127', '5', '5', '2', '3', '', '2015-09-01 10:54:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('192', '134', '57', '125', '5', '9', '1', '8', '', '2015-09-01 10:56:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('193', '136', '57', '126', '5', '3', '1', '2', '', '2015-09-01 10:56:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('194', '138', '57', '127', '5', '3', '1', '2', '', '2015-09-01 10:56:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('195', '139', '58', '128', '4', '20', '20', '0', '', '2015-09-01 11:03:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('196', '141', '58', '129', '4', '30', '30', '0', '', '2015-09-01 11:03:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('197', '143', '58', '130', '4', '10', '10', '0', '', '2015-09-01 11:03:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('198', '140', '58', '128', '6', '20', '20', '0', '', '2015-09-01 11:03:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('199', '142', '58', '129', '6', '30', '30', '0', '', '2015-09-01 11:03:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('200', '144', '58', '130', '6', '10', '10', '0', '', '2015-09-01 11:03:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('201', '140', '58', '128', '6', '0', '0', '0', '', '2015-09-01 11:03:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('202', '142', '58', '129', '6', '0', '0', '0', '', '2015-09-01 11:03:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('203', '144', '58', '130', '6', '0', '0', '0', '', '2015-09-01 11:03:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('204', '145', '50', '106', '4', '8', '8', '0', '', '2015-09-01 11:34:37', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('205', '147', '50', '107', '4', '80', '79', '1', '', '2015-09-01 11:34:37', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('206', '145', '50', '106', '4', '0', '0', '0', '', '2015-09-01 11:34:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('207', '147', '50', '107', '4', '1', '1', '0', '', '2015-09-01 11:34:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('208', '146', '50', '106', '5', '8', '5', '3', '', '2015-09-01 11:35:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('209', '148', '50', '107', '5', '80', '78', '2', '', '2015-09-01 11:35:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('210', '146', '50', '106', '5', '3', '3', '0', '', '2015-09-01 11:35:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('211', '148', '50', '107', '5', '2', '1', '1', '', '2015-09-01 11:35:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('212', '149', '60', '134', '4', '20', '20', '0', '', '2015-09-01 14:14:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('213', '152', '60', '135', '4', '30', '30', '0', '', '2015-09-01 14:14:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('214', '155', '60', '136', '4', '50', '50', '0', '', '2015-09-01 14:14:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('215', '150', '60', '134', '5', '20', '19', '1', '', '2015-09-01 14:14:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('216', '153', '60', '135', '5', '30', '30', '0', '', '2015-09-01 14:14:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('217', '156', '60', '136', '5', '50', '50', '0', '', '2015-09-01 14:14:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('218', '150', '60', '134', '5', '1', '1', '0', '', '2015-09-01 14:15:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('219', '153', '60', '135', '5', '0', '0', '0', '', '2015-09-01 14:15:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('220', '156', '60', '136', '5', '0', '0', '0', '', '2015-09-01 14:15:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('221', '151', '60', '134', '6', '20', '20', '0', '', '2015-09-01 14:15:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('222', '154', '60', '135', '6', '30', '30', '0', '', '2015-09-01 14:15:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('223', '157', '60', '136', '6', '50', '50', '0', '', '2015-09-01 14:15:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('224', '164', '61', '140', '1', '20', '19', '1', '', '2015-09-01 15:28:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('225', '166', '61', '141', '1', '10', '10', '0', '', '2015-09-01 15:28:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('226', '168', '61', '142', '1', '10', '10', '0', '', '2015-09-01 15:28:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('227', '158', '61', '137', '1', '20', '20', '0', '', '2015-09-01 15:28:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('228', '160', '61', '138', '1', '10', '10', '0', '', '2015-09-01 15:28:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('229', '162', '61', '139', '1', '10', '10', '0', '', '2015-09-01 15:28:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('230', '164', '61', '140', '1', '1', '1', '0', '', '2015-09-01 15:29:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('231', '166', '61', '141', '1', '0', '0', '0', '', '2015-09-01 15:29:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('232', '168', '61', '142', '1', '0', '0', '0', '', '2015-09-01 15:29:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('233', '158', '61', '137', '1', '0', '0', '0', '', '2015-09-01 15:29:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('234', '160', '61', '138', '1', '0', '0', '0', '', '2015-09-01 15:29:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('235', '162', '61', '139', '1', '0', '0', '0', '', '2015-09-01 15:29:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('236', '165', '61', '140', '2', '10', '0', '10', '', '2015-09-01 15:32:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('237', '167', '61', '141', '2', '10', '10', '0', '', '2015-09-01 15:32:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('238', '169', '61', '142', '2', '10', '10', '0', '', '2015-09-01 15:32:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('239', '159', '61', '137', '2', '20', '20', '0', '', '2015-09-01 15:32:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('240', '161', '61', '138', '2', '10', '10', '0', '', '2015-09-01 15:32:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('241', '163', '61', '139', '2', '10', '10', '0', '', '2015-09-01 15:32:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('242', '165', '61', '140', '2', '20', '20', '0', '', '2015-09-01 15:39:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('243', '167', '61', '141', '2', '0', '0', '0', '', '2015-09-01 15:39:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('244', '169', '61', '142', '2', '0', '0', '0', '', '2015-09-01 15:39:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('245', '159', '61', '137', '2', '0', '0', '0', '', '2015-09-01 15:39:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('246', '161', '61', '138', '2', '0', '0', '0', '', '2015-09-01 15:39:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('247', '163', '61', '139', '2', '0', '0', '0', '', '2015-09-01 15:39:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('248', '173', '62', '146', '1', '5', '5', '0', '', '2015-09-01 16:43:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('249', '174', '62', '147', '1', '5', '4', '1', '', '2015-09-01 16:43:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('250', '175', '62', '148', '1', '5', '4', '1', '', '2015-09-01 16:43:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('251', '170', '62', '143', '1', '5', '5', '0', '', '2015-09-01 16:43:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('252', '171', '62', '144', '1', '5', '5', '0', '', '2015-09-01 16:43:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('253', '172', '62', '145', '1', '5', '4', '1', '', '2015-09-01 16:43:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('254', '177', '63', '150', '3', '11', '11', '0', '', '2015-09-01 17:01:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('255', '176', '63', '149', '3', '11', '11', '0', '', '2015-09-01 17:01:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('256', '177', '63', '150', '3', '-1', '-1', '0', '', '2015-09-01 17:02:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('257', '176', '63', '149', '3', '-1', '-1', '0', '', '2015-09-01 17:02:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('258', '177', '63', '150', '3', '0', '0', '0', '', '2015-09-01 17:07:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('259', '176', '63', '149', '3', '0', '0', '0', '', '2015-09-01 17:07:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('260', '178', '67', '160', '4', '17', '17', '0', '', '2015-09-03 11:40:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('261', '180', '67', '161', '4', '17', '17', '0', '', '2015-09-03 11:40:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('262', '182', '67', '162', '4', '17', '17', '0', '', '2015-09-03 11:40:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('263', '179', '67', '160', '7', '17', '17', '0', '', '2015-09-03 11:40:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('264', '181', '67', '161', '7', '17', '17', '0', '', '2015-09-03 11:40:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('265', '183', '67', '162', '7', '17', '17', '0', '', '2015-09-03 11:40:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('266', '184', '73', '182', '4', '1', '1', '0', '', '2015-09-03 16:22:09', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('267', '189', '77', '193', '7', '10', '10', '0', '', '2015-09-04 11:50:58', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('268', '190', '77', '194', '7', '10', '10', '0', '', '2015-09-04 11:50:58', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('269', '187', '77', '191', '7', '10', '10', '0', '', '2015-09-04 11:50:58', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('270', '188', '77', '192', '7', '10', '10', '0', '', '2015-09-04 11:50:58', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('271', '191', '80', '201', '4', '35', '35', '0', '', '2015-09-04 13:53:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('272', '192', '80', '202', '4', '35', '35', '0', '', '2015-09-04 13:53:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('273', '193', '80', '203', '4', '35', '34', '1', '', '2015-09-04 13:53:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('274', '218', '81', '207', '1', '100000', '100000', '0', '', '2015-09-04 16:15:55', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('275', '214', '81', '206', '1', '10000', '10000', '0', '', '2015-09-04 16:15:55', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('276', '210', '81', '205', '1', '1000', '1000', '0', '', '2015-09-04 16:15:55', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('277', '206', '81', '204', '1', '100', '100', '0', '', '2015-09-04 16:15:55', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('278', '218', '81', '207', '1', '0', '0', '0', '', '2015-09-04 16:16:10', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('279', '214', '81', '206', '1', '0', '0', '0', '', '2015-09-04 16:16:10', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('280', '210', '81', '205', '1', '0', '0', '0', '', '2015-09-04 16:16:10', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('281', '206', '81', '204', '1', '0', '0', '0', '', '2015-09-04 16:16:10', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('282', '219', '81', '207', '2', '100000', '100000', '0', '', '2015-09-04 16:16:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('283', '215', '81', '206', '2', '10000', '10000', '0', '', '2015-09-04 16:16:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('284', '211', '81', '205', '2', '1000', '1000', '0', '', '2015-09-04 16:16:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('285', '207', '81', '204', '2', '100', '100', '0', '', '2015-09-04 16:16:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('286', '220', '81', '207', '5', '100000', '100000', '0', '', '2015-09-04 16:17:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('287', '216', '81', '206', '5', '10000', '10000', '0', '', '2015-09-04 16:17:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('288', '212', '81', '205', '5', '1000', '1000', '0', '', '2015-09-04 16:17:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('289', '208', '81', '204', '5', '100', '100', '0', '', '2015-09-04 16:17:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('290', '221', '81', '207', '7', '100000', '100000', '0', '', '2015-09-04 16:18:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('291', '217', '81', '206', '7', '10000', '10000', '0', '', '2015-09-04 16:18:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('292', '213', '81', '205', '7', '1000', '1000', '0', '', '2015-09-04 16:18:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('293', '209', '81', '204', '7', '100', '100', '0', '', '2015-09-04 16:18:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('294', '194', '83', '212', '4', '20', '20', '0', '', '2015-09-04 16:27:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('295', '197', '83', '213', '4', '10', '10', '0', '', '2015-09-04 16:27:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('296', '200', '83', '214', '4', '10', '10', '0', '', '2015-09-04 16:27:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('297', '203', '83', '215', '4', '10', '10', '0', '', '2015-09-04 16:27:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('298', '195', '83', '212', '5', '20', '20', '0', '', '2015-09-04 16:29:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('299', '198', '83', '213', '5', '10', '10', '0', '', '2015-09-04 16:29:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('300', '201', '83', '214', '5', '10', '10', '0', '', '2015-09-04 16:29:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('301', '204', '83', '215', '5', '10', '10', '0', '', '2015-09-04 16:29:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('302', '196', '83', '212', '6', '20', '20', '0', '', '2015-09-04 16:29:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('303', '199', '83', '213', '6', '10', '10', '0', '', '2015-09-04 16:29:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('304', '202', '83', '214', '6', '10', '10', '0', '', '2015-09-04 16:29:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('305', '205', '83', '215', '6', '10', '10', '0', '', '2015-09-04 16:29:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('306', '223', '84', '221', '3', '10', '10', '0', '', '2015-09-04 17:07:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('307', '222', '84', '220', '3', '100', '100', '0', '', '2015-09-04 17:07:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('308', '223', '84', '221', '3', '0', '0', '0', '', '2015-09-04 17:07:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('309', '222', '84', '220', '3', '0', '0', '0', '', '2015-09-04 17:07:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('310', '226', '85', '223', '1', '10', '10', '0', '', '2015-09-04 17:09:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('311', '224', '85', '222', '1', '10', '10', '0', '', '2015-09-04 17:09:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('312', '195', '83', '212', '5', '0', '0', '0', '', '2015-09-04 17:12:45', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('313', '198', '83', '213', '5', '0', '0', '0', '', '2015-09-04 17:12:45', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('314', '201', '83', '214', '5', '0', '0', '0', '', '2015-09-04 17:12:45', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('315', '204', '83', '215', '5', '0', '0', '0', '', '2015-09-04 17:12:45', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('316', '241', '80', '217', '6', '35', '35', '0', '', '2015-09-07 16:37:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('317', '242', '80', '218', '6', '35', '35', '0', '', '2015-09-07 16:37:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('318', '243', '80', '219', '6', '35', '35', '0', '', '2015-09-07 16:37:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('319', '240', '80', '216', '6', '10', '10', '0', '', '2015-09-07 16:37:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('320', '244', '91', '259', '4', '28', '28', '0', '', '2015-09-08 13:31:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('321', '246', '91', '260', '4', '28', '28', '0', '', '2015-09-08 13:31:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('322', '248', '91', '261', '4', '28', '28', '0', '', '2015-09-08 13:31:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('323', '250', '91', '262', '4', '28', '28', '0', '', '2015-09-08 13:31:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('324', '245', '91', '259', '5', '28', '28', '0', '', '2015-09-08 13:52:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('325', '247', '91', '260', '5', '28', '28', '0', '', '2015-09-08 13:52:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('326', '249', '91', '261', '5', '28', '28', '0', '', '2015-09-08 13:52:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('327', '251', '91', '262', '5', '28', '25', '3', '', '2015-09-08 13:52:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('328', '245', '91', '259', '5', '0', '0', '0', '', '2015-09-08 13:52:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('329', '247', '91', '260', '5', '0', '0', '0', '', '2015-09-08 13:52:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('330', '249', '91', '261', '5', '0', '0', '0', '', '2015-09-08 13:52:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('331', '251', '91', '262', '5', '3', '3', '0', '', '2015-09-08 13:52:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('332', '252', '92', '263', '4', '31', '31', '0', '', '2015-09-08 17:15:40', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('333', '254', '92', '264', '4', '31', '31', '0', '', '2015-09-08 17:15:40', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('334', '256', '92', '265', '4', '31', '31', '0', '', '2015-09-08 17:15:40', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('335', '258', '92', '266', '4', '31', '31', '0', '', '2015-09-08 17:15:40', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('336', '253', '92', '263', '7', '31', '31', '0', '', '2015-09-08 17:15:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('337', '255', '92', '264', '7', '31', '31', '0', '', '2015-09-08 17:15:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('338', '257', '92', '265', '7', '31', '31', '0', '', '2015-09-08 17:15:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('339', '259', '92', '266', '7', '31', '31', '0', '', '2015-09-08 17:15:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('340', '260', '93', '267', '4', '31', '31', '0', '', '2015-09-09 14:35:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('341', '263', '93', '268', '4', '31', '30', '1', '', '2015-09-09 14:35:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('342', '266', '93', '269', '4', '31', '31', '0', '', '2015-09-09 14:35:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('343', '269', '93', '270', '4', '31', '29', '2', '', '2015-09-09 14:35:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('344', '260', '93', '267', '4', '0', '0', '0', '', '2015-09-09 14:36:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('345', '263', '93', '268', '4', '1', '1', '0', '', '2015-09-09 14:36:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('346', '266', '93', '269', '4', '0', '0', '0', '', '2015-09-09 14:36:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('347', '269', '93', '270', '4', '2', '2', '0', '', '2015-09-09 14:36:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('348', '261', '93', '267', '5', '31', '31', '0', '', '2015-09-09 14:36:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('349', '264', '93', '268', '5', '31', '31', '0', '', '2015-09-09 14:36:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('350', '267', '93', '269', '5', '31', '31', '0', '', '2015-09-09 14:36:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('351', '270', '93', '270', '5', '31', '31', '0', '', '2015-09-09 14:36:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('352', '262', '93', '267', '7', '31', '31', '0', '', '2015-09-09 14:36:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('353', '265', '93', '268', '7', '31', '31', '0', '', '2015-09-09 14:36:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('354', '268', '93', '269', '7', '31', '31', '0', '', '2015-09-09 14:36:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('355', '271', '93', '270', '7', '31', '31', '0', '', '2015-09-09 14:36:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('356', '274', '97', '277', '4', '50', '50', '0', '', '2015-09-23 10:55:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('357', '272', '97', '276', '4', '20', '20', '0', '', '2015-09-23 10:55:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('358', '275', '97', '277', '5', '50', '50', '0', '', '2015-09-23 10:55:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('359', '273', '97', '276', '5', '20', '20', '0', '', '2015-09-23 10:55:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('360', '275', '97', '277', '5', '0', '0', '0', '', '2015-09-23 14:34:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('361', '273', '97', '276', '5', '0', '0', '0', '', '2015-09-23 14:34:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('362', '276', '100', '280', '4', '30', '25', '5', '', '2015-09-23 16:53:37', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('363', '277', '100', '280', '6', '25', '20', '5', '', '2015-09-23 16:53:53', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('364', '276', '100', '280', '4', '5', '5', '0', '', '2015-09-23 16:54:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('365', '277', '100', '280', '6', '10', '10', '0', '', '2015-09-23 16:54:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('366', '280', '101', '282', '4', '10', '10', '0', '', '2015-09-23 17:03:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('367', '278', '101', '281', '4', '30', '25', '5', '', '2015-09-23 17:03:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('368', '281', '101', '282', '6', '10', '10', '0', '', '2015-09-23 17:04:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('369', '279', '101', '281', '6', '25', '25', '0', '', '2015-09-23 17:04:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('370', '280', '101', '282', '4', '0', '0', '0', '', '2015-09-23 17:04:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('371', '278', '101', '281', '4', '5', '5', '0', '', '2015-09-23 17:04:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('372', '281', '101', '282', '6', '0', '0', '0', '', '2015-09-23 17:05:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('373', '279', '101', '281', '6', '5', '3', '2', '', '2015-09-23 17:05:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('374', '281', '101', '282', '6', '0', '0', '0', '', '2015-09-23 17:05:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('375', '279', '101', '281', '6', '2', '2', '0', '', '2015-09-23 17:05:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('376', '282', '102', '283', '5', '10', '8', '2', '', '2015-09-23 17:09:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('377', '283', '102', '283', '6', '8', '8', '0', '', '2015-09-23 17:09:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('378', '282', '102', '283', '5', '2', '2', '0', '', '2015-09-23 17:09:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('379', '283', '102', '283', '6', '2', '1', '1', '', '2015-09-23 17:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('380', '283', '102', '283', '6', '1', '1', '0', '', '2015-09-23 17:10:01', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('381', '284', '105', '286', '4', '20', '20', '0', '', '2015-09-23 17:39:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('382', '285', '106', '287', '4', '20', '20', '0', '', '2015-09-24 15:41:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('383', '286', '106', '288', '4', '40', '40', '0', '', '2015-09-24 15:41:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('384', '287', '106', '289', '4', '30', '30', '0', '', '2015-09-24 15:41:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('385', '285', '106', '287', '4', '10', '10', '0', '', '2015-09-24 15:41:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('386', '286', '106', '288', '4', '0', '0', '0', '', '2015-09-24 15:41:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('387', '287', '106', '289', '4', '0', '0', '0', '', '2015-09-24 15:41:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('388', '291', '107', '291', '4', '10', '10', '0', '', '2015-09-25 10:23:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('389', '289', '107', '290', '4', '20', '18', '2', '', '2015-09-25 10:23:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('390', '292', '107', '291', '6', '10', '10', '0', '', '2015-09-25 10:23:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('391', '290', '107', '290', '6', '18', '18', '0', '', '2015-09-25 10:23:13', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('392', '291', '107', '291', '4', '0', '0', '0', '', '2015-09-25 10:23:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('393', '289', '107', '290', '4', '2', '2', '0', '', '2015-09-25 10:23:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('394', '292', '107', '291', '6', '0', '0', '0', '', '2015-09-25 10:23:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('395', '290', '107', '290', '6', '2', '2', '0', '', '2015-09-25 10:23:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('396', '293', '111', '299', '4', '2', '2', '0', '', '2015-09-30 11:38:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('397', '293', '111', '299', '4', '2', '2', '0', '', '2015-09-30 11:41:22', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('398', '293', '111', '299', '4', '5', '5', '0', '', '2015-09-30 11:42:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('399', '293', '111', '299', '4', '4', '4', '0', '', '2015-09-30 11:44:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('400', '293', '111', '299', '4', '0', '0', '0', '', '2015-09-30 11:45:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('401', '295', '117', '306', '4', '10', '10', '0', '', '2015-09-30 15:04:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('402', '296', '117', '307', '4', '10', '10', '0', '', '2015-09-30 15:04:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('403', '297', '117', '308', '4', '10', '10', '0', '', '2015-09-30 15:04:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('404', '295', '117', '306', '4', '0', '0', '0', '', '2015-09-30 15:04:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('405', '296', '117', '307', '4', '0', '0', '0', '', '2015-09-30 15:04:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('406', '297', '117', '308', '4', '0', '0', '0', '', '2015-09-30 15:04:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('407', '298', '116', '309', '1', '2', '2', '0', '', '2015-09-30 15:08:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('408', '301', '116', '310', '1', '2', '2', '0', '', '2015-09-30 15:08:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('409', '298', '116', '309', '1', '50', '50', '0', '', '2015-09-30 15:08:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('410', '301', '116', '310', '1', '54', '54', '0', '', '2015-09-30 15:08:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('411', '299', '116', '309', '2', '52', '52', '0', '', '2015-09-30 15:09:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('412', '302', '116', '310', '2', '56', '56', '0', '', '2015-09-30 15:09:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('413', '304', '115', '304', '2', '12', '12', '0', '', '2015-09-30 15:11:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('414', '304', '115', '304', '2', '0', '0', '0', '', '2015-09-30 15:13:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('415', '300', '116', '309', '7', '2', '2', '0', '', '2015-09-30 15:17:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('416', '303', '116', '310', '7', '6', '6', '0', '', '2015-09-30 15:17:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('417', '298', '116', '309', '1', '68', '68', '0', '', '2015-09-30 15:18:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('418', '301', '116', '310', '1', '44', '44', '0', '', '2015-09-30 15:18:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('419', '298', '116', '309', '1', '0', '0', '0', '', '2015-09-30 15:18:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('420', '301', '116', '310', '1', '0', '0', '0', '', '2015-09-30 15:18:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('421', '299', '116', '309', '2', '68', '68', '0', '', '2015-09-30 15:19:01', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('422', '302', '116', '310', '2', '44', '44', '0', '', '2015-09-30 15:19:01', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('423', '300', '116', '309', '7', '118', '118', '0', '', '2015-09-30 15:19:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('424', '303', '116', '310', '7', '94', '94', '0', '', '2015-09-30 15:19:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('425', '305', '119', '312', '1', '1', '1', '0', '', '2015-09-30 15:46:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('426', '306', '119', '312', '2', '1', '1', '0', '', '2015-09-30 15:46:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('427', '307', '120', '313', '1', '1', '1', '0', '', '2015-09-30 15:50:07', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('428', '307', '120', '313', '1', '1', '1', '0', '', '2015-09-30 15:51:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('429', '307', '120', '313', '1', '1', '1', '0', '', '2015-09-30 15:51:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('430', '307', '120', '313', '1', '1', '1', '0', '', '2015-09-30 15:51:53', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('431', '307', '120', '313', '1', '1', '1', '0', '', '2015-09-30 15:51:56', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('432', '307', '120', '313', '1', '1', '1', '0', '', '2015-09-30 15:52:00', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('433', '308', '120', '313', '2', '1', '1', '0', '', '2015-09-30 15:52:23', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('434', '308', '120', '313', '2', '1', '1', '0', '', '2015-09-30 15:52:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('435', '308', '120', '313', '2', '1', '1', '0', '', '2015-09-30 15:52:35', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('436', '308', '120', '313', '2', '1', '1', '0', '', '2015-09-30 15:52:49', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('437', '308', '120', '313', '2', '1', '1', '0', '', '2015-09-30 15:53:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('438', '308', '120', '313', '2', '1', '1', '0', '', '2015-09-30 15:53:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('439', '307', '120', '313', '1', '-3', '-3', '0', '', '2015-09-30 15:53:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('440', '307', '120', '313', '1', '-3', '-3', '0', '', '2015-09-30 15:53:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('441', '310', '121', '314', '2', '10', '10', '0', '', '2015-09-30 15:55:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('444', '312', '122', '315', '1', '1', '1', '0', '', '2015-09-30 16:00:04', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('445', '313', '122', '315', '2', '1', '1', '0', '', '2015-09-30 16:00:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('446', '314', '124', '317', '1', '1', '1', '0', '', '2015-09-30 16:12:33', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('447', '315', '124', '317', '3', '1', '1', '0', '', '2015-09-30 16:12:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('448', '316', '126', '326', '1', '50', '50', '0', '', '2015-10-01 15:45:47', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('449', '317', '126', '327', '1', '50', '50', '0', '', '2015-10-01 15:45:47', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('450', '318', '126', '328', '1', '50', '50', '0', '', '2015-10-01 15:45:47', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('451', '316', '126', '326', '1', '50', '50', '0', '', '2015-10-01 15:47:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('452', '317', '126', '327', '1', '50', '50', '0', '', '2015-10-01 15:47:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('453', '318', '126', '328', '1', '50', '50', '0', '', '2015-10-01 15:47:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('454', '320', '128', '331', '1', '200', '200', '0', '', '2015-10-02 09:01:29', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('455', '320', '128', '331', '1', '0', '0', '0', '', '2015-10-02 09:01:41', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('456', '327', '129', '335', '4', '100', '100', '0', '', '2015-10-02 11:23:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('457', '329', '129', '336', '4', '100', '100', '0', '', '2015-10-02 11:23:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('458', '331', '129', '337', '4', '100', '100', '0', '', '2015-10-02 11:23:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('459', '321', '129', '332', '4', '100', '100', '0', '', '2015-10-02 11:23:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('460', '323', '129', '333', '4', '100', '100', '0', '', '2015-10-02 11:23:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('461', '325', '129', '334', '4', '100', '100', '0', '', '2015-10-02 11:23:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('462', '328', '129', '335', '5', '50', '50', '0', '', '2015-10-02 11:25:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('463', '330', '129', '336', '5', '50', '50', '0', '', '2015-10-02 11:25:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('464', '332', '129', '337', '5', '50', '50', '0', '', '2015-10-02 11:25:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('465', '322', '129', '332', '5', '50', '50', '0', '', '2015-10-02 11:25:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('466', '324', '129', '333', '5', '50', '50', '0', '', '2015-10-02 11:25:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('467', '326', '129', '334', '5', '50', '50', '0', '', '2015-10-02 11:25:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('468', '327', '129', '335', '4', '0', '0', '0', '', '2015-10-02 13:40:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('469', '329', '129', '336', '4', '0', '0', '0', '', '2015-10-02 13:40:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('470', '331', '129', '337', '4', '0', '0', '0', '', '2015-10-02 13:40:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('471', '321', '129', '332', '4', '0', '0', '0', '', '2015-10-02 13:40:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('472', '323', '129', '333', '4', '0', '0', '0', '', '2015-10-02 13:40:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('473', '325', '129', '334', '4', '0', '0', '0', '', '2015-10-02 13:40:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('474', '328', '129', '335', '5', '50', '50', '0', '', '2015-10-02 13:41:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('475', '330', '129', '336', '5', '50', '50', '0', '', '2015-10-02 13:41:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('476', '332', '129', '337', '5', '50', '50', '0', '', '2015-10-02 13:41:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('477', '322', '129', '332', '5', '50', '50', '0', '', '2015-10-02 13:41:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('478', '324', '129', '333', '5', '50', '50', '0', '', '2015-10-02 13:41:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('479', '326', '129', '334', '5', '50', '50', '0', '', '2015-10-02 13:41:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('480', '333', '130', '338', '1', '1000', '1000', '0', '', '2015-10-02 13:52:15', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('481', '333', '130', '338', '1', '0', '0', '0', '', '2015-10-02 13:52:27', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('482', '334', '131', '339', '1', '400', '400', '0', '', '2015-10-02 13:58:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('483', '340', '134', '342', '1', '12', '12', '0', '', '2015-10-02 15:39:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('484', '341', '134', '342', '2', '12', '12', '0', '', '2015-10-02 15:40:27', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('485', '344', '135', '343', '2', '122', '122', '0', '', '2015-10-02 15:47:43', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('486', '352', '139', '353', '3', '1000000', '1000000', '0', '', '2015-10-06 14:29:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('487', '346', '139', '350', '3', '1000', '1000', '0', '', '2015-10-06 14:29:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('488', '348', '139', '351', '3', '10000', '10000', '0', '', '2015-10-06 14:29:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('489', '350', '139', '352', '3', '100000', '100000', '0', '', '2015-10-06 14:29:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('490', '353', '139', '353', '4', '1000000', '1000000', '0', '', '2015-10-06 14:29:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('491', '347', '139', '350', '4', '1000', '1000', '0', '', '2015-10-06 14:29:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('492', '349', '139', '351', '4', '10000', '10000', '0', '', '2015-10-06 14:29:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('493', '351', '139', '352', '4', '100000', '100000', '0', '', '2015-10-06 14:29:17', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('494', '353', '139', '353', '4', '0', '0', '0', '', '2015-10-06 14:43:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('495', '347', '139', '350', '4', '0', '0', '0', '', '2015-10-06 14:43:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('496', '349', '139', '351', '4', '0', '0', '0', '', '2015-10-06 14:43:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('497', '351', '139', '352', '4', '0', '0', '0', '', '2015-10-06 14:43:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('498', '353', '139', '353', '4', '0', '0', '0', '', '2015-10-06 14:43:41', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('499', '347', '139', '350', '4', '0', '0', '0', '', '2015-10-06 14:43:41', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('500', '349', '139', '351', '4', '0', '0', '0', '', '2015-10-06 14:43:41', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('501', '351', '139', '352', '4', '0', '0', '0', '', '2015-10-06 14:43:41', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('502', '353', '139', '353', '4', '0', '0', '0', '', '2015-10-06 14:46:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('503', '347', '139', '350', '4', '0', '0', '0', '', '2015-10-06 14:46:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('504', '349', '139', '351', '4', '0', '0', '0', '', '2015-10-06 14:46:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('505', '351', '139', '352', '4', '0', '0', '0', '', '2015-10-06 14:46:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('506', '352', '139', '353', '3', '0', '0', '0', '', '2015-10-06 15:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('507', '346', '139', '350', '3', '0', '0', '0', '', '2015-10-06 15:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('508', '348', '139', '351', '3', '0', '0', '0', '', '2015-10-06 15:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('509', '350', '139', '352', '3', '0', '0', '0', '', '2015-10-06 15:09:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('510', '354', '140', '354', '1', '1', '1', '0', '', '2015-10-06 16:07:35', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('511', '356', '140', '355', '1', '2', '2', '0', '', '2015-10-06 16:07:35', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('512', '355', '140', '354', '6', '1', '1', '0', '', '2015-10-06 16:08:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('513', '357', '140', '355', '6', '2', '2', '0', '', '2015-10-06 16:08:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('514', '353', '139', '353', '4', '0', '0', '0', '', '2015-10-06 16:12:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('515', '347', '139', '350', '4', '0', '0', '0', '', '2015-10-06 16:12:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('516', '349', '139', '351', '4', '0', '0', '0', '', '2015-10-06 16:12:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('517', '351', '139', '352', '4', '0', '0', '0', '', '2015-10-06 16:12:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('518', '358', '141', '356', '1', '122', '122', '0', '', '2015-10-06 16:39:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('519', '359', '141', '356', '2', '122', '122', '0', '', '2015-10-06 16:39:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('520', '358', '141', '356', '1', '0', '0', '0', '', '2015-10-06 16:39:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('521', '359', '141', '356', '2', '0', '0', '0', '', '2015-10-06 16:39:46', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('522', '372', '144', '363', '1', '100', '100', '0', '', '2015-10-09 14:59:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('523', '376', '144', '364', '1', '100', '100', '0', '', '2015-10-09 14:59:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('524', '380', '144', '365', '1', '100', '100', '0', '', '2015-10-09 14:59:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('525', '360', '144', '360', '1', '100', '100', '0', '', '2015-10-09 14:59:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('526', '364', '144', '361', '1', '100', '100', '0', '', '2015-10-09 14:59:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('527', '368', '144', '362', '1', '100', '100', '0', '', '2015-10-09 14:59:18', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('528', '373', '144', '363', '12', '100', '100', '0', '', '2015-10-09 15:03:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('529', '377', '144', '364', '12', '100', '100', '0', '', '2015-10-09 15:03:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('530', '381', '144', '365', '12', '100', '100', '0', '', '2015-10-09 15:03:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('531', '361', '144', '360', '12', '100', '100', '0', '', '2015-10-09 15:03:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('532', '365', '144', '361', '12', '100', '100', '0', '', '2015-10-09 15:03:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('533', '369', '144', '362', '12', '100', '100', '0', '', '2015-10-09 15:03:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('534', '374', '144', '363', '4', '100', '100', '0', '', '2015-10-09 15:03:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('535', '378', '144', '364', '4', '100', '100', '0', '', '2015-10-09 15:03:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('536', '382', '144', '365', '4', '100', '100', '0', '', '2015-10-09 15:03:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('537', '362', '144', '360', '4', '100', '100', '0', '', '2015-10-09 15:03:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('538', '366', '144', '361', '4', '100', '100', '0', '', '2015-10-09 15:03:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('539', '370', '144', '362', '4', '100', '100', '0', '', '2015-10-09 15:03:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('540', '375', '144', '363', '9', '100', '100', '0', '', '2015-10-09 15:03:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('541', '379', '144', '364', '9', '100', '100', '0', '', '2015-10-09 15:03:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('542', '383', '144', '365', '9', '100', '100', '0', '', '2015-10-09 15:03:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('543', '363', '144', '360', '9', '100', '100', '0', '', '2015-10-09 15:03:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('544', '367', '144', '361', '9', '100', '100', '0', '', '2015-10-09 15:03:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('545', '371', '144', '362', '9', '100', '100', '0', '', '2015-10-09 15:03:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('546', '372', '144', '363', '1', '0', '0', '0', '', '2015-10-09 15:09:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('547', '376', '144', '364', '1', '0', '0', '0', '', '2015-10-09 15:09:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('548', '380', '144', '365', '1', '0', '0', '0', '', '2015-10-09 15:09:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('549', '360', '144', '360', '1', '0', '0', '0', '', '2015-10-09 15:09:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('550', '364', '144', '361', '1', '0', '0', '0', '', '2015-10-09 15:09:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('551', '368', '144', '362', '1', '0', '0', '0', '', '2015-10-09 15:09:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('552', '373', '144', '363', '12', '0', '0', '0', '', '2015-10-09 15:10:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('553', '377', '144', '364', '12', '0', '0', '0', '', '2015-10-09 15:10:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('554', '381', '144', '365', '12', '0', '0', '0', '', '2015-10-09 15:10:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('555', '361', '144', '360', '12', '0', '0', '0', '', '2015-10-09 15:10:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('556', '365', '144', '361', '12', '0', '0', '0', '', '2015-10-09 15:10:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('557', '369', '144', '362', '12', '0', '0', '0', '', '2015-10-09 15:10:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('558', '374', '144', '363', '4', '0', '0', '0', '', '2015-10-09 15:11:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('559', '378', '144', '364', '4', '0', '0', '0', '', '2015-10-09 15:11:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('560', '382', '144', '365', '4', '0', '0', '0', '', '2015-10-09 15:11:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('561', '362', '144', '360', '4', '0', '0', '0', '', '2015-10-09 15:11:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('562', '366', '144', '361', '4', '0', '0', '0', '', '2015-10-09 15:11:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('563', '370', '144', '362', '4', '0', '0', '0', '', '2015-10-09 15:11:36', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('564', '375', '144', '363', '9', '0', '0', '0', '', '2015-10-09 15:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('565', '379', '144', '364', '9', '0', '0', '0', '', '2015-10-09 15:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('566', '383', '144', '365', '9', '0', '0', '0', '', '2015-10-09 15:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('567', '363', '144', '360', '9', '0', '0', '0', '', '2015-10-09 15:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('568', '367', '144', '361', '9', '0', '0', '0', '', '2015-10-09 15:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('569', '371', '144', '362', '9', '0', '0', '0', '', '2015-10-09 15:11:48', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('570', '384', '145', '366', '1', '100', '100', '0', '', '2015-10-09 15:37:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('571', '385', '145', '366', '2', '100', '100', '0', '', '2015-10-09 15:37:58', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('572', '386', '145', '366', '5', '100', '100', '0', '', '2015-10-09 15:38:05', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('573', '387', '145', '366', '9', '100', '100', '0', '', '2015-10-09 15:38:12', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('574', '388', '148', '369', '1', '120', '120', '0', '', '2015-10-09 16:41:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('575', '389', '148', '369', '2', '120', '120', '0', '', '2015-10-09 16:42:02', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('576', '390', '148', '369', '4', '120', '120', '0', '', '2015-10-09 16:42:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('577', '391', '148', '369', '7', '120', '120', '0', '', '2015-10-09 16:42:56', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('578', '396', '150', '371', '4', '10', '10', '0', '', '2015-10-09 17:56:53', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('579', '397', '150', '372', '4', '10', '10', '0', '', '2015-10-09 17:56:53', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('580', '422', '153', '379', '1', '120', '120', '0', '', '2015-10-10 11:50:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('581', '424', '153', '380', '1', '100', '100', '0', '', '2015-10-10 11:50:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('582', '426', '153', '381', '1', '134', '134', '0', '', '2015-10-10 11:50:08', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('583', '423', '153', '379', '2', '120', '120', '0', '', '2015-10-10 11:50:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('584', '425', '153', '380', '2', '100', '100', '0', '', '2015-10-10 11:50:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('585', '427', '153', '381', '2', '134', '134', '0', '', '2015-10-10 11:50:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('586', '422', '153', '379', '1', '0', '0', '0', '', '2015-10-10 11:50:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('587', '424', '153', '380', '1', '0', '0', '0', '', '2015-10-10 11:50:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('588', '426', '153', '381', '1', '0', '0', '0', '', '2015-10-10 11:50:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('589', '423', '153', '379', '2', '0', '0', '0', '', '2015-10-10 11:50:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('590', '425', '153', '380', '2', '0', '0', '0', '', '2015-10-10 11:50:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('591', '427', '153', '381', '2', '0', '0', '0', '', '2015-10-10 11:50:38', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('592', '428', '155', '385', '1', '3', '3', '0', '', '2015-10-12 09:14:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('593', '432', '155', '386', '1', '5', '5', '0', '', '2015-10-12 09:14:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('594', '436', '155', '387', '1', '2', '2', '0', '', '2015-10-12 09:14:30', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('595', '429', '155', '385', '2', '3', '3', '0', '', '2015-10-12 09:14:44', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('596', '433', '155', '386', '2', '5', '5', '0', '', '2015-10-12 09:14:44', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('597', '437', '155', '387', '2', '2', '2', '0', '', '2015-10-12 09:14:44', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('598', '430', '155', '385', '6', '3', '3', '0', '', '2015-10-12 09:14:56', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('599', '434', '155', '386', '6', '5', '5', '0', '', '2015-10-12 09:14:56', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('600', '438', '155', '387', '6', '2', '2', '0', '', '2015-10-12 09:14:56', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('601', '431', '155', '385', '12', '3', '3', '0', '', '2015-10-12 09:15:11', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('602', '435', '155', '386', '12', '5', '5', '0', '', '2015-10-12 09:15:11', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('603', '439', '155', '387', '12', '2', '2', '0', '', '2015-10-12 09:15:11', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('604', '440', '157', '390', '1', '4', '4', '0', '', '2015-10-12 10:49:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('605', '445', '157', '391', '1', '5', '5', '0', '', '2015-10-12 10:49:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('606', '450', '157', '392', '1', '1', '1', '0', '', '2015-10-12 10:49:25', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('607', '441', '157', '390', '4', '4', '4', '0', '', '2015-10-12 10:49:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('608', '446', '157', '391', '4', '5', '5', '0', '', '2015-10-12 10:49:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('609', '451', '157', '392', '4', '1', '1', '0', '', '2015-10-12 10:49:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('610', '442', '157', '390', '5', '4', '4', '0', '', '2015-10-12 10:49:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('611', '447', '157', '391', '5', '5', '5', '0', '', '2015-10-12 10:49:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('612', '452', '157', '392', '5', '1', '1', '0', '', '2015-10-12 10:49:39', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('613', '443', '157', '390', '8', '4', '4', '0', '', '2015-10-12 10:49:47', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('614', '448', '157', '391', '8', '5', '5', '0', '', '2015-10-12 10:49:47', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('615', '453', '157', '392', '8', '1', '1', '0', '', '2015-10-12 10:49:47', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('616', '444', '157', '390', '12', '4', '4', '0', '', '2015-10-12 10:49:57', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('617', '449', '157', '391', '12', '5', '5', '0', '', '2015-10-12 10:49:57', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('618', '454', '157', '392', '12', '1', '1', '0', '', '2015-10-12 10:49:57', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('619', '455', '158', '393', '9', '50', '50', '0', '', '2015-10-13 14:13:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('620', '459', '158', '394', '9', '150', '150', '0', '', '2015-10-13 14:13:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('621', '463', '158', '395', '9', '100', '100', '0', '', '2015-10-13 14:13:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('622', '467', '158', '396', '9', '50', '50', '0', '', '2015-10-13 14:13:51', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('623', '456', '158', '393', '10', '50', '50', '0', '', '2015-10-13 14:14:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('624', '460', '158', '394', '10', '150', '150', '0', '', '2015-10-13 14:14:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('625', '464', '158', '395', '10', '100', '100', '0', '', '2015-10-13 14:14:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('626', '468', '158', '396', '10', '50', '50', '0', '', '2015-10-13 14:14:06', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('627', '457', '158', '393', '11', '50', '50', '0', '', '2015-10-13 14:14:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('628', '461', '158', '394', '11', '150', '150', '0', '', '2015-10-13 14:14:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('629', '465', '158', '395', '11', '100', '100', '0', '', '2015-10-13 14:14:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('630', '469', '158', '396', '11', '50', '50', '0', '', '2015-10-13 14:14:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('631', '458', '158', '393', '12', '50', '50', '0', '', '2015-10-13 14:14:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('632', '462', '158', '394', '12', '150', '150', '0', '', '2015-10-13 14:14:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('633', '466', '158', '395', '12', '100', '100', '0', '', '2015-10-13 14:14:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('634', '470', '158', '396', '12', '50', '50', '0', '', '2015-10-13 14:14:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('635', '410', '152', '376', '1', '3', '3', '0', '', '2015-10-20 10:32:09', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('636', '414', '152', '377', '1', '2', '2', '0', '', '2015-10-20 10:32:09', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('637', '418', '152', '378', '1', '5', '5', '0', '', '2015-10-20 10:32:09', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('638', '411', '152', '376', '4', '3', '2', '1', '', '2015-10-20 10:33:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('639', '415', '152', '377', '4', '2', '1', '1', '', '2015-10-20 10:33:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('640', '419', '152', '378', '4', '5', '2', '3', '', '2015-10-20 10:33:31', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('641', '471', '160', '400', '4', '1', '1', '0', '', '2015-10-28 12:01:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('642', '472', '160', '401', '4', '1', '1', '0', '', '2015-10-28 12:01:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('643', '473', '160', '402', '4', '1', '1', '0', '', '2015-10-28 12:01:21', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('644', '474', '161', '403', '1', '1', '1', '0', '', '2015-10-29 15:56:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('645', '476', '161', '404', '1', '2', '2', '0', '', '2015-10-29 15:56:20', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('646', '475', '161', '403', '2', '1', '1', '0', '', '2015-10-29 15:56:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('647', '477', '161', '404', '2', '2', '2', '0', '', '2015-10-29 15:56:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('648', '519', '176', '451', '5', '2', '2', '0', '', '2015-11-12 17:18:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('649', '521', '176', '452', '5', '1', '1', '0', '', '2015-11-12 17:18:50', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('650', '520', '176', '451', '6', '2', '2', '0', '', '2015-11-12 17:23:19', '11');
INSERT INTO `lifetek_kcs_history` VALUES ('651', '522', '176', '452', '6', '1', '1', '0', '', '2015-11-12 17:23:19', '11');
INSERT INTO `lifetek_kcs_history` VALUES ('652', '526', '180', '461', '5', '5', '4', '1', '', '2015-11-17 17:14:57', '12');
INSERT INTO `lifetek_kcs_history` VALUES ('653', '527', '180', '462', '5', '1', '1', '0', '', '2015-11-17 17:14:57', '12');
INSERT INTO `lifetek_kcs_history` VALUES ('654', '528', '180', '463', '5', '1', '1', '0', '', '2015-11-17 17:14:57', '12');
INSERT INTO `lifetek_kcs_history` VALUES ('655', '526', '180', '461', '5', '6', '6', '0', '', '2015-11-17 17:15:58', '13');
INSERT INTO `lifetek_kcs_history` VALUES ('656', '527', '180', '462', '5', '0', '0', '0', '', '2015-11-17 17:15:58', '13');
INSERT INTO `lifetek_kcs_history` VALUES ('657', '528', '180', '463', '5', '0', '0', '0', '', '2015-11-17 17:15:58', '13');
INSERT INTO `lifetek_kcs_history` VALUES ('658', '529', '181', '464', '5', '20', '20', '0', '', '2015-11-17 17:26:35', '14');
INSERT INTO `lifetek_kcs_history` VALUES ('659', '529', '181', '464', '5', '0', '0', '0', '', '2015-11-17 17:28:02', '15');
INSERT INTO `lifetek_kcs_history` VALUES ('660', '529', '181', '464', '5', '0', '0', '0', '', '2015-11-17 17:28:12', '16');
INSERT INTO `lifetek_kcs_history` VALUES ('661', '530', '182', '465', '20', '5', '4', '1', '', '2015-11-18 09:43:20', '17');
INSERT INTO `lifetek_kcs_history` VALUES ('662', '531', '182', '466', '20', '3', '3', '0', '', '2015-11-18 09:43:20', '17');
INSERT INTO `lifetek_kcs_history` VALUES ('663', '532', '182', '467', '20', '2', '2', '0', '', '2015-11-18 09:43:20', '17');
INSERT INTO `lifetek_kcs_history` VALUES ('664', '530', '182', '465', '20', '1', '1', '0', '', '2015-11-18 09:44:02', '18');
INSERT INTO `lifetek_kcs_history` VALUES ('665', '531', '182', '466', '20', '0', '0', '0', '', '2015-11-18 09:44:02', '18');
INSERT INTO `lifetek_kcs_history` VALUES ('666', '532', '182', '467', '20', '0', '0', '0', '', '2015-11-18 09:44:02', '18');
INSERT INTO `lifetek_kcs_history` VALUES ('667', '533', '183', '468', '10', '10', '10', '0', '', '2015-11-18 10:09:58', '19');
INSERT INTO `lifetek_kcs_history` VALUES ('668', '534', '183', '469', '10', '2', '2', '0', '', '2015-11-18 10:09:58', '19');
INSERT INTO `lifetek_kcs_history` VALUES ('669', '535', '184', '470', '10', '10', '10', '0', '', '2015-11-18 10:26:05', '20');
INSERT INTO `lifetek_kcs_history` VALUES ('670', '536', '184', '471', '10', '2', '2', '0', '', '2015-11-18 10:26:05', '20');
INSERT INTO `lifetek_kcs_history` VALUES ('671', '537', '185', '472', '16', '2', '2', '0', '', '2015-11-18 10:44:22', '21');
INSERT INTO `lifetek_kcs_history` VALUES ('672', '538', '186', '473', '26', '1', '1', '0', '', '2015-11-18 10:59:39', '22');
INSERT INTO `lifetek_kcs_history` VALUES ('673', '539', '187', '474', '26', '1', '1', '0', '', '2015-11-18 11:19:06', '23');
INSERT INTO `lifetek_kcs_history` VALUES ('674', '544', '188', '477', '5', '10', '5', '5', '', '2015-11-18 11:45:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('675', '546', '188', '478', '5', '15', '15', '0', '', '2015-11-18 11:45:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('676', '540', '188', '475', '5', '10', '10', '0', '', '2015-11-18 11:45:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('677', '542', '188', '476', '5', '10', '10', '0', '', '2015-11-18 11:45:19', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('678', '545', '188', '477', '20', '5', '5', '0', '', '2015-11-18 11:46:06', '24');
INSERT INTO `lifetek_kcs_history` VALUES ('679', '547', '188', '478', '20', '15', '15', '0', '', '2015-11-18 11:46:06', '24');
INSERT INTO `lifetek_kcs_history` VALUES ('680', '541', '188', '475', '20', '10', '10', '0', '', '2015-11-18 11:46:06', '24');
INSERT INTO `lifetek_kcs_history` VALUES ('681', '543', '188', '476', '20', '10', '10', '0', '', '2015-11-18 11:46:06', '24');
INSERT INTO `lifetek_kcs_history` VALUES ('682', '544', '188', '477', '5', '10', '10', '0', '', '2015-11-18 11:46:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('683', '546', '188', '478', '5', '0', '0', '0', '', '2015-11-18 11:46:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('684', '540', '188', '475', '5', '0', '0', '0', '', '2015-11-18 11:46:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('685', '542', '188', '476', '5', '0', '0', '0', '', '2015-11-18 11:46:28', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('686', '548', '189', '479', '22', '1', '1', '0', '', '2015-11-18 11:57:16', '25');
INSERT INTO `lifetek_kcs_history` VALUES ('687', '549', '190', '480', '22', '1', '1', '0', '', '2015-11-18 14:22:28', '26');
INSERT INTO `lifetek_kcs_history` VALUES ('688', '550', '190', '481', '22', '1', '1', '0', '', '2015-11-18 14:22:28', '26');
INSERT INTO `lifetek_kcs_history` VALUES ('689', '551', '191', '482', '16', '1', '1', '0', '', '2015-11-18 14:33:05', '27');
INSERT INTO `lifetek_kcs_history` VALUES ('690', '552', '192', '483', '22', '5', '5', '0', '', '2015-11-18 14:57:58', '28');
INSERT INTO `lifetek_kcs_history` VALUES ('691', '553', '192', '484', '22', '6', '6', '0', '', '2015-11-18 14:57:58', '28');
INSERT INTO `lifetek_kcs_history` VALUES ('692', '554', '192', '485', '22', '7', '7', '0', '', '2015-11-18 14:57:58', '28');
INSERT INTO `lifetek_kcs_history` VALUES ('693', '552', '192', '483', '22', '0', '0', '0', '', '2015-11-18 15:17:03', '29');
INSERT INTO `lifetek_kcs_history` VALUES ('694', '553', '192', '484', '22', '0', '0', '0', '', '2015-11-18 15:17:03', '29');
INSERT INTO `lifetek_kcs_history` VALUES ('695', '554', '192', '485', '22', '0', '0', '0', '', '2015-11-18 15:17:03', '29');
INSERT INTO `lifetek_kcs_history` VALUES ('696', '555', '193', '486', '16', '10', '10', '0', '', '2015-11-18 15:24:13', '30');
INSERT INTO `lifetek_kcs_history` VALUES ('697', '556', '194', '487', '16', '2', '2', '0', '', '2015-11-18 15:35:56', '31');
INSERT INTO `lifetek_kcs_history` VALUES ('698', '557', '195', '488', '16', '5', '5', '0', '', '2015-11-18 16:27:33', '32');
INSERT INTO `lifetek_kcs_history` VALUES ('699', '558', '195', '489', '16', '12', '12', '0', '', '2015-11-18 16:27:33', '32');
INSERT INTO `lifetek_kcs_history` VALUES ('700', '559', '195', '490', '16', '4', '4', '0', '', '2015-11-18 16:27:33', '32');
INSERT INTO `lifetek_kcs_history` VALUES ('701', '560', '195', '491', '16', '3', '3', '0', '', '2015-11-18 16:27:33', '32');
INSERT INTO `lifetek_kcs_history` VALUES ('702', '565', '196', '492', '11', '7', '7', '0', '', '2015-11-18 16:36:43', '33');
INSERT INTO `lifetek_kcs_history` VALUES ('703', '566', '197', '493', '16', '10', '10', '0', '', '2015-11-19 08:57:14', '34');
INSERT INTO `lifetek_kcs_history` VALUES ('704', '567', '197', '494', '16', '1', '1', '0', '', '2015-11-19 08:57:14', '34');
INSERT INTO `lifetek_kcs_history` VALUES ('705', '568', '197', '495', '16', '2', '2', '0', '', '2015-11-19 08:57:14', '34');
INSERT INTO `lifetek_kcs_history` VALUES ('706', '569', '199', '498', '22', '2', '2', '0', '', '2015-11-19 09:40:52', '35');
INSERT INTO `lifetek_kcs_history` VALUES ('707', '570', '198', '496', '16', '10', '10', '0', '', '2015-11-19 10:18:37', '36');
INSERT INTO `lifetek_kcs_history` VALUES ('708', '571', '198', '497', '16', '2', '2', '0', '', '2015-11-19 10:18:37', '36');
INSERT INTO `lifetek_kcs_history` VALUES ('709', '572', '201', '500', '22', '5', '5', '0', '', '2015-11-19 10:27:20', '37');
INSERT INTO `lifetek_kcs_history` VALUES ('710', '573', '201', '501', '22', '2', '2', '0', '', '2015-11-19 10:27:20', '37');
INSERT INTO `lifetek_kcs_history` VALUES ('711', '574', '201', '502', '22', '4', '4', '0', '', '2015-11-19 10:27:20', '37');
INSERT INTO `lifetek_kcs_history` VALUES ('712', '575', '201', '503', '22', '3', '3', '0', '', '2015-11-19 10:27:20', '37');
INSERT INTO `lifetek_kcs_history` VALUES ('713', '576', '201', '504', '22', '1', '1', '0', '', '2015-11-19 10:27:20', '37');
INSERT INTO `lifetek_kcs_history` VALUES ('714', '572', '201', '500', '22', '0', '0', '0', '', '2015-11-19 10:28:25', '38');
INSERT INTO `lifetek_kcs_history` VALUES ('715', '573', '201', '501', '22', '0', '0', '0', '', '2015-11-19 10:28:25', '38');
INSERT INTO `lifetek_kcs_history` VALUES ('716', '574', '201', '502', '22', '0', '0', '0', '', '2015-11-19 10:28:25', '38');
INSERT INTO `lifetek_kcs_history` VALUES ('717', '575', '201', '503', '22', '0', '0', '0', '', '2015-11-19 10:28:25', '38');
INSERT INTO `lifetek_kcs_history` VALUES ('718', '576', '201', '504', '22', '0', '0', '0', '', '2015-11-19 10:28:25', '38');
INSERT INTO `lifetek_kcs_history` VALUES ('719', '577', '202', '505', '16', '3', '3', '0', '', '2015-11-19 10:34:11', '39');
INSERT INTO `lifetek_kcs_history` VALUES ('720', '578', '203', '506', '16', '4', '4', '0', '', '2015-11-19 10:39:44', '40');
INSERT INTO `lifetek_kcs_history` VALUES ('721', '579', '204', '507', '21', '2', '2', '0', '', '2015-11-19 10:54:48', '41');
INSERT INTO `lifetek_kcs_history` VALUES ('722', '580', '204', '508', '21', '2', '2', '0', '', '2015-11-19 10:54:48', '41');
INSERT INTO `lifetek_kcs_history` VALUES ('723', '581', '204', '509', '21', '2', '2', '0', '', '2015-11-19 10:54:48', '41');
INSERT INTO `lifetek_kcs_history` VALUES ('724', '582', '205', '510', '14', '10', '10', '0', '', '2015-11-19 11:03:01', '42');
INSERT INTO `lifetek_kcs_history` VALUES ('725', '583', '205', '511', '14', '10', '5', '5', '', '2015-11-19 11:03:01', '42');
INSERT INTO `lifetek_kcs_history` VALUES ('726', '584', '205', '512', '14', '10', '10', '0', '', '2015-11-19 11:03:01', '42');
INSERT INTO `lifetek_kcs_history` VALUES ('727', '585', '206', '513', '14', '3', '2', '1', '', '2015-11-19 11:11:09', '43');
INSERT INTO `lifetek_kcs_history` VALUES ('728', '588', '207', '514', '16', '2', '2', '0', '', '2015-11-19 11:53:36', '44');
INSERT INTO `lifetek_kcs_history` VALUES ('729', '590', '209', '520', '9', '1', '1', '0', '', '2015-11-24 08:38:20', '45');
INSERT INTO `lifetek_kcs_history` VALUES ('730', '589', '209', '519', '9', '1', '1', '0', '', '2015-11-24 08:38:20', '45');
INSERT INTO `lifetek_kcs_history` VALUES ('731', '591', '210', '521', '9', '10', '10', '0', '', '2015-11-24 11:47:23', '46');
INSERT INTO `lifetek_kcs_history` VALUES ('732', '592', '210', '522', '9', '1', '1', '0', '', '2015-11-24 11:47:23', '46');
INSERT INTO `lifetek_kcs_history` VALUES ('733', '593', '213', '526', '9', '1', '1', '0', '', '2015-11-24 11:51:49', '47');
INSERT INTO `lifetek_kcs_history` VALUES ('734', '594', '214', '527', '14', '100', '100', '0', '', '2015-11-24 13:55:35', '48');
INSERT INTO `lifetek_kcs_history` VALUES ('735', '597', '216', '533', '13', '10', '10', '0', '', '2015-11-24 14:04:17', '49');
INSERT INTO `lifetek_kcs_history` VALUES ('736', '595', '216', '531', '13', '10', '10', '0', '', '2015-11-24 14:04:17', '49');
INSERT INTO `lifetek_kcs_history` VALUES ('737', '596', '216', '532', '13', '10', '10', '0', '', '2015-11-24 14:04:17', '49');
INSERT INTO `lifetek_kcs_history` VALUES ('738', '598', '217', '534', '9', '5', '5', '0', '', '2015-11-24 14:08:24', '50');
INSERT INTO `lifetek_kcs_history` VALUES ('739', '602', '215', '530', '6', '10', '10', '0', '', '2015-11-24 16:04:06', '51');
INSERT INTO `lifetek_kcs_history` VALUES ('740', '600', '215', '528', '6', '10', '10', '0', '', '2015-11-24 16:04:06', '51');
INSERT INTO `lifetek_kcs_history` VALUES ('741', '601', '215', '529', '6', '10', '10', '0', '', '2015-11-24 16:04:06', '51');
INSERT INTO `lifetek_kcs_history` VALUES ('742', '602', '215', '530', '6', '0', '0', '0', '', '2015-11-24 16:04:17', '52');
INSERT INTO `lifetek_kcs_history` VALUES ('743', '600', '215', '528', '6', '0', '0', '0', '', '2015-11-24 16:04:17', '52');
INSERT INTO `lifetek_kcs_history` VALUES ('744', '601', '215', '529', '6', '0', '0', '0', '', '2015-11-24 16:04:17', '52');
INSERT INTO `lifetek_kcs_history` VALUES ('745', '603', '218', '535', '22', '2', '2', '0', '', '2015-11-25 10:46:16', '53');
INSERT INTO `lifetek_kcs_history` VALUES ('746', '604', '218', '536', '22', '1', '1', '0', '', '2015-11-25 10:46:16', '53');
INSERT INTO `lifetek_kcs_history` VALUES ('747', '605', '218', '537', '22', '3', '3', '0', '', '2015-11-25 10:46:16', '53');
INSERT INTO `lifetek_kcs_history` VALUES ('748', '606', '220', '540', '16', '2', '2', '0', '', '2015-11-25 10:58:14', '54');
INSERT INTO `lifetek_kcs_history` VALUES ('749', '607', '220', '541', '16', '1', '1', '0', '', '2015-11-25 10:58:14', '54');
INSERT INTO `lifetek_kcs_history` VALUES ('750', '608', '220', '542', '16', '1', '1', '0', '', '2015-11-25 10:58:14', '54');
INSERT INTO `lifetek_kcs_history` VALUES ('751', '609', '221', '543', '16', '10', '10', '0', '', '2015-11-25 11:23:12', '55');
INSERT INTO `lifetek_kcs_history` VALUES ('752', '610', '222', '544', '16', '1', '1', '0', '', '2015-11-25 11:25:53', '56');
INSERT INTO `lifetek_kcs_history` VALUES ('753', '611', '223', '545', '5', '10', '5', '5', '', '2015-11-26 11:20:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('754', '613', '223', '546', '5', '10', '10', '0', '', '2015-11-26 11:20:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('755', '615', '223', '547', '5', '90', '40', '50', '', '2015-11-26 11:20:24', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('756', '611', '223', '545', '5', '5', '5', '0', '', '2015-11-28 11:48:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('757', '613', '223', '546', '5', '0', '0', '0', '', '2015-11-28 11:48:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('758', '615', '223', '547', '5', '50', '50', '0', '', '2015-11-28 11:48:26', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('759', '612', '223', '545', '9', '10', '10', '0', '', '2015-11-28 11:49:08', '57');
INSERT INTO `lifetek_kcs_history` VALUES ('760', '614', '223', '546', '9', '10', '10', '0', '', '2015-11-28 11:49:08', '57');
INSERT INTO `lifetek_kcs_history` VALUES ('761', '616', '223', '547', '9', '90', '90', '0', '', '2015-11-28 11:49:08', '57');
INSERT INTO `lifetek_kcs_history` VALUES ('762', '617', '224', '548', '5', '10', '10', '0', '', '2015-12-07 10:32:04', '58');
INSERT INTO `lifetek_kcs_history` VALUES ('763', '618', '225', '550', '9', '98', '98', '0', '', '2015-12-10 14:34:42', '59');
INSERT INTO `lifetek_kcs_history` VALUES ('764', '619', '226', '551', '9', '10', '10', '0', '', '2015-12-10 14:57:05', '60');
INSERT INTO `lifetek_kcs_history` VALUES ('765', '620', '227', '552', '9', '1', '1', '0', '', '2015-12-10 15:16:31', '61');
INSERT INTO `lifetek_kcs_history` VALUES ('766', '621', '228', '553', '20', '100', '100', '0', '', '2015-12-10 15:21:30', '62');
INSERT INTO `lifetek_kcs_history` VALUES ('767', '622', '229', '554', '9', '10', '10', '0', '', '2015-12-10 15:35:16', '63');
INSERT INTO `lifetek_kcs_history` VALUES ('768', '623', '230', '555', '9', '100', '100', '0', '', '2015-12-10 15:37:49', '64');
INSERT INTO `lifetek_kcs_history` VALUES ('769', '624', '231', '556', '9', '200', '200', '0', '', '2015-12-10 15:43:44', '65');
INSERT INTO `lifetek_kcs_history` VALUES ('770', '625', '232', '557', '15', '100', '100', '0', '', '2015-12-10 16:05:38', '66');
INSERT INTO `lifetek_kcs_history` VALUES ('771', '626', '233', '558', '15', '5', '5', '0', '', '2015-12-16 14:45:37', '67');
INSERT INTO `lifetek_kcs_history` VALUES ('772', '627', '234', '559', '14', '10', '10', '0', '', '2015-12-21 10:42:22', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('773', '629', '234', '560', '14', '10', '10', '0', '', '2015-12-21 10:42:22', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('774', '628', '234', '559', '16', '10', '10', '0', '', '2015-12-21 10:42:50', '68');
INSERT INTO `lifetek_kcs_history` VALUES ('775', '630', '234', '560', '16', '10', '10', '0', '', '2015-12-21 10:42:50', '68');
INSERT INTO `lifetek_kcs_history` VALUES ('776', '631', '236', '562', '21', '10', '10', '0', '', '2015-12-25 09:21:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('777', '633', '236', '563', '21', '10', '10', '0', '', '2015-12-25 09:21:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('778', '635', '236', '564', '21', '10', '10', '0', '', '2015-12-25 09:21:03', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('779', '632', '236', '562', '22', '10', '10', '0', '', '2015-12-25 09:21:30', '69');
INSERT INTO `lifetek_kcs_history` VALUES ('780', '634', '236', '563', '22', '10', '10', '0', '', '2015-12-25 09:21:30', '69');
INSERT INTO `lifetek_kcs_history` VALUES ('781', '636', '236', '564', '22', '10', '10', '0', '', '2015-12-25 09:21:30', '69');
INSERT INTO `lifetek_kcs_history` VALUES ('782', '643', '237', '565', '21', '10', '10', '0', '', '2015-12-25 09:37:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('783', '646', '237', '566', '21', '10', '10', '0', '', '2015-12-25 09:37:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('784', '649', '237', '567', '21', '10', '10', '0', '', '2015-12-25 09:37:59', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('785', '644', '237', '565', '22', '10', '10', '0', '', '2015-12-25 09:38:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('786', '647', '237', '566', '22', '10', '10', '0', '', '2015-12-25 09:38:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('787', '650', '237', '567', '22', '10', '10', '0', '', '2015-12-25 09:38:16', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('788', '645', '237', '565', '20', '10', '10', '0', '', '2015-12-25 09:38:26', '70');
INSERT INTO `lifetek_kcs_history` VALUES ('789', '648', '237', '566', '20', '10', '10', '0', '', '2015-12-25 09:38:26', '70');
INSERT INTO `lifetek_kcs_history` VALUES ('790', '651', '237', '567', '20', '10', '10', '0', '', '2015-12-25 09:38:26', '70');
INSERT INTO `lifetek_kcs_history` VALUES ('791', '661', '238', '568', '5', '10', '10', '0', '', '2015-12-25 09:59:28', '71');
INSERT INTO `lifetek_kcs_history` VALUES ('792', '662', '239', '569', '14', '10', '10', '0', '', '2015-12-25 10:32:39', '72');
INSERT INTO `lifetek_kcs_history` VALUES ('793', '663', '241', '571', '34', '2', '2', '0', '', '2016-01-06 15:20:34', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('794', '664', '241', '571', '35', '2', '2', '0', '', '2016-01-06 15:21:11', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('795', '665', '241', '571', '36', '2', '2', '0', '', '2016-01-06 15:22:58', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('796', '666', '241', '571', '37', '2', '2', '0', '', '2016-01-06 15:23:31', '73');
INSERT INTO `lifetek_kcs_history` VALUES ('797', '667', '242', '572', '14', '10', '10', '0', '', '2016-01-06 17:30:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('798', '670', '242', '573', '14', '1', '1', '0', '', '2016-01-06 17:30:32', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('799', '667', '242', '572', '14', '0', '0', '0', '', '2016-01-06 17:30:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('800', '670', '242', '573', '14', '0', '0', '0', '', '2016-01-06 17:30:52', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('801', '668', '242', '572', '15', '10', '10', '0', '', '2016-01-06 17:31:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('802', '671', '242', '573', '15', '1', '1', '0', '', '2016-01-06 17:31:42', '0');
INSERT INTO `lifetek_kcs_history` VALUES ('803', '669', '242', '572', '16', '10', '10', '0', '', '2016-01-06 17:32:18', '74');
INSERT INTO `lifetek_kcs_history` VALUES ('804', '672', '242', '573', '16', '1', '1', '0', '', '2016-01-06 17:32:18', '74');

-- ----------------------------
-- Table structure for lifetek_language
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_language`;
CREATE TABLE `lifetek_language` (
  `id_language` int(11) NOT NULL AUTO_INCREMENT,
  `name_language` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_language
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mail_auto
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mail_auto`;
CREATE TABLE `lifetek_mail_auto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL COMMENT 'mã khách hàng',
  `year` int(11) NOT NULL COMMENT 'năm gửi chúc mừng',
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='bảng mail tự động';

-- ----------------------------
-- Records of lifetek_mail_auto
-- ----------------------------
INSERT INTO `lifetek_mail_auto` VALUES ('1', '2090', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('2', '2091', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('3', '2097', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('4', '2099', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('5', '2102', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('6', '2104', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('7', '2105', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('8', '2106', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('9', '2107', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('10', '2208', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('11', '2209', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('12', '2212', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('13', '2216', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('14', '2221', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('15', '2242', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('16', '2244', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('17', '2245', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('18', '2246', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('19', '2250', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('20', '2252', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('21', '2258', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('22', '2259', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('23', '2260', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('24', '2261', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('25', '2265', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('26', '2266', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('27', '2277', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('28', '2289', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('29', '2290', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('30', '2299', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('31', '2300', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('32', '2301', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('33', '2302', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('34', '2303', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('35', '2306', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('36', '2307', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('37', '2310', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('38', '2247', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('39', '2318', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('40', '2322', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('41', '2324', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('42', '2328', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('43', '2330', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('44', '2333', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('45', '2339', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('46', '2341', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('47', '2342', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('48', '2345', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('49', '2346', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('50', '2347', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('51', '2348', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('52', '2350', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('53', '2095', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('54', '2355', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('55', '2356', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('56', '2362', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('57', '2366', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('58', '2367', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('59', '2368', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('60', '2249', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('61', '2369', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('62', '2370', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('63', '2371', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('64', '2372', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('65', '2373', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('66', '2378', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('67', '2379', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('68', '2389', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('69', '2393', '2015', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('70', '2401', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('71', '2402', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('72', '2403', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('73', '2404', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('74', '2405', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('75', '2405', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('76', '2406', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('77', '2406', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('78', '2407', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('79', '2408', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('80', '2410', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('81', '2411', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('82', '2414', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('83', '2414', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('84', '2415', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('85', '2416', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('86', '2417', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('87', '2421', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('88', '2422', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('89', '2424', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('90', '2425', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('91', '2426', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('92', '2427', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('93', '2429', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('94', '2430', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('95', '2431', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('96', '2431', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('97', '2432', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('98', '2433', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('99', '2434', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('100', '2435', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('101', '2436', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('102', '2440', '2015', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('103', '2113', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('104', '2114', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('105', '2115', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('106', '2116', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('107', '2117', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('108', '2118', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('109', '2119', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('110', '2120', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('111', '2121', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('112', '2122', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('113', '2123', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('114', '2124', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('115', '2125', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('116', '2126', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('117', '2127', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('118', '2128', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('119', '2129', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('120', '2130', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('121', '2131', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('122', '2132', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('123', '2133', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('124', '2134', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('125', '2135', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('126', '2136', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('127', '2137', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('128', '2138', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('129', '2139', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('130', '2140', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('131', '2141', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('132', '2142', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('133', '2143', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('134', '2144', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('135', '2145', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('136', '2146', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('137', '2147', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('138', '2148', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('139', '2149', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('140', '2150', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('141', '2151', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('142', '2152', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('143', '2153', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('144', '2154', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('145', '2155', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('146', '2156', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('147', '2157', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('148', '2158', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('149', '2159', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('150', '2160', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('151', '2161', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('152', '2162', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('153', '2163', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('154', '2163', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('155', '2164', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('156', '2164', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('157', '2165', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('158', '2165', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('159', '2166', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('160', '2166', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('161', '2167', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('162', '2167', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('163', '2168', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('164', '2168', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('165', '2169', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('166', '2169', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('167', '2170', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('168', '2170', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('169', '2171', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('170', '2171', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('171', '2172', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('172', '2172', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('173', '2173', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('174', '2173', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('175', '2174', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('176', '2174', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('177', '2175', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('178', '2175', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('179', '2176', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('180', '2177', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('181', '2178', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('182', '2179', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('183', '2180', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('184', '2181', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('185', '2182', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('186', '2183', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('187', '2184', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('188', '2185', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('189', '2186', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('190', '2187', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('191', '2188', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('192', '2189', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('193', '2190', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('194', '2191', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('195', '2192', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('196', '2193', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('197', '2194', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('198', '2195', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('199', '2196', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('200', '2196', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('201', '2197', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('202', '2197', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('203', '2253', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('204', '2253', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('205', '2254', '2016', '1');
INSERT INTO `lifetek_mail_auto` VALUES ('206', '2454', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('207', '2455', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('208', '2459', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('209', '2460', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('210', '2461', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('211', '2462', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('212', '2463', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('213', '2464', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('214', '2465', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('215', '2466', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('216', '2468', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('217', '2469', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('218', '2470', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('219', '2471', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('220', '2472', '2016', '0');
INSERT INTO `lifetek_mail_auto` VALUES ('221', '2475', '2016', '0');

-- ----------------------------
-- Table structure for lifetek_mail_history
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mail_history`;
CREATE TABLE `lifetek_mail_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL COMMENT 'mã khách hàng',
  `employee_id` int(11) NOT NULL COMMENT 'mã nhân viên',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: Chưa gửi ; 1: Đã gửi',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=414 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_mail_history
-- ----------------------------
INSERT INTO `lifetek_mail_history` VALUES ('1', '2090', '1', '', '', '2015-07-30 17:19:31', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('2', '2091', '1', '', '', '2015-07-30 17:19:36', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('3', '2097', '1', '', '', '2015-08-01 16:29:50', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('4', '2099', '1', '', '', '2015-08-03 14:30:19', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('5', '2102', '1', '', '', '2015-08-04 11:48:50', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('6', '2097', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-04 14:18:56', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('7', '2104', '1', '', '', '2015-08-05 10:29:06', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('8', '2105', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-07 09:43:23', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('9', '2106', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-07 13:43:28', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('10', '2107', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-07 13:44:17', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('11', '2097', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :thuhuong@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-10 10:14:07', '', 'BG_2042_VuMen_10082015101404.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('12', '2097', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :thuhuong@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-10 17:27:44', '', 'BG_2044_VuMen_10082015172742.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('13', '2097', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 08:47:10', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('14', '2197', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 08:47:50', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('15', '2194', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 11:06:41', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('16', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 11:15:09', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('17', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 11:23:22', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('18', '2209', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 11:23:28', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('19', '2193', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 11:53:22', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('20', '2209', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 08:58:18', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('21', '2104', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 08:58:52', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('22', '2104', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:02:14', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('23', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:17:28', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('24', '2209', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:19:06', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('25', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:20:58', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('26', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:21:54', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('27', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:37:55', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('28', '2209', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:38:00', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('29', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 16:03:05', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('30', '2208', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-12 16:09:29', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('31', '2209', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Thu Lan</p>\n', '2015-08-12 16:11:08', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('32', '2209', '1', 'Báo giá', '<p>Dear anh/chị:Nguyễn Thu Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :tuyendo1992@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-12 16:12:40', '', 'BG_2058_NguyenThuLan_12082015161237.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('33', '2209', '1', 'Báo giá', '<p>Dear anh/chị:Nguyễn Thu Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :tuyendo1992@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 08:38:40', '', 'BG_2058_NguyenThuLan_13082015083836.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('34', '2209', '1', 'Báo giá', '<p>Dear anh/chị:Nguyễn Thu Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 08:39:43', '', 'BG_2058_NguyenThuLan_13082015083938.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('35', '2208', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-13 08:40:27', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('36', '2208', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-13 09:01:38', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('37', '2208', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-13 10:18:02', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('38', '2097', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 10:24:20', '', 'BG_2042_VuMen_13082015102416.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('39', '2097', '1', 'Hợp đồng', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4bizqlsx.lifetek.vn/backend/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 10:24:41', '', 'HD_2040_VuMen_13082015102437.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('40', '2208', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-13 10:35:54', 'Gửi lại', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('41', '2212', '1', 'Báo giá', '<p>Dear anh/chị:Ngô Vũ Tiến Minh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 10:55:17', '', 'BG_2061_NgoVuTienMinh_13082015105513.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('42', '2212', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 10:56:30', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('43', '2212', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 10:57:20', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('44', '2212', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 10:57:48', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('45', '2212', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 12:09:04', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('46', '2099', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đỗ &nbsp;Tuyên</p>\n', '2015-08-13 15:07:51', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('47', '2212', '1', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng Ngô Vũ Tiến Minh một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Đội Cấn, Quận Ba Đình, HNquangsan90@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-08-13 16:14:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('48', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 16:19:07', '', 'BG_2066_MrsAn_13082015161903.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('49', '2099', '1', 'Báo giá', '<p>Dear anh/chị:Đỗ Tuyên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 16:21:59', '', 'BG_2067_DoTuyen_13082015162155.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('50', '2099', '1', 'Hợp đồng', '<p>Dear anh/chị:Đỗ Tuyên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4bizqlsx.lifetek.vn/backend/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 16:25:07', '', 'HD_1951_DoTuyen_13082015162503.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('51', '2095', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 09:49:20', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('52', '2095', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 10:20:34', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('53', '2208', '1', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng Vũ Đức Duy một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> 32 Hoàng Hoa Thámquangsan90@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-08-14 11:46:44', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('54', '2095', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 14:38:26', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('55', '2095', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 15:45:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('56', '2216', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;luu luu &nbsp;thanh thanh</p>\n', '2015-08-17 17:20:22', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('57', '2208', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-18 10:25:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('58', '2208', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Đức Duy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-20 14:22:19', '', 'BG_2097_VuDucDuy_20082015142214.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('59', '2221', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hoàng &nbsp;Tuấn</p>\n', '2015-08-21 14:44:24', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('60', '2242', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Bin</p>\n', '2015-08-28 10:14:37', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('61', '2208', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Thị Hiên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-28 16:55:41', '', 'BG_2138_VuThiHien_28082015165537.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('62', '2208', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Thị Hiên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-29 12:20:32', '', 'BG_2140_VuThiHien_29082015122027.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('63', '2208', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Thị Hiên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-29 12:20:54', '', 'BG_2140_VuThiHien_29082015122048.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('64', '2244', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đỗ Vũ &nbsp;Hà Vy</p>\n', '2015-09-07 12:04:55', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('65', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 10:21:49', '', 'BG_2162_MrsAn_08092015102144.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('66', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 10:22:22', '', 'BG_2162_MrsAn_08092015102218.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('67', '2244', '1', 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 10:24:48', '', 'BG_2163_DoVuHaVy_08092015102445.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('68', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 14:47:34', '', 'BG_2166_MrsAn_08092015144729.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('69', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 15:08:12', '', 'BG_2167_MrsAn_08092015150809.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('70', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:00:55', '', 'BG_2168_MrsAn_08092015160051.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('71', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:05:55', '', 'bangbaogia.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('72', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:08:27', '', 'bangbaogia.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('73', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:11:26', '', 'bangbaogia.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('74', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:12:10', '', 'BG_2168_MrsAn_08092015161207.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('75', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:12:28', '', 'BG_2168_MrsAn_08092015161224.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('76', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 16:17:39', '', 'BG_2168_MrsAn_08092015161735.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('77', '2245', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Tiến &nbsp;Minh</p>\n', '2015-09-11 15:03:12', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('78', '2246', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;sdfasd &nbsp;asdfasdf</p>\n', '2015-09-24 11:15:54', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('79', '2250', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;121212 &nbsp;12121212</p>\n', '2015-10-06 15:45:36', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('80', '2252', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Linh &nbsp;Bi</p>\n', '2015-10-06 16:58:10', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('81', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 16:51:40', '', 'BG_2243_12121212121212_15102015165138.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('82', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 16:52:42', '', 'BG_2243_12121212121212_15102015165239.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('83', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 16:53:29', '', 'BG_2243_12121212121212_15102015165327.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('84', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 16:54:01', '', 'BG_2243_12121212121212_15102015165359.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('85', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 16:57:58', '', 'BG_2243_12121212121212_15102015165755.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('86', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 21:42:52', '', 'BG_2243_12121212121212_15102015214248.xlsx', '0');
INSERT INTO `lifetek_mail_history` VALUES ('87', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 21:45:14', '', 'BG_2243_12121212121212_15102015214508.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('88', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 21:46:17', '', 'BG_2243_12121212121212_15102015214612.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('89', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 21:46:42', '', 'BG_2243_12121212121212_15102015214636.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('90', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 17:59:59', '', 'BG_2277_MrsAn_23102015175955.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('91', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 18:24:13', '', 'BG_2277_MrsAn_23102015182409.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('92', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 18:27:53', '', 'BG_2277_MrsAn_23102015182750.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('93', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 18:29:20', '', 'BG_2277_MrsAn_23102015182916.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('94', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 11:15:16', '', 'BG_2279_12121212121212_24102015111512.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('95', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 12:13:42', '', 'BG_2279_12121212121212_24102015121338.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('96', '2250', '1', 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 12:14:51', '', 'BG_2279_12121212121212_24102015121447.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('97', '2258', '1', 'Báo giá', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 12:30:26', '', 'BG_2280_TrinhThiLan_24102015123023.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('98', '2258', '1', 'Báo giá', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 13:14:52', '', 'BG_2280_TrinhThiLan_24102015131448.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('99', '2258', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trịnh Thị &nbsp;Lan</p>\n', '2015-10-24 14:07:36', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('100', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 15:07:09', '', 'BG_2279_VuVanSan_24102015150706.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('101', '2258', '1', 'Báo giá', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 15:13:40', '', 'BG_2280_TrinhThiLan_24102015151337.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('104', '2250', '1', 'Hợp đồng', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 09:58:44', '', 'HD_2279_VuVanSan_25102015095841.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('103', '2258', '1', 'Hợp đồng', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 15:31:12', '', 'HD_2281_TrinhThiLan_24102015153107.xlsx', '1');
INSERT INTO `lifetek_mail_history` VALUES ('105', '2250', '1', 'Hợp đồng', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:00:29', '', 'HD_2279_VuVanSan_25102015100026.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('106', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:38:51', '', 'BG_2279_VuVanSan_25102015103847.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('107', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:41:27', '', 'BG_2279_VuVanSan_25102015104123.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('108', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:42:24', '', 'BG_2279_VuVanSan_25102015104221.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('109', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:45:28', '', 'BG_2279_VuVanSan_25102015104525.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('110', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:58:03', '', 'BG_2279_VuVanSan_25102015105758.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('111', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:59:07', '', 'BG_2279_VuVanSan_25102015105903.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('112', '2250', '1', 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 10:59:50', '', 'BG_2279_VuVanSan_25102015105947.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('113', '2244', '1', 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 09:13:47', '', 'BG_2289_DoVuHaVy_26102015091343.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('114', '2259', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;! &nbsp;1111</p>\n', '2015-10-26 09:15:41', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('115', '2260', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;a &nbsp;a</p>\n', '2015-10-26 09:15:47', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('116', '2244', '1', 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 09:20:29', '', 'BG_2289_DoVuHaVy_26102015092026.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('117', '2244', '1', 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 09:20:52', '', 'BG_2289_DoVuHaVy_26102015092049.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('118', '2261', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;a &nbsp;a</p>\n', '2015-10-26 09:38:14', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('119', '2184', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-10-26 14:09:58', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('120', '2183', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-10-26 14:10:02', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('121', '2182', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-10-26 14:10:05', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('122', '2265', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;đỗ &nbsp;huệ</p>\n', '2015-10-26 16:49:56', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('123', '2266', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hue &nbsp;huệ</p>\n', '2015-10-26 16:59:51', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('124', '2183', '1', 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 22:19:13', '', 'HD_2275_MrsAn_26102015221909.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('125', '2260', '1', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng aadddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaassssssssss một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộiquangsan90@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-10-27 08:57:20', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('126', '2183', '1', 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 09:58:47', '', 'HD_2304_MrsAn_27102015095843.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('127', '2174', '1', 'Báo giá', '<p>Dear anh/chị:Nguyễn Hải Dương</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 10:10:24', '', 'BG_2283_NguyenHaiDuong_27102015101020.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('128', '2174', '1', 'Báo giá', '<p>Dear anh/chị:Nguyễn Hải Dương</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 10:11:26', '', 'BG_2283_NguyenHaiDuong_27102015101123.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('129', '2174', '1', 'Báo giá', '<p>Dear anh/chị:Nguyễn Hải Dương</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 10:46:48', '', 'BG_2283_NguyenHaiDuong_27102015104644.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('130', '2277', '1', 'Báo giá', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 10:57:33', '', 'BG_2307_dohue_27102015105729.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('131', '2277', '1', 'Báo giá', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 11:07:23', '', 'BG_2307_dohue_27102015110719.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('132', '2277', '1', 'Hợp đồng', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 11:15:23', '', 'HD_2309_dohue_27102015111519.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('133', '2277', '1', 'Báo giá', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 11:21:28', '', 'BG_2310_dohue_27102015112124.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('134', '2277', '1', 'Hợp đồng', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 11:23:17', '', 'HD_2309_dohue_27102015112314.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('135', '2277', '1', 'Hợp đồng', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 11:23:37', '', 'HD_2309_dohue_27102015112334.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('136', '2277', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;do &nbsp;hue</p>\n', '2015-10-27 11:51:52', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('137', '2289', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;đinh văn &nbsp;xinh</p>\n', '2015-11-11 11:48:36', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('138', '2290', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn hải &nbsp;yến</p>\n', '2015-11-11 11:48:41', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('139', '2290', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn hải &nbsp;yến</p>\n', '2015-11-11 12:10:08', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('140', '2299', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;minh &nbsp;nguyệt</p>\n', '2015-11-11 14:53:04', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('141', '2300', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ĐINH  VĂN &nbsp;MẠNH</p>\n', '2015-11-11 14:53:13', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('142', '2300', '1', 'Hợp đồng', '<p>Dear anh/chị:ĐINH  VĂN MẠNH</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-11 14:54:35', '', 'HD_2562_DINHVANMANH_11112015145431.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('143', '2301', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn công &nbsp;hoan</p>\n', '2015-11-11 16:12:49', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('144', '2302', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;đinh văn &nbsp;hạnh</p>\n', '2015-11-11 16:12:58', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('145', '2303', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;văn anh &nbsp;anh</p>\n', '2015-11-11 16:13:11', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('146', '2306', '1', 'Báo giá', '<p>Dear anh/chị:NGUYỄN VĂN BÌNH</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 11:07:48', '', 'BG_2576_NGUYENVANBINH_12112015110743.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('147', '2306', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;NGUYỄN VĂN &nbsp;BÌNH</p>\n', '2015-11-12 11:09:44', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('148', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 11:39:15', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('149', '2183', '1', 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 11:50:45', '', 'HD_2577_MrsAn_12112015115040.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('150', '2134', '1', 'Hợp đồng', '<p>Dear anh/chị:Trương Tuấn Anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 11:55:58', '', 'HD_2582_TruongTuanAnh_12112015115554.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('151', '2310', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyên &nbsp;định</p>\n', '2015-11-12 14:04:25', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('152', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 15:16:35', '', 'BG_2626_BuivanDung_12112015151630.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('153', '2307', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 15:30:57', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('154', '2247', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi văn &nbsp;Dũng</p>\n', '2015-11-12 15:50:54', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('155', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 15:57:26', '', 'BG_2631_MrsAn_12112015155721.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('156', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 15:59:03', '', 'BG_2631_MrsAn_12112015155900.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('157', '2183', '1', 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 16:00:18', '', 'HD_2631_MrsAn_12112015160015.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('158', '2306', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 16:31:23', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('159', '2306', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 16:42:16', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('160', '2307', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 16:46:51', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('161', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 16:52:30', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('162', '2307', '1', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng nguyễn thị định một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộihienvutk9@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-11-12 17:05:39', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('163', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 17:07:48', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('164', '2307', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 17:08:56', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('165', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 17:10:59', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('166', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 17:11:52', '', 'BG_2631_MrsAn_12112015171149.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('167', '2318', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hoàng &nbsp;minh</p>\n', '2015-11-13 09:25:22', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('168', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:26:19', '', 'BG_2631_MrsAn_13112015092614.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('169', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:26:40', '', 'BG_2631_MrsAn_13112015092634.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('170', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:37:36', '', 'BG_2631_MrsAn_13112015093730.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('171', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:45:26', '', 'BG_2631_MrsAn_13112015094520.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('172', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:55:55', '', 'BG_2631_MrsAn_13112015095547.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('173', '2124', '1', 'Báo giá', '<p>Dear anh/chị:Phùng Đức Hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:57:12', '', 'BG_2627_PhungDucHanh_13112015095705.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('174', '2306', '1', 'Báo giá', '<p>Dear anh/chị:NGUYỄN VĂN BÌNH</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 09:59:12', '', 'BG_2576_NGUYENVANBINH_13112015095906.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('175', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:02:32', '', 'BG_2626_BuivanDung_13112015100226.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('176', '2124', '1', 'Báo giá', '<p>Dear anh/chị:Phùng Đức Hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:03:35', '', 'BG_2627_PhungDucHanh_13112015100329.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('177', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:04:40', '', 'BG_2602_MrsAn_13112015100434.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('178', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:05:20', '', 'BG_2434_MrsAn_13112015100513.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('179', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:06:13', '', 'BG_2631_MrsAn_13112015100606.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('180', '2124', '1', 'Báo giá', '<p>Dear anh/chị:Phùng Đức Hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:06:55', '', 'BG_2627_PhungDucHanh_13112015100648.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('181', '2318', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hoàng &nbsp;minh</p>\n', '2015-11-13 10:07:43', 'Gửi lại', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('182', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:09:08', '', 'BG_2638_BuivanDung_13112015100901.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('183', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:10:39', '', 'BG_2638_BuivanDung_13112015101032.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('184', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:12:44', '', 'BG_2638_BuivanDung_13112015101236.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('185', '2306', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-13 10:37:51', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('186', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :hienvutk9@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:42:19', '', 'BG_2638_BuivanDung_13112015104214.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('187', '2247', '1', 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 10:43:27', '', 'BG_2638_BuivanDung_13112015104321.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('188', '2318', '1', 'CHÚC MỪNG SINH NHẬT CÔNG TY 15 NĂM ', '<p>ch&uacute;c mừng sinh nhật c&ocirc;ng ty tr&ograve;n 15 tuổi .ch&uacute;c c&ocirc;ng ty l&agrave;m nhiều c&oacute; nhiều thắng lợi</p>\n', '2015-11-13 11:25:21', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('189', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-13 11:51:15', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('190', '2322', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vu thi &nbsp;ly</p>\n', '2015-11-13 15:54:04', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('191', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :hienvutk9@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-14 08:28:46', '', 'BG_2639_MrsAn_14112015082842.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('192', '2318', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 08:33:06', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('193', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :hienvutk9@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-14 08:34:06', '', 'BG_2639_MrsAn_14112015083403.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('194', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-14 11:45:31', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('195', '2277', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 11:46:00', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('196', '2307', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 11:47:43', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('197', '2318', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 11:57:23', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('198', '2300', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ĐINH  VĂN &nbsp;MẠNH</p>\n', '2015-11-15 19:44:48', '', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('199', '2290', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-15 19:45:32', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('200', '2324', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Khách hàng &nbsp;mới</p>\n', '2015-11-16 14:39:34', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('201', '2328', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hà Hải &nbsp;Bình</p>\n', '2015-11-17 14:11:16', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('202', '2330', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đinh Thị &nbsp;Hạnh</p>\n', '2015-11-18 14:27:50', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('203', '2247', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-18 15:24:47', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('204', '2307', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-18 15:25:51', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('205', '2247', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-18 15:25:55', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('206', '2307', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-18 15:26:52', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('207', '2330', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đinh Thị &nbsp;Hạnh</p>\n', '2015-11-18 15:30:43', 'Gửi lại', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('208', '2183', '1', 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-19 10:34:37', '', 'HD_2654_MrsAn_19112015103432.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('209', '2130', '1', 'Hợp đồng', '<p>Dear anh/chị:Mrs Hằng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-20 09:24:05', '', 'HD_2567_MrsHang_20112015092401.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('210', '2302', '1', 'Hợp đồng', '<p>Dear anh/chị:đinh văn hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-20 09:28:48', '', 'HD_2564_dinhvanhanh_20112015092846.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('211', '2333', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đinh Mạnh &nbsp;Sơn</p>\n', '2015-11-20 11:37:11', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('212', '2339', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Dũng</p>\n', '2015-11-20 15:47:08', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('213', '2341', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huệ &nbsp;Đỗ</p>\n', '2015-11-26 11:50:14', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('214', '2342', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;hung</p>\n', '2015-11-27 13:50:30', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('215', '2252', '1', 'Báo giá', '<p>Dear anh/chị:Linh Bi</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-30 11:54:56', '', 'BG_2686_LinhBi_30112015115451.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('216', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-30 11:56:41', '', 'BG_2315_MrsAn_30112015115637.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('217', '2345', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vuong &nbsp;Duy</p>\n', '2015-12-07 11:54:59', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('218', '2245', '1', 'Hợp đồng', '<p>Dear anh/chị:Tiến Minh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4bizkdtm.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-07 13:38:37', '', 'HD_2226_TienMinh_07122015133834.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('219', '2346', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;tran &nbsp;anh</p>\n', '2015-12-08 09:07:25', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('220', '2347', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vuong &nbsp;duy</p>\n', '2015-12-08 09:16:50', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('221', '2348', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;abc &nbsp;abc</p>\n', '2015-12-08 09:28:56', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('222', '2341', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-08 15:36:52', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('223', '2350', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vuong &nbsp;Duy</p>\n', '2015-12-09 08:57:51', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('224', '2095', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đỗ &nbsp;Hà Vy</p>\n', '2015-12-11 08:48:30', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('225', '2341', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huệ &nbsp;Đỗ</p>\n', '2015-12-14 16:04:05', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('226', '2341', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huệ &nbsp;Đỗ</p>\n', '2015-12-14 16:04:35', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('227', '2134', '1', 'Báo giá', '<p>Dear anh/chị:Trương Tuấn Anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-14 16:05:39', '', 'BG_2704_TruongTuanAnh_14122015160534.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('228', '2355', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Thành Nam</p>\n', '2015-12-15 09:27:48', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('229', '2356', '1', 'Hợp đồng', '<p>Dear anh/chị:Vũ Hải Yến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 10:14:14', '', 'HD_2733_VuHaiYen_15122015101409.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('230', '2356', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Hải &nbsp;Yến</p>\n', '2015-12-15 10:14:30', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('231', '2346', '1', 'Hợp đồng', '<p>Dear anh/chị:tran anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 10:25:18', '', 'HD_2737_trananh_15122015102515.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('232', '2346', '1', 'Hợp đồng', '<p>Dear anh/chị:tran anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 10:25:48', '', 'HD_2737_trananh_15122015102545.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('233', '2134', '1', 'Hợp đồng', '<p>Dear anh/chị:Trương Tuấn Anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 10:25:58', '', 'HD_2712_TruongTuanAnh_15122015102553.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('234', '2362', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Lâm &nbsp;Thanh Phong</p>\n', '2015-12-15 11:55:24', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('235', '2366', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huyền &nbsp;Thanh</p>\n', '2015-12-15 13:27:38', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('236', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 14:13:18', '', 'BG_2744_MrsAn_15122015141312.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('237', '2183', '1', 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 14:14:11', '', 'BG_2758_MrsAn_15122015141406.doc', '1');
INSERT INTO `lifetek_mail_history` VALUES ('238', '2367', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;do &nbsp;lan</p>\n', '2015-12-15 15:09:22', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('239', '2368', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Khổng &nbsp;Tử</p>\n', '2015-12-15 16:38:37', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('240', '2249', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Hiền</p>\n', '2015-12-16 08:42:48', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('241', '2369', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Tuấn &nbsp;Du</p>\n', '2015-12-16 09:01:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('242', '2370', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Kim &nbsp;Tuấn</p>\n', '2015-12-16 09:24:18', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('243', '2371', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ha &nbsp;Ha</p>\n', '2015-12-16 09:24:20', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('244', '2372', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ANH &nbsp;A</p>\n', '2015-12-16 10:22:34', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('245', '2373', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;dj &nbsp;TOM</p>\n', '2015-12-16 10:34:58', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('246', '2369', '1', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng Tuấn Du một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộidungchip88@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-12-16 11:58:42', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('247', '2378', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;jk &nbsp;hung</p>\n', '2015-12-17 08:35:10', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('248', '2379', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;B</p>\n', '2015-12-17 13:41:23', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('249', '2370', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-19 10:24:58', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('250', '2389', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hj &nbsp;ha</p>\n', '2015-12-21 09:16:02', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('251', '2389', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-21 13:48:16', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('252', '2370', '1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-21 13:51:25', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('253', '2389', '1', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng hj ha một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộidungchip88@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-12-21 13:52:43', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('254', '2389', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hj &nbsp;ha</p>\n', '2015-12-21 14:10:07', 'Gửi lại', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('255', '2393', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh Long &nbsp;Châu</p>\n', '2015-12-21 16:26:23', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('256', '2401', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hoàng &nbsp;Hải</p>\n', '2015-12-22 12:01:15', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('257', '2402', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hải &nbsp;Đăng</p>\n', '2015-12-22 13:47:38', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('258', '2403', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh &nbsp;Hà</p>\n', '2015-12-22 13:47:46', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('259', '2404', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Thanh</p>\n', '2015-12-22 14:02:49', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('260', '2405', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh &nbsp;Thanh</p>\n', '2015-12-22 14:52:28', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('261', '2405', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh &nbsp;Thanh</p>\n', '2015-12-22 14:52:30', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('262', '2406', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Lan</p>\n', '2015-12-22 14:52:32', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('263', '2406', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Lan</p>\n', '2015-12-22 14:52:33', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('264', '2407', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;Hiên</p>\n', '2015-12-22 14:52:49', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('265', '2408', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Min</p>\n', '2015-12-22 14:53:08', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('266', '2410', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thùy &nbsp;Lâm</p>\n', '2015-12-23 09:13:31', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('267', '2411', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;iv &nbsp;anh</p>\n', '2015-12-23 09:15:52', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('268', '2414', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vân quân &nbsp;h</p>\n', '2015-12-23 12:01:58', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('269', '2414', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vân quân &nbsp;h</p>\n', '2015-12-23 12:01:59', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('270', '2415', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;mị &nbsp;mị</p>\n', '2015-12-23 15:59:11', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('271', '2416', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;xxxx &nbsp;xxxxxxxxxxxx</p>\n', '2015-12-23 15:59:19', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('272', '2417', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ha &nbsp;lan</p>\n', '2015-12-23 18:43:08', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('273', '2421', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;LY LY &nbsp;A</p>\n', '2015-12-24 11:23:02', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('274', '2422', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;life &nbsp;store</p>\n', '2015-12-24 11:23:09', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('275', '2421', '1', 'Hợp đồng', '<p>Dear anh/chị:LY LY A</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-25 08:56:53', '', 'HD_3175_LYLYA_25122015085649.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('276', '2424', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Nam</p>\n', '2015-12-25 11:41:39', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('277', '2425', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;xxxxxxx &nbsp;xxx</p>\n', '2015-12-25 11:49:13', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('278', '2426', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;view &nbsp;Sys</p>\n', '2015-12-25 12:14:33', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('279', '2427', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hue &nbsp;hue</p>\n', '2015-12-25 13:39:19', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('280', '2429', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Chị &nbsp;Anh</p>\n', '2015-12-28 10:30:56', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('281', '2430', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn &nbsp;duyên</p>\n', '2015-12-28 14:04:29', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('282', '2431', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngọc Ngọc &nbsp;Mai</p>\n', '2015-12-28 15:16:10', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('283', '2431', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngọc Ngọc &nbsp;Mai</p>\n', '2015-12-28 15:16:11', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('284', '2432', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vu &nbsp;Ly</p>\n', '2015-12-28 16:12:45', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('285', '2433', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hoàng Nhan &nbsp;Cô nương</p>\n', '2015-12-28 16:12:57', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('286', '2434', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Lý</p>\n', '2015-12-28 16:13:12', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('287', '2435', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vu &nbsp;Vu</p>\n', '2015-12-28 16:13:28', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('288', '2436', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Nết</p>\n', '2015-12-28 16:13:47', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('289', '2440', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thép &nbsp;Thép</p>\n', '2015-12-31 09:54:49', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('290', '2113', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Oanh</p>\n', '2016-01-01 15:05:01', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('291', '2114', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thanh &nbsp;Bình</p>\n', '2016-01-01 15:05:04', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('292', '2115', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Oanh</p>\n', '2016-01-01 15:05:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('293', '2116', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Đại</p>\n', '2016-01-01 15:05:13', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('294', '2117', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:05:17', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('295', '2118', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Ngọc</p>\n', '2016-01-01 15:05:21', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('296', '2119', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị Thanh &nbsp;Hồng</p>\n', '2016-01-01 15:05:25', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('297', '2120', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Chính</p>\n', '2016-01-01 15:05:29', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('298', '2121', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hiền</p>\n', '2016-01-01 15:05:33', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('299', '2122', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Nga</p>\n', '2016-01-01 15:05:37', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('300', '2123', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Khoa</p>\n', '2016-01-01 15:05:42', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('301', '2124', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Phùng Đức &nbsp;Hạnh</p>\n', '2016-01-01 15:05:47', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('302', '2125', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Dương</p>\n', '2016-01-01 15:05:51', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('303', '2126', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Thái</p>\n', '2016-01-01 15:05:55', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('304', '2127', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Nhung</p>\n', '2016-01-01 15:06:03', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('305', '2128', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Phạm Việt &nbsp;Hùng</p>\n', '2016-01-01 15:06:07', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('306', '2129', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Lâm</p>\n', '2016-01-01 15:06:11', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('307', '2130', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hằng</p>\n', '2016-01-01 15:06:15', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('308', '2131', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Nguyệt</p>\n', '2016-01-01 15:06:19', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('309', '2132', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đặng Đình &nbsp;Tâm</p>\n', '2016-01-01 15:06:23', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('310', '2133', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Vinh</p>\n', '2016-01-01 15:06:28', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('311', '2134', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trương Tuấn &nbsp;Anh</p>\n', '2016-01-01 15:06:32', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('312', '2135', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Thu &nbsp;Phương</p>\n', '2016-01-01 15:06:38', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('313', '2136', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Minh &nbsp;Hiếu</p>\n', '2016-01-01 15:06:41', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('314', '2137', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Thanh &nbsp;Xuân</p>\n', '2016-01-01 15:06:45', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('315', '2138', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Trang</p>\n', '2016-01-01 15:06:49', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('316', '2139', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trần Tử &nbsp;Bình </p>\n', '2016-01-01 15:06:54', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('317', '2140', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thế Thị &nbsp;Mỹ</p>\n', '2016-01-01 15:06:58', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('318', '2141', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hồng</p>\n', '2016-01-01 15:07:01', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('319', '2142', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trần Thị  &nbsp;Ngoan</p>\n', '2016-01-01 15:07:05', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('320', '2143', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Oanh</p>\n', '2016-01-01 15:07:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('321', '2144', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hà</p>\n', '2016-01-01 15:07:13', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('322', '2145', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Mai &nbsp;Hồng</p>\n', '2016-01-01 15:07:16', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('323', '2146', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hoàng</p>\n', '2016-01-01 15:07:21', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('324', '2147', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2016-01-01 15:08:33', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('325', '2148', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Kiều</p>\n', '2016-01-01 15:08:35', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('326', '2149', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Chung</p>\n', '2016-01-01 15:08:42', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('327', '2150', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Quang &nbsp;Tuấn</p>\n', '2016-01-01 15:08:45', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('328', '2151', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trần &nbsp;Lâm</p>\n', '2016-01-01 15:08:49', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('329', '2152', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn thị &nbsp;Thuận</p>\n', '2016-01-01 15:08:53', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('330', '2153', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Bảo &nbsp;Oanh</p>\n', '2016-01-01 15:08:57', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('331', '2154', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Duy</p>\n', '2016-01-01 15:09:01', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('332', '2155', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Ban</p>\n', '2016-01-01 15:09:04', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('333', '2156', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hương</p>\n', '2016-01-01 15:09:08', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('334', '2157', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Xuân &nbsp;Khiêm</p>\n', '2016-01-01 15:09:12', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('335', '2158', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hoài</p>\n', '2016-01-01 15:09:14', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('336', '2159', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Dũng</p>\n', '2016-01-01 15:09:22', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('337', '2160', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Nga</p>\n', '2016-01-01 15:09:33', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('338', '2161', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Lâm</p>\n', '2016-01-01 15:09:37', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('339', '2162', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Lợi</p>\n', '2016-01-01 15:09:41', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('340', '2163', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:09:45', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('341', '2163', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:09:48', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('342', '2164', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hằng</p>\n', '2016-01-01 15:09:49', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('343', '2164', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hằng</p>\n', '2016-01-01 15:09:52', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('344', '2165', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:09:54', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('345', '2165', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:09:56', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('346', '2166', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hữu &nbsp;Yên</p>\n', '2016-01-01 15:09:58', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('347', '2166', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hữu &nbsp;Yên</p>\n', '2016-01-01 15:10:00', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('348', '2167', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr  &nbsp;Hào</p>\n', '2016-01-01 15:10:03', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('349', '2167', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr  &nbsp;Hào</p>\n', '2016-01-01 15:10:04', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('350', '2168', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Đức &nbsp;Cần</p>\n', '2016-01-01 15:10:07', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('351', '2168', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Đức &nbsp;Cần</p>\n', '2016-01-01 15:10:09', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('352', '2169', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Trung</p>\n', '2016-01-01 15:10:12', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('353', '2169', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Trung</p>\n', '2016-01-01 15:10:13', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('354', '2170', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hải</p>\n', '2016-01-01 15:10:15', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('355', '2170', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hải</p>\n', '2016-01-01 15:10:18', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('356', '2171', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Viết &nbsp;Đại</p>\n', '2016-01-01 15:10:19', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('357', '2171', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Viết &nbsp;Đại</p>\n', '2016-01-01 15:10:22', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('358', '2172', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Anh</p>\n', '2016-01-01 15:10:24', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('359', '2172', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Anh</p>\n', '2016-01-01 15:10:26', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('360', '2173', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Hải</p>\n', '2016-01-01 15:10:27', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('361', '2173', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Hải</p>\n', '2016-01-01 15:10:30', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('362', '2174', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hải &nbsp;Dương</p>\n', '2016-01-01 15:10:32', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('363', '2174', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hải &nbsp;Dương</p>\n', '2016-01-01 15:10:34', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('364', '2175', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đặng Đình &nbsp;Tâm</p>\n', '2016-01-01 15:10:34', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('365', '2175', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đặng Đình &nbsp;Tâm</p>\n', '2016-01-01 15:10:37', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('366', '2176', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Khăc &nbsp;Hiếu</p>\n', '2016-01-01 15:10:50', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('367', '2177', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Chí &nbsp;Phú</p>\n', '2016-01-01 15:10:54', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('368', '2178', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Thùy</p>\n', '2016-01-01 15:10:58', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('369', '2179', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đoàn Quang &nbsp;Tiến</p>\n', '2016-01-01 15:11:02', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('370', '2180', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuân</p>\n', '2016-01-01 15:11:06', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('371', '2181', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Quang &nbsp;Hùng</p>\n', '2016-01-01 15:11:11', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('372', '2182', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hà</p>\n', '2016-01-01 15:11:15', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('373', '2183', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;An</p>\n', '2016-01-01 15:11:19', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('374', '2184', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hương</p>\n', '2016-01-01 15:11:23', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('375', '2185', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Quyết</p>\n', '2016-01-01 15:11:26', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('376', '2186', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Chỉnh</p>\n', '2016-01-01 15:11:43', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('377', '2187', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Cường</p>\n', '2016-01-01 15:11:46', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('378', '2188', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Giang</p>\n', '2016-01-01 15:11:50', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('379', '2189', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hồng</p>\n', '2016-01-01 15:11:54', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('380', '2190', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Lụa</p>\n', '2016-01-01 15:11:59', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('381', '2191', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Linh</p>\n', '2016-01-01 15:12:01', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('382', '2192', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hiếu</p>\n', '2016-01-01 15:12:20', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('383', '2193', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Hữu &nbsp;Âu</p>\n', '2016-01-01 15:12:25', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('384', '2194', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thái Thu &nbsp;Huyền</p>\n', '2016-01-01 15:12:29', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('385', '2195', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Bến </p>\n', '2016-01-01 15:12:33', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('386', '2196', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Thiện</p>\n', '2016-01-01 15:12:37', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('387', '2196', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Thiện</p>\n', '2016-01-01 15:12:38', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('388', '2197', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:12:42', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('389', '2197', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 15:12:43', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('390', '2253', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị &nbsp;Hường</p>\n', '2016-01-01 15:12:44', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('391', '2253', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị &nbsp;Hường</p>\n', '2016-01-01 15:12:45', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('392', '2254', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị &nbsp;Phương Thảo</p>\n', '2016-01-01 15:13:07', '', '', '1');
INSERT INTO `lifetek_mail_history` VALUES ('393', '2454', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nhan &nbsp;duc</p>\n', '2016-01-04 11:58:46', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('394', '2455', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;5</p>\n', '2016-01-04 11:58:52', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('395', '2459', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Sắt</p>\n', '2016-01-04 15:06:21', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('396', '2460', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Cụ &nbsp;Vít</p>\n', '2016-01-05 11:32:51', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('397', '2461', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nhan &nbsp;duc</p>\n', '2016-01-05 13:52:36', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('398', '2462', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hoa &nbsp;thuan</p>\n', '2016-01-05 13:52:44', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('399', '2463', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;chung &nbsp;thanh</p>\n', '2016-01-05 17:40:22', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('400', '2464', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;1</p>\n', '2016-01-05 17:40:34', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('401', '2465', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;2</p>\n', '2016-01-06 09:00:27', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('402', '2463', '1', 'Hợp đồng', '<p>Dear anh/chị:chung thanh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 11:06:27', '', 'HD_3273_chungthanh_06012016110625.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('403', '2460', '1', 'Hợp đồng', '<p>Dear anh/chị:Cụ Vít</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 11:20:00', '', 'HD_3275_CuVit_06012016111957.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('404', '2463', '1', 'Hợp đồng', '<p>Dear anh/chị:chung thanh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 11:20:15', '', 'HD_3273_chungthanh_06012016112013.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('405', '2464', '1', 'Hợp đồng', '<p>Dear anh/chị:Hiên 1</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 11:34:37', '', 'HD_3266_Hien1_06012016113434.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('406', '2463', '1', 'Hợp đồng', '<p>Dear anh/chị:chung thanh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=\'http://4biz.lifetek.vn/images/logoreport/11.png\'><p style=\'text-transform: uppercase;\'>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 11:34:37', '', 'HD_3273_chungthanh_06012016113434.doc', '0');
INSERT INTO `lifetek_mail_history` VALUES ('407', '2466', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;binh &nbsp;binh</p>\n', '2016-01-06 13:58:31', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('408', '2468', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;6</p>\n', '2016-01-06 14:08:30', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('409', '2469', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;anh &nbsp;Anh</p>\n', '2016-01-06 14:08:40', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('410', '2470', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Xuân &nbsp;Dần</p>\n', '2016-01-06 15:25:52', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('411', '2471', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;xuan &nbsp;thu</p>\n', '2016-01-06 15:26:07', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('412', '2472', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Thị &nbsp;Mơ</p>\n', '2016-01-06 15:26:25', 'Gửi lại', '', '0');
INSERT INTO `lifetek_mail_history` VALUES ('413', '2475', '1', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Dũng</p>\n', '2016-01-07 10:22:06', 'Gửi lại', '', '0');

-- ----------------------------
-- Table structure for lifetek_mail_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mail_template`;
CREATE TABLE `lifetek_mail_template` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mail_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mail_template
-- ----------------------------
INSERT INTO `lifetek_mail_template` VALUES ('1', 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '0');
INSERT INTO `lifetek_mail_template` VALUES ('2', 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;__FIRST_NAME__ &nbsp;__LAST_NAME__</p>\n', '0');
INSERT INTO `lifetek_mail_template` VALUES ('3', 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng __FIRST_NAME__ __LAST_NAME__ một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;__FIRST_NAME_EMPLOYEE__ __FIRST_NAME_EMPLOYEE__&nbsp; nh&acirc;n vi&ecirc;n&nbsp;__NAME_COMPANY__ __ADDRESS_COMPANY____EMAIL_COMPANY__ __FAX_COMPANY__ __WEBSITE_COMPANY__</p>\n', '0');
INSERT INTO `lifetek_mail_template` VALUES ('4', 'ghfggfhf hgfhgf', '<p>Cộng haofdgs ds gdgd fh</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('5', 'CHÚC MỪNG SINH NHẬT CÔNG TY 15 NĂM ', '<p>ch&uacute;c mừng sinh nhật c&ocirc;ng ty tr&ograve;n 15 tuổi .ch&uacute;c c&ocirc;ng ty l&agrave;m nhiều c&oacute; nhiều thắng lợi</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('6', 'Chúc mừng', '<p>Ch&uacute;c mừng kh&aacute;ch h&agrave;ng đ&atilde; tr&uacute;ng thưởng&nbsp;__FIRST_NAME__&nbsp;__LAST_NAME__ đ&atilde; tr&uacute;ng tuyển 01 chiếc điện thoại &nbsp;di động nokia 1601</p>\n\n<p>T&ecirc;n t&ocirc;i l&agrave; :&nbsp;FIRST_NAME_EMPLOYEE__&nbsp;LAST_NAME_EMPLOYEE__&nbsp;__PHONE_NUMBER_EMPLOYEE_&nbsp;</p>\n\n<p>C&ocirc;ng ty:&nbsp;__NAME_COMPANY__&nbsp;__ADDRESS_COMPANY__&nbsp;__WEBSITE_COMPANY__ k&iacute;nh mời Anh/Chị đến nhận phần thưởng tại ....</p>\n\n<p>tr&acirc;n trọng k&iacute;nh b&aacute;o!</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('7', 'a', '<p>a</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('8', 'a', '<p>&acirc;</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('9', 'a', '<p>a</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('10', 's', '<p>s</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('11', 's', '<p>s</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('12', 'j', '<p>jk</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('13', 'ngsjknsg', '<p>kdsgfmkdfg</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('14', 'hgf', '<p>gfhgfhgfgfhfgh</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('15', 'ygkjyuk', '<p>hkhjkh</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('16', 'ygkghkh', '<p>jkhkj</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('17', 'h', '<p>h</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('18', 'ad', '<p>ass</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('19', 'cccccccccccccccc', '<p>faafafafaafafafa</p>\n', '1');
INSERT INTO `lifetek_mail_template` VALUES ('20', 'asss', '<p>s</p>\n', '1');

-- ----------------------------
-- Table structure for lifetek_maloai_hopdong
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_maloai_hopdong`;
CREATE TABLE `lifetek_maloai_hopdong` (
  `id_ma_hopdong` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `ten_maloai_hopdong` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mota_loaihopdong` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_ma_hopdong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_maloai_hopdong
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_message
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_message`;
CREATE TABLE `lifetek_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cus` int(11) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `content_message` text NOT NULL,
  `equals` int(11) NOT NULL,
  `msgid` int(11) NOT NULL,
  `date_send` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_message
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_method_cost
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_method_cost`;
CREATE TABLE `lifetek_method_cost` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  ` name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_method_cost
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_modules
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_modules`;
CREATE TABLE `lifetek_modules` (
  `name_lang_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc_lang_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active_home` int(1) NOT NULL DEFAULT '0',
  `active_header` int(1) NOT NULL DEFAULT '0',
  `active_category` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_modules
-- ----------------------------
INSERT INTO `lifetek_modules` VALUES ('module_abouts', 'module_abouts_desc', '210', 'abouts', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_account_plan', 'module_account_plan_desc', '800', 'account_plan', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_account_type', 'module_account_type_desc', '225', 'account_type', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_accountings', 'module_accountings_desc', '10', 'accountings', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_admin_agent', 'module_admin_agent_desc', '2363', 'admin_agent', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_affiliates', 'module_affiliates_desc', '30', 'affiliates', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_assets', 'module_assets_desc', '100', 'assets', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_bangcap', 'module_bangcap_desc', '210', 'bangcap', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_bill_cost', 'module_bill_cost_desc', '266', 'bill_cost', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_categories', 'module_categories_desc', '70', 'categories', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_category_processes', 'module_category_processes_desc', '16', 'category_processes', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_chungtus', 'module_chungtus_desc', '120', 'chungtus', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_cities', 'module_cities_desc', '140', 'cities', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_city_desc', 'module_city', '227', 'city', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_citys', 'module_citys_desc', '228', 'citys', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_congcus', 'module_congcus_desc', '110', 'congcus', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_contact_admin', 'module_contact_admin_desc', '567', 'contact_admin', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_contractcustomer', 'module_contractcustomer_desc', '110', 'contractcustomer', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_contractcustomer_type', 'module_contractcustomer_type_desc', '110', 'contractcustomer_type', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_contracts', 'module_contracts_desc', '226', 'contracts', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_costs', 'module_costs_desc', '115', 'costs', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_create_invetorys', 'module_create_invetorys_desc', '201', 'create_invetorys', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_currencys', 'module_currencys_desc', '111', 'currencys', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_customer_type', 'module_customer_type_desc', '180', 'customer_type', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_customers', 'module_customers_desc', '2', 'customers', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_department_desc', 'module_department', '20', 'department', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_dttcs', 'module_dttcs_desc', '216', 'dttcs', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_education', 'module_education_desc', '210', 'education', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_employees', 'module_employees_desc', '6', 'employees', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_file', 'module_file_desc', '229', 'file', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_giftcards', 'module_giftcards_desc', '130', 'giftcards', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_hrm', 'module_hrm_desc', '160', 'hrm', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_imports', 'module_imports_desc', '14', 'imports', '0', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_introductions', 'module_introductions_desc', '555', 'introductions', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_item_kits', 'module_item_kits_desc', '302', 'item_kits', '0', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_item2s', 'module_item2s_desc', '201', 'item2s', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_item4s', 'module_item4s_desc', '100', 'item4s', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_items', 'module_items_desc', '5', 'items', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_jobs', 'module_jobs_desc', '7', 'jobs', '0', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_jobs_employee', 'module_jobs_employee_desc', '180', 'jobs_employee', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_jobs_project', 'module_jobs_project_desc', '180', 'jobs_project', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_jobs_report', 'module_jobs_report_desc', '180', 'jobs_report', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_kh', 'module_kh_desc', '100', 'kh', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_language', 'module_language_desc', '50', 'language', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_news', 'module_news_desc', '888', 'news', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_packs', 'module_packs_desc', '88', 'packs', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_positions_desc', 'module_positions', '40', 'positions', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_profit', 'module_profit_desc', '9', 'profit', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_profit1111', 'module_profit1111_desc', '170', 'profix', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_quotes_contract', 'module_quotes_contract_desc', '11', 'quotes_contract', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_receivings', 'module_receivings_desc', '4', 'receivings', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_regions', 'module_regions_desc', '11', 'regions', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_reports', 'module_reports_desc', '11', 'reports', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_resellers', 'module_resellers_desc', '333', 'resellers', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_salaryconfig', 'module_salaryconfig_desc', '110', 'salaryconfig', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_salaryoption', 'module_salaryoption_desc', '110', 'salaryoption', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_sales', 'module_sales_desc', '1', 'sales', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_salestraining', 'module_salestraining_desc', '1', 'salestraining', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_services', 'module_services_desc', '6', 'services', '0', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_setting', 'module_setting_desc', '12', 'setting', '0', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_shop_guide', 'module_shop_guide_desc', '2244', 'shop_guide', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_slider', 'module_slider_desc', '110', 'slider', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_solutions', 'module_solutions_desc', '444', 'solutions', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_suppliers', 'module_suppliers_desc', '3', 'suppliers', '0', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_support', 'module_support_desc', '13', 'support', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_timekeeping', 'module_timekeeping_desc', '8', 'timekeeping', '1', '1', '0');
INSERT INTO `lifetek_modules` VALUES ('module_tinhoc', 'module_tinhoc_desc', '60', 'tinhoc', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_tkdus', 'module_tkdus_desc', '217', 'tkdus', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_units', 'module_units_desc', '80', 'units', '0', '0', '1');
INSERT INTO `lifetek_modules` VALUES ('module_vendors', 'module_vendors_desc', '1123', 'vendors', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_visa', 'module_visa_desc', '210', 'visa', '0', '0', '0');
INSERT INTO `lifetek_modules` VALUES ('module_web', 'module_web_desc', '9', 'web', '0', '0', '0');

-- ----------------------------
-- Table structure for lifetek_modules_actions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_modules_actions`;
CREATE TABLE `lifetek_modules_actions` (
  `action_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action_name_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`action_id`,`module_id`),
  KEY `phppos_modules_actions_ibfk_1` (`module_id`),
  CONSTRAINT `lifetek_modules_actions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `lifetek_modules` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_modules_actions
-- ----------------------------
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'abouts', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'account_plan', 'module_action_add_update', '800');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'account_type', 'module_action_add_update', '225');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'accountings', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'admin_agent', 'module_action_add_update', '2363');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'affiliates', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'assets', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'bangcap', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'bill_cost', 'module_action_add_update', '266');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'categories', 'module_action_add_update', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'category_processes', 'module_action_add_update', '16');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'chungtus', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'cities', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'city', 'module_action_add_update', '111');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'citys', 'module_action_add_update', '123');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'congcus', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'contractcustomer', 'module_action_add_update', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'contractcustomer_type', 'module_action_add_update', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'contracts', 'module_action_add_update', '1114');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'costs', 'module_action_add_update', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'create_invetorys', 'module_action_add_update', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'currencys', 'module_action_add_update', '111');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'customer_type', 'module_action_add_update', '180');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'customers', 'module_action_add_update', '1');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'department', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'dttcs', 'module_action_add_update', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'education', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'employees', 'module_action_add_update', '130');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'file', 'module_action_add_update', '300000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'giftcards', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'hrm', 'module_action_add_update', '160');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'imports', 'module_action_add_update', '14');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'introductions', 'module_action_add_update', '555');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'item_kits', 'module_action_add_update', '70');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'item2s', 'module_action_add_update', '1');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'item4s', 'module_action_add_update', '100');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'items', 'module_action_add_update', '40');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'jobs', 'module_action_add_update', '150');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'jobs_employee', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'jobs_project', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'jobs_report', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'kh', 'module_action_add_update', '12');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'language', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'news', 'module_action_add_update', '888');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'packs', 'module_action_add_update', '820');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'positions', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'profit', 'module_action_add_update', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'profix', 'module_action_add_update', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'quotes_contract', 'module_action_add_update', '11');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'receivings', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'regions', 'module_action_add_update', '100');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'reports', 'module_action_add_update', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'resellers', 'module_action_add_update', '333');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'salaryconfig', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'salaryoption', 'module_action_add_update', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'services', 'module_action_add_update', '5');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'setting', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'shop_guide', 'module_action_add_update', '2244');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'slider', 'module_action_add_update', '1');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'solutions', 'module_action_add_update', '444');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'suppliers', 'module_action_add_update', '100');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'support', 'module_action_add_update', '13');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'timekeeping', 'module_action_add_update', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'tinhoc', 'module_action_add_update', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'tkdus', 'module_action_add_update', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'units', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'vendors', 'module_action_add_update', '1123');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'visa', 'module_action_add_update', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update', 'web', 'module_action_add_update', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('add_update_export_store', 'create_invetorys', 'module_action_add_update_export_store', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('confirm_export_store', 'create_invetorys', 'module_action_confirm_export_store', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('confirm_receiving', 'receivings', 'module_action_confirm_receiving', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'abouts', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'account_plan', 'module_action_delete', '800');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'account_type', 'module_action_delete', '230');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'accountings', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'admin_agent', 'module_action_delete', '2363');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'affiliates', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'assets', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'bangcap', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'bill_cost', 'module_action_delete', '266');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'categories', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'category_processes', 'module_action_delete', '16');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'chungtus', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'cities', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'city', 'module_action_delete', '11111');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'congcus', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'contact_admin', 'module_action_delete', '567');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'contractcustomer', 'module_action_delete', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'contractcustomer_type', 'module_action_add_update', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'contracts', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'costs', 'module_action_delete', '20');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'create_invetorys', 'module_action_delete', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'currencys', 'module_action_delete', '111');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'customer_type', 'module_action_delete', '180');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'customers', 'module_action_delete', '20');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'department', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'dttcs', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'education', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'employees', 'module_action_delete', '140');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'file', 'module_action_delete', '300000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'giftcards', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'introductions', 'module_action_delete', '555');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'item_kits', 'module_action_delete', '80');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'items', 'module_action_delete', '50');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'jobs', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'jobs_employee', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'jobs_project', 'module_action_delete', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'jobs_report', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'language', 'module_action_delete', '20');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'news', 'module_action_delete', '888');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'packs', 'module_action_delete', '800');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'positions', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'profit', 'module_action_delete', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'quotes_contract', 'module_action_delete', '11');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'receivings', 'module_action_delete', '1800');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'regions', 'module_action_delete', '200');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'resellers', 'module_action_delete', '333');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'salaryconfig', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'salaryoption', 'module_action_delete', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'services', 'module_action_delete', '5');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'slider', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'solutions', 'module_action_delete', '444');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'suppliers', 'module_action_delete', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'support', 'module_action_delete', '13');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'timekeeping', 'module_action_delete', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'tinhoc', 'module_action_delete', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'tkdus', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'units', 'module_action_delete', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'vendors', 'module_action_delete', '1123');
INSERT INTO `lifetek_modules_actions` VALUES ('delete', 'visa', 'module_action_delete', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('delete_receiving', 'receivings', 'module_action_delete_receiving', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('delete_sale', 'sales', 'module_action_delete_sale', '3214');
INSERT INTO `lifetek_modules_actions` VALUES ('edit_sale_price', 'sales', 'module_edit_sale_price', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('edit_salestraining_price', 'salestraining', 'module_edit_salestraining_price', '1');
INSERT INTO `lifetek_modules_actions` VALUES ('estimate', 'item_kits', 'module_action_estimate', '50');
INSERT INTO `lifetek_modules_actions` VALUES ('manage_production', 'item_kits', 'module_action_manage_production', '52');
INSERT INTO `lifetek_modules_actions` VALUES ('orders', 'sales', 'module_action_orders', '56');
INSERT INTO `lifetek_modules_actions` VALUES ('paybook', 'sales', 'module_action_paybook', '55');
INSERT INTO `lifetek_modules_actions` VALUES ('price_alert', 'sales', 'module_action_price_alert', '54');
INSERT INTO `lifetek_modules_actions` VALUES ('print_order', 'sales', 'module_action_print_order', '2234');
INSERT INTO `lifetek_modules_actions` VALUES ('production', 'item_kits', 'module_action_production', '51');
INSERT INTO `lifetek_modules_actions` VALUES ('receiving_order', 'receivings', 'module_action_receiving_order', '201');
INSERT INTO `lifetek_modules_actions` VALUES ('sales_order', 'sales', 'module_action_sales_order', '2900');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'abouts', 'module_action_search_abouts', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'account_plan', 'module_action_search_account_plan', '800');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'account_type', 'module_action_search_account_type', '305');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'accountings', 'module_action_search_accountings', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'admin_agent', 'module_action_search', '2363');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'affiliates', 'module_action_search_affiliates', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'assets', 'module_action_search_assets', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'bangcap', 'module_action_search_bangcap', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'bill_cost', 'module_action_search_bill_cost', '266');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'categories', 'module_action_search_categories', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'category_processes', 'module_action_search_category_processes', '16');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'chungtus', 'module_action_search_chungtus', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'cities', 'module_action_search_cities', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'city', 'module_action_search_city', '11111');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'congcus', 'module_action_search_congcus', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'contact_admin', 'module_action_search_contact_admin', '567');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'contractcustomer', 'module_action_search_contractcustomer', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'contractcustomer_type', 'module_action_search_contractcustomer_type', '110');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'contracts', 'module_action_search_contracts', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'costs', 'module_action_search_costs', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'currencys', 'module_action_search_currencys', '111');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'customer_type', 'module_action_search_customer_type', '180');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'customers', 'module_action_search_customers', '30');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'department', 'module_action_search_department', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'dttcs', 'module_action_search_dttcs', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'education', 'module_action_search_education', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'employees', 'module_action_search_employees', '150');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'file', 'module_action_search_file', '300000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'giftcards', 'module_action_search_giftcards', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'introductions', 'module_action_search', '555');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'item_kits', 'module_action_search_item_kits', '90');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'items', 'module_action_search_items', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'jobs', 'module_action_search_jobs', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'jobs_employee', 'module_action_search_jobs_employee', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'jobs_project', 'module_action_search_jobs_project', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'jobs_report', 'module_action_search_jobs_report', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'language', 'module_action_search_language', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'news', 'module_action_search', '888');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'packs', 'module_action_search_packs', '810');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'positions', 'module_action_search_positions', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'profit', 'module_action_search_profit', '170');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'quotes_contract', 'module_action_search', '11');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'regions', 'module_action_search_regions', '200');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'resellers', 'module_action_search', '333');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'salaryconfig', 'module_action_search_salaryconfig', '210');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'salaryoption', 'module_action_search_salaryoption', '1000');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'services', 'module_action_search_services', '5');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'solutions', 'module_action_search', '444');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'suppliers', 'module_action_search_suppliers', '120');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'support', 'module_action_search', '13');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'tinhoc', 'module_action_search_tinhoc', '25');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'tkdus', 'module_action_search_tkdus', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'units', 'module_action_search_units', '60');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'vendors', 'module_action_search_vendors', '1123');
INSERT INTO `lifetek_modules_actions` VALUES ('search', 'visa', 'module_action_search_visa', '11111');
INSERT INTO `lifetek_modules_actions` VALUES ('see_cost_price', 'items', 'module_see_cost_price', '61');
INSERT INTO `lifetek_modules_actions` VALUES ('technical', 'items', 'module_action_add_update', '99');
INSERT INTO `lifetek_modules_actions` VALUES ('update_receiving', 'receivings', 'module_action_update_receiving', '201');

-- ----------------------------
-- Table structure for lifetek_money_birthdate
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_money_birthdate`;
CREATE TABLE `lifetek_money_birthdate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noidung` varchar(255) CHARACTER SET latin1 NOT NULL,
  `chiphi` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_money_birthdate
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_banner
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_banner`;
CREATE TABLE `lifetek_mt_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(255) CHARACTER SET utf8 NOT NULL,
  `flash` text CHARACTER SET utf8 NOT NULL,
  `width` int(4) NOT NULL DEFAULT '200',
  `height` int(4) NOT NULL DEFAULT '200',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `positions` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_banner
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_banner_positions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_banner_positions`;
CREATE TABLE `lifetek_mt_banner_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_banner_positions
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_bottom
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_bottom`;
CREATE TABLE `lifetek_mt_bottom` (
  `content` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_bottom
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_categories
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_categories`;
CREATE TABLE `lifetek_mt_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sections` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_categories
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_content
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_content`;
CREATE TABLE `lifetek_mt_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `introtext` mediumtext CHARACTER SET utf8 NOT NULL,
  `fulltext` mediumtext CHARACTER SET utf8 NOT NULL,
  `sectionid` int(11) unsigned NOT NULL DEFAULT '0',
  `catid` int(11) unsigned NOT NULL DEFAULT '0',
  `created` date NOT NULL DEFAULT '0000-00-00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) unsigned NOT NULL,
  `anh` varchar(100) DEFAULT NULL,
  `anh_con` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_content
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_sections
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_sections`;
CREATE TABLE `lifetek_mt_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_sections
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_mt_support
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_mt_support`;
CREATE TABLE `lifetek_mt_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `skype` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yahoo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `parts_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_mt_support
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_news
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_news`;
CREATE TABLE `lifetek_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 NOT NULL,
  `en_title` text NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `en_description` text NOT NULL,
  `full` text CHARACTER SET utf8 NOT NULL,
  `en_full` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `source` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL,
  `url` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_news
-- ----------------------------
INSERT INTO `lifetek_news` VALUES ('1', 'Du học Nhật Bản', '', 'Trào lưu học sinh, sinh viên du học Nhật Bản, lao động xuất khẩu', '<p>dess</p>\n', '<p>Nghề chăm s&oacute;c người bệnh hay c&ograve;n gọi l&agrave; osin bệnh viện từ l&acirc;u đ&atilde; trở th&agrave;nh một nghề tự ph&aacute;t được nhiều phụ nữ n&ocirc;ng th&ocirc;n ra th&agrave;nh phố lựa chọn. C&oacute; những l&agrave;ng, phụ nữ rủ nhau đi l&agrave;m nghề osin bệnh viện gần hết. Nghề tuy vất vả nhưng c&oacute; thể đưa lại cho họ thu nhập cao hơn việc trồng l&uacute;a hay đi l&agrave;m osin đơn thuần.</p>\n\n<p><strong>Osin được đi &quot;du lịch ch&acirc;u &Acirc;u&quot;</strong></p>\n\n<p>Chị Nguyễn Thị Ly (40 tuổi) cho biết: &ldquo;T&ocirc;i l&agrave;m nghề n&agrave;y được 5 năm nhưng rất nhiều lần được thu&ecirc; đi c&ugrave;ng bệnh nh&acirc;n đi sang nước ngo&agrave;i chữa bệnh. Số tiền được trả thường 15 triệu/th&aacute;ng, ăn uống được bao hết&rdquo;.</p>\n', '<p>full</p>\n', 'girl-xinh-ngo-thu-1.jpg', 'Theo Hiểu Khuê (Infonet)', '2015-12-03', 'du-hoc-nhat-ban', null);
INSERT INTO `lifetek_news` VALUES ('20', 'Rộn ràng giáng sinh', 'R?n ràng giáng sinh', 'Rộn ràng giáng sinh', 'R?n ràng giáng sinh', 'Rộn ràng giáng sinh', 'R?n ràng giáng sinh', 'Desert.jpg', 'Rộn ràng giáng sinh', '2016-01-17', 'ron-rang-giang-sinh', '15');

-- ----------------------------
-- Table structure for lifetek_news_category
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_news_category`;
CREATE TABLE `lifetek_news_category` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_name` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `active` bit(1) NOT NULL DEFAULT b'0',
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_news_category
-- ----------------------------
INSERT INTO `lifetek_news_category` VALUES ('12', 'e2', 'e', '0', '1', '', 'e2');
INSERT INTO `lifetek_news_category` VALUES ('13', '3', '333', '0', '1', '', '3');
INSERT INTO `lifetek_news_category` VALUES ('14', '3', '3', '0', '1', '\0', '3');
INSERT INTO `lifetek_news_category` VALUES ('15', '1', '1', '0', '0', '', '1');

-- ----------------------------
-- Table structure for lifetek_nhomts_thietbi
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_nhomts_thietbi`;
CREATE TABLE `lifetek_nhomts_thietbi` (
  `id_tstb` int(11) NOT NULL AUTO_INCREMENT,
  `name_tstb` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `desc_tstb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_tstb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_nhomts_thietbi
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_number_sms
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_number_sms`;
CREATE TABLE `lifetek_number_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_sms` int(11) NOT NULL,
  `quantity_sms` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_number_sms
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_category
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_category`;
CREATE TABLE `lifetek_omc_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(1000) NOT NULL,
  `longdesc` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `parentid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_category
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_colors
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_colors`;
CREATE TABLE `lifetek_omc_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_colors
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_customer
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_customer`;
CREATE TABLE `lifetek_omc_customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(50) NOT NULL,
  `customer_first_name` varchar(50) NOT NULL,
  `customer_last_name` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `Namsinh` date NOT NULL DEFAULT '0000-00-00',
  `Gioitinh` tinyint(1) NOT NULL,
  `post_code` int(10) unsigned NOT NULL,
  `thongtinkhac` varchar(255) NOT NULL,
  `nguoidung` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_customer
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_menu
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_menu`;
CREATE TABLE `lifetek_omc_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `page_uri` varchar(60) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `parentid` int(10) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_uri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_menu
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_messages
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_messages`;
CREATE TABLE `lifetek_omc_messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_messages
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_order
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_order`;
CREATE TABLE `lifetek_omc_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `payment_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_order
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_order_item
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_order_item`;
CREATE TABLE `lifetek_omc_order_item` (
  `order_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_order_item
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_page
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_page`;
CREATE TABLE `lifetek_omc_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_page
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_parts
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_parts`;
CREATE TABLE `lifetek_omc_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_omc_parts
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_product
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_product`;
CREATE TABLE `lifetek_omc_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `longdesc` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_order` int(11) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `grouping` varchar(16) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `id_cat` int(11) NOT NULL,
  `featured` enum('none','front','webshop') NOT NULL,
  `other_feature` enum('none','most sold','new product') NOT NULL,
  `price` float(7,2) NOT NULL,
  PRIMARY KEY (`id`,`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_product
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_product_colors
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_product_colors`;
CREATE TABLE `lifetek_omc_product_colors` (
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`color_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_product_colors
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_product_sizes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_product_sizes`;
CREATE TABLE `lifetek_omc_product_sizes` (
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`size_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_product_sizes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_sizes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_sizes`;
CREATE TABLE `lifetek_omc_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_sizes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_omc_subscribers
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_omc_subscribers`;
CREATE TABLE `lifetek_omc_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_omc_subscribers
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_options
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_options`;
CREATE TABLE `lifetek_options` (
  `id` int(11) NOT NULL,
  `ques_id` int(11) NOT NULL,
  `value` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_options
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_order_service
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_order_service`;
CREATE TABLE `lifetek_order_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `symbol` varchar(68) CHARACTER SET utf8 NOT NULL,
  `person_id` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `order_date` date NOT NULL,
  `tax_percent` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `delete` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT '0' COMMENT '0: Nhập hàng , 1 :Bán hàng',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_order_service
-- ----------------------------
INSERT INTO `lifetek_order_service` VALUES ('1', '8', 'Z8', '2255', '2015-11-12', '2015-11-12', '10', 'abc  2', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('2', '0', '', '2240', '2015-11-11', '2015-11-11', '0', 'munbxnzx', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('3', '0', '', '0', '1970-01-01', '1970-01-01', '0', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('4', '0', '', '0', '1970-01-01', '1970-01-01', '0', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('5', '123', 'as', '2288', '2015-10-26', '2015-10-26', '10', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('6', '3211', 'sss', '2287', '2015-10-27', '2015-11-24', '10', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('7', '5444', 'qq', '2222', '2015-11-10', '2015-11-10', '10', 'diễn giải', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('8', '111111', 'q', '2259', '2015-10-26', '2015-11-11', '10', 'bbbbbbbbbbbbbbbbbbbbbbbbb aaaaaaaaaaaaaaaaaaaaaaaaaaaa cccccccccccccccccccccccccccc', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('9', '1222', 'QA', '2286', '2015-10-26', '2015-11-26', '10', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('10', '14', 'HD', '2287', '2015-11-10', '2015-11-11', '10', 'vvvvc', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('11', '12', 'HD', '2286', '2015-10-26', '2015-11-04', '10', 'THÊM DIỄN GIẢI', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('12', '16', 'HF', '2240', '2015-10-26', '2015-11-10', '10', 'Diễn giải mới', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('13', '18', 'FH', '2293', '2015-11-11', '2015-11-11', '10', '  sssfdsffg', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('14', '12', 'HK', '2213', '2015-10-26', '2015-10-26', '10', ' adaddaaa', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('15', '2811', ' HT', '2240', '2015-11-28', '2015-11-28', '10', 'KKKKKKKKK', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('16', '88', 'HT', '2286', '2015-11-11', '2015-11-11', '10', 'HEHE', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('17', '15', 'HT', '2218', '2015-11-12', '2015-11-12', '10', 'thêm diễn giải\n', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('18', '14', 'HT', '2286', '2015-11-12', '2015-11-12', '10', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('19', '1234', 'HT', '2308', '2015-10-27', '2015-11-16', '10', ' ', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('20', '12', 'TT/14P', '2288', '2015-11-01', '2015-11-01', '10', 'Nhập mua tài sản cố định', '0', '0');
INSERT INTO `lifetek_order_service` VALUES ('21', '125236', 'HT', '2240', '2015-11-02', '2015-11-23', '10', '', '1', '0');
INSERT INTO `lifetek_order_service` VALUES ('22', '0', 'dungchip1', '2101', '2015-11-01', '2015-11-01', '12', 'xxxxxx', '1', '1');
INSERT INTO `lifetek_order_service` VALUES ('23', '1', '1', '2101', '2015-11-10', '2015-11-10', '1', '1', '1', '1');
INSERT INTO `lifetek_order_service` VALUES ('24', '134', '1', '2332', '2015-11-17', '2015-12-02', '1', '1', '0', '1');
INSERT INTO `lifetek_order_service` VALUES ('25', '5', '5', '2309', '2015-11-02', '2015-11-13', '5', '34', '0', '1');
INSERT INTO `lifetek_order_service` VALUES ('26', '0', 'klinh ', '2252', '2015-11-05', '2015-11-19', '0', 'linh bi', '1', '1');
INSERT INTO `lifetek_order_service` VALUES ('27', '13456', 'HTTT', '2252', '2015-11-27', '2015-11-27', '5', '', '0', '1');
INSERT INTO `lifetek_order_service` VALUES ('28', '123456', 'th', '2240', '2015-12-03', '1970-01-01', '0', '', '0', '1');
INSERT INTO `lifetek_order_service` VALUES ('29', '123', '', '2277', '2015-12-09', '2015-11-30', '0', '', '0', '1');
INSERT INTO `lifetek_order_service` VALUES ('30', '22', 'lan', '2277', '2015-12-14', '2015-12-10', '10', 'huệ lan hoa thắng quyết diệp chi tùng bà ông :)', '0', '1');

-- ----------------------------
-- Table structure for lifetek_packs
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_packs`;
CREATE TABLE `lifetek_packs` (
  `pack_id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `unit` int(11) NOT NULL,
  `unit_price` decimal(15,0) DEFAULT NULL,
  `cost_price` decimal(15,0) DEFAULT NULL,
  `value_price` decimal(15,0) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `location` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `taxes` float NOT NULL,
  `images` varchar(255) NOT NULL,
  `total_quantity` double(20,2) NOT NULL,
  `total_cost` decimal(15,0) NOT NULL,
  `total_sale_price` decimal(15,0) NOT NULL,
  `status_material` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_packs
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_pack_items
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_pack_items`;
CREATE TABLE `lifetek_pack_items` (
  `pack_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double(20,2) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `product_as_item` double(20,2) NOT NULL,
  `quantity_inventory` double(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_pack_items
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_parts
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_parts`;
CREATE TABLE `lifetek_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_parts
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_people
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_people`;
CREATE TABLE `lifetek_people` (
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Số di động',
  `phone` varchar(15) DEFAULT NULL COMMENT 'Số máy bàn',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comments` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  `birth_date` date DEFAULT NULL,
  `register_date` date NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`person_id`),
  KEY `first_name` (`first_name`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_people
-- ----------------------------
INSERT INTO `lifetek_people` VALUES ('Lê ', 'Nam Admin', '01677932954', '', 'lifeone@gmail.com', 'Ba Đình', '24', '', '1', '2013-06-01', '0000-00-00', '');

-- ----------------------------
-- Table structure for lifetek_permissions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_permissions`;
CREATE TABLE `lifetek_permissions` (
  `module_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `lifetek_permissions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_permissions
-- ----------------------------
INSERT INTO `lifetek_permissions` VALUES ('account_plan', '1');
INSERT INTO `lifetek_permissions` VALUES ('account_type', '1');
INSERT INTO `lifetek_permissions` VALUES ('accountings', '1');
INSERT INTO `lifetek_permissions` VALUES ('admin_agent', '1');
INSERT INTO `lifetek_permissions` VALUES ('affiliates', '1');
INSERT INTO `lifetek_permissions` VALUES ('assets', '1');
INSERT INTO `lifetek_permissions` VALUES ('bangcap', '1');
INSERT INTO `lifetek_permissions` VALUES ('bill_cost', '1');
INSERT INTO `lifetek_permissions` VALUES ('categories', '1');
INSERT INTO `lifetek_permissions` VALUES ('category_processes', '1');
INSERT INTO `lifetek_permissions` VALUES ('chungtus', '1');
INSERT INTO `lifetek_permissions` VALUES ('cities', '1');
INSERT INTO `lifetek_permissions` VALUES ('city', '1');
INSERT INTO `lifetek_permissions` VALUES ('congcus', '1');
INSERT INTO `lifetek_permissions` VALUES ('contact_admin', '1');
INSERT INTO `lifetek_permissions` VALUES ('contractcustomer', '1');
INSERT INTO `lifetek_permissions` VALUES ('contractcustomer_type', '1');
INSERT INTO `lifetek_permissions` VALUES ('contracts', '1');
INSERT INTO `lifetek_permissions` VALUES ('costs', '1');
INSERT INTO `lifetek_permissions` VALUES ('create_invetorys', '1');
INSERT INTO `lifetek_permissions` VALUES ('currencys', '1');
INSERT INTO `lifetek_permissions` VALUES ('customer_type', '1');
INSERT INTO `lifetek_permissions` VALUES ('customers', '1');
INSERT INTO `lifetek_permissions` VALUES ('department', '1');
INSERT INTO `lifetek_permissions` VALUES ('dttcs', '1');
INSERT INTO `lifetek_permissions` VALUES ('education', '1');
INSERT INTO `lifetek_permissions` VALUES ('employees', '1');
INSERT INTO `lifetek_permissions` VALUES ('file', '1');
INSERT INTO `lifetek_permissions` VALUES ('giftcards', '1');
INSERT INTO `lifetek_permissions` VALUES ('hrm', '1');
INSERT INTO `lifetek_permissions` VALUES ('imports', '1');
INSERT INTO `lifetek_permissions` VALUES ('introductions', '1');
INSERT INTO `lifetek_permissions` VALUES ('item_kits', '1');
INSERT INTO `lifetek_permissions` VALUES ('items', '1');
INSERT INTO `lifetek_permissions` VALUES ('jobs', '1');
INSERT INTO `lifetek_permissions` VALUES ('jobs_employee', '1');
INSERT INTO `lifetek_permissions` VALUES ('jobs_project', '1');
INSERT INTO `lifetek_permissions` VALUES ('jobs_report', '1');
INSERT INTO `lifetek_permissions` VALUES ('language', '1');
INSERT INTO `lifetek_permissions` VALUES ('news', '1');
INSERT INTO `lifetek_permissions` VALUES ('news_category', '1');
INSERT INTO `lifetek_permissions` VALUES ('packs', '1');
INSERT INTO `lifetek_permissions` VALUES ('positions', '1');
INSERT INTO `lifetek_permissions` VALUES ('profit', '1');
INSERT INTO `lifetek_permissions` VALUES ('quotes_contract', '1');
INSERT INTO `lifetek_permissions` VALUES ('receivings', '1');
INSERT INTO `lifetek_permissions` VALUES ('regions', '1');
INSERT INTO `lifetek_permissions` VALUES ('reports', '1');
INSERT INTO `lifetek_permissions` VALUES ('resellers', '1');
INSERT INTO `lifetek_permissions` VALUES ('salaryconfig', '1');
INSERT INTO `lifetek_permissions` VALUES ('salaryoption', '1');
INSERT INTO `lifetek_permissions` VALUES ('sales', '1');
INSERT INTO `lifetek_permissions` VALUES ('services', '1');
INSERT INTO `lifetek_permissions` VALUES ('setting', '1');
INSERT INTO `lifetek_permissions` VALUES ('shop_guide', '1');
INSERT INTO `lifetek_permissions` VALUES ('slider', '1');
INSERT INTO `lifetek_permissions` VALUES ('solutions', '1');
INSERT INTO `lifetek_permissions` VALUES ('suppliers', '1');
INSERT INTO `lifetek_permissions` VALUES ('support', '1');
INSERT INTO `lifetek_permissions` VALUES ('timekeeping', '1');
INSERT INTO `lifetek_permissions` VALUES ('tinhoc', '1');
INSERT INTO `lifetek_permissions` VALUES ('tkdus', '1');
INSERT INTO `lifetek_permissions` VALUES ('units', '1');
INSERT INTO `lifetek_permissions` VALUES ('vendors', '1');
INSERT INTO `lifetek_permissions` VALUES ('visa', '1');
INSERT INTO `lifetek_permissions` VALUES ('web', '1');

-- ----------------------------
-- Table structure for lifetek_permissions_actions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_permissions_actions`;
CREATE TABLE `lifetek_permissions_actions` (
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(11) NOT NULL,
  `action_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`,`action_id`),
  KEY `phppos_permissions_actions_ibfk_2` (`person_id`),
  KEY `phppos_permissions_actions_ibfk_3` (`action_id`),
  CONSTRAINT `lifetek_permissions_actions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`),
  CONSTRAINT `lifetek_permissions_actions_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `lifetek_modules_actions` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_permissions_actions
-- ----------------------------
INSERT INTO `lifetek_permissions_actions` VALUES ('account_plan', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('account_plan', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('account_plan', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('account_type', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('account_type', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('account_type', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('accountings', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('accountings', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('accountings', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('admin_agent', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('admin_agent', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('admin_agent', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('affiliates', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('affiliates', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('affiliates', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('assets', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('assets', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('assets', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('bangcap', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('bangcap', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('bangcap', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('bill_cost', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('bill_cost', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('bill_cost', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('categories', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('categories', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('categories', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('category_processes', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('category_processes', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('category_processes', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('chungtus', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('chungtus', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('chungtus', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('cities', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('cities', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('cities', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('city', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('city', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('city', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('congcus', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('congcus', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('congcus', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('contact_admin', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('contact_admin', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('contractcustomer', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('contractcustomer', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('contractcustomer', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('contractcustomer_type', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('contractcustomer_type', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('contractcustomer_type', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('contracts', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('contracts', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('contracts', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('costs', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('costs', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('costs', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('create_invetorys', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('create_invetorys', '1', 'add_update_export_store');
INSERT INTO `lifetek_permissions_actions` VALUES ('create_invetorys', '1', 'confirm_export_store');
INSERT INTO `lifetek_permissions_actions` VALUES ('create_invetorys', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('currencys', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('currencys', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('currencys', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('customer_type', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('customer_type', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('customer_type', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('customers', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('customers', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('customers', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('department', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('department', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('department', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('dttcs', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('dttcs', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('dttcs', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('education', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('education', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('education', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('employees', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('employees', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('employees', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('file', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('file', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('file', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('giftcards', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('giftcards', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('giftcards', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('hrm', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('imports', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('introductions', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('introductions', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('introductions', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('item_kits', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('item_kits', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('item_kits', '1', 'estimate');
INSERT INTO `lifetek_permissions_actions` VALUES ('item_kits', '1', 'manage_production');
INSERT INTO `lifetek_permissions_actions` VALUES ('item_kits', '1', 'production');
INSERT INTO `lifetek_permissions_actions` VALUES ('item_kits', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('items', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('items', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('items', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('items', '1', 'see_cost_price');
INSERT INTO `lifetek_permissions_actions` VALUES ('items', '1', 'technical');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_employee', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_employee', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_employee', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_project', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_project', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_project', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_report', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_report', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('jobs_report', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('language', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('language', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('language', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('news', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('news', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('news', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('news_category', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('news_category', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('news_category', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('packs', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('packs', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('packs', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('positions', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('positions', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('positions', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('profit', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('profit', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('profit', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('quotes_contract', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('quotes_contract', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('quotes_contract', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('receivings', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('receivings', '1', 'confirm_receiving');
INSERT INTO `lifetek_permissions_actions` VALUES ('receivings', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('receivings', '1', 'delete_receiving');
INSERT INTO `lifetek_permissions_actions` VALUES ('receivings', '1', 'receiving_order');
INSERT INTO `lifetek_permissions_actions` VALUES ('receivings', '1', 'update_receiving');
INSERT INTO `lifetek_permissions_actions` VALUES ('regions', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('regions', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('regions', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('reports', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('resellers', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('resellers', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('resellers', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('salaryconfig', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('salaryconfig', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('salaryconfig', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('salaryoption', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('salaryoption', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('salaryoption', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'delete_sale');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'edit_sale_price');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'orders');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'paybook');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'price_alert');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'print_order');
INSERT INTO `lifetek_permissions_actions` VALUES ('sales', '1', 'sales_order');
INSERT INTO `lifetek_permissions_actions` VALUES ('services', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('services', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('services', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('setting', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('shop_guide', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('slider', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('slider', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('solutions', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('solutions', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('solutions', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('suppliers', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('suppliers', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('suppliers', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('support', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('support', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('support', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('timekeeping', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('timekeeping', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('tinhoc', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('tinhoc', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('tinhoc', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('tkdus', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('tkdus', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('tkdus', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('units', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('units', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('units', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('vendors', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('vendors', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('vendors', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('visa', '1', 'add_update');
INSERT INTO `lifetek_permissions_actions` VALUES ('visa', '1', 'delete');
INSERT INTO `lifetek_permissions_actions` VALUES ('visa', '1', 'search');
INSERT INTO `lifetek_permissions_actions` VALUES ('web', '1', 'add_update');

-- ----------------------------
-- Table structure for lifetek_ppkh
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_ppkh`;
CREATE TABLE `lifetek_ppkh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_ppkh
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_preferences
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_preferences`;
CREATE TABLE `lifetek_preferences` (
  `name` varchar(254) NOT NULL,
  `value` text NOT NULL,
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_preferences
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_processes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_processes`;
CREATE TABLE `lifetek_processes` (
  `id_processes` int(11) NOT NULL AUTO_INCREMENT,
  `name_processes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(2) DEFAULT '0',
  `cat_pro_id` int(11) NOT NULL,
  PRIMARY KEY (`id_processes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_processes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_processes_design_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_processes_design_template`;
CREATE TABLE `lifetek_processes_design_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) NOT NULL,
  `id_design_template` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_confirm` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_processes_design_template
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_processes_item_kit
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_processes_item_kit`;
CREATE TABLE `lifetek_processes_item_kit` (
  `item_kit_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `date_finish` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_processes_item_kit
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_production_flow_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_production_flow_template`;
CREATE TABLE `lifetek_production_flow_template` (
  `id_production_flow_template` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) DEFAULT NULL,
  `id_processes` int(11) DEFAULT NULL,
  `time_processes` float DEFAULT NULL,
  `unit_time` tinyint(4) DEFAULT NULL,
  `cost_tools` decimal(15,0) DEFAULT NULL COMMENT 'Chi phí công cụ sản xuất',
  `cost_labor` decimal(15,0) DEFAULT NULL COMMENT 'Chi phí nhân công',
  `cost_other` decimal(15,0) DEFAULT NULL COMMENT 'Chi phí ngoài',
  `production_order` int(11) DEFAULT NULL COMMENT 'Thứ tự sản xuất',
  `status` int(11) DEFAULT NULL COMMENT 'Trạng thái sản xuất',
  PRIMARY KEY (`id_production_flow_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Luồng sản xuất mẫu';

-- ----------------------------
-- Records of lifetek_production_flow_template
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_profit
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_profit`;
CREATE TABLE `lifetek_profit` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `formula_name` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `transport` int(100) DEFAULT NULL,
  `tax` int(4) DEFAULT NULL,
  `staff_id` decimal(15,5) DEFAULT NULL,
  `fixed_costs` decimal(15,5) DEFAULT NULL,
  `advertising_costs` decimal(15,5) DEFAULT NULL,
  `commission` decimal(15,5) DEFAULT NULL,
  `customer_care` decimal(15,5) DEFAULT NULL,
  `other_costs` decimal(15,5) DEFAULT NULL,
  `expected_profit` decimal(15,5) DEFAULT NULL,
  `sum_salary` decimal(15,5) DEFAULT NULL,
  `estimated_number` decimal(15,5) DEFAULT NULL,
  `deleted` smallint(4) DEFAULT NULL,
  `price` decimal(15,5) DEFAULT NULL,
  `flag` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`name`,`formula_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_profit
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_profit_empl
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_profit_empl`;
CREATE TABLE `lifetek_profit_empl` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(250) NOT NULL,
  `name_empl` varchar(200) NOT NULL,
  `day_hour` varchar(20) NOT NULL,
  `day_hour_number` int(4) DEFAULT NULL,
  `salary_empl` decimal(15,5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_profit_empl
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_profit_other
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_profit_other`;
CREATE TABLE `lifetek_profit_other` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(200) NOT NULL,
  `cost_name` varchar(200) DEFAULT NULL,
  `price2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`f_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_profit_other
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_questions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_questions`;
CREATE TABLE `lifetek_questions` (
  `id` int(11) NOT NULL,
  `ques` text NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_questions
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_quotes_contract
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_quotes_contract`;
CREATE TABLE `lifetek_quotes_contract` (
  `id_quotes_contract` int(11) NOT NULL AUTO_INCREMENT,
  `title_quotes_contract` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_quotes_contract` text COLLATE utf8_unicode_ci,
  `cat_quotes_contract` tinyint(2) DEFAULT '0' COMMENT '1: Mẫu hợp đồng - 2: Mẫu báo giá',
  PRIMARY KEY (`id_quotes_contract`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_quotes_contract
-- ----------------------------
INSERT INTO `lifetek_quotes_contract` VALUES ('6', 'Báo giá dịch vụ', '<p  center;\">BẢNG BÁO GIÁ</p>\n\n<p>{LOGO}</p>\n\n<p  center;\"><em>Ngày  {DATE}, Tháng {MONTH}, Năm {YEAR}</em></p>\n\n<hr />\n<p>Tên đơn vị(Company):                                                      {TEN_KH}</p>\n\n<p>Họ tên Người mua hàng(Customer\'s name):                 {DD_KH}</p>\n\n<p>Mã số thuế (Tax Code):                                                     </p>\n\n<p>Địa chỉ (Address):                                                                {DIA_CHI_KH}</p>\n\n<p>Số tài khoản (Acount no):                                                   {TKNH_KH}</p>\n\n<p>Tại ngân hàng (Bank\'s name):                                           {NH_KH}                       </p>\n\n<p>Hình thức TT (Payment of term):                                        </p>\n\n<p>Gọi tắt là bên A      </p>\n\n<hr />\n<p>Đơn vị bán hàng  (Sale Company):                   Công ty TNHH Công Nghệ Tự Động Hóa Minh Anh.</p>\n\n<p>Địa chỉ (Address):                                                 </p>\n\n<p>Điện thoại (Tex/Fax):                                            0436413130 - 0164939929688</p>\n\n<p>Người báo giá (Salesman):                                </p>\n\n<p>Quản lý (Manager):                                               Ông  Nguyễn Xuân Giang          Điện thoại (Mob):  0944245885</p>\n\n<p  right;\">Gọi tắt là bên B                                                                                                               Đơn vị tiền tệ (Unit currency):     VNĐ  </p>\n\n<p>{TABLE_DATA}</p>\n\n<p>- Đơn giá trên đã bao gồm thuế VAT</p>\n\n<p>- Bảo hành 12 tháng kể từ ngày ký biên bản nghiệm thu hàng hóa</p>\n\n<p>- Giá trên đã bao gồm các loại thuế, chi phí vận chuyển tại kho Hà Nội, bảo hiểm, bảo hành trong thời gian hoàn thành...</p>\n\n<p>Trách nhiệm của bên A</p>\n\n<p>Thông báo kịp thời cho bên B khi thang máy bị sự cố, hư hỏng.<br />\nNgoài thao tác cứu hộ hành khách ra khỏi phòng thang trong tr¬ường hợp khẩn cấp như đã được hướng dẫn, bên A hoặc bên thứ ba không được tự thực hiện bất kỳ công việc gì liên quan tới thiết bị thang máy khi chưa có sự đồng ý bằng văn bản của bên B.  <br />\nTạo điều kiện thuận lợi để bên B thực hiện công việc bảo hành, bảo dưỡng thang máy.<br />\nKý xác nhận vào phiếu công tác của bên B mỗi khi bên B thực hiện công việc bảo trì, sửa chữa thang máy.</p>\n\n<p>Trách nhiệm của bên B</p>\n\n<p>\'Bảo dưỡng, bảo trì định kỳ 01 lần/ 01 tháng cho thang máy của bên A, Bên B đảm bảo thời gian trực 24/24h mỗi ngày tại trung tâm bảo hành thang máy và sẵn sàng đáp ứng kịp thời yêu cầu chỉnh sửa của bên A, Khi nhận được thông báo yêu cầu cảu bên A, Kỹ thuật viên của bên B sẽ có mặt trong thời gian sớm nhất để xác định sự cố và tiến hành sửa chữa</p>\n\n<p>CÁC ĐIỀU KHOẢN THƯƠNG MẠI: </p>\n\n<p>- Giao hàng: Thời gian giao hàng trong vòng 25 ngày kể từ ngày ký hợp đồng có hiệu lực</p>\n\n<p>- Địa điểm: Tại kho Bên A theo yêu cầu</p>\n\n<p>- Thanh toán: Thanh toán 100% giá trị đơn hàng sau 30 ngày kể từ khi bên bán bàn giao hàng hóa cùng các chứng từ liên quan.<br />\n                Đặt cọc 50% tổng giá trị hợp đồng kinh tế sau khi bên B thực hiện hoàn tất công việc bảo trì tháng thứ 6<br />\n                Đặt cọc 50% tổng giá trị hợp đồng kinh tế trong vòng 10 ngày sau khi bên bán thực hiện hoàn tất công việc bảo trì của tháng thứ 12</p>\n\n<p>Quý khách hàng xin vui lòng chuyển khoản vào thông tin sau:<br />\nTài khoản công ty:<br />\nChủ TK: Phạm Thành Long <br />\nSố TK: 98756543211 <br />\nNgân hàng Vietcombankk, chi nhánh Cầu Giấy </p>\n\n<p>Tài khoản cá nhân:<br />\nChủ TK: Phạm Thành Longg <br />\nSố TK: 9876543211 <br />\nNgân hàng Vietcombankk, chi nhánh Cầu Giấy </p>\n\n<p>Hiệu lực: Bảng chào giá có hiệu lực 30 ngày kể từ ngày ký báo giá</p>\n\n<p>Cảm ơn Quý khách hàng, mong sự cộng tác bền lâu!</p>\n\n<p  right;\">ĐẠI DIỆN NHÀ CUNG CẤP</p>\n', '2');
INSERT INTO `lifetek_quotes_contract` VALUES ('7', 'Hợp đồng hàng hóa', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Độc lập - Tự do - Hạnh phúc</strong></p>\n\n<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>{TITLE}</strong></h2>\n\n<p><em>Căn cứ Luật Thương mại đã được Quốc hội nước Cộng hòa xã hội chủ nghĩa Việt Nam khóa XI, kỳ họp thứ 7 thông qua ngày 14 tháng 6 năm 2005</em></p>\n\n<p><em>Căn cứ Bộ Luật Dân sự này đã được Quốc hội nước Cộng hòa xã hội chủ nghĩa Việt Nam khóa XI, kỳ họp thứ 7 thông qua ngày 14 tháng 6 năm 2005</em></p>\n\n<p><em>Căn cứ nhu cầu và khả năng cung cấp hai bên ký hợp đồng.</em></p>\n\n<table>\n <tbody>\n  <tr>\n   <td>\n   <p><strong>Bên A</strong></p>\n   </td>\n   <td>\n   <p>{TEN_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Địa chỉ</p>\n   </td>\n   <td>\n   <p>{DIA_CHI_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Điện thoại</p>\n   </td>\n   <td>\n   <p>{SDT_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Đại diện bởi:</p>\n   </td>\n   <td>\n   <p>(Ông/Bà) {DD_NCC}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chức vụ: {CHUCVU_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Số tài khoản:</p>\n   </td>\n   <td>\n   <p>{TKNH_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Tại ngân hàng:</p>\n   </td>\n   <td>\n   <p>{NH_NCC}</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<table>\n <tbody>\n  <tr>\n   <td>\n   <p><strong>Bên B</strong></p>\n   </td>\n   <td>\n   <p>{TEN_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Địa chỉ</p>\n   </td>\n   <td>\n   <p>{DIA_CHI_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Điện thoại</p>\n   </td>\n   <td>{SDT_KH}</td>\n  </tr>\n  <tr>\n   <td>\n   <p>Đại diện bởi:</p>\n   </td>\n   <td>\n   <p>(Ông/Bà) {DD_KH}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chức vụ: {CHUCVU_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Số tài khoản:</p>\n   </td>\n   <td>\n   <p>{TKNH_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Tại ngân hàng:</p>\n   </td>\n   <td>{NH_KH}</td>\n  </tr>\n </tbody>\n</table>\n\n<p><strong>ĐIỀU 1: NỘI DUNG HỢP ĐỒNG MUA BÁN</strong></p>\n\n<p>- Bên A đồng ý bán cho bên B</p>\n\n<p>{TABLE_DATA}</p>\n\n<p>ĐIỀU 3: GIAO HÀNG</p>\n\n<p>- Thời gian chuyển giao: Một ngày sau khi nhận được tiền</p>\n\n<p>- Hình thức chuyển giao: Nhân viên kĩ thuật sẽ hướng dẫn cài đặt hoặc trực tiếp xuống cài đặt và gửi file</p>\n\n<p>ĐIỀU 4: BẢO HÀNH VÀ TƯ VẤN</p>\n\n<p>- Bên B chịu trách nhiệm bảo hành sản phẩm trong vòng 12 tháng kể từ ngày ký kết hợp đồng chuyển giao.</p>\n\n<p>- &nbsp;Bên B chịu bảo hành các lỗi gặp phải khi vận hành phần mềm đúng như yêu cầu đặt hàng phần mềm của bên A</p>\n\n<p>- Bên B không chịu trách nhiệm bảo hành các lỗi do thiết bị phần cứng gây ra, các lỗi do người sử dụng vô tình hay cố ý gây ra khi vận hành phần mềm không đúng với tài liệu hướng dẫn sử dụng. Bên B không chịu trách nhiệm bảo hành tính pháp lý của số liệu kế toán trong phần mềm. Bên B không chịu trách nhiệm bảo hành phần mềm trong các trường hợp sự cố gây ra do thiên tai: lũ lụt, động đất, sét đánh, hỏa hoạn, mất trộm, mất điện …</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ĐẠI DIỆN BÊN A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ĐẠI DIỆN BÊN B</p>\n', '1');
INSERT INTO `lifetek_quotes_contract` VALUES ('9', 'Báo giá hàng hóa', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n <tbody>\n  <tr>\n   <td rowspan=\"3\">\n   <p>{LOGO}</p>\n   </td>\n   <td>\n   <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BẢNG B&Aacute;O GI&Aacute;</strong></p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>&nbsp;</p>\n\n   <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\n\n   <p><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ng&agrave;y </em>{DATE},<em> Th&aacute;ng&nbsp;</em>{MONTH}<em>, Năm&nbsp;</em>{YEAR}</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>&nbsp;</p>\n\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n <tbody>\n  <tr>\n   <td>\n   <p><strong>T&ecirc;n đơn vị</strong>(Company):</p>\n   </td>\n   <td>\n   <p>&nbsp;{TEN_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Họ t&ecirc;n Người mua h&agrave;ng</strong>(Customer&#39;s name):</p>\n   </td>\n   <td>\n   <p>{DD_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>M&atilde; số thuế</strong> (Tax Code):</p>\n   </td>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Địa chỉ</strong> (Address):</p>\n   </td>\n   <td>\n   <p>&nbsp;{DIA_CHI_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Số t&agrave;i khoản</strong> (Acount no):</p>\n   </td>\n   <td>\n   <p>{TKNH_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Tại ng&acirc;n h&agrave;ng</strong> (Bank&#39;s name):</p>\n   </td>\n   <td>\n   <p>{NH_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>H&igrave;nh thức TT</strong> (Payment of term):</p>\n   </td>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Gọi tắt l&agrave; b&ecirc;n A &nbsp; &nbsp; &nbsp;</p>\n   </td>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>&nbsp;</p>\n\n<hr />\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n <tbody>\n  <tr>\n   <td>\n   <p><strong>Đơn vị b&aacute;n h&agrave;ng</strong> &nbsp;(Sale Company):</p>\n   </td>\n   <td colspan=\"3\">\n   <p>{TEN_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Địa chỉ</strong> (Address):</p>\n   </td>\n   <td colspan=\"3\">\n   <p>{DIA_CHI_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Điện thoại</strong> (Tex/Fax):</p>\n   </td>\n   <td colspan=\"3\">\n   <p>{SDT_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Người b&aacute;o gi&aacute;</strong> (Salesman):</p>\n   </td>\n   <td colspan=\"3\">\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Quản l&yacute;</strong> (Manager):</p>\n   </td>\n   <td>\n   <p>&Ocirc;ng:&nbsp; {DD_NCC}</p>\n   </td>\n   <td>\n   <p>Điện thoại (Mob):</p>\n   </td>\n   <td>\n   <p>{SDT_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Gọi tắt l&agrave; b&ecirc;n B&nbsp; &nbsp; &nbsp;</p>\n   </td>\n   <td colspan=\"3\">\n   <p>Đơn vị tiền tệ (Unit currency): VNĐ&nbsp;&nbsp;</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>{TABLE_DATA}</p>\n\n<p>- Đơn gi&aacute; tr&ecirc;n đ&atilde; bao gồm thuế VAT</p>\n\n<p>- Bảo h&agrave;nh 12 th&aacute;ng kể từ ng&agrave;y k&yacute; bi&ecirc;n bản nghiệm thu h&agrave;ng h&oacute;a</p>\n\n<p>- Gi&aacute; tr&ecirc;n đ&atilde; bao gồm c&aacute;c loại thuế, chi ph&iacute; vận chuyển tại kho H&agrave; Nội, bảo hiểm, bảo h&agrave;nh trong thời gian ho&agrave;n th&agrave;nh...</p>\n\n<p><strong>Tr&aacute;ch nhiệm của b&ecirc;n A</strong></p>\n\n<p>Th&ocirc;ng b&aacute;o kịp thời cho b&ecirc;n B khi thang m&aacute;y bị sự cố, hư hỏng.</p>\n\n<p>Ngo&agrave;i thao t&aacute;c cứu hộ h&agrave;nh kh&aacute;ch ra khỏi ph&ograve;ng thang trong trường hợp khẩn cấp như đ&atilde; được hướng dẫn, b&ecirc;n A hoặc b&ecirc;n thứ ba kh&ocirc;ng được tự thực hiện bất kỳ c&ocirc;ng việc g&igrave; li&ecirc;n quan tới thiết bị thang m&aacute;y khi chưa c&oacute; sự đồng &yacute; bằng văn bản của b&ecirc;n B.</p>\n\n<p>Tạo điều kiện thuận lợi để b&ecirc;n B thực hiện c&ocirc;ng việc bảo h&agrave;nh, bảo dưỡng thang m&aacute;y.<br />\nK&yacute; x&aacute;c nhận v&agrave;o phiếu c&ocirc;ng t&aacute;c của b&ecirc;n B mỗi khi b&ecirc;n B thực hiện c&ocirc;ng việc bảo tr&igrave;, sửa chữa thang m&aacute;y.</p>\n\n<p><strong>Tr&aacute;ch nhiệm của b&ecirc;n B</strong></p>\n\n<p>Bảo dưỡng, bảo tr&igrave; định kỳ 01 lần/ 01 th&aacute;ng cho thang m&aacute;y của b&ecirc;n A, B&ecirc;n B đảm bảo thời gian trực 24/24h mỗi ng&agrave;y tại trung t&acirc;m bảo h&agrave;nh thang m&aacute;y v&agrave; sẵn s&agrave;ng đ&aacute;p ứng kịp thời y&ecirc;u cầu chỉnh sửa của b&ecirc;n A, khi nhận được th&ocirc;ng b&aacute;o y&ecirc;u cầu cảu b&ecirc;n A, Kỹ thuật vi&ecirc;n của b&ecirc;n B sẽ c&oacute; mặt trong thời gian sớm nhất để x&aacute;c định sự cố v&agrave; tiến h&agrave;nh sửa chữa.</p>\n\n<p><strong>C&Aacute;C ĐIỀU KHOẢN THƯƠNG MẠI:&nbsp;</strong></p>\n\n<p>- Giao h&agrave;ng: Thời gian giao h&agrave;ng trong v&ograve;ng 25 ng&agrave;y kể từ ng&agrave;y k&yacute; hợp đồng c&oacute; hiệu lực</p>\n\n<p>- Địa điểm: Tại kho B&ecirc;n A theo y&ecirc;u cầu</p>\n\n<p>- Thanh to&aacute;n: Thanh to&aacute;n 100% gi&aacute; trị đơn h&agrave;ng sau 30 ng&agrave;y kể từ khi b&ecirc;n b&aacute;n b&agrave;n giao h&agrave;ng h&oacute;a c&ugrave;ng c&aacute;c chứng từ li&ecirc;n quan.<br />\n&nbsp; &nbsp; &nbsp; + Đặt cọc 50% tổng gi&aacute; trị hợp đồng kinh tế sau khi b&ecirc;n B thực hiện ho&agrave;n tất c&ocirc;ng việc bảo tr&igrave; th&aacute;ng thứ 6.<br />\n&nbsp; &nbsp; &nbsp; + Đặt cọc 50% tổng gi&aacute; trị hợp đồng kinh tế trong v&ograve;ng 10 ng&agrave;y sau khi b&ecirc;n b&aacute;n thực hiện ho&agrave;n tất c&ocirc;ng việc bảo tr&igrave; của th&aacute;ng thứ 12.</p>\n\n<p><strong>Qu&yacute; kh&aacute;ch h&agrave;ng xin vui l&ograve;ng chuyển khoản v&agrave;o th&ocirc;ng tin sau:<br />\nT&agrave;i khoản c&ocirc;ng ty:<br />\nChủ TK: Phạm Th&agrave;nh Long&nbsp;<br />\nSố TK: 98756543211&nbsp;<br />\nNg&acirc;n h&agrave;ng Vietcombankk, chi nh&aacute;nh Cầu Giấy&nbsp;</strong></p>\n\n<p><strong>T&agrave;i khoản c&aacute; nh&acirc;n:<br />\nChủ TK: Phạm Th&agrave;nh Longg&nbsp;<br />\nSố TK: 9876543211&nbsp;<br />\nNg&acirc;n h&agrave;ng Vietcombankk, chi nh&aacute;nh Cầu Giấy&nbsp;</strong></p>\n\n<p><strong>Hiệu lực: Bảng ch&agrave;o gi&aacute; c&oacute; hiệu lực 30 ng&agrave;y kể từ ng&agrave;y k&yacute; b&aacute;o gi&aacute;</strong></p>\n\n<p>Cảm ơn Qu&yacute; kh&aacute;ch h&agrave;ng, mong sự cộng t&aacute;c bền l&acirc;u!</p>\n\n<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ĐẠI DIỆN NH&Agrave; CUNG CẤP</strong></p>\n', '2');
INSERT INTO `lifetek_quotes_contract` VALUES ('16', 'Hợp đồng kinh tế', '<p  center;\"><strong>CỘNG HO&Agrave; X&Atilde; HỘI CHỦ NGHĨA VIỆT NAM</strong></p>\n\n<p  center;\">Độc lập - Tự do - Hạnh ph&uacute;c</p>\n\n<p  center;\">-------------oOo-----------</p>\n\n<p  center;\">&nbsp;</p>\n\n<p  center;\"><strong>HỢP ĐỒNG KINH TẾ</strong></p>\n\n<p  center;\"><em>Số: ........../ 20&hellip;/ HĐKT</em></p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;&nbsp;&nbsp;- Căn cứ Bộ luật D&acirc;n sự số 33/2005/QH11 ng&agrave;y 14/6/2005 của nước Cộng h&ograve;a x&atilde; hội chủ nghĩa Việt nam;</p>\n\n<p>- Căn cứ v&agrave;o Luật Thương Mại số 36/2005/QH11 ng&agrave;y 14/6/2005 của nước Cộng h&ograve;a x&atilde; hội chủ nghĩa Việt nam;</p>\n\n<p>- Căn cứ v&agrave;o nhu cầu, khả năng của hai b&ecirc;n.</p>\n\n<p>H&ocirc;m nay, ng&agrave;y &hellip;.. &nbsp;th&aacute;ng &hellip;.năm 2015&nbsp; Ch&uacute;ng t&ocirc;i gồm:</p>\n\n<p><strong>B&ecirc;n A:&nbsp;&nbsp; </strong>{TEN_NCC}</p>\n\n<ul>\n <li>Địa chỉ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{DIA_CHI_NCC}</li>\n <li>Điện thoại&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{SDT_NCC}</li>\n <li>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</li>\n <li>CMTND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; &nbsp;&hellip;&hellip;&hellip;&hellip;CA Th&agrave;nh phố &hellip;&hellip;&hellip;&hellip;.&hellip; cấp ng&agrave;y&hellip;&hellip;&hellip;&hellip;..&hellip;..</li>\n</ul>\n\n<p><strong>B&ecirc;n B:&nbsp;&nbsp; C&ocirc;ng ty TNHH C&ocirc;ng Nghệ Tự Động H&oacute;a Minh Anh.</strong></p>\n\n<ul>\n <li>Địa chỉ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; Số 23 ng&otilde; 389/4 Ho&agrave;ng Quốc Việt &ndash; Quận Cầu Giấy -&nbsp; H&agrave; Nội.</li>\n <li>Điện thoại&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; +84 4&ndash;378 5885.</li>\n <li>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; +84 4&ndash;378 5885.</li>\n <li>M&atilde; số thuế &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; 0101130774.</li>\n <li>Đại diện bởi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; &Ocirc;ng &nbsp;<strong>Nguyễn Xu&acirc;n Giang</strong></li>\n <li>Chức vụ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; Ph&oacute; Gi&aacute;m đốc</li>\n <li>T&agrave;i khoản số&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; 10820962715015</li>\n <li>Tại Ng&acirc;n h&agrave;ng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; Ng&acirc;n h&agrave;ng TMCP Kỹ Thương &ndash; CN Ho&agrave;n Kiếm &ndash; H&agrave; Nội</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p>Tại Trụ sở b&ecirc;n A, hai b&ecirc;n thỏa thuận k&yacute; kết hợp đồng kinh tế n&agrave;y với c&aacute;c điều khoản sau:</p>\n\n<p><strong><em><u>Điều 1:</u></em></strong><strong><em> Nội dung c&ocirc;ng việc</em></strong></p>\n\n<p>1.1. B&ecirc;n B nhận cung cấp bằng nhập khẩu cho b&ecirc;n A&nbsp; &hellip;&hellip; ( &hellip;.. ) thang m&aacute;y tải kh&aacute;ch (m&atilde; hiệu &hellip;&hellip;&hellip;..), tải trọng &hellip;..kg (&hellip;.. người ), tốc độ &hellip;&hellip; m/ph&uacute;t, &hellip;.. điểm dừng , xuất xứ &hellip;&hellip;&hellip;, mới 100%, sản xuất năm &hellip;&hellip;. trở về sau.</p>\n\n<p><em>(Theo Bản Phụ lục Hợp đồng 1)</em></p>\n\n<p>1.2. Cung cấp vật tư lắp đặt v&agrave; lắp đặt ho&agrave;n chỉnh thang m&aacute;y tr&ecirc;n tại c&ocirc;ng tr&igrave;nh :</p>\n\n<p>&ldquo;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&rdquo;</p>\n\n<p><strong><em><u>Điều 2:</u></em></strong><strong><em> Tr&aacute;ch nhiệm của b&ecirc;n A</em></strong></p>\n\n<ul>\n <li>X&acirc;y dựng, hiệu chỉnh hố thang đảm bảo c&aacute;c th&ocirc;ng số kỹ thuật cho việc lắp đặt thang m&aacute;y theo bản vẽ kỹ thuật hố thang do b&ecirc;n B cung cấp.</li>\n <li>Chậm nhất l&agrave; trong v&ograve;ng 5 ng&agrave;y kể từ ng&agrave;y b&ecirc;n B chuyển bản vẽ kỹ thuật, b&ecirc;n A phải k&yacute; x&aacute;c nhận v&agrave;o bản vẽ kỹ thuật sau khi đ&atilde; thống nhất để B&ecirc;n B đặt h&agrave;ng với H&atilde;ng sản xuất. Qu&aacute; thời hạn tr&ecirc;n coi như b&ecirc;n A đ&atilde; đồng &yacute; với bản vẽ kỹ thuật m&agrave; b&ecirc;n B đ&atilde; chuyển để hai b&ecirc;n thực hiện c&ocirc;ng việc.</li>\n <li>B&ecirc;n A giao đầy đủ hồ sơ thiết kế li&ecirc;n quan đến hố thang m&aacute;y cho B&ecirc;n B.</li>\n <li>Cử c&aacute;n bộ c&oacute; tr&aacute;ch nhiệm phối hợp c&ugrave;ng b&ecirc;n B tham gia kiểm tra v&agrave; k&yacute; x&aacute;c nhận thiết bị thang m&aacute;y khi l&ocirc; thiết bị được chuyển về ch&acirc;n c&ocirc;ng tr&igrave;nh. Nếu tại thời điểm h&agrave;ng về ch&acirc;n c&ocirc;ng tr&igrave;nh, b&ecirc;n A kh&ocirc;ng bố tr&iacute; được người kiểm tra, b&ecirc;n B vẫn vận chuyển l&ocirc; thiết bị tr&ecirc;n v&agrave;o kho v&agrave; l&ocirc; thiết bị tr&ecirc;n coi như đ&atilde; được kiểm tra đầy đủ, đ&uacute;ng theo danh mục hồ sơ thang m&aacute;y k&egrave;m theo.</li>\n <li>Bố tr&iacute; kho chứa thiết bị an to&agrave;n tại tầng một khi b&ecirc;n B vận chuyển thiết bị đến c&ocirc;ng tr&igrave;nh v&agrave; đảm bảo an ninh cho kho chứa thiết bị thang m&aacute;y tại c&ocirc;ng tr&igrave;nh.</li>\n <li>B&agrave;n giao mặt bằng đủ điều kiện để thi c&ocirc;ng lắp đặt cho b&ecirc;n B đ&uacute;ng tiến độ.</li>\n <li>Cung cấp điểm đấu nối nguồn điện để thi c&ocirc;ng, lắp đặt thang m&aacute;y trong khu vực thi c&ocirc;ng.</li>\n <li>Cung cấp nguồn điện 3 phase 380V/220V v&agrave; 01 Aptomat 3 phase /1 thang v&agrave; điểm đấu nối d&acirc;y tiếp địa tại ph&ograve;ng đặt m&aacute;y để b&ecirc;n B hiệu chỉnh thang m&aacute;y .</li>\n <li>B&ecirc;n A cử c&aacute;n bộ kỹ thuật thường xuy&ecirc;n phối hợp c&ugrave;ng b&ecirc;n B trong suốt qu&aacute; tr&igrave;nh thi c&ocirc;ng lắp đặt để giải quyết kịp thời c&aacute;c c&ocirc;ng việc trong qu&aacute; tr&igrave;nh thực hiện hợp đồng.</li>\n <li>&nbsp;Tổ chức nghiệm thu, k&yacute; bi&ecirc;n bản nghiệm thu giai đoạn (nếu c&oacute;) v&agrave; nghiệm thu b&agrave;n giao kịp thời khi b&ecirc;n B ho&agrave;n tất c&ocirc;ng việc.</li>\n <li>Thực hiện phần việc x&acirc;y dựng ho&agrave;n thiện sau khi b&ecirc;n B ho&agrave;n tất lắp đặt thiết bị thang m&aacute;y.</li>\n <li>Tạm ứng v&agrave; thanh to&aacute;n kịp thời cho B&ecirc;n B theo điều 6 của Hợp đồng.</li>\n</ul>\n\n<p><strong><em><u>Điều 3:</u></em></strong><strong><em> Tr&aacute;ch nhiệm của b&ecirc;n B</em></strong></p>\n\n<ul>\n <li>Khảo s&aacute;t v&agrave; thiết kế bản vẽ hố thang theo ti&ecirc;u chuẩn v&agrave; chuyển cho b&ecirc;n A k&yacute; x&aacute;c nhận l&agrave;m cơ sở đặt h&agrave;ng với H&atilde;ng sản xuất v&agrave; thực hiện c&aacute;c c&ocirc;ng việc li&ecirc;n quan.</li>\n <li>Nhập khẩu thiết bị thang m&aacute;y theo c&aacute;c th&ocirc;ng số kỹ thuật của Phụ lục số 01 về đặc t&iacute;nh kỹ thuật thang m&aacute;y.</li>\n <li>Trước khi vận chuyển thiết bị về c&ocirc;ng tr&igrave;nh, b&ecirc;n B c&oacute; tr&aacute;ch nhiệm th&ocirc;ng b&aacute;o cho b&ecirc;n A ng&agrave;y thiết bị về đến c&ocirc;ng tr&igrave;nh để b&ecirc;n A bố tr&iacute; kho chứa thiết bị tại c&ocirc;ng tr&igrave;nh.</li>\n <li>Vận chuyển thiết bị đến c&ocirc;ng tr&igrave;nh, &nbsp;phối hợp c&ugrave;ng với đại diện của b&ecirc;n A kiểm tra v&agrave; k&yacute; x&aacute;c nhận v&agrave;o c&aacute;c bi&ecirc;n bản.</li>\n <li>Cung cấp vật tư &nbsp;lắp đặt v&agrave; lắp đặt, hiệu chỉnh, đưa thang m&aacute;y v&agrave;o sử dụng.</li>\n <li>C&oacute; tr&aacute;ch nhiệm mời cơ quan c&oacute; chức năng, tổ chức kiểm định - cung cấp Bi&ecirc;n bản kiểm định kỹ thuật an to&agrave;n thang m&aacute;y của cơ quan Nh&agrave; nước c&oacute; thẩm quyền đủ điều kiện an to&agrave;n sử dụng b&agrave;n giao cho b&ecirc;n A.</li>\n <li>C&oacute; tr&aacute;ch nhiệm quản l&yacute;, đảm bảo an ninh, an to&agrave;n trong qu&aacute; tr&igrave;nh thi c&ocirc;ng tr&ecirc;n c&ocirc;ng tr&igrave;nh v&agrave; giữ g&igrave;n vệ sinh m&ocirc;i trường trong suốt thời gian thi c&ocirc;ng.</li>\n <li>Đảm bảo v&agrave; chịu tr&aacute;ch nhiệm về c&aacute;c điều kiện an to&agrave;n cho con người, an ninh trong khu vực thi c&ocirc;ng theo quy định chung.</li>\n <li>Hướng dẫn c&aacute;ch sử dụng vận h&agrave;nh thang m&aacute;y cho b&ecirc;n A.</li>\n <li>B&ecirc;n B c&oacute; tr&aacute;ch nhiệm bảo h&agrave;nh c&ocirc;ng tr&igrave;nh theo quy định tại điều 7 của Hợp đồng kinh tế.</li>\n</ul>\n\n<p><strong><em><u>Điều 4:</u></em></strong><strong><em> Tiến độ thực hiện được b&ecirc;n B thực hiện như sau:&nbsp; </em></strong></p>\n\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n <tbody>\n  <tr>\n   <td>\n   <p>4.1 Thời gian thiết bị thang m&aacute;y đ&shy;ược nhập khẩu v&agrave; vận chuyển đến c&ocirc;ng tr&igrave;nh kể từ ng&agrave;y b&ecirc;n B nhận được kinh ph&iacute; tạm ứng kỳ 1 v&agrave; b&ecirc;n A x&aacute;c nhận v&agrave;o bản vẽ kỹ thuật hố thang l&agrave;: &hellip;. th&aacute;ng</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>4.2 Thời gian lắp đặt, hiệu chỉnh được thực hiện khi b&ecirc;n B nhận được kinh ph&iacute; thanh to&aacute;n kỳ 2, b&ecirc;n A b&agrave;n giao mặt bằng đầy đủ điều kiện thi c&ocirc;ng v&agrave; k&yacute; bi&ecirc;n bản nghiệm thu thiết bị trước khi lắp đặt l&agrave;: &hellip;.. ng&agrave;y</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>-&nbsp;&nbsp; Tiến độ tr&ecirc;n chỉ được thực hiện với c&aacute;c điều kiện sau:</p>\n\n<ul>\n <li>B&ecirc;n A thanh to&aacute;n đ&uacute;ng thời hạn v&agrave; gi&aacute; trị đ&atilde; ghi ở điều 5 v&agrave; điều 6 hợp đồng n&agrave;y.</li>\n <li>C&aacute;c chi tiết kỹ thuật của thang m&aacute;y phải được b&ecirc;n A thống nhất trước khi k&yacute; kết hợp đồng kinh tế. Trong trường hợp c&oacute; những thay đổi về chi tiết kỹ thuật của thang m&aacute;y từ ph&iacute;a b&ecirc;n A như bổ sung, bỏ bớt hoặc điều chỉnh th&igrave; hai b&ecirc;n thống thất bằng một văn bản hoặc phụ lục hợp đồng bổ sung để hiệu chỉnh gi&aacute; trị hợp đồng v&agrave; tiến độ thực hiện nhưng thời gian cho việc thay đổi trong v&ograve;ng 30 ng&agrave;y kể từ ng&agrave;y hợp đồng c&oacute; hiệu lực.</li>\n <li>Việc lắp đặt thang m&aacute;y chỉ được tiến h&agrave;nh sau khi điều 4.2 đ&atilde; được thực hiện .</li>\n</ul>\n\n<p><strong><em><u>Điều 5:</u></em></strong><strong><em>&nbsp; Gi&aacute; trị của hợp đồng kinh tế </em></strong></p>\n\n<ul>\n <li>Gi&aacute; trị hợp đồng kinh tế cung cấp lắp đặt thang m&aacute;y l&agrave;: khoản tiền VNĐ c&oacute; gi&aacute; trị bảo đảm tương đương: <strong>&hellip;&hellip;&hellip;&hellip;.. VND <em>(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.. VND</em></strong>) <strong>.</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>\n</ul>\n\n<p><strong><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;( Bằng chữ: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;. )</em></strong></p>\n\n<ul>\n <li><em>Gi&aacute; trị hợp đồng tr&ecirc;n đ&atilde; bao gồm: gi&aacute; thiết bị thang m&aacute;y nhập khẩu về tới ch&acirc;n c&ocirc;ng tr&igrave;nh, vật tư lắp đặt, chi ph&iacute; lắp đặt, hiệu chỉnh, tổ chức kiểm định thang m&aacute;y cấp giấy chứng nhận thang m&aacute;y đủ điểu kiện an to&agrave;n sử dụng, chi ph&iacute; bảo h&agrave;nh &nbsp;v&agrave; thuế GTGT.</em></li>\n</ul>\n\n<p><strong><em><u>Điều 6:</u></em></strong><strong><em> Ph&shy;ương thức thanh to&aacute;n </em></strong></p>\n\n<ul>\n <li>B&ecirc;n A tạm ứng, thanh to&aacute;n cho b&ecirc;n B theo c&aacute;c kỳ nh&shy;ư sau:</li>\n</ul>\n\n<ul>\n <li><u>Kỳ 1: </u>Tạm ứng <strong>40</strong>% tổng gi&aacute; trị hợp đồng kinh tế ngay sau khi Hợp đồng kinh tế được k&yacute; kết.</li>\n</ul>\n\n<ul>\n <li><u>Kỳ 2:</u> Thanh to&aacute;n 5<strong>0%</strong> tổng gi&aacute; trị hợp đồng kinh tế - kh&ocirc;ng bao gồm gi&aacute; trị đ&atilde; tạm ứng kỳ 1 - trong v&ograve;ng 7 ng&agrave;y sau khi thiết bị thang m&aacute;y đ&shy;ược chuyển đến ch&acirc;n c&ocirc;ng tr&igrave;nh.</li>\n <li><u>Kỳ 3:</u> Thanh to&aacute;n phần c&ograve;n lại của tổng gi&aacute; trị hợp đồng trong v&ograve;ng 10 ng&agrave;y kể từ ng&agrave;y b&ecirc;n B ho&agrave;n tất việc lắp đặt v&agrave; thang m&aacute;y được kiểm định an to&agrave;n.</li>\n</ul>\n\n<ul>\n <li>Tr&shy;ường hợp b&ecirc;n A kh&ocirc;ng thực hiện đầy đủ nghĩa vụ thanh to&aacute;n như&shy; đ&atilde; thống nhất ở tr&ecirc;n, b&ecirc;n B c&oacute; quyền ngừng thực hiện c&aacute;c c&ocirc;ng việc li&ecirc;n quan đến thang m&aacute;y cho đến khi b&ecirc;n A ho&agrave;n th&agrave;nh nghĩa vụ thanh to&aacute;n của m&igrave;nh v&agrave; đền b&ugrave; những thiệt hại cho b&ecirc;n B theo l&atilde;i suất qu&aacute; hạn cho vay của Ng&acirc;n h&agrave;ng b&ecirc;n B mở t&agrave;i khoản.</li>\n <li>Trong trường hợp b&ecirc;n B đ&atilde; ho&agrave;n th&agrave;nh to&agrave;n bộ c&ocirc;ng việc theo như hợp đồng kinh tế đ&atilde; k&yacute; kết m&agrave; b&ecirc;n A chưa c&oacute; nguồn điện ch&iacute;nh thức để sử dụng thang m&aacute;y, hoặc chưa c&oacute; nhu cầu sử dụng th&igrave; tr&aacute;ch nhiệm của b&ecirc;n A l&agrave; phải ho&agrave;n th&agrave;nh nghĩa vụ thanh to&aacute;n to&agrave;n bộ gi&aacute; trị hợp đồng cho b&ecirc;n B để b&ecirc;n B quyết to&aacute;n hợp đồng v&agrave; thực hiện nghĩa vụ nộp thuế theo quy định của Nh&agrave; nước.</li>\n</ul>\n\n<p><strong><em><u>Điều 7 :</u></em></strong><strong><em> Bảo h&agrave;nh v&agrave; Bảo tr&igrave;</em></strong></p>\n\n<ul>\n <li>B&ecirc;n B c&oacute; tr&aacute;ch nhiệm bảo h&agrave;nh thiết bị trong thời hạn 12 th&aacute;ng kể từ ng&agrave;y thang m&aacute;y được kiểm định an to&agrave;n. Nếu trong thời gian bảo h&agrave;nh m&agrave; thang m&aacute;y bị hư hỏng, nhận được th&ocirc;ng b&aacute;o của b&ecirc;n A trong thời gian sớm nhất b&ecirc;n B phải cử người đến xử l&yacute; v&agrave; chịu mọi ph&iacute; tổn sửa chữa nếu xảy ra sự cố kỹ thuật do lỗi của nh&agrave; sản xuất hoặc do lỗi kh&aacute;c của b&ecirc;n B.</li>\n <li>B&ecirc;n B c&oacute; tr&aacute;ch nhiệm lập quy tr&igrave;nh bảo tr&igrave; cho c&ocirc;ng tr&igrave;nh khi hết thời hạn bảo h&agrave;nh v&agrave; hai b&ecirc;n sẽ thương thảo, k&yacute; kết hợp đồng bảo tr&igrave; cho c&ocirc;ng tr&igrave;nh.</li>\n</ul>\n\n<p><strong><em><u>Điều 8:</u></em></strong><strong><em>&nbsp; Hiệu lực hợp đồng </em></strong></p>\n\n<ul>\n <li>Hợp đồng kinh tế n&agrave;y c&oacute; hiệu lực kể từ ng&agrave;y k&yacute; v&agrave; kh&ocirc;ng đư&shy;ợc hủy ngang, nếu b&ecirc;n n&agrave;o vi phạm th&igrave; sẽ đền b&ugrave; cho b&ecirc;n c&ograve;n lại 20% gi&aacute; trị Hợp đồng kinh tế.</li>\n <li>Hai b&ecirc;n cam kết thực hiện đ&uacute;ng c&aacute;c điều khoản ghi trong hợp đồng kinh tế. Khi c&oacute; &nbsp;vướng mắc hai b&ecirc;n c&ugrave;ng trao đổi để khắc phục. Nếu kh&ocirc;ng giải quyết được bằng thương lượng th&igrave; một trong hai b&ecirc;n sẽ đưa ra To&agrave; &aacute;n Nh&acirc;n d&acirc;n c&oacute; thẩm quyền thuộc th&agrave;nh phố H&agrave; Nội để giải quyết. Ph&aacute;n quyết của To&agrave; &aacute;n Nh&acirc;n d&acirc;n c&oacute; thẩm quyền thuộc th&agrave;nh phố H&agrave; Nội l&agrave; ph&aacute;n quyết cuối c&ugrave;ng để hai b&ecirc;n thực hiện, mọi chi ph&iacute; ph&aacute;t sinh v&agrave; &aacute;n ph&iacute; do b&ecirc;n c&oacute; lỗi chịu tr&aacute;ch nhiệm thanh to&aacute;n.</li>\n <li>Hợp đồng n&agrave;y đ&shy;ược lập th&agrave;nh &hellip;.. bản, mỗi b&ecirc;n giữ &hellip;. bản v&agrave; c&oacute; gi&aacute; trị ph&aacute;p l&yacute; nh&shy;ư nhau.</li>\n</ul>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ĐẠI DIỆN B&Ecirc;N A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;ĐẠI DIỆN B&Ecirc;N B</strong></p>\n\n<p>&nbsp;</p>\n', '1');
INSERT INTO `lifetek_quotes_contract` VALUES ('17', 'HỢP ĐỒNG KINH TẾ', '<p>&nbsp;</p>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CỘNG H&Ograve;A X&Atilde; HỘI CHỦ NGHĨA VIỆT NAM</strong></p>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Độc lập &ndash; Tự do &ndash; Hạnh ph&uacute;c</p>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; ----------&amp;&amp;&amp;---------</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {TITLE}</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số: {CODE}/2015/HĐKT/VD</p>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Về việc: Cung cấp v&agrave; lắp đặt cửa nhựa l&otilde;i th&eacute;p UPVC, cửa cuốn tại </strong></p>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nh&agrave; m&aacute;y NANO SMART MATERIAL</strong></p>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; (Địa chỉ: &nbsp;Cụm CN Hợp Thịnh huyện Hiệp H&ograve;a tỉnh Bắc Giang )</p>\n\n<p>- Căn cứ Bộ Luật d&acirc;n sự được Quốc hội nước CHXHCN Việt Nam kh&oacute;a XI kỳ họp thứ 7 th&ocirc;ng qua ng&agrave;y 14/6/2005;</p>\n\n<p>- Căn cứ luật thương mại số 36/2005/QH11 được Quốc hội nước CHXHCN Việt Nam kh&oacute;a XI kỳ họp thứ 7 th&ocirc;ng qua ng&agrave;y 14/6/2005;</p>\n\n<p>- &nbsp;Nhu cầu v&agrave; khả năng đ&aacute;p ứng của c&aacute;c b&ecirc;n;</p>\n\n<p>H&ocirc;m nay, Ng&agrave;y&nbsp; {DATE} Th&aacute;ng&nbsp; {MONTH} Năm&nbsp; {YEAR}, tại {TEN_NCC}, ch&uacute;ng t&ocirc;i gồm:</p>\n\n<p><strong>B&ecirc;n A:&nbsp;</strong>{TEN_KH}</p>\n\n<p>Địa chỉ:&nbsp;{DIA_CHI_KH}</p>\n\n<p>Số điện thoại: {SDT_KH}</p>\n\n<p>Đai diện:&nbsp;{DD_KH}</p>\n\n<p>Chức vụ: {CHUCVU_KH}</p>\n\n<p>T&agrave;i khoản ng&acirc;n h&agrave;ng: {TKNH_KH}</p>\n\n<p><strong>B&ecirc;n B:<em>&nbsp; </em></strong>{TEN_NCC}</p>\n\n<p>Địa Chỉ: {DIA_CHI_NCC}</p>\n\n<p>Số điện thoại:&nbsp;{SDT_NCC}</p>\n\n<p>Đại diện:{DD_NCC}</p>\n\n<p>Chức vụ: {CHUCVU_NCC}</p>\n\n<p>T&agrave;i khoản ng&acirc;n h&agrave;ng: {TKNH_NCC}</p>\n\n<p>- Hai B&ecirc;n A v&agrave; B&ecirc;n B c&ugrave;ng thoả thuận, thống nhất v&agrave; k&yacute; kết hợp đồng kinh tế về việc: Cung cấp v&agrave; lắp đặt hệ thống cửa nhựa l&otilde;i th&eacute;p UPVC, cửa cuốn tại Nh&agrave; m&aacute;y NANO SMART MATERIAL (Địa chỉ: Cụm CN Hợp Thịnh huyện Hiệp H&ograve;a tỉnh Bắc Giang). Với những điều khoản sau đ&acirc;y:</p>\n\n<p><strong><u>ĐIỀU 1</u></strong>: <strong>ĐỊNH NGHĨA</strong></p>\n\n<ul>\n <li>Hợp đồng kinh tế: L&agrave; bản hợp đồng n&agrave;y được k&yacute; giữa b&ecirc;n giao thầu v&agrave; b&ecirc;n nhận thầu kể cả c&aacute;c phụ lục, c&aacute;c văn bản k&egrave;m theo v&agrave; c&aacute;c văn bản được đưa v&agrave;o tham chiếu.</li>\n <li>Gi&aacute; trị hợp đồng: L&agrave; gi&aacute; trị được b&ecirc;n giao thầu v&agrave; b&ecirc;n nhận thầu thoả thuận sau khi thương thảo ho&agrave;n thiện hợp đồng v&agrave; được cụ thể ho&aacute; tại điều 2 của hợp đồng n&agrave;y.</li>\n <li>H&agrave;ng ho&aacute; - dịch vụ: L&agrave; vật tư v&agrave; nh&acirc;n c&ocirc;ng cung cấp cho b&ecirc;n giao thầu được cụ thể trong điều 2 của hợp đồng n&agrave;y.</li>\n</ul>\n\n<p><strong><u>ĐIỀU 2</u></strong>: <strong>NỘI DUNG, GI&Aacute; TRỊ HỢP ĐỒNG.</strong></p>\n\n<p><strong>2.1 Nội dung:</strong></p>\n\n<p>B&ecirc;n A đồng &yacute; thu&ecirc; b&ecirc;n B cung cấp vật tư v&agrave; lắp đặt cửa nhựa l&otilde;i th&eacute;p tại Nh&agrave; m&aacute;y&nbsp; NANO SMART MATERIAL (Địa chỉ: Cụm CN Hợp Thịnh huyện Hiệp H&ograve;a tỉnh Bắc Giang). theo y&ecirc;u cầu của b&ecirc;n A.</p>\n\n<p>{TABLE_DATA}</p>\n\n<p>- Gi&aacute; trị hợp đồng tr&ecirc;n đ&atilde; bao gồm thuế VAT 10%.</p>\n\n<p>- H&igrave;nh thức hợp đồng: Hợp đồng theo đơn gi&aacute; cố định.</p>\n\n<p>- Trong tr&shy;&ecirc;ng h&icirc;p ph&cedil;t sinh kh&egrave;i l&shy;&icirc;ng, hai b&ordf;n s&Iuml; ti&Otilde;n h&micro;nh b&aelig; sung b&raquo;ng ph&ocirc; l&ocirc;c h&icirc;p &reg;&aring;ng.</p>\n\n<p>- Gi&cedil; tr&THORN; h&icirc;p &reg;&aring;ng l&micro; gi&cedil; tr&THORN; t&sup1;m t&Yacute;nh. Gi&cedil; tr&THORN; quy&Otilde;t to&cedil;n c&ntilde;a h&icirc;p &reg;&aring;ng &reg;&shy;&icirc;c x&cedil;c &reg;&THORN;nh tr&ordf;n c&not; s&euml; kh&egrave;i l&shy;&icirc;ng th&ugrave;c t&Otilde; b&ordf;n B c&Ecirc;p &reg;&shy;&icirc;c cho b&ordf;n A (&reg;&shy;&icirc;c hai b&ordf;n k&yacute; x&cedil;c nh&Euml;n).</p>\n\n<p>&nbsp;</p>\n\n<p><strong><u>ĐIỀU 3:</u></strong><strong> PHƯƠNG THỨC THANH TO&Aacute;N</strong></p>\n\n<ul>\n <li>To&agrave;n bộ gi&aacute; trị hợp đồng được thanh to&aacute;n bằng Đồng Việt Nam</li>\n <li>H&igrave;nh thức thanh to&aacute;n: Thanh to&aacute;n bằng chuyển khoản.</li>\n <li>Thời hạn thanh to&aacute;n: Ngay khi hợp đồng kinh tế được k&yacute;.</li>\n</ul>\n\n<ul>\n <li><strong><em>Lần I:</em></strong> Tạm ứng 40% gi&aacute; trị hợp đồng tương đương <strong>120.000.000 VNĐ.</strong></li>\n <li><strong><em>Lần II:</em></strong> Thanh to&aacute;n 100% gi&aacute; trị hợp đồng sau khi nghiệm thu c&ocirc;ng tr&igrave;nh trong v&ograve;ng 07 ng&agrave;y.</li>\n</ul>\n\n<p><strong><u>ĐIỀU 4</u></strong>: <strong>TI&Ecirc;U CHUẨN KỸ THUẬT -</strong> <strong>TIẾN ĐỘ THI C&Ocirc;NG</strong></p>\n\n<ul>\n <li>B&ecirc;n B chịu tr&aacute;ch nhiệm thi c&ocirc;ng theo đ&uacute;ng hồ sơ thiết kế, y&ecirc;u cầu kỹ thuật đ&atilde; được chủ đầu tư c&ocirc;ng tr&igrave;nh ph&ecirc; duyệt dưới sự gi&aacute;m s&aacute;t trực tiếp của b&ecirc;n A cũng như phải đảm bảo chất lượng theo c&aacute;c ti&ecirc;u chuẩn v&agrave; quy định của ph&aacute;p luật Việt nam.</li>\n <li>B&ecirc;n B phải thi c&ocirc;ng theo đ&uacute;ng tập bản vẽ đ&atilde; tr&igrave;nh b&ecirc;n A v&agrave; được coi l&agrave; 1 bộ hồ sơ c&oacute; gi&aacute; trị thực hiện đ&iacute;nh k&egrave;m hợp đồng n&agrave;y.</li>\n <li>Ti&ecirc;u chuẩn thanh nhựa: SPARLEE PROFILE</li>\n <li>Ti&ecirc;u chuẩn phụ kiện: GQ (GOLKING); VVP Th&aacute;i Lan</li>\n <li>Ti&ecirc;u chuẩn k&iacute;nh: K&iacute;nh nổi Việt Nhật (VFG)</li>\n <li>To&agrave;n bộ khối lượng tại điều 2 sẽ được b&ecirc;n B thực hiện ho&agrave;n th&agrave;nh trong v&ograve;ng 30 ng&agrave;y kể từ ng&agrave;y nhận được tiền tạm ứng v&agrave; mặt bằng thi c&ocirc;ng.</li>\n <li>Trong trường hợp bất khả kh&aacute;ng như: Chiến tranh, động đất, mưa b&atilde;o, mất điện.... hoặc c&aacute;c nguy&ecirc;n nh&acirc;n do b&ecirc;n A hoặc b&ecirc;n chủ đầu tư th&igrave; thời gian thi c&ocirc;ng được gia hạn th&ecirc;m.</li>\n</ul>\n\n<p><strong><u>ĐIỀU </u></strong><strong><u>5</u></strong><strong><u>:</u></strong><strong> PHẠT CHẬM </strong><strong>TIẾN ĐỘ </strong><strong>V&Agrave;</strong> <strong>THANH TO&Aacute;N</strong></p>\n\n<ul>\n <li>Nếu một trong hai b&ecirc;n đơn phương huỷ bỏ hợp đồng đ&atilde; k&yacute; m&agrave; kh&ocirc;ng c&oacute; sự đồng &yacute; của cả 2 b&ecirc;n th&igrave; b&ecirc;n huỷ phải thanh to&aacute;n tiền phạt vi phạm hợp đồng cho ph&iacute;a b&ecirc;n kia với mức phạt l&agrave; 30% tổng gi&aacute; trị hợp đồng.</li>\n <li>B&ecirc;n B đảm bảo tiến độ thi c&ocirc;ng thực hiện hợp đồng đ&uacute;ng tiến độ. Chậm tiến độ thi c&ocirc;ng do lỗi của b&ecirc;n B (trừ trường hợp do bất khả kh&aacute;ng) th&igrave; b&ecirc;n B phải nộp phạt 5% gi&aacute; trị hợp đồng cho tuần chậm thi c&ocirc;ng đầu ti&ecirc;n, 0,2% gi&aacute; trị hợp đồng cho ng&agrave;y tiếp theo nhưng tổng số tiền phạt kh&ocirc;ng được vượt qu&aacute; 10%.</li>\n <li>B&ecirc;n B thi c&ocirc;ng chậm tiến độ do c&aacute;c nguy&ecirc;n nh&acirc;n của b&ecirc;n A như: chậm tạm ứng theo điều 3, chậm b&agrave;n giao mặt bằng, th&igrave; b&ecirc;n B sẽ được t&iacute;nh th&ecirc;m tương đương số ng&agrave;y chậm đ&oacute; v&agrave;o tiến độ thi c&ocirc;ng.</li>\n <li>Trong trường hợp B&ecirc;n A thanh to&aacute;n chậm so với điều 3 th&igrave; phải thanh to&aacute;n tiền phạt chậm thanh to&aacute;n cho B&ecirc;n B theo l&atilde;i suất tiền gửi của ng&acirc;n h&agrave;ng b&ecirc;n B l&agrave; NH NN&amp;PTNT.</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p><strong><u>ĐIỀU 6:</u></strong><strong> TR&Aacute;CH NHIỆM V&Agrave; QUYỀN LỢI</strong></p>\n\n<p><em>Tr&aacute;ch nhiệm của B&ecirc;n A. </em></p>\n\n<ul>\n <li>Chịu tr&aacute;ch nhiệm b&agrave;n giao mặt bằng, nguồn điện cho b&ecirc;n B thi c&ocirc;ng.</li>\n <li>Cử c&aacute;n bộ kỹ thuật hoặc c&aacute;n bộ đại diện xử l&yacute; c&aacute;c ph&aacute;t sinh (nếu c&oacute;) trong qu&aacute; tr&igrave;nh thi c&ocirc;ng cũng như x&aacute;c nhận kịp thời, cập nhật gi&aacute; trị ho&agrave;n th&agrave;nh cho b&ecirc;n B l&agrave;m cơ sở thanh to&aacute;n.</li>\n <li>Chịu tr&aacute;ch nhiệm thanh to&aacute;n theo đ&uacute;ng điều 3 của hợp đồng.</li>\n</ul>\n\n<p><em>Tr&aacute;ch nhiệm của B&ecirc;n B.</em></p>\n\n<ul>\n <li>Thi c&ocirc;ng theo đ&uacute;ng tiến độ, chất lượng.</li>\n <li>Chịu tr&aacute;ch nhiệm bồi thường thiệt hại 100% cho b&ecirc;n A hoặc b&ecirc;n thứ 3 (nếu c&oacute;) trong qu&aacute; tr&igrave;nh thi c&ocirc;ng. B&ecirc;n B sẽ kh&ocirc;ng chịu tr&aacute;ch nhiệm trong trường hợp kh&ocirc;ng phải do lỗi của b&ecirc;n B g&acirc;y ra.</li>\n <li>Chịu tr&aacute;ch nhiệm xuất ho&aacute; đơn VAT v&agrave; b&agrave;n giao c&ocirc;ng tr&igrave;nh cho b&ecirc;n A ngay khi b&ecirc;n A ho&agrave;n th&agrave;nh thanh to&aacute;n cho b&ecirc;n B theo điều 3 của hợp đồng n&agrave;y.</li>\n</ul>\n\n<p><strong><u>ĐIỀU 7:</u></strong><strong> ĐIỀU KHOẢN CHUNG, TRANH CHẤP TO&Agrave; &Aacute;N</strong></p>\n\n<ul>\n <li>Mọi tranh chấp li&ecirc;n quan ph&aacute;t sinh từ hợp đồng n&agrave;y, hai b&ecirc;n c&ugrave;ng đ&agrave;m ph&aacute;n tr&ecirc;n tinh thần hợp t&aacute;c v&agrave; c&ugrave;ng nhau giải quyết. Nếu đ&agrave;m ph&aacute;n kh&ocirc;ng đi đến thống nhất v&agrave; kh&ocirc;ng giải quyết được th&igrave; sẽ đưa ra To&agrave; &aacute;n kinh tế th&agrave;nh phố H&agrave; Nội để giải quyết. Kết luận cuối c&ugrave;ng của To&agrave; &aacute;n kinh tế l&agrave; cơ sở x&aacute;c định đ&uacute;ng sai. Chi ph&iacute; To&agrave; &aacute;n do b&ecirc;n thua chịu.</li>\n <li>Khi hợp đồng được k&yacute;, mọi thư t&iacute;n v&agrave; thoả thuận trước đ&acirc;y sẽ kh&ocirc;ng c&ograve;n hiệu lực.</li>\n <li>Hợp đồng&nbsp; c&oacute; hiệu lực từ ng&agrave;y k&yacute;. Bất kỳ sự sửa đổi n&agrave;o đối với hợp đồng n&agrave;y chỉ c&oacute; hiệu lực khi c&oacute; văn bản chấp thuận được k&yacute; bởi cả hai b&ecirc;n.</li>\n <li>Hai b&ecirc;n cam kết thực hiện nghi&ecirc;m t&uacute;c c&aacute;c điều khoản ghi trong hợp đồng. Nếu b&ecirc;n n&agrave;o vi phạm kh&ocirc;ng thực hiện đ&uacute;ng, b&ecirc;n đ&oacute; sẽ chịu ho&agrave;n to&agrave;n tr&aacute;ch nhiệm bồi thường c&aacute;c tổn thất do b&ecirc;n đ&oacute; g&acirc;y ra.</li>\n <li>Khi hai b&ecirc;n đ&atilde; ho&agrave;n th&agrave;nh đầy đủ nghĩa vụ v&agrave; tr&aacute;ch nhiệm của m&igrave;nh theo hợp đồng n&agrave;y th&igrave; hợp đồng hết hiệu lực v&agrave; tự thanh l&yacute;.</li>\n <li>Hợp đồng được lập th&agrave;nh 04 bản bằng tiếng Việt c&oacute; gi&aacute; trị ph&aacute;p l&yacute; như nhau, mỗi b&ecirc;n giữ 02 bản v&agrave; c&oacute; hiệu lực kể từ ng&agrave;y k&yacute;.</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<table>\n <tbody>\n  <tr>\n   <td>\n   <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ĐẠI DIỆN B&Ecirc;N A</strong></p>\n   </td>\n   <td>\n   <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ĐẠI DIỆN B&Ecirc;N B</strong></p>\n   </td>\n  </tr>\n </tbody>\n</table>\n', '1');

-- ----------------------------
-- Table structure for lifetek_receivings
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_receivings`;
CREATE TABLE `lifetek_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `receiving_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `inventory_id` int(11) NOT NULL COMMENT 'mã bảng kho',
  `suspended` int(1) NOT NULL DEFAULT '0' COMMENT 'trường xđ ghi nợ',
  `clause` int(11) DEFAULT NULL COMMENT 'định khoản trong kế toán',
  `reciprocal` int(11) DEFAULT NULL COMMENT 'tài khoản đối ứng trong kế toán',
  `VAT_acount` int(11) DEFAULT NULL COMMENT 'trường cho bít đơn hàng nhập có thuế hay không',
  `status` tinyint(1) DEFAULT '0',
  `currency_id` int(11) NOT NULL,
  `status_currency` tinyint(4) NOT NULL DEFAULT '0',
  `date_debt` date NOT NULL,
  `later_cost_price` int(11) NOT NULL COMMENT 'tổng tiền hàng',
  `symbol_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ký hiệu hóa đơn',
  `number_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'số hóa đơn',
  `number_taxes` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'mã số thuế',
  `date_debt1` date NOT NULL COMMENT 'ngày hóa đơn',
  `other_cost` float NOT NULL COMMENT 'chi phí khác',
  `no_1331` int(11) NOT NULL COMMENT 'nợ ',
  `money_1331` float NOT NULL,
  `co_331` int(11) NOT NULL COMMENT 'có 331',
  `money_331` float NOT NULL,
  PRIMARY KEY (`receiving_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`),
  KEY `deleted` (`deleted`),
  CONSTRAINT `lifetek_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `lifetek_employees` (`person_id`),
  CONSTRAINT `lifetek_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `lifetek_suppliers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_receivings
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_receivings_inventory
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_receivings_inventory`;
CREATE TABLE `lifetek_receivings_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_supplier` int(11) DEFAULT NULL,
  `id_city_code` int(11) DEFAULT NULL,
  `id_receiving` int(11) NOT NULL,
  `pay_amount` int(11) NOT NULL,
  `pay_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_receivings_inventory
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_receivings_items
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_receivings_items`;
CREATE TABLE `lifetek_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serialnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` double(20,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `rate_currency` double NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `taxes` float NOT NULL,
  `date` date NOT NULL,
  `cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tk_no_recv` int(11) NOT NULL,
  `money_tk_no` float NOT NULL,
  PRIMARY KEY (`receiving_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `lifetek_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`),
  CONSTRAINT `lifetek_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `lifetek_receivings` (`receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_receivings_items
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_receivings_items_taxes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_receivings_items_taxes`;
CREATE TABLE `lifetek_receivings_items_taxes` (
  `receiving_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(115) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_receivings_items_taxes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_receivings_payments
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_receivings_payments`;
CREATE TABLE `lifetek_receivings_payments` (
  `receiving_id` int(11) NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_receivings_payments
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_receivings_tam
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_receivings_tam`;
CREATE TABLE `lifetek_receivings_tam` (
  `pays_type` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays_amount` int(11) NOT NULL,
  `id_receiving` int(11) NOT NULL,
  `date_tam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `employees_id` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_receivings_tam
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_recv_cost_tkdu
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_recv_cost_tkdu`;
CREATE TABLE `lifetek_recv_cost_tkdu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cost` int(11) NOT NULL,
  `tkdu` int(11) NOT NULL,
  `money_no` decimal(15,0) NOT NULL,
  `money_co` decimal(15,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_recv_cost_tkdu
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_register_log
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_register_log`;
CREATE TABLE `lifetek_register_log` (
  `register_log_id` int(10) NOT NULL AUTO_INCREMENT,
  `employee_id` int(10) NOT NULL,
  `employees_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `shift_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shift_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `open_amount` decimal(15,2) NOT NULL COMMENT 'tiền bắt đầu vào ca',
  `rest` decimal(15,2) NOT NULL COMMENT 'tiền còn lại = tiền máy in - tiền trong két',
  `money_shifts_after` decimal(15,2) NOT NULL COMMENT 'tiền chuyển ca sau',
  `close_amount` decimal(15,2) NOT NULL,
  `cash_sales_amount` decimal(15,2) NOT NULL,
  `Nhanvien_xacnhan` decimal(15,2) NOT NULL,
  `Tien_boket` decimal(15,2) NOT NULL,
  `Ngay_giaoca` date NOT NULL,
  `moneys_throws` decimal(15,2) NOT NULL COMMENT 'tiền chi trong ca',
  `moneys_debts` decimal(15,2) NOT NULL COMMENT 'tiền thu nợ trong ca',
  `discount_money` decimal(15,2) NOT NULL COMMENT 'tiền chiết khấu trong ca',
  `total_actual` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'tổng tiền thu được',
  `revenues_moneys` decimal(15,2) NOT NULL COMMENT 'tổng doanh thu trong ca',
  `moneys_oders` decimal(15,2) NOT NULL COMMENT 'tiền đặt hàng trong ca',
  `customer_debt` decimal(15,2) NOT NULL COMMENT 'tiền khách hàng nợ trong ca',
  PRIMARY KEY (`register_log_id`),
  KEY `phppos_register_log_ibfk_1` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_register_log
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_request_production_template
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_request_production_template`;
CREATE TABLE `lifetek_request_production_template` (
  `id_request` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) DEFAULT NULL,
  `number_request` float DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1: Đã tiếp nhận, 2: Chưa tiếp nhận',
  `command` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_request`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_request_production_template
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_resellers
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_resellers`;
CREATE TABLE `lifetek_resellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 NOT NULL,
  `en_title` text NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `en_description` text NOT NULL,
  `full` text CHARACTER SET utf8 NOT NULL,
  `en_full` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_resellers
-- ----------------------------
INSERT INTO `lifetek_resellers` VALUES ('1', 'Công ty Viễn thông Viettel (Viettel Telecom)', 'english language', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>dess</p>\n', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>des</p>\n', '', 'cong-ty-vien-thong-viettel-(viettel-telecom)');
INSERT INTO `lifetek_resellers` VALUES ('7', 's', 's', '<p>s</p>\n', '<p>s</p>\n', '<p>s</p>\n', '<p>s</p>\n', '', 's');

-- ----------------------------
-- Table structure for lifetek_resources
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_resources`;
CREATE TABLE `lifetek_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_resources
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_salary
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_salary`;
CREATE TABLE `lifetek_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_salary` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `total_basic_salary` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_real_wages` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `money_amount_owed` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `money_custody` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `money_advance` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_actual` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `money_actual_payment` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `debt_salary` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expected_salary_2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expected_salary_1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_complete_again` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `comment_manager` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) NOT NULL,
  `parent_manager_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `date_parent_manager` date NOT NULL,
  `date_parent` date NOT NULL,
  PRIMARY KEY (`id`,`person_id`,`status`,`date_parent_manager`,`date_parent`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `lifetek_salary_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_salary
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_salarystatic
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_salarystatic`;
CREATE TABLE `lifetek_salarystatic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_x` varchar(11) DEFAULT '0',
  `total_c` varchar(11) DEFAULT '0',
  `total_p` varchar(11) DEFAULT '0',
  `total_k` varchar(11) DEFAULT '0',
  `total_t` varchar(11) DEFAULT '0',
  `total_l` varchar(11) DEFAULT '0',
  `total_nb` varchar(11) DEFAULT '0',
  `total_h` varchar(11) DEFAULT '0',
  `total_ts` varchar(11) DEFAULT '0',
  `total_o` varchar(11) DEFAULT '0',
  `total_kl` varchar(11) DEFAULT '0',
  `total_vacation` varchar(11) DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `year_months` varchar(15) DEFAULT '0',
  `total_all` varchar(11) DEFAULT '0',
  `total_x150` varchar(11) DEFAULT '0',
  `total_x200` varchar(11) DEFAULT '0',
  `total_x300` varchar(11) DEFAULT '0',
  PRIMARY KEY (`id`,`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_salarystatic
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_salary_config
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_salary_config`;
CREATE TABLE `lifetek_salary_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_salary_config
-- ----------------------------
INSERT INTO `lifetek_salary_config` VALUES ('1', 'nghỉ phép', 'nghỉ phép năm', '0');
INSERT INTO `lifetek_salary_config` VALUES ('2', 'x', 'đi làm cả ngày\n', '0');
INSERT INTO `lifetek_salary_config` VALUES ('3', 'x/2', 'làm nửa ngày\n', '0');
INSERT INTO `lifetek_salary_config` VALUES ('4', 'xx', 'tăng ca', '0');

-- ----------------------------
-- Table structure for lifetek_salary_option
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_salary_option`;
CREATE TABLE `lifetek_salary_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numberdays` varchar(50) NOT NULL,
  `numberhours` varchar(50) NOT NULL,
  `percent_overtime_weekdays` varchar(50) NOT NULL,
  `percent_overtime_sunday` varchar(50) NOT NULL,
  `percent_overtime_holiday` varchar(50) NOT NULL,
  `union_dues` varchar(50) NOT NULL,
  `exemption_amount` varchar(50) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `vacation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_salary_option
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales`;
CREATE TABLE `lifetek_sales` (
  `sale_time` date NOT NULL,
  `date_debt` date NOT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `show_comment_on_receipt` int(1) NOT NULL DEFAULT '0',
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_ref_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `suspended` int(1) NOT NULL DEFAULT '0' COMMENT ' ghi nợ',
  `liability` int(1) NOT NULL DEFAULT '0' COMMENT 'đặt hàng',
  `materials` int(1) NOT NULL DEFAULT '0' COMMENT 'active báo giá',
  `later_cost_price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'tổng tiền đơn hàng',
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `actual_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `employees_id` int(11) NOT NULL DEFAULT '0' COMMENT 'người báo giá',
  `delivery_employee` int(11) NOT NULL COMMENT 'nhân viên giao hàng',
  `sale_status` tinyint(4) NOT NULL DEFAULT '0',
  `symbol_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ký hiệu hóa đơn',
  `number_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'số hóa đơn',
  `date_debt1` date NOT NULL COMMENT 'ngày hóa đơn',
  `co_1331` int(11) NOT NULL,
  `co_1331_money` float NOT NULL,
  `no_131` int(11) NOT NULL,
  `no_131_money` int(11) NOT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`),
  KEY `deleted` (`deleted`),
  CONSTRAINT `lifetek_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `lifetek_employees` (`person_id`),
  CONSTRAINT `lifetek_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `lifetek_customers` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_inventory
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_inventory`;
CREATE TABLE `lifetek_sales_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) DEFAULT NULL,
  `id_city_code` int(11) DEFAULT NULL,
  `id_sale` int(11) NOT NULL,
  `pay_amount` int(11) NOT NULL,
  `pay_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_inventory
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_items
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_items`;
CREATE TABLE `lifetek_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `id_customer` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serialnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(20,2) NOT NULL DEFAULT '0.00',
  `unit_item` int(11) NOT NULL,
  `item_cost_price` decimal(15,0) NOT NULL,
  `item_unit_price` decimal(15,0) NOT NULL,
  `item_unit_price_rate` decimal(15,0) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `taxes_percent` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stored_id` int(11) NOT NULL DEFAULT '0' COMMENT 'mã bảng kho',
  `co_tk_thu` int(11) NOT NULL,
  `co_tk_thu_money` float NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `lifetek_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`),
  CONSTRAINT `lifetek_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_items
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_items_taxes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_items_taxes`;
CREATE TABLE `lifetek_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `lifetek_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales_items` (`sale_id`),
  CONSTRAINT `lifetek_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_items_taxes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_item_kits
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_item_kits`;
CREATE TABLE `lifetek_sales_item_kits` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_kit_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(20,2) NOT NULL DEFAULT '0.00',
  `unit_item_kit` int(11) NOT NULL,
  `item_kit_cost_price` decimal(15,0) NOT NULL,
  `item_kit_unit_price` decimal(15,0) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  `stored_id` int(11) NOT NULL DEFAULT '0',
  `id_customer` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sale_id`,`item_kit_id`,`line`),
  KEY `item_kit_id` (`item_kit_id`),
  CONSTRAINT `lifetek_sales_item_kits_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`),
  CONSTRAINT `lifetek_sales_item_kits_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_item_kits
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_item_kits_taxes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_item_kits_taxes`;
CREATE TABLE `lifetek_sales_item_kits_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_kit_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_kit_id`),
  CONSTRAINT `lifetek_sales_item_kits_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales_item_kits` (`sale_id`),
  CONSTRAINT `lifetek_sales_item_kits_taxes_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_item_kits_taxes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_materials
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_materials`;
CREATE TABLE `lifetek_sales_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL COMMENT 'mã đơn hàng để báo giá cho khách hàng',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'tên file',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1 COMMENT='save file báo giá qua email';

-- ----------------------------
-- Records of lifetek_sales_materials
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_packs
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_packs`;
CREATE TABLE `lifetek_sales_packs` (
  `sale_id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `line` int(3) NOT NULL,
  `quantity_purchased` int(11) NOT NULL,
  `unit_pack` int(11) NOT NULL,
  `pack_cost_price` decimal(15,0) NOT NULL,
  `pack_unit_price` decimal(15,0) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `stored_id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_packs
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_payments
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_payments`;
CREATE TABLE `lifetek_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stt` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`payment_type`,`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_payments
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_payments12
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_payments12`;
CREATE TABLE `lifetek_sales_payments12` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`),
  CONSTRAINT `lifetek_sales_payments12_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sales_payments12
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sales_tam
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sales_tam`;
CREATE TABLE `lifetek_sales_tam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pays_amount` int(11) NOT NULL,
  `id_sale` int(11) NOT NULL,
  `date_tam` date NOT NULL,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `employees_id` int(11) NOT NULL,
  `stt` int(1) NOT NULL DEFAULT '0',
  `dathang` int(1) NOT NULL DEFAULT '0' COMMENT 'trạng thái đặt hàng',
  `id_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2173 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_sales_tam
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sale_cost_tkdu
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sale_cost_tkdu`;
CREATE TABLE `lifetek_sale_cost_tkdu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cost` int(11) NOT NULL,
  `tkdu` int(11) NOT NULL,
  `money_no` decimal(15,0) NOT NULL,
  `money_co` decimal(15,0) NOT NULL,
  `date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `stt` tinyint(4) NOT NULL DEFAULT '0',
  `stt_cmt` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_sale_cost_tkdu
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sessions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sessions`;
CREATE TABLE `lifetek_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_sessions
-- ----------------------------
INSERT INTO `lifetek_sessions` VALUES ('ea59b2fe82aa3e04fac77da706391d16', '::1', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '1452925410', 'a:4:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:1:\"1\";s:4:\"cart\";a:0:{}s:8:\"cartRecv\";a:0:{}}');

-- ----------------------------
-- Table structure for lifetek_shop_guide
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_shop_guide`;
CREATE TABLE `lifetek_shop_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_shop_guide
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_shoutbox
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_shoutbox`;
CREATE TABLE `lifetek_shoutbox` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) NOT NULL DEFAULT 'anonimous',
  `user_id` int(25) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `status` enum('to do','completed') NOT NULL DEFAULT 'to do',
  `privacy` enum('public','private') NOT NULL DEFAULT 'public',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_shoutbox
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_slider
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_slider`;
CREATE TABLE `lifetek_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `img` varchar(150) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_slider
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_sms
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_sms`;
CREATE TABLE `lifetek_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `number_char` int(11) NOT NULL,
  `number_message` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_sms
-- ----------------------------
INSERT INTO `lifetek_sms` VALUES ('1', 'Chúc m?ng n?m m?i!', 'Chúc n?m m?i vui v? h?nh phúc.', '30', '1', '0');
INSERT INTO `lifetek_sms` VALUES ('2', 'chúc m?ng sinh nh?t', 'chúc m?ng sinh nh?t công ty 15  tu?i. chúc công ty nhi?u may m?n', '64', '1', '0');
INSERT INTO `lifetek_sms` VALUES ('3', 'h', 'l', '1', '1', '1');

-- ----------------------------
-- Table structure for lifetek_solutions
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_solutions`;
CREATE TABLE `lifetek_solutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 NOT NULL,
  `en_title` text NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `en_description` text NOT NULL,
  `full` text CHARACTER SET utf8 NOT NULL,
  `en_full` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_solutions
-- ----------------------------
INSERT INTO `lifetek_solutions` VALUES ('1', 'Giải pháp Video Conference cho doanh nghiệp lớn và nhà cung cấp dịch vụ', 'title', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>dess</p>\n', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>full</p>\n', '', 'giai-phap-video-conference-cho-doanh-nghiep-lon-va-nha-cung-cap-dich-vu');
INSERT INTO `lifetek_solutions` VALUES ('11', 'gẻgergerg', 'g?gergerg', '<p>gẻgerger</p>\n', '<p>g?gregerger</p>\n', '<p>gregergeg</p>\n', '<p>g?gergreeg</p>\n', '', 'gegergerg');

-- ----------------------------
-- Table structure for lifetek_super_admin
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_super_admin`;
CREATE TABLE `lifetek_super_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `authentication` varchar(32) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_super_admin
-- ----------------------------
INSERT INTO `lifetek_super_admin` VALUES ('1', 'lifetek2014', '25d55ad283aa400af464c76d713c07ad', '0', '2013-12-01 16:08:04', 'lifetek@2014', 'Hoàng Tiến Hưng', 'hunght1188@fmail.com', 'super admin');

-- ----------------------------
-- Table structure for lifetek_suppliers
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_suppliers`;
CREATE TABLE `lifetek_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `anh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_cate` int(11) DEFAULT NULL,
  `account_implicit_sp` int(11) NOT NULL COMMENT 'tài khoản ngầm định',
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`),
  KEY `deleted` (`deleted`),
  CONSTRAINT `lifetek_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_people` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_suppliers
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_support
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_support`;
CREATE TABLE `lifetek_support` (
  `id_support` int(11) NOT NULL AUTO_INCREMENT,
  `name_support` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yahoo` varchar(255) NOT NULL,
  `skype` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  PRIMARY KEY (`id_support`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_support
-- ----------------------------
INSERT INTO `lifetek_support` VALUES ('1', 'Hỗ trợ bán hàng', 'dungchip', 'chip88', '1698719069');

-- ----------------------------
-- Table structure for lifetek_s_bo_tt
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_bo_tt`;
CREATE TABLE `lifetek_s_bo_tt` (
  `boid` int(20) NOT NULL AUTO_INCREMENT,
  `ten_bo` varchar(200) NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '0',
  `id_nhomtt` varchar(500) NOT NULL,
  PRIMARY KEY (`boid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_bo_tt
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_giatri_tt
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_giatri_tt`;
CREATE TABLE `lifetek_s_giatri_tt` (
  `idgiatri` int(20) NOT NULL AUTO_INCREMENT,
  `ma_tt` varchar(50) NOT NULL,
  `giatri` text NOT NULL,
  PRIMARY KEY (`idgiatri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_giatri_tt
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_nhacungcap
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_nhacungcap`;
CREATE TABLE `lifetek_s_nhacungcap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_cate` int(11) DEFAULT NULL,
  `ten_ncc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `anh` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_s_nhacungcap
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_nhom_ncc
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_nhom_ncc`;
CREATE TABLE `lifetek_s_nhom_ncc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_s_nhom_ncc
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_nhom_tt
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_nhom_tt`;
CREATE TABLE `lifetek_s_nhom_tt` (
  `nhomid` int(20) NOT NULL AUTO_INCREMENT,
  `ten_nhom` varchar(200) NOT NULL,
  `ten_ht` varchar(200) NOT NULL,
  `thutu` int(5) NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '0',
  `id_tt` varchar(500) NOT NULL,
  PRIMARY KEY (`nhomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_nhom_tt
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_product
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_product`;
CREATE TABLE `lifetek_s_product` (
  `spid` int(20) NOT NULL AUTO_INCREMENT,
  `ma_sp` varchar(50) DEFAULT NULL,
  `motangan` text NOT NULL,
  `ten_sp` varchar(200) NOT NULL,
  `gia_ny` int(20) NOT NULL,
  `gia_km` int(20) NOT NULL,
  `khuyen_mai` varchar(250) NOT NULL,
  `bao_hanh` varchar(250) NOT NULL,
  `co_vat` tinyint(1) NOT NULL DEFAULT '0',
  `co_hang` tinyint(1) NOT NULL DEFAULT '0',
  `danhmuc` int(20) NOT NULL,
  `sp_banchay` tinyint(1) NOT NULL DEFAULT '0',
  `sp_km` tinyint(1) NOT NULL DEFAULT '0',
  `sp_moi` tinyint(1) NOT NULL DEFAULT '0',
  `sp_tot` tinyint(1) NOT NULL DEFAULT '0',
  `sp_giamgia` tinyint(1) NOT NULL DEFAULT '0',
  `anh` varchar(50) NOT NULL,
  `anh_con` varchar(255) NOT NULL,
  `id_bo_tt` int(10) NOT NULL,
  `ngaytao` varchar(50) NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '0',
  `ncc_id` int(20) NOT NULL,
  `sp_depvadoc` tinyint(1) NOT NULL DEFAULT '0',
  `count_view` int(20) DEFAULT '1',
  `like` int(11) DEFAULT '1',
  `unlike` int(11) DEFAULT '1',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keyword` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `ads_left` int(11) NOT NULL DEFAULT '0',
  `ads_right` int(11) NOT NULL DEFAULT '0',
  `url_video` varchar(300) DEFAULT NULL,
  `is_now` int(10) DEFAULT '0',
  `is_go_in` int(10) DEFAULT '0',
  `product_view_home` tinyint(1) NOT NULL DEFAULT '0',
  `view_img_slider` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`spid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_product
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_product_images
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_product_images`;
CREATE TABLE `lifetek_s_product_images` (
  `link` varchar(255) NOT NULL,
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(20) NOT NULL,
  `anh_con` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_product_images
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_sanpham_tt
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_sanpham_tt`;
CREATE TABLE `lifetek_s_sanpham_tt` (
  `ma_tt` varchar(200) NOT NULL,
  `item_id` int(20) NOT NULL,
  `giatri` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_sanpham_tt
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_s_thuoctinh
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_s_thuoctinh`;
CREATE TABLE `lifetek_s_thuoctinh` (
  `idtt` int(20) NOT NULL AUTO_INCREMENT,
  `kieu` varchar(20) NOT NULL,
  `ten` varchar(50) NOT NULL,
  `ten_ht` varchar(200) NOT NULL,
  `ma` varchar(50) NOT NULL,
  `hien_loc` tinyint(1) NOT NULL DEFAULT '0',
  `hien_sosanh` tinyint(1) NOT NULL DEFAULT '0',
  `hien_timkiem` tinyint(1) NOT NULL DEFAULT '0',
  `batbuoc` tinyint(1) NOT NULL DEFAULT '0',
  `macdinh` text,
  `thutu` int(10) NOT NULL,
  `trangthai` tinyint(1) NOT NULL,
  PRIMARY KEY (`idtt`),
  UNIQUE KEY `ma` (`ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_s_thuoctinh
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_templates_contract
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_templates_contract`;
CREATE TABLE `lifetek_templates_contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_cus` varchar(50) CHARACTER SET latin1 NOT NULL,
  `add_cus` varchar(50) CHARACTER SET latin1 NOT NULL,
  `phone_cus` varchar(50) CHARACTER SET latin1 NOT NULL,
  `code_tax` varchar(50) CHARACTER SET latin1 NOT NULL,
  `company_cus` varchar(50) CHARACTER SET latin1 NOT NULL,
  `total_money` varchar(50) CHARACTER SET latin1 NOT NULL,
  `row` int(11) NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `primary` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_templates_contract
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_timekeeping
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_timekeeping`;
CREATE TABLE `lifetek_timekeeping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `salaryconfig_id` int(11) NOT NULL,
  `day_keeping` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `salaryconfig_id` (`salaryconfig_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_timekeeping
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_tinhoc
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_tinhoc`;
CREATE TABLE `lifetek_tinhoc` (
  `id_tinhoc` int(11) NOT NULL AUTO_INCREMENT,
  `chungchi_tinhoc` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tinhoc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_tinhoc
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_tkdu
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_tkdu`;
CREATE TABLE `lifetek_tkdu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acc_cat_id` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55334 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_tkdu
-- ----------------------------
INSERT INTO `lifetek_tkdu` VALUES ('111', 'Tiền mặt', '7', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('112', 'Tiền gửi ngân hàng', '0', '0', '1', '', '0', '300000');
INSERT INTO `lifetek_tkdu` VALUES ('121', 'Đầu tư chứng khoán ngắn hạn', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('131', 'Phải thu khách hàng', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('133', 'Thuế GTGT được khấu trừ', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('138', 'Phải thu khác', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('141', 'Tạm ứng', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('142', 'Chi phí trả trước', '17', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('152', 'Nguyên liệu, vật liệu', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('153', 'Công cụ, dụng cụ', '18', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('154', 'Chi phí sản xuất, kinh doanh dở dang', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('155', 'Thành phẩm', '18', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('156', 'Hàng hoá', '18', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('157', 'Hàng gửi đi bán', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('159', 'Các khoản dự phòng', '9', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('171', 'Giao dịch mua bán trái phiếu của Chính Phủ', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('211', 'Tài sản  cố định', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('214', 'Hao mòn TSCĐ', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('217', 'Bất động sản đầu tư', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('221', 'Đầu tư vào công ty con', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('229', 'Dự phòng giảm giá đầu tư dài hạn', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('241', 'Xây dựng cơ bản', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('242', 'Chi phí trả trước dài hạn', '17', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('244', 'Ký quỹ, ký cược dài hạn', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('311', 'Vay ngắn hạn', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('315', 'Nợ dài hạn đến hạn trả', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('331', 'Phải trả cho người bán', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('333', 'Thuế và các khoản phải nộp Nhà nước', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('334', 'Phải trả người lao động', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('335', 'Chi phí phải trả', '10', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('338', 'Phải trả, phải nộp khác', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('341', 'Vay, nợ dài hạn', '10', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('351', 'Quỹ dự phòng trợ cấp mất việc làm', '8', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('352', 'Dự phòng phải trả', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('353', 'Quỹ khen thưởng phúc lợi', '8', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('356', 'Quỹ phát triển khoa học và công nghệ', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('411', 'Nguồn vốn kinh doanh', '0', '0', '1', '', '300000', '0');
INSERT INTO `lifetek_tkdu` VALUES ('413', 'Chênh lệch tỷ giá', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('418', 'Các quỹ khác thuộc vốn chủ sở hữu', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('419', 'Cổ phiếu quỹ', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('421', 'Lợi nhuận chưa phân phối', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('511', 'Doanh thu HH & cung cấp DV', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('515', 'Doanh thu hoạt động tài chính', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('521', 'Các khoản giảm trừ doanh thu', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('611', 'Mua hàng', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('631', 'Giá thành sản xuất ', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('632', 'Giá vốn hàng bán', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('635', 'Chi phí tài chính', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('642', 'Chi phí quản lý DN', '16', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('711', 'Thu nhập khác', '15', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('811', 'Chi phí khác', '16', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('821', 'Chi phí thuế thu nhập doanh nghiệp', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('911', 'Xác định kết quả kinh doanh', '0', '0', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1111', 'Tiền mặt Việt Nam', '0', '111', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1112', 'Ngoại tệ', '0', '111', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1113', 'Vàng, bạc, kim khí quý, đá quý', '0', '111', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1121', 'Tiền Việt Nam', '0', '112', '0', '', '0', '300000');
INSERT INTO `lifetek_tkdu` VALUES ('1122', 'Ngoại tệ', '0', '112', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1123', 'Vàng, bạc, kim khí quý, đá quý', '0', '112', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1331', 'Thuế GTGT được khấu trừ HH, DV', '0', '133', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1332', 'Thuế GTGT được khấu trừ của TSCĐ', '0', '133', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1381', 'Tài sản thiếu chờ xử lý', '0', '138', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1388', 'Phải thu khác', '0', '138', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1591', 'Dự phòng giảm giá đầu tư tài chính ngắn hạn', '9', '159', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1592', 'Dự phòng phải thu khó đòi', '0', '159', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('1593', 'Dự phòng giảm giá hàng tồn kho', '9', '159', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2111', 'Tài sản cố định hữu hình', '9', '211', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2112', 'TSCĐ thuê tài chính', '0', '211', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2113', 'TSCĐ vô hình', '0', '211', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2141', 'Hao mòn TSCĐ hữu hình', '0', '214', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2142', 'Hao mòn TSCĐ thuê tài chính', '0', '214', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2143', 'Hao mòn TSCĐ vô hình', '0', '214', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2147', 'Hao mòn bất động sản đầu tư', '0', '214', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2212', 'Vốn góp liên doanh', '0', '221', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2213', 'Đầu tư vào công ty liên kết', '0', '221', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2218', 'Đầu tư tài chính dài hạn khác', '0', '221', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2411', 'Mua sắm TSCĐ', '0', '241', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2412', 'Xây dựng cơ bản', '0', '241', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('2413', 'Sửa chữa lớn TSCĐ', '0', '241', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3331', 'Thuế GTGT đầu ra phải nộp', '10', '333', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3332', 'Thuế tiêu thu đặc biệt', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3333', 'Thuế xuất, nhập khẩu', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3334', 'Thuế thu nhập doanh nghiệp', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3335', 'Thuế thu nhập cá nhân', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3336', 'Thuế tài nguyên', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3337', 'Thuế nhà đất, tiền thuê đất', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3338', 'Các loại thuế khác', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3339', 'Phí, lệ phí và các khoản phải nộp khác', '0', '333', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3381', 'Tài sản thừa chờ giải quyết', '0', '338', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3382', 'Kinh phí công đoàn', '0', '338', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3383', 'Bảo hiểm xã hội', '10', '338', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3384', 'Bảo hiểm y tế', '10', '338', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3386', 'Nhận ký qũi, ký cược ngắn hạn', '0', '338', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3387', 'Doanh thu chưa thực hiện', '0', '338', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3388', 'Phải trả, phải nộp khác', '0', '338', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3389', 'Bảo hiểm thất nghiệp', '10', '338', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3411', 'Vay dài hạn', '0', '341', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3412', 'Nợ dài hạn', '0', '341', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3413', 'Trái phiếu phát hành', '0', '341', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3414', 'Nhật ký quỹ, ký cược dài hạn', '0', '341', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3531', 'Quỹ khen thưởng', '8', '353', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3532', 'Quỹ phúc lợi', '0', '353', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3533', 'Quỹ phúc lợi đã hình thành TSCĐ', '0', '353', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3534', 'Quỹ thưởng ban QL điều hành công ty', '0', '353', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3561', 'Quỹ phát triển khoa học và công nghệ', '0', '356', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('3562', 'Quỹ phát triển khoa học và công nghệ đã hình thành', '0', '356', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('4111', 'Vốn đầu tư của chủ sở hữu', '0', '411', '0', '', '300000', '0');
INSERT INTO `lifetek_tkdu` VALUES ('4112', 'Thặng dư vốn cổ phần', '0', '411', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('4118', 'Vốn khác', '0', '411', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('4211', 'Lợi nhuận chưa phân phối năm trước', '0', '421', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('4212', 'Lợi nhuận chưa phân phối năm nay', '0', '421', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5111', 'Doanh thu bán hàng hóa', '15', '511', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5112', 'Doanh thu bán các thành phẩm', '15', '511', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5113', 'Doanh thu cung cấp dịch vụ', '0', '511', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5118', 'Doanh thu khác', '0', '511', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5211', 'Chiết khấu thương mại', '0', '521', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5212', 'Hàng bán bị trả lại', '0', '521', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('5213', 'Giảm giá hàng bán', '0', '521', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('6411', 'Chi phí nhân viên', '0', '641', '0', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('6421', 'Chi phí bán hàng', '16', '642', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('6422', 'Chi phí quản lý doanh nghiệp', '16', '642', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('11211', 'VIB', '6', '1121', '1', '', '0', '100000');
INSERT INTO `lifetek_tkdu` VALUES ('11212', 'Agribank', '6', '1121', '1', '', '0', '200000');
INSERT INTO `lifetek_tkdu` VALUES ('11213', 'Vietcombank', '0', '1121', '1', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21111', 'Nhà cửa, vật kiến trúc', '0', '2111', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21112', 'Máy móc, thiết bị', '0', '2111', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21113', 'Phương tiện vận tải, truyền dẫn', '0', '2111', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21114', 'Thiết bị, dụng cụ quản lý', '0', '2111', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21115', 'Cây lâu năm, súc vật làm việc và cho SP', '0', '2111', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21118', 'TSCĐ khác', '0', '2111', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21131', 'Quyền sử dụng đất', '9', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21132', 'Quyền phát hành', '0', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21133', 'Bản quyền, bằng sáng tạo', '9', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21134', 'Nhãn hiệu hàng hóa', '0', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21135', 'Phần mềm máy vi tính', '0', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21136', 'Giấy phép và giấp phép nhượng quyền', '0', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('21138', 'TSCĐ vô hình khác', '0', '2113', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('33311', 'Thuế GTGT đầu ra', '0', '3331', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('33312', 'Thuế GTGT hàng nhập khẩu', '0', '3331', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('34131', 'Mệnh giá trái phiếu', '0', '3413', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('34132', 'Chiết khấu trái phiếu', '0', '3413', '2', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('34133', 'Phụ trội trái phiếu', '8', '3413', '3', '', '0', '0');
INSERT INTO `lifetek_tkdu` VALUES ('55333', 'Nợ bản quyền', '3', '2133', '2', '', '0', '0');

-- ----------------------------
-- Table structure for lifetek_transfer_stores
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_transfer_stores`;
CREATE TABLE `lifetek_transfer_stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stt` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='lịch sử chuyển kho';

-- ----------------------------
-- Records of lifetek_transfer_stores
-- ----------------------------
INSERT INTO `lifetek_transfer_stores` VALUES ('1', '2', '0', '4107', '99', '0', '2015-07-30 17:31:40');
INSERT INTO `lifetek_transfer_stores` VALUES ('2', '3', '0', '4108', '100', '0', '2015-07-31 16:30:41');
INSERT INTO `lifetek_transfer_stores` VALUES ('3', '3', '0', '4108', '100', '0', '2015-08-01 14:06:29');
INSERT INTO `lifetek_transfer_stores` VALUES ('4', '2', '0', '4121', '1', '0', '2015-08-04 10:47:09');
INSERT INTO `lifetek_transfer_stores` VALUES ('5', '2', '0', '4123', '1', '0', '2015-08-04 11:06:14');
INSERT INTO `lifetek_transfer_stores` VALUES ('6', '2', '0', '4124', '0', '0', '2015-08-04 11:10:00');
INSERT INTO `lifetek_transfer_stores` VALUES ('7', '3', '0', '4121', '1', '0', '2015-08-04 14:08:50');
INSERT INTO `lifetek_transfer_stores` VALUES ('8', '5', '0', '4125', '10', '0', '2015-08-05 09:51:05');
INSERT INTO `lifetek_transfer_stores` VALUES ('9', '0', '5', '4125', '7', '0', '2015-08-05 09:54:31');
INSERT INTO `lifetek_transfer_stores` VALUES ('10', '0', '5', '4125', '1', '0', '2015-08-05 10:13:01');
INSERT INTO `lifetek_transfer_stores` VALUES ('11', '6', '0', '4120', '5', '0', '2015-08-07 10:59:33');
INSERT INTO `lifetek_transfer_stores` VALUES ('12', '7', '0', '4120', '9', '0', '2015-08-07 11:04:42');
INSERT INTO `lifetek_transfer_stores` VALUES ('13', '8', '0', '4120', '5', '0', '2015-08-07 11:27:24');
INSERT INTO `lifetek_transfer_stores` VALUES ('14', '10', '0', '4143', '5', '0', '2015-08-08 10:11:40');
INSERT INTO `lifetek_transfer_stores` VALUES ('15', '6', '0', '4112', '81', '0', '2015-08-13 10:11:46');
INSERT INTO `lifetek_transfer_stores` VALUES ('16', '3', '0', '4118', '6', '0', '2015-08-13 11:37:24');
INSERT INTO `lifetek_transfer_stores` VALUES ('17', '6', '0', '4107', '1', '0', '2015-08-13 16:06:16');
INSERT INTO `lifetek_transfer_stores` VALUES ('18', '3', '0', '4159', '50', '0', '2015-08-14 09:59:07');
INSERT INTO `lifetek_transfer_stores` VALUES ('19', '3', '0', '4158', '5', '0', '2015-08-14 09:59:07');
INSERT INTO `lifetek_transfer_stores` VALUES ('20', '3', '0', '4199', '50', '0', '2015-08-14 10:39:07');
INSERT INTO `lifetek_transfer_stores` VALUES ('21', '2', '0', '4196', '3', '0', '2015-08-19 13:42:54');
INSERT INTO `lifetek_transfer_stores` VALUES ('22', '3', '0', '4216', '50', '0', '2015-08-20 14:50:06');
INSERT INTO `lifetek_transfer_stores` VALUES ('23', '3', '0', '4220', '999', '0', '2015-08-20 16:37:51');
INSERT INTO `lifetek_transfer_stores` VALUES ('24', '3', '0', '4230', '10', '0', '2015-08-24 13:59:29');
INSERT INTO `lifetek_transfer_stores` VALUES ('25', '3', '0', '4218', '10', '0', '2015-08-27 14:45:11');
INSERT INTO `lifetek_transfer_stores` VALUES ('26', '3', '0', '4282', '122', '0', '2015-09-03 09:58:58');
INSERT INTO `lifetek_transfer_stores` VALUES ('27', '3', '0', '4277', '117', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_transfer_stores` VALUES ('28', '3', '0', '4278', '68', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_transfer_stores` VALUES ('29', '3', '0', '4279', '48', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_transfer_stores` VALUES ('30', '3', '0', '4280', '6', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_transfer_stores` VALUES ('31', '3', '0', '4281', '13', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_transfer_stores` VALUES ('32', '8', '0', '4288', '0', '0', '2015-09-04 10:43:26');
INSERT INTO `lifetek_transfer_stores` VALUES ('33', '8', '0', '4288', '10', '0', '2015-09-04 10:43:55');
INSERT INTO `lifetek_transfer_stores` VALUES ('34', '3', '0', '4293', '1000', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_transfer_stores` VALUES ('35', '3', '0', '4294', '1000', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_transfer_stores` VALUES ('36', '3', '0', '4291', '160', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_transfer_stores` VALUES ('37', '3', '0', '4290', '150', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_transfer_stores` VALUES ('38', '3', '0', '4289', '150', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_transfer_stores` VALUES ('39', '3', '0', '4292', '1000', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_transfer_stores` VALUES ('40', '3', '0', '4292', '10002', '0', '2015-09-04 11:58:53');
INSERT INTO `lifetek_transfer_stores` VALUES ('41', '5', '0', '4288', '0', '0', '2015-09-04 13:48:54');
INSERT INTO `lifetek_transfer_stores` VALUES ('42', '8', '0', '4288', '0', '0', '2015-09-04 13:58:47');
INSERT INTO `lifetek_transfer_stores` VALUES ('43', '14', '0', '4166', '1', '0', '2015-10-06 10:20:21');
INSERT INTO `lifetek_transfer_stores` VALUES ('44', '0', '2', '4385', '5', '0', '2015-10-26 15:03:24');
INSERT INTO `lifetek_transfer_stores` VALUES ('45', '15', '0', '4179', '1', '0', '2015-10-26 22:00:03');
INSERT INTO `lifetek_transfer_stores` VALUES ('46', '10', '0', '4166', '1', '0', '2015-10-26 22:00:51');
INSERT INTO `lifetek_transfer_stores` VALUES ('47', '14', '0', '4379', '1', '0', '2015-10-27 13:37:57');
INSERT INTO `lifetek_transfer_stores` VALUES ('48', '15', '0', '4367', '1', '0', '2015-11-11 13:37:03');
INSERT INTO `lifetek_transfer_stores` VALUES ('49', '15', '0', '4227', '1', '0', '2015-11-12 08:55:52');
INSERT INTO `lifetek_transfer_stores` VALUES ('50', '22', '0', '4193', '1', '0', '2015-11-12 14:28:32');
INSERT INTO `lifetek_transfer_stores` VALUES ('51', '3', '0', '4475', '1', '0', '2015-11-18 13:58:45');
INSERT INTO `lifetek_transfer_stores` VALUES ('52', '3', '0', '4488', '0', '0', '2015-11-19 09:03:17');
INSERT INTO `lifetek_transfer_stores` VALUES ('53', '22', '0', '4159', '1', '0', '2015-12-15 11:49:32');
INSERT INTO `lifetek_transfer_stores` VALUES ('54', '4', '0', '4329', '1', '0', '2015-12-16 16:49:55');
INSERT INTO `lifetek_transfer_stores` VALUES ('55', '4', '0', '4330', '1', '0', '2015-12-16 16:50:12');
INSERT INTO `lifetek_transfer_stores` VALUES ('56', '8', '0', '4329', '2', '0', '2015-12-16 16:55:46');
INSERT INTO `lifetek_transfer_stores` VALUES ('57', '4', '0', '4329', '1', '0', '2015-12-16 16:58:20');
INSERT INTO `lifetek_transfer_stores` VALUES ('58', '8', '0', '4520', '1', '0', '2015-12-18 12:21:00');
INSERT INTO `lifetek_transfer_stores` VALUES ('59', '15', '0', '4198', '0', '0', '2015-12-18 12:22:43');
INSERT INTO `lifetek_transfer_stores` VALUES ('60', '15', '0', '4198', '1', '0', '2015-12-18 12:24:48');
INSERT INTO `lifetek_transfer_stores` VALUES ('61', '15', '0', '4222', '1', '0', '2015-12-19 09:50:35');
INSERT INTO `lifetek_transfer_stores` VALUES ('62', '15', '0', '4227', '0', '0', '2015-12-19 09:50:35');
INSERT INTO `lifetek_transfer_stores` VALUES ('63', '15', '0', '4228', '2', '0', '2015-12-19 09:55:07');
INSERT INTO `lifetek_transfer_stores` VALUES ('64', '15', '0', '4299', '1', '0', '2015-12-19 09:57:20');
INSERT INTO `lifetek_transfer_stores` VALUES ('65', '15', '0', '4537', '20', '0', '2015-12-19 10:02:13');
INSERT INTO `lifetek_transfer_stores` VALUES ('66', '25', '0', '4329', '1', '0', '2015-12-21 11:42:02');
INSERT INTO `lifetek_transfer_stores` VALUES ('67', '9', '0', '4328', '120', '0', '2015-12-22 14:28:20');
INSERT INTO `lifetek_transfer_stores` VALUES ('68', '25', '0', '4178', '7', '0', '2015-12-22 14:33:48');
INSERT INTO `lifetek_transfer_stores` VALUES ('69', '9', '0', '4541', '8', '0', '2015-12-22 15:15:32');
INSERT INTO `lifetek_transfer_stores` VALUES ('70', '25', '0', '4534', '1', '0', '2015-12-24 14:16:42');
INSERT INTO `lifetek_transfer_stores` VALUES ('71', '15', '0', '4447', '0', '0', '2015-12-25 10:33:01');
INSERT INTO `lifetek_transfer_stores` VALUES ('72', '15', '0', '4447', '10', '0', '2015-12-25 10:33:45');
INSERT INTO `lifetek_transfer_stores` VALUES ('73', '3', '0', '4551', '0', '0', '2015-12-26 12:16:53');
INSERT INTO `lifetek_transfer_stores` VALUES ('74', '3', '0', '4552', '0', '0', '2015-12-26 12:16:53');
INSERT INTO `lifetek_transfer_stores` VALUES ('75', '3', '0', '4595', '10', '0', '2016-01-06 14:44:07');
INSERT INTO `lifetek_transfer_stores` VALUES ('76', '3', '0', '4596', '10', '0', '2016-01-06 14:44:07');

-- ----------------------------
-- Table structure for lifetek_units
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_units`;
CREATE TABLE `lifetek_units` (
  `id_unit` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delete` int(1) NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_units
-- ----------------------------
INSERT INTO `lifetek_units` VALUES ('1', 'Cốc', '0');

-- ----------------------------
-- Table structure for lifetek_users
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_users`;
CREATE TABLE `lifetek_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group` int(10) unsigned DEFAULT NULL,
  `activation_key` varchar(32) DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `password` (`password`),
  KEY `group` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_users
-- ----------------------------
INSERT INTO `lifetek_users` VALUES ('1', 'admin102', 'c110cb67c8edc55d8eb4e48cd6493784d8988f38', 'hoanghung888@gmail.com', '1', '2', null, '2012-04-20 09:29:19', '2012-03-25 08:09:10', null);
INSERT INTO `lifetek_users` VALUES ('10', 'admin', 'c110cb67c8edc55d8eb4e48cd6493784d8988f38', 'hunght1188@gmail.com', '1', '2', null, '2014-03-19 09:49:13', '2012-12-27 11:43:21', '2013-11-23 02:39:38');
INSERT INTO `lifetek_users` VALUES ('11', 'nhanvien', 'c110cb67c8edc55d8eb4e48cd6493784d8988f38', 'nhanvien@gmail.com', '1', '7', null, null, '2013-11-25 02:56:05', null);

-- ----------------------------
-- Table structure for lifetek_user_profiles
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_user_profiles`;
CREATE TABLE `lifetek_user_profiles` (
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_user_profiles
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_vendors
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_vendors`;
CREATE TABLE `lifetek_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(200) NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_vendors
-- ----------------------------
INSERT INTO `lifetek_vendors` VALUES ('1', '', 'http://www.24h.com.vn/');
INSERT INTO `lifetek_vendors` VALUES ('2', '', 'a');
INSERT INTO `lifetek_vendors` VALUES ('3', '', 'www.zingme.vn');
INSERT INTO `lifetek_vendors` VALUES ('4', '', 'www.vietbao.combbnb');

-- ----------------------------
-- Table structure for lifetek_visa
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_visa`;
CREATE TABLE `lifetek_visa` (
  `id_visa` int(11) NOT NULL AUTO_INCREMENT,
  `name_visa` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_visa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of lifetek_visa
-- ----------------------------
INSERT INTO `lifetek_visa` VALUES ('1', 'Việt Nam', '0');
INSERT INTO `lifetek_visa` VALUES ('2', 'Mỹ', '0');
INSERT INTO `lifetek_visa` VALUES ('3', 'Thái lan', '0');
INSERT INTO `lifetek_visa` VALUES ('4', 'Anh', '0');

-- ----------------------------
-- Table structure for lifetek_votes
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_votes`;
CREATE TABLE `lifetek_votes` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `voted_on` datetime NOT NULL,
  `ip` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lifetek_votes
-- ----------------------------

-- ----------------------------
-- Table structure for lifetek_warehouse_items
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_warehouse_items`;
CREATE TABLE `lifetek_warehouse_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) NOT NULL COMMENT 'mã bảng kho/khonhang',
  `store_id` int(11) NOT NULL COMMENT 'kho chuyen',
  `item_id` int(11) NOT NULL COMMENT 'mã sản phẩm or nguyên vật liệu',
  `quantity` double(20,2) NOT NULL COMMENT 'số lượng ',
  `stt` int(11) NOT NULL COMMENT 'trạng thái',
  `date` datetime NOT NULL COMMENT 'thời gian chuyển , nhận',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='số lượng lưu trữ của từng kho';

-- ----------------------------
-- Records of lifetek_warehouse_items
-- ----------------------------
INSERT INTO `lifetek_warehouse_items` VALUES ('1', '2', '0', '4107', '90.00', '0', '2015-07-30 17:31:40');
INSERT INTO `lifetek_warehouse_items` VALUES ('2', '3', '0', '4110', '984.10', '1', '2015-07-31 09:37:23');
INSERT INTO `lifetek_warehouse_items` VALUES ('3', '3', '0', '4111', '887.00', '1', '2015-07-31 09:37:23');
INSERT INTO `lifetek_warehouse_items` VALUES ('5', '3', '0', '4108', '199.00', '0', '2015-08-01 14:06:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('6', '5', '0', '4120', '10.00', '1', '2015-08-04 10:21:50');
INSERT INTO `lifetek_warehouse_items` VALUES ('8', '2', '0', '4121', '1.00', '0', '2015-08-04 10:47:09');
INSERT INTO `lifetek_warehouse_items` VALUES ('9', '2', '0', '4123', '1.00', '0', '2015-08-04 11:06:14');
INSERT INTO `lifetek_warehouse_items` VALUES ('10', '2', '0', '4124', '0.03', '0', '2015-08-04 11:10:00');
INSERT INTO `lifetek_warehouse_items` VALUES ('11', '3', '0', '4121', '1.00', '0', '2015-08-04 14:08:50');
INSERT INTO `lifetek_warehouse_items` VALUES ('12', '2', '0', '4126', '999.00', '1', '2015-08-05 09:20:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('13', '5', '0', '4125', '9.00', '1', '2015-08-05 10:15:50');
INSERT INTO `lifetek_warehouse_items` VALUES ('15', '6', '0', '4120', '6.00', '1', '2015-08-13 16:23:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('16', '7', '0', '4120', '9.00', '0', '2015-08-07 11:04:42');
INSERT INTO `lifetek_warehouse_items` VALUES ('17', '8', '0', '4120', '5.00', '0', '2015-08-07 11:27:24');
INSERT INTO `lifetek_warehouse_items` VALUES ('18', '2', '0', '4139', '10.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('19', '2', '0', '4140', '10.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('20', '2', '0', '4141', '10.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('21', '2', '0', '4142', '101.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('22', '2', '0', '4143', '10.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('23', '2', '0', '4144', '10.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('24', '2', '0', '4145', '101.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('25', '2', '0', '4146', '99.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('26', '2', '0', '4147', '88.00', '0', '2015-08-08 09:43:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('27', '10', '0', '4143', '3.00', '0', '2015-08-08 10:11:40');
INSERT INTO `lifetek_warehouse_items` VALUES ('29', '8', '0', '4148', '110.00', '1', '2015-08-12 14:28:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('30', '6', '0', '4151', '20.00', '0', '2015-08-13 09:53:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('31', '6', '0', '4112', '80.90', '0', '2015-08-13 10:11:46');
INSERT INTO `lifetek_warehouse_items` VALUES ('32', '3', '0', '4118', '6.00', '0', '2015-08-13 11:37:24');
INSERT INTO `lifetek_warehouse_items` VALUES ('33', '6', '0', '4155', '20.00', '0', '2015-08-13 16:01:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('34', '6', '0', '4107', '1.00', '0', '2015-08-13 16:06:16');
INSERT INTO `lifetek_warehouse_items` VALUES ('35', '6', '0', '4153', '1.00', '1', '2015-08-13 16:23:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('36', '3', '0', '4159', '298.00', '1', '2015-10-19 14:01:15');
INSERT INTO `lifetek_warehouse_items` VALUES ('37', '3', '0', '4158', '1087.00', '1', '2015-09-04 11:45:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('38', '6', '0', '4158', '63.00', '1', '2015-08-14 10:23:56');
INSERT INTO `lifetek_warehouse_items` VALUES ('39', '3', '0', '4199', '8.46', '0', '2015-08-14 10:39:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('40', '3', '0', '4200', '10.68', '1', '2015-10-06 15:52:30');
INSERT INTO `lifetek_warehouse_items` VALUES ('41', '3', '0', '4172', '0.00', '1', '2015-08-14 11:14:47');
INSERT INTO `lifetek_warehouse_items` VALUES ('42', '6', '0', '4206', '20.00', '0', '2015-08-15 11:23:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('43', '2', '0', '4196', '0.00', '0', '2015-08-19 13:42:54');
INSERT INTO `lifetek_warehouse_items` VALUES ('44', '3', '0', '4216', '1000.00', '1', '2015-08-28 16:39:39');
INSERT INTO `lifetek_warehouse_items` VALUES ('45', '3', '0', '4220', '999.00', '0', '2015-08-20 16:37:51');
INSERT INTO `lifetek_warehouse_items` VALUES ('52', '3', '0', '4230', '10.00', '0', '2015-08-24 13:59:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('54', '3', '0', '4232', '10.00', '1', '2015-08-25 10:20:22');
INSERT INTO `lifetek_warehouse_items` VALUES ('63', '3', '0', '4218', '110.00', '1', '2015-10-13 14:39:56');
INSERT INTO `lifetek_warehouse_items` VALUES ('78', '5', '0', '4254', '7.00', '1', '2015-08-31 11:11:44');
INSERT INTO `lifetek_warehouse_items` VALUES ('79', '10', '0', '4159', '10.00', '1', '2015-08-31 12:10:08');
INSERT INTO `lifetek_warehouse_items` VALUES ('80', '3', '0', '4255', '2009.00', '1', '2015-08-31 17:29:16');
INSERT INTO `lifetek_warehouse_items` VALUES ('81', '3', '0', '4256', '2010.00', '1', '2015-08-31 17:29:16');
INSERT INTO `lifetek_warehouse_items` VALUES ('82', '4', '0', '4257', '2.00', '0', '2015-09-01 10:56:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('83', '4', '0', '4258', '3.00', '0', '2015-09-01 10:56:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('84', '4', '0', '4259', '3.00', '0', '2015-09-01 10:56:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('85', '4', '0', '4260', '20.00', '0', '2015-09-01 11:03:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('86', '4', '0', '4261', '30.00', '0', '2015-09-01 11:03:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('87', '4', '0', '4262', '10.00', '0', '2015-09-01 11:03:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('88', '4', '0', '4263', '8.00', '0', '2015-09-01 11:35:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('89', '4', '0', '4264', '79.00', '0', '2015-09-01 11:35:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('90', '4', '0', '4268', '20.00', '0', '2015-09-01 15:39:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('91', '4', '0', '4269', '10.00', '0', '2015-09-01 15:39:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('92', '4', '0', '4270', '10.00', '0', '2015-09-01 15:39:06');
INSERT INTO `lifetek_warehouse_items` VALUES ('93', '4', '0', '4271', '10.00', '0', '2015-09-01 17:07:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('94', '4', '0', '4274', '10.00', '0', '2015-09-01 17:07:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('95', '3', '0', '4282', '129.00', '1', '2015-09-08 17:10:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('96', '3', '0', '4277', '45.11', '0', '2015-09-08 17:01:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('97', '3', '0', '4278', '64.32', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('98', '3', '0', '4279', '45.00', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('99', '3', '0', '4280', '398.00', '1', '2015-10-05 14:23:43');
INSERT INTO `lifetek_warehouse_items` VALUES ('100', '3', '0', '4281', '10.00', '0', '2015-09-03 09:58:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('101', '8', '0', '4288', '10.00', '0', '2015-09-04 13:58:47');
INSERT INTO `lifetek_warehouse_items` VALUES ('102', '3', '0', '4293', '885.00', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('103', '3', '0', '4294', '885.00', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('104', '3', '0', '4291', '50.00', '1', '2015-10-05 14:24:58');
INSERT INTO `lifetek_warehouse_items` VALUES ('105', '3', '0', '4290', '140.00', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('106', '3', '0', '4289', '140.00', '0', '2015-09-04 11:27:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('107', '3', '0', '4292', '9845.00', '0', '2015-09-04 11:58:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('108', '5', '0', '4288', '-3.00', '0', '2015-09-04 13:48:54');
INSERT INTO `lifetek_warehouse_items` VALUES ('109', '4', '0', '4310', '10.00', '0', '2015-09-04 17:07:15');
INSERT INTO `lifetek_warehouse_items` VALUES ('110', '4', '0', '4311', '100.00', '0', '2015-09-04 17:07:15');
INSERT INTO `lifetek_warehouse_items` VALUES ('111', '4', '0', '4299', '35.00', '0', '2015-09-07 16:37:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('112', '4', '0', '4300', '35.00', '0', '2015-09-07 16:37:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('113', '4', '0', '4301', '35.00', '0', '2015-09-07 16:37:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('114', '4', '0', '4314', '27.00', '0', '2015-09-08 13:52:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('115', '4', '0', '4315', '26.00', '0', '2015-09-08 13:52:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('116', '4', '0', '4316', '27.00', '0', '2015-09-08 13:52:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('117', '4', '0', '4317', '27.00', '0', '2015-09-08 13:52:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('118', '4', '0', '4329', '-3.00', '0', '2015-12-16 16:58:20');
INSERT INTO `lifetek_warehouse_items` VALUES ('119', '4', '0', '4330', '-1.00', '0', '2015-12-16 16:50:12');
INSERT INTO `lifetek_warehouse_items` VALUES ('120', '10', '0', '4326', '15.00', '1', '2015-09-23 14:51:36');
INSERT INTO `lifetek_warehouse_items` VALUES ('121', '4', '0', '4332', '40.00', '0', '2015-09-23 17:10:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('122', '4', '0', '4333', '10.00', '0', '2015-09-23 17:05:18');
INSERT INTO `lifetek_warehouse_items` VALUES ('123', '4', '0', '4334', '30.00', '0', '2015-09-23 17:05:18');
INSERT INTO `lifetek_warehouse_items` VALUES ('124', '4', '0', '4335', '20.00', '0', '2015-09-23 17:39:49');
INSERT INTO `lifetek_warehouse_items` VALUES ('125', '4', '0', '4337', '30.00', '0', '2015-09-24 15:41:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('126', '4', '0', '4338', '40.00', '0', '2015-09-24 15:41:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('127', '4', '0', '4339', '30.00', '0', '2015-09-24 15:41:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('128', '4', '0', '4340', '10.00', '0', '2015-09-25 10:23:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('129', '4', '0', '4341', '20.00', '0', '2015-09-25 10:23:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('130', '4', '0', '4342', '13.00', '0', '2015-09-30 11:45:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('131', '4', '0', '4344', '130.00', '0', '2015-09-30 15:19:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('132', '4', '0', '4345', '110.00', '0', '2015-09-30 15:19:22');
INSERT INTO `lifetek_warehouse_items` VALUES ('133', '4', '0', '4346', '10.00', '0', '2015-09-30 15:04:47');
INSERT INTO `lifetek_warehouse_items` VALUES ('134', '4', '0', '4347', '12.00', '0', '2015-09-30 15:13:22');
INSERT INTO `lifetek_warehouse_items` VALUES ('135', '4', '0', '4348', '23.00', '0', '2015-09-30 16:12:39');
INSERT INTO `lifetek_warehouse_items` VALUES ('136', '4', '0', '4349', '100.00', '0', '2015-10-01 15:47:18');
INSERT INTO `lifetek_warehouse_items` VALUES ('137', '4', '0', '4350', '100.00', '0', '2015-10-01 15:47:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('138', '4', '0', '4351', '100.00', '0', '2015-10-01 15:47:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('139', '4', '0', '4352', '200.00', '0', '2015-10-02 09:01:41');
INSERT INTO `lifetek_warehouse_items` VALUES ('140', '4', '0', '4353', '100.00', '0', '2015-10-02 13:41:34');
INSERT INTO `lifetek_warehouse_items` VALUES ('141', '4', '0', '4354', '100.00', '0', '2015-10-02 13:41:40');
INSERT INTO `lifetek_warehouse_items` VALUES ('142', '4', '0', '4355', '100.00', '0', '2015-10-02 13:41:46');
INSERT INTO `lifetek_warehouse_items` VALUES ('143', '4', '0', '4356', '1112.00', '0', '2015-10-02 15:40:27');
INSERT INTO `lifetek_warehouse_items` VALUES ('144', '4', '0', '4357', '100.00', '0', '2015-10-02 13:42:08');
INSERT INTO `lifetek_warehouse_items` VALUES ('145', '4', '0', '4358', '100.00', '0', '2015-10-02 13:42:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('146', '4', '0', '4359', '400.00', '0', '2015-10-02 13:58:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('147', '4', '0', '4360', '122.00', '0', '2015-10-02 15:47:43');
INSERT INTO `lifetek_warehouse_items` VALUES ('148', '14', '0', '4166', '1.00', '0', '2015-10-06 10:20:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('149', '4', '0', '4367', '1000000.00', '0', '2015-10-06 16:12:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('150', '4', '0', '4368', '1000.00', '0', '2015-10-06 16:12:27');
INSERT INTO `lifetek_warehouse_items` VALUES ('151', '4', '0', '4369', '10000.00', '0', '2015-10-06 16:12:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('152', '4', '0', '4370', '100000.00', '0', '2015-10-06 16:12:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('153', '4', '0', '4371', '1.00', '0', '2015-10-06 16:08:39');
INSERT INTO `lifetek_warehouse_items` VALUES ('154', '4', '0', '4372', '2.00', '0', '2015-10-06 16:08:39');
INSERT INTO `lifetek_warehouse_items` VALUES ('155', '4', '0', '4373', '122.00', '0', '2015-10-06 16:39:46');
INSERT INTO `lifetek_warehouse_items` VALUES ('156', '4', '0', '4374', '100.00', '0', '2015-10-09 15:11:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('157', '4', '0', '4375', '100.00', '0', '2015-10-09 15:11:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('158', '4', '0', '4376', '100.00', '0', '2015-10-09 15:11:49');
INSERT INTO `lifetek_warehouse_items` VALUES ('159', '4', '0', '4377', '100.00', '0', '2015-10-09 15:11:49');
INSERT INTO `lifetek_warehouse_items` VALUES ('160', '4', '0', '4378', '100.00', '0', '2015-10-09 15:11:49');
INSERT INTO `lifetek_warehouse_items` VALUES ('161', '4', '0', '4379', '110.00', '0', '2015-10-09 17:56:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('162', '4', '0', '4382', '100.00', '0', '2015-10-09 15:38:12');
INSERT INTO `lifetek_warehouse_items` VALUES ('163', '4', '0', '4383', '120.00', '0', '2015-10-09 16:42:56');
INSERT INTO `lifetek_warehouse_items` VALUES ('164', '4', '0', '4384', '10.00', '0', '2015-10-09 17:56:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('165', '8', '0', '4194', '1.00', '1', '2015-10-10 10:09:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('166', '8', '0', '4194', '1.00', '1', '2015-10-10 10:09:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('167', '2', '0', '4385', '17.00', '1', '2015-10-10 10:13:09');
INSERT INTO `lifetek_warehouse_items` VALUES ('168', '9', '0', '4385', '30.00', '1', '2015-10-10 10:17:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('169', '5', '0', '4385', '-3.00', '1', '2015-10-10 10:31:50');
INSERT INTO `lifetek_warehouse_items` VALUES ('170', '3', '0', '4385', '17.00', '1', '2015-11-17 13:41:34');
INSERT INTO `lifetek_warehouse_items` VALUES ('171', '4', '0', '4386', '120.00', '0', '2015-10-10 11:50:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('172', '4', '0', '4387', '100.00', '0', '2015-10-10 11:50:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('173', '4', '0', '4388', '134.00', '0', '2015-10-10 11:50:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('174', '4', '0', '4389', '3.00', '0', '2015-11-07 14:33:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('175', '4', '0', '4390', '5.00', '0', '2015-11-07 14:33:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('176', '4', '0', '4391', '2.00', '0', '2015-11-07 14:33:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('177', '4', '0', '4392', '4.00', '0', '2015-10-12 10:49:57');
INSERT INTO `lifetek_warehouse_items` VALUES ('178', '4', '0', '4393', '5.00', '0', '2015-10-12 10:49:57');
INSERT INTO `lifetek_warehouse_items` VALUES ('179', '4', '0', '4394', '1.00', '0', '2015-10-12 10:49:57');
INSERT INTO `lifetek_warehouse_items` VALUES ('180', '4', '0', '4395', '8.00', '1', '2015-10-13 11:52:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('181', '4', '0', '4396', '50.00', '0', '2015-10-13 14:14:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('182', '4', '0', '4397', '150.00', '0', '2015-10-13 14:14:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('183', '4', '0', '4398', '100.00', '0', '2015-10-13 14:14:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('184', '4', '0', '4399', '50.00', '0', '2015-10-13 14:14:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('185', '15', '0', '4400', '6.00', '1', '2015-10-14 11:57:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('186', '5', '0', '4218', '295.00', '1', '2015-10-13 14:39:56');
INSERT INTO `lifetek_warehouse_items` VALUES ('187', '0', '0', '0', '0.00', '0', '2015-10-14 11:52:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('188', '15', '0', '4403', '10.00', '1', '2015-10-14 11:57:29');
INSERT INTO `lifetek_warehouse_items` VALUES ('189', '5', '0', '4178', '-2.00', '1', '2015-10-14 14:13:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('190', '15', '0', '4329', '0.00', '1', '2015-10-20 14:36:35');
INSERT INTO `lifetek_warehouse_items` VALUES ('191', '15', '0', '4159', '5.00', '1', '2015-10-23 19:46:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('192', '15', '0', '4178', '1.00', '1', '2015-10-22 14:09:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('193', '15', '0', '4210', '1.00', '1', '2015-10-22 15:00:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('194', '3', '0', '4306', '101.00', '1', '2015-11-24 11:26:10');
INSERT INTO `lifetek_warehouse_items` VALUES ('195', '3', '0', '4180', '1.00', '1', '2015-10-26 16:06:40');
INSERT INTO `lifetek_warehouse_items` VALUES ('196', '15', '0', '4179', '1.00', '0', '2015-10-26 22:00:03');
INSERT INTO `lifetek_warehouse_items` VALUES ('197', '10', '0', '4166', '1.00', '0', '2015-10-26 22:00:51');
INSERT INTO `lifetek_warehouse_items` VALUES ('198', '15', '0', '4180', '1.00', '1', '2015-10-27 13:02:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('199', '15', '0', '4383', '1.00', '1', '2015-10-27 13:02:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('200', '14', '0', '4379', '1.00', '0', '2015-10-27 13:37:57');
INSERT INTO `lifetek_warehouse_items` VALUES ('201', '15', '0', '4193', '1.00', '1', '2015-10-27 15:05:02');
INSERT INTO `lifetek_warehouse_items` VALUES ('202', '4', '0', '4427', '1.00', '0', '2015-10-28 12:01:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('203', '4', '0', '4428', '2.00', '0', '2015-10-29 15:56:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('204', '4', '0', '4429', '1.00', '0', '2015-10-28 12:01:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('205', '4', '0', '4431', '2.00', '0', '2015-10-29 15:56:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('206', '15', '0', '4367', '1.00', '0', '2015-11-11 13:37:03');
INSERT INTO `lifetek_warehouse_items` VALUES ('207', '15', '0', '4227', '1.02', '0', '2015-12-19 09:50:35');
INSERT INTO `lifetek_warehouse_items` VALUES ('208', '22', '0', '4193', '0.00', '0', '2015-11-12 14:28:32');
INSERT INTO `lifetek_warehouse_items` VALUES ('209', '4', '0', '4449', '2.00', '0', '2015-11-12 17:23:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('210', '4', '0', '4450', '1.00', '0', '2015-11-12 17:23:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('211', '0', '0', '0', '0.00', '0', '2015-11-12 17:23:19');
INSERT INTO `lifetek_warehouse_items` VALUES ('212', '4', '0', '4457', '10.00', '0', '2015-11-17 17:15:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('213', '4', '0', '4458', '21.00', '0', '2015-11-17 17:28:12');
INSERT INTO `lifetek_warehouse_items` VALUES ('214', '4', '0', '4459', '1.00', '0', '2015-11-17 17:15:59');
INSERT INTO `lifetek_warehouse_items` VALUES ('215', '4', '0', '4460', '5.00', '0', '2015-11-18 09:44:02');
INSERT INTO `lifetek_warehouse_items` VALUES ('216', '4', '0', '4461', '3.00', '0', '2015-11-18 09:44:02');
INSERT INTO `lifetek_warehouse_items` VALUES ('217', '4', '0', '4462', '2.00', '0', '2015-11-18 09:44:02');
INSERT INTO `lifetek_warehouse_items` VALUES ('218', '4', '0', '4463', '10.00', '0', '2015-11-18 10:09:58');
INSERT INTO `lifetek_warehouse_items` VALUES ('219', '4', '0', '4464', '2.00', '0', '2015-11-18 10:09:58');
INSERT INTO `lifetek_warehouse_items` VALUES ('220', '4', '0', '4465', '10.00', '0', '2015-11-18 10:26:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('221', '4', '0', '4466', '2.00', '0', '2015-11-18 10:26:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('222', '4', '0', '4467', '2.00', '0', '2015-11-18 10:44:22');
INSERT INTO `lifetek_warehouse_items` VALUES ('223', '4', '0', '4468', '1.00', '0', '2015-11-18 10:59:39');
INSERT INTO `lifetek_warehouse_items` VALUES ('224', '4', '0', '4469', '1.00', '0', '2015-11-18 11:19:06');
INSERT INTO `lifetek_warehouse_items` VALUES ('225', '4', '0', '4470', '5.00', '0', '2015-11-18 11:46:06');
INSERT INTO `lifetek_warehouse_items` VALUES ('226', '4', '0', '4471', '15.00', '0', '2015-11-18 11:46:06');
INSERT INTO `lifetek_warehouse_items` VALUES ('227', '4', '0', '4472', '10.00', '0', '2015-11-18 11:46:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('228', '4', '0', '4473', '10.00', '0', '2015-11-18 11:46:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('229', '4', '0', '4474', '1.00', '0', '2015-11-18 11:57:16');
INSERT INTO `lifetek_warehouse_items` VALUES ('230', '3', '0', '4475', '1.00', '0', '2015-11-18 13:58:45');
INSERT INTO `lifetek_warehouse_items` VALUES ('231', '4', '0', '4476', '3.00', '0', '2015-11-18 14:33:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('232', '4', '0', '4477', '1.00', '0', '2015-11-18 14:22:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('233', '4', '0', '4478', '25.00', '0', '2015-11-18 15:24:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('234', '4', '0', '4479', '20.00', '0', '2015-11-18 16:36:43');
INSERT INTO `lifetek_warehouse_items` VALUES ('235', '4', '0', '4480', '11.00', '0', '2015-11-18 15:35:56');
INSERT INTO `lifetek_warehouse_items` VALUES ('236', '4', '0', '4481', '5.00', '0', '2015-11-18 16:27:33');
INSERT INTO `lifetek_warehouse_items` VALUES ('237', '4', '0', '4482', '12.00', '0', '2015-11-18 16:27:33');
INSERT INTO `lifetek_warehouse_items` VALUES ('238', '4', '0', '4483', '4.00', '0', '2015-11-18 16:27:33');
INSERT INTO `lifetek_warehouse_items` VALUES ('239', '4', '0', '4484', '3.00', '0', '2015-11-18 16:27:33');
INSERT INTO `lifetek_warehouse_items` VALUES ('240', '4', '0', '4485', '12.00', '0', '2015-11-19 09:40:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('241', '4', '0', '4486', '1.00', '0', '2015-11-19 08:57:14');
INSERT INTO `lifetek_warehouse_items` VALUES ('242', '4', '0', '4487', '4.00', '0', '2015-11-19 09:40:52');
INSERT INTO `lifetek_warehouse_items` VALUES ('243', '3', '0', '4488', '10.02', '1', '2015-11-19 10:11:42');
INSERT INTO `lifetek_warehouse_items` VALUES ('244', '4', '0', '4489', '20.00', '0', '2015-11-19 10:28:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('245', '4', '0', '4490', '4.00', '0', '2015-11-19 10:28:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('246', '4', '0', '4491', '4.00', '0', '2015-11-19 10:28:25');
INSERT INTO `lifetek_warehouse_items` VALUES ('247', '4', '0', '4492', '7.00', '0', '2015-11-19 10:39:44');
INSERT INTO `lifetek_warehouse_items` VALUES ('248', '4', '0', '4493', '4.00', '0', '2015-11-19 10:34:11');
INSERT INTO `lifetek_warehouse_items` VALUES ('249', '4', '0', '4494', '12.00', '0', '2015-11-19 11:03:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('250', '4', '0', '4495', '6.00', '0', '2015-11-19 11:11:09');
INSERT INTO `lifetek_warehouse_items` VALUES ('251', '4', '0', '4496', '2.00', '0', '2015-11-19 10:54:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('252', '4', '0', '4497', '10.00', '0', '2015-11-19 11:03:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('253', '4', '0', '4498', '5.00', '0', '2015-11-19 11:03:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('254', '4', '0', '4499', '10.00', '0', '2015-11-19 11:03:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('255', '4', '0', '4500', '12.00', '0', '2015-11-24 11:47:23');
INSERT INTO `lifetek_warehouse_items` VALUES ('256', '4', '0', '4504', '1.00', '0', '2015-11-24 08:38:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('257', '4', '0', '4505', '1.00', '0', '2015-11-24 08:38:21');
INSERT INTO `lifetek_warehouse_items` VALUES ('258', '4', '0', '4506', '1.00', '0', '2015-11-24 11:47:23');
INSERT INTO `lifetek_warehouse_items` VALUES ('259', '4', '0', '4507', '1.00', '0', '2015-11-24 11:51:49');
INSERT INTO `lifetek_warehouse_items` VALUES ('260', '4', '0', '4508', '105.00', '0', '2015-11-24 14:08:24');
INSERT INTO `lifetek_warehouse_items` VALUES ('261', '4', '0', '4509', '40.00', '0', '2015-11-24 16:04:17');
INSERT INTO `lifetek_warehouse_items` VALUES ('262', '4', '0', '4510', '20.00', '0', '2015-11-24 16:04:17');
INSERT INTO `lifetek_warehouse_items` VALUES ('263', '4', '0', '4511', '104.00', '0', '2015-12-10 16:05:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('264', '4', '0', '4512', '2.00', '0', '2015-11-25 10:58:14');
INSERT INTO `lifetek_warehouse_items` VALUES ('265', '4', '0', '4513', '4.00', '0', '2015-11-25 10:58:14');
INSERT INTO `lifetek_warehouse_items` VALUES ('266', '4', '0', '4514', '11.00', '0', '2015-11-25 11:25:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('267', '2', '0', '4516', '20.00', '0', '2015-11-25 11:56:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('268', '4', '0', '4520', '230.00', '0', '2015-12-10 15:43:44');
INSERT INTO `lifetek_warehouse_items` VALUES ('269', '4', '0', '4521', '118.00', '0', '2015-12-10 14:57:05');
INSERT INTO `lifetek_warehouse_items` VALUES ('270', '4', '0', '4522', '191.00', '0', '2015-12-10 15:37:49');
INSERT INTO `lifetek_warehouse_items` VALUES ('271', '4', '0', '4527', '100.00', '0', '2015-12-10 15:21:30');
INSERT INTO `lifetek_warehouse_items` VALUES ('272', '22', '0', '4159', '1.00', '0', '2015-12-15 11:49:32');
INSERT INTO `lifetek_warehouse_items` VALUES ('273', '1', '0', '4528', '10.00', '0', '2015-12-15 13:43:34');
INSERT INTO `lifetek_warehouse_items` VALUES ('274', '1', '0', '4408', '10.00', '0', '2015-12-15 13:45:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('275', '1', '0', '4529', '10.00', '0', '2015-12-15 13:58:28');
INSERT INTO `lifetek_warehouse_items` VALUES ('276', '4', '0', '4534', '5.00', '0', '2015-12-16 14:45:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('277', '8', '0', '4329', '2.00', '0', '2015-12-16 16:55:46');
INSERT INTO `lifetek_warehouse_items` VALUES ('278', '8', '0', '4520', '1.00', '0', '2015-12-18 12:21:00');
INSERT INTO `lifetek_warehouse_items` VALUES ('279', '15', '0', '4198', '1.02', '0', '2015-12-18 12:24:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('280', '15', '0', '4222', '1.00', '0', '2015-12-19 09:50:35');
INSERT INTO `lifetek_warehouse_items` VALUES ('281', '15', '0', '4228', '2.00', '0', '2015-12-19 09:55:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('282', '15', '0', '4299', '1.00', '0', '2015-12-19 09:57:20');
INSERT INTO `lifetek_warehouse_items` VALUES ('283', '15', '0', '4537', '20.00', '0', '2015-12-19 10:02:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('284', '4', '0', '4538', '10.00', '0', '2015-12-21 10:42:50');
INSERT INTO `lifetek_warehouse_items` VALUES ('285', '4', '0', '4539', '10.00', '0', '2015-12-21 10:42:50');
INSERT INTO `lifetek_warehouse_items` VALUES ('286', '25', '0', '4329', '-1.00', '0', '2015-12-21 11:42:02');
INSERT INTO `lifetek_warehouse_items` VALUES ('287', '9', '0', '4329', '0.00', '1', '2015-12-22 11:06:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('288', '9', '0', '4498', '0.00', '1', '2015-12-22 11:06:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('289', '9', '0', '4541', '1.00', '1', '2015-12-22 15:15:32');
INSERT INTO `lifetek_warehouse_items` VALUES ('290', '9', '0', '4540', '-14.00', '1', '2015-12-22 11:31:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('291', '9', '0', '4328', '119.00', '0', '2015-12-22 14:28:20');
INSERT INTO `lifetek_warehouse_items` VALUES ('292', '25', '0', '4178', '1.00', '0', '2015-12-22 14:33:48');
INSERT INTO `lifetek_warehouse_items` VALUES ('293', '3', '0', '4541', '1.00', '1', '2015-12-24 11:06:54');
INSERT INTO `lifetek_warehouse_items` VALUES ('294', '3', '0', '4540', '1.00', '1', '2015-12-24 11:06:54');
INSERT INTO `lifetek_warehouse_items` VALUES ('295', '25', '0', '4534', '-2.00', '0', '2015-12-24 14:16:42');
INSERT INTO `lifetek_warehouse_items` VALUES ('296', '2', '0', '4282', '10.00', '0', '2015-12-25 09:12:03');
INSERT INTO `lifetek_warehouse_items` VALUES ('297', '2', '0', '4543', '20.00', '0', '2015-12-25 09:12:03');
INSERT INTO `lifetek_warehouse_items` VALUES ('298', '4', '0', '4544', '10.00', '0', '2015-12-25 09:21:30');
INSERT INTO `lifetek_warehouse_items` VALUES ('299', '4', '0', '4545', '10.00', '0', '2015-12-25 09:21:30');
INSERT INTO `lifetek_warehouse_items` VALUES ('300', '4', '0', '4546', '10.00', '0', '2015-12-25 09:21:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('301', '4', '0', '4547', '10.00', '0', '2015-12-25 09:38:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('302', '4', '0', '4548', '10.00', '0', '2015-12-25 09:38:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('303', '4', '0', '4549', '10.00', '0', '2015-12-25 09:38:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('304', '4', '0', '4550', '20.00', '0', '2015-12-25 10:32:39');
INSERT INTO `lifetek_warehouse_items` VALUES ('305', '26', '0', '4447', '2.00', '1', '2015-12-25 10:27:23');
INSERT INTO `lifetek_warehouse_items` VALUES ('306', '15', '0', '4447', '10.00', '0', '2015-12-25 10:33:45');
INSERT INTO `lifetek_warehouse_items` VALUES ('307', '3', '0', '4551', '0.10', '0', '2015-12-26 12:16:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('308', '3', '0', '4552', '0.10', '0', '2015-12-26 12:16:53');
INSERT INTO `lifetek_warehouse_items` VALUES ('309', '2', '0', '4559', '10.00', '0', '2015-12-31 09:13:16');
INSERT INTO `lifetek_warehouse_items` VALUES ('310', '2', '0', '4560', '10.00', '0', '2015-12-31 09:13:16');
INSERT INTO `lifetek_warehouse_items` VALUES ('311', '1', '0', '4557', '50.00', '0', '2015-12-31 09:14:17');
INSERT INTO `lifetek_warehouse_items` VALUES ('312', '3', '0', '4561', '30.00', '0', '2015-12-31 09:14:17');
INSERT INTO `lifetek_warehouse_items` VALUES ('313', '4', '0', '4562', '20.00', '0', '2015-12-31 09:14:17');
INSERT INTO `lifetek_warehouse_items` VALUES ('314', '2', '0', '4563', '10.00', '0', '2015-12-31 09:15:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('315', '2', '0', '4564', '10.00', '0', '2015-12-31 09:15:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('316', '2', '0', '4565', '10.00', '0', '2015-12-31 09:15:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('317', '2', '0', '4566', '10.00', '0', '2015-12-31 09:15:38');
INSERT INTO `lifetek_warehouse_items` VALUES ('318', '1', '0', '4567', '10.00', '0', '2015-12-31 09:17:40');
INSERT INTO `lifetek_warehouse_items` VALUES ('319', '1', '0', '4568', '20.00', '0', '2015-12-31 09:17:40');
INSERT INTO `lifetek_warehouse_items` VALUES ('320', '1', '0', '4569', '50.00', '0', '2015-12-31 09:24:46');
INSERT INTO `lifetek_warehouse_items` VALUES ('321', '3', '0', '4570', '30.00', '0', '2015-12-31 09:24:46');
INSERT INTO `lifetek_warehouse_items` VALUES ('322', '1', '0', '4571', '10.00', '0', '2015-12-31 09:33:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('323', '1', '0', '4572', '20.00', '0', '2015-12-31 09:33:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('324', '1', '0', '4573', '10.00', '0', '2015-12-31 09:33:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('325', '1', '0', '4574', '10.00', '0', '2015-12-31 09:33:13');
INSERT INTO `lifetek_warehouse_items` VALUES ('326', '1', '0', '4575', '10.00', '0', '2015-12-31 09:34:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('327', '1', '0', '4576', '20.00', '0', '2015-12-31 09:34:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('328', '1', '0', '4577', '10.00', '0', '2015-12-31 09:34:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('329', '1', '0', '4578', '10.00', '0', '2015-12-31 09:34:26');
INSERT INTO `lifetek_warehouse_items` VALUES ('330', '1', '0', '4582', '10.00', '0', '2015-12-31 11:07:01');
INSERT INTO `lifetek_warehouse_items` VALUES ('331', '1', '0', '4587', '10.00', '0', '2015-12-31 11:25:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('332', '1', '0', '4588', '20.00', '0', '2015-12-31 11:25:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('333', '1', '0', '4589', '30.00', '0', '2015-12-31 11:25:37');
INSERT INTO `lifetek_warehouse_items` VALUES ('334', '3', '0', '4595', '10.00', '0', '2016-01-06 14:44:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('335', '3', '0', '4596', '10.00', '0', '2016-01-06 14:44:07');
INSERT INTO `lifetek_warehouse_items` VALUES ('336', '4', '0', '4597', '2.00', '0', '2016-01-06 15:23:31');
INSERT INTO `lifetek_warehouse_items` VALUES ('337', '4', '0', '4599', '10.00', '0', '2016-01-06 17:32:18');
INSERT INTO `lifetek_warehouse_items` VALUES ('338', '4', '0', '4600', '1.00', '0', '2016-01-06 17:32:18');

-- ----------------------------
-- Table structure for lifetek_welfare_rewards
-- ----------------------------
DROP TABLE IF EXISTS `lifetek_welfare_rewards`;
CREATE TABLE `lifetek_welfare_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_lunch` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_seniority` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_position` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_project` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_computer` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_petrol_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_other_support` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`person_id`),
  KEY `person_id` (`person_id`),
  CONSTRAINT `lifetek_welfare_rewards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lifetek_welfare_rewards
-- ----------------------------

-- ----------------------------
-- Table structure for phppos_jobs_file
-- ----------------------------
DROP TABLE IF EXISTS `phppos_jobs_file`;
CREATE TABLE `phppos_jobs_file` (
  `jobs_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_file_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `jobs_file_date` date DEFAULT NULL,
  PRIMARY KEY (`jobs_file_id`,`person_id`),
  KEY `phppos_jobs_file_ibfk_1` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of phppos_jobs_file
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
