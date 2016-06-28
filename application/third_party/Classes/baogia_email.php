<?php
$count = count($rows);
$this->load->library('Excel');

$objPHPExcel = new PHPExcel();

$this->excel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->setShowGridlines(true);
$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$this->excel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$this->excel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
$this->excel->getActiveSheet()->getPageMargins()->setLEFT(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setRIGHT(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setTop(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setBOTTOM(0.25);
$this->excel->getActiveSheet()->getPageMargins()->setFOOTER(0);
$this->excel->getActiveSheet()->getPageMargins()->setHEADER(0);
//activate worksheet number 1
$this->excel->setActiveSheetIndex(0);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
//name the worksheet

$id_image = $this->config->item('report_logo');
$imagePath = 'images/logoreport/' . "$id_image";
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setPath($imagePath);
$objDrawing->setCoordinates('C2');
$objDrawing->setHeight(70);
$objDrawing->setWidth(160);
$objDrawing->setWorksheet($this->excel->getActiveSheet());


$this->excel->setActiveSheetIndex(0)->mergeCells('D2:G2');
if ($excel == 0) {
    $this->excel->getActiveSheet()->setCellValue('D2', "BẢNG BÁO GIÁ HÀNG HÓA");
} else {
    $this->excel->getActiveSheet()->setCellValue('D2', "BẢNG BÁO GIÁ DỊCH VỤ");
}
$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle("D2")->getFont()->setSize(12);
$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->setCellValue('H2', "Mẫu");
$this->excel->getActiveSheet()->setCellValue('H3', "Ký hiệu");
$this->excel->getActiveSheet()->setCellValue('H4', "Số");
$this->excel->getActiveSheet()->setCellValue('I2', "V02GTTT2/001");
$this->excel->getActiveSheet()->setCellValue('I3', "A-HD");
$this->excel->getActiveSheet()->setCellValue('I4', "HD " . $data['sale_id']);
$this->excel->getActiveSheet()->getStyle('H2:H4')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('I2:I4')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle("I2:I4")->getFont()->setSize(8.5);
$this->excel->getActiveSheet()->getStyle("H2:H4")->getFont()->setSize(8.5);
$this->excel->getActiveSheet()->getStyle('I2:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('H2:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$ngay = date('d');
$thang = date('m');
$nam = date('Y');
$this->excel->setActiveSheetIndex(0)->mergeCells('D5' . ':H5');
$this->excel->setActiveSheetIndex(0)->mergeCells('B12' . ':C12');
$this->excel->setActiveSheetIndex(0)->mergeCells('B13' . ':C13');
$this->excel->setActiveSheetIndex(0)->mergeCells('F13' . ':I13');
$this->excel->setActiveSheetIndex(0)->mergeCells('F5' . ':I5');
$this->excel->setActiveSheetIndex(0)->mergeCells('F6' . ':I6');
$date_material = $this->Sale->get_all();
foreach ($date_material->result() as $d) {
    if ($sale_id == $d->sale_id) {
        if ($d->date_debt != '0000-00-00') {
            $this->excel->setActiveSheetIndex(0)->setCellValue('D5', "......, Ngày " . date('d', strtotime($d->date_debt)) . " tháng " . date('m', strtotime($d->date_debt)) . " năm " . date('Y', strtotime($d->date_debt)));
        } else {
            $this->excel->setActiveSheetIndex(0)->setCellValue('D5', "......, Ngày....... tháng...... năm......");
        }
    }
}

$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setSize(9);
$this->excel->getActiveSheet()->getStyle('D5')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('B7' . ':C7');
$objRichText8 = new PHPExcel_RichText();
$objRed8 = $objRichText8->createTextRun('Đơn vị bán hàng');
$objRed8->getFont()->setBold(true);
$objGreen8 = $objRichText8->createTextRun(' (Sale Company):');
$objRichText8->createText(' ');
$objRed8->getFont()->setSize(10);
$objRed8->getFont()->setName('Times New Roman');
$objGreen8->getFont()->setSize(10);
$objGreen8->getFont()->setItalic(true);
$objGreen8->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B7')->setValue($objRichText8);
$this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('B8' . ':C8');
$objRichText9 = new PHPExcel_RichText();
$objRed9 = $objRichText9->createTextRun('Địa chỉ');
$objRed9->getFont()->setBold(true);
$objGreen9 = $objRichText9->createTextRun(' (Address):');
$objRichText9->createText(' ');
$objRed9->getFont()->setSize(10);
$objRed9->getFont()->setName('Times New Roman');
$objGreen9->getFont()->setSize(10);
$objGreen9->getFont()->setItalic(true);
$objGreen9->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B8')->setValue($objRichText9);
$this->excel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('B9:C9');
$objRichText10 = new PHPExcel_RichText();
$objRed10 = $objRichText10->createTextRun('Điện thoại');
$objRed10->getFont()->setBold(true);
$objGreen10 = $objRichText10->createTextRun(' (Tex/Fax):');
$objRichText10->createText(' ');
$objRed10->getFont()->setSize(10);
$objRed10->getFont()->setName('Times New Roman');
$objGreen10->getFont()->setSize(10);
$objGreen10->getFont()->setItalic(true);
$objGreen10->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B9')->setValue($objRichText10);
$this->excel->getActiveSheet()->getStyle('B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('B10' . ':C10');
$objRichText11 = new PHPExcel_RichText();
$objRed11 = $objRichText11->createTextRun('Người báo giá');
$objRed11->getFont()->setBold(true);
$objGreen11 = $objRichText11->createTextRun(' (Salesman):');
$objRichText11->createText(' ');
$objRed11->getFont()->setSize(10);
$objRed11->getFont()->setName('Times New Roman');
$objGreen11->getFont()->setSize(10);
$objGreen11->getFont()->setItalic(true);
$objGreen11->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B10')->setValue($objRichText11);
$this->excel->getActiveSheet()->getStyle('B10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
//DEENS DDAAY
$this->excel->setActiveSheetIndex(0)->mergeCells('B11' . ':C11');
$objRichText12 = new PHPExcel_RichText();
$objRed12 = $objRichText12->createTextRun('Quản lý');
$objRed12->getFont()->setBold(true);
$objGreen12 = $objRichText12->createTextRun(' (Manager):');
$objRichText12->createText(' ');
$objRed12->getFont()->setSize(10);
$objRed12->getFont()->setName('Times New Roman');
$objGreen12->getFont()->setSize(10);
$objGreen12->getFont()->setItalic(true);
$objGreen12->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B11')->setValue($objRichText12);
$this->excel->getActiveSheet()->getStyle('B11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('D7' . ':I7');
$this->excel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
$this->excel->getActiveSheet()->setCellValue('D7', $this->config->item('company'));
$this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('D8' . ':I8');
$this->excel->getActiveSheet()->setCellValue('D8', nl2br($this->config->item('address')));
$this->excel->getActiveSheet()->getStyle('D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('D9' . ':I9');
$this->excel->getActiveSheet()->setCellValue('D9', $this->config->item('phone'));
$this->excel->getActiveSheet()->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('D10' . ':F10');
$this->excel->getActiveSheet()->setCellValue('D10', $data['employees_id']);
$this->excel->getActiveSheet()->getStyle('D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$a = $data['phone_number1'];
$b = (string) $a;
$this->excel->getActiveSheet()->setCellValue('I10', ' ' . $b);
$this->excel->getActiveSheet()->getStyle('I10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$this->excel->getActiveSheet()->getStyle('I10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('D11' . ':F11');
$this->excel->setActiveSheetIndex(0)->mergeCells('D10' . ':F10');
$this->excel->setActiveSheetIndex(0)->mergeCells('D12' . ':E12');
$this->excel->setActiveSheetIndex(0)->mergeCells('D13' . ':E13');
$this->excel->setActiveSheetIndex(0)->mergeCells('D5' . ':E5');
$this->excel->setActiveSheetIndex(0)->mergeCells('D6' . ':E6');
$this->excel->setActiveSheetIndex(0)->mergeCells('D2' . ':E2');
$this->excel->setActiveSheetIndex(0)->mergeCells('D20' . ':E20');

$this->excel->getActiveSheet()->setCellValue('D11', 'Ms Hương Vũ');
$this->excel->getActiveSheet()->getStyle('D11')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$this->excel->getActiveSheet()->getStyle('D7:D17')->getFont()->setSize(10);

$this->excel->getActiveSheet()->setCellValue('I11', ' 0944245885');
$this->excel->getActiveSheet()->getStyle('I11')->getFont()->setSize(10);
$this->excel->getActiveSheet()->getStyle('I11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('G11' . ':H11');
$objRichText13 = new PHPExcel_RichText();
$objRed13 = $objRichText13->createTextRun('Điện thoại');
$objRed13->getFont()->setBold(true);
$objGreen13 = $objRichText13->createTextRun(" (Mob):");
$objRichText13->createText(' ');
$objRed13->getFont()->setSize(9);
$objRed13->getFont()->setName('Times New Roman');
$objGreen13->getFont()->setSize(9);
$objGreen13->getFont()->setItalic(true);
$objGreen13->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('G11')->setValue($objRichText13);
$this->excel->getActiveSheet()->getStyle('G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('F12' . ':I12');
$this->excel->getActiveSheet()->setCellValue('F12', "NH TMCP Công Thương VN - CN Nam Thăng Long");
$this->excel->getActiveSheet()->getStyle('F12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getStyle('F11:F12')->getFont()->setSize(8);

/* do rong dong tt nguoi ban */
$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(6.75);
$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(20.25);
$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(15.25);
$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(15.25);
$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(15.25);
$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(15.25);
$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(0);
$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(15);
$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(15);
$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(15);
$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(15);
$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(15);
$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(15);
$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(15);
/* do rong dong */
$this->excel->setActiveSheetIndex(0)->mergeCells('B14' . ':C14');
$objRichText15 = new PHPExcel_RichText();
$objRed15 = $objRichText15->createTextRun('Tên đơn vị');
$objRed15->getFont()->setBold(true);
$objGreen15 = $objRichText15->createTextRun("(Company):");
$objRichText15->createText(' ');
$objRed15->getFont()->setSize(9);
$objRed15->getFont()->setName('Times New Roman');
$objGreen15->getFont()->setSize(9);
$objGreen15->getFont()->setItalic(true);
$objGreen15->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B14')->setValue($objRichText15);
$this->excel->getActiveSheet()->getStyle('B14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('D14' . ':I14');
$this->excel->getActiveSheet()->setCellValue('D14', $data['cus_name']);
$this->excel->getActiveSheet()->getStyle('D14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getStyle('D14')->getFont()->setBold(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B15' . ':C15');
$objRichText16 = new PHPExcel_RichText();
$objRed16 = $objRichText16->createTextRun('Họ tên Người mua hàng');
$objRed16->getFont()->setBold(true);
$objGreen16 = $objRichText16->createTextRun("(Customer's name):");
$objRichText16->createText(' ');
$objRed16->getFont()->setSize(9);
$objRed16->getFont()->setName('Times New Roman');
$objGreen16->getFont()->setSize(9);
$objGreen16->getFont()->setItalic(true);
$objGreen16->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B15')->setValue($objRichText16);
$this->excel->getActiveSheet()->getStyle('B15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('D15' . ':I15');
$this->excel->getActiveSheet()->setCellValue('D15', ' Ông/bà (Mr/Ms): ' . mb_convert_case($data['customer'], MB_CASE_UPPER, "UTF-8"));
$this->excel->getActiveSheet()->getStyle('D15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B16' . ':C16');
$objRichText17 = new PHPExcel_RichText();
$objRed17 = $objRichText17->createTextRun('Mã số thuế');
$objRed17->getFont()->setBold(true);
$objGreen17 = $objRichText17->createTextRun(" (Tax Code):");
$objRichText17->createText(' ');
$objRed17->getFont()->setSize(9);
$objRed17->getFont()->setName('Times New Roman');
$objGreen17->getFont()->setSize(9);
$objGreen17->getFont()->setItalic(true);
$objGreen17->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B16')->setValue($objRichText17);
$this->excel->getActiveSheet()->getStyle('B16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('D16' . ':I16');
$this->excel->getActiveSheet()->setCellValue('D16', $data['code_tax']);
$this->excel->getActiveSheet()->getStyle('D16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B17' . ':C17');
$objRichText18 = new PHPExcel_RichText();
$objRed18 = $objRichText18->createTextRun('Địa chỉ');
$objRed18->getFont()->setBold(true);
$objGreen18 = $objRichText18->createTextRun(" (Address):");
$objRichText18->createText(' ');
$objRed18->getFont()->setSize(9);
$objRed18->getFont()->setName('Times New Roman');
$objGreen18->getFont()->setSize(9);
$objGreen18->getFont()->setItalic(true);
$objGreen18->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B17')->setValue($objRichText18);
$this->excel->getActiveSheet()->getStyle('B17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('D17' . ':I17');
$this->excel->getActiveSheet()->setCellValue('D17', $data['address']);
$this->excel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B18' . ':C18');
$objRichText19 = new PHPExcel_RichText();
$objRed19 = $objRichText19->createTextRun('Số tài khoản');
$objRed19->getFont()->setBold(true);
$objGreen19 = $objRichText19->createTextRun(" (Acount no):");
$objRichText19->createText(' ');
$objRed19->getFont()->setSize(9);
$objRed19->getFont()->setName('Times New Roman');
$objGreen19->getFont()->setSize(9);
$objGreen19->getFont()->setItalic(true);
$objGreen19->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B18')->setValue($objRichText19);
$this->excel->getActiveSheet()->getStyle('B18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->setActiveSheetIndex(0)->mergeCells('D18' . ':E18');
$this->excel->getActiveSheet()->setCellValue('D18', $data['account_number']);
$this->excel->getActiveSheet()->getStyle('D18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B19' . ':C19');
$this->excel->setActiveSheetIndex(0)->mergeCells('D19' . ':E19');
$objRichText20 = new PHPExcel_RichText();
$objRed20 = $objRichText20->createTextRun('Hình thức TT');
$objRed20->getFont()->setBold(true);
$objGreen20 = $objRichText20->createTextRun(" (Payment of term):");
$objRichText20->createText(' ');
$objRed20->getFont()->setSize(9);
$objRed20->getFont()->setName('Times New Roman');
$objGreen20->getFont()->setSize(9);
$objGreen20->getFont()->setItalic(true);
$objGreen20->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B19')->setValue($objRichText20);
$this->excel->getActiveSheet()->getStyle('B19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('F18' . ':I18');
$objRichText14 = new PHPExcel_RichText();
$objRed14 = $objRichText14->createTextRun('Tại ngân hàng');
$objRed14->getFont()->setBold(true);
$objGreen14 = $objRichText14->createTextRun(" (Bank's name):");
$objRichText14->createText(' ');
$objRed14->getFont()->setSize(9);
$objRed14->getFont()->setName('Times New Roman');
$objGreen14->getFont()->setSize(9);
$objGreen14->getFont()->setItalic(true);
$objGreen14->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('F18')->setValue($objRichText14);
$this->excel->getActiveSheet()->getStyle('F18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


$this->excel->getActiveSheet()->getStyle('D19')->getFont()->setSize(9);
$this->excel->getActiveSheet()->getStyle('D19')->getFont()->setBold(true);
$this->excel->getActiveSheet()->setCellValue('D19', $payment['payment_type']);
$this->excel->getActiveSheet()->getStyle('G19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$this->excel->setActiveSheetIndex(0)->mergeCells('F20' . ':H20');
$objRichText32 = new PHPExcel_RichText();
$objRed32 = $objRichText32->createTextRun('Đơn vị tiền tệ');
$objRed32->getFont()->setBold(true);
$objGreen32 = $objRichText32->createTextRun(" (Unit currency):");
$objRichText32->createText(' ');
$objRed32->getFont()->setSize(9);
$objRed32->getFont()->setName('Times New Roman');
$objGreen32->getFont()->setSize(9);
$objGreen32->getFont()->setItalic(true);
$objGreen32->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('F20')->setValue($objRichText32);
$this->excel->getActiveSheet()->getStyle('F20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->setCellValue('I20', "VND");

$this->excel->getActiveSheet()->setCellValue('B22', "STT");
$this->excel->getActiveSheet()->getStyle('B22')->getFont()->setBold(true);
$this->excel->getActiveSheet()->setCellValue('C22', "Mã/Tên hàng hóa, dv, gói sản phẩm");
$this->excel->getActiveSheet()->getStyle('C22')->getFont()->setBold(true);
$this->excel->setActiveSheetIndex(0)->mergeCells('D22:E22');
$this->excel->getActiveSheet()->setCellValue('D22', "Mô tả/Hình ảnh");
$this->excel->getActiveSheet()->getStyle('D22')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('C22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('F22', "ĐV tính");
$this->excel->getActiveSheet()->setCellValue('G22', "Số lượng");
$this->excel->getActiveSheet()->setCellValue('H22', "Đơn giá");
$this->excel->getActiveSheet()->setCellValue('I22', "Thành tiền");

$this->excel->getActiveSheet()->setCellValue('B23', "(Items)");
$this->excel->getActiveSheet()->getStyle('B23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B23')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->setCellValue('C23', "(Nam,Number)");
$this->excel->getActiveSheet()->getStyle('C23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C23')->getFont()->setItalic(true);
$this->excel->setActiveSheetIndex(0)->mergeCells('D23' . ':D23');
$this->excel->getActiveSheet()->setCellValue('D23', "(Description)");
$this->excel->getActiveSheet()->getStyle('D23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D23')->getFont()->setItalic(true);

$this->excel->getActiveSheet()->setCellValue('E23', "(Images)");
$this->excel->getActiveSheet()->getStyle('E23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('E23')->getFont()->setItalic(true);

$this->excel->getActiveSheet()->setCellValue('F23', "(Units)");
$this->excel->getActiveSheet()->getStyle('F23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('F23')->getFont()->setItalic(true);

$this->excel->getActiveSheet()->setCellValue('G23', "(Quantity)");
$this->excel->getActiveSheet()->getStyle('G23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('G23')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->setCellValue('H23', "(Unit price)");
$this->excel->getActiveSheet()->getStyle('H23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('H23')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('I23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('I23', "(Amount)");
$this->excel->getActiveSheet()->getStyle('I23')->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('A23:I23')->getFont()->setSize(9);

$this->excel->getActiveSheet()->getStyle('A23:I23')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
//DEN DAY
$this->excel->getActiveSheet()->getStyle('F22:I22')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('F22:I22')->getFont()->setSize(9);
$this->excel->getActiveSheet()->getStyle('F22:I22')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->setActiveSheetIndex(0)->mergeCells('C24' . ':E24');
$this->excel->getActiveSheet()->setCellValue('B24', "A");
$this->excel->getActiveSheet()->setCellValue('C24', "B");
$this->excel->getActiveSheet()->getStyle('B24:I24')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('F24', "C");
$this->excel->getActiveSheet()->setCellValue('G24', "1");
$this->excel->getActiveSheet()->setCellValue('H24', "2");
$this->excel->getActiveSheet()->setCellValue('I24', "3 = 1 x 2");
$this->excel->getActiveSheet()->getStyle('B24:I24')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('B24:I24')->getFont()->setSize(8);
$this->excel->getActiveSheet()->getStyle('F24:I24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/* */
$styleDOTBlackBorderOutline = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$styleDOTBlackBorderTOPBOTOutline = array(
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
/* */
$k = 25;
$stt = 1;
$tongtienhang = 0;
$arr_item = array();
$arr_service = array();
foreach ($data['cart'] as $line => $val) {
    if ($val['item_id']) {
        $info_item = $this->Item->get_info($val['item_id']);
        if ($info_item->service == 0) {
            $arr_item[] = array(
                'item_id' => $val['item_id'],
                'line' => $line,
                'name' => $val['name'],
                'item_number' => $val['item_number'],
                'description' => $val['description'],
                'serialnumber' => $val['serialnumber'],
                'allow_alt_description' => $val['allow_alt_description'],
                'is_serialized' => $val['is_serialized'],
                'quantity' => $val['quantity'],
                'stored_id' => $val['stored_id'],
                'discount' => $val['discount'],
                'price' => $val['price'],
                'price_rate' => $val['price_rate'],
                'taxes' => $val['taxes'],
                'unit' => $val['unit']
            );
        } else {
            $arr_service[] = array(
                'item_id' => $val['item_id'],
                'line' => $line,
                'name' => $val['name'],
                'item_number' => $val['item_number'],
                'description' => $val['description'],
                'serialnumber' => $val['serialnumber'],
                'allow_alt_description' => $val['allow_alt_description'],
                'is_serialized' => $val['is_serialized'],
                'quantity' => $val['quantity'],
                'stored_id' => $val['stored_id'],
                'discount' => $val['discount'],
                'price' => $val['price'],
                'price_rate' => $val['price_rate'],
                'taxes' => $val['taxes'],
                'unit' => $val['unit']
            );
        }
    } else {
        $arr_item[] = array(
            'pack_id' => $val['pack_id'],
            'line' => $val['line'],
            'pack_number' => $val['pack_number'],
            'name' => $val['name'],
            'description' => $val['description'],
            'quantity' => $val['quantity'],
            'discount' => $val['discount'],
            'price' => $val['price'],
            'taxes' => $val['taxes'],
            'unit' => $val['unit']
        );
    }
}

if ($excel == 0) {
    foreach ($arr_item as $line => $item) {
        if ($item['unit'] == 'unit') {
            $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
        } else {
            $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
        }

        if ($item['pack_id']) {
            $this->load->model('Unit');
            $this->load->model('Pack');
            $this->load->model('Item');
            $this->load->model('Pack_items');
            $pack = $this->Pack->all_pack();
            $pack_item = $this->Pack_items->get_all();
            $item_info = $this->Item->all_items();
            foreach ($pack as $key => $pack_info) {
                if ($pack_info['pack_id'] == $item['pack_id'] && $this->Pack->get_info($pack_info['pack_id'])->status_material == 1) {
                    $this->excel->setActiveSheetIndex(0)->mergeCells('B' . $k . ':B' . ($k ++));
                    $this->excel->getActiveSheet()->setCellValue('B' . $k, $item['line']);
                    $this->excel->getActiveSheet()->getStyle('B' . $k)->getAlignment()->setIndent(1);

                    $this->excel->getActiveSheet()->setCellValue('C' . ($k), $item['name'] . '(Gói sản phẩm)');
                    $this->excel->getActiveSheet()->getStyle('C' . $k)->getFont()->setBold(true);
                    $this->excel->setActiveSheetIndex(0)->mergeCells('D' . $k . ':D' . ($k));
                    $this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($k) . ':D' . ($k));
                    $this->excel->getActiveSheet()->setCellValue('D' . ($k), $this->Pack->get_info($pack_info['pack_id'])->description);
                    $this->excel->getActiveSheet()->getStyle('D' . $k)->getFont()->setBold(false);
                    $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->setActiveSheetIndex(0)->mergeCells('F' . $k . ':F' . ($k + 1));

                    $unit = $this->Pack->get_info($pack_info['pack_id'])->unit;
                    $unit_name_pack = $this->Unit->get_info($unit);

                    $this->excel->getActiveSheet()->setCellValue('F' . $k, $unit_name_pack->name);
                    $this->excel->getActiveSheet()->getStyle('F' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $this->excel->setActiveSheetIndex(0)->mergeCells('G' . $k . ':G' . ($k + 1));
                    $this->excel->getActiveSheet()->setCellValue('G' . $k, $item['quantity']);
                    $this->excel->getActiveSheet()->getStyle('G' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $this->excel->getActiveSheet()->getStyle('G' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->setActiveSheetIndex(0)->mergeCells('H' . $k . ':H' . ($k + 1));
                    if ($item['unit'] == 'unit') {
                        $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price']));
                    } else {
                        $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price_rate']));
                    }
                    $this->excel->getActiveSheet()->getStyle('H' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $this->excel->getActiveSheet()->getStyle('H' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    if ($item['unit'] == "unit") {
                        $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100));
                    } else {
                        $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100));
                    }
                    $this->excel->setActiveSheetIndex(0)->mergeCells('I' . $k . ':I' . ($k + 1));
                    $this->excel->getActiveSheet()->getStyle('I' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $this->excel->getActiveSheet()->getStyle('I' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    foreach ($pack_item as $pack_item_info) {
                        if ($pack_item_info['pack_id'] == $pack_info['pack_id']) {
                            foreach ($item_info as $it) {
                                if ($pack_item_info['item_id'] == $it['item_id']) {
                                    $this->excel->getActiveSheet()->setCellValue('C' . ($k += 1), $this->Item->get_info($it['item_id'])->name);
                                    $this->excel->getActiveSheet()->getStyle('C' . ($k += 1))->getAlignment()->setWrapText(true);
                                    $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                                }
                            }
                        }
                    }
                } else if ($pack_info['pack_id'] == $item['pack_id'] && $this->Pack->get_info($pack_info['pack_id'])->status_material != 1) {
                    $this->excel->setActiveSheetIndex(0)->mergeCells('B' . $k . ':B' . ($k + 1));
                    $this->excel->getActiveSheet()->setCellValue('B' . $k, $item['line']);
                    $this->excel->getActiveSheet()->getStyle('B' . $k)->getAlignment()->setIndent(1);

                    $this->excel->getActiveSheet()->setCellValue('C' . ($k), '');
                    $this->excel->getActiveSheet()->setCellValue('C' . ($k + 1), $item['name']);
                    $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setWrapText(true);

                    $this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($k) . ':D' . ($k + 1));
                    $this->excel->getActiveSheet()->setCellValue('D' . ($k), $this->Pack->get_info($pack_info['pack_id'])->description);
                    $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('D' . $k)->getFont()->setBold(false);
                    $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

                    $this->excel->getActiveSheet()->getStyle('C' . $k)->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('C' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

                    $this->excel->setActiveSheetIndex(0)->mergeCells('F' . $k . ':F' . ($k + 1));
                    $unit = $this->Pack->get_info($pack_info['pack_id'])->unit;
                    $unit_name_pack = $this->Unit->get_info($unit);
                    $this->excel->getActiveSheet()->setCellValue('F' . $k, $unit_name_pack->name);
                    $this->excel->getActiveSheet()->getStyle('F' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $this->excel->setActiveSheetIndex(0)->mergeCells('G' . $k . ':G' . ($k + 1));
                    $this->excel->getActiveSheet()->setCellValue('G' . $k, $item['quantity']);
                    $this->excel->getActiveSheet()->getStyle('G' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->setActiveSheetIndex(0)->mergeCells('H' . $k . ':H' . ($k + 1));
                    if ($item['unit'] == 'unit') {
                        $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price']));
                    } else {
                        $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price_rate']));
                    }
                    $this->excel->getActiveSheet()->getStyle('H' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    if ($item['unit'] == "unit") {
                        $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100));
                    } else {
                        $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100));
                    }

                    $this->excel->setActiveSheetIndex(0)->mergeCells('I' . $k . ':I' . ($k + 1));
                    $this->excel->getActiveSheet()->getStyle('I' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                }
            }
        } else {
            $this->excel->setActiveSheetIndex(0)->mergeCells('B' . $k . ':B' . ($k + 1));
            $this->excel->getActiveSheet()->setCellValue('B' . $k, $item['line']);
            $this->excel->getActiveSheet()->getStyle('B' . $k)->getAlignment()->setIndent(1);

            $this->excel->getActiveSheet()->setCellValue('C' . ($k), $this->Item->get_info($item['item_id'])->item_number);
            $this->excel->getActiveSheet()->setCellValue('C' . ($k + 1), $this->Item->get_info($item['item_id'])->name);
            $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setWrapText(true);

            $this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($k) . ':D' . ($k + 1));
            $this->excel->getActiveSheet()->setCellValue('D' . ($k), $item['description']);
            $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('D' . $k)->getFont()->setBold(false);
            $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $this->excel->getActiveSheet()->getStyle('C' . $k)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $this->excel->setActiveSheetIndex(0)->mergeCells('F' . $k . ':F' . ($k + 1));
            if ($item['item_id']) {
                $term = $this->Item->get_info($item['item_id']);
                if ($item['unit'] == 'unit') {
                    $unit_name = $this->Unit->get_info($term->unit);
                } else {
                    $unit_name = $this->Unit->get_info($term->unit_from);
                }
            } else {
                $term = $this->Item_kit->get_info($item['item_kit_id']);
                $unit_name = $this->Unit->get_info($term->unit);
            }
            $this->excel->getActiveSheet()->setCellValue('F' . $k, $unit_name->name);
            $this->excel->getActiveSheet()->getStyle('F' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $this->excel->setActiveSheetIndex(0)->mergeCells('G' . $k . ':G' . ($k + 1));
            $this->excel->getActiveSheet()->setCellValue('G' . $k, $item['quantity']);
            $this->excel->getActiveSheet()->getStyle('G' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->setActiveSheetIndex(0)->mergeCells('H' . $k . ':H' . ($k + 1));
            if ($item['unit'] == 'unit') {
                $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price']));
            } else {
                $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price_rate']));
            }
            $this->excel->getActiveSheet()->getStyle('H' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            if ($item['unit'] == "unit") {
                $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100));
            } else {
                $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100));
            }

            $this->excel->setActiveSheetIndex(0)->mergeCells('I' . $k . ':I' . ($k + 1));
            $this->excel->getActiveSheet()->getStyle('I' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('B' . $k . ':I' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B' . $k . ':C' . ($k))->applyFromArray($styleDOTBlackBorderOutline);

            $this->excel->getActiveSheet()->getStyle('B' . ($k))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }

        $this->excel->getActiveSheet()->getStyle('B' . $k . ':I' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B' . $k . ':C' . ($k))->applyFromArray($styleDOTBlackBorderOutline);

        $this->excel->getActiveSheet()->getStyle('B' . ($k))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        if ($item['pack_id']) {
            $anh = $this->Pack->get_info($item['pack_id'])->images;
            if ($anh != "") {
                $imagePath = 'packs/' . $anh;
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setPath($imagePath);
                $objDrawing->setHeight(90);
                $objDrawing->setWidth(145);
                $objDrawing->setCoordinates('E' . ($k + 1));
                $objDrawing->setWorksheet($this->excel->getActiveSheet());
                $this->excel->getActiveSheet()->getStyle('E' . ($k + 1))->getAlignment()->setIndent(5);
                $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            } else {
                $this->excel->getActiveSheet()->setCellValue('E' . $k, "");
                $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        } else {
            $anh = $this->Item->get_info($item['item_id'])->images;
            if ($anh != "") {
                $imagePath = 'item/' . $anh;
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setPath($imagePath);
                $objDrawing->setHeight(90);
                $objDrawing->setWidth(145);
                $objDrawing->setCoordinates('E' . ($k));
                $objDrawing->setWorksheet($this->excel->getActiveSheet());
                $this->excel->getActiveSheet()->getStyle('E' . ($k))->getAlignment()->setIndent(5);
                $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            } else {
                $this->excel->getActiveSheet()->setCellValue('E' . $k, "");
                $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }

        $this->excel->getActiveSheet()->getRowDimension($k + 1)->setRowHeight(90);
        $this->excel->getActiveSheet()->getStyle('A' . ($k + 1) . ':I' . ($k + 1))->getBorders()->getBOTTOM()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        if ($item['unit'] == 'unit') {
            $tongtienhang += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
        } else {
            $tongtienhang += $item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100;
        }

        $k+=2;
        $stt++;
    }
} else {
    foreach ($arr_service as $line => $item) {
        if ($item['unit'] == 'unit') {
            $total_taxes_percent += $item['taxes'] * ($item['price'] * $item['quantity'] - $item['discount'] * $item['price'] * $item['quantity'] / 100) / 100;
        } else {
            $total_taxes_percent += $item['taxes'] * ($item['price_rate'] * $item['quantity'] - $item['discount'] * $item['price_rate'] * $item['quantity'] / 100) / 100;
        }

        $this->excel->setActiveSheetIndex(0)->mergeCells('B' . $k . ':B' . ($k + 1));
        $this->excel->getActiveSheet()->setCellValue('B' . $k, $item['line']);
        $this->excel->getActiveSheet()->getStyle('B' . $k)->getAlignment()->setIndent(1);

        $this->excel->getActiveSheet()->setCellValue('C' . ($k), $this->Item->get_info($item['item_id'])->item_number);
        $this->excel->getActiveSheet()->setCellValue('C' . ($k + 1), $this->Item->get_info($item['item_id'])->name);
        $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setWrapText(true);

        $this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($k) . ':D' . ($k + 1));
        $this->excel->getActiveSheet()->setCellValue('D' . ($k), $item['description']);
        $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setWrapText(true);
        $this->excel->getActiveSheet()->getStyle('D' . $k)->getFont()->setBold(false);
        $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('D' . ($k))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $this->excel->getActiveSheet()->getStyle('C' . $k)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C' . ($k + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $this->excel->setActiveSheetIndex(0)->mergeCells('F' . $k . ':F' . ($k + 1));
        if ($item['item_id']) {
            $term = $this->Item->get_info($item['item_id']);
            if ($item['unit'] == 'unit') {
                $unit_name = $this->Unit->get_info($term->unit);
            } else {
                $unit_name = $this->Unit->get_info($term->unit_from);
            }
        } else {
            $term = $this->Item_kit->get_info($item['item_kit_id']);
            $unit_name = $this->Unit->get_info($term->unit);
        }
        $this->excel->getActiveSheet()->setCellValue('F' . $k, $unit_name->name);
        $this->excel->getActiveSheet()->getStyle('F' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $this->excel->setActiveSheetIndex(0)->mergeCells('G' . $k . ':G' . ($k + 1));
        $this->excel->getActiveSheet()->setCellValue('G' . $k, $item['quantity']);
        $this->excel->getActiveSheet()->getStyle('G' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->setActiveSheetIndex(0)->mergeCells('H' . $k . ':H' . ($k + 1));
        if ($item['unit'] == 'unit') {
            $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price']));
        } else {
            $this->excel->getActiveSheet()->setCellValue('H' . $k, to_currency_unVND_nomar($item['price_rate']));
        }
        $this->excel->getActiveSheet()->getStyle('H' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        if ($item['unit'] == "unit") {
            $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100));
        } else {
            $this->excel->getActiveSheet()->setCellValue('I' . $k, to_currency_unVND_nomar($item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100));
        }

        $this->excel->setActiveSheetIndex(0)->mergeCells('I' . $k . ':I' . ($k + 1));
        $this->excel->getActiveSheet()->getStyle('I' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->excel->getActiveSheet()->getStyle('B' . $k . ':I' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B' . $k . ':C' . ($k))->applyFromArray($styleDOTBlackBorderOutline);

        $this->excel->getActiveSheet()->getStyle('B' . ($k))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


        $this->excel->getActiveSheet()->getStyle('B' . $k . ':I' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B' . $k . ':C' . ($k))->applyFromArray($styleDOTBlackBorderOutline);

        $this->excel->getActiveSheet()->getStyle('B' . ($k))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $anh = $this->Item->get_info($item['item_id'])->images;
        if ($anh != "") {
            $imagePath = 'item/' . $anh;
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setPath($imagePath);
            $objDrawing->setHeight(90);
            $objDrawing->setWidth(145);
            $objDrawing->setCoordinates('E' . ($k));
            $objDrawing->setWorksheet($this->excel->getActiveSheet());
            $this->excel->getActiveSheet()->getStyle('E' . ($k))->getAlignment()->setIndent(5);
            $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else {
            $this->excel->getActiveSheet()->setCellValue('E' . $k, "");
            $this->excel->getActiveSheet()->getStyle('E' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $this->excel->getActiveSheet()->getRowDimension($k + 1)->setRowHeight(90);
        $this->excel->getActiveSheet()->getStyle('A' . ($k + 1) . ':I' . ($k + 1))->getBorders()->getBOTTOM()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        if ($item['unit'] == 'unit') {
            $tongtienhang += $item['price'] * $item['quantity'] - $item['price'] * $item['quantity'] * $item['discount'] / 100;
        } else {
            $tongtienhang += $item['price_rate'] * $item['quantity'] - $item['price_rate'] * $item['quantity'] * $item['discount'] / 100;
        }

        $k+=2;
        $stt++;
    }
}
/* style border cot */
$this->excel->getActiveSheet()->getStyle('B25:B' . ($k - 1))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B25:B' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('D25:D' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('E25:E' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('F25:F' . ($k - 1))->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('F25:F' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('G25:G' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('H25:H' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('I25:I' . ($k - 1))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
/* end style border cot */
if ($k = $k) {
    for ($a = $k; $a <= $k; $a++) {
        $this->excel->getActiveSheet()->getStyle('B' . $a . ':I' . ($a))->applyFromArray($styleDOTBlackBorderOutline);
        $this->excel->getActiveSheet()->getRowDimension($a)->setRowHeight(50);
    }
}

$i = $this->excel->getActiveSheet()->getHighestRow();
$this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($i) . ':G' . ($i));
$objRichText = new PHPExcel_RichText();
$objRed = $objRichText->createTextRun('Cộng tiền hàng');
$objRed->getFont()->setBold(true);
$objGreen = $objRichText->createTextRun(' (Value of goods):');
$objRichText->createText(' ');
$objRed->getFont()->setSize(9);
$objRed->getFont()->setName('Times New Roman');
$objGreen->getFont()->setSize(9);
$objGreen->getFont()->setItalic(true);
$objGreen->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('D' . ($i))->setValue($objRichText);
$this->excel->getActiveSheet()->getStyle('B' . ($i) . ':G' . ($i + 2))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3) . ':I' . ($i + 2))->getBorders()->getBOTTOM()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i) . ':I' . ($i))->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('D' . ($i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('D' . ($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->setCellValue('I' . $i, to_currency_unVND_nomar($tongtienhang));
$this->excel->getActiveSheet()->getStyle('I' . ($i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 1) . ':C' . ($i + 1));
$objRichText2 = new PHPExcel_RichText();
$objRed2 = $objRichText2->createTextRun('');
$objRed2->getFont()->setBold(true);
$objGreen2 = $objRichText2->createTextRun(' ');
$objRichText2->createText(' ');
$objRed2->getFont()->setSize(9);
$objRed2->getFont()->setName('Times New Roman');
$objGreen2->getFont()->setSize(9);
$objGreen2->getFont()->setItalic(true);
$objGreen2->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B' . ($i + 1))->setValue($objRichText2);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 1))->getAlignment()->setIndent(1);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 1) . ':I' . ($i + 1))->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($i + 1) . ':G' . ($i + 1));
$this->excel->getActiveSheet()->setCellValue('D' . ($i + 1), "Tiền thuế GTGT (VAT): ");
$this->excel->getActiveSheet()->getStyle('D' . ($i + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D' . ($i + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('D' . ($i + 1))->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('D' . ($i + 1))->getFont()->setSize(9);
$this->excel->getActiveSheet()->setCellValue('I' . ($i + 1), to_currency_unVND_nomar($total_taxes_percent));
$this->excel->getActiveSheet()->getStyle('I' . ($i + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 2) . ':G' . ($i + 2));
$objRichText1 = new PHPExcel_RichText();
$objRed1 = $objRichText1->createTextRun('Tổng cộng tiền thanh toán');
$objRed1->getFont()->setBold(true);
$objGreen1 = $objRichText1->createTextRun(' (Total):');
$objRichText1->createText(' ');
$objRed1->getFont()->setSize(9);
$objRed1->getFont()->setName('Times New Roman');
$objGreen1->getFont()->setSize(9);
$objGreen1->getFont()->setItalic(true);
$objGreen1->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B' . ($i + 2))->setValue($objRichText1);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 2) . ':I' . ($i + 2))->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$this->excel->getActiveSheet()->setCellValue('I' . ($i + 2), to_currency_unVND_nomar($tongtienhang + $total_taxes_percent));
$this->excel->getActiveSheet()->getStyle('I' . ($i + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 3) . ':G' . ($i + 3));
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3))->getFont()->setSize(9);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3))->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3) . ':I' . ($i + 3))->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3) . ':G' . ($i + 3))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 3), "Còn nợ lại : ");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$this->excel->getActiveSheet()->getStyle('I' . ($i + 3))->getFont()->setSize(11);

if ($payments_cost > 0) {
    $this->excel->getActiveSheet()->setCellValue('I' . ($i + 3), to_currency_unVND_nomar($payments_cost));
    $this->excel->getActiveSheet()->getStyle('I' . ($i + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
} else {
    $this->excel->getActiveSheet()->setCellValue('I' . ($i + 3), to_currency_unVND_nomar($data['total']));
    $this->excel->getActiveSheet()->getStyle('I' . ($i + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}


$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 4) . ':C' . ($i + 4));
$this->excel->setActiveSheetIndex(0)->mergeCells('D' . ($i + 4) . ':I' . ($i + 4));
$objRichText7 = new PHPExcel_RichText();
$objRed7 = $objRichText7->createTextRun('Số tiền viết bằng chữ');
$objRed7->getFont()->setBold(true);
$objGreen7 = $objRichText7->createTextRun(' (Inwords):');
$objRichText7->createText(' ');
$objRed7->getFont()->setSize(9);
$objRed7->getFont()->setName('Times New Roman');
$objGreen7->getFont()->setSize(9);
$objGreen7->getFont()->setItalic(true);
$objGreen7->getFont()->setName('Times New Roman');
$this->excel->getActiveSheet()->getCell('B' . ($i + 4))->setValue($objRichText7);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 4))->getAlignment()->setIndent(1);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 4) . ':I' . ($i + 4))->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$c = to_currency_unVND_nomar($tongtienhang + $total_taxes_percent);
$a = str_replace(',', '', $c);
$this->excel->getActiveSheet()->setCellValue('D' . ($i + 4), $this->Cost->get_string_number($a));
$this->excel->getActiveSheet()->getStyle('D' . ($i + 4))->getFont()->setSize(10)->setBold(true)->setItalic(true);
$this->excel->getActiveSheet()->getStyle('D' . ($i + 4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$this->excel->getActiveSheet()->getStyle('D' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 5) . ':I' . ($i + 5));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 5), "- Đơn giá trên đã bao gồm thuế VAT");
$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 6) . ':I' . ($i + 6));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 6), "- Bảo hành 12 tháng kể từ ngày ký biên bản nghiệm thu hàng hóa");
$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 7) . ':I' . ($i + 7));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 7), "- Giá trên đã bao gồm các loại thuế, chi phí vận chuyển tại kho Hà Nội, bảo hiểm, bảo hành trong thời gian hoàn thành...");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 5) . ":I" . ($i + 7))->getFont()->setItalic(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('A' . ($i + 8) . ':I' . ($i + 8));
$this->excel->getActiveSheet()->setCellValue('A' . ($i + 8), "CÁC ĐIỀU KHOẢN THƯƠNG MẠI: ");
$this->excel->getActiveSheet()->getStyle('A' . ($i + 8))->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('A' . ($i + 8))->getFont()->setBold(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 9) . ':I' . ($i + 9));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 9), "- Giao hàng: Thời gian giao hàng trong vòng 25 ngày kể từ ngày ký hợp đồng có hiệu lực");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 9))->getAlignment()->setWrapText(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 10) . ':I' . ($i + 10));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 10), "- Địa điểm: Tại kho Bên A theo yêu cầu");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 10))->getAlignment()->setWrapText(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 11) . ':I' . ($i + 11));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 11), "- Thanh toán: Thanh toán 100% giá trị đơn hàng sau 30 ngày kể từ khi bên bán bàn giao hàng hóa cùng các chứng từ liên quan.
                Đặt cọc 50% tổng giá trị đơn hàng ngay sau khi ký hợp đồng.
                Đặt cọc 50% còn lại ngay sau khi nhận được chứng từ thanh toán từ bên bán hàng
");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 11))->getAlignment()->setWrapText(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 12) . ':I' . ($i + 12));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 12), "Quý khách hàng xin vui lòng chuyển khoản vào thông tin sau:
Tài khoản công ty:
Chủ TK: " . $this->config->item('corp_master_account') . " 
Số TK: " . $this->config->item('corp_number_account') . " 
Ngân hàng " . $this->config->item('corp_bank_name') . ", chi nhánh " . $this->config->item('corp_bank_affiliate') . " 

Tài khoản cá nhân:
Chủ TK: " . $this->config->item('private_master_account') . " 
Số TK: " . $this->config->item('private_number_account') . " 
Ngân hàng " . $this->config->item('private_bank_name') . ", chi nhánh " . $this->config->item('private_bank_affiliate') . " 
");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 12))->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 12))->getFont()->setBold(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 13) . ':I' . ($i + 13));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 13), "Hiệu lực: Bảng chào giá có hiệu lực 60 ngày kể từ ngày báo giá");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 13))->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 13))->getFont()->setBold(true);

$this->excel->setActiveSheetIndex(0)->mergeCells('B' . ($i + 14) . ':I' . ($i + 14));
$this->excel->getActiveSheet()->setCellValue('B' . ($i + 14), "Cảm ơn Quý khách hàng, mong sự cộng tác bền lâu!");
$this->excel->getActiveSheet()->getStyle('B' . ($i + 14))->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 14))->getFont()->setItalic(true);
$this->excel->getActiveSheet()->getStyle('B' . ($i + 14))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$this->excel->setActiveSheetIndex(0)->mergeCells('F' . ($i + 15) . ':I' . ($i + 15));
$this->excel->getActiveSheet()->setCellValue('F' . ($i + 15), "ĐẠI DIỆN NHÀ CUNG CẤP");
$this->excel->getActiveSheet()->getStyle('F' . ($i + 15))->getAlignment()->setWrapText(true);
$this->excel->getActiveSheet()->getStyle('F' . ($i + 15))->getFont()->setBold(true);

$this->excel->getActiveSheet()->getStyle('A' . ($i + 15))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A' . ($i + 15))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
/* */
/* */
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);
$this->excel->getActiveSheet()->getStyle('B1:J1')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('J1:J24')->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('A1:A24')->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B7:J7')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B14:J14')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B22:J22')->getBorders()->getTOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B23:J23')->getBorders()->getBOTTOM()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B24:J24')->getBorders()->getBOTTOM()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B23:B24')->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('C22:C24')->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('G23:G24')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('F23:F24')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('H23:H24')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('I23:I24')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$this->excel->getActiveSheet()->getStyle('B22:B23')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('C22:C23')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('G22:G23')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('F22:F23')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('H22:H23')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('I22:I23')->getBorders()->getLEFT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$this->excel->getActiveSheet()->getStyle('J' . ($i) . ':J' . ($i + 3))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('A' . ($i - 2) . ':A' . ($i + 3))->getBorders()->getRIGHT()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$this->excel->getActiveSheet()->getStyle('B1:B20')->getAlignment()->setIndent(1);
/* */
$this->excel->getActiveSheet()->getRowDimension('1:5')->setRowHeight(15.75);
$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(8.75);
$this->excel->getActiveSheet()->getRowDimension('14')->setRowHeight(18.75);
$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(8);
$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(8);
$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(20.25);
$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(19.5);
$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(12);
$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(14.75);
$this->excel->getActiveSheet()->getRowDimension($i + 1)->setRowHeight(14.75);
$this->excel->getActiveSheet()->getRowDimension($i + 2)->setRowHeight(14.75);
$this->excel->getActiveSheet()->getRowDimension($i + 3)->setRowHeight(0);
$this->excel->getActiveSheet()->getRowDimension($i + 4)->setRowHeight(27.75);
$this->excel->getActiveSheet()->getRowDimension($i + 11)->setRowHeight(60);
$this->excel->getActiveSheet()->getRowDimension($i + 12)->setRowHeight(160);
$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(0.5);
$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5.7);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30.95);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(24.9);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20.8);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(8.15);
$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8.9);
$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12.5);
$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(14.57);
$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(0.08);

//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
$md5file = md5(date('YmdHis')) . '.xlsx';
//$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
$filename = "BG_" . $sale_id . "_" . str_replace(" ", "", replace_character($data['customer'])) . "_" . date('dmYHis') . ".xlsx"; //save our workbook as this file name
$objWriter->save(APPPATH . "/../excel_materials/" . $filename);
if (file_exists($filename)) {
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename=""'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache 
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    ob_clean();
    flush();
    readfile($filename);
}
?>