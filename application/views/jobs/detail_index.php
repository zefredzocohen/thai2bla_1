<?php $this->load->view("partial/header"); ?>
<style type="text/css">
    h2#info_jobs{
        color: #FFF;
        font-size: 16px;
        height: 37px;
        line-height: 37px;
        text-align: left;
        padding-left: 10px;
        width: 25%;
        margin-left: 96px;
        background: CORNFLOWERBLUE;
    }
    #inventory_jobs{
        width: 80%;
        margin: 0 auto;
        font-size: 10px;
    }
    #inventory_jobs tr td{
        border: 1px solid #CCC;
        padding-left: 7px;
        font-size: 13px;
        color: #232323;
        height: 35px;
        line-height: 35px;
    }
    #inventory_jobs tr td:first-child{
        width: 20%;
    }
</style>

<h2 id="info_jobs">Thông tin chi tiết công việc</h2>
<table id="inventory_jobs">
	<tr>
		<td class="first">Tên công việc : </td>
		<td class="end"><?php echo $jobs_info->jobs_name; ?></td>
    </tr>
     <tr>
        <td>Nội dung công việc : </td>
        <td style="height: 80px"><?php echo $jobs_info->jobs_content; ?></td>
    </tr>
    <tr>
        <td>Văn bản đính kèm : </td>
        <td><?php echo $jobs_info->jobs_url_file; ?></td>
    </tr>

    <tr>
        <td>Độ quan trọng : </td>
        <?php foreach($jobs_important AS $values):
            if($values->jobs_important_id == $jobs_info->jobs_important){
            ?>
                <td><?php echo $values->jobs_important_name ?></td>
        <?php }else{
                echo '';
            }
        endforeach; ?>
    </tr>
    <tr>
        <td>Ngày giao việc : </td>
        <td><?php echo date('d-m-Y',strtotime($jobs_info->jobs_end_date)) ?></td>
    </tr>
    <tr>
        <td>Hạn hoàn thành : </td>
        <td><?php echo date('d-m-Y',strtotime($jobs_info->jobs_start_date)); ?></td>
    </tr>
    <tr>
        <td>Trạng thái : </td>
        <?php foreach($jobs_status AS $values):
            if($values->jobs_status_id == $jobs_info->jobs_status_id){
                ?>
                <td><?php echo $values->jobs_status_name ?></td>
            <?php }else echo ''; endforeach; ?>
    </tr>
</table>