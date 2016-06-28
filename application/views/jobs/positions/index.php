<?php $this->load->view("partial/header");?><div id="content_demo">    
<ul id="warning"></ul>    
<script type="text/javascript">        
$(document).ready(function(){            
	enable_select_all();            
	enable_checkboxes();            
	enable_row_selection();            
	var table_columns_status = ['','jobs_regions_name','jobs_status_id','jobs_status_show',''];            
	enable_sorting("<?php echo site_url($controller_name."/sorting"); ?>",table_columns_status, <?php echo $per_page; ?>);            
	enable_search('<?php echo site_url($controller_name."/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);            
	enable_delete(<?php echo json_encode(lang("positions_confirm_delete"));?>,<?php echo json_encode(lang("none_selected_positions"));?>);                 
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);            
	$("#tab_show li").click(function(){                
		$('#tab_show li a').removeClass('active');                
		$(this).toggleClass('active');            
	});        
});        
	function clickRegions(){            
		var url = $('#manager_1').attr('href');            
		$.post(url,{},function(data){                
			$('#content_demo').html(data);            
		});        
	}        
	function clickIndex(){            
		var url = $('#manager_2').attr('href');            
		$.post(url,{},function(data){                
		$('#content_demo').html(data);            
		});        
	}        
	function post_person_form_submit(response){            
		if(!response.success){                
			set_feedback(response.message,'error_message',true);            
		}else{                //This is an update, just update one row                
			if(jQuery.inArray(response.jobs_id,get_visible_checkbox_ids()) != -1){                    
				update_row(response.jobs_id,'<?php echo site_url("$controller_name/get_row")?>');                    
				set_feedback(response.message,'success_message',false);                
			}else{ //refresh entire table                
				do_search(true,function(){                        
					highlight_row(response.jobs_id);                        
					set_feedback(response.message,'success_message',false);                    
				});                
			}            
		}        
	}    
</script>
<div id="content_area_wrapper"><div id="content_area">    <table id="title_bar_new">        <tr>            <td id="title_icon">                 <?php 				if($controller_name == employees){			?>			<img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' />			<?php			}else{?>				<a href="<?php echo base_url()?>employees" ><div class="newface_back"></div></a>			<?php			}			?>            </td>            <td id="title" style="color: #FFF;line-height:40px;padding-left: 5px">                <?php echo lang($controller_name); ?>            </td>            <td id="title_search_new">                <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>                <input type="text" name ='search' id='search' placeholder="Nhập tên chức danh .."/>                <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />                </form>            </td>        </tr>    </table>    <table id="contents">        <tr>            <td id="commands">                <div class="module_employee">                    <?php //if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>                        <?php //echo anchor("employees",                            'Phòng ban - Nhân viên',                            array('class'=>'none new', 'title'=>'Phòng ban - Nhân viên'));                        ?>                        <?php echo anchor("$controller_name",                            $this->lang->line($controller_name.'_index'),                            array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_index')));                    //}                    ?>                                            <?php if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>                                <?php echo anchor("$controller_name/view/-1/width~$form_width_module",                                    $this->lang->line($controller_name.'_insert'),                                    array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_insert')));                            }                            ?>                                                <?php if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {?>                                <?php                                echo anchor("$controller_name/delete",$this->lang->line($controller_name."_delete_".$controller_name),array('id'=>'delete', 'class'=>'delete_inactive'));                                ?>                            <?php } ?>                                                         </div><!--end module status-->            </td>            <td style="width:10px;"></td>            <td>                <div id="item_table">                    <div id="table_holder">                        <?php echo $manage_table; ?>                    </div>                </div>                <div id="pagination">                    <?php echo $pagination;?>                </div>            </td>        </tr>    </table>    <div id="feedback_bar"></div></div></div>    <link href="<?php echo base_url()?>css/indexJobs.css" rel="stylesheet" type="text/css" />
<?php $this->load->view("partial/footer"); ?>

<style>    #tab_show li{        float: left;        list-style: none;        border-right: 2px solid #FFF;        cursor: pointer;        background: CORNFLOWERBLUE;        padding: 10px;        color: #FFF;        font-size: 14px;        font-weight: bold;    }    #tab_show li a{        color: #FFF;    }    #tab_show li a:hover{        color: #000;    }    #tab_show li:hover{        color: #000;    }    #tab_show li.active{        background: #048CAD;    }</style>