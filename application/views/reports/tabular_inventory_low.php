<?php $this->load->view("partial/header"); ?>
<style type="text/css">
.center{
	text-align: center;
	} 
.right{
	text-align: right;
	} 	
</style> 
<script type="text/javascript">

    $(document).ready(function () {
        $(".print_report1").click(function () {
            window.print();
        });

        $(".print_report").click(function ()
        {

            window.print();
        });

    });
</script>
<style type="text/css">
    .print_report{
        background: none repeat scroll 0 0 #1E5A96;
        border: 1px solid #EEEEEE;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        line-height: 30px;
        margin-left: 9px;
        padding: 5px;
        text-align: center;
        width: 100px;
    }
</style>
<div id="content_area_wrapper">
<div id="content_area">
<table id="title_bar_new">
	<tr>
		<td id="title_icon">
			<img src='<?php echo base_url()?>images/menubar/reports.png' alt='<?php echo lang('reports_reports'); ?> - <?php //echo $title; ?>' />
		</td>
		<td id="title" style="font-size: 20px;"><?php echo lang('reports_reports'); ?> - <?php echo $title ?></td>
		<td><a style="font-size:18px;text-decoration: underline; float: right;margin-right:30px; color: #FFF" href=<?php echo base_url().$link; ?>>Trở lại</a></td>
	</tr>
	<tr style="margin-top: 8px;">
		<td>&nbsp;</td>
		<td><small style="font-size: 15px; font-style: italic"><?php echo $subtitle ?></small></td>
		<td>&nbsp;</td>
	</tr>
	
</table>

<br /><div style="color:#000">
<table id="contents">
    <tr>
        <td id="item_table">
            <div id="table_holder" style="width: 960px;">
                <table class="tablesorter report" id="sortable_table" style="font-size: 16px">
                    <thead>
                        <tr>
                            <th style="text-align: center">Mã hàng</th>
                            <th style="text-align: center">Tên mặt hàng</th>
                            <th style="text-align: center">Mô tả</th>
                            <th style="text-align: center">Giá gốc</th>
                            <th style="text-align: center">Đơn giá </th> 
                            <th style="text-align: center">ĐVT </th>  
                            <th style="text-align: center">Số lượng </th>
                            <th style="text-align: center">Mức đặt hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach($data as $key => $d){?>
                        
                      <tr>  
                        <td class="center"><?php echo $d['item_number']?></td>
                        <td class="center"><?php echo $d['name']?></td>
                        <td class="center"><?php echo $d['description']?></td>
                        <td class="right"><?php echo number_format($d['cost_price']) ?></td>
                        <td class="right"><?php echo number_format($d['unit_price']) ?></td>
                        <td class="center"><?php echo $this->Unit->get_info($d['unit'])->name;?></td>
                        <td class="center"><?php echo number_format($d['quantity']) ?></td>
                        <td class="center"><?php echo $d['reorder_level'] ?></td>
                      </tr>    
                    <?php 
                    } ?> 
                    </tbody>
                </table>
            </div>
            
        </td>
    </tr>
</table>
<div id="feedback_bar"></div>
</div></div></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
function init_table_sorting()
{
	//Only init if there is more than one row-
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(); 
	}
}
$(document).ready(function()
{
	init_table_sorting();
});
</script>
