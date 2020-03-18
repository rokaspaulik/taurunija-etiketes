<?php

namespace App\Utils;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LabGenerator
{
    private $labelAreaStartCol = 'A';
    private $labelAreaStartRow = '1';
    private $labelAreaEndCol = 'G';
    private $labelAreaEndRow = '4';

    private $priceAreaStartCol = 'C';
    private $priceAreaStartRow = '1';
    private $priceAreaEndCol = 'E';
    private $priceAreaEndRow = '1';

    private $contentTxtAreaStartCol = 'A';
    private $contentTxtAreaStartRow = '2';
    private $contentTxtAreaEndCol = 'A';
    private $contentTxtAreaEndRow = '3';

    private $contentBodyTxtAreaStartCol = 'C';
    private $contentBodyTxtAreaStartRow = '2';
    private $contentBodyTxtAreaEndCol = 'C';
    private $contentBodyTxtAreaEndRow = '3';

    private $priceValueCellCol = 'C';
    private $priceValueCellRow = '1';

    private $priceTextCellCol = 'A';
    private $priceTextCellRow = '1';

    private $dimensionsValueCellCol = 'F';
    private $dimensionsValueCellRow = '4';

    private $countryTextCellCol = 'G';
    private $countryTextCellRow = '1';

    private $fabricTextCellCol = 'A';
    private $fabricTextCellRow = '2';

    private $structureTextCellCol = 'A';
    private $structureTextCellRow = '3';

    private $widthValueCol = 'F';
    private $widthValueRow = '4';

    private $symbolCol = 'A';
    private $symbolRow = '4';

    private $infoCol = 'F';
    private $infoRow = '1';

    private $iconCol = 'G';
    private $iconRow = '2';

    private $collumns = array();
    private $rows = array();

    private $styles = [
        'kaina' => array(
            'font' => [
                'italic' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ),
        'outlineStyle' => array(
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ),
        'countryStlye' => array(
            'font' => [
                'size' => 7,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ),
        'widthLenghtStyle' => array(
            'font' => [
                'size' => 10,
                'name' => 'Calibri'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM,
            ],
        ),
        'priceStyle' => array(
            'font' => [
                'size' => 20,
                'name' => 'Calibri',
                'bold' => true
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM,
            ],
        ),
    ];

    private $sheet;

    private $counter = 0;

    function __construct()
    {
        $this->sheet = new Spreadsheet();

        // Populate collumns array
        array_push($this->collumns,
            $this->labelAreaStartCol,
            $this->labelAreaEndCol,
            $this->priceAreaStartCol,
            $this->priceAreaEndCol,
            $this->contentTxtAreaStartCol,
            $this->contentTxtAreaEndCol,
            $this->contentBodyTxtAreaStartCol,
            $this->contentBodyTxtAreaEndCol,
            $this->priceValueCellCol,
            $this->priceTextCellCol,
            $this->dimensionsValueCellCol,
            $this->countryTextCellCol,
            $this->fabricTextCellCol,
            $this->structureTextCellCol,
            $this->widthValueCol,
            $this->iconCol,
            $this->symbolCol,
            $this->infoCol
            );

        // Populate rows array
        array_push($this->rows,
            $this->labelAreaStartRow,
            $this->labelAreaEndRow,
            $this->priceAreaStartRow,
            $this->priceAreaEndRow,
            $this->contentTxtAreaStartRow,
            $this->contentTxtAreaEndRow,
            $this->contentBodyTxtAreaStartRow,
            $this->contentBodyTxtAreaEndRow,
            $this->priceValueCellRow,
            $this->priceTextCellRow,
            $this->dimensionsValueCellRow,
            $this->countryTextCellRow,
            $this->fabricTextCellRow,
            $this->structureTextCellRow,
            $this->widthValueRow,
            $this->iconRow,
            $this->symbolRow,
            $this->infoRow
            );

        $this->initSheet();
    }

    private function initSheet(){
        try {
            $this->sheet->getDefaultStyle()->getFont()->setName('Arial');
            $this->sheet->getDefaultStyle()->getFont()->setSize(10);
            $this->sheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

            $this->sheet->getActiveSheet()->getRowDimension('4')->setRowHeight(19);
            $this->sheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('C')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('D')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('E')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
            $this->sheet->getActiveSheet()->getColumnDimension('G')->setWidth(9);

            $this->sheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('I')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('J')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('K')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('L')->setWidth(5);
            $this->sheet->getActiveSheet()->getColumnDimension('M')->setWidth(11);
            $this->sheet->getActiveSheet()->getColumnDimension('N')->setWidth(9);

            $this->sheet->getActiveSheet()->getPageMargins()->setTop(0.25);
            $this->sheet->getActiveSheet()->getPageMargins()->setRight(0);
            $this->sheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
            $this->sheet->getActiveSheet()->getPageMargins()->setBottom(0);

            $this->sheet->getActiveSheet()->getPageSetup()
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        } catch (Exception $e) {
        }
    }

    private function resizeRows(){

        $count = (int)($this->counter / 2) + 1;
        $rowStarts = [
            1,
            2,
            3,
            4
        ];

        for($i=0; $i<$count; $i++){
            try {
                $this->sheet->getActiveSheet()->getRowDimension($rowStarts[0])->setRowHeight(27);
                $this->sheet->getActiveSheet()->getRowDimension($rowStarts[1])->setRowHeight(15);
                $this->sheet->getActiveSheet()->getRowDimension($rowStarts[2])->setRowHeight(15);
                $this->sheet->getActiveSheet()->getRowDimension($rowStarts[3])->setRowHeight(19);
            } catch (Exception $e) {
            }

            for($k=0; $k < 4; $k++){
                $rowStarts[$k] = $rowStarts[$k] + 4;
            }
        }

    }

    private function updateValues(){
        $this->labelAreaStartCol = $this->collumns[0];
        $this->labelAreaEndCol = $this->collumns[1];
        $this->priceAreaStartCol = $this->collumns[2];
        $this->priceAreaEndCol = $this->collumns[3];
        $this->contentTxtAreaStartCol = $this->collumns[4];
        $this->contentTxtAreaEndCol = $this->collumns[5];
        $this->contentBodyTxtAreaStartCol = $this->collumns[6];
        $this->contentBodyTxtAreaEndCol = $this->collumns[7];
        $this->priceValueCellCol = $this->collumns[8];
        $this->priceTextCellCol = $this->collumns[9];
        $this->dimensionsValueCellCol = $this->collumns[10];
        $this->countryTextCellCol = $this->collumns[11];
        $this->fabricTextCellCol = $this->collumns[12];
        $this->structureTextCellCol = $this->collumns[13];
        $this->widthValueCol = $this->collumns[14];
        $this->iconCol = $this->collumns[15];
        $this->symbolCol = $this->collumns[16];
        $this->infoCol = $this->collumns[17];

        $this->labelAreaStartRow = $this->rows[0];
        $this->labelAreaEndRow = $this->rows[1];
        $this->priceAreaStartRow = $this->rows[2];
        $this->priceAreaEndRow = $this->rows[3];
        $this->contentTxtAreaStartRow = $this->rows[4];
        $this->contentTxtAreaEndRow = $this->rows[5];
        $this->contentBodyTxtAreaStartRow = $this->rows[6];
        $this->contentBodyTxtAreaEndRow = $this->rows[7];
        $this->priceValueCellRow = $this->rows[8];
        $this->priceTextCellRow = $this->rows[9];
        $this->dimensionsValueCellRow = $this->rows[10];
        $this->countryTextCellRow = $this->rows[11];
        $this->fabricTextCellRow = $this->rows[12];
        $this->structureTextCellRow = $this->rows[13];
        $this->widthValueRow = $this->rows[14];
        $this->iconRow = $this->rows[15];
        $this->symbolRow = $this->rows[16];
        $this->infoRow = $this->rows[17];
    }

    private function swapCols(){
        foreach ($this->collumns as $key => $value){
            $Seven = $value;
            for($i=0; $i<7; $i++){
                if($this->priceTextCellCol == 'A'){
                    $Seven++;
                }else{
                    $Seven = chr(ord($Seven) - 1);
                }
            }
            $this->collumns[$key] = $Seven;
        }
        $this->updateValues();
    }

    private function incrementRows(){
        foreach ($this->rows as $key => $value){
            $plusFive = $value + 4;
            $this->rows[$key] = $plusFive;
        }
        $this->updateValues();
    }

    private function generateSymbols($symbols){
        $incrementor = 0;
        $letter = $this->symbolCol;
        for($i=0; $i<5; $i++){
            $set = substr($symbols,$incrementor,2);
            if($set == null) break;
            // case... generate symbol
            switch ($set){
                case 'a0':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/iron_0.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'a1':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/iron_1.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'b0':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/dry_0.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'b1':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/dry_1.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'c0':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/bleach_0.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'c1':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/bleach_1.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'd0':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/wash_0.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                case 'd1':
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    try {
                        $drawing->setPath('icons/wash_1.png');
                    } catch (Exception $e) {
                    }
                    $drawing->setCoordinates($letter.$this->symbolRow);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(1);
                    $drawing->setWidthAndHeight(22,22);
                    try {
                        $drawing->setWorksheet($this->sheet->getActiveSheet());
                    } catch (Exception $e) {
                    }
                    break;
                default:
                    break;
            }

            // incrementors
            $incrementor += 2;
            $letter++;
        }
    }

    public function generateLabel($price, $fabric, $structure, $country, $width, $symbols, $info){
        // price text
        $priceTxtCell = $this->priceTextCellCol.$this->priceTextCellRow;
        try {
            $this->sheet->getActiveSheet()->setCellValue($priceTxtCell, 'Kaina: ');
        } catch (Exception $e) {
        }

        // price
        $priceCell = $this->priceValueCellCol.$this->priceValueCellRow;
        try {
            $this->sheet->getActiveSheet()->setCellValue($priceCell, $price);
        } catch (Exception $e) {
        }

        // info
        $infoCell = $this->infoCol.$this->infoRow;
        try {
            $this->sheet->getActiveSheet()->setCellValue($infoCell, $info);
        } catch (Exception $e) {
        }

        // fabric
        $fabricCell = $this->fabricTextCellCol.$this->fabricTextCellRow;
        try {
            $this->sheet->getActiveSheet()->setCellValue($fabricCell, $fabric);
        } catch (Exception $e) {
        }

        // structure
        $structureCell = $this->structureTextCellCol.$this->structureTextCellRow;
        try {
            $this->sheet->getActiveSheet()->setCellValue($structureCell, $structure);
        } catch (Exception $e) {
        }

        // width/lenght
        $widthValueCell = $this->widthValueCol.$this->widthValueRow;
        $convertChar = substr($width, -1);
        $widthOrLength = '';
        if($convertChar == 'i'){
            $widthOrLength = 'Ilgis ';
        }else if($convertChar == 'p'){
            $widthOrLength = 'Plotis ';
        }else if($convertChar = 'a'){
            $widthOrLength = 'Aukštis ';
        }
        $value = $widthOrLength . substr($width, 0, -1) . ' cm';
        try {
            $this->sheet->getActiveSheet()->setCellValue($widthValueCell, $value);
        } catch (Exception $e) {
        }

        // country tag
        $countryCell = $this->countryTextCellCol.$this->countryTextCellRow;
        try {
            $this->sheet->getActiveSheet()->setCellValue($countryCell, $country);
        } catch (Exception $e) {
        }

        // symbols
        if(!is_null($symbols)){
            $this->generateSymbols($symbols);
        }

        // Styles
        // outline border
        $labelArea = $this->labelAreaStartCol.$this->labelAreaStartRow.':'.$this->labelAreaEndCol.$this->labelAreaEndRow;
        try {
            $this->sheet->getActiveSheet()->getStyle($labelArea)->applyFromArray($this->styles['outlineStyle']);
        } catch (Exception $e) {
        }

        // country tag style
        try {
            $this->sheet->getActiveSheet()->getStyle($countryCell)->applyFromArray($this->styles['countryStlye']);
        } catch (Exception $e) {
        }
        // info tag style
        try {
            $this->sheet->getActiveSheet()->getStyle($infoCell)->applyFromArray($this->styles['countryStlye']);
        } catch (Exception $e) {
        }

        // width/lenght style
        try {
            $this->sheet->getActiveSheet()->getStyle($widthValueCell)->applyFromArray($this->styles['widthLenghtStyle']);
        } catch (Exception $e) {
        }

        // price style
        try {
            $this->sheet->getActiveSheet()->getStyle($priceTxtCell)->applyFromArray($this->styles['kaina']);
        } catch (Exception $e) {
        }

        // pricearea style
        $priceArea = $this->priceAreaStartCol.$this->priceAreaStartRow.':'.$this->priceAreaEndCol.$this->priceAreaEndRow;
        try {
            $this->sheet->getActiveSheet()->getStyle($priceArea)->getNumberFormat()
                ->setFormatCode('0.00 €');
        } catch (Exception $e) {
        }
        try {
            $this->sheet->getActiveSheet()->mergeCells($priceArea);
        } catch (Exception $e) {
        }
        try {
            $this->sheet->getActiveSheet()->getStyle($priceArea)->applyFromArray($this->styles['priceStyle']);
        } catch (Exception $e) {
        }
        try {
            $this->sheet->getActiveSheet()->getStyle($priceArea)->applyFromArray($this->styles['outlineStyle']);
        } catch (Exception $e) {
        }

        // add icon
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        try {
            $drawing->setPath('siule_logo.png');
        } catch (Exception $e) {
        }
        $drawing->setCoordinates($this->iconCol.$this->iconRow);
        $drawing->setOffsetX(4);
        $drawing->setOffsetY(-9);
        try {
            $drawing->setWorksheet($this->sheet->getActiveSheet());
        } catch (Exception $e) {
        }

        $this->swapCols();
        $this->counter = $this->counter + 1;
        if($this->counter >= 2){
            $counter = $this->counter;
            if($counter % 2 == 0){
                $this->incrementRows();
            }
        }
    }

    public function saveLabels(){
        $this->resizeRows();
        $writer = new Xlsx($this->sheet);
        try {
            $writer->save('etiket.xlsx');
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
        }
    }
}