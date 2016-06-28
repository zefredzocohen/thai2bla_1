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
$this->excel->getActiveSheet()->setTitle('Bao_cao_cong_no_khach_hang');
$this->excel->setActiveSheetIndex(0)->mergeCells('A1:F1');
$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
$this->excel->getActiveSheet()->setCellValue('A1', $data['company']);
$this->excel->setActiveSheetIndex(0)->mergeCells('A2:F2');
$this->excel->getActiveSheet()->setCellValue('A2', $this->config->item('address'));
$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('A4:F4');
$this->excel->getActiveSheet()->setCellValue('A4', "BÁO CÁO CÔNG NỢ KHÁCH HÀNG");
$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(14)->setBold(true);
$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->setCellValue('A5', 'Từ ' . date('d-m-Y H:i:s', strtotime($start_date)) . ' đến ' . date('d-m-Y H:i:s', strtotime($end_date)));
$this->excel->setActiveSheetIndex(0)->mergeCells('A5:F5');
$this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(10)->setItalic(true);
$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->setCellValue('A7', "Khách hàng/Mã ĐH");
$this->excel->getActiveSheet()->setCellValue('B7', "Tổng GTĐH");
$this->excel->getActiveSheet()->setCellValue('C7', "CKĐH");
$this->excel->getActiveSheet()->setCellValue('D7', "Tổng TT");
$this->excel->getActiveSheet()->setCellValue('E7', "Đã thanh toán");
$this->excel->getActiveSheet()->setCellValue('F7', "Còn nợ");

$this->excel->getActiveSheet()->getStyle('A7:F7')->getFont()->setSize(11)->setBold(true);
$this->excel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->getStyle('A7:F7')->getFill()->applyFromArray(array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
        'rgb' => "9A9A9A"
    )
));

$data_cus = array();
if ($customer_id) {
    $data_cus[] = array("person_id" => $customer_id);
} else {
    $customer = $this->Customer->get_list_customer();
    foreach ($customer as $c) {
        $data_cus[] = array("person_id" => $c->person_id);
    }
}
$total_gtdh = 0;
$total_ckdh = 0;
$total_tt = 0;
$total_da_tt = 0;
$total_con_no = 0;
$k = 8;
foreach ($data_cus as $cus) {
    $data_sale_customer = $this->Sale->get_sale_suspended_by_customer($cus['person_id'], $start_date, $end_date);
    $sub_total_price = 0;
    $sub_tong_don_hang = 0;
    $sub_ckdh = 0;
    $sub_tong_thanh_toan = 0;
    $sub_da_thanh_toan = 0;
    $sub_con_no = 0;
    if ($data_sale_customer) {
        foreach ($data_sale_customer as $sale_cus) {
            $sale_item = $this->Sale->get_item_in_sale($sale_cus->sale_id);
            $sale_pack = $this->Sale->get_pack_in_sale($sale_cus->sale_id);
            $data_sale_item_pack = array_merge($sale_item, $sale_pack);
            $total_price = 0;
            $tong_don_hang = 0;
            $ckdh = 0;
            $tong_thanh_toan = 0;
            $da_thanh_toan = 0;
            $con_no = 0;
            foreach ($data_sale_item_pack as $val) {
                if ($val->item_id) {
                    $info_item = $this->Item->get_info($val->item_id);
                    if ($info_item->unit_from) {
                        if ($info_item->unit_from == $val->unit_item) {
                            $total_price += $val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100) * $val->taxes_percent / 100;
                        } else {
                            $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                        }
                    } else {
                        $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                    }
                } else {
                    $total_price += $val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100) * $val->taxes->percent / 100;
                }
            }
            //Lay tong tien chiet khau tren hoa don
            $sales_tam = $this->Sale->get_sales_tam($val->sale_id);
            foreach ($sales_tam as $s_t) {
                $da_thanh_toan += $s_t['pays_amount'];
                $ckdh += $s_t['discount_money'];
            }
            $sub_total_price += $total_price;
            $sub_ckdh += $ckdh;
            $sub_tong_thanh_toan += $total_price - $ckdh;
            $sub_da_thanh_toan += $da_thanh_toan;
            $sub_con_no += $total_price - $ckdh - $da_thanh_toan;
        }
        $total_gtdh += $sub_total_price;
        $total_ckdh += $sub_ckdh;
        $total_tt += $sub_tong_thanh_toan;
        $total_da_tt += $sub_da_thanh_toan;
        $total_con_no += $sub_con_no;
        $info_cus = $this->Customer->get_info($cus['person_id']);
        $cus_name = $info_cus->company_name != "" ? $info_cus->company_name : ($info_cus->first_name . " " . $info_cus->last_name);

        $this->excel->getActiveSheet()->setCellValue('A' . $k, $cus_name);
        $this->excel->getActiveSheet()->getStyle('A' . $k)->getAlignment()->setWrapText(true);
        $this->excel->getActiveSheet()->setCellValue('B' . $k, number_format($sub_total_price));
        $this->excel->getActiveSheet()->setCellValue('C' . $k, number_format($sub_ckdh));
        $this->excel->getActiveSheet()->setCellValue('D' . $k, number_format($sub_tong_thanh_toan));
        $this->excel->getActiveSheet()->setCellValue('E' . $k, number_format($sub_da_thanh_toan));
        $this->excel->getActiveSheet()->setCellValue('F' . $k, number_format($sub_con_no));
        $this->excel->getActiveSheet()->getStyle('A' . $k . ':F' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B' . $k . ':F' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('A' . $k . ':F' . $k)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => "E2E2E2"
            )
        ));
        $this->excel->getActiveSheet()->getStyle('A' . $k . ':F' . $k)->getFont()->setBold(true);
        foreach ($data_sale_customer as $sale_cus) {
            $sale_item = $this->Sale->get_item_in_sale($sale_cus->sale_id);
            $sale_pack = $this->Sale->get_pack_in_sale($sale_cus->sale_id);
            $data_sale_item_pack = array_merge($sale_item, $sale_pack);
            $total_price = 0;
            $tong_don_hang = 0;
            $ckdh = 0;
            $tong_thanh_toan = 0;
            $da_thanh_toan = 0;
            $con_no = 0;
            foreach ($data_sale_item_pack as $val) {
                if ($val->item_id) {
                    $info_item = $this->Item->get_info($val->item_id);
                    if ($info_item->unit_from) {
                        if ($info_item->unit_from == $val->unit_item) {
                            $total_price += $val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price_rate - $val->quantity_purchased * $val->item_unit_price_rate * $val->discount_percent / 100) * $val->taxes_percent / 100;
                        } else {
                            $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                        }
                    } else {
                        $total_price += $val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->item_unit_price - $val->quantity_purchased * $val->item_unit_price * $val->discount_percent / 100) * $val->taxes_percent / 100;
                    }
                } else {
                    $total_price += $val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100 + ($val->quantity_purchased * $val->pack_unit_price - $val->quantity_purchased * $val->pack_unit_price * $val->discount_percent / 100) * $val->taxes->percent / 100;
                }
            }
            //Lay tong tien chiet khau tren hoa don
            $sales_tam = $this->Sale->get_sales_tam($val->sale_id);
            foreach ($sales_tam as $s_t) {
                $da_thanh_toan += $s_t['pays_amount'];
                $ckdh += $s_t['discount_money'];
            }
            $this->excel->getActiveSheet()->setCellValue('A' . ($k + 1), $sale_cus->sale_id);
            $this->excel->getActiveSheet()->setCellValue('B' . ($k + 1), number_format($total_price));
            $this->excel->getActiveSheet()->setCellValue('C' . ($k + 1), number_format($ckdh));
            $this->excel->getActiveSheet()->setCellValue('D' . ($k + 1), number_format($total_price - $ckdh));
            $this->excel->getActiveSheet()->setCellValue('E' . ($k + 1), number_format($da_thanh_toan));
            $this->excel->getActiveSheet()->setCellValue('F' . ($k + 1), number_format($total_price - $ckdh - $da_thanh_toan));
            $this->excel->getActiveSheet()->getStyle('A' . ($k + 1) . ':F' . ($k + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . ($k + 1) . ':F' . ($k + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getDefaultRowDimension($k)->setRowHeight(-1);
            $k ++;
        }
        $this->excel->getActiveSheet()->getDefaultRowDimension($k)->setRowHeight(-1);
        $k ++;
    }
}
$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(38);
$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(17);

$this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setWrapText(true);

$j = $this->excel->getActiveSheet()->getHighestRow() + 1;
$this->excel->getActiveSheet()->setCellValue('A' . $j, "Tổng");
$this->excel->getActiveSheet()->setCellValue('B' . $j, number_format($total_gtdh));
$this->excel->getActiveSheet()->setCellValue('C' . $j, number_format($total_ckdh));
$this->excel->getActiveSheet()->setCellValue('D' . $j, number_format($total_tt));
$this->excel->getActiveSheet()->setCellValue('E' . $j, number_format($total_da_tt));
$this->excel->getActiveSheet()->setCellValue('F' . $j, number_format($total_con_no));
$this->excel->getActiveSheet()->getStyle('A' . $j . ':F' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B' . $j . ':F' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getDefaultRowDimension($j)->setRowHeight(20);
$this->excel->getActiveSheet()->getStyle('A' . $j . ':F' . $j)->getFill()->applyFromArray(array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'startcolor' => array(
        'rgb' => "9A9A9A"
    )
));
$this->excel->getActiveSheet()->getStyle('A' . $j . ':F' . $j)->getFont()->setBold(true);
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
$filename = 'bao_cao_cong_no_khach_hang.xlsx'; //save our workbook as this file name
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