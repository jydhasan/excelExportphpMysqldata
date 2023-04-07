<?php
$conn = mysqli_connect("localhost", "root", "", "excelphp") or die . mysqli_connect_error();
$result = mysqli_query($conn, "select *from excel");
// while ($row = mysqli_fetch_assoc($result)) {
//     echo $row['name'];
// }

require_once 'PHPExcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

$row = 1;
while ($data = mysqli_fetch_array($result)) {
    $col = 0;
    foreach ($data as $value) {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="table_name.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
