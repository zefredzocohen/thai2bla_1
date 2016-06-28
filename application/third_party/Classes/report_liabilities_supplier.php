<?php

$count = count($data);
$this->load->library('Excel');
$objPHPExcel = new PHPExcel();
$this->excel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->setShowGridlines(true);
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(9);
$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$this->excel->getActiveSheet()->getPageMargins()->setRight(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.25);
$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTop(array(7, 7));
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('Bao_cao_cong_no_ncc');
$this->excel->setActiveSheetIndex(0)->mergeCells('A1:F1');
$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
$this->excel->getActiveSheet()->setCellValue('A1', $this->config->item('company'));
$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(18);

$this->excel->setActiveSheetIndex(0)->mergeCells('A2:F2');
$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
$this->excel->getActiveSheet()->setCellValue('A2', $this->config->item('address'));
$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);

$this->excel->setActiveSheetIndex(0)->mergeCells('A4:F4');
$this->excel->getActiveSheet()->setCellValue('A4', "BÁO CÁO CHI TIẾT CÔNG NỢ NHÀ CUNG CẤP");
$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(14)->setBold(true);
$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(18);

$this->excel->getActiveSheet()->setCellValue('A5', 'Từ ' . date('d-m-Y', strtotime($start_date)) . ' đến ' . date('d-m-Y', strtotime($end_date)));
$this->excel->setActiveSheetIndex(0)->mergeCells('A5:F5');
$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(10)->setItalic(true);
$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(18);

$this->excel->getActiveSheet()->setCellValue('A7', "Nhà cung cấp/Mã ĐH");
$this->excel->getActiveSheet()->setCellValue('B7', "Giá trị ĐH");
$this->excel->getActiveSheet()->setCellValue('C7', "CK đơn hàng");
$this->excel->getActiveSheet()->setCellValue('D7', "Tổng thanh toán(Bao gồm cả thuế và chi phí)");
$this->excel->getActiveSheet()->setCellValue('E7', "Đã thanh toán");
$this->excel->getActiveSheet()->setCellValue('F7', "Còn nợ");

$this->excel->getActiveSheet()->getStyle('A7:F7')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A7:F7')->getFill()->applyFromArray(array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
        'rgb' => "CACACA"
    )
));

$k = 8;
$data_sup = array();
if ($supplier_id) {
    $data_sup[] = array("supplier_id" => $supplier_id);
} else {
    $data_list_supplier = $this->Supplier->get_all_supplier();
    foreach ($data_list_supplier as $sup) {
        $data_sup[] = array("supplier_id" => $sup['person_id']);
    }
}
$total_gia_tri_dh = 0;
$total_chiet_khau = 0;
$total_tong_thanh_toan = 0;
$total_da_thanh_toan = 0;
$total_con_no = 0;
$total_taxe = 0;//tổng thuế
$total_other_cost = 0;//tổng chi phí
foreach ($data_sup as $d_s) {
    $data_receiving_supplier = $this->Receiving->get_supplier_owe($d_s['supplier_id'], $start_date, $end_date);
    $sub_gia_tri_dh = 0;
    $sub_chiet_khau = 0;
    $sub_tong_thanh_toan = 0;
    $sub_da_thanh_toan = 0;
    $sub_con_no = 0;
    if ($data_receiving_supplier) {
        foreach ($data_receiving_supplier as $val) {
            $total_taxe += $this->Receiving->get_info($val['receiving_id'])->row()->money_1331;
                            $total_other_cost += $this->Receiving->get_info($val['receiving_id'])->row()->other_cost;
            $receiving_items = $this->Receiving->get_item_receiving2($val['receiving_id'])->result();
            $gia_tri_dh = 0;
            $chiet_khau = 0;
            $tong_thanh_toan = 0;
            $da_thanh_toan = 0;
            $con_no = 0;
             
            foreach ($receiving_items as $val1) {
                                if ($val1->rate_currency) {
                                    $gia_tri_dh += $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100 + ($val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100) * $val1->taxes / 100;
                                } else {
                                    $gia_tri_dh += $val1->quantity_purchased * $val1->item_unit_price - $val1->quantity_purchased * $val1->item_unit_price * $val1->discount_percent / 100;
                                }
                            }
            $receiving_tam = $this->Receiving->get_receiving_tam_by_id($val['receiving_id']);
            foreach ($receiving_tam as $r_t) {
                $da_thanh_toan += $r_t->pays_amount;
                $chiet_khau += $r_t->discount_money;
            }
            $sub_gia_tri_dh += $gia_tri_dh;
            $sub_chiet_khau += $chiet_khau;
            $sub_tong_thanh_toan += ($gia_tri_dh + $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost- $chiet_khau);
            $sub_da_thanh_toan += $da_thanh_toan;
            $sub_con_no += ($gia_tri_dh + $total_taxe + $total_other_cost - $chiet_khau - $da_thanh_toan);
        }
        $total_gia_tri_dh += $sub_gia_tri_dh;
        $total_chiet_khau += $sub_chiet_khau;
        $total_tong_thanh_toan += $sub_thanh_toan;
        $total_da_thanh_toan += $sub_da_thanh_toan;
        $total_con_no += $sub_con_no;
        $info_sup = $this->Supplier->get_info($d_s['supplier_id']);
        $this->excel->getActiveSheet()->setCellValue('A' . $k, $info_sup->company_name);
        $this->excel->getActiveSheet()->setCellValue('B' . $k, number_format($sub_gia_tri_dh));
        $this->excel->getActiveSheet()->setCellValue('C' . $k, number_format($sub_chiet_khau));
        $this->excel->getActiveSheet()->setCellValue('D' . $k, number_format($sub_tong_thanh_toan));
        $this->excel->getActiveSheet()->setCellValue('E' . $k, number_format($sub_da_thanh_toan));
        $this->excel->getActiveSheet()->setCellValue('F' . $k, number_format($sub_con_no));
        $this->excel->getActiveSheet()->getRowDimension($k)->setRowHeight(18);
        $this->excel->getActiveSheet()->getStyle('A' . $k . ':F' . $k)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A' . $k . ':F' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B' . $k . ':F' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('A' . $k . ':F' . $k)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => "EFEFEF"
            )
        ));
        foreach ($data_receiving_supplier as $val) {
            $receiving_items = $this->Receiving->get_item_receiving2($val['receiving_id'])->result();
            $gia_tri_dh = 0;
            $chiet_khau = 0;
            $da_thanh_toan = 0;
            foreach ($receiving_items as $val1) {
                                if ($val1->rate_currency) {
                                    $gia_tri_dh1 += $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100 + ($val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency - $val1->quantity_purchased * $val1->item_unit_price * $val1->rate_currency * $val1->discount_percent / 100) * $val1->taxes / 100;
                                } else {
                                    $gia_tri_dh1 += $val1->quantity_purchased * $val1->item_unit_price - $val1->quantity_purchased * $val1->item_unit_price * $val1->discount_percent / 100 ;
                                }
                            }
            $receiving_tam = $this->Receiving->get_receiving_tam_by_id($val['receiving_id']);
            foreach ($receiving_tam as $r_t) {
                $da_thanh_toan += $r_t->pays_amount;
                $chiet_khau += $r_t->discount_money;
            }
            $this->excel->getActiveSheet()->setCellValue('A' . ($k + 1), $val['receiving_id']);
            $this->excel->getActiveSheet()->setCellValue('B' . ($k + 1), number_format($gia_tri_dh1));
            $this->excel->getActiveSheet()->setCellValue('C' . ($k + 1), number_format($chiet_khau));
            $this->excel->getActiveSheet()->setCellValue('D' . ($k + 1), number_format($gia_tri_dh1+ $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost - $chiet_khau));
            $this->excel->getActiveSheet()->setCellValue('E' . ($k + 1), number_format($da_thanh_toan));
            $this->excel->getActiveSheet()->setCellValue('F' . ($k + 1), number_format($gia_tri_dh1+ $this->Receiving->get_info($val['receiving_id'])->row()->money_1331 + $this->Receiving->get_info($val['receiving_id'])->row()->other_cost - $chiet_khau1 - $da_thanh_toan));
            $this->excel->getActiveSheet()->getStyle('A' . ($k + 1) . ':F' . ($k + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A' . ($k + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . ($k + 1) . ':F' . ($k + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getRowDimension($k + 1)->setRowHeight(18);
            $k++;
        }
        $k++;
    }
}
$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(21);

$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(36);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(16);

$j = $this->excel->getActiveSheet()->getHighestRow() + 1;

$this->excel->getActiveSheet()->setCellValue('A' . $j, "Tổng");
$this->excel->getActiveSheet()->setCellValue('B' . $j, number_format($total_gia_tri_dh));
$this->excel->getActiveSheet()->setCellValue('C' . $j, number_format($total_chiet_khau));
$this->excel->getActiveSheet()->setCellValue('D' . $j, number_format($total_gia_tri_dh - $total_chiet_khau));
$this->excel->getActiveSheet()->setCellValue('E' . $j, number_format($total_da_thanh_toan));
$this->excel->getActiveSheet()->setCellValue('F' . $j, number_format($total_gia_tri_dh - $total_chiet_khau - $total_da_thanh_toan));
$this->excel->getActiveSheet()->getRowDimension($j)->setRowHeight(21);
$this->excel->getActiveSheet()->getStyle('A' . $j . ':F' . $j)->getFont()->setSize(10)->setBold(true);
$this->excel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->getStyle('B' . $j . ':F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B' . $j . ':F' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('A' . $j . ':F' . $j)->getFill()->applyFromArray(array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
        'rgb' => "DCDCDC"
    )
));
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
/* */
$this->excel->getActiveSheet()->getStyle('A7:F' . $k)->applyFromArray($styleThinBlackBorderOutline);
//$this->excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&RPage &P of &N')
$this->excel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$this->excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $this->excel->getProperties()->getTitle() . '&RPage &P of &N');
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
$md5file = md5(date('YmdHis')) . '.xlsx';
$filename = 'Bao_cao_cong_no_ncc.xlsx'; //save our workbook as this file name
$objWriter->save($filename);
if (file_exists($filename)) {
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache    
//    header('Content-Description: File Transfer')
//    header('Content-Type: application/octet-stream')
//    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    ob_clean();
    flush();
    readfile($filename);
    exit;
}
?>