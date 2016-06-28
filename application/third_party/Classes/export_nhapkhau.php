<?php

$this->load->library('Excel');
$objPHPExcel = new PHPExcel();

$this->excel->getActiveSheet()->setShowGridlines(false);
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
$this->excel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(9);
$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$this->excel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$this->excel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
$this->excel->getActiveSheet()->getPageMargins()->setRight(0.1);
$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.27);
$this->excel->getActiveSheet()->getPageMargins()->setTop(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setBOTTOM(0.5);
$this->excel->getActiveSheet()->getPageMargins()->setFOOTER(0.1);
$this->excel->getActiveSheet()->getPageMargins()->setHEADER(0);
$this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTop(array(6, 7));
//name the worksheet
$this->excel->getActiveSheet()->setTitle('Báo cáo nhập khẩu');
/* ten dia chi cong ty ngay thang noi dung */
$this->excel->setActiveSheetIndex(0)->mergeCells('A1:D1');
$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);

$this->excel->getActiveSheet()->setCellValue('A1', $data['company']);
$this->excel->getActiveSheet()->setCellValue('A2', $data['address']);
$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->setActiveSheetIndex(0)->mergeCells('A2:D2');
$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(9);


$this->excel->setActiveSheetIndex(0)->mergeCells('D4:E4');
$this->excel->getActiveSheet()->setCellValue('D4', "BẢNG KÊ NHẬP KHẨU");
$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setSize(14)->setBold(true);
$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

/* end ten dia chi cong ty ngay thang noi dung */
$this->excel->setActiveSheetIndex(0)->mergeCells('D5:E5');
$objRichTextdate = new PHPExcel_RichText();
$tu = $objRichTextdate->createTextRun('Từ: ')->getFont()->setSize(9)->setName('Times New Roman');
$startdate = $objRichTextdate->createTextRun(date("d/m/Y", strtotime($start_date)))->getFont()->setItalic(true)->setSize(9)->setName('Times New Roman')->setBold(true);
$den = $objRichTextdate->createTextRun(' đến: ')->getFont()->setSize(9);
$enddate = $objRichTextdate->createTextRun(date("d/m/Y", strtotime($end_date)))->getFont()->setItalic(true)->setSize(9)->setName('Times New Roman')->setBold(true);
$this->excel->getActiveSheet()->getCell('D5')->setValue($objRichTextdate);
$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(21.75);
/* tieu de cac cot */
$this->excel->getActiveSheet()->setCellValue('A6', "Chứng từ");
$this->excel->setActiveSheetIndex(0)->mergeCells('A6:B6');
$this->excel->getActiveSheet()->getStyle('A6:B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(16);

$this->excel->getActiveSheet()->setCellValue('A7', "Ngày");
$this->excel->getActiveSheet()->setCellValue('B7', "Số");
$this->excel->getActiveSheet()->getStyle('A7:B7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A7:B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('C6', "Tên đối tượng giao dịch");
$this->excel->getActiveSheet()->setCellValue('D6', "Mã hàng");
$this->excel->getActiveSheet()->setCellValue('E6', "Tên hàng");
$this->excel->getActiveSheet()->setCellValue('F6', "ĐVT");
$this->excel->getActiveSheet()->setCellValue('G6', "SL");
$this->excel->getActiveSheet()->setCellValue('H6', "Đơn giá");
$this->excel->getActiveSheet()->setCellValue('I6', "Thuế");
$this->excel->getActiveSheet()->setCellValue('J6', "Tiền");
$this->excel->getActiveSheet()->setCellValue('K6', "Ngoại tệ");
$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(16);
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$this->excel->getActiveSheet()->getStyle('A6:K7')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A6:K7' . $k)->applyFromArray($styleThinBlackBorderOutline);
$this->excel->setActiveSheetIndex(0)->mergeCells('C6:C7');
$this->excel->setActiveSheetIndex(0)->mergeCells('D6:D7');
$this->excel->setActiveSheetIndex(0)->mergeCells('E6:E7');
$this->excel->setActiveSheetIndex(0)->mergeCells('F6:F7');
$this->excel->setActiveSheetIndex(0)->mergeCells('G6:G7');
$this->excel->setActiveSheetIndex(0)->mergeCells('H6:H7');
$this->excel->setActiveSheetIndex(0)->mergeCells('I6:I7');
$this->excel->setActiveSheetIndex(0)->mergeCells('J6:J7');
$this->excel->setActiveSheetIndex(0)->mergeCells('K6:K7');
$this->excel->getActiveSheet()->getStyle('C6:K6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C6:K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/* */
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$styleDOTBlackBorderOutline = array(
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('argb' => 'FF000000'),
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$styleDOTBlackBorderTOPBOTOutline = array(
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$k = 9;
if ($data_receiving != null) {

    $total_money = 0;
    foreach ($data_receiving as $data) {

        $this->excel->getActiveSheet()->setCellValue('A' . ($k - 1), date("d/m/Y H:i:s", strtotime($data['receiving_time'])));
        $this->excel->getActiveSheet()->getStyle('A' . ($k - 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A' . ($k - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $this->excel->getActiveSheet()->setCellValue('E' . ($k - 1), "Nhập hàng: " . $this->Supplier->get_info($data['supplier_id'])->first_name . ' ' . $this->Supplier->get_info($data['supplier_id'])->last_name);
        $this->excel->getActiveSheet()->getStyle('E' . ($k - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('E' . ($k - 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A' . ($k - 1) . ':I' . ($k - 1))->applyFromArray($styleDOTBlackBorderTOPBOTOutline);
        /* làm phần tổng */

        $this->excel->getActiveSheet()->setCellValue('I' . ($k - 1), '');
        $this->excel->getActiveSheet()->getStyle('I' . ($k - 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('I' . ($k - 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        /* end làm phần tổng */
        $this->excel->getActiveSheet()->getRowDimension($k - 1)->setRowHeight(23);
        $this->excel->getActiveSheet()->getStyle('A' . ($k - 1) . ':K' . ($k - 1))->getFont()->setBold(true);
        /* style */
//        $data_item_recv = $this->Inventory->receiving_items_import();
        $total = 0;
        if ($data_item_recv != null) {
            foreach ($data_item_recv as $data1) {
                if ($data1['receiving_id'] == $data['receiving_id']) {

                    $this->excel->getActiveSheet()->getRowDimension($k)->setRowHeight(20);
                    $this->excel->getActiveSheet()->setCellValue('C' . ($k), $this->Supplier->get_info($data['supplier_id'])->first_name . ' ' . $this->Supplier->get_info($data['supplier_id'])->last_name);
                    $this->excel->getActiveSheet()->getStyle('C' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $this->excel->getActiveSheet()->setCellValue('D' . ($k), $this->Item->get_info($data1['item_id'])->item_number);
                    $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $this->excel->getActiveSheet()->setCellValue('E' . ($k), $this->Item->get_info($data1['item_id'])->name);
                    $this->excel->getActiveSheet()->getStyle('E' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $this->excel->getActiveSheet()->setCellValue('F' . ($k), $this->Unit->get_info($this->Item->get_info($data1['item_id'])->unit)->name);
                    $this->excel->getActiveSheet()->getStyle('F' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $this->excel->getActiveSheet()->setCellValue('G' . ($k), $data1['quantity_purchased']);
                    $this->excel->getActiveSheet()->getStyle('G' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->getActiveSheet()->setCellValue('H' . ($k), $data1['item_unit_price']);
                    $this->excel->getActiveSheet()->getStyle('H' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $total = ($data1['item_unit_price'] * $data1['rate_currency'] ) * $data1['quantity_purchased'] - ($data1['item_unit_price'] * $data1['rate_currency'] ) * $data1['quantity_purchased'] * $data1['discount_percent'] / 100 + (($data1['item_unit_price'] * $data1['rate_currency']  * $data1['quantity_purchased'] - $data1['item_unit_price'] * $data1['rate_currency']  * $data1['quantity_purchased'] * $data1['discount_percent'] / 100) * $data1['taxes'] / 100);

                    $total_money +=$total;
                    $this->excel->getActiveSheet()->setCellValue('I' . ($k), $data1['taxes'] . '%');
                    $this->excel->getActiveSheet()->getStyle('I' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $this->load->model('Import');

                    $this->excel->getActiveSheet()->setCellValue('J' . ($k), number_format($total, 2));
                    $this->excel->getActiveSheet()->getStyle('J' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $this->load->model('Currency');
                    $this->excel->getActiveSheet()->setCellValue('K' . ($k), $this->Currency->get_info($data['currency_id'])->currency_name . ' ' . ($this->Currency->get_info($data['currency_id'])->currency_id));
                    $this->excel->getActiveSheet()->getStyle('K' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $k++;
                    $this->excel->getActiveSheet()->getStyle('A' . ($k) . ':K' . $k)->applyFromArray($styleDOTBlackBorderOutline);
                }
            }
        }
      $k+=1;  
    } 
}

$i = $this->excel->getActiveSheet()->getHighestRow() + 1;
/* style border cot */
$this->excel->getActiveSheet()->getStyle('A8:A' . ($i - 1))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('A8:A' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B8:B' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('C8:C' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('D8:D' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('E8:E' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('F8:F' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('G8:G' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('H8:H' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('I8:I' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('J8:J' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('K8:K' . ($i - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
/* end style border cot */
$this->excel->getActiveSheet()->setCellValue('C' . ($i), 'TỔNG CỘNG ');
$this->excel->getActiveSheet()->getStyle('C' . ($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C' . ($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('J' . ($i), number_format($total_money));
$this->excel->getActiveSheet()->getStyle('J' . ($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('J' . ($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('A' . ($i) . ':K' . ($i))->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A' . ($i) . ':K' . ($i))->applyFromArray($styleThinBlackBorderOutline);
$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(23);

$this->excel->getActiveSheet()->setCellValue('G' . ($i + 2), 'Ngày ......./......./.............');
$this->excel->getActiveSheet()->getStyle('G' . ($i + 2))->getFont()->setItalic(true);

$this->excel->getActiveSheet()->setCellValue('C' . ($i + 4), 'NGƯỜI LẬP BIỂU');
$this->excel->getActiveSheet()->setCellValue('G' . ($i + 4), 'KẾ TOÁN TRƯỞNG');
$this->excel->getActiveSheet()->getStyle('A' . ($i + 4) . ':I' . ($i + 4))->getFont()->setBold(true);

$this->excel->getActiveSheet()->setCellValue('C' . ($i + 5), '(Ký, ghi họ tên)');
$this->excel->getActiveSheet()->setCellValue('G' . ($i + 5), '(Ký, ghi họ tên)');
$this->excel->getActiveSheet()->getStyle('C' . ($i + 5))->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('G' . ($i + 5))->getFont()->setItalic(true);

$this->excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&RPage &P of &N');
$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(29);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(11.20);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(9);
$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8.70);
$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15.33);
$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(27);


//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
$md5file = md5(date('YmdHis')) . '.xlsx';
//$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
$filename = 'thongtin_nhapkhau.xlsx'; //save our workbook as this file name


$objWriter->save($filename);
if (file_exists($filename)) {
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache    
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