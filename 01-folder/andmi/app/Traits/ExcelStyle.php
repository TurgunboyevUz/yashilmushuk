<?php

namespace App\Traits;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait ExcelStyle
{
    public function styles(Worksheet $sheet)
    {
        $headingCount = count($this->headings());
        $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($headingCount); // e.g., J for 10 columns

        $sheet->getStyle("A1:{$endColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0080FF'],
            ],
        ]);

        $highestRow = $sheet->getHighestRow(); // Get the total number of rows dynamically
        if ($highestRow > 1) { // Check if there are any data rows
            $sheet->getStyle("A2:{$endColumn}{$highestRow}")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);
        }

        foreach (range(1, $headingCount) as $columnIndex) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
        }
    }
}
