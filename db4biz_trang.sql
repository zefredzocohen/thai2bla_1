-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2016 at 04:08 AM
-- Server version: 5.1.65-log
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `longgiang88_name`
--

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_abouts`
--

CREATE TABLE IF NOT EXISTS `lifetek_abouts` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lifetek_abouts`
--

INSERT INTO `lifetek_abouts` (`id`, `yahoo`, `skype`, `deleted`, `active`, `title`, `parts_id`, `email`, `phone`, `fax`) VALUES
(1, 'support.lifetek', 'support.lifetek', 0, 1, '', 2, 'support@lifetek.com.vn', '04. 3762 1194', '04. 3762 1194');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_account_plan`
--

CREATE TABLE IF NOT EXISTS `lifetek_account_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tk_co` int(11) NOT NULL,
  `tk_no` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `lifetek_account_plan`
--

INSERT INTO `lifetek_account_plan` (`id`, `name`, `tk_co`, `tk_no`) VALUES
(6, 'Tạm ứng', 141, 1111),
(7, 'BH', 131, 111),
(8, 'Chi phí nhân công', 111, 622),
(9, 'chi ph van chuyen', 1562, 111),
(10, 'testdemo1', 711, 111),
(11, 'testdemo2', 515, 1111),
(12, 'testdemo3', 511, 111),
(13, 'testdemo4', 6417, 111),
(14, 'testdemo5', 111, 158),
(15, 'testdemo6', 344, 112),
(16, 'testdemo7', 2135, 1111),
(17, 'Chi cho khách hàng', 111, 521),
(18, 'Chi cho khách hàng', 1111, 521),
(19, 'Tài khoản trung hạn', 111, 55333),
(20, 'demo', 115, 1111),
(21, 'demo2', 121, 111);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_account_type`
--

CREATE TABLE IF NOT EXISTS `lifetek_account_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `lifetek_account_type`
--

INSERT INTO `lifetek_account_type` (`type_id`, `type_name`) VALUES
(3, 'Nợ phải thu'),
(6, 'Tài khoản tiền gửi'),
(7, 'Tài khoản tiền mặt'),
(8, 'Nguồn vốn'),
(9, 'Tài sản '),
(10, 'Nợ phải trả'),
(15, 'Doanh thu'),
(16, 'Chi phí'),
(17, 'Chờ phân bổ'),
(18, 'Kho');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_acl_actions`
--

CREATE TABLE IF NOT EXISTS `lifetek_acl_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(254) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lifetek_acl_actions`
--

INSERT INTO `lifetek_acl_actions` (`id`, `name`) VALUES
(1, 'Add'),
(3, 'Delete'),
(2, 'Edit');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_acl_groups`
--

CREATE TABLE IF NOT EXISTS `lifetek_acl_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(254) NOT NULL,
  `link` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `lifetek_acl_groups`
--

INSERT INTO `lifetek_acl_groups` (`id`, `lft`, `rgt`, `name`, `link`) VALUES
(1, 1, 10, 'Member', NULL),
(2, 2, 9, 'Administrator', NULL),
(4, 7, 8, 'Bán hàng', 0),
(6, 5, 6, 'Nội dung', 0),
(7, 3, 4, 'Kinh doanh', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_acl_permissions`
--

CREATE TABLE IF NOT EXISTS `lifetek_acl_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned NOT NULL DEFAULT '0',
  `aco_id` int(10) unsigned NOT NULL DEFAULT '0',
  `allow` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aro_id` (`aro_id`),
  KEY `aco_id` (`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `lifetek_acl_permissions`
--

INSERT INTO `lifetek_acl_permissions` (`id`, `aro_id`, `aco_id`, `allow`) VALUES
(1, 2, 1, 'Y'),
(2, 4, 5, 'N'),
(3, 4, 2, 'Y'),
(4, 4, 4, 'N'),
(7, 4, 20, 'N'),
(8, 1, 6, 'N'),
(15, 6, 28, 'Y'),
(16, 6, 24, 'Y'),
(17, 7, 20, 'Y'),
(18, 7, 36, 'Y'),
(20, 7, 34, 'N'),
(23, 1, 24, 'N'),
(24, 7, 35, 'N'),
(26, 7, 41, 'Y'),
(27, 7, 25, 'N'),
(28, 7, 14, 'Y'),
(29, 7, 40, 'N'),
(30, 7, 8, 'N'),
(31, 7, 9, 'N'),
(32, 7, 10, 'N'),
(33, 7, 29, 'N'),
(34, 7, 30, 'N'),
(35, 7, 31, 'N'),
(36, 7, 27, 'N'),
(37, 7, 32, 'N'),
(38, 7, 33, 'N'),
(39, 7, 24, 'N'),
(40, 7, 5, 'N'),
(41, 7, 4, 'N'),
(42, 7, 6, 'y'),
(43, 7, 7, 'N'),
(44, 7, 3, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_acl_permission_actions`
--

CREATE TABLE IF NOT EXISTS `lifetek_acl_permission_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_id` int(10) unsigned NOT NULL DEFAULT '0',
  `axo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `allow` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_id` (`access_id`),
  KEY `axo_id` (`axo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_acl_resources`
--

CREATE TABLE IF NOT EXISTS `lifetek_acl_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(254) NOT NULL,
  `link` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `lifetek_acl_resources`
--

INSERT INTO `lifetek_acl_resources` (`id`, `lft`, `rgt`, `name`, `link`) VALUES
(1, 1, 74, 'Site', NULL),
(2, 18, 73, 'Control Panel', NULL),
(3, 49, 68, 'System', NULL),
(4, 62, 63, 'Members', NULL),
(5, 52, 61, 'Access Control', NULL),
(6, 64, 65, 'Settings', NULL),
(7, 66, 67, 'Utilities', NULL),
(8, 59, 60, 'Permissions', NULL),
(9, 57, 58, 'Groups', NULL),
(10, 55, 56, 'Resources', NULL),
(11, 53, 54, 'Actions', NULL),
(12, 2, 17, 'Order', 0),
(13, 15, 16, 'Calendar', 0),
(14, 13, 14, 'Categories', 0),
(15, 11, 12, 'Customers', 0),
(17, 9, 10, 'Messages', 0),
(19, 7, 8, 'Pages', 0),
(20, 69, 72, 'Products', 0),
(22, 5, 6, 'Admins', 0),
(24, 37, 48, 'Interface', 0),
(25, 46, 47, 'Support', 0),
(26, 44, 45, 'Parts', 0),
(27, 42, 43, 'Bottom', 0),
(28, 29, 36, 'Content', 0),
(29, 34, 35, 'Sections', 0),
(30, 32, 33, 'Categories_news', 0),
(31, 30, 31, '_Content', 0),
(32, 40, 41, 'Positions', 0),
(33, 38, 39, 'Banner', 0),
(34, 3, 4, 'Orders', 0),
(35, 50, 51, 'Filemanager', 0),
(36, 21, 28, 'QLTT', 0),
(37, 26, 27, 'BoTT', 0),
(38, 24, 25, 'NhomTT', 0),
(39, 22, 23, 'ThuocTinh', 0),
(40, 19, 20, 'Attributes', 0),
(41, 70, 71, 'NCC', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_app_config`
--

CREATE TABLE IF NOT EXISTS `lifetek_app_config` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lifetek_app_config`
--

INSERT INTO `lifetek_app_config` (`key`, `value`) VALUES
('additional_payment_types', ' trả góp,trả trước, trả ngắn hạn'),
('address', '88 - Lý Thường Kiệt - T.T Thắng - Hiệp Hòa - Bắc Giang '),
('amazon_access_key', ''),
('amazon_secret_key', ''),
('brandname', 'SoLienLacDT'),
('check_auto', '0'),
('check_auto_birthday', '1'),
('check_auto_calendar', '1'),
('check_auto_contact', '1'),
('company', 'Công Ty CP xây dựng và sản xuất Việt Đức'),
('company_logo', '5'),
('config_phone_support', '7,555,555'),
('cong_no', '0'),
('constract_materialed', 'HỢP ĐỒNG KINH TẾ 6'),
('corp_bank_affiliate', 'Cầu Giấy'),
('corp_bank_name', 'Vietcombank'),
('corp_master_account', 'Phạm Thành Long'),
('corp_number_account', '98756543211'),
('currency_symbol', 'VNĐ'),
('currency_symbol_possition', '1'),
('date_format', 'little_endian'),
('default_payment_type', 'Tiền mặt'),
('default_tax_1_name', '0'),
('default_tax_1_rate', '0'),
('default_tax_2_cumulative', '0'),
('default_tax_2_name', '0'),
('default_tax_2_rate', '0'),
('default_tax_rate', '8'),
('delivery', '1'),
('disable_confirmation_sale', '1'),
('email', 'dungchip88@gmail.com'),
('email_cc', ''),
('enable_credit_card_processing', '1'),
('expired_contract', '30'),
('fax', '04 6265 00655'),
('gasoline', '88,888,885'),
('hide_signature', '1'),
('hide_suspended_sales_in_reports', '1'),
('language', 'vietnam'),
('mail_template', '7'),
('mail_template_birthday', '2'),
('mail_template_calendar', '1'),
('mail_template_contact', '1'),
('mailchimp_api_key', '33db57921a738d9e0c774c9f222979bc'),
('meals', '66,665'),
('merchant_id', 'admin'),
('merchant_password', '12345678'),
('nghiemthu_suspended', 'BIÊN BẢN BÀN GIAO, NGHIỆM THU 7'),
('number_of_items_per_page', '10'),
('pass_email', 'dungchiplananh'),
('pass_sms', 'v1m4@2e3'),
('phone', ': 02403 569 869   DĐ: 0904 998 438 - 0936 629 222 - 0962 352 333.'),
('phone_support', '100000'),
('print_after_sale', '1'),
('print_excel', 'print'),
('private_bank_affiliate', 'Cầu Giấy'),
('private_bank_name', 'Vietcombankk'),
('private_master_account', 'Phạm Thành Longg'),
('private_number_account', '9876543211'),
('receive_stock_alert', '0'),
('report_logo', 'logo.png'),
('return_policy', 'LifeOne'),
('speed_up_search_queries', '0'),
('stock_alert_email', 'luuthithanh2009@gmail.com'),
('thanhly_suspended', 'BIÊN BẢN THANH LÝ HỢP ĐỒNG 8'),
('time_format', '24_hour'),
('timezone', 'Asia/Bangkok'),
('title_contract', 'CUNG CẤP PHẦN MỀM  ỨNG DỤNG'),
('track_cash', '0'),
('user_sms', 'vmic'),
('website', 'www.lifetek.com.vnn');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_app_files`
--

CREATE TABLE IF NOT EXISTS `lifetek_app_files` (
  `file_id` int(10) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_data` longblob NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `lifetek_app_files`
--

INSERT INTO `lifetek_app_files` (`file_id`, `file_name`, `file_data`) VALUES
(5, 'logo.png', 0x89504e470d0a1a0a0000000d49484452000000430000003c08060000003dbe076700000e09494441546881edda7f8cdf757d07f0c7eb766b6e4dd335bd5bd7740721e5c40e0956c71011b1634814c360f8b3a8db1c2ac2550921841c0b316c911b0162982d4c71ba69d20386e81c43c6109131c4828cd4aa5d3dba5a0ed275d7e6d23497ee72b9d7fe787dee47dbebf5eedaf217afe4d3eff5f3797fde9ff7ebf97efd7ebd799d5ea7d7e9759a3dc56bf1913d9d5d8465d25bf10eac4a4e0e96a2ad1936867dd885edc973c1a694db3a065e3af05aacf38482b1a7f30dade459f8282e52ccefc2d6e67a4501309a2c0c3a702a4ec7c9588c17d08787b1bb7da0ff84adf7848031d8d9d512acc6750a84a1e4bbc13fe355c5e432acc012b46238d91df57c2fc6c8b3b19638abdecb7b88fbda07fa874ec4ba8f3b187b3abb96a4fc7488cfe200be8cefa023b934b8c0e4ae2f400b4884510c2b305e50e03da340bb166bc8e7899bc9e7db075e1a3b9e6b3fae60ece9eceac21770211ec29794045c85354a0de64223d8866f2a40df8abfc042fc1536b60ff48f1c8fb5731cc1d8d3d975063660a502e40974e363589a521ce173e3cf72da052562142f36f36e57409c8bdb84f5ed2ff71f17037b5cc0d8d3d9751abe8ee5ca4eec4e793b716e8cabc134742840d9c071e8a2a6803514dc89fb70232ec7171a408e59425a8f7582c1934eed90bea8ecc0d5ca4e7c3dc4aaf1313349c5d4e7c5f0e1f231fe6e94b1bd19bf8ddb94cde99176edf99dae8dedaf1c9ba7392630f67476b54a372891bd0e43f83b9c3675dc918098548d9872efa8b4009fc1a8529b154a6d3663cb9c9998424714e159d21a7c32f986b2fab76b80a81d9e917661ff38f3cdf857a529e27ec4395a1520ef5106b555b865ef496f683bd20bb3a17983b1a7b3ab4d89ecae28af713dce1e7f3e935a34f404764c193f9af2e18cd85b77a637a753a88dbc11adc95db828332f9e332353e85824e362c5fc5d4a1a3e34dd7c33c8c78f3030e5ff23217e14253166a3302956e0c628b7bb15d7ef39a96bded2312f30f67476b5a4bc1afd785405444ba61b7bb86720e588d2ef81ba9754b0b54db9ce59500a64ba00672a5bb55a3a6f6edc4c50cb9cc1d8d3d905ab429c83fbd1857366fb7ee3170615d3ff8db146a5f6a950fc102398cdbf87ca588cff2cc2c7d5a60ce2e37b3a4f9d353f5369be6a7281b2eadfc52558349797a3246228e5f634613077a51cc24f0f1bedc84a53fec8b959e1fd53389f583c97f5343477c9205bf0874a4777298fb2193ba719bc5f458e9b9af1e3b4451a267628f590ec8c887d4a32f61f32cf5ee245a54653f39141e2e73810e5debfa75ced2af3a0f948465bb22ae56615712e243f9c15199ab00a3c9de9ed781bfe2033af9b22e8cf09a35159eabe461576b4bfdc3f26ed36e165927477ca37e35db84101358cbfc49bf14ef436dfd98231e98c469de74263f300239604cb42fc1427930b8896c9b03b2403c1551196e027e4af44dcdf88fa18b664d52c5ab18b18c17f0d76769ddde843134ac67784eb42bc073f53758d45f85b057e377ea13cda29d88d41e18d478d72a6a1f948c6e2948b8a09cb89c3a2d8104f2abbd08365c4b69874a3bbb153e6f94aa477262351005ea22a5fffa922cc7b1560bfa782ba4d2abdffa64a083f59f36b6b7e35cf3be7c1dbd87cc2f1b6100b94b8ae4c5aa649acf64681d481c79478af563abd037b45bca59963475418bfbf19b34cd9a031e51d4695db6cc5598ad121950b2d9cf2d98568218753b4cd27039d3318c9584cf3b7837622ce54cc3ca5c2e69fe2f9e6e1d6946321baf02bbca4b2dc911027e39494db94513c2fc58b51127661b3de16ac4e9e8f52a7d5cdbc63528b88c33667b6346730a2b2d203aa6639d4303dd6307b075a43ae213e90f2ce10ffa3aa560de5738deb5ba93cd00bd811a24da9cde90ac49d29ae8ba62e925c16fc3eaec00dc1952abeb85819cfd39a4a591bf6bf5636635f732d5776a355254ccbf11c7e4c1cc06d216e54b6a243b9beb16473b022e592069061726bf3fe12bc29c47088fe2895f8363e4b0eaba08c0af2eec765cdbd57952d1a6be6d81907bbe059d17c6cc65003c2efe201dc83df6aae717a028f2bb0dfa4f4f963188c8a2dce0fb150017080f8b1ca6f5a9564b428237a99c6cd86786333f71d53bef31b29df18625fb38ea5cdf58bccb9cbc63cd42446526e51ba3a983c5625fe1c1baf4dd46f3689675006f167f884328a6f51116c4763809fc2fb9a4faca82bb7e019e24f95842c35f36ebf909cd7b8f82d1dafbc3457d6e66340730cdf57bb765af0c758879683d3f6981a433fad80f879e346cf6802b3c55199e7161375108b82538867f109e17c997729499ab60ea624f5d2284077e6449c32379ab3cd689a384fe040ca0fe39f30ac0c601bdaa2f99d725d887b93fea81c626553f168adbf2d512a234a62ce50b9ca19d206939db7c3e66efeff340e9017e1d18e81fee1d7040cc8b4038f87f88812fb471ddd60bd274aaf4f37d13208aa83d6a118a6007a738d8f2f63f1f4695a369741558cbe2cc5226558e745f302a3e3957e598c75a4fca8aa74bd7a94d7e003cdd8a959eecaacd862714e3278a18a3e3b8e5c1e0ac458663e98f2555c193c9593f1cc9c69de95ae28d17c2cc4a79b5b77a9a2cd116882a9b72a5518a7e5c11921dacae6046530574c7ce9e0f7a7d2e688f85288abb14cbab363a07f743efc700c60b40ff48f6655a5c7925bf020f18043d465bc283383a35b46bea3461e3a2a67fa6b972a06afc29fe081ac0d9a37fddab1bc7ce36f2edda598ffb390adc41d8ddf5fa9d9d2f1d2cc0c05e236a293f8f5f1bec9e4d849a938e4de106e4cb923c43d4a45afe978e5d81ad2c7d42a687fb95f467c257880f80c2e0f71ad830cea513385565312aee9413be8dea04afc3685d8d0bc7b43fb40ffc0342fce898eb56fa2e3e55f0e47c40d2a3bfdbcaa9277e3ab2a8799031d356adcae729217b23cc829e4b5ed03fd4fceed3bd3d33183014b5ffee55e7c0a8f283dbe59d9912bb15d056a33d0b85d39a2148d6023f96e2571ff185558ba8a78e838b080e30406b40ff40f6645997fa332cbefa9e4e9edc42d6674bd472cfa8eaa00efbd59ed88ab717f329cf2fdc443ed03fdc7ed8cc6713fac32d8796a4b53a6bb4d59faef08b74bdb525e14e25255a459814593aa1194040ca970fa7195b1eec44754c76e39fe1eb7b40ff4ef3ede6b3f21c798f69ef40699d9813f6f4479852adbf5e1599369fd321580b528fb329e116b6aa497927f1462b9b249b7e3d9f663882566a2137cc0adab45317d71cab521c603ae01959aefd41c70535e61992aec9eacc2f39d291f0bf14d6c9639d23e8f6c74b67442c118a7a66cdf86e5c9ea9067aafac4783157cad1a62e31a0ca842fa83ec97e61b4fde51377ca6f9c5e13300ea5069c0552ab9838e036268c61f444a9c1eb34079a5132ba7b3776c8f8488461dcb7be67ed617582eedebe45385f3a799ad9c68287d7f7ac7d75caf855584bfe2ff1b50dcd9ceb7afb5a928ba5b745f8bf4c5fdb70d3e47beb7afb1690e7c85895b44cf69d8da86feceebeb58fb09cbc80586cbcf457d5b6fe0d3d6b1f9f89df192b5d215608bd5931c2239abee8414054f1e572916d13cb8324e470466c75708cf151dc24dd277c75fc66662e26ae17d6245b83f5e3cfaee9ed6b4d6e26ae1179507d23198ab459c5342b65f68958ddb40da6f0e241e5aee707c6645c182d4788942f173e847dc457c93d53bf9e62cc94867477efc605d245cdf31fe0fc75bd7d4faeef593b8295c2e9cd279fceb0b2fbd6be2d1b6e5a3b127528e673b5def81a5e9eb286910cafaeebed5b90e9461167ab26775f6387a0256771de6b5635d0c9baee2475f7f6c1079537b823e52d77f75c31b3e1cb388d5c256290d88e9e64dbbadebe1d29cf516ef84003544f86eb1598ef8fcc4519f16072fddd3d6b0fedd25bd7dbb742b858a9cd0dc2c31b7ad6ce86bd099a051885c2e182916dc4191891f91f77df74c5e8badebe16b466e6047ac1e8fa9eb5633547ae09b1487a16a7883c875893f201e2dd2af8da2b0d08e7453ab7bbb76f006766440b7e182c5877ebc6e5191319ee1839949c227508bbf1cc5c81982518d35388c5a5e70ed44e83b3926b45b434c7094645f4e2e7ddbd1b5bf05eb448ff8a77aa9ae5fbf182b4bac17d930ad597ab46f44326eba3bb7067469cc5c406ed27ae96b95444ab6a3ccfabae314b3066a8431eac3e2b94476815b15019dc7b6b8a582e9cdbdc7b527857ddcf3111ab85151895be1f6177322aac69aae92d5356d0a64e01302119e3cb4c22e69db81d058cf12ec5e11fc88a0cf7a986cfd2e6de33f8a0c825c46d229725aeb9b50f792eb1447a3e427ff22d5c24e20732df492c1006f1745614da4f9e96e9acd0485e5886cf865830059c31ec8d88859939aaa468899290e309c6c4b6b7910bba7b3792e345db1c96b945c429917176776fdf131b7ad6eec6e3ddbd7dcbc8fdc43288d0425cd2c0f8948c61e151a51e55b0a94f6d8dc8feac5eed535825e2924c5b840bd5299d6facef593be8105ad7dbb7a351d7e5c159eb7a373eb6bee78a398171b4a06b15fe5d5a2c3c40fc64cae34daa0b760f86a47bc8c166ca45b856582cbd4f7851b5175790ef969e8808c9c5e442195fc74291b786b8b9d9f5cbf02d723b7195f46da145fa8af0d2f829a064387824d9276d103e197532e85e9500521e66fb869eb54fccc4efd12463179e152e22afa86b02c3bf5667a9deade28dcfcb711bd2f459c5fec6ac9c8d15c90e62f3869bcad2afebed7b24b95d6823f7113f5cdf7881eedebe4dca609eac54e16ed5c6fc1c5936248988bde4d60d3d576ceabeb5af1767a73c9df8e2041b654b1e5485a2f981b1a167ed5077efc64fd441d3581251f336f2b439eab4cda7927f08968bc6d06588486ae7b6293dbe32d825277539534b44fc1b7e460c2b691b7fb88bb82a4247cadd223e4ffe0b5686689974df39d2c42c226cafcd89f3eba85539df2c373fcbc3b6afd3eb7428fd3f03cf151db8b2b1580000000049454e44ae426082);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_assets`
--

CREATE TABLE IF NOT EXISTS `lifetek_assets` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `lifetek_assets`
--

INSERT INTO `lifetek_assets` (`id`, `name`, `asset_number`, `id_parent`, `lydotang`, `date_tang`, `date_kh`, `ky_khauhao`, `ppkh`, `tktk`, `tkkh`, `tkcp`, `id_tstb`, `id_bpsd`, `value_remain`, `value`, `allocate`, `han_khauhao`) VALUES
(1, 'Tivi samsung 42 inch', '1', 0, '', '2015-09-14', '2015-09-14', 4, 0, 2133, 214, 6422, 0, 0, 12000000, 24000000, 0, '2016-01-14'),
(7, 'Máy Khâu', 'MM', 0, 'mua mới', '2015-11-18', '2015-11-18', 12, 0, 0, 242, 142, 0, 0, 0, 2000000, 0, '2016-11-18'),
(8, 'Máy Giặt Là', 'MGL', 0, '', '2015-11-18', '2015-11-18', 12, 0, 0, 242, 142, 0, 0, 0, 4000000, 0, '2016-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_bangcap`
--

CREATE TABLE IF NOT EXISTS `lifetek_bangcap` (
  `id_bangcap` int(11) NOT NULL AUTO_INCREMENT,
  `nam_bangcap` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_bangcap`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_bank_account`
--

CREATE TABLE IF NOT EXISTS `lifetek_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account` int(11) NOT NULL,
  `receiving_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `lifetek_bank_account`
--

INSERT INTO `lifetek_bank_account` (`id`, `bank_account`, `receiving_id`, `sale_id`, `id_cost`) VALUES
(1, 11211, 832, 0, 0),
(2, 11211, 833, 0, 0),
(3, 11211, 846, 0, 0),
(4, 11211, 0, 2506, 0),
(5, 11212, 847, 0, 0),
(6, 11211, 0, 2508, 0),
(7, 11212, 0, 2509, 0),
(8, 11212, 0, 0, 2013),
(9, 11211, 0, 2510, 0),
(10, 11212, 0, 2511, 0),
(11, 11211, 0, 2517, 0),
(12, 11212, 0, 0, 2030),
(13, 11211, 849, 0, 0),
(14, 11212, 851, 0, 0),
(15, 11212, 0, 2522, 0),
(16, 11212, 0, 2523, 0),
(17, 11212, 0, 2524, 0),
(18, 11212, 0, 2525, 0),
(19, 11212, 0, 2526, 0),
(20, 11212, 0, 2527, 0),
(21, 11212, 0, 2528, 0),
(22, 11212, 0, 2529, 0),
(23, 11212, 0, 2530, 0),
(24, 11212, 0, 2531, 0),
(25, 11212, 0, 2532, 0),
(26, 11212, 860, 0, 2066),
(28, 11211, 861, 0, 0),
(31, 11211, 0, 2539, 0),
(32, 11212, 0, 2540, 0),
(33, 11212, 0, 2542, 2072),
(34, 11211, 0, 2544, 2074),
(35, 11211, 0, 0, 2077),
(36, 11212, 0, 2548, 2087),
(37, 11212, 0, 2551, 2090),
(40, 11212, 0, 2552, 2102),
(41, 11212, 0, 0, 2103),
(42, 11212, 0, 0, 2104),
(43, 11212, 0, 0, 2108),
(46, 11212, 0, 2556, 2133),
(47, 11212, 0, 2557, 2134),
(50, 11212, 0, 0, 2149),
(51, 0, 0, 0, 2148),
(52, 11212, 0, 0, 2154),
(53, 11211, 0, 2569, 2155),
(54, 11212, 0, 2571, 2157),
(55, 11212, 0, 2572, 2158),
(56, 11212, 0, 2577, 2163),
(57, 11212, 0, 2578, 2164),
(58, 11212, 0, 2579, 2165),
(59, 11212, 0, 2580, 2166),
(60, 11212, 0, 2585, 2174),
(61, 11211, 0, 2589, 2183),
(62, 11212, 0, 2590, 2184),
(63, 11211, 0, 2592, 2186),
(64, 11211, 0, 2593, 2187),
(65, 11212, 0, 2595, 2194),
(66, 11212, 0, 2597, 2199),
(67, 11212, 0, 2603, 2206),
(68, 11212, 0, 2609, 2213),
(69, 11212, 0, 2613, 2217),
(70, 11211, 0, 2616, 2220),
(71, 11211, 0, 2624, 2228),
(72, 11212, 0, 2642, 2247),
(73, 11212, 939, 0, 2434),
(74, 11213, 940, 0, 2435),
(75, 11213, 942, 0, 2444),
(76, 11211, 945, 0, 2510),
(77, 11211, 0, 2699, 2480),
(78, 11211, 952, 0, 2482),
(79, 11212, 956, 0, 2499),
(80, 11211, 957, 0, 0),
(81, 11211, 958, 0, 2501),
(82, 11211, 0, 2714, 2517),
(83, 11212, 0, 2717, 2520),
(84, 11212, 0, 2718, 2521),
(85, 11212, 963, 0, 2528),
(86, 11211, 0, 2734, 2578),
(87, 11211, 0, 2752, 2609),
(88, 11211, 0, 2786, 2645),
(89, 11212, 0, 2789, 2651),
(90, 11211, 0, 2790, 2658),
(91, 11211, 985, 0, 2825),
(92, 11211, 987, 0, 2829),
(93, 11211, 0, 2858, 2844),
(94, 11211, 0, 2859, 2845),
(95, 11211, 0, 2866, 2863),
(96, 11212, 1018, 0, 2922),
(97, 11211, 1034, 0, 2968),
(98, 11211, 0, 2925, 3012),
(99, 11212, 0, 2929, 3023),
(100, 11211, 0, 2961, 3148),
(101, 11211, 0, 2974, 3202),
(102, 11212, 0, 3000, 3270),
(103, 11211, 0, 3034, 3384),
(104, 11211, 0, 3069, 3457),
(105, 11212, 0, 3131, 3680),
(106, 11211, 0, 3186, 3991),
(107, 11211, 0, 3246, 4125);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_bill_cost`
--

CREATE TABLE IF NOT EXISTS `lifetek_bill_cost` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_bpsd`
--

CREATE TABLE IF NOT EXISTS `lifetek_bpsd` (
  `id_bpsd` int(11) NOT NULL AUTO_INCREMENT,
  `name_bpsd` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `desc_bpsd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_bpsd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_categories_item`
--

CREATE TABLE IF NOT EXISTS `lifetek_categories_item` (
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
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_category_processes`
--

CREATE TABLE IF NOT EXISTS `lifetek_category_processes` (
  `cat_pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_pro_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`cat_pro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_chungtus`
--

CREATE TABLE IF NOT EXISTS `lifetek_chungtus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` date NOT NULL,
  `diachi_lap` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diachi_nhan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `noidung` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_chungtu_detail`
--

CREATE TABLE IF NOT EXISTS `lifetek_chungtu_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chungtu_id` int(11) NOT NULL,
  `sotien` decimal(15,0) NOT NULL,
  `tk_no` int(11) NOT NULL,
  `tk_co` int(11) NOT NULL,
  `mark` int(11) NOT NULL COMMENT '0: chứng từ, 1: hóa đơn dịch vụ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147 ;

--
-- Dumping data for table `lifetek_chungtu_detail`
--

INSERT INTO `lifetek_chungtu_detail` (`id`, `chungtu_id`, `sotien`, `tk_no`, `tk_co`, `mark`) VALUES
(5, 4, '8600', 111, 1113, 0),
(6, 4, '9999', 1123, 1212, 0),
(7, 4, '8888', 1281, 1131, 0),
(15, 8, '2421180', 6422, 3383, 0),
(16, 8, '403530', 6422, 3384, 0),
(17, 8, '134510', 6422, 3388, 0),
(18, 9, '100000', 0, 0, 0),
(19, 10, '10000000', 622, 3341, 0),
(20, 10, '1000000', 0, 0, 0),
(21, 11, '100000', 1121, 1131, 0),
(22, 2, '0', 0, 0, 0),
(23, 12, '0', 0, 0, 0),
(24, 6, '10000', 111, 331, 0),
(25, 6, '20000', 111, 243, 0),
(26, 6, '30000', 111, 331, 0),
(27, 3, '100000', 111, 331, 0),
(28, 3, '120000', 111, 2288, 0),
(29, 13, '2', 1113, 1111, 0),
(30, 14, '15000', 331, 711, 0),
(33, 15, '1000', 128, 1281, 0),
(34, 15, '500000', 1281, 1132, 0),
(35, 16, '100000', 128, 1123, 0),
(49, 2, '1000000', 1111, 1112, 1),
(53, 3, '1233330', 1211, 1212, 1),
(54, 4, '3333333330', 1131, 1122, 1),
(58, 1, '80000', 1113, 2133, 1),
(59, 1, '1000', 1212, 1281, 1),
(62, 17, '10', 1111, 1212, 0),
(63, 17, '800', 1122, 1121, 0),
(64, 5, '100000', 111, 113, 1),
(65, 5, '100000', 2133, 1281, 1),
(68, 6, '200000', 1211, 113, 1),
(69, 6, '100000', 11211, 11211, 1),
(70, 6, '100000', 113, 11212, 1),
(74, 7, '500000', 1211, 1211, 1),
(75, 7, '1000000', 1211, 1131, 1),
(78, 8, '100000000', 1211, 1212, 1),
(90, 12, '10000000', 1212, 1132, 1),
(95, 13, '1400000', 1211, 1122, 1),
(97, 10, '10000000', 1212, 121, 1),
(98, 11, '230000', 1132, 1212, 1),
(106, 9, '234000', 1131, 1132, 1),
(110, 16, '10000000000', 121, 1132, 1),
(111, 14, '200000', 121, 1131, 1),
(112, 15, '90000000', 121, 113, 1),
(115, 17, '100000', 128, 1131, 1),
(116, 17, '200000', 1123, 11212, 1),
(117, 7, '120000', 622, 334, 0),
(118, 7, '100000', 642, 334, 0),
(121, 18, '10000000', 1211, 121, 1),
(122, 18, '20000000', 113, 121, 1),
(124, 18, '145222000', 642, 11211, 0),
(125, 19, '450000', 1211, 1211, 0),
(126, 19, '10', 1211, 1132, 1),
(128, 20, '50000000', 211, 331, 1),
(129, 20, '12000000', 242, 331, 1),
(131, 21, '1000000', 1121, 1332, 1),
(132, 23, '111', 1332, 1123, 1),
(133, 24, '200000', 1332, 138, 1),
(134, 25, '150000', 1331, 121, 1),
(135, 26, '135000', 1332, 121, 1),
(138, 27, '100000', 1331, 133, 1),
(139, 27, '200000', 121, 133, 1),
(141, 28, '100000', 121, 131, 1),
(142, 29, '200000', 131, 11212, 1),
(143, 30, '200000', 131, 111, 1),
(144, 20, '200000', 131, 11211, 0),
(145, 21, '2000000', 131, 111, 0),
(146, 22, '200000', 131, 331, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_cities`
--

CREATE TABLE IF NOT EXISTS `lifetek_cities` (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `zip_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  PRIMARY KEY (`id_city`),
  UNIQUE KEY `zip_code` (`zip_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_ci_sessions`
--

CREATE TABLE IF NOT EXISTS `lifetek_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `user_data` text NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_clip`
--

CREATE TABLE IF NOT EXISTS `lifetek_clip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `des` text,
  `anh` varchar(300) DEFAULT NULL,
  `anh_con` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_comments`
--

CREATE TABLE IF NOT EXISTS `lifetek_comments` (
  `id_comment` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(20) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `dateport` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_congcus`
--

CREATE TABLE IF NOT EXISTS `lifetek_congcus` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_cong_no_kh`
--

CREATE TABLE IF NOT EXISTS `lifetek_cong_no_kh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  `oh_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `lifetek_cong_no_kh`
--

INSERT INTO `lifetek_cong_no_kh` (`id`, `person_id`, `du_no`, `du_co`, `oh_year`) VALUES
(23, 2183, '100000', '0', 2015),
(24, 2250, '12000', '0', 2015),
(25, 2134, '100000', '0', 2015),
(26, 2277, '100000', '0', 2015);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_cong_no_khac`
--

CREATE TABLE IF NOT EXISTS `lifetek_cong_no_khac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) NOT NULL,
  `code` varchar(25) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `lifetek_cong_no_khac`
--

INSERT INTO `lifetek_cong_no_khac` (`id`, `account`, `code`, `name`, `du_no`, `du_co`) VALUES
(10, 111, '1a', 'hung', '1000', '1200'),
(11, 122, '2v', 'thuong', '2000', '2400'),
(12, 0, '', '', '0', '0'),
(13, 0, '', '', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_cong_no_ncc`
--

CREATE TABLE IF NOT EXISTS `lifetek_cong_no_ncc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  `oh_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `lifetek_cong_no_ncc`
--

INSERT INTO `lifetek_cong_no_ncc` (`id`, `person_id`, `du_no`, `du_co`, `oh_year`) VALUES
(56, 2240, '0', '100000', 2010),
(57, 2255, '0', '1000000', 2010);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_contact`
--

CREATE TABLE IF NOT EXISTS `lifetek_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_contact_home`
--

CREATE TABLE IF NOT EXISTS `lifetek_contact_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` text NOT NULL,
  `view` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_contraccustomer`
--

CREATE TABLE IF NOT EXISTS `lifetek_contraccustomer` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_contract_type`
--

CREATE TABLE IF NOT EXISTS `lifetek_contract_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `lifetek_contract_type`
--

INSERT INTO `lifetek_contract_type` (`id`, `code`, `name`, `description`, `deleted`) VALUES
(7, 'HĐKT', 'hợp đồng kinh tế', 'hợp đồng kinh tế mang giá trị thời hạn 01 năm', 0),
(8, 'HĐKTPM', 'hợp đồng phần mềm', '', 0),
(9, 'HĐMB', 'Hợp Đồng Mua Bán', 'hợp đồng mua bán nhà đất', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_costs`
--

CREATE TABLE IF NOT EXISTS `lifetek_costs` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4330 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_cost_detail`
--

CREATE TABLE IF NOT EXISTS `lifetek_cost_detail` (
  `id` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `receiving_id` int(11) NOT NULL,
  `money_debt` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_cost_select`
--

CREATE TABLE IF NOT EXISTS `lifetek_cost_select` (
  `cost_id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cost_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_create_invetory`
--

CREATE TABLE IF NOT EXISTS `lifetek_create_invetory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_inventory` varchar(255) NOT NULL,
  `address` varchar(150) NOT NULL,
  `created_date` datetime NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type_warehouse` tinyint(4) NOT NULL COMMENT ' 0: Kho khác - 1: Kho thành phẩm - 2: Kho nguyên vật liệu',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_culture`
--

CREATE TABLE IF NOT EXISTS `lifetek_culture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `culture_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_currency`
--

CREATE TABLE IF NOT EXISTS `lifetek_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `currency_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `currency_rate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_customers`
--

CREATE TABLE IF NOT EXISTS `lifetek_customers` (
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
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_customer_type`
--

CREATE TABLE IF NOT EXISTS `lifetek_customer_type` (
  `customer_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `status_agent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_dttcs`
--

CREATE TABLE IF NOT EXISTS `lifetek_dttcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_1` date DEFAULT NULL,
  `date_2` date DEFAULT NULL,
  `date_3` date DEFAULT NULL,
  `date_4` date DEFAULT NULL,
  `date_5` date DEFAULT NULL,
  `date_6` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lifetek_dttcs`
--

INSERT INTO `lifetek_dttcs` (`id`, `name`, `date_1`, `date_2`, `date_3`, `date_4`, `date_5`, `date_6`) VALUES
(3, 'b', '2015-11-07', '2015-11-07', '2015-11-07', '2015-11-07', '2015-11-07', '2015-11-07'),
(4, 'Nguyễn Văn Định', '2015-11-13', '2015-11-13', '2015-11-13', '2015-11-13', '2015-11-13', '2015-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_dttcs_detail`
--

CREATE TABLE IF NOT EXISTS `lifetek_dttcs_detail` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_education`
--

CREATE TABLE IF NOT EXISTS `lifetek_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_education` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_emails`
--

CREATE TABLE IF NOT EXISTS `lifetek_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_employees`
--

CREATE TABLE IF NOT EXISTS `lifetek_employees` (
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
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lifetek_employees`
--

INSERT INTO `lifetek_employees` (`username`, `password`, `person_id`, `emp_code`, `identity_card`, `date_identity_card`, `date_working`, `hs_salary`, `bank_account`, `name_bank`, `id_language`, `id_education`, `name_nation`, `id_visa`, `id_diplomas`, `id_informatics`, `check_petrol`, `check_phone`, `curiculum_vitae`, `labor_contract`, `deleted`, `positions_id`, `parent_id`, `em_salary_basic`, `em_wage_level_coverage`, `em_social_insurance`, `em_on_vacation`, `department_id`, `emp_expense`, `emp_deposit`, `image_face`, `end_working`, `warehouse_sale`, `warehouse_import`) VALUES
('admin', '25d55ad283aa400af464c76d713c07ad', 1, 'NV001', 1507920321, '2015-12-14', '2014-01-01', '2', 'VietBankV', 'VietBank', 5, 0, 'Kinh', 1, 0, 2, 1, 1, '', 'Book16.xls', 0, 0, 1, '5000000', 0, '1500000', '0', 5, '80.00', '760000.00', 'logo-soft1223.png', '1970-01-01 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_events_map`
--

CREATE TABLE IF NOT EXISTS `lifetek_events_map` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_event_user`
--

CREATE TABLE IF NOT EXISTS `lifetek_event_user` (
  `event_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`event_user_id`,`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_export_store`
--

CREATE TABLE IF NOT EXISTS `lifetek_export_store` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `lifetek_export_store`
--

INSERT INTO `lifetek_export_store` (`export_store_id`, `date_export`, `status`, `follow`, `store_id`, `comment`, `employee_id`, `item_production_id`, `tk_no`, `tk_co`, `form`) VALUES
(1, '2015-07-31 15:46:01', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(2, '2015-08-05 09:59:40', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(3, '2015-08-05 10:00:28', 1, 0, 5, '                    ', 1, 0, '0', '0', 0),
(5, '2015-08-05 10:03:34', 1, 0, 5, '                    ', 1, 0, '0', '0', 0),
(7, '2015-08-05 15:20:40', 1, 0, 0, 'Xuất kho', 1, 0, '0', '0', 0),
(8, '2015-08-07 11:00:40', 1, 0, 0, '                                        ', 1, 0, '0', '0', 0),
(9, '2015-08-07 11:28:25', 1, 0, 0, '                                        ', 1, 0, '0', '0', 0),
(10, '2015-08-08 10:12:49', 1, 0, 10, '                    ', 1, 0, '0', '0', 0),
(11, '2015-08-10 09:56:28', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(12, '2015-08-13 10:13:39', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(13, '2015-08-13 15:25:53', 1, 0, 0, '                   khkh ', 1, 0, '0', '0', 0),
(14, '2015-08-13 16:08:15', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(15, '2015-08-14 15:08:28', 1, 0, 6, '                    ', 1, 0, '0', '0', 0),
(16, '2015-08-14 16:31:09', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(17, '2015-08-15 11:45:49', 1, 0, 0, '                                        ', 1, 0, '0', '0', 0),
(18, '2015-08-15 11:45:42', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(19, '2015-08-19 09:33:56', 1, 0, 0, '                                        ', 1, 0, '0', '0', 0),
(20, '2015-08-19 09:35:51', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(21, '2015-08-19 17:16:15', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(22, '2015-08-20 15:29:49', 1, 0, 3, '                                        ', 1, 30, '0', '0', 0),
(23, '2015-08-20 15:31:40', 1, 0, 3, '                  heloo  ', 1, 30, '0', '0', 0),
(24, '2015-08-20 15:34:57', 1, 0, 3, '                    xuất kho để sản xuất', 1, 30, '0', '0', 0),
(25, '2015-08-20 15:39:49', 1, 0, 3, '         âsas           ', 1, 29, '0', '0', 0),
(26, '2015-08-20 16:15:01', 1, 0, 3, '                    ', 1, 37, '0', '0', 0),
(27, '2015-08-20 16:30:34', 1, 0, 0, '                  aloo  ', 1, 0, '0', '0', 0),
(28, '2015-08-20 16:33:08', 1, 0, 3, '                    ', 1, 27, '0', '0', 0),
(29, '2015-08-22 08:23:32', 1, 0, 3, '                    ', 1, 31, '0', '0', 0),
(30, '2015-08-31 09:48:17', 1, 0, 3, '                                        ', 1, 8, '0', '0', 0),
(31, '2015-08-26 14:18:12', 1, 0, 0, '                    ', 1, 0, '0', '0', 0),
(32, '2015-08-31 09:32:19', 1, 0, 6, '                    ', 1, 0, '0', '0', 0),
(33, '2015-09-07 12:06:24', 1, 0, 3, '                                        ', 1, 73, '0', '0', 0),
(34, '2015-09-07 12:07:57', 1, 0, 3, '                                                            ', 1, 73, '0', '0', 0),
(35, '2015-09-07 15:50:49', 1, 0, 3, '                    ', 1, 73, '0', '0', 0),
(36, '2015-09-24 11:02:30', 1, 0, 3, '                                                                                                                                                                                                        ', 1, 66, '6277', '1281', 0),
(37, '2015-09-24 09:08:35', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(38, '2015-09-24 11:11:11', 1, 0, 3, '                                                                                ', 1, 32, '621', '1112', 0),
(39, '2015-09-24 14:01:02', 1, 0, 3, '                                        ', 1, 77, '6211', '129', 0),
(41, '2015-10-16 14:59:30', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(42, '2015-10-20 11:00:13', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(45, '2015-10-26 14:33:21', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(46, '2015-10-26 15:08:51', 1, 0, 0, '       Cần gấp            ', 1, 0, '', '', 0),
(47, '2015-10-26 22:02:00', 1, 0, 0, '           nhanh và luôn         ', 1, 0, '', '', 0),
(49, '2015-10-28 14:18:23', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(50, '2015-10-29 11:12:07', 1, 0, 0, '     aaaaaaa               ', 1, 0, '', '', 0),
(51, '2015-10-29 12:11:15', 1, 0, 3, '                    ', 1, 11, '6211', '1121', 1),
(52, '2015-10-29 12:13:40', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(53, '2015-11-12 09:04:07', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(54, '2015-11-12 14:26:45', 1, 0, 0, '     xuất dùng nội bộ               ', 1, 0, '', '', 0),
(55, '2015-11-13 14:58:27', 0, 0, 0, '   xuất điều chuyển                 ', 1, 0, '', '', 0),
(56, '2015-11-26 10:23:49', 0, 0, 3, '                    ', 1, 11, '154', '152', 1),
(57, '2015-11-26 13:41:01', 0, 0, 3, '                    ', 1, 6, '154', '152', 1),
(58, '2015-11-26 13:50:25', 0, 0, 0, '                    ', 1, 0, '', '', 0),
(59, '2015-12-08 15:11:19', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(60, '2015-12-11 10:34:01', 1, 0, 3, '                    ', 1, 6, '111', '331', 1),
(62, '2015-12-16 11:15:55', 1, 0, 0, '                    ', 1, 0, '', '', 0),
(63, '2015-12-18 12:12:29', 0, 0, 3, '                    ', 1, 25, '131', '111', 1),
(64, '2015-12-22 14:41:58', 0, 0, 9, '                    ', 1, 0, '', '', 0),
(65, '2015-12-22 14:43:15', 0, 0, 9, '                    ', 1, 0, '', '', 0),
(67, '2015-12-23 09:56:58', 1, 0, 3, '                    ', 1, 32, '111', '1111', 1),
(68, '2015-12-24 09:10:31', 0, 0, 0, '                    ', 1, 0, '', '', 0),
(69, '2015-12-24 10:26:15', 0, 0, 2, '                    ', 1, 0, '', '', 0),
(70, '2015-12-24 10:27:21', 0, 0, 3, '                    ', 1, 33, '111', '1111', 1),
(71, '2015-12-25 10:24:47', 0, 0, 2, '                    ', 2394, 0, '', '', 0),
(72, '2015-12-25 10:27:48', 0, 0, 3, '                    ', 2394, 12, '111', '131', 1),
(73, '2015-12-25 10:30:07', 0, 0, 0, '                    ', 2394, 0, '', '', 0),
(74, '2015-12-25 14:29:28', 0, 0, 0, '                    ', 2394, 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_export_store_item`
--

CREATE TABLE IF NOT EXISTS `lifetek_export_store_item` (
  `export_store_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_request` double(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Số lượng yêu cầu, mặc định là 0',
  `quantity_export` double(20,2) NOT NULL,
  `cost_price_export` decimal(15,0) NOT NULL,
  `unit_export` int(11) NOT NULL,
  `unit_convert` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lifetek_export_store_item`
--

INSERT INTO `lifetek_export_store_item` (`export_store_id`, `item_id`, `quantity_request`, `quantity_export`, `cost_price_export`, `unit_export`, `unit_convert`) VALUES
(1, 4106, 0.00, 1.00, '0', 7, 0),
(2, 4125, 0.00, 2.00, '100000', 3, 0),
(3, 4125, 0.00, 1.00, '100000', 3, 0),
(5, 4125, 0.00, 1.00, '100000', 3, 0),
(7, 4120, 0.00, 2.00, '100000', 8, 0),
(7, 4119, 0.00, 6.00, '1000', 1, 0),
(8, 4120, 0.00, 5.00, '100000', 8, 0),
(9, 4120, 0.00, 4.00, '100000', 8, 0),
(10, 4143, 0.00, 2.00, '0', 8, 0),
(11, 4128, 0.00, 1.11, '500000', 7, 0),
(12, 4123, 0.00, 7.00, '250000', 7, 0),
(13, 4106, 0.00, 1.00, '0', 7, 0),
(14, 4109, 0.00, 84.00, '10000', 7, 0),
(15, 4158, 0.00, 1.00, '100000', 7, 0),
(16, 4196, 0.00, 5.00, '0', 8, 0),
(18, 4206, 0.00, 10.00, '100000', 12, 0),
(18, 4205, 0.00, 10.00, '150000', 12, 0),
(18, 4204, 0.00, 15.00, '200000', 1, 0),
(17, 4206, 0.00, 10.00, '100000', 12, 0),
(19, 4182, 0.00, 7.00, '120000', 8, 0),
(20, 4216, 0.00, 50.00, '0', 1, 0),
(20, 4218, 0.00, 70.00, '0', 1, 0),
(20, 4217, 0.00, 150.00, '0', 1, 0),
(20, 4215, 0.00, 100.00, '0', 1, 0),
(21, 4172, 0.00, 11.00, '5000000', 7, 0),
(22, 4159, 3.00, 1.00, '100000', 7, 0),
(22, 4158, 3.00, 1.00, '100000', 7, 0),
(23, 4158, 3.00, 1.50, '100000', 7, 0),
(23, 4159, 3.00, 1.50, '100000', 7, 0),
(24, 4158, 3.00, 0.50, '10000', 7, 0),
(24, 4159, 3.00, 0.50, '10000', 7, 0),
(25, 4158, 12.00, 1.90, '10000', 7, 0),
(25, 4159, 12.00, 11.90, '10000', 7, 0),
(26, 4158, 117.00, 0.10, '10000', 7, 0),
(26, 4159, 39.00, 0.10, '10000', 7, 0),
(26, 4172, 78.00, 1.00, '5000000', 7, 0),
(26, 4199, 156.00, 1.00, '100000', 3, 0),
(26, 4200, 195.00, 195.00, '8000', 3, 0),
(26, 4216, 234.00, 50.00, '0', 1, 0),
(27, 4210, 0.00, 3.00, '0', 1, 0),
(28, 4199, 50.00, 39.54, '100000', 3, 0),
(28, 4200, 150.00, 4.32, '8000', 3, 0),
(29, 4159, 5.00, 1.00, '10000', 7, 0),
(31, 4159, 0.00, 1.00, '10000', 7, 0),
(32, 4158, 0.00, 1.00, '10000', 7, 0),
(30, 4199, 0.00, 1.00, '100000', 3, 0),
(33, 4282, 108.00, 1.00, '0', 1, 0),
(33, 4281, 120.00, 1.00, '0', 1, 0),
(33, 4280, 44445.00, 1.00, '1000', 1, 0),
(33, 4279, 444906.00, 1.00, '1000', 1, 0),
(33, 4278, 5551067.00, 1.00, '1000', 1, 0),
(33, 4277, 2147483647.00, 70.89, '1000', 1, 0),
(34, 4277, 2147483647.00, 10.00, '1000', 1, 0),
(34, 4278, 5551067.00, 1.00, '1000', 1, 0),
(34, 4279, 444906.00, 1.00, '1000', 1, 0),
(34, 4280, 44445.00, 1.00, '1000', 1, 0),
(34, 4281, 120.00, 1.00, '0', 1, 0),
(34, 4282, 108.00, 1.00, '0', 1, 0),
(35, 4277, 2147483647.00, 1.00, '1000', 1, 0),
(35, 4278, 5551067.00, 1.68, '1000', 1, 0),
(35, 4279, 444906.00, 1.00, '1000', 1, 0),
(35, 4280, 44445.00, 1.00, '1000', 1, 0),
(35, 4281, 120.00, 1.00, '0', 1, 0),
(35, 4282, 108.00, 1.00, '0', 1, 0),
(37, 4159, 0.00, 1.00, '10000', 7, 0),
(36, 4158, 110.00, 110.00, '10000', 7, 0),
(36, 4294, 115.00, 115.00, '1', 1, 0),
(36, 4293, 115.00, 115.00, '1000', 1, 0),
(36, 4292, 1155.00, 1155.00, '1000', 1, 0),
(36, 4291, 160.00, 160.00, '1000', 1, 0),
(36, 4290, 10.00, 10.00, '1000', 1, 0),
(36, 4289, 10.00, 10.00, '1000', 1, 0),
(36, 4280, 10.00, 11.00, '1000', 1, 0),
(38, 4159, 4.00, 2.00, '10000', 7, 0),
(38, 4158, 2.00, 1.00, '10000', 7, 0),
(39, 4292, 20.00, 2.00, '1000', 1, 0),
(39, 4255, 70.00, 1.00, '10000', 1, 0),
(39, 4158, 70.00, 1.00, '10000', 7, 0),
(41, 4178, 0.00, 10.00, '500000', 7, 0),
(42, 4159, 0.00, 1.00, '10000', 7, 0),
(45, 4159, 0.00, 1.00, '10000', 7, 0),
(46, 4180, 0.00, 10.00, '140000', 8, 0),
(47, 4179, 0.00, 10.00, '120000', 8, 0),
(49, 4180, 0.00, 10.00, '140000', 8, 0),
(50, 4176, 0.00, 1.00, '900', 7, 0),
(51, 4110, 30.00, 1.00, '0', 0, 0),
(51, 4111, 200.00, 12.00, '0', 0, 0),
(52, 4329, 0.00, 1.00, '0', 0, 0),
(53, 4164, 0.00, 1.00, '180000', 2, 0),
(54, 4329, 0.00, 1.00, '0', 0, 0),
(55, 4385, 0.00, 2.00, '0', 5, 0),
(56, 4110, 30.00, 1.00, '0', 0, 0),
(56, 4111, 200.00, 1.00, '0', 0, 0),
(57, 4108, 15.00, 10.00, '0', 0, 0),
(57, 4111, 90.00, 10.00, '0', 0, 0),
(58, 4329, 0.00, 1.00, '0', 0, 0),
(58, 4379, 0.00, 1.00, '0', 8, 0),
(59, 4193, 0.00, 3.00, '0', 8, 0),
(60, 4108, 15.00, 1.00, '0', 0, 0),
(60, 4111, 90.00, 1.00, '0', 0, 0),
(62, 4495, 0.00, 1.00, '0', 7, 0),
(63, 4158, 2.00, 2.00, '10000', 8, 0),
(63, 4159, 4.00, 1.00, '10000', 7, 0),
(64, 4328, 0.00, 2.00, '30000', 7, 0),
(65, 4385, 0.00, 5.00, '0', 5, 0),
(67, 4158, 2.00, 1.00, '10000', 8, 0),
(67, 4159, 4.00, 2.00, '10000', 7, 0),
(68, 4495, 0.00, 10.00, '0', 7, 0),
(69, 4385, 0.00, 10.00, '0', 5, 0),
(69, 4516, 0.00, 10.00, '200000', 7, 0),
(70, 4158, 3030.00, 10.00, '10000', 8, 0),
(70, 4159, 2020.00, 10.00, '10000', 7, 0),
(71, 4385, 0.00, 10.00, '0', 5, 0),
(71, 4516, 0.00, 10.00, '200000', 7, 0),
(72, 4108, 3.00, 1.00, '0', 0, 0),
(72, 4111, 3.00, 1.00, '0', 0, 0),
(73, 4249, 0.00, 1.00, '10000', 11, 0),
(73, 4436, 0.00, 1.00, '4500000', 7, 0),
(74, 4436, 0.00, 10.00, '4500000', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_gantt_links`
--

CREATE TABLE IF NOT EXISTS `lifetek_gantt_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `type` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_gantt_project`
--

CREATE TABLE IF NOT EXISTS `lifetek_gantt_project` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_giftcards`
--

CREATE TABLE IF NOT EXISTS `lifetek_giftcards` (
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
  KEY `phppos_giftcards_ibfk_1` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_groups`
--

CREATE TABLE IF NOT EXISTS `lifetek_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_groups_asset`
--

CREATE TABLE IF NOT EXISTS `lifetek_groups_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_hopdong`
--

CREATE TABLE IF NOT EXISTS `lifetek_hopdong` (
  `id_hopdong` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ma_hopdong` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_employess` int(5) NOT NULL,
  `loai_hopdong` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY (`id_hopdong`),
  KEY `id_employess` (`id_employess`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_import_product`
--

CREATE TABLE IF NOT EXISTS `lifetek_import_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_introductions`
--

CREATE TABLE IF NOT EXISTS `lifetek_introductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 NOT NULL,
  `en_title` text NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `en_description` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lifetek_introductions`
--

INSERT INTO `lifetek_introductions` (`id`, `title`, `en_title`, `description`, `en_description`, `url`) VALUES
(1, 'Giới thiệu công ty Hành tinh xanh', 'title', '<p>c&ocirc;ng ty ch&uacute;ng t&ocirc;i chuy&ecirc;n cung cấp c&aacute;c dịch vụ CMS cho c&aacute;c doanh nghiệp vừa v&agrave; nhỏ</p>\n', '', 'gioi-thieu-cong-ty-hanh-tinh-xanh'),
(4, 'công ty A', '', '<p>chuy&ecirc;n mua</p>\n', '', 'cong-ty-a');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_inventory`
--

CREATE TABLE IF NOT EXISTS `lifetek_inventory` (
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
  KEY `phppos_inventory_ibfk_2` (`trans_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4055 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_items`
--

CREATE TABLE IF NOT EXISTS `lifetek_items` (
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
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4608 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_items_taxes`
--

CREATE TABLE IF NOT EXISTS `lifetek_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_items_verifying`
--

CREATE TABLE IF NOT EXISTS `lifetek_items_verifying` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_history_production`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_history_production` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_production_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_production` double(20,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='lịch sử sản xuất thành phẩm' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kits`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kits` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=318 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kits_taxes`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kits_taxes` (
  `item_kit_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_kit_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_cost_price`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_cost_price` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='giá vốn sản phẩm' AUTO_INCREMENT=95 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_design_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_design_template` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='thông tin mẫu tk' AUTO_INCREMENT=214 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_feature`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_feature` (
  `feature_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) NOT NULL,
  `number_feature` varchar(15) NOT NULL,
  `name_feature` varchar(50) NOT NULL,
  `delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`feature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='công thức nvl trong từng mẫu' AUTO_INCREMENT=238 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_formula_materials`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_formula_materials` (
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

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_items`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_items` (
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
  KEY `phppos_item_kit_items_ibfk_2` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_norms_item`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_norms_item` (
  `request_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tổng định mức nvl theo lệnh sx';

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_processes`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_processes` (
  `pro_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `time_processes` double(15,2) NOT NULL,
  `unit_time` int(11) NOT NULL,
  `processes_money` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='công đoạn trong lệnh sx';

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_processes_cost`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_processes_cost` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='chi phí từng công đoạn trong lệnh sx' AUTO_INCREMENT=868 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_production_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_production_template` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='thông tin lệnh sx theo từng mẫu' AUTO_INCREMENT=159 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_request_cost_price`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_request_cost_price` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='giá vốn lệnh sx' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_request_feature`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_request_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `size` varchar(8) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='lệnh sx theo size' AUTO_INCREMENT=574 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_request_production`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_request_production` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: Chưa tiếp nhận, 1: Chờ tiếp nhận, 2: Đã tiếp nhận',
  `delete` tinyint(4) NOT NULL,
  `total_money_norms` int(11) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='lệnh sx' AUTO_INCREMENT=243 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_kit_request_production_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_kit_request_production_template` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `quantity_request` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='lệnh sx theo từng mẫu' AUTO_INCREMENT=163 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_item_production`
--

CREATE TABLE IF NOT EXISTS `lifetek_item_production` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='thông tin lệnh sản xuất' AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs` (
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
  KEY `jobs_security_id` (`jobs_security_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs2014`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs2014` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_affiliates`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_affiliates` (
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
  KEY `jobs_city_id` (`jobs_city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_city`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_city` (
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
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_department`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_department` (
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
  KEY `jobs_affiliates_id` (`jobs_affiliates_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_employees`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_employees` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_file`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_file` (
  `jobs_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_file_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `jobs_file_date` date DEFAULT NULL,
  PRIMARY KEY (`jobs_file_id`,`person_id`),
  KEY `phppos_jobs_file_ibfk_1` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `lifetek_jobs_file`
--

INSERT INTO `lifetek_jobs_file` (`jobs_file_id`, `jobs_file_title`, `jobs_file_description`, `jobs_file_name`, `person_id`, `jobs_file_date`) VALUES
(2, 'Luồng sx', '', NULL, 1, '2015-08-10'),
(4, 'Mẫu khởi tạo excel', '', 'import_items1.xlsx', 1, '2015-08-10'),
(6, 'Quy trình 4biz', ':D', 'import_items3.xlsx', 1, '2015-08-10'),
(8, 'Danh sách khách hàng', 'Danh sách tổng hợp khách hàng.', 'Copy_of_import_customers1.xlsx', 1, '2015-08-11'),
(9, 'Tài liệu dự án kinh doanh đất', 'abcz', NULL, 1, '2015-10-27'),
(14, 'thành phố hoàng gia', '', NULL, 1, '2015-11-13'),
(15, '0', '', NULL, 1, '1970-01-01'),
(16, 'HDSD', '', 'import_customers_khach_hang1.xlsx', 1, '2015-11-19'),
(17, '0', '', NULL, 1, '1970-01-01'),
(18, 'bao cao ban hang', '', 'baocao_banhang-22-12-20151.xlsx', 1, '2015-12-23');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_important`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_important` (
  `jobs_important_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_important_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_important_date` date DEFAULT NULL,
  `jobs_important_show` int(4) DEFAULT '1',
  `person_id` int(11) DEFAULT NULL,
  `jobs_important_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`jobs_important_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_positions`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_positions` (
  `jobs_positions_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_positions_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_positions_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_positions_color` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_positions_date` date NOT NULL,
  `delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`jobs_positions_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_regions`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_regions` (
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
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_report`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_report` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_security`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_security` (
  `jobs_security_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_security_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobs_security_date` date DEFAULT NULL,
  `jobs_security_show` int(2) DEFAULT '1',
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`jobs_security_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_jobs_status`
--

CREATE TABLE IF NOT EXISTS `lifetek_jobs_status` (
  `jobs_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_status_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_status_date` date DEFAULT NULL,
  `jobs_status_show` tinyint(4) DEFAULT '1',
  `person_id` int(11) DEFAULT NULL,
  `jobs_status_color` varchar(10) COLLATE utf8_unicode_ci DEFAULT '#FFFFFF',
  PRIMARY KEY (`jobs_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_kcs`
--

CREATE TABLE IF NOT EXISTS `lifetek_kcs` (
  `kcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `feature_size_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `quantity_request` int(11) NOT NULL COMMENT 'sl yêu cầu',
  `quantity_production` int(11) NOT NULL COMMENT 'sl đã sản xuất',
  `status` tinyint(4) NOT NULL,
  `import_product_id` int(11) NOT NULL,
  PRIMARY KEY (`kcs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=679 ;

--
-- Dumping data for table `lifetek_kcs`
--

INSERT INTO `lifetek_kcs` (`kcs_id`, `request_id`, `feature_size_id`, `id_processes`, `quantity_request`, `quantity_production`, `status`, `import_product_id`) VALUES
(126, 53, 111, 4, 2, 2, 1, 0),
(127, 54, 112, 6, 20, 20, 1, 0),
(128, 54, 113, 6, 30, 30, 1, 0),
(129, 55, 114, 5, 2, 2, 1, 0),
(130, 55, 115, 5, 5, 5, 0, 0),
(131, 55, 114, 5, 2, 0, 0, 0),
(132, 55, 115, 5, 5, 0, 0, 0),
(133, 57, 125, 4, 10, 10, 1, 0),
(134, 57, 125, 5, 10, 2, 0, 0),
(135, 57, 126, 4, 5, 5, 1, 0),
(136, 57, 126, 5, 5, 3, 0, 0),
(137, 57, 127, 4, 5, 5, 1, 0),
(138, 57, 127, 5, 5, 3, 0, 0),
(139, 58, 128, 4, 20, 20, 1, 0),
(140, 58, 128, 6, 20, 20, 1, 0),
(141, 58, 129, 4, 30, 30, 1, 0),
(142, 58, 129, 6, 30, 30, 1, 0),
(143, 58, 130, 4, 10, 10, 1, 0),
(144, 58, 130, 6, 10, 10, 1, 0),
(145, 50, 106, 4, 8, 8, 1, 0),
(146, 50, 106, 5, 8, 8, 1, 0),
(147, 50, 107, 4, 80, 80, 1, 0),
(148, 50, 107, 5, 80, 79, 0, 0),
(149, 60, 134, 4, 20, 20, 1, 0),
(150, 60, 134, 5, 20, 20, 1, 0),
(151, 60, 134, 6, 20, 20, 1, 0),
(152, 60, 135, 4, 30, 30, 1, 0),
(153, 60, 135, 5, 30, 30, 1, 0),
(154, 60, 135, 6, 30, 30, 1, 0),
(155, 60, 136, 4, 50, 50, 1, 0),
(156, 60, 136, 5, 50, 50, 1, 0),
(157, 60, 136, 6, 50, 50, 1, 0),
(158, 61, 137, 1, 20, 20, 1, 0),
(159, 61, 137, 2, 20, 20, 1, 0),
(160, 61, 138, 1, 10, 10, 1, 0),
(161, 61, 138, 2, 10, 10, 1, 0),
(162, 61, 139, 1, 10, 10, 1, 0),
(163, 61, 139, 2, 10, 10, 1, 0),
(164, 61, 140, 1, 20, 20, 1, 0),
(165, 61, 140, 2, 20, 20, 1, 0),
(166, 61, 141, 1, 10, 10, 1, 0),
(167, 61, 141, 2, 10, 10, 1, 0),
(168, 61, 142, 1, 10, 10, 1, 0),
(169, 61, 142, 2, 10, 10, 1, 0),
(170, 62, 143, 1, 10, 5, 0, 0),
(171, 62, 144, 1, 10, 5, 0, 0),
(172, 62, 145, 1, 10, 4, 0, 0),
(173, 62, 146, 1, 10, 5, 0, 0),
(174, 62, 147, 1, 10, 4, 0, 0),
(175, 62, 148, 1, 10, 4, 0, 0),
(176, 63, 149, 3, 10, 10, 1, 0),
(177, 63, 150, 3, 10, 10, 1, 0),
(178, 67, 160, 4, 17, 17, 1, 0),
(179, 67, 160, 7, 17, 17, 1, 0),
(180, 67, 161, 4, 17, 17, 1, 0),
(181, 67, 161, 7, 17, 17, 1, 0),
(182, 67, 162, 4, 17, 17, 1, 0),
(183, 67, 162, 7, 17, 17, 1, 0),
(184, 73, 182, 4, 1, 1, 1, 0),
(185, 73, 182, 4, 1, 0, 0, 0),
(186, 75, 187, 8, 1, 0, 0, 0),
(187, 77, 191, 7, 10, 10, 1, 0),
(188, 77, 192, 7, 10, 10, 1, 0),
(189, 77, 193, 7, 10, 10, 1, 0),
(190, 77, 194, 7, 10, 10, 1, 0),
(191, 80, 201, 4, 35, 35, 1, 0),
(192, 80, 202, 4, 35, 35, 1, 0),
(193, 80, 203, 4, 35, 34, 0, 0),
(194, 83, 212, 4, 20, 20, 1, 0),
(195, 83, 212, 5, 20, 20, 1, 0),
(196, 83, 212, 6, 20, 20, 1, 0),
(197, 83, 213, 4, 10, 10, 1, 0),
(198, 83, 213, 5, 10, 10, 1, 0),
(199, 83, 213, 6, 10, 10, 1, 0),
(200, 83, 214, 4, 10, 10, 1, 0),
(201, 83, 214, 5, 10, 10, 1, 0),
(202, 83, 214, 6, 10, 10, 1, 0),
(203, 83, 215, 4, 10, 10, 1, 0),
(204, 83, 215, 5, 10, 10, 1, 0),
(205, 83, 215, 6, 10, 10, 1, 0),
(206, 81, 204, 1, 100, 100, 0, 0),
(207, 81, 204, 2, 100, 100, 1, 0),
(208, 81, 204, 5, 100, 100, 1, 0),
(209, 81, 204, 7, 100, 100, 1, 0),
(210, 81, 205, 1, 1000, 1000, 1, 0),
(211, 81, 205, 2, 1000, 1000, 1, 0),
(212, 81, 205, 5, 1000, 1000, 1, 0),
(213, 81, 205, 7, 1000, 1000, 1, 0),
(214, 81, 206, 1, 10000, 10000, 1, 0),
(215, 81, 206, 2, 10000, 10000, 1, 0),
(216, 81, 206, 5, 10000, 10000, 1, 0),
(217, 81, 206, 7, 10000, 10000, 1, 0),
(218, 81, 207, 1, 100000, 100000, 1, 0),
(219, 81, 207, 2, 100000, 100000, 1, 0),
(220, 81, 207, 5, 100000, 100000, 1, 0),
(221, 81, 207, 7, 100000, 100000, 1, 0),
(222, 84, 220, 3, 100, 100, 1, 0),
(223, 84, 221, 3, 10, 10, 1, 0),
(224, 85, 222, 1, 10, 10, 1, 0),
(225, 85, 222, 2, 0, 0, 0, 0),
(226, 85, 223, 1, 10, 10, 1, 0),
(227, 85, 223, 2, 0, 0, 0, 0),
(228, 80, 216, 4, 10, 0, 0, 0),
(229, 80, 217, 4, 35, 0, 0, 0),
(230, 80, 218, 4, 35, 0, 0, 0),
(231, 80, 219, 4, 35, 0, 0, 0),
(232, 80, 216, 4, 10, 0, 0, 0),
(233, 80, 217, 4, 35, 0, 0, 0),
(234, 80, 218, 4, 35, 0, 0, 0),
(235, 80, 219, 4, 35, 0, 0, 0),
(236, 80, 216, 4, 10, 0, 0, 0),
(237, 80, 217, 4, 35, 0, 0, 0),
(238, 80, 218, 4, 35, 0, 0, 0),
(239, 80, 219, 4, 35, 0, 0, 0),
(240, 80, 216, 6, 10, 10, 1, 0),
(241, 80, 217, 6, 35, 35, 1, 0),
(242, 80, 218, 6, 35, 35, 1, 0),
(243, 80, 219, 6, 35, 35, 1, 0),
(244, 91, 259, 4, 28, 28, 1, 0),
(245, 91, 259, 5, 28, 28, 1, 0),
(246, 91, 260, 4, 28, 28, 1, 0),
(247, 91, 260, 5, 28, 28, 1, 0),
(248, 91, 261, 4, 28, 28, 1, 0),
(249, 91, 261, 5, 28, 28, 1, 0),
(250, 91, 262, 4, 28, 28, 1, 0),
(251, 91, 262, 5, 28, 28, 1, 0),
(252, 92, 263, 4, 31, 31, 1, 0),
(253, 92, 263, 7, 31, 31, 1, 0),
(254, 92, 264, 4, 31, 31, 1, 0),
(255, 92, 264, 7, 31, 31, 1, 0),
(256, 92, 265, 4, 31, 31, 1, 0),
(257, 92, 265, 7, 31, 31, 1, 0),
(258, 92, 266, 4, 31, 31, 1, 0),
(259, 92, 266, 7, 31, 31, 1, 0),
(260, 93, 267, 4, 31, 31, 1, 0),
(261, 93, 267, 5, 31, 31, 1, 0),
(262, 93, 267, 7, 31, 31, 1, 0),
(263, 93, 268, 4, 31, 31, 1, 0),
(264, 93, 268, 5, 31, 31, 1, 0),
(265, 93, 268, 7, 31, 31, 1, 0),
(266, 93, 269, 4, 31, 31, 1, 0),
(267, 93, 269, 5, 31, 31, 1, 0),
(268, 93, 269, 7, 31, 31, 1, 0),
(269, 93, 270, 4, 31, 31, 1, 0),
(270, 93, 270, 5, 31, 31, 1, 0),
(271, 93, 270, 7, 31, 31, 1, 0),
(272, 97, 276, 4, 20, 20, 1, 0),
(273, 97, 276, 5, 20, 20, 1, 0),
(274, 97, 277, 4, 50, 50, 1, 0),
(275, 97, 277, 5, 50, 50, 1, 0),
(276, 100, 280, 4, 30, 30, 1, 0),
(277, 100, 280, 6, 30, 30, 1, 0),
(278, 101, 281, 4, 30, 30, 1, 0),
(279, 101, 281, 6, 30, 30, 1, 0),
(280, 101, 282, 4, 10, 10, 1, 0),
(281, 101, 282, 6, 10, 10, 1, 0),
(282, 102, 283, 5, 10, 10, 1, 0),
(283, 102, 283, 6, 10, 10, 1, 0),
(284, 105, 286, 4, 20, 20, 1, 0),
(285, 106, 287, 4, 30, 30, 1, 0),
(286, 106, 288, 4, 40, 40, 1, 0),
(287, 106, 289, 4, 30, 30, 1, 0),
(288, 103, 284, 1, 10, 0, 0, 0),
(289, 107, 290, 4, 20, 20, 1, 0),
(290, 107, 290, 6, 20, 20, 1, 0),
(291, 107, 291, 4, 10, 10, 1, 0),
(292, 107, 291, 6, 10, 10, 1, 0),
(293, 111, 299, 4, 13, 13, 1, 0),
(294, 111, 299, 4, 13, 0, 0, 0),
(295, 117, 306, 4, 10, 10, 1, 0),
(296, 117, 307, 4, 10, 10, 1, 0),
(297, 117, 308, 4, 10, 10, 1, 0),
(298, 116, 309, 1, 120, 120, 1, 0),
(299, 116, 309, 2, 120, 120, 1, 0),
(300, 116, 309, 7, 120, 120, 1, 0),
(301, 116, 310, 1, 100, 100, 1, 0),
(302, 116, 310, 2, 100, 100, 1, 0),
(303, 116, 310, 7, 100, 100, 1, 0),
(304, 115, 304, 2, 100, 12, 1, 0),
(305, 119, 312, 1, 1, 1, 1, 0),
(306, 119, 312, 2, 1, 1, 1, 0),
(307, 120, 313, 1, 3, 0, 1, 0),
(308, 120, 313, 2, 0, 6, 0, 0),
(309, 120, 313, 4, 6, 0, 0, 0),
(310, 121, 314, 2, 10, 10, 1, 0),
(312, 122, 315, 1, 1, 1, 1, 0),
(313, 122, 315, 2, 1, 1, 1, 0),
(314, 124, 317, 1, 1, 1, 1, 0),
(315, 124, 317, 3, 1, 1, 1, 0),
(316, 126, 326, 1, 100, 100, 1, 0),
(317, 126, 327, 1, 100, 100, 1, 0),
(318, 126, 328, 1, 100, 100, 1, 0),
(319, 127, 329, 1, 100, 0, 0, 0),
(320, 128, 331, 1, 200, 200, 1, 0),
(321, 129, 332, 4, 100, 100, 1, 0),
(322, 129, 332, 5, 100, 100, 1, 0),
(323, 129, 333, 4, 100, 100, 1, 0),
(324, 129, 333, 5, 100, 100, 1, 0),
(325, 129, 334, 4, 100, 100, 1, 0),
(326, 129, 334, 5, 100, 100, 1, 0),
(327, 129, 335, 4, 100, 100, 1, 0),
(328, 129, 335, 5, 100, 100, 1, 0),
(329, 129, 336, 4, 100, 100, 1, 0),
(330, 129, 336, 5, 100, 100, 1, 0),
(331, 129, 337, 4, 100, 100, 1, 0),
(332, 129, 337, 5, 100, 100, 1, 0),
(333, 130, 338, 1, 1000, 1000, 1, 0),
(334, 131, 339, 1, 400, 400, 1, 0),
(335, 132, 340, 1, 11, 0, 0, 0),
(336, 132, 340, 2, 0, 0, 0, 0),
(337, 132, 340, 6, 0, 0, 0, 0),
(338, 132, 340, 8, 0, 0, 0, 0),
(339, 133, 341, 6, 12, 0, 0, 0),
(340, 134, 342, 1, 12, 12, 1, 0),
(341, 134, 342, 2, 12, 12, 1, 0),
(342, 134, 342, 1, 12, 0, 0, 0),
(343, 134, 342, 2, 0, 0, 0, 0),
(344, 135, 343, 2, 122, 122, 1, 0),
(345, 137, 346, 1, 122, 0, 0, 0),
(346, 139, 350, 3, 1000, 1000, 1, 0),
(347, 139, 350, 4, 1000, 1000, 1, 0),
(348, 139, 351, 3, 10000, 10000, 1, 0),
(349, 139, 351, 4, 10000, 10000, 1, 0),
(350, 139, 352, 3, 100000, 100000, 1, 0),
(351, 139, 352, 4, 100000, 100000, 1, 0),
(352, 139, 353, 3, 1000000, 1000000, 1, 0),
(353, 139, 353, 4, 1000000, 1000000, 1, 0),
(354, 140, 354, 1, 1000000, 1, 1, 0),
(355, 140, 354, 6, 1, 1, 1, 0),
(356, 140, 355, 1, 2, 2, 1, 0),
(357, 140, 355, 6, 2, 2, 1, 0),
(358, 141, 356, 1, 122, 122, 1, 0),
(359, 141, 356, 2, 122, 122, 1, 0),
(360, 144, 360, 1, 100, 100, 1, 0),
(361, 144, 360, 12, 100, 100, 1, 0),
(362, 144, 360, 4, 100, 100, 1, 0),
(363, 144, 360, 9, 100, 100, 1, 0),
(364, 144, 361, 1, 100, 100, 1, 0),
(365, 144, 361, 12, 100, 100, 1, 0),
(366, 144, 361, 4, 100, 100, 1, 0),
(367, 144, 361, 9, 100, 100, 1, 0),
(368, 144, 362, 1, 100, 100, 1, 0),
(369, 144, 362, 12, 100, 100, 1, 0),
(370, 144, 362, 4, 100, 100, 1, 0),
(371, 144, 362, 9, 100, 100, 1, 0),
(372, 144, 363, 1, 100, 100, 1, 0),
(373, 144, 363, 12, 100, 100, 1, 0),
(374, 144, 363, 4, 100, 100, 1, 0),
(375, 144, 363, 9, 100, 100, 1, 0),
(376, 144, 364, 1, 100, 100, 1, 0),
(377, 144, 364, 12, 100, 100, 1, 0),
(378, 144, 364, 4, 100, 100, 1, 0),
(379, 144, 364, 9, 100, 100, 1, 0),
(380, 144, 365, 1, 100, 100, 1, 0),
(381, 144, 365, 12, 100, 100, 1, 0),
(382, 144, 365, 4, 100, 100, 1, 0),
(383, 144, 365, 9, 100, 100, 1, 0),
(384, 145, 366, 1, 100, 100, 1, 0),
(385, 145, 366, 2, 100, 100, 1, 0),
(386, 145, 366, 5, 100, 100, 1, 0),
(387, 145, 366, 9, 100, 100, 1, 0),
(388, 148, 369, 1, 120, 120, 1, 0),
(389, 148, 369, 2, 120, 120, 1, 0),
(390, 148, 369, 4, 120, 120, 1, 0),
(391, 148, 369, 7, 120, 120, 1, 0),
(392, 149, 370, 1, 210, 0, 0, 0),
(393, 149, 370, 2, 0, 0, 0, 0),
(394, 149, 370, 4, 0, 0, 0, 0),
(395, 149, 370, 5, 0, 0, 0, 0),
(396, 150, 371, 4, 10, 10, 1, 0),
(397, 150, 372, 4, 10, 10, 1, 0),
(398, 151, 373, 9, 5, 0, 0, 0),
(399, 151, 373, 10, 0, 0, 0, 0),
(400, 151, 373, 11, 0, 0, 0, 0),
(401, 151, 373, 12, 0, 0, 0, 0),
(402, 151, 374, 9, 3, 0, 0, 0),
(403, 151, 374, 10, 0, 0, 0, 0),
(404, 151, 374, 11, 0, 0, 0, 0),
(405, 151, 374, 12, 0, 0, 0, 0),
(406, 151, 375, 9, 2, 0, 0, 0),
(407, 151, 375, 10, 0, 0, 0, 0),
(408, 151, 375, 11, 0, 0, 0, 0),
(409, 151, 375, 12, 0, 0, 0, 0),
(410, 152, 376, 1, 3, 3, 0, 0),
(411, 152, 376, 4, 3, 2, 0, 0),
(412, 152, 376, 8, 2, 0, 0, 0),
(413, 152, 376, 12, 0, 0, 0, 0),
(414, 152, 377, 1, 2, 2, 0, 0),
(415, 152, 377, 4, 2, 1, 0, 0),
(416, 152, 377, 8, 1, 0, 0, 0),
(417, 152, 377, 12, 0, 0, 0, 0),
(418, 152, 378, 1, 5, 5, 0, 0),
(419, 152, 378, 4, 5, 2, 0, 0),
(420, 152, 378, 8, 2, 0, 0, 0),
(421, 152, 378, 12, 0, 0, 0, 0),
(422, 153, 379, 1, 120, 120, 1, 0),
(423, 153, 379, 2, 120, 120, 1, 0),
(424, 153, 380, 1, 100, 100, 1, 0),
(425, 153, 380, 2, 100, 100, 1, 0),
(426, 153, 381, 1, 134, 134, 1, 0),
(427, 153, 381, 2, 134, 134, 1, 0),
(428, 155, 385, 1, 3, 3, 1, 0),
(429, 155, 385, 2, 3, 3, 1, 0),
(430, 155, 385, 6, 3, 3, 1, 0),
(431, 155, 385, 12, 3, 3, 1, 0),
(432, 155, 386, 1, 5, 5, 1, 0),
(433, 155, 386, 2, 5, 5, 1, 0),
(434, 155, 386, 6, 5, 5, 1, 0),
(435, 155, 386, 12, 5, 5, 1, 0),
(436, 155, 387, 1, 2, 2, 1, 0),
(437, 155, 387, 2, 2, 2, 1, 0),
(438, 155, 387, 6, 2, 2, 1, 0),
(439, 155, 387, 12, 2, 2, 1, 0),
(440, 157, 390, 1, 4, 4, 1, 0),
(441, 157, 390, 4, 4, 4, 1, 0),
(442, 157, 390, 5, 4, 4, 1, 0),
(443, 157, 390, 8, 4, 4, 1, 0),
(444, 157, 390, 12, 4, 4, 1, 0),
(445, 157, 391, 1, 5, 5, 1, 0),
(446, 157, 391, 4, 5, 5, 1, 0),
(447, 157, 391, 5, 5, 5, 1, 0),
(448, 157, 391, 8, 5, 5, 1, 0),
(449, 157, 391, 12, 5, 5, 1, 0),
(450, 157, 392, 1, 1, 1, 1, 0),
(451, 157, 392, 4, 1, 1, 1, 0),
(452, 157, 392, 5, 1, 1, 1, 0),
(453, 157, 392, 8, 1, 1, 1, 0),
(454, 157, 392, 12, 1, 1, 1, 0),
(455, 158, 393, 9, 50, 50, 1, 0),
(456, 158, 393, 10, 50, 50, 1, 0),
(457, 158, 393, 11, 50, 50, 1, 0),
(458, 158, 393, 12, 50, 50, 1, 0),
(459, 158, 394, 9, 150, 150, 1, 0),
(460, 158, 394, 10, 150, 150, 1, 0),
(461, 158, 394, 11, 150, 150, 1, 0),
(462, 158, 394, 12, 150, 150, 1, 0),
(463, 158, 395, 9, 100, 100, 1, 0),
(464, 158, 395, 10, 100, 100, 1, 0),
(465, 158, 395, 11, 100, 100, 1, 0),
(466, 158, 395, 12, 100, 100, 1, 0),
(467, 158, 396, 9, 50, 50, 1, 0),
(468, 158, 396, 10, 50, 50, 1, 0),
(469, 158, 396, 11, 50, 50, 1, 0),
(470, 158, 396, 12, 50, 50, 1, 0),
(471, 160, 400, 4, 1, 1, 1, 0),
(472, 160, 401, 4, 1, 1, 1, 0),
(473, 160, 402, 4, 1, 1, 1, 0),
(474, 161, 403, 1, 1, 1, 1, 0),
(475, 161, 403, 2, 1, 1, 1, 0),
(476, 161, 404, 1, 2, 2, 1, 0),
(477, 161, 404, 2, 2, 2, 1, 0),
(482, 166, 422, 6, 10, 0, 0, 0),
(483, 166, 423, 6, 100, 0, 0, 0),
(484, 166, 424, 6, 20, 0, 0, 0),
(485, 166, 425, 6, 100, 0, 0, 0),
(490, 168, 428, 11, 10, 0, 0, 0),
(491, 168, 429, 11, 10, 0, 0, 0),
(492, 168, 428, 11, 10, 0, 0, 0),
(493, 168, 429, 11, 10, 0, 0, 0),
(494, 168, 430, 11, 10, 0, 0, 0),
(495, 168, 431, 11, 10, 0, 0, 0),
(507, 171, 441, 5, 500, 0, 0, 0),
(508, 171, 442, 5, 10, 0, 0, 0),
(509, 171, 443, 5, 40, 0, 0, 0),
(510, 171, 441, 9, 500, 0, 0, 0),
(511, 171, 442, 9, 10, 0, 0, 0),
(512, 171, 443, 9, 40, 0, 0, 0),
(513, 171, 445, 9, 50, 0, 0, 0),
(514, 171, 446, 9, 10, 0, 0, 0),
(515, 171, 447, 9, 40, 0, 0, 0),
(516, 171, 445, 9, 50, 0, 0, 0),
(517, 171, 446, 9, 10, 0, 0, 0),
(518, 171, 447, 9, 40, 0, 0, 0),
(519, 176, 451, 5, 2, 2, 1, 0),
(520, 176, 451, 6, 2, 2, 1, 11),
(521, 176, 452, 5, 1, 1, 1, 0),
(522, 176, 452, 6, 1, 1, 1, 11),
(523, 177, 453, 5, 10, 0, 0, 0),
(524, 177, 454, 5, 10, 0, 0, 0),
(525, 177, 455, 5, 10, 0, 0, 0),
(526, 180, 461, 5, 10, 10, 1, 13),
(527, 180, 462, 5, 1, 1, 1, 13),
(528, 180, 463, 5, 1, 1, 1, 13),
(529, 181, 464, 5, 20, 20, 1, 16),
(530, 182, 465, 20, 5, 5, 1, 18),
(531, 182, 466, 20, 3, 3, 1, 18),
(532, 182, 467, 20, 2, 2, 1, 18),
(533, 183, 468, 10, 10, 10, 1, 19),
(534, 183, 469, 10, 2, 2, 1, 19),
(535, 184, 470, 10, 10, 10, 1, 20),
(536, 184, 471, 10, 2, 2, 1, 20),
(537, 185, 472, 16, 2, 2, 1, 21),
(538, 186, 473, 26, 1, 1, 1, 22),
(539, 187, 474, 26, 1, 1, 1, 23),
(540, 188, 475, 5, 10, 10, 1, 0),
(541, 188, 475, 20, 10, 10, 1, 24),
(542, 188, 476, 5, 10, 10, 1, 0),
(543, 188, 476, 20, 10, 10, 1, 24),
(544, 188, 477, 5, 15, 15, 1, 0),
(545, 188, 477, 20, 15, 5, 1, 24),
(546, 188, 478, 5, 15, 15, 1, 0),
(547, 188, 478, 20, 15, 15, 1, 24),
(548, 189, 479, 22, 1, 1, 1, 25),
(549, 190, 480, 22, 1, 1, 1, 26),
(550, 190, 481, 22, 1, 1, 1, 26),
(551, 191, 482, 16, 1, 1, 1, 27),
(552, 192, 483, 22, 5, 5, 1, 29),
(553, 192, 484, 22, 6, 6, 1, 29),
(554, 192, 485, 22, 7, 7, 1, 29),
(555, 193, 486, 16, 10, 10, 1, 30),
(556, 194, 487, 16, 2, 2, 1, 31),
(557, 195, 488, 16, 5, 5, 1, 32),
(558, 195, 489, 16, 12, 12, 1, 32),
(559, 195, 490, 16, 4, 4, 1, 32),
(560, 195, 491, 16, 3, 3, 1, 32),
(561, 195, 488, 16, 5, 0, 0, 0),
(562, 195, 489, 16, 12, 0, 0, 0),
(563, 195, 490, 16, 4, 0, 0, 0),
(564, 195, 491, 16, 3, 0, 0, 0),
(565, 196, 492, 11, 7, 7, 1, 33),
(566, 197, 493, 16, 10, 10, 1, 34),
(567, 197, 494, 16, 1, 1, 1, 34),
(568, 197, 495, 16, 2, 2, 1, 34),
(569, 199, 498, 22, 2, 2, 1, 35),
(570, 198, 496, 16, 10, 10, 1, 36),
(571, 198, 497, 16, 2, 2, 1, 36),
(572, 201, 500, 22, 5, 5, 1, 38),
(573, 201, 501, 22, 2, 2, 1, 38),
(574, 201, 502, 22, 4, 4, 1, 38),
(575, 201, 503, 22, 3, 3, 1, 38),
(576, 201, 504, 22, 1, 1, 1, 38),
(577, 202, 505, 16, 3, 3, 1, 39),
(578, 203, 506, 16, 4, 4, 1, 40),
(579, 204, 507, 21, 2, 2, 1, 41),
(580, 204, 508, 21, 2, 2, 1, 41),
(581, 204, 509, 21, 2, 2, 1, 41),
(582, 205, 510, 14, 10, 10, 1, 42),
(583, 205, 511, 14, 10, 5, 1, 42),
(584, 205, 512, 14, 10, 10, 1, 42),
(585, 206, 513, 14, 3, 2, 1, 43),
(586, 206, 513, 14, 3, 0, 0, 0),
(587, 206, 513, 14, 3, 0, 0, 0),
(588, 207, 514, 16, 2, 2, 1, 44),
(589, 209, 519, 9, 1, 1, 1, 45),
(590, 209, 520, 9, 1, 1, 1, 45),
(591, 210, 521, 9, 10, 10, 1, 46),
(592, 210, 522, 9, 1, 1, 1, 46),
(593, 213, 526, 9, 1, 1, 1, 47),
(594, 214, 527, 14, 100, 100, 1, 48),
(595, 216, 531, 13, 10, 10, 1, 49),
(596, 216, 532, 13, 10, 10, 1, 49),
(597, 216, 533, 13, 10, 10, 1, 49),
(598, 217, 534, 9, 5, 5, 1, 50),
(599, 217, 534, 9, 5, 0, 0, 0),
(600, 215, 528, 6, 10, 10, 1, 52),
(601, 215, 529, 6, 10, 10, 1, 52),
(602, 215, 530, 6, 10, 10, 1, 52),
(603, 218, 535, 22, 2, 2, 1, 53),
(604, 218, 536, 22, 1, 1, 1, 53),
(605, 218, 537, 22, 3, 3, 1, 53),
(606, 220, 540, 16, 2, 2, 1, 54),
(607, 220, 541, 16, 1, 1, 1, 54),
(608, 220, 542, 16, 1, 1, 1, 54),
(609, 221, 543, 16, 10, 10, 1, 55),
(610, 222, 544, 16, 1, 1, 1, 56),
(611, 223, 545, 5, 10, 10, 1, 0),
(612, 223, 545, 9, 10, 10, 1, 57),
(613, 223, 546, 5, 10, 10, 1, 0),
(614, 223, 546, 9, 10, 10, 1, 57),
(615, 223, 547, 5, 90, 90, 1, 0),
(616, 223, 547, 9, 90, 90, 1, 57),
(617, 224, 548, 5, 10, 10, 1, 58),
(618, 225, 550, 9, 98, 98, 1, 59),
(619, 226, 551, 9, 10, 10, 1, 60),
(620, 227, 552, 9, 1, 1, 1, 61),
(621, 228, 553, 20, 100, 100, 1, 62),
(622, 229, 554, 9, 10, 10, 1, 63),
(623, 230, 555, 9, 100, 100, 1, 64),
(624, 231, 556, 9, 200, 200, 1, 65),
(625, 232, 557, 15, 100, 100, 1, 66),
(626, 233, 558, 15, 5, 5, 1, 67),
(627, 234, 559, 14, 10, 10, 1, 0),
(628, 234, 559, 16, 10, 10, 1, 68),
(629, 234, 560, 14, 10, 10, 1, 0),
(630, 234, 560, 16, 10, 10, 1, 68),
(631, 236, 562, 21, 10, 10, 1, 0),
(632, 236, 562, 22, 10, 10, 1, 69),
(633, 236, 563, 21, 10, 10, 1, 0),
(634, 236, 563, 22, 10, 10, 1, 69),
(635, 236, 564, 21, 10, 10, 1, 0),
(636, 236, 564, 22, 10, 10, 1, 69),
(637, 236, 562, 21, 10, 0, 0, 0),
(638, 236, 562, 22, 0, 0, 0, 0),
(639, 236, 563, 21, 10, 0, 0, 0),
(640, 236, 563, 22, 0, 0, 0, 0),
(641, 236, 564, 21, 10, 0, 0, 0),
(642, 236, 564, 22, 0, 0, 0, 0),
(643, 237, 565, 21, 10, 10, 1, 0),
(644, 237, 565, 22, 10, 10, 1, 0),
(645, 237, 565, 20, 10, 10, 1, 70),
(646, 237, 566, 21, 10, 10, 1, 0),
(647, 237, 566, 22, 10, 10, 1, 0),
(648, 237, 566, 20, 10, 10, 1, 70),
(649, 237, 567, 21, 10, 10, 1, 0),
(650, 237, 567, 22, 10, 10, 1, 0),
(651, 237, 567, 20, 10, 10, 1, 70),
(652, 237, 565, 21, 10, 0, 0, 0),
(653, 237, 565, 22, 0, 0, 0, 0),
(654, 237, 565, 20, 0, 0, 0, 0),
(655, 237, 566, 21, 10, 0, 0, 0),
(656, 237, 566, 22, 0, 0, 0, 0),
(657, 237, 566, 20, 0, 0, 0, 0),
(658, 237, 567, 21, 10, 0, 0, 0),
(659, 237, 567, 22, 0, 0, 0, 0),
(660, 237, 567, 20, 0, 0, 0, 0),
(661, 238, 568, 5, 10, 10, 1, 71),
(662, 239, 569, 14, 10, 10, 1, 72),
(663, 241, 571, 34, 2, 2, 1, 0),
(664, 241, 571, 35, 2, 2, 1, 0),
(665, 241, 571, 36, 2, 2, 1, 0),
(666, 241, 571, 37, 2, 2, 1, 73),
(667, 242, 572, 14, 10, 10, 1, 0),
(668, 242, 572, 15, 10, 10, 1, 0),
(669, 242, 572, 16, 10, 10, 1, 74),
(670, 242, 573, 14, 1, 1, 1, 0),
(671, 242, 573, 15, 1, 1, 1, 0),
(672, 242, 573, 16, 1, 1, 1, 74),
(673, 242, 572, 14, 10, 0, 0, 0),
(674, 242, 572, 15, 0, 0, 0, 0),
(675, 242, 572, 16, 0, 0, 0, 0),
(676, 242, 573, 14, 1, 0, 0, 0),
(677, 242, 573, 15, 0, 0, 0, 0),
(678, 242, 573, 16, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_kcs_history`
--

CREATE TABLE IF NOT EXISTS `lifetek_kcs_history` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=805 ;

--
-- Dumping data for table `lifetek_kcs_history`
--

INSERT INTO `lifetek_kcs_history` (`id`, `kcs_history_id`, `request_id`, `feature_size_id`, `id_processes`, `quantity_kcs`, `quantity_success`, `quantity_error`, `cause_error`, `date_kcs`, `import_product_id`) VALUES
(149, 126, 53, 111, 4, 2, 1, 1, '', '2015-08-29 04:54:26', 0),
(150, 126, 53, 111, 4, 1, 1, 0, '', '2015-08-29 04:54:55', 0),
(151, 128, 54, 113, 6, 30, 20, 10, '', '2015-08-29 06:58:14', 0),
(152, 127, 54, 112, 6, 20, 10, 10, '', '2015-08-29 06:58:14', 0),
(153, 128, 54, 113, 6, 10, 10, 0, '', '2015-08-29 06:59:42', 0),
(154, 127, 54, 112, 6, 10, 10, 0, '', '2015-08-29 06:59:42', 0),
(155, 128, 54, 113, 6, 0, 0, 0, '', '2015-08-29 07:01:06', 0),
(156, 127, 54, 112, 6, 0, 0, 0, '', '2015-08-29 07:01:06', 0),
(157, 129, 55, 114, 5, 2, 0, 2, '', '2015-08-29 08:40:24', 0),
(158, 130, 55, 115, 5, 5, 5, 0, '', '2015-08-29 08:40:24', 0),
(159, 129, 55, 114, 5, 2, 1, 1, '', '2015-08-29 08:42:36', 0),
(160, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-29 08:42:36', 0),
(161, 129, 55, 114, 5, 1, 1, 0, '', '2015-08-29 08:43:40', 0),
(162, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-29 08:43:40', 0),
(163, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:05:04', 0),
(164, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:05:04', 0),
(165, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:05:20', 0),
(166, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:05:20', 0),
(167, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:06:00', 0),
(168, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:06:00', 0),
(169, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:08:30', 0),
(170, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:08:30', 0),
(171, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:09:10', 0),
(172, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:09:10', 0),
(173, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:09:26', 0),
(174, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:09:26', 0),
(175, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:09:46', 0),
(176, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:09:46', 0),
(177, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:10:07', 0),
(178, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:10:07', 0),
(179, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:11:48', 0),
(180, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:11:48', 0),
(181, 129, 55, 114, 5, 0, 0, 0, '', '2015-08-31 04:14:57', 0),
(182, 130, 55, 115, 5, 0, 0, 0, '', '2015-08-31 04:14:57', 0),
(183, 133, 57, 125, 4, 10, 10, 0, '', '2015-09-01 01:50:29', 0),
(184, 135, 57, 126, 4, 5, 5, 0, '', '2015-09-01 01:50:29', 0),
(185, 137, 57, 127, 4, 5, 3, 2, '', '2015-09-01 01:50:29', 0),
(186, 133, 57, 125, 4, 0, 0, 0, '', '2015-09-01 01:51:29', 0),
(187, 135, 57, 126, 4, 0, 0, 0, '', '2015-09-01 01:51:29', 0),
(188, 137, 57, 127, 4, 2, 2, 0, '', '2015-09-01 01:51:29', 0),
(189, 134, 57, 125, 5, 10, 1, 9, '', '2015-09-01 03:53:59', 0),
(190, 136, 57, 126, 5, 5, 2, 3, '', '2015-09-01 03:53:59', 0),
(191, 138, 57, 127, 5, 5, 2, 3, '', '2015-09-01 03:54:00', 0),
(192, 134, 57, 125, 5, 9, 1, 8, '', '2015-09-01 03:56:21', 0),
(193, 136, 57, 126, 5, 3, 1, 2, '', '2015-09-01 03:56:21', 0),
(194, 138, 57, 127, 5, 3, 1, 2, '', '2015-09-01 03:56:21', 0),
(195, 139, 58, 128, 4, 20, 20, 0, '', '2015-09-01 04:03:33', 0),
(196, 141, 58, 129, 4, 30, 30, 0, '', '2015-09-01 04:03:33', 0),
(197, 143, 58, 130, 4, 10, 10, 0, '', '2015-09-01 04:03:33', 0),
(198, 140, 58, 128, 6, 20, 20, 0, '', '2015-09-01 04:03:43', 0),
(199, 142, 58, 129, 6, 30, 30, 0, '', '2015-09-01 04:03:43', 0),
(200, 144, 58, 130, 6, 10, 10, 0, '', '2015-09-01 04:03:43', 0),
(201, 140, 58, 128, 6, 0, 0, 0, '', '2015-09-01 04:03:59', 0),
(202, 142, 58, 129, 6, 0, 0, 0, '', '2015-09-01 04:03:59', 0),
(203, 144, 58, 130, 6, 0, 0, 0, '', '2015-09-01 04:03:59', 0),
(204, 145, 50, 106, 4, 8, 8, 0, '', '2015-09-01 04:34:37', 0),
(205, 147, 50, 107, 4, 80, 79, 1, '', '2015-09-01 04:34:37', 0),
(206, 145, 50, 106, 4, 0, 0, 0, '', '2015-09-01 04:34:48', 0),
(207, 147, 50, 107, 4, 1, 1, 0, '', '2015-09-01 04:34:48', 0),
(208, 146, 50, 106, 5, 8, 5, 3, '', '2015-09-01 04:35:17', 0),
(209, 148, 50, 107, 5, 80, 78, 2, '', '2015-09-01 04:35:17', 0),
(210, 146, 50, 106, 5, 3, 3, 0, '', '2015-09-01 04:35:52', 0),
(211, 148, 50, 107, 5, 2, 1, 1, '', '2015-09-01 04:35:52', 0),
(212, 149, 60, 134, 4, 20, 20, 0, '', '2015-09-01 07:14:30', 0),
(213, 152, 60, 135, 4, 30, 30, 0, '', '2015-09-01 07:14:30', 0),
(214, 155, 60, 136, 4, 50, 50, 0, '', '2015-09-01 07:14:30', 0),
(215, 150, 60, 134, 5, 20, 19, 1, '', '2015-09-01 07:14:49', 0),
(216, 153, 60, 135, 5, 30, 30, 0, '', '2015-09-01 07:14:49', 0),
(217, 156, 60, 136, 5, 50, 50, 0, '', '2015-09-01 07:14:49', 0),
(218, 150, 60, 134, 5, 1, 1, 0, '', '2015-09-01 07:15:05', 0),
(219, 153, 60, 135, 5, 0, 0, 0, '', '2015-09-01 07:15:05', 0),
(220, 156, 60, 136, 5, 0, 0, 0, '', '2015-09-01 07:15:05', 0),
(221, 151, 60, 134, 6, 20, 20, 0, '', '2015-09-01 07:15:24', 0),
(222, 154, 60, 135, 6, 30, 30, 0, '', '2015-09-01 07:15:24', 0),
(223, 157, 60, 136, 6, 50, 50, 0, '', '2015-09-01 07:15:24', 0),
(224, 164, 61, 140, 1, 20, 19, 1, '', '2015-09-01 08:28:31', 0),
(225, 166, 61, 141, 1, 10, 10, 0, '', '2015-09-01 08:28:31', 0),
(226, 168, 61, 142, 1, 10, 10, 0, '', '2015-09-01 08:28:31', 0),
(227, 158, 61, 137, 1, 20, 20, 0, '', '2015-09-01 08:28:31', 0),
(228, 160, 61, 138, 1, 10, 10, 0, '', '2015-09-01 08:28:31', 0),
(229, 162, 61, 139, 1, 10, 10, 0, '', '2015-09-01 08:28:31', 0),
(230, 164, 61, 140, 1, 1, 1, 0, '', '2015-09-01 08:29:42', 0),
(231, 166, 61, 141, 1, 0, 0, 0, '', '2015-09-01 08:29:42', 0),
(232, 168, 61, 142, 1, 0, 0, 0, '', '2015-09-01 08:29:42', 0),
(233, 158, 61, 137, 1, 0, 0, 0, '', '2015-09-01 08:29:42', 0),
(234, 160, 61, 138, 1, 0, 0, 0, '', '2015-09-01 08:29:42', 0),
(235, 162, 61, 139, 1, 0, 0, 0, '', '2015-09-01 08:29:42', 0),
(236, 165, 61, 140, 2, 10, 0, 10, '', '2015-09-01 08:32:13', 0),
(237, 167, 61, 141, 2, 10, 10, 0, '', '2015-09-01 08:32:13', 0),
(238, 169, 61, 142, 2, 10, 10, 0, '', '2015-09-01 08:32:13', 0),
(239, 159, 61, 137, 2, 20, 20, 0, '', '2015-09-01 08:32:13', 0),
(240, 161, 61, 138, 2, 10, 10, 0, '', '2015-09-01 08:32:13', 0),
(241, 163, 61, 139, 2, 10, 10, 0, '', '2015-09-01 08:32:13', 0),
(242, 165, 61, 140, 2, 20, 20, 0, '', '2015-09-01 08:39:04', 0),
(243, 167, 61, 141, 2, 0, 0, 0, '', '2015-09-01 08:39:04', 0),
(244, 169, 61, 142, 2, 0, 0, 0, '', '2015-09-01 08:39:04', 0),
(245, 159, 61, 137, 2, 0, 0, 0, '', '2015-09-01 08:39:04', 0),
(246, 161, 61, 138, 2, 0, 0, 0, '', '2015-09-01 08:39:04', 0),
(247, 163, 61, 139, 2, 0, 0, 0, '', '2015-09-01 08:39:04', 0),
(248, 173, 62, 146, 1, 5, 5, 0, '', '2015-09-01 09:43:15', 0),
(249, 174, 62, 147, 1, 5, 4, 1, '', '2015-09-01 09:43:15', 0),
(250, 175, 62, 148, 1, 5, 4, 1, '', '2015-09-01 09:43:15', 0),
(251, 170, 62, 143, 1, 5, 5, 0, '', '2015-09-01 09:43:15', 0),
(252, 171, 62, 144, 1, 5, 5, 0, '', '2015-09-01 09:43:15', 0),
(253, 172, 62, 145, 1, 5, 4, 1, '', '2015-09-01 09:43:15', 0),
(254, 177, 63, 150, 3, 11, 11, 0, '', '2015-09-01 10:01:31', 0),
(255, 176, 63, 149, 3, 11, 11, 0, '', '2015-09-01 10:01:31', 0),
(256, 177, 63, 150, 3, -1, -1, 0, '', '2015-09-01 10:02:30', 0),
(257, 176, 63, 149, 3, -1, -1, 0, '', '2015-09-01 10:02:30', 0),
(258, 177, 63, 150, 3, 0, 0, 0, '', '2015-09-01 10:07:48', 0),
(259, 176, 63, 149, 3, 0, 0, 0, '', '2015-09-01 10:07:48', 0),
(260, 178, 67, 160, 4, 17, 17, 0, '', '2015-09-03 04:40:05', 0),
(261, 180, 67, 161, 4, 17, 17, 0, '', '2015-09-03 04:40:05', 0),
(262, 182, 67, 162, 4, 17, 17, 0, '', '2015-09-03 04:40:05', 0),
(263, 179, 67, 160, 7, 17, 17, 0, '', '2015-09-03 04:40:13', 0),
(264, 181, 67, 161, 7, 17, 17, 0, '', '2015-09-03 04:40:13', 0),
(265, 183, 67, 162, 7, 17, 17, 0, '', '2015-09-03 04:40:13', 0),
(266, 184, 73, 182, 4, 1, 1, 0, '', '2015-09-03 09:22:09', 0),
(267, 189, 77, 193, 7, 10, 10, 0, '', '2015-09-04 04:50:58', 0),
(268, 190, 77, 194, 7, 10, 10, 0, '', '2015-09-04 04:50:58', 0),
(269, 187, 77, 191, 7, 10, 10, 0, '', '2015-09-04 04:50:58', 0),
(270, 188, 77, 192, 7, 10, 10, 0, '', '2015-09-04 04:50:58', 0),
(271, 191, 80, 201, 4, 35, 35, 0, '', '2015-09-04 06:53:12', 0),
(272, 192, 80, 202, 4, 35, 35, 0, '', '2015-09-04 06:53:12', 0),
(273, 193, 80, 203, 4, 35, 34, 1, '', '2015-09-04 06:53:12', 0),
(274, 218, 81, 207, 1, 100000, 100000, 0, '', '2015-09-04 09:15:55', 0),
(275, 214, 81, 206, 1, 10000, 10000, 0, '', '2015-09-04 09:15:55', 0),
(276, 210, 81, 205, 1, 1000, 1000, 0, '', '2015-09-04 09:15:55', 0),
(277, 206, 81, 204, 1, 100, 100, 0, '', '2015-09-04 09:15:55', 0),
(278, 218, 81, 207, 1, 0, 0, 0, '', '2015-09-04 09:16:10', 0),
(279, 214, 81, 206, 1, 0, 0, 0, '', '2015-09-04 09:16:10', 0),
(280, 210, 81, 205, 1, 0, 0, 0, '', '2015-09-04 09:16:10', 0),
(281, 206, 81, 204, 1, 0, 0, 0, '', '2015-09-04 09:16:10', 0),
(282, 219, 81, 207, 2, 100000, 100000, 0, '', '2015-09-04 09:16:59', 0),
(283, 215, 81, 206, 2, 10000, 10000, 0, '', '2015-09-04 09:16:59', 0),
(284, 211, 81, 205, 2, 1000, 1000, 0, '', '2015-09-04 09:16:59', 0),
(285, 207, 81, 204, 2, 100, 100, 0, '', '2015-09-04 09:16:59', 0),
(286, 220, 81, 207, 5, 100000, 100000, 0, '', '2015-09-04 09:17:12', 0),
(287, 216, 81, 206, 5, 10000, 10000, 0, '', '2015-09-04 09:17:12', 0),
(288, 212, 81, 205, 5, 1000, 1000, 0, '', '2015-09-04 09:17:12', 0),
(289, 208, 81, 204, 5, 100, 100, 0, '', '2015-09-04 09:17:12', 0),
(290, 221, 81, 207, 7, 100000, 100000, 0, '', '2015-09-04 09:18:02', 0),
(291, 217, 81, 206, 7, 10000, 10000, 0, '', '2015-09-04 09:18:02', 0),
(292, 213, 81, 205, 7, 1000, 1000, 0, '', '2015-09-04 09:18:02', 0),
(293, 209, 81, 204, 7, 100, 100, 0, '', '2015-09-04 09:18:02', 0),
(294, 194, 83, 212, 4, 20, 20, 0, '', '2015-09-04 09:27:00', 0),
(295, 197, 83, 213, 4, 10, 10, 0, '', '2015-09-04 09:27:00', 0),
(296, 200, 83, 214, 4, 10, 10, 0, '', '2015-09-04 09:27:00', 0),
(297, 203, 83, 215, 4, 10, 10, 0, '', '2015-09-04 09:27:00', 0),
(298, 195, 83, 212, 5, 20, 20, 0, '', '2015-09-04 09:29:05', 0),
(299, 198, 83, 213, 5, 10, 10, 0, '', '2015-09-04 09:29:05', 0),
(300, 201, 83, 214, 5, 10, 10, 0, '', '2015-09-04 09:29:05', 0),
(301, 204, 83, 215, 5, 10, 10, 0, '', '2015-09-04 09:29:05', 0),
(302, 196, 83, 212, 6, 20, 20, 0, '', '2015-09-04 09:29:31', 0),
(303, 199, 83, 213, 6, 10, 10, 0, '', '2015-09-04 09:29:31', 0),
(304, 202, 83, 214, 6, 10, 10, 0, '', '2015-09-04 09:29:31', 0),
(305, 205, 83, 215, 6, 10, 10, 0, '', '2015-09-04 09:29:31', 0),
(306, 223, 84, 221, 3, 10, 10, 0, '', '2015-09-04 10:07:00', 0),
(307, 222, 84, 220, 3, 100, 100, 0, '', '2015-09-04 10:07:00', 0),
(308, 223, 84, 221, 3, 0, 0, 0, '', '2015-09-04 10:07:15', 0),
(309, 222, 84, 220, 3, 0, 0, 0, '', '2015-09-04 10:07:15', 0),
(310, 226, 85, 223, 1, 10, 10, 0, '', '2015-09-04 10:09:50', 0),
(311, 224, 85, 222, 1, 10, 10, 0, '', '2015-09-04 10:09:50', 0),
(312, 195, 83, 212, 5, 0, 0, 0, '', '2015-09-04 10:12:45', 0),
(313, 198, 83, 213, 5, 0, 0, 0, '', '2015-09-04 10:12:45', 0),
(314, 201, 83, 214, 5, 0, 0, 0, '', '2015-09-04 10:12:45', 0),
(315, 204, 83, 215, 5, 0, 0, 0, '', '2015-09-04 10:12:45', 0),
(316, 241, 80, 217, 6, 35, 35, 0, '', '2015-09-07 09:37:52', 0),
(317, 242, 80, 218, 6, 35, 35, 0, '', '2015-09-07 09:37:52', 0),
(318, 243, 80, 219, 6, 35, 35, 0, '', '2015-09-07 09:37:52', 0),
(319, 240, 80, 216, 6, 10, 10, 0, '', '2015-09-07 09:37:52', 0),
(320, 244, 91, 259, 4, 28, 28, 0, '', '2015-09-08 06:31:50', 0),
(321, 246, 91, 260, 4, 28, 28, 0, '', '2015-09-08 06:31:50', 0),
(322, 248, 91, 261, 4, 28, 28, 0, '', '2015-09-08 06:31:50', 0),
(323, 250, 91, 262, 4, 28, 28, 0, '', '2015-09-08 06:31:50', 0),
(324, 245, 91, 259, 5, 28, 28, 0, '', '2015-09-08 06:52:31', 0),
(325, 247, 91, 260, 5, 28, 28, 0, '', '2015-09-08 06:52:31', 0),
(326, 249, 91, 261, 5, 28, 28, 0, '', '2015-09-08 06:52:31', 0),
(327, 251, 91, 262, 5, 28, 25, 3, '', '2015-09-08 06:52:31', 0),
(328, 245, 91, 259, 5, 0, 0, 0, '', '2015-09-08 06:52:48', 0),
(329, 247, 91, 260, 5, 0, 0, 0, '', '2015-09-08 06:52:48', 0),
(330, 249, 91, 261, 5, 0, 0, 0, '', '2015-09-08 06:52:48', 0),
(331, 251, 91, 262, 5, 3, 3, 0, '', '2015-09-08 06:52:48', 0),
(332, 252, 92, 263, 4, 31, 31, 0, '', '2015-09-08 10:15:40', 0),
(333, 254, 92, 264, 4, 31, 31, 0, '', '2015-09-08 10:15:40', 0),
(334, 256, 92, 265, 4, 31, 31, 0, '', '2015-09-08 10:15:40', 0),
(335, 258, 92, 266, 4, 31, 31, 0, '', '2015-09-08 10:15:40', 0),
(336, 253, 92, 263, 7, 31, 31, 0, '', '2015-09-08 10:15:48', 0),
(337, 255, 92, 264, 7, 31, 31, 0, '', '2015-09-08 10:15:48', 0),
(338, 257, 92, 265, 7, 31, 31, 0, '', '2015-09-08 10:15:48', 0),
(339, 259, 92, 266, 7, 31, 31, 0, '', '2015-09-08 10:15:48', 0),
(340, 260, 93, 267, 4, 31, 31, 0, '', '2015-09-09 07:35:52', 0),
(341, 263, 93, 268, 4, 31, 30, 1, '', '2015-09-09 07:35:52', 0),
(342, 266, 93, 269, 4, 31, 31, 0, '', '2015-09-09 07:35:52', 0),
(343, 269, 93, 270, 4, 31, 29, 2, '', '2015-09-09 07:35:52', 0),
(344, 260, 93, 267, 4, 0, 0, 0, '', '2015-09-09 07:36:07', 0),
(345, 263, 93, 268, 4, 1, 1, 0, '', '2015-09-09 07:36:07', 0),
(346, 266, 93, 269, 4, 0, 0, 0, '', '2015-09-09 07:36:07', 0),
(347, 269, 93, 270, 4, 2, 2, 0, '', '2015-09-09 07:36:07', 0),
(348, 261, 93, 267, 5, 31, 31, 0, '', '2015-09-09 07:36:26', 0),
(349, 264, 93, 268, 5, 31, 31, 0, '', '2015-09-09 07:36:26', 0),
(350, 267, 93, 269, 5, 31, 31, 0, '', '2015-09-09 07:36:26', 0),
(351, 270, 93, 270, 5, 31, 31, 0, '', '2015-09-09 07:36:26', 0),
(352, 262, 93, 267, 7, 31, 31, 0, '', '2015-09-09 07:36:33', 0),
(353, 265, 93, 268, 7, 31, 31, 0, '', '2015-09-09 07:36:33', 0),
(354, 268, 93, 269, 7, 31, 31, 0, '', '2015-09-09 07:36:33', 0),
(355, 271, 93, 270, 7, 31, 31, 0, '', '2015-09-09 07:36:33', 0),
(356, 274, 97, 277, 4, 50, 50, 0, '', '2015-09-23 03:55:07', 0),
(357, 272, 97, 276, 4, 20, 20, 0, '', '2015-09-23 03:55:07', 0),
(358, 275, 97, 277, 5, 50, 50, 0, '', '2015-09-23 03:55:12', 0),
(359, 273, 97, 276, 5, 20, 20, 0, '', '2015-09-23 03:55:12', 0),
(360, 275, 97, 277, 5, 0, 0, 0, '', '2015-09-23 07:34:39', 0),
(361, 273, 97, 276, 5, 0, 0, 0, '', '2015-09-23 07:34:39', 0),
(362, 276, 100, 280, 4, 30, 25, 5, '', '2015-09-23 09:53:37', 0),
(363, 277, 100, 280, 6, 25, 20, 5, '', '2015-09-23 09:53:53', 0),
(364, 276, 100, 280, 4, 5, 5, 0, '', '2015-09-23 09:54:19', 0),
(365, 277, 100, 280, 6, 10, 10, 0, '', '2015-09-23 09:54:26', 0),
(366, 280, 101, 282, 4, 10, 10, 0, '', '2015-09-23 10:03:49', 0),
(367, 278, 101, 281, 4, 30, 25, 5, '', '2015-09-23 10:03:49', 0),
(368, 281, 101, 282, 6, 10, 10, 0, '', '2015-09-23 10:04:05', 0),
(369, 279, 101, 281, 6, 25, 25, 0, '', '2015-09-23 10:04:05', 0),
(370, 280, 101, 282, 4, 0, 0, 0, '', '2015-09-23 10:04:49', 0),
(371, 278, 101, 281, 4, 5, 5, 0, '', '2015-09-23 10:04:49', 0),
(372, 281, 101, 282, 6, 0, 0, 0, '', '2015-09-23 10:05:03', 0),
(373, 279, 101, 281, 6, 5, 3, 2, '', '2015-09-23 10:05:03', 0),
(374, 281, 101, 282, 6, 0, 0, 0, '', '2015-09-23 10:05:18', 0),
(375, 279, 101, 281, 6, 2, 2, 0, '', '2015-09-23 10:05:18', 0),
(376, 282, 102, 283, 5, 10, 8, 2, '', '2015-09-23 10:09:17', 0),
(377, 283, 102, 283, 6, 8, 8, 0, '', '2015-09-23 10:09:25', 0),
(378, 282, 102, 283, 5, 2, 2, 0, '', '2015-09-23 10:09:38', 0),
(379, 283, 102, 283, 6, 2, 1, 1, '', '2015-09-23 10:09:46', 0),
(380, 283, 102, 283, 6, 1, 1, 0, '', '2015-09-23 10:10:01', 0),
(381, 284, 105, 286, 4, 20, 20, 0, '', '2015-09-23 10:39:49', 0),
(382, 285, 106, 287, 4, 20, 20, 0, '', '2015-09-24 08:41:04', 0),
(383, 286, 106, 288, 4, 40, 40, 0, '', '2015-09-24 08:41:04', 0),
(384, 287, 106, 289, 4, 30, 30, 0, '', '2015-09-24 08:41:04', 0),
(385, 285, 106, 287, 4, 10, 10, 0, '', '2015-09-24 08:41:25', 0),
(386, 286, 106, 288, 4, 0, 0, 0, '', '2015-09-24 08:41:25', 0),
(387, 287, 106, 289, 4, 0, 0, 0, '', '2015-09-24 08:41:25', 0),
(388, 291, 107, 291, 4, 10, 10, 0, '', '2015-09-25 03:23:03', 0),
(389, 289, 107, 290, 4, 20, 18, 2, '', '2015-09-25 03:23:03', 0),
(390, 292, 107, 291, 6, 10, 10, 0, '', '2015-09-25 03:23:13', 0),
(391, 290, 107, 290, 6, 18, 18, 0, '', '2015-09-25 03:23:13', 0),
(392, 291, 107, 291, 4, 0, 0, 0, '', '2015-09-25 03:23:30', 0),
(393, 289, 107, 290, 4, 2, 2, 0, '', '2015-09-25 03:23:30', 0),
(394, 292, 107, 291, 6, 0, 0, 0, '', '2015-09-25 03:23:38', 0),
(395, 290, 107, 290, 6, 2, 2, 0, '', '2015-09-25 03:23:38', 0),
(396, 293, 111, 299, 4, 2, 2, 0, '', '2015-09-30 04:38:43', 0),
(397, 293, 111, 299, 4, 2, 2, 0, '', '2015-09-30 04:41:22', 0),
(398, 293, 111, 299, 4, 5, 5, 0, '', '2015-09-30 04:42:51', 0),
(399, 293, 111, 299, 4, 4, 4, 0, '', '2015-09-30 04:44:20', 0),
(400, 293, 111, 299, 4, 0, 0, 0, '', '2015-09-30 04:45:07', 0),
(401, 295, 117, 306, 4, 10, 10, 0, '', '2015-09-30 08:04:30', 0),
(402, 296, 117, 307, 4, 10, 10, 0, '', '2015-09-30 08:04:30', 0),
(403, 297, 117, 308, 4, 10, 10, 0, '', '2015-09-30 08:04:30', 0),
(404, 295, 117, 306, 4, 0, 0, 0, '', '2015-09-30 08:04:46', 0),
(405, 296, 117, 307, 4, 0, 0, 0, '', '2015-09-30 08:04:46', 0),
(406, 297, 117, 308, 4, 0, 0, 0, '', '2015-09-30 08:04:46', 0),
(407, 298, 116, 309, 1, 2, 2, 0, '', '2015-09-30 08:08:30', 0),
(408, 301, 116, 310, 1, 2, 2, 0, '', '2015-09-30 08:08:30', 0),
(409, 298, 116, 309, 1, 50, 50, 0, '', '2015-09-30 08:08:59', 0),
(410, 301, 116, 310, 1, 54, 54, 0, '', '2015-09-30 08:08:59', 0),
(411, 299, 116, 309, 2, 52, 52, 0, '', '2015-09-30 08:09:43', 0),
(412, 302, 116, 310, 2, 56, 56, 0, '', '2015-09-30 08:09:43', 0),
(413, 304, 115, 304, 2, 12, 12, 0, '', '2015-09-30 08:11:43', 0),
(414, 304, 115, 304, 2, 0, 0, 0, '', '2015-09-30 08:13:21', 0),
(415, 300, 116, 309, 7, 2, 2, 0, '', '2015-09-30 08:17:24', 0),
(416, 303, 116, 310, 7, 6, 6, 0, '', '2015-09-30 08:17:24', 0),
(417, 298, 116, 309, 1, 68, 68, 0, '', '2015-09-30 08:18:32', 0),
(418, 301, 116, 310, 1, 44, 44, 0, '', '2015-09-30 08:18:32', 0),
(419, 298, 116, 309, 1, 0, 0, 0, '', '2015-09-30 08:18:50', 0),
(420, 301, 116, 310, 1, 0, 0, 0, '', '2015-09-30 08:18:50', 0),
(421, 299, 116, 309, 2, 68, 68, 0, '', '2015-09-30 08:19:01', 0),
(422, 302, 116, 310, 2, 44, 44, 0, '', '2015-09-30 08:19:01', 0),
(423, 300, 116, 309, 7, 118, 118, 0, '', '2015-09-30 08:19:21', 0),
(424, 303, 116, 310, 7, 94, 94, 0, '', '2015-09-30 08:19:21', 0),
(425, 305, 119, 312, 1, 1, 1, 0, '', '2015-09-30 08:46:16', 0),
(426, 306, 119, 312, 2, 1, 1, 0, '', '2015-09-30 08:46:28', 0),
(427, 307, 120, 313, 1, 1, 1, 0, '', '2015-09-30 08:50:07', 0),
(428, 307, 120, 313, 1, 1, 1, 0, '', '2015-09-30 08:51:38', 0),
(429, 307, 120, 313, 1, 1, 1, 0, '', '2015-09-30 08:51:42', 0),
(430, 307, 120, 313, 1, 1, 1, 0, '', '2015-09-30 08:51:53', 0),
(431, 307, 120, 313, 1, 1, 1, 0, '', '2015-09-30 08:51:56', 0),
(432, 307, 120, 313, 1, 1, 1, 0, '', '2015-09-30 08:52:00', 0),
(433, 308, 120, 313, 2, 1, 1, 0, '', '2015-09-30 08:52:23', 0),
(434, 308, 120, 313, 2, 1, 1, 0, '', '2015-09-30 08:52:30', 0),
(435, 308, 120, 313, 2, 1, 1, 0, '', '2015-09-30 08:52:35', 0),
(436, 308, 120, 313, 2, 1, 1, 0, '', '2015-09-30 08:52:49', 0),
(437, 308, 120, 313, 2, 1, 1, 0, '', '2015-09-30 08:53:03', 0),
(438, 308, 120, 313, 2, 1, 1, 0, '', '2015-09-30 08:53:06', 0),
(439, 307, 120, 313, 1, -3, -3, 0, '', '2015-09-30 08:53:20', 0),
(440, 307, 120, 313, 1, -3, -3, 0, '', '2015-09-30 08:53:24', 0),
(441, 310, 121, 314, 2, 10, 10, 0, '', '2015-09-30 08:55:30', 0),
(444, 312, 122, 315, 1, 1, 1, 0, '', '2015-09-30 09:00:04', 0),
(445, 313, 122, 315, 2, 1, 1, 0, '', '2015-09-30 09:00:12', 0),
(446, 314, 124, 317, 1, 1, 1, 0, '', '2015-09-30 09:12:33', 0),
(447, 315, 124, 317, 3, 1, 1, 0, '', '2015-09-30 09:12:39', 0),
(448, 316, 126, 326, 1, 50, 50, 0, '', '2015-10-01 08:45:47', 0),
(449, 317, 126, 327, 1, 50, 50, 0, '', '2015-10-01 08:45:47', 0),
(450, 318, 126, 328, 1, 50, 50, 0, '', '2015-10-01 08:45:47', 0),
(451, 316, 126, 326, 1, 50, 50, 0, '', '2015-10-01 08:47:16', 0),
(452, 317, 126, 327, 1, 50, 50, 0, '', '2015-10-01 08:47:16', 0),
(453, 318, 126, 328, 1, 50, 50, 0, '', '2015-10-01 08:47:16', 0),
(454, 320, 128, 331, 1, 200, 200, 0, '', '2015-10-02 02:01:29', 0),
(455, 320, 128, 331, 1, 0, 0, 0, '', '2015-10-02 02:01:41', 0),
(456, 327, 129, 335, 4, 100, 100, 0, '', '2015-10-02 04:23:43', 0),
(457, 329, 129, 336, 4, 100, 100, 0, '', '2015-10-02 04:23:43', 0),
(458, 331, 129, 337, 4, 100, 100, 0, '', '2015-10-02 04:23:43', 0),
(459, 321, 129, 332, 4, 100, 100, 0, '', '2015-10-02 04:23:43', 0),
(460, 323, 129, 333, 4, 100, 100, 0, '', '2015-10-02 04:23:43', 0),
(461, 325, 129, 334, 4, 100, 100, 0, '', '2015-10-02 04:23:43', 0),
(462, 328, 129, 335, 5, 50, 50, 0, '', '2015-10-02 04:25:17', 0),
(463, 330, 129, 336, 5, 50, 50, 0, '', '2015-10-02 04:25:17', 0),
(464, 332, 129, 337, 5, 50, 50, 0, '', '2015-10-02 04:25:17', 0),
(465, 322, 129, 332, 5, 50, 50, 0, '', '2015-10-02 04:25:17', 0),
(466, 324, 129, 333, 5, 50, 50, 0, '', '2015-10-02 04:25:17', 0),
(467, 326, 129, 334, 5, 50, 50, 0, '', '2015-10-02 04:25:17', 0),
(468, 327, 129, 335, 4, 0, 0, 0, '', '2015-10-02 06:40:34', 0),
(469, 329, 129, 336, 4, 0, 0, 0, '', '2015-10-02 06:40:34', 0),
(470, 331, 129, 337, 4, 0, 0, 0, '', '2015-10-02 06:40:34', 0),
(471, 321, 129, 332, 4, 0, 0, 0, '', '2015-10-02 06:40:34', 0),
(472, 323, 129, 333, 4, 0, 0, 0, '', '2015-10-02 06:40:34', 0),
(473, 325, 129, 334, 4, 0, 0, 0, '', '2015-10-02 06:40:34', 0),
(474, 328, 129, 335, 5, 50, 50, 0, '', '2015-10-02 06:41:32', 0),
(475, 330, 129, 336, 5, 50, 50, 0, '', '2015-10-02 06:41:32', 0),
(476, 332, 129, 337, 5, 50, 50, 0, '', '2015-10-02 06:41:32', 0),
(477, 322, 129, 332, 5, 50, 50, 0, '', '2015-10-02 06:41:32', 0),
(478, 324, 129, 333, 5, 50, 50, 0, '', '2015-10-02 06:41:32', 0),
(479, 326, 129, 334, 5, 50, 50, 0, '', '2015-10-02 06:41:32', 0),
(480, 333, 130, 338, 1, 1000, 1000, 0, '', '2015-10-02 06:52:15', 0),
(481, 333, 130, 338, 1, 0, 0, 0, '', '2015-10-02 06:52:27', 0),
(482, 334, 131, 339, 1, 400, 400, 0, '', '2015-10-02 06:58:30', 0),
(483, 340, 134, 342, 1, 12, 12, 0, '', '2015-10-02 08:39:39', 0),
(484, 341, 134, 342, 2, 12, 12, 0, '', '2015-10-02 08:40:27', 0),
(485, 344, 135, 343, 2, 122, 122, 0, '', '2015-10-02 08:47:43', 0),
(486, 352, 139, 353, 3, 1000000, 1000000, 0, '', '2015-10-06 07:29:02', 0),
(487, 346, 139, 350, 3, 1000, 1000, 0, '', '2015-10-06 07:29:02', 0),
(488, 348, 139, 351, 3, 10000, 10000, 0, '', '2015-10-06 07:29:02', 0),
(489, 350, 139, 352, 3, 100000, 100000, 0, '', '2015-10-06 07:29:02', 0),
(490, 353, 139, 353, 4, 1000000, 1000000, 0, '', '2015-10-06 07:29:17', 0),
(491, 347, 139, 350, 4, 1000, 1000, 0, '', '2015-10-06 07:29:17', 0),
(492, 349, 139, 351, 4, 10000, 10000, 0, '', '2015-10-06 07:29:17', 0),
(493, 351, 139, 352, 4, 100000, 100000, 0, '', '2015-10-06 07:29:17', 0),
(494, 353, 139, 353, 4, 0, 0, 0, '', '2015-10-06 07:43:05', 0),
(495, 347, 139, 350, 4, 0, 0, 0, '', '2015-10-06 07:43:05', 0),
(496, 349, 139, 351, 4, 0, 0, 0, '', '2015-10-06 07:43:05', 0),
(497, 351, 139, 352, 4, 0, 0, 0, '', '2015-10-06 07:43:05', 0),
(498, 353, 139, 353, 4, 0, 0, 0, '', '2015-10-06 07:43:41', 0),
(499, 347, 139, 350, 4, 0, 0, 0, '', '2015-10-06 07:43:41', 0),
(500, 349, 139, 351, 4, 0, 0, 0, '', '2015-10-06 07:43:41', 0),
(501, 351, 139, 352, 4, 0, 0, 0, '', '2015-10-06 07:43:41', 0),
(502, 353, 139, 353, 4, 0, 0, 0, '', '2015-10-06 07:46:08', 0),
(503, 347, 139, 350, 4, 0, 0, 0, '', '2015-10-06 07:46:08', 0),
(504, 349, 139, 351, 4, 0, 0, 0, '', '2015-10-06 07:46:08', 0),
(505, 351, 139, 352, 4, 0, 0, 0, '', '2015-10-06 07:46:08', 0),
(506, 352, 139, 353, 3, 0, 0, 0, '', '2015-10-06 08:09:46', 0),
(507, 346, 139, 350, 3, 0, 0, 0, '', '2015-10-06 08:09:46', 0),
(508, 348, 139, 351, 3, 0, 0, 0, '', '2015-10-06 08:09:46', 0),
(509, 350, 139, 352, 3, 0, 0, 0, '', '2015-10-06 08:09:46', 0),
(510, 354, 140, 354, 1, 1, 1, 0, '', '2015-10-06 09:07:35', 0),
(511, 356, 140, 355, 1, 2, 2, 0, '', '2015-10-06 09:07:35', 0),
(512, 355, 140, 354, 6, 1, 1, 0, '', '2015-10-06 09:08:39', 0),
(513, 357, 140, 355, 6, 2, 2, 0, '', '2015-10-06 09:08:39', 0),
(514, 353, 139, 353, 4, 0, 0, 0, '', '2015-10-06 09:12:26', 0),
(515, 347, 139, 350, 4, 0, 0, 0, '', '2015-10-06 09:12:26', 0),
(516, 349, 139, 351, 4, 0, 0, 0, '', '2015-10-06 09:12:26', 0),
(517, 351, 139, 352, 4, 0, 0, 0, '', '2015-10-06 09:12:26', 0),
(518, 358, 141, 356, 1, 122, 122, 0, '', '2015-10-06 09:39:21', 0),
(519, 359, 141, 356, 2, 122, 122, 0, '', '2015-10-06 09:39:30', 0),
(520, 358, 141, 356, 1, 0, 0, 0, '', '2015-10-06 09:39:38', 0),
(521, 359, 141, 356, 2, 0, 0, 0, '', '2015-10-06 09:39:46', 0),
(522, 372, 144, 363, 1, 100, 100, 0, '', '2015-10-09 07:59:18', 0),
(523, 376, 144, 364, 1, 100, 100, 0, '', '2015-10-09 07:59:18', 0),
(524, 380, 144, 365, 1, 100, 100, 0, '', '2015-10-09 07:59:18', 0),
(525, 360, 144, 360, 1, 100, 100, 0, '', '2015-10-09 07:59:18', 0),
(526, 364, 144, 361, 1, 100, 100, 0, '', '2015-10-09 07:59:18', 0),
(527, 368, 144, 362, 1, 100, 100, 0, '', '2015-10-09 07:59:18', 0),
(528, 373, 144, 363, 12, 100, 100, 0, '', '2015-10-09 08:03:19', 0),
(529, 377, 144, 364, 12, 100, 100, 0, '', '2015-10-09 08:03:19', 0),
(530, 381, 144, 365, 12, 100, 100, 0, '', '2015-10-09 08:03:19', 0),
(531, 361, 144, 360, 12, 100, 100, 0, '', '2015-10-09 08:03:19', 0),
(532, 365, 144, 361, 12, 100, 100, 0, '', '2015-10-09 08:03:19', 0),
(533, 369, 144, 362, 12, 100, 100, 0, '', '2015-10-09 08:03:19', 0),
(534, 374, 144, 363, 4, 100, 100, 0, '', '2015-10-09 08:03:34', 0),
(535, 378, 144, 364, 4, 100, 100, 0, '', '2015-10-09 08:03:34', 0),
(536, 382, 144, 365, 4, 100, 100, 0, '', '2015-10-09 08:03:34', 0),
(537, 362, 144, 360, 4, 100, 100, 0, '', '2015-10-09 08:03:34', 0),
(538, 366, 144, 361, 4, 100, 100, 0, '', '2015-10-09 08:03:34', 0),
(539, 370, 144, 362, 4, 100, 100, 0, '', '2015-10-09 08:03:34', 0),
(540, 375, 144, 363, 9, 100, 100, 0, '', '2015-10-09 08:03:51', 0),
(541, 379, 144, 364, 9, 100, 100, 0, '', '2015-10-09 08:03:51', 0),
(542, 383, 144, 365, 9, 100, 100, 0, '', '2015-10-09 08:03:51', 0),
(543, 363, 144, 360, 9, 100, 100, 0, '', '2015-10-09 08:03:51', 0),
(544, 367, 144, 361, 9, 100, 100, 0, '', '2015-10-09 08:03:51', 0),
(545, 371, 144, 362, 9, 100, 100, 0, '', '2015-10-09 08:03:51', 0),
(546, 372, 144, 363, 1, 0, 0, 0, '', '2015-10-09 08:09:31', 0),
(547, 376, 144, 364, 1, 0, 0, 0, '', '2015-10-09 08:09:31', 0),
(548, 380, 144, 365, 1, 0, 0, 0, '', '2015-10-09 08:09:31', 0),
(549, 360, 144, 360, 1, 0, 0, 0, '', '2015-10-09 08:09:31', 0),
(550, 364, 144, 361, 1, 0, 0, 0, '', '2015-10-09 08:09:31', 0),
(551, 368, 144, 362, 1, 0, 0, 0, '', '2015-10-09 08:09:31', 0),
(552, 373, 144, 363, 12, 0, 0, 0, '', '2015-10-09 08:10:48', 0),
(553, 377, 144, 364, 12, 0, 0, 0, '', '2015-10-09 08:10:48', 0),
(554, 381, 144, 365, 12, 0, 0, 0, '', '2015-10-09 08:10:48', 0),
(555, 361, 144, 360, 12, 0, 0, 0, '', '2015-10-09 08:10:48', 0),
(556, 365, 144, 361, 12, 0, 0, 0, '', '2015-10-09 08:10:48', 0),
(557, 369, 144, 362, 12, 0, 0, 0, '', '2015-10-09 08:10:48', 0),
(558, 374, 144, 363, 4, 0, 0, 0, '', '2015-10-09 08:11:36', 0),
(559, 378, 144, 364, 4, 0, 0, 0, '', '2015-10-09 08:11:36', 0),
(560, 382, 144, 365, 4, 0, 0, 0, '', '2015-10-09 08:11:36', 0),
(561, 362, 144, 360, 4, 0, 0, 0, '', '2015-10-09 08:11:36', 0),
(562, 366, 144, 361, 4, 0, 0, 0, '', '2015-10-09 08:11:36', 0),
(563, 370, 144, 362, 4, 0, 0, 0, '', '2015-10-09 08:11:36', 0),
(564, 375, 144, 363, 9, 0, 0, 0, '', '2015-10-09 08:11:48', 0),
(565, 379, 144, 364, 9, 0, 0, 0, '', '2015-10-09 08:11:48', 0),
(566, 383, 144, 365, 9, 0, 0, 0, '', '2015-10-09 08:11:48', 0),
(567, 363, 144, 360, 9, 0, 0, 0, '', '2015-10-09 08:11:48', 0),
(568, 367, 144, 361, 9, 0, 0, 0, '', '2015-10-09 08:11:48', 0),
(569, 371, 144, 362, 9, 0, 0, 0, '', '2015-10-09 08:11:48', 0),
(570, 384, 145, 366, 1, 100, 100, 0, '', '2015-10-09 08:37:51', 0),
(571, 385, 145, 366, 2, 100, 100, 0, '', '2015-10-09 08:37:58', 0),
(572, 386, 145, 366, 5, 100, 100, 0, '', '2015-10-09 08:38:05', 0),
(573, 387, 145, 366, 9, 100, 100, 0, '', '2015-10-09 08:38:12', 0),
(574, 388, 148, 369, 1, 120, 120, 0, '', '2015-10-09 09:41:50', 0),
(575, 389, 148, 369, 2, 120, 120, 0, '', '2015-10-09 09:42:02', 0),
(576, 390, 148, 369, 4, 120, 120, 0, '', '2015-10-09 09:42:25', 0),
(577, 391, 148, 369, 7, 120, 120, 0, '', '2015-10-09 09:42:56', 0),
(578, 396, 150, 371, 4, 10, 10, 0, '', '2015-10-09 10:56:53', 0),
(579, 397, 150, 372, 4, 10, 10, 0, '', '2015-10-09 10:56:53', 0),
(580, 422, 153, 379, 1, 120, 120, 0, '', '2015-10-10 04:50:08', 0),
(581, 424, 153, 380, 1, 100, 100, 0, '', '2015-10-10 04:50:08', 0),
(582, 426, 153, 381, 1, 134, 134, 0, '', '2015-10-10 04:50:08', 0),
(583, 423, 153, 379, 2, 120, 120, 0, '', '2015-10-10 04:50:20', 0),
(584, 425, 153, 380, 2, 100, 100, 0, '', '2015-10-10 04:50:20', 0),
(585, 427, 153, 381, 2, 134, 134, 0, '', '2015-10-10 04:50:20', 0),
(586, 422, 153, 379, 1, 0, 0, 0, '', '2015-10-10 04:50:30', 0),
(587, 424, 153, 380, 1, 0, 0, 0, '', '2015-10-10 04:50:30', 0),
(588, 426, 153, 381, 1, 0, 0, 0, '', '2015-10-10 04:50:30', 0),
(589, 423, 153, 379, 2, 0, 0, 0, '', '2015-10-10 04:50:38', 0),
(590, 425, 153, 380, 2, 0, 0, 0, '', '2015-10-10 04:50:38', 0),
(591, 427, 153, 381, 2, 0, 0, 0, '', '2015-10-10 04:50:38', 0),
(592, 428, 155, 385, 1, 3, 3, 0, '', '2015-10-12 02:14:30', 0),
(593, 432, 155, 386, 1, 5, 5, 0, '', '2015-10-12 02:14:30', 0),
(594, 436, 155, 387, 1, 2, 2, 0, '', '2015-10-12 02:14:30', 0),
(595, 429, 155, 385, 2, 3, 3, 0, '', '2015-10-12 02:14:44', 0),
(596, 433, 155, 386, 2, 5, 5, 0, '', '2015-10-12 02:14:44', 0),
(597, 437, 155, 387, 2, 2, 2, 0, '', '2015-10-12 02:14:44', 0),
(598, 430, 155, 385, 6, 3, 3, 0, '', '2015-10-12 02:14:56', 0),
(599, 434, 155, 386, 6, 5, 5, 0, '', '2015-10-12 02:14:56', 0),
(600, 438, 155, 387, 6, 2, 2, 0, '', '2015-10-12 02:14:56', 0),
(601, 431, 155, 385, 12, 3, 3, 0, '', '2015-10-12 02:15:11', 0),
(602, 435, 155, 386, 12, 5, 5, 0, '', '2015-10-12 02:15:11', 0),
(603, 439, 155, 387, 12, 2, 2, 0, '', '2015-10-12 02:15:11', 0),
(604, 440, 157, 390, 1, 4, 4, 0, '', '2015-10-12 03:49:25', 0),
(605, 445, 157, 391, 1, 5, 5, 0, '', '2015-10-12 03:49:25', 0),
(606, 450, 157, 392, 1, 1, 1, 0, '', '2015-10-12 03:49:25', 0),
(607, 441, 157, 390, 4, 4, 4, 0, '', '2015-10-12 03:49:32', 0),
(608, 446, 157, 391, 4, 5, 5, 0, '', '2015-10-12 03:49:32', 0),
(609, 451, 157, 392, 4, 1, 1, 0, '', '2015-10-12 03:49:32', 0),
(610, 442, 157, 390, 5, 4, 4, 0, '', '2015-10-12 03:49:39', 0),
(611, 447, 157, 391, 5, 5, 5, 0, '', '2015-10-12 03:49:39', 0),
(612, 452, 157, 392, 5, 1, 1, 0, '', '2015-10-12 03:49:39', 0),
(613, 443, 157, 390, 8, 4, 4, 0, '', '2015-10-12 03:49:47', 0),
(614, 448, 157, 391, 8, 5, 5, 0, '', '2015-10-12 03:49:47', 0),
(615, 453, 157, 392, 8, 1, 1, 0, '', '2015-10-12 03:49:47', 0),
(616, 444, 157, 390, 12, 4, 4, 0, '', '2015-10-12 03:49:57', 0),
(617, 449, 157, 391, 12, 5, 5, 0, '', '2015-10-12 03:49:57', 0),
(618, 454, 157, 392, 12, 1, 1, 0, '', '2015-10-12 03:49:57', 0),
(619, 455, 158, 393, 9, 50, 50, 0, '', '2015-10-13 07:13:51', 0),
(620, 459, 158, 394, 9, 150, 150, 0, '', '2015-10-13 07:13:51', 0),
(621, 463, 158, 395, 9, 100, 100, 0, '', '2015-10-13 07:13:51', 0),
(622, 467, 158, 396, 9, 50, 50, 0, '', '2015-10-13 07:13:51', 0),
(623, 456, 158, 393, 10, 50, 50, 0, '', '2015-10-13 07:14:06', 0),
(624, 460, 158, 394, 10, 150, 150, 0, '', '2015-10-13 07:14:06', 0),
(625, 464, 158, 395, 10, 100, 100, 0, '', '2015-10-13 07:14:06', 0),
(626, 468, 158, 396, 10, 50, 50, 0, '', '2015-10-13 07:14:06', 0),
(627, 457, 158, 393, 11, 50, 50, 0, '', '2015-10-13 07:14:21', 0),
(628, 461, 158, 394, 11, 150, 150, 0, '', '2015-10-13 07:14:21', 0),
(629, 465, 158, 395, 11, 100, 100, 0, '', '2015-10-13 07:14:21', 0),
(630, 469, 158, 396, 11, 50, 50, 0, '', '2015-10-13 07:14:21', 0),
(631, 458, 158, 393, 12, 50, 50, 0, '', '2015-10-13 07:14:28', 0),
(632, 462, 158, 394, 12, 150, 150, 0, '', '2015-10-13 07:14:28', 0),
(633, 466, 158, 395, 12, 100, 100, 0, '', '2015-10-13 07:14:28', 0),
(634, 470, 158, 396, 12, 50, 50, 0, '', '2015-10-13 07:14:28', 0),
(635, 410, 152, 376, 1, 3, 3, 0, '', '2015-10-20 03:32:09', 0),
(636, 414, 152, 377, 1, 2, 2, 0, '', '2015-10-20 03:32:09', 0),
(637, 418, 152, 378, 1, 5, 5, 0, '', '2015-10-20 03:32:09', 0),
(638, 411, 152, 376, 4, 3, 2, 1, '', '2015-10-20 03:33:31', 0),
(639, 415, 152, 377, 4, 2, 1, 1, '', '2015-10-20 03:33:31', 0),
(640, 419, 152, 378, 4, 5, 2, 3, '', '2015-10-20 03:33:31', 0),
(641, 471, 160, 400, 4, 1, 1, 0, '', '2015-10-28 05:01:21', 0),
(642, 472, 160, 401, 4, 1, 1, 0, '', '2015-10-28 05:01:21', 0),
(643, 473, 160, 402, 4, 1, 1, 0, '', '2015-10-28 05:01:21', 0),
(644, 474, 161, 403, 1, 1, 1, 0, '', '2015-10-29 08:56:20', 0),
(645, 476, 161, 404, 1, 2, 2, 0, '', '2015-10-29 08:56:20', 0),
(646, 475, 161, 403, 2, 1, 1, 0, '', '2015-10-29 08:56:26', 0),
(647, 477, 161, 404, 2, 2, 2, 0, '', '2015-10-29 08:56:26', 0),
(648, 519, 176, 451, 5, 2, 2, 0, '', '2015-11-12 10:18:50', 0),
(649, 521, 176, 452, 5, 1, 1, 0, '', '2015-11-12 10:18:50', 0),
(650, 520, 176, 451, 6, 2, 2, 0, '', '2015-11-12 10:23:19', 11),
(651, 522, 176, 452, 6, 1, 1, 0, '', '2015-11-12 10:23:19', 11),
(652, 526, 180, 461, 5, 5, 4, 1, '', '2015-11-17 10:14:57', 12),
(653, 527, 180, 462, 5, 1, 1, 0, '', '2015-11-17 10:14:57', 12),
(654, 528, 180, 463, 5, 1, 1, 0, '', '2015-11-17 10:14:57', 12),
(655, 526, 180, 461, 5, 6, 6, 0, '', '2015-11-17 10:15:58', 13),
(656, 527, 180, 462, 5, 0, 0, 0, '', '2015-11-17 10:15:58', 13),
(657, 528, 180, 463, 5, 0, 0, 0, '', '2015-11-17 10:15:58', 13),
(658, 529, 181, 464, 5, 20, 20, 0, '', '2015-11-17 10:26:35', 14),
(659, 529, 181, 464, 5, 0, 0, 0, '', '2015-11-17 10:28:02', 15),
(660, 529, 181, 464, 5, 0, 0, 0, '', '2015-11-17 10:28:12', 16),
(661, 530, 182, 465, 20, 5, 4, 1, '', '2015-11-18 02:43:20', 17),
(662, 531, 182, 466, 20, 3, 3, 0, '', '2015-11-18 02:43:20', 17),
(663, 532, 182, 467, 20, 2, 2, 0, '', '2015-11-18 02:43:20', 17),
(664, 530, 182, 465, 20, 1, 1, 0, '', '2015-11-18 02:44:02', 18),
(665, 531, 182, 466, 20, 0, 0, 0, '', '2015-11-18 02:44:02', 18),
(666, 532, 182, 467, 20, 0, 0, 0, '', '2015-11-18 02:44:02', 18),
(667, 533, 183, 468, 10, 10, 10, 0, '', '2015-11-18 03:09:58', 19),
(668, 534, 183, 469, 10, 2, 2, 0, '', '2015-11-18 03:09:58', 19),
(669, 535, 184, 470, 10, 10, 10, 0, '', '2015-11-18 03:26:05', 20),
(670, 536, 184, 471, 10, 2, 2, 0, '', '2015-11-18 03:26:05', 20),
(671, 537, 185, 472, 16, 2, 2, 0, '', '2015-11-18 03:44:22', 21),
(672, 538, 186, 473, 26, 1, 1, 0, '', '2015-11-18 03:59:39', 22),
(673, 539, 187, 474, 26, 1, 1, 0, '', '2015-11-18 04:19:06', 23),
(674, 544, 188, 477, 5, 10, 5, 5, '', '2015-11-18 04:45:19', 0),
(675, 546, 188, 478, 5, 15, 15, 0, '', '2015-11-18 04:45:19', 0),
(676, 540, 188, 475, 5, 10, 10, 0, '', '2015-11-18 04:45:19', 0),
(677, 542, 188, 476, 5, 10, 10, 0, '', '2015-11-18 04:45:19', 0),
(678, 545, 188, 477, 20, 5, 5, 0, '', '2015-11-18 04:46:06', 24),
(679, 547, 188, 478, 20, 15, 15, 0, '', '2015-11-18 04:46:06', 24),
(680, 541, 188, 475, 20, 10, 10, 0, '', '2015-11-18 04:46:06', 24),
(681, 543, 188, 476, 20, 10, 10, 0, '', '2015-11-18 04:46:06', 24),
(682, 544, 188, 477, 5, 10, 10, 0, '', '2015-11-18 04:46:28', 0),
(683, 546, 188, 478, 5, 0, 0, 0, '', '2015-11-18 04:46:28', 0),
(684, 540, 188, 475, 5, 0, 0, 0, '', '2015-11-18 04:46:28', 0),
(685, 542, 188, 476, 5, 0, 0, 0, '', '2015-11-18 04:46:28', 0),
(686, 548, 189, 479, 22, 1, 1, 0, '', '2015-11-18 04:57:16', 25),
(687, 549, 190, 480, 22, 1, 1, 0, '', '2015-11-18 07:22:28', 26),
(688, 550, 190, 481, 22, 1, 1, 0, '', '2015-11-18 07:22:28', 26),
(689, 551, 191, 482, 16, 1, 1, 0, '', '2015-11-18 07:33:05', 27),
(690, 552, 192, 483, 22, 5, 5, 0, '', '2015-11-18 07:57:58', 28),
(691, 553, 192, 484, 22, 6, 6, 0, '', '2015-11-18 07:57:58', 28),
(692, 554, 192, 485, 22, 7, 7, 0, '', '2015-11-18 07:57:58', 28),
(693, 552, 192, 483, 22, 0, 0, 0, '', '2015-11-18 08:17:03', 29),
(694, 553, 192, 484, 22, 0, 0, 0, '', '2015-11-18 08:17:03', 29),
(695, 554, 192, 485, 22, 0, 0, 0, '', '2015-11-18 08:17:03', 29),
(696, 555, 193, 486, 16, 10, 10, 0, '', '2015-11-18 08:24:13', 30),
(697, 556, 194, 487, 16, 2, 2, 0, '', '2015-11-18 08:35:56', 31),
(698, 557, 195, 488, 16, 5, 5, 0, '', '2015-11-18 09:27:33', 32),
(699, 558, 195, 489, 16, 12, 12, 0, '', '2015-11-18 09:27:33', 32),
(700, 559, 195, 490, 16, 4, 4, 0, '', '2015-11-18 09:27:33', 32),
(701, 560, 195, 491, 16, 3, 3, 0, '', '2015-11-18 09:27:33', 32),
(702, 565, 196, 492, 11, 7, 7, 0, '', '2015-11-18 09:36:43', 33),
(703, 566, 197, 493, 16, 10, 10, 0, '', '2015-11-19 01:57:14', 34),
(704, 567, 197, 494, 16, 1, 1, 0, '', '2015-11-19 01:57:14', 34),
(705, 568, 197, 495, 16, 2, 2, 0, '', '2015-11-19 01:57:14', 34),
(706, 569, 199, 498, 22, 2, 2, 0, '', '2015-11-19 02:40:52', 35),
(707, 570, 198, 496, 16, 10, 10, 0, '', '2015-11-19 03:18:37', 36),
(708, 571, 198, 497, 16, 2, 2, 0, '', '2015-11-19 03:18:37', 36),
(709, 572, 201, 500, 22, 5, 5, 0, '', '2015-11-19 03:27:20', 37),
(710, 573, 201, 501, 22, 2, 2, 0, '', '2015-11-19 03:27:20', 37),
(711, 574, 201, 502, 22, 4, 4, 0, '', '2015-11-19 03:27:20', 37),
(712, 575, 201, 503, 22, 3, 3, 0, '', '2015-11-19 03:27:20', 37),
(713, 576, 201, 504, 22, 1, 1, 0, '', '2015-11-19 03:27:20', 37),
(714, 572, 201, 500, 22, 0, 0, 0, '', '2015-11-19 03:28:25', 38),
(715, 573, 201, 501, 22, 0, 0, 0, '', '2015-11-19 03:28:25', 38),
(716, 574, 201, 502, 22, 0, 0, 0, '', '2015-11-19 03:28:25', 38),
(717, 575, 201, 503, 22, 0, 0, 0, '', '2015-11-19 03:28:25', 38),
(718, 576, 201, 504, 22, 0, 0, 0, '', '2015-11-19 03:28:25', 38),
(719, 577, 202, 505, 16, 3, 3, 0, '', '2015-11-19 03:34:11', 39),
(720, 578, 203, 506, 16, 4, 4, 0, '', '2015-11-19 03:39:44', 40),
(721, 579, 204, 507, 21, 2, 2, 0, '', '2015-11-19 03:54:48', 41),
(722, 580, 204, 508, 21, 2, 2, 0, '', '2015-11-19 03:54:48', 41),
(723, 581, 204, 509, 21, 2, 2, 0, '', '2015-11-19 03:54:48', 41),
(724, 582, 205, 510, 14, 10, 10, 0, '', '2015-11-19 04:03:01', 42),
(725, 583, 205, 511, 14, 10, 5, 5, '', '2015-11-19 04:03:01', 42),
(726, 584, 205, 512, 14, 10, 10, 0, '', '2015-11-19 04:03:01', 42),
(727, 585, 206, 513, 14, 3, 2, 1, '', '2015-11-19 04:11:09', 43),
(728, 588, 207, 514, 16, 2, 2, 0, '', '2015-11-19 04:53:36', 44),
(729, 590, 209, 520, 9, 1, 1, 0, '', '2015-11-24 01:38:20', 45),
(730, 589, 209, 519, 9, 1, 1, 0, '', '2015-11-24 01:38:20', 45),
(731, 591, 210, 521, 9, 10, 10, 0, '', '2015-11-24 04:47:23', 46),
(732, 592, 210, 522, 9, 1, 1, 0, '', '2015-11-24 04:47:23', 46),
(733, 593, 213, 526, 9, 1, 1, 0, '', '2015-11-24 04:51:49', 47),
(734, 594, 214, 527, 14, 100, 100, 0, '', '2015-11-24 06:55:35', 48),
(735, 597, 216, 533, 13, 10, 10, 0, '', '2015-11-24 07:04:17', 49),
(736, 595, 216, 531, 13, 10, 10, 0, '', '2015-11-24 07:04:17', 49),
(737, 596, 216, 532, 13, 10, 10, 0, '', '2015-11-24 07:04:17', 49),
(738, 598, 217, 534, 9, 5, 5, 0, '', '2015-11-24 07:08:24', 50),
(739, 602, 215, 530, 6, 10, 10, 0, '', '2015-11-24 09:04:06', 51),
(740, 600, 215, 528, 6, 10, 10, 0, '', '2015-11-24 09:04:06', 51),
(741, 601, 215, 529, 6, 10, 10, 0, '', '2015-11-24 09:04:06', 51),
(742, 602, 215, 530, 6, 0, 0, 0, '', '2015-11-24 09:04:17', 52),
(743, 600, 215, 528, 6, 0, 0, 0, '', '2015-11-24 09:04:17', 52),
(744, 601, 215, 529, 6, 0, 0, 0, '', '2015-11-24 09:04:17', 52),
(745, 603, 218, 535, 22, 2, 2, 0, '', '2015-11-25 03:46:16', 53),
(746, 604, 218, 536, 22, 1, 1, 0, '', '2015-11-25 03:46:16', 53),
(747, 605, 218, 537, 22, 3, 3, 0, '', '2015-11-25 03:46:16', 53),
(748, 606, 220, 540, 16, 2, 2, 0, '', '2015-11-25 03:58:14', 54),
(749, 607, 220, 541, 16, 1, 1, 0, '', '2015-11-25 03:58:14', 54),
(750, 608, 220, 542, 16, 1, 1, 0, '', '2015-11-25 03:58:14', 54),
(751, 609, 221, 543, 16, 10, 10, 0, '', '2015-11-25 04:23:12', 55),
(752, 610, 222, 544, 16, 1, 1, 0, '', '2015-11-25 04:25:53', 56),
(753, 611, 223, 545, 5, 10, 5, 5, '', '2015-11-26 04:20:24', 0),
(754, 613, 223, 546, 5, 10, 10, 0, '', '2015-11-26 04:20:24', 0),
(755, 615, 223, 547, 5, 90, 40, 50, '', '2015-11-26 04:20:24', 0),
(756, 611, 223, 545, 5, 5, 5, 0, '', '2015-11-28 04:48:26', 0),
(757, 613, 223, 546, 5, 0, 0, 0, '', '2015-11-28 04:48:26', 0),
(758, 615, 223, 547, 5, 50, 50, 0, '', '2015-11-28 04:48:26', 0),
(759, 612, 223, 545, 9, 10, 10, 0, '', '2015-11-28 04:49:08', 57),
(760, 614, 223, 546, 9, 10, 10, 0, '', '2015-11-28 04:49:08', 57),
(761, 616, 223, 547, 9, 90, 90, 0, '', '2015-11-28 04:49:08', 57),
(762, 617, 224, 548, 5, 10, 10, 0, '', '2015-12-07 03:32:04', 58),
(763, 618, 225, 550, 9, 98, 98, 0, '', '2015-12-10 07:34:42', 59),
(764, 619, 226, 551, 9, 10, 10, 0, '', '2015-12-10 07:57:05', 60),
(765, 620, 227, 552, 9, 1, 1, 0, '', '2015-12-10 08:16:31', 61),
(766, 621, 228, 553, 20, 100, 100, 0, '', '2015-12-10 08:21:30', 62),
(767, 622, 229, 554, 9, 10, 10, 0, '', '2015-12-10 08:35:16', 63),
(768, 623, 230, 555, 9, 100, 100, 0, '', '2015-12-10 08:37:49', 64),
(769, 624, 231, 556, 9, 200, 200, 0, '', '2015-12-10 08:43:44', 65),
(770, 625, 232, 557, 15, 100, 100, 0, '', '2015-12-10 09:05:38', 66),
(771, 626, 233, 558, 15, 5, 5, 0, '', '2015-12-16 07:45:37', 67),
(772, 627, 234, 559, 14, 10, 10, 0, '', '2015-12-21 03:42:22', 0),
(773, 629, 234, 560, 14, 10, 10, 0, '', '2015-12-21 03:42:22', 0),
(774, 628, 234, 559, 16, 10, 10, 0, '', '2015-12-21 03:42:50', 68),
(775, 630, 234, 560, 16, 10, 10, 0, '', '2015-12-21 03:42:50', 68),
(776, 631, 236, 562, 21, 10, 10, 0, '', '2015-12-25 02:21:03', 0),
(777, 633, 236, 563, 21, 10, 10, 0, '', '2015-12-25 02:21:03', 0),
(778, 635, 236, 564, 21, 10, 10, 0, '', '2015-12-25 02:21:03', 0),
(779, 632, 236, 562, 22, 10, 10, 0, '', '2015-12-25 02:21:30', 69),
(780, 634, 236, 563, 22, 10, 10, 0, '', '2015-12-25 02:21:30', 69),
(781, 636, 236, 564, 22, 10, 10, 0, '', '2015-12-25 02:21:30', 69),
(782, 643, 237, 565, 21, 10, 10, 0, '', '2015-12-25 02:37:59', 0),
(783, 646, 237, 566, 21, 10, 10, 0, '', '2015-12-25 02:37:59', 0),
(784, 649, 237, 567, 21, 10, 10, 0, '', '2015-12-25 02:37:59', 0),
(785, 644, 237, 565, 22, 10, 10, 0, '', '2015-12-25 02:38:16', 0),
(786, 647, 237, 566, 22, 10, 10, 0, '', '2015-12-25 02:38:16', 0),
(787, 650, 237, 567, 22, 10, 10, 0, '', '2015-12-25 02:38:16', 0),
(788, 645, 237, 565, 20, 10, 10, 0, '', '2015-12-25 02:38:26', 70),
(789, 648, 237, 566, 20, 10, 10, 0, '', '2015-12-25 02:38:26', 70),
(790, 651, 237, 567, 20, 10, 10, 0, '', '2015-12-25 02:38:26', 70),
(791, 661, 238, 568, 5, 10, 10, 0, '', '2015-12-25 02:59:28', 71),
(792, 662, 239, 569, 14, 10, 10, 0, '', '2015-12-25 03:32:39', 72),
(793, 663, 241, 571, 34, 2, 2, 0, '', '2016-01-06 08:20:34', 0),
(794, 664, 241, 571, 35, 2, 2, 0, '', '2016-01-06 08:21:11', 0),
(795, 665, 241, 571, 36, 2, 2, 0, '', '2016-01-06 08:22:58', 0),
(796, 666, 241, 571, 37, 2, 2, 0, '', '2016-01-06 08:23:31', 73),
(797, 667, 242, 572, 14, 10, 10, 0, '', '2016-01-06 10:30:32', 0),
(798, 670, 242, 573, 14, 1, 1, 0, '', '2016-01-06 10:30:32', 0),
(799, 667, 242, 572, 14, 0, 0, 0, '', '2016-01-06 10:30:52', 0),
(800, 670, 242, 573, 14, 0, 0, 0, '', '2016-01-06 10:30:52', 0),
(801, 668, 242, 572, 15, 10, 10, 0, '', '2016-01-06 10:31:42', 0),
(802, 671, 242, 573, 15, 1, 1, 0, '', '2016-01-06 10:31:42', 0),
(803, 669, 242, 572, 16, 10, 10, 0, '', '2016-01-06 10:32:18', 74),
(804, 672, 242, 573, 16, 1, 1, 0, '', '2016-01-06 10:32:18', 74);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_language`
--

CREATE TABLE IF NOT EXISTS `lifetek_language` (
  `id_language` int(11) NOT NULL AUTO_INCREMENT,
  `name_language` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_language`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mail_auto`
--

CREATE TABLE IF NOT EXISTS `lifetek_mail_auto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL COMMENT 'mã khách hàng',
  `year` int(11) NOT NULL COMMENT 'năm gửi chúc mừng',
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='bảng mail tự động' AUTO_INCREMENT=222 ;

--
-- Dumping data for table `lifetek_mail_auto`
--

INSERT INTO `lifetek_mail_auto` (`id`, `people_id`, `year`, `active`) VALUES
(1, 2090, 2015, 0),
(2, 2091, 2015, 0),
(3, 2097, 2015, 0),
(4, 2099, 2015, 0),
(5, 2102, 2015, 0),
(6, 2104, 2015, 0),
(7, 2105, 2015, 0),
(8, 2106, 2015, 0),
(9, 2107, 2015, 0),
(10, 2208, 2015, 1),
(11, 2209, 2015, 0),
(12, 2212, 2015, 1),
(13, 2216, 2015, 0),
(14, 2221, 2015, 0),
(15, 2242, 2015, 0),
(16, 2244, 2015, 1),
(17, 2245, 2015, 0),
(18, 2246, 2015, 0),
(19, 2250, 2015, 0),
(20, 2252, 2015, 1),
(21, 2258, 2015, 1),
(22, 2259, 2015, 0),
(23, 2260, 2015, 1),
(24, 2261, 2015, 0),
(25, 2265, 2015, 0),
(26, 2266, 2015, 0),
(27, 2277, 2015, 1),
(28, 2289, 2015, 1),
(29, 2290, 2015, 1),
(30, 2299, 2015, 0),
(31, 2300, 2015, 1),
(32, 2301, 2015, 0),
(33, 2302, 2015, 0),
(34, 2303, 2015, 0),
(35, 2306, 2015, 1),
(36, 2307, 2015, 1),
(37, 2310, 2015, 0),
(38, 2247, 2015, 1),
(39, 2318, 2015, 1),
(40, 2322, 2015, 0),
(41, 2324, 2015, 0),
(42, 2328, 2015, 0),
(43, 2330, 2015, 1),
(44, 2333, 2015, 0),
(45, 2339, 2015, 0),
(46, 2341, 2015, 1),
(47, 2342, 2015, 0),
(48, 2345, 2015, 0),
(49, 2346, 2015, 0),
(50, 2347, 2015, 0),
(51, 2348, 2015, 0),
(52, 2350, 2015, 0),
(53, 2095, 2015, 1),
(54, 2355, 2015, 1),
(55, 2356, 2015, 1),
(56, 2362, 2015, 1),
(57, 2366, 2015, 1),
(58, 2367, 2015, 1),
(59, 2368, 2015, 0),
(60, 2249, 2015, 0),
(61, 2369, 2015, 1),
(62, 2370, 2015, 1),
(63, 2371, 2015, 0),
(64, 2372, 2015, 0),
(65, 2373, 2015, 0),
(66, 2378, 2015, 0),
(67, 2379, 2015, 0),
(68, 2389, 2015, 1),
(69, 2393, 2015, 1),
(70, 2401, 2015, 0),
(71, 2402, 2015, 0),
(72, 2403, 2015, 0),
(73, 2404, 2015, 0),
(74, 2405, 2015, 0),
(75, 2405, 2015, 0),
(76, 2406, 2015, 0),
(77, 2406, 2015, 0),
(78, 2407, 2015, 0),
(79, 2408, 2015, 0),
(80, 2410, 2015, 0),
(81, 2411, 2015, 0),
(82, 2414, 2015, 0),
(83, 2414, 2015, 0),
(84, 2415, 2015, 0),
(85, 2416, 2015, 0),
(86, 2417, 2015, 0),
(87, 2421, 2015, 0),
(88, 2422, 2015, 0),
(89, 2424, 2015, 0),
(90, 2425, 2015, 0),
(91, 2426, 2015, 0),
(92, 2427, 2015, 0),
(93, 2429, 2015, 0),
(94, 2430, 2015, 0),
(95, 2431, 2015, 0),
(96, 2431, 2015, 0),
(97, 2432, 2015, 0),
(98, 2433, 2015, 0),
(99, 2434, 2015, 0),
(100, 2435, 2015, 0),
(101, 2436, 2015, 0),
(102, 2440, 2015, 0),
(103, 2113, 2016, 1),
(104, 2114, 2016, 1),
(105, 2115, 2016, 1),
(106, 2116, 2016, 1),
(107, 2117, 2016, 1),
(108, 2118, 2016, 1),
(109, 2119, 2016, 1),
(110, 2120, 2016, 1),
(111, 2121, 2016, 1),
(112, 2122, 2016, 1),
(113, 2123, 2016, 1),
(114, 2124, 2016, 1),
(115, 2125, 2016, 1),
(116, 2126, 2016, 1),
(117, 2127, 2016, 1),
(118, 2128, 2016, 1),
(119, 2129, 2016, 1),
(120, 2130, 2016, 1),
(121, 2131, 2016, 1),
(122, 2132, 2016, 1),
(123, 2133, 2016, 1),
(124, 2134, 2016, 1),
(125, 2135, 2016, 1),
(126, 2136, 2016, 1),
(127, 2137, 2016, 1),
(128, 2138, 2016, 1),
(129, 2139, 2016, 1),
(130, 2140, 2016, 1),
(131, 2141, 2016, 1),
(132, 2142, 2016, 1),
(133, 2143, 2016, 1),
(134, 2144, 2016, 1),
(135, 2145, 2016, 1),
(136, 2146, 2016, 1),
(137, 2147, 2016, 1),
(138, 2148, 2016, 0),
(139, 2149, 2016, 1),
(140, 2150, 2016, 1),
(141, 2151, 2016, 1),
(142, 2152, 2016, 1),
(143, 2153, 2016, 1),
(144, 2154, 2016, 1),
(145, 2155, 2016, 1),
(146, 2156, 2016, 1),
(147, 2157, 2016, 1),
(148, 2158, 2016, 0),
(149, 2159, 2016, 0),
(150, 2160, 2016, 1),
(151, 2161, 2016, 1),
(152, 2162, 2016, 1),
(153, 2163, 2016, 1),
(154, 2163, 2016, 1),
(155, 2164, 2016, 1),
(156, 2164, 2016, 1),
(157, 2165, 2016, 1),
(158, 2165, 2016, 1),
(159, 2166, 2016, 1),
(160, 2166, 2016, 1),
(161, 2167, 2016, 1),
(162, 2167, 2016, 1),
(163, 2168, 2016, 1),
(164, 2168, 2016, 1),
(165, 2169, 2016, 1),
(166, 2169, 2016, 1),
(167, 2170, 2016, 1),
(168, 2170, 2016, 1),
(169, 2171, 2016, 1),
(170, 2171, 2016, 1),
(171, 2172, 2016, 1),
(172, 2172, 2016, 1),
(173, 2173, 2016, 1),
(174, 2173, 2016, 1),
(175, 2174, 2016, 1),
(176, 2174, 2016, 1),
(177, 2175, 2016, 0),
(178, 2175, 2016, 0),
(179, 2176, 2016, 1),
(180, 2177, 2016, 1),
(181, 2178, 2016, 1),
(182, 2179, 2016, 1),
(183, 2180, 2016, 1),
(184, 2181, 2016, 1),
(185, 2182, 2016, 1),
(186, 2183, 2016, 1),
(187, 2184, 2016, 1),
(188, 2185, 2016, 0),
(189, 2186, 2016, 1),
(190, 2187, 2016, 1),
(191, 2188, 2016, 1),
(192, 2189, 2016, 1),
(193, 2190, 2016, 1),
(194, 2191, 2016, 0),
(195, 2192, 2016, 1),
(196, 2193, 2016, 1),
(197, 2194, 2016, 1),
(198, 2195, 2016, 1),
(199, 2196, 2016, 1),
(200, 2196, 2016, 1),
(201, 2197, 2016, 1),
(202, 2197, 2016, 1),
(203, 2253, 2016, 0),
(204, 2253, 2016, 0),
(205, 2254, 2016, 1),
(206, 2454, 2016, 0),
(207, 2455, 2016, 0),
(208, 2459, 2016, 0),
(209, 2460, 2016, 0),
(210, 2461, 2016, 0),
(211, 2462, 2016, 0),
(212, 2463, 2016, 0),
(213, 2464, 2016, 0),
(214, 2465, 2016, 0),
(215, 2466, 2016, 0),
(216, 2468, 2016, 0),
(217, 2469, 2016, 0),
(218, 2470, 2016, 0),
(219, 2471, 2016, 0),
(220, 2472, 2016, 0),
(221, 2475, 2016, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mail_history`
--

CREATE TABLE IF NOT EXISTS `lifetek_mail_history` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=414 ;

--
-- Dumping data for table `lifetek_mail_history`
--

INSERT INTO `lifetek_mail_history` (`id`, `person_id`, `employee_id`, `title`, `content`, `time`, `note`, `file`, `status`) VALUES
(1, 2090, 1, '', '', '2015-07-30 10:19:31', 'Gửi lại', '', 0),
(2, 2091, 1, '', '', '2015-07-30 10:19:36', 'Gửi lại', '', 0),
(3, 2097, 1, '', '', '2015-08-01 09:29:50', 'Gửi lại', '', 0),
(4, 2099, 1, '', '', '2015-08-03 07:30:19', 'Gửi lại', '', 0),
(5, 2102, 1, '', '', '2015-08-04 04:48:50', 'Gửi lại', '', 0),
(6, 2097, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-04 07:18:56', '', '', 0),
(7, 2104, 1, '', '', '2015-08-05 03:29:06', 'Gửi lại', '', 0),
(8, 2105, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-07 02:43:23', 'Gửi lại', '', 0),
(9, 2106, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-07 06:43:28', 'Gửi lại', '', 0),
(10, 2107, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-07 06:44:17', 'Gửi lại', '', 0),
(11, 2097, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :thuhuong@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-10 03:14:07', '', 'BG_2042_VuMen_10082015101404.xlsx', 0),
(12, 2097, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :thuhuong@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-10 10:27:44', '', 'BG_2044_VuMen_10082015172742.xlsx', 0),
(13, 2097, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 01:47:10', '', '', 0),
(14, 2197, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 01:47:50', '', '', 0),
(15, 2194, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 04:06:41', '', '', 0),
(16, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 04:15:09', '', '', 0),
(17, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 04:23:22', 'Gửi lại', '', 0),
(18, 2209, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 04:23:28', 'Gửi lại', '', 0),
(19, 2193, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-11 04:53:22', '', '', 0),
(20, 2209, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 01:58:18', '', '', 0),
(21, 2104, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 01:58:52', '', '', 0),
(22, 2104, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:02:14', '', '', 0),
(23, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:17:28', '', '', 0),
(24, 2209, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:19:06', '', '', 0),
(25, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:20:58', '', '', 0),
(26, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:21:54', '', '', 0),
(27, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:37:55', '', '', 0),
(28, 2209, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 02:38:00', '', '', 0),
(29, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-12 09:03:05', '', '', 0),
(30, 2208, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-12 09:09:29', '', '', 0),
(31, 2209, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Thu Lan</p>\n', '2015-08-12 09:11:08', '', '', 0),
(32, 2209, 1, 'Báo giá', '<p>Dear anh/chị:Nguyễn Thu Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :tuyendo1992@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-12 09:12:40', '', 'BG_2058_NguyenThuLan_12082015161237.xlsx', 0),
(33, 2209, 1, 'Báo giá', '<p>Dear anh/chị:Nguyễn Thu Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :tuyendo1992@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 01:38:40', '', 'BG_2058_NguyenThuLan_13082015083836.xlsx', 0),
(34, 2209, 1, 'Báo giá', '<p>Dear anh/chị:Nguyễn Thu Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 01:39:43', '', 'BG_2058_NguyenThuLan_13082015083938.xlsx', 1),
(35, 2208, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-13 01:40:27', '', '', 1),
(36, 2208, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-13 02:01:38', '', '', 1),
(37, 2208, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-13 03:18:02', '', '', 1),
(38, 2097, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 03:24:20', '', 'BG_2042_VuMen_13082015102416.xlsx', 1),
(39, 2097, 1, 'Hợp đồng', '<p>Dear anh/chị:Vũ Mến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4bizqlsx.lifetek.vn/backend/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 03:24:41', '', 'HD_2040_VuMen_13082015102437.xlsx', 1),
(40, 2208, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-13 03:35:54', 'Gửi lại', '', 1),
(41, 2212, 1, 'Báo giá', '<p>Dear anh/chị:Ngô Vũ Tiến Minh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Đội Cấn, Quận Ba Đình, HN</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 03:55:17', '', 'BG_2061_NgoVuTienMinh_13082015105513.xlsx', 1),
(42, 2212, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 03:56:30', '', '', 1),
(43, 2212, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 03:57:20', '', '', 1),
(44, 2212, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 03:57:48', '', '', 1),
(45, 2212, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2015-08-13 05:09:04', '', '', 1),
(46, 2099, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đỗ &nbsp;Tuyên</p>\n', '2015-08-13 08:07:51', '', '', 1),
(47, 2212, 1, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng Ngô Vũ Tiến Minh một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Đội Cấn, Quận Ba Đình, HNquangsan90@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-08-13 09:14:09', '', '', 1),
(48, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 09:19:07', '', 'BG_2066_MrsAn_13082015161903.xlsx', 1),
(49, 2099, 1, 'Báo giá', '<p>Dear anh/chị:Đỗ Tuyên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 09:21:59', '', 'BG_2067_DoTuyen_13082015162155.xlsx', 1),
(50, 2099, 1, 'Hợp đồng', '<p>Dear anh/chị:Đỗ Tuyên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4bizqlsx.lifetek.vn/backend/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-13 09:25:07', '', 'HD_1951_DoTuyen_13082015162503.xlsx', 1),
(51, 2095, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 02:49:20', '', '', 1),
(52, 2095, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 03:20:34', '', '', 1),
(53, 2208, 1, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng Vũ Đức Duy một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> 32 Hoàng Hoa Thámquangsan90@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-08-14 04:46:44', '', '', 1),
(54, 2095, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 07:38:26', '', '', 1),
(55, 2095, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng.Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-08-14 08:45:09', '', '', 1),
(56, 2216, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;luu luu &nbsp;thanh thanh</p>\n', '2015-08-17 10:20:22', 'Gửi lại', '', 0),
(57, 2208, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Đức Duy</p>\n', '2015-08-18 03:25:09', '', '', 1),
(58, 2208, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Đức Duy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-20 07:22:19', '', 'BG_2097_VuDucDuy_20082015142214.xlsx', 1),
(59, 2221, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hoàng &nbsp;Tuấn</p>\n', '2015-08-21 07:44:24', 'Gửi lại', '', 0),
(60, 2242, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Bin</p>\n', '2015-08-28 03:14:37', 'Gửi lại', '', 0),
(61, 2208, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Thị Hiên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-28 09:55:41', '', 'BG_2138_VuThiHien_28082015165537.xlsx', 1),
(62, 2208, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Thị Hiên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-29 05:20:32', '', 'BG_2140_VuThiHien_29082015122027.xlsx', 1),
(63, 2208, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Thị Hiên</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-08-29 05:20:54', '', 'BG_2140_VuThiHien_29082015122048.xlsx', 1),
(64, 2244, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đỗ Vũ &nbsp;Hà Vy</p>\n', '2015-09-07 05:04:55', '', '', 1),
(65, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 03:21:49', '', 'BG_2162_MrsAn_08092015102144.xlsx', 1),
(66, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 03:22:22', '', 'BG_2162_MrsAn_08092015102218.xlsx', 1),
(67, 2244, 1, 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 03:24:48', '', 'BG_2163_DoVuHaVy_08092015102445.xlsx', 1),
(68, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 07:47:34', '', 'BG_2166_MrsAn_08092015144729.xlsx', 1),
(69, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 08:08:12', '', 'BG_2167_MrsAn_08092015150809.xlsx', 1),
(70, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:00:55', '', 'BG_2168_MrsAn_08092015160051.xlsx', 1),
(71, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:05:55', '', 'bangbaogia.xlsx', 1),
(72, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:08:27', '', 'bangbaogia.xlsx', 1),
(73, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:11:26', '', 'bangbaogia.xlsx', 1),
(74, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:12:10', '', 'BG_2168_MrsAn_08092015161207.xlsx', 1),
(75, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:12:28', '', 'BG_2168_MrsAn_08092015161224.xlsx', 1),
(76, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :32 Hoàng Hoa Thám</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-09-08 09:17:39', '', 'BG_2168_MrsAn_08092015161735.xlsx', 1),
(77, 2245, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Tiến &nbsp;Minh</p>\n', '2015-09-11 08:03:12', 'Gửi lại', '', 0),
(78, 2246, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;sdfasd &nbsp;asdfasdf</p>\n', '2015-09-24 04:15:54', 'Gửi lại', '', 0),
(79, 2250, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;121212 &nbsp;12121212</p>\n', '2015-10-06 08:45:36', 'Gửi lại', '', 0),
(80, 2252, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Linh &nbsp;Bi</p>\n', '2015-10-06 09:58:10', '', '', 1),
(81, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 09:51:40', '', 'BG_2243_12121212121212_15102015165138.xlsx', 0),
(82, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 09:52:42', '', 'BG_2243_12121212121212_15102015165239.xlsx', 0),
(83, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 09:53:29', '', 'BG_2243_12121212121212_15102015165327.xlsx', 0),
(84, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 09:54:01', '', 'BG_2243_12121212121212_15102015165359.xlsx', 0),
(85, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 09:57:58', '', 'BG_2243_12121212121212_15102015165755.xlsx', 0),
(86, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :sanvv@lifetek.vn</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 14:42:52', '', 'BG_2243_12121212121212_15102015214248.xlsx', 0),
(87, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 14:45:14', '', 'BG_2243_12121212121212_15102015214508.xlsx', 1),
(88, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 14:46:17', '', 'BG_2243_12121212121212_15102015214612.xlsx', 1),
(89, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-15 14:46:42', '', 'BG_2243_12121212121212_15102015214636.xlsx', 1);
INSERT INTO `lifetek_mail_history` (`id`, `person_id`, `employee_id`, `title`, `content`, `time`, `note`, `file`, `status`) VALUES
(90, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 10:59:59', '', 'BG_2277_MrsAn_23102015175955.xlsx', 1),
(91, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 11:24:13', '', 'BG_2277_MrsAn_23102015182409.xlsx', 1),
(92, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 11:27:53', '', 'BG_2277_MrsAn_23102015182750.xlsx', 1),
(93, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-23 11:29:20', '', 'BG_2277_MrsAn_23102015182916.xlsx', 1),
(94, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 04:15:16', '', 'BG_2279_12121212121212_24102015111512.xlsx', 1),
(95, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 05:13:42', '', 'BG_2279_12121212121212_24102015121338.doc', 1),
(96, 2250, 1, 'Báo giá', '<p>Dear anh/chị:121212 12121212</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 05:14:51', '', 'BG_2279_12121212121212_24102015121447.doc', 1),
(97, 2258, 1, 'Báo giá', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 05:30:26', '', 'BG_2280_TrinhThiLan_24102015123023.doc', 1),
(98, 2258, 1, 'Báo giá', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 06:14:52', '', 'BG_2280_TrinhThiLan_24102015131448.doc', 1),
(99, 2258, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trịnh Thị &nbsp;Lan</p>\n', '2015-10-24 07:07:36', '', '', 1),
(100, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 08:07:09', '', 'BG_2279_VuVanSan_24102015150706.doc', 1),
(101, 2258, 1, 'Báo giá', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 08:13:40', '', 'BG_2280_TrinhThiLan_24102015151337.doc', 1),
(104, 2250, 1, 'Hợp đồng', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 02:58:44', '', 'HD_2279_VuVanSan_25102015095841.doc', 1),
(103, 2258, 1, 'Hợp đồng', '<p>Dear anh/chị:Trịnh Thị Lan</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-24 08:31:12', '', 'HD_2281_TrinhThiLan_24102015153107.xlsx', 1),
(105, 2250, 1, 'Hợp đồng', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:00:29', '', 'HD_2279_VuVanSan_25102015100026.doc', 1),
(106, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:38:51', '', 'BG_2279_VuVanSan_25102015103847.doc', 1),
(107, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:41:27', '', 'BG_2279_VuVanSan_25102015104123.doc', 1),
(108, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:42:24', '', 'BG_2279_VuVanSan_25102015104221.doc', 1),
(109, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:45:28', '', 'BG_2279_VuVanSan_25102015104525.doc', 1),
(110, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:58:03', '', 'BG_2279_VuVanSan_25102015105758.doc', 1),
(111, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:59:07', '', 'BG_2279_VuVanSan_25102015105903.doc', 1),
(112, 2250, 1, 'Báo giá', '<p>Dear anh/chị:Vũ Văn San</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-25 03:59:50', '', 'BG_2279_VuVanSan_25102015105947.doc', 1),
(113, 2244, 1, 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 02:13:47', '', 'BG_2289_DoVuHaVy_26102015091343.doc', 1),
(114, 2259, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;! &nbsp;1111</p>\n', '2015-10-26 02:15:41', 'Gửi lại', '', 0),
(115, 2260, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;a &nbsp;a</p>\n', '2015-10-26 02:15:47', '', '', 1),
(116, 2244, 1, 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 02:20:29', '', 'BG_2289_DoVuHaVy_26102015092026.doc', 1),
(117, 2244, 1, 'Báo giá', '<p>Dear anh/chị:Đỗ Vũ Hà Vy</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 02:20:52', '', 'BG_2289_DoVuHaVy_26102015092049.doc', 1),
(118, 2261, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;a &nbsp;a</p>\n', '2015-10-26 02:38:14', 'Gửi lại', '', 0),
(119, 2184, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-10-26 07:09:58', '', '', 1),
(120, 2183, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-10-26 07:10:02', '', '', 1),
(121, 2182, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-10-26 07:10:05', '', '', 1),
(122, 2265, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;đỗ &nbsp;huệ</p>\n', '2015-10-26 09:49:56', 'Gửi lại', '', 0),
(123, 2266, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hue &nbsp;huệ</p>\n', '2015-10-26 09:59:51', 'Gửi lại', '', 0),
(124, 2183, 1, 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-26 15:19:13', '', 'HD_2275_MrsAn_26102015221909.doc', 1),
(125, 2260, 1, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng aadddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaassssssssss một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộiquangsan90@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-10-27 01:57:20', '', '', 1),
(126, 2183, 1, 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 02:58:47', '', 'HD_2304_MrsAn_27102015095843.doc', 1),
(127, 2174, 1, 'Báo giá', '<p>Dear anh/chị:Nguyễn Hải Dương</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 03:10:24', '', 'BG_2283_NguyenHaiDuong_27102015101020.doc', 1),
(128, 2174, 1, 'Báo giá', '<p>Dear anh/chị:Nguyễn Hải Dương</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 03:11:26', '', 'BG_2283_NguyenHaiDuong_27102015101123.doc', 1),
(129, 2174, 1, 'Báo giá', '<p>Dear anh/chị:Nguyễn Hải Dương</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 03:46:48', '', 'BG_2283_NguyenHaiDuong_27102015104644.doc', 1),
(130, 2277, 1, 'Báo giá', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 03:57:33', '', 'BG_2307_dohue_27102015105729.doc', 1),
(131, 2277, 1, 'Báo giá', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 04:07:23', '', 'BG_2307_dohue_27102015110719.doc', 1),
(132, 2277, 1, 'Hợp đồng', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 04:15:23', '', 'HD_2309_dohue_27102015111519.doc', 1),
(133, 2277, 1, 'Báo giá', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 04:21:28', '', 'BG_2310_dohue_27102015112124.doc', 1),
(134, 2277, 1, 'Hợp đồng', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 04:23:17', '', 'HD_2309_dohue_27102015112314.doc', 1),
(135, 2277, 1, 'Hợp đồng', '<p>Dear anh/chị:do hue</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-10-27 04:23:37', '', 'HD_2309_dohue_27102015112334.doc', 1),
(136, 2277, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;do &nbsp;hue</p>\n', '2015-10-27 04:51:52', '', '', 1),
(137, 2289, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;đinh văn &nbsp;xinh</p>\n', '2015-11-11 04:48:36', '', '', 1),
(138, 2290, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn hải &nbsp;yến</p>\n', '2015-11-11 04:48:41', '', '', 1),
(139, 2290, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn hải &nbsp;yến</p>\n', '2015-11-11 05:10:08', '', '', 1),
(140, 2299, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;minh &nbsp;nguyệt</p>\n', '2015-11-11 07:53:04', 'Gửi lại', '', 0),
(141, 2300, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ĐINH  VĂN &nbsp;MẠNH</p>\n', '2015-11-11 07:53:13', '', '', 1),
(142, 2300, 1, 'Hợp đồng', '<p>Dear anh/chị:ĐINH  VĂN MẠNH</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-11 07:54:35', '', 'HD_2562_DINHVANMANH_11112015145431.doc', 1),
(143, 2301, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn công &nbsp;hoan</p>\n', '2015-11-11 09:12:49', 'Gửi lại', '', 0),
(144, 2302, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;đinh văn &nbsp;hạnh</p>\n', '2015-11-11 09:12:58', 'Gửi lại', '', 0),
(145, 2303, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;văn anh &nbsp;anh</p>\n', '2015-11-11 09:13:11', 'Gửi lại', '', 0),
(146, 2306, 1, 'Báo giá', '<p>Dear anh/chị:NGUYỄN VĂN BÌNH</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 04:07:48', '', 'BG_2576_NGUYENVANBINH_12112015110743.doc', 1),
(147, 2306, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;NGUYỄN VĂN &nbsp;BÌNH</p>\n', '2015-11-12 04:09:44', '', '', 1),
(148, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 04:39:15', '', '', 1),
(149, 2183, 1, 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 04:50:45', '', 'HD_2577_MrsAn_12112015115040.doc', 1);
INSERT INTO `lifetek_mail_history` (`id`, `person_id`, `employee_id`, `title`, `content`, `time`, `note`, `file`, `status`) VALUES
(150, 2134, 1, 'Hợp đồng', '<p>Dear anh/chị:Trương Tuấn Anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 04:55:58', '', 'HD_2582_TruongTuanAnh_12112015115554.doc', 1),
(151, 2310, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyên &nbsp;định</p>\n', '2015-11-12 07:04:25', 'Gửi lại', '', 0),
(152, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 08:16:35', '', 'BG_2626_BuivanDung_12112015151630.doc', 1),
(153, 2307, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 08:30:57', '', '', 1),
(154, 2247, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi văn &nbsp;Dũng</p>\n', '2015-11-12 08:50:54', '', '', 1),
(155, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 08:57:26', '', 'BG_2631_MrsAn_12112015155721.doc', 1),
(156, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 08:59:03', '', 'BG_2631_MrsAn_12112015155900.doc', 1),
(157, 2183, 1, 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 09:00:18', '', 'HD_2631_MrsAn_12112015160015.doc', 1),
(158, 2306, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 09:31:23', '', '', 0),
(159, 2306, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 09:42:16', '', '', 0),
(160, 2307, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 09:46:51', '', '', 0),
(161, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 09:52:30', '', '', 0),
(162, 2307, 1, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng nguyễn thị định một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộihienvutk9@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-11-12 10:05:39', '', '', 0),
(163, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 10:07:48', '', '', 0),
(164, 2307, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-12 10:08:56', '', '', 0),
(165, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-12 10:10:59', '', '', 0),
(166, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-12 10:11:52', '', 'BG_2631_MrsAn_12112015171149.doc', 0),
(167, 2318, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hoàng &nbsp;minh</p>\n', '2015-11-13 02:25:22', 'Gửi lại', '', 0),
(168, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:26:19', '', 'BG_2631_MrsAn_13112015092614.doc', 0),
(169, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:26:40', '', 'BG_2631_MrsAn_13112015092634.doc', 0),
(170, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:37:36', '', 'BG_2631_MrsAn_13112015093730.doc', 0),
(171, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:45:26', '', 'BG_2631_MrsAn_13112015094520.doc', 0),
(172, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:55:55', '', 'BG_2631_MrsAn_13112015095547.doc', 1),
(173, 2124, 1, 'Báo giá', '<p>Dear anh/chị:Phùng Đức Hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:57:12', '', 'BG_2627_PhungDucHanh_13112015095705.doc', 1),
(174, 2306, 1, 'Báo giá', '<p>Dear anh/chị:NGUYỄN VĂN BÌNH</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 02:59:12', '', 'BG_2576_NGUYENVANBINH_13112015095906.doc', 0),
(175, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:02:32', '', 'BG_2626_BuivanDung_13112015100226.doc', 0),
(176, 2124, 1, 'Báo giá', '<p>Dear anh/chị:Phùng Đức Hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:03:35', '', 'BG_2627_PhungDucHanh_13112015100329.doc', 0),
(177, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:04:40', '', 'BG_2602_MrsAn_13112015100434.doc', 0),
(178, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:05:20', '', 'BG_2434_MrsAn_13112015100513.doc', 1),
(179, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:06:13', '', 'BG_2631_MrsAn_13112015100606.doc', 1),
(180, 2124, 1, 'Báo giá', '<p>Dear anh/chị:Phùng Đức Hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:06:55', '', 'BG_2627_PhungDucHanh_13112015100648.doc', 1),
(181, 2318, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hoàng &nbsp;minh</p>\n', '2015-11-13 03:07:43', 'Gửi lại', '', 1),
(182, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:09:08', '', 'BG_2638_BuivanDung_13112015100901.doc', 1),
(183, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:10:39', '', 'BG_2638_BuivanDung_13112015101032.doc', 1),
(184, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :quangsan90@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:12:44', '', 'BG_2638_BuivanDung_13112015101236.doc', 1),
(185, 2306, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-13 03:37:51', '', '', 0),
(186, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :hienvutk9@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:42:19', '', 'BG_2638_BuivanDung_13112015104214.doc', 0),
(187, 2247, 1, 'Báo giá', '<p>Dear anh/chị:Bùi văn Dũng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-13 03:43:27', '', 'BG_2638_BuivanDung_13112015104321.doc', 0),
(188, 2318, 1, 'CHÚC MỪNG SINH NHẬT CÔNG TY 15 NĂM ', '<p>ch&uacute;c mừng sinh nhật c&ocirc;ng ty tr&ograve;n 15 tuổi .ch&uacute;c c&ocirc;ng ty l&agrave;m nhiều c&oacute; nhiều thắng lợi</p>\n', '2015-11-13 04:25:21', '', '', 0),
(189, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-13 04:51:15', '', '', 0),
(190, 2322, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vu thi &nbsp;ly</p>\n', '2015-11-13 08:54:04', 'Gửi lại', '', 0),
(191, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :hienvutk9@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-14 01:28:46', '', 'BG_2639_MrsAn_14112015082842.doc', 0),
(192, 2318, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 01:33:06', '', '', 0),
(193, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :hienvutk9@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-14 01:34:06', '', 'BG_2639_MrsAn_14112015083403.doc', 0),
(194, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-14 04:45:31', '', '', 0),
(195, 2277, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 04:46:00', '', '', 0),
(196, 2307, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 04:47:43', '', '', 0),
(197, 2318, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-14 04:57:23', '', '', 0),
(198, 2300, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ĐINH  VĂN &nbsp;MẠNH</p>\n', '2015-11-15 12:44:48', '', '', 0),
(199, 2290, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-15 12:45:32', '', '', 1),
(200, 2324, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Khách hàng &nbsp;mới</p>\n', '2015-11-16 07:39:34', 'Gửi lại', '', 0),
(201, 2328, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hà Hải &nbsp;Bình</p>\n', '2015-11-17 07:11:16', 'Gửi lại', '', 0),
(202, 2330, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đinh Thị &nbsp;Hạnh</p>\n', '2015-11-18 07:27:50', 'Gửi lại', '', 0),
(203, 2247, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-18 08:24:47', '', '', 1),
(204, 2307, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-18 08:25:51', '', '', 1),
(205, 2247, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-11-18 08:25:55', '', '', 1),
(206, 2307, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn thị &nbsp;định</p>\n', '2015-11-18 08:26:52', '', '', 1),
(207, 2330, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đinh Thị &nbsp;Hạnh</p>\n', '2015-11-18 08:30:43', 'Gửi lại', '', 1),
(208, 2183, 1, 'Hợp đồng', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-19 03:34:37', '', 'HD_2654_MrsAn_19112015103432.doc', 1),
(209, 2130, 1, 'Hợp đồng', '<p>Dear anh/chị:Mrs Hằng</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-20 02:24:05', '', 'HD_2567_MrsHang_20112015092401.doc', 1),
(210, 2302, 1, 'Hợp đồng', '<p>Dear anh/chị:đinh văn hạnh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-20 02:28:48', '', 'HD_2564_dinhvanhanh_20112015092846.doc', 0),
(211, 2333, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đinh Mạnh &nbsp;Sơn</p>\n', '2015-11-20 04:37:11', 'Gửi lại', '', 0),
(212, 2339, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Dũng</p>\n', '2015-11-20 08:47:08', 'Gửi lại', '', 0),
(213, 2341, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huệ &nbsp;Đỗ</p>\n', '2015-11-26 04:50:14', '', '', 1),
(214, 2342, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;hung</p>\n', '2015-11-27 06:50:30', 'Gửi lại', '', 0),
(215, 2252, 1, 'Báo giá', '<p>Dear anh/chị:Linh Bi</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-30 04:54:56', '', 'BG_2686_LinhBi_30112015115451.doc', 1),
(216, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-11-30 04:56:41', '', 'BG_2315_MrsAn_30112015115637.doc', 1),
(217, 2345, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vuong &nbsp;Duy</p>\n', '2015-12-07 04:54:59', 'Gửi lại', '', 0),
(218, 2245, 1, 'Hợp đồng', '<p>Dear anh/chị:Tiến Minh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4bizkdtm.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-07 06:38:37', '', 'HD_2226_TienMinh_07122015133834.doc', 0),
(219, 2346, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;tran &nbsp;anh</p>\n', '2015-12-08 02:07:25', 'Gửi lại', '', 0),
(220, 2347, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vuong &nbsp;duy</p>\n', '2015-12-08 02:16:50', 'Gửi lại', '', 0),
(221, 2348, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;abc &nbsp;abc</p>\n', '2015-12-08 02:28:56', 'Gửi lại', '', 0),
(222, 2341, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-08 08:36:52', '', '', 1),
(223, 2350, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vuong &nbsp;Duy</p>\n', '2015-12-09 01:57:51', 'Gửi lại', '', 0),
(224, 2095, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đỗ &nbsp;Hà Vy</p>\n', '2015-12-11 01:48:30', '', '', 1),
(225, 2341, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huệ &nbsp;Đỗ</p>\n', '2015-12-14 09:04:05', '', '', 1),
(226, 2341, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huệ &nbsp;Đỗ</p>\n', '2015-12-14 09:04:35', '', '', 1),
(227, 2134, 1, 'Báo giá', '<p>Dear anh/chị:Trương Tuấn Anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-14 09:05:39', '', 'BG_2704_TruongTuanAnh_14122015160534.doc', 1),
(228, 2355, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Thành Nam</p>\n', '2015-12-15 02:27:48', '', '', 1),
(229, 2356, 1, 'Hợp đồng', '<p>Dear anh/chị:Vũ Hải Yến</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 03:14:14', '', 'HD_2733_VuHaiYen_15122015101409.doc', 1),
(230, 2356, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Hải &nbsp;Yến</p>\n', '2015-12-15 03:14:30', '', '', 1),
(231, 2346, 1, 'Hợp đồng', '<p>Dear anh/chị:tran anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 03:25:18', '', 'HD_2737_trananh_15122015102515.doc', 0);
INSERT INTO `lifetek_mail_history` (`id`, `person_id`, `employee_id`, `title`, `content`, `time`, `note`, `file`, `status`) VALUES
(232, 2346, 1, 'Hợp đồng', '<p>Dear anh/chị:tran anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 03:25:48', '', 'HD_2737_trananh_15122015102545.doc', 0),
(233, 2134, 1, 'Hợp đồng', '<p>Dear anh/chị:Trương Tuấn Anh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :vuly.lifetek@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 03:25:58', '', 'HD_2712_TruongTuanAnh_15122015102553.doc', 1),
(234, 2362, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Lâm &nbsp;Thanh Phong</p>\n', '2015-12-15 04:55:24', '', '', 1),
(235, 2366, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Huyền &nbsp;Thanh</p>\n', '2015-12-15 06:27:38', '', '', 1),
(236, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 07:13:18', '', 'BG_2744_MrsAn_15122015141312.doc', 1),
(237, 2183, 1, 'Báo giá', '<p>Dear anh/chị:Mrs An</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng báo giá chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-15 07:14:11', '', 'BG_2758_MrsAn_15122015141406.doc', 1),
(238, 2367, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;do &nbsp;lan</p>\n', '2015-12-15 08:09:22', '', '', 1),
(239, 2368, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Khổng &nbsp;Tử</p>\n', '2015-12-15 09:38:37', 'Gửi lại', '', 0),
(240, 2249, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Hiền</p>\n', '2015-12-16 01:42:48', 'Gửi lại', '', 0),
(241, 2369, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Tuấn &nbsp;Du</p>\n', '2015-12-16 02:01:09', '', '', 1),
(242, 2370, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Kim &nbsp;Tuấn</p>\n', '2015-12-16 02:24:18', '', '', 1),
(243, 2371, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ha &nbsp;Ha</p>\n', '2015-12-16 02:24:20', 'Gửi lại', '', 0),
(244, 2372, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ANH &nbsp;A</p>\n', '2015-12-16 03:22:34', 'Gửi lại', '', 0),
(245, 2373, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;dj &nbsp;TOM</p>\n', '2015-12-16 03:34:58', 'Gửi lại', '', 0),
(246, 2369, 1, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng Tuấn Du một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộidungchip88@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-12-16 04:58:42', '', '', 1),
(247, 2378, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;jk &nbsp;hung</p>\n', '2015-12-17 01:35:10', 'Gửi lại', '', 0),
(248, 2379, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;B</p>\n', '2015-12-17 06:41:23', 'Gửi lại', '', 0),
(249, 2370, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-19 03:24:58', '', '', 1),
(250, 2389, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hj &nbsp;ha</p>\n', '2015-12-21 02:16:02', 'Gửi lại', '', 0),
(251, 2389, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-21 06:48:16', '', '', 1),
(252, 2370, 1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', '2015-12-21 06:51:25', '', '', 1),
(253, 2389, 1, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng hj ha một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;<b>Lê </b> <b>Lê </b>&nbsp; nh&acirc;n vi&ecirc;n&nbsp;<b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nộidungchip88@gmail.com 04 6265 00655 www.lifetek.com.vnn</p>\n', '2015-12-21 06:52:43', '', '', 1),
(254, 2389, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hj &nbsp;ha</p>\n', '2015-12-21 07:10:07', 'Gửi lại', '', 1),
(255, 2393, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh Long &nbsp;Châu</p>\n', '2015-12-21 09:26:23', '', '', 1),
(256, 2401, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hoàng &nbsp;Hải</p>\n', '2015-12-22 05:01:15', 'Gửi lại', '', 0),
(257, 2402, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hải &nbsp;Đăng</p>\n', '2015-12-22 06:47:38', 'Gửi lại', '', 0),
(258, 2403, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh &nbsp;Hà</p>\n', '2015-12-22 06:47:46', 'Gửi lại', '', 0),
(259, 2404, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Thanh</p>\n', '2015-12-22 07:02:49', 'Gửi lại', '', 0),
(260, 2405, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh &nbsp;Thanh</p>\n', '2015-12-22 07:52:28', 'Gửi lại', '', 0),
(261, 2405, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thanh &nbsp;Thanh</p>\n', '2015-12-22 07:52:30', 'Gửi lại', '', 0),
(262, 2406, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Lan</p>\n', '2015-12-22 07:52:32', 'Gửi lại', '', 0),
(263, 2406, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ &nbsp;Lan</p>\n', '2015-12-22 07:52:33', 'Gửi lại', '', 0),
(264, 2407, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;Hiên</p>\n', '2015-12-22 07:52:49', 'Gửi lại', '', 0),
(265, 2408, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Min</p>\n', '2015-12-22 07:53:08', 'Gửi lại', '', 0),
(266, 2410, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thùy &nbsp;Lâm</p>\n', '2015-12-23 02:13:31', 'Gửi lại', '', 0),
(267, 2411, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;iv &nbsp;anh</p>\n', '2015-12-23 02:15:52', 'Gửi lại', '', 0),
(268, 2414, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vân quân &nbsp;h</p>\n', '2015-12-23 05:01:58', 'Gửi lại', '', 0),
(269, 2414, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;vân quân &nbsp;h</p>\n', '2015-12-23 05:01:59', 'Gửi lại', '', 0),
(270, 2415, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;mị &nbsp;mị</p>\n', '2015-12-23 08:59:11', 'Gửi lại', '', 0),
(271, 2416, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;xxxx &nbsp;xxxxxxxxxxxx</p>\n', '2015-12-23 08:59:19', 'Gửi lại', '', 0),
(272, 2417, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;ha &nbsp;lan</p>\n', '2015-12-23 11:43:08', 'Gửi lại', '', 0),
(273, 2421, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;LY LY &nbsp;A</p>\n', '2015-12-24 04:23:02', 'Gửi lại', '', 0),
(274, 2422, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;life &nbsp;store</p>\n', '2015-12-24 04:23:09', 'Gửi lại', '', 0),
(275, 2421, 1, 'Hợp đồng', '<p>Dear anh/chị:LY LY A</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2015-12-25 01:56:53', '', 'HD_3175_LYLYA_25122015085649.doc', 0),
(276, 2424, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Nam</p>\n', '2015-12-25 04:41:39', 'Gửi lại', '', 0),
(277, 2425, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;xxxxxxx &nbsp;xxx</p>\n', '2015-12-25 04:49:13', 'Gửi lại', '', 0),
(278, 2426, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;view &nbsp;Sys</p>\n', '2015-12-25 05:14:33', 'Gửi lại', '', 0),
(279, 2427, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hue &nbsp;hue</p>\n', '2015-12-25 06:39:19', 'Gửi lại', '', 0),
(280, 2429, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Chị &nbsp;Anh</p>\n', '2015-12-28 03:30:56', 'Gửi lại', '', 0),
(281, 2430, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nguyễn &nbsp;duyên</p>\n', '2015-12-28 07:04:29', 'Gửi lại', '', 0),
(282, 2431, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngọc Ngọc &nbsp;Mai</p>\n', '2015-12-28 08:16:10', 'Gửi lại', '', 0),
(283, 2431, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngọc Ngọc &nbsp;Mai</p>\n', '2015-12-28 08:16:11', 'Gửi lại', '', 0),
(284, 2432, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vu &nbsp;Ly</p>\n', '2015-12-28 09:12:45', 'Gửi lại', '', 0),
(285, 2433, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hoàng Nhan &nbsp;Cô nương</p>\n', '2015-12-28 09:12:57', 'Gửi lại', '', 0),
(286, 2434, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Anh &nbsp;Lý</p>\n', '2015-12-28 09:13:12', 'Gửi lại', '', 0),
(287, 2435, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vu &nbsp;Vu</p>\n', '2015-12-28 09:13:28', 'Gửi lại', '', 0),
(288, 2436, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Nết</p>\n', '2015-12-28 09:13:47', 'Gửi lại', '', 0),
(289, 2440, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thép &nbsp;Thép</p>\n', '2015-12-31 02:54:49', 'Gửi lại', '', 0),
(290, 2113, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Oanh</p>\n', '2016-01-01 08:05:01', '', '', 1),
(291, 2114, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thanh &nbsp;Bình</p>\n', '2016-01-01 08:05:04', '', '', 1),
(292, 2115, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Oanh</p>\n', '2016-01-01 08:05:09', '', '', 1),
(293, 2116, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Đại</p>\n', '2016-01-01 08:05:13', '', '', 1),
(294, 2117, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:05:17', '', '', 1),
(295, 2118, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Ngọc</p>\n', '2016-01-01 08:05:21', '', '', 1),
(296, 2119, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị Thanh &nbsp;Hồng</p>\n', '2016-01-01 08:05:25', '', '', 1),
(297, 2120, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Chính</p>\n', '2016-01-01 08:05:29', '', '', 1),
(298, 2121, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hiền</p>\n', '2016-01-01 08:05:33', '', '', 1),
(299, 2122, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Nga</p>\n', '2016-01-01 08:05:37', '', '', 1),
(300, 2123, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Khoa</p>\n', '2016-01-01 08:05:42', '', '', 1),
(301, 2124, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Phùng Đức &nbsp;Hạnh</p>\n', '2016-01-01 08:05:47', '', '', 1),
(302, 2125, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Dương</p>\n', '2016-01-01 08:05:51', '', '', 1),
(303, 2126, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Thái</p>\n', '2016-01-01 08:05:55', '', '', 1),
(304, 2127, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Nhung</p>\n', '2016-01-01 08:06:03', '', '', 1),
(305, 2128, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Phạm Việt &nbsp;Hùng</p>\n', '2016-01-01 08:06:07', '', '', 1),
(306, 2129, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Lâm</p>\n', '2016-01-01 08:06:11', '', '', 1),
(307, 2130, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hằng</p>\n', '2016-01-01 08:06:15', '', '', 1),
(308, 2131, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Nguyệt</p>\n', '2016-01-01 08:06:19', '', '', 1),
(309, 2132, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đặng Đình &nbsp;Tâm</p>\n', '2016-01-01 08:06:23', '', '', 1),
(310, 2133, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Vinh</p>\n', '2016-01-01 08:06:28', '', '', 1),
(311, 2134, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trương Tuấn &nbsp;Anh</p>\n', '2016-01-01 08:06:32', '', '', 1),
(312, 2135, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Thu &nbsp;Phương</p>\n', '2016-01-01 08:06:38', '', '', 1),
(313, 2136, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Minh &nbsp;Hiếu</p>\n', '2016-01-01 08:06:41', '', '', 1),
(314, 2137, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Thanh &nbsp;Xuân</p>\n', '2016-01-01 08:06:45', '', '', 1),
(315, 2138, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Trang</p>\n', '2016-01-01 08:06:49', '', '', 1),
(316, 2139, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trần Tử &nbsp;Bình </p>\n', '2016-01-01 08:06:54', '', '', 1),
(317, 2140, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thế Thị &nbsp;Mỹ</p>\n', '2016-01-01 08:06:58', '', '', 1),
(318, 2141, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hồng</p>\n', '2016-01-01 08:07:01', '', '', 1),
(319, 2142, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trần Thị  &nbsp;Ngoan</p>\n', '2016-01-01 08:07:05', '', '', 1),
(320, 2143, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Oanh</p>\n', '2016-01-01 08:07:09', '', '', 1),
(321, 2144, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hà</p>\n', '2016-01-01 08:07:13', '', '', 1),
(322, 2145, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Mai &nbsp;Hồng</p>\n', '2016-01-01 08:07:16', '', '', 1),
(323, 2146, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hoàng</p>\n', '2016-01-01 08:07:21', '', '', 1),
(324, 2147, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Ngô Vũ Tiến &nbsp;Minh</p>\n', '2016-01-01 08:08:33', '', '', 1),
(325, 2148, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Kiều</p>\n', '2016-01-01 08:08:35', 'Gửi lại', '', 0),
(326, 2149, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Chung</p>\n', '2016-01-01 08:08:42', '', '', 1),
(327, 2150, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Quang &nbsp;Tuấn</p>\n', '2016-01-01 08:08:45', '', '', 1),
(328, 2151, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Trần &nbsp;Lâm</p>\n', '2016-01-01 08:08:49', '', '', 1),
(329, 2152, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn thị &nbsp;Thuận</p>\n', '2016-01-01 08:08:53', '', '', 1),
(330, 2153, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Bảo &nbsp;Oanh</p>\n', '2016-01-01 08:08:57', '', '', 1),
(331, 2154, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Duy</p>\n', '2016-01-01 08:09:01', '', '', 1),
(332, 2155, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Ban</p>\n', '2016-01-01 08:09:04', '', '', 1),
(333, 2156, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hương</p>\n', '2016-01-01 08:09:08', '', '', 1),
(334, 2157, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Xuân &nbsp;Khiêm</p>\n', '2016-01-01 08:09:12', '', '', 1),
(335, 2158, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hoài</p>\n', '2016-01-01 08:09:14', 'Gửi lại', '', 0),
(336, 2159, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Dũng</p>\n', '2016-01-01 08:09:22', 'Gửi lại', '', 0),
(337, 2160, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Nga</p>\n', '2016-01-01 08:09:33', '', '', 1),
(338, 2161, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Lâm</p>\n', '2016-01-01 08:09:37', '', '', 1),
(339, 2162, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Lợi</p>\n', '2016-01-01 08:09:41', '', '', 1),
(340, 2163, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:09:45', '', '', 1),
(341, 2163, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:09:48', '', '', 1),
(342, 2164, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hằng</p>\n', '2016-01-01 08:09:49', '', '', 1),
(343, 2164, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hằng</p>\n', '2016-01-01 08:09:52', '', '', 1),
(344, 2165, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:09:54', '', '', 1),
(345, 2165, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:09:56', '', '', 1),
(346, 2166, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hữu &nbsp;Yên</p>\n', '2016-01-01 08:09:58', '', '', 1),
(347, 2166, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hữu &nbsp;Yên</p>\n', '2016-01-01 08:10:00', '', '', 1),
(348, 2167, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr  &nbsp;Hào</p>\n', '2016-01-01 08:10:03', '', '', 1),
(349, 2167, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr  &nbsp;Hào</p>\n', '2016-01-01 08:10:04', '', '', 1),
(350, 2168, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Đức &nbsp;Cần</p>\n', '2016-01-01 08:10:07', '', '', 1),
(351, 2168, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Đức &nbsp;Cần</p>\n', '2016-01-01 08:10:09', '', '', 1),
(352, 2169, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Trung</p>\n', '2016-01-01 08:10:12', '', '', 1),
(353, 2169, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Trung</p>\n', '2016-01-01 08:10:13', '', '', 1),
(354, 2170, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hải</p>\n', '2016-01-01 08:10:15', '', '', 1),
(355, 2170, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hải</p>\n', '2016-01-01 08:10:18', '', '', 1),
(356, 2171, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Viết &nbsp;Đại</p>\n', '2016-01-01 08:10:19', '', '', 1),
(357, 2171, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Viết &nbsp;Đại</p>\n', '2016-01-01 08:10:22', '', '', 1),
(358, 2172, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Anh</p>\n', '2016-01-01 08:10:24', '', '', 1),
(359, 2172, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Anh</p>\n', '2016-01-01 08:10:26', '', '', 1),
(360, 2173, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Hải</p>\n', '2016-01-01 08:10:27', '', '', 1),
(361, 2173, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs  &nbsp;Hải</p>\n', '2016-01-01 08:10:30', '', '', 1),
(362, 2174, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hải &nbsp;Dương</p>\n', '2016-01-01 08:10:32', '', '', 1),
(363, 2174, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Hải &nbsp;Dương</p>\n', '2016-01-01 08:10:34', '', '', 1),
(364, 2175, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đặng Đình &nbsp;Tâm</p>\n', '2016-01-01 08:10:34', 'Gửi lại', '', 0),
(365, 2175, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đặng Đình &nbsp;Tâm</p>\n', '2016-01-01 08:10:37', 'Gửi lại', '', 0),
(366, 2176, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Khăc &nbsp;Hiếu</p>\n', '2016-01-01 08:10:50', '', '', 1),
(367, 2177, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Chí &nbsp;Phú</p>\n', '2016-01-01 08:10:54', '', '', 1),
(368, 2178, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Thùy</p>\n', '2016-01-01 08:10:58', '', '', 1),
(369, 2179, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Đoàn Quang &nbsp;Tiến</p>\n', '2016-01-01 08:11:02', '', '', 1),
(370, 2180, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuân</p>\n', '2016-01-01 08:11:06', '', '', 1),
(371, 2181, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Quang &nbsp;Hùng</p>\n', '2016-01-01 08:11:11', '', '', 1),
(372, 2182, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hà</p>\n', '2016-01-01 08:11:15', '', '', 1),
(373, 2183, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;An</p>\n', '2016-01-01 08:11:19', '', '', 1),
(374, 2184, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hương</p>\n', '2016-01-01 08:11:23', '', '', 1),
(375, 2185, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Quyết</p>\n', '2016-01-01 08:11:26', 'Gửi lại', '', 0),
(376, 2186, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Chỉnh</p>\n', '2016-01-01 08:11:43', '', '', 1),
(377, 2187, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Cường</p>\n', '2016-01-01 08:11:46', '', '', 1),
(378, 2188, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Giang</p>\n', '2016-01-01 08:11:50', '', '', 1),
(379, 2189, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Hồng</p>\n', '2016-01-01 08:11:54', '', '', 1),
(380, 2190, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Lụa</p>\n', '2016-01-01 08:11:59', '', '', 1),
(381, 2191, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Linh</p>\n', '2016-01-01 08:12:01', 'Gửi lại', '', 0),
(382, 2192, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Hiếu</p>\n', '2016-01-01 08:12:20', '', '', 1),
(383, 2193, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Vũ Hữu &nbsp;Âu</p>\n', '2016-01-01 08:12:25', '', '', 1),
(384, 2194, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Thái Thu &nbsp;Huyền</p>\n', '2016-01-01 08:12:29', '', '', 1),
(385, 2195, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mrs &nbsp;Bến </p>\n', '2016-01-01 08:12:33', '', '', 1),
(386, 2196, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Thiện</p>\n', '2016-01-01 08:12:37', '', '', 1),
(387, 2196, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Thiện</p>\n', '2016-01-01 08:12:38', '', '', 1),
(388, 2197, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:12:42', '', '', 1),
(389, 2197, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Mr &nbsp;Tuấn</p>\n', '2016-01-01 08:12:43', '', '', 1),
(390, 2253, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị &nbsp;Hường</p>\n', '2016-01-01 08:12:44', 'Gửi lại', '', 0),
(391, 2253, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị &nbsp;Hường</p>\n', '2016-01-01 08:12:45', 'Gửi lại', '', 0),
(392, 2254, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn Thị &nbsp;Phương Thảo</p>\n', '2016-01-01 08:13:07', '', '', 1),
(393, 2454, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nhan &nbsp;duc</p>\n', '2016-01-04 04:58:46', 'Gửi lại', '', 0),
(394, 2455, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;5</p>\n', '2016-01-04 04:58:52', 'Gửi lại', '', 0),
(395, 2459, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Nguyễn &nbsp;Sắt</p>\n', '2016-01-04 08:06:21', 'Gửi lại', '', 0),
(396, 2460, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Cụ &nbsp;Vít</p>\n', '2016-01-05 04:32:51', 'Gửi lại', '', 0),
(397, 2461, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;nhan &nbsp;duc</p>\n', '2016-01-05 06:52:36', 'Gửi lại', '', 0),
(398, 2462, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;hoa &nbsp;thuan</p>\n', '2016-01-05 06:52:44', 'Gửi lại', '', 0),
(399, 2463, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;chung &nbsp;thanh</p>\n', '2016-01-05 10:40:22', 'Gửi lại', '', 0),
(400, 2464, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;1</p>\n', '2016-01-05 10:40:34', 'Gửi lại', '', 0),
(401, 2465, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;2</p>\n', '2016-01-06 02:00:27', 'Gửi lại', '', 0),
(402, 2463, 1, 'Hợp đồng', '<p>Dear anh/chị:chung thanh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 04:06:27', '', 'HD_3273_chungthanh_06012016110625.doc', 0),
(403, 2460, 1, 'Hợp đồng', '<p>Dear anh/chị:Cụ Vít</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 04:20:00', '', 'HD_3275_CuVit_06012016111957.doc', 0),
(404, 2463, 1, 'Hợp đồng', '<p>Dear anh/chị:chung thanh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 04:20:15', '', 'HD_3273_chungthanh_06012016112013.doc', 0),
(405, 2464, 1, 'Hợp đồng', '<p>Dear anh/chị:Hiên 1</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 04:34:37', '', 'HD_3266_Hien1_06012016113434.doc', 0),
(406, 2463, 1, 'Hợp đồng', '<p>Dear anh/chị:chung thanh</p><p>Dựa vào nhu cầu của Quý khách hàng.</p><p><b>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</b> xin phép được gửi tới Quý khách hàng hợp đồng chi tiết như sau:</p><p>Xin vui lòng xem ở file đính kèm</p><p><i>Để biết thêm thông tin, vui lòng liên hệ Dịch vụ khách hàng theo số điện thoại: 0436413130 - 0164939929688</i></p><i>(Xin vui lòng không phản hồi email này. Đây là email được tự động gửi đi từ hệ thống của chúng tôi).</i><p>-----</p><p><i>Thanks and Regards!</i></p><p><i>Lê  Nam Admin</i></p><p>Mobile: 01677932954</p><p>Email: lifeone@gmail.com</p>------------------------------------------------------------------------<img src=''http://4biz.lifetek.vn/images/logoreport/11.png''><p style=''text-transform: uppercase;''>Công ty TNHH công nghệ điện tử - phần mềm và viễn thông LifeTek</p><p>Rep Off  :Số 8/8 Ngõ 379 Đội Cấn - Ba Đình - Hà Nội</p><p>Email    :dungchip88@gmail.com</p><p>Tel      :0436413130 - 0164939929688 | Fax: 04 6265 00655</p><p>Web      :www.lifetek.com.vnn</p>', '2016-01-06 04:34:37', '', 'HD_3273_chungthanh_06012016113434.doc', 0),
(407, 2466, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;binh &nbsp;binh</p>\n', '2016-01-06 06:58:31', 'Gửi lại', '', 0),
(408, 2468, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Hiên &nbsp;6</p>\n', '2016-01-06 07:08:30', 'Gửi lại', '', 0),
(409, 2469, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;anh &nbsp;Anh</p>\n', '2016-01-06 07:08:40', 'Gửi lại', '', 0),
(410, 2470, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Xuân &nbsp;Dần</p>\n', '2016-01-06 08:25:52', 'Gửi lại', '', 0),
(411, 2471, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;xuan &nbsp;thu</p>\n', '2016-01-06 08:26:07', 'Gửi lại', '', 0),
(412, 2472, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Thị &nbsp;Mơ</p>\n', '2016-01-06 08:26:25', 'Gửi lại', '', 0),
(413, 2475, 1, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;Bùi Văn &nbsp;Dũng</p>\n', '2016-01-07 03:22:06', 'Gửi lại', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mail_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_mail_template` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mail_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `lifetek_mail_template`
--

INSERT INTO `lifetek_mail_template` (`mail_id`, `mail_title`, `mail_content`, `deleted`) VALUES
(1, 'Chúc mừng năm mới KH!', '<p>Ch&uacute;c năm mới an khanh, thịnh vượng. Một năm dồi d&agrave;o sức khỏe!</p>\n', 0),
(2, 'Chúc mừng sinh nhật', '<p>Ch&uacute;c mừng sinh nhật&nbsp;__FIRST_NAME__ &nbsp;__LAST_NAME__</p>\n', 0),
(3, 'Chúc Mừng Năm Mới', '<p>Dear anh, chị!</p>\n\n<p>Năm mới ch&uacute;c kh&aacute;ch h&agrave;ng __FIRST_NAME__ __LAST_NAME__ một năm mới an khang thịnh vượng!</p>\n\n<p>T&ecirc;n em l&agrave;&nbsp;__FIRST_NAME_EMPLOYEE__ __FIRST_NAME_EMPLOYEE__&nbsp; nh&acirc;n vi&ecirc;n&nbsp;__NAME_COMPANY__ __ADDRESS_COMPANY____EMAIL_COMPANY__ __FAX_COMPANY__ __WEBSITE_COMPANY__</p>\n', 0),
(4, 'ghfggfhf hgfhgf', '<p>Cộng haofdgs ds gdgd fh</p>\n', 1),
(5, 'CHÚC MỪNG SINH NHẬT CÔNG TY 15 NĂM ', '<p>ch&uacute;c mừng sinh nhật c&ocirc;ng ty tr&ograve;n 15 tuổi .ch&uacute;c c&ocirc;ng ty l&agrave;m nhiều c&oacute; nhiều thắng lợi</p>\n', 1),
(6, 'Chúc mừng', '<p>Ch&uacute;c mừng kh&aacute;ch h&agrave;ng đ&atilde; tr&uacute;ng thưởng&nbsp;__FIRST_NAME__&nbsp;__LAST_NAME__ đ&atilde; tr&uacute;ng tuyển 01 chiếc điện thoại &nbsp;di động nokia 1601</p>\n\n<p>T&ecirc;n t&ocirc;i l&agrave; :&nbsp;FIRST_NAME_EMPLOYEE__&nbsp;LAST_NAME_EMPLOYEE__&nbsp;__PHONE_NUMBER_EMPLOYEE_&nbsp;</p>\n\n<p>C&ocirc;ng ty:&nbsp;__NAME_COMPANY__&nbsp;__ADDRESS_COMPANY__&nbsp;__WEBSITE_COMPANY__ k&iacute;nh mời Anh/Chị đến nhận phần thưởng tại ....</p>\n\n<p>tr&acirc;n trọng k&iacute;nh b&aacute;o!</p>\n', 1),
(7, 'a', '<p>a</p>\n', 1),
(8, 'a', '<p>&acirc;</p>\n', 1),
(9, 'a', '<p>a</p>\n', 1),
(10, 's', '<p>s</p>\n', 1),
(11, 's', '<p>s</p>\n', 1),
(12, 'j', '<p>jk</p>\n', 1),
(13, 'ngsjknsg', '<p>kdsgfmkdfg</p>\n', 1),
(14, 'hgf', '<p>gfhgfhgfgfhfgh</p>\n', 1),
(15, 'ygkjyuk', '<p>hkhjkh</p>\n', 1),
(16, 'ygkghkh', '<p>jkhkj</p>\n', 1),
(17, 'h', '<p>h</p>\n', 1),
(18, 'ad', '<p>ass</p>\n', 1),
(19, 'cccccccccccccccc', '<p>faafafafaafafafa</p>\n', 1),
(20, 'asss', '<p>s</p>\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_maloai_hopdong`
--

CREATE TABLE IF NOT EXISTS `lifetek_maloai_hopdong` (
  `id_ma_hopdong` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `ten_maloai_hopdong` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mota_loaihopdong` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_ma_hopdong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_message`
--

CREATE TABLE IF NOT EXISTS `lifetek_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cus` int(11) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `content_message` text NOT NULL,
  `equals` int(11) NOT NULL,
  `msgid` int(11) NOT NULL,
  `date_send` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_method_cost`
--

CREATE TABLE IF NOT EXISTS `lifetek_method_cost` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  ` name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_modules`
--

CREATE TABLE IF NOT EXISTS `lifetek_modules` (
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

--
-- Dumping data for table `lifetek_modules`
--

INSERT INTO `lifetek_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`, `active_home`, `active_header`, `active_category`) VALUES
('module_abouts', 'module_abouts_desc', 210, 'abouts', 0, 0, 0),
('module_account_plan', 'module_account_plan_desc', 800, 'account_plan', 0, 0, 1),
('module_account_type', 'module_account_type_desc', 225, 'account_type', 0, 0, 0),
('module_accountings', 'module_accountings_desc', 10, 'accountings', 1, 1, 0),
('module_admin_agent', 'module_admin_agent_desc', 2363, 'admin_agent', 0, 0, 0),
('module_affiliates', 'module_affiliates_desc', 30, 'affiliates', 0, 0, 1),
('module_assets', 'module_assets_desc', 100, 'assets', 0, 0, 1),
('module_bangcap', 'module_bangcap_desc', 210, 'bangcap', 0, 0, 0),
('module_bill_cost', 'module_bill_cost_desc', 266, 'bill_cost', 0, 0, 0),
('module_categories', 'module_categories_desc', 70, 'categories', 0, 0, 1),
('module_category_processes', 'module_category_processes_desc', 16, 'category_processes', 0, 0, 0),
('module_chungtus', 'module_chungtus_desc', 120, 'chungtus', 0, 0, 1),
('module_cities', 'module_cities_desc', 140, 'cities', 0, 0, 1),
('module_city_desc', 'module_city', 227, 'city', 0, 0, 0),
('module_citys', 'module_citys_desc', 228, 'citys', 0, 0, 0),
('module_congcus', 'module_congcus_desc', 110, 'congcus', 0, 0, 1),
('module_contact_admin', 'module_contact_admin_desc', 567, 'contact_admin', 0, 0, 0),
('module_contractcustomer', 'module_contractcustomer_desc', 110, 'contractcustomer', 0, 0, 0),
('module_contractcustomer_type', 'module_contractcustomer_type_desc', 110, 'contractcustomer_type', 0, 0, 0),
('module_contracts', 'module_contracts_desc', 226, 'contracts', 0, 0, 0),
('module_costs', 'module_costs_desc', 115, 'costs', 0, 0, 0),
('module_create_invetorys', 'module_create_invetorys_desc', 201, 'create_invetorys', 0, 0, 0),
('module_currencys', 'module_currencys_desc', 111, 'currencys', 0, 0, 1),
('module_customer_type', 'module_customer_type_desc', 180, 'customer_type', 0, 0, 0),
('module_customers', 'module_customers_desc', 2, 'customers', 1, 1, 0),
('module_department_desc', 'module_department', 20, 'department', 0, 0, 1),
('module_dttcs', 'module_dttcs_desc', 216, 'dttcs', 0, 0, 0),
('module_education', 'module_education_desc', 210, 'education', 0, 0, 0),
('module_employees', 'module_employees_desc', 6, 'employees', 1, 1, 0),
('module_file', 'module_file_desc', 229, 'file', 0, 0, 0),
('module_giftcards', 'module_giftcards_desc', 130, 'giftcards', 0, 0, 1),
('module_hrm', 'module_hrm_desc', 160, 'hrm', 0, 0, 0),
('module_imports', 'module_imports_desc', 14, 'imports', 0, 1, 0),
('module_introductions', 'module_introductions_desc', 555, 'introductions', 0, 0, 0),
('module_item_kits', 'module_item_kits_desc', 302, 'item_kits', 0, 1, 0),
('module_item2s', 'module_item2s_desc', 201, 'item2s', 0, 0, 0),
('module_item4s', 'module_item4s_desc', 100, 'item4s', 0, 0, 0),
('module_items', 'module_items_desc', 5, 'items', 1, 1, 0),
('module_jobs', 'module_jobs_desc', 7, 'jobs', 0, 1, 0),
('module_jobs_employee', 'module_jobs_employee_desc', 180, 'jobs_employee', 0, 0, 0),
('module_jobs_project', 'module_jobs_project_desc', 180, 'jobs_project', 0, 0, 0),
('module_jobs_report', 'module_jobs_report_desc', 180, 'jobs_report', 0, 0, 0),
('module_kh', 'module_kh_desc', 100, 'kh', 0, 0, 0),
('module_language', 'module_language_desc', 50, 'language', 0, 0, 1),
('module_news', 'module_news_desc', 888, 'news', 0, 0, 0),
('module_packs', 'module_packs_desc', 88, 'packs', 0, 0, 1),
('module_positions_desc', 'module_positions', 40, 'positions', 0, 0, 1),
('module_profit', 'module_profit_desc', 9, 'profit', 0, 0, 1),
('module_profit1111', 'module_profit1111_desc', 170, 'profix', 0, 0, 0),
('module_quotes_contract', 'module_quotes_contract_desc', 11, 'quotes_contract', 0, 0, 0),
('module_receivings', 'module_receivings_desc', 4, 'receivings', 1, 1, 0),
('module_regions', 'module_regions_desc', 11, 'regions', 0, 0, 1),
('module_reports', 'module_reports_desc', 11, 'reports', 1, 1, 0),
('module_resellers', 'module_resellers_desc', 333, 'resellers', 0, 0, 0),
('module_salaryconfig', 'module_salaryconfig_desc', 110, 'salaryconfig', 0, 0, 0),
('module_salaryoption', 'module_salaryoption_desc', 110, 'salaryoption', 0, 0, 0),
('module_sales', 'module_sales_desc', 1, 'sales', 1, 1, 0),
('module_salestraining', 'module_salestraining_desc', 1, 'salestraining', 0, 0, 0),
('module_services', 'module_services_desc', 6, 'services', 0, 1, 0),
('module_setting', 'module_setting_desc', 12, 'setting', 0, 1, 0),
('module_shop_guide', 'module_shop_guide_desc', 2244, 'shop_guide', 0, 0, 0),
('module_slider', 'module_slider_desc', 110, 'slider', 0, 0, 0),
('module_solutions', 'module_solutions_desc', 444, 'solutions', 0, 0, 0),
('module_suppliers', 'module_suppliers_desc', 3, 'suppliers', 0, 1, 0),
('module_support', 'module_support_desc', 13, 'support', 1, 1, 0),
('module_timekeeping', 'module_timekeeping_desc', 8, 'timekeeping', 1, 1, 0),
('module_tinhoc', 'module_tinhoc_desc', 60, 'tinhoc', 0, 0, 1),
('module_tkdus', 'module_tkdus_desc', 217, 'tkdus', 0, 0, 0),
('module_units', 'module_units_desc', 80, 'units', 0, 0, 1),
('module_vendors', 'module_vendors_desc', 1123, 'vendors', 0, 0, 0),
('module_visa', 'module_visa_desc', 210, 'visa', 0, 0, 0),
('module_web', 'module_web_desc', 9, 'web', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_modules_actions`
--

CREATE TABLE IF NOT EXISTS `lifetek_modules_actions` (
  `action_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `action_name_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`action_id`,`module_id`),
  KEY `phppos_modules_actions_ibfk_1` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lifetek_modules_actions`
--

INSERT INTO `lifetek_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES
('add_update', 'abouts', 'module_action_add_update', 210),
('add_update', 'account_plan', 'module_action_add_update', 800),
('add_update', 'account_type', 'module_action_add_update', 225),
('add_update', 'accountings', 'module_action_add_update', 1000),
('add_update', 'admin_agent', 'module_action_add_update', 2363),
('add_update', 'affiliates', 'module_action_add_update', 1000),
('add_update', 'assets', 'module_action_add_update', 210),
('add_update', 'bangcap', 'module_action_add_update', 210),
('add_update', 'bill_cost', 'module_action_add_update', 266),
('add_update', 'categories', 'module_action_add_update', 30),
('add_update', 'category_processes', 'module_action_add_update', 16),
('add_update', 'chungtus', 'module_action_add_update', 210),
('add_update', 'cities', 'module_action_add_update', 210),
('add_update', 'city', 'module_action_add_update', 111),
('add_update', 'citys', 'module_action_add_update', 123),
('add_update', 'congcus', 'module_action_add_update', 210),
('add_update', 'contractcustomer', 'module_action_add_update', 110),
('add_update', 'contractcustomer_type', 'module_action_add_update', 110),
('add_update', 'contracts', 'module_action_add_update', 1114),
('add_update', 'costs', 'module_action_add_update', 170),
('add_update', 'create_invetorys', 'module_action_add_update', 201),
('add_update', 'currencys', 'module_action_add_update', 111),
('add_update', 'customer_type', 'module_action_add_update', 180),
('add_update', 'customers', 'module_action_add_update', 1),
('add_update', 'department', 'module_action_add_update', 1000),
('add_update', 'dttcs', 'module_action_add_update', 170),
('add_update', 'education', 'module_action_add_update', 210),
('add_update', 'employees', 'module_action_add_update', 130),
('add_update', 'file', 'module_action_add_update', 300000),
('add_update', 'giftcards', 'module_action_add_update', 210),
('add_update', 'hrm', 'module_action_add_update', 160),
('add_update', 'imports', 'module_action_add_update', 14),
('add_update', 'introductions', 'module_action_add_update', 555),
('add_update', 'item_kits', 'module_action_add_update', 70),
('add_update', 'item2s', 'module_action_add_update', 1),
('add_update', 'item4s', 'module_action_add_update', 100),
('add_update', 'items', 'module_action_add_update', 40),
('add_update', 'jobs', 'module_action_add_update', 150),
('add_update', 'jobs_employee', 'module_action_add_update', 210),
('add_update', 'jobs_project', 'module_action_add_update', 210),
('add_update', 'jobs_report', 'module_action_add_update', 1000),
('add_update', 'kh', 'module_action_add_update', 12),
('add_update', 'language', 'module_action_add_update', 210),
('add_update', 'news', 'module_action_add_update', 888),
('add_update', 'packs', 'module_action_add_update', 820),
('add_update', 'positions', 'module_action_add_update', 1000),
('add_update', 'profit', 'module_action_add_update', 170),
('add_update', 'profix', 'module_action_add_update', 60),
('add_update', 'quotes_contract', 'module_action_add_update', 11),
('add_update', 'receivings', 'module_action_add_update', 1000),
('add_update', 'regions', 'module_action_add_update', 100),
('add_update', 'reports', 'module_action_add_update', 30),
('add_update', 'resellers', 'module_action_add_update', 333),
('add_update', 'salaryconfig', 'module_action_add_update', 210),
('add_update', 'salaryoption', 'module_action_add_update', 110),
('add_update', 'services', 'module_action_add_update', 5),
('add_update', 'setting', 'module_action_add_update', 210),
('add_update', 'shop_guide', 'module_action_add_update', 2244),
('add_update', 'slider', 'module_action_add_update', 1),
('add_update', 'solutions', 'module_action_add_update', 444),
('add_update', 'suppliers', 'module_action_add_update', 100),
('add_update', 'support', 'module_action_add_update', 13),
('add_update', 'timekeeping', 'module_action_add_update', 110),
('add_update', 'tinhoc', 'module_action_add_update', 210),
('add_update', 'tkdus', 'module_action_add_update', 170),
('add_update', 'units', 'module_action_add_update', 1000),
('add_update', 'vendors', 'module_action_add_update', 1123),
('add_update', 'visa', 'module_action_add_update', 1000),
('add_update', 'web', 'module_action_add_update', 170),
('add_update_export_store', 'create_invetorys', 'module_action_add_update_export_store', 201),
('confirm_export_store', 'create_invetorys', 'module_action_confirm_export_store', 201),
('confirm_receiving', 'receivings', 'module_action_confirm_receiving', 201),
('delete', 'abouts', 'module_action_delete', 210),
('delete', 'account_plan', 'module_action_delete', 800),
('delete', 'account_type', 'module_action_delete', 230),
('delete', 'accountings', 'module_action_delete', 30),
('delete', 'admin_agent', 'module_action_delete', 2363),
('delete', 'affiliates', 'module_action_delete', 1000),
('delete', 'assets', 'module_action_delete', 210),
('delete', 'bangcap', 'module_action_delete', 30),
('delete', 'bill_cost', 'module_action_delete', 266),
('delete', 'categories', 'module_action_delete', 30),
('delete', 'category_processes', 'module_action_delete', 16),
('delete', 'chungtus', 'module_action_delete', 210),
('delete', 'cities', 'module_action_delete', 1000),
('delete', 'city', 'module_action_delete', 11111),
('delete', 'congcus', 'module_action_delete', 210),
('delete', 'contact_admin', 'module_action_delete', 567),
('delete', 'contractcustomer', 'module_action_delete', 110),
('delete', 'contractcustomer_type', 'module_action_add_update', 110),
('delete', 'contracts', 'module_action_delete', 30),
('delete', 'costs', 'module_action_delete', 20),
('delete', 'create_invetorys', 'module_action_delete', 201),
('delete', 'currencys', 'module_action_delete', 111),
('delete', 'customer_type', 'module_action_delete', 180),
('delete', 'customers', 'module_action_delete', 20),
('delete', 'department', 'module_action_delete', 1000),
('delete', 'dttcs', 'module_action_delete', 1000),
('delete', 'education', 'module_action_delete', 30),
('delete', 'employees', 'module_action_delete', 140),
('delete', 'file', 'module_action_delete', 300000),
('delete', 'giftcards', 'module_action_delete', 1000),
('delete', 'introductions', 'module_action_delete', 555),
('delete', 'item_kits', 'module_action_delete', 80),
('delete', 'items', 'module_action_delete', 50),
('delete', 'jobs', 'module_action_delete', 30),
('delete', 'jobs_employee', 'module_action_delete', 210),
('delete', 'jobs_project', 'module_action_delete', 110),
('delete', 'jobs_report', 'module_action_delete', 210),
('delete', 'language', 'module_action_delete', 20),
('delete', 'news', 'module_action_delete', 888),
('delete', 'packs', 'module_action_delete', 800),
('delete', 'positions', 'module_action_delete', 1000),
('delete', 'profit', 'module_action_delete', 170),
('delete', 'quotes_contract', 'module_action_delete', 11),
('delete', 'receivings', 'module_action_delete', 1800),
('delete', 'regions', 'module_action_delete', 200),
('delete', 'resellers', 'module_action_delete', 333),
('delete', 'salaryconfig', 'module_action_delete', 210),
('delete', 'salaryoption', 'module_action_delete', 110),
('delete', 'services', 'module_action_delete', 5),
('delete', 'slider', 'module_action_delete', 30),
('delete', 'solutions', 'module_action_delete', 444),
('delete', 'suppliers', 'module_action_delete', 110),
('delete', 'support', 'module_action_delete', 13),
('delete', 'timekeeping', 'module_action_delete', 110),
('delete', 'tinhoc', 'module_action_delete', 1000),
('delete', 'tkdus', 'module_action_delete', 210),
('delete', 'units', 'module_action_delete', 30),
('delete', 'vendors', 'module_action_delete', 1123),
('delete', 'visa', 'module_action_delete', 210),
('delete_receiving', 'receivings', 'module_action_delete_receiving', 201),
('delete_sale', 'sales', 'module_action_delete_sale', 3214),
('edit_sale_price', 'sales', 'module_edit_sale_price', 170),
('edit_salestraining_price', 'salestraining', 'module_edit_salestraining_price', 1),
('estimate', 'item_kits', 'module_action_estimate', 50),
('manage_production', 'item_kits', 'module_action_manage_production', 52),
('orders', 'sales', 'module_action_orders', 56),
('paybook', 'sales', 'module_action_paybook', 55),
('price_alert', 'sales', 'module_action_price_alert', 54),
('print_order', 'sales', 'module_action_print_order', 2234),
('production', 'item_kits', 'module_action_production', 51),
('receiving_order', 'receivings', 'module_action_receiving_order', 201),
('sales_order', 'sales', 'module_action_sales_order', 2900),
('search', 'abouts', 'module_action_search_abouts', 210),
('search', 'account_plan', 'module_action_search_account_plan', 800),
('search', 'account_type', 'module_action_search_account_type', 305),
('search', 'accountings', 'module_action_search_accountings', 25),
('search', 'admin_agent', 'module_action_search', 2363),
('search', 'affiliates', 'module_action_search_affiliates', 1000),
('search', 'assets', 'module_action_search_assets', 60),
('search', 'bangcap', 'module_action_search_bangcap', 60),
('search', 'bill_cost', 'module_action_search_bill_cost', 266),
('search', 'categories', 'module_action_search_categories', 25),
('search', 'category_processes', 'module_action_search_category_processes', 16),
('search', 'chungtus', 'module_action_search_chungtus', 1000),
('search', 'cities', 'module_action_search_cities', 25),
('search', 'city', 'module_action_search_city', 11111),
('search', 'congcus', 'module_action_search_congcus', 60),
('search', 'contact_admin', 'module_action_search_contact_admin', 567),
('search', 'contractcustomer', 'module_action_search_contractcustomer', 110),
('search', 'contractcustomer_type', 'module_action_search_contractcustomer_type', 110),
('search', 'contracts', 'module_action_search_contracts', 25),
('search', 'costs', 'module_action_search_costs', 60),
('search', 'currencys', 'module_action_search_currencys', 111),
('search', 'customer_type', 'module_action_search_customer_type', 180),
('search', 'customers', 'module_action_search_customers', 30),
('search', 'department', 'module_action_search_department', 1000),
('search', 'dttcs', 'module_action_search_dttcs', 60),
('search', 'education', 'module_action_search_education', 60),
('search', 'employees', 'module_action_search_employees', 150),
('search', 'file', 'module_action_search_file', 300000),
('search', 'giftcards', 'module_action_search_giftcards', 210),
('search', 'introductions', 'module_action_search', 555),
('search', 'item_kits', 'module_action_search_item_kits', 90),
('search', 'items', 'module_action_search_items', 60),
('search', 'jobs', 'module_action_search_jobs', 25),
('search', 'jobs_employee', 'module_action_search_jobs_employee', 1000),
('search', 'jobs_project', 'module_action_search_jobs_project', 1000),
('search', 'jobs_report', 'module_action_search_jobs_report', 1000),
('search', 'language', 'module_action_search_language', 25),
('search', 'news', 'module_action_search', 888),
('search', 'packs', 'module_action_search_packs', 810),
('search', 'positions', 'module_action_search_positions', 1000),
('search', 'profit', 'module_action_search_profit', 170),
('search', 'quotes_contract', 'module_action_search', 11),
('search', 'regions', 'module_action_search_regions', 200),
('search', 'resellers', 'module_action_search', 333),
('search', 'salaryconfig', 'module_action_search_salaryconfig', 210),
('search', 'salaryoption', 'module_action_search_salaryoption', 1000),
('search', 'services', 'module_action_search_services', 5),
('search', 'solutions', 'module_action_search', 444),
('search', 'suppliers', 'module_action_search_suppliers', 120),
('search', 'support', 'module_action_search', 13),
('search', 'tinhoc', 'module_action_search_tinhoc', 25),
('search', 'tkdus', 'module_action_search_tkdus', 60),
('search', 'units', 'module_action_search_units', 60),
('search', 'vendors', 'module_action_search_vendors', 1123),
('search', 'visa', 'module_action_search_visa', 11111),
('see_cost_price', 'items', 'module_see_cost_price', 61),
('technical', 'items', 'module_action_add_update', 99),
('update_receiving', 'receivings', 'module_action_update_receiving', 201);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_money_birthdate`
--

CREATE TABLE IF NOT EXISTS `lifetek_money_birthdate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noidung` varchar(255) CHARACTER SET latin1 NOT NULL,
  `chiphi` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_banner`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(255) CHARACTER SET utf8 NOT NULL,
  `flash` text CHARACTER SET utf8 NOT NULL,
  `width` int(4) NOT NULL DEFAULT '200',
  `height` int(4) NOT NULL DEFAULT '200',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `positions` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_banner_positions`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_banner_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_bottom`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_bottom` (
  `content` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_categories`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sections` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_content`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_content` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_sections`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_mt_support`
--

CREATE TABLE IF NOT EXISTS `lifetek_mt_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `skype` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yahoo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `parts_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_news`
--

CREATE TABLE IF NOT EXISTS `lifetek_news` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `lifetek_news`
--

INSERT INTO `lifetek_news` (`id`, `title`, `en_title`, `description`, `en_description`, `full`, `en_full`, `images`, `source`, `date`, `url`) VALUES
(1, 'Du học Nhật Bản', '', 'Trào lưu học sinh, sinh viên du học Nhật Bản, lao động xuất khẩu', '<p>dess</p>\n', '<p>Nghề chăm s&oacute;c người bệnh hay c&ograve;n gọi l&agrave; osin bệnh viện từ l&acirc;u đ&atilde; trở th&agrave;nh một nghề tự ph&aacute;t được nhiều phụ nữ n&ocirc;ng th&ocirc;n ra th&agrave;nh phố lựa chọn. C&oacute; những l&agrave;ng, phụ nữ rủ nhau đi l&agrave;m nghề osin bệnh viện gần hết. Nghề tuy vất vả nhưng c&oacute; thể đưa lại cho họ thu nhập cao hơn việc trồng l&uacute;a hay đi l&agrave;m osin đơn thuần.</p>\n\n<p><strong>Osin được đi &quot;du lịch ch&acirc;u &Acirc;u&quot;</strong></p>\n\n<p>Chị Nguyễn Thị Ly (40 tuổi) cho biết: &ldquo;T&ocirc;i l&agrave;m nghề n&agrave;y được 5 năm nhưng rất nhiều lần được thu&ecirc; đi c&ugrave;ng bệnh nh&acirc;n đi sang nước ngo&agrave;i chữa bệnh. Số tiền được trả thường 15 triệu/th&aacute;ng, ăn uống được bao hết&rdquo;.</p>\n', '<p>full</p>\n', 'girl-xinh-ngo-thu-1.jpg', 'Theo Hiểu Khuê (Infonet)', '2015-12-03', 'du-hoc-nhat-ban'),
(20, 'Rộn ràng giáng sinh', 'R?n ràng giáng sinh', 'Rộn ràng giáng sinh', 'R?n ràng giáng sinh', 'Rộn ràng giáng sinh', 'R?n ràng giáng sinh', 'Desert.jpg', 'Rộn ràng giáng sinh', '2015-12-25', 'ron-rang-giang-sinh');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_nhomts_thietbi`
--

CREATE TABLE IF NOT EXISTS `lifetek_nhomts_thietbi` (
  `id_tstb` int(11) NOT NULL AUTO_INCREMENT,
  `name_tstb` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `desc_tstb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_tstb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_number_sms`
--

CREATE TABLE IF NOT EXISTS `lifetek_number_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_sms` int(11) NOT NULL,
  `quantity_sms` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_category`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(1000) NOT NULL,
  `longdesc` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `parentid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_colors`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_customer`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_customer` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_menu`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `page_uri` varchar(60) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `parentid` int(10) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_uri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_messages`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_order`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `delivery_date` datetime NOT NULL,
  `payment_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_order_item`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_order_item` (
  `order_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_page`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_parts`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_product`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_product` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_product_colors`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_product_colors` (
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`color_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_product_sizes`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_product_sizes` (
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`size_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_sizes`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_omc_subscribers`
--

CREATE TABLE IF NOT EXISTS `lifetek_omc_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_options`
--

CREATE TABLE IF NOT EXISTS `lifetek_options` (
  `id` int(11) NOT NULL,
  `ques_id` int(11) NOT NULL,
  `value` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_order_service`
--

CREATE TABLE IF NOT EXISTS `lifetek_order_service` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `lifetek_order_service`
--

INSERT INTO `lifetek_order_service` (`id`, `number`, `symbol`, `person_id`, `create_date`, `order_date`, `tax_percent`, `comment`, `delete`, `stt`) VALUES
(1, 8, 'Z8', 2255, '2015-11-12', '2015-11-12', 10, 'abc  2', 1, 0),
(2, 0, '', 2240, '2015-11-11', '2015-11-11', 0, 'munbxnzx', 1, 0),
(3, 0, '', 0, '1970-01-01', '1970-01-01', 0, '', 1, 0),
(4, 0, '', 0, '1970-01-01', '1970-01-01', 0, '', 1, 0),
(5, 123, 'as', 2288, '2015-10-26', '2015-10-26', 10, '', 1, 0),
(6, 3211, 'sss', 2287, '2015-10-27', '2015-11-24', 10, '', 1, 0),
(7, 5444, 'qq', 2222, '2015-11-10', '2015-11-10', 10, 'diễn giải', 1, 0),
(8, 111111, 'q', 2259, '2015-10-26', '2015-11-11', 10, 'bbbbbbbbbbbbbbbbbbbbbbbbb aaaaaaaaaaaaaaaaaaaaaaaaaaaa cccccccccccccccccccccccccccc', 1, 0),
(9, 1222, 'QA', 2286, '2015-10-26', '2015-11-26', 10, '', 1, 0),
(10, 14, 'HD', 2287, '2015-11-10', '2015-11-11', 10, 'vvvvc', 1, 0),
(11, 12, 'HD', 2286, '2015-10-26', '2015-11-04', 10, 'THÊM DIỄN GIẢI', 1, 0),
(12, 16, 'HF', 2240, '2015-10-26', '2015-11-10', 10, 'Diễn giải mới', 1, 0),
(13, 18, 'FH', 2293, '2015-11-11', '2015-11-11', 10, '  sssfdsffg', 1, 0),
(14, 12, 'HK', 2213, '2015-10-26', '2015-10-26', 10, ' adaddaaa', 1, 0),
(15, 2811, ' HT', 2240, '2015-11-28', '2015-11-28', 10, 'KKKKKKKKK', 1, 0),
(16, 88, 'HT', 2286, '2015-11-11', '2015-11-11', 10, 'HEHE', 1, 0),
(17, 15, 'HT', 2218, '2015-11-12', '2015-11-12', 10, 'thêm diễn giải\n', 1, 0),
(18, 14, 'HT', 2286, '2015-11-12', '2015-11-12', 10, '', 1, 0),
(19, 1234, 'HT', 2308, '2015-10-27', '2015-11-16', 10, ' ', 1, 0),
(20, 12, 'TT/14P', 2288, '2015-11-01', '2015-11-01', 10, 'Nhập mua tài sản cố định', 0, 0),
(21, 125236, 'HT', 2240, '2015-11-02', '2015-11-23', 10, '', 1, 0),
(22, 0, 'dungchip1', 2101, '2015-11-01', '2015-11-01', 12, 'xxxxxx', 1, 1),
(23, 1, '1', 2101, '2015-11-10', '2015-11-10', 1, '1', 1, 1),
(24, 134, '1', 2332, '2015-11-17', '2015-12-02', 1, '1', 0, 1),
(25, 5, '5', 2309, '2015-11-02', '2015-11-13', 5, '34', 0, 1),
(26, 0, 'klinh ', 2252, '2015-11-05', '2015-11-19', 0, 'linh bi', 1, 1),
(27, 13456, 'HTTT', 2252, '2015-11-27', '2015-11-27', 5, '', 0, 1),
(28, 123456, 'th', 2240, '2015-12-03', '1970-01-01', 0, '', 0, 1),
(29, 123, '', 2277, '2015-12-09', '2015-11-30', 0, '', 0, 1),
(30, 22, 'lan', 2277, '2015-12-14', '2015-12-10', 10, 'huệ lan hoa thắng quyết diệp chi tùng bà ông :)', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_packs`
--

CREATE TABLE IF NOT EXISTS `lifetek_packs` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_pack_items`
--

CREATE TABLE IF NOT EXISTS `lifetek_pack_items` (
  `pack_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double(20,2) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `product_as_item` double(20,2) NOT NULL,
  `quantity_inventory` double(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_parts`
--

CREATE TABLE IF NOT EXISTS `lifetek_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_people`
--

CREATE TABLE IF NOT EXISTS `lifetek_people` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2476 ;

--
-- Dumping data for table `lifetek_people`
--

INSERT INTO `lifetek_people` (`first_name`, `last_name`, `phone_number`, `phone`, `email`, `address_1`, `city`, `comments`, `person_id`, `birth_date`, `register_date`, `password`) VALUES
('Lê ', 'Nam Admin', '01677932954', '', 'lifeone@gmail.com', 'Ba Đình', '24', '', 1, '2013-06-01', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_permissions`
--

CREATE TABLE IF NOT EXISTS `lifetek_permissions` (
  `module_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lifetek_permissions`
--

INSERT INTO `lifetek_permissions` (`module_id`, `person_id`) VALUES
('account_plan', 1),
('account_type', 1),
('accountings', 1),
('admin_agent', 1),
('affiliates', 1),
('assets', 1),
('bangcap', 1),
('bill_cost', 1),
('categories', 1),
('category_processes', 1),
('chungtus', 1),
('cities', 1),
('city', 1),
('congcus', 1),
('contact_admin', 1),
('contractcustomer', 1),
('contractcustomer_type', 1),
('contracts', 1),
('costs', 1),
('create_invetorys', 1),
('currencys', 1),
('customer_type', 1),
('customers', 1),
('department', 1),
('dttcs', 1),
('education', 1),
('employees', 1),
('file', 1),
('giftcards', 1),
('hrm', 1),
('imports', 1),
('introductions', 1),
('item_kits', 1),
('items', 1),
('jobs', 1),
('jobs_employee', 1),
('jobs_project', 1),
('jobs_report', 1),
('language', 1),
('news', 1),
('packs', 1),
('positions', 1),
('profit', 1),
('quotes_contract', 1),
('receivings', 1),
('regions', 1),
('reports', 1),
('resellers', 1),
('salaryconfig', 1),
('salaryoption', 1),
('sales', 1),
('services', 1),
('setting', 1),
('shop_guide', 1),
('slider', 1),
('solutions', 1),
('suppliers', 1),
('support', 1),
('timekeeping', 1),
('tinhoc', 1),
('tkdus', 1),
('units', 1),
('vendors', 1),
('visa', 1),
('web', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_permissions_actions`
--

CREATE TABLE IF NOT EXISTS `lifetek_permissions_actions` (
  `module_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(11) NOT NULL,
  `action_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`,`action_id`),
  KEY `phppos_permissions_actions_ibfk_2` (`person_id`),
  KEY `phppos_permissions_actions_ibfk_3` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lifetek_permissions_actions`
--

INSERT INTO `lifetek_permissions_actions` (`module_id`, `person_id`, `action_id`) VALUES
('account_plan', 1, 'add_update'),
('account_plan', 1, 'delete'),
('account_plan', 1, 'search'),
('account_type', 1, 'add_update'),
('account_type', 1, 'delete'),
('account_type', 1, 'search'),
('accountings', 1, 'add_update'),
('accountings', 1, 'delete'),
('accountings', 1, 'search'),
('admin_agent', 1, 'add_update'),
('admin_agent', 1, 'delete'),
('admin_agent', 1, 'search'),
('affiliates', 1, 'add_update'),
('affiliates', 1, 'delete'),
('affiliates', 1, 'search'),
('assets', 1, 'add_update'),
('assets', 1, 'delete'),
('assets', 1, 'search'),
('bangcap', 1, 'add_update'),
('bangcap', 1, 'delete'),
('bangcap', 1, 'search'),
('bill_cost', 1, 'add_update'),
('bill_cost', 1, 'delete'),
('bill_cost', 1, 'search'),
('categories', 1, 'add_update'),
('categories', 1, 'delete'),
('categories', 1, 'search'),
('category_processes', 1, 'add_update'),
('category_processes', 1, 'delete'),
('category_processes', 1, 'search'),
('chungtus', 1, 'add_update'),
('chungtus', 1, 'delete'),
('chungtus', 1, 'search'),
('cities', 1, 'add_update'),
('cities', 1, 'delete'),
('cities', 1, 'search'),
('city', 1, 'add_update'),
('city', 1, 'delete'),
('city', 1, 'search'),
('congcus', 1, 'add_update'),
('congcus', 1, 'delete'),
('congcus', 1, 'search'),
('contact_admin', 1, 'delete'),
('contact_admin', 1, 'search'),
('contractcustomer', 1, 'add_update'),
('contractcustomer', 1, 'delete'),
('contractcustomer', 1, 'search'),
('contractcustomer_type', 1, 'add_update'),
('contractcustomer_type', 1, 'delete'),
('contractcustomer_type', 1, 'search'),
('contracts', 1, 'add_update'),
('contracts', 1, 'delete'),
('contracts', 1, 'search'),
('costs', 1, 'add_update'),
('costs', 1, 'delete'),
('costs', 1, 'search'),
('create_invetorys', 1, 'add_update'),
('create_invetorys', 1, 'add_update_export_store'),
('create_invetorys', 1, 'confirm_export_store'),
('create_invetorys', 1, 'delete'),
('currencys', 1, 'add_update'),
('currencys', 1, 'delete'),
('currencys', 1, 'search'),
('customer_type', 1, 'add_update'),
('customer_type', 1, 'delete'),
('customer_type', 1, 'search'),
('customers', 1, 'add_update'),
('customers', 1, 'delete'),
('customers', 1, 'search'),
('department', 1, 'add_update'),
('department', 1, 'delete'),
('department', 1, 'search'),
('dttcs', 1, 'add_update'),
('dttcs', 1, 'delete'),
('dttcs', 1, 'search'),
('education', 1, 'add_update'),
('education', 1, 'delete'),
('education', 1, 'search'),
('employees', 1, 'add_update'),
('employees', 1, 'delete'),
('employees', 1, 'search'),
('file', 1, 'add_update'),
('file', 1, 'delete'),
('file', 1, 'search'),
('giftcards', 1, 'add_update'),
('giftcards', 1, 'delete'),
('giftcards', 1, 'search'),
('hrm', 1, 'add_update'),
('imports', 1, 'add_update'),
('introductions', 1, 'add_update'),
('introductions', 1, 'delete'),
('introductions', 1, 'search'),
('item_kits', 1, 'add_update'),
('item_kits', 1, 'delete'),
('item_kits', 1, 'estimate'),
('item_kits', 1, 'manage_production'),
('item_kits', 1, 'production'),
('item_kits', 1, 'search'),
('items', 1, 'add_update'),
('items', 1, 'delete'),
('items', 1, 'search'),
('items', 1, 'see_cost_price'),
('items', 1, 'technical'),
('jobs', 1, 'add_update'),
('jobs', 1, 'delete'),
('jobs', 1, 'search'),
('jobs_employee', 1, 'add_update'),
('jobs_employee', 1, 'delete'),
('jobs_employee', 1, 'search'),
('jobs_project', 1, 'add_update'),
('jobs_project', 1, 'delete'),
('jobs_project', 1, 'search'),
('jobs_report', 1, 'add_update'),
('jobs_report', 1, 'delete'),
('jobs_report', 1, 'search'),
('language', 1, 'add_update'),
('language', 1, 'delete'),
('language', 1, 'search'),
('news', 1, 'add_update'),
('news', 1, 'delete'),
('news', 1, 'search'),
('packs', 1, 'add_update'),
('packs', 1, 'delete'),
('packs', 1, 'search'),
('positions', 1, 'add_update'),
('positions', 1, 'delete'),
('positions', 1, 'search'),
('profit', 1, 'add_update'),
('profit', 1, 'delete'),
('profit', 1, 'search'),
('quotes_contract', 1, 'add_update'),
('quotes_contract', 1, 'delete'),
('quotes_contract', 1, 'search'),
('receivings', 1, 'add_update'),
('receivings', 1, 'confirm_receiving'),
('receivings', 1, 'delete'),
('receivings', 1, 'delete_receiving'),
('receivings', 1, 'receiving_order'),
('receivings', 1, 'update_receiving'),
('regions', 1, 'add_update'),
('regions', 1, 'delete'),
('regions', 1, 'search'),
('reports', 1, 'add_update'),
('resellers', 1, 'add_update'),
('resellers', 1, 'delete'),
('resellers', 1, 'search'),
('salaryconfig', 1, 'add_update'),
('salaryconfig', 1, 'delete'),
('salaryconfig', 1, 'search'),
('salaryoption', 1, 'add_update'),
('salaryoption', 1, 'delete'),
('salaryoption', 1, 'search'),
('sales', 1, 'delete_sale'),
('sales', 1, 'edit_sale_price'),
('sales', 1, 'orders'),
('sales', 1, 'paybook'),
('sales', 1, 'price_alert'),
('sales', 1, 'print_order'),
('sales', 1, 'sales_order'),
('services', 1, 'add_update'),
('services', 1, 'delete'),
('services', 1, 'search'),
('setting', 1, 'add_update'),
('shop_guide', 1, 'add_update'),
('slider', 1, 'add_update'),
('slider', 1, 'delete'),
('solutions', 1, 'add_update'),
('solutions', 1, 'delete'),
('solutions', 1, 'search'),
('suppliers', 1, 'add_update'),
('suppliers', 1, 'delete'),
('suppliers', 1, 'search'),
('support', 1, 'add_update'),
('support', 1, 'delete'),
('support', 1, 'search'),
('timekeeping', 1, 'add_update'),
('timekeeping', 1, 'delete'),
('tinhoc', 1, 'add_update'),
('tinhoc', 1, 'delete'),
('tinhoc', 1, 'search'),
('tkdus', 1, 'add_update'),
('tkdus', 1, 'delete'),
('tkdus', 1, 'search'),
('units', 1, 'add_update'),
('units', 1, 'delete'),
('units', 1, 'search'),
('vendors', 1, 'add_update'),
('vendors', 1, 'delete'),
('vendors', 1, 'search'),
('visa', 1, 'add_update'),
('visa', 1, 'delete'),
('visa', 1, 'search'),
('web', 1, 'add_update');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_ppkh`
--

CREATE TABLE IF NOT EXISTS `lifetek_ppkh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_preferences`
--

CREATE TABLE IF NOT EXISTS `lifetek_preferences` (
  `name` varchar(254) NOT NULL,
  `value` text NOT NULL,
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_processes`
--

CREATE TABLE IF NOT EXISTS `lifetek_processes` (
  `id_processes` int(11) NOT NULL AUTO_INCREMENT,
  `name_processes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(2) DEFAULT '0',
  `cat_pro_id` int(11) NOT NULL,
  PRIMARY KEY (`id_processes`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_processes_design_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_processes_design_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_kit_id` int(11) NOT NULL,
  `id_design_template` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_confirm` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=496 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_processes_item_kit`
--

CREATE TABLE IF NOT EXISTS `lifetek_processes_item_kit` (
  `item_kit_id` int(11) NOT NULL,
  `id_processes` int(11) NOT NULL,
  `date_finish` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_production_flow_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_production_flow_template` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Luồng sản xuất mẫu' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_profit`
--

CREATE TABLE IF NOT EXISTS `lifetek_profit` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_profit_empl`
--

CREATE TABLE IF NOT EXISTS `lifetek_profit_empl` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(250) NOT NULL,
  `name_empl` varchar(200) NOT NULL,
  `day_hour` varchar(20) NOT NULL,
  `day_hour_number` int(4) DEFAULT NULL,
  `salary_empl` decimal(15,5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_profit_other`
--

CREATE TABLE IF NOT EXISTS `lifetek_profit_other` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(200) NOT NULL,
  `cost_name` varchar(200) DEFAULT NULL,
  `price2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`f_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_questions`
--

CREATE TABLE IF NOT EXISTS `lifetek_questions` (
  `id` int(11) NOT NULL,
  `ques` text NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_quotes_contract`
--

CREATE TABLE IF NOT EXISTS `lifetek_quotes_contract` (
  `id_quotes_contract` int(11) NOT NULL AUTO_INCREMENT,
  `title_quotes_contract` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_quotes_contract` text COLLATE utf8_unicode_ci,
  `cat_quotes_contract` tinyint(2) DEFAULT '0' COMMENT '1: Mẫu hợp đồng - 2: Mẫu báo giá',
  PRIMARY KEY (`id_quotes_contract`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `lifetek_quotes_contract`
--

INSERT INTO `lifetek_quotes_contract` (`id_quotes_contract`, `title_quotes_contract`, `content_quotes_contract`, `cat_quotes_contract`) VALUES
(6, 'Báo giá dịch vụ', '<p  center;">BẢNG BÁO GIÁ</p>\n\n<p>{LOGO}</p>\n\n<p  center;"><em>Ngày  {DATE}, Tháng {MONTH}, Năm {YEAR}</em></p>\n\n<hr />\n<p>Tên đơn vị(Company):                                                      {TEN_KH}</p>\n\n<p>Họ tên Người mua hàng(Customer''s name):                 {DD_KH}</p>\n\n<p>Mã số thuế (Tax Code):                                                     </p>\n\n<p>Địa chỉ (Address):                                                                {DIA_CHI_KH}</p>\n\n<p>Số tài khoản (Acount no):                                                   {TKNH_KH}</p>\n\n<p>Tại ngân hàng (Bank''s name):                                           {NH_KH}                       </p>\n\n<p>Hình thức TT (Payment of term):                                        </p>\n\n<p>Gọi tắt là bên A      </p>\n\n<hr />\n<p>Đơn vị bán hàng  (Sale Company):                   Công ty TNHH Công Nghệ Tự Động Hóa Minh Anh.</p>\n\n<p>Địa chỉ (Address):                                                 </p>\n\n<p>Điện thoại (Tex/Fax):                                            0436413130 - 0164939929688</p>\n\n<p>Người báo giá (Salesman):                                </p>\n\n<p>Quản lý (Manager):                                               Ông  Nguyễn Xuân Giang          Điện thoại (Mob):  0944245885</p>\n\n<p  right;">Gọi tắt là bên B                                                                                                               Đơn vị tiền tệ (Unit currency):     VNĐ  </p>\n\n<p>{TABLE_DATA}</p>\n\n<p>- Đơn giá trên đã bao gồm thuế VAT</p>\n\n<p>- Bảo hành 12 tháng kể từ ngày ký biên bản nghiệm thu hàng hóa</p>\n\n<p>- Giá trên đã bao gồm các loại thuế, chi phí vận chuyển tại kho Hà Nội, bảo hiểm, bảo hành trong thời gian hoàn thành...</p>\n\n<p>Trách nhiệm của bên A</p>\n\n<p>Thông báo kịp thời cho bên B khi thang máy bị sự cố, hư hỏng.<br />\nNgoài thao tác cứu hộ hành khách ra khỏi phòng thang trong tr¬ường hợp khẩn cấp như đã được hướng dẫn, bên A hoặc bên thứ ba không được tự thực hiện bất kỳ công việc gì liên quan tới thiết bị thang máy khi chưa có sự đồng ý bằng văn bản của bên B.  <br />\nTạo điều kiện thuận lợi để bên B thực hiện công việc bảo hành, bảo dưỡng thang máy.<br />\nKý xác nhận vào phiếu công tác của bên B mỗi khi bên B thực hiện công việc bảo trì, sửa chữa thang máy.</p>\n\n<p>Trách nhiệm của bên B</p>\n\n<p>''Bảo dưỡng, bảo trì định kỳ 01 lần/ 01 tháng cho thang máy của bên A, Bên B đảm bảo thời gian trực 24/24h mỗi ngày tại trung tâm bảo hành thang máy và sẵn sàng đáp ứng kịp thời yêu cầu chỉnh sửa của bên A, Khi nhận được thông báo yêu cầu cảu bên A, Kỹ thuật viên của bên B sẽ có mặt trong thời gian sớm nhất để xác định sự cố và tiến hành sửa chữa</p>\n\n<p>CÁC ĐIỀU KHOẢN THƯƠNG MẠI: </p>\n\n<p>- Giao hàng: Thời gian giao hàng trong vòng 25 ngày kể từ ngày ký hợp đồng có hiệu lực</p>\n\n<p>- Địa điểm: Tại kho Bên A theo yêu cầu</p>\n\n<p>- Thanh toán: Thanh toán 100% giá trị đơn hàng sau 30 ngày kể từ khi bên bán bàn giao hàng hóa cùng các chứng từ liên quan.<br />\n                Đặt cọc 50% tổng giá trị hợp đồng kinh tế sau khi bên B thực hiện hoàn tất công việc bảo trì tháng thứ 6<br />\n                Đặt cọc 50% tổng giá trị hợp đồng kinh tế trong vòng 10 ngày sau khi bên bán thực hiện hoàn tất công việc bảo trì của tháng thứ 12</p>\n\n<p>Quý khách hàng xin vui lòng chuyển khoản vào thông tin sau:<br />\nTài khoản công ty:<br />\nChủ TK: Phạm Thành Long <br />\nSố TK: 98756543211 <br />\nNgân hàng Vietcombankk, chi nhánh Cầu Giấy </p>\n\n<p>Tài khoản cá nhân:<br />\nChủ TK: Phạm Thành Longg <br />\nSố TK: 9876543211 <br />\nNgân hàng Vietcombankk, chi nhánh Cầu Giấy </p>\n\n<p>Hiệu lực: Bảng chào giá có hiệu lực 30 ngày kể từ ngày ký báo giá</p>\n\n<p>Cảm ơn Quý khách hàng, mong sự cộng tác bền lâu!</p>\n\n<p  right;">ĐẠI DIỆN NHÀ CUNG CẤP</p>\n', 2),
(7, 'Hợp đồng hàng hóa', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Độc lập - Tự do - Hạnh phúc</strong></p>\n\n<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>{TITLE}</strong></h2>\n\n<p><em>Căn cứ Luật Thương mại đã được Quốc hội nước Cộng hòa xã hội chủ nghĩa Việt Nam khóa XI, kỳ họp thứ 7 thông qua ngày 14 tháng 6 năm 2005</em></p>\n\n<p><em>Căn cứ Bộ Luật Dân sự này đã được Quốc hội nước Cộng hòa xã hội chủ nghĩa Việt Nam khóa XI, kỳ họp thứ 7 thông qua ngày 14 tháng 6 năm 2005</em></p>\n\n<p><em>Căn cứ nhu cầu và khả năng cung cấp hai bên ký hợp đồng.</em></p>\n\n<table>\n <tbody>\n  <tr>\n   <td>\n   <p><strong>Bên A</strong></p>\n   </td>\n   <td>\n   <p>{TEN_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Địa chỉ</p>\n   </td>\n   <td>\n   <p>{DIA_CHI_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Điện thoại</p>\n   </td>\n   <td>\n   <p>{SDT_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Đại diện bởi:</p>\n   </td>\n   <td>\n   <p>(Ông/Bà) {DD_NCC}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Chức vụ: {CHUCVU_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Số tài khoản:</p>\n   </td>\n   <td>\n   <p>{TKNH_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Tại ngân hàng:</p>\n   </td>\n   <td>\n   <p>{NH_NCC}</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<table>\n <tbody>\n  <tr>\n   <td>\n   <p><strong>Bên B</strong></p>\n   </td>\n   <td>\n   <p>{TEN_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Địa chỉ</p>\n   </td>\n   <td>\n   <p>{DIA_CHI_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Điện thoại</p>\n   </td>\n   <td>{SDT_KH}</td>\n  </tr>\n  <tr>\n   <td>\n   <p>Đại diện bởi:</p>\n   </td>\n   <td>\n   <p>(Ông/Bà) {DD_KH}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chức vụ: {CHUCVU_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Số tài khoản:</p>\n   </td>\n   <td>\n   <p>{TKNH_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Tại ngân hàng:</p>\n   </td>\n   <td>{NH_KH}</td>\n  </tr>\n </tbody>\n</table>\n\n<p><strong>ĐIỀU 1: NỘI DUNG HỢP ĐỒNG MUA BÁN</strong></p>\n\n<p>- Bên A đồng ý bán cho bên B</p>\n\n<p>{TABLE_DATA}</p>\n\n<p>ĐIỀU 3: GIAO HÀNG</p>\n\n<p>- Thời gian chuyển giao: Một ngày sau khi nhận được tiền</p>\n\n<p>- Hình thức chuyển giao: Nhân viên kĩ thuật sẽ hướng dẫn cài đặt hoặc trực tiếp xuống cài đặt và gửi file</p>\n\n<p>ĐIỀU 4: BẢO HÀNH VÀ TƯ VẤN</p>\n\n<p>- Bên B chịu trách nhiệm bảo hành sản phẩm trong vòng 12 tháng kể từ ngày ký kết hợp đồng chuyển giao.</p>\n\n<p>- &nbsp;Bên B chịu bảo hành các lỗi gặp phải khi vận hành phần mềm đúng như yêu cầu đặt hàng phần mềm của bên A</p>\n\n<p>- Bên B không chịu trách nhiệm bảo hành các lỗi do thiết bị phần cứng gây ra, các lỗi do người sử dụng vô tình hay cố ý gây ra khi vận hành phần mềm không đúng với tài liệu hướng dẫn sử dụng. Bên B không chịu trách nhiệm bảo hành tính pháp lý của số liệu kế toán trong phần mềm. Bên B không chịu trách nhiệm bảo hành phần mềm trong các trường hợp sự cố gây ra do thiên tai: lũ lụt, động đất, sét đánh, hỏa hoạn, mất trộm, mất điện …</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ĐẠI DIỆN BÊN A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ĐẠI DIỆN BÊN B</p>\n', 1),
(9, 'Báo giá hàng hóa', '<table border="0" cellpadding="0" cellspacing="0">\n <tbody>\n  <tr>\n   <td rowspan="3">\n   <p>{LOGO}</p>\n   </td>\n   <td>\n   <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BẢNG B&Aacute;O GI&Aacute;</strong></p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>&nbsp;</p>\n\n   <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\n\n   <p><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ng&agrave;y </em>{DATE},<em> Th&aacute;ng&nbsp;</em>{MONTH}<em>, Năm&nbsp;</em>{YEAR}</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>&nbsp;</p>\n\n<table border="0" cellpadding="0" cellspacing="0">\n <tbody>\n  <tr>\n   <td>\n   <p><strong>T&ecirc;n đơn vị</strong>(Company):</p>\n   </td>\n   <td>\n   <p>&nbsp;{TEN_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Họ t&ecirc;n Người mua h&agrave;ng</strong>(Customer&#39;s name):</p>\n   </td>\n   <td>\n   <p>{DD_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>M&atilde; số thuế</strong> (Tax Code):</p>\n   </td>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Địa chỉ</strong> (Address):</p>\n   </td>\n   <td>\n   <p>&nbsp;{DIA_CHI_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Số t&agrave;i khoản</strong> (Acount no):</p>\n   </td>\n   <td>\n   <p>{TKNH_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Tại ng&acirc;n h&agrave;ng</strong> (Bank&#39;s name):</p>\n   </td>\n   <td>\n   <p>{NH_KH}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>H&igrave;nh thức TT</strong> (Payment of term):</p>\n   </td>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Gọi tắt l&agrave; b&ecirc;n A &nbsp; &nbsp; &nbsp;</p>\n   </td>\n   <td>\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>&nbsp;</p>\n\n<hr />\n<table border="0" cellpadding="0" cellspacing="0">\n <tbody>\n  <tr>\n   <td>\n   <p><strong>Đơn vị b&aacute;n h&agrave;ng</strong> &nbsp;(Sale Company):</p>\n   </td>\n   <td colspan="3">\n   <p>{TEN_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Địa chỉ</strong> (Address):</p>\n   </td>\n   <td colspan="3">\n   <p>{DIA_CHI_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Điện thoại</strong> (Tex/Fax):</p>\n   </td>\n   <td colspan="3">\n   <p>{SDT_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Người b&aacute;o gi&aacute;</strong> (Salesman):</p>\n   </td>\n   <td colspan="3">\n   <p>&nbsp;</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p><strong>Quản l&yacute;</strong> (Manager):</p>\n   </td>\n   <td>\n   <p>&Ocirc;ng:&nbsp; {DD_NCC}</p>\n   </td>\n   <td>\n   <p>Điện thoại (Mob):</p>\n   </td>\n   <td>\n   <p>{SDT_NCC}</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>Gọi tắt l&agrave; b&ecirc;n B&nbsp; &nbsp; &nbsp;</p>\n   </td>\n   <td colspan="3">\n   <p>Đơn vị tiền tệ (Unit currency): VNĐ&nbsp;&nbsp;</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>{TABLE_DATA}</p>\n\n<p>- Đơn gi&aacute; tr&ecirc;n đ&atilde; bao gồm thuế VAT</p>\n\n<p>- Bảo h&agrave;nh 12 th&aacute;ng kể từ ng&agrave;y k&yacute; bi&ecirc;n bản nghiệm thu h&agrave;ng h&oacute;a</p>\n\n<p>- Gi&aacute; tr&ecirc;n đ&atilde; bao gồm c&aacute;c loại thuế, chi ph&iacute; vận chuyển tại kho H&agrave; Nội, bảo hiểm, bảo h&agrave;nh trong thời gian ho&agrave;n th&agrave;nh...</p>\n\n<p><strong>Tr&aacute;ch nhiệm của b&ecirc;n A</strong></p>\n\n<p>Th&ocirc;ng b&aacute;o kịp thời cho b&ecirc;n B khi thang m&aacute;y bị sự cố, hư hỏng.</p>\n\n<p>Ngo&agrave;i thao t&aacute;c cứu hộ h&agrave;nh kh&aacute;ch ra khỏi ph&ograve;ng thang trong trường hợp khẩn cấp như đ&atilde; được hướng dẫn, b&ecirc;n A hoặc b&ecirc;n thứ ba kh&ocirc;ng được tự thực hiện bất kỳ c&ocirc;ng việc g&igrave; li&ecirc;n quan tới thiết bị thang m&aacute;y khi chưa c&oacute; sự đồng &yacute; bằng văn bản của b&ecirc;n B.</p>\n\n<p>Tạo điều kiện thuận lợi để b&ecirc;n B thực hiện c&ocirc;ng việc bảo h&agrave;nh, bảo dưỡng thang m&aacute;y.<br />\nK&yacute; x&aacute;c nhận v&agrave;o phiếu c&ocirc;ng t&aacute;c của b&ecirc;n B mỗi khi b&ecirc;n B thực hiện c&ocirc;ng việc bảo tr&igrave;, sửa chữa thang m&aacute;y.</p>\n\n<p><strong>Tr&aacute;ch nhiệm của b&ecirc;n B</strong></p>\n\n<p>Bảo dưỡng, bảo tr&igrave; định kỳ 01 lần/ 01 th&aacute;ng cho thang m&aacute;y của b&ecirc;n A, B&ecirc;n B đảm bảo thời gian trực 24/24h mỗi ng&agrave;y tại trung t&acirc;m bảo h&agrave;nh thang m&aacute;y v&agrave; sẵn s&agrave;ng đ&aacute;p ứng kịp thời y&ecirc;u cầu chỉnh sửa của b&ecirc;n A, khi nhận được th&ocirc;ng b&aacute;o y&ecirc;u cầu cảu b&ecirc;n A, Kỹ thuật vi&ecirc;n của b&ecirc;n B sẽ c&oacute; mặt trong thời gian sớm nhất để x&aacute;c định sự cố v&agrave; tiến h&agrave;nh sửa chữa.</p>\n\n<p><strong>C&Aacute;C ĐIỀU KHOẢN THƯƠNG MẠI:&nbsp;</strong></p>\n\n<p>- Giao h&agrave;ng: Thời gian giao h&agrave;ng trong v&ograve;ng 25 ng&agrave;y kể từ ng&agrave;y k&yacute; hợp đồng c&oacute; hiệu lực</p>\n\n<p>- Địa điểm: Tại kho B&ecirc;n A theo y&ecirc;u cầu</p>\n\n<p>- Thanh to&aacute;n: Thanh to&aacute;n 100% gi&aacute; trị đơn h&agrave;ng sau 30 ng&agrave;y kể từ khi b&ecirc;n b&aacute;n b&agrave;n giao h&agrave;ng h&oacute;a c&ugrave;ng c&aacute;c chứng từ li&ecirc;n quan.<br />\n&nbsp; &nbsp; &nbsp; + Đặt cọc 50% tổng gi&aacute; trị hợp đồng kinh tế sau khi b&ecirc;n B thực hiện ho&agrave;n tất c&ocirc;ng việc bảo tr&igrave; th&aacute;ng thứ 6.<br />\n&nbsp; &nbsp; &nbsp; + Đặt cọc 50% tổng gi&aacute; trị hợp đồng kinh tế trong v&ograve;ng 10 ng&agrave;y sau khi b&ecirc;n b&aacute;n thực hiện ho&agrave;n tất c&ocirc;ng việc bảo tr&igrave; của th&aacute;ng thứ 12.</p>\n\n<p><strong>Qu&yacute; kh&aacute;ch h&agrave;ng xin vui l&ograve;ng chuyển khoản v&agrave;o th&ocirc;ng tin sau:<br />\nT&agrave;i khoản c&ocirc;ng ty:<br />\nChủ TK: Phạm Th&agrave;nh Long&nbsp;<br />\nSố TK: 98756543211&nbsp;<br />\nNg&acirc;n h&agrave;ng Vietcombankk, chi nh&aacute;nh Cầu Giấy&nbsp;</strong></p>\n\n<p><strong>T&agrave;i khoản c&aacute; nh&acirc;n:<br />\nChủ TK: Phạm Th&agrave;nh Longg&nbsp;<br />\nSố TK: 9876543211&nbsp;<br />\nNg&acirc;n h&agrave;ng Vietcombankk, chi nh&aacute;nh Cầu Giấy&nbsp;</strong></p>\n\n<p><strong>Hiệu lực: Bảng ch&agrave;o gi&aacute; c&oacute; hiệu lực 30 ng&agrave;y kể từ ng&agrave;y k&yacute; b&aacute;o gi&aacute;</strong></p>\n\n<p>Cảm ơn Qu&yacute; kh&aacute;ch h&agrave;ng, mong sự cộng t&aacute;c bền l&acirc;u!</p>\n\n<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ĐẠI DIỆN NH&Agrave; CUNG CẤP</strong></p>\n', 2),
(16, 'Hợp đồng kinh tế', '<p  center;"><strong>CỘNG HO&Agrave; X&Atilde; HỘI CHỦ NGHĨA VIỆT NAM</strong></p>\n\n<p  center;">Độc lập - Tự do - Hạnh ph&uacute;c</p>\n\n<p  center;">-------------oOo-----------</p>\n\n<p  center;">&nbsp;</p>\n\n<p  center;"><strong>HỢP ĐỒNG KINH TẾ</strong></p>\n\n<p  center;"><em>Số: ........../ 20&hellip;/ HĐKT</em></p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;&nbsp;&nbsp;- Căn cứ Bộ luật D&acirc;n sự số 33/2005/QH11 ng&agrave;y 14/6/2005 của nước Cộng h&ograve;a x&atilde; hội chủ nghĩa Việt nam;</p>\n\n<p>- Căn cứ v&agrave;o Luật Thương Mại số 36/2005/QH11 ng&agrave;y 14/6/2005 của nước Cộng h&ograve;a x&atilde; hội chủ nghĩa Việt nam;</p>\n\n<p>- Căn cứ v&agrave;o nhu cầu, khả năng của hai b&ecirc;n.</p>\n\n<p>H&ocirc;m nay, ng&agrave;y &hellip;.. &nbsp;th&aacute;ng &hellip;.năm 2015&nbsp; Ch&uacute;ng t&ocirc;i gồm:</p>\n\n<p><strong>B&ecirc;n A:&nbsp;&nbsp; </strong>{TEN_NCC}</p>\n\n<ul>\n <li>Địa chỉ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{DIA_CHI_NCC}</li>\n <li>Điện thoại&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;{SDT_NCC}</li>\n <li>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</li>\n <li>CMTND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp; &nbsp;&hellip;&hellip;&hellip;&hellip;CA Th&agrave;nh phố &hellip;&hellip;&hellip;&hellip;.&hellip; cấp ng&agrave;y&hellip;&hellip;&hellip;&hellip;..&hellip;..</li>\n</ul>\n\n<p><strong>B&ecirc;n B:&nbsp;&nbsp; C&ocirc;ng ty TNHH C&ocirc;ng Nghệ Tự Động H&oacute;a Minh Anh.</strong></p>\n\n<ul>\n <li>Địa chỉ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; Số 23 ng&otilde; 389/4 Ho&agrave;ng Quốc Việt &ndash; Quận Cầu Giấy -&nbsp; H&agrave; Nội.</li>\n <li>Điện thoại&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; +84 4&ndash;378 5885.</li>\n <li>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; +84 4&ndash;378 5885.</li>\n <li>M&atilde; số thuế &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; 0101130774.</li>\n <li>Đại diện bởi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; &Ocirc;ng &nbsp;<strong>Nguyễn Xu&acirc;n Giang</strong></li>\n <li>Chức vụ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; Ph&oacute; Gi&aacute;m đốc</li>\n <li>T&agrave;i khoản số&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; 10820962715015</li>\n <li>Tại Ng&acirc;n h&agrave;ng&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp; Ng&acirc;n h&agrave;ng TMCP Kỹ Thương &ndash; CN Ho&agrave;n Kiếm &ndash; H&agrave; Nội</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p>Tại Trụ sở b&ecirc;n A, hai b&ecirc;n thỏa thuận k&yacute; kết hợp đồng kinh tế n&agrave;y với c&aacute;c điều khoản sau:</p>\n\n<p><strong><em><u>Điều 1:</u></em></strong><strong><em> Nội dung c&ocirc;ng việc</em></strong></p>\n\n<p>1.1. B&ecirc;n B nhận cung cấp bằng nhập khẩu cho b&ecirc;n A&nbsp; &hellip;&hellip; ( &hellip;.. ) thang m&aacute;y tải kh&aacute;ch (m&atilde; hiệu &hellip;&hellip;&hellip;..), tải trọng &hellip;..kg (&hellip;.. người ), tốc độ &hellip;&hellip; m/ph&uacute;t, &hellip;.. điểm dừng , xuất xứ &hellip;&hellip;&hellip;, mới 100%, sản xuất năm &hellip;&hellip;. trở về sau.</p>\n\n<p><em>(Theo Bản Phụ lục Hợp đồng 1)</em></p>\n\n<p>1.2. Cung cấp vật tư lắp đặt v&agrave; lắp đặt ho&agrave;n chỉnh thang m&aacute;y tr&ecirc;n tại c&ocirc;ng tr&igrave;nh :</p>\n\n<p>&ldquo;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&rdquo;</p>\n\n<p><strong><em><u>Điều 2:</u></em></strong><strong><em> Tr&aacute;ch nhiệm của b&ecirc;n A</em></strong></p>\n\n<ul>\n <li>X&acirc;y dựng, hiệu chỉnh hố thang đảm bảo c&aacute;c th&ocirc;ng số kỹ thuật cho việc lắp đặt thang m&aacute;y theo bản vẽ kỹ thuật hố thang do b&ecirc;n B cung cấp.</li>\n <li>Chậm nhất l&agrave; trong v&ograve;ng 5 ng&agrave;y kể từ ng&agrave;y b&ecirc;n B chuyển bản vẽ kỹ thuật, b&ecirc;n A phải k&yacute; x&aacute;c nhận v&agrave;o bản vẽ kỹ thuật sau khi đ&atilde; thống nhất để B&ecirc;n B đặt h&agrave;ng với H&atilde;ng sản xuất. Qu&aacute; thời hạn tr&ecirc;n coi như b&ecirc;n A đ&atilde; đồng &yacute; với bản vẽ kỹ thuật m&agrave; b&ecirc;n B đ&atilde; chuyển để hai b&ecirc;n thực hiện c&ocirc;ng việc.</li>\n <li>B&ecirc;n A giao đầy đủ hồ sơ thiết kế li&ecirc;n quan đến hố thang m&aacute;y cho B&ecirc;n B.</li>\n <li>Cử c&aacute;n bộ c&oacute; tr&aacute;ch nhiệm phối hợp c&ugrave;ng b&ecirc;n B tham gia kiểm tra v&agrave; k&yacute; x&aacute;c nhận thiết bị thang m&aacute;y khi l&ocirc; thiết bị được chuyển về ch&acirc;n c&ocirc;ng tr&igrave;nh. Nếu tại thời điểm h&agrave;ng về ch&acirc;n c&ocirc;ng tr&igrave;nh, b&ecirc;n A kh&ocirc;ng bố tr&iacute; được người kiểm tra, b&ecirc;n B vẫn vận chuyển l&ocirc; thiết bị tr&ecirc;n v&agrave;o kho v&agrave; l&ocirc; thiết bị tr&ecirc;n coi như đ&atilde; được kiểm tra đầy đủ, đ&uacute;ng theo danh mục hồ sơ thang m&aacute;y k&egrave;m theo.</li>\n <li>Bố tr&iacute; kho chứa thiết bị an to&agrave;n tại tầng một khi b&ecirc;n B vận chuyển thiết bị đến c&ocirc;ng tr&igrave;nh v&agrave; đảm bảo an ninh cho kho chứa thiết bị thang m&aacute;y tại c&ocirc;ng tr&igrave;nh.</li>\n <li>B&agrave;n giao mặt bằng đủ điều kiện để thi c&ocirc;ng lắp đặt cho b&ecirc;n B đ&uacute;ng tiến độ.</li>\n <li>Cung cấp điểm đấu nối nguồn điện để thi c&ocirc;ng, lắp đặt thang m&aacute;y trong khu vực thi c&ocirc;ng.</li>\n <li>Cung cấp nguồn điện 3 phase 380V/220V v&agrave; 01 Aptomat 3 phase /1 thang v&agrave; điểm đấu nối d&acirc;y tiếp địa tại ph&ograve;ng đặt m&aacute;y để b&ecirc;n B hiệu chỉnh thang m&aacute;y .</li>\n <li>B&ecirc;n A cử c&aacute;n bộ kỹ thuật thường xuy&ecirc;n phối hợp c&ugrave;ng b&ecirc;n B trong suốt qu&aacute; tr&igrave;nh thi c&ocirc;ng lắp đặt để giải quyết kịp thời c&aacute;c c&ocirc;ng việc trong qu&aacute; tr&igrave;nh thực hiện hợp đồng.</li>\n <li>&nbsp;Tổ chức nghiệm thu, k&yacute; bi&ecirc;n bản nghiệm thu giai đoạn (nếu c&oacute;) v&agrave; nghiệm thu b&agrave;n giao kịp thời khi b&ecirc;n B ho&agrave;n tất c&ocirc;ng việc.</li>\n <li>Thực hiện phần việc x&acirc;y dựng ho&agrave;n thiện sau khi b&ecirc;n B ho&agrave;n tất lắp đặt thiết bị thang m&aacute;y.</li>\n <li>Tạm ứng v&agrave; thanh to&aacute;n kịp thời cho B&ecirc;n B theo điều 6 của Hợp đồng.</li>\n</ul>\n\n<p><strong><em><u>Điều 3:</u></em></strong><strong><em> Tr&aacute;ch nhiệm của b&ecirc;n B</em></strong></p>\n\n<ul>\n <li>Khảo s&aacute;t v&agrave; thiết kế bản vẽ hố thang theo ti&ecirc;u chuẩn v&agrave; chuyển cho b&ecirc;n A k&yacute; x&aacute;c nhận l&agrave;m cơ sở đặt h&agrave;ng với H&atilde;ng sản xuất v&agrave; thực hiện c&aacute;c c&ocirc;ng việc li&ecirc;n quan.</li>\n <li>Nhập khẩu thiết bị thang m&aacute;y theo c&aacute;c th&ocirc;ng số kỹ thuật của Phụ lục số 01 về đặc t&iacute;nh kỹ thuật thang m&aacute;y.</li>\n <li>Trước khi vận chuyển thiết bị về c&ocirc;ng tr&igrave;nh, b&ecirc;n B c&oacute; tr&aacute;ch nhiệm th&ocirc;ng b&aacute;o cho b&ecirc;n A ng&agrave;y thiết bị về đến c&ocirc;ng tr&igrave;nh để b&ecirc;n A bố tr&iacute; kho chứa thiết bị tại c&ocirc;ng tr&igrave;nh.</li>\n <li>Vận chuyển thiết bị đến c&ocirc;ng tr&igrave;nh, &nbsp;phối hợp c&ugrave;ng với đại diện của b&ecirc;n A kiểm tra v&agrave; k&yacute; x&aacute;c nhận v&agrave;o c&aacute;c bi&ecirc;n bản.</li>\n <li>Cung cấp vật tư &nbsp;lắp đặt v&agrave; lắp đặt, hiệu chỉnh, đưa thang m&aacute;y v&agrave;o sử dụng.</li>\n <li>C&oacute; tr&aacute;ch nhiệm mời cơ quan c&oacute; chức năng, tổ chức kiểm định - cung cấp Bi&ecirc;n bản kiểm định kỹ thuật an to&agrave;n thang m&aacute;y của cơ quan Nh&agrave; nước c&oacute; thẩm quyền đủ điều kiện an to&agrave;n sử dụng b&agrave;n giao cho b&ecirc;n A.</li>\n <li>C&oacute; tr&aacute;ch nhiệm quản l&yacute;, đảm bảo an ninh, an to&agrave;n trong qu&aacute; tr&igrave;nh thi c&ocirc;ng tr&ecirc;n c&ocirc;ng tr&igrave;nh v&agrave; giữ g&igrave;n vệ sinh m&ocirc;i trường trong suốt thời gian thi c&ocirc;ng.</li>\n <li>Đảm bảo v&agrave; chịu tr&aacute;ch nhiệm về c&aacute;c điều kiện an to&agrave;n cho con người, an ninh trong khu vực thi c&ocirc;ng theo quy định chung.</li>\n <li>Hướng dẫn c&aacute;ch sử dụng vận h&agrave;nh thang m&aacute;y cho b&ecirc;n A.</li>\n <li>B&ecirc;n B c&oacute; tr&aacute;ch nhiệm bảo h&agrave;nh c&ocirc;ng tr&igrave;nh theo quy định tại điều 7 của Hợp đồng kinh tế.</li>\n</ul>\n\n<p><strong><em><u>Điều 4:</u></em></strong><strong><em> Tiến độ thực hiện được b&ecirc;n B thực hiện như sau:&nbsp; </em></strong></p>\n\n<table border="0" cellpadding="0" cellspacing="0">\n <tbody>\n  <tr>\n   <td>\n   <p>4.1 Thời gian thiết bị thang m&aacute;y đ&shy;ược nhập khẩu v&agrave; vận chuyển đến c&ocirc;ng tr&igrave;nh kể từ ng&agrave;y b&ecirc;n B nhận được kinh ph&iacute; tạm ứng kỳ 1 v&agrave; b&ecirc;n A x&aacute;c nhận v&agrave;o bản vẽ kỹ thuật hố thang l&agrave;: &hellip;. th&aacute;ng</p>\n   </td>\n  </tr>\n  <tr>\n   <td>\n   <p>4.2 Thời gian lắp đặt, hiệu chỉnh được thực hiện khi b&ecirc;n B nhận được kinh ph&iacute; thanh to&aacute;n kỳ 2, b&ecirc;n A b&agrave;n giao mặt bằng đầy đủ điều kiện thi c&ocirc;ng v&agrave; k&yacute; bi&ecirc;n bản nghiệm thu thiết bị trước khi lắp đặt l&agrave;: &hellip;.. ng&agrave;y</p>\n   </td>\n  </tr>\n </tbody>\n</table>\n\n<p>-&nbsp;&nbsp; Tiến độ tr&ecirc;n chỉ được thực hiện với c&aacute;c điều kiện sau:</p>\n\n<ul>\n <li>B&ecirc;n A thanh to&aacute;n đ&uacute;ng thời hạn v&agrave; gi&aacute; trị đ&atilde; ghi ở điều 5 v&agrave; điều 6 hợp đồng n&agrave;y.</li>\n <li>C&aacute;c chi tiết kỹ thuật của thang m&aacute;y phải được b&ecirc;n A thống nhất trước khi k&yacute; kết hợp đồng kinh tế. Trong trường hợp c&oacute; những thay đổi về chi tiết kỹ thuật của thang m&aacute;y từ ph&iacute;a b&ecirc;n A như bổ sung, bỏ bớt hoặc điều chỉnh th&igrave; hai b&ecirc;n thống thất bằng một văn bản hoặc phụ lục hợp đồng bổ sung để hiệu chỉnh gi&aacute; trị hợp đồng v&agrave; tiến độ thực hiện nhưng thời gian cho việc thay đổi trong v&ograve;ng 30 ng&agrave;y kể từ ng&agrave;y hợp đồng c&oacute; hiệu lực.</li>\n <li>Việc lắp đặt thang m&aacute;y chỉ được tiến h&agrave;nh sau khi điều 4.2 đ&atilde; được thực hiện .</li>\n</ul>\n\n<p><strong><em><u>Điều 5:</u></em></strong><strong><em>&nbsp; Gi&aacute; trị của hợp đồng kinh tế </em></strong></p>\n\n<ul>\n <li>Gi&aacute; trị hợp đồng kinh tế cung cấp lắp đặt thang m&aacute;y l&agrave;: khoản tiền VNĐ c&oacute; gi&aacute; trị bảo đảm tương đương: <strong>&hellip;&hellip;&hellip;&hellip;.. VND <em>(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.. VND</em></strong>) <strong>.</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>\n</ul>\n\n<p><strong><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;( Bằng chữ: &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;. )</em></strong></p>\n\n<ul>\n <li><em>Gi&aacute; trị hợp đồng tr&ecirc;n đ&atilde; bao gồm: gi&aacute; thiết bị thang m&aacute;y nhập khẩu về tới ch&acirc;n c&ocirc;ng tr&igrave;nh, vật tư lắp đặt, chi ph&iacute; lắp đặt, hiệu chỉnh, tổ chức kiểm định thang m&aacute;y cấp giấy chứng nhận thang m&aacute;y đủ điểu kiện an to&agrave;n sử dụng, chi ph&iacute; bảo h&agrave;nh &nbsp;v&agrave; thuế GTGT.</em></li>\n</ul>\n\n<p><strong><em><u>Điều 6:</u></em></strong><strong><em> Ph&shy;ương thức thanh to&aacute;n </em></strong></p>\n\n<ul>\n <li>B&ecirc;n A tạm ứng, thanh to&aacute;n cho b&ecirc;n B theo c&aacute;c kỳ nh&shy;ư sau:</li>\n</ul>\n\n<ul>\n <li><u>Kỳ 1: </u>Tạm ứng <strong>40</strong>% tổng gi&aacute; trị hợp đồng kinh tế ngay sau khi Hợp đồng kinh tế được k&yacute; kết.</li>\n</ul>\n\n<ul>\n <li><u>Kỳ 2:</u> Thanh to&aacute;n 5<strong>0%</strong> tổng gi&aacute; trị hợp đồng kinh tế - kh&ocirc;ng bao gồm gi&aacute; trị đ&atilde; tạm ứng kỳ 1 - trong v&ograve;ng 7 ng&agrave;y sau khi thiết bị thang m&aacute;y đ&shy;ược chuyển đến ch&acirc;n c&ocirc;ng tr&igrave;nh.</li>\n <li><u>Kỳ 3:</u> Thanh to&aacute;n phần c&ograve;n lại của tổng gi&aacute; trị hợp đồng trong v&ograve;ng 10 ng&agrave;y kể từ ng&agrave;y b&ecirc;n B ho&agrave;n tất việc lắp đặt v&agrave; thang m&aacute;y được kiểm định an to&agrave;n.</li>\n</ul>\n\n<ul>\n <li>Tr&shy;ường hợp b&ecirc;n A kh&ocirc;ng thực hiện đầy đủ nghĩa vụ thanh to&aacute;n như&shy; đ&atilde; thống nhất ở tr&ecirc;n, b&ecirc;n B c&oacute; quyền ngừng thực hiện c&aacute;c c&ocirc;ng việc li&ecirc;n quan đến thang m&aacute;y cho đến khi b&ecirc;n A ho&agrave;n th&agrave;nh nghĩa vụ thanh to&aacute;n của m&igrave;nh v&agrave; đền b&ugrave; những thiệt hại cho b&ecirc;n B theo l&atilde;i suất qu&aacute; hạn cho vay của Ng&acirc;n h&agrave;ng b&ecirc;n B mở t&agrave;i khoản.</li>\n <li>Trong trường hợp b&ecirc;n B đ&atilde; ho&agrave;n th&agrave;nh to&agrave;n bộ c&ocirc;ng việc theo như hợp đồng kinh tế đ&atilde; k&yacute; kết m&agrave; b&ecirc;n A chưa c&oacute; nguồn điện ch&iacute;nh thức để sử dụng thang m&aacute;y, hoặc chưa c&oacute; nhu cầu sử dụng th&igrave; tr&aacute;ch nhiệm của b&ecirc;n A l&agrave; phải ho&agrave;n th&agrave;nh nghĩa vụ thanh to&aacute;n to&agrave;n bộ gi&aacute; trị hợp đồng cho b&ecirc;n B để b&ecirc;n B quyết to&aacute;n hợp đồng v&agrave; thực hiện nghĩa vụ nộp thuế theo quy định của Nh&agrave; nước.</li>\n</ul>\n\n<p><strong><em><u>Điều 7 :</u></em></strong><strong><em> Bảo h&agrave;nh v&agrave; Bảo tr&igrave;</em></strong></p>\n\n<ul>\n <li>B&ecirc;n B c&oacute; tr&aacute;ch nhiệm bảo h&agrave;nh thiết bị trong thời hạn 12 th&aacute;ng kể từ ng&agrave;y thang m&aacute;y được kiểm định an to&agrave;n. Nếu trong thời gian bảo h&agrave;nh m&agrave; thang m&aacute;y bị hư hỏng, nhận được th&ocirc;ng b&aacute;o của b&ecirc;n A trong thời gian sớm nhất b&ecirc;n B phải cử người đến xử l&yacute; v&agrave; chịu mọi ph&iacute; tổn sửa chữa nếu xảy ra sự cố kỹ thuật do lỗi của nh&agrave; sản xuất hoặc do lỗi kh&aacute;c của b&ecirc;n B.</li>\n <li>B&ecirc;n B c&oacute; tr&aacute;ch nhiệm lập quy tr&igrave;nh bảo tr&igrave; cho c&ocirc;ng tr&igrave;nh khi hết thời hạn bảo h&agrave;nh v&agrave; hai b&ecirc;n sẽ thương thảo, k&yacute; kết hợp đồng bảo tr&igrave; cho c&ocirc;ng tr&igrave;nh.</li>\n</ul>\n\n<p><strong><em><u>Điều 8:</u></em></strong><strong><em>&nbsp; Hiệu lực hợp đồng </em></strong></p>\n\n<ul>\n <li>Hợp đồng kinh tế n&agrave;y c&oacute; hiệu lực kể từ ng&agrave;y k&yacute; v&agrave; kh&ocirc;ng đư&shy;ợc hủy ngang, nếu b&ecirc;n n&agrave;o vi phạm th&igrave; sẽ đền b&ugrave; cho b&ecirc;n c&ograve;n lại 20% gi&aacute; trị Hợp đồng kinh tế.</li>\n <li>Hai b&ecirc;n cam kết thực hiện đ&uacute;ng c&aacute;c điều khoản ghi trong hợp đồng kinh tế. Khi c&oacute; &nbsp;vướng mắc hai b&ecirc;n c&ugrave;ng trao đổi để khắc phục. Nếu kh&ocirc;ng giải quyết được bằng thương lượng th&igrave; một trong hai b&ecirc;n sẽ đưa ra To&agrave; &aacute;n Nh&acirc;n d&acirc;n c&oacute; thẩm quyền thuộc th&agrave;nh phố H&agrave; Nội để giải quyết. Ph&aacute;n quyết của To&agrave; &aacute;n Nh&acirc;n d&acirc;n c&oacute; thẩm quyền thuộc th&agrave;nh phố H&agrave; Nội l&agrave; ph&aacute;n quyết cuối c&ugrave;ng để hai b&ecirc;n thực hiện, mọi chi ph&iacute; ph&aacute;t sinh v&agrave; &aacute;n ph&iacute; do b&ecirc;n c&oacute; lỗi chịu tr&aacute;ch nhiệm thanh to&aacute;n.</li>\n <li>Hợp đồng n&agrave;y đ&shy;ược lập th&agrave;nh &hellip;.. bản, mỗi b&ecirc;n giữ &hellip;. bản v&agrave; c&oacute; gi&aacute; trị ph&aacute;p l&yacute; nh&shy;ư nhau.</li>\n</ul>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ĐẠI DIỆN B&Ecirc;N A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;ĐẠI DIỆN B&Ecirc;N B</strong></p>\n\n<p>&nbsp;</p>\n', 1);
INSERT INTO `lifetek_quotes_contract` (`id_quotes_contract`, `title_quotes_contract`, `content_quotes_contract`, `cat_quotes_contract`) VALUES
(17, 'HỢP ĐỒNG KINH TẾ', '<p>&nbsp;</p>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CỘNG H&Ograve;A X&Atilde; HỘI CHỦ NGHĨA VIỆT NAM</strong></p>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Độc lập &ndash; Tự do &ndash; Hạnh ph&uacute;c</p>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; ----------&amp;&amp;&amp;---------</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {TITLE}</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Số: {CODE}/2015/HĐKT/VD</p>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Về việc: Cung cấp v&agrave; lắp đặt cửa nhựa l&otilde;i th&eacute;p UPVC, cửa cuốn tại </strong></p>\n\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nh&agrave; m&aacute;y NANO SMART MATERIAL</strong></p>\n\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; (Địa chỉ: &nbsp;Cụm CN Hợp Thịnh huyện Hiệp H&ograve;a tỉnh Bắc Giang )</p>\n\n<p>- Căn cứ Bộ Luật d&acirc;n sự được Quốc hội nước CHXHCN Việt Nam kh&oacute;a XI kỳ họp thứ 7 th&ocirc;ng qua ng&agrave;y 14/6/2005;</p>\n\n<p>- Căn cứ luật thương mại số 36/2005/QH11 được Quốc hội nước CHXHCN Việt Nam kh&oacute;a XI kỳ họp thứ 7 th&ocirc;ng qua ng&agrave;y 14/6/2005;</p>\n\n<p>- &nbsp;Nhu cầu v&agrave; khả năng đ&aacute;p ứng của c&aacute;c b&ecirc;n;</p>\n\n<p>H&ocirc;m nay, Ng&agrave;y&nbsp; {DATE} Th&aacute;ng&nbsp; {MONTH} Năm&nbsp; {YEAR}, tại {TEN_NCC}, ch&uacute;ng t&ocirc;i gồm:</p>\n\n<p><strong>B&ecirc;n A:&nbsp;</strong>{TEN_KH}</p>\n\n<p>Địa chỉ:&nbsp;{DIA_CHI_KH}</p>\n\n<p>Số điện thoại: {SDT_KH}</p>\n\n<p>Đai diện:&nbsp;{DD_KH}</p>\n\n<p>Chức vụ: {CHUCVU_KH}</p>\n\n<p>T&agrave;i khoản ng&acirc;n h&agrave;ng: {TKNH_KH}</p>\n\n<p><strong>B&ecirc;n B:<em>&nbsp; </em></strong>{TEN_NCC}</p>\n\n<p>Địa Chỉ: {DIA_CHI_NCC}</p>\n\n<p>Số điện thoại:&nbsp;{SDT_NCC}</p>\n\n<p>Đại diện:{DD_NCC}</p>\n\n<p>Chức vụ: {CHUCVU_NCC}</p>\n\n<p>T&agrave;i khoản ng&acirc;n h&agrave;ng: {TKNH_NCC}</p>\n\n<p>- Hai B&ecirc;n A v&agrave; B&ecirc;n B c&ugrave;ng thoả thuận, thống nhất v&agrave; k&yacute; kết hợp đồng kinh tế về việc: Cung cấp v&agrave; lắp đặt hệ thống cửa nhựa l&otilde;i th&eacute;p UPVC, cửa cuốn tại Nh&agrave; m&aacute;y NANO SMART MATERIAL (Địa chỉ: Cụm CN Hợp Thịnh huyện Hiệp H&ograve;a tỉnh Bắc Giang). Với những điều khoản sau đ&acirc;y:</p>\n\n<p><strong><u>ĐIỀU 1</u></strong>: <strong>ĐỊNH NGHĨA</strong></p>\n\n<ul>\n <li>Hợp đồng kinh tế: L&agrave; bản hợp đồng n&agrave;y được k&yacute; giữa b&ecirc;n giao thầu v&agrave; b&ecirc;n nhận thầu kể cả c&aacute;c phụ lục, c&aacute;c văn bản k&egrave;m theo v&agrave; c&aacute;c văn bản được đưa v&agrave;o tham chiếu.</li>\n <li>Gi&aacute; trị hợp đồng: L&agrave; gi&aacute; trị được b&ecirc;n giao thầu v&agrave; b&ecirc;n nhận thầu thoả thuận sau khi thương thảo ho&agrave;n thiện hợp đồng v&agrave; được cụ thể ho&aacute; tại điều 2 của hợp đồng n&agrave;y.</li>\n <li>H&agrave;ng ho&aacute; - dịch vụ: L&agrave; vật tư v&agrave; nh&acirc;n c&ocirc;ng cung cấp cho b&ecirc;n giao thầu được cụ thể trong điều 2 của hợp đồng n&agrave;y.</li>\n</ul>\n\n<p><strong><u>ĐIỀU 2</u></strong>: <strong>NỘI DUNG, GI&Aacute; TRỊ HỢP ĐỒNG.</strong></p>\n\n<p><strong>2.1 Nội dung:</strong></p>\n\n<p>B&ecirc;n A đồng &yacute; thu&ecirc; b&ecirc;n B cung cấp vật tư v&agrave; lắp đặt cửa nhựa l&otilde;i th&eacute;p tại Nh&agrave; m&aacute;y&nbsp; NANO SMART MATERIAL (Địa chỉ: Cụm CN Hợp Thịnh huyện Hiệp H&ograve;a tỉnh Bắc Giang). theo y&ecirc;u cầu của b&ecirc;n A.</p>\n\n<p>{TABLE_DATA}</p>\n\n<p>- Gi&aacute; trị hợp đồng tr&ecirc;n đ&atilde; bao gồm thuế VAT 10%.</p>\n\n<p>- H&igrave;nh thức hợp đồng: Hợp đồng theo đơn gi&aacute; cố định.</p>\n\n<p>- Trong tr&shy;&ecirc;ng h&icirc;p ph&cedil;t sinh kh&egrave;i l&shy;&icirc;ng, hai b&ordf;n s&Iuml; ti&Otilde;n h&micro;nh b&aelig; sung b&raquo;ng ph&ocirc; l&ocirc;c h&icirc;p &reg;&aring;ng.</p>\n\n<p>- Gi&cedil; tr&THORN; h&icirc;p &reg;&aring;ng l&micro; gi&cedil; tr&THORN; t&sup1;m t&Yacute;nh. Gi&cedil; tr&THORN; quy&Otilde;t to&cedil;n c&ntilde;a h&icirc;p &reg;&aring;ng &reg;&shy;&icirc;c x&cedil;c &reg;&THORN;nh tr&ordf;n c&not; s&euml; kh&egrave;i l&shy;&icirc;ng th&ugrave;c t&Otilde; b&ordf;n B c&Ecirc;p &reg;&shy;&icirc;c cho b&ordf;n A (&reg;&shy;&icirc;c hai b&ordf;n k&yacute; x&cedil;c nh&Euml;n).</p>\n\n<p>&nbsp;</p>\n\n<p><strong><u>ĐIỀU 3:</u></strong><strong> PHƯƠNG THỨC THANH TO&Aacute;N</strong></p>\n\n<ul>\n <li>To&agrave;n bộ gi&aacute; trị hợp đồng được thanh to&aacute;n bằng Đồng Việt Nam</li>\n <li>H&igrave;nh thức thanh to&aacute;n: Thanh to&aacute;n bằng chuyển khoản.</li>\n <li>Thời hạn thanh to&aacute;n: Ngay khi hợp đồng kinh tế được k&yacute;.</li>\n</ul>\n\n<ul>\n <li><strong><em>Lần I:</em></strong> Tạm ứng 40% gi&aacute; trị hợp đồng tương đương <strong>120.000.000 VNĐ.</strong></li>\n <li><strong><em>Lần II:</em></strong> Thanh to&aacute;n 100% gi&aacute; trị hợp đồng sau khi nghiệm thu c&ocirc;ng tr&igrave;nh trong v&ograve;ng 07 ng&agrave;y.</li>\n</ul>\n\n<p><strong><u>ĐIỀU 4</u></strong>: <strong>TI&Ecirc;U CHUẨN KỸ THUẬT -</strong> <strong>TIẾN ĐỘ THI C&Ocirc;NG</strong></p>\n\n<ul>\n <li>B&ecirc;n B chịu tr&aacute;ch nhiệm thi c&ocirc;ng theo đ&uacute;ng hồ sơ thiết kế, y&ecirc;u cầu kỹ thuật đ&atilde; được chủ đầu tư c&ocirc;ng tr&igrave;nh ph&ecirc; duyệt dưới sự gi&aacute;m s&aacute;t trực tiếp của b&ecirc;n A cũng như phải đảm bảo chất lượng theo c&aacute;c ti&ecirc;u chuẩn v&agrave; quy định của ph&aacute;p luật Việt nam.</li>\n <li>B&ecirc;n B phải thi c&ocirc;ng theo đ&uacute;ng tập bản vẽ đ&atilde; tr&igrave;nh b&ecirc;n A v&agrave; được coi l&agrave; 1 bộ hồ sơ c&oacute; gi&aacute; trị thực hiện đ&iacute;nh k&egrave;m hợp đồng n&agrave;y.</li>\n <li>Ti&ecirc;u chuẩn thanh nhựa: SPARLEE PROFILE</li>\n <li>Ti&ecirc;u chuẩn phụ kiện: GQ (GOLKING); VVP Th&aacute;i Lan</li>\n <li>Ti&ecirc;u chuẩn k&iacute;nh: K&iacute;nh nổi Việt Nhật (VFG)</li>\n <li>To&agrave;n bộ khối lượng tại điều 2 sẽ được b&ecirc;n B thực hiện ho&agrave;n th&agrave;nh trong v&ograve;ng 30 ng&agrave;y kể từ ng&agrave;y nhận được tiền tạm ứng v&agrave; mặt bằng thi c&ocirc;ng.</li>\n <li>Trong trường hợp bất khả kh&aacute;ng như: Chiến tranh, động đất, mưa b&atilde;o, mất điện.... hoặc c&aacute;c nguy&ecirc;n nh&acirc;n do b&ecirc;n A hoặc b&ecirc;n chủ đầu tư th&igrave; thời gian thi c&ocirc;ng được gia hạn th&ecirc;m.</li>\n</ul>\n\n<p><strong><u>ĐIỀU </u></strong><strong><u>5</u></strong><strong><u>:</u></strong><strong> PHẠT CHẬM </strong><strong>TIẾN ĐỘ </strong><strong>V&Agrave;</strong> <strong>THANH TO&Aacute;N</strong></p>\n\n<ul>\n <li>Nếu một trong hai b&ecirc;n đơn phương huỷ bỏ hợp đồng đ&atilde; k&yacute; m&agrave; kh&ocirc;ng c&oacute; sự đồng &yacute; của cả 2 b&ecirc;n th&igrave; b&ecirc;n huỷ phải thanh to&aacute;n tiền phạt vi phạm hợp đồng cho ph&iacute;a b&ecirc;n kia với mức phạt l&agrave; 30% tổng gi&aacute; trị hợp đồng.</li>\n <li>B&ecirc;n B đảm bảo tiến độ thi c&ocirc;ng thực hiện hợp đồng đ&uacute;ng tiến độ. Chậm tiến độ thi c&ocirc;ng do lỗi của b&ecirc;n B (trừ trường hợp do bất khả kh&aacute;ng) th&igrave; b&ecirc;n B phải nộp phạt 5% gi&aacute; trị hợp đồng cho tuần chậm thi c&ocirc;ng đầu ti&ecirc;n, 0,2% gi&aacute; trị hợp đồng cho ng&agrave;y tiếp theo nhưng tổng số tiền phạt kh&ocirc;ng được vượt qu&aacute; 10%.</li>\n <li>B&ecirc;n B thi c&ocirc;ng chậm tiến độ do c&aacute;c nguy&ecirc;n nh&acirc;n của b&ecirc;n A như: chậm tạm ứng theo điều 3, chậm b&agrave;n giao mặt bằng, th&igrave; b&ecirc;n B sẽ được t&iacute;nh th&ecirc;m tương đương số ng&agrave;y chậm đ&oacute; v&agrave;o tiến độ thi c&ocirc;ng.</li>\n <li>Trong trường hợp B&ecirc;n A thanh to&aacute;n chậm so với điều 3 th&igrave; phải thanh to&aacute;n tiền phạt chậm thanh to&aacute;n cho B&ecirc;n B theo l&atilde;i suất tiền gửi của ng&acirc;n h&agrave;ng b&ecirc;n B l&agrave; NH NN&amp;PTNT.</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p><strong><u>ĐIỀU 6:</u></strong><strong> TR&Aacute;CH NHIỆM V&Agrave; QUYỀN LỢI</strong></p>\n\n<p><em>Tr&aacute;ch nhiệm của B&ecirc;n A. </em></p>\n\n<ul>\n <li>Chịu tr&aacute;ch nhiệm b&agrave;n giao mặt bằng, nguồn điện cho b&ecirc;n B thi c&ocirc;ng.</li>\n <li>Cử c&aacute;n bộ kỹ thuật hoặc c&aacute;n bộ đại diện xử l&yacute; c&aacute;c ph&aacute;t sinh (nếu c&oacute;) trong qu&aacute; tr&igrave;nh thi c&ocirc;ng cũng như x&aacute;c nhận kịp thời, cập nhật gi&aacute; trị ho&agrave;n th&agrave;nh cho b&ecirc;n B l&agrave;m cơ sở thanh to&aacute;n.</li>\n <li>Chịu tr&aacute;ch nhiệm thanh to&aacute;n theo đ&uacute;ng điều 3 của hợp đồng.</li>\n</ul>\n\n<p><em>Tr&aacute;ch nhiệm của B&ecirc;n B.</em></p>\n\n<ul>\n <li>Thi c&ocirc;ng theo đ&uacute;ng tiến độ, chất lượng.</li>\n <li>Chịu tr&aacute;ch nhiệm bồi thường thiệt hại 100% cho b&ecirc;n A hoặc b&ecirc;n thứ 3 (nếu c&oacute;) trong qu&aacute; tr&igrave;nh thi c&ocirc;ng. B&ecirc;n B sẽ kh&ocirc;ng chịu tr&aacute;ch nhiệm trong trường hợp kh&ocirc;ng phải do lỗi của b&ecirc;n B g&acirc;y ra.</li>\n <li>Chịu tr&aacute;ch nhiệm xuất ho&aacute; đơn VAT v&agrave; b&agrave;n giao c&ocirc;ng tr&igrave;nh cho b&ecirc;n A ngay khi b&ecirc;n A ho&agrave;n th&agrave;nh thanh to&aacute;n cho b&ecirc;n B theo điều 3 của hợp đồng n&agrave;y.</li>\n</ul>\n\n<p><strong><u>ĐIỀU 7:</u></strong><strong> ĐIỀU KHOẢN CHUNG, TRANH CHẤP TO&Agrave; &Aacute;N</strong></p>\n\n<ul>\n <li>Mọi tranh chấp li&ecirc;n quan ph&aacute;t sinh từ hợp đồng n&agrave;y, hai b&ecirc;n c&ugrave;ng đ&agrave;m ph&aacute;n tr&ecirc;n tinh thần hợp t&aacute;c v&agrave; c&ugrave;ng nhau giải quyết. Nếu đ&agrave;m ph&aacute;n kh&ocirc;ng đi đến thống nhất v&agrave; kh&ocirc;ng giải quyết được th&igrave; sẽ đưa ra To&agrave; &aacute;n kinh tế th&agrave;nh phố H&agrave; Nội để giải quyết. Kết luận cuối c&ugrave;ng của To&agrave; &aacute;n kinh tế l&agrave; cơ sở x&aacute;c định đ&uacute;ng sai. Chi ph&iacute; To&agrave; &aacute;n do b&ecirc;n thua chịu.</li>\n <li>Khi hợp đồng được k&yacute;, mọi thư t&iacute;n v&agrave; thoả thuận trước đ&acirc;y sẽ kh&ocirc;ng c&ograve;n hiệu lực.</li>\n <li>Hợp đồng&nbsp; c&oacute; hiệu lực từ ng&agrave;y k&yacute;. Bất kỳ sự sửa đổi n&agrave;o đối với hợp đồng n&agrave;y chỉ c&oacute; hiệu lực khi c&oacute; văn bản chấp thuận được k&yacute; bởi cả hai b&ecirc;n.</li>\n <li>Hai b&ecirc;n cam kết thực hiện nghi&ecirc;m t&uacute;c c&aacute;c điều khoản ghi trong hợp đồng. Nếu b&ecirc;n n&agrave;o vi phạm kh&ocirc;ng thực hiện đ&uacute;ng, b&ecirc;n đ&oacute; sẽ chịu ho&agrave;n to&agrave;n tr&aacute;ch nhiệm bồi thường c&aacute;c tổn thất do b&ecirc;n đ&oacute; g&acirc;y ra.</li>\n <li>Khi hai b&ecirc;n đ&atilde; ho&agrave;n th&agrave;nh đầy đủ nghĩa vụ v&agrave; tr&aacute;ch nhiệm của m&igrave;nh theo hợp đồng n&agrave;y th&igrave; hợp đồng hết hiệu lực v&agrave; tự thanh l&yacute;.</li>\n <li>Hợp đồng được lập th&agrave;nh 04 bản bằng tiếng Việt c&oacute; gi&aacute; trị ph&aacute;p l&yacute; như nhau, mỗi b&ecirc;n giữ 02 bản v&agrave; c&oacute; hiệu lực kể từ ng&agrave;y k&yacute;.</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<table>\n <tbody>\n  <tr>\n   <td>\n   <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ĐẠI DIỆN B&Ecirc;N A</strong></p>\n   </td>\n   <td>\n   <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ĐẠI DIỆN B&Ecirc;N B</strong></p>\n   </td>\n  </tr>\n </tbody>\n</table>\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_receivings`
--

CREATE TABLE IF NOT EXISTS `lifetek_receivings` (
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
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1249 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_receivings_inventory`
--

CREATE TABLE IF NOT EXISTS `lifetek_receivings_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_supplier` int(11) DEFAULT NULL,
  `id_city_code` int(11) DEFAULT NULL,
  `id_receiving` int(11) NOT NULL,
  `pay_amount` int(11) NOT NULL,
  `pay_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(1) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=638 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_receivings_items`
--

CREATE TABLE IF NOT EXISTS `lifetek_receivings_items` (
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
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_receivings_items_taxes`
--

CREATE TABLE IF NOT EXISTS `lifetek_receivings_items_taxes` (
  `receiving_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(115) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_receivings_payments`
--

CREATE TABLE IF NOT EXISTS `lifetek_receivings_payments` (
  `receiving_id` int(11) NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_receivings_tam`
--

CREATE TABLE IF NOT EXISTS `lifetek_receivings_tam` (
  `pays_type` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays_amount` int(11) NOT NULL,
  `id_receiving` int(11) NOT NULL,
  `date_tam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `employees_id` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1219 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_recv_cost_tkdu`
--

CREATE TABLE IF NOT EXISTS `lifetek_recv_cost_tkdu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cost` int(11) NOT NULL,
  `tkdu` int(11) NOT NULL,
  `money_no` decimal(15,0) NOT NULL,
  `money_co` decimal(15,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=552 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_register_log`
--

CREATE TABLE IF NOT EXISTS `lifetek_register_log` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_request_production_template`
--

CREATE TABLE IF NOT EXISTS `lifetek_request_production_template` (
  `id_request` int(11) NOT NULL AUTO_INCREMENT,
  `id_design_template` int(11) DEFAULT NULL,
  `number_request` float DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1: Đã tiếp nhận, 2: Chưa tiếp nhận',
  `command` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_request`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_resellers`
--

CREATE TABLE IF NOT EXISTS `lifetek_resellers` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `lifetek_resellers`
--

INSERT INTO `lifetek_resellers` (`id`, `title`, `en_title`, `description`, `en_description`, `full`, `en_full`, `images`, `url`) VALUES
(1, 'Công ty Viễn thông Viettel (Viettel Telecom)', 'english language', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>dess</p>\n', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>des</p>\n', '', 'cong-ty-vien-thong-viettel-(viettel-telecom)'),
(7, 's', 's', '<p>s</p>\n', '<p>s</p>\n', '<p>s</p>\n', '<p>s</p>\n', '', 's');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_resources`
--

CREATE TABLE IF NOT EXISTS `lifetek_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_salary`
--

CREATE TABLE IF NOT EXISTS `lifetek_salary` (
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
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_salarystatic`
--

CREATE TABLE IF NOT EXISTS `lifetek_salarystatic` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_salary_config`
--

CREATE TABLE IF NOT EXISTS `lifetek_salary_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lifetek_salary_config`
--

INSERT INTO `lifetek_salary_config` (`id`, `name`, `description`, `deleted`) VALUES
(1, 'nghỉ phép', 'nghỉ phép năm', 0),
(2, 'x', 'đi làm cả ngày\n', 0),
(3, 'x/2', 'làm nửa ngày\n', 0),
(4, 'xx', 'tăng ca', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_salary_option`
--

CREATE TABLE IF NOT EXISTS `lifetek_salary_option` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales` (
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
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3308 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_inventory`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) DEFAULT NULL,
  `id_city_code` int(11) DEFAULT NULL,
  `id_sale` int(11) NOT NULL,
  `pay_amount` int(11) NOT NULL,
  `pay_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=649 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_items`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_items` (
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
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_items_taxes`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_item_kits`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_item_kits` (
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
  KEY `item_kit_id` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_item_kits_taxes`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_item_kits_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_kit_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(15,0) NOT NULL,
  `cumulative` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_kit_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_kit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_materials`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL COMMENT 'mã đơn hàng để báo giá cho khách hàng',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'tên file',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='save file báo giá qua email' AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_packs`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_packs` (
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

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_payments`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_money` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stt` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`payment_type`,`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2214 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_payments12`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_payments12` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sales_tam`
--

CREATE TABLE IF NOT EXISTS `lifetek_sales_tam` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2173 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sale_cost_tkdu`
--

CREATE TABLE IF NOT EXISTS `lifetek_sale_cost_tkdu` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1655 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sessions`
--

CREATE TABLE IF NOT EXISTS `lifetek_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lifetek_sessions`
--

INSERT INTO `lifetek_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('054117644c45d9c684e2b698dac03483', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', 1452132175, 'a:4:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:8:"cartRecv";a:0:{}}'),
('075f6c696cc4ae51b64c6d7378eeb195', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088158, ''),
('098fe2c732830a55ecee6c57feacdd82', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088150, ''),
('1146ca457c331f60e94a61adfdb9b52f', '113.178.38.225', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', 1452130595, ''),
('172fd11c780c5c8e2d5a5ee0eab058aa', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088152, ''),
('1c5ec13058624b3983ae8cbc26a2c2d5', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072979, ''),
('23ccd6391f2262c56adc1fae1ca83cc5', '123.30.175.165', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452066520, ''),
('39faf675f41a8281071927557dcc4c59', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072981, ''),
('3bdeb98aa418d454f49e59844d266840', '123.30.175.163', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452098787, ''),
('41584d90770d1e3b4cef99f66a3fc6f8', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088117, ''),
('436e66fa40ab2d409d710a61ded6c206', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452102710, ''),
('456cfb2d6989082f33e3fac3ff4143ce', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', 1452132730, 'a:7:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:8:"cartRecv";a:0:{}s:14:"cartRecvImport";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;}'),
('4749229608112daee0469e4003ef55a9', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072966, ''),
('50349d4d1fcb3ae49ae500326cfabe67', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', 1452132166, ''),
('53da5f2e66693686e99a55c238c7c815', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088113, ''),
('56a98c0c81804a93d3f0ad60f5430821', '117.6.25.230', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/52.2.98 Chrome/46.2.2490.98 S', 1452087503, ''),
('606b8947c6db33ca2109f28d19a1608b', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', 1452055831, 'a:16:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:12:"load_account";s:1:"0";s:5:"store";s:4:"1999";s:39:"payment_types_tm32762016-01-06 14:01:38";a:1:{s:12:"payamount_tm";i:150000;}s:8:"ckbh3276";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:4:"cart";a:0:{}s:8:"customer";i:-1;s:9:"item_kits";s:3:"317";s:15:"design_template";s:3:"213";s:6:"number";i:6;s:18:"item_production_id";s:3:"198";s:11:"item_kit_id";s:3:"316";s:10:"start_date";s:10:"06-01-2016";s:8:"end_date";s:10:"07-01-2016";s:8:"cartRecv";a:0:{}}'),
('615d485f34c6bac086508c3e696e4548', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452102712, ''),
('62443b8b7f1c2334c9813b68dd24255d', '89.145.95.40', 'Mozilla/5.0 (compatible; GrapeshotCrawler/2.0; +http://www.grapeshot.co.uk/crawler.php)', 1452065042, ''),
('6573b61d3a6c80fae8cd871f15a1e5b1', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088115, ''),
('6a1d5694d96c6f7a16e39726fe891a2f', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452111797, ''),
('6ceeab0f22c51c610ca1fae6d7f2b5a6', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072975, ''),
('732761015cda5269aa930d4dc06a5718', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088111, ''),
('75da9206014d778bd1d54b8d049078ed', '66.249.77.94', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 1452117619, ''),
('76c69536659c38c6e5ccd0ab18fba8aa', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072972, ''),
('7c2ba9d93ecac8632a999c54f0e49952', '113.178.38.225', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', 1452130595, 'a:4:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:8:"cartRecv";a:0:{}}'),
('7ca9bd768326086cb53991694b9bd73a', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', 1452068728, 'a:16:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:12:"load_account";b:0;s:8:"ckbh3295";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:5:"store";s:4:"1999";s:8:"ckbh3297";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:17:"userInfo2460_3297";N;s:22:"payamount_ttn2460_3297";a:1:{s:13:"payamount_ttn";s:6:"330000";}s:39:"payment_types_tm33002016-01-06 16:53:05";a:1:{s:12:"payamount_tm";i:56000;}s:8:"ckbh3300";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:6:"unit_2";s:4:"unit";s:6:"unit_1";s:4:"unit";s:8:"ckbh3302";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:4:"cart";a:0:{}s:17:"userInfo2460_3302";N;s:22:"payamount_ttn2460_3302";a:1:{s:13:"payamount_ttn";s:6:"100000";}}'),
('84d7d4bb191b81f04e7cf6bf9a7a9a35', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088156, ''),
('8a47735b5e4e26193cc038312e1c8c30', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088127, ''),
('8c05fbfb7a5535ff399ca143b039b86f', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452102716, ''),
('8dfd5faf33e5414f708725fe7ffa1b44', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088123, ''),
('91bb94d3e1292e77e26a7b990e48c498', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452102706, ''),
('9846c899a512cbba4c9189b50d4ca838', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.6.2171.95 Safari/537.36', 1452056414, 'a:41:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:12:"load_account";s:1:"0";s:36:"payment_types_tm02016-01-06 13:56:45";a:1:{s:12:"payamount_tm";i:5700000;}s:5:"ckbh0";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:39:"payment_types_tm32812016-01-06 14:16:09";a:1:{s:12:"payamount_tm";i:9000000;}s:8:"ckbh3281";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:8:"ckbh3283";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:5:"store";s:4:"1999";s:8:"ckbh3286";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:17:"userInfo2471_3286";N;s:22:"payamount_ttn2471_3286";a:1:{s:13:"payamount_ttn";s:7:"5000000";}s:8:"ckbh3288";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:18:"userInfo2471_32883";N;s:23:"payamount_ttn2471_32883";a:1:{s:13:"payamount_ttn";s:8:"91000000";}s:8:"ckbh3289";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:8:"ckbh3290";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:17:"userInfo2471_3290";N;s:22:"payamount_ttn2471_3290";a:1:{s:13:"payamount_ttn";s:8:"10000000";}s:8:"ckbh3292";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:6:"unit_4";s:4:"unit";s:8:"ckbh3293";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:8:"ckbh3294";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:8:"cartRecv";a:1:{i:2;a:14:{s:7:"item_id";s:4:"4599";s:4:"line";i:2;s:4:"name";s:25:"Áo vest kẻ xanh size L";s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"1";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:1;s:9:"unit_rate";s:1:"0";s:14:"quantity_first";s:1:"0";s:8:"discount";i:0;s:5:"price";s:6:"200000";s:5:"taxes";i:0;s:4:"unit";s:1:"7";}}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:8:"ckbh3296";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:8:"ckbh3301";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:17:"userInfo2471_3301";N;s:22:"payamount_ttn2471_3301";a:1:{s:13:"payamount_ttn";s:7:"5000000";}s:8:"ckbh3303";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:17:"userInfo2471_3303";N;s:22:"payamount_ttn2471_3303";a:1:{s:13:"payamount_ttn";s:7:"4000000";}s:6:"unit_3";s:4:"unit";s:8:"ckbh3304";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:17:"userInfo2471_3304";N;s:22:"payamount_ttn2471_3304";a:1:{s:13:"payamount_ttn";s:9:"112000000";}s:6:"unit_2";s:4:"unit";s:6:"unit_1";s:4:"unit";s:8:"ckbh3305";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:4:"cart";a:0:{}}'),
('9b4a1b630d884768f420396c3c2c5220', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088146, ''),
('9c47564ab6201eaf388455d828ca5748', '123.30.175.159', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452066306, ''),
('9d2d1632255b7d653a65ab9e40037a3b', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452111793, ''),
('a77fc6030839f4ca469ae79037066c57', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', 1452132684, 'a:12:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"supplier";i:-1;s:8:"cartRecv";a:0:{}s:12:"load_account";b:0;s:8:"ckbh3306";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:8:"ckbh3307";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:6:"unit_1";s:4:"unit";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";i:-1;s:8:"payments";a:0:{}}'),
('b487eb27f8efcd47ab625c0670f6506d', '123.30.175.163', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452098789, ''),
('b736c9e3013abac1e84d9a81224b3689', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452111799, ''),
('b73ff509679cad7ce77b563d925cb307', '123.30.175.165', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452066518, ''),
('b87ad0ca1f4369509998f3b8075eacc7', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072970, ''),
('b9c0efc5707d5cdfa6cb3f07d64e9502', '89.145.95.40', 'Mozilla/5.0 (compatible; GrapeshotCrawler/2.0; +http://www.grapeshot.co.uk/crawler.php)', 1452064090, ''),
('ba73166ca3d825e5c1ce711d73802374', '1.55.139.55', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/52.2.98 Chrome/46.2.2490.98 S', 1452134385, ''),
('bbebd218a4a8a53a8df64ad7d39abae4', '117.6.25.230', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/52.2.98 Chrome/46.2.2490.98 S', 1452071326, 'a:14:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"info_item";s:4:"4598";s:8:"supplier";i:-1;s:12:"load_account";b:0;s:6:"unit_1";s:4:"unit";s:39:"payment_types_tm32982016-01-06 16:27:19";a:1:{s:12:"payamount_tm";i:100000;}s:8:"ckbh3298";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:5:"store";s:2:"25";s:39:"payment_types_tm32992016-01-06 16:46:31";a:1:{s:12:"payamount_tm";i:1000000;}s:8:"ckbh3299";a:1:{s:16:"chietkhaubanhang";s:0:"";}s:4:"cart";a:0:{}s:8:"customer";i:-1;}'),
('c514c57ba1f0321768b789a4cdbcc199', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072964, ''),
('c5cfbb8c1ab77a866e607780510a681f', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072962, ''),
('c8d6b930a66dc263777777a486c8fb28', '123.30.175.163', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452098785, ''),
('cd1f4aaceb3f88a65f787a70a9e79072', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088129, ''),
('d0fd6b08ce31cef918864ab6ad1e614c', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.6.2171.95 Safari/537.36', 1452136003, 'a:8:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:8:"cartRecv";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:12:"load_account";b:0;}'),
('d297de21ea7731a1bc08e781e19d7936', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.3; rv:43.0) Gecko/20100101 Firefox/43.0', 1452064488, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('db98b4d3ecb4db1ddaa4ef22eefe9df5', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452102708, ''),
('dff381137a8abdd1d3019d9650b4295b', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072968, ''),
('e112e4f88c95862d18e4733b467c3fd8', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088119, ''),
('e891c7d6d712f54e3edaeacd79a58c0a', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088121, ''),
('e9d0a37308141aa0b3f92fd5a04a87a9', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452072977, ''),
('ecccb7ca76cc13fa61c07afd2a60c41d', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088125, ''),
('eda34b5a629e509712dc4b39791ae19d', '123.30.175.162', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452111795, ''),
('ee91f1e27ffba6a937508c04572513ad', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088154, ''),
('f57e29cd5bcb9ccfabd12ac93c546445', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452102714, ''),
('fe4667a48f84950a6965fb2da8009c84', '123.30.175.158', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452127870, ''),
('fe8a50fc7d363d35b0bfa19c783881a4', '117.6.1.149', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', 1452131126, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('ff94ae476a0bce099a8aec0d43624eaf', '123.30.175.161', 'Mozilla/5.0 (compatible; coccoc/1.0; +http://help.coccoc.com/)', 1452088148, '');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_shop_guide`
--

CREATE TABLE IF NOT EXISTS `lifetek_shop_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_shoutbox`
--

CREATE TABLE IF NOT EXISTS `lifetek_shoutbox` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) NOT NULL DEFAULT 'anonimous',
  `user_id` int(25) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `status` enum('to do','completed') NOT NULL DEFAULT 'to do',
  `privacy` enum('public','private') NOT NULL DEFAULT 'public',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_slider`
--

CREATE TABLE IF NOT EXISTS `lifetek_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `img` varchar(150) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_sms`
--

CREATE TABLE IF NOT EXISTS `lifetek_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `number_char` int(11) NOT NULL,
  `number_message` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lifetek_sms`
--

INSERT INTO `lifetek_sms` (`id`, `title`, `message`, `number_char`, `number_message`, `deleted`) VALUES
(1, 'Chúc m?ng n?m m?i!', 'Chúc n?m m?i vui v? h?nh phúc.', 30, 1, 0),
(2, 'chúc m?ng sinh nh?t', 'chúc m?ng sinh nh?t công ty 15  tu?i. chúc công ty nhi?u may m?n', 64, 1, 0),
(3, 'h', 'l', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_solutions`
--

CREATE TABLE IF NOT EXISTS `lifetek_solutions` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `lifetek_solutions`
--

INSERT INTO `lifetek_solutions` (`id`, `title`, `en_title`, `description`, `en_description`, `full`, `en_full`, `images`, `url`) VALUES
(1, 'Giải pháp Video Conference cho doanh nghiệp lớn và nhà cung cấp dịch vụ', 'title', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>dess</p>\n', '<p>Giải ph&aacute;p Video Conference cho doanh nghiệp lớn v&agrave; nh&agrave; cung cấp dịch vụ</p>\n', '<p>full</p>\n', '', 'giai-phap-video-conference-cho-doanh-nghiep-lon-va-nha-cung-cap-dich-vu'),
(11, 'gẻgergerg', 'g?gergerg', '<p>gẻgerger</p>\n', '<p>g?gregerger</p>\n', '<p>gregergeg</p>\n', '<p>g?gergreeg</p>\n', '', 'gegergerg');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_super_admin`
--

CREATE TABLE IF NOT EXISTS `lifetek_super_admin` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lifetek_super_admin`
--

INSERT INTO `lifetek_super_admin` (`id`, `username`, `password`, `active`, `created`, `authentication`, `fullname`, `email`, `display_name`) VALUES
(1, 'lifetek2014', '25d55ad283aa400af464c76d713c07ad', 0, '2013-12-01 16:08:04', 'lifetek@2014', 'Hoàng Tiến Hưng', 'hunght1188@fmail.com', 'super admin');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_suppliers`
--

CREATE TABLE IF NOT EXISTS `lifetek_suppliers` (
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
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_support`
--

CREATE TABLE IF NOT EXISTS `lifetek_support` (
  `id_support` int(11) NOT NULL AUTO_INCREMENT,
  `name_support` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yahoo` varchar(255) NOT NULL,
  `skype` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  PRIMARY KEY (`id_support`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `lifetek_support`
--

INSERT INTO `lifetek_support` (`id_support`, `name_support`, `yahoo`, `skype`, `phone`) VALUES
(1, 'Hỗ trợ bán hàng', 'dungchip', 'chip88', 1698719069);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_bo_tt`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_bo_tt` (
  `boid` int(20) NOT NULL AUTO_INCREMENT,
  `ten_bo` varchar(200) NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '0',
  `id_nhomtt` varchar(500) NOT NULL,
  PRIMARY KEY (`boid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_giatri_tt`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_giatri_tt` (
  `idgiatri` int(20) NOT NULL AUTO_INCREMENT,
  `ma_tt` varchar(50) NOT NULL,
  `giatri` text NOT NULL,
  PRIMARY KEY (`idgiatri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_nhacungcap`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_nhacungcap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_cate` int(11) DEFAULT NULL,
  `ten_ncc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `anh` varchar(255) CHARACTER SET utf8 NOT NULL,
  `link` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_nhom_ncc`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_nhom_ncc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_nhom_tt`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_nhom_tt` (
  `nhomid` int(20) NOT NULL AUTO_INCREMENT,
  `ten_nhom` varchar(200) NOT NULL,
  `ten_ht` varchar(200) NOT NULL,
  `thutu` int(5) NOT NULL,
  `trangthai` tinyint(1) NOT NULL DEFAULT '0',
  `id_tt` varchar(500) NOT NULL,
  PRIMARY KEY (`nhomid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_product`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_product` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_product_images`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_product_images` (
  `link` varchar(255) NOT NULL,
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(20) NOT NULL,
  `anh_con` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_sanpham_tt`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_sanpham_tt` (
  `ma_tt` varchar(200) NOT NULL,
  `item_id` int(20) NOT NULL,
  `giatri` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_s_thuoctinh`
--

CREATE TABLE IF NOT EXISTS `lifetek_s_thuoctinh` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_templates_contract`
--

CREATE TABLE IF NOT EXISTS `lifetek_templates_contract` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_timekeeping`
--

CREATE TABLE IF NOT EXISTS `lifetek_timekeeping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `salaryconfig_id` int(11) NOT NULL,
  `day_keeping` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `salaryconfig_id` (`salaryconfig_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_tinhoc`
--

CREATE TABLE IF NOT EXISTS `lifetek_tinhoc` (
  `id_tinhoc` int(11) NOT NULL AUTO_INCREMENT,
  `chungchi_tinhoc` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tinhoc`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_tkdu`
--

CREATE TABLE IF NOT EXISTS `lifetek_tkdu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acc_cat_id` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `du_no` decimal(15,0) NOT NULL,
  `du_co` decimal(15,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55334 ;

--
-- Dumping data for table `lifetek_tkdu`
--

INSERT INTO `lifetek_tkdu` (`id`, `name`, `acc_cat_id`, `id_parent`, `level`, `comment`, `du_no`, `du_co`) VALUES
(111, 'Tiền mặt', 7, 0, 1, '', '0', '0'),
(112, 'Tiền gửi ngân hàng', 0, 0, 1, '', '0', '300000'),
(121, 'Đầu tư chứng khoán ngắn hạn', 0, 0, 1, '', '0', '0'),
(131, 'Phải thu khách hàng', 0, 0, 1, '', '0', '0'),
(133, 'Thuế GTGT được khấu trừ', 0, 0, 1, '', '0', '0'),
(138, 'Phải thu khác', 0, 0, 1, '', '0', '0'),
(141, 'Tạm ứng', 0, 0, 1, '', '0', '0'),
(142, 'Chi phí trả trước', 17, 0, 1, '', '0', '0'),
(152, 'Nguyên liệu, vật liệu', 0, 0, 1, '', '0', '0'),
(153, 'Công cụ, dụng cụ', 18, 0, 1, '', '0', '0'),
(154, 'Chi phí sản xuất, kinh doanh dở dang', 0, 0, 1, '', '0', '0'),
(155, 'Thành phẩm', 18, 0, 1, '', '0', '0'),
(156, 'Hàng hoá', 18, 0, 1, '', '0', '0'),
(157, 'Hàng gửi đi bán', 0, 0, 1, '', '0', '0'),
(159, 'Các khoản dự phòng', 9, 0, 1, '', '0', '0'),
(171, 'Giao dịch mua bán trái phiếu của Chính Phủ', 0, 0, 1, '', '0', '0'),
(211, 'Tài sản  cố định', 0, 0, 1, '', '0', '0'),
(214, 'Hao mòn TSCĐ', 0, 0, 1, '', '0', '0'),
(217, 'Bất động sản đầu tư', 0, 0, 1, '', '0', '0'),
(221, 'Đầu tư vào công ty con', 0, 0, 1, '', '0', '0'),
(229, 'Dự phòng giảm giá đầu tư dài hạn', 0, 0, 1, '', '0', '0'),
(241, 'Xây dựng cơ bản', 0, 0, 1, '', '0', '0'),
(242, 'Chi phí trả trước dài hạn', 17, 0, 1, '', '0', '0'),
(244, 'Ký quỹ, ký cược dài hạn', 0, 0, 1, '', '0', '0'),
(311, 'Vay ngắn hạn', 0, 0, 1, '', '0', '0'),
(315, 'Nợ dài hạn đến hạn trả', 0, 0, 1, '', '0', '0'),
(331, 'Phải trả cho người bán', 0, 0, 1, '', '0', '0'),
(333, 'Thuế và các khoản phải nộp Nhà nước', 0, 0, 1, '', '0', '0'),
(334, 'Phải trả người lao động', 0, 0, 1, '', '0', '0'),
(335, 'Chi phí phải trả', 10, 0, 1, '', '0', '0'),
(338, 'Phải trả, phải nộp khác', 0, 0, 1, '', '0', '0'),
(341, 'Vay, nợ dài hạn', 10, 0, 1, '', '0', '0'),
(351, 'Quỹ dự phòng trợ cấp mất việc làm', 8, 0, 1, '', '0', '0'),
(352, 'Dự phòng phải trả', 0, 0, 1, '', '0', '0'),
(353, 'Quỹ khen thưởng phúc lợi', 8, 0, 1, '', '0', '0'),
(356, 'Quỹ phát triển khoa học và công nghệ', 0, 0, 1, '', '0', '0'),
(411, 'Nguồn vốn kinh doanh', 0, 0, 1, '', '300000', '0'),
(413, 'Chênh lệch tỷ giá', 0, 0, 1, '', '0', '0'),
(418, 'Các quỹ khác thuộc vốn chủ sở hữu', 0, 0, 1, '', '0', '0'),
(419, 'Cổ phiếu quỹ', 0, 0, 1, '', '0', '0'),
(421, 'Lợi nhuận chưa phân phối', 0, 0, 1, '', '0', '0'),
(511, 'Doanh thu HH & cung cấp DV', 0, 0, 1, '', '0', '0'),
(515, 'Doanh thu hoạt động tài chính', 0, 0, 1, '', '0', '0'),
(521, 'Các khoản giảm trừ doanh thu', 0, 0, 1, '', '0', '0'),
(611, 'Mua hàng', 0, 0, 1, '', '0', '0'),
(631, 'Giá thành sản xuất ', 0, 0, 1, '', '0', '0'),
(632, 'Giá vốn hàng bán', 0, 0, 1, '', '0', '0'),
(635, 'Chi phí tài chính', 0, 0, 1, '', '0', '0'),
(642, 'Chi phí quản lý DN', 16, 0, 1, '', '0', '0'),
(711, 'Thu nhập khác', 15, 0, 1, '', '0', '0'),
(811, 'Chi phí khác', 16, 0, 1, '', '0', '0'),
(821, 'Chi phí thuế thu nhập doanh nghiệp', 0, 0, 1, '', '0', '0'),
(911, 'Xác định kết quả kinh doanh', 0, 0, 1, '', '0', '0'),
(1111, 'Tiền mặt Việt Nam', 0, 111, 0, '', '0', '0'),
(1112, 'Ngoại tệ', 0, 111, 0, '', '0', '0'),
(1113, 'Vàng, bạc, kim khí quý, đá quý', 0, 111, 0, '', '0', '0'),
(1121, 'Tiền Việt Nam', 0, 112, 0, '', '0', '300000'),
(1122, 'Ngoại tệ', 0, 112, 0, '', '0', '0'),
(1123, 'Vàng, bạc, kim khí quý, đá quý', 0, 112, 0, '', '0', '0'),
(1331, 'Thuế GTGT được khấu trừ HH, DV', 0, 133, 0, '', '0', '0'),
(1332, 'Thuế GTGT được khấu trừ của TSCĐ', 0, 133, 0, '', '0', '0'),
(1381, 'Tài sản thiếu chờ xử lý', 0, 138, 0, '', '0', '0'),
(1388, 'Phải thu khác', 0, 138, 0, '', '0', '0'),
(1591, 'Dự phòng giảm giá đầu tư tài chính ngắn hạn', 9, 159, 2, '', '0', '0'),
(1592, 'Dự phòng phải thu khó đòi', 0, 159, 2, '', '0', '0'),
(1593, 'Dự phòng giảm giá hàng tồn kho', 9, 159, 2, '', '0', '0'),
(2111, 'Tài sản cố định hữu hình', 9, 211, 2, '', '0', '0'),
(2112, 'TSCĐ thuê tài chính', 0, 211, 2, '', '0', '0'),
(2113, 'TSCĐ vô hình', 0, 211, 2, '', '0', '0'),
(2141, 'Hao mòn TSCĐ hữu hình', 0, 214, 0, '', '0', '0'),
(2142, 'Hao mòn TSCĐ thuê tài chính', 0, 214, 0, '', '0', '0'),
(2143, 'Hao mòn TSCĐ vô hình', 0, 214, 0, '', '0', '0'),
(2147, 'Hao mòn bất động sản đầu tư', 0, 214, 2, '', '0', '0'),
(2212, 'Vốn góp liên doanh', 0, 221, 2, '', '0', '0'),
(2213, 'Đầu tư vào công ty liên kết', 0, 221, 2, '', '0', '0'),
(2218, 'Đầu tư tài chính dài hạn khác', 0, 221, 2, '', '0', '0'),
(2411, 'Mua sắm TSCĐ', 0, 241, 0, '', '0', '0'),
(2412, 'Xây dựng cơ bản', 0, 241, 0, '', '0', '0'),
(2413, 'Sửa chữa lớn TSCĐ', 0, 241, 0, '', '0', '0'),
(3331, 'Thuế GTGT đầu ra phải nộp', 10, 333, 2, '', '0', '0'),
(3332, 'Thuế tiêu thu đặc biệt', 0, 333, 0, '', '0', '0'),
(3333, 'Thuế xuất, nhập khẩu', 0, 333, 0, '', '0', '0'),
(3334, 'Thuế thu nhập doanh nghiệp', 0, 333, 0, '', '0', '0'),
(3335, 'Thuế thu nhập cá nhân', 0, 333, 0, '', '0', '0'),
(3336, 'Thuế tài nguyên', 0, 333, 0, '', '0', '0'),
(3337, 'Thuế nhà đất, tiền thuê đất', 0, 333, 0, '', '0', '0'),
(3338, 'Các loại thuế khác', 0, 333, 0, '', '0', '0'),
(3339, 'Phí, lệ phí và các khoản phải nộp khác', 0, 333, 0, '', '0', '0'),
(3381, 'Tài sản thừa chờ giải quyết', 0, 338, 0, '', '0', '0'),
(3382, 'Kinh phí công đoàn', 0, 338, 0, '', '0', '0'),
(3383, 'Bảo hiểm xã hội', 10, 338, 2, '', '0', '0'),
(3384, 'Bảo hiểm y tế', 10, 338, 2, '', '0', '0'),
(3386, 'Nhận ký qũi, ký cược ngắn hạn', 0, 338, 0, '', '0', '0'),
(3387, 'Doanh thu chưa thực hiện', 0, 338, 0, '', '0', '0'),
(3388, 'Phải trả, phải nộp khác', 0, 338, 0, '', '0', '0'),
(3389, 'Bảo hiểm thất nghiệp', 10, 338, 2, '', '0', '0'),
(3411, 'Vay dài hạn', 0, 341, 2, '', '0', '0'),
(3412, 'Nợ dài hạn', 0, 341, 2, '', '0', '0'),
(3413, 'Trái phiếu phát hành', 0, 341, 2, '', '0', '0'),
(3414, 'Nhật ký quỹ, ký cược dài hạn', 0, 341, 2, '', '0', '0'),
(3531, 'Quỹ khen thưởng', 8, 353, 2, '', '0', '0'),
(3532, 'Quỹ phúc lợi', 0, 353, 2, '', '0', '0'),
(3533, 'Quỹ phúc lợi đã hình thành TSCĐ', 0, 353, 2, '', '0', '0'),
(3534, 'Quỹ thưởng ban QL điều hành công ty', 0, 353, 2, '', '0', '0'),
(3561, 'Quỹ phát triển khoa học và công nghệ', 0, 356, 2, '', '0', '0'),
(3562, 'Quỹ phát triển khoa học và công nghệ đã hình thành', 0, 356, 2, '', '0', '0'),
(4111, 'Vốn đầu tư của chủ sở hữu', 0, 411, 0, '', '300000', '0'),
(4112, 'Thặng dư vốn cổ phần', 0, 411, 0, '', '0', '0'),
(4118, 'Vốn khác', 0, 411, 2, '', '0', '0'),
(4211, 'Lợi nhuận chưa phân phối năm trước', 0, 421, 0, '', '0', '0'),
(4212, 'Lợi nhuận chưa phân phối năm nay', 0, 421, 0, '', '0', '0'),
(5111, 'Doanh thu bán hàng hóa', 15, 511, 2, '', '0', '0'),
(5112, 'Doanh thu bán các thành phẩm', 15, 511, 2, '', '0', '0'),
(5113, 'Doanh thu cung cấp dịch vụ', 0, 511, 0, '', '0', '0'),
(5118, 'Doanh thu khác', 0, 511, 2, '', '0', '0'),
(5211, 'Chiết khấu thương mại', 0, 521, 2, '', '0', '0'),
(5212, 'Hàng bán bị trả lại', 0, 521, 2, '', '0', '0'),
(5213, 'Giảm giá hàng bán', 0, 521, 2, '', '0', '0'),
(6411, 'Chi phí nhân viên', 0, 641, 0, '', '0', '0'),
(6421, 'Chi phí bán hàng', 16, 642, 2, '', '0', '0'),
(6422, 'Chi phí quản lý doanh nghiệp', 16, 642, 2, '', '0', '0'),
(11211, 'VIB', 6, 1121, 1, '', '0', '100000'),
(11212, 'Agribank', 6, 1121, 1, '', '0', '200000'),
(11213, 'Vietcombank', 0, 1121, 1, '', '0', '0'),
(21111, 'Nhà cửa, vật kiến trúc', 0, 2111, 3, '', '0', '0'),
(21112, 'Máy móc, thiết bị', 0, 2111, 3, '', '0', '0'),
(21113, 'Phương tiện vận tải, truyền dẫn', 0, 2111, 3, '', '0', '0'),
(21114, 'Thiết bị, dụng cụ quản lý', 0, 2111, 3, '', '0', '0'),
(21115, 'Cây lâu năm, súc vật làm việc và cho SP', 0, 2111, 3, '', '0', '0'),
(21118, 'TSCĐ khác', 0, 2111, 3, '', '0', '0'),
(21131, 'Quyền sử dụng đất', 9, 2113, 3, '', '0', '0'),
(21132, 'Quyền phát hành', 0, 2113, 3, '', '0', '0'),
(21133, 'Bản quyền, bằng sáng tạo', 9, 2113, 3, '', '0', '0'),
(21134, 'Nhãn hiệu hàng hóa', 0, 2113, 3, '', '0', '0'),
(21135, 'Phần mềm máy vi tính', 0, 2113, 3, '', '0', '0'),
(21136, 'Giấy phép và giấp phép nhượng quyền', 0, 2113, 3, '', '0', '0'),
(21138, 'TSCĐ vô hình khác', 0, 2113, 3, '', '0', '0'),
(33311, 'Thuế GTGT đầu ra', 0, 3331, 3, '', '0', '0'),
(33312, 'Thuế GTGT hàng nhập khẩu', 0, 3331, 3, '', '0', '0'),
(34131, 'Mệnh giá trái phiếu', 0, 3413, 2, '', '0', '0'),
(34132, 'Chiết khấu trái phiếu', 0, 3413, 2, '', '0', '0'),
(34133, 'Phụ trội trái phiếu', 8, 3413, 3, '', '0', '0'),
(55333, 'Nợ bản quyền', 3, 2133, 2, '', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_transfer_stores`
--

CREATE TABLE IF NOT EXISTS `lifetek_transfer_stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stt` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='lịch sử chuyển kho' AUTO_INCREMENT=77 ;

--
-- Dumping data for table `lifetek_transfer_stores`
--

INSERT INTO `lifetek_transfer_stores` (`id`, `warehouse_id`, `store_id`, `item_id`, `quantity`, `stt`, `date`) VALUES
(1, 2, 0, 4107, 99, 0, '2015-07-30 17:31:40'),
(2, 3, 0, 4108, 100, 0, '2015-07-31 16:30:41'),
(3, 3, 0, 4108, 100, 0, '2015-08-01 14:06:29'),
(4, 2, 0, 4121, 1, 0, '2015-08-04 10:47:09'),
(5, 2, 0, 4123, 1, 0, '2015-08-04 11:06:14'),
(6, 2, 0, 4124, 0, 0, '2015-08-04 11:10:00'),
(7, 3, 0, 4121, 1, 0, '2015-08-04 14:08:50'),
(8, 5, 0, 4125, 10, 0, '2015-08-05 09:51:05'),
(9, 0, 5, 4125, 7, 0, '2015-08-05 09:54:31'),
(10, 0, 5, 4125, 1, 0, '2015-08-05 10:13:01'),
(11, 6, 0, 4120, 5, 0, '2015-08-07 10:59:33'),
(12, 7, 0, 4120, 9, 0, '2015-08-07 11:04:42'),
(13, 8, 0, 4120, 5, 0, '2015-08-07 11:27:24'),
(14, 10, 0, 4143, 5, 0, '2015-08-08 10:11:40'),
(15, 6, 0, 4112, 81, 0, '2015-08-13 10:11:46'),
(16, 3, 0, 4118, 6, 0, '2015-08-13 11:37:24'),
(17, 6, 0, 4107, 1, 0, '2015-08-13 16:06:16'),
(18, 3, 0, 4159, 50, 0, '2015-08-14 09:59:07'),
(19, 3, 0, 4158, 5, 0, '2015-08-14 09:59:07'),
(20, 3, 0, 4199, 50, 0, '2015-08-14 10:39:07'),
(21, 2, 0, 4196, 3, 0, '2015-08-19 13:42:54'),
(22, 3, 0, 4216, 50, 0, '2015-08-20 14:50:06'),
(23, 3, 0, 4220, 999, 0, '2015-08-20 16:37:51'),
(24, 3, 0, 4230, 10, 0, '2015-08-24 13:59:29'),
(25, 3, 0, 4218, 10, 0, '2015-08-27 14:45:11'),
(26, 3, 0, 4282, 122, 0, '2015-09-03 09:58:58'),
(27, 3, 0, 4277, 117, 0, '2015-09-03 09:58:59'),
(28, 3, 0, 4278, 68, 0, '2015-09-03 09:58:59'),
(29, 3, 0, 4279, 48, 0, '2015-09-03 09:58:59'),
(30, 3, 0, 4280, 6, 0, '2015-09-03 09:58:59'),
(31, 3, 0, 4281, 13, 0, '2015-09-03 09:58:59'),
(32, 8, 0, 4288, 0, 0, '2015-09-04 10:43:26'),
(33, 8, 0, 4288, 10, 0, '2015-09-04 10:43:55'),
(34, 3, 0, 4293, 1000, 0, '2015-09-04 11:27:19'),
(35, 3, 0, 4294, 1000, 0, '2015-09-04 11:27:19'),
(36, 3, 0, 4291, 160, 0, '2015-09-04 11:27:19'),
(37, 3, 0, 4290, 150, 0, '2015-09-04 11:27:19'),
(38, 3, 0, 4289, 150, 0, '2015-09-04 11:27:19'),
(39, 3, 0, 4292, 1000, 0, '2015-09-04 11:27:19'),
(40, 3, 0, 4292, 10002, 0, '2015-09-04 11:58:53'),
(41, 5, 0, 4288, 0, 0, '2015-09-04 13:48:54'),
(42, 8, 0, 4288, 0, 0, '2015-09-04 13:58:47'),
(43, 14, 0, 4166, 1, 0, '2015-10-06 10:20:21'),
(44, 0, 2, 4385, 5, 0, '2015-10-26 15:03:24'),
(45, 15, 0, 4179, 1, 0, '2015-10-26 22:00:03'),
(46, 10, 0, 4166, 1, 0, '2015-10-26 22:00:51'),
(47, 14, 0, 4379, 1, 0, '2015-10-27 13:37:57'),
(48, 15, 0, 4367, 1, 0, '2015-11-11 13:37:03'),
(49, 15, 0, 4227, 1, 0, '2015-11-12 08:55:52'),
(50, 22, 0, 4193, 1, 0, '2015-11-12 14:28:32'),
(51, 3, 0, 4475, 1, 0, '2015-11-18 13:58:45'),
(52, 3, 0, 4488, 0, 0, '2015-11-19 09:03:17'),
(53, 22, 0, 4159, 1, 0, '2015-12-15 11:49:32'),
(54, 4, 0, 4329, 1, 0, '2015-12-16 16:49:55'),
(55, 4, 0, 4330, 1, 0, '2015-12-16 16:50:12'),
(56, 8, 0, 4329, 2, 0, '2015-12-16 16:55:46'),
(57, 4, 0, 4329, 1, 0, '2015-12-16 16:58:20'),
(58, 8, 0, 4520, 1, 0, '2015-12-18 12:21:00'),
(59, 15, 0, 4198, 0, 0, '2015-12-18 12:22:43'),
(60, 15, 0, 4198, 1, 0, '2015-12-18 12:24:48'),
(61, 15, 0, 4222, 1, 0, '2015-12-19 09:50:35'),
(62, 15, 0, 4227, 0, 0, '2015-12-19 09:50:35'),
(63, 15, 0, 4228, 2, 0, '2015-12-19 09:55:07'),
(64, 15, 0, 4299, 1, 0, '2015-12-19 09:57:20'),
(65, 15, 0, 4537, 20, 0, '2015-12-19 10:02:13'),
(66, 25, 0, 4329, 1, 0, '2015-12-21 11:42:02'),
(67, 9, 0, 4328, 120, 0, '2015-12-22 14:28:20'),
(68, 25, 0, 4178, 7, 0, '2015-12-22 14:33:48'),
(69, 9, 0, 4541, 8, 0, '2015-12-22 15:15:32'),
(70, 25, 0, 4534, 1, 0, '2015-12-24 14:16:42'),
(71, 15, 0, 4447, 0, 0, '2015-12-25 10:33:01'),
(72, 15, 0, 4447, 10, 0, '2015-12-25 10:33:45'),
(73, 3, 0, 4551, 0, 0, '2015-12-26 12:16:53'),
(74, 3, 0, 4552, 0, 0, '2015-12-26 12:16:53'),
(75, 3, 0, 4595, 10, 0, '2016-01-06 14:44:07'),
(76, 3, 0, 4596, 10, 0, '2016-01-06 14:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_units`
--

CREATE TABLE IF NOT EXISTS `lifetek_units` (
  `id_unit` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delete` int(1) NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_users`
--

CREATE TABLE IF NOT EXISTS `lifetek_users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `lifetek_users`
--

INSERT INTO `lifetek_users` (`id`, `username`, `password`, `email`, `active`, `group`, `activation_key`, `last_visit`, `created`, `modified`) VALUES
(1, 'admin102', 'c110cb67c8edc55d8eb4e48cd6493784d8988f38', 'hoanghung888@gmail.com', 1, 2, NULL, '2012-04-20 09:29:19', '2012-03-25 08:09:10', NULL),
(10, 'admin', 'c110cb67c8edc55d8eb4e48cd6493784d8988f38', 'hunght1188@gmail.com', 1, 2, NULL, '2014-03-19 09:49:13', '2012-12-27 11:43:21', '2013-11-23 02:39:38'),
(11, 'nhanvien', 'c110cb67c8edc55d8eb4e48cd6493784d8988f38', 'nhanvien@gmail.com', 1, 7, NULL, NULL, '2013-11-25 02:56:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_user_profiles`
--

CREATE TABLE IF NOT EXISTS `lifetek_user_profiles` (
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_vendors`
--

CREATE TABLE IF NOT EXISTS `lifetek_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(200) NOT NULL,
  `link` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lifetek_vendors`
--

INSERT INTO `lifetek_vendors` (`id`, `images`, `link`) VALUES
(1, '', 'http://www.24h.com.vn/'),
(2, '', 'a'),
(3, '', 'www.zingme.vn'),
(4, '', 'www.vietbao.combbnb');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_visa`
--

CREATE TABLE IF NOT EXISTS `lifetek_visa` (
  `id_visa` int(11) NOT NULL AUTO_INCREMENT,
  `name_visa` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_visa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lifetek_visa`
--

INSERT INTO `lifetek_visa` (`id_visa`, `name_visa`, `deleted`) VALUES
(1, 'Việt Nam', 0),
(2, 'Mỹ', 0),
(3, 'Thái lan', 0),
(4, 'Anh', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_votes`
--

CREATE TABLE IF NOT EXISTS `lifetek_votes` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `voted_on` datetime NOT NULL,
  `ip` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_warehouse_items`
--

CREATE TABLE IF NOT EXISTS `lifetek_warehouse_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) NOT NULL COMMENT 'mã bảng kho/khonhang',
  `store_id` int(11) NOT NULL COMMENT 'kho chuyen',
  `item_id` int(11) NOT NULL COMMENT 'mã sản phẩm or nguyên vật liệu',
  `quantity` double(20,2) NOT NULL COMMENT 'số lượng ',
  `stt` int(11) NOT NULL COMMENT 'trạng thái',
  `date` datetime NOT NULL COMMENT 'thời gian chuyển , nhận',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='số lượng lưu trữ của từng kho' AUTO_INCREMENT=339 ;

--
-- Dumping data for table `lifetek_warehouse_items`
--

INSERT INTO `lifetek_warehouse_items` (`id`, `warehouse_id`, `store_id`, `item_id`, `quantity`, `stt`, `date`) VALUES
(1, 2, 0, 4107, 90.00, 0, '2015-07-30 17:31:40'),
(2, 3, 0, 4110, 984.10, 1, '2015-07-31 09:37:23'),
(3, 3, 0, 4111, 887.00, 1, '2015-07-31 09:37:23'),
(5, 3, 0, 4108, 199.00, 0, '2015-08-01 14:06:29'),
(6, 5, 0, 4120, 10.00, 1, '2015-08-04 10:21:50'),
(8, 2, 0, 4121, 1.00, 0, '2015-08-04 10:47:09'),
(9, 2, 0, 4123, 1.00, 0, '2015-08-04 11:06:14'),
(10, 2, 0, 4124, 0.03, 0, '2015-08-04 11:10:00'),
(11, 3, 0, 4121, 1.00, 0, '2015-08-04 14:08:50'),
(12, 2, 0, 4126, 999.00, 1, '2015-08-05 09:20:19'),
(13, 5, 0, 4125, 9.00, 1, '2015-08-05 10:15:50'),
(15, 6, 0, 4120, 6.00, 1, '2015-08-13 16:23:07'),
(16, 7, 0, 4120, 9.00, 0, '2015-08-07 11:04:42'),
(17, 8, 0, 4120, 5.00, 0, '2015-08-07 11:27:24'),
(18, 2, 0, 4139, 10.00, 0, '2015-08-08 09:43:28'),
(19, 2, 0, 4140, 10.00, 0, '2015-08-08 09:43:28'),
(20, 2, 0, 4141, 10.00, 0, '2015-08-08 09:43:28'),
(21, 2, 0, 4142, 101.00, 0, '2015-08-08 09:43:28'),
(22, 2, 0, 4143, 10.00, 0, '2015-08-08 09:43:28'),
(23, 2, 0, 4144, 10.00, 0, '2015-08-08 09:43:28'),
(24, 2, 0, 4145, 101.00, 0, '2015-08-08 09:43:28'),
(25, 2, 0, 4146, 99.00, 0, '2015-08-08 09:43:28'),
(26, 2, 0, 4147, 88.00, 0, '2015-08-08 09:43:28'),
(27, 10, 0, 4143, 3.00, 0, '2015-08-08 10:11:40'),
(29, 8, 0, 4148, 110.00, 1, '2015-08-12 14:28:52'),
(30, 6, 0, 4151, 20.00, 0, '2015-08-13 09:53:01'),
(31, 6, 0, 4112, 80.90, 0, '2015-08-13 10:11:46'),
(32, 3, 0, 4118, 6.00, 0, '2015-08-13 11:37:24'),
(33, 6, 0, 4155, 20.00, 0, '2015-08-13 16:01:25'),
(34, 6, 0, 4107, 1.00, 0, '2015-08-13 16:06:16'),
(35, 6, 0, 4153, 1.00, 1, '2015-08-13 16:23:07'),
(36, 3, 0, 4159, 298.00, 1, '2015-10-19 14:01:15'),
(37, 3, 0, 4158, 1087.00, 1, '2015-09-04 11:45:31'),
(38, 6, 0, 4158, 63.00, 1, '2015-08-14 10:23:56'),
(39, 3, 0, 4199, 8.46, 0, '2015-08-14 10:39:07'),
(40, 3, 0, 4200, 10.68, 1, '2015-10-06 15:52:30'),
(41, 3, 0, 4172, 0.00, 1, '2015-08-14 11:14:47'),
(42, 6, 0, 4206, 20.00, 0, '2015-08-15 11:23:31'),
(43, 2, 0, 4196, 0.00, 0, '2015-08-19 13:42:54'),
(44, 3, 0, 4216, 1000.00, 1, '2015-08-28 16:39:39'),
(45, 3, 0, 4220, 999.00, 0, '2015-08-20 16:37:51'),
(52, 3, 0, 4230, 10.00, 0, '2015-08-24 13:59:29'),
(54, 3, 0, 4232, 10.00, 1, '2015-08-25 10:20:22'),
(63, 3, 0, 4218, 110.00, 1, '2015-10-13 14:39:56'),
(78, 5, 0, 4254, 7.00, 1, '2015-08-31 11:11:44'),
(79, 10, 0, 4159, 10.00, 1, '2015-08-31 12:10:08'),
(80, 3, 0, 4255, 2009.00, 1, '2015-08-31 17:29:16'),
(81, 3, 0, 4256, 2010.00, 1, '2015-08-31 17:29:16'),
(82, 4, 0, 4257, 2.00, 0, '2015-09-01 10:56:21'),
(83, 4, 0, 4258, 3.00, 0, '2015-09-01 10:56:21'),
(84, 4, 0, 4259, 3.00, 0, '2015-09-01 10:56:21'),
(85, 4, 0, 4260, 20.00, 0, '2015-09-01 11:03:59'),
(86, 4, 0, 4261, 30.00, 0, '2015-09-01 11:03:59'),
(87, 4, 0, 4262, 10.00, 0, '2015-09-01 11:03:59'),
(88, 4, 0, 4263, 8.00, 0, '2015-09-01 11:35:52'),
(89, 4, 0, 4264, 79.00, 0, '2015-09-01 11:35:52'),
(90, 4, 0, 4268, 20.00, 0, '2015-09-01 15:39:05'),
(91, 4, 0, 4269, 10.00, 0, '2015-09-01 15:39:05'),
(92, 4, 0, 4270, 10.00, 0, '2015-09-01 15:39:06'),
(93, 4, 0, 4271, 10.00, 0, '2015-09-01 17:07:48'),
(94, 4, 0, 4274, 10.00, 0, '2015-09-01 17:07:48'),
(95, 3, 0, 4282, 129.00, 1, '2015-09-08 17:10:25'),
(96, 3, 0, 4277, 45.11, 0, '2015-09-08 17:01:19'),
(97, 3, 0, 4278, 64.32, 0, '2015-09-03 09:58:59'),
(98, 3, 0, 4279, 45.00, 0, '2015-09-03 09:58:59'),
(99, 3, 0, 4280, 398.00, 1, '2015-10-05 14:23:43'),
(100, 3, 0, 4281, 10.00, 0, '2015-09-03 09:58:59'),
(101, 8, 0, 4288, 10.00, 0, '2015-09-04 13:58:47'),
(102, 3, 0, 4293, 885.00, 0, '2015-09-04 11:27:19'),
(103, 3, 0, 4294, 885.00, 0, '2015-09-04 11:27:19'),
(104, 3, 0, 4291, 50.00, 1, '2015-10-05 14:24:58'),
(105, 3, 0, 4290, 140.00, 0, '2015-09-04 11:27:19'),
(106, 3, 0, 4289, 140.00, 0, '2015-09-04 11:27:19'),
(107, 3, 0, 4292, 9845.00, 0, '2015-09-04 11:58:53'),
(108, 5, 0, 4288, -3.00, 0, '2015-09-04 13:48:54'),
(109, 4, 0, 4310, 10.00, 0, '2015-09-04 17:07:15'),
(110, 4, 0, 4311, 100.00, 0, '2015-09-04 17:07:15'),
(111, 4, 0, 4299, 35.00, 0, '2015-09-07 16:37:52'),
(112, 4, 0, 4300, 35.00, 0, '2015-09-07 16:37:52'),
(113, 4, 0, 4301, 35.00, 0, '2015-09-07 16:37:52'),
(114, 4, 0, 4314, 27.00, 0, '2015-09-08 13:52:48'),
(115, 4, 0, 4315, 26.00, 0, '2015-09-08 13:52:48'),
(116, 4, 0, 4316, 27.00, 0, '2015-09-08 13:52:48'),
(117, 4, 0, 4317, 27.00, 0, '2015-09-08 13:52:48'),
(118, 4, 0, 4329, -3.00, 0, '2015-12-16 16:58:20'),
(119, 4, 0, 4330, -1.00, 0, '2015-12-16 16:50:12'),
(120, 10, 0, 4326, 15.00, 1, '2015-09-23 14:51:36'),
(121, 4, 0, 4332, 40.00, 0, '2015-09-23 17:10:01'),
(122, 4, 0, 4333, 10.00, 0, '2015-09-23 17:05:18'),
(123, 4, 0, 4334, 30.00, 0, '2015-09-23 17:05:18'),
(124, 4, 0, 4335, 20.00, 0, '2015-09-23 17:39:49'),
(125, 4, 0, 4337, 30.00, 0, '2015-09-24 15:41:25'),
(126, 4, 0, 4338, 40.00, 0, '2015-09-24 15:41:25'),
(127, 4, 0, 4339, 30.00, 0, '2015-09-24 15:41:25'),
(128, 4, 0, 4340, 10.00, 0, '2015-09-25 10:23:38'),
(129, 4, 0, 4341, 20.00, 0, '2015-09-25 10:23:38'),
(130, 4, 0, 4342, 13.00, 0, '2015-09-30 11:45:07'),
(131, 4, 0, 4344, 130.00, 0, '2015-09-30 15:19:21'),
(132, 4, 0, 4345, 110.00, 0, '2015-09-30 15:19:22'),
(133, 4, 0, 4346, 10.00, 0, '2015-09-30 15:04:47'),
(134, 4, 0, 4347, 12.00, 0, '2015-09-30 15:13:22'),
(135, 4, 0, 4348, 23.00, 0, '2015-09-30 16:12:39'),
(136, 4, 0, 4349, 100.00, 0, '2015-10-01 15:47:18'),
(137, 4, 0, 4350, 100.00, 0, '2015-10-01 15:47:19'),
(138, 4, 0, 4351, 100.00, 0, '2015-10-01 15:47:21'),
(139, 4, 0, 4352, 200.00, 0, '2015-10-02 09:01:41'),
(140, 4, 0, 4353, 100.00, 0, '2015-10-02 13:41:34'),
(141, 4, 0, 4354, 100.00, 0, '2015-10-02 13:41:40'),
(142, 4, 0, 4355, 100.00, 0, '2015-10-02 13:41:46'),
(143, 4, 0, 4356, 1112.00, 0, '2015-10-02 15:40:27'),
(144, 4, 0, 4357, 100.00, 0, '2015-10-02 13:42:08'),
(145, 4, 0, 4358, 100.00, 0, '2015-10-02 13:42:25'),
(146, 4, 0, 4359, 400.00, 0, '2015-10-02 13:58:31'),
(147, 4, 0, 4360, 122.00, 0, '2015-10-02 15:47:43'),
(148, 14, 0, 4166, 1.00, 0, '2015-10-06 10:20:21'),
(149, 4, 0, 4367, 1000000.00, 0, '2015-10-06 16:12:26'),
(150, 4, 0, 4368, 1000.00, 0, '2015-10-06 16:12:27'),
(151, 4, 0, 4369, 10000.00, 0, '2015-10-06 16:12:28'),
(152, 4, 0, 4370, 100000.00, 0, '2015-10-06 16:12:29'),
(153, 4, 0, 4371, 1.00, 0, '2015-10-06 16:08:39'),
(154, 4, 0, 4372, 2.00, 0, '2015-10-06 16:08:39'),
(155, 4, 0, 4373, 122.00, 0, '2015-10-06 16:39:46'),
(156, 4, 0, 4374, 100.00, 0, '2015-10-09 15:11:48'),
(157, 4, 0, 4375, 100.00, 0, '2015-10-09 15:11:48'),
(158, 4, 0, 4376, 100.00, 0, '2015-10-09 15:11:49'),
(159, 4, 0, 4377, 100.00, 0, '2015-10-09 15:11:49'),
(160, 4, 0, 4378, 100.00, 0, '2015-10-09 15:11:49'),
(161, 4, 0, 4379, 110.00, 0, '2015-10-09 17:56:53'),
(162, 4, 0, 4382, 100.00, 0, '2015-10-09 15:38:12'),
(163, 4, 0, 4383, 120.00, 0, '2015-10-09 16:42:56'),
(164, 4, 0, 4384, 10.00, 0, '2015-10-09 17:56:53'),
(165, 8, 0, 4194, 1.00, 1, '2015-10-10 10:09:07'),
(166, 8, 0, 4194, 1.00, 1, '2015-10-10 10:09:07'),
(167, 2, 0, 4385, 17.00, 1, '2015-10-10 10:13:09'),
(168, 9, 0, 4385, 30.00, 1, '2015-10-10 10:17:53'),
(169, 5, 0, 4385, -3.00, 1, '2015-10-10 10:31:50'),
(170, 3, 0, 4385, 17.00, 1, '2015-11-17 13:41:34'),
(171, 4, 0, 4386, 120.00, 0, '2015-10-10 11:50:38'),
(172, 4, 0, 4387, 100.00, 0, '2015-10-10 11:50:38'),
(173, 4, 0, 4388, 134.00, 0, '2015-10-10 11:50:38'),
(174, 4, 0, 4389, 3.00, 0, '2015-11-07 14:33:37'),
(175, 4, 0, 4390, 5.00, 0, '2015-11-07 14:33:37'),
(176, 4, 0, 4391, 2.00, 0, '2015-11-07 14:33:37'),
(177, 4, 0, 4392, 4.00, 0, '2015-10-12 10:49:57'),
(178, 4, 0, 4393, 5.00, 0, '2015-10-12 10:49:57'),
(179, 4, 0, 4394, 1.00, 0, '2015-10-12 10:49:57'),
(180, 4, 0, 4395, 8.00, 1, '2015-10-13 11:52:38'),
(181, 4, 0, 4396, 50.00, 0, '2015-10-13 14:14:28'),
(182, 4, 0, 4397, 150.00, 0, '2015-10-13 14:14:28'),
(183, 4, 0, 4398, 100.00, 0, '2015-10-13 14:14:29'),
(184, 4, 0, 4399, 50.00, 0, '2015-10-13 14:14:29'),
(185, 15, 0, 4400, 6.00, 1, '2015-10-14 11:57:29'),
(186, 5, 0, 4218, 295.00, 1, '2015-10-13 14:39:56'),
(187, 0, 0, 0, 0.00, 0, '2015-10-14 11:52:05'),
(188, 15, 0, 4403, 10.00, 1, '2015-10-14 11:57:29'),
(189, 5, 0, 4178, -2.00, 1, '2015-10-14 14:13:53'),
(190, 15, 0, 4329, 0.00, 1, '2015-10-20 14:36:35'),
(191, 15, 0, 4159, 5.00, 1, '2015-10-23 19:46:31'),
(192, 15, 0, 4178, 1.00, 1, '2015-10-22 14:09:52'),
(193, 15, 0, 4210, 1.00, 1, '2015-10-22 15:00:13'),
(194, 3, 0, 4306, 101.00, 1, '2015-11-24 11:26:10'),
(195, 3, 0, 4180, 1.00, 1, '2015-10-26 16:06:40'),
(196, 15, 0, 4179, 1.00, 0, '2015-10-26 22:00:03'),
(197, 10, 0, 4166, 1.00, 0, '2015-10-26 22:00:51'),
(198, 15, 0, 4180, 1.00, 1, '2015-10-27 13:02:21'),
(199, 15, 0, 4383, 1.00, 1, '2015-10-27 13:02:21'),
(200, 14, 0, 4379, 1.00, 0, '2015-10-27 13:37:57'),
(201, 15, 0, 4193, 1.00, 1, '2015-10-27 15:05:02'),
(202, 4, 0, 4427, 1.00, 0, '2015-10-28 12:01:21'),
(203, 4, 0, 4428, 2.00, 0, '2015-10-29 15:56:26'),
(204, 4, 0, 4429, 1.00, 0, '2015-10-28 12:01:21'),
(205, 4, 0, 4431, 2.00, 0, '2015-10-29 15:56:26'),
(206, 15, 0, 4367, 1.00, 0, '2015-11-11 13:37:03'),
(207, 15, 0, 4227, 1.02, 0, '2015-12-19 09:50:35'),
(208, 22, 0, 4193, 0.00, 0, '2015-11-12 14:28:32'),
(209, 4, 0, 4449, 2.00, 0, '2015-11-12 17:23:19'),
(210, 4, 0, 4450, 1.00, 0, '2015-11-12 17:23:19'),
(211, 0, 0, 0, 0.00, 0, '2015-11-12 17:23:19'),
(212, 4, 0, 4457, 10.00, 0, '2015-11-17 17:15:59'),
(213, 4, 0, 4458, 21.00, 0, '2015-11-17 17:28:12'),
(214, 4, 0, 4459, 1.00, 0, '2015-11-17 17:15:59'),
(215, 4, 0, 4460, 5.00, 0, '2015-11-18 09:44:02'),
(216, 4, 0, 4461, 3.00, 0, '2015-11-18 09:44:02'),
(217, 4, 0, 4462, 2.00, 0, '2015-11-18 09:44:02'),
(218, 4, 0, 4463, 10.00, 0, '2015-11-18 10:09:58'),
(219, 4, 0, 4464, 2.00, 0, '2015-11-18 10:09:58'),
(220, 4, 0, 4465, 10.00, 0, '2015-11-18 10:26:05'),
(221, 4, 0, 4466, 2.00, 0, '2015-11-18 10:26:05'),
(222, 4, 0, 4467, 2.00, 0, '2015-11-18 10:44:22'),
(223, 4, 0, 4468, 1.00, 0, '2015-11-18 10:59:39'),
(224, 4, 0, 4469, 1.00, 0, '2015-11-18 11:19:06'),
(225, 4, 0, 4470, 5.00, 0, '2015-11-18 11:46:06'),
(226, 4, 0, 4471, 15.00, 0, '2015-11-18 11:46:06'),
(227, 4, 0, 4472, 10.00, 0, '2015-11-18 11:46:07'),
(228, 4, 0, 4473, 10.00, 0, '2015-11-18 11:46:07'),
(229, 4, 0, 4474, 1.00, 0, '2015-11-18 11:57:16'),
(230, 3, 0, 4475, 1.00, 0, '2015-11-18 13:58:45'),
(231, 4, 0, 4476, 3.00, 0, '2015-11-18 14:33:05'),
(232, 4, 0, 4477, 1.00, 0, '2015-11-18 14:22:28'),
(233, 4, 0, 4478, 25.00, 0, '2015-11-18 15:24:13'),
(234, 4, 0, 4479, 20.00, 0, '2015-11-18 16:36:43'),
(235, 4, 0, 4480, 11.00, 0, '2015-11-18 15:35:56'),
(236, 4, 0, 4481, 5.00, 0, '2015-11-18 16:27:33'),
(237, 4, 0, 4482, 12.00, 0, '2015-11-18 16:27:33'),
(238, 4, 0, 4483, 4.00, 0, '2015-11-18 16:27:33'),
(239, 4, 0, 4484, 3.00, 0, '2015-11-18 16:27:33'),
(240, 4, 0, 4485, 12.00, 0, '2015-11-19 09:40:52'),
(241, 4, 0, 4486, 1.00, 0, '2015-11-19 08:57:14'),
(242, 4, 0, 4487, 4.00, 0, '2015-11-19 09:40:52'),
(243, 3, 0, 4488, 10.02, 1, '2015-11-19 10:11:42'),
(244, 4, 0, 4489, 20.00, 0, '2015-11-19 10:28:25'),
(245, 4, 0, 4490, 4.00, 0, '2015-11-19 10:28:25'),
(246, 4, 0, 4491, 4.00, 0, '2015-11-19 10:28:25'),
(247, 4, 0, 4492, 7.00, 0, '2015-11-19 10:39:44'),
(248, 4, 0, 4493, 4.00, 0, '2015-11-19 10:34:11'),
(249, 4, 0, 4494, 12.00, 0, '2015-11-19 11:03:01'),
(250, 4, 0, 4495, 6.00, 0, '2015-11-19 11:11:09'),
(251, 4, 0, 4496, 2.00, 0, '2015-11-19 10:54:48'),
(252, 4, 0, 4497, 10.00, 0, '2015-11-19 11:03:01'),
(253, 4, 0, 4498, 5.00, 0, '2015-11-19 11:03:01'),
(254, 4, 0, 4499, 10.00, 0, '2015-11-19 11:03:01'),
(255, 4, 0, 4500, 12.00, 0, '2015-11-24 11:47:23'),
(256, 4, 0, 4504, 1.00, 0, '2015-11-24 08:38:21'),
(257, 4, 0, 4505, 1.00, 0, '2015-11-24 08:38:21'),
(258, 4, 0, 4506, 1.00, 0, '2015-11-24 11:47:23'),
(259, 4, 0, 4507, 1.00, 0, '2015-11-24 11:51:49'),
(260, 4, 0, 4508, 105.00, 0, '2015-11-24 14:08:24'),
(261, 4, 0, 4509, 40.00, 0, '2015-11-24 16:04:17'),
(262, 4, 0, 4510, 20.00, 0, '2015-11-24 16:04:17'),
(263, 4, 0, 4511, 104.00, 0, '2015-12-10 16:05:38'),
(264, 4, 0, 4512, 2.00, 0, '2015-11-25 10:58:14'),
(265, 4, 0, 4513, 4.00, 0, '2015-11-25 10:58:14'),
(266, 4, 0, 4514, 11.00, 0, '2015-11-25 11:25:53'),
(267, 2, 0, 4516, 20.00, 0, '2015-11-25 11:56:13'),
(268, 4, 0, 4520, 230.00, 0, '2015-12-10 15:43:44'),
(269, 4, 0, 4521, 118.00, 0, '2015-12-10 14:57:05'),
(270, 4, 0, 4522, 191.00, 0, '2015-12-10 15:37:49'),
(271, 4, 0, 4527, 100.00, 0, '2015-12-10 15:21:30'),
(272, 22, 0, 4159, 1.00, 0, '2015-12-15 11:49:32'),
(273, 1, 0, 4528, 10.00, 0, '2015-12-15 13:43:34'),
(274, 1, 0, 4408, 10.00, 0, '2015-12-15 13:45:31'),
(275, 1, 0, 4529, 10.00, 0, '2015-12-15 13:58:28'),
(276, 4, 0, 4534, 5.00, 0, '2015-12-16 14:45:37'),
(277, 8, 0, 4329, 2.00, 0, '2015-12-16 16:55:46'),
(278, 8, 0, 4520, 1.00, 0, '2015-12-18 12:21:00'),
(279, 15, 0, 4198, 1.02, 0, '2015-12-18 12:24:48'),
(280, 15, 0, 4222, 1.00, 0, '2015-12-19 09:50:35'),
(281, 15, 0, 4228, 2.00, 0, '2015-12-19 09:55:07'),
(282, 15, 0, 4299, 1.00, 0, '2015-12-19 09:57:20'),
(283, 15, 0, 4537, 20.00, 0, '2015-12-19 10:02:13'),
(284, 4, 0, 4538, 10.00, 0, '2015-12-21 10:42:50'),
(285, 4, 0, 4539, 10.00, 0, '2015-12-21 10:42:50'),
(286, 25, 0, 4329, -1.00, 0, '2015-12-21 11:42:02'),
(287, 9, 0, 4329, 0.00, 1, '2015-12-22 11:06:01'),
(288, 9, 0, 4498, 0.00, 1, '2015-12-22 11:06:01'),
(289, 9, 0, 4541, 1.00, 1, '2015-12-22 15:15:32'),
(290, 9, 0, 4540, -14.00, 1, '2015-12-22 11:31:37'),
(291, 9, 0, 4328, 119.00, 0, '2015-12-22 14:28:20'),
(292, 25, 0, 4178, 1.00, 0, '2015-12-22 14:33:48'),
(293, 3, 0, 4541, 1.00, 1, '2015-12-24 11:06:54'),
(294, 3, 0, 4540, 1.00, 1, '2015-12-24 11:06:54'),
(295, 25, 0, 4534, -2.00, 0, '2015-12-24 14:16:42'),
(296, 2, 0, 4282, 10.00, 0, '2015-12-25 09:12:03'),
(297, 2, 0, 4543, 20.00, 0, '2015-12-25 09:12:03'),
(298, 4, 0, 4544, 10.00, 0, '2015-12-25 09:21:30'),
(299, 4, 0, 4545, 10.00, 0, '2015-12-25 09:21:30'),
(300, 4, 0, 4546, 10.00, 0, '2015-12-25 09:21:31'),
(301, 4, 0, 4547, 10.00, 0, '2015-12-25 09:38:26'),
(302, 4, 0, 4548, 10.00, 0, '2015-12-25 09:38:26'),
(303, 4, 0, 4549, 10.00, 0, '2015-12-25 09:38:26'),
(304, 4, 0, 4550, 20.00, 0, '2015-12-25 10:32:39'),
(305, 26, 0, 4447, 2.00, 1, '2015-12-25 10:27:23'),
(306, 15, 0, 4447, 10.00, 0, '2015-12-25 10:33:45'),
(307, 3, 0, 4551, 0.10, 0, '2015-12-26 12:16:53'),
(308, 3, 0, 4552, 0.10, 0, '2015-12-26 12:16:53'),
(309, 2, 0, 4559, 10.00, 0, '2015-12-31 09:13:16'),
(310, 2, 0, 4560, 10.00, 0, '2015-12-31 09:13:16'),
(311, 1, 0, 4557, 50.00, 0, '2015-12-31 09:14:17'),
(312, 3, 0, 4561, 30.00, 0, '2015-12-31 09:14:17'),
(313, 4, 0, 4562, 20.00, 0, '2015-12-31 09:14:17'),
(314, 2, 0, 4563, 10.00, 0, '2015-12-31 09:15:38'),
(315, 2, 0, 4564, 10.00, 0, '2015-12-31 09:15:38'),
(316, 2, 0, 4565, 10.00, 0, '2015-12-31 09:15:38'),
(317, 2, 0, 4566, 10.00, 0, '2015-12-31 09:15:38'),
(318, 1, 0, 4567, 10.00, 0, '2015-12-31 09:17:40'),
(319, 1, 0, 4568, 20.00, 0, '2015-12-31 09:17:40'),
(320, 1, 0, 4569, 50.00, 0, '2015-12-31 09:24:46'),
(321, 3, 0, 4570, 30.00, 0, '2015-12-31 09:24:46'),
(322, 1, 0, 4571, 10.00, 0, '2015-12-31 09:33:13'),
(323, 1, 0, 4572, 20.00, 0, '2015-12-31 09:33:13'),
(324, 1, 0, 4573, 10.00, 0, '2015-12-31 09:33:13'),
(325, 1, 0, 4574, 10.00, 0, '2015-12-31 09:33:13'),
(326, 1, 0, 4575, 10.00, 0, '2015-12-31 09:34:26'),
(327, 1, 0, 4576, 20.00, 0, '2015-12-31 09:34:26'),
(328, 1, 0, 4577, 10.00, 0, '2015-12-31 09:34:26'),
(329, 1, 0, 4578, 10.00, 0, '2015-12-31 09:34:26'),
(330, 1, 0, 4582, 10.00, 0, '2015-12-31 11:07:01'),
(331, 1, 0, 4587, 10.00, 0, '2015-12-31 11:25:37'),
(332, 1, 0, 4588, 20.00, 0, '2015-12-31 11:25:37'),
(333, 1, 0, 4589, 30.00, 0, '2015-12-31 11:25:37'),
(334, 3, 0, 4595, 10.00, 0, '2016-01-06 14:44:07'),
(335, 3, 0, 4596, 10.00, 0, '2016-01-06 14:44:07'),
(336, 4, 0, 4597, 2.00, 0, '2016-01-06 15:23:31'),
(337, 4, 0, 4599, 10.00, 0, '2016-01-06 17:32:18'),
(338, 4, 0, 4600, 1.00, 0, '2016-01-06 17:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `lifetek_welfare_rewards`
--

CREATE TABLE IF NOT EXISTS `lifetek_welfare_rewards` (
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
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `phppos_jobs_file`
--

CREATE TABLE IF NOT EXISTS `phppos_jobs_file` (
  `jobs_file_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_file_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobs_file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `jobs_file_date` date DEFAULT NULL,
  PRIMARY KEY (`jobs_file_id`,`person_id`),
  KEY `phppos_jobs_file_ibfk_1` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lifetek_customers`
--
ALTER TABLE `lifetek_customers`
  ADD CONSTRAINT `lifetek_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_people` (`person_id`);

--
-- Constraints for table `lifetek_employees`
--
ALTER TABLE `lifetek_employees`
  ADD CONSTRAINT `lifetek_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_people` (`person_id`);

--
-- Constraints for table `lifetek_giftcards`
--
ALTER TABLE `lifetek_giftcards`
  ADD CONSTRAINT `lifetek_giftcards_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `lifetek_customers` (`person_id`);

--
-- Constraints for table `lifetek_hopdong`
--
ALTER TABLE `lifetek_hopdong`
  ADD CONSTRAINT `lifetek_hopdong_ibfk_1` FOREIGN KEY (`id_employess`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lifetek_inventory`
--
ALTER TABLE `lifetek_inventory`
  ADD CONSTRAINT `lifetek_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `lifetek_items` (`item_id`),
  ADD CONSTRAINT `lifetek_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `lifetek_employees` (`person_id`);

--
-- Constraints for table `lifetek_items`
--
ALTER TABLE `lifetek_items`
  ADD CONSTRAINT `lifetek_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `lifetek_suppliers` (`person_id`);

--
-- Constraints for table `lifetek_items_taxes`
--
ALTER TABLE `lifetek_items_taxes`
  ADD CONSTRAINT `lifetek_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `lifetek_item_kits_taxes`
--
ALTER TABLE `lifetek_item_kits_taxes`
  ADD CONSTRAINT `lifetek_item_kits_taxes_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`) ON DELETE CASCADE;

--
-- Constraints for table `lifetek_item_kit_items`
--
ALTER TABLE `lifetek_item_kit_items`
  ADD CONSTRAINT `lifetek_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lifetek_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `lifetek_jobs`
--
ALTER TABLE `lifetek_jobs`
  ADD CONSTRAINT `lifetek_jobs_ibfk_1` FOREIGN KEY (`jobs_important`) REFERENCES `lifetek_jobs_important` (`jobs_important_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lifetek_jobs_ibfk_3` FOREIGN KEY (`jobs_security_id`) REFERENCES `lifetek_jobs_security` (`jobs_security_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lifetek_jobs_affiliates`
--
ALTER TABLE `lifetek_jobs_affiliates`
  ADD CONSTRAINT `lifetek_jobs_affiliates_ibfk_1` FOREIGN KEY (`jobs_city_id`) REFERENCES `lifetek_jobs_city` (`jobs_city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lifetek_jobs_city`
--
ALTER TABLE `lifetek_jobs_city`
  ADD CONSTRAINT `lifetek_jobs_city_ibfk_1` FOREIGN KEY (`jobs_regions_id`) REFERENCES `lifetek_jobs_regions` (`jobs_regions_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lifetek_jobs_city_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lifetek_jobs_department`
--
ALTER TABLE `lifetek_jobs_department`
  ADD CONSTRAINT `lifetek_jobs_department_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lifetek_jobs_department_ibfk_2` FOREIGN KEY (`jobs_affiliates_id`) REFERENCES `lifetek_jobs_affiliates` (`jobs_affiliates_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lifetek_jobs_regions`
--
ALTER TABLE `lifetek_jobs_regions`
  ADD CONSTRAINT `lifetek_jobs_regions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lifetek_modules_actions`
--
ALTER TABLE `lifetek_modules_actions`
  ADD CONSTRAINT `lifetek_modules_actions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `lifetek_modules` (`module_id`);

--
-- Constraints for table `lifetek_permissions`
--
ALTER TABLE `lifetek_permissions`
  ADD CONSTRAINT `lifetek_permissions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`);

--
-- Constraints for table `lifetek_permissions_actions`
--
ALTER TABLE `lifetek_permissions_actions`
  ADD CONSTRAINT `lifetek_permissions_actions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`),
  ADD CONSTRAINT `lifetek_permissions_actions_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `lifetek_modules_actions` (`action_id`);

--
-- Constraints for table `lifetek_receivings`
--
ALTER TABLE `lifetek_receivings`
  ADD CONSTRAINT `lifetek_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `lifetek_employees` (`person_id`),
  ADD CONSTRAINT `lifetek_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `lifetek_suppliers` (`person_id`);

--
-- Constraints for table `lifetek_receivings_items`
--
ALTER TABLE `lifetek_receivings_items`
  ADD CONSTRAINT `lifetek_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`),
  ADD CONSTRAINT `lifetek_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `lifetek_receivings` (`receiving_id`);

--
-- Constraints for table `lifetek_salary`
--
ALTER TABLE `lifetek_salary`
  ADD CONSTRAINT `lifetek_salary_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lifetek_sales`
--
ALTER TABLE `lifetek_sales`
  ADD CONSTRAINT `lifetek_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `lifetek_employees` (`person_id`),
  ADD CONSTRAINT `lifetek_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `lifetek_customers` (`person_id`);

--
-- Constraints for table `lifetek_sales_items`
--
ALTER TABLE `lifetek_sales_items`
  ADD CONSTRAINT `lifetek_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`),
  ADD CONSTRAINT `lifetek_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales` (`sale_id`);

--
-- Constraints for table `lifetek_sales_items_taxes`
--
ALTER TABLE `lifetek_sales_items_taxes`
  ADD CONSTRAINT `lifetek_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales_items` (`sale_id`),
  ADD CONSTRAINT `lifetek_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `lifetek_items` (`item_id`);

--
-- Constraints for table `lifetek_sales_item_kits`
--
ALTER TABLE `lifetek_sales_item_kits`
  ADD CONSTRAINT `lifetek_sales_item_kits_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`),
  ADD CONSTRAINT `lifetek_sales_item_kits_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales` (`sale_id`);

--
-- Constraints for table `lifetek_sales_item_kits_taxes`
--
ALTER TABLE `lifetek_sales_item_kits_taxes`
  ADD CONSTRAINT `lifetek_sales_item_kits_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales_item_kits` (`sale_id`),
  ADD CONSTRAINT `lifetek_sales_item_kits_taxes_ibfk_2` FOREIGN KEY (`item_kit_id`) REFERENCES `lifetek_item_kits` (`item_kit_id`);

--
-- Constraints for table `lifetek_sales_payments12`
--
ALTER TABLE `lifetek_sales_payments12`
  ADD CONSTRAINT `lifetek_sales_payments12_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `lifetek_sales` (`sale_id`);

--
-- Constraints for table `lifetek_suppliers`
--
ALTER TABLE `lifetek_suppliers`
  ADD CONSTRAINT `lifetek_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_people` (`person_id`);

--
-- Constraints for table `lifetek_welfare_rewards`
--
ALTER TABLE `lifetek_welfare_rewards`
  ADD CONSTRAINT `lifetek_welfare_rewards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `lifetek_employees` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
