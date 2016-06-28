<?php

$this->load->library('Excel');
$objPHPExcel = new PHPExcel();
$this->excel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->getSize(9);
$this->excel->getActiveSheet()->setShowGridlines(false);
$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$this->excel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$this->excel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
$this->excel->getActiveSheet()->getPageMargins()->setLEFT(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setRIGHT(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setTop(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setBOTTOM(0.3);
$this->excel->getActiveSheet()->getPageMargins()->setFOOTER(0.1);
$this->excel->getActiveSheet()->getPageMargins()->setHEADER(0);
$this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTop(array(6, 6));
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
//name the worksheet
$this->excel->getActiveSheet()->setTitle('Báo cáo bán hàng');
$this->excel->setActiveSheetIndex(0)->mergeCells('A1:O1');
$this->excel->getActiveSheet()->setCellValue("A1", $this->config->item('company'));
$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(11);
$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);

$this->excel->setActiveSheetIndex(0)->mergeCells('A2:O2');
$this->excel->getActiveSheet()->setCellValue("A2", $this->config->item('address'));
$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(11);
$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);

$this->excel->setActiveSheetIndex(0)->mergeCells('A3:O3');
$this->excel->getActiveSheet()->setCellValue("A3", "BÁO CÁO BÁN HÀNG");
$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);

$this->excel->setActiveSheetIndex(0)->mergeCells('A4:O4');
$this->excel->getActiveSheet()->setCellValue("A4", "Từ " . date("d-m-Y", strtotime($start_date)) . " đến " . date("d-m-Y", strtotime($end_date)));
$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(20);

$this->excel->getActiveSheet()->setCellValue('A6', "Thời gian");
$this->excel->getActiveSheet()->setCellValue('B6', "Mã ĐH");
$this->excel->getActiveSheet()->setCellValue('C6', "Khách hàng");
$this->excel->getActiveSheet()->setCellValue('D6', "Mã MH");
$this->excel->getActiveSheet()->setCellValue('E6', "Tên MH");
$this->excel->getActiveSheet()->setCellValue('F6', "ĐVT");
$this->excel->getActiveSheet()->setCellValue('G6', "SL");
$this->excel->getActiveSheet()->setCellValue('H6', "Đơn giá");
$this->excel->getActiveSheet()->setCellValue('I6', "CK %");
$this->excel->getActiveSheet()->setCellValue('J6', "Thuế %");
$this->excel->getActiveSheet()->setCellValue('K6', "Thành tiền");
$this->excel->getActiveSheet()->setCellValue('L6', "CKTM");
$this->excel->getActiveSheet()->setCellValue('M6', "Thực thu");
$this->excel->getActiveSheet()->setCellValue('N6', "HTTT");
$this->excel->getActiveSheet()->setCellValue('O6', "Ghi chú");
$this->excel->getActiveSheet()->getStyle('A6:O6')->getFont()->setSize(9)->setBold(true);
$this->excel->getActiveSheet()->getStyle('A6:O6')->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('A6:O6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A6:O6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20.25);

//Dung vong lap for thay foreach de no ko xuat ra dong cuoi cung ko co du lieu, phuc vu cho viec import nguoc lai file 
//excel vua xuat ra khong bi thong bao loi

$k = 7;
if ($sales) {
    $total_quantity = 0;
    foreach ($sales as $sale) {
        $data_sale_item = $this->Sale->get_item_in_sale($sale->sale_id);
        $data_sale_pack = $this->Sale->get_pack_in_sale($sale->sale_id);
        $data_sale = array_merge($data_sale_item, $data_sale_pack);
        $i = count($data_sale);
        if ($sale->customer_id) {
            if ($this->Customer->get_info($sale->customer_id)->company_name != NULL) {
                $name_customer = $this->Customer->get_info($sale->customer_id)->company_name;
            } else {
                $name_customer = $this->Customer->get_info($sale->customer_id)->first_name . " " . $this->Customer->get_info($sale->customer_id)->last_name;
            }
        } else {
            $name_customer = "KHÁCH LẺ";
        }
        $info_sale = $this->Sale->get_info_sale($sale->sale_id);
        $n = 0;
        foreach ($data_sale as $value) {
            $n++;
            $total_quantity += $value->quantity_purchased;
            if ($value->pack_id) {
                $number_item = $this->Pack->get_info($value->pack_id)->pack_number;
                $unit_name = $this->Unit->get_info($value->unit)->name;
                $item_unit_price = $value->pack_unit_price;
            } else {
                $number_item = $this->Item->get_info($value->item_id)->item_number;
                if ($value->unit_item == $value->unit_from) {
                    $unit_name = $this->Unit->get_info($value->unit_from)->name;
                    $item_unit_price = $value->item_unit_price_rate;
                } else {
                    $unit_name = $this->Unit->get_info($value->unit)->name;
                    $item_unit_price = $value->item_unit_price;
                }
            }

            $gia = $value->quantity_purchased * $item_unit_price;
            $chietkhau = ($value->quantity_purchased * $item_unit_price * $value->discount_percent) / 100;
            $total_money_tax = ($value->quantity_purchased * $item_unit_price - ($value->quantity_purchased * $item_unit_price * $value->discount_percent) / 100) * $value->taxes_percent / 100;
            $tong_cot += ($gia - $chietkhau + $total_money_tax);
            if ($i > 1) {
                if ($n == 1) {
                    $this->excel->setActiveSheetIndex(0)->mergeCells('A' . $k . ':A' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('A' . $k, date("d-m-Y H:i:s", strtotime($sale->sale_time)));
                    $this->excel->setActiveSheetIndex(0)->mergeCells('B' . $k . ':B' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('B' . $k, $sale->sale_id);
                    $this->excel->setActiveSheetIndex(0)->mergeCells('C' . $k . ':C' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('C' . $k, $name_customer);
                }
            } else {
                $this->excel->getActiveSheet()->setCellValue('A' . $k, date("d-m-Y H:i:s", strtotime($sale->sale_time)));
                $this->excel->getActiveSheet()->setCellValue('B' . $k, $sale->sale_id);
                $this->excel->getActiveSheet()->setCellValue('C' . $k, $name_customer);
            }
            $this->excel->getActiveSheet()->setCellValue('D' . $k, $number_item);
            $this->excel->getActiveSheet()->setCellValue('E' . $k, $value->name);
            $this->excel->getActiveSheet()->setCellValue('F' . $k, $unit_name);
            $this->excel->getActiveSheet()->setCellValue('G' . $k, format_quantity($value->quantity_purchased));
            $this->excel->getActiveSheet()->setCellValue('H' . $k, number_format($item_unit_price));
            $this->excel->getActiveSheet()->setCellValue('I' . $k, $value->discount_percent);
            $this->excel->getActiveSheet()->setCellValue('J' . $k, ($value->taxes ? $value->taxes : 0));
            $this->excel->getActiveSheet()->setCellValue('K' . $k, number_format($gia - $chietkhau + $total_money_tax));
            $form_payment = $this->Sale->get_form_payment($sale->sale_id);
            $form_payment_name = "";
            $pays_money = 0;
            $pays_discount = 0;
            foreach ($form_payment as $val) {
                $form_payment_name .= $val->pays_type . ", ";
            }
            $payments = $this->Sale->get_payment_sale_by_sale_id($sale->sale_id);
            foreach ($payments as $v) {
                $pays_money += $v['payment_amount'];
                $pays_discount += $v['discount_money'];
            }
            if ($i > 1) {
                if ($n == 1) {
                    $this->excel->setActiveSheetIndex(0)->mergeCells('L' . $k . ':L' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('L' . $k, number_format($pays_discount));
                    $this->excel->setActiveSheetIndex(0)->mergeCells('M' . $k . ':M' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('M' . $k, number_format($pays_money));
                    $this->excel->setActiveSheetIndex(0)->mergeCells('N' . $k . ':N' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('N' . $k, rtrim($form_payment_name, ", "));
                    $this->excel->setActiveSheetIndex(0)->mergeCells('O' . $k . ':O' . ($k + $i - 1));
                    $this->excel->getActiveSheet()->setCellValue('O' . $k, $info_sale['comment']);
                }
            } else {
                $this->excel->getActiveSheet()->setCellValue('L' . $k, number_format($pays_discount));
                $this->excel->getActiveSheet()->setCellValue('M' . $k, number_format($pays_money));
                $this->excel->getActiveSheet()->setCellValue('N' . $k, rtrim($form_payment_name, ", "));
                $this->excel->getActiveSheet()->setCellValue('O' . $k, $info_sale['comment']);
            }

            $this->excel->getActiveSheet()->getStyle('A' . $k . ':O' . $k)->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A' . $k . ':O' . $k)->getFont()->setSize(9);
            $this->excel->getActiveSheet()->getStyle('A' . $k . ':O' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('H' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('I' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('J' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('K' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('L' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('M' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $k++;
        }
        $tong_pays_money += $pays_money;
        $tong_pays_discount += $pays_discount;
    }
}
$this->excel->getActiveSheet()->getRowDimension($k)->setRowHeight(-1);

$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(6.45);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18.5);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(7.5);
$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(5.25);
$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(12.25);
$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10.25);
$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
$this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
$this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(18);

$j = $this->excel->getActiveSheet()->getHighestRow();
$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $j . ':F' . $j);
$this->excel->getActiveSheet()->getStyle('A' . $j . ':O' . $j)->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A' . $j . ':O' . $j)->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('A' . $j, "Tổng");
$this->excel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('G' . $j, format_quantity($total_quantity));
$this->excel->getActiveSheet()->setCellValue('K' . $j, number_format($tong_cot));
$this->excel->getActiveSheet()->setCellValue('L' . $j, number_format($tong_pays_discount));
$this->excel->getActiveSheet()->setCellValue('M' . $j, number_format($tong_pays_money));
$this->excel->getActiveSheet()->getStyle('G' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('K' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('L' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('M' . $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$this->excel->setActiveSheetIndex(0)->mergeCells('K' . ($j + 2) . ':O' . ($j + 2));
$this->excel->getActiveSheet()->getStyle('K' . ($j + 2) . ':O' . ($j + 2))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('K' . ($j + 2), "......, Ngày " . date("d") . " tháng " . date("m") . " năm " . date("Y"));
$this->excel->getActiveSheet()->getStyle('K' . ($j + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('K' . ($j + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('A' . ($j + 3) . ':D' . ($j + 3));
$this->excel->getActiveSheet()->getStyle('A' . ($j + 3) . ':D' . ($j + 3))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('A' . ($j + 3), "Người lập biểu");
$this->excel->getActiveSheet()->getStyle('A' . ($j + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A' . ($j + 3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->setActiveSheetIndex(0)->mergeCells('A' . ($j + 4) . ':D' . ($j + 4));
$this->excel->getActiveSheet()->getStyle('A' . ($j + 4) . ':D' . ($j + 4))->getFont()->setItalic(9);
$this->excel->getActiveSheet()->getStyle('A' . ($j + 4) . ':D' . ($j + 4))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('A' . ($j + 4), "(Ký tên)");
$this->excel->getActiveSheet()->getStyle('A' . ($j + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A' . ($j + 4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('E' . ($j + 3) . ':J' . ($j + 3));
$this->excel->getActiveSheet()->getStyle('E' . ($j + 3) . ':J' . ($j + 3))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('E' . ($j + 3), "Kế toán trưởng");
$this->excel->getActiveSheet()->getStyle('E' . ($j + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('E' . ($j + 3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->setActiveSheetIndex(0)->mergeCells('E' . ($j + 4) . ':J' . ($j + 4));
$this->excel->getActiveSheet()->getStyle('E' . ($j + 4) . ':J' . ($j + 4))->getFont()->setItalic(9);
$this->excel->getActiveSheet()->getStyle('E' . ($j + 4) . ':J' . ($j + 4))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('E' . ($j + 4), "(Ký tên)");
$this->excel->getActiveSheet()->getStyle('E' . ($j + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('E' . ($j + 4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('K' . ($j + 3) . ':O' . ($j + 3));
$this->excel->getActiveSheet()->getStyle('K' . ($j + 3) . ':O' . ($j + 3))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('K' . ($j + 3), "Giám đốc");
$this->excel->getActiveSheet()->getStyle('K' . ($j + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('K' . ($j + 3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->setActiveSheetIndex(0)->mergeCells('K' . ($j + 4) . ':O' . ($j + 4));
$this->excel->getActiveSheet()->getStyle('K' . ($j + 4) . ':O' . ($j + 4))->getFont()->setItalic(9);
$this->excel->getActiveSheet()->getStyle('K' . ($j + 4) . ':O' . ($j + 4))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('K' . ($j + 4), "(Ký tên)");
$this->excel->getActiveSheet()->getStyle('K' . ($j + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('K' . ($j + 4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleThinBlackBorderOutline = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);

$this->excel->getActiveSheet()->getStyle('A6:O' . ($k))->applyFromArray($styleThinBlackBorderOutline);
$this->excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&RPage &P of &N');

//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
$md5file = md5(date('YmdHis')) . '.xlsx';
//$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
$ngay = date('d');
$thang = date('m');
$nam = date('Y');
$filename = 'baocao_banhang-' . $ngay . '-' . $thang . '-' . $nam . '.xlsx'; //save our workbook as this file name
//$filename = 'Book1.xlsx';

$objWriter->save($filename);
if (file_exists($filename)) {
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache    
//    header('Content-Description: File Transfer');
//    header('Content-Type: application/octet-stream');
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