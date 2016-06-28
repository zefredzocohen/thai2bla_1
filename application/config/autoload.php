<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  | AUTO-LOADER
  | -------------------------------------------------------------------
  | This file specifies which systems should be loaded by default.
  |
  | In order to keep the framework as light-weight as possible only the
  | absolute minimal resources are loaded by default. For example,
  | the database is not connected to automatically since no assumption
  | is made regarding whether you intend to use it.  This file lets
  | you globally define which systems you would like loaded with every
  | request.
  |
  | -------------------------------------------------------------------
  | Instructions
  | -------------------------------------------------------------------
  |
  | These are the things you can load automatically:
  |
  | 1. Packages
  | 2. Libraries
  | 3. Helper files
  | 4. Custom config files
  | 5. Language files
  | 6. Models
  |
 */

/*
  | -------------------------------------------------------------------
  |  Auto-load Packges
  | -------------------------------------------------------------------
  | Prototype:
  |
  |  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
  |
 */

$autoload['packages'] = array();


/*
  | -------------------------------------------------------------------
  |  Auto-load Libraries
  | -------------------------------------------------------------------
  | These are the classes located in the system/libraries folder
  | or in your application/libraries folder.
  |
  | Prototype:
  |
  |	$autoload['libraries'] = array('database', 'session', 'xmlrpc');
 */

$autoload['libraries'] = array('database', 'form_validation', 'session', 'user_agent', 'pagination');


/*
  | -------------------------------------------------------------------
  |  Auto-load Helper Files
  | -------------------------------------------------------------------
  | Prototype:
  |
  |	$autoload['helper'] = array('url', 'file');
 */

$autoload['helper'] = array('form', 'url', 'table', 'text', 'currency', 'html', 'download',
    'base64', 'mailchimp', 'language', 'file', 'assets', 'sale', 'jobs_project', 'jobs_report', 'jobs_employees',
    'jobs_regions', 'jobs_city', 'jobs_affiliates', 'jobs_department', 'jobs_positions', 'hrm_salary_config',
    'hrm_salary_option', 'ckeditor', 'jobs_file', 'employees_config', 'contractcustomer', 'lifetek');

/*
  | -------------------------------------------------------------------
  |  Auto-load Config files
  | -------------------------------------------------------------------
  | Prototype:
  |
  |	$autoload['config'] = array('config1', 'config2');
  |
  | NOTE: This item is intended for use ONLY if you have created custom
  | config files.  Otherwise, leave it blank.
  |
 */

$autoload['config'] = array();


/*
  | -------------------------------------------------------------------
  |  Auto-load Language files
  | -------------------------------------------------------------------
  | Prototype:
  |
  |	$autoload['language'] = array('lang1', 'lang2');
  |
  | NOTE: Do not include the "_lang" part of your file.  For example
  | "codeigniter_lang.php" would be referenced as array('codeigniter');
  |
 */

$autoload['language'] = array('common', 'config', 'customers', 'employees', 'error', 'items',
    'login', 'module', 'reports', 'timekeeping', 'sales', 'suppliers', 'receivings', 'giftcards',
    'item_kits', 'cost', 'profit', 'jobs_project', 'jobs_report', 'jobs_employees', 'employees_config',
    'jobs_regions', 'jobs_city', 'jobs_affiliates', 'jobs_department', 'jobs_positions', 'jobs_common',
    'education', 'bangcap', 'tinhoc', 'language', 'visa', 'chungtu', 'assets', 'salary', 'jobs_file', 'contracts',
    'cate_contractcustomer', 'nhomts_thietbi', 'bpsd', 'create_inventorys', 'services', 'packs', 'category_processes', 'quotes_contract','news_category');


/*
  | -------------------------------------------------------------------
  |  Auto-load Models
  | -------------------------------------------------------------------
  | Prototype:
  |
  |	$autoload['model'] = array('model1', 'model2');
  |
 */

$autoload['model'] = array('Appconfig', 'My_person', 'Person', 'Customer', 'Employee', 'Module', 'Item',
    'Item_taxes', 'Sale', 'Supplier', 'Inventory', 'Receiving', 'Giftcard', 'Item_kit', 'Item_kit_taxes',
    'Item_kit_items', 'Appfile', 'Module_action', 'Category', 'City', 'Unit', 'Sliders', 'About', 'Jobs_employees',
    'Profit_m', 'Jobs_regions', 'Jobs_city', 'Jobs_affiliates', 'Jobs_department', 'Jobs_positions', 'Jobs_projects',
    'Jobs_reports', 'Educations', 'Bangcaps', 'Tinhocs', 'Languages', 'Visas', 'Chungtu', 'Asset', 'Congcu', 'Dttc',
    'Tkdu', 'Jobcategory', 'Contract', 'Salaryconfigs', 'Salaryoptions', 'Timekeepings', 'Jobs_file', 'M_customer_type',
    'Em_culture', 'Contractcustomers', 'Contractcustomer_types', 'Template', 'Nhomts_thietbis', 'Bpsds',
    'Contractemp_types', 'Create_invetory', 'Service', 'Cost', 'Pack', 'Pack_items', 'M_category_processes', 'M_quotes_contract', 'News_category_model');

/* End of file autoload.php */
/* Location: ./application/config/autoload.php */
