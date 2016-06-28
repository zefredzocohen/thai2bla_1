<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
$(document).ready(function()
{ 
    var table_columns = ['','first_name','city','email','phone_number','birth_date'];

    enable_sorting("<?php echo site_url($controller_name."/sorting_regions_detail"); ?>",table_columns, <?php echo $per_page; ?>);            
	enable_search('<?php echo site_url($controller_name."/suggest_regions_detail");?>',<?php echo json_encode(lang("common_confirm_search"));?>);            
	
    enable_select_all();

    enable_checkboxes();
    
    enable_row_selection(); 

    enable_email('<?php echo site_url("$controller_name/mailto")?>');

    enable_delete(<?php echo json_encode(lang("employees_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
	
	enable_sendmail(<?php echo json_encode('Vui lòng chọn khách hàng để gửi mail!');?>)

	  
});
 
</script> 
<table id="title_bar_new">
    <tr>
        <td id="title_icon">
            <a href="<?php echo base_url()?><?php echo "index.php/".$controller_name; ?>"><img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /></a>
        </td>
        <td id="title" style="color: #FFF;line-height:40px;padding-left: 5px; width: 1100px">                
		<?php echo "Nhân viên trong thành phố ".$info_regions->jobs_regions_name ?>            
		</td>  
        
        
        <?php $type_customers = $this->Customer->get_Customer_type(); ?>
        <td id="title_search_new" >
            <?php echo form_open("$controller_name/search_regions_detail",array('id'=>'search_form')); ?>
            <?php if($controller_name == 'customers') { 
                $employees = $this->Employee->get_list_employee();
            ?>
                <?php if($this->session->userdata('person_id')==1){ ?>
                <div style="position: absolute; right: 475px; margin-top: 1px;">
                    <select id="employeesearch" name="employeesearch" class='form-control'>
                         <option value="" selected="selected">Tất cả</option>
                        <?php foreach ($employees as $employee){ ?>
                        <option value="<?php echo $employee['person_id']; ?>" ><?php echo $employee['first_name']." ".$employee['last_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } ?>
                <div style="position: absolute; right: 280px; margin-top: 1px;">
                    <select id="categorysearch" name="categorysearch" class='form-control'>
                        <option value="" selected="selected">Tất cả</option>
                        <?php foreach ($type_customers as $type_customer){ ?>
                        <option value="<?php echo $type_customer['customer_type_id']; ?>" ><?php echo $type_customer['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <input type="text" name ='search' id='search' placeholder="Tên hoặc số điện thoại ... " style="margin: 0 !important;" />
                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
                <?php } else{?>
                <input type="text" name ='search' id='search' placeholder="Tên hoặc số điện thoại ... "  />
                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
                <?php }?>
            </form>
        </td>
    </tr>
</table>



<table id="contents">

	<tr>

		<td id="commands">

			<div id="new_button">

				
                <?php

				if ($controller_name == 'employees' ) {
                                    ?>
                 <br />
				<?php if ($this->Employee->has_module_action_permission('regions', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("regions",

					$this->lang->line('common_regions'),

					array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_regions')));

				}

				?>

				<?php if ($this->Employee->has_module_action_permission($controller_name, 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("citys",

					$this->lang->line('common_citys'),

					array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_city')));

				}


				?>

					<?php if ($this->Employee->has_module_action_permission('affiliates', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("affiliates",

					$this->lang->line('common_department'),

					array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_department')));

				}	

				?>

				<?php if ($this->Employee->has_module_action_permission("department", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("department",

					$this->lang->line('common_affiliates'),

					array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_affiliates')));

				}	

				?>

				<?php if ($this->Employee->has_module_action_permission("positions", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("positions",

					$this->lang->line('common_postions'),

					array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_postions')));

				}	  
				 if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("$controller_name/view/-1/width~$form_width",

					$this->lang->line($controller_name.'_new'),

						array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));

				}	

				?>
 				<?php
				 if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("$controller_name/view/-1/width~$form_width",

					$this->lang->line($controller_name.'_new'),

						array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));

				}	

				?>
				<?php 
					  echo 
					anchor("$controller_name/creat_contract",
					lang("employees_add_contract"),
					array('id'=>'employees_add_news', 
						'class' => ' none new',
						'title'=>lang('employees_add_contract'))); 
				
				?>
				<!-- phan lam -->
                                <?php }?>
				 
				<style type="text/css">

				#shoping_customer{background-position: -10px -130px;}

				</style>

				<!-- end phan lam -->

				

				 
				<?php 
 				if ($this->Employee->has_module_action_permission('employees', 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

					<?php echo anchor("employees/delete",$this->lang->line("common_delete"),array('id'=>'delete', 'class'=>'delete_inactive')); ?>

				<?php } ?> 
				 
			</div>

		</td>

		<td style="width:10px;"></td>

<td>

             <div id="item_table">

			<div id="table_holder">
 
			<?php echo $manage_table; ?>

			</div>

			</div>

			<div id="pagination">

				<?php echo $pagination;?>
			</div>
		</td>

	</tr>

</table>

<div id="feedback_bar"></div>

<?php $this->load->view("partial/abouts"); ?>

</div></div>

<?php $this->load->view("partial/footer"); ?>

<link href="<?php echo base_url()?>css/indexJobs.css" rel="stylesheet" type="text/css" />

<style>
    #tab_show li{
        float: left;
        list-style: none;
        border-right: 2px solid #FFF;
        cursor: pointer;
        background: CORNFLOWERBLUE;
        padding: 10px;
        color: #FFF;
        font-size: 14px;
        font-weight: bold;
    }
    #tab_show li a{
        color: #FFF;
    }
    #tab_show li a:hover{
        color: #000;
    }
    #tab_show li:hover{
        color: #000;
    }
    #tab_show li.active{
        background: #048CAD;
    }    
    .detail_contract{
        background: none !important;
        color: #0066FF !important;
        text-shadow: none !important;
        font-size: 14px;       
        width: 100% !important;
    }
    .detail_contract:hover{
        background: none !important;
        color: #0066FF !important;
        text-decoration: underline !important;
        text-shadow: none !important; 
    } 
    .a-menu{
        background: none !important; 
        color: #0150D1 !important; 
        text-shadow: none !important; 
        border-bottom: none;
        font-size: 13px !important;
        text-align: left;
    }
    .a-menu:hover{
        background: none !important;       
        border-bottom: none;   
        text-shadow: none !important;
        text-decoration: underline;
        color: #0150D1 !important; 
    }
</style>
