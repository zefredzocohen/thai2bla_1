<table class="table_detail">    
    <tr>        
        <th>Tên kho</th>
        <th>Số lượng</th>
    </tr>   
    <tr>
        <td>Kho tổng</td>
        <td style='text-align: center'><?php echo format_quantity($info_item->quantity_total);?></td>
    </tr>   
    <?php 
    foreach ($list_item_warehouse as $value){
        $this->load->model("Create_invetory");
        $info_invetory = $this->Create_invetory->get_info($value['warehouse_id']);
        echo "<tr>";
            echo "<td>".$info_invetory->name_inventory."</td>";
            echo "<td style='text-align: center'>".format_quantity($value['quantity'])."</td>";
        echo "</tr>";
    }
    ?>
</table>
<style>
    .table_detail{
        border-collapse: collapse;
    }
    .table_detail th{
        text-align: center;
        background: #C0C0C0;
    }
    .table_detail th, .table_detail td{
        border: 1px solid #CCCCCC;
        padding: 5px 10px;
    }
</style>