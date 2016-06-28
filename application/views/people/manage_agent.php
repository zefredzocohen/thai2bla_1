<?php $this->load->view("partial/header"); ?>
<div id="content_area_wrapper">
<div id="content_area">
<script type="text/javascript">
 
$(document).ready(function()
{ 
    var table_columns = ['','last_name','city','email','phone_number','birth_date'];

    enable_sorting("<?php echo site_url("$controller_name/sorting"); ?>",table_columns, <?php echo $per_page; ?>);

    enable_select_all();

    enable_checkboxes();
    
    enable_row_selection(); 

    enable_search('<?php echo site_url("$controller_name/suggest");?>',<?php echo json_encode(lang("common_confirm_search"));?>);

    enable_email('<?php echo site_url("$controller_name/mailto")?>');

    enable_delete(<?php echo json_encode(lang($controller_name."_confirm_delete"));?>,<?php echo json_encode(lang($controller_name."_none_selected"));?>);
	enable_cleanup(<?php echo json_encode(lang("customers_confirm_cleanup"));?>);
	
	enable_sendmail(<?php echo json_encode('Vui lòng chọn đại lý để gửi mail!');?>);
	enable_sendsms(<?php echo json_encode('Vui lòng chọn đại lý để gửi SMS')?>,<?php echo json_encode('Bạn chỉ gửi được 1KH/1lần')?>);

	$('.date-pick').datePicker()

	$('#start-date').bind(

		'dpClosed',

		function(e, selectedDates)

		{

			var d = selectedDates[0];

			if (d) {

				d = new Date(d);

				$('#end-date').dpSetStartDate(d.addDays(1).asString());

			}

		}

	);

	$('#end-date').bind(

		'dpClosed',

		function(e, selectedDates)

		{

			var d = selectedDates[0];

			if (d) {

				d = new Date(d);

				$('#start-date').dpSetEndDate(d.addDays(-1).asString());

			}

		}

	);

	<!-- phan lam -->

	var button1 = $('#button1');

    var menu1 = $('#menutest1');

    

    $('ul li a', menu1).each(function() {

        $(this).append('<span />');

    });

    

    button1.toggle(function(e) {

        e.preventDefault();

        menu1.css({display: 'block'});

        $('.ar', this).html('&#9650;').css({top: '3px'});

        $(this).addClass('active');

    },function() {

        menu1.css({display: 'none'});

        $('.ar', this).html('&#9660;').css({top: '5px'});

        $(this).removeClass('active');

    });

	

	

	var button2 = $('#button2');

    var menu2 = $('#menutest2');

    

    $('ul li a', menu1).each(function() {

        $(this).append('<span />');

    });

    

    button2.toggle(function(e) {

        e.preventDefault();

        menu2.css({display: 'block'});

        $('.ar', this).html('&#9650;').css({top: '3px'});

        $(this).addClass('active');

    },function() {

        menu2.css({display: 'none'});

        $('.ar', this).html('&#9660;').css({top: '5px'});

        $(this).removeClass('active');

    });

    

    var button4 = $('#button4');

    var menu4 = $('#menutest4');

    

    $('ul li a', menu4).each(function() {

        $(this).append('<span />');

    });

    

    button4.toggle(function(e) {

        e.preventDefault();

        menu4.css({display: 'block'});

        $('.ar', this).html('&#9650;').css({top: '3px'});

        $(this).addClass('active');

    },function() {

        menu4.css({display: 'none'});

        $('.ar', this).html('&#9660;').css({top: '5px'});

        $(this).removeClass('active');

    });
    //Created by San
    var button5 = $('#button5');
    var menu5 = $('#menutest5');
	var button6 = $("#button6");
    var menu6 = $("#menutest6");
    var button7 = $("#button7");
    var menu7 = $("#menutest7"); 
    var button10 = $('#button');
    var menu10 = $('#menutest');
    menu10.css({display: 'none'});
    button10.click(function(){
        menu10.toggle();
        menu7.css({'display':'none'});
        menu6.css({'display':'none'});
        menu5.css({'display':'none'});
    });    
    menu5.css({display: 'none'});
    button5.click(function(){
        menu5.toggle();
        menu7.css({'display':'none'});
        menu6.css({'display':'none'});
        menu10.css({'display':'none'});
    });
    menu6.css({display: 'none'});
    button6.click(function(){
        menu6.toggle();
        menu7.css({'display':'none'});
        menu5.css({'display':'none'});
		menu10.css({'display':'none'});
    });
    menu7.css({display: 'none'});
    button7.click(function(){
        menu7.toggle();
        menu6.css({'display':'none'});
        menu5.css({'display':'none'});
		menu10.css({'display':'none'});
    });	
    <!-- end phan lam -->
    
    <!-- phan lam mua hang -->
    $('#shoping_customer').click(function(){
    	var selected = get_selected_values();
    	if (selected.length == 0){
            alert(<?php echo json_encode(lang('customers_must_select_for_shopping')); ?>);
            return false;
    	}
        if (selected.length > 1){
            alert(<?php echo json_encode(lang('customers_must_select_1_for_shopping')); ?>);
            return false;
    	}
        $(this).attr('href','<?php echo site_url("customers/shopping");?>/'+selected);
    });
    <!-- end phanlam mua hang -->
    
    //Created by San
    $("#check_list_send_mail").click(function(){
        var selected = get_selected_values();
    	if (selected.length == 0)
    	{
            alert("Bạn chưa chọn khách hàng nào");
            return false;
    	}
            // alert(selected);
            $(this).attr('href','<?php echo site_url("customers/save_list_send_mail");?>/'+selected.join('~'));
    });
    
    $("#sendmail_list").click(function(b){
        b.preventDefault();       
        tb_show($(this).attr("title"),$(this).attr("href"),false);
        $(this).blur();
        menu7.toggle();
    });
    $(".delete_email").click(function(){
        var id = $(this).attr("id");
        var parent = $(this).parent().parent();
        var data = "id=" + id;
        $.ajax({
            type: "post",
            url: "<?php echo site_url().'/customers/remove_mail_list';?>",
            data: data,
            success: function(data){
                $(parent).remove();
                $(".number_mail").html(data);
            }
        });
        return false;
    });
    $(".delete_all_email").click(function(){
        var id = $(this).attr("id");
        var parent = $(this).parent().parent().parent();
        var data = "id=" + id;
        $.ajax({
            type: "post",
            url: "<?php echo site_url().'/customers/remove_mail_list';?>",
            data: data,
            success: function(data){
                $(parent).remove();
                $(".number_mail").html(data);
                $(".table_mail").append("<tr><td colspan='3' style='text-align: center'>Không có mail nào</td></tr>");
            }
        });
        return false;
    });
    $("#employeesearch").change(function(){
        var employee_id = $("#employeesearch").val();        
        var data = "employee_id=" + employee_id;
        $.ajax({
            type: 'post',
            url: "<?php echo site_url().'/customers/save_session_employee';?>",
            data: data,
            success:function(){}
        });
        return false;
    });
    $("#categorysearch").change(function(){
        var type_customer = $("#categorysearch").val();        
        var data = "type_customer=" + type_customer;
        $.ajax({
            type: 'post',
            url: "<?php echo site_url().'/customers/save_session_type_customer';?>",
            data: data,
            success:function(){}
        });
        return false;
    });
    //SMS    
    $(".delete_contacts").click(function(){
        var id = $(this).attr("id");
        var parent = $(this).parent().parent();
        var data = "id=" + id;
        $.ajax({
            type: "post",
            url: "<?php echo site_url().'/customers/remove_contacts_list';?>",
            data: data,
            success: function(data){
                $(parent).remove();
                $(".number_contacts").html(data);
            }
        });
        return false;
    });
    $(".delete_all_contacts").click(function(){
        var id = $(this).attr("id");
        var parent = $(this).parent().parent().parent();
        var data = "id=" + id;
        $.ajax({
            type: "post",
            url: "<?php echo site_url().'/customers/remove_contacts_list';?>",
            data: data,
            success: function(data){
                $(parent).remove();
                $(".number_contacts").html(data);
                $(".table_contacts").append("<tr><td colspan='3' style='text-align: center'>Danh bạ trống</td></tr>");
            }
        });
        return false;
    });
});

function post_person_form_submit(response){
    if(!response.success){
        set_feedback(response.message,'error_message',true);
        $.get('<?php echo site_url("admin_agent/get_number_birthday");?>',{},function(data){
            $("#spansn").html(data.number);
            $("#menutest table tbody").remove();
            $.each(data.customers_birthday, function(key,value){
                $("#menutest table").append(
                    "<tbody><tr>"
                        + "<td><a class='a-menu' href='" + value.url +"'>" + value.first_name + " "+ value.last_name + "</a></td>"
                        + "<td style='text-align: center'>" + value.birth_date + "</td>"
                        + "<td style='text-align: center'>" + value.active + "</td>"
                    + "</tr></tbody>"
                );
            });
        },'json');
    }else{
        //This is an update, just update one row
        if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1){
            update_row(response.person_id,'<?php echo site_url("$controller_name/get_row_agent")?>');
            set_feedback(response.message,'success_message',false);
            $.get('<?php echo site_url("admin_agent/get_number_birthday");?>',{},function(data){
                $("#spansn").html(data.number);
                $("#menutest table tbody").remove();
                $.each(data.customers_birthday, function(key,value){
                    $("#menutest table").append(
                        "<tbody><tr>"
                            + "<td><a class='a-menu' href='" + value.url +"'>" + value.first_name + " "+ value.last_name + "</a></td>"
                            + "<td style='text-align: center'>" + value.birth_date + "</td>"
                            + "<td style='text-align: center'>" + value.active + "</td>"
                        + "</tr></tbody>"
                    );
                });
            },'json');
        }else{ //refresh entire table
            do_search(true,function(){
                //highlight new row
                highlight_row(response.person_id);
                set_feedback(response.message,'success_message',false);
                $.get('<?php echo site_url("admin_agent/get_number_birthday");?>',{},function(data){
                    $("#spansn").html(data.number);
                    $("#menutest table tbody").remove();
                    $.each(data.customers_birthday, function(key,value){
                        $("#menutest table").append(
                            "<tbody><tr>"
                                + "<td><a class='a-menu' href='" + value.url +"'>" + value.first_name + " "+ value.last_name + "</a></td>"
                                + "<td style='text-align: center'>" + value.birth_date + "</td>"
                                + "<td style='text-align: center'>" + value.active + "</td>"
                            + "</tr></tbody>"
                        );
                    });
                },'json');
            });
        }
    }
}
</script>
<?php if ($controller_name == 'customers'){?>
<div style="margin-top: -10px; float: right; margin-right: 10px;">

		<nav>

                    <ul class="group">
                        <?php 
                        $this->load->model('sale');
                        $date_pay = null ;
                        ?>						
                        <li>
                            <a id="button7">Danh sách gửi mail tạm</a>
                            <?php
                            if(isset($_SESSION['mail']) && $_SESSION['mail']!=NULL){
                                echo "<span id='spankhn' class='kh number_mail'>".count($_SESSION['mail'])."</span>";
                            }
                            ?>
                            <div id="menutest7" class="menu-togged" style="width: 500px !important; display: none;">
                                <table class="mytable table_mail" cellspacing="0" style="width: 100%; margin: 0px !important;">
                                     <thead>
                                        <tr>                                            
                                            <th style="text-align:center;">Tên KH</th>
                                            <th style="text-align:center;">Email</th>
                                            <th></th>
                                        </tr>                                      
                                    </thead>
                                <?php
                                if(isset($_SESSION['mail']) && $_SESSION['mail']!=NULL){
                                ?>                                
                                    <tbody>
                                        <?php
                                        foreach ($_SESSION['mail'] as $value){
                                        ?>
                                        <tr>
                                            <td style="width: 40%"><?php echo $value['name'];?></td>
                                            <td style="width: 40%"><?php echo $value['email']?></td>
                                            <td style="width: 20%; text-align: center;">
                                                <a style="width: 25px !important;" class="delete_email a-menu" id="<?php echo $value['person_id'];?>">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <?php echo anchor("$controller_name/send_mail?type_send=1",
                                                    'Gửi mail',
                                                    array(
                                                        'class' => 'bulk_edit_inactive submit_button float_right', 
                                                        'id'    =>'sendmail_list', 
                                                        'title' =>'Gửi mail',
                                                        'style' => 'width: 50px !important;',
                                                    ));
                                                ?>
                                            </td>
                                            <td>
                                                <a style="width: 65px !important;" class="delete_all_email a-menu" id="0">Xóa tất cả</a>
                                            </td>
                                        </tr>
                                    </tbody>                                
                                <?php
                                }else{
                                    echo "<tr>";
                                        echo "<td colspan='3' style='text-align: center'>Không có mail nào</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </table>
                            </div>
                        </li>
                        <li>
                            <a id="button6">Hợp đồng sắp hết hạn</a>                            
                            <?php 
                            if($ids!=NULL){
                            ?>
                                <span id="spankhn" class="kh"><?php echo count($ids);?></span> 
                            <?php
                            }
                            ?>
                            <div id="menutest6" class="menu-togged" style="width: 800px;display: none;">                                
                                <table class="mytable" cellspacing="0" style="width: 100%; margin: 0px !important;">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Mã HĐ</th>
                                            <th style="text-align:center;">Tên HĐ</th>
                                            <th style="text-align:center;">Tên KH</th>
                                            <th style="text-align:center;">Số HĐ</th>
                                            <th style="text-align:center;">Ngày ký</th>
                                            <th style="text-align:center;">Ngày hết hạn</th>                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($ids!=NULL){
                                            foreach ($ids as $id){
                                                $info_contrac = $this->Contractcustomers->get_info_contraccustomer_expried($id);
                                                echo "<tr>";
                                                    echo "<td style='width: 10%px !important'>".$info_contrac['code_contract']."</td>";
                                                    echo "<td style='width: 20%px !important;'><a href='".site_url()."/contractcustomer/view/".$id."/width~470/height~440' class='thickbox detail_contract'>".$info_contrac['name']."</a></td>";
                                                    echo "<td style='width: 20%px !important'>".$info_contrac['first_name']." ".$info_contrac['last_name']."</td>";
                                                    echo "<td style='width: 5%px !important'>".$info_contrac['number_contract']."</td>";
                                                    echo "<td style='width: 10%px !important'>".date('d-m-Y',strtotime($info_contrac['start_date']))."</td>";
                                                    echo "<td style='width: 10%px !important'>".date('d-m-Y',strtotime($info_contrac['end_date']))."</td>";
                                                    echo "<td style='width: 10%px !important'>";//                                                   
                                                       echo form_open('contractcustomer/send_mail');
                                                            echo form_hidden('person_id',$info_contrac['person_id']);
                                                            echo form_hidden('id_contract',$info_contrac['id']);
                                                            echo form_submit(array(
                                                                    'class' =>'submit_button float_right',
                                                                    'name'  =>'send_mail',
                                                                    'value' => 'Gửi mail'
                                                                ));
                                                       echo form_close();
                                                    echo "</td>";                                                    
                                                echo "</tr>";
                                            }                                        
                                        }else{
                                            echo "<tr>";
                                                echo "<td style='text-align: center' colspan='7'>Không có hợp đồng nào sắp hết hạn</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div> 
                        </li>
                        <li>
                            <a id="button5">Nợ</a>                            
                            <?php if($suspends_date != null){ ?>
                                <span id="spankhn" class="kh"><?php echo count($suspends_date); ?></span>
                             <?php } ?>
                            <div id="menutest5" class="menu-togged" style="width: 500px !important; display: none;">
                                <table class="mytable" cellspacing="0" style="width: 100%; margin: 0px !important;">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Tên</th>
                                            <th style="text-align:center;">SĐT</th>
                                            <th style="text-align:center;">Thành phố</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($suspends_date != null){
                                        $this->load->model('Customer');
                                        foreach ($suspends_date as $suspend_date){
                                        ?>
                                            <tr>
                                                <td>
                                                    <a class="a-menu" href="<?php echo site_url('reports/specific_'.( 'customer').'/'.$start_of_time.'/'.$today.'/'.$suspend_date['customer_id'].'/all/0') ?>">
                                                    <?php 
                                                    if($suspend_date['customer_id'] != null){
                                                        echo $this->Customer->get_info($suspend_date['customer_id'])->first_name;
                                                        echo " ".$this->Customer->get_info($suspend_date['customer_id'])->last_name;
                                                    }else echo "Khách hàng ko tên";
                                                    ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $this->Customer->get_info($suspend_date['customer_id'])->phone_number; ?></td>
                                                <?php 
                                                $this->load->model('customer');
                                                $name_city = $this->Customer->get_city($this->Customer->get_info($suspend_date['customer_id'])->city);
                                                 ?>
                                                <td><?php echo $name_city[0]['name']; ?></td>
                                                <td>
                                                <?php 
                                                echo form_open('sales/unsuspend');
                                                echo form_hidden('suspended_sale_id', $suspend_date['sale_id']);
                                                ?>
                                                <input type="submit" name="submit" value="<?php echo lang('sales_unsuspend'); ?>" id="submit_unsuspend" class="submit_button float_right">
                                                </form>
                                                </td>
                                            </tr>
                                        <?php }                                  
                                    }else{
                                        echo "<tr>";
                                            echo "<td style='text-align: center' colspan='4'>Không có đơn hàng nợ</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>                            
                        </li>
                        <li>
                            <a id="button">Sinh nhật</a>
                            <?php if ($customer != null) { ?>
                                <span id="spansn"><?php echo count($customer); ?></span> 
                            <?php } ?>
                            <div id="menutest" class="menu-togged" style="width: 500px !important; display: none;">
                                <?php 
                                    $start_of_time =  date('d-m-Y', 0);
                                    $today = date('d-m-Y');                                   
                                    ?>
                                    <table class="mytable" cellspacing="0" style="width: 100%; margin: 0px !important;">
                                        <thead>
                                            <th style="text-align:center;">Tên</th>
                                            <th style="text-align:center;">Birth_date</th>
                                            <th style="text-align:center;">Gửi mail</th>
                                        </thead>                                       
                                        <tbody>
                                        <?php  if ($customer != null){
                                            $this->load->model('Customer');
                                            foreach ($customer as $customer1){
                                                $customer2=$this->Customer->findPerson($customer1['person_id']);
                                                $customer3 = $this->Customer->get_customer_mail_auto($customer1['person_id']);
                                            ?>
                                            <tr>
                                                <td>
                                                    <a class="a-menu" href="<?php echo site_url('reports/specific_'.( 'customer').'/'.$start_of_time.'/'.$today.'/'.$customer2[0]['person_id'].'/all/0') ?>"><?php echo $customer2[0]['first_name'].' '.$customer2[0]['last_name']; ?></a>
                                                </td>
                                                <td style="text-align: center">
                                                    <?php echo date("d-m-Y", strtotime($customer2[0]['birth_date'])); ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    if($customer3['active']==1){
                                                        echo "Đã gửi";
                                                    }else{
                                                        echo "Chưa gửi";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                        }else{
                                            echo "<tr>";
                                                echo "<td style='text-align: center' colspan='3'>Không có khách hàng sinh nhật</td>";
                                            echo "</tr>";
                                        }
                                        ?>                                            
                                        </tbody>
                                    </table>                                    
                            </div>
                        </li>
                        <li style="position:relative;display:none !important">
                            <a id="button4">Khách hàng mới</a>
                            <?php if($register_date != null){ ?>
                            <span id="spankh" class="kh"><?php echo count($register_date); ?></span> 
                        </li>
                        <?php } ?>
                        <li style="position:relative;display:none !important">
                            <a class="thickbox none"
                        href="<?php echo base_url(); ?>sales/suspended/width~600" >Đơn hàng</a>
                            <?php if ($suspended_sales != null) { ?>
                            <span id="spansn"><?php echo count($suspended_sales); ?></span> </li>
                            <?php } ?>
                        </li>
                        <li style="position:relative;display:none !important"><a id="button2" >Hết hàng</a>
                            <?php if($items != null){ ?>
                            <span  ><?php echo count($items); ?></span>
                            <?php } ?>
                        </li>
                        <li style="position:relative;display:none !important">
                            <a class="thickbox none" href="<?php echo base_url(); ?>sales/suspended_web/width~600">Đơn hàng trên web</a> 
                            <?php if ($payment_date!= null) { ?>
                                <span id="spansn"><?php echo count($payment_date); ?></span> </li>
                            <?php } ?>
                        </li>
                        <li>
                            <a id="button8">SMS</a>
                            <?php if($number_sms){
                                echo "<span id='spansms' class='kh number_sms'>".$number_sms['quantity_sms']."</span>";
                            }
                            ?>
                        </li>
                    </ul>
				<div id="menutest4">
                    <?php 
					if ($register_date != null){
					$this->load->model('Customer');
					?>
					<table class="mytable" cellspacing="0">
						<thead>
							<th style="text-align:center;">Tên</th>
							<th style="text-align:center;">SĐT</th>
							<th style="text-align:center;">Thành phố</th>
						</thead>
						<tbody>
							<?php foreach ($register_date as $register_dates){
							?>
							<tr>
							<td><a href="<?php echo site_url('reports/specific_'.( 'customer').'/'.$start_of_time.'/'.$today.'/'.$register_dates['person_id'].'/all/0') ?>"><?php echo $register_dates['first_name'] ?></a></td>
							<td><?php echo $register_dates['phone_number']; ?></td>
							<?php 
							$this->load->model('customer');
							$name_city = $this->Customer->get_city($register_dates['city']);
							 ?>
							<td><?php echo $name_city[0]['name']; ?></td>
							</tr>
						<?php	} ?>
						</tbody>
					</table>
					<?php } else echo "không có khách hàng trong hôm nay"; ?>
				</div>
                    
			

                    <div id="menutest2" style="display: none;">

					<?php

                    if ($items != null){

					$this->load->model('Customer');

					?>

					<table class="mytable" cellspacing="0">

						<thead>

							<th style="text-align:center;">Tên</th>

							<th style="text-align:center;">Số lượng</th>

							<th style="text-align:center;">Mức ngưỡng</th>

						</thead>

						<tbody>

							<?php for ($i=0;$i< count($items);$i++){

						$item_info=$this->Item->get_info($items[$i]);

							?>

							<tr>

							<td><a href="<?php echo base_url(); ?>items/switch_receving/<?php echo $item_info->item_id;  ?>"><?php echo $item_info->name; ?></a></td>

							<td><?php echo $item_info->quantity; ?></td>

							<td><?php echo $item_info->reorder_level; ?></td>

							</tr>

						<?php	} ?>

						</tbody>

					</table>

					<?php } else echo "Chưa có mặt hàng nào hết hàng"; ?>

				</div>
		  </nav>
</div>

<?php } 

            	$region = $this->Jobs_regions->get_region_id($this->Employee->get_logged_in_employee_info()->person_id);
            	$city = $this->Jobs_city->get_city_id($this->Employee->get_logged_in_employee_info()->person_id);
            	$aff = $this->Jobs_affiliates->get_aff_id($this->Employee->get_logged_in_employee_info()->person_id);
            	$dep = $this->Jobs_department->get_dep_id($this->Employee->get_logged_in_employee_info()->person_id);
?>

<table id="title_bar_new">
    <tr>
        <td id="title_icon">
            <a href="<?php echo base_url()?><?php echo $controller_name; ?>"><img src='<?php echo base_url()?>images/menubar/<?php echo $controller_name; ?>.png' alt='title icon' /></a>
        </td>
        <?php if($controller_name == 'customers') {?>
        <td id="title">
            <a href="<?php echo base_url()?><?php echo $controller_name; ?>"><?php echo lang('common_list_of').' '.lang('module_'.$controller_name); ?></a>
        </td>
        <?php }else{?>
         <td id="title" style="width:720px; font-size: 20px; line-height: 22px  ">
            <a href="<?php echo base_url()?><?php echo $controller_name; ?>">
            	<?php 
            	
            	if( $region->num_rows() > 0){ 
					$job_name= $region->row()->jobs_regions_name;
            	}elseif( $city->num_rows() > 0){ 
					$job_name= 'Thành phố '.$city->row()->jobs_city_name;
            	}elseif( $aff->num_rows() > 0){ 
					$job_name= $aff->row()->jobs_affiliates_name;
            	}elseif( $dep->num_rows() > 0){ 
					$job_name= $dep->row()->department_name;
            	}else{
            		$job_name=' ';
            	} 
            	echo lang('common_list_of').' '.lang('module_'.$controller_name)." $job_name"; ?></a>
            	
        </td>
        <?php }?>
        
        
        <?php $type_customers = $this->Customer->get_Customer_type(); ?>
        <td id="title_search_new" >
            <?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
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
            <?php if ($controller_name == 'employees' ) {?>
            <br />
                <?php if( $this->Employee->get_logged_in_employee_info()->person_id == 1){
                    if ($this->Employee->has_module_action_permission('regions', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("regions",$this->lang->line('common_regions'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_regions')
                        ));
                    }
                    if ($this->Employee->has_module_action_permission('city', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("citys",$this->lang->line('common_citys'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_city')
                        ));
                    }
                    if ($this->Employee->has_module_action_permission('affiliates', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("affiliates",$this->lang->line('common_department'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_department')
                        ));
                    }	
                    if ($this->Employee->has_module_action_permission("department", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("department",$this->lang->line('common_affiliates'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_affiliates')
                        ));
                    }	
                }else if($region->num_rows() > 0){
                    if ($this->Employee->has_module_action_permission('city', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("citys",$this->lang->line('common_citys'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_city')
                        ));
                    }
                    if ($this->Employee->has_module_action_permission('affiliates', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("affiliates",$this->lang->line('common_department'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_department')
                        ));
                    }	
                    if ($this->Employee->has_module_action_permission("department", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("department",$this->lang->line('common_affiliates'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_affiliates')
                        ));
                    }	
                }else if($city->num_rows() > 0){ 
                    if ($this->Employee->has_module_action_permission('affiliates', 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("affiliates",$this->lang->line('common_department'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_department')
                        ));
                    }	
                    if ($this->Employee->has_module_action_permission("department", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("department",$this->lang->line('common_affiliates'),array(
                            'class'=>'none new',
                            'title'=>$this->lang->line($controller_name.'_affiliates')
                        ));

                    }	
                }else if($aff->num_rows() > 0 ){
                            if ($this->Employee->has_module_action_permission("department", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

                                    <?php echo anchor("department",

                                    $this->lang->line('common_affiliates'),

                                    array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_affiliates')));

                            }	
                }else if($dep->num_rows() > 0 ){
                }else{
                }
             ?>

                    <?php if ($this->Employee->has_module_action_permission("positions", 'search', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

                            <?php echo anchor("positions",

                            $this->lang->line('common_postions'),

                            array('class'=>'none new', 'title'=>$this->lang->line($controller_name.'_postions')));

                    }	

                    ?>
                    <!--uyen xoa
                    <?php
                     if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

                            <?php echo anchor("$controller_name/view/-1/width~$form_width",

                            $this->lang->line($controller_name.'_new'),

                                    array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));

                    }	

                    ?>
uyen -->
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
                    <?php

                    if ($controller_name == 'customers' ) {	


                     if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

                            <?php echo anchor("$controller_name/view/-1/width~$form_width",

                            $this->lang->line($controller_name.'_new'),

                                    array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));

                    }
                     echo anchor("customer_type",'Nhóm KH - Đại lý',
                                    array('class'=>'none new', 'title'=>'Nhóm KH - Đại lý'));
                    echo anchor("admin_agent",'Đại lý',
                                    array('class'=>'none new', 'title'=>'Đại lý'));
                    if ($this->sale_lib->get_customer() == -1){

                            echo anchor("$controller_name/shopping",

                            lang('customers_shopping'),

                            array('class'=>'none','id'=>'shoping_customer'));

                    }

                    else {

                            echo anchor("$controller_name",

                            lang('customers_shopping_exits'),

                            array('class'=>'none','id'=>'shoping_customer'));

                    }

                    }

                    ?>
 
                    <!-- agent-->
                      <?php

                    if ($controller_name == 'admin_agent' ) {	


                     if ($this->Employee->has_module_action_permission($controller_name, 'add_update', $this->Employee->get_logged_in_employee_info()->person_id)) {?>

                            <?php echo anchor("$controller_name/view/-1/width~$form_width",

                            $this->lang->line($controller_name.'_new'),

                               array('class'=>'thickbox none new', 'title'=>$this->lang->line($controller_name.'_new')));

                    }
                    

                    }

                    ?>


                    <style type="text/css">

                    #shoping_customer{background-position: -10px -130px;}

                    </style>

                    <!-- end phan lam -->



                    <?php
                    if ($controller_name == 'customers' ) {
                        echo anchor("$controller_name/excel_import/width~500",lang('common_excel_import'),array(
                            'class'=>'thickbox none import',
                            'title'=>lang('customers_import_customers_from_excel')
                        ));					
                        echo anchor("$controller_name/excel_export",lang('common_excel_export'),array(
                            'class'=>'none import'
                        ));			
                    }
                    if ($this->Employee->has_module_action_permission($controller_name, 'delete', $this->Employee->get_logged_in_employee_info()->person_id)) {
                        echo anchor("$controller_name/delete",$this->lang->line("common_delete"),array(
                            'id'=>'delete',
                            'class'=>'delete_inactive'
                        ));                                    
                    } 
                    if ($controller_name =='customers') {
                        echo anchor("$controller_name/cleanup",lang("customers_cleanup_old_customers"),array(
                            'id'=>'cleanup',
                            'class'=>'cleanup'
                        )); 
                        echo anchor("contractcustomer",'Hợp đồng khách hàng',array(
                            'class'=>'none new',
                            'title'=>'Hợp đồng khách hàng'
                        ));
                        echo anchor("$controller_name/manage_mail",'Quản lý mail',array(
                            'class'=>'none new',
                            'title'=>'Quản lý mail',
                            'target' => '_blank'
                        ));
                        echo anchor("$controller_name/send_mail?type_send=0",'Gửi mail',array(
                            'class' => 'bulk_edit_inactive',
                            'id' =>'sendmail',
                            'title'=>'Gửi mail'
                        ));
                        echo anchor("$controller_name/save_list_send_mail",'Vào danh sách gửi mail tạm',array(
                            'id'    => 'check_list_send_mail',
                            'class' => 'bulk_edit_inactive none new', 
                            'title' => 'Vào danh sách gửi mail tạm',                                            
                        ));
                        echo anchor("$controller_name/manage_sms",'Quản lý SMS Brandname',array(
                            'id'    => 'check_list_Brandname',
                            'class' => 'none new', 
                            'title' => 'Quản lý SMS Brandname',                                            
                        ));
                        echo anchor("$controller_name/send_sms?type_send=0",'Gửi SMS',array(
                            'class' => 'sms_inactive none new',
                            'id' =>'sendsms',
                            'title'=>'Gửi SMS',
                        ));                      
                    }
                    
                    if ($controller_name =='admin_agent') {
                       
                        echo anchor("contractcustomer",'Hợp đồng đại lý',array(
                            'class'=>'none new',
                            'title'=>'Hợp đồng khách hàng'
                        ));
                        echo anchor("$controller_name/manage_mail",'Quản lý mail',array(
                            'class'=>'none new',
                            'title'=>'Quản lý mail',
                            'target' => '_blank'
                        ));
                        echo anchor("$controller_name/send_mail?type_send=0",'Gửi mail',array(
                            'class' => 'bulk_edit_inactive',
                            'id' =>'sendmail',
                            'title'=>'Gửi mail'
                        ));
                        echo anchor("$controller_name/save_list_send_mail",'Vào danh sách gửi mail tạm',array(
                            'id'    => 'check_list_send_mail',
                            'class' => 'bulk_edit_inactive none new', 
                            'title' => 'Vào danh sách gửi mail tạm',                                            
                        ));
                        echo anchor("$controller_name/manage_sms",'Quản lý SMS Brandname',array(
                            'id'    => 'check_list_Brandname',
                            'class' => 'none new', 
                            'title' => 'Quản lý SMS Brandname',                                            
                        ));
                        echo anchor("$controller_name/send_sms?type_send=0",'Gửi SMS',array(
                            'class' => 'sms_inactive none new',
                            'id' =>'sendsms',
                            'title'=>'Gửi SMS',
                        ));                      
                    }
                ?>
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