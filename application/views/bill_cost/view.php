<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">
    table{
        border: 1px solid #ccc;
        border-collapse: collapse;
        width: 100%;
    }
    tr th{
        background: #37B2C9;
        font-size: 14px;
        color: white;
        line-height: 30px;
        font-family: 'OpenSansLight', sans-serif;
    }

</style>
<table>
    <tr>
        <th>Ngày thu chi</th>
        <th>Số chứng từ</th>
        <th>Ngày CT</th>
        <th>Nội dung</th>
        <th>TK nợ</th>
        <th>Tk có</th>
        <th>KH-NCC-NV</th>
        <th>Nhân viên</th>
        <th>Số tiền</th>
        <th>Hình thức</th>
    </tr>
    <tr>
        <?php
        $this->load->model('Cost');
        $this->load->model('Customer');
        $this->load->model('Supplier');
        $this->load->model('Employee');
        $id = $this->uri->segment('3');
        $date = $this->Cost->get_info($id)->date;
        $date_ct = $this->Cost->get_info($id)->cost_date_ct;

        if ($this->Customer->exists($id->id_customer)) {
            $name = $this->Person->get_info($id->id_customer)->first_name
                    . ' ' . $this->Person->get_info($id->id_customer)->last_name;
        } elseif ($this->Supplier->exists($id->id_customer)){
             $name = $this->Supplier->get_info($id->id_customer)->company_name;
        } elseif ($this->Employee->exists($id->employees_id)) {
            $name = $this->Person->get_info($id->employees_id)->first_name
                    . ' ' . $this->Person->get_info($id->employees_id)->last_name;
        } else {
            $name = $this->Person->get_info($id->id_customer)->first_name
                    . ' ' . $this->Person->get_info($id->id_customer)->last_name;
        }
        ?>
        <td><?= date('d-m-Y H:i:s', strtotime($date)) ?></td>
        <td align="center"><?= $this->Cost->get_info($id)->id_cost ?></td>
        <td><?= date('d-m-Y H:i:s', strtotime($date_ct)) ?></td>
        <td><?= $this->Cost->get_info($id)->comment ?></td>
        <td align="center"><?= $this->Cost->get_info($id)->tk_no ?></td>
        <td align="center"><?= $this->Cost->get_info($id)->tk_co ?></td>
        <td><?=$name?></td>
        <td><?=$this->Person->get_info($this->Cost->get_info($id)->cost_employees)->first_name
            . ' ' . $this->Person->get_info($this->Cost->get_info($id)->cost_employees)->last_name?></td>
        <td align="center"><?= number_format($this->Cost->get_info($id)->money) ?></td>
        <td align="center"><?= $this->Cost->get_info($id)->form_cost == 0 ? "Thu" :"Chi"?></td>
    </tr>
</table>