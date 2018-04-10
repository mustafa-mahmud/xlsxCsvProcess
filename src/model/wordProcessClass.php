<?php

namespace xlsxCsv\model;

use PhpOffice\PhpSpreadsheet\IOFactory;

class wordProcessClass {
    public $ckModel="ok all";
    
    public function __construct($data=""){
        $file=$data["fileCk"]["tmp_name"];
        $reader= IOFactory::createReader("Xlsx");
        $spreadsheet=$reader->load($file);
        $show=$spreadsheet->getActiveSheet()->toArray();// |OK
        print_r($show);
    }
}
