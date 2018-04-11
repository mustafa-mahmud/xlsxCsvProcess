<?php
//class wordProcessClass() and class MyReadFilter() have same 'namespace'-'xlsxCsv' 
namespace xlsxCsv\model;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class wordProcessClass {
    public $ckModel="ok all";
    
    public function readData($data=""){
        $file=$data["fileCk"]["tmp_name"];
        $reader= IOFactory::createReader("Xlsx");
        $spreadsheet=$reader->load($file);
        $show=$spreadsheet->getActiveSheet()->toArray();// |OK
//        print_r($show);
    }
    
}

class MyReadFilter implements IReadFilter{
    public function readCell($column, $row="", $worksheetName = '') {
       echo count($column);
    }
}
