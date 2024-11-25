<?php
// Include các file cần thiết
include("class/classdatabase.php");
require 'C:\xampp\htdocs\PTUD_git\PTUD\furni-1.0.0\page\admin\baocaotheodoitonkho\vendor\autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;


// Khởi tạo đối tượng database
$obj = new database();

// Lấy filter và định dạng từ request
$filter = isset($_POST['filter']) ? $_POST['filter'] : '';
$format = isset($_POST['format']) ? $_POST['format'] : 'excel';

// Tạo câu truy vấn dựa trên bộ lọc
$sql = "
    SELECT 
        maDauSach, 
        tenDauSach, 
        tongSoLuong, 
        soLuongDangThue, 
        maDM, 
        (tongSoLuong - soLuongDangThue) AS soLuongConLai
    FROM dausach";

if ($filter === 'low_stock') {
    $sql .= " WHERE (tongSoLuong - soLuongDangThue) > 0 AND (tongSoLuong - soLuongDangThue) < 3";
} elseif ($filter === 'out_of_stock') {
    $sql .= " WHERE (tongSoLuong - soLuongDangThue) = 0";
}

// Thực hiện truy vấn và lấy dữ liệu
$dausach = $obj->xuatdulieu($sql);

// Kiểm tra dữ liệu
if (!$dausach || !is_array($dausach)) {
    die("Không có dữ liệu để xuất báo cáo.");
}

// Xử lý xuất dữ liệu theo định dạng
if ($format === 'excel') {
    // Tạo đối tượng Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Tiêu đề cột
    $sheet->setCellValue('A1', 'Mã Đầu Sách')
          ->setCellValue('B1', 'Tên Đầu Sách')
          ->setCellValue('C1', 'Tổng Số Lượng')
          ->setCellValue('D1', 'Số Lượng Đang Thuê')
          ->setCellValue('E1', 'Số Lượng Còn Lại')
          ->setCellValue('F1', 'Mã Danh Mục');

    // Thêm dữ liệu vào các dòng
    $row = 2;
    foreach ($dausach as $item) {
        $sheet->setCellValue("A{$row}", $item['maDauSach'])
              ->setCellValue("B{$row}", $item['tenDauSach'])
              ->setCellValue("C{$row}", $item['tongSoLuong'])
              ->setCellValue("D{$row}", $item['soLuongDangThue'])
              ->setCellValue("E{$row}", $item['soLuongConLai'])
              ->setCellValue("F{$row}", $item['maDM']);
        $row++;
    }

    // Xuất file Excel
    $writer = new Xlsx($spreadsheet);
    $filename = 'baocaotonkho.xlsx';

    // Gửi headers cho phép tải xuống file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Lưu file vào output
    $writer->save('php://output');
    exit;

} elseif ($format === 'pdf') {
    if (!class_exists('TCPDF')) {
        require_once __DIR__ . '/tcpdf/tcpdf.php';
    }

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('Báo Cáo Tồn Kho');
    $pdf->SetHeaderData('', 0, 'Báo Cáo Tồn Kho', '');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // **Thiết lập font Unicode**
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->AddPage();
    $html = '<h3 style="font-family: dejavusans;">Báo Cáo Tồn Kho</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Mã Đầu Sách</th>
                <th>Tên Đầu Sách</th>
                <th>Tổng Số Lượng</th>
                <th>Số Lượng Đang Thuê</th>
                <th>Số Lượng Còn Lại</th>
                <th>Mã Danh Mục</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($dausach as $item) {
        $html .= '<tr>
            <td>' . htmlspecialchars($item['maDauSach'], ENT_QUOTES, 'UTF-8') . '</td>
            <td>' . htmlspecialchars($item['tenDauSach'], ENT_QUOTES, 'UTF-8') . '</td>
            <td>' . $item['tongSoLuong'] . '</td>
            <td>' . $item['soLuongDangThue'] . '</td>
            <td>' . $item['soLuongConLai'] . '</td>
            <td>' . $item['maDM'] . '</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('baocaotonkho.pdf', 'D');
    exit;

} elseif ($format === 'word') {
    // Xuất file Word
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $section->addText('Báo Cáo Tồn Kho', ['bold' => true, 'size' => 16]);

    // Tiêu đề bảng
    $table = $section->addTable();
    $table->addRow();
    $table->addCell()->addText('Mã Đầu Sách');
    $table->addCell()->addText('Tên Đầu Sách');
    $table->addCell()->addText('Tổng Số Lượng');
    $table->addCell()->addText('Số Lượng Đang Thuê');
    $table->addCell()->addText('Số Lượng Còn Lại');
    $table->addCell()->addText('Mã Danh Mục');

    // Ghi dữ liệu
    foreach ($dausach as $item) {
        $table->addRow();
        $table->addCell()->addText($item['maDauSach']);
        $table->addCell()->addText($item['tenDauSach']);
        $table->addCell()->addText($item['tongSoLuong']);
        $table->addCell()->addText($item['soLuongDangThue']);
        $table->addCell()->addText($item['soLuongConLai']);
        $table->addCell()->addText($item['maDM']);
    }

    // Xuất file Word
    $filename = 'baocaotonkho.docx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save('php://output');
    exit;

} else {
    die("Định dạng file không hợp lệ.");
}
?>
