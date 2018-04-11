<?php
//class wordProcessClass() and class MyReadFilter() have same 'namespace'-'xlsxCsv' 
namespace xlsxCsv\model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
class wordProcessClass {
    public $ckReader;
    public $ckLoader;


    public function readData($data=""){
        $file=$data["fileCk"]["tmp_name"];
        $this->ckReader= IOFactory::createReader("Xlsx");
        $this->ckLoader= $this->ckReader->load($file);
    }
    
}
class MyReadFilter implements IReadFilter{
    public function readCell($column, $row, $worksheetName = '') {
        print_r($column);
       return true;
    }
}