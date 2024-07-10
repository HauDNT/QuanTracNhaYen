<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function exportExcel(array $data, array $headers = [], $fileName = 'data.xlsx')
{
  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  foreach ($headers as $index => $value) {
    $sheet->setCellValue([$index + 1, 1], $value);
  }

  $rows = 1;
  foreach($data as $item) {
    $rows++;
    $cols = 0;
    foreach($item as $value) {
      $sheet->setCellValue([++$cols, $rows], $value);
    }
  }

  $writer = new Xlsx($spreadsheet);
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
  $writer->save('php://output');
}
